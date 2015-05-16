<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Document</title>
        <script type="text/javascript" src="http://fe.bdimg.com/tangram/2.0.2.5.js"></script>
        <script type="text/javascript" src="http://tangram.baidu.com/import.php?f=plugin.fx.animate"></script>
    </head>
    <body>
        <h1 id="run">click</h1>
        <div style="top:100px;left:100px;">
            <div id="box" style="position: absolute;background-color: red;width:10px;height:10px;"></div>
        </div>
        <script>
            T('#run').on('click', function(){
                T('#box').animate({
                    left: '+1000',
                    top: '500'
                }).animate({
                    left: 0,
                    top: 0
                });
            });
        </script>
    </body>
</html>
