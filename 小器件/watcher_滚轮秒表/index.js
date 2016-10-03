$('#watcher').click(function() {
    var mydate = new Date();
    console.log(mydate.toLocaleDateString());
    watcher.start(mydate, function(res) {
        console.log(res);
        $('#watcher>input').val(res.dateStringCn);
    }, function(res) {
        //cancel
    });
});