SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `lf_action`;
CREATE TABLE `lf_action` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` char(30) NOT NULL DEFAULT '' COMMENT '行为唯一标识',
  `title` char(80) NOT NULL DEFAULT '' COMMENT '行为说明',
  `remark` char(140) NOT NULL DEFAULT '' COMMENT '行为描述',
  `rule` text COMMENT '行为规则',
  `log` text COMMENT '日志规则',
  `type` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '类型',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='系统行为表';


INSERT INTO `lf_action` VALUES (1,'admin_login','管理员登陆','管理员登陆','','管理员[user|get_member_name]登录了后台',1,1,1433910200);
INSERT INTO `lf_action` VALUES (2,'admin_logout','管理员退出','管理员退出','','管理员[user|get_member_name]退出了后台',1,1,1380173180);
INSERT INTO `lf_action` VALUES (3,'update_config','更新配置','更新配置','table:member|field:score|condition:uid={$self}|rule:score+1','',1,1,1383285646);
INSERT INTO `lf_action` VALUES (4,'update_sys','更新系统','更新系统','','系统升级至版本：[model]',1,1,1433913086);
INSERT INTO `lf_action` VALUES (5,'delete_log','清空日志','清空日志','','保留从[time|time_format]起一周日志数据其余全部清除',1,1,1433913944);
INSERT INTO `lf_action` VALUES (6,'add_admin','新增管理员','新增管理员','','新增管理员：[record|get_member_name]',1,1,1433914139);
INSERT INTO `lf_action` VALUES (7,'update_admin','更新管理员','更新管理员','','更新管理员：[record|get_member_name]',1,1,1383295057);
INSERT INTO `lf_action` VALUES (8,'delete_admin','删除管理员','删除管理员','','删除管理员记录编号[record]',1,1,1433915933);
INSERT INTO `lf_action` VALUES (9,'add_player','新增播放器','新增播放器','','新增播放器记录编号[record]',1,1,1383296301);
INSERT INTO `lf_action` VALUES (10,'update_player','更新播放器','更新播放器','','更新播放器记录编号[record]',1,1,1383296392);
INSERT INTO `lf_action` VALUES (11,'delete_player','删除播放器','删除播放器','','删除播放器记录编号[record]',1,1,1383296765);
INSERT INTO `lf_action` VALUES (12,'add_player','新增播放器','新增播放器','','新增播放器记录编号[record]',1,1,1383296301);
INSERT INTO `lf_action` VALUES (13,'delete_player','删除播放器','删除播放器','','删除播放器记录编号[record]',1,1,1383296301);
INSERT INTO `lf_action` VALUES (14,'update_player','更新播放器','更新播放器','','更新播放器记录编号[record]',1,1,0);
INSERT INTO `lf_action` VALUES (15,'backup_data','备份数据库表','备份数据库表','','备份数据库表[record]',1,1,0);
INSERT INTO `lf_action` VALUES (16,'optimize_data','优化数据库表','优化数据库表','','优化数据库表[record]',1,1,0);
INSERT INTO `lf_action` VALUES (17,'repair_data','修复数据库表','修复数据库表','','修复数据库表[record]',1,1,0);
INSERT INTO `lf_action` VALUES (18,'restore_data','还原数据库备份','还原数据库备份','','还原数据库备份[record]',1,1,0);
INSERT INTO `lf_action` VALUES (19,'delete_data','删除备份数据库','删除备份数据库','','删除备份数据库[record]',1,1,0);
INSERT INTO `lf_action` VALUES (20,'add_link','新增友情链接','新增友情链接','','新增友情链接记录编号[record]',1,1,0);
INSERT INTO `lf_action` VALUES (21,'update_link','更新友情链接','更新友情链接','','更新友情链接记录编号[record]',1,1,0);
INSERT INTO `lf_action` VALUES (22,'delete_link','删除友情链接','删除友情链接','','删除友情链接记录编号[record]',1,1,0);
INSERT INTO `lf_action` VALUES (23,'add_ad','新增广告','新增广告','','新增广告记录编号[record]',1,1,0);
INSERT INTO `lf_action` VALUES (24,'update_ad','更新广告','更新广告','','更新广告记录编号[record]',1,1,0);
INSERT INTO `lf_action` VALUES (25,'delete_ad','删除广告','删除广告','','删除广告记录编号[record]',1,1,0);
INSERT INTO `lf_action` VALUES (26,'add_category','新增分类','新增分类','','新增分类记录编号[record]',1,1,0);
INSERT INTO `lf_action` VALUES (27,'update_category','更新分类','更新分类','','更新分类记录编号[record]',1,1,0);
INSERT INTO `lf_action` VALUES (28,'del_category','删除分类','删除分类','','删除分类记录编号[record]',1,1,0);
INSERT INTO `lf_action` VALUES (29,'move_category','移动分类','移动分类','','移动分类记录编号[record]',1,1,0);
INSERT INTO `lf_action` VALUES (30,'merge_category','合并分类','合并分类','','合并分类记录编号[record]',1,1,0);
INSERT INTO `lf_action` VALUES (31,'add_movie','新增影片','新增影片','','新增影片编号[record]',1,1,0);
INSERT INTO `lf_action` VALUES (32,'update_movie','更新影片','更新影片','','更新影片记录编号[record]',1,1,0);
INSERT INTO `lf_action` VALUES (33,'del_movie','删除影片','删除影片','','删除影片编号[record]',1,1,0);
INSERT INTO `lf_action` VALUES (34,'add_news','新增文章','新增文章','','新增文章编号[record]',1,1,0);
INSERT INTO `lf_action` VALUES (35,'update_news','更新文章','更新文章','','更新文章编号[record]',1,1,0);
INSERT INTO `lf_action` VALUES (36,'del_news','删除文章','删除文章','','删除影片编号[record]',1,1,0);
INSERT INTO `lf_action` VALUES (37,'add_user','新增用户','新增用户','','新增用户编号[record]',1,1,0);
INSERT INTO `lf_action` VALUES (38,'update_user','更新用户','更新用户','','更新用户编号[record]',1,1,0);
INSERT INTO `lf_action` VALUES (39,'del_user','删除用户','删除用户','','删除用户编号[record]',1,1,0);
INSERT INTO `lf_action` VALUES (40,'add_prize','新增奖品','新增奖品','','新增奖品编号[record]',1,1,0);
INSERT INTO `lf_action` VALUES (41,'update_prize','更新奖品','更新奖品','','更新奖品编号[record]',1,1,0);
INSERT INTO `lf_action` VALUES (42,'del_prize','删除奖品','删除奖品','','删除奖品编号[record]',1,1,0);
INSERT INTO `lf_action` VALUES (43,'cancel_prize','取消兑奖','取消交易','','取消交易编号[record]',1,1,0);
INSERT INTO `lf_action` VALUES (44,'delivery_prize','兑奖发货','兑奖发货','','兑奖发货编号[record]',1,1,0);
INSERT INTO `lf_action` VALUES (45,'update_tpl','编辑模板','编辑模板','','编辑模板文件[record]',1,1,0);
INSERT INTO `lf_action` VALUES (46,'config_tpl','设置模板','设置模板','','设置模板[record]',1,1,0);
INSERT INTO `lf_action` VALUES (47,'users_sign','用户签到','用户签到','','签到用户[user|get_user_name] 签到时间[time] 签到积分[record]',2,1,1435454214);
INSERT INTO `lf_action` VALUES (48,'users_rlink','用户推广','用户推广','','推广用户[user|get_user_name] 推广时间[time] 推广积分[record]',2,1,0);
INSERT INTO `lf_action` VALUES (49,'users_play','看片积分','看片积分','','积分用户[user|get_user_name] 积分时间[time] 积分[record]',2,1,0);
INSERT INTO `lf_action` VALUES (50,'del_message','清除消息','清除消息','','清除已看消息',1,1,0);
INSERT INTO `lf_action` VALUES (51,'add_message','发送消息','发送消息',NULL,'发送消息类型[record]',1,0,0);
INSERT INTO `lf_action` VALUES (52,'users_addtime','增加vip时间','增加vip时间','','增加用户[record|get_user_name]-vip时间',1,1,0);

DROP TABLE IF EXISTS `lf_action_log`;
CREATE TABLE `lf_action_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `type` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '类型',
  `action_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '行为id',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '执行用户id',
  `action_ip` bigint(20) NOT NULL COMMENT '执行行为者ip',
  `model` varchar(255) NOT NULL DEFAULT '' COMMENT '触发行为的表',
  `record_id` varchar(255) NOT NULL DEFAULT '0' COMMENT '触发行为的数据id',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '日志备注',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '执行行为的时间',
  PRIMARY KEY (`id`),
  KEY `action_ip_ix` (`action_ip`),
  KEY `action_id_ix` (`action_id`),
  KEY `user_id_ix` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='行为日志表';

DROP TABLE IF EXISTS `lf_ad`;
CREATE TABLE `lf_ad` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '数据状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `lf_ad` VALUES (1,'377x100','index_377x100',1),(2,'779x100','index_779x100',1),(3,'1180x100','type_1180x100',1),(4,'840x100','movie_840x100',1),(5,'295x100','player_295x100',1);


DROP TABLE IF EXISTS `lf_addons`;
CREATE TABLE `lf_addons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(40) NOT NULL COMMENT '插件名或标识',
  `title` varchar(20) NOT NULL DEFAULT '' COMMENT '中文名',
  `description` text COMMENT '插件描述',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `config` text COMMENT '配置',
  `author` varchar(40) DEFAULT '' COMMENT '作者',
  `version` varchar(20) DEFAULT '' COMMENT '版本号',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '安装时间',
  `has_adminlist` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否有后台列表',
  `has_hook` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否钩子插件',
  `group` varchar(30) DEFAULT NULL COMMENT '配置分组',
  `mold` varchar(50) NOT NULL DEFAULT '' COMMENT '类型',
  `exclusive` tinyint(1) unsigned DEFAULT '0' COMMENT '排他',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序（同级有效）',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='插件表';


