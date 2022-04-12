var api = {
    
    req: {
        "methodName": "SkillerTag200",
        "skiller_id": this.skiller_id
    },
    // level_config: {},
    table_config: function() {
        return [
            [ {
                field: "title",
                title: "标题",
                width: 200,
                templet: function(d) {
                    return d.title;
                },
            }, {
                field: "",
                title: "操作",
                align: "center",
                fixed: "right",
                width: 200,
                toolbar: "#table-attr-switch",
            }, ],
        ]
    },
    YuesaoVocationAudit: function(req) {
        api_crm(req, function(res) {
            layer.msg(res.msg);
        }, function(res) {
            console.log(res);
        })
    },
    select_update: function() {
        // // 搜索区
        // var html = '<option value="0">星级筛选</option>';
        // $.each(api.level_config, function(k, v) {
        //     html += "<option value=" + k + ">" + v + "</option>";
        // });
        // $("#js_level").html(html);
        // layui.form.render();
    },
    table_bind: function() {
        layui.form.on('switch(attr-status-lock)', function(obj) {
            var id = $(this).data('id'),
                status = 0;
            if (obj.elem.checked) {
                status = 1
            }
            var req = {
                methodName: 'SkillerTagMapStatus',
                id: id,
                skiller_id: api.req.skiller_id,
                status: status
            };
            api_crm(req, function() {
                layer.msg('操作成功!');
            })
        });
    },
    DemoDelete: function(req) {
        api_crm(req, function(res) {
            api.DemoList();
        }, function() {
            //error
        });
    },
    DemoList: function() {
        api_crm(api.req, function(res) {
            // 数据表格
            var data = res.data;
            data.page = 1;
            data.size = 200;
            data.total = 200;
            data.count = 200;
            data.cols = api.table_config();
            comm.datalist(data, function(page) {
                api.req.page = page;
            });
            api.table_bind();
        }, function(err) {
            // err
        });
    },
};
// 读参数
var skiller_id = g_params.skiller_id;
if (!skiller_id) {
    layer.msg('参数错误!');
}

api.req.skiller_id = skiller_id;
api.req.page = 1;
api.DemoList();
// //时间范围
// layui.laydate.render({
//     elem: "#create_at",
//     range: ["#start_time", "#end_time"],
// });
// layui.jquery("#demo_add").click(function() {
//     location.href = "/html/banner_info.html";
// });
// // 滑动门
// $("#tab_switch>li").click(function(k, v) {
//     api.req.status = $(this).attr("data-status");
//     console.log(status);
//     api.DemoList();
// });
// // 导出
// $("#daochu").click(function () {
//     var req = api.req;
//     req.page = 1;
//     var result = [];
//     result.push(["角色", "姓名(工号)", "星级", "类型", "开始时间", "结束时间", "天数", "打卡次数", "备注", "状态", "销假时间", "操作人", ]);
//     exporter_feng.daochu(req, result, function (item) {
//         var takemy = [];
//         var table_config = api.table_config();
//         takemy[0] = table_config[0][0].templet(item);
//         takemy[1] = table_config[0][1].templet(item);
//         takemy[2] = table_config[0][2].templet(item);
//         takemy[3] = table_config[0][3].templet(item);
//         takemy[4] = table_config[0][4].templet(item);
//         takemy[5] = table_config[0][5].templet(item);
//         takemy[6] = item.day;
//         takemy[7] = item.count_geo;
//         takemy[8] = item.remark;
//         takemy[9] = table_config[0][9].templet(item);
//         takemy[10] = table_config[0][10].templet(item);
//         takemy[11] = item.admin_name;
//         return takemy;
//     }, "qingjiajilu.xlsx");
// });