/*
Navicat MySQL Data Transfer

Source Server         : 阿里云
Source Server Version : 50537
Source Host           : 123.57.52.70:3306
Source Database       : blog

Target Server Type    : MYSQL
Target Server Version : 50537
File Encoding         : 65001

Date: 2015-07-08 00:22:48
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for blog
-- ----------------------------
DROP TABLE IF EXISTS `blog`;
CREATE TABLE `blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` char(72) NOT NULL DEFAULT '',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '-1 删除 0 草稿 1 正常 2 置顶',
  `createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '文章类型（分级）',
  `look` int(11) NOT NULL DEFAULT '1' COMMENT '浏览量',
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for blogtag
-- ----------------------------
DROP TABLE IF EXISTS `blogtag`;
CREATE TABLE `blogtag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `blogid` int(11) DEFAULT '0',
  `tagid` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `blogid` (`blogid`) USING BTREE,
  KEY `tagid` (`tagid`) USING BTREE,
  CONSTRAINT `blogid` FOREIGN KEY (`blogid`) REFERENCES `blog` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8 COMMENT='blog_tag关联表';

-- ----------------------------
-- Table structure for blogtype
-- ----------------------------
DROP TABLE IF EXISTS `blogtype`;
CREATE TABLE `blogtype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(24) NOT NULL DEFAULT '' COMMENT '类型名称',
  `topid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for cat
-- ----------------------------
DROP TABLE IF EXISTS `cat`;
CREATE TABLE `cat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(36) NOT NULL DEFAULT '',
  `value` varchar(360) NOT NULL DEFAULT '',
  `ext` tinyint(2) NOT NULL DEFAULT '0',
  `comment` varchar(360) DEFAULT '' COMMENT '解释这条记录的含义',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='网站信息综合表，name代表这条记录的关键key ';

-- ----------------------------
-- Table structure for comment
-- ----------------------------
DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `blogid` int(11) DEFAULT NULL,
  `content` varchar(240) DEFAULT '',
  `nickname` char(24) DEFAULT '',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `replyid` int(11) DEFAULT '0' COMMENT '-1 已被回复 0 未被回复 >0 回复的那个id',
  PRIMARY KEY (`id`),
  KEY `id` (`blogid`),
  CONSTRAINT `commentid` FOREIGN KEY (`blogid`) REFERENCES `blog` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for content
-- ----------------------------
DROP TABLE IF EXISTS `content`;
CREATE TABLE `content` (
  `blogid` int(11) NOT NULL,
  `content` text,
  PRIMARY KEY (`blogid`),
  CONSTRAINT `id` FOREIGN KEY (`blogid`) REFERENCES `blog` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for link
-- ----------------------------
DROP TABLE IF EXISTS `link`;
CREATE TABLE `link` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` char(36) NOT NULL DEFAULT '',
  `title` char(36) NOT NULL DEFAULT '',
  `createtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for say
-- ----------------------------
DROP TABLE IF EXISTS `say`;
CREATE TABLE `say` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(480) NOT NULL DEFAULT '',
  `createtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `imgs` varchar(480) NOT NULL DEFAULT '' COMMENT 'json格式',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tag
-- ----------------------------
DROP TABLE IF EXISTS `tag`;
CREATE TABLE `tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(24) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for test
-- ----------------------------
DROP TABLE IF EXISTS `test`;
CREATE TABLE `test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bid` char(20) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;


INSERT INTO `cat` VALUES ('1', 'login', '6d253d7e5955a36e0213b6f6957b788d', '0', '登陆验证 value是md5(md5(password)+name)');
INSERT INTO `cat` VALUES ('2', 'site_back', 'xxxxxx', '0', '网站备案号');
INSERT INTO `cat` VALUES ('3', 'site_title', 'xxxxxx', '0', '网站名称');
INSERT INTO `cat` VALUES ('4', 'site_keywords', 'xxxxxx', '0', '网站关键词');
INSERT INTO `cat` VALUES ('5', 'site_description', 'xxxxxx', '0', '网站描述');
INSERT INTO `cat` VALUES ('6', 'blog_title', 'xxxxxx', '0', '博客名称');
INSERT INTO `cat` VALUES ('7', 'site_url', 'xxxxxx', '0', '本站url');
