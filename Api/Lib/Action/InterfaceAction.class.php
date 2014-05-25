<?php
class InterfaceAction extends Action{

    // 消息回复
    public function index() {
        global $wechatObj,$uid,$openid,$reply_thumb,$reply_desc;
        //$appPath = "Weizhan";
        //require C('WEB_ROOT')."/App/".$appPath."/reply.php";

        // 用户信息获取
        $AppApply = M('AppApply');
        $App = M('App');
        $User = M('User');
        $UserInfo = M('UserInfo');
        $username = $_GET['u'];
        $map['username'] = $username;
        $user = $User->where($map)->find();
        $uid = $user['uid'];
        $userInfo = $UserInfo->where(array('uid'=> $uid))->find();
        $user['wxnumber'] = $userInfo['wxnumber'];
        $user['wxpassword'] = $userInfo['wxpassword'];
        //var_dump($user);

        // 导入 “微信第三方”接口文件
        import('ORG.Util.Wx');
        import('ORG.Util.WxConfig');

        // 实例化
        $wechatToolObj = new WechatTools( $user['uid'] );
        $wechatOptions = array(
            'token'=> 'weixin',
            'account'=> $user['wxnumber'],
            'password'=> $user['wxpassword'],
            "wechattool"=>$wechatToolObj
        );

        $wechatObj = new Wechat($wechatOptions);
        $wechatObj->valid();

        //$wechatObj->setAutoSendOpenidSwitch(TRUE);
        //$wechatObj->setPassiveAscSwitch(TRUE, TRUE);
        $wechatObj->getRev();
        $revtype = $wechatObj->getRev()->getRevType();
        $openid = $wechatObj->getRevFrom();

        //exit();
        switch($revtype) {
            //文本消息
            case Wechat::MSGTYPE_TEXT:
                $revText = $wechatObj->getRevContent();

                // 根据 “文本消息”检索出对应的应用
                $revArray = explode(' ',$revText);
                $appPath = '';


                //检索是否为用户设置的个性回复
                $map = array();
                $map['uid'] = $user['uid'];
                $map['keywords'] = $revArray[0] ? $revArray[0] : '';
                $apply = $AppApply->where( $map )->find();

                if ( $apply ) {

                    $reply_thumb = $apply['keywordpic'];
                    $reply_desc = $apply['keyworddesc'];

                    $app = $App->where(array('app_id'=> $apply['app_id']))->find();
                    $appPath = $app['app_ename'];
                } else {
                    $map['keywords'] = $revArray[0];
                    $app = $App->where( $map )->find();

                    if ( !empty($app) ) {
                        $appPath = $app['app_ename'];
                        $map = array();
                        $map['app_id'] = $app['app_id'];
                        $map['uid'] = $user['uid'];
                        $apply = $AppApply->where($map)->find();

                        if ( empty( $apply ) ) {
                            $wechatObj->text("您未启用该应用，请核实！")->reply();
                            exit();
                        }
                    }
                }

                // 匹配应用回复
                if ( !empty($appPath) ) {
                    require C('WEB_ROOT')."/App/".$appPath."/reply.php";
                    /*$wechatObj->text( C('WEB_ROOT')."/App/".$appPath."/reply.php" )->reply();
                    exit();*/
                    $replyMsg = reply( $revArray[1] , C('WEB_URL'));

                    if ( is_array( $replyMsg) ) {
                        $wechatObj->news( $replyMsg )->reply();
                    } else{
                        $wechatObj->text( $replyMsg )->reply();
                    }
                    exit();
                }

                // 匹配“消息回复文本”
                $Reply = M('Reply');

                $map = array();
                $map['uid'] = $uid;
                $map['keyword'] = $revText;
                //$wechatObj->text( $revText )->reply();
                $reply = $Reply->where($map)->find();

                if ( $reply ) {
                    return $this->msgReply( $reply );
                } else {

                    // 文本消息记录,存表
                    $data = array();
                    $data['content'] = trim($wechatObj->getRevContent());
                    if(!empty($data['content']))
                    {
                        $Msg = M('Msg');
                        $data['uid'] = $user['uid'];
                        $data['openid'] = $openid;
                        $data['senddate'] = date('Y-m-d',time());
                        $data['addtime'] = time();
                        $data['adddate'] = strtotime(date('Y-m-d',time()));
                        $data['status'] = 0;
                        $Msg->add( $data );
                    }

                    // 无匹配文本回复
                    $ReplyMsg = M('ReplyMsg');
                    $map = array();
                    $map['uid'] = $uid;
                    $replyMsg = $ReplyMsg->where($map)->find();

                    $map['reply_id'] = $replyMsg['nomsg_id'];
                    $noReply = $Reply->where($map)->find();

                    if ( $noReply ) {
                        return $this->msgReply( $noReply );
                    } else {
                        $wechatObj->text('抱歉,暂时没有您所需要的信息！')->reply();
                    }



                }


                break;

            //关注,取消关注 事件
            case Wechat::MSGTYPE_EVENT:
                $revEvent = array();
                $revEvent = $wechatObj->getRevEvent();
                $wechatObj->positiveInit();
                $map['uid'] = $user['uid'];

                // 事件回复
                switch( $revEvent['event'] ) {
                    // "关注事件"
                    case "subscribe":
                        $ReplyMsg = M('ReplyMsg');
                        $Reply = M('Reply');

                        if ( !$revEvent['key'] ) {
                            $replyMsg = $ReplyMsg->where($map)->find();
                            $map['reply_id'] = $replyMsg['subscribe_id'];
                            $reply = $Reply->where($map)->find();

                            if ( $reply ) {
                                $this->msgReply( $reply );
                            }

                        } else {
                            // 场景关注
                            $this->sceneReply( $revEvent['key'] );
                        }

                        // 关注用户（数据添加）
                        ob_flush();
                        flush();
                        $data = array();
                        $data['uid'] = $user['uid'];
                        $data['openid'] = $openid;
                        $data['addtime'] = time();
                        $data['s_date'] = date('Y-m-d', time());
                        $SubscribeUser = M('SubscribeUser');
                        // 关注前，先删除小概率存留的用户信息
                        $map = array();
                        $map['uid'] = $user['uid'];
                        $map['openid'] = $openid;
                        $SubscribeUser->where($map)->delete();
                        $SubscribeUser->add($data);

                        /**
                         * 获取用户基本信息（用户基本信息，属于高级接口，只有服务号，才可以调用）
                         */
                        $UserInfo = M('UserInfo');
                        $map = array();
                        $map['uid'] = $user['uid'];
                        $obj = $UserInfo->where($map)->find();
                        $appId = $obj['appId'];
                        $appSecret = $obj['appSecret'];

                        /**
                         * 获取 ticket Start
                         */
                        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appId."&secret=".$appSecret;
                        $result = https_get($url);
                        $jsoninfo = json_decode($result, true);
                        $access_token = $jsoninfo['access_token'];

                        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
                        $result = https_get($url);
                        $jsoninfo = json_decode($result, true);

                        $data = array();
                        $data['nickname'] = $jsoninfo['nickname'];
                        $data['sex'] = $jsoninfo['sex'];
                        $data['language'] = $jsoninfo['language'];
                        $data['city'] = $jsoninfo['city'];
                        $data['province'] = $jsoninfo['province'];
                        $data['country'] = $jsoninfo['country'];
                        $data['headimgurl'] = $jsoninfo['headimgurl'];
                        $SubscribeUser->where(array('openid'=> $openid))->save($data);

                        break;

                    // "取消关注"
                    case "unsubscribe":

                        $map = array();
                        $map['openid'] = $openid;
                        $map['uid'] = $user['uid'];
                        $SubscribeUser = M('SubscribeUser');
                        $SubscribeUser->where($map)->delete();
                        break;

                    // "点击事件"
                    case "CLICK":

                        break;

                    // "二维码扫描事件"
                    case "SCAN":
                        return $this->sceneReply( $revEvent['key'] );
                        break;

                    // 获取用户地理坐标事件
                    case 'LOCATION':
                        $GlobalLocation = M('GlobalLocation');

                        $revLoc = $wechatObj->getLocation();
                        $map = array();
                        $map['openid'] = $openid;
                        $map['uid'] = $user['uid'];

                        $data = array();
                        $data['openid'] = $openid;
                        $data['userid'] = $user['uid'];
                        $data['x'] = $revLoc['x'];
                        $data['y'] = $revLoc['y'];
                        $data['precision'] = $revLoc['precision'];

                        $pos = $GlobalLocation->where($map)->find();

                        if ( $pos ) {
                            $GlobalLocation->where( $map )->save( $data );
                        } else {
                            $GlobalLocation->add( $data );
                        }
                        break;

                }
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
                break;

            //其他
            default:
                $wechatObj->text("help info")->reply();
        }

    }

