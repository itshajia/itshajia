<?php
class IndexAction extends CommonAction{
    public function _empty() {
        $this->lottery();
    }

    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 活动管理
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
    public function lottery() {
        $AppLottery = D('Common://AppLottery');
        $view = $_GET['view'] ? $_GET['view'] : 'list';

        switch( $view ) {
            case "add":
                if ( $_POST['submit'] ) {
                    if ( !$AppLottery->create() ) return;

                    $AppLottery->is_open = $_POST['is_open'] ? 1 : 0;
                    if ( $AppLottery->wed_id ) {

                        if ( $AppLottery->save() ) {
                            $this->success('数据保存成功！', appUrl('m=Index&a=lottery'));
                            return;
                        }
                        $this->error('数据保存成功！');
                    } else {
                        $AppLottery->uid = $_SESSION['_User']['uid'];
                        $AppLottery->addtime = time();

                        if ( $AppLottery->add() ) {
                            $this->success('数据添加成功！', appUrl('m=Index&a=lottery&view=add'));
                            return;
                        }
                        $this->error('数据添加失败！');
                    }
                    return;
                }

                if ( $_GET['lot_id'] ) {
                    $map['lot_id'] = $_GET['lot_id'];
                    $map['uid'] = $_SESSION['_User']['uid'];
                    $obj = $AppLottery->where($map)->find();
                    $this->assign('obj', $obj);
                }

                $this->display('lot_add');
                break;

            case "list":
                if ( $_POST['submit'] ) {
                    $tool = $_POST['tool'];
                    $ids = $_POST['id'];

                    if ( !count($ids) ) $this->error('请选择要操作的选项！');
                    switch( $tool ) {
                        case "delAll":
                            foreach( $ids as $k=>$v ) {
                                $map['lot_id'] = $k;
                                $map['uid'] = $_SESSION['_User']['uid'];
                                $AppLottery->where($map)->delete();
                            }
                            $this->success('数据删除成功！', appUrl('m=Index&a=lottery'));
                            break;
                    }
                    return;
                }

                $page = $_GET['page'] ? $_GET['page'] : 1;
                $pagesize = 10;
                $pageset = ( $page -1) * $pagesize;
                $limit = array('page'=> $pageset, 'pagesize'=> $pagesize);

                $map['uid'] = $_SESSION['_User']['uid'];
                $list = $AppLottery->getList( $map, $limit );
                $this->assign( 'list', $list );

                $pageHtml = page( $AppLottery->getCount($map), $page, $pagesize );
                $this->assign('pageHtml', $pageHtml);

                $this->display('lot_list');
                break;

            case "del":
                if( $_GET['lot_id'] ) {
                    $map['lot_id'] = $_GET['lot_id'];
                    $map['uid'] = $_SESSION['_User']['uid'];
                    $AppLottery->where($map)->delete();
                    $this->success('数据删除成功！', appUrl('m=Index&a=lottery') );
                    return;
                }
                $this->error('访问地址不正确！');
                break;
        }
    }

    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 基本信息
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
    public function prize() {
        $Prize = D('Common://AppLotteryPrize');
        $view = $_GET['view'] ? $_GET['view'] : 'list';

        switch ( $view ) {
            case "add":
                if ( $_POST['submit'] ) {
                    if ( !$Prize->create() ) return;

                    if ( $Prize->prize_id ) {

                        if ( $Prize->save() ) {
                            $this->success('数据保存成功！', appUrl('m=Index&a=prize&enter=1&lot_id='.$_POST['lot_id']));
                            return;
                        }
                        $this->error('数据保存成功！');
                    } else {
                        $Prize->uid = $_SESSION['_User']['uid'];
                        $Prize->addtime = time();

                        if ( $Prize->add() ) {
                            $this->success('数据添加成功！', appUrl('m=Index&a=prize&view=add&enter=1&lot_id='.$_POST['lot_id']));
                            return;
                        }
                        $this->error('数据添加失败！');
                    }
                    return;
                }

                if ( $_GET['prize_id'] ) {
                    $map['prize_id'] = $_GET['prize_id'];
                    $map['uid'] = $_SESSION['_User']['uid'];
                    $obj = $Prize->where($map)->find();
                    $this->assign('obj', $obj);
                }

                $this->display('prize_add');
                break;

            case "list":
                if ( $_POST['submit'] ) {
                    $tool = $_POST['tool'];
                    $ids = $_POST['id'];

                    if ( !count($ids) ) $this->error('请选择要操作的选项！');
                    switch( $tool ) {
                        case "delAll":
                            foreach( $ids as $k=>$v ) {
                                $map['lot_id'] = $k;
                                $map['uid'] = $_SESSION['_User']['uid'];
                                $Prize->where($map)->delete();
                            }
                            $this->success('数据删除成功！', appUrl('m=Index&a=prize&enter=1&lot_id='.$_POST['lot_id']));
                            break;
                    }
                    return;
                }

                $page = $_GET['page'] ? $_GET['page'] : 1;
                $pagesize = 10;
                $pageset = ( $page -1) * $pagesize;
                $limit = array('page'=> $pageset, 'pagesize'=> $pagesize);

                $map['uid'] = $_SESSION['_User']['uid'];
                $map['lot_id'] = $_GET['lot_id'];
                $list = $Prize->getList( $map, $limit );
                $this->assign( 'list', $list );

                $pageHtml = page( $Prize->getCount($map), $page, $pagesize );
                $this->assign('pageHtml', $pageHtml);

                $this->display('prize_list');
                break;

            case "del":
                if( $_GET['prize_id'] ) {
                    $map['prize_id'] = $_GET['prize_id'];
                    $map['uid'] = $_SESSION['_User']['uid'];
                    $Prize->where($map)->delete();
                    $this->success('数据删除成功！', appUrl('m=Index&a=prize&enter=1&lot_id='.$_GET['lot_id']) );
                    return;
                }
                $this->error('访问地址不正确！');
                break;
        }
    }

