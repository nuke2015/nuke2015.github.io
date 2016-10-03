// 回调式秒表,这是移动端组件,所以,请在移动端查看
// watcher.start(mydate, function(res) {
//     console.log(res);
// }, null);
var watcher = {
    instantiated: 0,
    results: {},
    years: function() {
        var now = new Date();
        var years = {}
        for (i = now.getFullYear(); i < now.getFullYear() + 3; i += 1) {
            years[i] = i + "年";
        }
        return years;
    },
    months: function() {
        var months = {
            0: '1月',
            1: '2月',
            2: '3月',
            3: '4月',
            4: '5月',
            5: '6月',
            6: '7月',
            7: '8月',
            8: '9月',
            9: '10月',
            10: '11月',
            11: '12月'
        };
        return months;
    },
    days: function() {
        var days = {};
        for (var i = 1; i < 32; i += 1) {
            days[i] = i + "日";
        }
        return days;
    },
    hide: function() {
        // 日期控件
        $(".js-mask").css("display", "none");
        // 释放
        watcher.instantiated = 0;
    },
    start: function(mydate, callback, cancel) {
        // 伪单例模式
        if (watcher.instantiated) {
            return;
        } else {
            watcher.instantiated = 1;
        }
        // console.log('time-start',mydate);
        var years = this.years();
        var months = this.months();
        var days = this.days();
        // 初始化,避免单层累积
        SpinningWheel.slotData = [];
        SpinningWheel.addSlot(years, 'center', mydate.getFullYear());
        SpinningWheel.addSlot(months, 'center', mydate.getMonth());
        SpinningWheel.addSlot(days, 'center', mydate.getDate());
        SpinningWheel.setCancelAction(function() {
            watcher.hide();
        });
        SpinningWheel.setDoneAction(function() {
            watcher.results = SpinningWheel.getSelectedValues();
            watcher.format()
            console.info("SpinningWheel", watcher.results);
            watcher.hide();
            SpinningWheel.close();
            callback(watcher.results);
        });
        SpinningWheel.open();
    },
    format: function() {
        var results = watcher.results;
        // 顺带组装一个可用的时间戳
        if (parseInt(results.keys[1])+1 < 10) {
            m = "0" + (parseInt(results.keys[1]) + 1);
        } else {
            m = parseInt(results.keys[1]) + 1;
        }
        if (parseInt(results.keys[2]) < 10) {
            d = "0" + results.keys[2];
        } else {
            d = results.keys[2];
        }
        var dateString = results.keys[0] + "/" + m + "/" + d + " 10:01:01";
        // 时间显示
        watcher.results.dateStringCn = results.values.join("");
        // 时间字符串
        watcher.results.dateString = dateString;
        // 时间戳
        watcher.results.timestamp = watcher.dateToTimeStamp(dateString);
        return;
    },
    dateToTimeStamp: function(stringTime) {
        // 转为时间戳,秒
        // 正确 var stringTime = '2013/07/10';
        // 不允许 var stringTime = '2013/9/7';
        // var stringTime = '2013/07/10 10:01:01';
        if (stringTime) {
            var timestampNs = Date.parse(new Date(stringTime));
            timestamp = timestampNs / 1000;
        } else {
            timestamp = 0;
        }
        return timestamp;
    },
};