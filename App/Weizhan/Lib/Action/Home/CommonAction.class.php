<?php
class CommonAction extends Action{

    public function _initialize(){
        // 选择皮肤
        $this->Skin = 'Skin_1';
        $this->assign('Skin', $this->Skin);

        $this->__run();
    }

    private function __run() {
        $this->appAccess();
        $this->setBase();
        $this->setTop();
    }

    // 检测应用的访问权限
    private function appAccess() {
        $return = false;
        B('AppAccess', $return);

        if( !$return ) {
            //$this->redirect( appUrl('m=Index&a=login') );
            $this->error('该应用没有开启，或已过使用期限！');
            exit();
        }
    }

    // 获取基本信息
    private function setBase() {
        $AppWz = D('Common://AppWz');
        $map['uid'] = $_GET['uid'];
        $app = $AppWz->where( $map )->find();

        $this->assign('title', $app['wz_name']);
    }

    // 内页顶部数据获取
    private function setTop() {
        $Column = D('Common://Column');
        $map['uid'] = $_GET['uid'];
        $map['is_show'] = 1;
        $map['app_name'] = 'wz';
        $topList = $Column->order(array('is_home'=>'desc', 'sort'=> 'asc'))->where($map)->select();
        $this->assign('topList', $topList);
    }
}
?>