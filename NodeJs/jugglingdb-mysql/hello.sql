/*
Navicat MySQL Data Transfer

Source Server         : 654
Source Server Version : 50613
Source Host           : localhost:3306
Source Database       : test

Target Server Type    : MYSQL
Target Server Version : 50613
File Encoding         : 65001

Date: 2016-12-08 17:45:53
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `hello`
-- ----------------------------
DROP TABLE IF EXISTS `hello`;
CREATE TABLE `hello` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of hello
-- ----------------------------
INSERT INTO `hello` VALUES ('1', 'title me', '2016-12-24 15:14:16');
INSERT INTO `hello` VALUES ('2', 'i title', '2016-12-03 15:14:29');
INSERT INTO `hello` VALUES ('3', '', '0000-00-00 00:00:00');
