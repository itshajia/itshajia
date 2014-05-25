define( function( require, exports, module ){
    var $ = require('jquery');
    require('uio')($);
    require('tmpl')($);
    require('easyLayer.css');
    require('easyLayer')($);


    exports.edit = function() {
        $('#menu_add').on('click', function(){
            menuAdd();
        });

        $('.menu_edit').on('click', function(){
            var dataId = $(this).attr('dataId');
            menuEdit( dataId );
        });

        $('.menu_del').on('click', function(){
            if ( !cfirm() ) return;
            var dataId = $(this).attr('dataId');
            menuDel( dataId );
        });

        function menuAdd() {
            menuCom({menu_id:0,menu_type:''});
        }

        function menuEdit( id ) {
            var url, data;
            url = $.uio.getWebUrl() +"/ajax.php?m=CustomMenu&a=getMenu";
            data = {id: id};
            $.uio.post( url, data, function( dataJson ) {
                if ( dataJson ){
                    menuCom( dataJson.fdata );
                } else {
                    $.zxEasyLayer.alert( dataJson.msg );
                }
            });
        }

        function menuDel( id ) {
            var url, data;
            url = $.uio.getWebUrl() +"/ajax.php?m=CustomMenu&a=menuDel";
            data = {id: id};
            $.uio.post( url, data, function( dataJson ) {
                if ( dataJson ){
                    $.zxEasyLayer.alert( dataJson.msg, function(){location.reload();} );
                } else {
                    $.zxEasyLayer.alert( dataJson.msg );
                }
            });
        }

        function menuCom(fdata) {
            // 插入 form DOM
            $.zxEasyLayer.form({
                width: 600,
                data: fdata,
                tmplId: 'easyLayerTmpl',
                title: '自定义菜单管理',
                OKFun: function() {
                    var title,menu_key;

                    title = $('#title').val();
                    menu_key = $('#menu_key').val();

                    if( !title ) {
                        $.zxEasyLayer.alert('菜单名称不能为空！');
                        return;
                    }

                    if( !menu_key ) {
                        $.zxEasyLayer.alert( $('#menu_key').attr('nullmsg') );
                        return;
                    }

                    submit();
                    return true;
                },
                CancelFun: function(){

                },
                CloseFun: function() {

                }
            });

            // “绑定” 和 “超链接”切换
            $('.menu_type').on('change', function(){
                var val = $(this).val();
                var link_title = $('#link_title');
                var bind_title = $('#bind_title');
                var menu_key_win = $('#menu_key_win');
                var menu_key = $('#menu_key');

                switch ( val ) {
                    case "click":
                        link_title.addClass('hidden');
                        bind_title.removeClass('hidden');
                        menu_key_win.removeClass('hidden');
                        menu_key.val('').attr('type', 'hidden').attr('nullmsg', '请选择绑定规则！');
                        break;

                    case "view":
                        bind_title.addClass('hidden');
                        menu_key_win.addClass('hidden');
                        link_title.removeClass('hidden');
                        menu_key.val('').attr('type', 'text').attr('nullmsg', '请填写链接地址！');
                        break;
                }
            });

            // 选择“绑定规则”
            $('#menu_key_btn').on('click', function(){

                menuKey(fdata);
            });

            // 提交 自定义菜单
            function submit() {
                var url, data;

                url = $.uio.getWebUrl() +"/ajax.php?m=CustomMenu&a=menuAdd"
                data = $('#frm').serialize();

                $.uio.post( url, data, function( dataJson ) {
                    if ( dataJson ){
                        $.zxEasyLayer.alert( dataJson.msg, function(){ location.reload(); } )
                    } else {
                        $.zxEasyLayer.alert( dataJson.msg )
                    }
                });
            }
        }

        function menuKey(fdata) {
            $.zxEasyLayer.form({
                data: fdata,
                tmplId: 'menuKeyTmpl',
                title: '选择绑定规则',
                OKFun: function() {

                    // 确定选择的规则
                    var keyObj = $('.menu_key.on');
                    if( keyObj.get(0) ) {
                        $('#menu_key').val( keyObj.attr('dataKey') );
                        $('#menu_key_show').text( keyObj.attr('dataKey') );

                        return true;
                    } else {
                        $.zxEasyLayer.alert('请选择绑定规则！');
                    }

                }
            });

            // 单个规则 选择事件，并标注为 “选择装填”
            menuKeySelect();
        }

        function menuKeySelect(){
            var menu_key = $('.menu_key');

            menu_key.off('click').on('click', function(){
                menu_key.removeClass('on');
                $(this).addClass('on');
            });
        }
    }

    /**
     * 公共接口
     * */
        // 提供 $ 接口
    exports.$ = $;
} );