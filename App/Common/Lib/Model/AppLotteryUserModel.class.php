<?php
class AppLotteryUserModel extends CommonModel{

    public function getList( $map=array(), $limit=array() ) {
        $map = setMapPrefix( $map, $this->trueTableName );
        $list = $this->join('JOIN '.$this->tablePrefix.'subscribe_user USING (openid)')->where($map)
            ->limit($limit['page'].','.$limit['pagesize'])->select();

        return $list;
    }

    public function getListWithImg( $map=array() ) {
        $map = setMapPrefix( $map, $this->trueTableName );
        $list = $this->join('JOIN '.$this->tablePrefix.'subscribe_user USING (openid)')->where($map)->select();

        return $list;
    }

    public function getListWithPrize( $map=array(), $limit=array() ) {
        $SubscribeUser = M('SubscribeUser');
        $map = setMapPrefix( $map, $this->trueTableName );
        $list = $this->join('JOIN '.$this->tablePrefix.'app_lottery_prize USING (prize_id)')->where($map)
            ->limit($limit['page'].','.$limit['pagesize'])->select();

        foreach( $list as $k=>$v ){
            $map = array();
            $map['openid'] = $v['openid'];
            $map['uid'] = $v['uid'];
            $obj = $SubscribeUser->where( $map )->find();
            $list[$k]['headimgurl'] = $obj['headimgurl'];
        }

        return $list;
    }

}
?>