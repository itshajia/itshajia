<?php
class UserAction extends CommonAction{

    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 资料管理
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
    public function basic() {
        $User = D('User');

        if( $_POST['submit'] ) {

            if ( !$User->create() || !$User->uid ) return;
            if( $User->save() ) {
                $this->success('数据保存成功！', appUrl('m=User&a=basic') );
                return;
            }
            $this->error('数据保存失败！');
            return;
        }
        $map = array();
        $map['uid'] = $_SESSION['_User']['uid'];
        $obj = $User->where($map)->find();
        $this->assign('obj', $obj);

        $this->display('user_basic');
    }

    public function comNum() {
        $UserInfo = D('UserInfo');
        if ( $_POST['submit'] ) {

            if ( !$UserInfo->create() ) return;

            $UserInfo->uid = $_SESSION['_User']['uid'];
            if ( $UserInfo->info_id ) {

                if ( $UserInfo->save() ) {
                    $this->success('数据保存成功！', appUrl('m=User&a=comNum'));
                    return;
                }
                $this->error('数据保存失败！');
            } else {

                $UserInfo->addtime = time();
                if ( $UserInfo->add() ) {
                    $this->success('数据保存成功！', appUrl('m=User&a=comNum'));
                    return;
                }
                $this->error('数据保存失败！');
                return;
            }

            return;
        }
        $map['uid'] = $_SESSION['_User']['uid'];
        $obj = $UserInfo->where($map)->find();
        $this->assign('obj', $obj);

        $this->display('user_comNum');
    }

    public function passwordModify() {
        if ( $_POST['submit'] ) {

            if ( trim($_POST['newpassword']) == trim($_POST['repassword']) ) {
                $User = D('User');
                $map['uid'] = $_SESSION['_User']['uid'];;
                $user = $User->where($map)->find();

                if ( trim($_POST['oldpassword']) != trim($_POST['newpassword']) ) {

                    if( $user && $user['password'] == md5(trim($_POST['oldpassword']))) {
                        $data['password'] = md5(trim($_POST['newpassword']));
                        $User->where($map)->save($data);
                        $this->success('密码修改成功！', appUrl('m=User&a=passwordModify') );
                    } else {
                        $this->error('原密码不正确！');
                    }
                } else {
                    $this->error('新密码不能与原密码一样！');
                }
            } else {
                $this->error('重复密码不一致！');
            }
            return;
        }
        $this->display('user_password');
    }

    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 消息回复
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
    public function replySet() {
        $ReplyMsg = M('ReplyMsg');

        if ( $_POST['submit'] ) {

            if ( !$ReplyMsg->create() ) return;

            if ( $ReplyMsg->msg_id ) {

                if ( $ReplyMsg->save() ) {
                    $this->success('数据设置成功！', appUrl('m=User&a=replySet'));
                } else {
                    $this->error('数据设置失败！');
                }
            } else {
                $ReplyMsg->uid = $_SESSION['_User']['uid'];
                $ReplyMsg->addtime = time();

                if ( $ReplyMsg->add() ) {
                    $this->success('数据设置成功！', appUrl('m=User&a=replySet'));
                } else {
                    $this->error('数据设置失败！');
                }
            }
            return;
        }

        // 获取“回复”列表
        $Reply = D('Reply');
        $map['uid'] = $_SESSION['_User']['uid'];
        $list = $Reply->where($map)->select();
        $this->assign('list', $list);

        // 获取“回复设置”对象
        $replyMsg = $ReplyMsg->where($map)->find();
        $this->assign('replyMsg', $replyMsg);

        $this->display('user_replySet');
    }

