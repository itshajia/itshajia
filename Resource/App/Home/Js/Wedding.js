define( function( require, exports, module ){
    var $ = require('jquery');
    require('tmpl')($);
    require('uio')($);
    require('audioplayer')($);
    require('alert.css');
    require('alert')($);
    require('touchSlider2')($);

    // 音乐
    exports.music = function() {
        //console.log('121212');
        //$('#audio').get( 0 ).play();
        //$( 'audio' ).audioPlayer();
    }

    // 邀请函
    exports.invitation = function() {
        $('#invitation').on('click', function(){
            $.ml.formAlert({
                tmplId: 'invitationTmpl',
                callback: function( ) {
                }
            });
        });

    }

    // 送祝福
    exports.bless = function() {
        $('#bless').on('click', function(){
            $.ml.formAlert({
                tmplId: 'blessTmpl',
                callback: function( ) {
                }
            });

            submit();
        });

        // 表单提交
        function submit() {
            $('#send_message').on('click', function(){
                var frm, url, data, _this;

                if ( $(this).hasClass('loading')) return;
                _this = this;
                frm = $('#bless_frm');
                url = $.uio.getWebUrl() +"/ajax.php?m=Wedding&a=bless";
                data = frm.serialize();

                $.uio.post(url, data, function( dataJson ){
                    $.ml.msgAlert( dataJson.msg, dataJson.success );
                    $(_this).removeClass('loading');
                    if ( dataJson && dataJson.success ) {
                        frm.reset();
                    }
                });

            });
        }
    }

    // 婚纱照
    exports.photo = function() {
        photoEvent();
        $('#photo').on('click', function(){
            $('#touchbox').show();
            //$('body').height( $('#touchcover').height()).css({overflow: 'hidden'});
            $('#goods').hide();
        });

        function photoEvent() {

            $('#touchbox').bind('click', function() {
                $('#touchbox').hide();
                $('#goods').show();
                $('body').css({overflow: 'visible'});
            });

            $(".touchslider").touchSlider({
                mouseTouch: true
            });

            $('.touchslider-item').width( $(document).width() );
        }

    }

    // 新人故事
    exports.story = function() {
        $('#story').on('click', function(){
            $.ml.formAlert({
                tmplId: 'storyTmpl',
                callback: function( ) {
                }
            });
            require("http://static.bshare.cn/b/buttonLite.js#style=-1&amp;uuid=2770c835-1a2e-4716-b4b7-42132f0a7f9e&amp;pophcol=2&amp;lang=zh");
            require("http://static.bshare.cn/b/bshareC0.js");
        });
    }

    // 分享喜悦
    exports.shareJoy = function() {
        $('#shareJoy').on('click', function(){
            $.ml.formAlert({
                tmplId: 'shareJoyTmpl',
                callback: function( ) {
                }
            });
        });
    }

    // 获取“祝福信息”
    exports.getBless = function() {
        var url, data, dom;

        url = $.uio.getWebUrl() +"/ajax.php?m=Wedding&a=getBless";
        data = {
            'uid': $.uio.getUrlParam('uid'),
            'wed_id':$.uio.getUrlParam('wed_id')
        };

        setInterval( function() {
            $.uio.post(url, data, function( dataJson ){
                if ( dataJson && dataJson.success && dataJson.obj ) {
                    dom = $('#blessTmpl').tmpl(dataJson.obj);

                    if ( $('#blessGroup .blessItem').length ) {
                        $('#blessGroup').prepend( dom );
                    } else {
                        $('#blessGroup').append( dom );
                    }

                    dom.animate({opacity: 1}, {duration: 500});
                }
            });
        }, 3000);


    }

    // 加载
    exports.loading = function(){
        window.onload = function(){
            $('#loading').addClass('hidden');
            $('#wedding').removeClass('hidden')
        };
    }

} );