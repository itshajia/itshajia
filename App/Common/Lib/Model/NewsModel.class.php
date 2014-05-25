<?php
class NewsModel extends CommonModel{

    public function getListWithJoin( $map=array(), $limit=array() ) {
        $map = setMapPrefix( $map, $this->trueTableName );

        $list = $this->join('JOIN '.$this->tablePrefix.'news_cate USING (cate_id)')->field($this->trueTableName.'.*,'.
            $this->tablePrefix.'news_cate.cate_name')->order(array('listorder', 'addtime'=>'desc'))
            ->where($map)->limit($limit['page'].','.$limit['pagesize'])->select();

        return $list;
    }

}
?>