    public function textReply() {
        $Reply = D('Reply');
        $view = $_GET['view'] ? $_GET['view'] : 'list';

        switch ( $view ) {
            case "add":
                if ( $_POST['submit'] ) {

                    if ( !$Reply->create() ) return;

                    $Reply->uid = $_SESSION['_User']['uid'];
                    if ( $Reply->reply_id ) {

                        if ( $Reply->save() ) {
                            $this->success('数据保存成功！', appUrl('m=User&a=textReply'));
                            return;
                        }
                        $this->error('数据保存失败！');
                    } else {

                        $Reply->reply_type = 0;
                        $Reply->addtime = time();
                        if ( $Reply->add() ) {
                            $this->success('数据添加成功！', appUrl('m=User&a=textReply&view=add'));
                            return;
                        }
                        $this->error('数据添加失败！');
                    }
                    return;
                }
                if ( $_GET['reply_id'] ) {
                    $map['reply_id'] = $_GET['reply_id'];
                    $map['uid'] = $_SESSION['_User']['uid'];
                    $obj = $Reply->where($map)->find();
                    $this->assign('obj', $obj);
                }
                $this->display('user_textReply_add');
                break;

            case "list":
                if ( $_POST['submit'] ) {
                    $tool = $_POST['tool'];
                    $ids = $_POST['id'];

                    if ( !count($ids) ) $this->error('请选择要操作的选项！');
                    switch( $tool ) {
                        case "delAll":
                            foreach( $ids as $k=>$v ) {
                                $map['reply_id'] = $k;
                                $map['uid'] = $_SESSION['_User']['uid'];
                                $Reply->where($map)->delete();
                            }
                            $this->success('数据删除成功！', appUrl('m=User&a=textReply'));
                            break;
                    }
                    return;
                }

                $page = $_GET['page'] ? $_GET['page'] : 1;
                $pagesize = 10;
                $pageset = ( $page -1) * $pagesize;
                $limit = array('page'=> $pageset, 'pagesize'=> $pagesize);

                $map['uid'] = $_SESSION['_User']['uid'];
                $map['reply_type'] = 0; // 表示 “文本回复”
                $list = $Reply->getList( $map, $limit );
                $this->assign( 'list', $list );

                $pageHtml = page( $Reply->getCount($map), $page, $pagesize );
                $this->assign('pageHtml', $pageHtml);

                $this->display('user_textReply');
                break;

            case "del":
                if( $_GET['reply_id'] ) {
                    $map['reply_id'] = $_GET['reply_id'];
                    $map['uid'] = $_SESSION['_User']['uid'];
                    $Reply->where($map)->delete();
                    $this->success('数据删除成功！', appUrl('m=User&a=textReply') );
                    return;
                }
                $this->error('访问地址不正确！');
                break;
        }

    }

