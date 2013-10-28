/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50614
Source Host           : localhost:3306
Source Database       : szone

Target Server Type    : MYSQL
Target Server Version : 50614
File Encoding         : 65001

Date: 2013-10-26 19:22:58
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for szone-deps
-- ----------------------------
DROP TABLE IF EXISTS `szone-deps`;
CREATE TABLE `szone-deps` (
  `id` int(8) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(40) NOT NULL COMMENT '部门名称',
  `type` int(4) DEFAULT NULL COMMENT '待用?',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for szone-file
-- ----------------------------
DROP TABLE IF EXISTS `szone-file`;
CREATE TABLE `szone-file` (
  `id` int(8) NOT NULL,
  `filename` varchar(100) NOT NULL COMMENT '文件名',
  `filepath` varchar(100) NOT NULL COMMENT '文件路径',
  `filetype` int(2) NOT NULL COMMENT '文件类型',
  `createtime` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  `updatetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `createuser` int(8) NOT NULL COMMENT '创建者id',
  `mark` int(8) DEFAULT '0' COMMENT '标记位',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for szone-group
-- ----------------------------
DROP TABLE IF EXISTS `szone-group`;
CREATE TABLE `szone-group` (
  `id` int(8) NOT NULL,
  `name` varchar(40) DEFAULT NULL COMMENT '小组名',
  `level` int(2) DEFAULT NULL COMMENT '一级还是2级',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for szone-msg
-- ----------------------------
DROP TABLE IF EXISTS `szone-msg`;
CREATE TABLE `szone-msg` (
  `id` int(12) NOT NULL,
  `form-user` int(8) NOT NULL COMMENT '来源',
  `to-user` int(8) NOT NULL COMMENT '目标用户id',
  `content` varchar(255) NOT NULL COMMENT '内容',
  `time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for szone-share
-- ----------------------------
DROP TABLE IF EXISTS `szone-share`;
CREATE TABLE `szone-share` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `file-id` int(8) NOT NULL COMMENT '文件id',
  `form-user` int(8) NOT NULL COMMENT '来源用户id',
  `to-user` int(8) NOT NULL COMMENT '分享到的用户id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for szone-user
-- ----------------------------
DROP TABLE IF EXISTS `szone-user`;
CREATE TABLE `szone-user` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `deps` int(8) NOT NULL COMMENT '部门id',
  `groupid` int(8) NOT NULL COMMENT '小组id',
  `mark` int(8) DEFAULT NULL,
  `used` int(16) DEFAULT '0' COMMENT '已用大小',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for szone-userzone
-- ----------------------------
DROP TABLE IF EXISTS `szone-userzone`;
CREATE TABLE `szone-userzone` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `userid` int(8) NOT NULL,
  `name` varchar(40) NOT NULL COMMENT '分组名字',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
