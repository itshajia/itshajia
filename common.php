<?php
/**
 * @author itshajia <itshajia@gmail.com>
 * @package Common
 */


/**
 * Url地址前补上 站点 WEB_URL
 * @param string $url 可能缺少头部的URL
 * @return string
 */
function urlWithWebUrl( $url='' ) {
    return C('WEB_URL').$url;
}

/**
 * 获取格式化的时间
 * @param string $str 日期的时间戳
 * @return string
 */
function format_time( $str ) {
    echo date("Y-m-d H:i:s",$str);
}
function format_date( $str ) {
    echo date("Y-m-d",$str);
}

/**
 * 生成 Page
 * @param int $total 数据总数
 * @param int $page 当前页数
 * @param int $pagesize 每页获取数据的条数
 * @appname int
 * @return DOM
 */
function page( $total, $page, $pagesize, $appname=0 ) {


    $last = ceil($total / $pagesize);
    $page = ( empty($page) || $page>$last ) ? '1' : $page;

    // 计算出 prev 和 next
    if ( $page > 1 ) {
        $prev = array(
            'is_able' => 1,
            'page' => $page - 1
        );
    } else {
        $prev = array(
            'is_able' => 0
        );
    }

    if ( $page < $last ) {
        $next = array(
            'is_able' => 1,
            'page' => $page + 1
        );
    } else {
        $next = array(
            'is_able' => 0
        );
    }

    // 过滤 page 参数
    if( $appname ) {
        //$url = "/".APP_NAME.'/'.$mod.'/'.$act;
        $url = __APP__."?m=".MODULE_NAME."&a=".ACTION_NAME;
    } else {
        //$url = '/'.$mod.'/'.$act;
        $url = "?g=".GROUP_NAME."&m=".MODULE_NAME."&a=".ACTION_NAME;
    }

    foreach( $_GET as $k => $v ) {
        if( $k!='page' && $k!='_URL_' ) {
            $url .= '&'.$k.'='.$v;
        }
    }



    $pageHtml = "";
    $pageHtml .= "<div class='page'>";
    $pageHtml .= "<span class='page_panel'>";
    $pageHtml .= "<span class='page_item'>";


    if ( $prev['is_able'] ) {
        $pageHtml .= "<a href='".$url."&page=".$prev['page']."' class='prev'>Prev</a>";
    } else {
        $pageHtml .= "<a href='javascript:;' class='prev unable'>Prev</a>";
    }

    if ( $last>10 ) {

        for ( $i=0; $i<2; $i++ ) {
            if( $page == $i+1 ) {
                $pageHtml .= "<a href='javascript:;' class='on'>".( $i+1 )."</a>";
            } else {
                $pageHtml .= "<a href='".$url."&page=".( $i+1 )."'>".( $i+1 )."</a>";
            }
        }

        $pageHtml .= "<a class='dot'>...</a>";

        $page_center_first = (( $page - 3) > 2) ? $page -3 : 2;

        if( ($page_center_first+5) < $last - 2 ) {
            $page_center_last = $page_center_first+5;
        } else {
            $page_center_last = $last - 2;
            $page_center_first = $last - 7;
        }

        for ( $i=$page_center_first; $i<$page_center_last; $i++ ) {
            if( $page == $i+1 ) {
                $pageHtml .= "<a href='javascript:;' class='on'>".( $i+1 )."</a>";
            } else {
                $pageHtml .= "<a href='".$url."&page=".( $i+1 )."'>".( $i+1 )."</a>";
            }
        }

        $pageHtml .= "<a class='dot'>...</a>";

        for ( $i= $last-2; $i<$last; $i++ ) {

            if( $page == $i+1 ) {
                $pageHtml .= "<a href='javascript:;' class='on'>".( $i+1 )."</a>";
            } else {
                $pageHtml .= "<a href='".$url."&page=".( $i+1 )."'>".( $i+1 )."</a>";
            }
        }


    } else {

        for ( $i=0; $i<$last; $i++ ) {

            if( $page == $i+1 ) {
                $pageHtml .= "<a href='javascript:;' class='on'>".( $i+1 )."</a>";
            } else {
                $pageHtml .= "<a href='".$url."&page=".( $i+1 )."'>".( $i+1 )."</a>";
            }


        }

    }



    if ( $next['is_able'] ) {
        $pageHtml .= "<a href='".$url."&page=".$next['page']."' class='next'>Next</a>";
    } else {
        $pageHtml .= "<a href='javascript:;' class='next unable'>Next</a>";
    }
    $pageHtml .= "</span>";
    $pageHtml .= "<span class='page_info'>";
    $pageHtml .= "共".$total."条/".$last."页";
    $pageHtml .= "</span>";
    $pageHtml .= "<span class='page_go'>";
    $pageHtml .= "到第<input id='page_val' class='page_val' />页";
    $pageHtml .= "<button class='page_go_btn' onclick='page();'>跳转</button>";
    $pageHtml .= "<input type='hidden' id='urlnopage' value='".appUrl(getUrlNoPage())."' />";
    $pageHtml .= "</span>";
    $pageHtml .= "</span>";
    $pageHtml .= "</div>";

    return $pageHtml;
}


