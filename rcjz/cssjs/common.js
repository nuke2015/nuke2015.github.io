console.info('hello rcjz oa,power by 榕城家政');
var $ = layui.jquery;
var comm = {
    datalist: function (param, jumper) {
        console.log(param);
        layui.use('table', function () {
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
                //,limits: [5, 7, 10]
                //,limit: 5 //每页默认显示的数量
            });
        });
        layui.use('laypage', function () {
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
                jump: function (obj) {
                    if (obj.curr != param.page) {
                        jumper(obj.curr);
                    }
                }
            });
        });
    },
    rsync_form: function (filter, data) {
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
    upload_maker: function (tag) {
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
        layui.use(['upload'], function () {
            var upload = layui.upload;
            upload.render({
                elem: tag + '_btn',
                url: "http://api_oa.loc.qinqinyuesao.com/",
                data: {
                    methodName: "FileUpload",
                    admin_id: 1,
                },
                multiple: true,
                before: function (obj) {
                    //预读本地文件示例，不支持ie8
                    obj.preview(function (index, file, result) {
                        // console.log(index, file, result);
                    });
                },
                done: function (res) {
                    if (res.code > 0) {
                        layer.msg(res.msg);
                    } else {
                        var img_url = res.data.domain + res.data.path;
                        $(tag + ' .js_result_up').append('<span class="js_upload_item "><a href="' + img_url + '" target="_blank"><img class="layui-upload-img" src="' + img_url + '"></a><br><i class="layui-icon layui-icon-close"></i></span>');
                        // 删除事件
                        $(tag + " .js_result_up .js_upload_item i").click(function () {
                            $(this).parent().remove();
                        });
                    }
                }
            });
        });
    },
    upload_get: function (tag) {
        var result = []
        $(tag + " .js_upload_item img").each(function (k, v) {
            var img = $(v).attr("src");
            result.push(img);
        });
        var img_str_list = result.join(',');
        return img_str_list;
    },
    upload_set: function (tag, str) {
        var ary = str.split(',');
        if (ary && ary.length > 0) {
            ary.forEach(function (k, v) {
                var img_url = k;
                $(tag + ' .js_result_up').append('<span class="js_upload_item "><a href="' + img_url + '" target="_blank"><img class="layui-upload-img" src="' + img_url + '"></a><br><i class="layui-icon layui-icon-close"></i></span>');
                // 删除事件
                $(tag + " .js_result_up .js_upload_item i").click(function () {
                    $(this).parent().remove();
                });
                console.log(k);
            });
        }
    },
    getAge: function (birthday) {
        // 生日转年龄
        var birTime = new Date(birthday * 1000).getFullYear();
        var nowTime = new Date().getFullYear();
        return Math.ceil((nowTime - birTime));
    },
    msg: function (msg, cb) {
        layer.msg(msg, {
            icon: 6,
            time: 1000
        }, cb);
    },
    html_append: function (turl, cb) {
        var $ = layui.jquery;
        $.get(turl, cb);
    }
}
// 全站导航
comm.html_append('/hello/common_hello.html', function (res) {
    $('div.main').before(res);
});