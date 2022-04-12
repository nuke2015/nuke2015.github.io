var api = {
    formJson: function() {
        // var block_action = fengform.config_get('block_action');
        // var option = fengform.config_to_form(block_action);
        return [{
            "id": "title",
            "index": 0,
            "label": "标题",
            "tag": "input",
            "tagIcon": "input",
            "placeholder": "文章标题",
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
            "id": "category_id",
            "index": 1,
            "label": "分章栏目",
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
            "options": []
        }, {
            "id": "pic",
            "index": 2,
            "label": "封面图片",
            "tag": "image",
            "tagIcon": "image",
            "placeholder": "上传封面图片",
            "defaultValue": null,
            "labelWidth": null,
            "disabled": false,
            "required": false,
            "document": "",
            "uploadUrl": ""
        }, {
            "id": "content",
            "index": 3,
            "label": "文章内容",
            "tag": "editor",
            "tagIcon": "editor",
            "width": "100%",
            "clearable": true,
            "maxlength": null,
            "showWordLimit": false,
            "menu": ["backColor", "fontSize", "foreColor", "bold", "italic", "underline", "strikeThrough", "justifyLeft", "justifyCenter", "justifyRight", "indent", "outdent", "insertOrderedList", "insertUnorderedList", "superscript", "subscript", "createLink", "unlink", "hr", "face", "table", "files", "music", "video", "insertImage", "removeFormat", "code", "line"],
            "height": "200px",
            "uploadUrl": "/api_crm/?methodName=iceFileUpload",
            "disabled": false,
            "document": "/html/upload_help.html"
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
            json.methodName = "OrderFollowEdit";
        } else {
            json.methodName = "OrderFollowAdd";
        }
        // 读图片 
        json.pic = fengform.upload_get("pic");
        api_crm(json, function(res) {
            layer.msg(res.msg);
        }, function(res) {
            console.log(res);
        });
        return false;
    });
});