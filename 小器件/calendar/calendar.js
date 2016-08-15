/**
 * 月嫂工作排期展示组件,
 * by loop同学亲手打造,
 * 锋子同学在此基础上进行改造.
 */
var calendar = {
    monthDom: '.js-month',
    dayDom: '.day',
    ynow: 0,
    mnow: 0,
    dnow: 0,
    m_days: [],
    data: {
        '2015': { //ajax 返回的数据,大key:为当前年份, key:为月份(注:月份要减 1), value:[]为被占用的天数, 如:2015.5.29, 为:{'2015':{'4':[29]}
            '11': [2, 4, 6, 7, 8],
            '10': [24, 3, 25, 2]
        },
        '2016': {
            '0': [2, 4, 6, 7, 8],
            '3': [24, 3, 25, 2]
        }
    },
    init: function() {
        var nstr = new Date(); //当前Date
        this.ynow = nstr.getFullYear(); //年份
        this.mnow = nstr.getMonth(); //月份
        this.dnow = nstr.getDate(); //今日日期
        this.getMdays(this.ynow);
        this.showMonth(this.ynow, this.mnow);
        this.showDays(this.ynow, this.mnow);
    },
    reload: function() {
        $(this.dayDom).html('');
        $(this.dayDom).removeClass("active");
    },
    getMdays: function(y) {
        this.m_days = [31, 28 + this.is_leap(y), 31, 30, 31, 31, 30, 31, 30, 31, 30, 31];
    },
    is_leap: function(year) {
        return (year % 100 == 0 ? (year % 400 == 0 ? 1 : 0) : (year % 4 == 0 ? 1 : 0));
    },
    getNextMonth: function() {
        if (this.mnow == 11) {
            this.mnow = 0;
            this.ynow++;
        } else {
            this.mnow++;
        }
        this.reload();
        this.showMonth(this.ynow, this.mnow);
        this.showDays(this.ynow, this.mnow);
    },
    getLastMonth: function() {
        if (this.mnow == 0) {
            this.mnow = 11;
            this.ynow--;
        } else {
            this.mnow--;
        }
        this.reload();
        this.showMonth(this.ynow, this.mnow);
        this.showDays(this.ynow, this.mnow);
    },
    showMonth: function(y, m) {
        var month = y + '年' + (m + 1) + '月';
        console.log(month);
        $(this.monthDom).html(month);
    },
    showDays: function(y, m) {
        var n1str = new Date(y, m, 1); //当月第一天Date资讯
        var wnow = n1str.getDay(); //当月第一天星期几
        var size = $(this.dayDom).size();
        for (var i = 0; i < this.m_days[m]; i++) {
            $(this.dayDom).eq(wnow + i).html(i + 1);
            if (this.data[y] && this.data[y][m]) { //判断这月是否存在被占用的天数
                for (var j = 0; j < this.data[y][m].length; j++) {
                    if ((i + 1) == this.data[y][m][j]) {
                        $(this.dayDom).eq(wnow + i).addClass("active");
                    }
                }
            }
        }
    },
    changToArr: function(arr) {
        // 时间戳数组转为日期数组
        var obj = {};
        var oneDay = 86400000;
        for (var i = 0; i < arr.length; i++) {
            var itemObj = arr[i];
            var start = new Date(itemObj.start_time * 1000 - itemObj.start_time * 1000 % oneDay),
                end = new Date(itemObj.end_time * 1000 - itemObj.end_time * 1000 % oneDay);
            var tmpObj = null;
            tmpObj = start;
            while (tmpObj.getTime() <= end.getTime()) {
                if (!obj[tmpObj.getFullYear() + ""]) { //若是存在直接Push
                    obj[tmpObj.getFullYear() + ""] = {};
                }
                if (!obj[tmpObj.getFullYear() + ""][tmpObj.getMonth() + ""]) {
                    obj[tmpObj.getFullYear() + ""][tmpObj.getMonth() + ""] = [];
                }
                obj[tmpObj.getFullYear() + ""][tmpObj.getMonth() + ""].push(tmpObj.getDate());
                tmpObj = new Date(tmpObj.getTime() + oneDay);
            }
        }
        return obj;
    }
};
$(function() {
    var dataJson = {
        "code": 0,
        "msg": "success",
        "version": "1.0",
        "timestamp": 1464025358,
        "data": {
            "Schedule": [{
                "start_time": 1464025333,
                "end_time": 1464111733,
                "status": 1
            }, {
                "start_time": 1464198133,
                "end_time": 1464370933,
                "status": 3
            }, {
                "start_time": 1464284533,
                "end_time": 1464111733,
                "status": 1
            }]
        }
    };
    console.info(dataJson);
    var arr = dataJson.data.Schedule;
    var obj = calendar.changToArr(arr);
    calendar.data = obj;
    calendar.init();
    $(".leftArrow").on("click", function() {
        calendar.getLastMonth();
    });
    $(".rightArrow").on("click", function() {
        calendar.getNextMonth();
    });
});