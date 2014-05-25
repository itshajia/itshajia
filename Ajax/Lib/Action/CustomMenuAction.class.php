<?php
class CustomMenuAction extends Action{

    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 自定义菜单添加
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
    public function menuAdd() {
        $CustomMenu = D('CustomMenu');

        if ( $_POST['menu_id'] ) {
            $CustomMenu->create();

            if ( $CustomMenu->save() ) {
                $success = true;
                $msg = "数据保存成功！";
            } else {
                $success = false;
                $msg = "数据保存失败！";
            }
        } else {
            $CustomMenu->create();
            $CustomMenu->addtime = time();
            $CustomMenu->uid = $_SESSION['_User']['uid'];
            $CustomMenu->child_count = 0;

            if ( $CustomMenu->add() ) {
                $this->changeChildCount( $_POST['parent_id'], 1);
                $success = true;
                $msg = "数据添加成功！";
            } else {
                $success = false;
                $msg = "数据添加失败！";
            }
        }

        $dataJson = array(
            'success' => $success,
            'msg' => $msg
        );

        echo json_encode( $dataJson );
    }

    private function getChildCount( $map = array() ) {
        $list = $this->where( $map )->select();
        return  $list ? count($list) : 0;
    }

    public function getMenu() {
        if ( $_POST['id'] ) {
            $CustomMenu = M('CustomMenu');
            $map['uid'] = $_SESSION['_User']['uid'];
            $map['menu_id'] = $_POST['id'];
            $menu = $CustomMenu->where($map)->find();

            if ($menu['parent_id']) {
                $map['menu_id'] = $menu['parent_id'];
                $menu_p = $CustomMenu->where($map)->find();
                $menu['title_p'] = $menu_p['title'];
            } else {
                $menu['title_p'] = "顶级菜单";
            }


            if ( $menu ) {
                $success = true; $msg = "获取成功！";
            } else {
                $success = false; $msg = "该菜单不存在！";
            }

        } else {
            $success = false;
            $msg = "请求地址不正确！";
        }

        $dataJson = array(
            'success' => $success,
            'msg' => $msg,
            'fdata' => $menu
        );

        echo json_encode( $dataJson );
    }

    public function menuDel() {
        if ( $_POST['id'] ) {
            $CustomMenu = M('CustomMenu');
            $map['uid'] = $_SESSION['_User']['uid'];
            $map['parent_id'] = $_POST['id'];

            if( $CustomMenu->where($map)->find() ) {
                $success = false;
                $msg = "该菜单下存在子菜单，请先删除所有子菜单！";
            } else {

                unset($map['parent_id']);
                $map['menu_id'] = $_POST['id'];
                $menuObj = $CustomMenu->where($map)->find();
                if ( $CustomMenu->where($map)->delete() ) {
                    $this->changeChildCount( $menuObj['parent_id'], -1);
                    $success = true;
                    $msg = "删除成功！";
                } else {
                    $success = false;
                    $msg = "删除失败！";
                }
            }


        } else {
            $success = false;
            $msg = "请求地址不正确！";
        }
        $dataJson = array(
            'success' => $success,
            'msg' => $msg
        );

        echo json_encode( $dataJson );
    }

    private function changeChildCount( $menu_id, $type ) {
        $CustomMenu = D('CustomMenu');
        $map['menu_id'] = $menu_id;
        $map['uid'] = $_SESSION['_User']['uid'];

        switch ( $type ) {
            case "1";
                $CustomMenu->where($map)->setInc('child_count');
                break;

            case "-1":
                $CustomMenu->where($map)->setDec('child_count');
                break;
        }
    }



    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * XXXX
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
}

?>