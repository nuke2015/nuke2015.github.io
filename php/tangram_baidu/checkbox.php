<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Document</title>
        <script type="text/javascript" src="http://fe.bdimg.com/tangram/2.0.2.5.js"></script>
    </head>
    <body>
        <h1 id="title">checkbox</h1>
        <form action="">
            <input type="checkbox" name="uid[]" value="1">
            <input type="checkbox" name="uid[]" value="2">
            <input type="checkbox" name="uid[]" value="3">
            <input type="checkbox" name="uid[]" value="4">
            <input type="checkbox" name="uid[]" value="5">
        </form>
        <span onclick="javascript:request();">点我</span>
        <div id="result"></div>
        <script>
            function request() {
                var a=[];
                T("input:checkbox:checked").each(function(k,v){
                    a.push(v.value);
                });
                alert(a);
            }
        </script>
    </body>
</html>
