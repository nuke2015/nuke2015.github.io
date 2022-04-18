
// 以下代码可以跳过后端,一次性的拿到测试用户的openid
wx.login({
    success: function(res) {
        console.log(res)
        if (res.code) {
            console.log('通过login接口的code换取openid');
            wx.request({
                url: 'https://api.weixin.qq.com/sns/jscode2session',
                data: {
                    //填上自己的小程序唯一标识
                    appid: '',
                    //填上自己的小程序的 app secret
                    secret: '',
                    grant_type: 'authorization_code',
                    js_code: res.code
                },
                method: 'GET',
                header: {
                    'content-type': 'application/json'
                },
                success: function(openIdRes) {
                    console.info("登录成功返回的openId：" + openIdRes.data.openid);
                },
                fail: function(error) {
                    console.info("获取用户openId失败");
                    console.info(error);
                }
            })
        }
    }
});