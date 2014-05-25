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
            'menu_name' => '微超市',
            'menu_ename' => 'supermarket'
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
                case "supermarket";
                    $menuObj['tag'] = 'supermarket';
                    $menuObj['menu_name'] = '微超市';
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
                'submenu_name' => '微超市配置',
                'three_sons' => array(
                    array(
                        'resource_name' => '基本信息设置',
                        'resource_url' => appUrl('m=Index&a=basic'),
                        'ename' => 'basic'
                    ),
                    array(
                        'resource_name' => '首页广告',
                        'resource_url' => appUrl('m=Index&a=ad'),
                        'ename' => 'ad'
                    ),
                    array(
                        'resource_name' => '地图标注',
                        'resource_url' => appUrl('m=Index&a=bzmap'),
                        'ename' => 'bzmap'
                    ),
                    array(
                        'resource_name' => '模板配置',
                        'resource_url' => appUrl('m=Index&a=tmpl'),
                        'ename' => 'tmpl'
                    ),
                    array(
                        'resource_name' => '效果预览',
                        'resource_url' => appUrl('m=Index&a=preview'),
                        'ename' => 'preview'
                    )
                )
            ),
            array(
                'submenu_name' => '商品管理',
                'three_sons' => array(
                    array(
                        'resource_name' => '商品分类',
                        'resource_url' => appUrl('m=Index&a=proCate'),
                        'ename' => 'proCate'
                    ),
                    array(
                        'resource_name' => '商品列表',
                        'resource_url' => appUrl('m=Index&a=pro'),
                        'ename' => 'pro'
                    )
                )
            ),
            array(
                'submenu_name' => '新闻管理',
                'three_sons' => array(
                    array(
                        'resource_name' => '新闻分类',
                        'resource_url' => appUrl('m=Index&a=newsCate'),
                        'ename' => 'newsCate'
                    ),
                    array(
                        'resource_name' => '新闻列表',
                        'resource_url' => appUrl('m=Index&a=news'),
                        'ename' => 'news'
                    )
                )
            ),
            array(
                'submenu_name' => '单页管理',
                'three_sons' => array(
                    array(
                        'resource_name' => '单页列表',
                        'resource_url' => appUrl('m=Index&a=page'),
                        'ename' => 'page'
                    )
                )
            )
        );
    }




}
?>