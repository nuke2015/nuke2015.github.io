// 全局类函数
var helper = {
    // 自动加载
    config_autoload: {
        action: "html",
        android_fit: 1,
        android_fit_width: 750,
        webnav: 1,
        tanchuang: 1,
        kefu: 1,
        weixin_append: 1,
    },
    autoload: function() {
        helper.jlog(helper.config_autoload);
        helper.config_autoload.android_fit && this.android_fit(helper.config_autoload.android_fit_width);
        helper.config_autoload.weixin_append && this.weixin_append();
    },
    android_fit: function(a) {
        if (/Android (\d+\.\d+)/.test(navigator.userAgent)) {
            if (2.3 < parseFloat(RegExp.$1)) {
                var c = parseInt(window.screen.width) / a;
                document.write('<meta name="viewport" content="width=' + a + ', minimum-scale =1.0, maximum-scale = 1.0,user-scalable=no, target-densitydpi=device-dpi">');
            } else {
                document.write('<meta name="viewport" content="width=' + a + ', user-scalable=no,target-densitydpi=device-dpi">');
            }
        } else {
            document.write('<meta name="viewport" content="width=' + a + ', user-scalable=no">')
        }
    },
    weixin_append: function() {
        // 微信浏览器
        if (0 <= navigator.userAgent.indexOf("MicroMessenger")) {
            helper.js_append("//res.wx.qq.com/open/js/jweixin-1.0.0.js");
            document.addEventListener("WeixinJSBridgeReady", function() {
                WeixinJSBridge.call("hideToolbar")
            });
        }
    },
    jlog: function(obj) {
        var log = JSON.stringify(obj);
        // 以json格式打日志
        console.log(log);
        return log;
    },
    array_merge: function(a, c) {
        // 数组合并,从c&&a的并集
        var d = {},
            b;
        for (b in a) d[b] = a[b];
        for (b in c) d[b] = c[b];
        return d
    },
    in_array: function(search, array) {
        // 数组存在判断
        for (var i in array) {
            if (array[i] == search) {
                return true;
            }
        }
        return false;
    },
    /**
     * 字符串序列化为对象
     * @method str2Args
     * @param {String} 待分割字符串
     * @param {String} 分隔符
     */
    str2Args: function(query, split) {
        var args = {};
        query = query || '';
        split = split || '&';
        var pairs = query.split(split);
        for (var i = 0; i < pairs.length; i++) {
            var pos = pairs[i].indexOf('=');
            if (pos == -1) {
                continue;
            }
            var argname = pairs[i].substring(0, pos).replace(/amp;/, "");
            var value = pairs[i].substring(pos + 1);
            args[argname] = decodeURIComponent(value);
        }
        return args;
    },
    /**
     * 将Object转换为字符串参数
     * @method args2Str
     * @param {Object} args 需要转换的对象
     * @param {String} split 分隔符，默认是&
     * @return String 字符串参数
     */
    args2Str: function(args, split) {
        split = split || '&';
        var key, rtn = '',
            sp = '';
        for (key in args) {
            //value为空的忽略
            if (args[key]) {
                rtn += (sp + key + '=' + encodeURIComponent(args[key]));
                sp = split;
            }
        }
        return rtn;
    },
    jsonObjParams2Str: function(params, link) {
        if (!link) {
            link = "&";
        }
        var argsstr = '';
        for (key in params) {
            //value为空的忽略
            if (params[key]) {
                var tmpstr = key + '=' + params[key];
                tmpstr += '&';
                argsstr += tmpstr;
            }
        }
        return argsstr;
    },
    isWeiXin: function() {
        var ua = navigator.userAgent.toLowerCase();
        if (ua.match(/MicroMessenger/i) == "micromessenger") {
            return true;
        } else {
            return false;
        }
    },
    isHttps: function() {
        var url = window.location.href;
        var isHttps = url.toUpperCase().indexOf("HTTPS");
        if (isHttps > -1) {
            return true;
        }
        return false;
    },
    // 登陆回跳
    gotoLogin: function() {
        location.href = 'http://' + TQ._domains.main + '/html/bindphone.html?topage=' + encodeURIComponent(location.href);
    },
    // 自由跳转
    gotoUrl: function(url_to) {
        location.href = 'http://' + TQ._domains.main + url_to;
    },
    getProtocol: function() {
        if (helper.isHttps()) {
            return "https"
        }
        return "http";
    },
    preventBackgroundScroll: function() {
        $("body,html").css({
            "overflow": "hidden"
        });
    },
    resumeBackgroundScroll: function() {
        $("body,html").css({
            "overflow": "auto"
        });
    },
    js_append: function(url_t) {
        var hm = document.createElement("script");
        hm.src = url_t;
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    },
    setTitle: function(t) {
        var $body = $('body');
        document.title = t;
        // hack在微信等webview中无法修改document.title的情况
        if (helper.isWeiXin()) {
            var $iframe = $('<iframe src="/fav.ico" height="0"></iframe>').on('load', function() {
                setTimeout(function() {
                    $iframe.off('load').remove()
                }, 0)
            }).appendTo($body);
        }
    },
    set5Score: function(v, totalscore, width) {
        var t = (v * width * 100) / (totalscore * 100);
        return t;
    },
    level2Txt: function(level) {
        var txt = "";
        if (level == 3) {
            txt = "三星月嫂";
        } else if (level == 4) {
            txt = "四星月嫂";
        } else if (level == 5) {
            txt = "五星月嫂";
        } else if (level == 6) {
            txt = "金牌月嫂";
        } else if (level == 7) {
            txt = "皇冠月嫂";
        }
        return txt;
    },
    level2Cls: function(level) {
        var txt = "jjys-big-start5";
        if (level == 3) {
            txt = "jjys-big-start3";
        } else if (level == 4) {
            txt = "jjys-big-start4";
        } else if (level == 5) {
            txt = "jjys-big-start5";
        } else if (level == 6) {
            txt = "jjys-big-start6";
        } else if (level == 7) {
            txt = "jjys-big-start7";
        }
        return txt;
    },
    //****************************************************************
    //* 名　　称：IsEmpty
    //* 功    能：判断是否为空
    //* 入口参数：fData：要检查的数据
    //* 出口参数：True：空
    //*           False：非空
    //*****************************************************************
    isEmpty: function(v) {
        switch (typeof v) {
            case 'undefined':
                return true;
            case 'string':
                if (v.replace(/(^[ \t\n\r]*)|([ \t\n\r]*$)/g, '').length == 0) return true;
                break;
            case 'boolean':
                if (!v) return true;
                break;
            case 'number':
                if (0 === v || isNaN(v)) return true;
                break;
            case 'object':
                if (null === v || v.length === 0) return true;
                for (var i in v) {
                    return false;
                }
                return true;
        }
        return false;
    },
    isAndroid: function() {
        var u = navigator.userAgent;
        if (u.indexOf('Android') > -1 || u.indexOf('Linux') > -1) { //安卓手机
            return true;
        }
        return false;
    },
    isIOS: function() {
        var u = navigator.userAgent;
        if (u.indexOf('iPhone') > -1) { //安卓手机
            return true;
        }
        return false;
    },
    isMobile: function(phone) {
        // 手机号正则
        var reg = /^1[3|4|5|7|8][0-9]\d{8}$/;
        if (reg.test(phone)) {
            return true;
        }
        return false;
    },
    showPage: function(page, params, hashparams) {
        if (this.isEmpty(params)) {
            if (this.isEmpty(hashparams)) {
                window.location.href = page;
            } else {
                window.location.href = page + "#" + this.jsonObjParams2Str(hashparams);
            }
            return;
        }
        if (this.isEmpty(hashparams)) {
            window.location.href = page + "?" + this.jsonObjParams2Str(params);
        } else {
            window.location.href = page + "?" + this.jsonObjParams2Str(params) + "#" + this.jsonObjParams2Str(hashparams);
        }
    },
    changeHash: function(hashparams) {
        var arr = window.location.href.split("#");
        window.location.href = arr[0] + "#" + this.jsonObjParams2Str(hashparams);
    },
    /***
     * 本地化存储数据，
     * @param key   string类型
     * @param obj   存储非函数类型的对象，不深度拷贝
     * @private
     */
    _store: function(key, obj) {
        var value;
        // 因为open_id和手机号是关系断开的,所以,暂时用localstorage忽悠一下.
        //优先使用localstorege,其次使用cookie,
        if (window.localStorage) {
            if (obj) {
                if (typeof obj == "object") {
                    window.localStorage.setItem(key, JSON.stringify(obj));
                } else if (typeof obj == "string") {
                    window.localStorage.setItem(key, obj);
                } else {
                    tip("_storeByBrowser:你存储的是非对象");
                }
            } else {
                try {
                    value = JSON.parse(window.localStorage.getItem(key));
                } catch (e) {
                    return window.localStorage.getItem(key);
                }
            }
        } else { //使用cookie
            TQ.cookie('test', 'test');
            if (!document.cookie || document.cookie == '') {
                //tip('请设置您的浏览器支持cookie以便正常访问');暂时放空
                if (obj) {
                    value = TQ._store(key, obj);
                } else {
                    value = TQ._store(key);
                }
            } else {
                if (obj) {
                    if (typeof obj == "object") {
                        value = TQ.cookie(key, JSON.stringify(obj));
                    } else if (typeof obj == "string") {
                        value = TQ.cookie(key, obj);
                    } else {
                        tip("_storeByBrowser:你存储的是非对象");
                    }
                } else {
                    try {
                        value = JSON.parse(TQ.cookie(key));
                    } catch (e) {
                        value = TQ.cookie(key);
                    }
                }
            }
        }
        return value;
    },
    _sess: function(key, obj) {
        if (window.sessionStorage) {
            if (obj) {
                if (typeof obj == "object") {
                    window.sessionStorage.setItem(key, JSON.stringify(obj));
                } else if (typeof obj == "string") {
                    window.sessionStorage.setItem(key, obj);
                } else {
                    tip("_storeByBrowser:你存储的是非对象");
                }
            } else {
                try {
                    return JSON.parse(window.sessionStorage.getItem(key));
                } catch (e) {
                    return window.sessionStorage.getItem(key);
                }
            }
        } else {
            console.info('sessionStorage not for ready!');
        }
    },
    /**
     * 获取url参数字段
     */
    getUrlParams: function(name) {
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
        var r = window.location.search.substr(1).match(reg); //匹配目标参数
        if (r != null) return decodeURIComponent(r[2]);
        return null; //返回参数值
    },
    //获取字符串的长度(区分中英文)
    Bytelen: function(str) {
        return str.replace(/[^\x00-\xff]/g, "**").length;
    },
    isLogin: function() {
        var identityObj = helper._store("identity");
        if (!helper.isEmpty(identityObj)) {
            if (!helper.isEmpty(identityObj.user_id)) {
                return true;
            }
        }
        return false;
    },
    loading: function() {
        if ($("body").has(".loading").length == 0) {
            $('body').append('<div class="loading"></div>');
        }
    },
    reachBottom: function() {
        //瀑布流滚动识别
        var clientHeight = 0;
        var scrollHeight = 0;
        if (document.documentElement && document.documentElement.scrollTop) {
            scrollTop = document.documentElement.scrollTop;
        } else if (document.body) {
            scrollTop = document.body.scrollTop;
        }
        if (document.body.clientHeight && document.documentElement.clientHeight) {
            clientHeight = (document.body.clientHeight < document.documentElement.clientHeight) ? document.body.clientHeight : document.documentElement.clientHeight;
        } else {
            clientHeight = (document.body.clientHeight > document.documentElement.clientHeight) ? document.body.clientHeight : document.documentElement.clientHeight;
        }
        scrollHeight = Math.max(document.body.scrollHeight, document.documentElement.scrollHeight);
        if (scrollTop + clientHeight + 100 > scrollHeight && clientHeight != scrollHeight) {
            return true;
        } else {
            return false;
        }
    },
    subStringCn: function(str, len, hasDot) {
        // 截取多余的字符串
        var newLength = 0;
        var newStr = "";
        var chineseRegex = /[^\x00-\xff]/g;
        var singleChar = "";
        var strLength = str.replace(chineseRegex, "**").length;
        for (var i = 0; i < strLength; i++) {
            singleChar = str.charAt(i).toString();
            if (singleChar.match(chineseRegex) != null) {
                newLength += 2;
            } else {
                newLength++;
            }
            if (newLength > len) {
                break;
            }
            newStr += singleChar;
        }
        if (hasDot && strLength > len) {
            newStr += "...";
        }
        return newStr;
    },
    // 取本地openid
    get_open_id: function() {
        var global_param = helper._store("global_param");
        if (!helper.isEmpty(global_param)) {
            open_id = global_param.open_id;
        } else {
            open_id = "";
        }
        return open_id;
    },
    // 1android2ios3公众号0wap
    get_platform: function() {
        var global_param = helper._store("global_param");
        if (!helper.isEmpty(global_param)) {
            platform = global_param.platform;
        } else {
            var ua = navigator.userAgent.toLowerCase();
            if (0 <= ua.indexOf("micromessenger")) {
                platform = 3;
            } else if (0 <= ua.indexOf("jjys_app_user_android")) {
                platform = 1;
            } else if (0 <= ua.indexOf("jjys_app_user_ios")) {
                platform = 2;
            } else {
                // 浏览器
                platform = 0;
            }
        }
        return platform;
    },
    getRandomArrItem: function(arr) {
        // 随机数组取其一
        if (helper.isEmpty(arr)) {
            return "";
        }
        return arr[Math.round(Math.random() * arr.length)];
    },
    timeStampToDate: function(seconds, f) {
        // 时间戳转日期
        var md = new Date(1e3 * parseInt(seconds));
        if (f == 'day') {
            return md.getFullYear() + "年" + (md.getMonth() + 1) + "月" + md.getDate() + '日';
        } else {
            return md.getFullYear() + "/" + (md.getMonth() + 1) + "/" + md.getDate() + " " + md.getHours() + ":" + md.getMinutes();
        }
    },
    dateToTimeStamp: function(stringTime) {
        // 转为时间戳,秒
        // 正确 var stringTime = '2013/07/10';
        // 不允许 var stringTime = '2013/9/7';
        // var stringTime = '2013/07/10 10:01:01';
        if (stringTime) {
            var timestampNs = Date.parse(new Date(stringTime));
            timestamp = timestampNs / 1000;
        } else {
            timestamp = 0;
        }
        return timestamp;
    },
    ossThumb: function(url_pic, thumb) {
        // 云存储自动缩略图
        if (url_pic.indexOf('http://upload.ddys168.com/') != -1) {
            url_pic = url_pic + thumb;
        }
        return url_pic;
    },
    toggle: function(x) {
        if (x) {
            return 0;
        } else {
            return 1;
        }
    },
    timerOut: function(timeNow, className) {
        var timeEnd = timeNow.getTime() + 60 * 60 * 2 * 1000; //结束时间
        var text = '';
        var timer = setInterval(function() {
            var now = new Date();
            var timeLeft = parseInt((timeEnd - now.getTime()) / 1000);
            if (timeLeft == 0) {
                clearInterval(timer);
            };
            var secLeft = timeLeft % 60;
            var minLeft = parseInt(timeLeft / 60) % 60
            var hourLeft = parseInt(timeLeft / 60 / 60) % 24;
            /*var dayLeft=parseInt(timeLeft/60/60/24);*/
            text = "0" + hourLeft + ":" + minLeft + ":" + secLeft;
            $("." + className).text(text);
        }, 1000)
    },
};
// app交互行为定制
var app = {
    // 跳转到app界面,比如uri=index,跳转到首页
    jump: function(uri) {
        var json = '{"func":"jump","param":{"uri":uri}}';
        this.send(json);
    },
    // 发送报文
    send: function(obj) {
        var platform = helper.get_platform();
        console.info('jjys#', obj);
        // 只有app内嵌页面才进行召唤.
        if (platform == 1 || platform == 2) {
            var url_comm = JSON.stringify(obj);
            location.href = "http://jjys#" + Base64.encode(url_comm);
        }
    },
};
//Base64编码
var Base64 = {
    _keyStr: "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",
    encode: function(e) {
        var t = "";
        var n, r, i, s, o, u, a;
        var f = 0;
        e = Base64._utf8_encode(e);
        while (f < e.length) {
            n = e.charCodeAt(f++);
            r = e.charCodeAt(f++);
            i = e.charCodeAt(f++);
            s = n >> 2;
            o = (n & 3) << 4 | r >> 4;
            u = (r & 15) << 2 | i >> 6;
            a = i & 63;
            if (isNaN(r)) {
                u = a = 64
            } else if (isNaN(i)) {
                a = 64
            }
            t = t + this._keyStr.charAt(s) + this._keyStr.charAt(o) + this._keyStr.charAt(u) + this._keyStr.charAt(a)
        }
        return t
    },
    decode: function(e) {
        var t = "";
        var n, r, i;
        var s, o, u, a;
        var f = 0;
        e = e.replace(/[^A-Za-z0-9\+\/\=]/g, "");
        while (f < e.length) {
            s = this._keyStr.indexOf(e.charAt(f++));
            o = this._keyStr.indexOf(e.charAt(f++));
            u = this._keyStr.indexOf(e.charAt(f++));
            a = this._keyStr.indexOf(e.charAt(f++));
            n = s << 2 | o >> 4;
            r = (o & 15) << 4 | u >> 2;
            i = (u & 3) << 6 | a;
            t = t + String.fromCharCode(n);
            if (u != 64) {
                t = t + String.fromCharCode(r)
            }
            if (a != 64) {
                t = t + String.fromCharCode(i)
            }
        }
        t = Base64._utf8_decode(t);
        return t
    },
    _utf8_encode: function(e) {
        e = e.replace(/\r\n/g, "\n");
        var t = "";
        for (var n = 0; n < e.length; n++) {
            var r = e.charCodeAt(n);
            if (r < 128) {
                t += String.fromCharCode(r)
            } else if (r > 127 && r < 2048) {
                t += String.fromCharCode(r >> 6 | 192);
                t += String.fromCharCode(r & 63 | 128)
            } else {
                t += String.fromCharCode(r >> 12 | 224);
                t += String.fromCharCode(r >> 6 & 63 | 128);
                t += String.fromCharCode(r & 63 | 128)
            }
        }
        return t
    },
    _utf8_decode: function(e) {
        var t = "";
        var n = 0;
        var r = c1 = c2 = 0;
        while (n < e.length) {
            r = e.charCodeAt(n);
            if (r < 128) {
                t += String.fromCharCode(r);
                n++
            } else if (r > 191 && r < 224) {
                c2 = e.charCodeAt(n + 1);
                t += String.fromCharCode((r & 31) << 6 | c2 & 63);
                n += 2
            } else {
                c2 = e.charCodeAt(n + 1);
                c3 = e.charCodeAt(n + 2);
                t += String.fromCharCode((r & 15) << 12 | (c2 & 63) << 6 | c3 & 63);
                n += 3
            }
        }
        return t
    }
};
// 只用于公众号的分享
var weixin_pub = {
    shareSend: function(wxParams) {
        // 避免非微信环境的调用
        if (!helper.isWeiXin()) {
            console.log('shareSend fail,weixin pls', wxParams);
            return;
        }
        var req = {
            "methodName": "WeixinShare",
            "refer_url": location.href
        }
        doRequestwithnoheader(req, function(res) {
            weixin_pub.shareInit(wxParams, res.data);
        }, function() {
            // no error
        });
    },
    //微信分享初始化
    shareInit: function(wxParams, wxShareConfig) {
        wx.config({
            debug: wxShareConfig.debug,
            appId: wxShareConfig.appId,
            timestamp: wxShareConfig.timestamp,
            nonceStr: wxShareConfig.nonceStr,
            signature: wxShareConfig.signature,
            jsApiList: ['onMenuShareAppMessage', 'onMenuShareTimeline', 'onMenuShareQQ', 'onMenuShareWeibo', 'onMenuShareQZone']
        });
        var wxData = {
            imgUrl: wxParams.icon,
            link: wxParams.link,
            title: wxParams.title,
            desc: wxParams.desc,
        };
        wx.ready(function doWeixinShare() {
            wx.onMenuShareTimeline(wxData);
            wx.onMenuShareAppMessage(wxData);
            wx.onMenuShareQQ(wxData);
            wx.onMenuShareWeibo(wxData);
        });
    },
};
var conf_websocket = 'ws://127.0.0.1:8001';
var ws = new WebSocket(conf_websocket);
// 异步请求
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
        // 硬注platform参数
        req.platform = helper.get_platform();
    }
    // 覆盖最新版本号
    req.version = '2.22';
    req._ajax = 1;
    helper.jlog(req);
    var methodName = req.methodName;
    app[methodName] = handler;
    app[methodName + "_err"] = errorHandler;
    var that = app;
    console.log(app);
    // console.log(ws);
    if (ws.readyState == 1) {
        ws.send(JSON.stringify(req));
        // 收消息 
        ws.onmessage = function(res) {
            // console.log(res.data);
            var obj = JSON.parse(res.data);
            var act = obj.cb;
            if (obj.code > 0) {
                that[act + "_err"](obj);
            } else {
                that[act](obj);
            }
        }
    } else if (ws.readyState == 3) {
        // 断线重连
        ws = new WebSocket(conf);
    } else {
        // 连接中
        console.log('connectting...');
    }
};
// 全局变量统一定义
var t_paramsArr = window.location.href.split("?");
var g_paramsStr = t_paramsArr.length > 1 ? t_paramsArr[1] : "";
var g_params = helper.str2Args(g_paramsStr, "&");
var g_userId = "";
var protocol = helper.getProtocol();
// 初始化
var identity = helper._store("identity") || {};
// 若干全局参数,不与identity共存是因为login相关操作会清除identity
var global_param = helper._store("global_param") || {};
// 页面会话
var global_sess = helper._store("global_sess") || {};
// 来自公众号的跳转,带有授权信息
if (!helper.isEmpty(g_params.open_id)) {
    global_param.open_id = g_params.open_id;
    helper._store("global_param", global_param);
}
// 来自公众号的跳转,带有授权信息
if (g_params.scene_id) {
    global_param.scene_id = g_params.scene_id;
    helper._store("global_param", global_param);
}
// 即时覆盖
if (g_params.origin_id) {
    // 临时会话
    global_sess.origin_id = (g_params.origin_id > 0) ? g_params.origin_id : 0;
    helper._sess('global_sess', global_sess);
}
// 来自推广的请求,带有推广指纹_spm
if (!helper.isEmpty(g_params._spm)) {
    global_param._spm = g_params._spm;
    helper._store("global_param", global_param);
}
// 指定平台标识
if (!helper.isEmpty(g_params.platform)) {
    global_param.platform = parseInt(g_params.platform);
    helper._store("global_param", global_param);
}
console.info('global_param', global_param);
// api网关
var g_host_api = '//' + location.host + '/api/';
window.TQ = {
    debug: function() {
        return true;
    },
    _domains: {
        main: window.location.host,
        imgcache: protocol + "://upload.ddys168.com",
        api: g_host_api
    },
    set_host_api: function(uri) {
        this._domains.api = protocol + '://' + uri;
    }
};
// 统一自动加载,配置可覆盖
var autoload = (function() {
    "undefined" != typeof config_autoload && (helper.config_autoload = helper.array_merge(helper.config_autoload, config_autoload));
    helper.autoload();
})(autoload);
// 强制必须加载页面,若有部分功能不加载,在页面内进行定制.
jQuery(document).ready(function() {
    $.get("/html/common_append.html", function(res) {
        $('body').append(res);
    });
});
// 模板相关定制
template.openTag = '<%';
template.closeTag = '%>';
// 一键注入,请勿模仿;
template.helper('helper', function() {
    return helper;
});
template.helper('json2stringify', function(obj) {
    return JSON.stringify(obj);
});
template.helper('set5Score', function(v) {
    return helper.set5Score(parseFloat(v), 5, 120);
});
template.helper('getAge', function(y) {
    return new Date().getFullYear() - new Date(y * 1000).getFullYear();
});
template.helper('timeStampToDate', function(nS, f) {
    return helper.timeStampToDate(nS, f);
});
template.helper('getDayBuy', function() {
    return g_params["day_buy"];
});
template.helper('numbertoFixed', function(score) {
    return score.toFixed(1);
});
template.helper('showNotFinished', function(len, sort) {
    if (len >= sort) {
        return "hide";
    }
    return "";
});
//支付了的就不能取消订单
template.helper('getCancelBtncls', function(process, status) {
    var grid = "";
    if (status > 1 || process > 0) {
        grid = "grid";
    }
    return grid;
});
template.helper('getBtncls', function(process) {
    var btncls = "";
    if ((process == 0) || (process >= 3 && process <= 7)) {
        btncls = "green";
    } else {
        btncls = "red";
    }
    return btncls;
});
/**
 * status   tinyint(1) [1]  订单支付状态，1未付款，2预付款，3已付款，4已退款
 */
