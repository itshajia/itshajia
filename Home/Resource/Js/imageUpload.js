/*
 * 配置：
 * 1. 修改ueditor.config.js 中的路径
 * 2. 添加ueditor.jar 和commons-fileupload-1.2.2.jar 到lib更好
 * 3. 如果为strut2集成，则需要添加过滤器继承原有的过滤器，对imageUp.jsp进行过滤
 * 4. 如果单独使用工具类，则建议使用script的方式，不要使用input
 * 	  如下：
 *  <input id="uploadImg" type="text" value=""/>
 <script id="myeditorImg"></script>
 <span  id="imageBtn">ddd</span>
 单独使用时，不用渲染，获取editor即可。否则在ie会出问题。
 5. 如果只需要渲染，则直接调用render方法即可。
 * UEditor单独图片上传工具类
 */
define( function( require, exports, module ) {

    var $ = require('jquery');
    require('tmpl')($);
    require('json')($);
    require('uio')($);


    exports.upload = function( options ) {
        var settings = {
            inputID: 'uploadImg',
            scriptId: 'myeditorImg',
            spanId: 'imageBtn',
            savePath: ['User']
        };

        if( options ) $.extend( settings, options );

        var image = {
            editor:null,
            key: null,
            init:function(editorid,keyid){
                image.key = $("#"+keyid);

                var _editor =this.getEditor(editorid);
                _editor.ready(function () {
                    _editor.setDisabled();
                    _editor.hide();
                    _editor.addListener('beforeInsertImage', function (t, args) {
                        var src = args[0].src;

                        image.key.val( src );
                        image.insertPic( src );
                    });
                });
            },
            getEditor:function(editorid){
                this.editor = UE.getEditor(editorid, {savePath: settings.savePath});
                return this.editor;
            },
            show:function(id){
                var _editor = this.editor;
                //注意这里只需要获取编辑器，无需渲染，如果强行渲染，在IE下可能会不兼容（切记）
                //和网上一些朋友的代码不同之处就在这里
                $("#"+id).click(function(){
                    var image = _editor.getDialog("insertimage");
                    image.render();
                    image.open();
                });
            },
            render:function(editorid){
                var _editor = this.getEditor(editorid);
                _editor.render();
            },
            insertPic: function( src ) {
                $('#uploadImgBox').empty().append($('#uploadImgTmpl').tmpl( {src: src} ));
                image.onDelete();
            },
            onDelete: function() {
                $('.uploadDel', $('#uploadImgBox')).unbind('click').bind('click', function() {
                    var src = $(this).attr('data-src');
                    image.doDelect( src, $(this) );
                });
            },
            doDelect: function( src, btn ) {
                var url, data;

                url = $.uio.getWebUrl() + '/ajax.php?m=Common&a=fileDel';
                data = {
                    path : encodeURIComponent(src)
                };

                $.uio.post( url, data, function( dataJson ) {

                    if ( dataJson && dataJson.success ) {
                        image.key.val('');
                        btn.parent().parent().remove();
                    }

                }, 'json');
            }
        };

        $(function(){
            image.init( settings.scriptId,settings.inputId);
            image.show( settings.spanId );
            image.onDelete();
        });

    };



    /**
     * 公共接口
     * */
        // 提供 $ 接口
    exports.$ = $;

} );