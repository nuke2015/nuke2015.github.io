<?php
// 中转
// turl=http://mmbiz.qpic.cn/mmbiz_jpg/4xvMLMPT3thvw1xt9u3KudiaoXZm2YWw0joYIovkeHRoicDiaffy2y45QibQRnhibTib8DkYgTmbJUdK0MZeSbNXbbTA/0?r=1
function mmbiz()
{
    $turl = trim($_REQUEST['turl']);
    $turl = urldecode($turl);
    // $turl = 'http://mmbiz.qpic.cn/mmbiz_jpg/4xvMLMPT3thvw1xt9u3KudiaoXZm2YWw0joYIovkeHRoicDiaffy2y45QibQRnhibTib8DkYgTmbJUdK0MZeSbNXbbTA/0?r=1';
    $x = file_get_contents($turl);
    @header('Content-type:image/jpeg');
    echo $x;
    exit;
}
