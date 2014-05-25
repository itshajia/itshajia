<?php
class AppModel extends CommonModel {

    // 获取我的应用列表
    function getMyList( $limit=array() ) {
        $AppApply = D('AppApply');
        $applyIds = array();
        $map['status'] = 1;
        $map['uid'] = $_SESSION['_User']['uid'];
        $list = $AppApply->where($map)->select();

        foreach( $list as $k=>$v ) {
            array_push($applyIds, $v['app_id']);
        }
        $list = array();
        $applyIds = array_filter($applyIds);
        $map['app_id'] = array('in', $applyIds);

        if ( count($applyIds) ) {
            $list = $this->order(array('listorder'))->where($map)->limit($limit['page'].','.$limit['pagesize'])->select();
            $list = $this->moreInfo($list);
        }
        return array(
            'list' => $list,
            'map' => $map
        );

    }

    // 获取应用列表
    function getList( $map = array(), $limit=array() ) {
        //$map = setMapPrefix( $map, $this->trueTableName );
        $list = $this->order(array('listorder'))->where($map)->limit($limit['page'].','.$limit['pagesize'])->select();

        return $list;
    }


}
?>