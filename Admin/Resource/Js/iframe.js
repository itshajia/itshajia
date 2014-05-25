define( function(require, exports, module) {
    var $ = require('jquery');

    require('validform')($);

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