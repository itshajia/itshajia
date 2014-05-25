<?php
class WeizhanAction extends Action{

    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 栏目操作
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
    public function columnReset() {

        $Column = M('Column');
        $map['uid'] = $_SESSION['_User']['uid'];
        $map['app_name'] = 'wz';
        $map['is_sys'] = 1;
        $Column->where( $map )->delete();
        $columnArr = $this->getInitColumn( $_SESSION['_User']['uid'] );

        foreach( $columnArr as $k=>$v ) {
            $v['addtime'] = time();
            $Column->add( $v );
        }
        $success = true;
        $msg = "系统栏目初始化成功！";

        $dataJson = array(
            'success' => $success,
            'msg' => $msg
        );
        echo json_encode( $dataJson );
    }

    private function getInitColumn( $uid ) {
        $Bzmap = M('Bzmap');
        $map['uid'] = $uid;
        $map['app_name'] = 'wz';
        $obj = $Bzmap->order(array('sort'))->where()->find();
        $maparr=explode(',',$obj['bzpoint']);

        return array(
            array(
                'uid' => $uid, 'column_name' => '首页', 'css_icon' => '',
                'image' => '',
                'is_sys' => 1, 'is_show' => 1, 'is_home' => 1, 'sort' => 0,
                'linkurl' => 'index.php?uid='.$uid,
                'description' => '',
                'app_name' => 'wz'
            ),
            array(
                'uid' => $uid, 'column_name' => '公司简介', 'css_icon' => '',
                'image' => '',
                'is_sys' => 1, 'is_show' => 1, 'is_home' => 0, 'sort' => 1,
                'linkurl' => 'index.php?m=Index&a=about&uid='.$uid,
                'description' => '',
                'app_name' => 'wz'
            ),
            array(
                'uid' => $uid, 'column_name' => '产品中心', 'css_icon' => '',
                'image' => '',
                'is_sys' => 1, 'is_show' => 1, 'is_home' => 0, 'sort' => 2,
                'linkurl' => 'index.php?m=Index&a=pro&uid='.$uid,
                'description' => '',
                'app_name' => 'wz'
            ),
            array(
                'uid' => $uid, 'column_name' => '新闻中心', 'css_icon' => '',
                'image' => '',
                'is_sys' => 1, 'is_show' => 1, 'is_home' => 0, 'sort' => 3,
                'linkurl' => 'index.php?m=Index&a=news&uid='.$uid,
                'description' => '',
                'app_name' => 'wz'
            ),
            array(
                'uid' => $uid, 'column_name' => '联系我们', 'css_icon' => '',
                'image' => '',
                'is_sys' => 1, 'is_show' => 1, 'is_home' => 0, 'sort' => 4,
                'linkurl' => 'index.php?m=Index&a=contact&uid='.$uid,
                'description' => '',
                'app_name' => 'wz'
            ),
            array(
                'uid' => $uid, 'column_name' => '一键拨号', 'css_icon' => '',
                'image' => '',
                'is_sys' => 1, 'is_show' => 1, 'is_home' => 0, 'sort' => 5,
                'linkurl' => 'tel:'.$obj['tel'],
                'description' => '',
                'app_name' => 'wz'
            ),
            array(
                'uid' => $uid, 'column_name' => '一键导航', 'css_icon' => '',
                'image' => '',
                'is_sys' => 1, 'is_show' => 1, 'is_home' => 0, 'sort' => 6,
                'linkurl' => "http://api.map.baidu.com/marker?location={$maparr[1]},{$maparr[0]}&title={$obj['company']}&name={$obj['company']}&content={$obj['address']}&output=html&src=weiba|weiweb",
                'description' => '',
                'app_name' => 'wz'
            )
        );
    }

    public function columnAdd() {
        $Column = M('Column');

        if ( $_POST['column_id'] ) {
            $Column->create();

            if ( $Column->save() ) {
                $success = true;
                $msg = "保存成功！";
            } else {
                $success = false;
                $msg = "保存失败！";
            }

        } else {

            $Column->create();
            $Column->uid = $_SESSION['_User']['uid'];
            $Column->app_name = 'wz';
            $Column->addtime = time();
            $Column->is_sys = 0;
            $Column->is_home = 0;

            if ( $Column->add()) {
                $success = true;
                $msg = "添加成功！";
            } else {
                $success = false;
                $msg = "添加失败！";
            }

        }

        $dataJson = array(
            'success' => $success,
            'msg' => $msg
        );

        echo json_encode( $dataJson );
    }

    public function getColumn() {
        if ( $_POST['id'] ) {
            $Column = M('Column');
            $map['uid'] = $_SESSION['_User']['uid'];
            $map['column_id'] = $_POST['id'];
            $map['app_name'] = 'wz';
            $column = $Column->where($map)->find();

            if ( $column ) {
                $success = true; $msg = "获取成功！";
            } else {
                $success = false; $msg = "该栏目不存在！";
            }

        } else {
            $success = false;
            $msg = "请求地址不正确！";
        }

        $dataJson = array(
            'success' => $success,
            'msg' => $msg,
            'column' => $column
        );

        echo json_encode( $dataJson );
    }

    public function delColumn() {
        if ( $_POST['id'] ) {
            $Column = M('Column');
            $map['uid'] = $_SESSION['_User']['uid'];
            $map['column_id'] = $_POST['id'];
            $map['is_sys'] = 0;
            $map['app_name'] = 'wz';

            if ( $Column->where($map)->delete() ) {
                $success = true;
                $msg = "删除成功！";
            } else {
                $success = false;
                $msg = "删除失败！";
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

    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 列表异步获取
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
    public function moreNews() {
        if ( $_POST['i'] && $_POST['uid'] ) {
            $News = M('News');
            $NewsCate = D('NewsCate');

            $map['uid'] = $_POST['uid'];
            $map['app_name'] = 'wz';
            if ( $_GET['cate_id'] ) $map['cate_id'] = array('in', join(',', $NewsCate->getUnlimitIds(array(),array(), $_GET['cate_id'])));
            $list = $News->where( $map )->limit($_POST['i'], 10)->select();
            foreach( $list as $k=>$v ) {
                $list[$k]['linkurl'] = "?m=Index&a=newsShow&id=".$v['news_id']."&uid=".$_GET['uid'];;
            }
        } else {
            $success = false;
            $msg = "请求地址不正确！";
        }

        $dataJson = array(
            'success' => $success,
            'msg' => $msg,
            'list' => $list
        );
        echo json_encode( $dataJson );
    }

    public function morePro() {
        if ( $_POST['i'] && $_POST['uid'] ) {
            $Pro = M('Pro');
            $ProCate = D('ProCate');

            $map['uid'] = $_POST['uid'];
            $map['app_name'] = 'wz';
            if ( $_GET['cate_id'] ) $map['cate_id'] = array('in', join(',', $ProCate->getUnlimitIds(array(),array(), $_GET['cate_id'])));
            $list = $Pro->where( $map )->limit($_POST['i'], 10)->select();
            foreach( $list as $k=>$v ) {
                $list[$k]['linkurl'] = "?m=Index&a=proShow&id=".$v['pro_id']."&uid=".$_GET['uid'];;
            }
        } else {
            $success = false;
            $msg = "请求地址不正确！";
        }

        $dataJson = array(
            'success' => $success,
            'msg' => $msg,
            'list' => $list
        );
        echo json_encode( $dataJson );
    }

    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * XXXX
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
}
?>