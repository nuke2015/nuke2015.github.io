<?
    function saveSort() {
        $seqNoList = $_POST ['seqNoList'];
        if (!empty($seqNoList)) {
            //�������ݶ���
            $name = $this->getActionName();
            $model = D($name);
            $col = explode(',', $seqNoList);
            //��������
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
            //�ύ����
            $model->commit();
            if ($result !== false) {
                //������ͨ��ʽ��תˢ��ҳ��
                $this->success('���³ɹ�');
            } else {
                $this->error($model->getError());
            }
        }
    }
