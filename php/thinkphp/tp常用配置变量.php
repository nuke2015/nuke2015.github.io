<?php
$config_public=array();
$config = array(
    'CONFIG_TEST' => 'COMMON config now!',
    'DEFAULT_THEME'     => 'Default',
    'DEFAULT_CHARSET' => 'utf-8',
    'APP_GROUP_LIST' => 'Api,Web,Test',
    'DEFAULT_GROUP' =>'Api',
    'TMPL_FILE_DEPR' => '_',
    'DB_FIELDS_CACHE' => false,
    'DB_FIELDTYPE_CHECK' => true,
    'URL_ROUTER_ON' => true,
    'URL_CASE_INSENSITIVE'=> true,
    'LANG_AUTO_DETECT'=> false,
    'LANG_SWITCH_ON' => true, 
    'DEFAULT_LANG'   => 'zh-cn',
    'TAGLIB_LOAD' => true,
    'COOKIE_PREFIX'=>'',
    'COOKIE_EXPIRE'=>'',
    'VAR_PAGE' => 'p',
    'LAYOUT_HOME_ON'=>1,
    
    //报错页面定制,只在debug状态下显示出错信息
    'TMPL_EXCEPTION_FILE'=>TMPL_PATH . '/exception.html',
    'TMPL_CACHE_ON'=>true,
    'TMPL_CACHE_TIME'=>3600,
    
    //路径优化
    'URL_MODEL'=>2,
    'URL_HTML_SUFFIX'=>'.html',

);
return array_merge($config, $config_public);
