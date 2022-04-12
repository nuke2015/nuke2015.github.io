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
        var product_type_id = fengform.config_get('product_type_id');
        var option = fengform.config_to_form(product_type_id);
        return [{
            "id": "title",
            "index": 0,
            "label": "标题",
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
            "id": "pic",
            "index": 1,
            "label": "封面图",
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
            "id": "tag",
            "index": 2,
            "label": "调用标识",
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
            "id": "product_type_id",
            "index": 3,
            "label": "关联产品",
            "tag": "select",
            "tagIcon": "select",
            "labelWidth": 110,
            "width": "100%",
            "disabled": false,
            "required": false,
            "document": "",
            "datasourceType": "local",
            "remoteUrl": "http://",
            "remoteMethod": "post",
            "remoteOptionText": "options.data.dictName",
            "remoteOptionValue": "options.data.dictId",
            "remoteDefaultValue": "12",
            "options": option
        }, {
            "id": "content",
            "index": 4,
            "label": "富文本海报",
            "tag": "editor",
            "tagIcon": "editor",
            "width": "100%",
            "clearable": true,
            "maxlength": null,
            "showWordLimit": false,
            "menu": ["backColor", "fontSize", "foreColor", "bold", "italic", "underline", "strikeThrough", "justifyLeft", "justifyCenter", "justifyRight", "indent", "outdent", "insertOrderedList", "insertUnorderedList", "superscript", "subscript", "createLink", "unlink", "hr", "face", "table", "files", "music", "video", "insertImage", "removeFormat", "code", "line"],
            "height": "200px",
            "uploadUrl": "/api_crm/?methodName=IceFileUpload",
            "disabled": false,
            "document": ""
        }];
    },
    r: {},
    get_info: function(id) {
        if (id > 0) {
            var req = {
                "methodName": "SingleInfo",
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
            fengform.upload_set('pic', formData.pic);
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
            json.methodName = "SingleEdit";
        } else {
            json.methodName = "SingleAdd";
        }
        // 读图片 
        json.pic = fengform.upload_get("pic");
        api_crm(json, function(res) {
            layer.msg("编辑成功!", function() {
                location.href = "/html/single_list.html";
            });
        }, function(res) {
            console.log(res);
        });
        return false;
    });
});