-- phpMyAdmin SQL Dump
-- version 4.0.7
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2013-11-10 16:18:19
-- 服务器版本: 5.6.14
-- PHP 版本: 5.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- 数据库: `szone`
--

-- --------------------------------------------------------

--
-- 表的结构 `board`
--

CREATE TABLE IF NOT EXISTS `board` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `parent-id` int(8) unsigned zerofill NOT NULL COMMENT '父消息id',
  `user-id` int(8) NOT NULL COMMENT '用户id',
  `content` varchar(255) DEFAULT NULL COMMENT '留言内容',
  `create-time` int(12) NOT NULL COMMENT '创建时间',
  `target-id` int(8) NOT NULL COMMENT '目标文件id',
  `status` tinyint(2) unsigned zerofill NOT NULL COMMENT '审核状态 0 审核中 1 审核通过',
  `target-type` int(8) NOT NULL COMMENT '类型 0 个人 1 小组 的文件',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `id` int(8) NOT NULL AUTO_INCREMENT COMMENT '文件id',
  `path` varchar(120) NOT NULL COMMENT '文件存放路径',
  `md5` varchar(60) NOT NULL COMMENT '文件md5',
  `del` int(2) unsigned zerofill NOT NULL COMMENT '文件是否被删除',
  `size` int(12) unsigned zerofill NOT NULL COMMENT '文件大小',
  `type` tinyint(2) unsigned zerofill DEFAULT NULL COMMENT '文件类型',
  PRIMARY KEY (`id`),
  UNIQUE KEY `md5` (`md5`),
  UNIQUE KEY `path` (`path`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- 表的结构 `groupcollection`
--

CREATE TABLE IF NOT EXISTS `groupcollection` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `gid` int(8) NOT NULL COMMENT '小组id',
  `fid` int(8) NOT NULL COMMENT '文件id',
  `remark` varchar(120) DEFAULT NULL COMMENT '备注',
  `time` int(12) NOT NULL COMMENT '收藏时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `groupfile`
--

CREATE TABLE IF NOT EXISTS `groupfile` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `fid` int(8) NOT NULL COMMENT '文件id',
  `gid` int(8) NOT NULL COMMENT '小组id',
  `createtime` int(12) NOT NULL COMMENT '创建时间',
  `fname` varchar(80) NOT NULL COMMENT '文件名',
  `content` varchar(255) DEFAULT NULL COMMENT '文件说明',
  `del` int(2) unsigned zerofill DEFAULT NULL COMMENT '是否被逻辑删除',
  `uid` int(8) NOT NULL COMMENT '来源用户id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- 表的结构 `groupfolds`
--

CREATE TABLE IF NOT EXISTS `groupfolds` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL COMMENT '文件夹名称',
  `gid` int(8) NOT NULL COMMENT '分组id',
  `createtime` int(12) NOT NULL COMMENT '创建时间的时间戳',
  `updatetime` timestamp(6) NULL DEFAULT NULL COMMENT '更新时间',
  `type` int(2) unsigned zerofill NOT NULL COMMENT '预留扩展 是否隐藏的类型?',
  `pid` int(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL COMMENT '分组名',
  `type` int(2) NOT NULL COMMENT '类型 0 系统 1 小组 2 部门',
  `parent` int(8) NOT NULL COMMENT '父id 只对小组有效?',
  `create` int(8) DEFAULT NULL COMMENT '创建人id',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- 表的结构 `groupuser`
--

CREATE TABLE IF NOT EXISTS `groupuser` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `gid` int(8) NOT NULL,
  `uid` int(8) NOT NULL,
  `auth` int(8) unsigned zerofill NOT NULL COMMENT '0 普通成员 1 管理员',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

-- --------------------------------------------------------

--
-- 表的结构 `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `fuid` int(8) NOT NULL,
  `tuid` int(8) NOT NULL,
  `content` text NOT NULL,
  `fid` int(8) DEFAULT NULL,
  `createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '发送时间',
  `pid` int(8) unsigned zerofill DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL COMMENT '用户名',
  `nick` varchar(60) DEFAULT NULL COMMENT '昵称',
  `auth` tinyint(2) unsigned zerofill NOT NULL COMMENT '权限 0x0 普通 0x1 小组管理员 0x2 部门管理员 0x4 管理员 0x8 系统管理员',
  `size` int(8) unsigned zerofill NOT NULL DEFAULT '00000000' COMMENT '用户总空间',
  `used` int(8) unsigned zerofill NOT NULL DEFAULT '00000000' COMMENT '用户已用空间',
  `pwd` varchar(60) DEFAULT NULL COMMENT '登录管理后台的密码',
  `access` varchar(64) NOT NULL COMMENT 'access token',
  `openid` varchar(64) DEFAULT NULL COMMENT 'openid',
  `update-time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `lastgroup` int(8) DEFAULT NULL COMMENT '最后一次访问的小组名',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- 表的结构 `usercollection`
--

CREATE TABLE IF NOT EXISTS `usercollection` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `uid` int(8) NOT NULL COMMENT '用户id或小组id',
  `fid` int(8) NOT NULL COMMENT '文件id',
  `remark` varchar(120) DEFAULT NULL COMMENT '备注',
  `time` int(12) NOT NULL COMMENT '收藏时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=39 ;

-- --------------------------------------------------------

--
-- 表的结构 `userfile`
--

CREATE TABLE IF NOT EXISTS `userfile` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `fid` int(8) NOT NULL COMMENT '文件id',
  `fdid` int(8) NOT NULL DEFAULT '0' COMMENT '文件夹id',
  `name` varchar(80) NOT NULL COMMENT '文件名',
  `uid` int(8) NOT NULL COMMENT '用户id',
  `createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `content` varchar(255) DEFAULT NULL COMMENT '文件说明',
  `del` int(2) unsigned zerofill DEFAULT NULL COMMENT '是否被逻辑删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- 表的结构 `userfolds`
--

CREATE TABLE IF NOT EXISTS `userfolds` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `pid` int(8) NOT NULL DEFAULT '0',
  `name` varchar(120) NOT NULL COMMENT '文件夹名称',
  `uid` int(8) NOT NULL COMMENT '用户id',
  `mark` varchar(120) NOT NULL COMMENT '备注',
  `createtime` int(12) NOT NULL COMMENT '创建时间的时间戳',
  `updatetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  `type` int(2) unsigned zerofill NOT NULL COMMENT '预留扩展 是否隐藏的类型?',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;
