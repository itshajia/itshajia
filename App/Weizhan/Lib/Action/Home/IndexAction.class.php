<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends CommonAction {

    // 首页
    public function index() {

        // 栏目获取
        $Column = D('Common://Column');
        $map['uid'] = $_GET['uid'];
        $map['is_show'] = 1;
        $map['is_home'] = 0;
        $map['app_name'] = "wz";
        $list = $Column->order(array('sort'))->where($map)->select();
        $this->assign('list', $list);

        $this->display($this->Skin.':Index:index');
    }

    // 关于我们
    public function about() {
        $AppWz = D('Common://AppWz');
        $map['uid'] = $_GET['uid'];
        $app = $AppWz->where( $map )->find();
        $this->assign('app', $app);

        $this->display($this->Skin.':Index:about');
    }

    // 产品中心
    public function pro() {
        $Pro = D('Common://Pro');
        $ProCate = D('Common://ProCate');
        $map['uid'] = $_GET['uid'];
        $map['app_name'] = 'wz';

        $levelList = $ProCate->getLevelUnlimit( $ProCate->getUnlimit( $map ) );
        foreach ( $levelList as $k=>$v ) {
            $levelList[$k]['linkurl'] = C('WEB_URL').'/App/Weizhan/index.php?m=Index&a=news&uid='.$_GET['uid']."&cate_id=".$v['cate_id'];
        }
        $this->assign('levelList', $levelList);

        if ( $_GET['cate_id'] ) $map['cate_id'] = array('in', join(',', $ProCate->getUnlimitIds(array(),array(), $_GET['cate_id'])));
        $list = $Pro->order(array('listorder', 'addtime'=> 'desc'))->where( $map )->limit(0, 10)->select();
        foreach ( $list as $k=>$v ) {
            $list[$k]['linkurl'] = "?m=Index&a=proShow&id=".$v['pro_id']."&uid=".$_GET['uid'];
            $picarr = explode(',', $list[$k]['pic']);
            if ( count($picarr) ){
                $list[$k]['pic'] = $picarr[0];
            }
        }
        $this->assign('list', $list);
        $this->display($this->Skin.':Index:pro');
    }

    // 产品详情展示
    public function proShow() {
        $Pro = D('Common://Pro');
        $map['uid'] = $_GET['uid'];
        $map['app_name'] = 'wz';
        $map['news_id'] = $_GET['id'];
        $obj = $Pro->where( $map )->find();
        $picarr = explode(',', $obj['pic']);
        $obj['picarr'] = $picarr;
        $this->assign('obj', $obj);

        $this->display($this->Skin.':Index:proShow');
    }

    // 新闻中心
    public function news() {
        $News = D('Common://News');
        $NewsCate = D('Common://NewsCate');

        $map['uid'] = $_GET['uid'];
        $map['app_name'] = 'wz';

        $levelList = $NewsCate->getLevelUnlimit( $NewsCate->getUnlimit( $map ) );
        foreach ( $levelList as $k=>$v ) {
            $levelList[$k]['linkurl'] = C('WEB_URL').'/App/Weizhan/index.php?m=Index&a=news&uid='.$_GET['uid']."&cate_id=".$v['cate_id'];
        }
        $this->assign('levelList', $levelList);

        if ( $_GET['cate_id'] ) $map['cate_id'] = array('in', join(',', $NewsCate->getUnlimitIds(array(),array(), $_GET['cate_id'])));
        //var_dump($map);
        $list = $News->order(array('listorder', 'addtime'=> 'desc'))->where( $map )->limit(0, 10)->select();
        foreach( $list as $k=>$v ) {
            $list[$k]['linkurl'] = "?m=Index&a=newsShow&id=".$v['news_id']."&uid=".$_GET['uid'];
        }
        $this->assign('list', $list);



        $this->display($this->Skin.':Index:news');
    }

    // 新闻详情展示
    public function newsShow() {
        $News = D('Common://News');
        $map['uid'] = $_GET['uid'];
        $map['app_name'] = 'wz';
        $map['news_id'] = $_GET['id'];
        $obj = $News->where( $map )->find();
        $this->assign('obj', $obj);
        $this->display($this->Skin.':Index:newsShow');
    }

    // 联系我们
    public function contact() {
        $AppWz = D('Common://AppWz');
        $map['uid'] = $_GET['uid'];
        $app = $AppWz->where( $map )->find();
        $this->assign('app', $app);

        $this->display($this->Skin.':Index:contact');
    }


}