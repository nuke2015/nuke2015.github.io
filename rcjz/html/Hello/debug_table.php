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
<table class="layui-hide" id="demo"></table>
               
          
<!-- 注意：如果你直接复制所有代码到本地，上述 JS 路径需要改成你本地的 -->
<script>
layui.use('table', function(){
  var table = layui.table;
  
  //展示已知数据
  table.render({
    elem: '#demo'
    ,cols: [[ //标题栏
      {field: 'id', title: 'ID', width: 80, sort: true}
      ,{field: 'username', title: '用户名', width: 120}
      ,{field: 'email', title: '邮箱', minWidth: 150}
      ,{field: 'sign', title: '签名', minWidth: 160}
      ,{field: 'sex', title: '性别', width: 80}
      ,{field: 'city', title: '城市', width: 100}
      ,{field: 'experience', title: '积分', width: 80, sort: true}
    ]]
    ,data: [{
      "id": "10001"
      ,"username": "杜甫"
      ,"email": "test@email.com"
      ,"sex": "男"
      ,"city": "浙江杭州"
      ,"sign": "人生恰似一场修行"
      ,"experience": "116"
      ,"ip": "192.168.0.8"
      ,"logins": "108"
      ,"joinTime": "2016-10-14"
    }, {
      "id": "10002"
      ,"username": "李白"
      ,"email": "test@email.com"
      ,"sex": "男"
      ,"city": "浙江杭州"
      ,"sign": "人生恰似一场修行"
      ,"experience": "12"
      ,"ip": "192.168.0.8"
      ,"logins": "106"
      ,"joinTime": "2016-10-14"
      ,"LAY_CHECKED": true
    }, {
      "id": "10003"
      ,"username": "王勃"
      ,"email": "test@email.com"
      ,"sex": "男"
      ,"city": "浙江杭州"
      ,"sign": "人生恰似一场修行"
      ,"experience": "65"
      ,"ip": "192.168.0.8"
      ,"logins": "106"
      ,"joinTime": "2016-10-14"
    }, {
      "id": "10004"
      ,"username": "贤心"
      ,"email": "test@email.com"
      ,"sex": "男"
      ,"city": "浙江杭州"
      ,"sign": "人生恰似一场修行"
      ,"experience": "666"
      ,"ip": "192.168.0.8"
      ,"logins": "106"
      ,"joinTime": "2016-10-14"
    }, {
      "id": "10005"
      ,"username": "贤心"
      ,"email": "test@email.com"
      ,"sex": "男"
      ,"city": "浙江杭州"
      ,"sign": "人生恰似一场修行"
      ,"experience": "86"
      ,"ip": "192.168.0.8"
      ,"logins": "106"
      ,"joinTime": "2016-10-14"
    }, {
      "id": "10006"
      ,"username": "贤心"
      ,"email": "test@email.com"
      ,"sex": "男"
      ,"city": "浙江杭州"
      ,"sign": "人生恰似一场修行"
      ,"experience": "12"
      ,"ip": "192.168.0.8"
      ,"logins": "106"
      ,"joinTime": "2016-10-14"
    }, {
      "id": "10007"
      ,"username": "贤心"
      ,"email": "test@email.com"
      ,"sex": "男"
      ,"city": "浙江杭州"
      ,"sign": "人生恰似一场修行"
      ,"experience": "16"
      ,"ip": "192.168.0.8"
      ,"logins": "106"
      ,"joinTime": "2016-10-14"
    }, {
      "id": "10008"
      ,"username": "贤心"
      ,"email": "test@email.com"
      ,"sex": "男"
      ,"city": "浙江杭州"
      ,"sign": "人生恰似一场修行"
      ,"experience": "106"
      ,"ip": "192.168.0.8"
      ,"logins": "106"
      ,"joinTime": "2016-10-14"
    }]
    //,skin: 'line' //表格风格
    ,even: true
    //,page: true //是否显示分页
    //,limits: [5, 7, 10]
    //,limit: 5 //每页默认显示的数量
  });
});
</script>

</body>
</html>        
        