DROP TABLE IF EXISTS `lf_card`;
CREATE TABLE `lf_card` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(32) NOT NULL DEFAULT '',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  `uid` int(11) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(2) NOT NULL DEFAULT '1',
  `type` tinyint(2) unsigned DEFAULT '0',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `time` int(11) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=91 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='卡表';

DROP TABLE IF EXISTS `lf_category`;
CREATE TABLE `lf_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类ID',
  `name` varchar(30) NOT NULL COMMENT '标志',
  `title` varchar(50) NOT NULL COMMENT '标题',
  `icon` char(100) DEFAULT NULL COMMENT '图标',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '分类模型',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序（同级有效）',
  `display` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '可见性',
  `meta_title` varchar(50) NOT NULL DEFAULT '' COMMENT 'SEO的网页标题',
  `keywords` varchar(255) NOT NULL DEFAULT '' COMMENT '关键字',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `template_index` varchar(100) NOT NULL COMMENT '频道页模板',
  `template_detail` varchar(100) NOT NULL COMMENT '详情页模板',
  `template_play` varchar(100) DEFAULT NULL COMMENT '播放页模板',
  `template_type` varchar(100) DEFAULT NULL COMMENT '筛选页模板',
  `link` varchar(100) DEFAULT NULL COMMENT '外链',
  `extend` text NOT NULL COMMENT '扩展设置',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '数据状态',
  `record` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '播放记录',
  `private` tinyint(3) unsigned DEFAULT '0' COMMENT '私人收藏',
  `navno` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '是否在导航显示',
  `appno` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否在app显示',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_name` (`name`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=103 DEFAULT CHARSET=utf8 COMMENT='分类表';


INSERT INTO `lf_category` VALUES (2,'dianshiju','电视剧','icons-tvshow',0,1,1,1,'','','','type.html','movie.html','player.html','lists.html','0','',1379475028,1419759684,1,1,0,1,1),(3,'xiju','喜剧',NULL,4,1,2,1,'','','','lists.html','','','','0','',1379475028,1502247304,1,1,0,1,1),(4,'film','电影','icons-movie',0,1,0,1,'','','','type.html','movie.html','player.html','lists.html','0','',1379474947,1432516372,1,1,0,1,1),(43,'aiqing','爱情',NULL,4,1,6,1,'','','','lists.html','','','','','',1419759483,1502247319,1,1,0,1,1),(44,'dongzuo','动作',NULL,4,1,1,1,'','','','lists.html','','','','','',1419759519,1502247301,1,1,0,1,1),(46,'kehuan','科幻',NULL,4,1,3,1,'','','','lists.html','','','','','',1419759609,1502247307,1,1,0,1,1),(49,'gtgz','国产剧',NULL,2,1,1,1,'','','','lists.html','','','','','',1419759738,1487929937,1,1,0,1,1),(51,'tvbjc','港台剧',NULL,2,1,2,1,'','','','lists.html','','','','','',1419759787,1487929946,1,1,0,1,1),(53,'myrj','欧美剧',NULL,2,1,4,1,'','','','lists.html','','','','','',1419759869,1487929959,1,1,0,1,1),(54,'rhzq','日韩剧',NULL,2,1,3,1,'','','','lists.html','','','','','',1419759900,1487929952,1,1,0,1,1),(55,'dongman','动漫','icons-dongman',0,1,2,1,'','','','lists.html','movie.html','player.html','lists.html','','',1419759920,1419759934,1,1,0,1,1),(56,'zhongyi','综艺','icons-zongyi',0,1,3,1,'','','','lists.html','movie.html','player.html','lists.html','','',1419759963,1419759963,1,1,0,1,1),(59,'inform','资讯',NULL,0,2,6,1,'','','','newslists.html','news.html','','','','',1419760039,1488099914,1,1,0,1,0),(64,'kongbu','恐怖','',4,1,4,1,'','','','lists.html','','','','','',1487929488,1502247309,1,1,0,1,1),(66,'juqing','剧情',NULL,4,1,5,1,'','','','lists.html','','','','','',1487929737,1502247312,1,1,0,1,1),(67,'zhanzheng','战争',NULL,4,1,7,1,'','','','lists.html','','','','','',1487929764,1502247324,1,1,0,1,1),(78,'lunli','伦理','',4,1,8,1,'','','','lists.html','','','','','',1487930424,1502247326,1,1,0,1,1),(101,'notice','公告',NULL,0,2,7,1,'','','','newslists.html','news.html','','','','',1488079861,1488079882,1,1,0,0,0),(102,'help','帮助',NULL,0,2,8,1,'','','','newslists.html','news.html','','','','',1488079914,1488079914,1,1,0,0,0);

DROP TABLE IF EXISTS `lf_comment`;
CREATE TABLE `lf_comment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  `uid` int(11) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(2) NOT NULL DEFAULT '1',
  `up` int(11) unsigned DEFAULT '0',
  `pid` int(11) unsigned DEFAULT '0',
  `mid` int(11) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='评论表';


DROP TABLE IF EXISTS `lf_config`;
CREATE TABLE `lf_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '配置ID',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '配置名称',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '配置类型',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '配置说明',
  `group` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '配置分组',
  `extra` varchar(255) NOT NULL DEFAULT '' COMMENT '配置值',
  `remark` varchar(100) NOT NULL COMMENT '配置说明',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `value` text NOT NULL COMMENT '配置值',
  `sort` smallint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `display` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '可见性',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_name` (`name`),
  KEY `type` (`type`),
  KEY `group` (`group`)
) ENGINE=MyISAM AUTO_INCREMENT=93 DEFAULT CHARSET=utf8;


INSERT INTO `lf_config` VALUES (1,'WEB_SITE_TITLE',1,'网站标题',1,'','网站标题前台显示标题',1378898976,1379235274,'lfdycms',4,1),(2,'WEB_SITE_DESCRIPTION',2,'网站描述',1,'','网站搜索引擎描述',1378898976,1379235841,'lfdycms',5,1),(3,'WEB_SITE_KEYWORD',2,'网站关键字',1,'','网站搜索引擎关键字',1378898976,1381390100,'lfdycms',6,1),(4,'WEB_SITE_CLOSE',4,'关闭站点',1,'0:关闭\r\n1:开启','站点关闭后其他用户不能访问，管理员可以正常访问',1378898976,1379235296,'1',0,1),(10,'WEB_SITE_ICP',1,'网站备案号',1,'','设置在网站底部显示的备案号，如“沪ICP备12007941号-2',1378900335,1379235859,'123',7,1),(11,'DOCUMENT_POSITION',3,'文档推荐位',2,'','文档推荐位，推荐到多个位置KEY值相加即可',1379053380,1379235329,'1:列表页推荐\r\n2:频道页推荐\r\n4:首页推荐',3,0),(20,'CONFIG_GROUP_LIST',3,'配置分组',4,'','配置分组',1379228036,1384418383,'1:基本\r\n2:内容\r\n3:用户\r\n4:系统\r\n5:UCenter\r\n6:邮件',4,0),(25,'LIST_ROWS',0,'后台每页记录数',2,'','后台数据每页显示记录数',1379503896,1380427745,'20',10,1),(26,'USER_ALLOW_REGISTER',4,'是否允许用户注册',3,'0:关闭注册\r\n1:允许注册','是否开放用户注册',1379504487,1379504580,'1',0,1),(28,'DATA_BACKUP_PATH',1,'数据库备份根路径',4,'','路径必须以 / 结尾',1381482411,1381482411,'./Data/',8,1),(29,'DATA_BACKUP_PART_SIZE',0,'数据库备份卷大小',4,'','该值用于限制压缩后的分卷最大长度。单位：B；建议设置20M',1381482488,1381729564,'20971520',9,1),(30,'DATA_BACKUP_COMPRESS',4,'数据库备份文件是否启用压缩',4,'0:不压缩\r\n1:启用压缩','压缩备份文件需要PHP环境支持gzopen,gzwrite函数',1381713345,1381729544,'1',10,1),(31,'DATA_BACKUP_COMPRESS_LEVEL',4,'数据库备份文件压缩级别',4,'1:普通\r\n4:一般\r\n9:最高','数据库备份文件的压缩级别，该配置在开启压缩时生效',1381713408,1381713408,'9',11,1),(37,'SHOW_PAGE_TRACE',4,'是否显示页面Trace',4,'0:关闭\r\n1:开启','是否显示页面Trace信息',1387165685,1387165685,'0',1,0),(38,'MOVIE_AREA',3,'影片地区',2,'','',1379056370,1379235322,'1:大陆\r\n2:港台\r\n3:日韩\r\n4:欧美\r\n5:新马泰\r\n6:其他',4,1),(39,'MOVIE_LANGUAGE',3,'影片语言',2,'','',0,0,'1:国语\r\n2:英语\r\n3:日语\r\n4:韩语\r\n5:法语\r\n6:俄语\r\n7:德语\r\n8:西班牙语\r\n9:粤语\r\n10:闽南语',0,1),(40,'MOVIE_YEAR',3,'影片年份',2,'','',0,0,'22:2017\r\n21:2016\r\n20:2015\r\n0:2014\r\n1:2013\r\n2:2012\r\n3:2011\r\n4:2010\r\n5:2009\r\n6:2008\r\n7:2007\r\n8:2006\r\n9:2005\r\n10:2004\r\n11:2003\r\n12:2002\r\n13:2001\r\n14:2000\r\n15:1990\r\n16:1980\r\n17:1970\r\n18:1960\r\n19:1950',0,1),(41,'COLLECT_URL',4,'联盟列表地址',1,'','',0,0,'http://www.lfdycms.com/index.php?s=/Home/ajax/unionUrl',0,0),(42,'COLLECT_DOWN_IMG',4,'采集图片保存',4,'0:后期保存\r\n1:直接保存','采集时图片保存设置',0,0,'0',12,1),(44,'WEB_PATTEM',4,'网站运行模式',4,'1:动态\r\n3:伪静态','',0,0,'1',2,1),(48,'WEB_URL',1,'网站地址',1,'','网站域名地址',0,0,'http://www.lfdycms.com',2,1),(49,'WEB_NAME',1,'网站名称',1,'','网站名称',0,0,'lfdycms',1,1),(50,'TPL_PATH',0,'前台模板目录',1,'','',0,0,'Template/',0,0),(51,'DEFAULT_WAP_TPl',0,'WAP前台默认模板',1,'','',0,0,'',0,0),(52,'DEFAULT_WEB_TPl',0,'WEB前台默认模板',1,'','',0,0,'greendvd',0,0),(54,'WEB_LOGO',1,'网站logo',1,'','',0,0,'logo.png',3,1),(57,'USER_ALLOW_SIGN',4,'是否允许用户签到',3,'0:关闭签到\r\n1:允许签到','',0,0,'1',1,1),(58,'USER_SIGN_1',0,'第一天签到积分',3,'','',0,0,'20',2,1),(59,'USER_SIGN_2',0,'第二天签到积分',3,'','',0,0,'30',3,1),(60,'USER_SIGN_3',0,'第三天签到积分',3,'','',0,0,'40',4,1),(61,'USER_SIGN_4',0,'第四天签到积分',3,'','',0,0,'50',5,1),(62,'USER_SIGN_5',0,'第五天签到积分',3,'','',0,0,'60',6,1),(63,'USER_SIGN_6',0,'第六天签到积分',3,'','',0,0,'70',7,1),(64,'USER_SIGN_7',0,'第七天签到积分',3,'','',0,0,'100',8,1),(65,'USER_ALLOW_RLINK',4,'是否允许用户推广',3,'0:关闭推广\r\n1:允许推广','',0,0,'1',9,1),(66,'USER_RLINK',0,'推广积分',3,'','',0,0,'10',10,1),(67,'USER_ALLOW_PLAY',4,'是否允许看片赚积分',3,'0:关闭看片积分\r\n1:允许看片积分','',0,0,'1',12,1),(68,'USER_PLAY',0,'看片积分',3,'','',0,0,'10',14,1),(69,'USER_PLAY_TIME',0,'积分赚取间隔时间',3,'','单位分钟',0,0,'30',13,1),(70,'USER_RLINK_COUNT',0,'每日推广数量',3,'','',0,0,'30',11,1),(71,'USER_PLAY_COUNT',0,'每日看片积分数量',3,'','最多数量',0,0,'30',15,1),(72,'FACE_ARRAY',3,'表情数组',4,'','',0,0,'face[微笑]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/5c/huanglianwx_thumb.gif\r\nface[嘻嘻]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/0b/tootha_thumb.gif\r\nface[哈哈]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/6a/laugh.gif\r\nface[可爱]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/14/tza_thumb.gif\r\nface[可怜]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/af/kl_thumb.gif\r\nface[挖鼻]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/0b/wabi_thumb.gif\r\nface[吃惊]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/f4/cj_thumb.gif\r\nface[害羞]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/6e/shamea_thumb.gif\r\nface[挤眼]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/c3/zy_thumb.gif\r\nface[闭嘴]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/29/bz_thumb.gif\r\nface[鄙视]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/71/bs2_thumb.gif\r\nface[爱你]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/6d/lovea_thumb.gif\r\nface[泪]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/9d/sada_thumb.gif\r\nface[偷笑]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/19/heia_thumb.gif\r\nface[亲亲]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/8f/qq_thumb.gif\r\nface[生病]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/b6/sb_thumb.gif\r\nface[太开心]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/58/mb_thumb.gif\r\nface[白眼]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/d9/landeln_thumb.gif\r\nface[右哼哼]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/98/yhh_thumb.gif\r\nface[左哼哼]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/6d/zhh_thumb.gif\r\nface[嘘]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/a6/x_thumb.gif\r\nface[衰]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/af/cry.gif\r\nface[委屈]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/73/wq_thumb.gif\r\nface[吐]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/9e/t_thumb.gif\r\nface[哈欠]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/cc/haqianv2_thumb.gif\r\nface[抱抱]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/27/bba_thumb.gif\r\nface[怒]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/7c/angrya_thumb.gif\r\nface[疑问]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/5c/yw_thumb.gif\r\nface[馋嘴]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/a5/cza_thumb.gif\r\nface[拜拜]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/70/88_thumb.gif\r\nface[思考]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/e9/sk_thumb.gif\r\nface[汗]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/24/sweata_thumb.gif\r\nface[困]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/40/kunv2_thumb.gif\r\nface[睡]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/96/huangliansj_thumb.gif\r\nface[钱]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/90/money_thumb.gif\r\nface[失望]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/0c/sw_thumb.gif\r\nface[酷]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/40/cool_thumb.gif\r\nface[色]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/20/huanglianse_thumb.gif\r\nface[哼]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/49/hatea_thumb.gif\r\nface[鼓掌]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/36/gza_thumb.gif\r\nface[晕]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/d9/dizzya_thumb.gif\r\nface[悲伤]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/1a/bs_thumb.gif\r\nface[抓狂]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/62/crazya_thumb.gif\r\nface[黑线]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/91/h_thumb.gif\r\nface[阴险]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/6d/yx_thumb.gif\r\nface[怒骂]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/60/numav2_thumb.gif\r\nface[互粉]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/89/hufen_thumb.gif\r\nface[心]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/40/hearta_thumb.gif\r\nface[伤心]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/ea/unheart.gif\r\nface[猪头]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/58/pig.gif\r\nface[熊猫]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/6e/panda_thumb.gif\r\nface[兔子]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/81/rabbit_thumb.gif\r\nface[ok]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/d6/ok_thumb.gif\r\nface[耶]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/d9/ye_thumb.gif\r\nface[good]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/d8/good_thumb.gif\r\nface[NO]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/ae/buyao_org.gif\r\nface[赞]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/d0/z2_thumb.gif\r\nface[来]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/40/come_thumb.gif\r\nface[弱]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/d8/sad_thumb.gif\r\nface[草泥马]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/7a/shenshou_thumb.gif\r\nface[神马]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/60/horse2_thumb.gif\r\nface[囧]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/15/j_thumb.gif\r\nface[浮云]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/bc/fuyun_thumb.gif\r\nface[给力]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/1e/geiliv2_thumb.gif\r\nface[围观]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/f2/wg_thumb.gif\r\nface[威武]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/70/vw_thumb.gif\r\nface[奥特曼]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/bc/otm_thumb.gif\r\nface[礼物]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/c4/liwu_thumb.gif\r\nface[钟]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/d3/clock_thumb.gif\r\nface[话筒]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/9f/huatongv2_thumb.gif\r\nface[蜡烛]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/d9/lazhuv2_thumb.gif\r\nface[蛋糕]:img.t.sinajs.cn/t4/appstyle/expression/ext/normal/3a/cakev2_thumb.gif',12,0),(73,'COMMENT_KEY',5,'评论敏感词',2,'','过滤评论敏感词',0,0,'http://\r\nwww\r\nqq',9,1),(74,'BBS_KEY',1,'通信密钥',5,'','通信密钥',0,0,'movie',2,1),(75,'BBS_URL',1,'UCenter URL',5,'','通讯地址',0,0,'http://bbs.movie.com',0,1),(76,'BBS_APIID',1,'UCenter APPID',5,'','APPID',0,0,'2',1,1),(77,'MAIL_HOST',1,'smtp服务器的名称',6,'','',0,0,'smtp.qq.com',1,1),(78,'MAIL_SMTPAUTH',4,'启用smtp认证',6,'0:关闭\r\n1:开启','',0,0,'1',2,1),(79,'MAIL_USERNAME',1,'邮箱名',6,'','',0,0,'kf@lfdycms.com',3,1),(80,'MAIL_PASSWORD',1,'邮箱密码',6,'','',0,0,'Kfqwer1',4,1),(81,'MAIL_FROM',1,'发件人地址',6,'','',0,0,'kf@lfdycms.com',5,1),(82,'MAIL_FROMNAME',1,'发件人姓名',6,'','',0,0,'雷风影视',6,1),(83,'MAIL_ISHTML',4,'是否HTML格式邮件',0,'0:关闭\r\n1:开启','',0,0,'',7,1),(84,'MAIL_CHARSET',1,'设置邮件编码',6,'','',0,0,'utf-8',8,1),(85,'IMAGE_WATER_ON',4,'图片水印',4,'0:关闭\r\n1:开启','',0,0,'1',13,1),(86,'IMAGE_WATER_POSITION',4,'水印位置',4,'1:左上角\r\n2:上居中\r\n3:右上角\r\n4:左居中\r\n5:居中\r\n6:右居中\r\n7:左下角\r\n8:下居中\r\n9:右下角','',0,0,'9',14,1),(87,'IMAGE_WATER_PIC',1,'水印图片',4,'','',0,0,'./Public/static/shui.png',14,1),(88,'WEB_VERSION',1,'程序版本',1,'','',0,0,'3.4.0',8,1),(89,'UPDATE_URL',0,'升级地址',0,'','',0,0,'http://www.lfdycms.com',0,0),(91,'USER_REG_VIP',4,'是否注册赠送VIP',3,'0:关闭\r\n1:开启','',0,0,'0',16,1),(90,'BBS_ON',4,'UCenter对接开关',5,'0:关闭\r\n1:开启','',0,0,'0',3,1),(92,'USER_REG_VIP_TIME',0,'赠送时间',3,'','单位天',0,0,'30',17,1);

DROP TABLE IF EXISTS `lf_exchange`;
CREATE TABLE `lf_exchange` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usersname` varchar(255) NOT NULL DEFAULT '',
  `uid` int(11) NOT NULL DEFAULT '0',
  `pid` int(11) NOT NULL DEFAULT '0',
  `integral` int(11) NOT NULL DEFAULT '0',
  `qq` int(11) NOT NULL DEFAULT '0',
  `tel` int(11) NOT NULL DEFAULT '0',
  `address` varchar(255) DEFAULT NULL,
  `remarks` text,
  `mode` tinyint(1) NOT NULL DEFAULT '0',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `lf_favorites`;
CREATE TABLE `lf_favorites` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '收藏者ID',
  `mid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '对应影片id',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '类型',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `mid` (`mid`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8 COMMENT='收藏表';

DROP TABLE IF EXISTS `lf_link`;
CREATE TABLE `lf_link` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `sort` smallint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '数据状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;


INSERT INTO `lf_link` VALUES (1,'雷风影视','http://www.lfdycms.com',1,1);

DROP TABLE IF EXISTS `lf_member`;
CREATE TABLE `lf_member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `username` char(16) DEFAULT NULL COMMENT '用户名',
  `password` char(32) DEFAULT NULL COMMENT '密码',
  `login` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登录次数',
  `last_login_ip` bigint(20) NOT NULL DEFAULT '0' COMMENT '最后登录IP',
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '用户状态',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='会员表';


DROP TABLE IF EXISTS `lf_menu`;
CREATE TABLE `lf_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文档ID',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '标题',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序（同级有效）',
  `url` char(255) NOT NULL DEFAULT '' COMMENT '链接地址',
  `hide` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否隐藏',
  `tip` varchar(255) NOT NULL DEFAULT '' COMMENT '提示',
  `group` varchar(50) DEFAULT '' COMMENT '分组',
  `icon` varchar(50) DEFAULT NULL COMMENT '图标',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=68 DEFAULT CHARSET=utf8;


INSERT INTO `lf_menu` VALUES (1,'系统信息',2,0,'Index/index',0,'','系统','icon-home'),(2,'系统',0,2,'Config/group',0,'','','icon-cog'),(3,'内容',0,3,'Movie/index',0,'','','icon-book'),(4,'用户',0,5,'Users/index',0,'','','icon-user'),(5,'模板',0,6,'Template/index',0,'','','icon-file'),(6,'采集',0,7,'Collect/index',0,'','','icon-magnet'),(7,'扩展',0,8,'Addons/index',0,'','','icon-puzzle-piece'),(8,'系统设置',2,0,'Config/group',0,'','系统',''),(9,'管理员管理',2,1,'Member/index',0,'','管理员',''),(10,'管理员添加',2,0,'Member/add',0,'','管理员',''),(11,'播放器添加',2,0,'Player/add',0,'','播放器',''),(12,'播放器管理',2,0,'Player/index',0,'','播放器',''),(13,'日志管理',2,0,'Action/index',0,'','系统',''),(14,'备份数据库',2,0,'Database/index?type=export',0,'','数据库',''),(15,'还原数据库',2,0,'Database/index?type=import',0,'','数据库',''),(16,'修改管理员密码',2,0,'Member/edit',1,'','管理员',''),(17,'修改播放器',2,0,'Player/edit',1,'','播放器',''),(18,'分类管理',3,1,'Category/index',0,'','分类',''),(19,'分类添加',3,0,'Category/add',0,'','分类',''),(20,'分类修改',3,0,'Category/edit',1,'','分类',''),(21,'分类合并',3,0,'Category/operate',1,'','分类',''),(22,'影片管理',3,3,'Movie/index',0,'','影片',''),(23,'影片添加',3,2,'Movie/add',0,'','影片',''),(24,'影片修改',3,0,'Movie/edit',1,'','影片',''),(25,'一键采集',6,0,'Collect/index',0,'','采集',''),(26,'绑定播放器',6,0,'Collect/listplay',0,'','采集',''),(27,'采集列表',6,0,'Collect/lists',1,'','采集',''),(28,'友情链接管理',2,2,'Link/index',0,'','链接',''),(29,'友情链接添加',2,0,'Link/add',0,'','链接',''),(30,'修改友情链接',2,0,'Link/edit',1,'','链接',''),(33,'下载远程图片',6,0,'Collect/downpic',0,'','采集',''),(34,'模板管理',5,0,'Template/index',0,'','模板',''),(35,'添加文章',3,6,'News/add',0,'','文章',''),(36,'文章管理',3,7,'News/index',0,'','文章',''),(37,'文章修改',3,0,'News/edit',1,'','文章',''),(38,'广告添加',2,0,'Ad/add',0,'','广告',''),(39,'广告管理',2,0,'Ad/index',0,'','广告',''),(40,'广告修改',2,0,'Ad/edit',1,'','广告',''),(41,'插件管理',7,0,'Addons/index',1,'','插件',''),(42,'在线升级',2,0,'Update/index',0,'','系统',NULL),(43,'插件设置',7,0,'Addons/config',1,'','插件',''),(44,'插件添加',7,0,'Addons/create',1,'','插件',''),(45,'模板编辑',5,0,'Template/edit',1,'','模板',''),(47,'模板设置',5,1,'Template/config',0,'','模板',''),(48,'清除缓存',2,0,'Index/cache',1,'','缓存',''),(49,'用户管理',4,1,'Users/index',0,'','用户管理',''),(50,'用户添加',4,0,'Users/add',0,'','用户管理',''),(51,'奖品添加',4,0,'Prize/add',0,'','奖品管理',''),(52,'奖品管理',4,1,'Prize/index',0,'','奖品管理',''),(53,'兑奖管理',4,2,'Prize/exchange',0,'','奖品管理',''),(54,'用户修改',4,0,'Users/edit',1,'','用户管理',''),(55,'奖品修改',4,0,'Prize/edit',1,'','奖品管理',''),(56,'消息管理',4,0,'Message/index',0,'','消息管理',NULL),(57,'评论管理',3,4,'Comment/index',0,'','影片',NULL),(58,'充值',0,7,'Card/index',0,'','','icon-money'),(59,'充值卡管理',58,0,'Card/index',0,'','充值卡',NULL),(60,'生成充值卡',58,0,'Card/add',1,'','生成充值卡',NULL),(64,'幻灯管理',3,5,'Slider/index',0,'','幻灯',NULL),(65,'幻灯添加',3,4,'Slider/add',0,'','幻灯',NULL),(66,'幻灯修改',3,0,'Slider/edit',1,'','幻灯',NULL),(68,'采集联盟添加',6,0,'Collect/add',1,'','采集',NULL),(69,'采集联盟修改',6,0,'Collect/edit',1,'','采集',NULL),(70,'清空数据',7,0,'Tool/remove',0,'','工具',NULL),(71,'日志',2,0,'Action/action',1,'','系统',NULL),(72,'数据替换',7,0,'Tool/replace',0,'','工具',NULL),(73,'随机数据',7,0,'Tool/random',0,'','工具',NULL),(74,'路由管理',2,1,'Route/index',1,'','路由',NULL),(75,'路由添加',2,0,'Route/add',1,'','路由',NULL),(76,'路由修改',2,0,'Route/edit',1,'','路由',NULL),(77,'插件管理',7,0,'Addons/index',0,'','插件',NULL);

DROP TABLE IF EXISTS `lf_message`;
CREATE TABLE `lf_message` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `to_uid` int(11) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '0系统消息,1用户消息',
  `is_read` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `uid` int(11) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='消息表';

DROP TABLE IF EXISTS `lf_movie`;
CREATE TABLE `lf_movie` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属分类',
  `title` char(80) NOT NULL DEFAULT '' COMMENT '名称',
  `actors` char(120) DEFAULT NULL COMMENT '演员',
  `area` char(20) DEFAULT NULL COMMENT '地区',
  `language` char(20) DEFAULT NULL COMMENT '语言',
  `year` year(4) DEFAULT NULL COMMENT '年份',
  `cover_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '封面',
  `content` text COMMENT '介绍',
  `display` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '可见性',
  `position` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '推荐位',
  `up` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '顶',
  `down` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '踩',
  `also_known_as` char(80) DEFAULT NULL COMMENT '别名',
  `hits` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '浏览数量',
  `rating` decimal(2,1) unsigned NOT NULL DEFAULT '0.0' COMMENT '评分',
  `rating_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '评分人数',
  `directors` char(120) DEFAULT NULL COMMENT '导演',
  `serialize` char(50) DEFAULT NULL COMMENT '连载',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态',
  `reurl` char(255) DEFAULT NULL COMMENT '来源',
  `pinyin` char(5) DEFAULT NULL COMMENT '拼音',
  `favorites_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '收藏人数',
  `tj_tag` tinyint(3) DEFAULT '0' COMMENT '推荐标签',
  `collect_updata` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `title` (`title`),
  KEY `actors` (`actors`),
  KEY `area` (`area`),
  KEY `language` (`language`),
  KEY `year` (`year`),
  KEY `status` (`status`),
  KEY `directors` (`directors`)
) ENGINE=MyISAM AUTO_INCREMENT=27844 DEFAULT CHARSET=utf8 COMMENT='影片表';

