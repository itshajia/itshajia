<?php
class AjaxAction extends Action{

    // 文件删除
    public function fileDel() {

        if( $_POST['path']) {
            // 获取文件真实路径
            $address = url2root( urldecode($_POST['path']), C('SUB_WEB_URL') );

            if ( file_exists($address) ) {
                unlink($address);
                $success = true;
                $msg = "删除成功！";
            } else {
                $success = false;
                $msg = "文件不存在！";
            }
        } else {
            $success = false;
            $msg = "文件路径丢失！";
        }

        $dataJson = array(
            'success' => $success,
            'msg' => $msg
        );

        echo json_encode( $dataJson );
    }


}
?>