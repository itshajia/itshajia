<?php
class LotteryAction extends Action{

    public function join(){
        $LotteryUser = M('AppLotteryUser');

        $map['uid'] = $_POST['uid'];
        $map['lot_id'] = $_POST['lot_id'];
        $map['openid'] = $_POST['openid'];
        $obj = $LotteryUser->where($map)->find();

        if ( $obj ) {
            $success = false;
            $msg = "您已经报过名了哦！";
        } else {
            $LotteryUser->create();
            $LotteryUser->addtime = time();

            if ( $LotteryUser->add() ) {
                $success = true;
                $msg = "报名成功！！";
            } else {
                $success = false;
                $msg = "报名失败！";
            }
        }



        $dataJson = array(
            'success' => $success,
            'msg' => $msg
        );

        echo json_encode( $dataJson );
    }

    public function doing() {
        $LotteryUser = M('AppLotteryUser');

        $map['uid'] = $_POST['uid'];
        $map['lot_id'] = $_POST['lot_id'];
        $map['openid'] = $_POST['openid'];
        $data['prize_id'] = $_POST['prize_id'];

        $LotteryUser->where($map)->save( $data );
    }

    // 测试专用
    public function reset() {
        $LotteryUser = M('AppLotteryUser');

        $map['uid'] = $_POST['uid'];
        $map['lot_id'] = $_POST['lot_id'];
        $map['prize_id'] = $_POST['prize_id'];

        $data['prize_id'] = 0;
        $LotteryUser->where($map)->save( $data );
        $success = true;
        $msg = '重置成功！';

        $dataJson = array(
            'success' => $success,
            'msg' => $msg
        );

        echo json_encode( $dataJson );
    }

}

?>