    public function imgReply() {
        $Reply = D('Reply');
        $view = $_GET['view'] ? $_GET['view'] : 'list';

        switch ( $view ) {
            case "add":
                if ( $_POST['submit'] ) {

                    if ( !$Reply->create() ) return;

                    $Reply->uid = $_SESSION['_User']['uid'];
                    if ( $Reply->reply_id ) {

                        if ( $Reply->save() ) {
                            $this->success('数据保存成功！', appUrl('m=User&a=imgReply'));
                            return;
                        }
                        $this->error('数据保存失败！');
                    } else {

                        $Reply->reply_type = 1;
                        $Reply->addtime = time();
                        if ( $Reply->add() ) {
                            $this->success('数据添加成功！', appUrl('m=User&a=imgReply&view=add'));
                            return;
                        }
                        $this->error('数据添加失败！');
                    }
                    return;
                }
                if ( $_GET['reply_id'] ) {
                    $map['reply_id'] = $_GET['reply_id'];
                    $map['uid'] = $_SESSION['_User']['uid'];
                    $obj = $Reply->where($map)->find();
                    $this->assign('obj', $obj);
                }
                $this->display('user_imgReply_add');
                break;

            case "list":
                if ( $_POST['submit'] ) {
                    $tool = $_POST['tool'];
                    $ids = $_POST['id'];

                    if ( !count($ids) ) $this->error('请选择要操作的选项！');
                    switch( $tool ) {
                        case "delAll":
                            foreach( $ids as $k=>$v ) {
                                $map['reply_id'] = $k;
                                $map['uid'] = $_SESSION['_User']['uid'];
                                $Reply->where($map)->delete();
                            }
                            $this->success('数据删除成功！', appUrl('m=User&a=textReply'));
                            break;
                    }
                    return;
                }

                $page = $_GET['page'] ? $_GET['page'] : 1;
                $pagesize = 10;
                $pageset = ( $page -1) * $pagesize;
                $limit = array('page'=> $pageset, 'pagesize'=> $pagesize);

                $map['uid'] = $_SESSION['_User']['uid'];
                $map['reply_type'] = 1; // 表示 “图文回复”
                $list = $Reply->getList( $map, $limit );
                $this->assign( 'list', $list );

                $pageHtml = page( $Reply->getCount($map), $page, $pagesize );
                $this->assign('pageHtml', $pageHtml);

                $this->display('user_imgReply');
                break;

            case "del":
                if( $_GET['reply_id'] ) {
                    $map['reply_id'] = $_GET['reply_id'];
                    $map['uid'] = $_SESSION['_User']['uid'];
                    $Reply->where($map)->delete();
                    $this->success('数据删除成功！', appUrl('m=User&a=imgReply') );
                    return;
                }
                $this->error('访问地址不正确！');
                break;

            case "pic":
                $ReplyImg = D('ReplyImg');
                if ( !$_GET['reply_id'] ) $this->error('访问地址不正确！');
                $map['reply_id'] = $_GET['reply_id'];
                $map['uid'] = $_SESSION['_User']['uid'];
                $obj = $Reply->where($map)->find();
                $this->assign('obj', $obj);

                $map['is_first'] = 1;
                $replyImgFirst = $ReplyImg->where($map)->find();
                $this->assign('replyImgFirst', $replyImgFirst);
                $map['is_first'] = 0;
                $replyImgList = $ReplyImg->order(array('sort'))->where($map)->select();
                $this->assign('replyImgList', $replyImgList);

                $this->display('user_imgReply_pic');
                break;
        }

    }

    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 自定义菜单
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
    public function menuAuth() {
        $UserInfo = D('UserInfo');
        if ( $_POST['submit'] ) {
            if ( !$UserInfo->create() ) return;

            $UserInfo->uid = $_SESSION['_User']['uid'];
            if ( $UserInfo->info_id ) {

                if ( $UserInfo->save() ) {
                    $this->success('数据保存成功！', appUrl('m=User&a=menuAuth'));
                    return;
                }
                $this->error('数据保存失败！');
            } else {

                $UserInfo->addtime = time();
                if ( $UserInfo->add() ) {
                    $this->success('数据保存成功！', appUrl('m=User&a=menuAuth'));
                    return;
                }
                $this->error('数据保存失败！');
                return;
            }
            return;
        }
        $map['uid'] = $_SESSION['_User']['uid'];
        $obj = $UserInfo->where($map)->find();
        $this->assign('obj', $obj);
        $this->display('user_menuAuth');
    }

