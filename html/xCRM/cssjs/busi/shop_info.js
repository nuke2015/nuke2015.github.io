var api = {
    config: {},
    config_get: function() {
        var req = {
            "methodName": "Config"
        };
        api_crm(req, function(res) {
            api.config = res.data;
            console.info(api.config);
        }, function() {
            //
        });
    },
    category_get: function(cb) {
        var req = {
            "methodName": "CategoryList"
        };
        api_crm(req, function(res) {
            var list = res.data.data;
            var result = [];
            result.push({
                "text": '请选择栏目',
                'value': 0,
                'checked': false
            });
            for (i in list) {
                result.push({
                    "text": list[i]['title'],
                    'value': list[i]['id'],
                    'checked': false
                });
            }
            cb(result);
        }, function() {
            //
        });
    },
    formJson: function() {
        var banner_action = fengform.config_get('banner_action');
        var option = fengform.config_to_form(banner_action);
        return [{
            "id": "shop_title",
            "index": 0,
            "label": "店铺名称",
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
        }, {
            "id": "contact",
            "index": 1,
            "label": "热线电话",
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
            "id": "address",
            "index": 2,
            "label": "店铺地址",
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
            "id": "geo_addr",
            "index": 3,
            "label": "门店坐标",
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
            "id": "about",
            "index": 4,
            "label": "店铺简介",
            "tag": "textarea",
            "tagIcon": "textarea",
            "placeholder": "请输入",
            "defaultValue": null,
            "width": "100%",
            "readonly": false,
            "disabled": false,
            "required": false,
            "document": ""
        }, {
            "id": "weixin",
            "index": 5,
            "label": "接单微信",
            "title": "上传二维码",
            "tag": "image",
            "tagIcon": "image",
            "placeholder": "请输入",
            "defaultValue": null,
            "labelWidth": null,
            "disabled": false,
            "required": true,
            "document": "",
            "uploadUrl": ""
        }];
    },
    r: {},
    get_info: function(id) {
        if (id > 0) {
            var req = {
                "methodName": "ShopInfo",
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
        api.category_get(function(config_category) {
            console.log(formData, api.config_category);
            api.r = layui.formPreview.render({
                elem: '#demoform',
                data: api.formJson(config_category),
                formData: formData
            });
            fengform.upload_set('weixin', formData.weixin);
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
    api.get_info(id);
    //监听表单提交
    form.on('submit(demo1)', function(data) {
        var json = api.r.getFormData();
        if (id > 0) {
            json.id = id;
            json.methodName = "ShopEdit";
        } else {
            json.methodName = "ShopAdd";
        }
        json.table = "bestphp_shop";
        // 读图片 
        json.weixin = fengform.upload_get("weixin");
        api_crm(json, function(res) {
            layer.msg(res.msg, function() {
                location.href = "/html/shop_list.html";
            });
        }, function(res) {
            console.log(res);
        });
        return false;
    });
});