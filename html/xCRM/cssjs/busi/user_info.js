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
    more_info:function(id){
        // 收款记录
        var turl = "/html/user_follow_list.html?&type=2&user_id={0}&r={1}".format(id, Math.random);
        var html = " <iframe src='" + turl + "' frameborder='0' scrolling=auto style='width:95%;height:800px;border:0px;'></iframe>";
        $("#more_info").append(html);
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
        return [{
                "id": "nickname",
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
            },
            {
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
            },
            {
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
            }
        ];
    },
    get_info: function(id) {
        if (id > 0) {
            var req = {
                "methodName": "UserInfo",
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
        formData.password='';
        // api.category_get(function(config_category) {
            console.log(formData, api.config_category);
            api.r = layui.formPreview.render({
                elem: '#demoform',
                data: api.formJson(),
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
    if(id){
        api.more_info(id);
    }
    //监听表单提交
    form.on('submit(demo1)', function(data) {
        var json = api.r.getFormData();
        if (id > 0) {
            json.id = id;
            json.methodName = "UserEdit";
        } else {
            json.methodName = "UserAdd";
        }
        // 读图片
        json.pic = fengform.upload_get("pic");
        api_crm(json, function(res) {
            layer.msg(res.msg, function() {
                location.href = "/html/user_list.html";
            });
        }, function(res) {
            console.log(res);
        });
        return false;
    });
});