    public function menuSet() {
        // 检测是否设置了 AppId 和 AppSecret
        $UserInfo = D('UserInfo');
        $map['uid'] = $_SESSION['_User']['uid'];
        $obj = $UserInfo->where($map)->find();
        $this->assign('obj', $obj);
        if ( !$obj || !$obj['appId'] || !$obj['appSecret'] ) $this->error('请先设置好应用ID和应用密钥！');


        $CustomMenu = D('CustomMenu');
        if ( $_POST['submit'] ) {

            $ids = $_POST['id'];
            $result = false;
            foreach( $ids as $i => $k ) {

                $map['menu_id'] = $i;
                $map['uid'] = $_SESSION['_User']['uid'];
                $data['listorder'] = $k['listorder'];

                if( $CustomMenu->where($map)->save($data) ) {
                    $result = true;
                }
            }

            if( $result ) {
                $this->success('数据保存成功！', appUrl('m=User&a=menuSet'));
            } else {
                $this->error('数据保存失败！');
            }

            return;
        }

        $Reply = D('Reply');
        $map['reply_type'] = 1;
        $imgReplyList = $Reply->where($map)->select();
        foreach( $imgReplyList as $k=>$v ) {
            $imgReplyList[$k]['menu_key'] = 'news_'.$v['reply_id'];
        }
        $this->assign('imgReplyList', $imgReplyList);

        $map['reply_type'] = 0;
        $textReplyList = $Reply->where($map)->select();
        foreach( $textReplyList as $k=>$v ) {
            $textReplyList[$k]['menu_key'] = 'text_'.$v['reply_id'];
        }
        $this->assign('textReplyList', $textReplyList);


        // 获取应用列表
        $App = D('App');
        $page = $_GET['page'] ? $_GET['page'] : 1;
        $pagesize = 100;
        $pageset = ( $page -1) * $pagesize;
        $limit = array('page'=> $pageset, 'pagesize'=> $pagesize);

        $my = $App->getMyList($limit);
        $appList = $my['list'];
        foreach( $appList as $k=>$v ) {
            $appList[$k]['menu_key'] = 'app_'.$v['app_id'];
        }
        $this->assign('appList', $appList);

        // 获取一级菜单列表
        $map = array();
        $map['uid'] = $_SESSION['_User']['uid'];
        $map['parent_id'] = 0;
        $menuOneList = $CustomMenu->where($map)->select();
        $this->assign('menuOneList', $menuOneList);

        // 获取 菜单列表
        $list = $CustomMenu->getLevelUnlimit($CustomMenu->getUnlimit(0,-1,'menu_id'));
        $this->assign('list', $list);

        $this->display('user_menuSet');
    }

    // 自定义菜单发布
    public function menuRelease() {
        if ( $_POST['submit'] ) {
            // 获取一级菜单列表
            $CustomMenu = D('CustomMenu');
            $map = array();
            $map['uid'] = $_SESSION['_User']['uid'];
            $map['parent_id'] = 0;
            $menu = array();
            $firstMenuList = $CustomMenu->order(array('listorder'))->where($map)->select();

            // 菜单整理
            foreach ( $firstMenuList as $k=>$v ) {
                $firstMenu = array();

                if ( $v['child_count'] ) {
                    $firstMenu['name'] = urlencode($v['title']);
                    $map['parent_id'] = $v['menu_id'];
                    $secondMenuList = $CustomMenu->order(array('listorder'))->where($map)->select();

                    foreach ( $secondMenuList as $k1=>$v1 ) {
                        $secondMenu = array();

                        $c_type = ( $v1['menu_type']=='click' ) ? 'key' : 'url';
                        $secondMenu['type'] = $v1['menu_type'];
                        $secondMenu['name'] = urlencode($v1['title']);
                        $secondMenu[$c_type] = $v1['menu_key'];
                        $firstMenu['sub_button'][] = $secondMenu;
                    }

                } else {
                    $c_type = ( $v['menu_type']=='click' ) ? 'key' : 'url';
                    $firstMenu['type'] = $v['menu_type'];
                    $firstMenu['name'] = urlencode($v['title']);
                    $firstMenu[$c_type] = $v['menu_key'];
                }

                array_push( $menu, $firstMenu );
            }

            //var_dump($menu);
            // 菜单发送
            $UserInfo = D('UserInfo');
            $map = array();
            $map['uid'] = $_SESSION['_User']['uid'];
            $obj = $UserInfo->where($map)->find();
            $this->assign('obj', $obj);
            $appId = $obj['appId'];
            $appSecret = $obj['appSecret'];

            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appId."&secret=".$appSecret;
            $result = https_get($url);
            $jsoninfo = json_decode($result, true);
            $access_token = $jsoninfo['access_token'];
            $menuJson = urldecode(json_encode(array('button'=>$menu)));

            $url = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=$access_token";
            $result = https_post($url, $menuJson);

            $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=$access_token";
            $result = https_post($url, $menuJson);
            $jsoninfo = json_decode($result, true);
            //var_dump($jsoninfo);

            $this->success('发布成功！', appUrl('m=User&a=menuSet'));
            return;
        }
    }


    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * XXX
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
}
?>