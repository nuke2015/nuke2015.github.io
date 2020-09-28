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
            if (!helper.isEmpty(this.identity)) {
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
                // console.log(e);
                // n.Event {originalEvent: Event, type: "change", isDefaultPrevented: ƒ, timeStamp: 4075.2900000006775, jQuery2110009581704503623056: true, …}
                $(config.tip).append('正在为您上传图片,请稍侯...');
                for (i = 0; i < e.target.files.length; i++) {
                    var file = e.target.files[i];
                    // console.info(file);
                    // File {name: "logo.png", lastModified: 1568857802486, lastModifiedDate: Thu Sep 19 2019 09:50:02 GMT+0800 (中国标准时间), webkitRelativePath: "", size: 88453, …}
                    // 限制9张
                    if (i >= 9) break;
                    // 图片文件,lrz压缩,不用限制宽高
                    if (file.type == 'image/png') {
                        lrz(file).then(function(rst) {
                            // console.log(rst, 'r');
                            // base64: "data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD"
                            // base64Len: 61415
                            // file: Blob {size: 46043, type: "image/jpeg"}
                            // fileLen: 46043
                            // formData: FormData {}
                            // origin: File {exifdata: {…}, iptcdata: {…}, name: "logo.png", lastModified: 1568857802486, lastModifiedDate: Thu Sep 19 2019 09:50:02 GMT+0800 (中国标准时间), …}
                            // __proto__: Object
                            var filemin = _this.convertBase64UrlToBlob(rst.base64, rst.origin.type);
                            // console.log(filemin, 'min');
                            // Blob {size: 46043, type: "image/png"}
                            _this.send(filemin, function(res) {
                                cb(res, rst.base64);
                            });
                        });
                    } else {
                        _this.show(file, function(result) {
                            bin = _this.AnyToBlob(result, file.type);
                            _this.send(bin, function(res) {
                                cb(res, _this.FileIcon.other);
                            });
                        });
                    }
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
        AnyToBlob: function(result, filetype) {
            return new Blob([result], {
                type: filetype,
            });
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
            return this.AnyToBlob([ab], filetype);
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
        FileIcon: {
            other: 'data:image/jpg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAcFBQYFBAcGBgYIBwcICxILCwoKCxYPEA0SGhYbGhkWGRgcICgiHB4mHhgZIzAkJiorLS4tGyIyNTEsNSgsLSz/2wBDAQcICAsJCxULCxUsHRkdLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCz/wgARCABSAFUDAREAAhEBAxEB/8QAHAAAAQUBAQEAAAAAAAAAAAAAAAECBQYHBAMI/8QAFAEBAAAAAAAAAAAAAAAAAAAAAP/aAAwDAQACEAMQAAAA+kTJzzPQB4wcQhtB0lQM/NvAAAQqJRDZDLzzNaAAACEMpLceRGGtgAABElLHARZrgAAARBTBRSNNaAAACGKcPGnEasAAAEOU4UQ4zVQAAAiCmDhpXCRGgPGinOWg5zjOA0UBQADwKCXosZghRBgAAohuhox//8QAORAAAAQEAgYIBAUFAAAAAAAAAQIDBAAFBgcRNhJBVnSUshAWIFFzs8LSF3Wk0RMUISIyFTE1QpL/2gAIAQEAAT8Ai5ldO036Ehp9yqDrTwVOh/fHUQIQt7XSzYiilYuUVDBiYgulv2wlbmuMT/jVsuTu0HSxoG3Nc7ar8UtAW3rbQzw6094Vj4c1ztqvxS0BbquNtV+KWhOoqjt3WANZ7MV5m1UAMdNY5ymIOsmlrDXDB83mbFJ40VKqgsUDEOGsOisK+ldMYs1FTmfKpGFMiZcdAdQnizciLNZ27njw4qnaG/ZjrUNjiboDs3HkLKc0m8WcpYrMkjLJH1lwi1ldsJPKlZdNXYIEKfFKEHSLhAiyKhVEzhiUxRxAQikaclE/q2rFZmzB2s1mRwT0zm1nPFiP8dN/GJ26xyXOtzV5Bi2tvpRVFOOXz8VwWI5MgX8I+oCF98WeVUWodT/cE3ZyB/ySLZZzrr5h61YsQfFnOSdypO3U5QPSk1L3tVOUYsbkp7v5/LJFlslu9/PyJxbLOddfMfWtFiv4TzxCert1QYS0nNjBqaK8gxY3JT3fz+WSLLZMeb+fkTi2Wcq6+Y+tWLGfwnnik9Xbq02FHzg3czV5BixuSnu/n8skWUya834/lki2ec663/1rRZI2JJ7vBe3VZQNSE33RXkGLG5Keb+fyyRZXJjzfz8hItlnSu9/9a0WUJmHxyF5u3VKYq0lNyd7NXkGLG5Ke7+fyyRZnElFOd+PyEi2mcq83/wBa0SnrtRT1+jLqdByDxUVMRSMcBwxwwEpgga/uLsh9Et7o+Idw9j/oF/dHxDuHsh9Av7oLX9w9kPo1vdAXDuFsf9Et7oG4df7Gn4JaHlaXCfMXDVSldAi6ZkzGBkrrDARARNFo5O7k1GqJPkDIKruTrAQ/dgUvpizBMKMdb8flJE9tzOSTp8/p6eLsPz6orLEKqcmJhEdZYoC4a7OZKyGpnX6lOYCulz4AQS6jmNhHW+nNoJXxaf3jrfTm0Er4tP7x1up3aCV8Wn9463U5tDKuLT90dbqc2hlXFp+6Ot1ObQyri0/dDmtKcQaLLf12WnFMgmwI5IYxsAx/QAHERiWT2rK4mT5WUviMZamcCFE5A+wiIxRtNqU3IRZLLgqodYyxjFLrNGqLooJBWLnBImJtHGFgAFTYdAwPRqCNQxZbJpvGP0f/xAAUEQEAAAAAAAAAAAAAAAAAAABg/9oACAECAQE/AHP/xAAUEQEAAAAAAAAAAAAAAAAAAABg/9oACAEDAQE/AHP/2Q=='
        }
    };
}