// 原生的aliyun oss传图片的方法
var oss_host = 'http://m.t.jjys168.com/oss.php';
var filename_to = Math.random();
$("#img_input").on("change", function(e) {
    var file = e.target.files[0]; //获取图片资源
    // 只选择图片文件
    if (!file.type.match('image.*')) {
        return false;
    }
    console.log(file);
    var ossData = new FormData();
    var oReq = new XMLHttpRequest();
    // 先请求授权，然后回调
    $.getJSON(oss_host, function(json) {
        //签名用的PHP
        // 添加签名信息
        ossData.append('OSSAccessKeyId', json.accessid);
        ossData.append('policy', json.policy);
        ossData.append('signature', json.signature);
        ossData.append('key', json.dir + filename_to);
        // 添加文件
        ossData.append('file', file);
        oReq.onreadystatechange = function(res) {
            // 这里是回调函数
            console.log(res);
            console.log(filename_to);
        };
        oReq.open("POST", json.host);
        oReq.send(ossData);
    });
});