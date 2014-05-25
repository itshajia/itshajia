<?php
class IndexAction extends CommonAction{

    public function _empty() {
        $this->wed();
    }

    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 婚庆管理
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
    public function wed(){
        $AppWedding = D('Common://AppWedding');
        $view = $_GET['view'] ? $_GET['view'] : 'list';

        switch( $view ) {
            case "add":
                if ( $_POST['submit'] ) {
                    if ( !$AppWedding->create() ) return;

                    $AppWedding->is_check = $_POST['is_check'] ? 1 : 0;
                    if ( $AppWedding->wed_id ) {

                        if ( $AppWedding->save() ) {
                            $this->success('数据保存成功！', appUrl('m=Index&a=wed'));
                            return;
                        }
                        $this->error('数据保存成功！');
                    } else {
                        $AppWedding->uid = $_SESSION['_User']['uid'];
                        $AppWedding->addtime = time();

                        if ( $AppWedding->add() ) {
                            $this->success('数据添加成功！', appUrl('m=Index&a=wed&view=add'));
                            return;
                        }
                        $this->error('数据添加失败！');
                    }
                    return;
                }

                if ( $_GET['wed_id'] ) {
                    $map['wed_id'] = $_GET['wed_id'];
                    $map['uid'] = $_SESSION['_User']['uid'];
                    $obj = $AppWedding->where($map)->find();
                    $this->assign('obj', $obj);
                }

                $this->display('wed_add');
                break;

            case "list":
                if ( $_POST['submit'] ) {
                    $tool = $_POST['tool'];
                    $ids = $_POST['id'];

                    if ( !count($ids) ) $this->error('请选择要操作的选项！');
                    switch( $tool ) {
                        case "delAll":
                            foreach( $ids as $k=>$v ) {
                                $map['wed_id'] = $k;
                                $map['uid'] = $_SESSION['_User']['uid'];
                                $AppWedding->where($map)->delete();
                            }
                            $this->success('数据删除成功！', appUrl('m=Index&a=wed'));
                            break;
                    }
                    return;
                }

                $page = $_GET['page'] ? $_GET['page'] : 1;
                $pagesize = 10;
                $pageset = ( $page -1) * $pagesize;
                $limit = array('page'=> $pageset, 'pagesize'=> $pagesize);

                $map['uid'] = $_SESSION['_User']['uid'];
                $list = $AppWedding->getList( $map, $limit );
                $this->assign( 'list', $list );

                $pageHtml = page( $AppWedding->getCount($map), $page, $pagesize );
                $this->assign('pageHtml', $pageHtml);

                $this->display('wed_list');
                break;

            case "del":
                if( $_GET['wed_id'] ) {
                    $map['wed_id'] = $_GET['wed_id'];
                    $map['uid'] = $_SESSION['_User']['uid'];
                    $AppWedding->where($map)->delete();
                    $this->success('数据删除成功！', appUrl('m=Index&a=wed') );
                    return;
                }
                $this->error('访问地址不正确！');
                break;
        }
    }

    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 相册管理
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
    public function albumCate() {
        $AlbumCate = D('Common://AlbumCate');
        $view = $_GET['view'] ? $_GET['view'] : 'list';

        switch ( $view ) {
            case "add";
                if ( $_POST['submit'] ) {

                    if ( !$AlbumCate->create() ) return;
                    if ( $AlbumCate->cate_id ) {

                        if ( $AlbumCate->save() ) {
                            $this->success('数据保存成功！', appUrl('m=Index&a=albumCate&enter=1&wed_id='.$_POST['wed_id']));
                            return;
                        }
                        $this->error('数据保存失败！');
                    } else {
                        $AlbumCate->uid = $_SESSION['_User']['uid'];
                        $AlbumCate->addtime = time();
                        $AlbumCate->app_name = 'wedding';

                        if ( $AlbumCate->add() ) {
                            $this->success('数据添加成功', appUrl('m=Index&a=albumCate&view=add&enter=1&wed_id='.$_POST['wed_id']));
                            return;
                        }
                        $this->error('数据添加失败！');
                    }
                    return;
                }

                $map['uid'] = $_SESSION['_User']['uid'];
                $map['app_name'] = 'wedding';
                $levelList = $AlbumCate->getLevelUnlimit( $AlbumCate->getUnlimit( $map ) );
                $this->assign('levelList', $levelList);

                if ( $_GET['cate_id'] ) {
                    $map['cate_id'] = $_GET['cate_id'];
                    $obj = $AlbumCate->where($map)->find();
                    $this->assign('obj', $obj);
                }

                $this->display('album_cate_add');
                break;

            case "list":
                if ( $_POST['submit'] ) {
                    $tool = $_POST['tool'];
                    $ids = $_POST['id'];

                    if ( !count($ids) ) $this->error('请选择要操作的选项！');
                    switch( $tool ) {
                        case "delAll":
                            foreach( $ids as $k=>$v ) {
                                $map['cate_id'] = $k;
                                $map['app_name'] = 'wedding';
                                $AlbumCate->where($map)->delete();
                            }
                            $this->success('数据删除成功！', appUrl('m=Index&a=albumCate&enter=1&wed_id='.$_POST['wed_id']));
                            break;
                    }
                    return;
                }


                $map['uid'] = $_SESSION['_User']['uid'];
                $map['item_id'] = $_GET['wed_id'];
                $map['app_name'] = 'wedding';
                $list = $AlbumCate->getLevelUnlimit( $AlbumCate->getUnlimit($map) );
                $this->assign('list', $list);

                $this->display('album_cate_list');
                break;

            case "del":
                if( $_GET['cate_id'] ) {
                    $map['cate_id'] = $_GET['cate_id'];
                    $map['uid'] = $_SESSION['_User']['uid'];
                    $map['item_id'] = $_GET['wed_id'];
                    $map['app_name'] = 'wedding';

                    // 检测该分类下是否存在数据
                    if( !D('Common://Album')->where($map)->find() ) {
                        $AlbumCate->where($map)->delete();
                        $this->success('数据删除成功！', appUrl('m=Index&a=albumCate&enter=1&wed_id='.$_GET['wed_id']) );
                    } else {
                        $this->error('改分类下存在数据，请先删除分类下的数据！');
                    }
                    return;
                }
                $this->error('访问地址不正确！');
                break;
        }
    }

