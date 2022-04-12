var api = {
    more_info: function(skiller_id) {
        // 购买记录
        var turl = "/html/skiller_pic_list.html?skiller_id=" + skiller_id;
        var html = " <iframe src='" + turl + "' frameborder='0' scrolling=auto style='width:95%;height:800px;border:0px;'></iframe>";
        $("#more_info").append(html);
    },
    avatar_bind: function(option) {
        $('.js_avatar').click(function() {
            var skiller_id = $(this).attr("skiller_id");
            var pic = $(this).attr("pic");
            var type = $(this).attr("type");
            console.log(skiller_id, pic, type);
            var turl = "/html/avatar2.html?skiller_id={0}&type={1}&turl={2}".format(skiller_id, type, pic);
            var i = fengform.open(turl);
            layer.full(i);
        });
    },
    formJson: function(formData) {
        var skiller_level = fengform.config_get('skiller_level');
        var option = fengform.config_to_form(skiller_level);
        return [{
            "id": "skiller_name",
            "index": 0,
            "label": "姓名",
            "tag": "input",
            "tagIcon": "input",
            "placeholder": "请输入",
            "defaultValue": null,
            "labelWidth": 110,
            "width": "NaN%",
            "clearable": true,
            "maxlength": null,
            "showWordLimit": false,
            "readonly": false,
            "disabled": false,
            "required": true,
            "expression": "",
            "document": ""
        }, {
            "id": "level",
            "index": 2,
            "label": "星级",
            "tag": "select",
            "tagIcon": "select",
            "labelWidth": 110,
            "width": "NaN%",
            "disabled": false,
            "required": true,
            "document": "",
            "datasourceType": "local",
            "remoteUrl": "http://",
            "remoteMethod": "post",
            "remoteOptionText": "options.data.dictName",
            "remoteOptionValue": "options.data.dictId",
            "remoteDefaultValue": "12",
            "options": option
        }, {
            "id": "describe",
            "index": 3,
            "label": "综合评价",
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
            "id": "birthday",
            "index": 5,
            "label": "生日",
            "tag": "date",
            "tagIcon": "date",
            "labelWidth": 110,
            "width": "100%",
            "clearable": true,
            "maxlength": null,
            "dateDefaultValue": helper.timeStampToDate(formData.birthday, 5),
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
            "id": "huli",
            "index": 6,
            "label": "护理多少年",
            "tag": "input",
            "tagIcon": "input",
            "placeholder": "请输入",
            "defaultValue": null,
            "labelWidth": 220,
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
            "id": "jiating",
            "index": 7,
            "label": "服务多少个家庭",
            "tag": "input",
            "tagIcon": "input",
            "placeholder": "请输入",
            "defaultValue": null,
            "labelWidth": 220,
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
            "id": "peixun",
            "index": 8,
            "label": "培训多少课时",
            "tag": "input",
            "tagIcon": "input",
            "placeholder": "请输入",
            "defaultValue": null,
            "labelWidth": 220,
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
            "id": "xueli",
            "index": 9,
            "label": "最高学历",
            "tag": "select",
            "tagIcon": "select",
            "labelWidth": 220,
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
            "options": [{
                "text": "小学",
                "value": "1",
                "checked": true
            }, {
                "text": "高中",
                "value": "2",
                "checked": false
            }, {
                "text": "大学",
                "value": "3",
                "checked": false
            }]
        }, {
            "id": "score",
            "index": 10,
            "label": "客户评价分",
            "tag": "rate",
            "tagIcon": "rate",
            "labelWidth": 220,
            "defaultValue": 0,
            "rateLength": 5,
            "half": false,
            "text": false,
            "theme": "default",
            "showBottom": true,
            "readonly": false,
            "document": ""
        }, {
            "id": "status",
            "index": 11,
            "label": "状态",
            "tag": "radio",
            "tagIcon": "radio",
            "labelWidth": 220,
            "disabled": false,
            "document": "",
            "datasourceType": "local",
            "remoteUrl": "http://",
            "remoteMethod": "post",
            "remoteOptionText": "options.data.dictName",
            "remoteOptionValue": "options.data.dictId",
            "options": [{
                "text": "黑名单",
                "value": "-1",
                "checked": true
            }, {
                "text": "下线",
                "value": "0",
                "checked": false
            }, {
                "text": "上线",
                "value": "1",
                "checked": false
            }]
        }, {
            "id": "health_card",
            "index": 12,
            "label": "健康证",
            "tag": "date",
            "tagIcon": "date",
            "labelWidth": 110,
            "width": "100%",
            "clearable": true,
            "maxlength": null,
            "dateDefaultValue": helper.timeStampToDate(formData.health_card, 5),
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
            "id": "health_meidu",
            "index": 5,
            "label": "梅毒检查时间",
            "tag": "date",
            "tagIcon": "date",
            "labelWidth": 110,
            "width": "100%",
            "clearable": true,
            "maxlength": null,
            "dateDefaultValue": helper.timeStampToDate(formData.health_meidu, 5),
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
            "id": "health_aizi",
            "index": 5,
            "label": "爱滋检查时间",
            "tag": "date",
            "tagIcon": "date",
            "labelWidth": 110,
            "width": "100%",
            "clearable": true,
            "maxlength": null,
            "dateDefaultValue": helper.timeStampToDate(formData.health_aizi, 5),
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
            "id": "health_yigan",
            "index": 5,
            "label": "乙肝检查时间",
            "tag": "date",
            "tagIcon": "date",
            "labelWidth": 110,
            "width": "100%",
            "clearable": true,
            "maxlength": null,
            "dateDefaultValue": helper.timeStampToDate(formData.health_yigan, 5),
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
        }, ];
    },
    r: {},
    get_info: function(id) {
        if (id > 0) {
            var req = {
                "methodName": "SkillerInfo",
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
            data: api.formJson(formData),
            formData: formData
        });
        fengform.upload_set('pic', formData.pic);
        fengform.upload_set('pic_big', formData.pic_big);
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
    $(".js_avatar").click(function() {
        console.log('sdf');
    });
    //监听表单提交
    form.on('submit(demo1)', function(data) {
        var json = api.r.getFormData();
        if (skiller_id > 0) {
            json.id = skiller_id;
            json.methodName = "SkillerEdit";
        } else {
            json.methodName = "SkillerAdd";
        }
        // 强制上星
        if (json.level < 1) {
            layer.msg('阿姨必须设置星级!');
            return false;
        }
        json.birthday = helper.dateToTimeStamp(json.datebirthday);
        json.health_card = helper.dateToTimeStamp(json.datehealth_card);
        json.health_meidu = helper.dateToTimeStamp(json.datehealth_meidu);
        json.health_yigan = helper.dateToTimeStamp(json.datehealth_yigan);
        json.health_aizi = helper.dateToTimeStamp(json.datehealth_aizi);
        
        // 读图片
        json.pic = fengform.upload_get("pic");
        json.pic_big = fengform.upload_get("pic_big");
        api_crm(json, function(res) {
            if (json.methodName == 'SkillerAdd') {
                layer.msg(res.msg);
            } else {
                layer.msg(res.msg);
            }
        }, function(res) {
            layer.msg(res);
        });
        return false;
    });
});