DROP TABLE IF EXISTS `lf_movie_url`;
CREATE TABLE `lf_movie_url` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `movie_url` text NOT NULL,
  `movie_player_id` int(11) unsigned NOT NULL DEFAULT '0',
  `movie_id` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `movie_id` (`movie_id`),
  KEY `movie_player_id` (`movie_player_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='影片地址表';

DROP TABLE IF EXISTS `lf_news`;
CREATE TABLE `lf_news` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属分类',
  `title` char(80) NOT NULL DEFAULT '' COMMENT '名称',
  `cover_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '封面',
  `content` text COMMENT '介绍',
  `up` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '顶',
  `down` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '踩',
  `hits` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '浏览数量',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态',
  `position` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '推荐位',
  `display` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '可见性',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='新闻表';


DROP TABLE IF EXISTS `lf_pay_log`;
CREATE TABLE `lf_pay_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `type` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '类型',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '日志备注',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '充值时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='充值记录';

DROP TABLE IF EXISTS `lf_picture`;
CREATE TABLE `lf_picture` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id自增',
  `path` varchar(255) NOT NULL DEFAULT '' COMMENT '路径',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '图片链接',
  `md5` char(32) NOT NULL DEFAULT '' COMMENT '文件md5',
  `sha1` char(40) NOT NULL DEFAULT '' COMMENT '文件 sha1编码',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `lf_player`;
CREATE TABLE `lf_player` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` char(80) NOT NULL DEFAULT '',
  `display` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '可见性',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序（同级有效）',
  `adon` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `player_code` text NOT NULL,
  `player_ad` text,
  `timer` int(4) unsigned NOT NULL DEFAULT '0' COMMENT '排序（同级有效）',
  `vip` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(3) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `sort` (`sort`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='播放器表';


INSERT INTO `lf_player` VALUES (1,'吉吉影音',1,1,0,'&lt;script type=&quot;text/javascript&quot;&gt;\r\n\t\t\tvar jjvod_url = \'&lt;$url&gt;\';//播放视频地址\r\n\t\t\tvar jjvod_w = \'100%\';//播放器宽度\r\n\t\t\tvar jjvod_h = document.getElementById(&quot;_player&quot;).offsetHeight;//播放器高度\r\n\t\t\tvar jjvod_ad = \'\';//缓冲和暂停调用广告地址，如http://www.abc.com/ad.html\r\n\t\t\tvar jjvod_c = \'baidu\'; //吉吉影音推广渠道，一般为域名简写，如baidu\r\n\t\t\tvar jjvod_install = \'http://player.jjvod.com/js/jjplayer_install.html?v=1&amp;c=\'+jjvod_c;\r\n\t\t\tvar jjvod_weburl = unescape(window.location.href);\r\n&lt;/script&gt;\r\n&lt;script type=&quot;text/javascript&quot; src=&quot;./Public/Player/player/jjplayer_v2.js&quot; charset=&quot;utf-8&quot;&gt;&lt;/script&gt;','',0,0,0),(2,'西瓜影音',1,2,0,'&lt;script language=&quot;javascript&quot;&gt;\r\nvar XgPlayer = {\r\n\t\'Url\': &quot;&lt;$url&gt;&quot;,  //本集播放地址，需更改\r\n\t\'NextcacheUrl\': &quot;&lt;$nexturl&gt;&quot;,  //缓冲下一集，需更改\r\n\t\'LastWebPage\': \'&lt;$lastplay&gt;\',\r\n\t\'NextWebPage\': &quot;&lt;$nextplay&gt;&quot;,  //下一集播放页面地址，需更改\r\n\t\'Buffer\': \'http://player.xigua.com/xg_loading.html\',  // 播缓冲AD，需更改\r\n\t\'Pase\': \'http://player.xigua.com/xg_loading.html\',  // 暂停AD，需更改\r\n\t\'Width\': &quot;100%&quot;,   // 播放器显示宽度\r\n\t\'Height\': document.getElementById(&quot;_player&quot;).offsetHeight,  // 播放器显示高度\r\n\t\'Second\': 8,  // 缓冲时间\r\n\t&quot;Installpage&quot;:\'http://static.xigua.com/installpage.html\'\r\n};\r\ndocument.write(\'&lt;script language=&quot;javascript&quot; src=&quot;http://static.xigua.com/xiguaplayer.js&quot; charset=&quot;utf-8&quot;&gt;&lt;\\/script&gt;\');\r\n&lt;/script&gt;','',0,0,0),(3,'先锋影音',1,3,0,'&lt;script type=&quot;text/javascript&quot;&gt;\r\n\t\t\tvar playerurl= \'&lt;$url&gt;\';//播放视频地址\r\n\t\t\tvar playerw= &quot;100%&quot;;//播放器宽度\r\n\t\t\tvar playerh= document.getElementById(&quot;_player&quot;).offsetHeight;//播放器高度\r\n&lt;/script&gt;\r\n&lt;script type=&quot;text/javascript&quot; src=&quot;./Public/Player/player/xfplay.js&quot; charset=&quot;utf-8&quot;&gt;&lt;/script&gt;','',0,0,0),(4,'mp4播放',1,5,0,'&lt;div id=&quot;a1&quot; style=&quot;width:100%;height:100%&quot;&gt;&lt;/div&gt;\r\n&lt;script type=&quot;text/javascript&quot; src=&quot;./Public/Player/player/ckplayer/ckplayer.js&quot; charset=&quot;utf-8&quot;&gt;&lt;/script&gt;\r\n&lt;script type=&quot;text/javascript&quot;&gt;\r\n\tvar flashvars={\r\n\t\tf:\'&lt;$url&gt;\',\r\n\t\tc:0,\r\n\t\tp:1,\r\n\t\tloaded:\'loadedHandler\'\r\n\t\t};\r\n\tvar video=[\'&lt;$url&gt;-&gt;video/mp4\'];\r\n    var params={bgcolor:\'#FFF\',allowFullScreen:true,allowScriptAccess:\'always\',wmode:\'transparent\'};\r\n    CKobject.embed(\'./Public/Player/player/ckplayer/ckplayer.swf\',\'a1\',\'ckplayer_a1\',\'100%\',\'100%\',false,flashvars,video,params);\r\n    function loadedHandler(){\r\n\t\tCKobject.getObjectById(\'ckplayer_a1\').addListener(\'ended\',\'endedHandler\');\r\n\t}\r\n\tfunction endedHandler(time){\r\n\t\tCKobject.getObjectById(\'ckplayer_a1\').openUrl(\'&lt;$nextplay&gt;\',\'_top\');\r\n\t}\r\n&lt;/script&gt;','',0,0,0),(5,'VIP播放',1,6,0,'&lt;div id=&quot;a1&quot; style=&quot;width:100%;height:100%&quot;&gt;&lt;/div&gt;\r\n&lt;script type=&quot;text/javascript&quot; src=&quot;./Public/Player/player/ckplayer/ckplayer.js&quot; charset=&quot;utf-8&quot;&gt;&lt;/script&gt;\r\n&lt;script type=&quot;text/javascript&quot;&gt;\r\n\tvar flashvars={\r\n\t\tf:\'&lt;$url&gt;\',\r\n\t\tc:0,\r\n\t\tp:1,\r\n\t\tloaded:\'loadedHandler\'\r\n\t\t};\r\n\tvar video=[\'&lt;$url&gt;-&gt;video/mp4\'];\r\n    var params={bgcolor:\'#FFF\',allowFullScreen:true,allowScriptAccess:\'always\',wmode:\'transparent\'};\r\n    CKobject.embed(\'./Public/Player/player/ckplayer/ckplayer.swf\',\'a1\',\'ckplayer_a1\',\'100%\',\'100%\',false,flashvars,video,params);\r\n    function loadedHandler(){\r\n\t\tCKobject.getObjectById(\'ckplayer_a1\').addListener(\'ended\',\'endedHandler\');\r\n\t}\r\n\tfunction endedHandler(time){\r\n\t\tCKobject.getObjectById(\'ckplayer_a1\').openUrl(\'&lt;$nextplay&gt;\',\'_top\');\r\n\t}\r\n&lt;/script&gt;','',0,1,0),(6,'VIP下载',1,7,0,'','',0,1,1),(7,'m3u8播放',1,8,0,'&lt;div id=&quot;a1&quot; style=&quot;width:100%;height:100%&quot;&gt;&lt;/div&gt;\r\n&lt;script type=&quot;text/javascript&quot; src=&quot;./Public/Player/player/ckplayer/ckplayer.js&quot; charset=&quot;utf-8&quot;&gt;&lt;/script&gt;\r\n&lt;script type=&quot;text/javascript&quot;&gt;\r\n\tvar flashvars={\r\n\t\tf:\'/Public/Player/player/ckplayer/m3u8.swf\',\r\n        a:\'&lt;$url&gt;\',\r\n        s:4,\r\n\t\tc:0,\r\n\t\tp:1,\r\n\t\tloaded:\'loadedHandler\'\r\n\t\t};\r\n\tvar video=[\'&lt;$url&gt;-&gt;video/mp4\'];\r\n    var params={bgcolor:\'#FFF\',allowFullScreen:true,allowScriptAccess:\'always\',wmode:\'transparent\'};\r\n    CKobject.embed(\'./Public/Player/player/ckplayer/ckplayer.swf\',\'a1\',\'ckplayer_a1\',\'100%\',\'100%\',false,flashvars,video,params);\r\n    function loadedHandler(){\r\n\t\tCKobject.getObjectById(\'ckplayer_a1\').addListener(\'ended\',\'endedHandler\');\r\n\t}\r\n\tfunction endedHandler(time){\r\n\t\tCKobject.getObjectById(\'ckplayer_a1\').openUrl(\'&lt;$nextplay&gt;\',\'_top\');\r\n\t}\r\n&lt;/script&gt;','',0,0,0),(8,'分享播放',1,9,0,'&lt;iframe scrolling=&quot;no&quot; frameborder=&quot;0&quot; src=&quot;&lt;$url&gt;&quot; style=&quot;height:100%; width:100%;&quot; allowfullscreen&gt;&lt;/iframe&gt;','',0,0,0),(10,'flv解析',1,10,0,'&lt;iframe scrolling=&quot;no&quot; frameborder=&quot;0&quot; src=&quot;http://api.haitian.tv/vip/index.php?url=&lt;$url&gt;&quot; style=&quot;height:100%; width:100%;&quot; allowfullscreen&gt;&lt;/iframe&gt;','',0,0,0),(11,'非凡影音',1,4,0,'&lt;script&gt;\r\n    var MacPlayer = {\r\n        \'PlayUrl\': \'&lt;$url&gt;\',  //视频播放地址\r\n        \'Width\': \'100%\',  //播放器宽度\r\n        \'Height\': document.getElementById(&quot;_player&quot;).offsetHeight,  //播放器高度\r\n    };\r\n&lt;/script&gt;\r\n&lt;script src=&quot;./Public/Player/player/ffplayer/ffhd.js&quot; charset=&quot;utf-8&quot;&gt;&lt;/script&gt;','',0,0,0);

DROP TABLE IF EXISTS `lf_player_log`;
CREATE TABLE `lf_player_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `log` text NOT NULL COMMENT '日志',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='播放记录日志表';


DROP TABLE IF EXISTS `lf_prize`;
CREATE TABLE `lf_prize` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(80) NOT NULL DEFAULT '' COMMENT '名称',
  `integral` int(11) NOT NULL DEFAULT '0' COMMENT '积分',
  `cover_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '封面',
  `content` text COMMENT '介绍',
  `display` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '可见性',
  `position` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '推荐位',
  `hits` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '浏览数量',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态',
  `number` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '兑换数量',
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='奖品表';

DROP TABLE IF EXISTS `lf_route`;
CREATE TABLE `lf_route` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '配置ID',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '配置名称',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '配置说明',
  `value` text NOT NULL COMMENT '配置值',
  `status` tinyint(2) NOT NULL DEFAULT '1',
  `display` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '可见性',
  `addons` varchar(40) DEFAULT NULL COMMENT '对应插件标识',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='路由';


DROP TABLE IF EXISTS `lf_slider`;
CREATE TABLE `lf_slider` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(80) NOT NULL DEFAULT '',
  `link` varchar(255) DEFAULT '',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(2) NOT NULL DEFAULT '1',
  `display` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `cover_id` varchar(255) NOT NULL DEFAULT '0',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序（同级有效）',
  `type` tinyint(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='幻灯';


DROP TABLE IF EXISTS `lf_users`;
CREATE TABLE `lf_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `username` char(16) NOT NULL COMMENT '用户名',
  `password` char(32) NOT NULL COMMENT '密码',
  `email` char(32) NOT NULL COMMENT '用户邮箱',
  `reg_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  `reg_ip` bigint(20) NOT NULL DEFAULT '0' COMMENT '注册IP',
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `last_login_ip` bigint(20) NOT NULL DEFAULT '0' COMMENT '最后登录IP',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(3) DEFAULT '0' COMMENT '用户状态',
  `path` varchar(255) DEFAULT NULL COMMENT '头像',
  `login` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登录次数',
  `gender` tinyint(3) DEFAULT '2' COMMENT '性别',
  `introduction` text COMMENT '介绍',
  `integral` int(11) NOT NULL DEFAULT '0' COMMENT '积分',
  `birthday` int(10) unsigned DEFAULT NULL COMMENT '生日',
  `sign` tinyint(3) NOT NULL DEFAULT '1' COMMENT '签到次数',
  `vip_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'vip时间',
  `favorites_password` char(32) NOT NULL DEFAULT '' COMMENT '收藏夹密码',
  `ucid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='用户表';


DROP TABLE IF EXISTS `lf_users_follow`;
CREATE TABLE `lf_users_follow` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '关注者ID',
  `fid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '被关注者ID',
  `remark` varchar(50) NOT NULL COMMENT '备注',
  `ctime` int(11) NOT NULL COMMENT '关注时间',
  PRIMARY KEY (`id`),
  KEY `fid` (`fid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;