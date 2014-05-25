<?php
class WeddingAction extends Action{

    public function bless() {
        $Bless = M('AppWeddingBless');

        /*$data['uid'] = $_POST['uid'];
        $data['wed_id'] = $_POST['wed_id'];
        $data['guest'] = $_POST['guest'];
        $data['pnum'] = $_POST['pnum'];
        $data['message'] = $_POST['message'];
        $data['openid'] = $_POST['openid'];*/
        $Bless->create();
        $Bless->status = 0;
        $Bless->addtime = time();

        if ( $Bless->add() ) {
            $success = true;
            $msg = "祝福已发送！";
        } else {
            $success = false;
            $msg = "发送失败，请重新发送！";
       }

        $dataJson = array(
            'success' => $success,
            'msg' => $msg
        );

        echo json_encode( $dataJson );
    }

    public function getBless() {
        $Bless = M('AppWeddingBless');

        $map['uid'] = $_POST['uid'];
        $map['wed_id'] = $_POST['wed_id'];
        $map['is_load'] = 0;

        $bless = $Bless->order(array('addtime'))->where($map)->find();
        if ( $bless ) {

            $map = array();
            $map['bless_id'] = $bless['bless_id'];
            $data['is_load'] = 1;
            $Bless->where($map)->save($data);

            $success = true;
            $msg = "获取成功！";
        } else {
            $success = false;
            $msg = "获取失败！";
        }

        $obj = array(
            'src' => 'http://gaoyongceshi.sk45.sdwlsym.com/apply/wedding/com/msg/tx.jpg',
            'guest' => $bless['guest'],
            'msg' => $bless['message'],
            'time' => date('Y-m-d H:m:s', $bless['addtime'])
        );

        $dataJson = array(
            'success' => $success,
            'msg' => $msg,
            'obj' => $obj
        );

        echo json_encode($dataJson);
    }

    public function screenReset() {
        $Bless = M('AppWeddingBless');

        $map['uid'] = $_POST['uid'];
        $map['wed_id'] = $_POST['wed_id'];

        $data['is_load'] = 0;
        if ( $Bless->where($map)->save($data) ) {
            $success = true;
            $msg = "数据重置成功！";
        } else {
            $success = false;
            $msg = "数据重置失败！";
        }

        $dataJson = array(
            'success' => $success,
            'msg' => $msg
        );

        echo json_encode($dataJson);
    }

}
?>