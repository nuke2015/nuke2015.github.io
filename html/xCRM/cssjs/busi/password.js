var api = {
    formJson: function() {
        // var block_action = fengform.config_get('block_action');
        // var option = fengform.config_to_form(block_action);
        return [{
            "id": "password_pre",
            "index": 0,
            "label": "新密码",
            "tag": "password",
            "tagIcon": "password",
            "placeholder": "请输入",
            "defaultValue": null,
            "labelWidth": 189,
            "width": "100%",
            "clearable": true,
            "maxlength": null,
            "showWordLimit": false,
            "readonly": false,
            "disabled": false,
            "required": true,
            "document": ""
        }, {
            "id": "password",
            "index": 1,
            "label": "请再次输入新密码",
            "tag": "password",
            "tagIcon": "password",
            "placeholder": "请输入",
            "defaultValue": null,
            "labelWidth": 189,
            "width": "100%",
            "clearable": true,
            "maxlength": null,
            "showWordLimit": false,
            "readonly": false,
            "disabled": false,
            "required": true,
            "document": ""
        }];
    },
    r: {},
    get_info: function(id) {
        if (id > 0) {
            var req = {
                "methodName": "DemoInfo",
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
        console.log(formData);
        api.r = layui.formPreview.render({
            elem: '#demoform',
            data: api.formJson(),
            formData: formData
        });
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
    var id = g_params.id
    // // 全局配置
    // banner_action = fengform.config_get('banner_action');
    // console.log(banner_action);
    // banner_action_form = fengform.config_to_form(banner_action);
    // console.log(banner_action_form);
    api.show_info();
    //监听表单提交
    form.on('submit(demo1)', function(data) {
        var json = api.r.getFormData();
        if (json.password_pre != json.password) {
            layer.msg('两次密码不一致!');
        }
        var identity = helper._store('identity');
        // 鐧婚檰鎬佹敞鍏�
        if (identity && identity.admin_id && identity.token) {
            json.methodName = "AdminEdit";
            json.id = identity.admin_id;
        }
        // 读图片 
        api_crm(json, function(res) {
            layer.msg(res.msg);
        }, function(res) {
            console.log(res);
        });
        return false;
    });
});