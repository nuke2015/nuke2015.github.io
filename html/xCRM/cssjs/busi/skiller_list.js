var api = {
    // 默认是看线上+月嫂
    req: {
        methodName: "SkillerList",
        type_id: 1,
        size: 20,
        status: 1,
    },
    // level_config: {},
    table_config: function() {
        var skiller_level = fengform.config_get('skiller_level');
        return [
            [{
                field: "skiller_name",
                title: "姓名",
                width: 100,
                templet: function(d) {
                    return d.skiller_name;
                },
            }, {
                field: "id",
                title: "工号",
                width: 100,
                templet: function(d) {
                    return Number(d.id) + 10000;
                },
            }, {
                field: "title",
                title: "星级",
                width: 150,
                templet: function(d) {
                    return d.title;
                },
            }, {
                field: "price",
                title: "价格",
                width: 100,
                templet: function(d) {
                    return d.price;
                },
            }, {
                field: "province_name",
                title: "籍贯",
                width: 150,
                templet: function(d) {
                    return d.province_name + '/' + d.city_name;
                },
            }, {
                field: "age",
                title: "年龄",
                width: 100,
                templet: function(d) {
                    return d.age;
                },
            }, {
                field: "animals",
                title: "生肖",
                width: 100,
                templet: function(d) {
                    return d.animals;
                },
            }, {
                field: "constellation",
                title: "星座",
                width: 100,
                templet: function(d) {
                    return d.constellation;
                },
            }, {
                field: "create_at",
                title: "注册日期",
                width: 200,
                templet: function(d) {
                    return helper.timeStampToDate(d.create_at)
                },
            }, {
                field: "status",
                title: "状态",
                width: 100,
                templet: function(d) {
                    if (d.status == 1) {
                        return '上线';
                    } else if (d.status == -1) {
                        return '黑名单';
                    } else if (d.status == 0) {
                        return '下线';
                    } else {
                        return '';
                    }
                },
            }, {
                field: "",
                title: "操作",
                align: "center",
                fixed: "right",
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
        $(".js_status").click(function() {
            var skiller_id = $(this).attr("data-skiller_id");
            var status = $(this).attr("data-online_status");
            if (status > 0) {
                status = 0;
            } else {
                status = 1;
            }
            var req = {
                methodName: "SkillerStatus",
                id: skiller_id,
                status: status,
            };
            api.DemoDelete(req);
            console.log(req);
        });
        $(".js_info").click(function() {
            var skiller_id = $(this).attr("data-skiller_id");
            var turl = "/html/skiller_index.html?skiller_id=" + skiller_id + "&r=" + Math.random();
            location.href = turl;
        });
        $(".js_order_skiller").click(function() {
            var skiller_id = $(this).attr("data-skiller_id");
            var order_id = $(this).attr("data-order_id");
            var turl = "/html/order_skiller_info.html?skiller_id=" + skiller_id + "&order_id=" + order_id;
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
    location.href = "/html/skiller_info.html";
});
// 滑动门
$("#tab_switch_status>li").click(function(k, v) {
    api.req.status = $(this).attr("data-status");
    api.DemoList();
});
// 滑动门
$("#tab_switch_year>li").click(function(k, v) {
    api.req.year = $(this).attr("data-year");
    api.DemoList();
});
// 滑动门
$("#tab_switch_level>li").click(function(k, v) {
    api.req.level = $(this).attr("data-level");
    api.DemoList();
});
// 滑动门
$("#tab_switch_type_id>li").click(function(k, v) {
    api.req.type_id = $(this).attr("data-type_id");
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