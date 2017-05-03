var http = require("http");
var iconv = require("iconv-lite");
var url = "http://hq.sinajs.cn/list=sh600595";
var req = http.request(url, function(res) {
    res.on('data', function(data) {
        data = iconv.decode(data, 'GBK');
        console.log("" + data);
    });
});
req.end();
// var hq_str_sh600595="中孚实业,5.200,5.230,5.250,5.290,5.170,5.250,5.260,8155
// 42607390.000,28640,5.250,17100,5.240,72010,5.230,33377,5.220,35200,5.210,473
// .260,122900,5.270,148200,5.280,239100,5.290,120200,5.300,2017-05-03,15:00:00
// 
// 
//