template.helper('getRightTopBtncls', function(status) {
    var btnCls = "";
    if (status == 1) {
        btnCls = "red-btn";
    } else if (status == 2) {
        btnCls = "orange-btn";
    } else if (status == 3) {
        btnCls = "green-btn";
    } else if (status == 4) {
        btnCls = "green-btn";
    }
    return btnCls;
});
/**
 * 0未付款，1已付订金，2等待服务，3服务中，4服务结束，5待评论，6待结算，7已完成，8已取消，9退款中，10已退款
 * 6 7微信端均展示已完成
 */
template.helper('getBtnText', function(process) {
    var text = "";
    if (process == 10) {
        text = "已退款";
    } else if (process == 9) {
        text = "退款中";
    } else if (process == 8) {
        text = "已取消";
    } else if (process == 7) {
        //text = "已完成";
        text = "已评价";
    } else if (process == 6) {
        //text = "待结算";
        text = "已评价";
    } else if (process == 5) {
        //text = "评价服务";
        text = "已评价";
    } else if (process == 4) {
        text = "评价服务";
    } else if (process == 3) {
        text = "服务中";
    } else if (process == 2) {
        text = "等待服务";
    } else if (process == 1) {
        //text = "支付尾款";
        text = "支付尾款";
    } else if (process == 0) {
        //text = "未付款";
        text = "马上付款";
    }
    return text;
});
/**
 * 0未付款，1已付订金，2等待服务，3服务中，4服务结束，5待评论，6待结算，7已完成，8已取消，9退款中，10已退款
 * 6 7微信端均展示已完成
 */
