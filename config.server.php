<?php
return array(
    // 站点url
    'WEB_URL' => 'http://itshajia.com',
    'WEB_ROOT' => $_SERVER['DOCUMENT_ROOT'],
    'WEB_URL_BLOG' => 'http://blog.itshajia.com',
    'WEB_URL_U' => 'http;//u.itshajia.com',
    'WEB_URL_CODE' => 'http://code.itshajia.com',

    // 路由模式 pathinfo
    'URL_MODEL ' => 0,

    // 模板标签替换
    TMPL_PARSE_STRING  =>array(
        '__PUBLIC__' => '/Resource',
        '__JS__' => '/Resource/Js',
        '__CSS__' => '/Resource/Css',
        '__IMG__' => '/Resource/Images',
        '__APP_H_JS__' => '/Resource/App/Home/Js',
        '__APP_H_CSS__' => '/Resource/App/Home/Css',
        '__APP_H_IMG' => '/Resource/App/Home/Images',
        '__APP_U_JS__' => '/Resource/App/User/Js',
        '__APP_U_CSS__' => '/Resource/App/User/Css',
        '__APP_U_IMG__' => '/Resource/App/User/Images',
        '__UPLOAD__' => '/Uploads',
        '__AP__' => '/App',
        '__API__' => '/Api'
    ),

    // 数据库连接
    'DB_TYPE'   => 'mysql',
    'DB_HOST'   => 'localhost',
    'DB_NAME'   => 'cwaiygfo_itshajia',
    'DB_USER'   => 'cwaiygfo_uioweb',
    'DB_PWD'    => 'xing84304578',
    'DB_PORT'   => '3306',
    'DB_PREFIX' => 'uio_',

    // 分组模式
    /*'APP_GROUP_LIST' => 'Home,Admin',
    'DEFAULT_GROUP' => 'Home',*/

    // 后台开发模式
    'ADMIN_DEVELOP' => true

);
?>