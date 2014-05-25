<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends CommonAction{

    // 首页
    public function index() {
        $LotteryUser = D('Common://AppLotteryUser');
        // 验证是否已经“报名”
        $map['uid'] = $_GET['uid'];
        $map['openid'] = $_GET['openid'];
        $map['lot_id'] = $_GET['lot_id'];
        $obj = $LotteryUser->where($map)->find();

        if ( $obj ) {
            if ( $obj['prize_id'] ) {

            } else {
                $this->display($this->Skin.':Index:success');
            }
        } else {
            // 未报名
            $this->display($this->Skin.':Index:index');
        }


    }


    // 婚庆大屏幕
    public function screen() {

        $this->display($this->Skin.':Index:screen');
    }

    // 抽奖活动
    public function prize() {
        $LotteryUser = D('Common://AppLotteryUser');
        $map['uid'] = $_GET['uid'];
        $map['lot_id'] = $_GET['lot_id'];
        $map['prize_id'] = 0;

        $list = $LotteryUser->getListWithImg($map);
        $this->assign('list', $list);

        // 获奖人名单
        $map['prize_id'] = $_GET['prize_id'];
        $winList = $LotteryUser->getListWithImg($map);
        $this->assign('winList', $winList);

        $Prize = D('Common://AppLotteryPrize');
        $prize = $Prize->where( $map )->find();
        $this->assign('winCount', $prize['amount']);


        // 测试
        //$this->prizeTest();
        $this->display($this->Skin.':Index:prize');
    }

    // 抽奖测试
    public function prizeTest() {
        $LotteryUser = D('Common://AppLotteryUser');
        $SubscribeUser = M('SubscribeUser');

        $arr = array();
        $obj = array();

        for ( $i=0;$i<18;$i++ ) {
            $obj['headimgurl'] = 'http://itshajia.com/App/Lottery/Resource/Skin_1/Images/pic/2/'.($i+1).'.jpg';
            $obj['nickname'] = ($i+1);
            $obj['openid'] = 'oSf0StyB5PruI851mkgVqP7N5Lv0'.($i+1);
            array_push($arr, $obj);
        }

        foreach( $arr as $k=>$v ) {
            $data = array();
            $data['uid'] = 4;
            $data['truename'] = $v['nickname'];
            $data['openid'] = $v['openid'];
            $data['tel'] = '13852457093';
            $data['prize_id'] = 0;
            $data['lot_id'] = 2;
            $data['addtime'] = time();
            $LotteryUser->add( $data );
        }

        foreach( $arr as $k=>$v ) {
            $data = array();
            $data['uid'] = 4;
            $data['openid'] = $v['openid'];
            $data['nickname'] = $v['nickname'];
            $data['headimgurl'] = $v['headimgurl'];
            $data['addtime'] = time();
            $SubscribeUser->add( $data );
        }

    }

}