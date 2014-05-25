<?php
class IndexAction extends CommonAction{

    public function _empty() {
        $this->basic();
    }

    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 栏目配置
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
    public function basic() {
        $AppWz = D('Common://AppWz');
        if ( $_POST['submit'] ) {
            if ( !$AppWz->create() ) return;
            if ( $AppWz->wz_id ) {

                if ( $AppWz->save() ) {
                    $this->success('数据保存成功！', appUrl('m=Index&a=basic'));
                    return;
                }
                $this->error('数据保存成功！');
            } else {
                $AppWz->uid = $_SESSION['_User']['uid'];
                $AppWz->addtime = time();

                if ( $AppWz->add() ) {
                    $this->success('数据添加成功！', appUrl('m=Index&a=basic'));
                    return;
                }
                $this->error('数据添加失败！');
            }
           return;
        }
        $map['uid'] = $_SESSION['_User']['uid'];
        $obj = $AppWz->where($map)->find();
        $this->assign('obj', $obj);

        $this->display('basic');
    }

    public function levelMsg() {
        if ( $_POST['submit'] ) {
            return;
        }
        $this->display('levelMsg');
    }

    /*public function bzmap() {
        $Bzmap = D('Common://Bzmap');

        if ( $_POST['submit'] ) {
            if ( !$Bzmap->create() ) return;
            if ( $Bzmap->bz_id ) {

                if ( $Bzmap->save() ) {
                    $this->success('数据保存成功！', appUrl('m=Index&a=bzmap'));
                    return;
                }
                $this->error('数据保存成功！');
            } else {
                $Bzmap->uid = $_SESSION['_User']['uid'];
                $Bzmap->addtime = time();

                if ( $Bzmap->add() ) {
                    $this->success('数据添加成功！', appUrl('m=Index&a=bzmap'));
                    return;
                }
                $this->error('数据添加失败！');
            }
            return;
        }

        // 获取地图列表
        $map['uid'] = $_SESSION['_User']['uid'];
        $map['app_name'] = 'wz';
        $list = $Bzmap->where($map)->select();
        $this->assign('list', $list);

        $this->display('bzmap');
    }*/

    public function bzmap() {
        $Bzmap = D('Common://Bzmap');
        $view = $_GET['view'] ? $_GET['view'] : 'list';

        switch ( $view ) {
            case "add":

                if ( $_POST['submit'] ) {
                    if ( !$Bzmap->create() ) return;
                    if ( $Bzmap->bz_id ) {

                        if ( $Bzmap->save() ) {
                            $this->success('数据保存成功！', appUrl('m=Index&a=bzmap'));
                            return;
                        }
                        $this->error('数据保存成功！');
                    } else {
                        $Bzmap->app_name = 'wz';
                        $Bzmap->uid = $_SESSION['_User']['uid'];
                        $Bzmap->addtime = time();

                        if ( $Bzmap->add() ) {
                            $this->success('数据添加成功！', appUrl('m=Index&a=bzmap&view=add'));
                            return;
                        }
                        $this->error('数据添加失败！');
                    }
                    return;
                }

                if ( $_GET['bz_id'] ) {
                    $map['bz_id'] = $_GET['bz_id'];
                    $map['app_name'] = 'wz';
                    $obj = $Bzmap->where($map)->find();
                    $this->assign('obj', $obj);
                }
                $this->display('bzmap_add');
                break;

            case "list":
                if ( $_POST['submit'] ) {
                    $tool = $_POST['tool'];
                    $ids = $_POST['id'];

                    if ( $tool && !count($ids) ) $this->error('请选择要操作的选项！');
                    switch( $tool ) {
                        case "delAll":
                            foreach( $ids as $k=>$v ) {
                                $map['bz_id'] = $k;
                                $map['uid'] = $_SESSION['_User']['uid'];
                                $map['app_name'] = 'wz';
                                $Bzmap->where($map)->delete();
                            }
                            $this->success('数据删除成功！', appUrl('m=Index&a=bzmap'));
                            break;
                    }


                    $result = false;
                    foreach( $ids as $i => $k ) {

                        $map['bz_id'] = $i;
                        $map['uid'] = $_SESSION['_User']['uid'];
                        $data['sort'] = $k['sort'];

                        if( $Bzmap->where($map)->save($data) ) {
                            $result = true;
                        }
                    }
                    if( $result ) {
                        $this->success('数据保存成功！', appUrl('m=Index&a=bzmap'));
                    } else {
                        $this->error('数据保存失败！');
                    }
                    return;
                }


                $map['uid'] = $_SESSION['_User']['uid'];
                $map['app_name'] = 'wz';
                $list = $Bzmap->order(array('sort'))->where($map)->select();
                $this->assign('list', $list);
                $this->display('bzmap_list');
                break;

            case "del":
                if( $_GET['bz_id'] ) {

                    $map['bz_id'] = $_GET['bz_id'];
                    $map['uid'] = $_SESSION['_User']['uid'];
                    $map['app_name'] = 'wz';

                    $Bzmap->where($map)->delete();
                    $this->success('数据删除成功！', appUrl('m=Index&a=bzmap') );
                    return;
                }
                $this->error('访问地址不正确！');
                break;
        }
    }

