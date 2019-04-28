<?php

/**
 * 当前脚本主要实现标签树功能,
 * 夹杂了永久存储与定时更新
 * 其中get_taginfo是取单个标签的详情
 * 其中get_tree是取完整的标签树
 * 在取标签树的时候,get_taginfo被调用了很多次,
 * 而get_taginfo调用了$this->CrondCache(0);
 * 这虽然是用了永久缓存,但它是全量数据,所以,很大.
 * 每次调用后释放,再调用,这就严重浪费了性能.
 * 当改成静态变量static $config以后,
 * 只调用一次,性能极大的提升,
 * 只要嗖的一下就组装好了整颗标签树!
 */

// 工厂模式
require_once __DIR__ . '/BaseStore.php';

/**
 * 单个标签tag_id所对应的菜
 * 条件:查询dishes和dishes_tags_sorter需要排除未发布的菜
 */

// //永久存储+定时更新
// import("@.Store.DishesTags");
// $DishesTags = D('DishesTags', 'Store');
// // 取数据
// $result = $DishesTags->CrondCache(0);
// // 更新数据
// $result = $DishesTags->CrondCache(1);

class DishesTagsStore extends BaseStore
{
    public $cache_key = '';
    public static $config;
    
    // 根据数据库生成目标结构数据库,单份缓存,不用二级缓存
    public function get_data($tag_id = 0) {
        $result = array();
        $dishes_tags = D('dishes_tags');
        $info = $dishes_tags->where(1)->field('tags_id,parent_id,tag_name,tag_image,tag_isselfdefine')->select();
        $result = array();
        $parent = array();
        if ($info && count($info)) {
            foreach ($info as $key => & $value) {
                $value['ids'][] = $value['tags_id'];
                if ($value['parent_id'] > 0) {
                    $parent[$value['parent_id']][] = $value['tags_id'];
                }
                $value['tag_image'] = picval($value['tag_image']);
                $result[$value['tags_id']] = $value;
            }
            
            // 把它独立出来,避免被覆盖
            if (count($parent)) {
                foreach ($parent as $key => $value) {
                    $result[$key]['ids'] = $value;
                }
            }
        }
        return $result;
    }
    
    // $result = $DishesTags->get_taginfo(323);
    // print_r($result);
    //标签+子标签
    
    
    
    /**
     这个地方改成用静态变量以后,
     程序性能成倍提高,
     从原来的1285毫秒,直接下降到75毫秒.
     * @param  [type] $tag_id [description]
     * @return [type]         [description]
     */
    public function get_taginfo($tag_id) {
        $result = array();
        if (!self::$config) {
            self::$config = $this->CrondCache(0);
        }
        if (isset(self::$config[$tag_id])) {
            $result = self::$config[$tag_id];
        }
        return $result;
    }
    
    // 随机推菜,根据标签数组
    public function get_tag_by_rand($tag_ids = array()) {
        if (is_array($tag_ids) && count($tag_ids)) {
            
            //小范围随机
            $tag_id = $tag_ids[array_rand($tag_ids) ];
            $tag = $this->get_taginfo($tag_id);
        } 
        else {
            
            //大随机
            $tag_ids = $this->CrondCache(0);
            $tag = $tag_ids[array_rand($tag_ids) ];
        }
        return $tag;
    }
    
    // 标签树
    public function get_tree($tag_isselfdefine = 1) {
        $config = $this->CrondCache(0);
        $result = array();
        if ($config && count($config)) {
            foreach ($config as $value) {
                if ($value['tag_isselfdefine'] != $tag_isselfdefine) continue;
                if (count($value['ids'])) {
                    foreach ($value['ids'] as $tags_id) {
                        $tag_info = $this->get_taginfo($tags_id);
                        if ($tag_info['tag_isselfdefine'] != $tag_isselfdefine) continue;
                        
                        // 自身
                        if ($tags_id == $value['tags_id']) continue;
                        $value['data'][] = array('tags_id' => $tags_id, 'tag_name' => $tag_info['tag_name'], 'tag_isselfdefine' => $tag_info['tag_isselfdefine'], 'tag_image' => picval($tag_info['image']));
                    }
                    unset($value['ids']);
                }
                if ($value['parent_id'] == 0) $result[] = $value;
            }
            unset($value);
        }
        return $result;
    }
}
