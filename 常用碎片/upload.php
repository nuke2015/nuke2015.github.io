<?php


//获取上传的图片并返回图片路径 注：该上传代码放在开头，否则在360极速模式下无法上传
if (!empty($_FILES)) {
    $targetFolder = '/huodong/day_' . date('ymd');
    $tempFile = $_FILES['Filedata']['name'];
    $targetPath = ROOT. '/pic/' . $targetFolder;
    $targetPath = mkdirs_fun($targetPath);
    $type = strtolower(filekzm($_FILES["Filedata"]["name"]));
    $allowTypes=array('.png','.jpg','.gif');
    if(!in_array($type,$allowTypes))jsonTip(0,'文件类型不允许!');
    $img_url = '/' . date('Ymd') . '_' . md5($_FILES['Filedata']['name'] . time()) . $type;
    $targetFile = $targetPath . '/' . date('Ymd') . '_' . md5($_FILES['Filedata']['name'] . time()) . $type;
    $isOk = move_uploaded_file($_FILES['Filedata']['tmp_name'], $targetFile);
    $img_url = PIC_DOMAIN . $targetFolder . $img_url;
    jsonTip(1,$img_url);
}

checkSess();

//消息提示;
function jsonTip($status,$message){
    $return['status']=(int) $status;
    $return['message']=$message;
    exit(json_encode($return));
}

//用户授权;
function checkSess(){
    $sess=trim($_POST['sess']);
    if(!$sess){
        jsonTip(0,'session_id必传!');
    }else{
        //重置session值;
        session_id($sess);
        session_start();
        if(!$_SESSION['uid'])jsonTip(0,'请先登陆再使用!');
    }
    return;
}


