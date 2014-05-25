define( function(require, exports, module) {
    var $ = require('jquery');

    require('validform')($);


    // location 跳转
    exports.localGo = function( btn ) {
        var href = $(btn).attr('href');

        if( !href ) return ;
        location.href = href;
    }


    // 跳转页面
    exports.pageGo = function() {
        var page = $('#page_val').val();

        page = parseInt(page) ? page : 1;

        location.href = $('#urlnopage').val() +'&page='+ page;
    }


    // 获取时间日期
    exports.setDate = function( id ) {

        if ( !$('#'+ id).val() ) {
            $('#'+ id).val( getDate() );
        }

    }


    // 表单验证
    exports.validform = function() {

        $('#frm').Validform({
            tiptype:4
        });
    }

    // 应用进入，调整 iframe 的 “大小”以及 “位置”
    exports.resetIframe = function() {
        $('.frame_box').each(function(){
            if ( $(this).hasClass('app') ) {
                $('.frame_box', $(parent.document)).css({left: '50px',top: '0px'}).queue(function(next){
                    $(this).show();
                    next();
                });
                $('#appClose', $(parent.document)).removeClass('hidden');
            } else {
                $('.frame_box', $(parent.document)).css({left: '255px',top: '35px'}).queue(function(next){
                    $(this).show();
                    next();
                });
                $('#appClose', $(parent.document)).addClass('hidden');
            }
        });
    }


    /**
     * 表单工具栏 方法
     * */
    // 表单多项选择
    exports.multiSelect = function() {

        $('#form_tool .sel_all').on('click', function(){
            $('tbody .checkbox').prop("checked", true);
        })

        $('#form_tool .sel_cancel').on('click', function(){
            $('tbody .checkbox').prop('checked', false);
        });
    }


    /**
     * 公共接口
     * */
    // 提供 $ 接口
    exports.$ = $;


});