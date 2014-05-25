<?php
/**
 * 消息图文回复
 * @param $text
 * @param $web_url 站点url
 * @return array
 */
function reply( $text, $web_url, $wed_id ) {
    global $uid, $openid,$reply_thumb,$reply_desc;

    $reply_thumb = $reply_thumb ? $reply_thumb : $web_url."/App/Wedding/Images/reply.jpg";
    $reply_desc = $reply_desc ? $reply_desc : "微婚庆";
    $reply_url = $web_url.'/App/Wedding/index.php?uid='.$uid.'&wed_id='.$wed_id.'&openid='.$openid;

    return array(
        array(
            'Title' => '微婚庆',
            'Description' => $reply_desc,
            'Url' => $reply_url,
            'PicUrl' => $reply_thumb
        )
    );
}
?>