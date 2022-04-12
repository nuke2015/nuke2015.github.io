var api = {
    json_form: [{
            "id": "textarea_1",
            "index": 0,
            "label": "多行文本",
            "tag": "textarea",
            "tagIcon": "textarea",
            "placeholder": "请输入",
            "defaultValue": null,
            "width": "100%",
            "readonly": false,
            "disabled": false,
            "required": true,
            "document": ""
        },
        {
            "id": "input_2",
            "index": 1,
            "label": "sdfs s",
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
            "id": "input_3",
            "index": 2,
            "label": "单行文本",
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
        },
        {
            "id": "checkbox_4",
            "index": 3,
            "label": "复选组",
            "tag": "checkbox",
            "tagIcon": "checkbox",
            "labelWidth": 110,
            "disabled": false,
            "required": true,
            "document": "",
            "datasourceType": "local",
            "remoteUrl": "http://",
            "remoteMethod": "post",
            "remoteOptionText": "options.data.dictName",
            "remoteOptionValue": "options.data.dictId",
            "options": [{
                    "text": "option1",
                    "value": "value1",
                    "checked": true
                },
                {
                    "text": "option2",
                    "value": "value2",
                    "checked": true
                },
                {
                    "text": "option3",
                    "value": "value3",
                    "checked": false
                }
            ]
        },
        {
            "id": "iconPicker_5",
            "index": 4,
            "label": "图标选择器",
            "tag": "iconPicker",
            "tagIcon": "iconPicker",
            "labelWidth": 110,
            "defaultValue": "",
            "iconPickerSearch": true,
            "iconPickerPage": true,
            "iconPickerLimit": 12,
            "iconPickerCellWidth": "43px",
            "disabled": false,
            "document": ""
        },
        {
            "id": "numberInput_6",
            "index": 5,
            "label": "排序文本框",
            "tag": "numberInput",
            "tagIcon": "numberInput",
            "labelWidth": 110,
            "width": "100%",
            "defaultValue": 0,
            "maxValue": 100,
            "minValue": 0,
            "stepValue": 1,
            "disabled": false,
            "document": ""
        }
    ],
    json_data: {
        "textarea_1": "客户评价",
        "input_2": "网站关键词",
        "input_3": "zoujunfeng"
    },
}
//JavaScript代码区域
layui.config({ base: '/ayq/modules/' }).use(['formPreview', 'form', 'layer', 'upload'], function() {
    var layer = layui.layer;
    var $ = layui.jquery;
    var upload = layui.upload;
    var index = layui.index;
    var formPreview = layui.formPreview;
    var form = layui.form;
    var render;
    console.log(api.json_demo);
    render = formPreview.render({
        elem: '#form_demo',
        data: api.json_form,
        formData: api.json_data
    });
    var images = render.getImages();
    console.log(images);
});