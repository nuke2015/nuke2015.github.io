var ws = require("nodejs-websocket");
console.log("开始建立连接...")
console.log("0.0.0.0:8001")
var myDate=new Date();
var server = ws.createServer(function(conn) {
    conn.on("text", function(str) {
        console.log("rec:"+myDate.toLocaleString());
        console.log(str);
        conn.sendText(str);
    });
    conn.on("close", function(code, reason) {
        console.log("关闭连接")
    });
    conn.on("error", function(code, reason) {
        console.log("异常关闭")
    });
}).listen(8001);
console.log("WebSocket listening>>");