define( function( require, exports, module ){
    var $ = require('jquery');
    require('uio')($);
    require('alert.css');
    require('alert')($);
    require('easyLayer.css');
    require('easyLayer')($);

    // 报名
    exports.join = function() {

        $('#goToJoin').on('click', function(){
            var frm, url, data, _this;

            if ( $(this).hasClass('loading')) return;

            if ( !$('#tel').val() ) {
                $.ml.msgAlert('请填写手机号码！');
                return;
            }

            if ( !$('#truename').val() ) {
                $.ml.msgAlert('请填写姓名！');
                return;
            }

            _this = this;
            $(this).addClass('loading');
            frm = $('#frm');
            url = $.uio.getWebUrl() +"/ajax.php?m=Lottery&a=join";
            data = frm.serialize();

            $.uio.post(url, data, function( dataJson ){
                $.ml.msgAlert( dataJson.msg, dataJson.success );
                $(_this).removeClass('loading');
                if ( dataJson && dataJson.success ) {
                    //frm.reset();
                    location.reload();
                }
            });

        });

    }

    // 活动抽奖
    exports.prize = function( imgList, winList, winCount ) {
        require('lottery.css');
        require('lottery')($);

        $('#lotteryReset').on('click', function(){
            var url, data;

            if ( !cfirm() ) return;
            url = $.uio.getWebUrl() +"/ajax.php?m=Lottery&a=reset";
            data = {
                'prize_id': $.uio.getUrlParam('prize_id'),
                'lot_id': $.uio.getUrlParam('lot_id'),
                'uid': $.uio.getUrlParam('uid')
            };

            $.uio.post(url, data, function( dataJson ){
                $.zxEasyLayer.alert( dataJson.msg, function(){ location.reload();} )

            });
        });

        $('#container').zxLottery({
            'startBtn': 'lotteryStart',
            'stopBtn': 'lotteryStop',
            'list': imgList,
            'winList': winList,
            'winCurCount': winList.length,
            'winCount': winCount,
            'success': function( obj ) {
                var url,data;

                url = $.uio.getWebUrl() +"/ajax.php?m=Lottery&a=doing";
                data = {
                    'openid': obj['openid'],
                    'prize_id': $.uio.getUrlParam('prize_id'),
                    'lot_id': $.uio.getUrlParam('lot_id'),
                    'uid': $.uio.getUrlParam('uid')
                };

                $.uio.post(url, data, function( dataJson ){
                });
            }
        });
    }

} );