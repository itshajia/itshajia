<?php
class CommonAction extends Action {

    public function _initialize() {
        $this->loginCheck();
        $this->__run();
    }

    public function __run() {
        $this->setUserInfo();
        $this->setMenu();
        $this->pullMsg();
    }

    /**
     * 验证用户是否登录 用户中心
     */
    public function loginCheck() {
        $return = false;
        B('LoginCheck', $return);
        //$act = ($_GET['_URL_'] && $_GET['_URL_'][1]) ? $_GET['_URL_'][1] : '';
        $act = ACTION_NAME;

        if( !$return &&  $act != 'login') {
            $this->redirect( appUrl('m=Index&a=login') );
        }

        if( $return && $act == 'login') {
            $this->redirect( appUrl('') );
        }

    }

    /**
     * 设置用户登录后的信息
     */
    public function setUserInfo() {
        $this->assign('title', 'UioWeb用户中心');
        $this->assign('User', session('_User'));
    }

    /**
     * 推送用户MSG
     */
    public function pullMsg() {
        $SubscribeUser = M('SubscribeUser');

        /*$list0 = $SubscribeUser->select();
        foreach( $list0 as $k=>$v ) {
            $map0 = array();
            $data0 = array();
            $map0['s_id'] = $v['s_id'];
            $data0['s_date'] = date('Y-m-d', $v['addtime']);
            $SubscribeUser->where($map0)->save($data0);
        }*/


        $map['uid'] = $_SESSION['_User']['uid'];
        $map['s_date'] = date('Y-m-d', time());
        //var_dump($map);
        $list = $SubscribeUser->where( $map )->select();
        $this->assign('subscribeCount', count($list));
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
            'menu_name' => '用户资料',
            'menu_ename' => 'user'
        ));

        array_push($arr, array(
            'menu_name' => '应用中心',
            'menu_ename' => 'app'
        ));

        array_push($arr, array(
            'menu_name' => '消息管理',
            'menu_ename' => 'info'
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
                case "user";
                    $menuObj['tag'] = 'user';
                    $menuObj['menu_name'] = '用户资料';
                    $menuObj['show'] = true;
                    $menuObj['sons'] = $this->user();
                    break;

                case "app";
                    $menuObj['tag'] = 'app';
                    $menuObj['menu_name'] = '应用中心';
                    $menuObj['sons'] = $this->app();
                    break;

                case "info":
                    $menuObj['tag'] = 'info';
                    $menuObj['menu_name'] = "消息管理";
                    $menuObj['sons'] = $this->info();
                    break;

            }
            array_push($leftMenu, $menuObj);
        }
        return $leftMenu;
    }

    /**
     * 用户模块
     */
    private function user() {
        return array(
            array(
                'submenu_name' => '资料管理',
                'three_sons' => array(
                    array(
                        'resource_name' => '基本信息',
                        'resource_url' => appUrl('m=User&a=basic')
                    ),
                    array(
                        'resource_name' => '公众号管理',
                        'resource_url' => appUrl('m=User&a=comNum')
                    ),
                    array(
                        'resource_name' => '修改密码',
                        'resource_url' => appUrl('m=User&a=passwordModify')
                    )
                )
            ),
            array(
                'submenu_name' => '消息回复',
                'three_sons' => array(
                    array(
                        'resource_name' => '回复设置',
                        'resource_url' => appUrl('m=User&a=replySet')
                    ),
                    array(
                        'resource_name' => '文本素材管理',
                        'resource_url' => appUrl('m=User&a=textReply')
                    ),
                    array(
                        'resource_name' => '图文素材管理',
                        'resource_url' => appUrl('m=User&a=imgReply')
                    )
                )
            ),
            array(
                'submenu_name' => '自定义菜单',
                'three_sons' => array(
                    array(
                        'resource_name' => '授权设置',
                        'resource_url' => appUrl('m=User&a=menuAuth')
                    ),
                    array(
                        'resource_name' => '菜单设置',
                        'resource_url' => appUrl('m=User&a=menuSet')
                    )
                )
            )
        );
    }

    /**
     * 应用模块
     */
    private function app() {
        $AppApply = D('AppApply');
        $map['uid'] = $_SESSION['_User']['uid'];
        $map['status'] = 1;
        return array(
            array(
                'submenu_name' => '我的应用',
                'three_sons' => array(
                    array(
                        'resource_name' => '我的应用 ('.$AppApply->getCount($map).')',
                        'resource_url' => appUrl('m=App&a=my')
                    ),
                    array(
                        'resource_name' => '应用关键字管理',
                        'resource_url' => appUrl('m=App&a=keywords')
                    ),
                    array(
                        'resource_name' => '审核中应用',
                        'resource_url' => appUrl('m=App&a=nopass')
                    )
                )
            ),
            array(
                'submenu_name' => '应用商店',
                'three_sons' => $this->getAppTypeMenu()
            ),
            array(
                'submenu_name' => '订单管理',
                'three_sons' => array(
                    array(
                        'resource_name' => '订单列表',
                        'resource_url' => appUrl('m=App&a=order')
                    )
                )
            )
        );
    }

    private function getAppTypeMenu() {
        $AppType = D('AppType');
        $typeList = $AppType->order(array('listorder'))->select();
        $typeMenu = array();

        array_push($typeMenu, array(
            'resource_name' => '所有应用',
            'resource_url' => appUrl('m=App&a=shop')
        ));
        foreach( $typeList as $k=>$v ) {
            array_push($typeMenu, array(
                'resource_name' => $v['type_name'],
                'resource_url' => appUrl('m=App&a=shop').'&type_id='.$v['type_id']
            ));
        }
        return $typeMenu;
    }

    /**
     * 消息模块
     */
    private function info() {
        return array(
            array(
                'submenu_name' => '实时消息',
                'three_sons' => array(
                    array(
                        'resource_name' => '全部消息',
                        'resource_url' => appUrl('m=Info&a=realTime&view=all')
                    ),
                    array(
                        'resource_name' => '今天',
                        'resource_url' => appUrl('m=Info&a=realTime&view=today')
                    ),
                    array(
                        'resource_name' => '昨天',
                        'resource_url' => appUrl('m=Info&a=realTime&view=yesterday')
                    ),
                    array(
                        'resource_name' => '前天',
                        'resource_url' => appUrl('m=Info&a=realTime&view=before')
                    ),
                    array(
                        'resource_name' => '更早消息',
                        'resource_url' => appUrl('m=Info&a=realTime&view=beforemore')
                    )
                )
            )
        );
    }


}


?>