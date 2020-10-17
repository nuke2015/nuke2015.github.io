<?
#thinkphp超经典的代码,不用递归;
function list_to_tree($list) {
	// 创建Tree
	$tree = array();
	if(is_array($list)) {
		// 创建基于主键的数组引用
		$refer = array();
		foreach ($list as $key => $data) {
			$refer[$data['id']] =& $list[$key];
		}
		foreach ($list as $key => $data) {
			// 判断是否存在parent
			$pid = $data['pid'];
			if ($pid) {
				if (isset($refer[$pid])){
					$parent=& $refer[$pid];
					$parent['_child'][]=& $list[$key];
				}
			}else{
				$tree[] =& $list[$key];
			}
		}
	}
	return $tree;
}