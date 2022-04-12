var api = {
    req: {
        "methodName": "DemoInfo",
        "id": 0
    },
    formJson: function() {
        return [{
            "id": "remark",
            "index": 0,
            "label": "跟进内容",
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
    get_info: function(id) {
        if (id > 0) {
            api.req.id=id;
            api_crm(api.req, function(res) {
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
    var order_id = g_params.order_id
    var type = g_params.type
    if(type){
        api.req.type=type;
    }
    // // 全局配置
    // banner_action = fengform.config_get('banner_action');
    // console.log(banner_action);
    // banner_action_form = fengform.config_to_form(banner_action);
    // console.log(banner_action_form);
    api.get_info(id);
    //监听表单提交
    form.on('submit(demo1)', function(data) {
        var json = api.r.getFormData();
        json.type=type;
        if (id > 0) {
            json.id = id;
            json.methodName = "OrderFollowEdit";
        } else {
            json.order_id=order_id;
            json.type=type;
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