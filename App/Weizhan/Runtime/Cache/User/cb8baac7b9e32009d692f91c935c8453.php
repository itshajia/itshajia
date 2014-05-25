<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title><?php echo ($title); ?></title>
    <link rel="stylesheet" href="__CSS__/reset.css" />
    <link rel="stylesheet" href="__CSS__/base.css" />
    <link rel="stylesheet" href="__CSS__/1210.css" />
    <link rel="stylesheet" href="__JS__/validform/css/validform.css" />
    <link rel="stylesheet" href="__CSS__/u.css" />
    <link rel="stylesheet" href="__CSS__/iframe.css" />
    <script type="text/javascript" src="__JS__/common.js"></script>
    <script type="text/javascript" src="__JS__/sea.js"></script>
    <script type="text/javascript">
        var zxPath = "";
        var basePath = "";
        seajs.config({
            base:'',
            alias: {
                'jquery': '__JS__/jquery.js',
                'uio': '__JS__/jquery.uio.js',
                'tmpl': '__JS__/jquery.tmpl.js',
                'validform': '__JS__/validform/validform.js',
                'json': '__JS__/jquery.json.js',
                'upload.ui.css': '__JS__/fileUpload/css/jquery.fileupload-ui.css',
                'upload.ui.widget': '__JS__/fileUpload/js/vendor/jquery.ui.widget.js',
                'upload.iframe.transport': '__JS__/fileUpload/js/jquery.iframe-transport.js',
                'upload.fileupload': '__JS__/fileUpload/js/jquery.fileupload.js',
                'upload.xdr.transport': '__JS__/fileUpload/js/cors/jquery.xdr-transport.js'
            }
        });
    </script>
