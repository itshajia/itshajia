<?php
class AppAccessBehavior extends Behavior{

    public function run(&$return) {
        // 验证是否有权访问
        $return = $this->is_access();
    }

    private function is_access() {
        $AppApply = M('AppApply');
        $App = M('App');
        $map['app_ename'] = APP_NAME;
        $app = $App->where( $map )->find();

        $map = array();
        $map['uid'] = $_GET['uid'];
        $map['app_id'] = $app['app_id'];
        $appApply = $AppApply->where( $map )->find();

        if ( $appApply ) {

            // 收费应用，需检测，应用使用时间是否过期
            if ( $app['is_fee'] ) {

                $time = time();
                if ( $appApply['endtime'] > $time ) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        } else {
            return false;
        }





    }

}

?>