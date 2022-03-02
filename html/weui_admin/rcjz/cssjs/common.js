console.info('hello rcjz oa,power by 榕城家政');
var $ = layui.jquery;
var comm = {
    datalist: function(param, jumper) {
        console.log(param);
        layui.use('table', function() {
            var table = layui.table;
            //展示已知数据
            table.render({
                elem: '.js_table',
                cols: param.cols,
                data: param.data
                    //,skin: 'line' //表格风格
                    ,
                even: true
                    //,page: true //是否显示分页
                    // ,limits: [5, 7, 10]
                    ,
                limit: param.count //每页默认显示的数量
            });
        });
        layui.use('laypage', function() {
            var laypage = layui.laypage;
            //执行一个laypage实例
            laypage.render({
                elem: 'pagebar' //注意，这里的 test1 是 ID，不用加 # 号
                    ,
                count: param.total //数据总数，从服务端得到
                    ,
                limit: param.size //数据总数，从服务端得到
                    ,
                curr: param.page //数据总数，从服务端得到
                    ,
                layout: ['count', 'prev', 'page', 'next'],
                jump: function(obj) {
                    if (obj.curr != param.page) {
                        jumper(obj.curr);
                    }
                }
            });
        });
    },
    rsync_form: function(filter, data) {
        var id = '#' + filter
        var $ = layui.jquery;
        var tpl = $(id).html();
        // 读取明码
        html = layui.laytpl(tpl).render(data);
        // console.log(html);
        // 同步渲染form模板
        $(id).html(html);
        // 送上赋值 
        layui.form.val(filter, data);
    },
    upload_maker: function(tag) {
        // <div class="layui-form-item" id="mypic">
        //     <label class="layui-form-label">多图列表：</label>
        //     <div class="layui-upload layui-input-block">
        //         <button type="button" class="layui-btn" id="mypic_btn">多图上传</button>
        //         <blockquote class="layui-elem-quote layui-quote-nm" style="margin-top: 10px;">
        //             <div class="layui-upload-list layui-inline js_result_up"></div>
        //             <input type="hidden" name="mypic" value="">
        //         </blockquote>
        //     </div>
        // </div>
        // 多图上传按钮 监听事件
        layui.use(['upload'], function() {
            var upload = layui.upload;
            var identity = helper._store('identity');
            var req = {};
            req.methodName = "FileUpload";
            // 登陆态注入
            if (identity && identity.admin_id && identity.token) {
                req.admin_id = identity.admin_id;
                req.token = identity.token;
                req.token_type = 1;
            }
            console.log(req);
            upload.render({
                elem: tag + '_btn',
                url: "/api_crm/",
                data: req,
                multiple: true,
                before: function(obj) {
                    //预读本地文件示例，不支持ie8
                    obj.preview(function(index, file, result) {
                        // console.log(index, file, result);
                    });
                },
                done: function(res) {
                    if (res.code > 0) {
                        layer.msg(res.msg);
                    } else {
                        var img_url = res.data.domain + res.data.path;
                        $(tag + ' .js_result_up').append('<span class="js_upload_item "><a href="' + img_url + '" target="_blank"><img class="layui-upload-img" src="' + img_url + '"></a><br><i class="layui-icon layui-icon-close"></i></span>');
                        // 删除事件
                        $(tag + " .js_result_up .js_upload_item i").click(function() {
                            $(this).parent().remove();
                        });
                    }
                }
            });
        });
    },
    upload_get: function(tag) {
        var result = []
        $(tag + " .js_upload_item img").each(function(k, v) {
            var img = $(v).attr("src");
            result.push(img);
        });
        var img_str_list = result.join(',');
        return img_str_list;
    },
    upload_set: function(tag, str) {
        if (str) {
            var ary = str.split(',');
            if (ary && ary.length > 0) {
                ary.forEach(function(k, v) {
                    var img_url = k;
                    $(tag + ' .js_result_up').append('<span class="js_upload_item "><a href="' + img_url + '" target="_blank"><img class="layui-upload-img" src="' + img_url + '"></a><br><i class="layui-icon layui-icon-close"></i></span>');
                    // 删除事件
                    $(tag + " .js_result_up .js_upload_item i").click(function() {
                        $(this).parent().remove();
                    });
                    console.log(k);
                });
            }
        }
    },
    getAge: function(birthday) {
        // 生日转年龄
        var birTime = new Date(birthday * 1000).getFullYear();
        var nowTime = new Date().getFullYear();
        return Math.ceil((nowTime - birTime));
    },
    msg: function(msg, cb) {
        layer.msg(msg, {
            icon: 6,
            time: 1000
        }, cb);
    },
    html_append: function(turl, cb) {
        var $ = layui.jquery;
        $.get(turl, cb);
    }
}
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
                console.log(csv_daochu);
                var sheet = XLSX.utils.aoa_to_sheet(csv_daochu);
                that.openDownloadDialog(that.sheet2blob(sheet), filename);
            }
        });
    }
}