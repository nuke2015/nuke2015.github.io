// 需要引入网页导出工具
// <script src="/Public/assets/sheetjs/xlsx.full.min.js"></script>
var exporter_feng = {
    // 字符串转ArrayBuffer
    s2ab: function(s) {
        var buf = new ArrayBuffer(s.length);
        var view = new Uint8Array(buf);
        for (var i = 0; i != s.length; ++i) view[i] = s.charCodeAt(i) & 0xFF;
        return buf;
    },
    // 将一个sheet转成最终的excel文件的blob对象，然后利用URL.createObjectURL下载
    sheet2blob: function(sheet, sheetName) {
        sheetName = sheetName || 'sheet1';
        var workbook = {
            SheetNames: [sheetName],
            Sheets: {}
        };
        workbook.Sheets[sheetName] = sheet;
        // 生成excel的配置项
        var wopts = {
            bookType: 'xlsx', // 要生成的文件类型
            bookSST: false, // 是否生成Shared String Table，官方解释是，如果开启生成速度会下降，但在低版本IOS设备上有更好的兼容性
            type: 'binary'
        };
        var wbout = XLSX.write(workbook, wopts);
        var blob = new Blob([this.s2ab(wbout)], {
            type: "application/octet-stream"
        });
        return blob;
    },
    /**
     * 通用的打开下载对话框方法，没有测试过具体兼容性
     * @param url 下载地址，也可以是一个blob对象，必选
     * @param saveName 保存文件名，可选
     */
    openDownloadDialog: function(url, saveName) {
        if (typeof url == 'object' && url instanceof Blob) {
            url = URL.createObjectURL(url); // 创建blob地址
        }
        var aLink = document.createElement('a');
        aLink.href = url;
        aLink.download = saveName || ''; // HTML5新增的属性，指定保存文件名，可以不要后缀，注意，file:///模式下不会生效
        var event;
        if (window.MouseEvent) event = new MouseEvent('click');
        else {
            event = document.createEvent('MouseEvents');
            event.initMouseEvent('click', true, false, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
        }
        aLink.dispatchEvent(event);
    },
    //获取纯文本方法
    removeHTMLTag: function(str) {
        if (str) {
            str = str.replace(/<\/?[^>]*>/g, ''); //去除HTML tag
            str = str.replace(/[ | ]*\n/g, '\n'); //去除行尾空白
            //str = str.replace(/\n[\s| | ]*\r/g,'\n'); //去除多余空行
            str = str.replace(/&nbsp;/ig, ''); //去掉&nbsp;
            str = str.replace(/\s/g, ''); //将空格去掉
        }
        return str;
    },
    // 导出数据
    daochu: function(req, csv_daochu, takemy, filename) {
        var that = this;
        api_crm(req, function(res) {
            if (res.data.data && res.data.data.length > 0) {
                for (i in res.data.data) {
                    item = takemy(res.data.data[i]);
                    csv_daochu.push(item);
                }
            }
            if (res.data.page * res.data.size < res.data.total) {
                req.page += 1;
                that.daochu(req, csv_daochu, takemy, filename);
            } else {
                that.tofile(filename, csv_daochu);
            }
        });
    },
    tofile: function(filename, csv_daochu) {
        // console.log(csv_daochu);
        var sheet = XLSX.utils.aoa_to_sheet(csv_daochu);
        this.openDownloadDialog(this.sheet2blob(sheet), filename);
    }
}