/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50525
Source Host           : localhost:3306
Source Database       : testdb

Target Server Type    : MYSQL
Target Server Version : 50525
File Encoding         : 65001

Date: 2015-08-21 13:11:43
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `article`
-- ----------------------------
DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `view` int(10) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of article
-- ----------------------------
INSERT INTO `article` VALUES ('1', '你好世界', '<p>我真的是内容，不信算了，哼~ O(∩_∩)O</p>', '1', '0', '0', '2015');
INSERT INTO `article` VALUES ('2', '你好长江', '<p>我真的是内容，不信算了，哼~ O(∩_∩)O</p>', '1', '0', '0', '0');
INSERT INTO `article` VALUES ('3', '你好黄河', '测试测试', '1', '0', '0', '0');
