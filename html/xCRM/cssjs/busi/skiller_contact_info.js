var api = {
    formJson: function(data) {
        console.info(data);
        var pca_default = data.province + ',' + data.city + ',' + data.area;
        return [{
            "id": "mobile",
            "index": 0,
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
            "required": true,
            "expression": "phone",
            "document": ""
        }, {
            "id": "idcard",
            "index": 1,
            "label": "身份证号",
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
            "id": "contact_person",
            "index": 2,
            "label": "紧急联系人",
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
            "id": "contact_phone",
            "index": 3,
            "label": "紧急联系电话",
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
            "id": "pca",
            "index": 4,
            "label": "省市区",
            "tag": "cityarea",
            "tagIcon": "cityarea",
            "placeholder": "请选择",
            "defaultValue": pca_default,
            "stepValue": 2,
            "minValue": 1,
            "maxValue": 20,
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
        }, {
            "id": "address",
            "index": 5,
            "label": "详细地址",
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
        }, ];
    },
    r: {},
    get_info: function(skiller_id) {
        if (skiller_id > 0) {
            var req = {
                "methodName": "SkillerContactInfo",
                "skiller_id": skiller_id
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
    //监听表单提交
    form.on('submit(demo1)', function(data) {
        var json = api.r.getFormData();
        json.skiller_id = skiller_id;
        json.methodName = "SkillerContactEdit";
        // 收单
        json.province = json.cityareapca_province;
        json.city = json.cityareapca_city;
        json.area = json.cityareapca_area;
        // 读图片
        // json.pic = fengform.upload_get("pic");
        console.log(json);
        api_crm(json, function(res) {
            layer.msg(res.msg);
        }, function(res) {
            layer.msg(res.msg);
        });
        return false;
    });
});