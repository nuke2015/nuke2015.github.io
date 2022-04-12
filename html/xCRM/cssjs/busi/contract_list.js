var api = {
    req: {
        methodName: "ContractList",
        role: 1,
        size: 10,
    },
    // level_config: {},
    table_config: function() {
        // var block_action = fengform.config_get('block_action');
        // var option = fengform.config_to_form(block_action);
        return [
            [{
                field: "id",
                title: "id",
                width: 50,
                templet: function(d) {
                    return d.id;
                },
            }, {
                field: "contract_no",
                title: "合同字号",
                width: 100,
                templet: function(d) {
                    return d.contract_no;
                },
            }, {
                field: "user_name",
                title: "客户姓名",
                width: 200,
                templet: function(d) {
                    return d.user_name;
                },
            }, {
                field: "user_phone",
                title: "客户手机",
                width: 200,
                templet: function(d) {
                    return d.user_phone;
                },
            }, {
                field: "skiller_name",
                title: "阿姨姓名",
                width: 200,
                templet: function(d) {
                    return d.skiller_name;
                },
            }, {
                field: "skiller_phone",
                title: "阿姨手机",
                width: 200,
                templet: function(d) {
                    return d.skiller_phone;
                },
            }, {
                field: "create_at",
                title: "创建日期",
                width: 150,
                templet: function(d) {
                    return helper.timeStampToDate(d.create_at)
                },
            }, {
                field: "pay_at",
                title: "签署日期",
                width: 150,
                templet: function(d) {
                    return helper.timeStampToDate(d.pay_at)
                },
            }, {
                field: "status",
                title: "状态",
                width: 100,
                templet: function(d) {
                    if (d.status == 1) {
                        return '已签署';
                    } else {
                        return '待定';
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
        $(".js_delete").click(function() {
            var id = $(this).attr('data-id');
            // YuesaoVocationAudit
            var req = {
                'methodName': "ContractRenew",
                "id": id,
            }
            api.DemoDelete(req);
            layer.msg('签名已删除!');
        });
        // 后置绑定
        $(".js_view_skiller").click(function() {
            var sign = $(this).attr('data-sign');
            var turl = 'https://' + location.host + "/html/contract_share.html?type=2&sign=" + sign;
            console.log(sign, turl);
            var turl_qrcode = "/api_crm/?methodName=Qrcode&turl=" + encodeURIComponent(turl)
            fengform.open(turl_qrcode);
            // location.href = turl_qrcode;
        });
        $(".js_view_user").click(function() {
            var sign = $(this).attr('data-sign');
            var turl = "https://" + location.host + "/html/contract_share.html?type=1&sign=" + sign;
            console.log(sign, turl);
            var turl_qrcode = "/api_crm/?methodName=Qrcode&turl=" + encodeURIComponent(turl)
            fengform.open(turl_qrcode);
            // location.href = turl_qrcode;
        });
        $(".js_view").click(function() {
            var sign = $(this).attr('data-sign');
            var turl = "//" + location.host + "/html/contract_share.html?sign=" + sign;
            console.log(sign, turl);
            // location.href = turl;
            window.open(turl);
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
    location.href = "/html/article_info.html";
});
// 滑动门
$("#tab_switch>li").click(function(k, v) {
    api.req.status = $(this).attr("data-status");
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