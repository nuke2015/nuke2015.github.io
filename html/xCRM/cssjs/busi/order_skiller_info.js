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
        return [{
            "id": "start_time",
            "index": 0,
            "label": "开始时间",
            "tag": "date",
            "tagIcon": "date",
            "labelWidth": 110,
            "width": "100%",
            "clearable": true,
            "maxlength": null,
            "dateDefaultValue": "",
            "datetype": "datetime",
            "range": false,
            "dateformat": "yyyy-MM-dd HH:mm:ss",
            "isInitValue": false,
            "dataMaxValue": "2088-12-31 0:0:0",
            "dataMinValue": "1900-01-01 0:0:0",
            "trigger": null,
            "position": "absolute",
            "theme": "default",
            "mark": null,
            "showBottom": true,
            "zindex": 66666666,
            "disabled": false,
            "required": true,
            "document": ""
        }, {
            "id": "end_time",
            "index": 1,
            "label": "结束时间",
            "tag": "date",
            "tagIcon": "date",
            "labelWidth": 110,
            "width": "100%",
            "clearable": true,
            "maxlength": null,
            "dateDefaultValue": "",
            "datetype": "datetime",
            "range": false,
            "dateformat": "yyyy-MM-dd HH:mm:ss",
            "isInitValue": false,
            "dataMaxValue": "2088-12-31 0:0:0",
            "dataMinValue": "1900-01-01 0:0:0",
            "trigger": null,
            "position": "absolute",
            "theme": "default",
            "mark": null,
            "showBottom": true,
            "zindex": 66666666,
            "disabled": false,
            "required": true,
            "document": ""
        }];
    },
    r: {},
    get_info: function(id) {
        if (id > 0) {
            var req = {
                "methodName": "OrderSkillerInfo",
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
    var order_id = g_params.order_id
    var skiller_id = g_params.skiller_id
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
            json.methodName = "OrderSkillerEdit";
        } else {
            json.methodName = "OrderSkillerAdd";
        }
        
        json.order_id=order_id;
        json.skiller_id=skiller_id;
        json.start_time=helper.dateToTimeStamp(json.datestart_time);
        json.end_time=helper.dateToTimeStamp(json.dateend_time);

        // 读图片 
        json.pic = fengform.upload_get("pic");
        // console.log(json);
        api_crm(json, function(res) {
            layer.msg(res.msg);
        }, function(res) {
            console.log(res);
        });
        return false;
    });
});