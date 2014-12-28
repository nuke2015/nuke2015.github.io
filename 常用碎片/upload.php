<?php

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


