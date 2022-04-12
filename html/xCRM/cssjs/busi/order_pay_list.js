var api = {
    req: {
        methodName: "OrderPayList",
        size: 10,
    },
    // level_config: {},
    table_config: function() {
        return [
            [{
                field: "order_title",
                title: "备注",
                width: 300,
                templet: function(d) {
                    return d.title;
                },
            }, {
                field: "money",
                title: "金额",
                width: 200,
                templet: function(d) {
                    return d.money;
                },
            }, {
                field: "transaction_no",
                title: "单据号",
                width: 300,
                templet: function(d) {
                    return d.transaction_no;
                },
            }, {
                field: "admin_name",
                title: "收款人",
                width: 200,
                templet: function(d) {
                    return d.admin_name;
                },
            }, {
                field: "create_at",
                title: "日期",
                width: 150,
                templet: function(d) {
                    return helper.timeStampToDate(d.create_at)
                },
            }, {
                field: "status",
                title: "状态",
                width: 100,
                templet: function(d) {
                    if (d.status == 1) {
                        return '已审核';
                    } else {
                        return '未审核';
                    }
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
        // 后置绑定
        // $(".js_delete").click(function() {
        //     var id = $(this).attr('data-id');
        //     var status = $(this).attr('data-status');
        //     if(status>0){
        //         status=0;
        //     }else{
        //         status=1;
        //     }
        //     console.log(status);
        //     var req = {
        //         'methodName': "OrderPayStatus",
        //         "id": id,
        //         "status":status,
        //     }
        //     api.DemoDelete(req);
        //     console.log(req);
        // });
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
// api.config_get();
api.req.page = 1;
api.req.order_id = g_params.order_id;
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
    location.href = "/html/banner_info.html";
});
// 滑动门
$("#tab_switch>li").click(function(k, v) {
    api.req.status = $(this).attr("data-status");
    console.log(status);
    api.DemoList();
});
// 导出
$("#daochu").click(function() {
    var req = api.req;
    req.page = 1;
    var result = [];
    result.push(["备注", "金额", "单据号", "收款人", "时间"]);
    exporter_feng.daochu(req, result, function(item) {
        var takemy = [];
        var table_config = api.table_config();
        takemy[0] = item.order_title;
        takemy[1] = item.money;
        takemy[2] = item.transaction_no;
        takemy[3] = item.admin_name;
        takemy[4] = helper.timeStampToDate(item.create_at);
        return takemy;
    }, "shoukuan.xlsx");
});