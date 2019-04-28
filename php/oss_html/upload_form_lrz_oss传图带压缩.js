// https://github.com/think2011/localResizeIMG
// 阿里云oss,离线上传
var oss_uper = {
    oss_host: 'http://m.t.jjys168.com/oss.php',
    send: function(file, cb) {
        console.log('oss_uper', file);
        var filename_to = this.random();
        // 先请求授权，然后回调
        $.getJSON(this.oss_host, function(config) {
            // 实例化,避免数据污染
            var ossData = new FormData();
            var oReq = new XMLHttpRequest();
            // 添加签名信息
            ossData.append('OSSAccessKeyId', config.accessid);
            ossData.append('policy', config.policy);
            ossData.append('signature', config.signature);
            ossData.append('key', config.dir + filename_to);
            // 添加文件
            ossData.append('file', file);
            oReq.onreadystatechange = cb({
                'filename': '/' + config.dir + filename_to,
                'path': config.host + config.dir + filename_to
            });
            oReq.open("POST", config.host);
            oReq.send(ossData);
        });
    },
    random: function() {
        return new Date() - 0;
    },
    show: function(file, cb) {
        var reader = new FileReader();
        // 将文件以Data URL形式进行读入页面
        reader.readAsDataURL(file);
        reader.onload = function(e) {
            cb(this.result);
        }
    },
    //测试 var f2 = convertBase64UrlToBlob(rst.base64,'image/png');
    convertBase64UrlToBlob: function(urlData, filetype) {
        var bytes = window.atob(urlData.split(',')[1]); //去掉url的头，并转换为byte
        //处理异常,将ascii码小于0的转换为大于0
        var ab = new ArrayBuffer(bytes.length);
        var ia = new Uint8Array(ab);
        for (var i = 0; i < bytes.length; i++) {
            ia[i] = bytes.charCodeAt(i);
        }
        return new Blob([ab], {
            type: filetype,
        });
    }
};
$("#oss_uper .selectfiles").on("change", function(e) {
    $('#oss_uper .tip').append('正在为您上传图片,请稍侯...');
    for (i = 0; i < e.target.files.length; i++) {
        var file = e.target.files[i];
        // 限制9张
        if (i >= 9) break;
        // lrz压缩
        lrz(file).then(function(rst) {
            var filemin = oss_uper.convertBase64UrlToBlob(rst.base64, file.type);
            oss_uper.send(filemin, function(res) {
                var html = '<img src="' + rst.base64 + '" class="oss_file" />';
                html += '<img path="' + res.filename + '" class="js-itempic" />';
                $('#oss_uper .tcontainer').append(html);
            });
        });
    }
});