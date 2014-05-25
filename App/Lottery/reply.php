<?php
/**
 * 消息图文回复
 * @param $text
 * @param $web_url 站点url
 * @return array
 */
function reply( $text, $web_url, $lot_id ) {
    global $uid, $openid,$reply_thumb,$reply_desc;

    $reply_thumb = $reply_thumb ? $reply_thumb : $web_url."/App/Lottery/Images/reply.jpg";
    $reply_desc = $reply_desc ? $reply_desc : "活动抽奖";
    $reply_url = $web_url.'/App/Lottery/index.php?uid='.$uid.'&lot_id='.$lot_id.'&openid='.$openid;

    return array(
        array(
            'Title' => '活动抽奖',
            'Description' => $reply_desc,
            'Url' => $reply_url,
            'PicUrl' => $reply_thumb
        )
    );
}
?>