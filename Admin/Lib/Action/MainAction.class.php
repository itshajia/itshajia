<?php
/**
 * 后台类似 “欢迎页面” 的所有请求
 */
class MainAction extends CommonAction {

    public function index() {
        $this->display('index');
    }
}
?>