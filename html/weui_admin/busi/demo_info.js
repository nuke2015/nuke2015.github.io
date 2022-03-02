var api = {
    DistributeInfo: function (req, cb) {
        api_crm(req, function (res) {
            console.log(req, res);
            cb(res);
        }, function (err) {
            comm.msg(err.msg);
        });
    },
    SkillerFind: function (req, cb) {
        api_crm(req, function (res) {
            console.log(req, res);
            cb(res);
        }, function (err) {
            comm.msg(err.msg);
        });
    },
    ShowDistributeInfo: function (data) {
        // 做表单,一定要id=filter
        comm.rsync_form("DistributeInfo", data);
        layui.jquery("#keyword").keyup(function () {
            console.log('ff');
            var keyword = $(this).val();
            req = {
                "methodName": "SkillerFind",
                "title": keyword,
            }
            api.SkillerFind(req, function (res) {
                $("#skiller_list").html('');
                if (res.data.data) {
                    for (i in res.data.data) {
                        item = res.data.data[i];
                        $('#skiller_list').append('<span skiller_id="' + item.skiller_id + '">' + item.skiller_id + ',' + item.title + '</span>&nbsp;');
                    }
                }
                // 选中
                $('#skiller_list>span').click(function () {
                    var skiller_id = $(this).attr("skiller_id");
                    var title = $(this).html();
                    console.log(skiller_id);
                    $("#skiller_id").val(skiller_id);
                    $("#title").val(title);
                    $('#skiller_list').html('');
                })
            });
        });
    },
    DistributeUpdate: function (req, cb) {
        api_crm(req, function (res) {
            console.log(req, res);
            cb(res);
        }, function (err) {
            comm.msg(err.msg);
        });
    },
    DistributeAdd: function (req, cb) {
        api_crm(req, function (res) {
            console.log(req, res);
            cb(res);
        }, function (err) {
            // err
        });
    }
}
layui.use(['form', 'upload', 'laydate', 'laytpl'], function () {
    var $ = layui.$,
        view = layui.view,
        laydate = layui.laydate,
        table = layui.table,
        form = layui.form,
        shopservice = layui.shopservice,
        upload = layui.upload,
        setter = layui.setter,
        laytpl = layui.laytpl;
    // 走数据
    var id = g_params.id;
    if (id > 0) {
        var req = {
            methodName: "ArticleCmsInfo",
            id: g_params.id
        }
        api.DistributeInfo(req, function (res) {
            api.ShowDistributeInfo(res.data);
        });
    } else {
        api.ShowDistributeInfo({});
    }
    //监听提交
    form.on('submit(DistributeSubmit)', function (data) {
        var req = data.field;
        // 上base64
        req.content=Base64.encode(req.content);
        if (id > 0) {
            req.methodName = "ArticleCmsEdit";
            api.DistributeUpdate(req, function (res) {
                comm.msg("修改成功!", function () {
                    location.reload();
                });
            });
        } else {
            req.methodName = "ArticleCmsAdd";
            api.DistributeAdd(req, function (res) {
                comm.msg("添加成功!", function () {
                    location.href = "/hello/demo_list.html";
                });
            });
        }
        console.log(req);
        return false;
    });

});