    public function tmpl() {
        if ( $_POST['submit'] ) {
            return;
        }
        $this->display('tmpl');
    }

    public function column() {
        $Column = D('Common://Column');
        if ( $_POST['submit'] ) {
            $idss = $_POST['id'];
            $ids = array();
            foreach ( $idss as $k=>$v ) {
                array_push($ids, $k);
            }

            $map['uid'] = $_SESSION['_User']['uid'];
            $map['app_name'] = 'wz';
            $list = $Column->where( $map )->select();

            foreach( $list as $k=>$v ) {
                $map['column_id'] = $v['column_id'];
                if ( in_array($v['column_id'], $ids) ) {
                    $data['is_show'] = 1;
                    $Column->where($map)->save($data);
                } else {
                    $data['is_show'] = 0;
                    $Column->where($map)->save($data);
                }
            }
            $this->success('数据保存成功！', appUrl('m=Index&a=column'));
            return;
        }
        $sysList = $Column->getSysColumn();
        $this->assign('sysList', $sysList);
        $customList = $Column->getCustomColumn();
        $this->assign('customList', $customList);

        $this->display('column');
    }

    public function preview() {
        if ( $_POST['submit'] ) {
            return;
        }
        $this->display('preview');
    }

    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 新闻管理
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
    public function newsCate() {
        $NewsCate = D('Common://NewsCate');
        $view = $_GET['view'] ? $_GET['view'] : 'list';

        switch ( $view ) {
            case "add";
                if ( $_POST['submit'] ) {

                    if ( !$NewsCate->create() ) return;
                    if ( $NewsCate->cate_id ) {

                        if ( $NewsCate->save() ) {
                            $this->success('数据保存成功！', appUrl('m=Index&a=newsCate'));
                            return;
                        }
                        $this->error('数据保存失败！');
                    } else {
                        $NewsCate->app_name = 'wz';
                        $NewsCate->uid = $_SESSION['_User']['uid'];
                        $NewsCate->addtime = time();

                        if ( $NewsCate->add() ) {
                            $this->success('数据添加成功', appUrl('m=Index&a=newsCate&view=add'));
                            return;
                        }
                        $this->error('数据添加失败！');
                    }
                    return;
                }

                $map['uid'] = $_SESSION['_User']['uid'];
                $map['app_name'] = 'wz';

                $levelList = $NewsCate->getLevelUnlimit( $NewsCate->getUnlimit($map) );
                $this->assign('levelList', $levelList);

                if ( $_GET['cate_id'] ) {
                    $map['cate_id'] = $_GET['cate_id'];
                    $obj = $NewsCate->where($map)->find();
                    $this->assign('obj', $obj);
                }

                //var_dump($levelList);

                $this->display('news_cate_add');
                break;

            case "list":

                if ( $_POST['submit'] ) {
                    $tool = $_POST['tool'];
                    $ids = $_POST['id'];

                    if ( !count($ids) ) $this->error('请选择要操作的选项！');
                    switch( $tool ) {
                        case "delAll":
                            foreach( $ids as $k=>$v ) {
                                $map['cate_id'] = $k;
                                $map['uid'] = $_SESSION['_User']['uid'];
                                $map['app_name'] = 'wz';
                                $NewsCate->where($map)->delete();
                            }
                            $this->success('数据删除成功！', appUrl('m=Index&a=newsCate'));
                            break;
                    }
                    return;
                }


                $map['uid'] = $_SESSION['_User']['uid'];
                $map['app_name'] = 'wz';
                $list = $NewsCate->getLevelUnlimit( $NewsCate->getUnlimit($map) );
                $this->assign('list', $list);

                $this->display('news_cate_list');
                break;

            case "del":
                if( $_GET['cate_id'] ) {

                    $map['cate_id'] = $_GET['cate_id'];
                    $map['uid'] = $_SESSION['_User']['uid'];
                    $map['app_name'] = 'wz';
                    // 检测该分类下是否存在数据
                    if( !D('Common://News')->where($map)->find() ) {
                        $NewsCate->where($map)->delete();
                        $this->success('数据删除成功！', appUrl('m=Index&a=newsCate') );
                    } else {
                        $this->error('改分类下存在数据，请先删除分类下的数据！');
                    }
                    return;
                }
                $this->error('访问地址不正确！');
                break;
        }
    }

