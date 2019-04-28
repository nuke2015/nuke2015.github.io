/** 
 * 省市区三级联动,by fengfeng
 * 页面js小插件
 * 2017年3月27日 17:23:03
 * 
 * api_pca.init(103198,103199,103207);
 * 调用示例
 * 
 * 接口:
 * api.loc.jjys168.com/index.php?methodName="AddressAreainfo"&belong_code=103212
 * 
 * 数据结构:
 * {"act":"AddressAreainfo","code":0,"msg":"success","version":"1.0","timestamp":1490607482,"data":{"areainfo":[{"code":"103213","city_name":"南山区"},{"code":"103214","city_name":"罗湖区"},{"code":"103215","city_name":"福田区"},{"code":"103216","city_name":"宝安区"},{"code":"103217","city_name":"光明新区"},{"code":"103218","city_name":"龙岗区"},{"code":"103219","city_name":"坪山新区"},{"code":"103220","city_name":"大鹏新区"},{"code":"103221","city_name":"盐田区"},{"code":"103222","city_name":"龙华新区"}]}}
 * 
 */
var api_pca = {
    default_province: 103198,
    default_city: 103212,
    default_area: 103214,
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
    init: function(province, city, area) {
        if (province) {
            api_pca.default_province = province;
            api_pca.default_city = city;
            api_pca.default_area = area;
        }
        // 默认省份
        if (api_pca.default_province) {
            api_pca.AddressArea_set('#pca_province', '', api_pca.default_province);
        }
        // 默认城市
        if (api_pca.default_city) {
            api_pca.AddressArea_set('#pca_city', api_pca.default_province, api_pca.default_city);
            // 关联层级
            if (api_pca.default_area) {
                api_pca.AddressArea_set('#pca_area', api_pca.default_city, api_pca.default_area);
            } else {
                api_pca.AddressArea_set('#pca_area', api_pca.default_city, 0);
            }
        }
        // 省事件响应
        $('#pca_province').change(function() {
            var province = $("#pca_province :selected").val();
            api_pca.AddressArea_set('#pca_city', province);
            // 归零
            $('#pca_area').html('<option>区县</option>');
        });
        // 城市响应
        $('#pca_city').change(function() {
            var city = $("#pca_city :selected").val();
            api_pca.AddressArea_set('#pca_area', city);
        });
    }
};
