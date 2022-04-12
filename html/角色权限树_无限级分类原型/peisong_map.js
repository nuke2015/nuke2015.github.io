var api = {
    req: {
        page: 1,
        size: 20,
    },
    // level_config: {},
    table_config: function() {
        // var block_action = fengform.config_get('block_action');
        // var option = fengform.config_to_form(block_action);
        return []
    },
    YuesaoVocationAudit: function(req) {
        // api_daojia('/backend/goods/ajaxGoodsType', req, function(res) {
        //     layer.msg(res.msg);
        // }, function(res) {
        //     layer.msg(res.msg);
        // })
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
        var province_direct = fengform.config_get('province_direct');
        // 展示 
        $(".direct").each(function(k, v) {
            var key = $(this).data('key');
            v.after(" ", province_direct[key]);
        });
        // 状态
        $(".direct").click(function() {
            checked = $(this).is(":checked");
            var key = $(this).data('key');
            console.log(key, checked);
            $(".js_sub_" + key).each(function(k, v) {
                $(v).prop("checked", checked);
            });
        });
        // 保存
        $("#setok").click(function() {
            var map = [];
            $(".js_map").each(function(k, v) {
                checked = $(this).is(":checked");
                if (checked) {
                    value = $(v).val();
                    map.push(value);
                }
            });
            var req = {
                "peisong_id": api.req.peisong_id,
                "ids": map.join(",")
            }
            api_daojia("/backend/goods/ajax_peisong_map_save", req, function(res) {
                layer.msg(res.data);
            }, function(res) {
                console.log(res);
            })
            console.log(req);
        });
    },
    DemoDelete: function(req) {
        api_daojia('', req, function(res) {
            api.DemoList();
        }, function() {
            //error
        });
    },
    DemoList: function() {
        api_daojia('/backend/goods/ajax_peisong_map', api.req, function(res) {
            var html = template("mytpl", {
                "data": res.data
            });
            // console.log(res.data, html);
            $("#result").html(html);
            api.table_bind();
        }, function(err) {
            // err
        });
    },
};
// api.config_get();
api.req.page = 1;
api.req.peisong_id = g_params.peisong_id;
api.DemoList();
// //时间范围
// layui.laydate.render({
//     elem: "#create_at",
//     range: ["#start_time", "#end_time"],
// });
// //监听搜索提交
// layui.form.on("submit(DistributeSubmit)", function(data) {
//     req = data.field;
//     api.req.page = 1;
//     req.start_time = helper.dateToTimeStamp(req.start_time);
//     req.end_time = helper.dateToTimeStamp(req.end_time);
//     api.req = helper.array_merge(api.req, req);
//     api.DemoList();
//     return false;
// });
// $("#demo_add").click(function() {
//     var turl = "/backend/goods/peisong_info.html";
//     fengform.open(turl);
// });
// 滑动门
// $("#tab_switch>li").click(function(k, v) {
//     api.req.proj = $(this).data("proj");
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