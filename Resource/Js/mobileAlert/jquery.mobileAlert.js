define( function( require, exports, module ){

    return function( $ ){

        $.mobileLayer = {
            idex: 1,
            zIndex: 999999
        };

        var ML = $.ml = $.mobileLayer;


        /**
         *  表单弹出层
         * */
        ML.formAlert = function( options ){

            // 默认配置
            var settings = {
                zIndex: ML.zIndex,
                tmplId: 'mobileAlertTmpl',
                hide: false,
                callback: function(){}
            };

            if( options ) $.extend( settings, options );

            var FA = formAlert = {};

            $.extend(FA, {
                initialize: function() {
                    this.initData();
                    this.initDOM();
                },
                initData: function(){

                    FA.screenW = document.documentElement.clientWidth || document.body.clientWidth;
                    FA.ScrollH = document.documentElement.scrollHeight || document.body.scrollHeight;
                },
                initDOM: function() {
                    var win, height, winIn, winBox, scrollH;

                    win = $('#'+ settings.tmplId ).tmpl();
                    FA.WIN = win;
                    winIn = $('.mobileAlertInner', win);
                    FA.WININ = winIn;
                    winBox = $('.mobileAlertBox', win);
                    FA.WINBOX = winBox;

                    win.attr('id', 'mobileAlert'+ ML.idex).css({
                        /*'min-height': FA.ScrollH,*/
                        'z-index': parseInt( settings.zIndex ) + parseInt( ML.idex ),
                        'left':0/*,
                         'overflow': 'hidden'*/
                    });

                    $('body').append( win );

                    scrollH = document.documentElement.scrollTop || document.body.scrollTop;
                    //winIn.height( winBox.height() ).css({/*overflow: 'hidden', */top: scrollH});
                    winBox.css({'left': FA.screenW, 'border-left': '3px solid #000000'});

                    this.closeEvent();

                    winBox.animate({left: 0}, 500, function(){
                        winBox.css({'border-left': '0px'});
                    });

                    ML.idex++;
                },
                closeEvent: function( ){

                    $('.closeMobileWin', FA.WININ).on('click', function(){
                        FA.close();
                    });
                },
                show: function() {
                    FA.WIN.show();
                    FA.WINBOX.animate({left: 0}, 500, function(){
                        FA.WINBOX.css({'border-left': '0px'});
                    });
                },
                close: function() {
                    FA.WINBOX.css({'border-left': '3px solid #000000'});
                    FA.WINBOX.animate({left: FA.screenW}, 500, function(){
                        FA.WINBOX.css({'border-left': '0px'});

                        if( settings.callback ) settings.callback( );
                        if( FA.endFunc ) FA.endFunc();

                        if ( settings.hide ){
                            FA.WIN.hide();
                        } else {
                            FA.WIN.remove();
                        }



                    });
                }
            });

            FA.initialize();

            return FA;


        };


        /**
         * 信息弹出层
         * */
        ML.msgAlert = function( msg, success ){

            // 默认配置
            var settings = {
                zIndex: ML.zIndex
            };

            var MA = msgAlert = {};
            var errorClass;

            if( success ) {
                errorClass = '';
            } else {
                errorClass = 'error';
            }

            $.extend(MA, {
                initialize: function(){
                    this.initData();
                    this.initDOM();
                },
                initData: function() {
                    MA.screenW = document.documentElement.clientWidth || document.body.clientWidth;
                    MA.ScrollH = document.documentElement.scrollHeight || document.body.scrollHeight;
                },
                initDOM: function() {
                    var win, top, winIn, winBox, scrollH;

                    win = $("<div class='mobileAlertWin'><div class='mobileMsgAlertInner'><div class='mobileAlertBox'><div class='msgbox "+ errorClass +"'>"+ msg +"</div></div></div></div>");
                    MA.WIN = win;
                    winIn = $('.mobileMsgAlertInner', win);
                    MA.WININ = winIn;
                    winBox = $('.mobileAlertBox', win);
                    MA.WINBOX = winBox;


                    win.attr('id', 'mobileAlert'+ ML.idex).css({
                        'min-height': MA.ScrollH,
                        'z-index': parseInt( settings.zIndex ) + parseInt( ML.idex ),
                        'left':0,
                        'top': 0,
                        'overflow': 'hidden'
                    });

                    $('body').append( win );

                    winBox.height(50);
                    scrollH = document.documentElement.scrollTop || document.body.scrollTop;
                    winIn.height( winBox.height() ).css({
                        top: scrollH
                    });
                    top = winBox.height();

                    winBox.css({'top': "-"+top+"px", 'border': '3px solid #dadada', 'border-top': 0,  'line-height': top+"px"});

                    winBox.animate({top: 0}, 500, function(){
                        setTimeout(function(){
                            MA.closeMsg( winBox );
                        }, 1000);
                    });


                    ML.idex++;
                },
                closeMsg: function( winBox ){
                    var top;

                    top = winBox.height();
                    winBox.animate({top: "-"+top+"px"}, 250, function(){
                        MA.WIN.remove();
                    });

                }
            });

            MA.initialize();

        };



        /**
         *  确认框弹出层
         * */
        ML.comfirmAlert = function( options ) {
            // 默认配置
            var settings = {
                title: '',
                zIndex: ML.zIndex,
                tmplId: 'mobileConfirmAlertTmpl',
                callback: function(){}
            };

            if( options ) $.extend( settings, options );

            var CA = comfirmAlert = {};

            $.extend(CA, {
                initialize: function() {
                    this.initData();
                    this.initDOM();
                },
                initData: function() {
                    CA.screenW = document.documentElement.clientWidth || document.body.clientWidth;
                    CA.ScrollH = document.documentElement.scrollHeight || document.body.scrollHeight;
                },
                initDOM: function() {
                    var win, top, winIn, winBox, scrollH, Ok, Cancel;

                    win = $('#'+ settings.tmplId ).tmpl({title: settings.title});
                    CA.WIN = win;
                    winIn = $('.mobileAlertInner', win);
                    CA.WININ = winIn;
                    winBox = $('.mobileAlertBox', win);
                    CA.WINBOX = winBox;
                    Ok = $('.confirmOk', win);
                    CA.OK = Ok;
                    Cancel = $('.confirmCancel', win);
                    CA.CANCEL = Cancel;



                    win.attr('id', 'mobileAlert'+ ML.idex).css({
                        'min-height': CA.ScrollH,
                        'z-index': parseInt( settings.zIndex ) + parseInt( ML.idex ),
                        'left':0,
                        'overflow': 'hidden'
                    });

                    $('body').append( win );

                    scrollH = document.documentElement.scrollTop || document.body.scrollTop;
                    winIn.height( winBox.height() ).css({overflow: 'hidden', top: scrollH});
                    winBox.css({'left': CA.screenW, 'border-left': '3px solid #000000'});

                    this.actionEvent();
                    this.closeEvent();

                    winBox.animate({left: 0}, 500, function(){
                        winBox.css({'border-left': '0px'});
                    });

                    ML.idex++;

                },
                actionEvent: function() {
                    CA.OK.on('click', function() {
                        if( settings.callback ) settings.callback( true );
                        CA.close();
                    });

                    CA.CANCEL.on('click', function(){
                        if( settings.callback ) settings.callback( false );
                        CA.close();
                    });


                },
                closeEvent: function( ){

                    $('.closeMobileWin', CA.WININ).on('click', function(){
                        CA.close();
                    });
                },
                close: function() {
                    CA.WINBOX.css({'border-left': '3px solid #000000'});
                    CA.WINBOX.animate({left: CA.screenW}, 500, function(){
                        CA.WINBOX.css({'border-left': '0px'});
                        CA.WIN.remove();

                        if( settings.callback ) settings.callback();
                    });
                }

            });

            CA.initialize();

        }

    };
} );
