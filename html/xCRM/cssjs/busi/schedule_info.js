var api = {
    formJson: function(formData) {
        var schedule_status = fengform.config_get('schedule_status');
        var option = fengform.config_to_form(schedule_status);
        return [{
            "id": "title",
            "index": 0,
            "label": "备注",
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
            "id": "start_time",
            "index": 1,
            "label": "开始时间",
            "tag": "date",
            "tagIcon": "date",
            "labelWidth": 110,
            "width": "100%",
            "clearable": true,
            "maxlength": null,
            "dateDefaultValue": helper.timeStampToDate(formData.start_time,'5'),
            "datetype": "date",
            "range": false,
            "dateformat": "yyyy-MM-dd",
            "isInitValue": false,
            "dataMaxValue": "2088-12-31",
            "dataMinValue": "1900-01-01",
            "trigger": null,
            "position": "absolute",
            "theme": "default",
            "mark": null,
            "showBottom": true,
            "zindex": 66666666,
            "disabled": false,
            "required": false,
            "document": ""
        }, {
            "id": "end_time",
            "index": 2,
            "label": "结束时间",
            "tag": "date",
            "tagIcon": "date",
            "labelWidth": 110,
            "width": "100%",
            "clearable": true,
            "maxlength": null,
            "dateDefaultValue": helper.timeStampToDate(formData.end_time,'5'),
            "datetype": "date",
            "range": false,
            "dateformat": "yyyy-MM-dd",
            "isInitValue": false,
            "dataMaxValue": "2088-12-31",
            "dataMinValue": "1900-01-01",
            "trigger": null,
            "position": "absolute",
            "theme": "default",
            "mark": null,
            "showBottom": true,
            "zindex": 66666666,
            "disabled": false,
            "required": false,
            "document": ""
        }, {
            "id": "status",
            "index": 0,
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
            "options": option
        }];
    },
    r: {},
    get_info: function(id) {
        if (id > 0) {
            var req = {
                "methodName": "ScheduleInfo",
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
            data: api.formJson(formData),
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
            json.methodName = "ScheduleEdit";
        } else {
            json.skiller_id = skiller_id;
            json.methodName = "ScheduleAdd";
        }
        json.start_time = helper.dateToTimeStamp(json.datestart_time);
        json.end_time = helper.dateToTimeStamp(json.dateend_time);
        // 读图片 
        json.pic = fengform.upload_get("pic");
        api_crm(json, function(res) {
            layer.msg(res.msg);
        }, function(res) {
            layer.msg(res.msg);
        });
        return false;
    });
});