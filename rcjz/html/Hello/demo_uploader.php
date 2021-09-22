<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport"
			content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<title>详情</title>
		<link rel="stylesheet" href="/Public/rcjz/layui2.6/layui/css/layui.css?t=20210802" media="all">
		<script src="/Public/rcjz/layui2.6/layui/layui.js?t=20210802"></script>
		<script src="/Public/rcjz/cssjs/utils_min.js?t=20210802"></script>
		<script src="/Public/rcjz/cssjs/common.js?t=20210802"></script>
	</head>
	<style>
	.layui-upload-img{
		width: 125px;
		height: 125px;
	}
	.js_upload_item{
		margin-left:7px;
		float: left;
	}
	#skiller_list span{
		font-size: 22px;
		border:1px red dashed;
		margin:5px 15px;
		float:left;
	}
	</style>
	<body class="layui-main">
		<div class="main layui-row layui-col-xs12">
			<h1 class="js_title">详情</h1>
			<div class="layui-card-body">
				<form method="post">
                <div class="layui-form" id="DistributeInfo" lay-filter="DistributeInfo">
                    
                    <input type="hidden" name="id" value="{{ d.id || '' }}" />
					
					<div class="layui-form-item">
                        <label class="layui-form-label">title</label>
                        <div class="layui-input-block">
                          <input type="text" name="title" lay-verify="title" autocomplete="off"  placeholder="" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">关键词</label>
                        <div class="layui-input-block">
                          <input type="text" name="keyword" lay-verify="keyword" autocomplete="off"  placeholder="" class="layui-input">
                        </div>
                    </div>
                    
                    <div class="layui-form-item">
                        <label class="layui-form-label">描述</label>
                        <div class="layui-input-block">
                          <input type="text" name="desp" lay-verify="desp" autocomplete="off"  placeholder="" class="layui-input">
                        </div>
                    </div>

					<div class="layui-form-item">
                        <label class="layui-form-label">分类</label>
                        <div class="layui-input-block">
                          <input type="text" name="category_id" lay-verify="category_id" autocomplete="off"  placeholder="" class="layui-input">
                        </div>
                    </div>

					<div class="layui-form-item" id="pic">
                        <label class="layui-form-label">图片：</label>
                        <div class="layui-upload layui-input-block">
                            <button type="button" class="layui-btn" id="pic_btn">上传</button>
                            <blockquote class="layui-elem-quote layui-quote-nm" style="margin-top: 10px;">
                                <div class="layui-upload-list layui-inline js_result_up"></div>
                            </blockquote>
                        </div>
                    </div>
				
				
					<div class="layui-form-item">
						<label class="layui-form-label">content</label>
                        <div class="layui-input-block">
                        	<textarea name="content" class="layui-textarea" cols="30" rows="10"></textarea>
                        </div>
                    </div>

					 <div class="layui-form-item">
	                    <div class="layui-input-block">
	                      <button type="submit" class="layui-btn" lay-submit="" lay-filter="DistributeSubmit">立即提交</button>
	                    </div>
	                </div>

                </div>
				</form>
			</div>
		</div>
		<script src="/Public/rcjz/busi/demo_uploader.js"></script>
	</body>
</html>
