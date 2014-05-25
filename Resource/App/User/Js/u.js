define( function( require, exports, module ){

    var $ = require('jquery');
    var Image = require('imageUpload');
    require('uio')($);
    require('tmpl')($);
    require('resize')($, window);
    require('easyLayer.css');
    require('easyLayer')($);


    // 系统栏目 “重置”
    exports.columnReset = function(  ) {

        $('#col_reset').on('click', function(){
            // 判断是否处于 “事件状态”
            if ( $(this).hasClass('eventing') ) return;
            if ( !cfirm() ) return;
            // 执行 “事件操作”
            $(this).addClass('eventing').addClass('loading');

            var data, url, _this;
            _this = this;
            url = $.uio.getWebUrl() +"/ajax.php?m=Weizhan&a=columnReset";
            $.uio.post( url, data, function( dataJson ) {
                if ( dataJson ){
                    $.zxEasyLayer.alert( dataJson.msg, function(){ location.reload(); } )
                } else {
                    $.zxEasyLayer.alert( dataJson.msg )
                    $(_this).removeClass('eventing').removeClass('loading');
                }
            });
        });
    }

    // 自定义栏目添加
    exports.columnAdd = function() {
        $('#col_add').on('click', function(){
            var _this = this;
            // 判断是否处于 “事件状态”
            if ( $(this).hasClass('eventing') ) return;
            // 执行 “事件操作”
            $(this).addClass('eventing');

            columnCom( _this, {is_home: 0} );
        });
    }



    // 栏目 操作菜单
    exports.opeMenu = function() {

        $('.col_item').on('click', function(e){
            var _this = this;
            // 判断是否处于 “事件状态”
            if ( $(this).hasClass('eventing') ) return;
            // 执行 “事件操作”
            //$(this).addClass('eventing');

            var tar,cTar;

            tar = e.target;
            cTar = e.currentTarget

            if ( $(tar).hasClass('col_ope') ) {
                $('.col_opeMenu', $(cTar)).removeClass('hidden');
            }

            // 修改
            if ( $(tar).hasClass('col_modify') ) {
                var id = $(cTar).attr('dataId');
                if (!id) return;

                var url, data;
                url = $.uio.getWebUrl() +"/ajax.php?m=Weizhan&a=getColumn";
                data = {id: id};
                $.uio.post( url, data, function( dataJson ) {
                    if ( dataJson ){
                        columnCom( _this, dataJson.column );
                    } else {
                        $.zxEasyLayer.alert( dataJson.msg );
                    }
                });
            }

            // 删除
            if ( $(tar).hasClass('col_del') ) {
                if ( !cfirm() ) return;
                var id = $(cTar).attr('dataId');
                if (!id) return;

                var url, data;
                url = $.uio.getWebUrl() +"/ajax.php?m=Weizhan&a=delColumn";
                data = {id: id};
                $.uio.post( url, data, function( dataJson ) {
                    if ( dataJson ){
                        $.zxEasyLayer.alert( dataJson.msg, function(){location.reload();} );
                    } else {
                        $.zxEasyLayer.alert( dataJson.msg );
                    }
                });
            }

        });

        $('.col_item').hover(function(){}, function(){
            $('.col_opeMenu', $(this)).addClass('hidden');
        });

    }

    // 栏目操作 “公共部分”
    function columnCom( _this, column ) {

        // 插入 form DOM
        $.zxEasyLayer.form({
            data: column,
            tmplId: 'easyLayerTmpl',
            title: '栏目添加',
            OKFun: function() {
                var name,url;

                name = $('#column_name').val();
                url = $('#linkurl').val();
                if( !name ) {
                    //alert('栏目名称不能为空');
                    $.zxEasyLayer.alert('栏目名称不能为空！');
                    return;
                }
                if ( !url ) {
                    //alert('栏目地址不能为空！');
                    $.zxEasyLayer.alert('栏目地址不能为空！');
                    return;
                }
                submit();
                comFun();
                return true;
            },
            CancelFun: function(){
                comFun();
            },
            CloseFun: function() {
                comFun();
            }
        });

        function submit() {
            var url, data;

            url = $.uio.getWebUrl() +"/ajax.php?m=Weizhan&a=columnAdd"
            data = $('#frm').serialize();

            $.uio.post( url, data, function( dataJson ) {
                if ( dataJson ){
                    $.zxEasyLayer.alert( dataJson.msg, function(){ location.reload(); } )
                } else {
                    $.zxEasyLayer.alert( dataJson.msg )
                }
            });
        }

        function comFun() {
            $(_this).removeClass('eventing');
        }

        // 选择 ICON
        $('#icon_btn').on('click', function(){
            icon();
        });
        iconDel();
        imageUpload();

        function icon() {
            var icons = {list: ICONS};
            $.zxEasyLayer.form({
                data: icons,
                tmplId: 'iconTmpl',
                title: '选择ICON',
                OKFun: function() {

                    // 确定选择的图标
                    var iconObj = $('.icon_box_item.on');
                    if( iconObj.get(0) ) {
                        $('#css_icon').val( iconObj.attr('id') );
                        $('#css_icon_box').removeClass().addClass('css_icon_box').addClass(iconObj.attr('id'));
                        $('#css_icon_del').removeClass('hidden');

                        return true;
                    } else {
                        $.zxEasyLayer.alert('请选择栏目图标！');
                    }

                }
            });

            // 单个图标 选择事件，并标注为 “选择装填”
            iconSelect();
        }

        function iconSelect() {
            var icons = $('.icon_box_item');

            icons.off('click').on('click', function(){
                icons.removeClass('on');
                $(this).addClass('on');
            });
        }

        // Icon 删除
        function iconDel() {
            $('#css_icon_del').off('click').on('click', function(){
                $('#css_icon').val('');
                $('#css_icon_box').removeClass();
                $(this).addClass('hidden');
            });
        }

        // 上传图片
        function imageUpload() {
            Image.upload({
                scriptId: 'myeditorImg',
                spanId: 'imageBtn',
                savePath: ['Weizhan'],
                idName: 'column_id',
                tName: 'Column',
                fName: 'image'
            });
        }
    }

    // 婚庆大屏幕数据重置
    exports.screenReset = function( uid ) {
        $('#screenReset').on('click', function(){
            screenReset();
        });

        function screenReset() {
            var url, data;

            if ( !cfirm() ) return;
            url = $.uio.getWebUrl() +"/ajax.php?m=Wedding&a=screenReset";
            data = {
                'uid': uid,
                'wed_id':$.uio.getUrlParam('wed_id')
            };

            $.uio.post(url, data, function( dataJson ){
                $.zxEasyLayer.alert(dataJson.msg);
            });
        }

    }

} );