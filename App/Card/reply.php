<?php
/**
 * 消息图文回复
 * @param $text
 * @param $web_url 站点url
 * @return array
 */
function reply( $text, $web_url ) {
    global $uid, $openid,$reply_thumb,$reply_desc;

    $reply_thumb = $reply_thumb ? $reply_thumb : $web_url."/App/Card/Images/reply.jpg";
    $reply_desc = $reply_desc ? $reply_desc : "会员卡";
    $reply_url = $web_url.'/App/Card/index.php?uid='.$uid.'&openid='.$openid;

    return array(
        array(
            'Title' => '会员卡',
            'Description' => $reply_desc,
            'Url' => $reply_url,
            'PicUrl' => $reply_thumb
        )
    );
}
?>