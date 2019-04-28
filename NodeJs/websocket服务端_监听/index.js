var ws = require("nodejs-websocket");
var request = require('request');
var api_host = 'http://127.0.0.128/index.php?param=';
console.log("ws starting...");
var myDate = new Date();
var server = ws.createServer(function(conn) {
    conn.on("text", function(str) {
        console.log(str);
        request(api_host + str, function(err, res, body) {
            if (!err && res.statusCode == 200) {
                conn.send(body);
            }
        });
    });
    conn.on("close", function(code, reason) {
        console.log("关闭连接")
    });
    conn.on("error", function(code, reason) {
        console.log("异常关闭")
    });
}).listen(8092);
console.log("WebSocket listening>>");