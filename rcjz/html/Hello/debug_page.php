<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <title>客户管理</title>
  <link rel="stylesheet" href="/Public/rcjz/layui2.6/layui/css/layui.css?t=20210802" media="all">
  <script src="/Public/rcjz/layui2.6/layui/layui.js?t=20210802"></script>
  <script src="/Public/rcjz/cssjs/common.js?t=20210802"></script>
  <style>
    body{margin: 10px;}
    .demo-carousel{height: 200px; line-height: 200px; text-align: center;}
  </style>
</head>
<body>
 
<div class="main"></div>
<div id="test1"></div>
 
<script>
layui.use('laypage', function(){
  var laypage = layui.laypage;
  
  //执行一个laypage实例
  laypage.render({
    elem: 'test1' //注意，这里的 test1 是 ID，不用加 # 号
    ,count: 50 //数据总数，从服务端得到
    ,jump:function(obj){
        console.log(obj);
    }
  });
});
</script>

</body>
</html>        
        