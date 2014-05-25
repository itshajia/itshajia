<?php
class UserAction extends Action{

    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 应用购买 或 添加
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
    public function buyNow() {
        if ( $_POST['app_id'] ) {
            $App = D('App');
            $map['app_id'] = $_POST['app_id'];
            $app = $App->where($map)->find();

            if( $app ) {

                if ( $app['is_fee'] ) {
                    // 添加申请记录
                    $AppApplyRecord = D('AppApplyRecord');
                    $data['app_id'] = $_POST['app_id'];
                    $data['uid'] = $_SESSION['_User']['uid'];
                    $data['addtime'] = time();
                    $data['is_check'] = 0;
                    $data['year'] = $_POST['year'] ? $_POST['year'] : 0;

                    if ( $AppApplyRecord->add($data) ) { $success = true; $msg = "申请成功，稍后管理员会进行审核！";
                    } else { $success = false; $msg = "申请失败！";
                    }
                } else {
                    // 添加申请记录
                    $AppApplyRecord = D('AppApplyRecord');
                    $data['app_id'] = $_POST['app_id'];
                    $data['uid'] = $_SESSION['_User']['uid'];
                    $data['addtime'] = time();
                    $data['is_check'] = 1;
                    $AppApplyRecord->add($data);

                    $AppApply = D('AppApply');
                    $map['app_id'] = $_POST['app_id'];
                    $map['uid'] = $_SESSION['_User']['uid'];
                    $appApply = $AppApply->order(array('addtime'=>'desc'))->where($map)->find();

                    if( $appApply ) {
                        $data['status'] = 1;

                        if ( $AppApply->where($map)->save($data) ) { $success = true; $msg = "添加成功！";
                        } else { $success = false; $msg = "添加失败！";
                        }
                    } else {
                        $data['app_id'] = $_POST['app_id'];
                        $data['uid'] = $_SESSION['_User']['uid'];
                        $data['addtime'] = time();
                        $data['status'] = 1;

                        if ( $AppApply->add($data) ) { $success = true; $msg = "添加成功！";
                        } else { $success = false; $msg = "添加失败！";
                        }
                    }


                }
            } else { $success = false; $msg = "该应用不存在！";
            }
        } else { $success = false; $msg = "请求地址不正确！";
        }
        $dataJson = array(
            'success' => $success,
            'msg' =>$msg
        );
        echo json_encode($dataJson);
    }


    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * XXX
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
}

?>