// vlog(data);追加模式,需要手动创建日志文件
function vlog(obj) {
    var fs = require('fs');
    var str = JSON.stringify(obj) + '\r\n\r\n';
    fs.appendFile('log.txt', str, function(err) {
        if (err) throw err;
    });
}