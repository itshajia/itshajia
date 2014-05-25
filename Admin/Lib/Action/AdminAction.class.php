<?php
class AdminAction extends CommonAction {

    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 系统管理
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
    public function add() {
        $Admin = D('Admin');

        if ( $_POST['submit'] ) {
            if( !$Admin->create() ) return;
            $sUrl = appUrl('m=Admin&a=adminList');

            if ( !$Admin->create() ) return;
            if ( $Admin->uid ) {

                if( $Admin->save() ) {
                    $this->success('数据保存成功！', $sUrl);
                } else {
                    $this->error('数据保存失败！');
                }
                return;
            }

            $Admin->data_format();
            $Admin->addtime = time();
            $Admin->status = 1;

            if( $Admin->add() ) {
                $this->success('数据添加成功！', $sUrl);
            } else {
                $this->error('数据添加失败！');
            }

            return;
        }

        if( $_GET['uid'] ) {
            $map['uid'] = $_GET['uid'];
            $obj = $Admin->where($map)->find();
            $this->assign('obj', $obj);
        }
        // 获取用户组
        $UserGroup = D('UserGroup');
        $map = array();
        $map['is_admin'] = 1;
        $groupList = $UserGroup->where($map)->select();
        $this->assign('groupList', $groupList);
        $this->display('admin_add');
    }

    public function adminList() {
        $op = $_GET['op'] ? $_GET['op'] : 'list';
        $Admin = D('Admin');

        switch( $op ) {
            case 'list':
                if ( $_POST['submit'] ) {
                    $tool = $_POST['tool'];
                    $ids = $_POST['uid'];

                    if ( !count($ids) ) {
                        $this->error('请选择要操作的选项！');
                        exit();
                    }

                    $sUrl = appUrl('m=Admin&a='.ACTION_NAME);
                    switch( $tool ) {
                        case "delAll":
                            foreach( $ids as $k=>$v ) {
                                $map['uid'] = $k;
                                $Admin->where($map)->delete();
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
                $userList = $Admin->getListWithJoin( $map, $limit );
                $this->assign('userList', $userList);

                $pageHtml = page( $Admin->getCount($map), $page, $pagesize, 1);
                $this->assign('pageHtml', $pageHtml);

                $this->display('admin_list');
                break;

            case 'disabled':
                if( $_GET['uid'] ) {
                    $map['uid'] = $_GET['uid'];
                    $user = $Admin->where($map)->find();
                    $data['status'] = $user['status'] ? 0 : 1;

                    if( $Admin->where($map)->save($data) ) {
                        $this->success('数据保存成功！', appUrl('m=Admin&a=adminList'));
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
                    $Admin->where($map)->delete();
                    $this->success('数据删除成功！', appUrl('m=Admin&a=adminList'));
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
    public function groupList() {
        $op = $_GET['op'] ? $_GET['op'] : 'list';
        $UserGroup = D('UserGroup');

        switch( $op ) {
            case 'list':
                $map['is_admin'] = 1;
                $groupList = $UserGroup->where($map)->select();
                $this->assign('groupList', $groupList);
                $this->display('admin_groupList');
                break;

            case 'del':

                if( $_GET['group_id'] ) {
                    $map['group_id'] = $_GET['group_id'];
                    // 检测是否存在子项
                    if( !D('Admin')->where($map)->find() ) {
                        $UserGroup->where($map)->delete();
                        $this->success('数据删除成功！', appUrl('m=Admin&a=groupList'));
                    } else {
                        $this->error('存在使用该组的用户，不能删除！');
                    }
                } else {
                    $this->error('非法操作！');
                }
                break;
        }
    }

    public function groupAdd() {
        $UserGroup = D('UserGroup');

        if( $_POST['submit'] ) {

            if( $UserGroup->create() ) {
                $UserGroup->data_format();
                $sUrl = appUrl('m=Admin&a=groupAdd&group_id='.$_POST['group_id']);

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
            $this->display('admin_groupAdd');

        }
    }


    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * XXX
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
}
?>