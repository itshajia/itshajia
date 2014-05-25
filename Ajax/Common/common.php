<?php

require dirname(dirname(dirname(__FILE__))).'/common.php';

/**
 * 转换TP原有的url为适应本项目的url
 */
function appUrl($param='') {
    $param = $param ? '?'.$param : $param;
    return C('WEB_URL').''.__APP__.$param;
}


?>