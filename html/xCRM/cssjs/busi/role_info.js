var api = {
    formJson: function() {
        // var block_action = fengform.config_get('block_action');
        // var option = fengform.config_to_form(block_action);
        return [{
            "id": "title",
            "index": 0,
            "label": "名称",
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
            "required": true,
            "expression": "",
            "document": ""
        }];
    },
    r: {},
    get_info: function(id) {
        if (id > 0) {
            var req = {
                "methodName": "RoleInfo",
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
        fengform.upload_set('pic', formData.pic);
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
            json.methodName = "RoleEdit";
        } else {
            json.methodName = "RoleAdd";
        }
        // 读图片 
        json.pic = fengform.upload_get("pic");
        api_crm(json, function(res) {
            layer.msg(res.msg, function() {
                location.href = "/html/role_list.html";
            });
        }, function(res) {
            console.log(res);
        });
        return false;
    });
});