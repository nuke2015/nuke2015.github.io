/**
    2017年1月13日 16:20:20
    websocket连接客户端.
**/
// websocket连接
// app.onlunch时, 连接一次
// var socket_ws = require('socket_ws');
// socket_ws.init();
// this.socket_ws = socket_ws;
// 调用示例
// console.log('websocket demo!');
// app.socket_ws.send({
//     "methodName": "YuesaoIndex",
//     "version": "2.22",
//     "user_id": "0"
// }, function(res) {
//     console.log('socket resp:', res);
// });
var socket_ws = {
    is_open: 0,
    event: [], //回调
    init: function() {
        var that = this;
        this.conn();
        setInterval(function() {
            wx.onSocketOpen(function(res) {
                that.is_open = 1;
            });
            if (!that.is_open) {
                console.log('WebSocket conn！');
                that.conn();
            }
        }, 1000);
    },
    conn: function() {
        var conf_ws = 'wss://www.jjys168.com/tester_api_ws/';
        wx.connectSocket({
            url: conf_ws
        });
    },
    send: function(req, res) {
        var methodName = req.methodName;
        this.event[methodName] = res;
        wx.sendSocketMessage({
            data: JSON.stringify(req)
        });
        var that = this;
        wx.onSocketMessage(function(resp) {
            var obj = JSON.parse(resp.data);
            var act = obj.act;
            if (act) {
                // 回调
                that.event[act](resp.data);
            }
        });
    },
}
module.exports = socket_ws;