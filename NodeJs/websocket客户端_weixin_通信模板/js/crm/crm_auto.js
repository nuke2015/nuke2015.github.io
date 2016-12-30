var app = this;
/**websocket握手**/
// 单例模式
if (!app.ws) {
    var conf_websocket = 'ws://127.0.0.1:8092';
    app.ws = new WebSocket(conf_websocket);
    console.log("   ---->>>>>----ws conn start!");
    setInterval(function() {
        if (app.ws.readyState == 3 || app.ws.readyState == 0) {
            app.ws = new WebSocket(conf_websocket);
            console.log("   ---->>>>>----ws tc again!", app.ws);
        }
    }, 1000);
}
/**异步请求**/
var doRequestwithnoheader = function(req, handler, errorHandler) {
    if (req) {
        // 注入自然指纹
        var identityObj = helper._store("identity");
        if (!helper.isEmpty(identityObj)) {
            req.user_id = identityObj.user_id;
            req.token = identityObj.token;
        } else {
            req.user_id = "";
        }
        // 全局参数,有则注入
        var global_param = helper._store('global_param');
        req = helper.array_merge(req, global_param);
    }
    // 覆盖最新版本号
    req.version = '2.22';
    req._ajax = 1;
    helper.jlog(req);
    var methodName = req.methodName;
    app[methodName] = handler;
    app[methodName + "_err"] = errorHandler;
    var that = app;
    // console.log(app);
    console.log(app.ws);
    if (app.ws.readyState == 1) {
        app.ws.send(JSON.stringify(req));
        /**收消息**/
        app.ws['onmessage'] = function(res) {
            // console.log(res.data);
            var obj = JSON.parse(res.data);
            var act = obj.act;
            if (obj.code > 0) {
                that[act + "_err"](obj);
            } else {
                that[act](obj);
            }
        };
    }
};
/**页面渲染**/
var gohref = function(turl) {
    if (!turl) {
        turl = '/crm/home.html';
    }
    $(document).ready(function() {
        console.log(turl);
        $('body').load(turl);
    });
}
gohref();