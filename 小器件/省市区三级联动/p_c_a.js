/** 
 * 省市区三级联动,by fengfeng
 * 页面js小插件
 * 2017年3月27日 17:23:03
 * 
 * 接口:
 * api.loc.jjys168.com/index.php?methodName="AddressAreainfo"&belong_code=103212
 * 
 * 数据结构:
 * {"act":"AddressAreainfo","code":0,"msg":"success","version":"1.0","timestamp":1490607482,"data":{"areainfo":[{"code":"103213","city_name":"南山区"},{"code":"103214","city_name":"罗湖区"},{"code":"103215","city_name":"福田区"},{"code":"103216","city_name":"宝安区"},{"code":"103217","city_name":"光明新区"},{"code":"103218","city_name":"龙岗区"},{"code":"103219","city_name":"坪山新区"},{"code":"103220","city_name":"大鹏新区"},{"code":"103221","city_name":"盐田区"},{"code":"103222","city_name":"龙华新区"}]}}
 * 
 */
var init = (function() {
    var api = {
        default_province: 103198,
        default_city: 103212,
        AddressAreainfo: function(req, res) {
            doRequestwithnoheader(req, res, function(res) {
                tip(res.msg);
            });
        },
        AddressArea_set: function(obj, code, code_default) {
            var req = {
                "methodName": "AddressAreainfo",
                "belong_code": code,
            };
            this.AddressAreainfo(req, function(res) {
                if (res.data.areainfo.length) {
                    var html = '';
                    for (i = 0; i < res.data.areainfo.length; i++) {
                        var item = res.data.areainfo[i];
                        if (code_default && item.code == code_default) {
                            html += '<option value="' + item.code + '" selected>' + item.city_name + '</option>';
                        } else {
                            html += '<option value="' + item.code + '">' + item.city_name + '</option>';
                        }
                    }
                }
                $(obj).html(html);
            });
        },
    };
    // 默认省份
    if (api.default_province) {
        api.AddressArea_set('#pca_province', '', api.default_province);
    }
    // 默认城市
    if (api.default_city) {
        api.AddressArea_set('#pca_city', api.default_province, api.default_city);
        api.AddressArea_set('#pca_area', api.default_city, 0);
    }
    // 省事件响应
    $('#pca_province').change(function() {
        var province = $("#pca_province :selected").val();
        api.AddressArea_set('#pca_city', province);
    });
    // 城市响应
    $('#pca_city').change(function() {
        var city = $("#pca_city :selected").val();
        api.AddressArea_set('#pca_area', city);
    });
})(init);