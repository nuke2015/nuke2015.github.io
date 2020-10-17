<?php
#���ù��ߺ���,ȫ����̬����;
class Vnet{
	#��ȡExcel��,��̬����;
	public function readexcel($filePath){
		include APP_PATH.'/Lib/Excel/PHPExcel/IOFactory.php'; //�����ֶ�����;
		$reader = PHPExcel_IOFactory::createReader('Excel5'); 
		$PHPExcel = $reader->load($filePath); // ����excel�ļ�
		$sheet = $PHPExcel->getSheet(0); // ��ȡ��һ��������
		$highestRow = $sheet->getHighestRow(); // ȡ��������
		$highestColumm = $sheet->getHighestColumn(); // ȡ��������
		 
		/** ѭ����ȡÿ����Ԫ������� */
		for ($row = 1; $row <= $highestRow; $row++){//�������Ե�1�п�ʼ
			for ($column = 'A'; $column <= $highestColumm; $column++) {//��������A�п�ʼ
				#$cell= $sheet->getCell($column.$row)->getValue();
				$cell= $sheet->getCell($column.$row)->getCalculatedValue();
				if(!empty($cell))$dataset[$row][$column]=$cell;
			}
		}
		return $dataset;
	}
	#Excel������;
	private function toexcel($data,$offset){
		include APP_PATH.'/Lib/Excel/PHPExcel.php'; //�����ֶ�����;
		$type = 'Excel5'; //���Ϊexcel2003
		$file = APP_PATH.'/Lib/Excel/excel.xls';
		$xls = PHPExcel_IOFactory::createReader($type);
		$xls = $xls->load($file);
		$xls->setActiveSheetIndex(0) //�����һ�ű�;
			->fromArray($data['userinfo'],'',$offset) //���������,Ĭ��null,λ��;;
			->insertNewRowBefore(5,count($res)-1) //����հױ��;
			->fromArray($data['orderinfo'],'','A4');
		#���;
		$obj = PHPExcel_IOFactory::createWriter($xls,$type);
		header("Content-Type: application/force-download"); 
		header("Content-Type: application/octet-stream"); 
		header("Content-Type: application/download"); 
		header('Content-Disposition:inline;filename=myexcel.xls'); 
		header("Content-Transfer-Encoding: binary"); 
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
		header("Pragma: no-cache"); 
		$obj->save('php://output'); 
	}
	#��ȡ�ı�;
	public function readtxt($file){
		$f= fopen($file,"r");
		while (!feof($f)){
		  $line = fgets($f);
		  $line=preg_replace("/\s/","",$line);
		  if($line)$tmp[]= $line; //�ǿ�;
		}
		fclose($f);
		return $tmp;
	}
	#�����ϴ�;
	public function readattach($filetype){
		#enctype="multipart/form-data"ǰ��;
        import('@.ORG.UploadFile');
        //�����ϴ���
        $upload = new UploadFile();
        //�����ϴ��ļ���С
        $upload->maxSize            = 1292200; //1m
        //�����ϴ��ļ�����
        $upload->allowExts          = explode(',',$filetype);
        //���ø����ϴ�Ŀ¼
        $upload->savePath           = UPLOAD_PATH;
        //������Ҫ��������ͼ������ͼ���ļ���Ч
        $upload->thumb              = false;
        // ��������ͼƬ����·��
        $upload->imageClassPath     = '@.ORG.Image';
        //�����ϴ��ļ�����
        $upload->saveRule           = 'uniqid';
        //ɾ��ԭͼ
        if (!$upload->upload()){
            //�����ϴ��쳣
            $this->error($upload->getErrorMsg());
        } else {
			$upload->upload();
			return $upload->getUploadFileInfo();
        }
    }
	#���sql;
	public function sql($sqlary,$conn){
		$conn=S(sid('conn'));
		$link = mysql_connect($conn['host'],$conn['user'],$conn['pwd'],$conn['dbname']) or die("���ݿ�����ʧ��!");  	
		$db_selected=mysql_select_db($conn['dbname'],$link);
		mysql_query('set names utf8'); //utf8����;
		/* ִ�� SQL ��ѯ */    
		foreach($sqlary as $sql){
			$result=mysql_query($sql);
		}
		mysql_free_result($db_selected);
		mysql_close($link);
		unset($link);
		return $result;
	}
	#��ʱˢ��;
	public function flush($msg){
		if($msg)echo $msg;
		ob_flush();
		flush();
		echo '<br/>';
	}
	#���ٻ���KVDB,key������,valueֵ;
	public function kvdb($key,$value=null){
		include_once(APP_PATH.'Lib/ORG/Secache.class.php');
		$cache=new secache();
		$cache->workat(RUNTIME_PATH.'KVDB');
		if(!isset($value)){
			$cache->fetch(md5($key),$rs); //ȡ����;
			return unserialize($rs);
		}else{
			if(!empty($value)){
				$cache->store(md5($key),serialize($value)); //�������л�,����ջ���;
			}else{
				$cache->delete(md5($key)); //ɾ������;
			}
		}
	}
	
}