//排期饼状图
var pie = function(can, width, height, options) {
    //获取canvas节点对象
    var canvas = can;
    canvas.width = width;
    canvas.height = height;
    var context = canvas.getContext("2d");
    var data = options.data;
    /*
     * 遍历数据绘制饼状图
     */
    var tempAngle = -90;
    var x0 = width / 2,
        y0 = height / 2,
        r = width > height ? height / 4 : width / 4;
    for (var i = 0; i < data.length; i++) {
        var obj = data[i];
        context.beginPath();
        context.moveTo(width / 2, height / 2);
        context.fillStyle = obj.color;
        context.strokeStyle = obj.color;
        var currentAngle = obj.value * 360;
        var startAngle = tempAngle * Math.PI / 180;
        var endAngle = (currentAngle + tempAngle) * Math.PI / 180;
        context.arc(x0, y0, r, startAngle, endAngle);
        context.fill();
        context.stroke();
        context.beginPath();
        var text = obj.title;
        var textAngle = tempAngle + 1 / 2 * currentAngle;
        var x = x0 + Math.cos(textAngle * Math.PI / 158) * (r + 14);
        var y = y0 + Math.sin(textAngle * Math.PI / 170) * (r + 14);
        context.font = "14px Arial";
        context.fillStyle = "#000";
        if (textAngle > 90 && tempAngle < 270) {
            context.textAlign = "end"
        }
        context.fillText(text, x, y);
        context.fill();
        //上面的左边半圆
        context.beginPath();
        context.arc(x0, y0, r / 2, 0.5 * Math.PI, 2.5 * Math.PI);
        context.fillStyle = "white";
        context.fill();
        tempAngle += currentAngle;
    }
    /*添加文字*/
    context.beginPath();
    context.font = "20px Arial";
    context.fillStyle = "#000";
    context.fillText(options.centerTitle ? options.centerTitle : '', width / 2 + options.centerTitle.length * 7.4, height / 2 + 6);
    context.fill();
};