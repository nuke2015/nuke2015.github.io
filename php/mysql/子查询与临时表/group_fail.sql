



-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `bestphp_order`;
CREATE TABLE `bestphp_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `serial_no` varchar(50) NOT NULL COMMENT '订单编号',
  `shop_id` int(11) NOT NULL DEFAULT '0' COMMENT '销售分店',
  `user_id` int(11) NOT NULL COMMENT '客户id',
  `total_money_product` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '产品合计金额',
  `saler_at` int(11) NOT NULL COMMENT '销售签单日期',
  `saler_id` int(11) NOT NULL COMMENT '销售员',
  `member_id` int(11) NOT NULL COMMENT '录单人',
  `total_money_topay` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '实际支付总金额',
  `money_payed` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '已支付金额',
  `contract_id` int(11) NOT NULL COMMENT '合同id',
  `contract_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '合同状态[0无合同1待审核2已审核3已驳回4已失效]',
  `title` varchar(200) NOT NULL COMMENT '标题',
  `create_at` int(11) NOT NULL COMMENT '订单添加时间',
  `update_at` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(1) NOT NULL COMMENT '订单状态[1待付款2已付全款3售后中4已关闭]',
  `remark` varchar(250) NOT NULL COMMENT '订单备注',
  `status_pay` tinyint(1) NOT NULL COMMENT '支付状态[1待支付,2部分支付3已付全款4已退款]',
  `club_id` int(11) NOT NULL COMMENT 'club_id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='客户订单表';


DROP TABLE IF EXISTS `bestphp_user_info`;
CREATE TABLE `bestphp_user_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL COMMENT '客户姓名',
  `nickname` varchar(50) NOT NULL DEFAULT '' COMMENT '昵称',
  `phone` char(11) NOT NULL COMMENT '用户手机号',
  `idcard` char(18) NOT NULL COMMENT '客户身份id',
  `sex` enum('0','1','2') NOT NULL DEFAULT '0' COMMENT '客户姓名 1男 ，2 女 0 保密',
  `birthday` int(11) NOT NULL COMMENT '生日',
  `age` tinyint(4) NOT NULL COMMENT '年龄',
  `origin` varchar(50) NOT NULL COMMENT '籍贯',
  `family` varchar(50) NOT NULL COMMENT '名族',
  `job` varchar(100) NOT NULL COMMENT '职业',
  `qq` varchar(50) NOT NULL COMMENT 'qq/微信',
  `email` varchar(100) NOT NULL COMMENT '邮箱',
  `province` int(11) NOT NULL COMMENT '省',
  `city` int(11) NOT NULL COMMENT '城市',
  `town` int(11) NOT NULL COMMENT '镇',
  `address` varchar(200) NOT NULL COMMENT '详细地址',
  `member_id` int(11) NOT NULL COMMENT '销售员id,平台管理员id',
  `introducer` varchar(50) NOT NULL COMMENT '介绍人',
  `customer_type` tinyint(4) NOT NULL COMMENT '客户类型：1 普通，2VIP ',
  `customer_origin` tinyint(4) NOT NULL COMMENT '客户来源 ： 1电话来访2自然上门3周边社区4网络推广5市场渠道6客户介绍7二胎入住8内部资源',
  `shop_id` tinyint(4) NOT NULL COMMENT '分店ID',
  `schedule_date` int(11) NOT NULL COMMENT '预约时间',
  `delivery_type` tinyint(2) NOT NULL COMMENT '分娩方式：1顺产，2 剖腹产',
  `how_births` tinyint(4) NOT NULL COMMENT '第几胎了',
  `hospital` varchar(50) NOT NULL COMMENT '产检医院',
  `escort` varchar(50) NOT NULL COMMENT '陪护人',
  `escort_phone` char(11) NOT NULL COMMENT '陪护人电话',
  `remark` varchar(250) NOT NULL COMMENT '备注信息',
  `desp` varchar(250) NOT NULL DEFAULT '' COMMENT '个性签名',
  `thumb` varchar(250) NOT NULL DEFAULT '' COMMENT '用户头像',
  `admin_id` int(11) NOT NULL COMMENT '创建者id',
  `club_id` int(11) NOT NULL COMMENT 'club_id',
  `idcard_right` varchar(255) NOT NULL COMMENT '身份证正面照片',
  `idcard_left` varchar(255) NOT NULL COMMENT '身份证反面照片',
  `contact` varchar(50) NOT NULL COMMENT '紧急联系人',
  `contact_tel` char(11) NOT NULL COMMENT '紧急联系人电话',
  `customer_relationship` varchar(255) NOT NULL COMMENT '与客户关系',
  `review_time` int(11) NOT NULL COMMENT '复查时间',
  `update_time` int(11) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `phone_club_id` (`phone`,`club_id`),
  KEY `idcard` (`idcard`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户档案表';


-- 2018-06-15 14:13:52








-- 查询正常
select count(*) as count ,user_id,club_id
from bestphp_order
group by user_id



-- 查询出错 (1052): Column 'club_id' in field list is ambiguous
select count(*) as count ,user_id,club_id
from bestphp_order as zo
left join bestphp_user_info as ui
on zo.user_id=ui.id
group by ui.id



-- 查询也正常
select count(zo.id) as count ,ui.id as user_id,ui.club_id
from bestphp_order as zo
left join bestphp_user_info as ui
on zo.user_id=ui.id
group by ui.id






