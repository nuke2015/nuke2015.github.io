var api = {
    req: {},
    yuesao_list: function(req) {
        console.log(req);
        doRequestwithnoheader(req, function(res) {
            // 地区下拉
            console.log(res);
            var html = template('template_test', res.data);
            $(".result_test").html(html);
        }, function(err) {
            console.log(err);
        });
    },
};
var init = (function() {
    api.req = {
        "methodName": "YuesaoIndex",
        "version": "2.2"
    };
    api.yuesao_list(api.req);
    $("#test").click(function() {
        api.yuesao_list(api.req);
    });
})(init);