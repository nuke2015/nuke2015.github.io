
//渲染模版
//字符串转数组
func (this *baseController) display(tpl ...string) {
	var tplname string
	if len(tpl) == 1 {
		tplname = this.moduleName + "/" + tpl[0] + ".html"
	} else {
		tplname = this.moduleName + "/" + this.controllerName + "_" + this.actionName + ".html"
	}

	this.Data["version"] = beego.AppConfig.String("AppVer")
	this.Data["adminid"] = this.userid
	this.Data["adminname"] = this.username
	//布局定制
	this.Layout = this.moduleName + "/layout.html"

	//模板定制
	this.TplNames = tplname
}

布局占位
{{.LayoutContent}}

//静态文件直接写,指向根目录
	<meta name="robots" content="all">
	<link href="/static/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="/static/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />
	<link href="/static/themes/admin/css/admin.css" rel="stylesheet" type="text/css"/>
	<script src="/static/js/jquery.min.js" type="text/javascript"></script>
	<script src="/static/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="/static/themes/admin/js/admin.js" type="text/javascript"></script>

模板循环,设置局部变量;
{{range $k, $v := .list}}
		<tr>
			<td><input type="checkbox" name="ids[]" value="{{$v.Id}}" /></td>
			//变量输出;
			<td>{{$v.Id}}</td>
			<td class="hl_title">

			模板判断;
				{{if $v.Istop}}
				<i class="icon-arrow-up" title="置顶"> </i>
				{{end}}
				<a href="{{$v.Link}}" target="_blank">{{str2html $v.ColorTitle}}</a>
				{{if $v.Urltype}}
				<span class="label label-important">页面</span>
				{{end}}
			</td>
			<td class="hl_tag">{{str2html $v.TagsLink}}</td>
			<td>{{$v.Views}}</td>
			<td class="hl_author">{{$v.Author}}</td>

			模板函数调用;
			<td>{{date $v.Posttime "m月d日 H:i:s"}}</td>
			<td><a href="/admin/article/edit?id={{$v.Id}}">编辑</a> | <a href="/admin/article/delete?id={{$v.Id}}" onclick="return del_confirm()">删除</a></td>
		</tr>
		{{end}}


bootstrap时间;
<div class="input-append date" id="datetimepicker" data-date="{{.posttime}}" data-date-format="yyyy-mm-dd HH:ii:ss">

模板等同判断;
{{if eq .post.Status 0}}selected{{end}}

html解析;
{{str2html .post.Content}}

百度编辑器
<script type="text/javascript" charset="utf-8">
	window.UEDITOR_HOME_URL = "/static/ueditor/";
</script>
<script type="text/javascript" src="/static/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="/static/ueditor/ueditor.all.min.js"></script>
<script type="text/plain" id="content" name="content"></script>
<script type="text/javascript" charset="utf-8">
	var options = {"fileUrl":"/admin/article/upload","filePath":"","imageUrl":"/admin/article/upload","imagePath":"","initialFrameWidth":"90%","initialFrameHeight":"400"};
	var ue = UE.getEditor("content", options);
</script>


颜色插件,时间插件
<link href="/static/themes/admin/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen" type="text/css" />
<script src="/static/themes/admin/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script src="/static/themes/admin/js/bootstrap-datetimepicker.zh-CN.js" type="text/javascript"></script>
<script src="/static/themes/admin/js/jquery.colorpicker.js" type="text/javascript"></script>
<script type="text/javascript">
	$(function() {
		$("#colorpicker").colorpicker({
			fillcolor:true,
			success:function(o,color){
				$("input[name='title']").css("color",color);
				$("input[name='color']").val(color);
			},
			reset:function(o) {
				$("input[name='title']").css("color","");
				$("input[name='color']").val("");
			}
		});
		$('#datetimepicker').datetimepicker({
			language:  'zh-CN',
	        weekStart: 1,
	        todayBtn:  1,
			autoclose: 1,
			todayHighlight: 1,
			startView: 2,
			forceParse: 1,
	        showMeridian: 1
	    });
	});
</script>

页面兼容性测试;
<section id="comment">
    <!--高速版，加载速度快，使用前需测试页面的兼容性-->
	<div id="SOHUCS"></div>
	<script>
	  (function(){
	    var appid = 'cyqPDiySE',
	    conf = 'prod_d77e68596c15c53c2a33ad143739902d';
	    var doc = document,
	    s = doc.createElement('script'),
	    h = doc.getElementsByTagName('head')[0] || doc.head || doc.documentElement;
	    s.type = 'text/javascript';
	    s.charset = 'utf-8';
	    s.src =  'http://assets.changyan.sohu.com/upload/changyan.js?conf='+ conf +'&appid=' + appid;
	    h.insertBefore(s,h.firstChild);
	    window.SCS_NO_IFRAME = true;
	  })()
	</script>
</section>

