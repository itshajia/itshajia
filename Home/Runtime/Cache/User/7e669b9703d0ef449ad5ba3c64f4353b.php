<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title><?php echo ($title); ?></title>
    <link rel="stylesheet" href="__CSS__/reset.css" />
    <link rel="stylesheet" href="__CSS__/base.css" />
    <link rel="stylesheet" href="__CSS__/1210.css" />
    <link rel="stylesheet" href="__JS__/validform/css/validform.css" />
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
                'easyLayer.css': '__JS__/zxEasyLayer/Css/zxEasyLayer.css',
                'easyLayer': '__JS__/zxEasyLayer/Js/jquery.zxEasyLayer.js',
                'imageUpload': '__JS__/imageUpload.js'
            }
        });
    </script>
</head>
<body>

<div class="frame_box">
    <div class="frame_panel">



<!--内容主体 Start-->
<div class="container">
    <div class="panel">

        <div class="con_header">
            <span class="con_title font_yahei font_b">图文素材管理</span>
            <span class="con_title2 font_yahei">新添加</span>
        </div>

        <div class="con_body">

            <table cellpadding="0" cellspacing="0" border="0">
                <tbody>
                <tr class="no_line">
                    <th scope="row" width="130px;">关键词：</th>
                    <td><?php echo ($obj["keyword"]); ?></td>
                </tr>
                </tbody>
            </table>

            <!-- 图文添加 Start -->
            <div class="imgReply font_yahei">
                <div class="imgReplyInner">
                    <?php if( $replyImgFirst ){ ?>
                    <div class="r_first">
                        <div class="r_head"><?php echo format_date($replyImgFirst['addtime']); ?></div>
                        <div class="r_body">
                            <div class="r_img">
                                <img src="<?php echo ($replyImgFirst["image"]); ?>" />
                            </div>
                            <div class="r_title"><span class="pl_5"><?php echo ($replyImgFirst["title"]); ?></span></div>
                            <a href="javascript:;" class="r_edit_cover hidden" dataId="<?php echo ($replyImgFirst["img_id"]); ?>" isFirst="1"></a>
                        </div>
                    </div>
                    <?php }else{ ?>
                    <div class="r_first">
                        <div class="r_head">日期</div>
                        <div class="r_body">
                            <div class="r_img">

                            </div>
                            <div class="r_title"><span class="pl_5">标题</span></div>
                            <a href="javascript:;" class="r_edit_cover hidden" dataId="" isFirst="1"></a>
                        </div>
                    </div>
                    <?php } ?>
                    <?php foreach( $replyImgList as $k=>$v ){ ?>
                    <div class="r_item clearfix r_body">
                        <div class="r_item_title font_b"><?php echo ($v["title"]); ?></div>
                        <div class="r_item_img">
                            <img src="<?php echo ($v["image"]); ?>" />
                        </div>
                        <a href="javascript:;" class="r_edit_cover hidden" dataId="<?php echo ($v["img_id"]); ?>" isFirst="0"></a>
                    </div>
                    <?php } ?>
                    <div class="r_item clearfix">
                        <a href="javascript:;" id="replyAdd" class="replyAdd">增加一条</a>
                    </div>
                </div>
            </div>
            <!-- 图文添加 End -->

        </div>

    </div>
</div>
<!--内容主体 End-->

<script type="text/x-jquery-tmpl" id="easyLayerTmpl">
<form id="frm">
    <input type="hidden" name="reply_id" id="reply_id" value="<?php echo ($obj["reply_id"]); ?>" />
    <table cellpadding="0" cellspacing="0" border="0">
        <tbody>
            <tr>
                <th scope="row" width="100px;">标题：</th>
                <td>
                    <input name="title" id="title" class="txt" value="{{= title}}" style="width:300px;" />
                </td>
            </tr>
            <tr>
                <th scope="row" width="100px;">封面：</th>
                <td class="top" style="height:150px;">
                    <!-- 图片上传 Start -->
                    <div><span id="imageBtn" class="uploadBtn">上传</span></div>
                    <div class="uploadImgWin">
                        <div class="uploadImgBox clearfix" id="uploadImgBox">
                            {{if (image)}}
                            <div class="uploadImgGroup">
                                <div class="uploadImgPic">
                                    <img src="{{= image}}" />
                                </div>
                                <div class="uploadImgOpe">
                                    <a href="javascript:;" class="uploadPullDown"></a>
                                    <div class="uploadMenu hidden">
                                        <ul>
                                            <li><a href="javascript:;" class="uploadDel" data-src="{{= image}}">删除</a></li>
                                        </ul>
                                    </div>
                                </div>

                                <input type="hidden" name="image" value="{{= image}}" />
                            </div>
                            {{/if}}
                        </div>
                    </div>
                    <!-- 图片上传 End -->
                </td>
            </tr>
            <tr>
                <th scope="row" width="100px;">描述：</th>
                <td>
                    <input name="desc" id="desc" class="txt" value="{{= desc}}" style="width:300px;" />
                </td>
            </tr>
            <tr>
                <th scope="row" width="100px;">链接地址：</th>
                <td>
                    <input name="url" id="url" class="txt" value="{{= url}}" style="width:150px;" />
                </td>
            </tr>
            {{if is_first==0}}
            <tr>
                <th scope="row" width="100px;">排序：</th>
                <td>
                    <input name="sort" class="txt" value="{{= sort}}" style="width:50px;" />
                </td>
            </tr>
            {{/if}}
            <input type="hidden" name="is_first" id="is_first" value="{{= is_first}}" />
            <input type="hidden" name="img_id" id="img_id" value="{{= img_id}}" />
        </tbody>
    </table>
</form>
</script>

<script id="myeditorImg"></script>
<script type="text/x-jquery-tmpl" id="uploadImgTmpl">
    <div class="uploadImgGroup">
        <div class="uploadImgPic">
            <img src="{{= src}}" />
        </div>
        <div class="uploadImgOpe">
            <a href="javascript:;" class="uploadPullDown"></a>
            <div class="uploadMenu hidden">
                <ul>
                    <li><a href="javascript:;" class="uploadDel" data-src="{{= src}}">删除</a></li>
                </ul>
            </div>
        </div>

        <input type="hidden" name="image" value="{{= src}}" />
    </div>
</script>

<!--UEditor Start-->
<script type="text/javascript" src="__JS__/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="__JS__/ueditor/ueditor.all.js"></script>
<script type="text/javascript" charset="utf-8" src="__JS__/ueditor/lang/zh-cn/zh-cn.js"></script>
<!--UEditor End-->

<script>
    seajs.use('<?php echo (APP_NAME); ?>/Resource/Js/reply', function( Reply ){

        Reply.edit();
    });
</script>

    </div>
</div>
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