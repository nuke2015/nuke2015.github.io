var api = {
    formJson: function(formData) {
        var order_status_server = fengform.config_get('order_status_server');
        var option_server = fengform.config_to_form(order_status_server);
        var order_status_pay = fengform.config_get('order_status_pay');
        var option_pay = fengform.config_to_form(order_status_pay);
        return [{
            "id": "title",
            "index": 0,
            "label": "商品名称",
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
            "id": "schedule_at",
            "index": 1,
            "label": "预约日期",
            "tag": "date",
            "tagIcon": "date",
            "labelWidth": 110,
            "width": "100%",
            "clearable": true,
            "maxlength": null,
            "dateDefaultValue": helper.timeStampToDate(formData.schedule_at, 5),
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
            "id": "address",
            "index": 2,
            "label": "上门地址",
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
            "id": "status_pay",
            "index": 3,
            "label": "付款状态",
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
            "options": option_pay
        }, {
            "id": "status_server",
            "index": 4,
            "label": "服务状态",
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
            "options": option_server
        }, {
            "id": "nickname",
            "index": 5,
            "label": "客户姓名",
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
            "id": "mobile",
            "index": 6,
            "label": "客户手机",
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
        }];
    },
    r: {},
    get_info: function(id) {
        if (id > 0) {
            var req = {
                "methodName": "OrderInfo",
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
            $("#order_update").hide();
            api.show_info({})
        }
    },
    more_info: function(order_id) {
        // 派人记录
        var turl = "/html/OrderSkillerList.html?order_id={0}&r={1}".format(order_id, Math.random);
        var html = " <iframe src='" + turl + "' frameborder='0' scrolling=auto style='width:95%;height:400px;border:0px;'></iframe>";
        $("#more_info").append(html);
        // 跟进记录
        var turl = "/html/order_follow_list.html?order_id={0}&r={1}".format(order_id, Math.random);
        var html = " <iframe src='" + turl + "' frameborder='0' scrolling=auto style='width:95%;height:400px;border:0px;'></iframe>";
        $("#more_info").append(html);
        // 账单记录
        var turl = "/html/order_plan_list.html?order_id={0}&r={1}".format(order_id, Math.random);
        console.info(turl);
        var html = " <iframe src='" + turl + "' frameborder='0' scrolling=auto style='width:95%;height:400px;border:0px;'></iframe>";
        $("#more_info").append(html);
        // 收款记录
        var turl = "/html/order_pay_list.html?order_id={0}&r={1}".format(order_id, Math.random);
        var html = " <iframe src='" + turl + "' frameborder='0' scrolling=auto style='width:95%;height:400px;border:0px;'></iframe>";
        $("#more_info").append(html);
    },
    show_info: function(formData) {
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
    // // 全局配置
    // banner_action = fengform.config_get('banner_action');
    // console.log(banner_action);
    // banner_action_form = fengform.config_to_form(banner_action);
    // console.log(banner_action_form);
    api.get_info(id);
    if (id) {
        // 编辑才有   
        api.more_info(id);
    }
    //监听表单提交
    form.on('submit(demo1)', function(data) {
        var json = api.r.getFormData();
        if (id > 0) {
            json.id = id;
            json.methodName = "OrderEdit";
        } else {
            json.methodName = "OrderAdd";
        }
        json.schedule_at = helper.dateToTimeStamp(json.dateschedule_at);
        // 读图片 
        json.pic = fengform.upload_get("pic");
        api_crm(json, function(res) {
            layer.msg(res.msg, function() {
                location.href = "/html/order_list.html";
            });
        }, function(res) {
            layer.msg(res.msg);
        });
        return false;
    });
    $(".js_order_follow").click(function() {
        var turl = "/html/order_follow_info.html?order_id=" + id;
        fengform.open(turl);
    });
    $(".js_order_plan").click(function() {
        var turl = "/html/order_plan_info.html?order_id=" + id;
        fengform.open(turl);
    });
    $(".js_order_pay").click(function() {
        var turl = "/html/order_pay_info.html?order_id=" + id;
        fengform.open(turl);
    });
    $(".js_order_skiller_send").click(function() {
        var turl = "/html/skiller_list.html?order_id=" + id;
        // fengform.open(turl);
        window.open(turl);
    });
    $(".js_order_contract").click(function() {
        var turl = "/html/contract_info.html?order_id=" + id;
        // fengform.open(turl);
        window.open(turl);
    });
});