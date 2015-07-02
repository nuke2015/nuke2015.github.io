<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Document</title>
        <script type="text/javascript" src="http://fe.bdimg.com/tangram/2.0.2.5.js"></script>
        <script type="text/javascript" src="http://tangram.baidu.com/import.php?f=plugin.fx.animate"></script>
    </head>
    <body>
        <div class="pannel-content-tool">
            <a class="button" id="demo_btn">点击</a>
        </div>
        <div class="pannel-content-part">
            <p>
            <input type="text" id="demo_input" disabled value="disabled text input" />
            </p>
        </div>
        <div class="pannel-show">
            运行结果：<span id="demo_execute_result"></span>
        </div>
        <script>
        T('#demo_btn').on('click',function(e){
            var prop = baidu('#demo_input').prop('disabled');
            baidu('#demo_execute_result').html(prop+"");
        });
        </script>
    </body>
</html>