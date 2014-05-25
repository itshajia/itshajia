<?php
class AdAction extends Action{

    public function linkurl() {
        if ( $_POST['id'] ) {
            $map['ad_id'] = $_POST['id'];
            $map['uid'] = $_SESSION['_User']['uid'];

            $data['linkurl'] = $_POST['linkurl'];
            D('AppAd')->where($map)->save($data);

            $success = true;
            $msg = "添加链接成功！";

        } else {
            $success = false;
            $msg = "请求地址不正确！";
        }

        $dataJson = array(
            'success' => $success,
            'msg' => $msg
        );

        echo json_encode( $dataJson );
    }


}
?>