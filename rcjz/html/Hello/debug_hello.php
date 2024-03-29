<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <title>layui 调试预览</title>
  <link rel="stylesheet" href="/Public/rcjz/layui2.6/layui/css/layui.css?t=20210801" media="all">
  <script src="/Public/rcjz/layui2.6/layui/layui.js?t=20210801"></script>
  <script src="/Public/rcjz/cssjs/common.js?t=20210801"></script>
  <style>
    body{margin: 10px;}
    .demo-carousel{height: 200px; line-height: 200px; text-align: center;}
  </style>
</head>
<body>

<div class="main"></div>
<table class="layui-hide" id="demo" lay-filter="test"></table>
 
<script type="text/html" id="barDemo">
  <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="detail">查看</a>
  <a class="layui-btn layui-btn-xs" lay-event="more">更多 <i class="layui-icon layui-icon-down"></i></a>
</script>
 
<div class="layui-tab layui-tab-brief" lay-filter="demo">
  <ul class="layui-tab-title">
    <li class="layui-this">演示说明</li>
    <li>日期</li>
    <li>分页</li>
    <li>上传</li>
    <li>滑块</li>
  </ul>
  <div class="layui-tab-content">
    <div class="layui-tab-item layui-show">
      <div class="layui-carousel" id="test1">
        <div carousel-item>
          <div><p class="layui-bg-green demo-carousel">在这里，你将以最直观的形式体验 layui！</p></div>
          <div><p class="layui-bg-red demo-carousel">在编辑器中可以执行 layui 相关的一切代码</p></div>
          <div><p class="layui-bg-blue demo-carousel">你也可以点击左侧导航针对性地试验我们提供的示例</p></div>
          <div><p class="layui-bg-orange demo-carousel">如果最左侧的导航的高度超出了你的屏幕</p></div>
          <div><p class="layui-bg-cyan demo-carousel">你可以将鼠标移入导航区域，然后滑动鼠标滚轮即可</p></div>
        </div>
      </div>
    </div>
    <div class="layui-tab-item">
      <div id="laydateDemo"></div>
    </div>
    <div class="layui-tab-item">
      <div id="pageDemo"></div>
    </div>
    <div class="layui-tab-item">
      <div class="layui-upload-drag" id="uploadDemo">
        <i class="layui-icon"></i>
        <p>点击上传，或将文件拖拽到此处</p>
        <div class="layui-hide" id="uploadDemoView">
          <hr>
          <img src="" alt="上传成功后渲染" style="max-width: 100%">
        </div>
      </div>
    </div>
    <div class="layui-tab-item">
      <div id="sliderDemo" style="margin: 50px 20px;"></div>
    </div>
  </div>
</div>

<blockquote class="layui-elem-quote layui-hide layui-text" id="footer">当前版本：layui v{{ layui.v }}</blockquote>

  

<script>
layui.config({
  version: '20210801' //为了更新 js 缓存，可忽略
});
 
