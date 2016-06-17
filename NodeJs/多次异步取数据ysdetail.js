var api = {
    // 月嫂分享
    WeixinAppShare: function(req) {
        doRequestwithnoheader(req, function(res) {
            var wxParams = res.data;
            var req = {
                "methodName": "WeixinShare",
                "version": "2.0",
                "refer_url": location.href
            };
            
            // 二次异步
            doRequestwithnoheader(req, function(res) {
                var wxShareConfig = res.data;
                doShare(wxParams, wxShareConfig);
                // 去公众号检查
            }, function() {
                // no error
            });
        }, function() {
            // no error
        });
    },
};

function initEvent() {
    // 公众号加载分享相关设置
    if (is_weixin) {
        var req = {
            "methodName": "AppShare",
            "version": "2.0",
            "yuesao_id": g_params["yuesao_id"]
        };
        api.WeixinAppShare(req);
    }
}