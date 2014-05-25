<?php
class ApplicationAction extends CommonAction{

    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 应用管理
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
    public function add() {
        $App = D('App');

        if ( $_POST['submit'] ) {
            $applyPath = C('WEB_ROOT')."/App/".$_POST['app_selected']."/";

            if( file_exists($applyPath.'config.php') ) {
                require $applyPath.'config.php';

                /* 数据库安装 Start */
                if ( !empty( $path['path_sql'] ) ) {
                    $lines = file( $applyPath.$path['path_sql'] );
                    $sqlStr = "";

                    foreach( $lines as $line ) {
                        $line = trim( $line );
                        if ( $line && !( $line{0}=="#" || $line{0}.$line{1}=="--") ) {
                            $sqlStr .= $line;
                        }
                    }

                    $sqlStr = rtrim( $sqlStr, ";" );
                    $sqls = explode( ";", $sqlStr );

                    // 创建模型，并执行sql，创建数据表
                    $Model = new Model();
                    foreach( $sqls as $k=>$v ) {
                        $Model->query( $v );
                    }


                }
                /* 数据库安装 End */

                // 写入应用数据
                $data['app_name'] = $_POST['app_name'] ? $_POST['app_name'] : $path['app_name'];
                $data['thumb'] = "/App/".$_POST['app_selected']."/".$path['thumb'];
                $data['introduce'] = $path['introduce'];
                $data['description'] = $path['description'];
                $data['app_ename'] = $_POST['app_selected'];
                $data['keywords'] = $path['keywords'];
                $data['is_sys'] = $_POST['is_sys'] ? 1 : 0;
                $data['status'] = $_POST['status'] ? 1 : 0;
                $data['is_fee'] = $_POST['is_fee'] ? 1 : 0;
                $data['unedit'] = $path['unedit'] ? 1 : 0;

                if( $App->add( $data ) ) {
                    file_put_contents($applyPath.'install.lock','1');
                    $this->success( '安装成功', appUrl('m=Application&a=appList') );
                    return ;
                }
                $this->error('安装失败，请重新安装！');

            } else {
                $this->error('应用安装失败,请检查路径是否正确');
            }
            return;
        }

        $files = scandir( C('WEB_ROOT').'/App/' );
        unset($files[0]);
        unset($files[1]);
        $installApp = array();

        foreach( $files as $k=>$v ){
            $childenfiles = scandir( C('WEB_ROOT')."/App/{$v}");
            if(!in_array('install.lock',$childenfiles)) $installApp[$v] = $v;
        }

        $this->assign('installApp', $installApp);
        $this->display('app_add');
    }

    public function edit() {
        $App = D('App');

        if ( $_POST['submit'] ) {

            if ( !$App->create() || !$App->app_id ) return;

            $map['app_id'] = $App->app_id;
            $data['type_id'] = $_POST['type_id'];
            $data['app_name'] = $_POST['app_name'];
            $data['price'] = $_POST['price'];
            $data['is_sys'] = $_POST['is_sys'] ? 1 : 0;
            $data['is_fee'] = $_POST['is_fee'] ? 1 : 0;
            $data['status'] = $_POST['status'] ? 1 : 0;
            $data['is_top'] = $_POST['is_top'] ? 1 : 0;

            if ( $App->where($map)->save( $data ) ) {
                $this->success( '数据保存成功！', appUrl('m=Application&a=edit&app_id='.$_POST['app_id']) );
                return;
            }
            $this->error( '数据保存失败！' );
            return;
        }

        $map = array();
        $map['app_id'] = $_GET['app_id'];
        $obj = $App->where( $map )->find();
        $this->assign('obj', $obj);

        // 应用分类
        $list = D('AppType')->getList();
        $this->assign('list', $list);
        $this->display('app_add');
    }

    public function appList() {
        $App = D('App');

        if ( $_POST['submit'] ) {
            return ;
        }
        $page = $_GET['page'] ? $_GET['page'] : 1;
        $pagesize = 10;
        $pageset = ( $page -1) * $pagesize;
        $limit = array('page'=> $pageset, 'pagesize'=> $pagesize);

        $map = array();
        $list = $App->getList( $map, $limit );
        $this->assign('list', $list);

        $pageHtml = page( $App->getCount($map), $page, $pagesize, 1);
        $this->assign('pageHtml', $pageHtml);

        $this->display('app_list');
    }

