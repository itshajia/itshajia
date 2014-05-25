define( function( require, exports, module ){

    var $ = require('jquery');


    // appEffect
    exports.appEffect = function () {
        var T,_this;
        $('.appGroup').hover( function(){
            _this = this;

            T = setTimeout( function(){
                $('.appCoverTop', $(_this)).animate({top: '0px'}, 250);
                $('.appCoverBottom', $(_this)).animate({bottom: '0px'}, 250);
            }, 150 );

        }, function(){
            clearTimeout(T);
            $('.appCoverTop', $(this)).animate({top: '-65px'}, 250);
            $('.appCoverBottom', $(this)).animate({bottom: '-65px'}, 250);
        } );

    }

    // appDel
    exports.appDel = function() {
        $('#appManage').bind('click', function(){
            $('.appGroup').each(function(){
                if ( $(this).hasClass('appDel') ) {
                    $(this).removeClass('appDel');
                } else {
                    $(this).addClass('appDel');
                }
            });
        });
    }


    /**
     * 公共接口
     * */
        // 提供 $ 接口
    exports.$ = $;

} );