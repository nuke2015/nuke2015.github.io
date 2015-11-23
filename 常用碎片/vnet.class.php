<?php
#常用工具函数,全部静态调用;
class vnet{
	#读取Excel表,静态调用;
	public static function readexcel($filePath){
		include APP_PATH.'/Lib/Excel/PHPExcel/IOFactory.php'; //必须手动包含;
		$reader = PHPExcel_IOFactory::createReader('Excel5'); 
		$PHPExcel = $reader->load($filePath); // 载入excel文件
		$sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
		$highestRow = $sheet->getHighestRow(); // 取得总行数
		$highestColumm = $sheet->getHighestColumn(); // 取得总列数
		 
		/** 循环读取每个单元格的数据 */
		for ($row = 1; $row <= $highestRow; $row++){//行数是以第1行开始
			for ($column = 'A'; $column <= $highestColumm; $column++) {//列数是以A列开始
				#$cell= $sheet->getCell($column.$row)->getValue();
				$cell= $sheet->getCell($column.$row)->getCalculatedValue();
				if(!empty($cell))$dataset[$row][$column]=$cell;
			}
		}
		return $dataset;
	}
	#Excel表格输出;
	public static function toexcel($data,$offset){
		include APP_PATH.'/Lib/Excel/PHPExcel.php'; //必须手动包含;
		$type = 'Excel5'; //输出为excel2003
		$file = APP_PATH.'/Lib/Excel/excel.xls';
		$xls = PHPExcel_IOFactory::createReader($type);
		$xls = $xls->load($file);
		$xls->setActiveSheetIndex(0) //激活第一张表;
			->fromArray($data['userinfo'],'',$offset) //按数组输出,默认null,位置;;
			->insertNewRowBefore(5,count($res)-1) //插入空白表格;
			->fromArray($data['orderinfo'],'','A4');
		#输出;
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
	#读取文本;
	public static function readtxt($file){
		$f= fopen($file,"r");
		while (!feof($f)){
		  $line = fgets($f);
		  $line=preg_replace("/\s/","",$line);
		  if($line)$tmp[]= $line; //非空;
		}
		fclose($f);
		return $tmp;
	}
	#附件上传;
	public static function readattach($filetype){
		#enctype="multipart/form-data"前端;
        import('@.ORG.UploadFile');
        //导入上传类
        $upload = new UploadFile();
        //设置上传文件大小
        $upload->maxSize            = 1292200; //1m
        //设置上传文件类型
        $upload->allowExts          = explode(',',$filetype);
        //设置附件上传目录
        $upload->savePath           = UPLOAD_PATH;
        //设置需要生成缩略图，仅对图像文件有效
        $upload->thumb              = false;
        // 设置引用图片类库包路径
        $upload->imageClassPath     = '@.ORG.Image';
        //设置上传文件规则
        $upload->saveRule           = 'uniqid';
        //删除原图
        if (!$upload->upload()){
            //捕获上传异常
            $this->error($upload->getErrorMsg());
        } else {
			$upload->upload();
			return $upload->getUploadFileInfo();
        }
    }
	#跨库sql;
	public static function sql($sqlary,$conn){
		$link = mysql_connect($conn['host'],$conn['user'],$conn['pwd'],$conn['dbname']) or die("数据库连接失败!");  	
		$db_selected=mysql_select_db($conn['dbname'],$link);
		mysql_query('set names utf8'); //utf8编码;
		/* 执行 SQL 查询 */    
		foreach($sqlary as $sql){
			$result=mysql_query($sql);
		}
		mysql_free_result($db_selected);
		mysql_close($link);
		unset($link);
		return $result;
	}
	#即时刷新;
	public static function flush($msg){
		if($msg)echo $msg;
		ob_flush();
		flush();
		echo '<br/>';//换行好一点;
	}
	#快速缓存KVDB,key变量名,value值;
	public static function kvdb($key,$value=null){
		include_once(APP_PATH.'Lib/ORG/Secache.class.php');
		$cache=new secache();
		$cache->workat(RUNTIME_PATH.'KVDB');
		if(!isset($value)){
			$cache->fetch(md5($key),$rs); //取缓存;
			return unserialize($rs);
		}else{
			if(!empty($value)){
				$cache->store(md5($key),serialize($value)); //数据序列化,或清空缓存;
			}else{
				$cache->delete(md5($key)); //删除缓存;
			}
		}
	}
    //去url中的参数字段
    public static function filter_url($url,$filters=array('page')){
        $parse = parse_url($url);
        if(isset($parse['query'])) {
            parse_str($parse['query'],$querys);
            foreach ($filters as $tag) {
                if(isset($querys[$tag]))unset($querys[$tag]);
            }
        }
        $url=$parse['path'].'?'.http_build_query($querys);
        return $url;
    }	
}
