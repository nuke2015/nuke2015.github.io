// 阿里云oss,离线上传
var oss_uper = {
    // 本地上传
    file_host: '/upload.php',
    res_host: 'http://upload.jjys168.com/',
    send: function(file, cb) {
        console.log('oss_uper', file);
        // 先请求授权，然后回调
        var ossData = new FormData();
        var xhr = new XMLHttpRequest();
        // 添加文件
        ossData.append('file', file);
        xhr.onreadystatechange = function() {
            if (this.readyState == 4) {
                var json = JSON.parse(xhr.responseText);
                cb(json);
            }
        }
        xhr.open("POST", this.file_host);
        xhr.send(ossData);
    },
    // 文件上传
    upload_file: function(btn_up, div_tip, cb) {
        $(btn_up).on("change", function(e) {
            $(div_tip).append('正在为您上传图片,请稍侯...');
            for (i = 0; i < e.target.files.length; i++) {
                var file = e.target.files[i];
                // 限制9张
                if (i >= 9) break;
                oss_uper.send(file, cb);
            }
        });
    },
    // 图片上传
    upload_image: function(btn_up, div_tip, cb) {
        $(btn_up).on("change", function(e) {
            $(div_tip).append('正在为您上传图片,请稍侯...');
            for (i = 0; i < e.target.files.length; i++) {
                var file = e.target.files[i];
                // 限制9张
                if (i >= 9) break;
                // lrz压缩,不用限制宽高
                lrz(file).then(function(rst) {
                    var filemin = oss_uper.convertBase64UrlToBlob(rst.base64, rst.origin.type);
                    // console.log(filemin);
                    oss_uper.send(filemin, function(res) {
                        cb(res, rst.base64);
                    });
                });
            }
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
