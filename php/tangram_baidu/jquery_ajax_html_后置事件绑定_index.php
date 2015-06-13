<?php
if ($_POST['time']) {
    echo "<span class='button'>点击弹出提示</span>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <script src="http://apps.bdimg.com/libs/jquery/2.1.1/jquery.min.js"></script>
</head>
<body>
    <div id="result">这个地方会不见</div>
    <script>
        jQuery.post(
            "#", 
            {time:new Date()},
            function (data){
                jQuery("#result").html(data);
                jQuery(".button").click(function(){
                    alert('ok');
                });
            }
        );
    </script>
</body>
</html>
