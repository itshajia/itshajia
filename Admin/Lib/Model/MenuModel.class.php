<?php
class MenuModel extends CommonModel {


    // 数据格式化
    public function data_format() {
        $this->status = $this->status ? 1 : 0;
    }

    //
    public function getListWithRules() {
        $_adminUser = session('_adminUser');
        $UserGroup = D('UserGroup');
        $SubmenuResource = D('SubmenuResource');

        $map['group_id'] = $_adminUser['group_id'];
        $userGroup = $UserGroup->where($map)->find();
        $group_rules = array_filter(explode(',', $userGroup['group_rules']));

        $map = array();
        $map['resource_id'] = array('in', $group_rules);
        $list = $SubmenuResource->join('JOIN '.$this->tablePrefix.'submenu USING (submenu_id)')->field(
            $this->tablePrefix.'submenu_resource.*,'.$this->tablePrefix.'submenu.menu_id')->where($map)->select();

        $menu_ids = array();
        for( $i=0;$i<count($list);$i++ ) {
            array_push( $menu_ids, $list[$i]['menu_id']);
        }
        $menu_ids = array_filter($menu_ids);

        $map = array();
        $map['menu_id'] = array('in', $menu_ids);
        $map['status'] = 1;
        $list = $this->where($map)->order(array('listorder'))->select();

        return $list;

    }


}
?>