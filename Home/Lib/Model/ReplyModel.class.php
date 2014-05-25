<?php
class ReplyModel extends CommonModel {

    public function getList( $map=array(), $limit=array() ) {
        $map = setMapPrefix( $map, $this->trueTableName );

        $list = $this->where($map)->limit($limit['page'].','.$limit['pagesize'])->select();

        return $list;
    }
}