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
    formJson: function(formData) {
        return [{
            "id": "money_user",
            "index": 0,
            "label": "客户居间费",
            "tag": "input",
            "tagIcon": "input",
            "placeholder": "请输入",
            "defaultValue": null,
            "labelWidth": 150,
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
            "id": "money_skiller",
            "index": 0,
            "label": "阿姨居间费",
            "tag": "input",
            "tagIcon": "input",
            "placeholder": "请输入",
            "defaultValue": null,
            "labelWidth": 150,
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
            "id": "money_traffic",
            "index": 0,
            "label": "交通费",
            "tag": "input",
            "tagIcon": "input",
            "placeholder": "请输入",
            "defaultValue": null,
            "labelWidth": 150,
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
            "id": "pay_month",
            "index": 0,
            "label": "月工资",
            "tag": "input",
            "tagIcon": "input",
            "placeholder": "请输入",
            "defaultValue": null,
            "labelWidth": 150,
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
            "id": "pay_day",
            "index": 0,
            "label": "日工资",
            "tag": "input",
            "tagIcon": "input",
            "placeholder": "请输入",
            "defaultValue": null,
            "labelWidth": 150,
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
            "id": "pay_change",
            "index": 0,
            "label": "换人操作费",
            "tag": "input",
            "tagIcon": "input",
            "placeholder": "请输入",
            "defaultValue": null,
            "labelWidth": 150,
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
            "id": "rest",
            "index": 0,
            "label": "月休息天数",
            "tag": "input",
            "tagIcon": "input",
            "placeholder": "请输入",
            "defaultValue": null,
            "labelWidth": 150,
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
            "id": "pay_overtime",
            "index": 0,
            "label": "加班费",
            "tag": "input",
            "tagIcon": "input",
            "placeholder": "请输入",
            "defaultValue": null,
            "labelWidth": 150,
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
            "id": "start_at",
            "index": 2,
            "label": "合同开始时间",
            "tag": "date",
            "tagIcon": "date",
            "labelWidth": 150,
            "width": "100%",
            "clearable": true,
            "maxlength": null,
            "dateDefaultValue": helper.timeStampToDate(formData.start_at, 6),
            "datetype": "datetime",
            "range": false,
            "dateformat": "yyyy-MM-dd HH:mm:ss",
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
            "required": true,
            "document": ""
        }, {
            "id": "end_at",
            "index": 3,
            "label": "合同结束时间",
            "tag": "date",
            "tagIcon": "date",
            "labelWidth": 150,
            "width": "100%",
            "clearable": true,
            "maxlength": null,
            "dateDefaultValue": helper.timeStampToDate(formData.end_at, 6),
            "datetype": "datetime",
            "range": false,
            "dateformat": "yyyy-MM-dd HH:mm:ss",
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
            "required": true,
            "document": ""
        }, {
            "id": "day_start",
            "index": 4,
            "label": "每日开始时间",
            "tag": "input",
            "tagIcon": "input",
            "placeholder": "请输入",
            "defaultValue": null,
            "labelWidth": 150,
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
            "id": "day_end",
            "index": 4,
            "label": "每日结束时间",
            "tag": "input",
            "tagIcon": "input",
            "placeholder": "请输入",
            "defaultValue": null,
            "labelWidth": 150,
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
            "id": "safe_title",
            "index": 4,
            "label": "保险名称",
            "tag": "input",
            "tagIcon": "input",
            "placeholder": "请输入",
            "defaultValue": null,
            "labelWidth": 150,
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
            "id": "safe_money",
            "index": 4,
            "label": "保险费",
            "tag": "input",
            "tagIcon": "input",
            "placeholder": "请输入",
            "defaultValue": null,
            "labelWidth": 150,
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
            "id": "pay_at",
            "index": 5,
            "label": "发工资时间",
            "tag": "input",
            "tagIcon": "input",
            "placeholder": "请输入",
            "defaultValue": null,
            "labelWidth": 150,
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
            "id": "user_name",
            "index": 6,
            "label": "客户名字",
            "tag": "input",
            "tagIcon": "input",
            "placeholder": "请输入",
            "defaultValue": null,
            "labelWidth": 150,
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
            "id": "user_phone",
            "index": 7,
            "label": "客户电话",
            "tag": "input",
            "tagIcon": "input",
            "placeholder": "请输入",
            "defaultValue": null,
            "labelWidth": 150,
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
            "id": "user_idcard",
            "index": 8,
            "label": "客户身份证",
            "tag": "input",
            "tagIcon": "input",
            "placeholder": "请输入",
            "defaultValue": null,
            "labelWidth": 150,
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
            "id": "user_address",
            "index": 8,
            "label": "客户地址",
            "tag": "input",
            "tagIcon": "input",
            "placeholder": "请输入",
            "defaultValue": null,
            "labelWidth": 150,
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
            "id": "skiller_name",
            "index": 9,
            "label": "阿姨名字",
            "tag": "input",
            "tagIcon": "input",
            "placeholder": "请输入",
            "defaultValue": null,
            "labelWidth": 150,
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
            "id": "skiller_phone",
            "index": 10,
            "label": "阿姨手机",
            "tag": "input",
            "tagIcon": "input",
            "placeholder": "请输入",
            "defaultValue": null,
            "labelWidth": 150,
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
            "id": "skiller_idcard",
            "index": 11,
            "label": "阿姨身份证",
            "tag": "input",
            "tagIcon": "input",
            "placeholder": "请输入",
            "defaultValue": null,
            "labelWidth": 150,
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
            "id": "skiller_address",
            "index": 8,
            "label": "阿姨地址",
            "tag": "input",
            "tagIcon": "input",
            "placeholder": "请输入",
            "defaultValue": null,
            "labelWidth": 150,
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
            "id": "address",
            "index": 8,
            "label": "上门服务地址",
            "tag": "input",
            "tagIcon": "input",
            "placeholder": "请输入",
            "defaultValue": null,
            "labelWidth": 150,
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
            "id": "contract_no",
            "index": 8,
            "label": "合同字号",
            "tag": "input",
            "tagIcon": "input",
            "placeholder": "请输入",
            "defaultValue": null,
            "labelWidth": 150,
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
            "id": "server",
            "index": 9,
            "label": "服务内容",
            "tag": "input",
            "tagIcon": "input",
            "placeholder": "请输入",
            "defaultValue": null,
            "labelWidth": 150,
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
            "id": "family",
            "index": 10,
            "label": "家庭情况",
            "tag": "input",
            "tagIcon": "input",
            "placeholder": "请输入",
            "defaultValue": null,
            "labelWidth": 150,
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
            "id": "way",
            "index": 11,
            "label": "服务方式",
            "tag": "input",
            "tagIcon": "input",
            "placeholder": "请输入",
            "defaultValue": null,
            "labelWidth": 150,
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
            "id": "condition",
            "index": 12,
            "label": "阿姨条件",
            "tag": "input",
            "tagIcon": "input",
            "placeholder": "请输入",
            "defaultValue": null,
            "labelWidth": 150,
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
            "id": "extration",
            "index": 100,
            "label": "附加条款",
            "tag": "input",
            "tagIcon": "input",
            "placeholder": "请输入",
            "defaultValue": null,
            "labelWidth": 150,
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
            "id": "admin_name",
            "index": 101,
            "label": "经办人",
            "tag": "input",
            "tagIcon": "input",
            "placeholder": "请输入",
            "defaultValue": null,
            "labelWidth": 150,
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
                "methodName": "ContractInfo",
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
    // // 全局配置
    // banner_action = fengform.config_get('banner_action');
    // console.log(banner_action);
    // banner_action_form = fengform.config_to_form(banner_action);
    // console.log(banner_action_form);
    api.get_info(id);
    //监听表单提交
    form.on('submit(demo1)', function(data) {
        var json = api.r.getFormData();
        json.order_id = order_id;
        json.start_at = helper.dateToTimeStamp(json.datestart_at);
        json.end_at = helper.dateToTimeStamp(json.dateend_at);
        if (id > 0) {
            json.id = id;
            json.methodName = "ContractEdit";
        } else {
            json.methodName = "ContractAdd";
        }
        // 读图片 
        json.pic = fengform.upload_get("pic");
        api_crm(json, function(res) {
            layer.msg(res.msg, function() {
                location.href = "/html/contract_list.html";
            });
        }, function(res) {
            console.log(res);
        });
        return false;
    });
});