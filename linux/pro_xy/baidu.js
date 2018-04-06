var http = require('http');
var https = require('https');
var net = require('net');
var url = require('url');

function request(cReq, cRes) {
    var u = url.parse(cReq.url);
    if(!u.hostname){
        u.hostname='www.baidu.com';
        u.port=443;
        cReq.headers.host='www.baidu.com';
        cReq.headers.referer='';
        cReq.headers.is_referer='';
    }
    var options = {
        hostname: u.hostname,
        port: u.port || 80,
        path: u.path,
        method: cReq.method,
        headers: cReq.headers
    };
    console.log(options)
    var pReq = https.request(options, function(pRes) {
        cRes.writeHead(pRes.statusCode, pRes.headers);
        pRes.pipe(cRes);
    }).on('error', function(e) {
        cRes.end();
    });
    cReq.pipe(pReq);
}

function connect(cReq, cSock) {
    var u = url.parse('http://' + cReq.url);
    if(!u.hostname){
        u.hostname='www.baidu.com';
    }
    console.log(u.hostname + ":" + u.port);
    var pSock = net.connect(u.port, u.hostname, function() {
        cSock.write('HTTP/1.1 200 Connection Established\r\n\r\n');
        pSock.pipe(cSock);
    }).on('error', function(e) {
        cSock.end();
    });
    cSock.pipe(pSock);
}
http.createServer().on('request', request).on('connect', connect).listen(8888, '0.0.0.0');
console.log('0.0.0.0:8888');