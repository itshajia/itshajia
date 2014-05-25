<?php
class SubmenuModel extends CommonModel {


    // 根据 menu_id 获取
    public function getListByMId($menu_id) {

        $map['menu_id'] = $menu_id;
        $map['status'] = 1;
        return $this->where($map)->order(array('listorder'))->select();
    }

    // 联合 Menu 表获取 “子菜单”列表
    public function getListWithJoin($map = array()) {
        //var_dump($this);
        //echo $this->trueTableName.'.*,'.$this->tablePrefix.'menu.menu_name';
        return $this->join('JOIN '.$this->tablePrefix.'menu USING (menu_id)')->field($this->trueTableName.'.*,'.
            $this->tablePrefix.'menu.menu_name,'.$this->tablePrefix.'menu.
            listorder as plistorder')->order(array('plistorder', 'listorder'))->where($map)->select();
    }

    // 数据格式化
    public function data_format() {
        $this->status = $this->status ? 1 : 0;
    }
}
?>