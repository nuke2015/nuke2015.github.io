<?php
error_reporting(2047);
require_once "jssdk.php";
$jssdk = new JSSDK("appid", "appsecret");
$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title></title>
</head>
<body>
  
</body>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
  // 注意：所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。 
  // 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
  // 完整 JS-SDK 文档地址：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
  wx.config({
	debug: true, 
    appId: '<?php
echo $signPackage["appId"]; ?>',
    timestamp: <?php
echo $signPackage["timestamp"]; ?>,
    nonceStr: '<?php
echo $signPackage["nonceStr"]; ?>',
    signature: '<?php
echo $signPackage["signature"]; ?>',
    jsApiList: [
      'onMenuShareTimeline'
    ]
  });
wx.ready(function () {
                //在此输入各种API
                //分享到朋友圈
                wx.onMenuShareTimeline({
                    title: 'hello weixin', // 分享标题
                    link: 'http://m.baidu.com', // 分享链接
                    imgUrl: 'http://www.baidu.com/img/bd_logo1.png', // 分享图标
                    success: function () {
                        alert('weixin share ok!');
                    },
                    cancel: function () {
                        // 用户取消分享后执行的回调函数
                    }
                });
                // config信息验证后会执行ready方法，所有接口调用都必须在config接口获得结果之后，config是一个客户端的异步操作，
                //所以如果需要在页面加载时就调用相关接口，则须把相关接口放在ready函数中调用来确保正确执行。对于用户触发时才调用的接口，则可以直接调用，不需要放在ready函数中。
            });
            wx.error(function (res) {
                alert(res);
                // config信息验证失败会执行error函数，如签名过期导致验证失败，具体错误信息可以打开config的debug模式查看，也可以在返回的res参数中查看，对于SPA可以在这里更新签名。
            });
</script>
</html>