    public function entrance() {
        $Prize = D('Common://AppLotteryPrize');
        $LotteryUser = D('Common://AppLotteryUser');

        if ( $_POST['submit'] ) {
            return;
        }

        $map['uid'] = $_SESSION['_User']['uid'];
        $map['lot_id'] = $_GET['lot_id'];
        $list = $Prize->order(array('sort'))->where($map)->select();

        foreach( $list as $i=>$v ) {
            $map = array();
            $list[$i]['url'] = C('WEB_URL').'/App/Lottery/index.php?g=Home&m=Index&a=prize&uid='.$_SESSION['_User']['uid'].'&lot_id='.$_GET['lot_id'].'&prize_id='.$v['prize_id'];
            $map['lot_id'] = $_GET['lot_id'];
            $map['prize_id'] = $v['prize_id'];
            $list[$i]['remain'] = $v['amount'] - $LotteryUser->getCount($map);
        }
        $this->assign('list', $list);


        $this->display('entrance');
    }

    public function screen() {
        if ( $_POST['submit'] ) {
            return;
        }
        $url = C('WEB_URL').'/App/Lottery/index.php?g=Home&m=Index&a=screen&uid='.$_SESSION['_User']['uid'].'&lot_id='.$_GET['lot_id'];
        $this->assign('url', $url);
        $this->display('screen');
    }

    public function erwm() {
        if ( $_POST['submit'] ) {
            return;
        }
        $UserInfo = M('UserInfo');
        $map = array();
        $map['uid'] = $_SESSION['_User']['uid'];
        $obj = $UserInfo->where($map)->find();
        $this->assign('obj', $obj);
        $appId = $obj['appId'];
        $appSecret = $obj['appSecret'];
        //var_dump($minfo);

        /**
         * 获取 ticket Start
         */
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appId."&secret=".$appSecret;
        //echo $url;
        $result = https_get($url);
        $jsoninfo = json_decode($result, true);
        //var_dump($jsoninfo);
        $access_token = $jsoninfo['access_token'];

        //永久
        $qrcode = '{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": 2'.$_GET['lot_id'].'}}}';
        $url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=$access_token";
        $result = https_post($url,$qrcode);
        $jsoninfo = json_decode($result, true);
        $ticket = $jsoninfo["ticket"];


        /**
         * 获取 ticket End
         */
        $url = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".urlencode($ticket);
        $this->assign('url', $url);
        $this->display('erwm');
    }

    public function preview() {
        if ( $_POST['submit'] ) {
            return;
        }
        $this->display('preview');
    }

    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 数据管理
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
    public function signUp() {
        $LotteryUser = D('Common://AppLotteryUser');
        if ( $_POST['submit'] ) {
            return;
        }

        $page = $_GET['page'] ? $_GET['page'] : 1;
        $pagesize = 10;
        $pageset = ( $page -1) * $pagesize;
        $limit = array('page'=> $pageset, 'pagesize'=> $pagesize);

        $map['uid'] = $_SESSION['_User']['uid'];
        $map['lot_id'] = $_GET['lot_id'];
        $list = $LotteryUser->getList( $map, $limit );
        $this->assign( 'list', $list );

        $pageHtml = page( $LotteryUser->getCount($map), $page, $pagesize );
        $this->assign('pageHtml', $pageHtml);

        $this->display('sign_up');
    }

    public function win() {
        $LotteryUser = D('Common://AppLotteryUser');
        if ( $_POST['submit'] ) {
            return;
        }

        $page = $_GET['page'] ? $_GET['page'] : 1;
        $pagesize = 10;
        $pageset = ( $page -1) * $pagesize;
        $limit = array('page'=> $pageset, 'pagesize'=> $pagesize);

        $map['uid'] = $_SESSION['_User']['uid'];
        $map['lot_id'] = $_GET['lot_id'];

        if ( $_GET['prize_id'] ) {
            $map['prize_id'] = $_GET['prize_id'];
        } else {
            $map['prize_id'] = array('neq', 0);
        }

        $list = $LotteryUser->getListWithPrize( $map, $limit );
        $this->assign( 'list', $list );

        $pageHtml = page( $LotteryUser->getCount($map), $page, $pagesize );
        $this->assign('pageHtml', $pageHtml);

        $this->display('win');
    }


    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * XXX
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
}
?>