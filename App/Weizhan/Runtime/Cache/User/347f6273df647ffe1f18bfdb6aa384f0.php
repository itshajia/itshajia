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
            <span class="con_title font_yahei font_b">微站配置</span>
            <span class="con_title2 font_yahei">栏目配置</span>

        </div>

        <div class="con_body font_yahei clearfix">



            <div class="column_win clearfix">

                <form action="<?php echo appUrl('m=Index&a=column'); ?>" method="post" name="frm">
                    <input type="hidden" id="submit" name="submit" value="1" />
                <!-- 操作栏 Start -->
                <div class="col_win_ope">
                    <button class="col_btn">保存</button>
                </div>
                <!-- 操作栏 End -->

                <!-- 系统栏目 Start -->
                <div class="column sys clearfix">
                    <div class="col_header">
                        <span class="col_title">系统栏目</span>
                        <span class="fl_r">
                            <a href="javascript:;" id="col_reset">
                                <?php if( count($sysList) ){ ?>
                                栏目重置
                                <?php }else{ ?>
                                栏目初始化
                                <?php } ?>
                            </a>
                        </span>
                    </div>
                    <div class="col_body">
                        <ul class="col_group">
                            <?php if( count($sysList) ){ ?>
                            <?php if(is_array($sysList)): $i = 0; $__LIST__ = $sysList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><li class="col_item" dataId="<?php echo ($item["column_id"]); ?>">
                                    <i>
                                        <?php if( !$item['is_home'] ) { ?>
                                        <?php echo ($item["sort"]); ?>.
                                        <?php } ?>
                                    </i>
                                <span class="col_checkBox">
                                    <input type="checkbox" name="id[<?php echo ($item["column_id"]); ?>]" <?php if($item['is_show']){ ?> checked="checked" <?php } ?> />
                                </span>
                                    <div class="col_info"><?php echo ($item["column_name"]); ?></div>
                                    <a href="javascript:;" class="col_ope"></a>
                                    <div class="col_opeMenu hidden">
                                        <ul>
                                            <li><a href="javascript:;" class="col_modify">修改</a></li>
                                        </ul>
                                    </div>
                                </li><?php endforeach; endif; else: echo "" ;endif; ?>
                            <?php }else{ ?>
                            <div class="null_msg">没有系统栏目，请执行初始化操作！</div>
                            <?php } ?>

                        </ul>
                    </div>
                </div>
                <!-- 系统栏目 End -->

                <!-- 自定义栏目 Start -->
                <div class="column custom clearfix">
                    <div class="col_header">
                        <span class="col_title">自定义栏目</span>
                        <span class="fl_r">
                            <a href="javascript:;" id="col_add">栏目添加</a>
                        </span>
                    </div>
                    <div class="col_body">
                        <ul class="col_group">
                            <?php if( count($customList) ){ ?>
                            <?php if(is_array($customList)): $i = 0; $__LIST__ = $customList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><li class="col_item" dataId="<?php echo ($item["column_id"]); ?>">
                                    <i>
                                        <?php if( !$item['is_home'] ) { ?>
                                        <?php echo ($item["sort"]); ?>.
                                        <?php } ?>
                                    </i>
                                <span class="col_checkBox">
                                    <input type="checkbox" name="id[<?php echo ($item["column_id"]); ?>]" <?php if($item['is_show']){ ?> checked="checked" <?php } ?> />
                                </span>
                                    <div class="col_info"><?php echo ($item["column_name"]); ?></div>
                                    <a href="javascript:;" class="col_ope"></a>
                                    <div class="col_opeMenu hidden">
                                        <ul>
                                            <li><a href="javascript:;" class="col_modify">修改</a></li>
                                            <li><a href="javascript:;" class="col_del">删除</a></li>
                                        </ul>
                                    </div>
                                </li><?php endforeach; endif; else: echo "" ;endif; ?>
                            <?php }else{ ?>
                            <div class="null_msg">您还没有自定义栏目，可选择添加！</div>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <!-- 自定义栏目 End -->

                </form>

            </div>



        </div>

    </div>
</div>
<!--内容主体 End-->
<script type="text/x-jquery-tmpl" id="easyLayerTmpl">
<form id="frm">
    <table cellpadding="0" cellspacing="0" border="0">
        <tbody>
            <tr>
                <th scope="row" width="100px;">栏目名称：</th>
                <td>
                    <input name="column_name" id="column_name" class="txt" value="{{= column_name}}" style="width:150px;" datatype="*"  nullmsg="请填写栏目标题！" />
                </td>
            </tr>
            <tr>
                <th scope="row" width="100px;">栏目链接：</th>
                <td>
                    <input name="linkurl" id="linkurl" class="txt" value="{{= linkurl}}" style="width: 250px;" />
                </td>
            </tr>
            {{if is_home==0}}
            <tr>
                <th scope="row" width="100px;">栏目图标：</th>
                <td>
                    <span id="css_icon_box" class="{{= css_icon}}"></span>
                    <input type="hidden" name="css_icon" id="css_icon" value="{{= css_icon}}">
                    <button type="button" id="icon_btn" class="btnGraySs">选择</button>
                    <span class="fl_r"><a class="hidden" href="javascript:;" id="css_icon_del">删除</a></span>
                </td>
            </tr>
            <tr >
                <th scope="row" width="100px;">背景图片：</th>
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
                <th scope="row" width="100px;">排序：</th>
                <td>
                    <input name="sort" class="txt" value="{{= sort}}" style="width:50px;" />
                </td>
            </tr>
            {{/if}}
            <input type="hidden" name="column_id" id="column_id" value="{{= column_id}}" />
        </tbody>
    </table>
</form>
</script>

<script type="text/x-jquery-tmpl" id="iconTmpl">
<div id="icon_box" class="icon_box">
    <div class="icon_box_inner clearfix">
        <ul>
            {{each(i, v) list}}
            <li id="${v}" class="icon_box_item">
                <span class="${v}"></span>
            </li>
            {{/each}}
        </ul>
    </div>
</div>
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
    seajs.use('__APP_U_JS__/u', function( U ) {

        // 系统栏目 “重置”
        U.columnReset()
        // 自定义栏目 “添加”
        U.columnAdd();
        // 栏目下拉菜单 “效果”
        U.opeMenu();
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