/*
SQLyog Enterprise - MySQL GUI v6.5 Beta1
MySQL - 5.5.32 : Database - itshajia
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

create database if not exists `itshajia`;

USE `itshajia`;

/*Table structure for table `uio_admin` */

DROP TABLE IF EXISTS `uio_admin`;

CREATE TABLE `uio_admin` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `nickname` varchar(20) NOT NULL,
  `group_id` int(11) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `email` varchar(60) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `company` varchar(50) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `addtime` int(11) NOT NULL,
  `reg_ip` varchar(20) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `truename` varchar(20) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `uio_admin` */

insert  into `uio_admin`(`uid`,`username`,`password`,`nickname`,`group_id`,`photo`,`email`,`mobile`,`company`,`description`,`addtime`,`reg_ip`,`status`,`truename`) values (1,'itshajia','96e79218965eb72c92a549dd5a330112','IT-沙加',1,'','itshajia@gmail.com','13852757093','微信团队','',0,'127.0.0.1',1,'周星'),(7,'admin','96e79218965eb72c92a549dd5a330112','',2,NULL,'','13852757093','微信团队',NULL,1394296359,'127.0.0.1',1,'周星');

/*Table structure for table `uio_album` */

DROP TABLE IF EXISTS `uio_album`;

CREATE TABLE `uio_album` (
  `album_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `title` varchar(20) DEFAULT NULL,
  `cate_id` int(11) NOT NULL,
  `description` text,
  `listorder` int(11) DEFAULT '0',
  `addtime` int(11) DEFAULT NULL,
  `app_name` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`album_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `uio_album` */

insert  into `uio_album`(`album_id`,`uid`,`title`,`cate_id`,`description`,`listorder`,`addtime`,`app_name`) values (1,4,'最美日出',1,NULL,1,1394859564,'wz');

/*Table structure for table `uio_album_cate` */

DROP TABLE IF EXISTS `uio_album_cate`;

CREATE TABLE `uio_album_cate` (
  `cate_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `cate_name` varchar(20) NOT NULL,
  `parent_id` int(11) DEFAULT '0',
  `listorder` int(11) DEFAULT '0',
  `addtime` int(11) DEFAULT NULL,
  `app_name` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`cate_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `uio_album_cate` */

insert  into `uio_album_cate`(`cate_id`,`uid`,`cate_name`,`parent_id`,`listorder`,`addtime`,`app_name`) values (1,4,'最美瞬间',0,1,1394807862,'wz'),(2,4,'企业参观',0,2,1394807901,'wz'),(3,4,'精美的那一刻',1,1,1394807932,'wz');

/*Table structure for table `uio_album_pic` */

DROP TABLE IF EXISTS `uio_album_pic`;

CREATE TABLE `uio_album_pic` (
  `pic_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `pic_title` varchar(20) DEFAULT NULL,
  `album_id` int(11) NOT NULL,
  `pic_url` text,
  `is_cover` tinyint(1) DEFAULT '0',
  `listorder` int(11) DEFAULT '0',
  `addtime` int(11) DEFAULT NULL,
  `app_name` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`pic_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

/*Data for the table `uio_album_pic` */

insert  into `uio_album_pic`(`pic_id`,`uid`,`pic_title`,`album_id`,`pic_url`,`is_cover`,`listorder`,`addtime`,`app_name`) values (13,4,'1',1,'http://itshajia.com/Uploads/Weizhan/20140315/1394866186102639.jpg',1,0,1394866244,'wz'),(14,4,'2',1,'http://itshajia.com/Uploads/Weizhan/20140315/1394866188748623.jpg',0,0,1394866244,'wz'),(15,4,'3',1,'http://itshajia.com/Uploads/Weizhan/20140315/1394866189766051.jpg',0,0,1394866244,'wz'),(16,4,'4',1,'http://itshajia.com/Uploads/Weizhan/20140315/1394866189969204.jpg',0,0,1394866244,'wz'),(17,4,'5',1,'http://itshajia.com/Uploads/Weizhan/20140315/1394866189353549.jpg',0,0,1394866244,'wz');

/*Table structure for table `uio_app` */

DROP TABLE IF EXISTS `uio_app`;

CREATE TABLE `uio_app` (
  `app_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) DEFAULT NULL,
  `app_name` varchar(20) NOT NULL,
  `app_ename` varchar(20) NOT NULL,
  `thumb` varchar(100) DEFAULT NULL,
  `introduce` text,
  `price` varchar(255) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `is_sys` tinyint(1) DEFAULT '0',
  `status` tinyint(1) DEFAULT '0',
  `is_fee` tinyint(1) DEFAULT '0',
  `is_top` tinyint(1) DEFAULT '0',
  `listorder` int(11) NOT NULL,
  `description` text,
  PRIMARY KEY (`app_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `uio_app` */

insert  into `uio_app`(`app_id`,`type_id`,`app_name`,`app_ename`,`thumb`,`introduce`,`price`,`keywords`,`is_sys`,`status`,`is_fee`,`is_top`,`listorder`,`description`) values (7,6,'微站','Weizhan','/App/Weizhan/app.jpg','这个是微站管理应用设置',NULL,'微站',1,1,0,1,0,'&nbsp&nbsp&nbsp&nbsp微站是指将企业信息、产品、新闻等内容通过微信网页的方式进行表现，用户只要通过简单的设置，就能快速生成属于您自己的微信3G网站，并且有各种精美模板，供您选择，还有自定义模版，可以设计出自己的风格，不但提高了信息量，也使信息的展现更加赏心悦目，进一步提高用户体验。'),(8,0,'微婚庆','Wedding','/App/Wedding/app.jpg','微婚庆','10000','微婚庆',0,1,1,1,0,NULL);

/*Table structure for table `uio_app_apply` */

DROP TABLE IF EXISTS `uio_app_apply`;

CREATE TABLE `uio_app_apply` (
  `apply_id` int(11) NOT NULL AUTO_INCREMENT,
  `app_id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `addtime` int(11) DEFAULT NULL,
  `starttime` int(11) DEFAULT NULL,
  `endtime` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `agent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`apply_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Data for the table `uio_app_apply` */

insert  into `uio_app_apply`(`apply_id`,`app_id`,`uid`,`addtime`,`starttime`,`endtime`,`status`,`agent_id`) values (10,7,4,1394432958,NULL,NULL,1,NULL);

/*Table structure for table `uio_app_apply_record` */

DROP TABLE IF EXISTS `uio_app_apply_record`;

CREATE TABLE `uio_app_apply_record` (
  `record_id` int(11) NOT NULL AUTO_INCREMENT,
  `app_id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `year` int(4) DEFAULT '0',
  `addtime` int(11) DEFAULT NULL,
  `is_check` tinyint(1) DEFAULT NULL,
  `agent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`record_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `uio_app_apply_record` */

insert  into `uio_app_apply_record`(`record_id`,`app_id`,`uid`,`year`,`addtime`,`is_check`,`agent_id`) values (4,7,4,0,1394432958,1,NULL);

/*Table structure for table `uio_app_type` */

DROP TABLE IF EXISTS `uio_app_type`;

CREATE TABLE `uio_app_type` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(20) NOT NULL,
  `type_ename` varchar(20) NOT NULL,
  `listorder` int(11) NOT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

/*Data for the table `uio_app_type` */

insert  into `uio_app_type`(`type_id`,`type_name`,`type_ename`,`listorder`) values (6,'工具','tool',1),(7,'资讯','info',2),(9,'娱乐','yule',3),(10,'沟通','chat',4),(11,'解决方案','solution',5);

/*Table structure for table `uio_app_wz` */

DROP TABLE IF EXISTS `uio_app_wz`;

CREATE TABLE `uio_app_wz` (
  `wz_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `wz_name` varchar(32) NOT NULL,
  `wz_intro` text,
  `wz_contact` text,
  `status` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`wz_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `uio_app_wz` */

insert  into `uio_app_wz`(`wz_id`,`uid`,`wz_name`,`wz_intro`,`wz_contact`,`status`) values (1,4,'It沙加','<p>公司介绍</p>','<p>联系我们</p>',0);

/*Table structure for table `uio_article` */

DROP TABLE IF EXISTS `uio_article`;

CREATE TABLE `uio_article` (
  `article_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `catid` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `module_tag` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `addtime` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `listorder` int(11) DEFAULT NULL,
  `is_public` tinyint(1) DEFAULT '0',
  `views` int(11) NOT NULL DEFAULT '0',
  `is_top` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`article_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `uio_article` */

insert  into `uio_article`(`article_id`,`uid`,`catid`,`title`,`module_tag`,`description`,`addtime`,`status`,`listorder`,`is_public`,`views`,`is_top`) values (2,1,0,'微网站模板升级公告','announce','<p>平台公告内容1</p>',1394251162,1,NULL,1,0,0),(3,1,0,'汽车行业的解决方案','announce','<p>公告测试正文内容2</p>',1394251064,1,NULL,1,0,0),(4,1,0,'新增加个人微站应用','announce','<p>测试公告标题3</p>',1394251093,1,NULL,1,0,0),(5,1,0,'微站系统升级微商城新增加模板','announce','<p>测试公告内容4</p>',1394251112,1,NULL,1,0,0),(6,1,0,'微站模版新增模版2套','announce','<p>测试公告内容5</p>',1394251136,1,NULL,1,0,0),(7,1,0,'腾讯微信最新升级，微信通部分升级，请及时关注','announce','<p>腾讯微信最新升级，微信通部分</p>',1394252740,1,NULL,1,0,0);

/*Table structure for table `uio_article_category` */

DROP TABLE IF EXISTS `uio_article_category`;

CREATE TABLE `uio_article_category` (
  `catid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `catname` varchar(20) NOT NULL,
  `is_sys` tinyint(1) DEFAULT '0',
  `listorder` int(11) DEFAULT NULL,
  `module_tag` varchar(20) NOT NULL,
  PRIMARY KEY (`catid`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `uio_article_category` */

insert  into `uio_article_category`(`catid`,`uid`,`catname`,`is_sys`,`listorder`,`module_tag`) values (6,0,'默认分类',1,1,'note');

/*Table structure for table `uio_bzmap` */

DROP TABLE IF EXISTS `uio_bzmap`;

CREATE TABLE `uio_bzmap` (
  `bz_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `bzpoint` varchar(200) DEFAULT NULL,
  `company` varchar(30) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `fax` varchar(20) DEFAULT NULL,
  `addtime` int(11) DEFAULT NULL,
  `app_name` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`bz_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `uio_bzmap` */

/*Table structure for table `uio_column` */

DROP TABLE IF EXISTS `uio_column`;

CREATE TABLE `uio_column` (
  `column_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `column_name` varchar(50) DEFAULT NULL,
  `css_icon` varchar(20) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `is_sys` tinyint(1) DEFAULT '0',
  `is_show` tinyint(1) DEFAULT '0',
  `is_home` tinyint(1) DEFAULT '0',
  `sort` int(11) DEFAULT '0',
  `linkurl` varchar(50) NOT NULL,
  `description` text,
  `addtime` int(11) DEFAULT NULL,
  `app_name` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`column_id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8;

/*Data for the table `uio_column` */

insert  into `uio_column`(`column_id`,`uid`,`column_name`,`css_icon`,`image`,`is_sys`,`is_show`,`is_home`,`sort`,`linkurl`,`description`,`addtime`,`app_name`) values (52,4,'自定义栏目1',NULL,NULL,0,0,0,1,'http://www.itshajia.com',NULL,1395324767,'wz'),(53,4,'自定义栏目2',NULL,NULL,0,0,0,2,'http://www.itshajia.com',NULL,1395328943,'wz'),(54,4,'首页','','',1,1,1,0,'index.php?uid=4','',1395499293,'wz'),(55,4,'公司简介','','',1,1,0,1,'index.php?m=Index&a=about&uid=4','',1395499294,'wz'),(56,4,'产品中心','','',1,1,0,2,'index.php?m=Index&a=pro&uid=4','',1395499294,'wz'),(57,4,'新闻中心','','',1,1,0,3,'index.php?m=Index&a=news&uid=4','',1395499294,'wz'),(58,4,'联系我们','','',1,1,0,4,'index.php?m=Index&a=contact&uid=4','',1395499294,'wz'),(59,4,'一键拨号','','',1,1,0,5,'tel:','',1395499294,'wz'),(60,4,'一键导航','','',1,1,0,6,'','',1395499295,'wz');

/*Table structure for table `uio_custom_menu` */

DROP TABLE IF EXISTS `uio_custom_menu`;

CREATE TABLE `uio_custom_menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `menu_type` varchar(20) DEFAULT NULL,
  `title` varchar(20) DEFAULT NULL,
  `menu_key` varchar(20) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `child_count` int(11) DEFAULT NULL,
  `listorder` int(11) DEFAULT '0',
  `addtime` int(11) DEFAULT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

/*Data for the table `uio_custom_menu` */

insert  into `uio_custom_menu`(`menu_id`,`uid`,`menu_type`,`title`,`menu_key`,`parent_id`,`child_count`,`listorder`,`addtime`) values (9,4,'click','关于我们','news_6',0,1,1,1396184679),(12,4,'click','预定管理','app_7',0,4,2,1396184741),(15,4,'view','酒店介绍','http://itshajia.com',9,0,0,1397071714),(16,4,'view','客房预定','http://itshajia.com',12,0,1,1397071752),(17,4,'view','会场预定','http://itshajia.com',12,0,4,1397071807),(18,4,'view','餐饮预定','http://itshajia.com',12,0,2,1397071847),(19,4,'view','宴厅预定','http://itshajia.com',12,0,3,1397071883);

/*Table structure for table `uio_levelmsg` */

DROP TABLE IF EXISTS `uio_levelmsg`;

CREATE TABLE `uio_levelmsg` (
  `msg_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `from_uid` int(11) DEFAULT NULL,
  `msg_name` varchar(20) DEFAULT NULL,
  `addtime` int(11) DEFAULT NULL,
  `app_name` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`msg_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `uio_levelmsg` */

/*Table structure for table `uio_menu` */

DROP TABLE IF EXISTS `uio_menu`;

CREATE TABLE `uio_menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_ename` varchar(32) NOT NULL,
  `menu_name` varchar(32) NOT NULL,
  `listorder` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `uio_menu` */

insert  into `uio_menu`(`menu_id`,`menu_ename`,`menu_name`,`listorder`,`status`) values (2,'article','文章管理',2,1),(4,'user','用户管理',1,1),(5,'tool','站长工具',4,1),(6,'app','应用中心',3,1);

/*Table structure for table `uio_nav` */

DROP TABLE IF EXISTS `uio_nav`;

CREATE TABLE `uio_nav` (
  `nav_id` int(11) NOT NULL AUTO_INCREMENT,
  `nav_url` varchar(200) NOT NULL,
  `nav_title` varchar(20) NOT NULL,
  `nav_style` varchar(20) NOT NULL,
  `listorder` int(11) NOT NULL,
  `newwindow` int(11) NOT NULL,
  `ishide` int(11) NOT NULL,
  PRIMARY KEY (`nav_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `uio_nav` */

/*Table structure for table `uio_news` */

DROP TABLE IF EXISTS `uio_news`;

CREATE TABLE `uio_news` (
  `news_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `title` varchar(32) NOT NULL,
  `cate_id` int(11) NOT NULL,
  `description` text,
  `listorder` int(11) DEFAULT '0',
  `addtime` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `app_name` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`news_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `uio_news` */

insert  into `uio_news`(`news_id`,`uid`,`title`,`cate_id`,`description`,`listorder`,`addtime`,`status`,`app_name`) values (1,4,'央行确认叫停虚拟信用卡 中信银行停牌',2,'<p>受央行叫停虚拟信用卡传闻影响，中信银行股价暴跌，午后停牌。截至午间收盘，中信银行跌8.07%，</p><p>有媒体报道称，央行下发紧急文件《中国人民银行支付结算司关于暂停支付宝公司线下条码(二维码)支付等业务意见的函》，叫停支付宝、腾讯的虚拟信用卡产品，同时叫停的还有条码(二维码)支付等面对面支付服务。</p><p>据人民网消息，今天上午，中国人民银行支付结算司冯新娅确认，中国人民银行支付结算司13日下发了关于叫停虚拟信用卡和二维码支付业务的通知，并已抄送人民银行相关分支机构、清算机构和支付清算协会。</p><p>对于叫停虚拟信用卡和二维码支付务的原因，冯新娅说，主要是从从客户支付安全的角度出发。下一步，会从风险的角度统一评估这两个产品，现在只是让他们履行义务报告的义务，请他们补充一些资料，对根据材料做进一步研究，现在只做到这一步。</p><p>对于两项业务触及何种风险触发央行叫停，冯新娅表示，因为涉及相关公司的业务走向不方便回答，何时能恢复这两项业务也不能确定。</p><p>2014年3月13日，中信银行发布关于进行互联网金融业务合作的公告，公告称因中信银行业务发展需要，该行近日在互联网金融领域进行一系列相关业务合作安排，具体情况包括与腾讯公司及众安保险推出的中信银行微信信用卡，即微信信用卡，还有与阿里巴巴的关联公司支付宝和众安保险推出的网络数字信用卡——中信淘宝异度支付信用卡，简称淘宝异度卡。</p><p><br/></p>',1,1394777984,0,'wz'),(2,4,'米雷军谈黄章：他骂了我们很多 都是一家之言',3,'<p style=\"text-align: center;\"><img src=\"http://itshajia.com/Resource/Js/ueditor/php/upload/58151394778094.jpg\" alt=\"雷军首谈黄章：他骂了我们很多 都是他一家之言\" style=\"border: black 1px solid;\" border=\"0\" height=\"319\" width=\"476\"/></p><p><strong>谈产品集权：你相信我是做事情极细的人吧</strong></p><p>(人物：PORTRAIT＝P、雷军＝L)</p><p>P：据说小米内部是“<strong>人事放松，产品集权</strong>”，很多产品决策要你拍板。具体指什么？</p><p>L：对。<strong>在包装上、产品上，比如说，字体、字号、东西大小怎么摆，这些细节都是我看过的，包括小米微博里发出去的每张图都是我定的。这样就保证了小米所有出去的东西都是一致性的，维持了很高的品质。</strong></p><p>就像如果我办杂志，里面的每一张图我都看过，每个版式、字体、有没有错别字、标点符号对不对，基本都看过了。好像你们的字体有问题，略小一号。</p><p>P：故意小的。</p><p>L：小完以后，会制造阅读的(障碍)，会让阅读很疲劳。</p><p>P：但是它会显得更精致、更美观、更好看。</p><p>L：精致和美观和字号小没关系。还有，你的行间距肯定宽了。</p><p>P：咱们先不纠结这个了吧。</p><p>L：OK，你肯定有你的选择，我有我的选择，如果这个产品是我做的，它必须按照这个标准走。所有这些细节要求完以后，你要把所有的事情简化，你要尽量少做一些事情，因为只有你少做事情，你才能把事情做好，所以小米极其强调专注。</p><p>我可以给你举个简单的例子。<strong>我以前做新闻发布会，我抓的细节是什么呢？比如说请客，我怎么能保证每一场新闻发布会，第一，准点开，第二，场场爆满。</strong>要不要我展开告诉你怎么能做到？</p><p>P：说一说你最得意的。</p><p>L：第一个，<strong>就是你要花4次的时间去邀请一个人</strong>，比如说你提前一个月告诉他，我们什么时候开发布会，你提前一周\r\n提醒他说什么时候开，然后你提前一天，你要跟他再次cellphone(电话)确认，提前一小时再发条短信，他出门没有。做了这些，不表示这个人能到，我\r\n们更强调的是现场会，这个会开完了以后，比如说你负责请20个人，现场开会，这20个人到了多少个，19个，为什么那个没到，就是因为你有一个客人没到，\r\n你可能在那里要给我解释半个小时，这个人为什么没到。</p><p>这个会结束以后，你一定会打电话投诉他，你为什么不到？好，下次你再请他，要么他就说我不来，要么他答应了来，他一定得准点来。<strong>我们有现场会，直接考核请到率，这是第一招狠的。</strong></p><p>第二招，<strong>请100个人，摆80把凳子，后来的人没有位置，是不是场场爆满。</strong></p><p>P：故意的。</p><p>L：故意的，所以你要准点到了，是吧，你相信我是做事情极细的人吧？OK，办一场发布会把自己累个半死，这次干小米，这些事情全部不干了，全部砍\r\n掉。因为我发现一个最重要的事情没做好，我们花了这么大代价、花了这么多钱把客人请来了，但是我们没有真正跟他们讲明白我们这个发布会到底发布什么。你看\r\n一般的发布会，记者都在外面抽烟，很多记者拿完新闻稿听完以后，基本都撤了，没有人真的坐在那里听。</p><p>P：嗯，这种新闻发布会模式的确高成本低收益。</p><p>L：好，成本是什么呢？每个请到的记者，我们所有成本算上去，你要租场地，你要布展，你所有的成本分摊到人头上去，可能闹不好2000块钱。正儿八\r\n经的你这个会可能只讲了15分钟、20分钟。讲稿呢？提前一天不怎么睡觉，花五六个小时整理一下就完了，这是传统的发布会，安排领导讲话，安排什么沙画、\r\n小提琴、艺术，什么乱七八糟的，最后找几个走秀，是吧？漂亮衣服展示一下，还挺热闹，其乐融融，但是没价值。我办小米，<strong>我跟他们说专注，小米的发布会只要干好一件事情，把讲稿写好，就是把现场的PPT写好。</strong>你知道我们讲稿要花多长时间，多少人写吗？</p><p><strong>我们会有四五人的一个核心团队，会有四五十人参与，一般会写一个月到一个半月，我自己每天会花四五个小时，一般会改100遍以上，每一张都要求是海报级。</strong>写完了稿子以后，要推敲每5分钟听众会不会有掌声，每10分钟听众会不会累，我们是应该插短片还是插段子，还是插图片，怎么调动全场气氛，怎么能确保这个发布会一个半小时能结束。我一个人从头讲到尾，保证那一个半小时里面，能让你觉得全场无尿点。</p><p>所以请客那些爱到不到算了，不重要，重要的是来了多少人，你能不能打动他，让他真的觉得你这个东西做得好。当然最后你可能说，雷军做东西也不见得好看，这个是能力问题，不是态度问题，但是<strong>你要知道我那个字号可能改了100次，左挪挪，右挪挪，上挪挪，拿尺子再量，都是干过的。</strong> (指办公室白板上贴着的小米电视海报)你觉得这个活儿，多长时间你能干完？比如说我们在电梯里面贴张海报。</p><p>P：找一个美编，一下午。</p><p>L：一下午，你说得很好。我们找10个人，先做100套方案，再选出10个方案，然后全部打印出来之后摆一排，我看一个星期以后选两幅，把两幅再展成十几幅，再干完以后，修图，修完以后再放两周，还有些问题，再改一遍，再看一周，然后再投放，至少要干一个半月。</p><p>(指墙上贴的小米电视海报)这是中间稿子，不是最终的，这个稿子还是有问题。</p><p>P：为什么不可以是一个你欣赏的、足够牛逼的设计师，他花一下午时间做。</p><p>L：我再告诉你，我们这里请了一大批牛逼的设计师，我认为小米对设计是极其重视的。我们8个合伙人有2个，一个是黎万强，跟我干了十几年设计，还有\r\n刘德，刘德是ACCD(Art Center College of Design)毕业的，全中国ACCD毕业的没几个人吧。但是我认为，<strong>世界上没有牛逼的人，只有极其认真的完美主义者。</strong></p><p>我再举个例子，<strong>同样是发布会，我准备已经够认真了，后来看乔布斯怎么做的时候，我发现我疯了。乔布斯会把那个会场租下来两个星期——我们没钱，我们只能租两天——现场彩排两周，我们没有一个人做到这样，花钱太厉害了。</strong></p><p>我为什么举这个例子(小米电视海报)呢，因为当当的老板见我说，你们广告做得很好啊，经常做广告，我说我们基本不做广告的，他说电梯广告每天换来换去，只有你们给我留下了印象。</p><p><br/></p>',1,1394778060,0,'wz'),(3,4,'企业云服务提供商MuleSoft获5000万美元融资，将上市',4,'<p>\r\n			\r\n		</p><p>\r\n		\r\n		<section id=\"wrap-left\">\r\n			\r\n			<article id=\"article\">\r\n				<header class=\"article-header\">\r\n					<a href=\"http://tech2ipo.com/news\" class=\"category title-act\">新闻</a>\r\n					\r\n\r\n					<h1 class=\"title\" id=\"art_title_63806\">企业云服务提供商MuleSoft获5000万美元融资，将上市</h1>\r\n					\r\n					\r\n					<p>\r\n						</p><p>\r\n														共分享<em id=\"share_total_63806\">0</em>次							<a class=\"sina\"></a>\r\n							<a class=\"qq\"></a>\r\n							<a class=\"renren\"></a>\r\n							<a class=\"qzone\"></a>\r\n							<a class=\"more\" id=\"showShare\"></a>\r\n							\r\n							\r\n						</p><p>\r\n						<span class=\"author\" id=\"author\">\r\n															<a href=\"http://tech2ipo.com/author/36164\" class=\"author\">柯基虫</a>\r\n																					\r\n													</span>发布于2014-03-14 12:05:53					</p>\r\n				</header>\r\n				<section id=\"article-content\">\r\n					<p><img src=\"http://img0.tech2ipo.com/upload/img/article/2014/03/1394768926106.png\" title=\"屏幕快照 2014-03-14 11.48.03.png\"/></p><p>站在多种流行趋势的交汇口，<a href=\"http://www.mulesoft.com/\" target=\"_blank\" title=\"\">MuleSoft</a>&nbsp;成为了又一家引领潮流的创业企业。</p><p>公司<a href=\"http://www.mulesoft.com/press-center/50-million-funding\" target=\"_blank\" title=\"\">公告</a>称，\r\n刚刚完成计划 5000 万美元的 F 轮融资，总融资额达到了131亿美元，目前估值近8亿美元。Anypoint 企业整合平台是 MuleSoft\r\n 旗下的最大产品，当中包括了SOA、SaaS整合以及API管理功能。全球 500 强企业当中一半的公司都使用了MuleSoft提供的产品。</p><p>“SaaS（软件即服务，基于 Web 的软件服务）、大数据、移动等等，这些都是刚刚过去的几年以来最流行的科技发展趋势。而他们需要一种新型的平台来连接所有的服务，于是MuleSoft来了。”MuleSoft的投资人&nbsp;Ravi Mhatre 这样讲到。</p><p>公\r\n司CEO&nbsp;Greg Schott 表示，MuleSoft 的融资策略一直以需求为基础，不会超额融资。从 A 轮到的 F \r\n轮，融资额从400万美元稳步提升。MuleSoft 的投资者众多，包括&nbsp;NEA、Lightspeed、Cisco、SAP \r\nVentures、Bay Partners 等知名私募基金、风投公司和 IT 企业。</p><p>未来，MuleSoft 将筹备上市。 <strong>它</strong><strong>的成功给了所有创业公司一个<a href=\"http://pando.com/2014/03/13/ipo-bound-mulesoft-raises-50m-and-doubles-its-valuation-to-800m-as-saas-adoption-explodes/\" target=\"_blank\" title=\"\">启示</a>：</strong></p><p>在创业顺利、风投紧追、卖身变现或是IPO上市所有这些事情发生之前，<strong>你先要知道自己该做什么，用什么创业</strong>。</p><p>优秀的创业者，观察科技、人、整个社会的发展变化趋势，然后用手头的技术来解决趋势发展产生的问题。</p><p>而顶尖的创业者，在许多种趋势的交汇口，将他们整合到一起。</p></section></article></section></p><p><br/></p>',1,1394778100,0,'wz'),(4,4,'暗藏iWatch应用 苹果iOS 8传言汇总',5,'<p class=\"image\"><img src=\"http://itshajia.com/Resource/Js/ueditor/php/upload/16251394778166.jpg\"/></p><p><iframe src=\"http://pos.baidu.com/ecom?cec=UTF-8&dai=2&cfv=11&cpa=1&col=zh-CN&dis=0&xuanting=0&n=49028089_cpr&conOP=0&scale=&skin=&rsi0=250&rsi1=250&rsi5=4&ltr=http%3A%2F%2Fnews.baidu.com%2Fn%3Fcmd%3D1%26class%3Dtechnnews%26pn%3D1%26from%3Dtab&ltu=http%3A%2F%2Fzhangguoren.baijia.baidu.com%2Farticle%2F7280&pcs=1360x619&rss0=%23FFFFFF&rss1=%23FFFFFF&rss2=%230000FF&rss3=%23444444&rss4=%23008000&rss5=&rss6=%23e10900&rss7=&rad=&pis=10000x10000&aurl=&psr=1360x768&pss=1360x619&tpr=1394778146873&lunum=6&ch=0&at=6&qn=1bb43b1564e44ee3&ps=522x847&tn=text_default_250_250&ts=1&c01=0&td_id=1462199&adn=3&cad=1&ccd=24&dtm=BAIDU_DUP2_SETJSONADSLOT&dc=2&di=u1462199\" marginwidth=\"0\" marginheight=\"0\" allowtransparency=\"true\" frameborder=\"0\" align=\"center,center\" height=\"250\" scrolling=\"no\" width=\"250\"></iframe></p><p class=\"text\">硬件再发明（公众号:newhard 编译整理）</p><p class=\"text\">下一代iOS操作系统应该会在今年秋天问世，而苹果一般会在夏天就先行公布相关的细节信息。不过在目前，我们已经看到了不少和iOS 8有关的信息和传闻。MacRumors进行了盘点：</p><p class=\"text\">iOS \r\n8据传将非常侧重于健康功能，并可能会整合iWatch——一款备受外界期待，但尚无任何确凿消息证明其存在的智能手表。消息称，iOS \r\n8当中将新增名为“Healthbook”的应用，可从iPhone 5s的M7动作协处理器和iWatch的传感器当中收集到健身相关的数据。</p><p class=\"text\">由于iOS 7带来了彻底的视觉调整，iOS 8在设计上应该不会带有太多的改动。相反，苹果会把重点放在现有功能的打磨和完善上，或许包括对于苹果地图和Siri的提升，以及通过新的移动支付系统强化Touch ID的功能。</p><p class=\"text\"><strong>iWatch</strong></p><p class=\"text\">iOS 8目前并没有太多确凿的信息，但9to5Mac最近报道的传闻称，iOS 8的一大重点是iWatch，以及与健康有关的应用和功能。</p><p class=\"text\">据传，iOS 8在开发阶段就考虑到了iWatch，而这款设备也会非常依赖于这款操作系统和iPhone。</p><p class=\"text\"><strong>应用</strong></p><p class=\"text\">iOS 8或许会加入名为“Healthbook”的应用程序，它和目前的Passbook游戏类似，可从多方来源处收集到和健康相关的数据，就像是Passbook汇集卡片和票据等信息一样。</p><p class=\"image\"><img src=\"http://itshajia.com/Resource/Js/ueditor/php/upload/17371394778166.jpg\"/></p><p class=\"text\">9to5Mac认为，该应用将可以去管理和追踪身体\r\n的重量信息，并监控和存储诸如步数、热量消耗和行进距离这样的健身数据。它说不定还能监控到用户的生命体征，比如血压、水合程度、心率和血糖水平，把这些\r\n信息汇总到一起，来呈现出身体健康的整体情况。Healthbook的本质应该会和市面上那些健身手环的配套应用很类似，比如Fitbit和\r\nJawbone。</p><p class=\"text\"><strong>地图</strong></p><p class=\"text\">苹果一直在努力提升其自家地图应用的品质。相信大家都还记得，苹果在iOS 6当中放弃了谷歌地图，而选择自己提供地图服务。但他们的苹果地图在问世之初因为大量错误和瑕疵受到了用户和媒体一致的批评。</p><p class=\"text\">虽然苹果在去年增加了丢失的数据，也修复了位置错误，但该服务依然还有一些功能提升即将和我们见面，包括室内地图功能和公交路线。</p><p class=\"text\">在2013年，苹果收购了多家地图公司，也招募了不少相关的技术人员。被收购的地图公司包括\r\nEmbark，HopStop，WifiSLAM和Locationary。其中前两家公司主要注重的是公共交通，而Locationary是一家侧重于\r\n餐馆和其他本地商业服务的众包位置数据的公司。</p><p class=\"image\"><img src=\"http://itshajia.com/Resource/Js/ueditor/php/upload/26051394778167.jpg\"/></p><p class=\"text\">另一家WifiSLAM所侧重的是室内地图，这应该\r\n是苹果非常感兴趣的功能，考虑到他们最近对于iBeacons的投入，后者同样可以用来通过蓝牙传递室内的精确地图数据。iPhone 5s和iPad \r\nmini所配备的M7动作协处理器同样可以在未来的地图升级当中被加以利用，来帮助用户寻找停泊的汽车，或者是在驾车和步行之间进行无缝转换。</p><p class=\"text\">最近有传闻称，iOS 8可能会在地图应用上面加入一些重大的升级，首度提供公交线路服务，并增强兴趣点功能。苹果还计划提供室内地图和增强的汽车整合，而后者的技术支持可能是由未来版本iOS中的增强现实软件所提供。</p><p class=\"text\"><strong>iTunes Radio</strong></p><p class=\"text\">iTunes Radio串流音乐服务随iOS 7一起问世，目前可通过iOS的音乐应用使用。而根据9to5Mac的新报道，在iOS 8当中，该功能可能会拥有属于自己的独立应用，以增加它的曝光度和使用频率。</p><p class=\"text\"><strong>Siri</strong></p><p class=\"text\">目前我们还不清楚苹果为Siri准备的安排，但iOS 8可能会继续带来对于这项服务的升级。根据The Information的报道，苹果目前正在侧重于拓展Siri和第三方应用对接的能力，因为它可能会成为iWatch的关键输入手段。</p><p class=\"text\">虽然Siri的特定功能已经拥有来自于第三方公司的支持，但苹果的目标是带来那些不需要定制商业交易的第三方整合。</p><p class=\"text\"><strong>移动支付</strong></p><p class=\"text\">华尔街日报最近暗示，苹果正有意开发一款新的移动支付服务，来允许消费者使用自己的iPhone购买实体商品或服务，而不是仅限于通过iTunes商店购买应用、歌曲和其他数字内容。</p><p class=\"image\"><img src=\"http://itshajia.com/Resource/Js/ueditor/php/upload/39611394778167.jpg\"/></p><p class=\"text\">这样的系统应该会和Touch ID指纹扫描器紧密协作，因为库克之前就已经确认，Touch ID在设计时就考虑到了支付功能。移动支付是苹果一直都很“好奇”的机遇，也是他们计划去追求的。</p><p class=\"text\">但这样一个移动支付系统能否赶在iOS 8发布时完成，这还完全是个未知数，但其中的部分功能可能会加入到这次升级当中。而重大功能的加入一般都会伴随着大版本升级和硬件发布一同到来，比如iOS 4的FaceTime，iOS 5的Siri，还有iOS 6的地图应用。</p><p class=\"text\"><strong>iOS 8浏览器活动</strong></p><p class=\"text\">科技网站MacRumors会定期观察对于自家网站的访问当中有多少设备会报告自己运行的系统版本是iOS 8。</p><p class=\"text\">尽管iOS 8在去年8月份就已经出现在了开发者日志当中，但该操作系统应该还处于早期研发阶段，只有一小部分员工才能接触到。因此，外部网站监测到来自该系统的访问并不多。</p><p class=\"text\"><strong>发布日期</strong></p><p class=\"text\">iOS 8最有可能会在今年秋天发布，随之而来的还有下一代iPhone。但苹果可能会在今年早些时候就对其进行预先的介绍。新版本iOS一般都会在每年的下半年发布。</p><p><br/></p>',1,1394778130,0,'wz'),(5,4,' 互联网不是狼，传统渠道你有什么可怕的？',6,'<p><img class=\"aligncenter size-large wp-image-81534\" title=\"渠道选择\" src=\"http://itshajia.com/Resource/Js/ueditor/php/upload/34931394778202.jpg\" alt=\"\" height=\"420\" width=\"560\"/></p><p>最近，我参加了好几个传统IT品牌的全国渠道会，下周还要去美国参加一个老牌IT巨头的全球渠道会。席间的话题少不了“<span class=\"wp_keywordlink_affiliate\"><a href=\"http://www.tmtpost.com/tag/%e4%ba%92%e8%81%94%e7%bd%91\" title=\"查看 互联网 中的全部文章\" target=\"_blank\">互联网</a></span>化”和“互联网冲击”，关注中国IT渠道超过10年时间，从没有一年如今年一样显得危机重重。</p><blockquote><p>“互联网抢走了生意，我们该怎么办？”；</p><p>“电商来了，我们又能去哪里？”；</p><p>“不转型就死了，可是我们要如何转？”；</p></blockquote><p>&nbsp;</p><p>嘈杂和繁乱的各种疑问句，在互联网上飘来飘去，就好像一朵朵云飘在天空，可惜......这成不了云计算。幸好最近接触的渠道朋友，多数是圈里的精英。互联网冲击也显然成了他们中间的天堑鸿沟，一边是地域，一边是天堂。</p><p>自我看来，所谓的互联网冲击对于传统渠道而言必然是存在的，但却绝没到生死关头，传统渠道多年建立起来的优势也不会一朝打破。为什么？</p><p>&nbsp;</p><p>一、卖场经济退化，实属自然淘汰</p><p>被互联网大潮冲击的第一波传统IT渠道，是通用电脑硬件销售商。在IT圈里，俗称“搬箱子”的一类人。说实话，即便是电商没来之前的很长一段时间，\r\n至少在5到8年前，在IT领域“搬箱子”的渠道早已成为整个渠道生态的末流，是必然要淘汰的“明日黄花”；当然今天已成“过去黄花”。</p><p>而互联网的冲击，只不过将这个过程无限提前了。实际上，“搬箱子”渠道退出历史舞台与电商的崛起关系并不是很大，因为在过去这段时期里，他们早已习\r\n惯了过零利润甚至负利润销售。传统分销商，通过牺牲利润，实现高出货量以博得高返点这是渠道中最基础的玩法。所以，电商的冲击对他们的利润冲击其实并不算\r\n大，而是对传统渠道的销量产生了比较大的影响，才使得中关村这种卖场经济逐渐退化了。</p><p>我更愿意相信，这是一种自然淘汰，而不完全是由于互联网的冲击引起的。</p><p>&nbsp;</p><p>二、互联网化的服务，对传统2B的渠道模式是补充</p><p>再进一步来讲，比“搬箱子”的渠道稍高一个层次的，是用户群并非全消费的一类渠道——也许可以叫做“商用搬箱子渠道”。举个例子，比如同样的是\r\nPC，在联想这种公司里就有“消费PC部门”和“商用PC部门”的区别。产品差别其实不大，但因为出货渠道是有差异的，所以产生了所谓的“商用渠道”，这\r\n种渠道类型是从“搬箱子”演变而来。</p><p>这类渠道身上，毕竟存在着“2B”的光环，而电商至少从目前上来讲冲击的主要是“2C”这个环节。因此“商用搬箱子”目前的处境相对还好过些。他们\r\n的销售对象主要以机关、单位、企事业单位为主体。形成了一定程度的地域覆盖和服务依赖，客户的粘合度较高，互联网对他们的冲击并不强，反而其中的“快渠道\r\n商”们已经开始用互联网工具在做客户服务（售前售后环节等），比如通过微信CRM来维护用户忠诚度，增加用户的紧密度等。</p><p>不过，居安思危是必要的。互联网的冲击，不仅仅是让用户在产品的购买层面发生了改变。<strong>互联网思维所引发的用户需求改变才是最可怕的</strong>，比如云存储的应用（例如：百度云，微云）导致移动硬盘和U盘的销量下降，云服务导致的基础服务收费难都是传统渠道做销售和服务时难以逾越的关卡。这种冲突，在未来也许会随着公有云的加速，更为明显。</p><p>&nbsp;</p><p>三、 系统集成商，影响很有限</p><p>再高一个层面，就是SI了，系统集成商。一定的技术含量、较高的技术服务依赖性、行业用户的系统需求等等，这些属性都决定了在现阶段他们还具有极强的不可替代性。</p><p>互联网的冲击对于系统集成商来说，短期内都是利好消息<strong>。更多的行业用户意识到互联网的好处，这代表着更多的预算和更高的产品技术需求</strong>，云计算和虚拟化这些名词逐渐变成用户选择的标配，互联网对他们而言，目前还是只有好处，没有坏处。同样的还有ISV，独立软件开发商，这个层面的渠道多数以行业大单为生存模式，目前互联网对其影响还不算大。</p><p>简单总结起来，互联网化对于传统IT渠道而言，其实并没有那么可怕。该消失的环节，那是历史发展的必然，并非一个电商能够单方面驱动的，该改进的环节，必然会随着互联网化的深入再调整，该发光的地方....这个以后单独写一篇文章来讨论一下。</p><p>别忘了，十多年前，那也曾是一个很多传统企业对“信息化”谈虎色变的年代；今天的互联网化，要么是一种服务补充，要么是产业链某个环节的优化。渠道，你还怕什么！</p><p><br/></p>',1212,1394778176,0,'wz'),(6,4,'盘点那些互联网品牌神机',7,'<p>手机的互联网化在今天看来已经不是什么新鲜事儿，这似乎也与我们的生活方式有着密不可分的联系，而手机与互联网都是我们日常生活当中不可或缺的东西，二者的结合自然是大势所趋。</p><p style=\"text-align:center;\">\r\n	<a href=\"http://tc.people.com.cn/n/2014/0314/c183175-24635496-2.html\"><img alt=\"IUNI一加nubia 盘点那些互联网品牌神机 \" src=\"http://www.people.com.cn/mediafile/pic/20140314/57/8956812082137595669.jpg\"/></a></p><p>\r\n	　　在近几年的手机行业当中，互联网手机的概念已经逐渐被用户所熟知，各大手机厂商也都纷纷成立了自己的互联网手机品牌，而说到互联网手机相信很多网友第一时间会想到的是小米，熟不知在近一年当中国内手机圈冒出了多个互联网手机品牌，让小米略显失色。</p><p>\r\n	　　能让小米都黯然失色的产品必然有它的独到之处，就拿最近即将发布的IUNI和一加来说，前者将在本月以单手机皇的姿态强势杀到，而后者更是曝出了将搭载声纹解锁的杀手锏功能。</p><p style=\"text-align:center;\">\r\n	<a href=\"http://tc.people.com.cn/n/2014/0314/c183175-24635496-2.html\"><img alt=\"IUNI一加nubia 盘点那些互联网品牌神机 \" src=\"http://www.people.com.cn/mediafile/pic/20140314/14/23623310582902694.jpg\"/></a></p><p>\r\n	　　除了即将上市的几款旗舰级产品之外，已经上市的nubia Z5S、荣耀3c、酷派大神都是目前国内关注度极高的互联网品牌手机。那么笔者今天在这里就关于目前市面上这些互联网神机进行一番汇总，看看其中有没有你心中的最爱。</p><p><br/></p>',1,1394778208,0,'wz'),(7,4,'爱克发新型喷墨打印设备隆重上市 开启印艺新标准',8,'<p>　<a target=\"_blank\" href=\"http://www.cpp114.com/\"><span style=\"color: #0000ff\"><strong>【CPP114】</strong></span></a>讯：宽幅 UV <a target=\"_blank\" href=\"http://cpp114.com/supply/listSupplyAndParam_1150.htm\">打印机</a>Jeti Titan系列的成功，为新的Jeti Titan S (快速) and HS （高速）打印机出台奠定了基础。Jeti Titan S 和 Jeti HS 纯平版UV喷墨打印机成就了高产量、高品质、最优价格的完美结合。<br/></p><p><img alt=\"\" src=\"http://www.cpp114.com/UserFiles/Image/%CD%BC%C6%AC1%285%29.jpg\"/></p><p>　　Jeti Titan S 及 HS引擎装置采用了最先的进拥有1280个喷嘴的理光第五代打印头。Jeti Titan S 配备的一排打印头可升级成为两排，从而打造出Jeti Titan HS 和更高的生产水平。<br/></p><p><img alt=\"\" src=\"http://www.cpp114.com/UserFiles/Image/%CD%BC%C6%AC3%281%29.jpg\" height=\"195\" width=\"500\"/></p><p><br/>　　工业制造，性能全面<br/><br/>　　根据市场需求，这两台设备的默认值涵盖6种色彩外加白色 （CMYKLcLmWW）。白色打印支持不同的打印模式，其中包括针对硬性介质的叠印, 底色打印, 专色, 底色专色, 填充打印以及针对卷装介质可以打印前预印白墨。白色<a target=\"_blank\" href=\"http://www.wdhc.cn/\">油墨</a>解决方案赋予自动循环系统下<a target=\"_blank\" href=\"http://www.wyy.cn/\">印刷</a>的最佳的可靠性。<br/><br/>　　Jeti Titan S 和 HS \r\n是大批量高转速工作的理想选择。他们能够保证高精度的下降位置。7皮升滴液大小使之能够实现照片般逼真的图像质量，且细致文本仅有正负4pt之差。对于高\r\n品质的艺术品、近距离的观赏品以及时装和化妆品市场来说，Jeti Titan S 和HS是高端产品<a target=\"_blank\" href=\"http://www.wyy.cn/\">印刷</a>无可取代的解决方案。<br/></p><p><img alt=\"\" src=\"http://www.cpp114.com/UserFiles/Image/%CD%BC%C6%AC2%282%29.jpg\" height=\"209\" width=\"500\"/></p><p><br/>　　Jeti Titan S 和HS 2X3m 的纯平板设计可提供优化注册及重复选择。这两种系统都配备精密的移动工作台，建在可昼夜工作的坚固钢制框架上。同时，这两台设备都采用了最新一代的打印头和固化技术。<br/><br/>　　特有的“平板与卷对卷转换”选件带来更大的生产灵活性, 用户可以在3.2米宽的柔性介质上打印，并且保证拥有和打印在硬性介质上同样的高品质和高清晰度。<br/><br/>　　Jeti Titan S 和HS是将Asanti工作流程软件Anuvia UV固化油墨结合，组成匹配的优化系统，以确保高质量、高生产力以及可预见的产出。</p><p><br/></p>',1,1394778296,0,'wz');

/*Table structure for table `uio_news_cate` */

DROP TABLE IF EXISTS `uio_news_cate`;

CREATE TABLE `uio_news_cate` (
  `cate_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `cate_name` varchar(20) NOT NULL,
  `parent_id` int(11) DEFAULT '0',
  `listorder` int(11) DEFAULT '0',
  `addtime` int(11) DEFAULT NULL,
  `app_name` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`cate_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `uio_news_cate` */

insert  into `uio_news_cate`(`cate_id`,`uid`,`cate_name`,`parent_id`,`listorder`,`addtime`,`app_name`) values (2,4,'互联网',0,1,1394777520,'wz'),(3,4,'人物动态',2,1,1394777616,'wz'),(4,4,'公司动态',2,2,1394777633,'wz'),(5,4,'科技',0,2,1394777710,'wz'),(6,4,'互联网',5,1,1394777723,'wz'),(7,4,'手机',5,2,1394777731,'wz'),(8,4,'数码产品',5,3,1394777741,'wz');

/*Table structure for table `uio_page` */

DROP TABLE IF EXISTS `uio_page`;

CREATE TABLE `uio_page` (
  `page_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `title` varchar(20) NOT NULL,
  `description` text,
  `listorder` int(11) DEFAULT '0',
  `addtime` int(11) DEFAULT NULL,
  `app_name` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`page_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `uio_page` */

insert  into `uio_page`(`page_id`,`uid`,`title`,`description`,`listorder`,`addtime`,`app_name`) values (4,4,'单页标题1','<p>单页内容1</p>',1,1394805437,'wz'),(5,4,'单页标题2','<p>单页内容2</p>',2,1394805498,'wz'),(6,4,'单页标题3','<p>单页内容3</p>',3,1394805512,'wz');

/*Table structure for table `uio_pro` */

DROP TABLE IF EXISTS `uio_pro`;

CREATE TABLE `uio_pro` (
  `pro_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `title` varchar(20) NOT NULL,
  `description` text,
  `listorder` int(11) DEFAULT '0',
  `addtime` int(11) DEFAULT NULL,
  `app_name` varchar(20) DEFAULT NULL,
  `pic` text,
  `cate_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`pro_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `uio_pro` */

insert  into `uio_pro`(`pro_id`,`uid`,`title`,`description`,`listorder`,`addtime`,`app_name`,`pic`,`cate_id`) values (7,4,'53度 茅台 迎宾酒（盱眙国际龙虾节专供','<p>53度 茅台 迎宾酒（盱眙国际龙虾节专供) 500ml&nbsp;</p>',1,1394787145,'wz','http://itshajia.com/Uploads/Weizhan/20140314/1394802801662990.jpg,http://itshajia.com/Uploads/Weizhan/20140314/1394802802377130.jpg,http://itshajia.com/Uploads/Weizhan/20140314/1394802802129654.jpg',1),(8,4,'测试产品标题','<p>121212</p>',2,1394843332,'wz','http://itshajia.com/Uploads/Weizhan/20140315/1394843342146178.jpg,http://itshajia.com/Uploads/Weizhan/20140315/1394843343102011.jpg',1);

/*Table structure for table `uio_pro_cate` */

DROP TABLE IF EXISTS `uio_pro_cate`;

CREATE TABLE `uio_pro_cate` (
  `cate_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `cate_name` varchar(20) NOT NULL,
  `parent_id` int(11) DEFAULT '0',
  `listorder` int(11) DEFAULT '0',
  `addtime` int(11) DEFAULT NULL,
  `app_name` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`cate_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

/*Data for the table `uio_pro_cate` */

insert  into `uio_pro_cate`(`cate_id`,`uid`,`cate_name`,`parent_id`,`listorder`,`addtime`,`app_name`) values (1,4,'白酒',0,1,1394778856,'wz'),(2,4,'葡萄酒',0,2,1394778873,'wz'),(3,4,'洋酒',0,3,1394778881,'wz'),(4,4,'黄酒',0,4,1394778890,'wz'),(5,4,'保健酒与啤酒',0,5,1394778913,'wz'),(6,4,'茅台',1,1,1394778929,'wz'),(7,4,'洋河',1,2,1394778942,'wz'),(8,4,'中国',2,1,1394778955,'wz'),(9,4,'法国',2,2,1394778965,'wz'),(10,4,'皇家路易',3,1,1394778983,'wz'),(11,4,'轩尼诗',3,2,1394778993,'wz'),(12,4,'石库门',4,1,1394779009,'wz'),(13,4,'女儿红',4,2,1394779018,'wz'),(14,4,'百威',5,1,1394779046,'wz'),(15,4,'青岛',5,2,1394779058,'wz'),(16,4,'喜力',5,3,1394779067,'wz'),(17,4,'劲酒',5,4,1394779076,'wz');

/*Table structure for table `uio_reply` */

DROP TABLE IF EXISTS `uio_reply`;

CREATE TABLE `uio_reply` (
  `reply_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `keyword` varchar(20) DEFAULT NULL,
  `reply` text,
  `reply_type` tinyint(1) DEFAULT NULL,
  `addtime` int(11) DEFAULT NULL,
  PRIMARY KEY (`reply_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `uio_reply` */

insert  into `uio_reply`(`reply_id`,`uid`,`keyword`,`reply`,`reply_type`,`addtime`) values (3,4,'帮助','帮助',0,1396109204),(6,4,'微站',NULL,1,1396148386);

/*Table structure for table `uio_reply_img` */

DROP TABLE IF EXISTS `uio_reply_img`;

CREATE TABLE `uio_reply_img` (
  `img_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `reply_id` int(11) NOT NULL,
  `title` varchar(20) DEFAULT NULL,
  `image` varchar(200) DEFAULT NULL,
  `desc` varchar(100) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `is_first` tinyint(1) DEFAULT NULL,
  `sort` int(11) DEFAULT '0',
  `addtime` int(11) DEFAULT NULL,
  PRIMARY KEY (`img_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `uio_reply_img` */

insert  into `uio_reply_img`(`img_id`,`uid`,`reply_id`,`title`,`image`,`desc`,`url`,`is_first`,`sort`,`addtime`) values (3,4,6,'网页设计','http://itshajia.com/Uploads/User/20140330/1396152133123626.jpg','描述','http://itshajia.com',1,0,1396151557),(4,4,6,'图文回复','http://itshajia.com/Uploads/User/20140330/1396153795117382.jpg','描述','http://itshajia.com',0,2,1396153670),(5,4,6,'让网页舞动起来！25个免费的视差滚动插件','http://itshajia.com/Uploads/User/20140330/1396154073563802.jpg','描述','http://itshajia.com',0,1,1396154091);

/*Table structure for table `uio_shortcuts` */

DROP TABLE IF EXISTS `uio_shortcuts`;

CREATE TABLE `uio_shortcuts` (
  `s_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `resource_id` int(11) NOT NULL,
  PRIMARY KEY (`s_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `uio_shortcuts` */

/*Table structure for table `uio_submenu` */

DROP TABLE IF EXISTS `uio_submenu`;

CREATE TABLE `uio_submenu` (
  `submenu_id` int(11) NOT NULL AUTO_INCREMENT,
  `submenu_name` varchar(32) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `listorder` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`submenu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

/*Data for the table `uio_submenu` */

insert  into `uio_submenu`(`submenu_id`,`submenu_name`,`menu_id`,`listorder`,`status`) values (12,'会员管理',4,1,1),(15,'系统组管理',4,4,1),(16,'平台公告',2,1,1),(17,'站点咨询',2,2,0),(18,'应用管理',6,1,1),(19,'财务管理',6,2,1),(20,'会员组管理',4,2,1),(21,'系统管理',4,3,1);

/*Table structure for table `uio_submenu_resource` */

DROP TABLE IF EXISTS `uio_submenu_resource`;

CREATE TABLE `uio_submenu_resource` (
  `resource_id` int(11) NOT NULL AUTO_INCREMENT,
  `resource_name` varchar(32) NOT NULL,
  `mod` varchar(30) NOT NULL,
  `act` varchar(30) NOT NULL,
  `resource_url` varchar(200) NOT NULL,
  `submenu_id` int(11) NOT NULL,
  `listorder` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`resource_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

/*Data for the table `uio_submenu_resource` */

insert  into `uio_submenu_resource`(`resource_id`,`resource_name`,`mod`,`act`,`resource_url`,`submenu_id`,`listorder`,`status`) values (4,'添加会员','User','add','m=User&a=add',12,1,1),(5,'会员管理','User','userList','m=User&a=userList',12,2,1),(6,'待审核会员','User','nopass','m=User&a=nopass',12,3,1),(7,'系统组管理','Admin','groupList','m=Admin&a=groupList',15,1,1),(8,'添加系统组','Admin','groupAdd','m=Admin&a=groupAdd',15,2,1),(9,'添加公告','Article','announce','m=Article&a=announce&view=add',16,1,1),(11,'公告管理','Article','announce','m=Article&a=announce',16,2,1),(12,'关于站点','Article','about','m=Article&a=about',17,1,1),(13,'应用添加','Application','add','m=Application&a=add',18,1,1),(14,'应用管理','Application','appList','m=Application&a=appList',18,2,1),(15,'购买审核','Application','buyCheck','m=Application&a=buyCheck',19,3,1),(16,'购买记录','Application','buyLog','m=Application&a=buyLog',19,4,1),(17,'应用分类','Application','type','m=Application&a=type',18,3,1),(18,'会员组管理','User','groupList','m=User&a=groupList',20,1,1),(19,'添加会员组','User','groupAdd','m=User&a=groupAdd',20,2,1),(20,'添加管理员','Admin','add','m=Admin&a=add',21,1,1),(21,'管理员管理','Admin','adminList','m=Admin&a=adminList',21,2,1);

/*Table structure for table `uio_user` */

DROP TABLE IF EXISTS `uio_user`;

CREATE TABLE `uio_user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `nickname` varchar(20) NOT NULL,
  `group_id` int(11) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `email` varchar(60) NOT NULL,
  `description` varchar(255) NOT NULL,
  `addtime` int(11) NOT NULL,
  `reg_ip` varchar(20) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `truename` varchar(20) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `company` varchar(50) DEFAULT NULL,
  `wxnumber` varchar(50) NOT NULL,
  `wxpassword` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `uio_user` */

insert  into `uio_user`(`uid`,`username`,`password`,`nickname`,`group_id`,`photo`,`email`,`description`,`addtime`,`reg_ip`,`status`,`truename`,`mobile`,`company`,`wxnumber`,`wxpassword`) values (4,'webchater','96e79218965eb72c92a549dd5a330112','周星',3,'','1224127093@qq.com','',1394156951,'127.0.0.1',1,'周星','','微信团队','IT_shajia','xing843045787');

/*Table structure for table `uio_user_group` */

DROP TABLE IF EXISTS `uio_user_group`;

CREATE TABLE `uio_user_group` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(20) NOT NULL,
  `group_rules` text,
  `uptime` int(11) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `uio_user_group` */

insert  into `uio_user_group`(`group_id`,`group_name`,`group_rules`,`uptime`,`is_admin`) values (1,'管理员','4,5,6,18,19,20,21,7,8,9,11,13,14,17,15,16',1394300259,1),(2,'代理商','4,5,6',1394296464,1),(3,'普通用户',NULL,1390121703,0);

/*Table structure for table `uio_user_info` */

DROP TABLE IF EXISTS `uio_user_info`;

CREATE TABLE `uio_user_info` (
  `info_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `wxnumber` varchar(20) DEFAULT NULL,
  `wxpassword` varchar(20) DEFAULT NULL,
  `erwm` varchar(100) DEFAULT NULL,
  `appId` varchar(100) DEFAULT NULL,
  `appSecret` varchar(100) DEFAULT NULL,
  `company` varchar(20) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `email` varchar(20) DEFAULT NULL,
  `fax` varchar(20) DEFAULT NULL,
  `truename` varchar(20) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `addtime` int(11) DEFAULT NULL,
  PRIMARY KEY (`info_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `uio_user_info` */

insert  into `uio_user_info`(`info_id`,`uid`,`wxnumber`,`wxpassword`,`erwm`,`appId`,`appSecret`,`company`,`mobile`,`tel`,`email`,`fax`,`truename`,`address`,`addtime`) values (8,4,'IT_shajia','xing84304578','http://itshajia.com/Uploads/User/20140329/1396105801194546.jpg','wxd4f98021b9dcfe13','2802ac703a4d6a9406bf0005e541bd50','微信团队','13852757093','4008000800',NULL,'4008000800','周星','广陵区新城信息大道1号(扬州聲谷)11号楼A座2楼 ( 扬州 )',1396105336);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
