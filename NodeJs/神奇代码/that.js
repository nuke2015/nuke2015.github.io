// 通信网磁
var ws = new WebSocket('ws://192.168.1.242:8001');
// 辅助函数
var websocket = {
    waitForConnection: function(callback, interval) {
        // 连接探测
        if (ws.readyState === 1) {
            callback();
        } else {
            var that = this;
            setTimeout(function() {
                that.waitForConnection(callback, interval);
            }, interval);
        }
    },
    send: function(message, callback) {
        // 发报,必须在连接握手之后
        this.waitForConnection(function() {
            ws.send(message);
            if (typeof callback !== 'undefined') {
                callback();
            }
        }, 1000);
    },
};
// // 举个例子,比如点击时发送消息到console
// $(".search").bind("click", function() {
//     websocket.send('hello fengfeng');
//     // window.location.href = "http://" + TQ._domains.main + "/html/search_list.html";
// });
//