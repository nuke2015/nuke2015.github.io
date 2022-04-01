
var api = {
    r: {},
    get_info: function(sign) {
        var req = {
            "methodName": "ContractShare",
            "sign": sign
        };
        api_crm(req, function(res) {
            api.show_info(res.data);
            // 图片上传
            // 图片显示
        }, function() {
            //error
        });
    },
    show_info: function(formData) {
        var mytpl = $("#mytpl").html();
        formData.start_at = helper.timeStampToDate(formData.start_at, 6);
        formData.end_at = helper.timeStampToDate(formData.end_at, 6);
        console.log(formData);
        html = layui.laytpl(mytpl).render(formData);
        $("#result").html(html);
        // 已签署的合同不让签字
        if (formData.status == 1) {
            $("#tosign").remove();
        }
        // 自动转换本地图片base64
        $("#result img").each(function(k, v) {
            var turl = $(v).attr('src');
            console.log(turl);
            if (turl) {
                api.getBase64(turl, function(r) {
                    $(v).attr('src', r);
                });
            }
        });
    },
    getBase64: function(url, callback) {
        var Img = new Image(),
            dataURL = '';
        Img.src = url + '?v=' + Math.random();
        Img.setAttribute('crossOrigin', 'Anonymous');
        Img.onload = function() {
            var canvas = document.createElement('canvas'),
                width = Img.width,
                height = Img.height;
            canvas.width = width;
            canvas.height = height;
            canvas.getContext('2d').drawImage(Img, 0, 0, width, height);
            dataURL = canvas.toDataURL('image/jpeg');
            return callback ? callback(dataURL) : null;
        };
    },
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
    var sign = g_params.sign
    // console.log(banner_action_form);
    api.get_info(sign);
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
$("#tosign").click(function() {
    var type = g_params.type;
    var sign = g_params.sign;
    // var turl = "/html/contract_sign.html?type=" + type + "&sign=" + sign;
    var turl = "/html/contract_sign2.html?type=" + type + "&sign=" + sign;
    location.href = turl;
});

$("#topdf").click(function() {
    var element = document.getElementById("result");
    html2pdf(element, {
        pagebreak: {
            mode: ["avoid-all", "css", "legacy"]
        },
        margin: 0.2,
        filename: "signer.pdf",
        image: {
            type: "jpeg",
            quality: 0.98
        },
        html2canvas: {
            scale: 3
        },
        jsPDF: {
            unit: "in",
            format: "letter",
            orientation: "portrait"
        }
    });
})