    public function news() {
        $News = D('Common://News');
        $NewsCate = D('Common://NewsCate');
        $view = $_GET['view'] ? $_GET['view'] : 'list';

        switch ( $view ) {
            case "add";
                if ( $_POST['submit'] ) {

                    if ( !$News->create() ) return;
                    $News->addtime = $News->addtime ? strtotime( $News->addtime) : time();

                    if ( $News->news_id ) {

                        if ( $News->save() ) {
                            $this->success('数据保存成功！',appUrl('m=Index&a=news&view=add&news_id='.$_POST['news_id']) );
                            return;
                        }
                        $this->error('数据保存失败！');
                    } else {
                        $News->uid = $_SESSION['_User']['uid'];
                        $News->app_name = 'wz';

                        if ( $News->add() ) {
                            $this->success( '数据添加成功！', appUrl('m=Index&a=news&view=add') );
                            return;
                        }
                        $this->error('数据添加失败！');
                    }
                    return;
                }

                $map['uid'] = $_SESSION['_User']['uid'];
                $map['app_name'] = 'wz';
                $levelList = $NewsCate->getLevelUnlimit( $NewsCate->getUnlimit( $map ) );
                $this->assign('levelList', $levelList);

                if ( $_GET['news_id'] ) {
                    $map['news_id'] = $_GET['news_id'];
                    $obj = $News->where($map)->find();
                    $this->assign('obj', $obj);
                }

                $this->display('news_add');
                break;

            case "list":
                if ( $_POST['submit'] ) {
                    $tool = $_POST['tool'];
                    $ids = $_POST['id'];

                    if ( !count($ids) ) $this->error('请选择要操作的选项！');
                    switch( $tool ) {
                        case "delAll":
                            foreach( $ids as $k=>$v ) {
                                $map['news_id'] = $k;
                                $map['uid'] = $_SESSION['_User']['uid'];
                                $map['app_name'] = 'wz';
                                $News->where($map)->delete();
                            }
                            $this->success('数据删除成功！', appUrl('m=Index&a=news'));
                            break;
                    }
                    return;
                }

                $page = $_GET['page'] ? $_GET['page'] : 1;
                $pagesize = 10;
                $pageset = ( $page -1) * $pagesize;
                $limit = array('page'=> $pageset, 'pagesize'=> $pagesize);

                $map['uid'] = $_SESSION['_User']['uid'];
                $map['app_name'] = 'wz';
                $list = $News->getListWithJoin( $map, $limit );
                $this->assign( 'list', $list );

                $pageHtml = page( $News->getCount($map), $page, $pagesize );
                $this->assign('pageHtml', $pageHtml);

                $this->display('news_list');
                break;

            case "del":
                if( $_GET['news_id'] ) {
                    $map['news_id'] = $_GET['news_id'];
                    $map['uid'] = $_SESSION['_User']['uid'];
                    $map['app_name'] = 'wz';
                    $News->where($map)->delete();
                    $this->success('数据删除成功！', appUrl('m=Index&a=news') );
                    return;
                }
                $this->error('访问地址不正确！');
                break;
        }
    }

    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 产品管理
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
    public function proCate() {
        $ProCate = D('Common://ProCate');
        $view = $_GET['view'] ? $_GET['view'] : 'list';

        switch ( $view ) {
            case "add";
                if ( $_POST['submit'] ) {

                    if ( !$ProCate->create() ) return;
                    if ( $ProCate->cate_id ) {

                        if ( $ProCate->save() ) {
                            $this->success('数据保存成功！', appUrl('m=Index&a=proCate'));
                            return;
                        }
                        $this->error('数据保存失败！');
                    } else {
                        $ProCate->uid = $_SESSION['_User']['uid'];
                        $ProCate->addtime = time();
                        $ProCate->app_name = 'wz';

                        if ( $ProCate->add() ) {
                            $this->success('数据添加成功', appUrl('m=Index&a=proCate&view=add'));
                            return;
                        }
                        $this->error('数据添加失败！');
                    }
                    return;
                }

                $map['uid'] = $_SESSION['_User']['uid'];
                $map['app_name'] = 'wz';
                $levelList = $ProCate->getLevelUnlimit( $ProCate->getUnlimit( $map ) );
                $this->assign('levelList', $levelList);

                if ( $_GET['cate_id'] ) {
                    $map['cate_id'] = $_GET['cate_id'];
                    $obj = $ProCate->where($map)->find();
                    $this->assign('obj', $obj);
                }

                $this->display('pro_cate_add');
                break;

            case "list":
                if ( $_POST['submit'] ) {
                    $tool = $_POST['tool'];
                    $ids = $_POST['id'];

                    if ( !count($ids) ) $this->error('请选择要操作的选项！');
                    switch( $tool ) {
                        case "delAll":
                            foreach( $ids as $k=>$v ) {
                                $map['cate_id'] = $k;
                                $map['app_name'] = 'wz';
                                $ProCate->where($map)->delete();
                            }
                            $this->success('数据删除成功！', appUrl('m=Index&a=proCate'));
                            break;
                    }
                    return;
                }


                $map['uid'] = $_SESSION['_User']['uid'];
                $map['app_name'] = 'wz';
                $list = $ProCate->getLevelUnlimit( $ProCate->getUnlimit($map) );
                $this->assign('list', $list);

                $this->display('pro_cate_list');
                break;

            case "del":
                if( $_GET['cate_id'] ) {
                    $map['cate_id'] = $_GET['cate_id'];
                    $map['uid'] = $_SESSION['_User']['uid'];
                    $map['app_name'] = 'wz';

                    // 检测该分类下是否存在数据
                    if( !D('Common://Pro')->where($map)->find() ) {
                        $ProCate->where($map)->delete();
                        $this->success('数据删除成功！', appUrl('m=Index&a=proCate') );
                    } else {
                        $this->error('改分类下存在数据，请先删除分类下的数据！');
                    }
                    return;
                }
                $this->error('访问地址不正确！');
                break;
        }
    }

