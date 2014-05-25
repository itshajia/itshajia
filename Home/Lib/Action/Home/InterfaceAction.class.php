<?php
class InterfaceAction extends CommonAction{

    // 消息回复
    public function index() {

        // 用户信息获取
        $User = D('User');
        $username = $_GET['u'];
        $map['username'] = $username;
        $user = $User->where($map)->find();

        // 导入 “微信第三方”接口文件
        import('ORG.Util.WxConfig');
        import('ORG.Util.Wx');

        // 实例化
        $wechatToolObj = new WechatTools( $user['uid'] );
        $wechatOptions = array(
            'token'=>'weixin',
            'account'=>'',
            'password'=>'',
            "wechattool"=>$wechatToolObj
        );

        $wechatOptions['account'] = $user['wxnumber'];
        $wechatOptions['password'] = $user['wxpassword'];
        $wechatObj = new Wechat($wechatOptions);
        $wechatObj->valid();
        //$wechatObj->setAutoSendOpenidSwitch(TRUE);
        //$wechatObj->setPassiveAscSwitch(TRUE, TRUE);
        $wechatObj->getRev();
        $revtype = $wechatObj->getRev()->getRevType();
        $_openid = $wechatObj->getRevFrom();


        switch($revtype) {
            //文本消息
            case Wechat::MSGTYPE_TEXT:
                $revText = $wechatObj->getRevContent();
                include WEB_ROOT.'/interface/text_reply.php';
                break;

            //关注,取消关注 事件
            case Wechat::MSGTYPE_EVENT:
                $revEvent = array();
                $revEvent = $wechatObj->getRevEvent();
                $wechatObj->positiveInit();
                include WEB_ROOT.'/interface/event_reply.php';
                break;


            //图片
            case Wechat::MSGTYPE_IMAGE:
                break;

            //位置
            case Wechat::MSGTYPE_LOCATION:
                $revGeo = $wechatObj->getRevGeo();
                if ($revGeo) {
                    $wechatObj->text("您的位置信息是：X=".$revGeo['x'].",Y=".$revGeo['y']."\n".$revGeo['label'])->reply();
                }
                break;

            //声音
            case Wechat::MSGTYPE_VOICE:
                /* //多媒体消息关联获取id，并下载文件到服务器本地示例
                $oneMessage = $wechatObj->getOneMessage($wechatObj->getRevCtime(), $wechatObj->getRevType(),$wechatObj->getRevFrom());
                $mediaFile = array();
                if ($oneMessage) {
                    $mediaFile = $wechatObj->getDownloadFile($oneMessage["id"]);
                }
                // 		$wechatObj->text(serialize($mediaFile))->reply();
                $wechatObj->text($oneMessage?"消息id:$oneMessage[id]\n类型:$oneMessage[type]\nLO时间戳:".$wechatObj->getRevCtime()."\nMP时间戳:$oneMessage[dateTime]\n文件路径:$mediaFile[filename]\n文件大小:$mediaFile[filesize]\n文件类型:$mediaFile[filetype]":"获取失败\nLO时间戳:".$wechatObj->getRevCtime().print_r($oneMessage, TRUE))->reply(); */
                break;

            //其他
            default:
                $wechatObj->text("help info")->reply();
        }

    }



}

?>