<?php
class SubmenuResourceModel extends CommonModel {

    // 根据 submenu_id 获取
    public function getListBySId($submenu_id) {
        $UserGroup = D('UserGroup');
        $map0 = array();
        $map0['group_id'] = $_SESSION['_adminUser']['group_id'];
        $userGroup = $UserGroup->where($map0)->find();
        $rules = explode(',', $userGroup['group_rules']);

        // 超级管理员无需 “路由权限” 限制
        if( $_SESSION['_adminUser']['group_id']!=1 ) {
            $map['resource_id'] = array('in', $rules);
        }

        $map['submenu_id'] = $submenu_id;
        $map['status'] = 1;

        $list = $this->where($map)->select();

        for( $i=0;$i<count($list);$i++ ) {
            $list[$i]['resource_url'] = appUrl($list[$i]['resource_url']);
        }
        return $list;
    }

    // 数据格式化
    public function data_format() {
        $this->status = $this->status ? 1 : 0;
    }

    // 联合 Submenu 表获取 “菜单项”列表
    public function getListWithJoin($map = array()) {
        //var_dump($this);
        //echo $this->trueTableName.'.*,'.$this->tablePrefix.'menu.menu_name';
        return $this->join('JOIN '.$this->tablePrefix.'submenu USING (submenu_id)')->field($this->trueTableName.'.*,'.
            $this->tablePrefix.'submenu.submenu_name,'.$this->tablePrefix.'submenu.
            listorder as plistorder')->order(array('plistorder', 'listorder'))->where($map)->select();
    }

    // 获取可访问url地址
    public function getAbleResourceIds() {

        $UserGroup = D('UserGroup');
        $map = array();
        $map['group_id'] = $_SESSION['_adminUser']['group_id'];
        $userGroup = $UserGroup->where($map)->find();
        $rules = explode(',', $userGroup['group_rules']);

        $map = array();
        $map['resource_id'] = array('in', $rules);
        $list = $this->where($map)->field('resource_id')->select();

        $ids = array();
        for ( $i=0; $i<count( $list ); $i++) {
            array_push( $ids, $list[$i]['resource_id']);
        }

        return $ids;
    }

    // 根据 Module 和 Action 获取子菜单ID
    public function getIdByMA() {
        $map['mod'] = MODULE_NAME;
        $map['act'] = ACTION_NAME;

        $obj = $this->where($map)->find();

        if( $obj ) {
            $id = $obj['resource_id'];
        } else {
            $id = 0;
        }

        return $id;
    }
}
?>