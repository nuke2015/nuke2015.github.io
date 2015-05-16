<?php
if ($_GET['time']) {
    echo 'ajax ok!';
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Document</title>
        <script type="text/javascript" src="http://fe.bdimg.com/tangram/2.0.2.5.js"></script>
    </head>
    <body>
        <h1 id="title">AJAX</h1>
        <span onclick="javascript:request();">点我</span>
        <div id="result"></div>
        <script>
            function request() {
                T.ajax({
                    url: '#',
                    type: 'GET',
                    data: {
                        time: Date.now(),
                    },
                    async: true,
                    success: function(responseText){
                        T('#result').html(responseText);
                    }
                });
            }
        </script>
    </body>
</html>
