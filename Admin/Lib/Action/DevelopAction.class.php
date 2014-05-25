<?php
class DevelopAction extends CommonAction {

    public function index() {

    }

    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 菜单管理
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
    public function menu() {
        $this->tool();
        $view = $_GET['view'] ? $_GET['view'] : 'nav';

        $Menu = D('Menu');
        $menuListO = $Menu->order(array('listorder'=>'asc'))->select();
        $this->assign('menuListO', $menuListO);

        $page = $_GET['page'] ? $_GET['page'] : 1;
        $pageHtml = page( count($menuListO), $page, 10, 1);
        $this->assign('pageHtml', $pageHtml);

        switch( $view ){
            case 'nav':
                $this->navMenu();
                break;

            case 'sub':
                $this->subMenu();
                break;

            case 'resource':
                $this->menuResource();
                break;
        }
    }

    // 导航菜单
    private function navMenu() {
        $op = $_GET['op'] ? $_GET['op'] : 'list';
        $Menu = D('Menu');

        switch($op){
            case 'list':
                if( $_POST['submit'] ) {
                    $menu = $_POST['menu'];
                    $result = false;

                    foreach( $menu as $i => $k ) {
                        $map['menu_id'] = $i;
                        $data['listorder'] = $k['listorder'];

                        if( $Menu->where($map)->save($data) ) {
                            $result = true;
                        }
                    }

                    if( $result ) {
                        $this->success('数据保存成功！', appUrl('m=Develop&a=menu&view=nav'));
                    } else {
                        $this->error('数据保存失败！');
                    }

                } else {
                    $this->display('menu_nav');
                }

                break;
            case 'add':
                if( $_POST['submit'] ) {
                    // 添加导航菜单
                    if($Menu->create()){

                        $Menu->data_format();
                        if( $Menu->menu_id) {

                            if( $Menu->save() ) {
                                $this->success('数据保存成功！', appUrl('m=Develop&a=menu&view=nav'));
                            } else {
                                $this->error('数据保存失败！');
                            }
                        }else{

                            if( $Menu->add() ) {
                                //echo __APP__.'/Admin/Develop/menu/view/nav';
                                $this->success('数据添加成功！', appUrl('m=Develop&a=menu&view=nav'));
                            } else {
                                $this->error('数据添加失败！');
                            }
                        }
                    } else {
                        $this->error('数据添加失败！');
                    }

                } else {
                    // 编辑状态获取 “菜单” 对象
                    $menu_id = $_GET['menu_id'];
                    $map['menu_id'] = $menu_id;
                    $obj = $Menu->where($map)->find();

                    $this->assign('obj', $obj);
                    $this->display('menu_nav_add');
                }


                break;

            case 'del':
                if( $_GET['menu_id'] ) {
                    $map['menu_id'] = $_GET['menu_id'];
                    // 检测是否有子项存在
                    if( !D('Submenu')->where($map)->find() ) {
                        $Menu->where($map)->delete();
                        $this->success('数据删除成功！', appUrl('m=Develop&a=menu&view=nav'));
                    } else {
                        $this->error('存在子项，请先删除其子项！');
                    }
                } else {
                    $this->error('非法操作！');
                }
                break;
        }

    }

