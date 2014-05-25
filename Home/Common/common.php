<?php

require dirname(dirname(dirname(__FILE__))).'/common.php';

/**
 * 转换TP原有的url为适应本项目的url
 */
function appUrl( $param='' ) {
    $param = $param ? '&'.$param : $param;
    return C('WEB_URL').''.__APP__.'?g='.GROUP_NAME.$param;
}

/**
 * App 入口地址转换
 */
function appGoUrl( $app_name ) {
    return C('WEB_URL').'/App/'.$app_name.__APP__.'?g=User';
}

?>