--
-- 表的结构 `uio_app_wedding`
--
DROP TABLE IF EXISTS `uio_app_wedding`;
CREATE TABLE IF NOT EXISTS `uio_app_wedding` (
  `wed_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `wed_name` varchar(32) NOT NULL,
  `bridegroom` varchar(20) NOT NULL,
  `bride` varchar(20) NOT NULL,
  `wed_date` varchar(20) NOT NULL,
  `wed_time` varchar(20) NOT NULL,
  `bzpoint` varchar(50),
  `address` varchar(200),
  `invitation` text,
  `story` text,
  `tmpl` varchar(20),
  `is_check` tinyint(1) default 1,
  `status` tinyint(1) default 1,
  `addtime` int(11),
  PRIMARY KEY (`wed_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 表的结构 `uio_app_wedding_bless`
--
DROP TABLE IF EXISTS `uio_app_wedding_bless`;
CREATE TABLE IF NOT EXISTS `uio_app_wedding_bless` (
  `bless_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `wed_id` int(11),
  `guest` varchar(20),
  `pnum` varchar(50),
  `message` varchar(100),
  `openid` varchar(100),
  `status` tinyint(1) default 0,
  `is_load` tinyint(1) default 0,
  `addtime` int(11),
  PRIMARY KEY (`bless_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;