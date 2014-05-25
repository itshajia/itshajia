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
            'menu_name' => '活动抽奖',
            'menu_ename' => 'lottery'
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
                case "lottery";
                    $menuObj['tag'] = 'lottery';
                    $menuObj['menu_name'] = '活动抽奖';
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
        $menu = array();
        $menu2 = array();
        $menu3 = array();

        $menu = array(
            array(
                'submenu_name' => '活动管理',
                'three_sons' => array(
                    array(
                        'resource_name' => '活动列表',
                        'resource_url' => appUrl('m=Index&a=lottery&view=list'),
                        'ename' => 'lottery'
                    )
                )
            )
        );

        if ( $_GET['enter'] && $_GET['lot_id']){
            $urlstr = "&enter=1&lot_id=".$_GET['lot_id'];
            $menu2 = array(
                array(
                    'submenu_name' => '基本配置',
                    'three_sons' => array(
                        array(
                            'resource_name' => '奖项设置',
                            'resource_url' => appUrl('m=Index&a=prize').$urlstr,
                            'ename' => 'prize'
                        ),
                        array(
                            'resource_name' => '抽奖入口',
                            'resource_url' => appUrl('m=Index&a=entrance').$urlstr,
                            'ename' => 'entrance'
                        ),
                        array(
                            'resource_name' => '活动大屏幕',
                            'resource_url' => appUrl('m=Index&a=screen').$urlstr,
                            'ename' => 'screen'
                        ),
                        array(
                            'resource_name' => '获取二维码',
                            'resource_url' => appUrl('m=Index&a=erwm').$urlstr,
                            'ename' => 'erwm'
                        ),
                        array(
                            'resource_name' => '效果预览',
                            'resource_url' => appUrl('m=Index&a=preview').$urlstr,
                            'ename' => 'preview'
                        )
                    )
                ),
                array(
                    'submenu_name' => '数据管理',
                    'three_sons' => array(
                        array(
                            'resource_name' => '报名人数',
                            'resource_url' => appUrl('m=Index&a=signUp').$urlstr,
                            'ename' => 'signUp'
                        ),
                        array(
                            'resource_name' => '中奖名单',
                            'resource_url' => appUrl('m=Index&a=win').$urlstr,
                            'ename' => 'win'
                        )
                    )
                )
            );





        }





        return array_merge($menu, $menu2);
    }

    private function appEnter() {

    }




}
?>