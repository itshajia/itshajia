<?php
/**
 * 消息图文回复
 * @param $text
 * @param $web_url 站点url
 * @return array
 */
function reply( $text, $web_url ) {
    global $uid, $openid,$reply_thumb,$reply_desc;

    $reply_thumb = $reply_thumb ? $reply_thumb : $web_url."/App/Weizhan/Images/reply.jpg";
    $reply_desc = $reply_desc ? $reply_desc : "将企业微餐饮植入微信公众平台关注公众平台即可访问网站";
    $reply_url = $web_url.'/App/Weizhan/index.php?uid='.$uid.'&openid='.$openid;

    return array(
        array(
            'Title' => '微站',
            'Description' => $reply_desc,
            'Url' => $reply_url,
            'PicUrl' => $reply_thumb
        )
    );
}
?>