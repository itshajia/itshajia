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
        return "使用方法: \n机器人+空格+聊天内容 ";
    }
    $url = "http://www.xiaojo.com/api5.php";
    $post="chat={$text}&db=qiekenao&pw=123456";
    $ch = curl_init();//初始化curl
    curl_setopt($ch,CURLOPT_URL,$url);//抓取指定网页
    curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
    curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    $data = curl_exec($ch);//运行curl
    curl_close($ch);
    $data = urldecode($data);
    return $data;
}


?>