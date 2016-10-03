$('#watcher').click(function() {
    var md = new Date();
    var param = {
        year: md.getFullYear(),
        month: md.getMonth() + 1,
        day: md.getDate()
    };
    console.log(param);
    watcher.start(param, function(res) {
        console.log(res);
        $('#watcher>input').val(res.dateStringCn);
    }, function(res) {
        //cancel
    });
});