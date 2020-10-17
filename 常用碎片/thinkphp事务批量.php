<?
    function saveSort() {
        $seqNoList = $_POST ['seqNoList'];
        if (!empty($seqNoList)) {
            //更新数据对象
            $name = $this->getActionName();
            $model = D($name);
            $col = explode(',', $seqNoList);
            //启动事务
            $model->startTrans();
            foreach ($col as $val) {
                $val = explode(':', $val);
                $model->id = $val [0];
                $model->sort = $val [1];
                $result = $model->save();
                if (!$result) {
                    break;
                }
            }
            //提交事务
            $model->commit();
            if ($result !== false) {
                //采用普通方式跳转刷新页面
                $this->success('更新成功');
            } else {
                $this->error($model->getError());
            }
        }
    }
