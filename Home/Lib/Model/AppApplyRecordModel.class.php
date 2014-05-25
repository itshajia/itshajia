<?php
class AppApplyRecordModel extends CommonModel {

    // 获取 “我的订单列表”
    function getMyOrderList( $map=array(),$limit=array() ) {
        $map = setMapPrefix( $map, $this->trueTableName );
        $map['is_fee'] = 1;
        $list = $this->join('JOIN '.$this->tablePrefix.'app USING (app_id)')->order(array('addtime'=>'desc'))
            ->where($map)->limit($limit['page'].','.$limit['pagesize'])->select();

        return $list;
    }


}

?>