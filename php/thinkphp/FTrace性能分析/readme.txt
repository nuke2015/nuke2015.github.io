
使用:
1.把功能类库FTrace放在\Thinkphp\Lib\Behavior中.
2.在项目中配置\Zhangchu\Conf\tags.php中增加调用配置,
return array('app_end' => array('FTrace'));
3.在\Zhangchu\Conf\config.php设置日志类别与日志目标字段.
//FTrace_logtype日志形式:[json,txt];
//FTrace_tags日志标签:['FILES','BASE','SQL', 'NOTIC', 'INFO'];
