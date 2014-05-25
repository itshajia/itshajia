<?php
class CommonAction extends Action{

    public function _initialize(){
        $this->__run();
    }

    private function __run() {
        $this->setMenu();
    }

    /**
     * 用户中心Menu数组
     */
    public function setMenu() {
        $menuList = $this->handleMenu();
        $this->assign('menuList', $menuList);

        $leftMenu = $this->setLeftMenu( $menuList );
        $this->assign('leftMenu', $leftMenu);
    }

    /**
     * 对获取后的 Menu 进行处理
     */
    public function handleMenu( ) {
        $arr = array();

        array_push($arr, array(
            'menu_name' => '会员卡',
            'menu_ename' => 'card'
        ));
        return $arr;
    }

    /**
     * 左侧栏 获取
     */
    public function setLeftMenu( $r ) {
        $leftMenu = array();

        for( $i=0;$i<count($r);$i++ ) {
            $menuObj = array();

            switch ( $r[$i]['menu_ename'] ){
                case "card";
                    $menuObj['tag'] = 'supermarket';
                    $menuObj['menu_name'] = '会员卡';
                    $menuObj['show'] = 1;
                    $menuObj['sons'] = $this->app();
                    break;

            }
            array_push($leftMenu, $menuObj);
        }
        return $leftMenu;
    }

    /**
     * 应用模块
     */
    private function app() {
        return array(
            array(
                'submenu_name' => '会员卡配置',
                'three_sons' => array(
                    array(
                        'resource_name' => '卡面设置',
                        'resource_url' => appUrl('m=Index&a=cardset'),
                        'ename' => 'cardset'
                    ),
                    array(
                        'resource_name' => '效果预览',
                        'resource_url' => appUrl('m=Index&a=preview'),
                        'ename' => 'preview'
                    )
                )
            ),
            array(
                'submenu_name' => '会员管理',
                'three_sons' => array(
                    array(
                        'resource_name' => '会员列表',
                        'resource_url' => appUrl('m=Index&a=member'),
                        'ename' => 'member'
                    )
                )
            ),
            array(
                'submenu_name' => '积分管理',
                'three_sons' => array(
                    array(
                        'resource_name' => '积分列表',
                        'resource_url' => appUrl('m=Index&a=score'),
                        'ename' => 'score'
                    )
                )
            ),
            array(
                'submenu_name' => '订单管理',
                'three_sons' => array(
                    array(
                        'resource_name' => '订单列表',
                        'resource_url' => appUrl('m=Index&a=order'),
                        'ename' => 'order'
                    )
                )
            )
        );
    }




}
?>