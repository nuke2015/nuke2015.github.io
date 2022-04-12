var api = {
    more_info: function(skiller_id) {
        // 基础资料
        var turl = "/html/skiller_info.html?skiller_id={0}&r={1}".format(skiller_id, Math.random);
        var html = " <iframe src='" + turl + "' frameborder='0' scrolling=auto style='width:95%;height:800px;border:0px;'></iframe>";
        $("#more_info").append(html);
        // 联系方式
        var turl2 = "/html/skiller_contact_info.html?skiller_id={0}&r={1}".format(skiller_id, Math.random);
        var html2 = " <iframe src='" + turl2 + "' frameborder='0' scrolling=auto style='width:95%;height:500px;border:0px;'></iframe>";
        $("#more_info").append(html2);
        // 头像证书
        var turl3 = "/html/skiller_info_ava.html?skiller_id={0}&r={1}".format(skiller_id, Math.random);
        var html3 = " <iframe src='" + turl3 + "' frameborder='0' scrolling=auto style='width:95%;height:800px;border:0px;'></iframe>";
        $("#more_info").append(html3);
        // 风采与证件
        var turl4 = "/html/skiller_pic_list.html?skiller_id={0}&r={1}".format(skiller_id, Math.random);
        var html4 = " <iframe src='" + turl4 + "' frameborder='0' scrolling=auto style='width:95%;height:400px;border:0px;'></iframe>";
        $("#more_info").append(html4);
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
    formJson: function(formData) {},
    r: {},
    show_info: function(skiller_id) {
        this.more_info(skiller_id)
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
    api.show_info(skiller_id);
    $(".js_order_comment").click(function() {
        // 评价
        var turl = "/html/comment_info.html?skiller_id={0}&r={1}".format(skiller_id, Math.random);
        fengform.open(turl);
    });
    $(".js_order_vacation").click(function() {
        // 评价
        var turl = "/html/vacation_info.html?skiller_id={0}&r={1}".format(skiller_id, Math.random);
        fengform.open(turl);
    });
    $(".js_order_schedule").click(function() {
        // 评价
        var turl = "/html/schedule_info.html?skiller_id={0}&r={1}".format(skiller_id, Math.random);
        fengform.open(turl);
    });
    $(".js_order_cert").click(function() {
        // 评价
        var turl = "/html/skiller_cert_200.html?skiller_id={0}&r={1}".format(skiller_id, Math.random);
        fengform.open(turl);
    });
    $(".js_order_tag").click(function() {
        // 评价
        var turl = "/html/skiller_list_200.html?skiller_id={0}&r={1}".format(skiller_id, Math.random);
        fengform.open(turl);
    });
    $(".js_order_show").click(function() {
        // 评价
        var turl = "/html/skiller_pic_info.html?skiller_id={0}&r={1}".format(skiller_id, Math.random);
        fengform.open(turl);
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
        // 读图片
        json.pic = fengform.upload_get("pic");
        json.pic_big = fengform.upload_get("pic_big");
        api_crm(json, function(res) {
            layer.msg('编辑成功!', function() {
                location.href = "/html/skiller_contact_list.html?skiller_id=" + skiller_id;
            });
        }, function(res) {
            layer.msg(res.msg);
            console.log(res);
        });
        return false;
    });
});