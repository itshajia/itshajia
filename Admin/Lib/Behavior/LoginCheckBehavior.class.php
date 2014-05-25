<?php
class LoginCheckBehavior extends Behavior{

    protected $options = array(
        'USER_LOGIN_ON' => true
    );

    public function run(&$return) {
        $return = $this->is_login(); // 验证是否登录
    }

    private function is_login() {
        // 没有登录
        if( !isset($_SESSION['_adminUser']) ) {
            return false;
        } else {
            return true;
        }
    }

}
?>