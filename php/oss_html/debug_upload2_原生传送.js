var oss_uper = {
    oss_host: 'http://m.t.jjys168.com/oss.php',
    oss_host_to: 'http://upload.jjys168.com/html5_temp/',
    send: function(file_loc, cb) {
        console.log('oss_uper', filename_to, file_loc);
        var filename_to = this.random();
        // 先请求授权，然后回调
        $.getJSON(this.oss_host, function(json) {
            var ossData = new FormData();
            var oReq = new XMLHttpRequest();
            //签名用的PHP
            // 添加签名信息
            ossData.append('OSSAccessKeyId', json.accessid);
            ossData.append('policy', json.policy);
            ossData.append('signature', json.signature);
            ossData.append('key', json.dir + filename_to);
            // 添加文件
            ossData.append('file', file_loc);
            oReq.onreadystatechange = cb(filename_to);
            oReq.open("POST", json.host);
            oReq.send(ossData);
        });
    },
    random: function() {
        return Math.random();
    }
};
$("#selectfiles").on("change", function(e) {
    $('#preview_box').html();
    for (i = 0; i < e.target.files.length; i++) {
        var file = e.target.files[i];
        if (file.size > 1024000) {
            console.log('file.size>', file.size);
            return false;
        }
        var uper = oss_uper;
        uper.send(file, function(res) {
            var html = '<img src="' + uper.oss_host_to + res + '" class="oss_file" ></img>';
            $('#preview_box').append(html);
        });
    }
});