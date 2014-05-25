<?php
class CommonAction extends Action{

    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 文件操作
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
    public function fileDel() {
        if( $_POST['path'] ) {

            if ( $_POST['id'] && $_POST['idName'] && $_POST['tName'] && $_POST['fName'] ) {
                // 先修改数据库中的数据
                $Table = M( $_POST['tName'] );
                $map['uid'] = $_SESSION['_User']['uid'];
                $map[$_POST['idName']] = $_POST['id'];

                // 相册删除图片
                if ( $_POST['isAlbum'] ) {
                    $Table->where($map)->delete();
                } else {

                    // 非相册删除图片
                    $obj = $Table->where($map)->find();
                    $arr = array();
                    if ( $obj && $obj[ $_POST['fName'] ]){

                        $data[ $_POST['fName'] ] = str_replace( urldecode($_POST['path']), "", $obj[ $_POST['fName'] ]);
                        $arr = explode(',', $data[ $_POST['fName'] ]);
                        $arr = array_filter($arr);
                        $data[ $_POST['fName'] ] = join(',', $arr);
                        $Table->where($map)->save($data);
                    }
                }
            }





            // 获取文件真实路径
            $address = url2root( urldecode($_POST['path']), C('WEB_URL') );

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
            'msg' => $msg,
            'obj' => $obj,
            'path' => urldecode($_POST['path']),
            'pic' => $obj[ $_POST['fName'] ]
        );

        echo json_encode( $dataJson );
    }


    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * XXX
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
}

?>