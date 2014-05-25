<?php
class MsgModel extends CommonModel{

    function getList( $map = array(), $limit=array() ) {
        $map = setMapPrefix( $map, $this->trueTableName );
        $list = $this->order(array('addtime'=>'desc'))->where($map)->limit($limit['page'].','.$limit['pagesize'])->select();

        return $list;
    }
}
?>