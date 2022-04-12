var api = {
    menu_show: 1,
    req: {
        "methodName": "MenuList"
    },
    MenuList: function(cb) {
        api_crm(api.req, function(res) {
            cb(res.data.data);
        }, function() {
            //
        });
    },
    AdminInfo: function() {
        var req = {
            "methodName": "AdminInfo"
        };
        api_crm(req, function(res) {
            $('#admininfo').text(res.data.admin_name);
        }, function() {
            //
        });
    }
}
layui.use(['element', 'layer', 'laytpl', 'util'], function() {
    var element = layui.element,
        layer = layui.layer,
        laytpl = layui.laytpl,
        util = layui.util,
        $ = layui.$;
    // 读数据
    var sys_nav_top = fengform.config_get('sys_nav_top');
    var tpl = $("#sys_menu").html();
    api.MenuList(function(data) {
        html = layui.laytpl(tpl).render({
            "category": sys_nav_top,
            "data": data
        });
        $("#sys_menu_html").html(html);
    });
    $("#menu_toggle").click(function() {
        if (api.menu_show) {
            api.menu_show = 0;
            $(".layui-side").hide();
            $(".layui-body").css('left', 0);
        } else {
            api.menu_show = 1;
            $(".layui-side").show();
            $(".layui-body").css('left', '200px');
        }
    })
    api.AdminInfo();
});