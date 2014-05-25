<?php
/**
 * 消息图文回复
 * @param $text
 * @param $web_url 站点url
 * @return array
 */


function reply( $text ) {
    global $uid, $openid;

    if(empty($text)){
        return "使用方法: \n 快递+空格+快递编号+:+快递单号 \n 快递编号:(:为英文输入法状态下:) \n a:顺丰快递  b:申通快递  c:圆通快递\n d:EMS  e:中通快递  f:韵达快递 \n g:汇通快递  h:宅急送  i:中邮物流 \n 例：快递 a:123456";
    }

    $option = array(
        'a'=>'shunfeng',
        'b'=>'shentong',
        'c'=>'yuantong',
        'd'=>'ems',
        'e'=>'zhongtong',
        'f'=>'yunda',
        'g'=>'huitongkuaidi',
        'h'=>'zhaijisong',
        'i'=>'zhongyouwuliu',
    );
    $strArray = explode(':',$text);
    $key = strtolower($strArray[0]);
    $url = "http://wap.kuaidi100.com/wap_result.jsp?rand=48729&id={$option[$key]}&fromWeb=null&postid={$strArray[1]}&sub=%E6%9F%A5%E8%AF%A2";
    $re_text = file_get_contents($url);

    if(stripos($re_text,'单号不正确')===false){
        $re_text = strip_tags($re_text);
        $start = stripos($re_text,'&middot;');
        $start = $start + 8;
        $end = stripos($re_text,'(AD)');
        $re_text = substr($re_text,$start,$end-$start);
        $re_text = trim($re_text);
        $re_text = str_replace('&middot;',"\n",$re_text);
    } else {
        $re_text = '未查询到信息,可能单号输入错误,请查证';
    }

    return $re_text;
}


?>