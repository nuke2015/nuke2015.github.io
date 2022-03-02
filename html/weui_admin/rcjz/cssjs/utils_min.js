/**
 * 缩小版的utils
 */
// app交互行为定制
var app = {
    // 跳转到app界面,比如uri=index,跳转到首页
    jump: function (uri) {
        var obj = {
            func: 'jump',
            'topage': uri
        };
        this.send(obj);
    },
    login: function (topage) {
        // app内部登陆事件
        var obj = {
            func: "login",
            topage: topage
        };
        this.send(obj);
    },
    // 发送报文
    send: function (obj) {
        var platform = helper.get_platform();
        // 只有app内嵌页面才进行召唤.
        if (platform == 1 || platform == 2) {
            var url_comm = helper.jlog(obj);
            url_base64 = "http://jjys#" + Base64.encode(url_comm);
            console.info(url_base64);
            location.href = url_base64;
        }
    },
    // app.debug('feng', 'this is logger');
    debug: function (title, data) {
        doRequestwithnoheader({
            'methodName': 'AppDebug',
            'title': title,
            'data': data
        }, function () {
            // succ
        }, function () {
            //err
        });
    }
};
var isMobile = {
    Android: function () {
        return navigator.userAgent.match(/Android/i) ? true : false;
    },
    BlackBerry: function () {
        return navigator.userAgent.match(/BlackBerry/i) ? true : false;
    },
    iOS: function () {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i) ? true : false;
    },
    Windows: function () {
        return navigator.userAgent.match(/IEMobile/i) ? true : false;
    },
    any: function () {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Windows());
    }
};
// 全局类函数
var helper = {
    // 自动加载
    config_autoload: {
        action: "html",
        android_fit: 1,
        android_fit_width: 375,
        webnav: 1,
        tanchuang: 1,
        kefu: 1,
        weixin_append: 1,
        common_append_must: 1,
        footerMenus: 0,
        floatWin: 0,
        share_info_diy: 0,
        school_headnav: 1, //学院头部：1(显示) 0(隐藏)
        school_footnav: 1, //学院底部：1(显示) 0(隐藏)
    },
    // 获取configWeb配置的缓存
    getConfigWebInfo: function () {
        var data = helper._store('ConfigWeb');
        helper.jlog(data);
        if (data) {
            return data;
        } else {
            helper.updateConfigWebInfo();
        }
    },
    updateConfigWebInfo: function () {
        doRequestwithnoheader({
            "methodName": "ConfigCorp"
        }, function (res) {
            if (res.data) {
                helper._sess('ConfigWeb', res.data);
            }
        }, function (res) {
            tip(res.msg);
        });
    },
    kefu_contact: function (n) {
        if (helper.isEmpty(helper.getConfigWebInfo().awt_kefu_id)) { // 没有商务通就打电话
            window.location.href = "tel:" + helper.kefu_phone();
        } else {
            // 百度客服
            window.open(helper.kefu_url(), n);
        }
    },
    // 客服电话
    kefu_phone: function () {
        return helper.getConfigWebInfo().contact;
    },
    //(多城市)商务通
    kefu_url: function () {
        return helper.getConfigWebInfo().awt_kefu + encodeURIComponent(location.href) + '&r=' + encodeURIComponent(document.referrer);
    },
   
    autoload: function () {
        helper.config_autoload.weixin_append && this.weixin_append();
        helper.config_autoload.android_fit && this.android_fit(helper.config_autoload.android_fit_width);
        helper.config_autoload.common_append_must && this.common_append_must();
    },
    citycode_set: function (code) {
        return true;
    },
    // 存corp_id【公司id】
    store_corp_id: function (corp_id) {
        return true;
    },
    common_append_must: function () {
        this.xhr_get("/html/common_append.html", function (res) {
            $('.page').prepend(res);
        });
        this.xhr_get("/html/common_footer.html", function (res) {
            $('body').append(res);
        });
        if (!helper.config_autoload.share_info_diy) {
            weixin_pub.shareDefault();
        }
    },
    android_fit: function (a) {
        if (/Android (\d+\.\d+)/.test(navigator.userAgent)) {
            document.write('<meta name="viewport" content="width=' + a + ',target-densitydpi=device-dpi,user-scalable=no" />');
        } else {
            document.write('<meta name="viewport" content="width=' + a + ', user-scalable=no">')
        }
    },
    weixin_append: function () {
        // 微信浏览器,提前加载
        define = null;
        require = null;
        helper.js_append("https://res.wx.qq.com/open/js/jweixin-1.3.2.js");
        // helper.js_append("/js/utils/jweixin-1.0.0.js");
    },
    jlog: function (obj) {
        var log = JSON.stringify(obj);
        // 以json格式打日志
        console.log(log);
        return log;
    },
    array_merge: function (a, c) {
        // 数组合并,从c&&a的并集
        var d = {},
            b;
        for (b in a) d[b] = a[b];
        for (b in c) d[b] = c[b];
        return d
    },
    in_array: function (search, array) {
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
    str2Args: function (query, split) {
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
    args2Str: function (args, split) {
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
    jsonObjParams2Str: function (params, link) {
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
    isWeiXin: function () {
        var ua = navigator.userAgent.toLowerCase();
        if (ua.match(/MicroMessenger/i) == "micromessenger") {
            return true;
        } else {
            return false;
        }
    },
    isWechatApp: function () {
        if (!window.WeixinJSBridge || !WeixinJSBridge.invoke) {
            document.addEventListener('WeixinJSBridgeReady', function () {
                return window.__wxjs_environment === 'miniprogram'
            }, false)
        } else {
            return window.__wxjs_environment === 'miniprogram'
        }
    },
    isHttps: function () {
        var url = window.location.href;
        var isHttps = url.toUpperCase().indexOf("HTTPS");
        if (isHttps > -1) {
            return true;
        }
        return false;
    },
    // 登陆回跳
    gotoLogin: function () {
        location.href = '//' + TQ._domains.main + '/html/bindphone.html?topage=' + encodeURIComponent(location.href);
    },
    // 自由跳转
    gotoUrl: function (url_to) {
        location.href = '//' + TQ._domains.main + url_to;
    },
    getProtocol: function () {
        if (helper.isHttps()) {
            return "https"
        }
        return "http";
    },
    preventBackgroundScroll: function () {
        $("body,html").css({
            "overflow": "hidden"
        });
    },
    resumeBackgroundScroll: function () {
        $("body,html").css({
            "overflow": "auto"
        });
    },
    js_append: function (url_t) {
        var hm = document.createElement("script");
        hm.src = url_t;
        hm.type = 'text/javascript';
        hm.async = true;
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    },
    setTitle: function (t) {
        var $body = $('body');
        document.title = t;
        // hack在微信等webview中无法修改document.title的情况
        if (helper.isWeiXin()) {
            var $iframe = $('<iframe src="/fav.ico" height="0"></iframe>').on('load', function () {
                setTimeout(function () {
                    $iframe.off('load').remove()
                }, 0)
            }).appendTo($body);
        }
    },
    set5Score: function (v, totalscore, width) {
        var t = (v * width * 100) / (totalscore * 100);
        return t;
    },
    level2Txt: function (level) {
        var txt = "";
        if (level == 1) {
            txt = "特供月嫂";
        } else if (level == 2) {
            txt = "二星月嫂";
        } else if (level == 3) {
            txt = "三星月嫂";
        } else if (level == 4) {
            txt = "四星月嫂";
        } else if (level == 5) {
            txt = "五星月嫂";
        } else if (level == 6) {
            txt = "六星月嫂";
        } else if (level == 7) {
            txt = "金牌月嫂";
        } else if (level == 8) {
            txt = "月子管家";
        } else if (level == 11) {
            txt = "铜牌月子管家";
        } else if (level == 12) {
            txt = "银牌月子管家";
        } else if (level == 13) {
            txt = "金牌月子管家";
        }
        return txt;
    },
    level3Txt: function (level) {
        var txt = "";
        if (level == 2) {
            txt = "二星";
        } else if (level == 3) {
            txt = "三星";
        } else if (level == 4) {
            txt = "四星";
        } else if (level == 5) {
            txt = "五星";
        } else if (level == 6) {
            txt = "六星";
        } else if (level == 7) {
            txt = "金牌";
        } else if (level == 8) {
            txt = "钻石";
        } else {
            txt = "不限";
        }
        return txt;
    },
    level3CareType: function (level) {
        var txt = "";
        if (level == 1) {
            txt = "育婴护理师";
        } else if (level == 2) {
            txt = "育儿护理师";
        } else if (level == 3) {
            txt = "幼儿护理师";
        } else {
            txt = "育婴师";
        }
        return txt;
    },
    level2Cls: function (level) {
        var txt = "jjys-big-start5";
        if (level == 1) {
            txt = "jjys-big-start1";
        } else if (level == 2) {
            txt = "jjys-big-start2";
        } else if (level == 3) {
            txt = "jjys-big-start3";
        } else if (level == 4) {
            txt = "jjys-big-start4";
        } else if (level == 5) {
            txt = "jjys-big-start5";
        } else if (level == 6) {
            txt = "jjys-big-start6";
        } else if (level == 7) {
            txt = "jjys-big-start7";
        } else if (level == 8) {
            txt = "jjys-big-start8";
        } else if (level == 11) {
            txt = "jjys-big-start11";
        } else if (level == 12) {
            txt = "jjys-big-start12";
        } else if (level == 13) {
            txt = "jjys-big-start13";
        }
        return txt;
    },
    level3Cls: function (level) {
        var txt = "jjys-yuyin-start5";
        if (level == 3) {
            txt = "jjys-yuyin-start3";
        } else if (level == 4) {
            txt = "jjys-yuyin-start4";
        } else if (level == 5) {
            txt = "jjys-yuyin-start5";
        } else if (level == 6) {
            txt = "jjys-yuyin-start6";
        } else if (level == 7) {
            txt = "jjys-yuyin-start7";
        } else if (level == 8) {
            txt = "jjys-yuyin-start8";
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
    isEmpty: function (v) {
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
    isAndroid: function () {
        var u = navigator.userAgent;
        if (u.indexOf('Android') > -1 || u.indexOf('Linux') > -1) { //安卓手机
            return true;
        }
        return false;
    },
    isIOS: function () {
        var u = navigator.userAgent;
        if (u.indexOf('iPhone') > -1) { //安卓手机
            return true;
        }
        return false;
    },
    isMobile: function (phone) {
        // 手机号正则
        var reg = /^1[3|4|5|6|7|8|9][0-9]\d{8}$/;
        if (reg.test(phone)) {
            return true;
        }
        return false;
    },
    showPage: function (page, params, hashparams) {
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
    changeHash: function (hashparams) {
        var arr = window.location.href.split("#");
        window.location.href = arr[0] + "#" + this.jsonObjParams2Str(hashparams);
    },
    /***
     * 本地化存储数据，
     * @param key   string类型
     * @param obj   存储非函数类型的对象，不深度拷贝
     * @private
     */
    _store: function (key, obj) {
        var value;
        // 因为open_id和手机号是关系断开的,所以,暂时用localstorage忽悠一下.
        //优先使用localstorege,其次使用cookie,
        if (window.localStorage) {
            if (obj) {
                if (typeof obj == "object") {
                    try {
                        window.localStorage.setItem(key, JSON.stringify(obj));
                    } catch (e) {}
                } else if (typeof obj == "string") {
                    try {
                        window.localStorage.setItem(key, obj);
                    } catch (e) {}
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
                    } else if (typeof (obj) == "string" || typeof (obj) == "number") {
                        value = TQ.cookie(key, obj);
                    } else {
                        alert("localStorage:你存储的是非对象");
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
    _sess: function (key, obj) {
        if (window.sessionStorage) {
            if (obj) {
                if (typeof obj == "object") {
                    window.sessionStorage.setItem(key, JSON.stringify(obj));
                } else if (typeof (obj) == "string" || typeof (obj) == "number") {
                    window.sessionStorage.setItem(key, obj);
                } else {
                    alert("sessionStorage:你存储的是非对象");
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
    getUrlParams: function (name) {
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
        var r = window.location.search.substr(1).match(reg); //匹配目标参数
        if (r != null) return decodeURIComponent(r[2]);
        return null; //返回参数值
    },
    //获取字符串的长度(区分中英文)
    Bytelen: function (str) {
        return str.replace(/[^\x00-\xff]/g, "**").length;
    },
    isLogin: function () {
        var identityObj = helper._store("identity");
        if (identityObj && identityObj.user_id && identityObj.token) {
            return true;
        }
        return false;
    },
    /**
     * [isLogout  清除用户信息]
     */
    isLogout: function () {
        localStorage.removeItem('identity')
    },
    loading: function () {
        if ($("body").has(".loading").length == 0) {
            $('body').append('<div class="loading"></div>');
        }
    },
    reachBottom: function () {
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
    subStringCn: function (str, len, hasDot) {
        // 截取多余的字符串
        var newLength = 0;
        // 强转
        str = String(str);
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
    // 1android2ios3公众号4小程序0wap
    get_platform: function () {
        var global_param = helper._store("global_param");
        if (!helper.isEmpty(global_param)) {
            platform = global_param.platform || 0;
        } else {
            var ua = navigator.userAgent.toLowerCase();
            if (0 <= ua.indexOf("micromessenger")) {
                platform = 3;
            } else if (0 <= ua.indexOf("jjys_app_user_android") || 0 <= ua.indexOf('jjys_app_yuesao_android')) {
                platform = 1;
            } else if (0 <= ua.indexOf("jjys_app_user_ios") || 0 <= ua.indexOf('jjys_app_yuesao_ios')) {
                platform = 2;
            } else if (this.isWechatApp()) {
                platform = 4;
            } else {
                // 浏览器
                platform = 0;
            }
        }
        return platform;
    },
    getRandomArrItem: function (arr) {
        // 随机数组取其一
        if (helper.isEmpty(arr)) {
            return "";
        }
        return arr[Math.round(Math.random() * arr.length)];
    },
    appendzero(obj) {
        if (obj < 10) return "0" + "" + obj;
        else return obj;
    },
    timeStampToDate: function (seconds, f) {
        // 时间戳转日期
        var md = new Date(1e3 * parseInt(seconds));
        var hour = md.getHours();
        var minutes = md.getMinutes();
        if (hour <= 9) {
            hour = "0" + hour;
        }
        if (minutes <= 9) {
            minutes = "0" + minutes;
        }
        if (f == 'day') {
            return md.getFullYear() + "年" + (md.getMonth() + 1) + "月" + md.getDate() + '日';
        } else if (f == 1) {
            return (md.getMonth() + 1) + "-" + md.getDate();
        } else if (f == 2) {
            return md.getFullYear() + "-" + helper.appendzero((md.getMonth() + 1)) + "-" + helper.appendzero(md.getDate());
        } else if (f == 3) {
            return md.getFullYear() + "年" + (md.getMonth() + 1) + "月" + md.getDate() + '日' + " " + hour + ":" + minutes;
        } else if (f == 4) {
            return md.getFullYear() + "/" + (md.getMonth() + 1) + "/" + md.getDate();
        } else {
            return md.getFullYear() + "/" + (md.getMonth() + 1) + "/" + md.getDate() + " " + hour + ":" + minutes;
        }
    },
    dateToTimeStamp: function (stringTime) {
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
    ossThumb: function (url_pic, thumb) {
        // 云存储自动缩略图
        if (url_pic.indexOf('http://upload.ddys168.com/') != -1 || url_pic.indexOf('http://upload.jjys168.com/') != -1) {
            url_pic = url_pic + thumb;
        }
        return url_pic;
    },
    toggle: function (x) {
        if (x) {
            return 0;
        } else {
            return 1;
        }
    },
    timerOut: function (timeNow, className, fun) {
        var timeEnd = timeNow.getTime() + 60 * 60 * 2 * 1000; //结束时间
        var text = '';
        var timer = setInterval(function () {
            var now = new Date();
            var timeLeft = parseInt((timeEnd - now.getTime()) / 1000);
            if (timeLeft <= 0) {
                clearInterval(timer);
                if (fun) {
                    fun()
                };
                return;
            };
            var secLeft = timeLeft % 60;
            var minLeft = parseInt(timeLeft / 60) % 60
            var hourLeft = parseInt(timeLeft / 60 / 60) % 24;
            /*var dayLeft=parseInt(timeLeft/60/60/24);*/
            text = "0" + hourLeft + ":" + minLeft + ":" + secLeft;
            $("." + className).text(text);
        }, 1000)
    },
    // 异步请求封装
    xhr_get: function (uri, cb) {
        var xhr;
        if (window.XMLHttpRequest) {
            xhr = new XMLHttpRequest();
        } else {
            xhr = new ActiveXObject('Microsoft.XMLHTTP');
        }
        //异步接受响应
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    cb(xhr.responseText);
                }
            }
        }
        // get请求
        xhr.open('get', uri, true);
        xhr.send();
    },
    // 异步post请求封装
    xhr_post: function (uri, req, cb) {
        var xhr;
        if (window.XMLHttpRequest) {
            xhr = new XMLHttpRequest();
        } else {
            xhr = new ActiveXObject('Microsoft.XMLHTTP');
        }
        //异步接受响应
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    cb(xhr.responseText);
                }
            }
        }
        // get请求
        xhr.open('post', uri, true);
        xhr.withCredentials = false;
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.send('param=' + helper.jlog(req));
    },
    /**
     * cityInfo：获取匹配的城市信息
     * @param  {Object} data 匹配城市数据的条件
     * @return {Object}      匹配成功的城市信息
     */
    cityInfo: function (data) {
        var city = [{
            city: '深圳',
            code: '103212',
            province: {
                'city': '广东省',
                'code': '103198'
            },
            baidu_code: "340",
            domain: ['szjjys', 'jjys']
        }, {
            city: '武汉',
            code: '102849',
            province: {
                'city': '湖北省',
                'code': '102848'
            },
            baidu_code: "218",
            domain: ['whjjys']
        }, {
            city: '杭州',
            code: '102661',
            province: {
                'city': '浙江省',
                'code': '102647'
            },
            baidu_code: "179",
            domain: ['hzjjys']
        }, {
            city: '大连',
            code: '101787',
            province: {
                'city': '辽宁省',
                'code': '101770'
            },
            baidu_code: "167",
            domain: ['dljjys']
        }, {
            city: '南京',
            code: '102226',
            province: {
                'city': '江苏省',
                'code': '102225'
            },
            baidu_code: "315",
            domain: ['njjjys']
        }, {
            city: '西安',
            code: '104480',
            province: {
                'city': '陕西省',
                'code': '104479'
            },
            baidu_code: "233",
            domain: ['xajjys']
        }, {
            city: '潮州',
            code: '103395',
            province: {
                'city': '广东省',
                'code': '103198'
            },
            baidu_code: "201",
            domain: ['czjjys']
        }, {
            city: '遵义',
            code: '104171',
            province: {
                'city': '贵州省',
                'code': '104153'
            },
            baidu_code: "262",
            domain: ['zyjjys']
        }, {
            city: '桂林',
            code: '103432',
            province: {
                'city': '广西省',
                'code': '103407'
            },
            baidu_code: "262",
            domain: []
        }, {
            city: '宁波',
            code: '102648',
            province: {
                'city': '浙江省',
                'code': '102647'
            },
            baidu_code: "262",
            domain: []
        }, {
            city: '湛江',
            code: '103353',
            province: {
                'city': '广东省',
                'code': '103198'
            },
            baidu_code: "198",
            domain: []
        }, {
            city: '成都',
            code: '103651',
            province: {
                'city': '四川省',
                'code': '103650'
            },
            baidu_code: "75",
            domain: []
        }, {
            city: '广州',
            code: '103199',
            province: {
                'city': '广东省',
                'code': '103198'
            },
            baidu_code: "257",
            domain: ['gzoujjys']
        }, {
            city: '广州',
            code: '105006',
            province: {
                'city': '广东省',
                'code': '103198'
            },
            baidu_code: "257",
            domain: ['gzjjys']
        }, {
            city: '贵港',
            code: '103473',
            province: {
                'city': '广西省',
                'code': '103407'
            },
            baidu_code: "257",
            domain: []
        }, {
            city: '东莞',
            code: '103274',
            province: {
                'city': '广东省',
                'code': '103198'
            },
            baidu_code: "257",
            domain: []
        }, {
            city: '天津',
            code: '104911',
            province: {
                'city': '天津省',
                'code': '100168'
            },
            baidu_code: "257",
            domain: []
        }, {
            city: '中山',
            code: '103308',
            province: {
                'city': '广东省',
                'code': '103198'
            },
            baidu_code: "257",
            domain: []
        }, {
            city: '厦门',
            code: '102767',
            province: {
                'city': '福建省',
                'code': '102752'
            },
            baidu_code: "257",
            domain: []
        }];
        return city;
    },
    /*获取当前城市信息*/
    getCity: function () {
        var city_code = helper._store('city_code') || 103212;
        var city_config = helper.cityInfo();
        var result = {};
        for (i in city_config) {
            if (city_config[i].code == city_code) result = city_config[i];
        }
        return result;
    },
};
//Base64编码
var Base64 = {
    _keyStr: "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",
    encode: function (e) {
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
    decode: function (e) {
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
    _utf8_encode: function (e) {
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
    _utf8_decode: function (e) {
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
    shareSend: function (wxParams) {
        // 避免非微信环境的调用
        if (!helper.isWeiXin()) {
            return 0;
        } else {
            helper.jlog(['shareSend fail,weixin pls', wxParams]);
        }
        var req = {
            "methodName": "WeixinShare",
            "refer_url": encodeURIComponent(window.location.href)
        }
        doRequestwithnoheader(req, function (res) {
            weixin_pub.shareInit(wxParams, res.data);
        }, function () {
            // no error
        });
    },
    //微信分享初始化
    shareInit: function (wxParams, wxShareConfig) {
        if (wx) {
            wx.config({
                debug: wxShareConfig.debug,
                appId: wxShareConfig.appId,
                timestamp: wxShareConfig.timestamp,
                nonceStr: wxShareConfig.nonceStr,
                signature: wxShareConfig.signature,
                jsApiList: ['onMenuShareAppMessage', 'onMenuShareTimeline', 'onMenuShareQQ', 'onMenuShareWeibo', 'onMenuShareQZone', 'checkJsApi', 'chooseWXPay', "previewImage"]
            });
        } else {
            return 0;
        }
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
    shareDefault: function () {
        // 分享定制
        var data_share = {
            "title": "家家月嫂平台,专业呵护母婴健康",
            "desc": "专业的母婴护理联盟在线服务平台，手机找月嫂就用家家月嫂",
            "icon": "http://m.jjys168.com/images/logo.png",
            // "link": (location.href).replace(/open_id=\w+[\&]?/, ''),
            "link": location.href,
        }
        weixin_pub.shareSend(data_share);
    }
};
// 异步请求
var api_exam = function (req, handler, errorHandler) {
    ajax_send("/api_exam/?", req, handler, errorHandler);
};
// 异步请求
var doRequestwithnoheader = function (req, handler, errorHandler) {
    var identity = helper._store('identity');
    // 登陆态注入
    if (identity && identity.admin_id && identity.token) {
        req.admin_id = identity.admin_id;
        req.token = identity.token;
    }
    ajax_send("/api_oa/?", req, handler, errorHandler);
};
// 异步请求
var api_crm = function (req, handler, errorHandler) {
    req['_corp_id'] = helper.isEmpty(req['_corp_id']) ? 1 : req['_corp_id']
    req['token_type'] = 1;
    var identity = helper._store('identity');
    // 登陆态注入
    if (identity && identity.admin_id && identity.token) {
        req.admin_id = identity.admin_id;
        req.token = identity.token;
    }
    ajax_send("/api_crm/?", req, handler, errorHandler);
};
// 系统方法
var ajax_send = function (api, req, handler, errorHandler) {
    // 覆盖最新版本号
    req.version = '4.11';
    var uri = '//' + g_host_api + api;
    helper.xhr_post(uri, req, function (res) {
        var json = JSON.parse(res);
        if (json.code > 0) {
            // 如果是错误的用户指纹,需要清指纹并重新登陆
            if (json.code == 10001) {
                helper._store('identity', {});
                helper.gotoLogin();
            }
            errorHandler(json);
        } else {
            handler(json);
        }
    });
}
// 全局变量统一定义
var t_paramsArr = window.location.href.split("?");
var g_paramsStr = t_paramsArr.length > 1 ? t_paramsArr[1] : "";
var g_params = helper.str2Args(g_paramsStr, "&");
var g_userId = "";
var protocol = helper.getProtocol();
// 初始化
var identity = {};
// 若干全局参数,不与identity共存是因为login相关操作会清除identity
var global_param = {};
// 页面会话
var global_sess = {};
// api网关
var g_host_api = location.host;
window.TQ = {
    debug: function () {
        return true;
    },
    _domains: {
        main: window.location.host,
        imgcache: protocol + "://upload.ddys168.com",
        api: g_host_api
    },
    set_host_api: function (uri) {
        this._domains.api = protocol + '://' + uri;
    }
};
// 统一自动加载,配置可覆盖
var autoload = (function () {
    //config_autoload = helper.array_merge(config_autoload, g_params) //可以通过url进行配置项
    "undefined" != typeof config_autoload && (helper.config_autoload = helper.array_merge(helper.config_autoload, helper.array_merge(config_autoload, g_params)));
    helper.autoload();
})(autoload);