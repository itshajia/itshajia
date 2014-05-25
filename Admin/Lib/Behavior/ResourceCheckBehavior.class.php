<?php
class ResourceCheckBehavior extends Behavior{


    public function run(&$return) {

        // 超级管理员无需 “路由权限” 限制
        if( $_SESSION['_adminUser']['group_id']==1 ) {
            $return = true;
            return;
        }

        $Resource = D('SubmenuResource');
        $ableResourceIds = $Resource->getAbleResourceIds();
        $id = $Resource->getIdByMA();

        if( $id ) {

            if( in_array($id, $ableResourceIds) ) {
                $return = true;
            } else {
                $return = false;
            }

        } else {
            $return = true;
        }

    }
}
?>