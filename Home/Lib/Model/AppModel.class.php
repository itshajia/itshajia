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

    // 获取审核应用列表
    function getNopassList( $limit=array() ) {
        $AppApplyRecord = D('AppApplyRecord');
        $recordIds = array();
        $map['is_check'] = 0;
        $map['uid'] = $_SESSION['_User']['uid'];
        $list = $AppApplyRecord->where($map)->select();

        foreach( $list as $k=>$v ) {
            array_push($recordIds, $v['app_id']);
        }
        $list = array();
        $recordIds = array_filter($recordIds);
        $map = array();
        $map['status'] = 1;
        $map['uid'] = $_SESSION['_User']['uid'];
        $map['app_id'] = array('in', $recordIds);

        if ( count($recordIds) ) {
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
        $list = $this->moreInfo($list);

        return $list;
    }


    //
    private function moreInfo( $list ) {
        $AppApply = D('AppApply');
        $AppApplyRecord = D('AppApplyRecord');

        for ( $i=0;$i<count($list);$i++ ) {
            $list[$i]['url'] = appUrl('m=App&a=show').'&app_id='.$list[$i]['app_id'];
            $map['status'] = 1;
            $map['app_id'] = $list[$i]['app_id'];
            $map['uid'] = $_SESSION['_User']['uid'];
            $appApply = $AppApply->where($map)->order(array('addtime'=>'desc'))->find();

            $map = array();
            $map['app_id'] = $list[$i]['app_id'];
            $map['is_check'] = 0;
            $map['uid'] = $_SESSION['_User']['uid'];
            $appApplyRecord = $AppApplyRecord->where($map)->find();

            if ( $appApply ){ $list[$i]['is_apply'] = 1;
                $list[$i]['go'] = appGoUrl($list[$i]['app_ename']);
            }

            if ( $appApplyRecord ) { $list[$i]['is_check'] = 0;
            }

        }

        return $list;
    }
}
?>