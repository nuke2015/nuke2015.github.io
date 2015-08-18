<?php

/**
 * 本页面放的是静态接口,仅供演示
 */
class BaseAction extends CommonAction
{
	public function result($code = 0, $data_api = null, $msg = ''){
		echo 'Test the BaseAction to be reload!<br/>';
		$this->data_api=$data_api;
	}
}