    // 场景文本回复
    private function sceneReply ( $revEventKey ) {
        global $wechatObj,$uid;

        $str = strval( $revEventKey );
        $sceneId = substr($str, 0, 1);
        $dataId = substr($str, 1);

        switch ( $sceneId ) {
            case "1":
                require C('WEB_ROOT')."/App/Wedding/reply.php";
                $replyMsg = reply( 'zx' , C('WEB_URL'), $dataId);

                if ( is_array( $replyMsg) ) {
                    $wechatObj->news( $replyMsg )->reply();
                } else{
                    $wechatObj->text( $replyMsg )->reply();
                }
                exit();
                break;

            case "2":
                require C('WEB_ROOT')."/App/Lottery/reply.php";
                $replyMsg = reply( 'zx' , C('WEB_URL'), $dataId);

                if ( is_array( $replyMsg) ) {
                    $wechatObj->news( $replyMsg )->reply();
                } else{
                    $wechatObj->text( $replyMsg )->reply();
                }
                exit();
                break;
        }

    }

    // 消息文本回复
    private function msgReply ( $reply ) {
        global $wechatObj,$uid;

        if ( $reply['reply_type']==1 ) {
            // 图文信息
            $ReplyArr = array();
            $ReplyImg = M('ReplyImg');
            $map['uid'] = $uid;
            $map['reply_id'] = $reply['reply_id'];
            $map['is_first'] = 1;
            $first = $ReplyImg->where($map)->find();
            array_push($ReplyArr, array(
                'Title' => $first['title'],
                'PicUrl' => $first['image'],
                'Url' => $first['url']
            ));

            $map['is_first'] = 0;
            $other = $ReplyImg->order(array('sort'))->where($map)->select();
            foreach( $other as $k=>$v) {
                array_push($ReplyArr, array(
                    'Title' => $v['title'],
                    'PicUrl' => $v['image'],
                    'Url' => $v['url']
                ));
            }

            $wechatObj->news($ReplyArr)->reply();
        } else {
            // 文本信息
            $wechatObj->text($reply['reply'])->reply();
        }
    }



}

?>