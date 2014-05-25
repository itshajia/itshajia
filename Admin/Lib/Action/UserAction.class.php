<?php
class UserAction extends CommonAction {


    public function index() {

    }

    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 用户管理
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
    // 用户添加
    public function add() {
        $User = D('User');

        if ( $_POST['submit'] ) {
            if( !$User->create() ) return;
            $sUrl = appUrl('m=User&a=userList');

            if ( !$User->create() ) return;
            if ( $User->uid ) {

                if( $User->save() ) {
                    $this->success('数据保存成功！', $sUrl);
                } else {
                    $this->error('数据保存失败！');
                }
                return;
            }

            $User->data_format();
            $User->addtime = time();
            $User->status = 1;

            if( $User->add() ) {
                $this->success('数据添加成功！', $sUrl);
            } else {
                $this->error('数据添加失败！');
            }

            return;
        }

        if( $_GET['uid'] ) {
            $map['uid'] = $_GET['uid'];
            $obj = $User->where($map)->find();
            $this->assign('obj', $obj);
        }
        // 获取用户组
        $UserGroup = D('UserGroup');
        $map = array();
        $map['is_admin'] = 0;
        $groupList = $UserGroup->where($map)->select();
        $this->assign('groupList', $groupList);
        $this->display('user_add');

    }



    // 用户管理
    public function userList() {
        $op = $_GET['op'] ? $_GET['op'] : 'list';
        $User = D('User');

        switch( $op ) {
            case 'list':
                if ( $_POST['submit'] ) {
                    $tool = $_POST['tool'];
                    $ids = $_POST['uid'];

                    if ( !count($ids) ) {
                        $this->error('请选择要操作的选项！');
                        exit();
                    }

                    $sUrl = appUrl('m=User&a='.ACTION_NAME);
                    switch( $tool ) {
                        case "delAll":
                            foreach( $ids as $k=>$v ) {
                                $map['uid'] = $k;
                                $User->where($map)->delete();
                            }

                            $this->success('数据删除成功！', $sUrl);
                            break;
                    }
                    return ;
                }

                $page = $_GET['page'] ? $_GET['page'] : 1;
                $pagesize = 10;
                $pageset = ( $page -1) * $pagesize;
                $limit = array('page'=> $pageset, 'pagesize'=> $pagesize);

                // 获取用户列表（公共部分）
                $map['status'] = 1;
                $userList = $User->getListWithJoin( $map, $limit );
                $this->assign('userList', $userList);

                $pageHtml = page( $User->getCount($map), $page, $pagesize, 1);
                $this->assign('pageHtml', $pageHtml);

                $this->display('user_list');
                break;

            case 'disabled':
                if( $_GET['uid'] ) {
                    $map['uid'] = $_GET['uid'];
                    $user = $User->where($map)->find();
                    $data['status'] = $user['status'] ? 0 : 1;

                    if( $User->where($map)->save($data) ) {
                        $this->success('数据保存成功！', appUrl('m=User&a=userList'));
                    } else {
                        $this->error('数据保存失败！');
                    }
                } else {
                    $this->error('地址不存在！');
                }
                break;

            case 'del':
                if( $_GET['uid'] ) {
                    $map['uid'] = $_GET['uid'];
                    $User->where($map)->delete();
                    $this->success('数据删除成功！', appUrl('m=User&a=userList'));
                } else {
                    $this->error('非法操作！');
                }
                break;
        }

    }

    // 用户组
    public function nopass() {
        $op = $_GET['op'] ? $_GET['op'] : 'list';
        $User = D('User');

        switch( $op ) {
            case "list":
                if ( $_POST['submit'] ) {
                    $tool = $_POST['tool'];
                    $ids = $_POST['uid'];

                    if ( !count($ids) ) {
                        $this->error('请选择要操作的选项！');
                        exit();
                    }

                    $sUrl = appUrl('m=User&a='.ACTION_NAME);
                    switch( $tool ) {
                        case "delAll":
                            foreach( $ids as $k=>$v ) {
                                $map['uid'] = $k;
                                $User->where($map)->delete();
                            }

                            $this->success('数据删除成功！', $sUrl);
                            break;
                    }
                    return ;
                }

                $page = $_GET['page'] ? $_GET['page'] : 1;
                $pagesize = 10;
                $pageset = ( $page -1) * $pagesize;
                $limit = array('page'=> $pageset, 'pagesize'=> $pagesize);

                $map['status'] = 0;
                $userList = $User->getListWithJoin( $map, $limit );
                $this->assign('userList', $userList);

                $pageHtml = page( $User->getCount($map), $page, $pagesize, 1);
                $this->assign('pageHtml', $pageHtml);

                $this->display('user_nopass_list');
                break;

            case 'abled':
                if( $_GET['uid'] ) {
                    $map['uid'] = $_GET['uid'];
                    $user = $User->where($map)->find();
                    $data['status'] = $user['status'] ? 0 : 1;

                    if( $User->where($map)->save($data) ) {
                        $this->success('数据保存成功！', appUrl('m=User&a=nopass'));
                    } else {
                        $this->error('数据保存失败！');
                    }
                } else {
                    $this->error('地址不存在！');
                }
                break;

            case 'del':
                if( $_GET['uid'] ) {
                    $map['uid'] = $_GET['uid'];
                    $User->where($map)->delete();
                    $this->success('数据删除成功！', appUrl('m=User&a=nopass'));
                } else {
                    $this->error('非法操作！');
                }
                break;
        }

    }


    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 系统组管理
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
    // 系统组管理
    public function groupList() {
        $op = $_GET['op'] ? $_GET['op'] : 'list';
        $UserGroup = D('UserGroup');

        switch( $op ) {
            case 'list':
                $map['is_admin'] = 0;
                $groupList = $UserGroup->where($map)->select();
                $this->assign('groupList', $groupList);
                $this->display('user_groupList');
                break;

            case 'del':

                if( $_GET['group_id'] ) {
                    $map['group_id'] = $_GET['group_id'];
                    // 检测是否存在子项
                    if( !D('User')->where($map)->find() ) {
                        $UserGroup->where($map)->delete();
                        $this->success('数据删除成功！', appUrl('m=User&a=groupList'));
                    } else {
                        $this->error('存在使用该组的用户，不能删除！');
                    }
                } else {
                    $this->error('非法操作！');
                }
                break;
        }

    }

    // 系统组添加
    public function groupAdd() {
        $UserGroup = D('UserGroup');

        if( $_POST['submit'] ) {

            if( $UserGroup->create() ) {
                $UserGroup->data_format();
                $sUrl = appUrl('m=User&a=groupAdd&group_id='.$_POST['group_id']);

                if( $UserGroup->group_id) {

                    if( $UserGroup->save() ) {
                        $this->success('数据保存成功！', $sUrl);
                    } else {
                        $this->error('数据保存失败！');
                    }
                }else{

                    if( $UserGroup->add() ) {
                        $this->success('数据添加成功！', $sUrl);
                    } else {
                        $this->error('数据添加失败！');
                    }

                }

            } else {
                $this->error('数据添加失败！');
            }
        } else {

            if( $_GET['group_id'] ) {
                $map['group_id'] = $_GET['group_id'];
                $obj = $UserGroup->where($map)->find();
                $this->assign('obj', $obj);
                $group_rules = explode(',', $obj['group_rules']);
                $this->assign('group_rules', $group_rules);
            }
            $this->display('user_groupAdd');

        }

    }


    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     *
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */

}
?>