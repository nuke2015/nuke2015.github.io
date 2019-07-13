var schedulePie = function(data) {
    var pie_empty = function(max) {
        var pie_empty = {};
        for (var i = 1; i <= max; i++) {
            if (i < 10) {
                i = '0' + i;
            } else {
                i = i + '';
            }
            pie_empty[i] = 0;
        }
        return pie_empty;
    };
    var k = 0;
    var now = new Date();
    var month_now = now.getMonth();
    var year_now = now.getFullYear();
    // console.log(year_now, month_now, data);
    for (var y = 0; y < 12; y++) {
        month_now++;
        if (month_now > 12) {
            year_now++
            month_now -= 12;
        }
        month_now = month_now < 10 ? '0' + month_now : month_now + '';
        datas = data[year_now];
        // console.log(year_now, month_now, datas);
        var dataItem;
        if (datas && datas[month_now]) {
            dataItem = datas[month_now];
        } else {
            // 空填充
            dataItem = pie_empty(31);
        }
        // console.log(year_now, month_now, dataItem);
        var item = [];
        for (var j = 1; j <= 31; j++) {
            val = 0;
            if (j < 10) {
                val = dataItem['0' + j];
            } else {
                val = dataItem[j + ''];
            }
            item.push({
                "tag": y + '_' + j + '_' + val,
                "value": 0.0323,
                "color": val > 0 ? "#c398E3" : "#D6D6D6",
                "title": (j % 5 == 0 && j != 30) || j == 1 ? j : ''
            });
        }
        var pre = null;
        //判断当前页的饼够4个了没有，有的话新增一页
        if ((k) % 4 == 0) { 
            $('.schedule_pie').append('<div class="swiper-slide"></div>');
        }
        pre = $('.schedule_pie').children('.swiper-slide:last-child');
        pre.append('<canvas id="canvas' + year_now + month_now + '"></canvas>');
        var centerTitle = Number(month_now) + '月';
        /*渲染一个饼*/
        console.log(data);
        pie(document.getElementById("canvas" + year_now + month_now), 186, 186, {
            data: item,
            centerTitle: centerTitle
        });
        k++;
    }
    var PieSwiper = new Swiper('.pieSwiper', {
        nested: true, 
        loop: false,
        pagination: '.piePagination',
        paginationClickable: true,
        longSwipesRatio: 0.3,
        touchRatio: 1,
        observer: true,
        observeParents: true
    });
}