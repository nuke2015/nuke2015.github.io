//采集页面内容到本地
var http = require("http");
var cheerio = require('cheerio'); //引用cheerio模块,使在服务器端像在客户端上操作DOM,不用正则表达式，据基准测试：cheerio大约比JsDom快8倍。
var iconv = require('iconv-lite'); //解决编码转换模块
var BufferHelper = require('bufferhelper'); //关于Buffer我后面细说
var data = download('http://blog.csdn.net/kissliux/article/details/20466889', function(data) {
    //console.log(data);
    var $ = cheerio.load(data); //载入到cheerio进行分析
    //遍历DIV
    // $('a').each(function(i,e){
    //   console.log($(e).attr('href'));
    // });
    // 遍历链接
    // $("a.downbtn").each(function(i, e) {
    //     console.log($(e).attr("href"));
    // });
    //var title=$('head>title').text();//读取Title信息
    //console.log(title);
    //分析得到页面基本信息
    var page = {
        "document": {
            title: $('head>title').text(),
            meta: {
                title: $('meta[property="og:title"]').attr("content"),
                author: $('meta[property="og:author"]').attr("content"),
                description: $('meta[name="description"]').attr("content"),
                url: $('meta[property="og:url"]').attr("content"),
                type: $('meta[property="og:type"]').attr("content"),
                image: $('meta[property="og:image"]').attr("content")
            },
            "content": undefined,
            "images": []
        }
    };
    //采集图片存入列表
    $('img').each(function() {
        var url = $(this).attr('src');
        if (page.document.images.indexOf(url) === -1) {
            page.document.images.push(url);
        }
    });
    console.log(page);
});
/**
 * 下载源码，自动识别编码
 * @param  {[type]}   url      [下载URL]
 * @param  {Function} callback [回调]
 * @return {[type]}            [description]
 */
function download(url, callback) {
    http.get(url, function(res) {
        var data = "";
        res.on('data', function(chunk) {
            data += chunk;
        });
        res.on("end", function() {
            callback(data);
        });
    }).on("error", function(e) {
        console.log("Got error: " + e.message);
        callback(null);
    });
}
