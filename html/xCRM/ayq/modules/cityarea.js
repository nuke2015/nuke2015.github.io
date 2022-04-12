layui.define(['jquery', 'util', 'layer', 'form'], function(exports) {
    var $ = layui.$,
        util = layui.util,
        layer = layui.layer,
        form = layui.form,
        input_elem = 'input[number-input]';
    // 省市区
    var cityarea = {
        options: {
            elem: input_elem
        },
        render: function(option) {
            var _this = this;
            _this.options = $.extend(_this.options, option);
            // console.log('ayq-cityarea',_this.options);
            _this.listen();
        },
        listen: function() {
            var arr = (this.options.item.defaultValue).split(',');
            console.info('pca-default', arr);
            // this.init(103198, 103212, 103214);
            // this.init(103198,0,0);
            // this.init(103198, 103212, 0);
            this.init(arr[0], arr[1], arr[2]);
            // this.init(0,0,0);
            // this.init(102647, 102661, 102664);
        },
        init: function(pcode, ccode, acode) {
            var elem = this.options.elem;
            var that = this;
            var province = elem + "_province";
            var city = elem + "_city";
            var area = elem + "_area";
            this.lister(0, province, pcode, function(t) {
                that.lister(t, city, ccode, function(t) {
                    that.lister(t, area, acode, function(t) {
                        //
                    });
                });
                form.on("select(" + province + ")", function(e) {
                    var pcode = e.value;
                    that.init(pcode, 0, 0);
                });
                form.on("select(" + city + ")", function(e) {
                    var ccode = e.value;
                    that.lister(ccode, area, 0, function() {
                        //
                    });
                });
            });
        },
        lister: function(belong_code, elem, value, cb) {
            var req = {
                "methodName": "AddressAreainfo",
                "belong_code": belong_code
            };
            api_crm(req, function(res) {
                // console.log(res.data);
                if (res.data.areainfo) {
                    var data = res.data.areainfo;
                    // 先清空
                    $("#" + elem).html('');
                    for (i in data) {
                        item = data[i];
                        $("#" + elem).append('<option value="{0}">{1}</option>'.format(item.code, item.city_name));
                    }
                    if (!value) {
                        value = data[0].code;
                    }
                    // console.log('hit', value);
                    // 后置刷新
                    $("#" + elem).val(value);
                    form.render();
                    cb(value);
                }
            });
        },
        world: function() {
            console.log('world world');
        },
        hello: function(arg1) {
            console.log('hello hello');
        }
    };
    //外部接口
    var exportApi = {
        render: function(option) {
            cityarea.render(option)
        },
    };
    exports('cityarea', exportApi);
});