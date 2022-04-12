var api = {
    formJson: function() {
        return [{
            "id": "admin_name",
            "index": 0,
            "label": "昵称",
            "tag": "input",
            "tagIcon": "input",
            "placeholder": "请输入",
            "defaultValue": null,
            "labelWidth": 110,
            "width": "100%",
            "clearable": true,
            "maxlength": null,
            "showWordLimit": false,
            "readonly": false,
            "disabled": false,
            "required": false,
            "expression": "",
            "document": ""
        }, {
            "id": "mobile",
            "index": 1,
            "label": "手机号",
            "tag": "input",
            "tagIcon": "input",
            "placeholder": "请输入",
            "defaultValue": null,
            "labelWidth": 110,
            "width": "100%",
            "clearable": true,
            "maxlength": null,
            "showWordLimit": false,
            "readonly": false,
            "disabled": false,
            "required": false,
            "expression": "",
            "document": ""
        }, {
            "id": "password",
            "index": 2,
            "label": "密码框",
            "tag": "password",
            "tagIcon": "password",
            "placeholder": "请输入",
            "defaultValue": null,
            "labelWidth": 110,
            "width": "100%",
            "clearable": true,
            "maxlength": null,
            "showWordLimit": false,
            "readonly": false,
            "disabled": false,
            "required": false,
            "document": ""
        }];
    },
    r: {},
    get_info: function(id) {
        if (id > 0) {
            var req = {
                "methodName": "AdminInfo",
                "admin_id_refer": id
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
        formData.password = '';
        // api.category_get(function(config_category) {
        console.log(formData, api.config_category);
        api.r = layui.formPreview.render({
            elem: '#demoform',
            data: api.formJson(formData),
            formData: formData
        });
        fengform.upload_set('pic', formData.pic);
        // });
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
    api.get_info(id);
    //监听表单提交
    form.on('submit(demo1)', function(data) {
        var json = api.r.getFormData();
        if (id > 0) {
            json.id = id;
            json.methodName = "AdminEdit";
        } else {
            json.methodName = "AdminAdd";
        }
        // 读图片
        json.pic = fengform.upload_get("pic");
        api_crm(json, function(res) {
            layer.msg('编辑成功!', function() {
                location.href = "/html/admin_list.html";
            });
        }, function(res) {
            console.log(res);
        });
        return false;
    });
});