    // 子菜单
    private function subMenu() {
        $op = $_GET['op'] ? $_GET['op'] : 'list';
        $Sub = D('Submenu');

        switch( $op ) {
            case 'list';
                if( $_POST['submit'] ) {
                    $submenu = $_POST['submenu'];
                    $result = false;

                    foreach( $submenu as $i => $k ) {
                        $map['submenu_id'] = $i;
                        $data['listorder'] = $k['listorder'];

                        if( $Sub->where($map)->save($data) ) {
                            $result = true;
                        }
                    }

                    if( $result ) {
                        $this->success('数据保存成功！', appUrl('m=Develop&a=menu&view=sub&menu_id='.$_POST['menu_id']));
                    } else {
                        $this->error('数据保存失败！');
                    }

                } else {
                    if( $_GET['menu_id'] ) {
                        $map['menu_id'] = $_GET['menu_id'];
                    }

                    $subList = $Sub->getListWithJoin($map);
                    $this->assign('subList', $subList);
                    $this->display('menu_sub');
                }


                break;

            case 'add':
                if( $_POST['submit'] ) {

                    if( $Sub->create() ) {
                        $Sub->data_format();
                        $sUrl = appUrl('m=Develop&a=menu&view=sub&menu_id='.$_POST['menu_id']);

                        if( $Sub->submenu_id) {

                            if( $Sub->save() ) {
                                $this->success('数据保存成功！', $sUrl);
                            } else {
                                $this->error('数据保存失败！');
                            }
                        }else{
                            if( $Sub->add() ) {
                                $this->success('数据添加成功！', $sUrl);
                            } else {
                                $this->error('数据添加失败！');
                            }
                        }
                    } else {
                        $this->error('数据添加失败！');
                    }

                } else {
                    // 编辑状态获取 “菜单” 对象
                    $submenu_id = $_GET['submenu_id'];
                    $map['submenu_id'] = $submenu_id;
                    $obj = $Sub->where($map)->find();
                    $this->assign('obj', $obj);

                    // menu_id存在情况下，获取父菜单对象
                    if( $_GET['menu_id'] ) {
                        $Menu = D('Menu');
                        $map = array();
                        $map['menu_id'] = $_GET['menu_id'];
                        $pObj = $Menu->where($map)->find();
                        $this->assign('pObj', $pObj);
                    }

                    $this->display('menu_sub_add');
                }

                break;

            case 'del':
                if( $_GET['submenu_id'] ) {
                    $map['submenu_id'] = $_GET['submenu_id'];
                    // 检测是否存在子项
                    if( !D('SubmenuResource')->where($map)->find() ) {
                        $Sub->where($map)->delete();
                        $this->success('数据删除成功！', appUrl('m=Develop&a=menu&view=sub&menu_id='.$_GET['menu_id']));
                    } else {
                        $this->error('存在子项，请先删除其子项！');
                    }
                } else {
                    $this->error('非法操作！');
                }
                break;
        }

    }

    // 菜单项
    private function menuResource() {
        $op = $_GET['op'] ? $_GET['op'] : 'list';
        $Resource = D('SubmenuResource');

        $Sub = D('Submenu');
        $subList = $Sub->order(array('listorder'))->select();
        $this->assign('subList', $subList);
        //var_dump($subList);

        switch( $op ) {
            case 'list':
                if( $_POST['submit'] ) {
                    $resource = $_POST['resource'];
                    $result = false;

                    foreach( $resource as $i => $k ) {
                        $map['resource_id'] = $i;
                        $data['listorder'] = $k['listorder'];
                        $data['resource_url'] = $k['resource_url'];
                        $data['mod'] = $k['mod'];
                        $data['act'] = $k['act'];

                        if( $Resource->where($map)->save($data) ) {
                            $result = true;
                        }
                    }

                    if( $result ) {
                        $this->success('数据保存成功！', appUrl('m=Develop&a=menu&view=resource&submenu_id='.$_POST['submenu_id']));
                    } else {
                        $this->error('数据保存失败！');
                    }

                } else {
                    if( $_GET['submenu_id'] ) {
                        $map['submenu_id'] = $_GET['submenu_id'];
                    }

                    $resourceList = $Resource->getListWithJoin($map);
                    $this->assign('resourceList', $resourceList);
                    //var_dump($resourceList);
                    $this->display('menu_resource');
                }
                break;

            case 'add':
                if( $_POST['submit'] ) {

                    if( $Resource->create() ) {
                        $Resource->data_format();
                        $sUrl = appUrl('m=Develop&a=menu&view=resource&submenu_id='.$_POST['submenu_id']);

                        if( $Resource->resource_id) {

                            if( $Resource->save() ) {
                                $this->success('数据保存成功！', $sUrl);
                            } else {
                                $this->error('数据保存失败！');
                            }
                        }else{
                            if( $Resource->add() ) {
                                $this->success('数据添加成功！', $sUrl);
                            } else {
                                $this->error('数据添加失败！');
                            }
                        }
                    } else {
                        $this->error('数据添加失败！');
                    }

                } else {
                    // 编辑状态获取 “菜单项” 对象
                    $resource_id = $_GET['resource_id'];
                    $map['resource_id'] = $resource_id;
                    $obj = $Resource->where($map)->find();
                    $this->assign('obj', $obj);

                    // menu_id存在情况下，获取父菜单对象
                    if( $_GET['submenu_id'] ) {
                        $map = array();
                        $map['submenu_id'] = $_GET['submenu_id'];
                        $pObj = $Sub->where($map)->find();
                        $this->assign('pObj', $pObj);
                    }

                    $this->display('menu_resource_add');
                }
                break;

            case 'del':
                if( $_GET['resource_id'] ) {
                    $map['resource_id'] = $_GET['resource_id'];
                    $Resource->where($map)->delete();
                    $this->success('数据删除成功！', appUrl('m=Develop&a=menu&view=resource&submenu_id='.$_GET['submenu_id']));
                } else {
                    $this->error('非法操作！');
                }
                break;

        }


    }

