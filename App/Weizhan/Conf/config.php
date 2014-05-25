<?php
$arr2 = array(
    // 分组模式
    'APP_GROUP_LIST' => 'Home,User',
    'DEFAULT_GROUP' => 'Home',
);

$arr1 = require dirname(dirname(dirname(dirname(__FILE__)))).'/config.php';

return $arr1 + $arr2;
?>