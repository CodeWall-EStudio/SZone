-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2013 年 12 月 24 日 12:05
-- 服务器版本: 5.1.71-log
-- PHP 版本: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- 数据库: `szone`
--

-- --------------------------------------------------------

--
-- 表的结构 `board`
--

DROP TABLE IF EXISTS `board`;
CREATE TABLE IF NOT EXISTS `board` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `pid` int(8) unsigned zerofill NOT NULL COMMENT '父消息id',
  `uid` int(8) NOT NULL COMMENT '用户id',
  `content` varchar(255) DEFAULT NULL COMMENT '留言内容',
  `ctime` int(12) NOT NULL COMMENT '创建时间',
  `tid` int(8) NOT NULL DEFAULT '0' COMMENT '目标文件id',
  `status` tinyint(2) unsigned zerofill NOT NULL COMMENT '审核状态 0 审核中 1 审核通过',
  `ttype` int(8) NOT NULL COMMENT '类型 0 个人 1 小组 的文件',
  `gid` int(8) NOT NULL DEFAULT '0' COMMENT '分组id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `files`
--

DROP TABLE IF EXISTS `files`;
CREATE TABLE IF NOT EXISTS `files` (
  `id` int(8) NOT NULL AUTO_INCREMENT COMMENT '文件id',
  `path` varchar(120) NOT NULL COMMENT '文件存放路径',
  `md5` varchar(60) NOT NULL COMMENT '文件md5',
  `size` float unsigned zerofill NOT NULL COMMENT '文件大小',
  `type` tinyint(2) unsigned zerofill DEFAULT NULL COMMENT '文件类型',
  `mimes` varchar(60) NOT NULL,
  `ref` int(8) NOT NULL DEFAULT '1' COMMENT '文件引用计数',
  `create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `md5` (`md5`),
  UNIQUE KEY `path` (`path`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `groupcollection`
--

DROP TABLE IF EXISTS `groupcollection`;
CREATE TABLE IF NOT EXISTS `groupcollection` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `gid` int(8) NOT NULL COMMENT '小组id',
  `fid` int(8) NOT NULL COMMENT '文件id',
  `remark` varchar(120) DEFAULT NULL COMMENT '备注',
  `time` int(12) NOT NULL COMMENT '收藏时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `groupfile`
--

DROP TABLE IF EXISTS `groupfile`;
CREATE TABLE IF NOT EXISTS `groupfile` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `fid` int(8) NOT NULL COMMENT '文件id',
  `gid` int(8) NOT NULL COMMENT '小组id',
  `fdid` int(8) NOT NULL DEFAULT '0' COMMENT '小组文件夹名称',
  `createtime` int(12) NOT NULL COMMENT '创建时间',
  `fname` varchar(80) NOT NULL COMMENT '文件名',
  `content` varchar(255) DEFAULT NULL COMMENT '文件说明',
  `del` int(2) unsigned zerofill DEFAULT '00' COMMENT '是否被逻辑删除',
  `uid` int(8) NOT NULL COMMENT '来源用户id',
  `fgid` int(8) NOT NULL DEFAULT '0' COMMENT ' 来源分组',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0 上传 1 分享',
  `tag` varchar(200) DEFAULT NULL COMMENT '审核评语',
  `rtag` int(1) DEFAULT '0' COMMENT '0 通过 1 不通过',
  `ttime` int(12) DEFAULT '0' COMMENT '审核时间',
  `ruid` int(8) DEFAULT '0' COMMENT '审核人的uid',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `groupfolds`
--

DROP TABLE IF EXISTS `groupfolds`;
CREATE TABLE IF NOT EXISTS `groupfolds` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL COMMENT '文件夹名称',
  `gid` int(8) NOT NULL COMMENT '分组id',
  `mark` varchar(255) NOT NULL COMMENT '备注',
  `createtime` int(12) NOT NULL COMMENT '创建时间的时间戳',
  `updatetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `closetime` int(12) NOT NULL DEFAULT '0' COMMENT '关闭上传时间',
  `type` int(2) unsigned zerofill NOT NULL COMMENT '预留扩展 是否隐藏的类型?',
  `pid` int(8) NOT NULL DEFAULT '0',
  `tid` int(8) DEFAULT '0' COMMENT '顶层id',
  `idpath` text COMMENT 'id路径',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `groups`
--

DROP TABLE IF EXISTS `groups`;
CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL COMMENT '分组名',
  `content` varchar(255) NOT NULL COMMENT '公告',
  `type` int(2) NOT NULL COMMENT '类型 0 系统 1 小组 2 部门 3 备课',
  `parent` int(8) NOT NULL COMMENT '父id 只对小组有效?',
  `create` int(8) DEFAULT NULL COMMENT '创建人id',
  `status` int(1) DEFAULT '0' COMMENT '是否为新申请',
  `pt` int(1) NOT NULL DEFAULT '0' COMMENT '是否为备课',
  `tag` int(1) NOT NULL DEFAULT '0' COMMENT '学科',
  `grade` int(1) NOT NULL DEFAULT '0' COMMENT '年级',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `groupuser`
--

DROP TABLE IF EXISTS `groupuser`;
CREATE TABLE IF NOT EXISTS `groupuser` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `gid` int(8) NOT NULL,
  `uid` int(8) NOT NULL,
  `auth` int(8) unsigned zerofill NOT NULL COMMENT '0 普通成员 1 管理员',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `fuid` int(8) NOT NULL,
  `tuid` int(8) NOT NULL,
  `content` text NOT NULL,
  `fid` int(8) DEFAULT NULL,
  `createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '发送时间',
  `pid` int(8) unsigned zerofill DEFAULT NULL,
  `flooked` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已经看过',
  `saved` int(1) DEFAULT '0' COMMENT '是否已经保存',
  `tlooked` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `prepare`
--

DROP TABLE IF EXISTS `prepare`;
CREATE TABLE IF NOT EXISTS `prepare` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL COMMENT '备课目录名称',
  `pid` int(8) NOT NULL COMMENT '年级id',
  `sid` int(8) DEFAULT '0' COMMENT '单元id',
  `gid` int(8) NOT NULL COMMENT '学期id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `preparefile`
--

DROP TABLE IF EXISTS `preparefile`;
CREATE TABLE IF NOT EXISTS `preparefile` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `pid` int(8) NOT NULL COMMENT '备课目录id',
  `fid` int(8) NOT NULL COMMENT '文件id',
  `uid` int(8) NOT NULL COMMENT '用户id',
  `mark` varchar(255) DEFAULT NULL COMMENT '备注',
  `type` tinyint(2) DEFAULT '0' COMMENT '0 用户 1 小组 2部门',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `prepareuser`
--

DROP TABLE IF EXISTS `prepareuser`;
CREATE TABLE IF NOT EXISTS `prepareuser` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `pid` int(8) NOT NULL COMMENT '备课目录id',
  `nid` int(8) DEFAULT NULL COMMENT '用户id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL COMMENT '用户名',
  `nick` VARCHAR(40) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '用户名称',
  `auth` tinyint(2) unsigned zerofill NOT NULL DEFAULT '0' COMMENT '权限 0x0 普通 0x1 小组管理员 0x2 部门管理员 0x4 管理员 0x8 系统管理员',
  `size` float unsigned zerofill NOT NULL DEFAULT '00000003e+09' COMMENT '用户总空间',
  `used` float unsigned zerofill NOT NULL DEFAULT '000000000000' COMMENT '用户已用空间',
  `lastgroup` int(8) DEFAULT NULL COMMENT '最后一次访问的小组名',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `usercollection`
--

DROP TABLE IF EXISTS `usercollection`;
CREATE TABLE IF NOT EXISTS `usercollection` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `uid` int(8) NOT NULL COMMENT '用户id或小组id',
  `fid` int(8) NOT NULL COMMENT '文件id',
  `remark` varchar(120) DEFAULT NULL COMMENT '备注',
  `time` int(12) NOT NULL COMMENT '收藏时间',
  `tid` int(8) DEFAULT '0' COMMENT '收藏他人或者小组id',
  `type` int(1) DEFAULT '0' COMMENT '0 自己 1他人 2 小组',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `userfile`
--

DROP TABLE IF EXISTS `userfile`;
CREATE TABLE IF NOT EXISTS `userfile` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `fid` int(8) NOT NULL COMMENT '文件id',
  `fdid` int(8) NOT NULL DEFAULT '0' COMMENT '文件夹id',
  `name` varchar(80) NOT NULL COMMENT '文件名',
  `uid` int(8) NOT NULL COMMENT '用户id',
  `createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `content` varchar(255) DEFAULT NULL COMMENT '文件说明',
  `tag` varchar(200) DEFAULT NULL COMMENT '审核评语',
  `rtag` int(1) DEFAULT NULL COMMENT '0通过 1不通过',
  `ttime` int(12) DEFAULT '0' COMMENT '审核时间',
  `mark` varchar(200) NOT NULL COMMENT '评论',
  `del` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `userfolds`
--

DROP TABLE IF EXISTS `userfolds`;
CREATE TABLE IF NOT EXISTS `userfolds` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `pid` int(8) NOT NULL DEFAULT '0',
  `name` varchar(120) NOT NULL COMMENT '文件夹名称',
  `uid` int(8) NOT NULL COMMENT '用户id',
  `mark` varchar(120) NOT NULL COMMENT '备注',
  `createtime` int(12) NOT NULL COMMENT '创建时间的时间戳',
  `updatetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  `type` int(2) unsigned zerofill NOT NULL COMMENT '预留扩展 是否隐藏的类型?',
  `tid` int(8) DEFAULT '0' COMMENT '顶层id',
  `idpath` text COMMENT '父id list',
  `prid` int(8) NOT NULL DEFAULT '0' COMMENT '备课id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
