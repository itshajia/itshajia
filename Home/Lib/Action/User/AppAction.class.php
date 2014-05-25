<?php
class AppAction extends CommonAction{

    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 我的应用
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
    public function my() {
        if ( $_POST['submit'] ) {
            return;
        }
        $App = D('App');
        $page = $_GET['page'] ? $_GET['page'] : 1;
        $pagesize = 21;
        $pageset = ( $page -1) * $pagesize;
        $limit = array('page'=> $pageset, 'pagesize'=> $pagesize);

        $my = $App->getMyList($limit);
        $list = $my['list'];
        //var_dump($list);
        $map = $my['map'];
        $this->assign('list', $list);

        $pageHtml = page( $App->getCount($map), $page, $pagesize);
        $this->assign('pageHtml', $pageHtml);
        $this->display('app_my');
    }


    public function keywords() {
        if ( $_POST['submit'] ) {
            return;
        }
        $this->display('app_keywords');
    }

    public function nopass() {
        if ( $_POST['submit'] ) {
            return;
        }
        $App = D('App');
        $page = $_GET['page'] ? $_GET['page'] : 1;
        $pagesize = 10;
        $pageset = ( $page -1) * $pagesize;
        $limit = array('page'=> $pageset, 'pagesize'=> $pagesize);

        $my = $App->getNopassList($limit);
        $list = $my['list'];
        //var_dump($list);
        $map = $my['map'];
        $this->assign('list', $list);

        $pageHtml = page( $App->getCount($map), $page, $pagesize);
        $this->assign('pageHtml', $pageHtml);
        $this->display('app_nopass');
    }

    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 应用商店
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
    public function shop() {
        $App = D('App');
        $this->shop_tool();

        if ( $_POST['submit'] ) {
            return;
        }

        $page = $_GET['page'] ? $_GET['page'] : 1;
        $pagesize = 21;
        $pageset = ( $page -1) * $pagesize;
        $limit = array('page'=> $pageset, 'pagesize'=> $pagesize);

        if( $_GET['type_id'] ) {
            $map['type_id'] = $_GET['type_id'];
            $AppType = D('AppType');
            $appType = $AppType->where($map)->find();
            $this->assign('appType', $appType);
        }

        if( isset($_GET['is_fee']) ) $map['is_fee'] = $_GET['is_fee'];
        $map['status'] = 1;
        $list = $App->getList($map, $limit);
        $this->assign('list', $list);

        $pageHtml = page( $App->getCount($map), $page, $pagesize);
        $this->assign('pageHtml', $pageHtml);
        $this->display('app_shop');
    }

    // 应用查看
    public function show() {
        if ( !$_GET['app_id'] ) $this->error('访问地址不正确！');
        $App = D('App');
        $map['app_id'] = $_GET['app_id'];
        $map['status'] = 1;
        $map['uid'] = $_SESSION['_User']['uid'];
        $obj = $App->where($map)->find();
        $obj['go'] = appGoUrl($obj['app_ename']);

        $AppApply = D('AppApply');
        $appApply = $AppApply->where($map)->order(array('addtime'=>'desc'))->find();

        if ( $appApply ) $obj['is_apply'] = 1;

        $AppApplyRecord = D('AppApplyRecord');
        $map = array();
        $map['app_id'] = $obj['app_id'];
        $map['is_check'] = 0;
        $appApplyRecord = $AppApplyRecord->where($map)->find();
        if ( $appApplyRecord ) $obj['is_check'] = 0;
        $this->assign('obj', $obj);
        $this->display('app_show');
    }

    // 应用商店工具栏
    private function shop_tool() {
        $App = D('App');
        $map = array();
        if( $_GET['type_id'] ) $map['type_id'] = $_GET['type_id'];
        $tools = array(
            array(
                'tag' => 'all',
                'name' => '所有应用('.$App->getCount($map).')',
                'url' =>  appUrl('m=App&a=shop'). ( $_GET['type_id'] ? '&type_id='.$_GET['type_id'] : '')
            ),
            array(
                'tag' => 'fee',
                'name' => '收费应用('.$App->getCount(array_merge($map, array('is_fee'=>1))).')',
                'url' => appUrl('m=App&a=shop').( $_GET['type_id'] ? '&type_id='.$_GET['type_id'] : '').'&is_fee=1'
            ),
            array(
                'tag' => 'free',
                'name' => '免费应用('.$App->getCount(array_merge($map, array('is_fee'=>0))).')',
                'url' => appUrl('m=App&a=shop'). ( $_GET['type_id'] ? '&type_id='.$_GET['type_id'] : '').'&is_fee=0'
            )
        );
        $this->assign('tools', $tools);
    }

    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 订单管理
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
    public function order() {
        $AppApplyRecord = D('AppApplyRecord');

        if ( $_POST['submit'] ) {
            return;
        }

        $page = $_GET['page'] ? $_GET['page'] : 1;
        $pagesize = 10;
        $pageset = ( $page -1) * $pagesize;
        $limit = array('page'=> $pageset, 'pagesize'=> $pagesize);

        $map['uid'] = $_SESSION['_User']['uid'];
        $list = $AppApplyRecord->getMyOrderList($map,$limit);

        $pageHtml = page( $AppApplyRecord->getCount($map), $page, $pagesize);
        $this->assign('pageHtml', $pageHtml);
        $this->assign('list', $list);
        $this->display('app_order');
    }

    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * XXX
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
}
?>