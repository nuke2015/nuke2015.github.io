var oss_host = 'http://m.t.jjys168.com/oss.php';
function callback(res){
    console.log(res);
}
$("#img_input").on("change", function(e) {
    var file = e.target.files[0]; //获取图片资源
    // 只选择图片文件
    if (!file.type.match('image.*')) {
        return false;
    }
    console.log(file);
    // 第一项，所以这里要自己new个出来
    var ossData = new FormData();
    // 先请求授权，然后回调
    $.getJSON(oss_host, function(json) {
        //签名用的PHP
        // 添加签名信息
        ossData.append('OSSAccessKeyId', json.accessid);
        ossData.append('policy', json.policy);
        ossData.append('signature', json.signature);
        ossData.append('key', json.dir+'xf.png');
        // 添加文件
        ossData.append('file',file);
        var oReq = new XMLHttpRequest();
        oReq.onreadystatechange = callback;  
        oReq.open("POST", json.host);
        oReq.send(ossData);

        // var config = {
        //     url: json.host,
        //     data: ossData,
        //     processData: true,
        //     contentType: false,
        //     type: 'POST'
        // };
        // console.log('oss', ossData, config);
        // $.ajax(config).done(function() {
        //     // 成功后显示图片预览
        //     var img = new Image();
        //     img.src = file.name;
        //     img.onload = function() {
        //         $(".preview_box").empty().append(img);
        //     };
        // });
    });
});
