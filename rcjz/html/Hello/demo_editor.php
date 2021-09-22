<include file="Common:header" />
<script src="/html/jiameng/layui/layui.js"></script>
<link rel="stylesheet" href="/html/jiameng/layui/css/layui.css" media="all">

<div class="layui-fluid">
  <div class="layui-card">
    <div class="layui-card-body">
      <div class="layui-form layui-card-header layuiadmin-card-header-auto" lay-filter="app-order-list">
        <input type="hidden" name="methodName" value="CorpOrderList">
        <div class="layui-form-item">
          <div class="layui-inline">
            <label class="layui-form-label">关键词</label>
            <div class="layui-input-inline">
              <input type="text" class="layui-input" name="keyword" placeholder="关键词">
            </div>
          </div>
          <button class="layui-btn" id="serachBtn" lay-submit
                lay-filter="LAY-app-order-list-search">
              <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
            </button>
          </div>
      </div>
      <div style="padding-bottom: 10px;">
        <a class="layui-btn layuiadmin-btn-list" href="/">添加</a>
      </div>
      <table id="LAY-app-order-list" lay-filter="LAY-app-order-list"></table>
      <script type="text/html" id="buttonTpl">
          <input type="checkbox" name="status" data-id="{{d.id}}" lay-skin="switch" lay-text="开启|关闭" title="状态管理" lay-filter="attr-status-lock"
             value="{{d.status}}" {{ d.status == true ? 'checked' : '' }}>
      </script>
      <script id="table-article-activity" type="text/html">
        <a class="layui-btn layui-btn-default layui-btn-xs" lay-href="/article/detail/id={{d.id}}"><i class="layui-icon layui-icon-edit"></i>编辑</a>
        <a class="layui-btn layui-btn-default layui-btn-xs" lay-event="del"><i class="layui-icon layui-icon-edit"></i>删除</a>
        </script>
    </div>
  </div>
</div>
<script type="text/javascript">
    layui.config({
        base: '/html/jiameng/src/' //指定项目路径，本地开发用 src，线上用 dist
    })
    layui.extend({
        setter: 'config', //配置文件
        admin: 'lib/admin', //核心模块
        view: 'lib/view', //核心模块
        helper: 'lib/helper' // 方法类助手
    })
    layui.define(['table', 'form', 'laydate','setter','helper'], function () {
        var $ = layui.$,
            view = layui.view,
            table = layui.table,
            laydate = layui.laydate,
            form = layui.form,
            setter = layui.setter,
            helper = layui.helper;
            console.log(setter)
        form.render(null, 'app-article-list');
        table.render({
             elem: '#LAY-app-order-list',
             url: setter.request.requestUrlPreffix + setter.request.requestUrlDir,
             method: 'post',
             where: { "methodName": 'ArticleCmsList','admin_id':'11','corp_id':1,'token':''},
             request: {
                 limitName: 'size'
             },
             cols: [
                 [
                     {
                         field: 'id',
                         title: 'ID',
                     },
                     { field: 'title', title: '文章标题', width: 140, align: 'center' },
                     { field: 'title', title: '文章缩略图', width: 100, align: 'center',templet: function (d) {
                             return '<img src="'+d.image+'" width="100">';
                     }},
                     // { field: 'category_id', title: '分类名称' },
                     {
                         field: 'keyword',
                         title: '关键词',
                     },
                     {
                         field: 'desp',
                         title: '描述',
                         width: 140
                     },
                     {
                         field: 'create_at',
                         title: '创建时间',
                         align: 'center',
                         templet: function (d) {
                             return helper.timeStampToDate(d.create_at, 2)
                         }
                     },
                     { field: 'status', title: '状态', width: 100, templet: '#articleButtonTpl', align: 'center', unresize: true },
                     { title: '操作', align: 'center', width: 200, fixed: 'right', toolbar: '#table-article-activity' }
                 ]
             ],
             parseData: function (res) {
                 res.data['code'] = 0
                 res.data['count'] = res.data.total
                 return res.data
             },
             done: function (res, curr, count) {
                 console.log(res)
             },
             defaultToolbar: ['filter', 'print', 'exports'],
             loading: true,
             page: true,
             limit: 10,
             limits: [10, 15, 20],
             text: '对不起，加载出现异常！'
         });
    })
</script>
<include file="Common:footer" />
