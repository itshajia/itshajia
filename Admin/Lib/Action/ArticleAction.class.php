<?php
class ArticleAction extends CommonAction{

    public function index() {

    }

    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 平台公告
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
    public function announce() {
        $view = $_GET['view'] ? $_GET['view'] : 'list';
        $Article = D('Article');
        $ArticleCategory = D('ArticleCategory');

        switch( $view ) {
            case "list":
                if( $_POST['submit'] ) {
                    $tool = $_POST['tool'];
                    $articleids = $_POST['article_id'];

                    if ( !count($articleids) ) {
                        $this->error('请选择要操作的选项！');
                        exit();
                    }

                    $sUrl = appUrl('m=Article&a=announce');
                    switch( $tool ) {
                        case "delAll":
                            foreach( $articleids as $k=>$v ) {
                                $map['article_id'] = $k;
                                $Article->where($map)->delete();
                            }

                            $this->success('数据删除成功！', $sUrl);
                            break;
                    }
                } else {
                    $page = $_GET['page'] ? $_GET['page'] : 1;
                    $pagesize = 10;
                    $pageset = ( $page -1) * $pagesize;
                    $limit = array('page'=> $pageset, 'pagesize'=> $pagesize);

                    $map = array();
                    $map['status'] = 1;
                    $map['module_tag'] = 'announce';
                    $list = $Article->getList($map, $limit);
                    $this->assign('list', $list);

                    $pageHtml = page( $Article->getCount($map), $page, $pagesize, 1);
                    $this->assign('pageHtml', $pageHtml);
                    $this->display('announce_list');
                }
                break;

            case "add";
                if ( $_POST['submit'] ) {

                    if( $Article->create() ) {
                        $Article->data_format();
                        $sUrl = appUrl('m=Article&a=announce&view=add&article_id='.$_POST['article_id']);

                        if( $Article->article_id) {

                            if( $Article->save() ) {
                                $this->success('数据保存成功！', $sUrl);
                            } else {
                                $this->error('数据保存失败！');
                            }
                        }else{
                            $Article->module_tag = "announce";
                            if( $Article->add() ) {
                                $this->success('数据添加成功！', $sUrl);
                            } else {
                                $this->error('数据添加失败！');
                            }
                        }
                    } else {
                        $this->error('数据添加失败！');
                    }
                    return;
                }

                // 编辑状态
                $map = array();
                $map['article_id'] = $_GET['article_id'];
                $obj = $Article->where($map)->find();
                $this->assign('obj', $obj);
                $this->display('announce_add');
                break;

            case "del":
                if( $_GET['article_id'] ) {
                    $map['article_id'] = $_GET['article_id'];
                    $Article->where($map)->delete();
                    $this->success('数据删除成功！', appUrl('m=Article&a=announce'));
                } else {
                    $this->error('非法操作！');
                }
                break;
        }
    }


    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 站点咨询
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */

}

?>