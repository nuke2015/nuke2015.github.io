/*
Navicat MySQL Data Transfer

Source Server         : sdfs
Source Server Version : 50613
Source Host           : localhost:3306
Source Database       : test

Target Server Type    : MYSQL
Target Server Version : 50613
File Encoding         : 65001

Date: 2016-12-09 09:51:44
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `hello`
-- ----------------------------
DROP TABLE IF EXISTS `hello`;
CREATE TABLE `hello` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of hello
-- ----------------------------
INSERT INTO `hello` VALUES ('19', '', '0000-00-00 00:00:00');
INSERT INTO `hello` VALUES ('20', '', '0000-00-00 00:00:00');
INSERT INTO `hello` VALUES ('21', '', '0000-00-00 00:00:00');
INSERT INTO `hello` VALUES ('22', '', '0000-00-00 00:00:00');
INSERT INTO `hello` VALUES ('23', '', '0000-00-00 00:00:00');
INSERT INTO `hello` VALUES ('24', '', '0000-00-00 00:00:00');
INSERT INTO `hello` VALUES ('25', '', '0000-00-00 00:00:00');
INSERT INTO `hello` VALUES ('26', '', '0000-00-00 00:00:00');
INSERT INTO `hello` VALUES ('27', '', '0000-00-00 00:00:00');
INSERT INTO `hello` VALUES ('28', '', '0000-00-00 00:00:00');
INSERT INTO `hello` VALUES ('29', '', '0000-00-00 00:00:00');
INSERT INTO `hello` VALUES ('30', '', '0000-00-00 00:00:00');
INSERT INTO `hello` VALUES ('31', '', '0000-00-00 00:00:00');
INSERT INTO `hello` VALUES ('32', '', '0000-00-00 00:00:00');
INSERT INTO `hello` VALUES ('33', '', '0000-00-00 00:00:00');
