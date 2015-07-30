/*
Navicat MySQL Data Transfer

Source Server         : 192.168.1.235
Source Server Version : 50543
Source Host           : 192.168.1.235:3306
Source Database       : api

Target Server Type    : MYSQL
Target Server Version : 50543
File Encoding         : 65001

Date: 2015-07-30 10:23:16
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `api_access_log`
-- ----------------------------
DROP TABLE IF EXISTS `api_access_log`;
CREATE TABLE `api_access_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `ip` char(16) NOT NULL,
  `useragent` varchar(200) NOT NULL,
  `spent` int(11) NOT NULL,
  `data` text NOT NULL,
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of api_access_log
-- ----------------------------
