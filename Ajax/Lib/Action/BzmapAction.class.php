<?php
class BzmapAction extends Action{
    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 地图标注
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
    public function getMap() {
        
        $success = true;
        $msg = "获取成功！";
        $mapList = array();

        $dataJson = array(
            'success' => $success,
            'msg' => $msg,
            'mapList' => $mapList
        );

        echo json_encode( $dataJson );
    }

    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * XXXX
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
}