<?php
class ReplyAction extends Action{

    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 图文回复
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
    public function imgReplyAdd() {
        $ReplyImg = D('ReplyImg');

        if ( $_POST['img_id'] ) {
            $ReplyImg->create();

            if ( $ReplyImg->save() ) {
                $success = true;
                $msg = "数据保存成功！";
            } else {
                $success = false;
                $msg = "数据保存失败！";
            }
        } else {
            $ReplyImg->create();
            $ReplyImg->uid = $_SESSION['_User']['uid'];
            $ReplyImg->addtime = time();
            if ( $ReplyImg->add() ) {
                $success = true;
                $msg = "数据添加成功！";
            } else {
                $success = false;
                $msg = "数据添加失败！";
            }
        }

        $dataJson = array(
            'success' => $success,
            'msg' => $msg
        );

        echo json_encode( $dataJson );
    }


    public function getReply() {
        if ( $_POST['id'] ) {
            $ReplyImg = M('ReplyImg');
            $map['uid'] = $_SESSION['_User']['uid'];
            $map['img_id'] = $_POST['id'];
            $replyImg = $ReplyImg->where($map)->find();

            if ( $replyImg ) {
                $success = true; $msg = "获取成功！";
            } else {
                $success = false; $msg = "该图文不存在！";
            }

        } else {
            $success = false;
            $msg = "请求地址不正确！";
        }

        $dataJson = array(
            'success' => $success,
            'msg' => $msg,
            'fdata' => $replyImg
        );

        echo json_encode( $dataJson );
    }


    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * XXXX
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
}

?>