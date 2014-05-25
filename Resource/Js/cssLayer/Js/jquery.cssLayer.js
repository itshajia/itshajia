jQuery( function( $ ){

    $.cssLayer = {
        idex: 1,
        zIndex: 999999
    };

    var CL = $.cl = $.cssLayer;
    $.extend(CL, {
        setPos: function( L, is_form ) {
            var h ,hH, fH, LH;
            var scroll = CL.getScrollTop();
            var scrollTop;

            hH = $('.cssLayerHead', L.CLBox).height();
            fH = $('.cssLayerFoot', L.CLBox).height();
            LH = L.CL.height();

            h = L.CLBoxInner.height() + hH + fH;

            if ( LH >= ( h + scroll ) ) {
                L.CLOutter.css({top: scroll});
            } else {
                scrollTop = LH - h - 150;
                L.CLOutter.css({top: scrollTop});
            }

            setTimeout(function(){
                if ( is_form ) {
                    L.CLInner.addClass('out');
                } else {
                    L.CLBox.addClass('out');
                }

            }, 250);

        },
        getBone: function( title, is_form , is_success) {
            var className = is_form ? "" : "lmsg";
            var errorClass = is_success ? "success" : "error";
            var Htm = '<div class="cssLayer">'+
                '<div class="cssLayerOutter">'+
                '<div class="cssLayerInner '+ className +'">'+
                '<div class="cssLayerBox">'+
                '<div class="cssLayerShadow"></div>'+
                '<div class="cssLayerHead">'+
                '<span class="cssLayerTitle">'+ title +'</span>'+
                this.getCloseHtm( is_form )+
                '</div>'+
                '<div class="cssLayerBody">'+
                '<div class="cssLayerBodyInner">' +
                '<div class="cssBodyContainer '+ className +' '+ errorClass +'"></div>' +
                '</div>'+
                '</div>'+
                this.getFootHtm( is_form ) +
                '</div>'+
                '</div>'+
                '</div>'+
                '</div>';

            return $(Htm);
        },
        getCloseHtm: function( is_form ) {
            return is_form ? '<a href="javascript:;" class="cssLayerClose"></a>' : '';
        },
        getFootHtm: function( is_form ) {
            return is_form ? '<div class="cssLayerFoot">'+
                '<div class="cssLayerFootInner">'+
                this.getCancelHtm( is_form ) +
                '</div>'+
                '</div>' : '';
        },
        getCancelHtm: function( is_form ){
            return is_form ? '<a href="javascript:;" class="cssLayerOK cssLayerButton">确定</a><a href="javascript:;" class="cssLayerCancel cssLayerButton">取消</a>' : '';
        },
        getScreenWidth: function(){
            return document.documentElement.clientWidth || document.body.clientWidth;
        },
        getScrollHeight: function(){
            return document.documentElement.scrollHeight || document.body.scrollHeight;
        },
        getScrollTop: function() {
            return document.documentElement.scrollTop || document.body.scrollTop;
        }
    });

    /**
     *  表单弹出层
     * */
    CL.form = function( options ){
        // 默认配置
        var settings = {
            width: 100,
            height: 90,
            cHeight: 'auto',
            title: '操作提示',
            zIndex: CL.zIndex,
            tmplId: 'cssLayerTmpl',
            data: '',
            hide: false,
            padding: true,
            insertBeforeFun: function( L ){},
            insertAfterFun: function( L ){},
            OKFun: function(){},
            CancelFun: function(){},
            CloseFun: function(){}
        };

        if( options ) $.extend( settings, options );

        var L = {};
        $.extend( L, {
            initialize: function() {
                this.initDom();
            },
            initDom: function() {
                var cssLayer,cssLayerBox;

                cssLayer = CL.getBone(settings.title, 1);

                L.CL = cssLayer;
                cssLayerBox = $('.cssLayerBox', cssLayer);
                L.CLOutter = $('.cssLayerOutter ', cssLayer);
                L.CLInner = $('.cssLayerInner ', cssLayer);
                L.CLBox = cssLayerBox;
                L.CLBoxInner = $('.cssLayerBodyInner', cssLayerBox);

                cssLayer.attr('id', 'cssLayer_'+ CL.idex).css({
                    'min-height': CL.getScrollHeight(),
                    'z-index': parseInt( settings.zIndex) + parseInt( CL.idex )
                });

                if ( !settings.padding ) cssLayer.addClass('no_padding');

                cssLayerBox.css({
                    width: settings.width +"%",
                    height: settings.height +"%"
                });

                //L.CLOutter.css({top: CL.getScrollTop()});

                if ( settings.insertBeforeFun ) settings.insertBeforeFun();
                this.insertDom();
                $('body').append( cssLayer );
                if ( settings.insertAfterFun ) settings.insertAfterFun( L );

                CL.setPos( L, 1 );
                this.onEvents();
                CL.idex++;
            },
            insertDom: function() {
                $('.cssBodyContainer', L.CL).height(settings.cHeight).append($('#'+ settings.tmplId ).tmpl( settings.data ) )
            },
            getId: function(){
                return 'cssLayer_'+ CL.idex;
            },
            show: function(){
                L.CL.show();
                setTimeout(function(){
                    L.CLInner.addClass('out');
                },150)

            },
            close: function() {
                L.CLInner.removeClass('out');
                $('div').delay(500, 'cssLayerForm')
                .queue('cssLayerForm', function(next){
                    if( !settings.hide ){
                        console.log('remove');
                        L.CL.remove();
                    } else {
                        L.CL.hide();
                    }
                    next();
                })
                .dequeue('cssLayerForm');
            },
            onEvents: function() {
                this.onClose();
                this.onCancel();
                this.onOK();
            },
            onClose: function() {
                $('.cssLayerClose', L.CL).on('click', function(){
                    L.doClose();
                });
            },
            doClose: function() {
                if ( settings.CloseFun ) settings.CloseFun();
                L.CLInner.removeClass('out');
                $('div').delay(500, 'cssLayerForm')
                .queue('cssLayerForm', function(next){
                    if( !settings.hide ){
                        L.CL.remove();
                    } else {
                        L.CL.hide();
                    }
                    if ( L.EndFun ) L.EndFun( );
                    next();
                })
                .dequeue('cssLayerForm');
            },
            onCancel: function() {
                $('.cssLayerCancel', L.CL).on('click', function(){
                    L.doCancel();
                });
            },
            doCancel: function() {
                if ( settings.CancelFun ) settings.CancelFun();
                L.CLInner.removeClass('out');
                $('div').delay(500, 'cssLayerForm')
                .queue('cssLayerForm', function(next){
                    if( !settings.hide ){
                        L.CL.remove();
                    } else {
                        L.CL.hide();
                    }
                    if ( L.EndFun ) L.EndFun( );
                    next();
                })
                .dequeue('cssLayerForm');
            },
            onOK: function() {
                $('.cssLayerOK', L.CL).on('click', function(){
                    L.doOK();
                });
            },
            doOK: function() {
                if ( settings.OKFun ) {
                    if ( settings.OKFun() ){
                        L.CLInner.removeClass('out');
                        $('div').delay(500, 'cssLayerForm')
                        .queue('cssLayerForm', function(next){
                            if( !settings.hide ){
                                L.CL.remove();
                            } else {
                                L.CL.hide();
                            }
                            if ( L.EndFun ) L.EndFun( );
                            next();
                        })
                        .dequeue('cssLayerForm');
                    }
                }

            }
        } );
        L.initialize();
        return L;
    }

    // 信息弹出层
    CL.alert = function( msg, success ) {
        if ( !msg ) return;

        // 默认配置
        var settings = {
            width: 100,
            title: '信息提示',
            zIndex: CL.zIndex
        };

        var L = {};
        $.extend( L, {
            initialize: function() {
                this.initDom();
            },
            initDom: function() {
                var cssLayer,cssLayerBox;

                cssLayer = CL.getBone( settings.title, 0, success );
                L.CL = cssLayer;
                cssLayerBox = $('.cssLayerBox', cssLayer);
                L.CLOutter = $('.cssLayerOutter ', cssLayer);
                L.CLInner = $('.cssLayerInner ', cssLayer);
                L.CLBox = cssLayerBox;
                L.CLBoxInner = $('.cssLayerBodyInner', cssLayerBox);

                cssLayer.attr('id', 'cssLayer_'+ CL.idex).css({
                    'min-height': CL.getScrollHeight(),
                    'z-index': parseInt( settings.zIndex) + parseInt( CL.idex )
                });

                cssLayerBox.css({
                    width: settings.width +"%"
                });

                L.CLOutter.css({top: CL.getScrollTop()});

                this.insertDom();
                $('body').append( cssLayer );

                CL.setPos( L,0 );

                // 3秒后自动退出
                setTimeout( function(){
                    L.CLBox.removeClass('out');
                    $('div').delay(500, 'cssLayerAlert')
                        .queue('cssLayerAlert', function(next){
                            L.CL.remove();
                            next();
                        })
                        .dequeue('cssLayerAlert');
                }, 3000);
                CL.idex++;
            },
            getId: function(){
                return 'cssLayer_'+ CL.idex;
            },
            insertDom: function() {
                $('.cssBodyContainer', L.CL).text( msg );
            }
        });

        L.initialize();
    };

} );