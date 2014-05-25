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
    <link rel="stylesheet" href="__CSS__/font-awesome.css" />
    <link rel="stylesheet" href="__CSS__/column.css" />
    <link rel="stylesheet" href="__APP_U_CSS__/u.css" />
    <script type="text/javascript" src="__JS__/common.js"></script>
    <script type="text/javascript" src="__JS__/fontWeb.js"></script>
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
                'notifIt.css': '__JS__/notifIt/css/notifIt.css',
                'notifIt': '__JS__/notifIt/js/notifIt.js',
                'easyLayer.css': '__JS__/zxEasyLayer/Css/zxEasyLayer.css',
                'easyLayer': '__JS__/zxEasyLayer/Js/jquery.zxEasyLayer.js',
                'resize': '__JS__/jquery.resize.js',
                'imageUpload': '__JS__/imageUpload.js'
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
            <span class="con_title font_yahei font_b">产品中心</span>
            <span class="con_title2 font_yahei">新添加</span>
        </div>

        <div class="con_body">

            <form action="<?php echo appUrl('m=Index&a=pro&view=add'); ?>" method="post" id="frm" name="frm">
                <input type="hidden" name="submit" value="1" />
                <table cellpadding="0" cellspacing="0" border="0">
                    <tbody>
                    <tr>
                        <th scope="row" width="130px;">产品标题：</th>
                        <td width="">
                            <input name="title" class="txt" id="title" value="<?php echo ($obj["title"]); ?>" style="width:350px;" datatype="*"  nullmsg="请填写产品标题！" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" width="130px;">产品图组：</th>
                        <td>
                            <!-- 图片上传 Start -->
                            <div><span id="imageBtn" class="uploadBtn">上传</span></div>
                            <div class="uploadImgWin">
                                <div class="uploadImgBox clearfix" id="uploadImgBox">
                                    <?php if($obj['pic']){ ?>
                                        <?php $pics = str2Arr( $obj['pic']); ?>

                                        <?php foreach( $pics as $v ){ ?>
                                        <div class="uploadImgGroup">
                                            <div class="uploadImgPic">
                                                <div class="uploadImgPicBox">
                                                    <img src="<?php echo ($v); ?>" />
                                                </div>

                                            </div>
                                            <div class="uploadImgOpe">
                                                <a href="javascript:;" class="uploadPullDown"></a>
                                                <div class="uploadMenu hidden">
                                                    <ul>
                                                        <li><a href="javascript:;" class="uploadDel" data-src="<?php echo ($v); ?>">删除</a></li>
                                                        <li><a href="javascript:;" class="uploadCover" data-src="<?php echo ($v); ?>">设为封面</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <input type="hidden" name="pic[]" value="<?php echo ($v); ?>" />
                                        </div>
                                        <?php } ?>

                                    <?php } ?>
                                </div>
                            </div>
                            <script id="myeditorImg"></script>
                            <script type="text/x-jquery-tmpl" id="uploadImgTmpl">
                                <div class="uploadImgGroup">
                                    <div class="uploadImgPic">
                                        <div class="uploadImgPicBox">
                                            <img src="{{= src}}" />
                                        </div>
                                    </div>
                                    <div class="uploadImgOpe">
                                        <a href="javascript:;" class="uploadPullDown"></a>
                                        <div class="uploadMenu hidden">
                                            <ul>
                                                <li><a href="javascript:;" class="uploadDel" data-src="<?php echo ($v); ?>">删除</a></li>
                                                <li><a href="javascript:;" class="uploadCover" data-src="<?php echo ($v); ?>">设为封面</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <input type="hidden" name="pic[]" value="{{= src}}" />
                                </div>
                            </script>
                            <!-- 图片上传 End -->
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" width="130px;">产品内容：</th>
                        <td class="textarea">
                            <textarea name="description" id="myEditor" datatype="*" nullmsg="请填写产品内容！"><?php echo ($obj["description"]); ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" width="130px;">产品分类：</th>
                        <td>
                            <select name="cate_id" style="width:160px;" datatype="*" nullmsg="请选择分类！">
                                <option value="">--请选择父级分类--</option>
                                <?php if(is_array($levelList)): $i = 0; $__LIST__ = $levelList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><option <?php if($obj['cate_id']==$item['cate_id']){ ?> selected="selected" <?php } ?> value="<?php echo ($item["cate_id"]); ?>"><?php echo UnlimitTagEcho($item['level']); echo ($item["cate_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" width="130px;">发表时间：</th>
                        <td>
                            <input name="addtime" class="txt" id="addtime" value="<?php if($obj && $obj['addtime']){ echo format_time($obj['addtime']); } ?>" style="width:150px;" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" width="130px;">排序：</th>
                        <td width="">
                            <input name="listorder" class="txt" id="listorder" value="<?php echo ($obj["listorder"]); ?>" style="width:150px;" />
                        </td>
                    </tr>
                    <tr class="no_line">
                        <th></th>
                        <td>
                            <?php if($obj){ ?>
                            <input type="hidden" name="pro_id" id="pro_id" value="<?php echo ($obj['pro_id']); ?>" />
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
<script style="text/javascript">
    UE.getEditor("myEditor", {
        toolbars:[['FullScreen','Source', 'Undo', 'Redo','Bold','forecolor','test','link','unlink','fontfamily','fontsize','justifyleft', 'justifycenter', 'justifyright', 'justifyjustify','insertcode','map','gmap','insertimage','insertvideo',,'preview','searchreplace','cleardoc','date','time','horizontal']],
        wordCount:false,
        elementPathEnabled:false,
        initialFrameWidth: 800,
        initialFrameHeight: 300,
        savePath: ['upload']
    });
</script>
<!--UEditor End-->

<script>
    seajs.use('__JS__/imageUpload', function( Image ){

        Image.upload({
            scriptId: 'myeditorImg',
            spanId: 'imageBtn',
            savePath: ['Weizhan'],
            id: "<?php echo $obj['pro_id']; ?>",
            idName: 'pro_id',
            tName: 'Pro',
            fName: 'pic',
            isMulti: true
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