    private function tool() {
        $tools = array(
            array(
                'tag' => 'nav',
                'name' => '导航菜单',
                'url' => appUrl('m=Develop&a=menu&view=nav')
            ),
            array(
                'tag' => 'sub',
                'name' => '子菜单',
                'url' => appUrl('m=Develop&a=menu&view=sub')
            ),
            array(
                'tag' => 'resource',
                'name' => '菜单项',
                'url' => appUrl('m=Develop&a=menu&view=resource')
            )
        );

        $this->assign('tools', $tools);
    }



    /*
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 文章管理
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * */
    public function article() {
        $view = $_GET['view'] ? $_GET['view'] : 'module';

        switch( $view ) {
            case "module":
                $this->module();
                break;
        }
    }

    // 文章分类列表
    private function module() {
        $op = $_GET['op'] ? $_GET['op'] : 'list';
        $ArticleModule = D('ArticleModule');

        switch( $op ) {
            case "list":
                if ( $_POST['submit'] ) {

                } else {
                    $list = $ArticleModule->select();
                    $this->assign('list', $list);
                    $this->display('article_module_list');
                }
                break;

            case "add":
                if ( $_POST['submit'] ) {
                    // 添加 文章模块
                    if($ArticleModule->create()){

                        if( $ArticleModule->module_id) {

                            if( $ArticleModule->save() ) {
                                $this->success('数据保存成功！', appUrl('m=Develop&a=article&view=module'));
                            } else {
                                $this->error('数据保存失败！');
                            }
                        }else{
                            if( $ArticleModule->add() ) {
                                $this->success('数据添加成功！', appUrl('m=Develop&a=article&view=module'));
                            } else {
                                $this->error('数据添加失败！');
                            }
                        }
                    } else {
                        $this->error('数据添加失败！');
                    }

                } else {
                    // 编辑状态获取 “菜单” 对象
                    $module_id = $_GET['module_id'];
                    $map['module_id'] = $module_id;
                    $obj = $ArticleModule->where($map)->find();

                    $this->assign('obj', $obj);
                    $this->display('article_module_add');
                }
                break;

            case 'del':
                if( $_GET['module_id'] ) {
                    $map['module_id'] = $_GET['module_id'];
                    // 检测是否有子项存在
                    if( !D('Article')->where($map)->find() ) {
                        $ArticleModule->where($map)->delete();
                        $this->success('数据删除成功！', appUrl('m=Develop&a=article&view=module'));
                    } else {
                        $this->error('该文章模块下还存在数据，请先删除这些数据！');
                    }
                } else {
                    $this->error('非法操作！');
                }
                break;

        }
    }
}
?>