</head>
<body>
<!--后台管理左菜单栏 start-->
<div class="slide_panel font_yahei app">
    <div class="slide_bar scroll">
        <div class="slide_group">
            <?php if(is_array($leftMenu)): $i = 0; $__LIST__ = $leftMenu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><div class="menu_bar <?php if(!$menu['show']){ ?> hidden <?php } ?>" id="<?php echo ($menu["tag"]); ?>">
                    <?php if(is_array($menu["sons"])): $j = 0; $__LIST__ = $menu["sons"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$son): $mod = ($j % 2 );++$j; if($son['three_sons']){ ?>
                        <dl>
                            <dt><?php echo ($son["submenu_name"]); ?></dt>
                            <dd <?php if($j!=1){ ?>style=""<?php } ?>>
                            <ul>
                                <?php if(is_array($son["three_sons"])): $i = 0; $__LIST__ = $son["three_sons"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$three_son): $mod = ($i % 2 );++$i;?><li><a href="<?php echo ($three_son["resource_url"]); ?>" <?php if($three_son['ename']==ACTION_NAME){ ?> class="active" <?php } ?> target="display_frame"><?php echo ($three_son["resource_name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
                            </ul>
                            </dd>
                        </dl>
                        <?php } endforeach; endif; else: echo "" ;endif; ?>
                </div><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
    </div>
</div>
<!--后台管理左菜单栏 end-->
<div class="frame_box app">
    <div class="frame_panel">



<!--内容主体 Start-->
<div class="container">
    <div class="panel">

        <div class="con_header">
            <span class="con_title font_yahei font_b">相册管理</span>
            <span class="con_title2 font_yahei">图片管理</span>

        </div>

        <div class="con_body">

            <form action="<?php echo appUrl('m=Index&a=album&view=pic'); ?>" method="post" id="frm" name="frm">
                <input type="hidden" name="submit" value="1" />
                <table cellpadding="0" cellspacing="0" border="0">
                    <tbody>
                    <tr>
                        <th scope="row" width="130px;">相册名称：</th>
                        <td width=""><?php echo ($obj["title"]); ?></td>
                    </tr>
                    <tr>
                        <th scope="row" width="130px;">相册图组：</th>
                        <td>
                            <!-- 图片上传 Start -->
                            <div><span id="imageBtn" class="uploadBtn">上传</span></div>
                            <div class="uploadImgWin">
                                <div class="uploadImgBox clearfix" id="uploadImgBox">

                                    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><div class="uploadImgGroup">
                                            <div class="uploadImgPic">
                                                <img src="<?php echo ($item["pic_url"]); ?>" />
                                            </div>
                                            <div class="uploadImgInfo">
                                                <div class="mod_input_focus">
                                                    <div class="input_wrap">
                                                        <input class="pic_title" placeholder="请输入图片描述" name="pic_title[]" value="<?php echo ($item["pic_title"]); ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="uploadImgOpe">
                                                <a href="javascript:;" class="uploadPullDown"></a>
                                                <div class="uploadMenu hidden">
                                                    <ul>
                                                        <li><a href="javascript:;" class="uploadDel" data-src="<?php echo ($item["pic_url"]); ?>" data-id="<?php echo ($item["pic_id"]); ?>">删除</a></li>
                                                        <li><a href="javascript:;" class="uploadCover" data-src="<?php echo ($item["pic_url"]); ?>" data-id="<?php echo ($item["pic_id"]); ?>">设为封面</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <input type="hidden" name="pic_url[]" value="<?php echo ($item["pic_url"]); ?>" />
                                            <input type="hidden" name="pic_id[]" value="<?php echo ($item["pic_id"]); ?>" />
                                        </div><?php endforeach; endif; else: echo "" ;endif; ?>

                                </div>
                            </div>
                            <script id="myeditorImg"></script>
                            <script type="text/x-jquery-tmpl" id="uploadImgTmpl">
                                <div class="uploadImgGroup">
                                    <div class="uploadImgPic">
                                        <img src="{{= src}}" />
                                    </div>
                                    <div class="uploadImgInfo">
                                        <div class="mod_input_focus">
                                            <div class="input_wrap">
                                                <input class="pic_title" placeholder="请输入图片描述" name="pic_title[]" value="" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="uploadImgOpe">
                                        <a href="javascript:;" class="uploadPullDown"></a>
                                        <div class="uploadMenu hidden">
                                            <ul>
                                                <li><a href="javascript:;" class="uploadDel" data-src="{{= src}}">删除</a></li>
                                                <li><a href="javascript:;" class="uploadCover" data-src="{{= src}}">设为封面</a></li>
                                            </ul>
                                        </div>
                                    </div>

                                    <input type="hidden" name="pic_url[]" value="{{= src}}" />
                                </div>
                            </script>
                            <!-- 图片上传 End -->
                        </td>
                    </tr>
                    <tr class="no_line">
                        <th></th>
                        <td>
                            <?php if($obj){ ?>
                            <input type="hidden" name="album_id" id="album_id" value="<?php echo ($obj['album_id']); ?>" />
                            <?php } ?>
                            <button type="submit" class="uio_btn">提交</button>
                        </td>
                    </tr>
                    </tbody>
                </table>

            </form>

        </div>

    </div>
</div>
<!--内容主体 End-->

<!--UEditor Start-->
<script type="text/javascript" src="__JS__/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="__JS__/ueditor/ueditor.all.js"></script>
<script type="text/javascript" charset="utf-8" src="__JS__/ueditor/lang/zh-cn/zh-cn.js"></script>
<!--UEditor End-->

<script>
    seajs.use('__JS__/imageUpload', function( Image ){

        Image.upload({
            scriptId: 'myeditorImg',
            spanId: 'imageBtn',
            savePath: ['Weizhan'],
            idName: 'pic_id',
            tName: 'AlbumPic',
            fName: 'pic_url',
            isMulti: true,
            isAlbum: true
        });
    });
</script>

<script>
    seajs.use('__JS__/iframe', function( Iframe ) {

        Iframe.setDate('addtime');

    });
</script>


    </div>
</div>
<script>
    seajs.use('__JS__/u');
</script>
<script>
    seajs.use('__JS__/iframe', function( Iframe ) {

        window.page = Iframe.pageGo;
        window.localGo = Iframe.localGo;

        Iframe.validform();
        Iframe.multiSelect();
        Iframe.resetIframe();


    });
</script>
</body>
</html>