var fengconfig = {
    "act": null,
    "code": 0,
    "msg": "success",
    "version": "1.0",
    "timestamp": 1640666620,
    "data": {
        "block_action": {
            "1": "客服工具",
            "2": "预约",
            "3": "找月嫂",
            "4": "找育婴师"
        },
        "banner_action": {
            "1": "客服工具",
            "2": "预约",
            "3": "找月嫂",
            "4": "找育婴师"
        },
        "product_type_id": {
            "1": "月嫂长单",
            "2": "月嫂短单",
            "3": "保洁",
            "4": "护工",
            "5": "钟点工",
            "6": "产康",
            "7": "培训上课",
            "8": "考试拿证",
            "9": "育婴师长单平台费",
            "10": "育婴师短单平台费",
            "11": "育婴师月工资",
            "12": "保姆长单",
            "13": "保姆短单"
        },
        "order_status_pay": ["未付款", "有定金", "全款已付"],
        "order_status_server": {
            "0": "待服务",
            "10": "服务中",
            "20": "已结束"
        },
        "skiller_level": {
            "3": "三星级",
            "4": "四星级",
            "5": "五星级",
            "6": "六星级",
            "7": "金牌星级"
        },
        "skiller_xueli": {
            "1": "小学",
            "2": "初中",
            "3": "高中",
            "4": "本科",
            "5": "硕士"
        },
        "skiller_status": {
            "0": "待审核",
            "1": "已上架",
            "-1": "已下线"
        },
        "skiller_cert_map": {
            "1": "身份证",
            "2": "月嫂证",
            "3": "健康证",
            "4": "母婴护理证",
            "5": "催乳师证",
            "6": "营养师证",
            "7": "护士证",
            "8": "早教证",
            "9": "健康管理师证",
            "10": "幼师证",
            "11": "育婴师证",
            "12": "香港探亲证",
            "13": "港澳通行证",
            "14": "产后修复证",
            "15": "小儿推拿证",
            "16": "养老护理员"
        },
        "schedule_status": {
            "0": "空档",
            "1": "有订单",
            "2": "在培训",
            "3": "请假中",
            "4": "后台锁定",
            "-1": "已删除"
        },
        "order_pay_payment": {
            "1": "支付宝手机支付",
            "2": "支付宝手机网页支付",
            "3": "支付宝扫码支付",
            "4": "现金支付",
            "5": "微信支付",
            "6": "微信公众账号支付",
            "7": "微信公众账号扫码支付",
            "8": "支付宝 PC 网页支付",
            "9": "转账支付",
            "10": "线下刷卡",
            "11": "微信小程序",
            "12": "扫码支付",
            "13": "微信H5支付",
            "14": "招行",
            "15": "工资代扣"
        },
        "order_plan_type": {
            "1": "服务费",
            "2": "节假日补贴",
            "3": "平台佣金",
            "4": "阿姨月工资",
            "5": "保险费用",
            "6": "补差价"
        },
        "sys_nav_top":{
            "1":"阿姨数据",
            "2":"订单数据",
            "3":"日常运营",
            "4":"系统设置",
            "5":"其它",
        }
    }
}
var fengform = {
    upload_get(tag) {
        var result = [];
        $("#uploader-list-" + tag + " img").each(function(k, v) {
            //   console.log(k, v);
            result.push($(v).attr("src"));
        });
        return result.join(',');
    },
    upload_show(tag, list) {
        for (i in list) {
            var item = list[i];
            //上传完毕
            $("#uploader-list-" + tag).append('<div id="" class="file-iteme">' + '<div class="handle"></div>' + '<img style="width: 100px;height: 100px;" src=' + item + ">" + '<i class="layui-icon layui-icon-delete"></i><div class="info">' + item + "</div>" + "</div>");
        }
        //删除监听
        $("#uploader-list-" + tag + " i").click(function() {
            var x = $(this).parent().remove();
        });
    },
    // 表单上传
    upload_set: function(tag, str) {
        // 空串不处理
        if (str) {
            pics = str.split(",");
            if (pics.length > 0) {
                fengform.upload_show(tag, pics);
            }
        }
        console.log("uploader ready");
        var that = this;
        layui.upload.render({
            elem: $("#image" + tag),
            url: "/api_crm/?methodName=FileUpload",
            multiple: true,
            before: function(obj) {
                layer.msg("图片上传中...", {
                    icon: 16,
                    shade: 0.01,
                    time: 0,
                });
            },
            done: function(res) {
                layer.close(layer.msg()); //关闭上传提示窗口
                var pics = [res.data.domain + res.data.path];
                that.upload_show(tag, pics);
            },
        });
    },
    config_get: function(tag) {
        // 读取静态配置
        var config = fengconfig.data;
        return config[tag];
    },
    config_to_form: function(list) {
        var result = [];
        result.push({
            "text": '请选择',
            'value': 0,
            'checked': false
        });
        for (i in list) {
            result.push({
                "text": list[i],
                'value': i,
                'checked': false
            });
        }
        return result;
    },
    open: function(turl) {
        return layer.open({
            type: 2,
            title: turl,
            shadeClose: true,
            anim: 7,
            isOutAnim: 2,
            move: false,
            offset: 'rt',
            area: ['60%', '95%'],
            content: turl,
            end: function() {
                console.info("open && close");
                location.reload();
            }
        });
    }
};