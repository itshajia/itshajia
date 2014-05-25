<?php
class IndexAction extends CommonAction {

    public function _empty() {
        $this->cardset();
    }

    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 基本配置
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
    public function cardset() {
        if ( $_POST['submit'] ) {
            return;
        }
        $this->display('cardset');
    }

    public function preview() {
        if ( $_POST['submit'] ) {
            return;
        }
        $this->display('preview');
    }

    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 会员管理
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
    public function member() {
        $view = $_GET['view'] ? $_GET['view'] : 'list';

        switch ( $view ) {
            case "add":
                if ( $_POST['submit'] ) {
                    return;
                }
                $this->display('member_add');
                break;

            case "list":
                if ( $_POST['submit'] ) {
                    return;
                }
                $this->display('member_list');
                break;

            case "del":
                break;
        }
    }

    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 积分管理
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
    public function score() {
        $view = $_GET['view'] ? $_GET['view'] : 'list';

        switch( $view ) {
            case "list":
                if ( $_POST['submit'] ) {
                    return;
                }
                $this->display('score_list');
                break;
        }
    }

    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 订单管理
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
    public function order() {
        $view = $_GET['view'] ? $_GET['view'] : 'list';

        switch( $view ) {
            case "list":
                if ( $_POST['submit'] ) {
                    return;
                }
                $this->display('order_list');
                break;
        }
    }
}
?>