    public function type() {
        $view = $_GET['view'] ? $_GET['view'] : 'list';
        $AppType = D('AppType');

        switch ( $view ) {
            case "list":
                if ( $_POST['submit'] ) {
                    $appType = $_POST['appType'];
                    $result = false;

                    foreach( $appType as $i => $k ) {
                        $map['type_id'] = $i;
                        $data['listorder'] = $k['listorder'];

                        if( $AppType->where($map)->save($data) ) {
                            $result = true;
                        }
                    }

                    if( $result ) {
                        $this->success('数据保存成功！', appUrl('m=Application&a=type'));
                    } else {
                        $this->error('数据保存失败！');
                    }
                    return;
                }

                $list = $AppType->getList();
                $this->assign('list', $list);
                $this->display('app_type_list');
                break;

            case "add";
                if ( $_POST['submit'] ) {

                    if ( !$AppType->create() ) return;
                    $sUrl = "m=Application&a=type&view=add&type_id=".$_POST['type_id'];

                    if ( $AppType->type_id ) {

                        if ( $AppType->save() ) {
                            $this->success('数据保存成功！', appUrl( $sUrl ) );
                            return;
                        }
                        $this->error('数据保存失败！');
                    } else {
                        if ( $AppType->add() ) {
                            $this->success('数据添加成功！', appUrl( $sUrl ) );
                            return;
                        }
                        $this->error('数据添加失败！');
                    }
                    return;
                }

                $map['type_id'] = $_GET['type_id'];
                $obj = $AppType->where( $map )->find();
                $this->assign('obj', $obj);

                $this->display('app_type_add');
                break;

            case "del":
                if( $_GET['type_id'] ) {
                    $map['type_id'] = $_GET['type_id'];

                    // 检测该分类下是否存在数据
                    if( !D('App')->where($map)->find() ) {
                        $AppType->where($map)->delete();
                        $this->success('数据删除成功！', appUrl('m=Application&a=type') );
                    } else {
                        $this->error('改分类下存在数据，请先删除分类下的数据！');
                    }
                } else {
                    $this->error('访问地址不存在！');
                }
                break;
        }
    }

    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 财务管理
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
    public function buyCheck() {
        $AppApplyRecord = D('AppApplyRecord');
        if ( $_POST['submit'] ) {
            return;
        }
        $page = $_GET['page'] ? $_GET['page'] : 1;
        $pagesize = 10;
        $pageset = ( $page -1) * $pagesize;
        $limit = array('page'=> $pageset, 'pagesize'=> $pagesize);

        $map['is_check'] = 0;
        $list = $AppApplyRecord->getBuyCheck($map, $limit);
        //var_dump($list);
        $this->assign('list', $list);

        $pageHtml = page( $AppApplyRecord->getCount($map), $page, $pagesize);
        $this->assign('pageHtml', $pageHtml);
        $this->display('app_buyCheck');
    }

    public function checkPass() {
        if ( !$_GET['record_id'] ) $this->error('访问地址不正确！');
        $AppApplyRecord = D('AppApplyRecord');
        $map['record_id'] = $_GET['record_id'];
        $data['is_check'] = 1;

        if ( $AppApplyRecord->where($map)->save($data) ) {
            $AppApplyRecord->buyCheckAfter( $_GET['record_id'] );
            $this->success('审核通过！', appUrl('m=Application&a=buyCheck'));
            return;
        }
        $this->error('审核失败！');
    }

    public function buyLog() {
        $AppApplyRecord = D('AppApplyRecord');
        if ( $_POST['submit'] ) {
            return;
        }
        $page = $_GET['page'] ? $_GET['page'] : 1;
        $pagesize = 10;
        $pageset = ( $page -1) * $pagesize;
        $limit = array('page'=> $pageset, 'pagesize'=> $pagesize);

        $map = array();
        $list = $AppApplyRecord->getBuyLog($map, $limit);
        //var_dump($list);
        $this->assign('list', $list);

        $pageHtml = page( $AppApplyRecord->getCount($map), $page, $pagesize);
        $this->assign('pageHtml', $pageHtml);
        $this->display('app_buyLog');
    }


    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     *
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
}
?>