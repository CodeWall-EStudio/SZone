/*
SQLyog Ultimate v10.51 
MySQL - 5.6.14 : Database - szone
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`szone` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `szone`;

/*Table structure for table `board` */

DROP TABLE IF EXISTS `board`;

CREATE TABLE `board` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `parent-id` int(8) unsigned zerofill NOT NULL COMMENT '父消息id',
  `user-id` int(8) NOT NULL COMMENT '用户id',
  `content` varchar(255) DEFAULT NULL COMMENT '留言内容',
  `create-time` int(12) NOT NULL COMMENT '创建时间',
  `target-id` int(8) NOT NULL COMMENT '目标文件id',
  `status` tinyint(2) unsigned zerofill NOT NULL COMMENT '审核状态 0 审核中 1 审核通过',
  `target-type` int(8) NOT NULL COMMENT '类型 0 个人 1 小组 的文件',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `board` */

/*Table structure for table `collection-group` */

DROP TABLE IF EXISTS `collection-group`;

CREATE TABLE `collection-group` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `group-id` int(8) NOT NULL COMMENT '小组id',
  `file-id` int(8) NOT NULL COMMENT '文件id',
  `remark` varchar(120) DEFAULT NULL COMMENT '备注',
  `time` int(12) NOT NULL COMMENT '收藏时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

/*Data for the table `collection-group` */

/*Table structure for table `collection-user` */

DROP TABLE IF EXISTS `collection-user`;

CREATE TABLE `collection-user` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `user-id` int(8) NOT NULL COMMENT '用户id或小组id',
  `file-id` int(8) NOT NULL COMMENT '文件id',
  `remark` varchar(120) DEFAULT NULL COMMENT '备注',
  `time` int(12) NOT NULL COMMENT '收藏时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

/*Data for the table `collection-user` */

/*Table structure for table `file-group` */

DROP TABLE IF EXISTS `file-group`;

CREATE TABLE `file-group` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `file-id` int(8) NOT NULL COMMENT '文件id',
  `group-id` int(8) NOT NULL COMMENT '小组id',
  `createtime` int(12) NOT NULL COMMENT '创建时间',
  `name` varchar(80) NOT NULL COMMENT '文件名',
  `content` varchar(255) DEFAULT NULL COMMENT '文件说明',
  `del` int(2) unsigned zerofill DEFAULT NULL COMMENT '是否被逻辑删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

/*Data for the table `file-group` */

/*Table structure for table `file-user` */

DROP TABLE IF EXISTS `file-user`;

CREATE TABLE `file-user` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `file-id` int(8) NOT NULL COMMENT '文件id',
  `user-id` int(8) NOT NULL COMMENT '用户id',
  `createtime` int(12) NOT NULL COMMENT '创建时间',
  `name` varchar(80) NOT NULL COMMENT '文件名',
  `content` varchar(255) DEFAULT NULL COMMENT '文件说明',
  `del` int(2) unsigned zerofill DEFAULT NULL COMMENT '是否被逻辑删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `file-user` */

/*Table structure for table `files` */

DROP TABLE IF EXISTS `files`;

CREATE TABLE `files` (
  `id` int(8) NOT NULL AUTO_INCREMENT COMMENT '文件id',
  `path` varchar(120) NOT NULL COMMENT '文件存放路径',
  `md5` varchar(60) NOT NULL COMMENT '文件md5',
  `del` int(2) unsigned zerofill NOT NULL COMMENT '文件是否被删除',
  `size` int(12) unsigned zerofill NOT NULL COMMENT '文件大小',
  `type` tinyint(2) unsigned zerofill DEFAULT NULL COMMENT '文件类型',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `files` */

/*Table structure for table `folds-group` */

DROP TABLE IF EXISTS `folds-group`;

CREATE TABLE `folds-group` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL COMMENT '文件夹名称',
  `group-id` int(8) NOT NULL COMMENT '分组id',
  `createtime` int(12) NOT NULL COMMENT '创建时间的时间戳',
  `updatetime` timestamp(6) NULL DEFAULT NULL COMMENT '更新时间',
  `type` int(2) unsigned zerofill NOT NULL COMMENT '预留扩展 是否隐藏的类型?',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

/*Data for the table `folds-group` */

/*Table structure for table `folds-user` */

DROP TABLE IF EXISTS `folds-user`;

CREATE TABLE `folds-user` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL COMMENT '文件夹名称',
  `user-id` int(8) NOT NULL COMMENT '用户id',
  `createtime` int(12) NOT NULL COMMENT '创建时间的时间戳',
  `updatetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  `type` int(2) unsigned zerofill NOT NULL COMMENT '预留扩展 是否隐藏的类型?',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `folds-user` */

/*Table structure for table `group-user` */

DROP TABLE IF EXISTS `group-user`;

CREATE TABLE `group-user` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `groupid` int(8) NOT NULL,
  `userid` int(8) NOT NULL,
  `auth` int(8) unsigned zerofill NOT NULL COMMENT '0 普通成员 1 管理员',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `group-user` */

/*Table structure for table `groups` */

DROP TABLE IF EXISTS `groups`;

CREATE TABLE `groups` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL COMMENT '分组名',
  `type` int(2) NOT NULL COMMENT '类型 0 系统 1 小组 2 部门',
  `parent` int(8) NOT NULL COMMENT '父id 只对小组有效?',
  `create` int(8) DEFAULT NULL COMMENT '创建人id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `groups` */

/*Table structure for table `message` */

DROP TABLE IF EXISTS `message`;

CREATE TABLE `message` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `from` int(8) NOT NULL,
  `to` int(8) NOT NULL,
  `content` text NOT NULL,
  `file-id` int(8) DEFAULT NULL,
  `createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '发送时间',
  `parentid` int(8) unsigned zerofill NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `message` */

insert  into `message`(`id`,`from`,`to`,`content`,`file-id`,`createtime`,`parentid`) values (1,1,2,'tset',NULL,'0000-00-00 00:00:00',00000000),(2,2,3,'test',NULL,'0000-00-00 00:00:00',00000000);

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL COMMENT '用户名',
  `auth` tinyint(2) unsigned zerofill NOT NULL COMMENT '权限 0x0 普通 0x1 小组管理员 0x2 部门管理员 0x4 管理员 0x8 系统管理员',
  `size` int(8) unsigned zerofill NOT NULL COMMENT '用户总空间',
  `used` int(8) unsigned zerofill NOT NULL COMMENT '用户已用空间',
  `pwd` varchar(60) DEFAULT NULL COMMENT '登录管理后台的密码',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `user` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
