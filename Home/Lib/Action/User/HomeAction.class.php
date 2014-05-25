<?php
class HomeAction extends CommonAction {

    public function index () {
        $App = D('App');
        $map['is_top'] = 1;
        $limit = array('page'=>0, 'pagesize'=>10);
        $hotAppList = $App->getList($map, $limit);
        //var_dump($hotAppList);
        $this->assign('hotAppList', $hotAppList);

        $Article = D('Article');
        $map = array();
        $map['status'] = 1;
        $map['module_tag'] = 'announce';
        $limit = array('page'=>0,'pagesize'=>7);
        $announceList = $Article->getList($map, $limit);
        $this->assign('announceList', $announceList);

        $this->display('index');
    }

    // 查看平台公告
    public function announce() {
        $Article = D('Article');
        $map = array();
        $map['article_id'] = $_GET['article_id'];
        $map['module_tag'] = 'announce';
        $map['status'] = 1;
        $obj = $Article->where($map)->find();
        $this->assign('obj', $obj);

        $this->display('announce');
    }


}

?>