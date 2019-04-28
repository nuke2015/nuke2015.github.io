<?php

/**
 * 用户添加收藏/取消收藏接口
 * 特色:
 * 使用了异步,把统计数据的汇总,转入异步执行.
 * 使用了事务锁,把批量处理的事务,进行队列锁操作.
 * 使用了过期锁,避免长时间死锁.
 * 使用了分布式事务锁,能多机共享一个锁,避免机器扩张引发问题.
 * 使用了数组交集差集,组合运算逻辑.
 * 使用了mvc数据分层,业务就是业务,数据就是数据,视图就是视图,层次分明,易于维护.
 * 使用了服务模型,把一些类似于基础设施的东西比如,堆栈bucket,定时crond,队列msg,锁locker,等归属为服务层.
 *
 * by 锋子
 * 2015年9月9日 18:22:08
 *
 */
class UserUpdatelikesAction extends BaseAction
{
    public function index() {
        $user_id = intval($_POST['user_id']);
        $ids = trim($_POST['ids']);
        
        //用户id必填
        if (!$user_id || !$ids) $this->result(ERR_WRONG_ARG);
        
        // 数据格式化
        if ($ids) {
            $ids_arr_tmp = explode(',', $ids);
            foreach ($ids_arr_tmp as $value) {
                $value = intval($value);
                
                // 避免收藏id=0的菜例
                if ($value) $ids_arr[] = $value;
            }
        } 
        else {
            $this->result(ERR_WRONG_ARG);
        }
        
        $type = intval($_POST['type']);
        
        //异步任务
        import("@.Service.CrondService");
        
        // type[0取消收藏,1添加收藏]
        if ($type == 0) {
            
            // 取交集
            $nop_ids = $this->nop_ids($user_id, $ids_arr);
            $ids_arr = array_intersect($ids_arr, $nop_ids);
            if (count($ids_arr)) {
                
                //不喜欢时,也要从表里删除数据
                $where = array();
                $where['user_id'] = $user_id;
                $where['dishes_id'] = array('in', $ids_arr);
                $user_collection = D('user_collection');
                
                $result = $user_collection->where($where)->delete();
                if (count($ids_arr)) {
                    foreach ($ids_arr as $dishes_id) {
                        
                        // 菜例收藏量减一
                        CrondService::crond_set('dishes', $dishes_id, 'agreement_amount', -1);
                    }
                }
            }
            $return = array('data' => array_values($ids_arr));
            $this->result(ERR_NONE, $return);
        } 
        else {
            
            $user_collection = D('user_collection');
            
            // 取差集
            $nop_ids = $this->nop_ids($user_id, $ids_arr);
            $ids_arr = array_diff($ids_arr, $nop_ids);
            if (count($ids_arr)) {
                
                //剩余入库
                $insert = array();
                $insert['user_id'] = $user_id;
                $insert['collection_date'] = date("Y-m-d H:i:s");
                $insert['create_date'] = date("Y-m-d H:i:s");
                
                // 代码事务锁
                import("@.service.LockService");
                $locker_key = "UserUpdatelikesAction#index#add_collection#{$user_id}";
                $locker = LockService::check($locker_key);
                if (!$locker) {
                    LockService::lock($locker_key, 60);
                    foreach ($ids_arr as $dishes_id) {
                        $insert['dishes_id'] = $dishes_id;
                        $user_collection->data($insert)->add();
                        
                        // 菜例收藏量加一
                        CrondService::crond_set('dishes', $dishes_id, 'agreement_amount', 1);
                    }
                    LockService::unlock($locker_key, 60);
                }
                $result = $user_collection->commit();
            }
            
            $return = array('data' => array_values($ids_arr));
            $this->result(ERR_NONE, $return);
        }
    }
    
    //主键排重
    private function nop_ids($user_id, $ids_arr) {
        $result = array();
        if (count($ids_arr)) {
            $where = array();
            $where['user_id'] = $user_id;
            $where['dishes_id'] = array('in', $ids_arr);
            $user_collection = D('user_collection');
            $data = $user_collection->where($where)->field('dishes_id')->select();
            if (count($data)) {
                foreach ($data as $value) {
                    $result[] = $value['dishes_id'];
                }
            }
        }
        return $result;
    }
}
