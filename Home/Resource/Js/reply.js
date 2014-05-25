define( function( require, exports, module ){
    var $ = require('jquery');
    var Image = require('imageUpload');
    require('uio')($);
    require('tmpl')($);
    require('easyLayer.css');
    require('easyLayer')($);


    exports.edit = function() {
        // 编辑遮罩层的显隐
        $('.r_body').hover(function(){
            $('.r_edit_cover', $(this)).removeClass('hidden');

        }, function(){
            $('.r_edit_cover', $(this)).addClass('hidden');
        });

        // 编辑事件绑定
        $('.r_edit_cover').on('click', function(){
            var dataId = $(this).attr('dataId');
            var is_first = $(this).attr('isFirst');

            if ( dataId ) {
                replyEdit( dataId );
            } else {
                replyAdd({is_first: is_first});
            }
        });

        // 增加一条 “回复”
        $('#replyAdd').on('click', function(){
            var is_first = $(this).attr('isFirst');
            replyAdd({is_first: is_first});
        });

        // 回复添加
        function replyAdd( data ) {
            replyCom( data );
        }

        // 回复编辑
        function replyEdit( id ) {
            var url, data;
            url = $.uio.getWebUrl() +"/ajax.php?m=Reply&a=getReply";
            data = {id: id};
            $.uio.post( url, data, function( dataJson ) {
                if ( dataJson ){
                    replyCom( dataJson.fdata );
                } else {
                    $.zxEasyLayer.alert( dataJson.msg );
                }
            });
        }

        function replyCom(fdata) {
            // 插入 form DOM
            $.zxEasyLayer.form({
                data: fdata,
                tmplId: 'easyLayerTmpl',
                title: '图文回复添加',
                OKFun: function() {
                    var title, desc, url;

                    title = $('#title').val();
                    desc = $('#desc').val();
                    url = $('#url').val();

                    if( !title ) {
                        $.zxEasyLayer.alert('标题不能为空！');
                        return;
                    }
                    if( !desc ) {
                        $.zxEasyLayer.alert('描述不能为空！');
                        return;
                    }
                    if( !url ) {
                        $.zxEasyLayer.alert('链接不能为空！');
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

            function submit() {
                var url, data;

                url = $.uio.getWebUrl() +"/ajax.php?m=Reply&a=imgReplyAdd"
                data = $('#frm').serialize();

                $.uio.post( url, data, function( dataJson ) {
                    if ( dataJson ){
                        $.zxEasyLayer.alert( dataJson.msg, function(){ location.reload(); } )
                    } else {
                        $.zxEasyLayer.alert( dataJson.msg )
                    }
                });
            }

            imageUpload(fdata['img_id']);

        }



        // 上传图片
        function imageUpload( id ) {
            Image.upload({
                scriptId: 'myeditorImg',
                spanId: 'imageBtn',
                idName: 'img_id',
                tName: 'ReplyImg',
                fName: 'image',
                id: id
            });
        }
    }


    /**
     * 公共接口
     * */
        // 提供 $ 接口
    exports.$ = $;
} );