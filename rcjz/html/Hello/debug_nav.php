<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Layui</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/Public/rcjz/layui2.6/layui/css/layui.css?t=20210802" media="all">
    <script src="/Public/rcjz/layui2.6/layui/layui.js?t=20210802"></script>
  <!-- 注意：如果你直接复制所有代码到本地，上述css路径需要改成你本地的 -->
</head>
<body>

<div class="nav">

	<ul class="layui-nav layui-black-blue" lay-bar="disabled">
	  <li class="layui-nav-item"><a href="/html/OrderList.html">订单管理</a></li>
	  <li class="layui-nav-item"><a href="/html/SkillerList.html">月嫂管理</a></li>
	  <li class="layui-nav-item"><a href="/html/MemberList.html">客户管理</a></li>
	  <li class="layui-nav-item">
	    <a href="javascript:;">系统配置</a>
	    <dl class="layui-nav-child">
	      <dd><a href="/html/UserList.html">用户列表</a></dd>
	      <dd><a href="/html/setting.html">系统设置</a></dd>
	    </dl>
	  </li>
	  <li class="layui-nav-item layui-layout-right"><a href="/html/Logout.html">退出</a></li>
	</ul> 
</div>   
<div class="main"></div>
</body>
</html>