<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title><?php echo ($title); ?></title>
    <link rel="stylesheet" href="__CSS__/reset.css" />
    <link rel="stylesheet" href="__CSS__/base.css" />
    <link rel="stylesheet" href="__AP__/<?php echo (APP_NAME); ?>/Resource/Css/admin.css" />
    <script type="text/javascript" src="__JS__/sea.js"></script>
    <script type="text/javascript">
        var zxPath = "";
        seajs.config({
            base:zxPath,
            alias: {
                'jquery': '__JS__/jquery'
            }
        });
    </script>
</head>
<body onscroll="no">
<div class="admin">
    <!--后台管理页头 start-->
<div class="header">
    <div class="logo"></div>
    <div class="nav_panel">
        <div class="nav_cover"></div>
        <div class="nav" id="nav">
            <ul>
                <?php if(is_array($menuList)): $i = 0; $__LIST__ = $menuList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><li>
                        <a href="javascript:;" rel="<?php echo ($menu["menu_ename"]); ?>" <?php if( $i==1 ){ ?>class="active"<?php } ?> ><?php echo ($menu["menu_name"]); ?></a>
                    </li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>

        <!-- 登录用户信息 -->
        <div class="user_box">
            <div class="avatar">
                <img class="pic_small" uid="" src="__AP__/<?php echo (APP_NAME); ?>/Resource/Images/user/avatar.png" />
            </div>
            <div class="welcome">
                你好，<?php echo ($adminUser["group_name"]); ?>，<b><?php echo ($adminUser["username"]); ?></b>
            </div>
            <div class="link_group">
                <a href="javascript:;" onclick="window.history.back()">返回上页</a>
                <a href="javascript:;" id="fresh">刷新</a>
                <a href="/" target="_blank">网站首页</a>
                <a href="<?php echo appUrl('Index/logout'); ?>">安全退出</a>
            </div>
        </div>

    </div>
</div>

<!--后台管理页头 end-->
    <!--后台管理左菜单栏 start-->
<div class="slide_bar">
    <div class="slide_group">
        <?php if(is_array($leftMenu)): $i = 0; $__LIST__ = $leftMenu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><div class="menu_bar <?php if(!$menu['show']){ ?> hidden <?php } ?>" id="<?php echo ($menu["tag"]); ?>">
                <?php if(is_array($menu["sons"])): $j = 0; $__LIST__ = $menu["sons"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$son): $mod = ($j % 2 );++$j; if($son['three_sons']){ ?>
                    <dl>
                        <dt><i class="<?php if($j==1){ ?> arrow_b <?php }else{ ?> arrow_r <?php } ?>"></i><?php echo ($son["submenu_name"]); ?></dt>
                        <dd <?php if($j!=1){ ?>style="display:none;"<?php } ?>>
                        <ul>
                            <?php if(is_array($son["three_sons"])): $i = 0; $__LIST__ = $son["three_sons"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$three_son): $mod = ($i % 2 );++$i;?><li><a href="<?php echo ($three_son["resource_url"]); ?>" target="display_frame"><?php echo ($three_son["resource_name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                        </dd>
                    </dl>
                    <?php } endforeach; endif; else: echo "" ;endif; ?>
            </div><?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
</div>
<!--后台管理左菜单栏 end-->
<!--后台管理工具栏 start-->
<div class="tool_box">
    <div class="bread">
        <a href="__APP__">管理首页</a>
        <span class="font_st">></span>
    </div>
</div>
<!--后台管理工具栏 end-->
    <div class="frame_box">
        <div class="frame_panel">
            <iframe id="display_frame" name="display_frame"  scrolling="auto"  src="<?php echo appUrl('Main/index'); ?>"
                    frameborder="0" ></iframe>
        </div>
    </div>
    
</div>

<script>
    seajs.use('__AP__/<?php echo (APP_NAME); ?>/Resource/Js/admin');
</script>
</body>
</html>