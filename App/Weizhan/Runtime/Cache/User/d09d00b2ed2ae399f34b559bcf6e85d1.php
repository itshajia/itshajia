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
            <span class="con_title font_yahei font_b">产品分类</span>
            <span class="con_title2 font_yahei">列表</span>
        </div>

        <div class="con_body">

            <form action="<?php echo appUrl('m=Index&a=proCate'); ?>" method="post" id="frm" name="frm">
                <input type="hidden" name="submit" value="1" />
                <table cellpadding="0" cellspacing="0" border="0">
                    <thead>
                    <tr>
                        <td width="10%">选择</td>
                        <td width="10%">序号</td>
                        <td width="30%">分类名称</td>
                        <td width="10%">父分类</td>
                        <td width="10%">文章数</td>
                        <td width="25%">操作</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><tr>
                            <td><?php echo UnlimitTagEcho($item['level']); ?><input type="checkbox" class="checkbox" name="id[<?php echo ($item["cate_id"]); ?>]" /></td>
                            <td><input type="text" class="txt" size="12" name="cate[<?php echo ($item["cate_id"]); ?>][listorder]" value="<?php echo ($item["listorder"]); ?>" /></td>
                            <td><?php echo UnlimitTagEcho($item['level']); echo ($item["cate_name"]); ?></td>
                            <td><strong class="green"><?php echo ($item["cate_pname"]); ?></strong></td>
                            <td></td>
                            <td>
                                <a class="" href="<?php echo appUrl('m=Index&a=proCate&view=add'); ?>&cate_id=<?php echo ($item["cate_id"]); ?>">编辑</a>
                                <a class="" onclick="return cfirm();" href="<?php echo appUrl('m=Index&a=proCate&view=del'); ?>&cate_id=<?php echo ($item["cate_id"]); ?>">删除</a>
                            </td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                    <tbody>
                    <tr class="no_line">
                        <td colspan="6">
                            <div class="clearfix">
                                <button type="button" class="uio_btn" href="<?php echo appUrl('m=Index&a=proCate&view=add'); ?>" onclick="localGo(this);">添加</button>
                                <button type="submit" class="uio_btn">提交更改</button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <!--表单工具栏 Start-->
                <div class="form_tool" id="form_tool">
                    <span class="tool_group">
                        <a href="javascript:;" class="sel_all">全选</a>/<a href="javascript:;" class="sel_cancel">取消</a>
                    </span>
                    <span class="tool_group">
                        选中项：<button name="tool" onclick="return cfirm();" value="delAll">删除</button>
                    </span>

                </div>
                <!--表单工具栏 End-->

            </form>

        </div>

    </div>
</div>
<!--内容主体 End-->


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