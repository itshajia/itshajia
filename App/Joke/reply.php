<?php
/**
 * 消息图文回复
 * @param $text
 * @param $web_url 站点url
 * @return array
 */
function reply( $text ) {
    global $uid, $openid;

    $url = "http://apix.sinaapp.com/joke/?appkey=trialuser";
    $result = file_get_contents($url);
    $result = substr($result, 0, strpos($result, '\n', 0));
    return $result;
}


?>