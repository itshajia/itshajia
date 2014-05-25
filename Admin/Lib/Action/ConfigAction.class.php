<?php
class ConfigAction extends CommonAction{

    public function index() {

    }

    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 系统配置
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
    public function web() {
        $Config = D('Config');

        if ( $_POST['submit'] ) {
            $config = $_POST['config'];

            foreach( $config as $k=>$v ) {

                $map = array();
                $map['config_key'] = $k;
                $data = array();
                $data['config_key']= $k;
                $data['config_value'] = $v;

                $obj = $Config->where($map)->find();
                if ( $obj ) {
                    $Config->where($map)->save($data);
                } else {
                    $Config->add($data);
                }
            }

            $this->success('数据保存成功！', appUrl('m=Config&a=web'));
            return;
        }
        $list = $Config->select();
        $ConfigSet = array();
        foreach( $list as $k=>$v ) {
            $ConfigSet[$v['config_key']] = $v['config_value'];
        }
        $this->assign('Config', $ConfigSet);
        $this->display('web');
    }

    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * XXX
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */

}

?>