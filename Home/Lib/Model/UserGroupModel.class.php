<?php
class UserGroupModel extends CommonModel {


    // 数据格式化
    public function data_format() {
        $ids = $this->group_rules;

        if( $ids ) {
            $this->group_rules = join(',', $ids);
        }
        $this->uptime = time();

    }

    // 获取后台可见的 “系统组数组”
    public function list_visible() {
        //$map[]
    }




}
?>