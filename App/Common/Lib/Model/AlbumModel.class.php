<?php
class AlbumModel extends CommonModel{

    public function getListWithJoin( $map=array(), $limit=array() ) {
        $map = setMapPrefix( $map, $this->trueTableName );

        $list = $this->join('JOIN '.$this->tablePrefix.'album_cate USING (cate_id)')->field($this->trueTableName.'.*,'.
            $this->tablePrefix.'album_cate.cate_name')->order(array('listorder', 'addtime'=>'desc'))
            ->where($map)->limit($limit['page'].','.$limit['pagesize'])->select();

        return $list;
    }
}
?>