    public function pro() {
        $Pro = D('Common://Pro');
        $ProCate = D('Common://ProCate');
        $view = $_GET['view'] ? $_GET['view'] : 'list';

        switch ( $view ) {
            case "add";
                if ( $_POST['submit'] ) {
                    if ( !$Pro->create() ) return;
                    $Pro->addtime = $Pro->addtime ? strtotime( $Pro->addtime) : time();
                    $Pro->pic = join(',', array_filter($Pro->pic));

                    if ( $Pro->pro_id ) {

                        if ( $Pro->save() ) {
                            $this->success('数据保存成功！',appUrl('m=Index&a=pro&view=add&pro_id='.$_POST['pro_id']) );
                            return;
                        }
                        $this->error('数据保存失败！');
                    } else {
                        $Pro->uid = $_SESSION['_User']['uid'];
                        $Pro->app_name = 'wz';

                        if ( $Pro->add() ) {
                            $this->success( '数据添加成功！', appUrl('m=Index&a=pro&view=add') );
                            return;
                        }
                        $this->error('数据添加失败！');
                    }
                    return;
                }

                $map['uid'] = $_SESSION['_User']['uid'];
                $map['app_name'] = 'wz';
                $levelList = $ProCate->getLevelUnlimit( $ProCate->getUnlimit( $map ) );
                $this->assign('levelList', $levelList);

                if ( $_GET['pro_id'] ) {
                    $map['pro_id'] = $_GET['pro_id'];
                    $obj = $Pro->where($map)->find();
                    $this->assign('obj', $obj);
                }

                $this->display('pro_add');
                break;

            case "list":
                if ( $_POST['submit'] ) {
                    $tool = $_POST['tool'];
                    $ids = $_POST['id'];

                    if ( !count($ids) ) $this->error('请选择要操作的选项！');
                    switch( $tool ) {
                        case "delAll":
                            foreach( $ids as $k=>$v ) {
                                $map['pro_id'] = $k;
                                $map['uid'] = $_SESSION['_User']['uid'];
                                $map['app_name'] = 'wz';
                                $Pro->where($map)->delete();
                            }
                            $this->success('数据删除成功！', appUrl('m=Index&a=pro'));
                            break;
                    }
                    return;
                }
                $page = $_GET['page'] ? $_GET['page'] : 1;
                $pagesize = 10;
                $pageset = ( $page -1) * $pagesize;
                $limit = array('page'=> $pageset, 'pagesize'=> $pagesize);

                $map['uid'] = $_SESSION['_User']['uid'];
                $map['app_name'] = 'wz';
                $list = $Pro->getListWithJoin( $map, $limit );
                $this->assign( 'list', $list );

                $pageHtml = page( $Pro->getCount($map), $page, $pagesize );
                $this->assign('pageHtml', $pageHtml);

                $this->display('pro_list');
                break;

            case "del":
                if( $_GET['pro_id'] ) {
                    $map['pro_id'] = $_GET['pro_id'];
                    $map['uid'] = $_SESSION['_User']['uid'];
                    $map['app_name'] = 'wz';
                    $Pro->where($map)->delete();
                    $this->success('数据删除成功！', appUrl('m=Index&a=pro') );
                    return;
                }
                $this->error('访问地址不正确！');
                break;
        }
    }

    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 单页管理
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
    public function page() {
        $Page = D('Common://Page');
        $view = $_GET['view'] ? $_GET['view'] : 'list';

        switch( $view ) {
            case "add":
                if ( $_POST['submit'] ) {

                    if ( !$Page->create() ) return;
                    $Page->addtime = $Page->addtime ? strtotime( $Page->addtime) : time();

                    if ( $Page->page_id ) {

                        if ( $Page->save() ){
                            $this->success('数据保存成功！', appUrl('m=Index&a=page&view=add&page_id='.$_POST['page_id']) );
                            return;
                        }
                        $this->error('数据保存失败！');
                    } else {

                        $Page->uid = $_SESSION['_User']['uid'];
                        $Page->app_name = 'wz';

                        if ( $Page->add() ) {
                            $this->success('数据添加成功！', appUrl('m=Index&a=page&view=add'));
                            return;
                        }
                        $this->error('数据添加失败！');
                    }
                    return;
                }

                $map['uid'] = $_SESSION['_User']['uid'];
                if ( $_GET['page_id'] ) {
                    $map['page_id'] = $_GET['page_id'];
                    $obj = $Page->where($map)->find();
                    $this->assign('obj', $obj);
                }

                $this->display('page_add');
                break;

            case "list":
                if ( $_POST['submit'] ) {
                    $tool = $_POST['tool'];
                    $ids = $_POST['id'];

                    if ( !count($ids) ) $this->error('请选择要操作的选项！');
                    switch( $tool ) {
                        case "delAll":
                            foreach( $ids as $k=>$v ) {
                                $map['page_id'] = $k;
                                $map['uid'] = $_SESSION['_User']['uid'];
                                $map['app_name'] = 'wz';
                                $Page->where($map)->delete();
                            }
                            $this->success('数据删除成功！', appUrl('m=Index&a=page'));
                            break;
                    }
                    return;
                }
                $page = $_GET['page'] ? $_GET['page'] : 1;
                $pagesize = 10;
                $pageset = ( $page -1) * $pagesize;
                $limit = array('page'=> $pageset, 'pagesize'=> $pagesize);

                $map['uid'] = $_SESSION['_User']['uid'];
                $map['app_name'] = 'wz';
                $list = $Page->where($map)->order(array('listorder'))->select();
                $this->assign('list', $list);

                $pageHtml = page( $Page->getCount($map), $page, $pagesize );
                $this->assign('pageHtml', $pageHtml);

                $this->display('page_list');
                break;

            case "del":
                if( $_GET['page_id'] ) {
                    $map['page_id'] = $_GET['page_id'];
                    $map['uid'] = $_SESSION['_User']['uid'];
                    $map['app_name'] = 'wz';
                    $Page->where($map)->delete();
                    $this->success('数据删除成功！', appUrl('m=Index&a=page') );
                    return;
                }
                $this->error('访问地址不正确！');
                break;
        }
    }

    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 相册管理
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
    public function albumCate() {
        $AlbumCate = D('Common://AlbumCate');
        $view = $_GET['view'] ? $_GET['view'] : 'list';

        switch ( $view ) {
            case "add";
                if ( $_POST['submit'] ) {

                    if ( !$AlbumCate->create() ) return;
                    if ( $AlbumCate->cate_id ) {

                        if ( $AlbumCate->save() ) {
                            $this->success('数据保存成功！', appUrl('m=Index&a=albumCate'));
                            return;
                        }
                        $this->error('数据保存失败！');
                    } else {
                        $AlbumCate->uid = $_SESSION['_User']['uid'];
                        $AlbumCate->addtime = time();
                        $AlbumCate->app_name = 'wz';

                        if ( $AlbumCate->add() ) {
                            $this->success('数据添加成功', appUrl('m=Index&a=albumCate&view=add'));
                            return;
                        }
                        $this->error('数据添加失败！');
                    }
                    return;
                }

                $map['uid'] = $_SESSION['_User']['uid'];
                $map['app_name'] = 'wz';
                $levelList = $AlbumCate->getLevelUnlimit( $AlbumCate->getUnlimit( $map ) );
                $this->assign('levelList', $levelList);

                if ( $_GET['cate_id'] ) {
                    $map['cate_id'] = $_GET['cate_id'];
                    $obj = $AlbumCate->where($map)->find();
                    $this->assign('obj', $obj);
                }

                $this->display('album_cate_add');
                break;

            case "list":
                if ( $_POST['submit'] ) {
                    $tool = $_POST['tool'];
                    $ids = $_POST['id'];

                    if ( !count($ids) ) $this->error('请选择要操作的选项！');
                    switch( $tool ) {
                        case "delAll":
                            foreach( $ids as $k=>$v ) {
                                $map['cate_id'] = $k;
                                $map['app_name'] = 'wz';
                                $AlbumCate->where($map)->delete();
                            }
                            $this->success('数据删除成功！', appUrl('m=Index&a=albumCate'));
                            break;
                    }
                    return;
                }


                $map['uid'] = $_SESSION['_User']['uid'];
                $map['app_name'] = 'wz';
                $list = $AlbumCate->getLevelUnlimit( $AlbumCate->getUnlimit($map) );
                $this->assign('list', $list);

                $this->display('album_cate_list');
                break;

            case "del":
                if( $_GET['cate_id'] ) {
                    $map['cate_id'] = $_GET['cate_id'];
                    $map['uid'] = $_SESSION['_User']['uid'];
                    $map['app_name'] = 'wz';

                    // 检测该分类下是否存在数据
                    if( !D('Common://Album')->where($map)->find() ) {
                        $AlbumCate->where($map)->delete();
                        $this->success('数据删除成功！', appUrl('m=Index&a=albumCate') );
                    } else {
                        $this->error('改分类下存在数据，请先删除分类下的数据！');
                    }
                    return;
                }
                $this->error('访问地址不正确！');
                break;
        }
    }

