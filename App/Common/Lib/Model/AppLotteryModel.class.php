<?php
class AppLotteryModel extends CommonModel{

    public function getList( $map=array(), $limit=array() ) {
        $list = $this->where($map)->order(array('sort'))->limit($limit['page'].','.$limit['pagesize'])->select();

        return $list;
    }

}
?>