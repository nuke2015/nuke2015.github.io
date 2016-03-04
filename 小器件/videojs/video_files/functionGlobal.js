var FunctionGlobal = {
    GetQueryString: function(name) { //get url param value
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
        var r = window.location.search.substr(1).match(reg);
        if (r != null) return unescape(r[2]);
        return null;
    },
    popLoadingNum: 0,
    userinfo: {
        user_id: 0,
        _time: '',
        _signature: ''
    },
    SendPost: function(param, callback, custom) { //post something //custom:自定义的一些开关行为
        param.user_id = FunctionGlobal.userinfo.user_id,
            param._time = FunctionGlobal.userinfo._time,
            param._signature = FunctionGlobal.userinfo._signature,
            //$.post( FunctionGlobal.GetListUrl , param, callback );
            FunctionGlobal.showPopLoading(custom);
        jQuery.ajax({
            type: "POST",
            url: FunctionGlobal.GetListUrl,
            data: param,
            timeout: 6000,
            success: function(json) {
                FunctionGlobal.hidePopLoading(custom);
                if (custom && custom.notUseCommon) {
                    callback(json);
                    return;
                }
                if (json && parseInt(json.code) != 0) {
                    typeof json.msg == "undefined" ? json.msg = json.message : "";
                    FunctionGlobal.showErrMsg(json.msg);
                    parseInt(json.code) == 10001 ? FunctionGlobal.jump("app://login"):"";
                    return;
                }
                callback(json);
            },
            error: function(json) {
                FunctionGlobal.showErrMsg("服务器繁忙,请稍后再试");
                FunctionGlobal.hidePopLoading(custom);
            }
        });
    },
    // GetAjaxListPage : function(total,size){ // get total page
    //  return Math.ceil(total/size);
    // },
    GetListSize: 5, // get page size
    // GetListUrl : "http://api.izhangchu.com/",  // get url 
    GetListUrl: "http://192.168.1.234:8090/", // get url 
    ImageIsError: function(img) {
        img.error(function() {
            $(this).attr("src", "http://img.szzhangchu.com/img-empty.gif").addClass("img-error")
        })
    },
    workspace: { //save userinfo
        userinfo: {}
    },
    GetUserAgent: window.navigator.userAgent.toLowerCase(),
    isFromZCApp: function() {
        return FunctionGlobal.GetUserAgent.indexOf("zhangchuapp") > -1;
    },
    isIOS: function() {
        return FunctionGlobal.GetUserAgent.indexOf("iphone") > -1;
    },
    isAndroid: function() {
        return FunctionGlobal.GetUserAgent.indexOf("android") > -1;
    },
    isWeiXin: function() {
        return FunctionGlobal.GetUserAgent.indexOf("micromessenger") > -1;
    },
    isUserLogin: function(userinfo) {
        return userinfo && userinfo.user_id && parseInt(userinfo.user_id) > 0;
    },
    timeStampToDate: function(nS,f) {
        var newDate = new Date();
        newDate.setTime(parseInt(nS));
        if(!f){
            f = 'yyyy-MM-dd';
        }
        return newDate.format(f);
    },
    replaceAddress:{
        "dish": "/dishes_view/index.html?&dishes_id=",
        "food_course_series": "/course/view.html?&series_id=",
        "boutiquepost": "/community/list.html",
        "scenelist":"/scene/list.html",
        "scene": "/scene/view.html?scene_id=",
        "talent": "/post/view.html?post_id=",
        "subjectList": "/topic/index.html",
        "post": "/post/view.html?post_id=",
        "material":"/material_view/index.html?material_id=",
        "login":"/login/index.html"
    },
    changeH5Link:function(linkText){
        var cLink = "";
        if (linkText.indexOf("app://") != -1) { // app start
            var linkTextArr = linkText.split("#");
            var pathName = linkTextArr[0];
            $.each(FunctionGlobal.replaceAddress, function (key, value) {
                if (pathName.indexOf(key) != -1) {
                    cLink = linkText.replace(pathName, value).replace(/#/gi, "");
                    return false;
                }
            });
        }
        return cLink;
    },
    jump: function(url, isApp) {
        if (FunctionGlobal.isFromZCApp()) { //app login
            openDishesWithTag.jump(url); //android
        }else{           
            var urlLink = FunctionGlobal.changeH5Link(url);
            if(urlLink){
                window.location.href = urlLink;
            }
        }
    },
    exitWebView:function(){
        openDishesWithTag.exitWebView();
    },
    getInfoAPP: function(text, isAppShare) {
        if (FunctionGlobal.isFromZCApp()) {            
            openDishesWithTag.getInfo(text, isAppShare);
        }
    },
    jumpShareAPP: function(text) {
        if (FunctionGlobal.isFromZCApp()) {
            openDishesWithTag.jumpShare(text);
        }
    },
    showPopLoading: function(custom){
        if(custom && custom.notPopLoading){
            return;
        }
        ++FunctionGlobal.popLoadingNum;
        $(".pop-loader").show();
    },
    hidePopLoading: function(custom){
        if(custom && custom.notPopLoading){
            return;
        }
        --FunctionGlobal.popLoadingNum;
        if (FunctionGlobal.popLoadingNum == 0) {
            $(".pop-loader").hide();
        }
    },
    showErrMsg: function(text, secondNum) {
        $(".errormsg").text(text);
        $(".errormsg").show();
        if (!secondNum) {
            secondNum = 2000;
        }
        setTimeout(function() {
            $(".errormsg").fadeOut("slow");
        }, secondNum);
    }
};
function updateIndicatorOnline(){
    var url = localStorage.getItem("zc_offlineCurrentUrl");
    if(url){
        window.location.reload();
        localStorage.removeItem("zc_offlineCurrentUrl");
    }   
}
function updateIndicatorOffline(){    
    localStorage.setItem("zc_offlineCurrentUrl",window.location.href);
    FunctionGlobal.showErrMsg("呃哦，网速不给力哦~~~~~~~~~~~~~",5000);
}
window.addEventListener('online', updateIndicatorOnline);
window.addEventListener('offline', updateIndicatorOffline);
Date.prototype.format = function(format) {
    var date = {
        "M+": this.getMonth() + 1,
        "d+": this.getDate(),
        "h+": this.getHours(),
        "m+": this.getMinutes(),
        "s+": this.getSeconds(),
        "q+": Math.floor((this.getMonth() + 3) / 3),
        "S+": this.getMilliseconds()
    };
    if (/(y+)/i.test(format)) {
        format = format.replace(RegExp.$1, (this.getFullYear() + '').substr(4 - RegExp.$1.length));
    }
    for (var k in date) {
        if (new RegExp("(" + k + ")").test(format)) {
            format = format.replace(RegExp.$1, RegExp.$1.length == 1 ? date[k] : ("00" + date[k]).substr(("" + date[k]).length));
        }
    }
    return format;
};
String.prototype.trim = function() {
    return this.replace(/(^\s*)|(\s*$)/g, "");
}