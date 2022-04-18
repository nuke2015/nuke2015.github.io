// app.json需要引入同声传译插件,免费,但是有限额!
//app.json
// {
//   ...
//   "plugins": {
//     ...
//     "WechatSI": {
//       "version": "0.0.7",
//       "provider": "wx069ba97219f66d99"
//         }
//   }
// }
console.log('tap start');
var plugin = requirePlugin("WechatSI")
plugin.textToSpeech({
    lang: "zh_CN",
    tts: true,
    content: "取餐人,邹俊锋!",
    success: function(res) {
        console.log("succ tts", res.filename)
        const innerAudioContext = wx.createInnerAudioContext()
        innerAudioContext.autoplay = true
        // innerAudioContext.src = 'http://ws.stream.qqmusic.qq.com/M500001VfvsJ21xFqb.mp3?guid=ffffffff82def4af4b12b3cd9337d5e7&uin=346897220&vkey=6292F51E1E384E061FF02C31F716658E5C81F5594D561F2E88B854E81CAAB7806D5E4F103E55D33C16F3FAC506D1AB172DE8600B37E43FAD&fromtag=46'
        innerAudioContext.src = res.filename;
        innerAudioContext.onPlay(() => {
            console.log('开始播放')
        })
        innerAudioContext.onError((res) => {
            console.log(res.errMsg)
            console.log(res.errCode)
        })
    },
    fail: function(res) {
        console.log("fail tts", res)
    }
});