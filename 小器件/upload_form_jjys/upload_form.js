// 阿里云oss,离线上传
var oss_uper = function(_config) {
    var config = { //默认配置
        tip: '#oss_uper .tip',
        input: '#oss_uper .selectfiles',
        select: '#oss_uper .tcontainer',
        file_host: '/api/', //接口网关
        identity: helper._store("identity"),
    };
    $.extend(config, _config); //合并配置对象
    return {
        identity: {},
        // 直接上阿里云
        send: function(file, cb) {
            console.log('oss_uper', file);
            // 先请求授权，然后回调
            var ossData = new FormData();
            var xhr = new XMLHttpRequest();
            // 添加文件
            ossData.append('file', file);
            ossData.append('methodName', 'FileUpload');
            ossData.append('platform', 3);
            if(!helper.isEmpty(this.identity)){
                ossData.append('user_id', this.identity.user_id);
                ossData.append('token', this.identity.token);
            }
            ossData.append('open_id', helper.get_open_id());
            ossData.append('odsn', helper.get_odsn());
            ossData.append('version', 2.5);
            xhr.onreadystatechange = function() {
                if (this.readyState == 4) {
                    var json = JSON.parse(xhr.responseText);
                    cb(json);
                }
            }
            xhr.open("POST", config.file_host);
            xhr.send(ossData);
        },
        // 文件上传
        upload_file: function(cb) {
            var _this = this;
            $(config.input).on("change", function(e) {
                $(config.tip).append('正在为您上传图片,请稍侯...');
                for (i = 0; i < e.target.files.length; i++) {
                    var file = e.target.files[i];
                    // 限制9张
                    if (i >= 9) break;
                    _this.send(file, cb);
                }
            });
        },
        // 图片上传
        upload_image: function(cb) {
            var _this = this;
            $(config.input).on("change", function(e) {
                $(config.tip).append('正在为您上传图片,请稍侯...');
                for (i = 0; i < e.target.files.length; i++) {
                    var file = e.target.files[i];
                    // 限制9张
                    if (i >= 9) break;
                    // lrz压缩,不用限制宽高
                    lrz(file).then(function(rst) {
                        var filemin = _this.convertBase64UrlToBlob(rst.base64, rst.origin.type);
                        // console.log(filemin);
                        _this.send(filemin, function(res) {
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
        },
        // 图片上传服务
        listen: function(fun) {
            // 注入用户权限
            this.identity = config.identity;
            this.upload_image(function(res, base64) {
                console.log('地址', res);
                if (res.code) {
                    alert(res.data);
                } else {
                    if (fun) {
                        fun(res, base64);
                    } else {
                        var html = '<img src="' + base64 + '" class="oss_file" />';
                        html += '<img path="' + res.data.path + '" class="js-itempic" />';
                        $(config.select).append(html);
                        $(config.tip).html('');
                    }
                }
            });
        },
    };
}