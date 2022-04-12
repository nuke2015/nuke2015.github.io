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
        // var banner_action=fengform.config_get('banner_action');
        // var option=fengform.config_to_form(banner_action);
        return [{
            "id": "title",
            "index": 0,
            "label": "宝妈名字",
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
            "id": "score_avg",
            "index": 1,
            "label": "综合评分",
            "tag": "rate",
            "tagIcon": "rate",
            "labelWidth": 110,
            "defaultValue": 0,
            "rateLength": 5,
            "half": false,
            "text": false,
            "theme": "default",
            "showBottom": true,
            "readonly": false,
            "document": ""
        }, {
            "id": "score_baobaohuli",
            "index": 2,
            "label": "宝宝护理",
            "tag": "rate",
            "tagIcon": "rate",
            "labelWidth": 110,
            "defaultValue": 0,
            "rateLength": 5,
            "half": false,
            "text": false,
            "theme": "default",
            "showBottom": true,
            "readonly": false,
            "document": ""
        }, {
            "id": "score_baobaozaojiao",
            "index": 3,
            "label": "宝宝早教",
            "tag": "rate",
            "tagIcon": "rate",
            "labelWidth": 110,
            "defaultValue": 0,
            "rateLength": 5,
            "half": false,
            "text": false,
            "theme": "default",
            "showBottom": true,
            "readonly": false,
            "document": ""
        }, {
            "id": "score_shanshidapei",
            "index": 4,
            "label": "膳食搭配",
            "tag": "rate",
            "tagIcon": "rate",
            "labelWidth": 110,
            "defaultValue": 0,
            "rateLength": 5,
            "half": false,
            "text": false,
            "theme": "default",
            "showBottom": true,
            "readonly": false,
            "document": ""
        }, {
            "id": "score_kexueweiyang",
            "index": 5,
            "label": "科学喂养",
            "tag": "rate",
            "tagIcon": "rate",
            "labelWidth": 110,
            "defaultValue": 0,
            "rateLength": 5,
            "half": false,
            "text": false,
            "theme": "default",
            "showBottom": true,
            "readonly": false,
            "document": ""
        }, {
            "id": "score_chanfuhuli",
            "index": 6,
            "label": "产妇护理",
            "tag": "rate",
            "tagIcon": "rate",
            "labelWidth": 110,
            "defaultValue": 0,
            "rateLength": 5,
            "half": false,
            "text": false,
            "theme": "default",
            "showBottom": true,
            "readonly": false,
            "document": ""
        }, {
            "id": "score_goutongjiqiao",
            "index": 7,
            "label": "沟通技巧",
            "tag": "rate",
            "tagIcon": "rate",
            "labelWidth": 110,
            "defaultValue": 0,
            "rateLength": 5,
            "half": false,
            "text": false,
            "theme": "default",
            "showBottom": true,
            "readonly": false,
            "document": ""
        }, {
            "id": "pics",
            "index": 8,
            "label": "用户图片,九张",
            "tag": "image",
            "tagIcon": "image",
            "placeholder": "请输入",
            "defaultValue": null,
            "labelWidth": null,
            "disabled": false,
            "required": false,
            "document": "",
            "uploadUrl": ""
        }, {
            "id": "content",
            "index": 9,
            "label": "评价内容",
            "tag": "textarea",
            "tagIcon": "textarea",
            "placeholder": "请输入",
            "defaultValue": null,
            "width": "100%",
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
                "methodName": "CommentInfo",
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
            fengform.upload_set('pics', formData.pics);
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
    var id = g_params.id;
    var skiller_id = g_params.skiller_id;
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
            json.methodName = "CommentEdit";
        } else {
            json.methodName = "CommentAdd";
        }
        json.skiller_id = skiller_id;
        // 读图片 
        json.pics = fengform.upload_get("pics");
        api_crm(json, function(res) {
            layer.msg("编辑成功!", function() {
                location.href = "/html/comment_list.html";
            });
        }, function(res) {
            console.log(res);
        });
        return false;
    });
});
