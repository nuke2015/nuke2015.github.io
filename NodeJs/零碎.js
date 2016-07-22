
// 搜索事件
$('input').on('input paste', function(e) {
    console.log(e);
    var name = $.trim($(this).val().toString());
    api.searchList({
        "methodName": "YuesaoSearch",
        "version": 2,
        "name": name,
        "page": api.page,
        "size": api.size,
    })
});

