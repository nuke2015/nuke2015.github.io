//express_demo.js 文件
var express = require('express');
var jsontogo = require('./json-to-go');
var app = express();

// 批量自动生成go对象
// view-source:http://127.0.0.1:8081/?title=YuesaoHome&param={%22methodName%22:%22YuesaoHome%22,%22day_count%22:250,%22user_id%22:%22%22,%22platform%22:0,%22open_id%22:%22%22,%22citycode%22:103212,%22version%22:%222.7%22}
app.get('/', function(req, res) {
    var json = req.query.param;
    var title = req.query.title;
    var result = jsontogo(json,title);
    res.send(result.go);
})
var server = app.listen(8081, function() {
    var host = server.address().address
    var port = server.address().port
    console.log("应用实例，访问地址为 http://%s:%s", host, port)
})
