var api = {
    req: {
        methodName: "AdminList",
        role: 1,
        size: 10,
        status: 1,
    },
    // level_config: {},
    table_config: function() {
        return [
            [{
                field: "id",
                title: "工号",
                width: 100,
                templet: function(d) {
                    return Number(d.id) + 100;
                },
            }, {
                field: "admin_name",
                title: "姓名",
                width: 100,
                templet: function(d) {
                    return d.admin_name;
                },
            }, {
                field: "mobile",
                title: "手机号",
                width: 200,
                templet: function(d) {
                    return d.mobile;
                },
            }, {
                field: "create_at",
                title: "注册时间",
                width: 200,
                templet: function(d) {
                    return helper.timeStampToDate(d.create_at)
                },
            }, {
                field: "status",
                title: "状态",
                width: 100,
                templet: function(d) {
                    if (d.status > 0) {
                        return '仍在职';
                    } else {
                        return '已离职'
                    }
                },
            }, {
                field: "",
                title: "操作",
                align: "center",
                fixed: "right",
                width: 300,
                toolbar: "#table-attr-do",
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
        // 后置绑定
        $(".js_delete").click(function() {
            var id = $(this).attr('data-id');
            var status = Number($(this).attr('data-status'));
            if (status) {
                status = 1;
            } else {
                status = 0;
            }
            // YuesaoVocationAudit
            var req = {
                'methodName': "AdminStatus",
                "id": id,
                status: status
            }
            api.DemoStatus(req);
            console.log(req);
        });
        // 后置绑定
        $(".js_role").click(function() {
            var admin_id_refer = $(this).attr('data-id');
            var turl = '/html/role_admin_map_list.html?admin_id_refer=' + admin_id_refer;
            fengform.open(turl);
        });
    },
    DemoStatus: function(req) {
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
            data.cols = api.table_config();
            comm.datalist(data, function(page) {
                api.req.page = page;
                api.DemoList(api.req);
            });
            api.table_bind();
        }, function(err) {
            // err
        });
    },
};
// api.config_get();
api.req.page = 1;
api.DemoList();
//时间范围
layui.laydate.render({
    elem: "#create_at",
    range: ["#start_time", "#end_time"],
});
//监听搜索提交
layui.form.on("submit(DistributeSubmit)", function(data) {
    req = data.field;
    api.req.page = 1;
    req.start_time = helper.dateToTimeStamp(req.start_time);
    req.end_time = helper.dateToTimeStamp(req.end_time);
    api.req = helper.array_merge(api.req, req);
    api.DemoList();
    return false;
});
layui.jquery("#demo_add").click(function() {
    location.href = "/html/admin_info.html";
});
// 滑动门
$("#tab_switch>li").click(function(k, v) {
    api.req.status = $(this).attr("data-status");
    console.log(status);
    api.DemoList();
});
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