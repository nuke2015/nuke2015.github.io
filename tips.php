<html>
    <head>
        <title>
            系统提示
        </title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv='Refresh' content='1;URL=javascript:history.back(-1);'>
        <style type="text/css">
            #main{ float:center; margin-top:10%; width:250px; } 
            a{
                text-decoration: none;
            }
            #main h4.alert_error
            { display: block; width: 95%; margin: 20px 3% 0 3%; margin-top: 20px; background: #34c083;background-position: 10px 10px; color:#fff;border-radius: 4px;
            #7B040F; padding: 10px 0; font-size: 14px; }
        </style>
    </head>
    
    <body>
        <center>
            <div id="main">
                <h4 class="alert_error">
                    {$this->data['message']}
                </h4>
                <br>
                <sub>
                    系统将在
                    <span id="wait" style="color:blue;font-weight:bold">
                        1
                    </span>
                    秒后自动
                    <b>
                        <a href="javascript:window.close();">
                            关闭!
                        </a>
                    </b>
                    </br>
                    </br>
                    <b>
                        <a id="href" href="javascript:history.back(-1);">
                            上一页
                        </a>
                    </b>
                    <span width="10px;">&nbsp;</span>
                    <b>
                        <a href="{$this->data['url']}">
                            立即跳转
                        </a>
                    </b>
                </sub>
                <div class="spacer">
                </div>
                <!-- <sub>FSCMS[锋速科技] Faster & Suiter!</sub> -->
            </div>
        </center>
        <script type="text/javascript">
            (function() {
                var wait = document.getElementById('wait'),
                href = document.getElementById('href').href;
                var interval = setInterval(function() {
                    var time = --wait.innerHTML; (time <= 0) && (location.href = href);
                },
                1000);
            })();
        </script>
    </body>

</html>