    public function album() {
        $Album = D('Common://Album');
        $AlbumCate = D('Common://AlbumCate');
        $AlbumPic = D('Common://AlbumPic');
        $view = $_GET['view'] ? $_GET['view'] : 'list';

        switch ( $view ) {
            case "pic":
                if ( $_POST['submit'] ) {

                    if ( !$AlbumPic->create()  ) return;
                    $pics = $AlbumPic->pic_url;
                    $titles = $AlbumPic->pic_title;
                    $ids = $AlbumPic->pic_id;

                    //$data['album_id'] = $_POST['album_id'];
                    $data['uid'] = $_SESSION['_User']['uid'];
                    $data['addtime'] = time();
                    $data['app_name'] = 'wedding';
                    $data['item_id'] = $_POST['wed_id'];

                    $map['uid'] = $_SESSION['_User']['uid'];
                    $map['app_name'] = 'wedding';

                    for( $i=0;$i<count($pics);$i++ ) {

                        $data['pic_url'] = $pics[$i];
                        $data['pic_title'] = $titles[$i];

                        if ( $ids[$i] ){
                            $map['pic_id'] = $ids[$i];
                            $AlbumPic->where($map)->save( $data );
                        } else {
                            $AlbumPic->add( $data );
                        }
                    }

                    $this->success('数据保存成功！', appUrl('m=Index&a=album&view=pic&album_id='.$_POST['album_id']."&enter=1&wed_id=".$_POST['wed_id']));
                    return;
                }

                //if ( !$_GET['album_id'] ) $this->error('访问地址不正确！');
                $map['item_id'] = $_GET['wed_id'];
                $map['uid'] = $_SESSION['_User']['uid'];
                $map['app_name'] = 'wedding';
               /* $obj = $Album->where($map)->find();
                $this->assign('obj', $obj);*/

                $list = $AlbumPic->order(array('listorder'))->where($map)->select();
                $this->assign('list', $list);

                $this->display('album_pic');
                break;

            case "add";
                if ( $_POST['submit'] ) {
                    if ( !$Album->create() ) return;
                    $Album->addtime = $Album->addtime ? strtotime( $Album->addtime) : time();

                    if ( $Album->album_id ) {

                        if ( $Album->save() ) {
                            $this->success('数据保存成功！',appUrl('m=Index&a=album&view=add&album_id='.$_POST['album_id'])."&enter=1&wed_id=".$_POST['wed_id'] );
                            return;
                        }
                        $this->error('数据保存失败！');
                    } else {
                        $Album->uid = $_SESSION['_User']['uid'];
                        $Album->app_name = 'wedding';

                        if ( $Album->add() ) {
                            $this->success( '数据添加成功！', appUrl('m=Index&a=album&view=add&enter=1&wed_id='.$_POST['wed_id']) );
                            return;
                        }
                        $this->error('数据添加失败！');
                    }
                    return;
                }

                $map['uid'] = $_SESSION['_User']['uid'];
                $map['app_name'] = 'wedding';
                $map['item_id'] = $_GET['wed_id'];
                $levelList = $AlbumCate->getLevelUnlimit( $AlbumCate->getUnlimit( $map ) );
                $this->assign('levelList', $levelList);

                if ( $_GET['album_id'] ) {
                    $map['album_id'] = $_GET['album_id'];
                    $obj = $Album->where($map)->find();
                    $this->assign('obj', $obj);
                }

                $this->display('album_add');
                break;

            case "list":
                if ( $_POST['submit'] ) {
                    $tool = $_POST['tool'];
                    $ids = $_POST['id'];

                    if ( $tool && !count($ids) ) $this->error('请选择要操作的选项！');
                    switch( $tool ) {
                        case "delAll":
                            foreach( $ids as $k=>$v ) {
                                $map['album_id'] = $k;
                                $map['uid'] = $_SESSION['_User']['uid'];
                                $map['app_name'] = 'wedding';
                                $Album->where($map)->delete();
                            }
                            $this->success('数据删除成功！', appUrl('m=Index&a=album&enter=1&wed_id='.$_POST['wed_id']));
                            break;
                    }
                    return;
                }
                $page = $_GET['page'] ? $_GET['page'] : 1;
                $pagesize = 10;
                $pageset = ( $page -1) * $pagesize;
                $limit = array('page'=> $pageset, 'pagesize'=> $pagesize);

                $map['uid'] = $_SESSION['_User']['uid'];
                $map['app_name'] = 'wedding';
                $map['item_id'] = $_GET['wed_id'];
                $list = $Album->getListWithJoin( $map, $limit );
                $this->assign( 'list', $list );

                $pageHtml = page( $Album->getCount($map), $page, $pagesize );
                $this->assign('pageHtml', $pageHtml);

                $this->display('album_list');
                break;

            case "del":
                if( $_GET['album_id'] ) {
                    $map['album_id'] = $_GET['album_id'];
                    $map['uid'] = $_SESSION['_User']['uid'];
                    $map['item_id'] = $_GET['wed_id'];
                    $map['app_name'] = 'wedding';
                    $Album->where($map)->delete();
                    $this->success('数据删除成功！', appUrl('m=Index&a=album&enter=1&wed_id='.$_GET['wed_id']) );
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
    public function bzmap(){
        $AppWedding = D('Common://AppWedding');

        if ( $_POST['submit'] ) {
            if ( !$AppWedding->create() ) return;

            if ( $AppWedding->wed_id ) {
                if ( $AppWedding->save() ) {
                    $this->success('数据保存成功！', appUrl('m=Index&a=bzmap&enter=1&wed_id='.$_POST['wed_id']));
                    return;
                }
                $this->error('数据保存成功！');
            }

            return;
        }

        $map['uid'] = $_SESSION['_User']['uid'];
        $map['wed_id'] = $_GET['wed_id'];
        $obj = $AppWedding->where($map)->find();
        $this->assign('obj', $obj);

        $this->display('bzmap');
    }

    public function tmpl() {
        if ( $_POST['submit'] ) {
            return;
        }
        $this->display('tmpl');
    }

    public function screen() {
        if ( $_POST['screen'] ) {
            return;
        }

        $url = C('WEB_URL').'/App/Wedding/index.php?g=Home&m=Index&a=screen&uid='.$_SESSION['_User']['uid'].'&wed_id='.$_GET['wed_id'];
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
        $qrcode = '{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": 1'.$_GET['wed_id'].'}}}';
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
     * 宾客祝福
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
    public function bless() {
        $Bless = D('Common://AppWeddingBless');
        $view = $_GET['view'] ? $_GET['view'] : 'pend';

        switch( $view ) {
            case "pend":
                if ( $_POST['submit']) {

                    $tool = $_POST['tool'];
                    $ids = $_POST['id'];

                    if ( !count($ids) ) $this->error('请选择要操作的选项！');
                    switch( $tool ) {
                        case "passAll":
                            foreach( $ids as $k=>$v ) {
                                $map['bless_id'] = $k;
                                $map['uid'] = $_SESSION['_User']['uid'];
                                $data['status'] = 1;
                                $Bless->where($map)->save( $data );
                            }
                            $this->success('操作执行成功！', appUrl('m=Index&a=bless&view=pend&enter=1&wed_id='.$_POST['wed_id']));
                            break;

                        case "refuseAll":
                            foreach( $ids as $k=>$v ) {
                                $map['bless_id'] = $k;
                                $map['uid'] = $_SESSION['_User']['uid'];
                                $data['status'] = 2;
                                $Bless->where($map)->save( $data );
                            }
                            $this->success('操作执行成功！', appUrl('m=Index&a=bless&view=pend&enter=1&wed_id='.$_POST['wed_id']));
                            break;
                    }
                    return;
                }


                $page = $_GET['page'] ? $_GET['page'] : 1;
                $pagesize = 10;
                $pageset = ( $page -1) * $pagesize;
                $limit = array('page'=> $pageset, 'pagesize'=> $pagesize);

                $map['uid'] = $_SESSION['_User']['uid'];
                $map['wed_id'] = $_GET['wed_id'];
                $map['status'] = 0;
                $list = $Bless->getList( $map, $limit );
                $this->assign( 'list', $list );

                $pageHtml = page( $Bless->getCount($map), $page, $pagesize );
                $this->assign('pageHtml', $pageHtml);

                $this->display('bless');
                break;

            case "refuse":
                if ( $_POST['submit']) {
                    $tool = $_POST['tool'];
                    $ids = $_POST['id'];

                    if ( !count($ids) ) $this->error('请选择要操作的选项！');
                    switch( $tool ) {
                        case "passAll":
                            foreach( $ids as $k=>$v ) {
                                $map['bless_id'] = $k;
                                $map['uid'] = $_SESSION['_User']['uid'];
                                $data['status'] = 1;
                                $Bless->where($map)->save( $data );
                            }
                            $this->success('操作执行成功！', appUrl('m=Index&a=bless&view=refuse&enter=1&wed_id='.$_POST['wed_id']));
                            break;
                    }
                    return;
                }

                $page = $_GET['page'] ? $_GET['page'] : 1;
                $pagesize = 10;
                $pageset = ( $page -1) * $pagesize;
                $limit = array('page'=> $pageset, 'pagesize'=> $pagesize);

                $map['uid'] = $_SESSION['_User']['uid'];
                $map['wed_id'] = $_GET['wed_id'];
                $map['status'] = 2;
                $list = $Bless->getList( $map, $limit );
                $this->assign( 'list', $list );

                $pageHtml = page( $Bless->getCount($map), $page, $pagesize );
                $this->assign('pageHtml', $pageHtml);

                $this->display('bless');
                break;

            case "pass":
                if ( $_POST['submit']) {

                    $tool = $_POST['tool'];
                    $ids = $_POST['id'];

                    if ( !count($ids) ) $this->error('请选择要操作的选项！');
                    switch( $tool ) {
                        case "refuseAll":
                            foreach( $ids as $k=>$v ) {
                                $map['bless_id'] = $k;
                                $map['uid'] = $_SESSION['_User']['uid'];
                                $data['status'] = 2;
                                $Bless->where($map)->save( $data );
                            }
                            $this->success('操作执行成功！', appUrl('m=Index&a=bless&view=pass&enter=1&wed_id='.$_POST['wed_id']));
                            break;
                    }
                    return;
                }

                $page = $_GET['page'] ? $_GET['page'] : 1;
                $pagesize = 10;
                $pageset = ( $page -1) * $pagesize;
                $limit = array('page'=> $pageset, 'pagesize'=> $pagesize);

                $map['uid'] = $_SESSION['_User']['uid'];
                $map['wed_id'] = $_GET['wed_id'];
                $map['status'] = 1;
                $list = $Bless->getList( $map, $limit );
                $this->assign( 'list', $list );

                $pageHtml = page( $Bless->getCount($map), $page, $pagesize );
                $this->assign('pageHtml', $pageHtml);

                $this->display('bless');
                break;

            case "all":
                $page = $_GET['page'] ? $_GET['page'] : 1;
                $pagesize = 10;
                $pageset = ( $page -1) * $pagesize;
                $limit = array('page'=> $pageset, 'pagesize'=> $pagesize);

                $map['uid'] = $_SESSION['_User']['uid'];
                $map['wed_id'] = $_GET['wed_id'];
                $list = $Bless->getList( $map, $limit );
                $this->assign( 'list', $list );

                $pageHtml = page( $Bless->getCount($map), $page, $pagesize );
                $this->assign('pageHtml', $pageHtml);

                $this->display('bless_all');
                break;
        }
    }

    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * XXX
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
}
?>