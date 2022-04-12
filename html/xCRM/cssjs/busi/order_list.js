var api = {
    config: {},
    config_category: {},
    config_get: function() {
        var req = {
            "methodName": "Config"
        };
        api_crm(req, function(res) {
            api.config = res.data;
            console.info(api.config);
        }, function() {
            //
        });
    },
    category_get: function(cb) {
        var req = {
            "methodName": "CategoryList"
        };
        api_crm(req, function(res) {
            var list = res.data.data;
            var result = [];
            result[0] = '-';
            for (i in list) {
                var item = list[i]
                result[item['id']] = item['title'];
            }
            api.config_category = result;
            cb();
        }, function() {
            //
        });
    },
    req: {
        methodName: "OrderList",
        role: 1,
        size: 10,
        status: 1,
    },
    // level_config: {},
    table_config: function() {
        return [
            [{
                field: "title",
                title: "商品名称",
                width: 200,
                templet: function(d) {
                    return d.title;
                },
            }, {
                field: "schedule_at",
                title: "预约时间",
                width: 150,
                templet: function(d) {
                    return helper.timeStampToDate(d.schedule_at)
                },
            }, {
                field: "nickname",
                title: "客户名称",
                width: 100,
                templet: function(d) {
                    return d.nickname;
                },
            }, {
                field: "mobile",
                title: "手机号",
                width: 150,
                templet: function(d) {
                    return d.mobile;
                },
            }, {
                field: "status_pay",
                title: "支付状态",
                width: 100,
                templet: function(d) {
                    if (d.status_pay == 1) {
                        return '定金已付';
                    } else if (d.status_pay == 2) {
                        return '已付全款'
                    } else {
                        return '待付款';
                    }
                },
            }, {
                field: "status_server",
                title: "服务状态",
                width: 100,
                templet: function(d) {
                    if (d.status_server == 10) {
                        return '服务中';
                    } else if (d.status_server == 20) {
                        return '服务完成'
                    } else {
                        return '待服务';
                    }
                },
            }, {
                field: "create_at",
                title: "下单时间",
                width: 150,
                templet: function(d) {
                    return helper.timeStampToDate(d.create_at)
                },
            }, {
                field: "admin_name",
                title: "归属人",
                width: 200,
                templet: function(d) {
                    return d.admin_name;
                },
            }, {
                field: "",
                title: "操作",
                align: "center",
                fixed: "right",
                width: 200,
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
        //  // 后置绑定
        $(".js_view").click(function() {
            var order_id = $(this).attr('data-order_id');
            var turl = "/html/order_info.html?id=" + order_id + "&r=" + Math.random();
            location.href = turl;
        });
        //  // 后置绑定
        $(".js_order_skiller").click(function() {
            var order_id = $(this).attr('data-order_id');
            var turl = "/html/skiller_list.html?order_id=" + order_id;
            fengform.open(turl);
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
            // api.category_get(function(){
            // 数据表格
            var data = res.data;
            data.cols = api.table_config();
            comm.datalist(data, function(page) {
                api.req.page = page;
                api.DemoList(api.req);
            });
            api.table_bind();
            // });
        }, function(err) {
            // err
        });
    },
};
var title = g_params.title;
if (title) {
    api.req.title = title;
}
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
    location.href = "/html/order_info.html";
});
// 滑动门
$("#tab_switch>li").click(function(k, v) {
    api.req.status_server = $(this).attr("data-status_server");
    api.DemoList();
});
// 滑动门
$("#tab_switch_pay>li").click(function(k, v) {
    status_pay = $(this).attr("data-status_pay");
    api.req.status_pay = status_pay;
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