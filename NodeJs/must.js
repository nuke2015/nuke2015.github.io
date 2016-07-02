// 举个例子处理页面自动加载与默认配置的矛盾

var must = {
    // 批量加载伪脚本
    autoload: function(config) {
        console.log(config);
        if (config.android_fit) this.android_fit(config.android_fit_width);
        if (config.weixin_hide) this.weixin_hide();
        if (config.weixin_load) this.weixin_load();
    },
    // 安卓版本适配
    android_fit: function(width_suit) {
        if (/Android (\d+\.\d+)/.test(navigator.userAgent)) {
            var version = parseFloat(RegExp.$1);
            if (version > 2.3) {
                var phoneScale = parseInt(window.screen.width) / width_suit;
                document.write('<meta name="viewport" content="width=' + width_suit + ', minimum-scale = ' + phoneScale + ', maximum-scale = ' + phoneScale + ', target-densitydpi=device-dpi">');
            } else {
                document.write('<meta name="viewport" content="width=' + width_suit + ', target-densitydpi=device-dpi">');
            }
        } else {
            document.write('<meta name="viewport" content="width=' + width_suit + ', user-scalable=no, target-densitydpi=device-dpi">');
        }
    },
    //微信去掉下方刷新栏
    weixin_hide: function() {
        if (navigator.userAgent.indexOf('MicroMessenger') >= 0) {
            document.addEventListener('WeixinJSBridgeReady', function() {
                WeixinJSBridge.call('hideToolbar');
            });
        };
    },
    // 加载js微信库
    weixin_load: function() {
        if (/MicroMessenger/i.test(navigator.userAgent)) document.write('<script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js"><\/script>');
    },
    // 取并集
    array_merge: function(obj1, obj2) {
        var obj3 = {};
        for (var attrname in obj1) {
            obj3[attrname] = obj1[attrname];
        }
        for (var attrname in obj2) {
            obj3[attrname] = obj2[attrname];
        }
        return obj3;
    }
};
// 强制自动加载,不留痕迹,无毒无公害
(function() {
    // 若无则加载默认配置
    var config_autoload_default = {
        android_fit: 1,
        weixin_hide: 1,
        weixin_load: 1,
        // 默认屏宽
        android_fit_width: 750,
    };
    // 覆盖
    if (typeof config_autoload != 'undefined') {
        config_autoload_default = must.array_merge(config_autoload_default, config_autoload);
    }
    must.autoload(config_autoload_default);
})();