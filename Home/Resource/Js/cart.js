define( function( require, exports, module ){
    var $ = require('jquery');
    require('uio')($);
    require('tmpl')($);
    require('easyLayer.css');
    require('easyLayer')($);

    // 立即添加 或 立即购买
    exports.buyNow = function( app_id, is_fee, price ) {
        $('#buyNow').bind('click', function(){
            var _this = this, data;

            if ( is_fee==1 ) {
                $.zxEasyLayer.form({
                    data: {price: price},
                    tmplId: 'buyTmpl',
                    title: '应用申请',
                    OKFun: function() {
                        data = {'app_id': app_id, 'year': $('#year').val()};
                        buyPost( data );
                        return true;
                    },
                    CancelFun: function(){
                    },
                    CloseFun: function() {
                    }
                });
                yearSelect();
                function yearSelect() {
                    var total = $('#total_fee');
                    $('#year').on('change', function(){
                        //console.log(12122);
                        total.text( parseInt($(this).val()) * price );
                    });
                }

            } else {
                if ( $(this).hasClass('loading') ) return false;
                $(this).addClass('loading');
                data = {'app_id': app_id};
                buyPost( data );
            }

            function buyPost( data ) {
                var url = $.uio.getWebUrl() + '/ajax.php?m=User&a=buyNow';
                $.uio.post( url, data, function( dataJson ) {

                    if ( dataJson && dataJson.success ) {
                        $.zxEasyLayer.alert( dataJson.msg, function(){ location.reload(); } )
                    } else {
                        $(_this).removeClass('loading');
                    }
                }, 'json');
            }
        });


    }


    /**
     * 公共接口
     * */
        // 提供 $ 接口
    exports.$ = $;
} );