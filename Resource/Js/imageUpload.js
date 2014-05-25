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
    require('easyLayer.css');
    require('easyLayer')($);


    exports.upload = function( options ) {
        var settings = {
            scriptId: 'myeditorImg',
            spanId: 'imageBtn',
            isMulti: 0,
            isAlbum: 0,
            id: 0,
            idName: '',
            tName: '',
            fName: '',
            savePath: ['User']
        };

        if( options ) $.extend( settings, options );

        var image = {
            editor:null,
            key: null,
            init:function(editorid){
                //image.key = $("#"+keyid);

                var _editor =this.getEditor(editorid);
                _editor.ready(function () {
                    _editor.setDisabled();
                    _editor.hide();
                    _editor.addListener('beforeInsertImage', function (t, args) {
                        var src="", strs, str;

                        // 多图上传
                        if ( settings.isMulti ) {

                            for ( var i=0;i<args.length;i++ ) {
                                src += ','+args[i]['src'];
                            }
                        } else {
                            src = args[0].src;
                        }

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
                // 多图上传
                if ( settings.isMulti ){
                    var srcs = src.split(',');
                    srcs = $.uio.array_filter( srcs);
                    var arr = [];
                    for( var i=0;i<srcs.length;i++ ) {
                        arr.push({src: srcs[i]});
                    }
                    $('#uploadImgBox').append($('#uploadImgTmpl').tmpl( arr ));
                } else {
                    $('#uploadImgBox').empty().append($('#uploadImgTmpl').tmpl( {src: src} ));
                }

                image.onMenu();
            },
            onMenu: function() {

                $('.uploadImgGroup').hover(function(){}, function(){
                    $('.uploadMenu', $(this)).addClass('hidden');
                });

                $('.uploadImgGroup', $('#uploadImgBox')).unbind('click').bind('click', function(e){
                    var tar,cTar, src;

                    tar = e.target;
                    cTar = e.currentTarget;
                    src = $(tar).attr('data-src');

                    // 删除
                    if ( $(tar).hasClass('uploadDel')) {
                        image.doDelect( src, $(tar), $(cTar) );
                    }

                    // 下拉
                    if ( $(tar).hasClass('uploadPullDown')){
                        $(tar).next('.uploadMenu').removeClass('hidden');
                    }

                    // 设为封面
                    if ( settings.isAlbum && $(tar).hasClass('uploadCover') ) {
                        image.doCover( $(tar) );
                    }

                    // 添加链接
                    if ( $(tar).hasClass('uploadLinkurl') ) {
                        image.doLink( $(tar) );
                    }
                });
            },
            doLink: function( btn ) {
                var data = {linkurl: btn.attr('data-src')};

                // 插入 form DOM
                $.zxEasyLayer.form({
                    width: 600,
                    data: data,
                    tmplId: 'linkUrlTmpl',
                    title: '添加链接',
                    OKFun: function() {
                        var linkurl;

                        linkurl = $('#linkurl').val();

                        if( !linkurl ) {
                            $.zxEasyLayer.alert('链接不能为空！');
                            return;
                        }

                        submit( linkurl );
                        return true;
                    },
                    CancelFun: function(){},
                    CloseFun: function() {}
                });

                function submit( linkurl ) {
                    var url, data;

                    url = $.uio.getWebUrl() +"/ajax.php?m=Ad&a=linkurl"
                    data = {
                        id: btn.attr('data-id'),
                        linkurl: linkurl
                    };

                    $.uio.post( url, data, function( dataJson ) {
                        if ( dataJson ){
                            $.zxEasyLayer.alert( dataJson.msg, function(){ btn.attr('data-src', linkurl) } )
                        } else {
                            $.zxEasyLayer.alert( dataJson.msg )
                        }
                    });

                }
            },
            doCover: function( btn ) {
                var url, data, id;

                url = $.uio.getWebUrl() +'/ajax.php?m=Album&a=setCover';
                data = {
                    id: btn.attr('data-id')
                };

                $.uio.post( url, data, function( dataJson ) {
                    if ( dataJson && dataJson.msg ) $.zxEasyLayer.alert( dataJson.msg, function(){location.reload();} );
                });

            },
            doDelect: function( src, btn, box ) {
                var url, data, id;

                if ( !cfirm() ) return;
                url = $.uio.getWebUrl() + '/ajax.php?m=Common&a=fileDel';

                if ( settings.isAlbum ) {
                    id = btn.attr('data-id');
                } else {
                    id = settings.id;
                }

                data = {
                    path : encodeURIComponent(src),
                    isAlbum: settings.isAlbum,
                    id: id,
                    idName: settings.idName,
                    tName: settings.tName,
                    fName: settings.fName
                };

                $.uio.post( url, data, function( dataJson ) {

                    if ( dataJson && dataJson.success ) {
                        box.remove();
                    }

                }, 'json');
            }
        };

        $(function(){
            image.init( settings.scriptId );
            image.show( settings.spanId );
            image.onMenu();
        });

    };



    /**
     * 公共接口
     * */
        // 提供 $ 接口
    exports.$ = $;

} );