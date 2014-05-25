<?php
class AppApplyRecordModel extends CommonModel {

    // 获取 “购买记录”
    function getBuyLog( $map=array(), $limit=array() ) {
        $map = setMapPrefix( $map, $this->trueTableName );
        $map['is_fee'] = 1;
        $list = $this->join('JOIN '.$this->tablePrefix.'app USING (app_id)')->order(array('addtime'=>'desc'))
            ->where($map)->limit($limit['page'].','.$limit['pagesize'])->select();

        $User = D('User');
        for( $i=0;$i<count($list);$i++ ) {
            $map = array();
            $map['uid'] = $list[$i]['uid'];
            $user = $User->where($map)->find();
            $list[$i]['username'] = $user['username'];
        }
        return $list;
    }

    // 获取 “未审核”购买
    function getBuyCheck( $map=array(), $limit=array() ) {
        $map = setMapPrefix( $map, $this->trueTableName );
        $list = $this->join('JOIN '.$this->tablePrefix.'app USING (app_id)')->order(array('addtime'=>'desc'))
            ->where($map)->limit($limit['page'].','.$limit['pagesize'])->select();

        $User = D('User');
        for( $i=0;$i<count($list);$i++ ) {
            $map = array();
            $map['uid'] = $list[$i]['uid'];
            $user = $User->where($map)->find();
            $list[$i]['username'] = $user['username'];
        }
        return $list;
    }

    // 审核通过后，“AppApply表” 添加一条 “应用使用记录”
    function buyCheckAfter( $record_id ) {
        $map['record_id'] = $record_id;
        $record = $this->order(array('addtime'=>'desc'))->where($map)->find();

        $AppApply = D('AppApply');
        $starttime = time();
        $year = date("Y", intval($starttime));
        $year = intval($year) + intval($record['year']);
        $uYear = date("m-d H:i:s", intval($starttime));
        $data['app_id'] = $record['app_id'];
        $data['uid'] = $record['uid'];
        $data['addtime'] = $starttime;
        $data['starttime'] = $starttime ;
        $data['endtime'] = strtotime( $year.'-'.$uYear );
        $data['status'] = 1;
        if ( $record['agent_id'] ) $data['agent_id'] = $record['agent_id'];

        $AppApply->add($data);
    }

}

?>