template.helper('getBtnStatusText', function(process) {
    var text = "";
    if (process == 10) {
        text = "已退款";
    } else if (process == 9) {
        text = "退款中";
    } else if (process == 8) {
        text = "已取消";
    } else if (process == 7) {
        //text = "已完成";
        text = "已评价";
    } else if (process == 6) {
        //text = "待结算";
        text = "已评价";
    } else if (process == 5) {
        //text = "评价服务";
        text = "已评价";
    } else if (process == 4) {
        text = "服务完成";
    } else if (process == 3) {
        text = "服务中";
    } else if (process == 2) {
        text = "等待服务";
    } else if (process == 1) {
        //text = "支付尾款";
        text = "已付定金";
    } else if (process == 0) {
        //text = "未付款";
        text = "未付款";
    }
    return text;
});
//区分自营月嫂和合作月嫂
template.helper("isCreat", function(num) {
    if (num == 0) {
        return "/images/hezuo1.png"
    } else if (num == 1) {
        return "/images/ziying1.png"
    }
});
template.helper('myCon', function(obj) {
    console.log(obj);
});
template.helper('getBtnCancelShowCls', function(process) {
    var text = "hide";
    if (process == 0) {
        text = "";
    }
    return text;
});
/**
 * 0未付款，1已付订金，2等待服务，3服务中，4服务结束，5待评论，6待结算，7已完成，8已取消，9退款中，10已退款
 * 6 7微信端均展示已完成
 */
template.helper('getBtnRightShowCls1', function(process) {
    var text = "hide";
    if (process == 0) {
        text = ""; //0  4显示（按钮为 立马付款）
    }
    return text;
});
template.helper('getBtnRightShowCls2', function(status, process) {
    var text = "hide";
    if ((status == 2 || status == 3) && (process >= 1 && process <= 7)) {
        text = ""; //（按钮为 评价服务）
    }
    return text;
});
template.helper('getHead', function(url) {
    var urlStr = "";
    if (url != "") {
        urlStr = url;
        return urlStr;
    } else {
        urlStr = "../images/toux.png";
        return urlStr;
    }
});
// 强转数字
template.helper('Number', function(a) {
    return Number(a);
});
// 强转字符串
template.helper('strval', function(a) {
    return a.toString();
});
// 植入Math相关函数
template.helper('Math', function(a) {
    return Math;
});