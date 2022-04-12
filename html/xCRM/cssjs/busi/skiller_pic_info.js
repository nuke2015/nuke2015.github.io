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
            "required": false,
            "expression": "",
            "document": ""
        }, {
            "id": "pic",
            "index": 1,
            "label": "照片",
            "title": "单张照片",
            "tag": "image",
            "tagIcon": "image",
            "placeholder": "请输入",
            "defaultValue": null,
            "labelWidth": null,
            "disabled": false,
            "required": true,
            "document": "",
            "uploadUrl": ""
        }, {
            "id": "type_pic",
            "index": 2,
            "label": "类型",
            "tag": "radio",
            "tagIcon": "radio",
            "labelWidth": 110,
            "disabled": false,
            "document": "",
            "datasourceType": "local",
            "remoteUrl": "http://",
            "remoteMethod": "post",
            "remoteOptionText": "options.data.dictName",
            "remoteOptionValue": "options.data.dictId",
            "options": [{
                "text": "证书证件",
                "value": "1",
                "checked": true
            }, {
                "text": "工作风采",
                "value": "2",
                "checked": false
            }]
        }];
    },
    r: {},
    get_info: function(id) {
        if (id > 0) {
            var req = {
                "methodName": "SkillerPicInfo",
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
    var skiller_id = g_params.skiller_id
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
        json.skiller_id = skiller_id;
        if (id > 0) {
            json.id = id;
            json.methodName = "SkillerPicEdit";
        } else {
            json.methodName = "SkillerPicAdd";
        }
        // 读图片 
        json.pic = fengform.upload_get("pic");
        pics = json.pic.split(',');
        if (pics.length > 1) {
            layer.msg('一次只能传一张图片!');
            return false;
        }
        api_crm(json, function(res) {
            if (id > 0) {
                layer.msg(res.msg);
            } else {
                layer.msg(res.msg);
                console.log('add and reload');
                // 添加时重载!
                location.reload();
            }
        }, function(res) {
            layer.msg(res);
        });
        return false;
    });
});