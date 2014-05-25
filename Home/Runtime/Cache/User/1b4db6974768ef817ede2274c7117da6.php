<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title><?php echo ($title); ?></title>
    <link rel="stylesheet" href="__CSS__/reset.css" />
    <link rel="stylesheet" href="__CSS__/base.css" />
    <link rel="stylesheet" href="<?php echo (APP_NAME); ?>/Resource/Css/u.css" />
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
<div class="u">
    <!--用户中心页头 start-->
<div class="header">

    <!-- 登录用户信息 -->
    <div class="user_box">
        <div class="user_box_panel">
            <div class="avatar">
                <img class="pic_small" uid="" src="<?php echo (APP_NAME); ?>/Resource/Images/user/avatar.png" />
            </div>
            <div class="user_info">
                <div>名称：<?php echo $_SESSION['_User']['username']; ?></div>
                <div>职位：<?php echo $_SESSION['_User']['group_name']; ?></div>
            </div>
        </div>
        <a href="javascript:;" class="slide_down"></a>
    </div>

    <div class="nav_panel">
        <div class="nav_msg">
            <!--<a href="javascript:;" class="slide_down"></a>-->
        </div>
        <div class="nav" id="nav">
            <ul>
                <?php if(is_array($menuList)): $i = 0; $__LIST__ = $menuList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><li>
                        <a href="javascript:;" rel="<?php echo ($menu["menu_ename"]); ?>" <?php if( $i==1 ){ ?>class="active"<?php } ?> ><?php echo ($menu["menu_name"]); ?></a>
                    </li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>



    </div>
</div>

<!--用户中心页头 end-->
    <!--后台管理左菜单栏 start-->
<div class="slide_bar">
    <div class="slide_group">
        <?php if(is_array($leftMenu)): $i = 0; $__LIST__ = $leftMenu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><div class="menu_bar <?php if(!$menu['show']){ ?> hidden <?php } ?>" id="<?php echo ($menu["tag"]); ?>">
                <?php if(is_array($menu["sons"])): $j = 0; $__LIST__ = $menu["sons"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$son): $mod = ($j % 2 );++$j; if($son['three_sons']){ ?>
                    <dl>
                        <dt><?php echo ($son["submenu_name"]); ?></dt>
                        <dd <?php if($j!=1){ ?>style=""<?php } ?>>
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
        <span class="fl_l">
             <a href="<?php echo appUrl(''); ?>">管理首页</a>
        <span class="font_st">></span>
        </span>

        <span class="fl_r">
            <div class="link_group">
                <a href="javascript:;" onclick="window.history.back()">返回上页</a>
                <a href="javascript:;" id="fresh">刷新</a>
                <a href="<?php echo appUrl('m=Index&a=logout'); ?>">安全退出</a>
            </div>
        </span>

    </div>
</div>
<!--后台管理工具栏 end-->
    <div class="frame_box">
        <div class="frame_panel">
            <iframe id="display_frame" name="display_frame"  scrolling="auto"  src="<?php echo appUrl('m=Home&a=index'); ?>"
                    frameborder="0" ></iframe>
        </div>
    </div>
    

</body>
</html>
</div>

<script>
    seajs.use('<?php echo (APP_NAME); ?>/Resource/Js/u');
</script>
</body>
</html>