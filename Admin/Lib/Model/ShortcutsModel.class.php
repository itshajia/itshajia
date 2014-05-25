<?php
class ShortcutsModel extends CommonModel {


    // 获取快捷操作
    public function listByUid() {

        $map['uid'] = $_SESSION['_adminUser']['uid'];
        return $this->join('JOIN '.$this->tablePrefix.'submenu_resource USING (resource_id)')->where($map)->select();
    }
}
?>