//加载模块  
layui.use(function(){ //亦可加载特定模块：layui.use(['layer', 'laydate', function(){
  //得到各种内置组件
  var layer = layui.layer //弹层
  ,laypage = layui.laypage //分页
  ,laydate = layui.laydate //日期
  ,table = layui.table //表格
  ,carousel = layui.carousel //轮播
  ,upload = layui.upload //上传
  ,element = layui.element //元素操作
  ,slider = layui.slider //滑块
  ,dropdown = layui.dropdown //下拉菜单
  
  //向世界问个好
  layer.msg('Hello World');
  
  //监听Tab切换
  element.on('tab(demo)', function(data){
    layer.tips('切换了 '+ data.index +'：'+ this.innerHTML, this, {
      tips: 1
    });
  });
  
  //执行一个 table 实例
  table.render({
    elem: '#demo'
    ,height: 420
    ,url: '/api_crm/?methodName=ArticleCmsList&admin_id=1&token=1' //数据接口
    ,title: '文章内容'
    ,page: true //开启分页
    ,toolbar: 'default' //开启工具栏，此处显示默认图标，可以自定义模板，详见文档
    ,totalRow: true //开启合计行
    ,cols: [[ //表头
      {type: 'checkbox', fixed: 'left'}
      ,{field: 'id', title: 'ID', width:80, sort: true, fixed: 'left', totalRowText: '合计：'}
      ,{field: 'title', title: 'title', width:80}
      ,{field: 'category_id', title: '分类', width: 100}
    ]]
  });
  
  //监听头工具栏事件
  table.on('toolbar(test)', function(obj){
    var checkStatus = table.checkStatus(obj.config.id)
    ,data = checkStatus.data; //获取选中的数据
    switch(obj.event){
      case 'add':
        layer.msg('添加');
      break;
      case 'update':
        if(data.length === 0){
          layer.msg('请选择一行');
        } else if(data.length > 1){
          layer.msg('只能同时编辑一个');
        } else {
          layer.alert('编辑 [id]：'+ checkStatus.data[0].id);
        }
      break;
      case 'delete':
        if(data.length === 0){
          layer.msg('请选择一行');
        } else {
          layer.msg('删除');
        }
      break;
    };
  });
  
  //监听行工具事件
  table.on('tool(test)', function(obj){ //注：tool 是工具条事件名，test 是 table 原始容器的属性 lay-filter="对应的值"
    var data = obj.data //获得当前行数据
    ,layEvent = obj.event; //获得 lay-event 对应的值
    if(layEvent === 'detail'){
      layer.msg('查看操作');
    } else if(layEvent === 'more'){
      //下拉菜单
      dropdown.render({
        elem: this //触发事件的 DOM 对象
        ,show: true //外部事件触发即显示
        ,data: [{
          title: '编辑'
          ,id: 'edit'
        },{
          title: '删除'
          ,id: 'del'
        }]
        ,click: function(menudata){
          if(menudata.id === 'del'){
            layer.confirm('真的删除行么', function(index){
              obj.del(); //删除对应行（tr）的DOM结构
              layer.close(index);
              //向服务端发送删除指令
            });
          } else if(menudata.id === 'edit'){
            layer.msg('编辑操作，当前行 ID:'+ data.id);
          }
        }
        ,align: 'right' //右对齐弹出（v2.6.8 新增）
        ,style: 'box-shadow: 1px 1px 10px rgb(0 0 0 / 12%);' //设置额外样式
      })
    }
  });
  
  //执行一个轮播实例
  carousel.render({
    elem: '#test1'
    ,width: '100%' //设置容器宽度
    ,height: 200
    ,arrow: 'none' //不显示箭头
    ,anim: 'fade' //切换动画方式
  });
  
  //将日期直接嵌套在指定容器中
  var dateIns = laydate.render({
    elem: '#laydateDemo'
    ,position: 'static'
    ,calendar: true //是否开启公历重要节日
    ,mark: { //标记重要日子
      '0-10-14': '生日'
      ,'2020-01-18': '小年'
      ,'2020-01-24': '除夕'
      ,'2020-01-25': '春节'
      ,'2020-02-01': '上班'
    } 
    ,done: function(value, date, endDate){
      if(date.year == 2017 && date.month == 11 && date.date == 30){
        dateIns.hint('一不小心就月底了呢');
      }
    }
    ,change: function(value, date, endDate){
      layer.msg(value)
    }
  });
  
  //分页
  laypage.render({
    elem: 'pageDemo' //分页容器的id
    ,count: 1000 //数据总数
    ,limit: 10 //每页显示的数据条数
    ,skin: '#1E9FFF' //自定义选中色值
    //,layout: ['prev', 'page', 'next', 'count', 'limit', 'refresh', 'skip'] //自定义排版
    ,jump: function(obj, first){
      if(!first){
        layer.msg('第'+ obj.curr +'页', {offset: 'b'});
      }
    }
  });
  
  //上传
  upload.render({
    elem: '#uploadDemo'
    ,url: 'https://httpbin.org/post' //改成您自己的上传接口
    ,done: function(res){
      layer.msg('上传成功');
      layui.$('#uploadDemoView').removeClass('layui-hide').find('img').attr('src', res.files.file);
      console.log(res)
    }
    ,before: function(){
      layer.msg('上传中', {icon: 16, time: 0});
    }
  });
  
  //滑块
  var sliderInst = slider.render({
    elem: '#sliderDemo'
    ,input: true //输入框
  });
  
  //底部信息
  var footerTpl = lay('#footer')[0].innerHTML;
  lay('#footer').html(layui.laytpl(footerTpl).render({}))
  .removeClass('layui-hide');
});
</script>
</body>
</html>        
        