var api = {
    make: function(c, img_product, img_qrcode) {
        var cxt = c.getContext("2d"); // 创建context对象
        // 设置myCanvas的宽高
        c.width = 320; //设置myCanvas的宽
        c.height = 580; //设置myCanvas的高
        // 绘制一个矩形，用来做全局背景颜色
        cxt.fillStyle = "#fff"; // fillStyle方法将其染成红色
        cxt.fillRect(0, 0, c.width, c.height); // fillRect方法是创建一个矩形，x坐标、y坐标、宽度、高度
        // 把图片绘制到myCanvas
        var img = new Image()
        img.src = img_product // 图片路径
        // 为了防止图片还没加载完成就执行drawImage，需要延迟10ms再执行drawImage
        setTimeout(function() {
            cxt.drawImage(img, 20, 20, 280, 280);
        }, 10)
        // 绘制商品标题，自动换行
        cxt.fillStyle = "#333";
        cxt.font = "15px bold 黑体";
        var str = "集采平台:【厂家直供】日本进口一级帮宝适拉拉裤箱装大码36X2片"
        cxt.textBaseline = "middle";
        cxt.textAlign = "left";
        var lineWidth = 0;
        var canvasWidth = 280; //一行文字占用的宽度
        var initHeight = 320; //绘制字体距离canvas顶部初始的高度
        var lastSubStrIndex = 0; //每次开始截取的字符串的索引
        for (let i = 0; i < str.length; i++) {
            lineWidth += cxt.measureText(str[i]).width;
            if (lineWidth > canvasWidth) {
                cxt.fillText(str.substring(lastSubStrIndex, i), 20, initHeight); //绘制截取部分
                initHeight += 20; //20为字体的高度
                lineWidth = 0;
                lastSubStrIndex = i;
            }
            if (i == str.length - 1) { //绘制剩余部分
                cxt.fillText(str.substring(lastSubStrIndex, i + 1), 20, initHeight);
            }
        }
        // 绘制券后价底部背景色
        cxt.fillStyle = "#ff0036"; // fillStyle方法将其染成红色
        cxt.fillRect(220, 360, 80, 40); // fillRect方法是创建一个矩形，x坐标、y坐标、宽度、高度
        // 绘制券底部背景色
        cxt.fillStyle = "#ff0036"; // fillStyle方法将其染成红色
        cxt.fillRect(20, 360, 150, 40); // fillRect方法是创建一个矩形，x坐标、y坐标、宽度、高度
        // 绘制价格
        cxt.fillStyle = "#fff";
        cxt.font = "normal bold 20px 黑体";
        var str_price = "采购价 ¥32.90"
        cxt.textBaseline = "middle";
        cxt.textAlign = "left";
        cxt.fillText(str_price, 26, 380);
        // 绘制券面值
        cxt.fillStyle = "#bdfb59";
        cxt.font = "normal bold 15px 黑体";
        var str_quan = " 5件起订"
        cxt.textBaseline = "middle";
        cxt.textAlign = "left";
        cxt.fillText(str_quan, 230, 380);
        // 绘制二维码
        var qrcode = new Image()
        qrcode.src = img_qrcode // 二维码图片路径
        // 为了防止图片还没加载完成就执行drawImage，需要延迟10ms再执行drawImage
        setTimeout(function() {
            cxt.drawImage(qrcode, 95, 420, 130, 130);
            base64 = c.toDataURL("image/png");
            console.log(base64);
            api.download(base64);
        }, 10)
    },
    download: function(imgUrl) {
        // 如果浏览器支持msSaveOrOpenBlob方法（也就是使用IE浏览器的时候），那么调用该方法去下载图片
        if (window.navigator.msSaveOrOpenBlob) {
            var bstr = atob(imgUrl.split(',')[1])
            var n = bstr.length
            var u8arr = new Uint8Array(n)
            while (n--) {
                u8arr[n] = bstr.charCodeAt(n)
            }
            var blob = new Blob([u8arr])
            window.navigator.msSaveOrOpenBlob(blob, 'chart-download' + '.' + 'png')
        } else {
            // 这里就按照chrome等新版浏览器来处理
            const a = document.createElement('a')
            a.href = imgUrl
            a.setAttribute('download', 'result')
            a.click()
        }
    },
    getBase64: function(url, callback) {
        var Img = new Image(),
            dataURL = '';
        Img.src = url + '?v=' + Math.random();
        Img.setAttribute('crossOrigin', 'Anonymous');
        Img.onload = function() {
            var canvas = document.createElement('canvas'),
                width = Img.width,
                height = Img.height;
            canvas.width = width;
            canvas.height = height;
            canvas.getContext('2d').drawImage(Img, 0, 0, width, height);
            dataURL = canvas.toDataURL('image/jpeg');
            return callback ? callback(dataURL) : null;
        };
    },
}
var c = document.getElementById("myCanvas"); // 使用id来寻找canvas元素
var pic = 'https://upload.jjys168.com/jiajiamuying_upload/20220419/1650357863625e76670b28d.png@150h_150w_1e_1c';
api.getBase64(pic, function(r1) {
    console.log(pic, r1);
    var pic_qrcode = "https://www.jjys168.com/a/qrcode?turl=m.ijiazhen.com";
    api.getBase64(pic_qrcode, function(r2) {
        api.make(c, r1, r2);
    });
});
// api.make(c,'imgdemo.jpg','qrcode.png');