--
-- 表的结构 `uio_app_lottery`
--
DROP TABLE IF EXISTS `uio_app_lottery`;
CREATE TABLE IF NOT EXISTS `uio_app_lottery` (
  `lot_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `title` varchar(50),
  `is_open` tinyint(1),
  `sort` int(11) default 0,
  `addtime` int(11),
  PRIMARY KEY (`lot_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 表的结构 `uio_app_lottery_prize`
--
DROP TABLE IF EXISTS `uio_app_lottery_prize`;
CREATE TABLE IF NOT EXISTS `uio_app_lottery_prize` (
  `prize_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `lot_id` int(11),
  `title` varchar(50),
  `content` varchar(200),
  `amount` int(11),
  `sort` int(11) default 0,
  `addtime` int(11),
  PRIMARY KEY (`prize_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 表的结构 `uio_app_lottery_user`
--
DROP TABLE IF EXISTS `uio_app_lottery_user`;
CREATE TABLE IF NOT EXISTS `uio_app_lottery_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `tel` varchar(20),
  `truename` varchar(10),
  `avatar` varchar(200),
  `openid` varchar(100),
  `prize_id` int(11) default 0,
  `lot_id` int(11),
  `addtime` int(11),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;