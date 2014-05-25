<?php
class InterfaceAction extends Action{

    // 消息回复
    public function index() {
        global $uid,$openid,$reply_thumb,$reply_desc;

        // 导入 “微信第三方”接口文件
        import('ORG.Util.Wx');
        import('ORG.Util.WxConfig');

        // 实例化
        $wechatToolObj = new WechatTools( 4 );
        $wechatOptions = array(
            'token'=> 'weixin',
            'account'=> 'IT_shajia',
            'password'=> 'xing84304578',
            "wechattool"=> $wechatToolObj
        );

        $wechatObj = new Wechat($wechatOptions);
        $wechatObj->valid();
        //$wechatObj->setAutoSendOpenidSwitch(TRUE);
        //$wechatObj->setPassiveAscSwitch(TRUE, TRUE);
        //$wechatObj->getRev();
        //$revtype = $wechatObj->getRev()->getRevType();
        //$_openid = $wechatObj->getRevFrom();
        $wechatObj->text("121221")->reply();


        /*switch($revtype) {

            case Wechat::MSGTYPE_TEXT:
                $wechatObj->text("121221")->reply();
                break;
        }*/

    }



}

?>