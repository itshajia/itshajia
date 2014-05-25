<?php
class CommonAction extends Action{

    public function _initialize() {

        $this->loginCheck();
        $this->accessCheck();
        B('AuthCheck');

        $this->__run();
    }

    public function __run() {
        $this->setUserInfo();
        $this->setMenu();
    }

    /**
     * 验证用户是否登录后台
     */
    public function loginCheck() {
        $return = false;
        B('LoginCheck', $return);

        if( !$return &&  ACTION_NAME != 'login') {
            $this->redirect(appUrl('m=Index&a=login'));
        }

        if( $return && ACTION_NAME == 'login') {
            $this->redirect(appUrl(''));
        }

    }

    /**
     * 验证用户的访问权限
     */
    public function accessCheck() {
        $return = false;
        B('ResourceCheck', $return);

        if( !$return ) {
            $this->error('您无权访问该模块！', appUrl('m=Admin&a=Main'));
        }
    }

    /**
     * 设置用户登录后的信息
     */
    public function setUserInfo() {
        $this->assign('title', 'UioWeb后台管理');
        $this->assign('adminUser', session('_adminUser'));
    }

    /**
     * 后台Menu数组
     */
    public function setMenu() {
        $Menu = D('Menu');
        $map['status'] = 1;

        // 管理员获取所有 Menu 列表
        if ($_SESSION['_adminUser']['group_id']==1){
            $menuList = $Menu->where($map)->order(array('listorder'))->select();
        }else {
            $menuList = $Menu->getListWithRules();
        }
        $menuList = $this->handleMenu($menuList);
        $this->assign('menuList', $menuList);
        $leftMenu = $this->setLeftMenu( $menuList );
        //var_dump($leftMenu);
        $this->assign('leftMenu', $leftMenu);
    }

    /**
     * 对获取后的 Menu 进行处理
     */
    public function handleMenu( $r ) {
        $arr = array();

        // 添加便捷操作
        array_push($arr, array(
            'menu_name' => '快捷操作',
            'menu_ename' => 'shortcuts'
        ));

        for ( $i=0;$i<count($r);$i++ ) {
            array_push($arr, $r[$i]);
        }

        if( C('ADMIN_DEVELOP') && $_SESSION['_adminUser']['group_id']==1 ) {
            array_push($arr, array(
                'menu_name' => '开发模块',
                'menu_ename' => 'develop'
            ));
        }

        return $arr;
    }

    /**
     * 左侧栏 获取
     */
    public function setLeftMenu( $r ) {
        $leftMenu = array();
        $Submenu = D('Submenu');
        $SubmenuResource = D('SubmenuResource');

        for( $i=0;$i<count($r);$i++ ) {
            $menuObj = array();

            switch ( $r[$i]['menu_ename'] ){
                case "shortcuts";
                    $menuObj['tag'] = 'shortcuts';
                    $menuObj['menu_name'] = '快捷操作';
                    $menuObj['show'] = true;
                    $menuObj['sons'] = array(
                        array(
                            'submenu_name' => '快捷操作',
                            'three_sons' => $this->shortcuts()
                        )
                    );
                    break;

                case "develop";
                    if( C('ADMIN_DEVELOP') ) {
                        $menuObj['tag'] = 'develop';
                        $menuObj['menu_name'] = '开发模式';
                        $menuObj['sons'] = $this->develop();
                    }
                    break;

                default :
                    $menuObj['tag'] = $r[$i]['menu_ename'];
                    $menuObj['menu_name'] = $r[$i]['menu_name'];
                    $sons = $Submenu->getListByMId( $r[$i]['menu_id'] );
                    for($j=0;$j<count($sons);$j++) {
                        $sons[$j]['three_sons'] = $SubmenuResource->getListBySId($sons[$j]['submenu_id']);
                    }
                        //var_dump($sons);
                    $menuObj['sons'] = $sons;
                    break;
            }
            array_push($leftMenu, $menuObj);
        }
        //var_dump($leftMenu);
        return $leftMenu;

    }

    /**
     * 快捷操作
     */
    private function shortcuts() {
        $Shortcuts = D('Shortcuts');
        return $Shortcuts->listByUid();
    }

    /**
     * 开发模式
     */
    private function develop() {
        return array(
            array(
                'submenu_name' => '开发模式',
                'three_sons' => array(
                    array(
                        'resource_name' => '菜单管理',
                        'resource_url' => appUrl('m=Develop&a=menu&view=nav')
                    ),
                    array(
                        'resource_name' => '文章分类管理',
                        'resource_url' => appUrl('m=Develop&a=article&view=module')
                    )
                )
            )
        );
    }
}
?>