    public function album() {
        $Album = D('Common://Album');
        $AlbumCate = D('Common://AlbumCate');
        $AlbumPic = D('Common://AlbumPic');
        $view = $_GET['view'] ? $_GET['view'] : 'list';

        switch ( $view ) {
            case "pic":
                if ( $_POST['submit'] ) {

                    if ( !$AlbumPic->create() || !$_POST['album_id'] ) return;
                    $pics = $AlbumPic->pic_url;
                    $titles = $AlbumPic->pic_title;
                    $ids = $AlbumPic->pic_id;

                    $data['album_id'] = $_POST['album_id'];
                    $data['uid'] = $_SESSION['_User']['uid'];
                    $data['addtime'] = time();
                    $data['app_name'] = 'wz';

                    $map['uid'] = $_SESSION['_User']['uid'];
                    $map['app_name'] = 'wz';

                    for( $i=0;$i<count($pics);$i++ ) {

                        $data['pic_url'] = $pics[$i];
                        $data['pic_title'] = $titles[$i];

                        if ( $ids[$i] ){
                            $map['pic_id'] = $ids[$i];
                            $AlbumPic->where($map)->save( $data );
                        } else {
                            $AlbumPic->add( $data );
                        }
                    }

                    $this->success('数据保存成功！', appUrl('m=Index&a=album&view=pic&album_id='.$_POST['album_id']));
                    return;
                }

                if ( !$_GET['album_id'] ) $this->error('访问地址不正确！');
                $map['album_id'] = $_GET['album_id'];
                $map['uid'] = $_SESSION['_User']['uid'];
                $map['app_name'] = 'wz';
                $obj = $Album->where($map)->find();
                $this->assign('obj', $obj);

                $list = $AlbumPic->order(array('listorder'))->where($map)->select();
                $this->assign('list', $list);

                $this->display('album_pic');
                break;

            case "add";
                if ( $_POST['submit'] ) {
                    if ( !$Album->create() ) return;
                    $Album->addtime = $Album->addtime ? strtotime( $Album->addtime) : time();

                    if ( $Album->album_id ) {

                        if ( $Album->save() ) {
                            $this->success('数据保存成功！',appUrl('m=Index&a=album&view=add&album_id='.$_POST['album_id']) );
                            return;
                        }
                        $this->error('数据保存失败！');
                    } else {
                        $Album->uid = $_SESSION['_User']['uid'];
                        $Album->app_name = 'wz';

                        if ( $Album->add() ) {
                            $this->success( '数据添加成功！', appUrl('m=Index&a=album&view=add') );
                            return;
                        }
                        $this->error('数据添加失败！');
                    }
                    return;
                }

                $map['uid'] = $_SESSION['_User']['uid'];
                $map['app_name'] = 'wz';
                $levelList = $AlbumCate->getLevelUnlimit( $AlbumCate->getUnlimit( $map ) );
                $this->assign('levelList', $levelList);

                if ( $_GET['album_id'] ) {
                    $map['album_id'] = $_GET['album_id'];
                    $obj = $Album->where($map)->find();
                    $this->assign('obj', $obj);
                }

                $this->display('album_add');
                break;

            case "list":
                if ( $_POST['submit'] ) {
                    $tool = $_POST['tool'];
                    $ids = $_POST['id'];

                    if ( !count($ids) ) $this->error('请选择要操作的选项！');
                    switch( $tool ) {
                        case "delAll":
                            foreach( $ids as $k=>$v ) {
                                $map['album_id'] = $k;
                                $map['uid'] = $_SESSION['_User']['uid'];
                                $map['app_name'] = 'wz';
                                $Album->where($map)->delete();
                            }
                            $this->success('数据删除成功！', appUrl('m=Index&a=album'));
                            break;
                    }
                    return;
                }
                $page = $_GET['page'] ? $_GET['page'] : 1;
                $pagesize = 10;
                $pageset = ( $page -1) * $pagesize;
                $limit = array('page'=> $pageset, 'pagesize'=> $pagesize);

                $map['uid'] = $_SESSION['_User']['uid'];
                $map['app_name'] = 'wz';
                $list = $Album->getListWithJoin( $map, $limit );
                $this->assign( 'list', $list );

                $pageHtml = page( $Album->getCount($map), $page, $pagesize );
                $this->assign('pageHtml', $pageHtml);

                $this->display('album_list');
                break;

            case "del":
                if( $_GET['album_id'] ) {
                    $map['album_id'] = $_GET['album_id'];
                    $map['uid'] = $_SESSION['_User']['uid'];
                    $map['app_name'] = 'wz';
                    $Album->where($map)->delete();
                    $this->success('数据删除成功！', appUrl('m=Index&a=album') );
                    return;
                }
                $this->error('访问地址不正确！');
                break;
        }
    }

    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * XXX
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
}
?>