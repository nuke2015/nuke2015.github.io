var api = {
    img0: 'https://xlxjz.oss-cn-beijing.aliyuncs.com/wxapp/daxiang.jpg',
    pic_big: {
        aspectRatio: 16 / 9,
        viewMode: 0,
        minContainerWidth: 750,
        minContainerHeight: 450,
        dragMode: 'move',
        corp: function(e) {
            console.log(e);
        }
    },
    pic_fang: {
        aspectRatio: 16 / 16,
        viewMode: 0,
        minContainerWidth: 450,
        minContainerHeight: 450,
        dragMode: 'move',
        corp: function(e) {
            console.log(e);
        }
    },
    corpper_to_canvas: function(canvas) {
        initialAvatarURL = avatar.src;
        avatar.src = canvas.toDataURL();
        canvas.toBlob(function(blob) {
            console.log(blob);
            var formData = new FormData();
            formData.append('file', blob, 'avatar.jpg');
            var identity = helper._store('identity');
            // 鐧婚檰鎬佹敞鍏�
            if (identity && identity.admin_id && identity.token) {
                formData.admin_id = identity.admin_id;
                formData.token = identity.token;
            }
            console.log(identity);
            $.ajax('/api_crm/?methodName=FileUpload', {
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                xhr: function() {
                    var xhr = new XMLHttpRequest();
                    xhr.upload.onprogress = function(e) {
                        var percent = '0';
                        var percentage = '0%';
                        if (e.lengthComputable) {
                            percent = Math.round((e.loaded / e.total) * 100);
                            percentage = percent + '%';
                            // $("#pbar").attr("lay-percent", percent);
                        }
                    };
                    return xhr;
                },
                success: function(res) {
                    helper.jlog(res)
                    var turl = res.data.domain + res.data.path
                    console.log(turl);
                    $("#avatar").attr("src", turl);
                    layer.msg('上传成功！');
                    if (g_params.type == 'pic_big') {
                        var req = {
                            "methodName": "SkillerEdit",
                            "pic_big": res.data.path,
                            "id": g_params.skiller_id
                        };
                    } else {
                        var req = {
                            "methodName": "SkillerEdit",
                            "pic": res.data.path,
                            "id": g_params.skiller_id
                        };
                    }
                    api.skiller_edit(req);
                },
                error: function() {
                    avatar.src = initialAvatarURL;
                    layer.msg('上传失败哦！');
                },
                complete: function() {
                    console.log('upload complete');
                },
            });
        });
    },
    skiller_edit: function(req) {
        api_crm(req, function(res) {
            layer.msg(res.msg);
        }, function() {
            layer.msg(res.msg);
        });
    }
}
//JavaScript代码区域
layui.config({
    base: '/ayq/modules/'
}).use(['formPreview', 'form', 'layer', 'upload'], function() {
    var $ = layui.jquery;
    $("#cpbtn").hide();
    if (g_params.type == 'pic_big') {
        myoption = api.pic_big;
        $("#t1").html("横图大头像");
    } else {
        myoption = api.pic_fang;
        $("#t1").html("方形小头像");
    }
    if (g_params.turl) {
        $("#avatar").attr("src", g_params.turl);
    } else {
        $('#avatar').attr('src', api.img0);
    }
    console.log(g_params, myoption);
    // 修改
    $("#cpbtn_edit").click(function() {
        $("#cpbtn").show();
        var image = document.getElementById('avatar');
        cpmy = new Cropper(image, myoption)
        console.log(cpmy);
    });
    $("#cpbtn").click(function() {
        var c = cpmy.getCroppedCanvas({
            width: myoption.minContainerWidth,
            height: myoption.minContainerHeight,
        });
        // 开始传
        // $("#pbar").attr("lay-percent", "10%");
        api.corpper_to_canvas(c);
        cpmy.destroy();
        console.log(c);
    });
    $("#cpbtn_close").click(function() {
        window.close();
    });
    $('#myfile').change(function() {
        console.log('change ing');
        var input = this;
        var url = $(this).val();
        var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
        if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#avatar').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            $('#avatar').attr('src', api.img0);
        }
    });
});