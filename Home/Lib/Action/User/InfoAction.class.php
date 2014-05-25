<?php
class InfoAction extends CommonAction{

    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 消息回复
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
    public function reply() {
        if ( $_POST['submit'] ) {
            return;
        }
        $this->display('info_reply');
    }

    public function text() {
        if ( $_POST['submit'] ) {
            return;
        }
        $this->display('info_text');
    }

    public function pic() {
        if ( $_POST['submit'] ) {
            return;
        }
        $this->display('info_pic');
    }

    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * 实时消息
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
    public function realTime() {
        $Msg = D('Msg');
        $view = $_GET['view'] ? $_GET['view'] : 'today';

        $page = $_GET['page'] ? $_GET['page'] : 1;
        $pagesize = 10;
        $pageset = ( $page -1) * $pagesize;
        $limit = array('page'=> $pageset, 'pagesize'=> $pagesize);

        $map['uid'] = $_SESSION['_User']['uid'];
        switch ( $view ) {
            case "all":


                break;

            case "today":
                $map['senddate'] = date('Y-m-d', time());
                break;

            case "yesterday":
                $map['senddate'] = date('Y-m-d', time() - 3600*24);
                break;

            case "before":
                $map['senddate'] = date('Y-m-d', time() - 3600*24*2);
                break;

            case "beforemore":
                $map['adddate'] = array('elt', time() - 3600*24*3);
                break;
        }

        $list = $Msg->getList( $map, $limit );
        $pageHtml = page( $Msg->getCount($map), $page, $pagesize);

        // 标记为“已读”
        /*$map = array();
        foreach ( $list as $k=>$v ) {
            if ( !$v['is_read'] ){
                $map['id'] = $v['id'];
                $data['is_read'] = 1;
                $Msg->where( $map )->save( $data );
            }
        }*/

        $this->assign('list', $list);
        $this->assign('pageHtml', $pageHtml);
        $this->display('info_realtime');
    }



    /**
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * XXX
     * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
}
?>