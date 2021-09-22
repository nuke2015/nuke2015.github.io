<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport"
			content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<title>内容管理系统</title>
		<link rel="stylesheet" href="/Public/rcjz/layui2.6/layui/css/layui.css?t=20210802" media="all">
		<script src="/Public/rcjz/layui2.6/layui/layui.js?t=20210802"></script>
		<script src="/Public/rcjz/cssjs/utils_min.js?t=20210802"></script>
		<script src="/Public/rcjz/cssjs/common.js?t=20210802"></script>
	</head>
	<body class="layui-main">
		<div class="main layui-row layui-col-xs12">
			<h1>内容管理系统</h1>
            <div class="action">
                <button type="button" id="DistributeAdd" class="layui-btn layui-btn-sm layui-btn-normal">添加</button>
            </div>
			<table class="layui-hide js_table"></table>
			<div id="pagebar"></div>
			<script type="text/html" id="table-attr-do">
				<a href="/hello/demo_info.html?id={{d.id}}" class="layui-btn layui-btn-default layui-btn-sm">编辑</a>
			</script>
		</div>

		<script src="/Public/rcjz/busi/demo_list.js"></script>

	</body>
</html>
