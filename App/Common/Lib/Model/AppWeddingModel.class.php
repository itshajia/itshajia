<?php
class AppWeddingModel extends CommonModel{

    public function getList( $map=array(), $limit=array() ) {
        $list = $this->where($map)->order(array('addtime'=>'desc'))->limit($limit['page'].','.$limit['pagesize'])->select();

        return $list;
    }

}
?>