/**
 * 去除url中的page参数
 * @return string
 */
function getUrlNoPage() {
    // 过滤 page 参数
    $url = "m=".MODULE_NAME."&a=".ACTION_NAME;

    foreach( $_GET as $k => $v ) {
        if( $k!='page' && $k!='_URL_' ) {
            $url .= '&'.$k.'='.$v;
        }
    }
    return $url;
}

/**
 * $map对象键名添加 “表前缀”
 * @param array $map 数组map
 * @prefix string $prefix 添加的表前缀
 * @return array
 */
function setMapPrefix( $map, $prefix ) {
    $newMap = array();
    foreach( $map as $k => $v ) {
        $newMap[$prefix.'.'.$k] = $v;
    }
    return $newMap;
}

/**
 * 循环删除目录 和 文件
 * @param string $dirName 目录名称
 * @return boolean
 */
function delDirAndFile($dirName){
    if($handle = opendir("$dirName")){
        while(false!==($item = readdir($handle))){
            if($item != "." && $item != ".." ){
                if(is_dir("$dirName/$item")){
                    delDirAndFile("$dirName/$item" );
                }else{
                    if(unlink("$dirName/$item")) {
                    } else {
                        return false;
                    }
                }
            }
        }
        closedir( $handle );
        if( rmdir( $dirName ) ) {
            return true;
        }
    }
}

/**
 * 字符串截取
 * @param string $string 截取的字符串
 * @param int $sublen 截取的长度
 * @param int $start 截取初始位置
 * @param string $code 字符串编码
 * @return string
 */
function cut_str($string, $sublen, $start = 0, $code = 'UTF-8'){

    if($code == 'UTF-8'){
        $pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
        preg_match_all($pa, $string, $t_string);

        if(count($t_string[0]) - $start > $sublen) return join('', array_slice($t_string[0], $start, $sublen))."...";
        return join('', array_slice($t_string[0], $start, $sublen));
    }else{
        $start = $start*2;
        $sublen = $sublen*2;
        $strlen = strlen($string);
        $tmpstr = '';

        for($i=0; $i< $strlen; $i++){
            if($i>=$start && $i< ($start+$sublen)){

                if(ord(substr($string, $i, 1))>129){
                    $tmpstr.= substr($string, $i, 2);
                }else{
                    $tmpstr.= substr($string, $i, 1);
                }
            }
            if(ord(substr($string, $i, 1))>129) $i++;
        }
        if(strlen($tmpstr)< $strlen ) $tmpstr.= "...";
        return $tmpstr;
    }
}


/**
 * 文件“上传” 和 “获取”时，将url转化为文件的物理地址
 * @param string $url 文件的url地址
 * @param string $appUrl url中被替换的部分
 * @return string
 */
function url2root( $url, $appUrl ) {
    $root = $_SERVER['DOCUMENT_ROOT'];
    $url = str_replace($appUrl, $root, $url);

    return $url;
}

/**
 * 无限分类结构排版中，层级符号的数量输出
 * @param int $count 符号需要循环的次数
 * @param string $tag 循环符号
 * @param string $startTag 循环符号的起始符号
 * @return string
 */
function UnlimitTagEcho( $count=0, $tag="--", $startTag='|' ) {
    if ( $count==0 ) return;
    $str = $startTag;
    for( $i=0;$i<$count;$i++ ) {
        $str .= $tag;
    }

    return $str;
}

/**
 * 字符串分组，并去除数组空元素
 * @param string $str 需要分割的字符串
 * @param string $tag 分割符号
 * @return array
 */
function str2Arr( $str, $tag=',' ) {
    $newArr = array();
    if ( $str ) {
        $newArr = explode( $tag, $str );
        $newArr = array_filter($newArr);
    }

    return $newArr;
}

/**
 * https_post
 * @return
 */
function https_post($url, $data = null){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    if (!empty($data)){
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}

/**
 * https_get
 * @return
 */
function https_get($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}


?>