define( function( require, exports, module ){

    return function( $ ) {

        $.fn.zxFadeSlider = function( options ) {
            // 默认配置
            var settings = {
            };

            if( options ) $.extend( settings, options );

            var F = fadeSlider = {idex: 0};
            F.el = this;

            $.extend( F, {
                initialize: function() {
                    this.initData();
                    this.initDom();
                    this.onRun();
                },
                initData: function() {
                    F.Lis = $('.zxFadeSliderItem', F.el);
                    F.resetZIndex();
                },
                initDom: function() {

                },
                onRun: function() {
                    F.T = setInterval( function(){
                        F.run();
                    }, 5000);
                },
                run: function() {
                    F.resetZIndex();
                    F.Lis.eq(F.getCurIdex()).css('zIndex', (F.Lis.length+1))
                    F.Lis.eq(F.getNextIdex()).css({opacity: 1});
                    F.Lis.eq(F.getCurIdex()).animate({opacity: 0}, {duration: 1000, queue: false})
                        .queue(function(next){
                            F.doIdex();
                            next();
                        });

                },
                getCurIdex: function() {
                    return F.idex;
                },
                getNextIdex: function() {
                    if (F.idex< F.Lis.length-1 ) {
                        return (F.idex+1);
                    } else {
                        return 0;
                    }
                },
                doIdex: function(){

                    if ( F.idex>= F.Lis.length-1 ) {
                        F.idex = 0;
                    } else {
                        F.idex++;
                    }

                },
                resetZIndex: function(){
                    F.Lis.each( function( i ){
                        $(this).css({'zIndex': F.Lis.length - i});
                    });
                }
            });

            F.initialize();

        };

    };

} );