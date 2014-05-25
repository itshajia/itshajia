<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends CommonAction{

    // 首页
    public function index() {
        $AppWedding = D('Common://AppWedding');
        $map['uid'] = $_GET['uid'];
        $map['wed_id'] = $_GET['wed_id'];
        $obj = $AppWedding->where( $map )->find();
        $this->assign('obj', $obj);

        if ( $obj && $obj['bzpoint'] ) {
            $bzpoint_arr = explode(',', $obj['bzpoint']);
            $mapUrl = "http://api.map.baidu.com/marker?location=".$bzpoint_arr[1].",".$bzpoint_arr[0]."&amp;title=".$obj['address']."&amp;name=".$obj['address']."&amp;content=".$obj['address']."&amp;output=html";
            //echo $mapUrl;
            $this->assign('mapUrl', $mapUrl);
        }

        // 获取相册图片
        $AlbumPic = D('Common://AlbumPic');
        $map = array();
        $map['uid'] = $_GET['uid'];
        $map['app_name'] = 'wedding';
        $map['item_id'] = $_GET['wed_id'];
        $photoList = $AlbumPic->where($map)->order(array('listorder'))->select();
        $this->assign('photoList', $photoList);

        $map['is_cover'] = 1;
        $photoCover = $AlbumPic->where($map)->find();
        $this->assign('photoCover', $photoCover);
        //$this->assign('enterUrl', C('WEB_URL').'/App/Wedding/index.php?g=Home&m=Index&a=column&uid='.$_GET['uid'].'&wed_id='.$_GET['wed_id']);
        $this->display($this->Skin.':Index:index');
    }

    // 栏目
    public function column() {

        $this->display($this->Skin.':Index:column');
    }

    // 婚庆大屏幕
    public function screen() {

        $this->display($this->Skin.':Index:screen');
    }

}