var api = {
    more_info: function(skiller_id) {
        // 购买记录
        var turl = "/html/skiller_pic_list.html?skiller_id=" + skiller_id;
        var html = " <iframe src='" + turl + "' frameborder='0' scrolling=auto style='width:95%;height:800px;border:0px;'></iframe>";
        $("#more_info").append(html);
    },
    avatar_bind: function(option) {
        $('.js_avatar').click(function() {
            var skiller_id = $(this).attr("skiller_id");
            var pic = $(this).attr("pic");
            var type = $(this).attr("type");
            console.log(skiller_id, pic, type);
            var turl = "/html/avatar2.html?skiller_id={0}&type={1}&turl={2}".format(skiller_id, type, pic);
            var i = fengform.open(turl);
            layer.full(i);
        });
    },
    formJson: function(formData) {
        var skiller_level = fengform.config_get('skiller_level');
        var option = fengform.config_to_form(skiller_level);
        return [{
            "id": "pic",
            "index": 1,
            "label": "方形小头像",
            "tag": "html",
            "tagIcon": "html",
            "placeholder": "请输入",
            "defaultValue": null,
            "labelWidth": 10,
            "disabled": false,
            "required": false,
            "html": "<img src='{0}' class='avt' /><span class='js_avatar layui-btn layui-btn-sm' skiller_id='{1}' pic='{2}' type='pic'>上传</span>".format(formData.pic, formData.id, formData.pic),
            "uploadUrl": "/api_crm/?methodName=FileUpload",
            "bind": api.avatar_bind,
        }, {
            "id": "pic_big",
            "index": 2,
            "label": "横图大头像",
            "tag": "html",
            "tagIcon": "html",
            "placeholder": "请输入",
            "defaultValue": null,
            "labelWidth": 10,
            "disabled": false,
            "required": false,
            "html": "<img src='{0}' class='avt_big' /><span class='js_avatar layui-btn layui-btn-sm' skiller_id='{1}' pic='{2}' type='pic_big'>上传</span>".format(formData.pic_big, formData.id, formData.pic_big),
            "uploadUrl": "/api_crm/?methodName=FileUpload",
            "bind": api.avatar_bind,
        }];
    },
    r: {},
    get_info: function(id) {
        if (id > 0) {
            var req = {
                "methodName": "SkillerInfo",
                "id": id
            };
            api_crm(req, function(res) {
                api.show_info(res.data);
                // 图片上传
                // 图片显示
            }, function() {
                //error
            });
        } else {
            api.show_info({})
        }
    },
    show_info: function(formData) {
        api.r = layui.formPreview.render({
            elem: '#demoform',
            data: api.formJson(formData),
            formData: formData
        });
        fengform.upload_set('pic', formData.pic);
        fengform.upload_set('pic_big', formData.pic_big);
    }
}
//JavaScript代码区域
layui.config({
    base: '/ayq/modules/'
}).use(['formPreview', 'form', 'layer', 'upload'], function() {
    var layer = layui.layer;
    var $ = layui.jquery;
    var upload = layui.upload;
    var index = layui.index;
    var formPreview = layui.formPreview;
    var form = layui.form;
    var skiller_id = g_params.skiller_id
    // // 全局配置
    // banner_action = fengform.config_get('banner_action');
    // console.log(banner_action);
    // banner_action_form = fengform.config_to_form(banner_action);
    // console.log(banner_action_form);
    api.get_info(skiller_id);
    $(".js_avatar").click(function() {
        console.log('sdf');
    });
    //监听表单提交
    form.on('submit(demo1)', function(data) {
        var json = api.r.getFormData();
        if (skiller_id > 0) {
            json.id = skiller_id;
            json.methodName = "SkillerEdit";
        } else {
            json.methodName = "SkillerAdd";
        }
        // 强制上星
        if (json.level < 1) {
            layer.msg('阿姨必须设置星级!');
            return false;
        }
      
        // api_crm(json, function(res) {
            layer.msg('编辑成功!');
        // }, function(res) {
        //     layer.msg(res.msg);
        //     console.log(res);
        // });
        return false;
    });
});