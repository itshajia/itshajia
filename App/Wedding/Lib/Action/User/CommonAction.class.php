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
            'menu_name' => '微婚庆',
            'menu_ename' => 'wedding'
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
                case "wedding";
                    $menuObj['tag'] = 'wedding';
                    $menuObj['menu_name'] = '微婚庆';
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
                'submenu_name' => '婚庆管理',
                'three_sons' => array(
                    array(
                        'resource_name' => '婚庆列表',
                        'resource_url' => appUrl('m=Index&a=wed&view=list'),
                        'ename' => 'wed'
                    )
                )
            )
        );

        if ( $_GET['enter'] && $_GET['wed_id']){
            $urlstr = "&enter=1&wed_id=".$_GET['wed_id'];
            $menu2 = array(
                array(
                    'submenu_name' => '基本配置',
                    'three_sons' => array(
                        array(
                            'resource_name' => '地图标注',
                            'resource_url' => appUrl('m=Index&a=bzmap').$urlstr,
                            'ename' => 'bzmap'
                        ),
                        array(
                            'resource_name' => '模板配置',
                            'resource_url' => appUrl('m=Index&a=tmpl').$urlstr,
                            'ename' => 'tmpl'
                        ),
                        array(
                            'resource_name' => '婚礼大屏幕',
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
                    'submenu_name' => '相册管理',
                    'three_sons' => array(
                        /*array(
                            'resource_name' => '相册分类',
                            'resource_url' => appUrl('m=Index&a=albumCate').$urlstr,
                            'ename' => 'albumCate'
                        ),*/
                        array(
                            'resource_name' => '相册列表',
                            'resource_url' => appUrl('m=Index&a=album&view=pic').$urlstr,
                            'ename' => 'album'
                        )
                    )
                )
            );



            $Wedding = D('Common://AppWedding');
            $map['uid'] = $_SESSION['_User']['uid'];
            $map['wed_id'] = $_GET['wed_id'];
            $obj = $Wedding->where($map)->find();

            // 祝福审核
            if ( $obj['is_check'] ) {
                $menu3 = array(
                    array(
                        'submenu_name' => '宾客祝福',
                        'three_sons' => array(
                            array(
                                'resource_name' => '待审核信息',
                                'resource_url' => appUrl('m=Index&a=bless&view=pend').$urlstr,
                                'ename' => 'bless_pend'
                            ),
                            array(
                                'resource_name' => '已拒绝信息',
                                'resource_url' => appUrl('m=Index&a=bless&view=refuse').$urlstr,
                                'ename' => 'bless_refuse'
                            ),
                            array(
                                'resource_name' => '已通过信息',
                                'resource_url' => appUrl('m=Index&a=bless&view=pass').$urlstr,
                                'ename' => 'bless_pass'
                            )
                        )
                    )
                );
            } else {
                $menu3 = array(
                    array(
                        'submenu_name' => '宾客祝福',
                        'three_sons' => array(
                            array(
                                'resource_name' => '祝福列表',
                                'resource_url' => appUrl('m=Index&a=bless&view=all').$urlstr,
                                'ename' => 'bless_all'
                            )
                        )
                    )
                );
            }





        }





        return array_merge($menu, $menu2, $menu3);
    }

    private function appEnter() {

    }




}
?>