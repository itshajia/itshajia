<?php
class ArticleModel extends CommonModel{


    // 数据格式化
    public function data_format() {
        $_adminUser = session('_adminUser');

        $this->is_public = $this->is_public ? 1 : 0;
        $this->uid = $_adminUser['uid'];
        $this->addtime = $this->addtime ? strtotime( $this->addtime) : time();
        $this->status = 1;
    }

    // 获取文章列表
    function getList( $map = array(), $limit=array() ) {
        $map = setMapPrefix( $map, $this->trueTableName );
        $User = D('User');
        $list = $this->order(array('listorder','addtime'=>'desc'))->where($map)->limit($limit['page'].','.$limit['pagesize'])->select();

        for ( $i=0;$i<count($list);$i++) {
            $map = array();
            $map['uid'] = $list[$i]['uid'];
            $user = $User->where($map)->find();
            $list[$i]['username'] = $user['username'];
        }
        return $list;
    }

    // 联合 Article_category表，获取 文章列表
    function getListWithJoin( $map = array(), $limit=array() ){
        $map = setMapPrefix( $map, $this->trueTableName );
        $User = D('User');

        $list = $this->join('JOIN '.$this->tablePrefix.'article_category USING (catid)')->field($this->trueTableName.'.*,'.
            $this->tablePrefix.'article_category.catname,'.$this->tablePrefix.'article_category.
            is_sys')->order(array('listorder'))->where($map)->limit($limit['page'].','.$limit['pagesize'])->select();

        for ( $i=0;$i<count($list);$i++) {
            $map = array();
            $map['uid'] = $list[$i]['uid'];
            $user = $User->where($map)->find();
            $list[$i]['username'] = $user['username'];
        }
        return $list;
    }



}
?>