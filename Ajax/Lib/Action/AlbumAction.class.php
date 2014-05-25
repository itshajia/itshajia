<?php
class AlbumAction extends Action{

    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 相册操作
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
    public function setCover() {
        if ( $_POST['id'] ) {
            $map['pic_id'] = $_POST['id'];
            $map['uid'] = $_SESSION['_User']['uid'];
            $pic = D('AlbumPic')->where($map)->find();

            $map2['uid'] = $_SESSION['_User']['uid'];
            if ( $pic['album_id'] ){
                $map2['album_id'] = $pic['album_id'];
            } else {
                $map2['item_id'] = $pic['item_id'];
                $map2['app_name'] = $pic['app_name'];
            }

            $data['is_cover'] = 0;
            D('AlbumPic')->where($map2)->save($data);

            $data['is_cover'] = 1;
            D('AlbumPic')->where($map)->save($data);

            $success = true;
            $msg = "封面设置成功！";

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