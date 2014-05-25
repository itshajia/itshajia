define( function( require, exports, module ){

    return function( $ ){

        $.zxEasyLayer = {
            idex: 1,
            zIndex: 1000
        };

        var EL = $.zxEasyLayer;
        $.extend(EL, {
            setPos: function( L ) {
                var h, winH ,hH, fH;

                hH = $('.easyLayerHead', L.ELBox).height();
                fH = $('.easyLayerFoot', L.ELBox).height();

                h = L.ELBoxInner.height() + hH + fH;
                winH = $(window).height();

                if ( winH > h ) {
                    L.ELBox.css({
                        marginTop: (winH - h)/4 +'px'
                    });
                    $('.easyLayerBody', L.ELBox).height('auto').removeClass('scroll');
                } else {
                    L.ELBox.css({
                        marginTop: 0
                    });

                    $('.easyLayerBody', L.ELBox).height( winH - hH - fH ).addClass('scroll');
                }

            },
            onDrag: function( L ){
                var tar = $('.easyLayerHead', L.EL);
                var flag = false, sX, sY, offset;

                tar.bind('mousedown', function(e){
                    sX = 0;
                    sY = 0;
                    offset = tar.offset()

                    if ( e.button == 0 ) {
                        flag = true;
                    }
                    sX = e.clientX - offset.left;
                    sY = e.clientY - offset.top;
                    return false;
                });

                $(document).bind('mousemove', function(e){
                    if ( flag == true) {
                        var x = e.clientX - sX;
                        var y = e.clientY - sY;
                        L.ELBox.css({
                            marginTop: 0,
                            marginLeft: 0,
                            left: x +'px',
                            top: y +'px'
                        });
                    }
                    //return false;
                });

                $(document).bind('mouseup', function(){
                    flag = false;
                    //return false;
                });

            },
            onResize: function( L ) {
                var T;
                $(window).bind('resize', function(){
                    clearTimeout(T);
                    T = setTimeout(function(){
                        EL.setPos( L );
                    }, 250)
                });
                /*$('.easyBodyContainer ', L).bind('resize', function(){
                 console.log(121212);
                 });*/
                $('.easyBodyContainer ', L).resize(function(){
                    console.log(121212);
                });
            },
            getBone: function( title, is_form ) {
                var className = is_form ? "" : "lmsg";
                var Htm = '<div class="easyLayer con_body">'+
                    '<div class="easyLayerInner">'+
                    '<div class="easyLayerBox">'+
                    '<div class="easyLayerShadow"></div>'+
                    '<div class="easyLayerHead">'+
                    '<span class="easyLayerTitle">'+ title +'</span>'+
                    '<a href="javascript:;" class="easyLayerClose"></a>'+
                    '</div>'+
                    '<div class="easyLayerBody">'+
                    '<div class="easyLayerBodyInner">' +
                    '<div class="easyBodyContainer '+ className +'"></div>' +
                    '</div>'+
                    '</div>'+
                    '<div class="easyLayerFoot">'+
                    '<div class="easyLayerFootInner">'+
                    '<a href="javascript:;" class="easyLayerOK easyLayerButton">确定</a>'+
                    this.getCancelHtm( is_form ) +
                    '</div>'+
                    '</div>'+
                    '</div>'+
                    '</div>'+
                    '</div>';

                return $(Htm);
            },
            getCancelHtm: function( is_form ){
                return is_form ? '<a href="javascript:;" class="easyLayerCancel easyLayerButton">取消</a>' : '';
            },
            getScreenWidth: function(){
                return document.documentElement.clientWidth || document.body.clientWidth;
            },
            getScrollHeight: function(){
                return document.documentElement.scrollHeight || document.body.scrollHeight;
            }
        });

        /**
         * 表单弹出层
         * */
        EL.form = function( options ) {
            // 默认配置
            var settings = {
                width: 500,
                title: '操作提示',
                zIndex: EL.zIndex,
                tmplId: 'easyLayerTmpl',
                data: '',
                OKFun: function(){},
                CancelFun: function(){},
                CloseFun: function(){}
            };

            if ( options ) $.extend( settings, options );

            var L = {};
            $.extend( L, {
                initialize: function() {
                    this.initDom();
                },
                initDom: function() {
                    var easyLayer,easyLayerBox;

                    easyLayer = EL.getBone(settings.title, 1);
                    L.EL = easyLayer;
                    easyLayerBox = $('.easyLayerBox', easyLayer);
                    L.ELBox = easyLayerBox;
                    L.ELBoxInner = $('.easyLayerBodyInner', easyLayerBox);

                    easyLayer.attr('id', 'easyLayer_'+ EL.idex).css({
                        'z-index': parseInt( settings.zIndex) + parseInt( EL.idex )
                    });

                    easyLayerBox.css({
                        width: settings.width
                    });

                    this.insertDom();
                    $('body').append( easyLayer );

                    EL.setPos( L );
                    EL.onDrag( L );
                    this.onEvents();
                    EL.onResize( L );
                },
                insertDom: function() {
                    /*if ( settings.data ) {

                     }*/
                    $('.easyBodyContainer', L.EL).append($('#'+ settings.tmplId ).tmpl( settings.data ) )
                },
                onEvents: function() {
                    this.onClose();
                    this.onCancel();
                    this.onOK();
                },
                onClose: function() {
                    $('.easyLayerClose', L.EL).on('click', function(){
                        L.doClose();
                    });
                },
                doClose: function() {
                    if ( settings.CloseFun ) settings.CloseFun();
                    L.EL.remove();
                },
                onCancel: function() {
                    $('.easyLayerCancel', L.EL).on('click', function(){
                        L.doCancel();
                    });
                },
                doCancel: function() {
                    if ( settings.CancelFun ) settings.CancelFun();
                    L.EL.remove();
                },
                onOK: function() {
                    $('.easyLayerOK', L.EL).on('click', function(){
                        L.doOK();
                    });
                },
                doOK: function() {
                    if ( settings.OKFun ) {
                        if ( settings.OKFun() ) L.EL.remove();
                    }

                }

            } );

            L.initialize();

        }


        // 信息弹出层
        EL.alert = function( msg, OKFun ) {

            // 默认配置
            var settings = {
                width: 300,
                title: '操作提示',
                zIndex: EL.zIndex
            };

            var L = {};
            $.extend( L, {
                initialize: function() {
                    this.initDom();
                },
                initDom: function() {
                    var easyLayer,easyLayerBox;

                    easyLayer = EL.getBone( settings.title, 0 );
                    L.EL = easyLayer;
                    easyLayerBox = $('.easyLayerBox', easyLayer);
                    L.ELBox = easyLayerBox;
                    L.ELBoxInner = $('.easyLayerBodyInner', easyLayerBox);

                    easyLayer.attr('id', 'easyLayer_'+ EL.idex).css({
                        'z-index': parseInt( settings.zIndex) + parseInt( EL.idex )
                    });

                    easyLayerBox.css({
                        width: settings.width
                    });

                    this.insertDom();
                    $('body').append( easyLayer );

                    EL.setPos( L );
                    EL.onDrag( L );
                    this.onEvents();
                    EL.onResize( L );
                },
                insertDom: function() {
                    $('.easyBodyContainer', L.EL).text( msg );
                },
                onEvents: function() {
                    this.onClose();
                    this.onOK();
                },
                onClose: function() {
                    $('.easyLayerClose', L.EL).on('click', function(){
                        L.doClose();
                    });
                },
                doClose: function() {
                    if ( OKFun ) OKFun();
                    L.EL.remove();
                },
                onOK: function() {
                    $('.easyLayerOK', L.EL).on('click', function(){
                        L.doOK();
                    });
                },
                doOK: function() {
                    if ( OKFun ) OKFun();
                    L.EL.remove();
                }
            });

            L.initialize();
        }

        // XXX

    };


} );