<?php
class CommonAction extends Action{

    public function _initialize(){
        // 选择皮肤
        $this->Skin = 'Skin_1';
        $this->assign('Skin', $this->Skin);

        $this->__run();
    }

    private function __run() {
        $this->checkWedId();
        $this->appAccess();
        $this->setBase();
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

    // 检测“婚庆ID”是否存在
    private function checkWedId() {
        if ( !$_GET['wed_id'] ) {
            $this->error('访问路径不正确！');
            exit();
        }
    }

    // 获取基本信息
    private function setBase() {
        $AppWedding = D('Common://AppWedding');
        $map['uid'] = $_GET['uid'];
        $map['wed_id'] = $_GET['wed_id'];
        $app = $AppWedding->where( $map )->find();

        $this->assign('title', $app['wed_name']);
    }

}
?>