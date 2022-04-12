var api = {
    ContractShareSign: function(req) {
        api_crm(req, function(res) {
            layer.msg('签名成功!');
        }, function(res) {
            layer.msg(res.msg);
        })
    },
    // jsform二制图片上传
    upload: function(file, cb) {
        let formData = new FormData();
        formData.append("methodName", "FileUpload");
        formData.append("file", file);
        // identityObj = helper._store("identity");
        // console.log(formData, identityObj);
        var uri = "/api_crm/?";
        $.ajax({
            url: uri,
            type: "POST",
            data: formData,
            processData: false, // tell jQuery not to process the data
            contentType: false, // tell jQuery not to set contentType
            success: function(data) {
                cb(data);
            },
        });
    },
    // 旋转
    rotateBase64Img: function(src, edg, callback) {
        var canvas = document.createElement("canvas");
        var ctx = canvas.getContext("2d");
        var imgW; //图片宽度
        var imgH; //图片高度
        var size; //canvas初始大小
        if (edg % 90 != 0) {
            console.error("旋转角度必须是90的倍数!");
            throw '旋转角度必须是90的倍数!';
        }
        (edg < 0) && (edg = (edg % 360) + 360)
        const quadrant = (edg / 90) % 4; //旋转象限
        const cutCoor = {
            sx: 0,
            sy: 0,
            ex: 0,
            ey: 0
        }; //裁剪坐标
        var image = new Image();
        image.crossOrigin = "anonymous"
        image.src = src;
        image.onload = function() {
            imgW = image.width;
            imgH = image.height;
            size = imgW > imgH ? imgW : imgH;
            canvas.width = size * 2;
            canvas.height = size * 2;
            switch (quadrant) {
                case 0:
                    cutCoor.sx = size;
                    cutCoor.sy = size;
                    cutCoor.ex = size + imgW;
                    cutCoor.ey = size + imgH;
                    break;
                case 1:
                    cutCoor.sx = size - imgH;
                    cutCoor.sy = size;
                    cutCoor.ex = size;
                    cutCoor.ey = size + imgW;
                    break;
                case 2:
                    cutCoor.sx = size - imgW;
                    cutCoor.sy = size - imgH;
                    cutCoor.ex = size;
                    cutCoor.ey = size;
                    break;
                case 3:
                    cutCoor.sx = size;
                    cutCoor.sy = size - imgW;
                    cutCoor.ex = size + imgH;
                    cutCoor.ey = size + imgW;
                    break;
            }
            ctx.translate(size, size);
            ctx.rotate(edg * Math.PI / 180);
            ctx.drawImage(image, 0, 0);
            var imgData = ctx.getImageData(cutCoor.sx, cutCoor.sy, cutCoor.ex, cutCoor.ey);
            if (quadrant % 2 == 0) {
                canvas.width = imgW;
                canvas.height = imgH;
            } else {
                canvas.width = imgH;
                canvas.height = imgW;
            }
            ctx.putImageData(imgData, 0, 0);
            callback(canvas.toDataURL())
        };
    },
    // base64转文件
    urltoFile: function(url, filename, mimeType) {
        mimeType = mimeType || (url.match(/^data:([^;]+);/) || "")[1];
        return fetch(url).then(function(res) {
            return res.arrayBuffer();
        }).then(function(buf) {
            return new File([buf], filename, {
                type: mimeType,
            });
        });
    }
};
$("#actmy").click(function() {
    var canvas = document.getElementById("canvas2");
    var dataURL = canvas.toDataURL();
    layer.msg("正在生成图片,请稍候...");
    api.rotateBase64Img(dataURL, 270, function(dataURL270) {
        // console.log(dataURL);
        layer.msg("正在上传,请稍候...");
        api.urltoFile(dataURL270, "a.png").then(function(file) {
            console.log(file);
            api.upload(file, function(res) {
                var pic = res.data.path;
                if (pic) {
                    var req = {
                        "methodName": "ContractShareSign",
                        "type": g_params.type,
                        "sign": g_params.sign,
                        "pic": pic
                    };
                    api.ContractShareSign(req);
                }
            });
        });
    });
});