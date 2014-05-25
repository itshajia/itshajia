<?php
class ColumnModel extends CommonModel{

    // 获取系统栏目
    public function getSysColumn() {

        $map['uid'] = $_SESSION['_User']['uid'];
        $map['is_sys'] = 1;
        $map['app_name'] = 'wz';

        return $this->order(array('sort'))->where( $map )->select();
    }

    // 获取自定义栏目
    public function getCustomColumn() {

        $map['uid'] = $_SESSION['_User']['uid'];
        $map['is_sys'] = 0;
        $map['app_name'] = 'wz';

        return $this->order(array('sort'))->where( $map )->select();
    }
}
?>