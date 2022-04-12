layui.define(['jquery', 'util', 'layer'], function(exports) {
    var $ = layui.$,
        util = layui.util,
        layer = layui.layer,
        input_elem = 'input[number-input]';
    var fengzi = {
        options: {
            elem: input_elem
        },
        render: function(option) {
            var _this = this;
            _this.options = $.extend(_this.options, option);
            _this.listen();
        },
        listen: function() {
            console.log('do what!', this.options);
            var elem = this.options.elem;
            for (i = 0; i < 10; i++) {
                // 测试动态装载
                $(elem).append("<option>" + i + "</option>");
            }
        },
        /**
         * 加法
         * @param arg1
         * @param arg2
         * @returns {number}
         */
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
            fengzi.render(option)
        },
    };
    exports('fengzi', exportApi);
});