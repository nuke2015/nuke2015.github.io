

-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP VIEW IF EXISTS `view_room_busy_now`;
CREATE TABLE `view_room_busy_now` (`room_id` int(11), `club_id` int(11), `schedule_id` int(11), `status` tinyint(2));


DROP VIEW IF EXISTS `view_room_useable_now`;
CREATE TABLE `view_room_useable_now` (`room_id` int(11), `schedule_id` int(11), `status` bigint(20), `club_id` int(11));


DROP TABLE IF EXISTS `zhihu_room_info`;
CREATE TABLE `zhihu_room_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) NOT NULL COMMENT '门店id',
  `number` varchar(50) NOT NULL COMMENT '房间名称',
  `room_type` int(11) NOT NULL COMMENT '房间类型',
  `room_style` int(11) NOT NULL COMMENT '房间风格',
  `room_turn` tinyint(2) NOT NULL COMMENT '房间朝向， 1正南/2正北/3正东/4正西/5东南/6西南/7东北/8西北',
  `room_area` int(11) NOT NULL COMMENT '房间面积',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态-1维修 0关闭 ，1开启',
  `admin_id` int(11) NOT NULL COMMENT '操作管理员id',
  `club_id` int(11) NOT NULL COMMENT '会所id',
  `sort_at` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='房间房号信息管理';


DROP TABLE IF EXISTS `zhihu_room_order`;
CREATE TABLE `zhihu_room_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL COMMENT '订单id',
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `room_id` int(11) NOT NULL COMMENT '房间号id',
  `check_in_time` int(11) NOT NULL DEFAULT '0' COMMENT '预住时间',
  `live_in_time` int(11) NOT NULL DEFAULT '0' COMMENT '入住时间',
  `schedule_day` int(11) NOT NULL COMMENT '天数',
  `status` int(11) NOT NULL COMMENT '状态 1 预约，2入住，3续住，4退房',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '更新时间',
  `club_id` int(11) NOT NULL COMMENT '会所id',
  `admin_id` int(11) NOT NULL COMMENT '录单人',
  `schedule_id` int(11) NOT NULL COMMENT '档期id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='房间入住订单管理';


DROP TABLE IF EXISTS `zhihu_room_schedule`;
CREATE TABLE `zhihu_room_schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `room_id` int(11) NOT NULL COMMENT '房间id',
  `start_time` int(11) NOT NULL COMMENT '开始时间',
  `end_time` int(11) NOT NULL COMMENT '结束时间',
  `notes` varchar(200) NOT NULL COMMENT '备注',
  `status` tinyint(2) NOT NULL COMMENT '档期[房间状态] 0空挡 1 预定，2入住 ',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '更时间',
  `club_id` int(11) NOT NULL COMMENT '会所id',
  `admin_id` int(11) NOT NULL COMMENT '操作人',
  `user_id` int(11) NOT NULL COMMENT 'user_id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='房间档期管理';


DROP TABLE IF EXISTS `zhihu_room_type`;
CREATE TABLE `zhihu_room_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `club_id` int(11) NOT NULL COMMENT '会所id',
  `name` varchar(100) NOT NULL COMMENT '房型名称',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `admin_id` int(11) NOT NULL COMMENT '管理员',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='房型管理';


DROP TABLE IF EXISTS `view_room_busy_now`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_room_busy_now` AS select `ri`.`id` AS `room_id`,`ri`.`club_id` AS `club_id`,`rs`.`id` AS `schedule_id`,`rs`.`status` AS `status` from (`zhihu_room_info` `ri` left join `zhihu_room_schedule` `rs` on((`ri`.`id` = `rs`.`room_id`))) where ((`ri`.`status` > 0) and (`rs`.`status` > 0) and (`rs`.`start_time` < unix_timestamp()) and (`rs`.`end_time` > unix_timestamp()));

DROP TABLE IF EXISTS `view_room_useable_now`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_room_useable_now` AS select `ri`.`id` AS `room_id`,`rs`.`id` AS `schedule_id`,-(1) AS `status`,`ri`.`club_id` AS `club_id` from (`zhihu_room_info` `ri` left join `zhihu_room_schedule` `rs` on((`ri`.`id` = `rs`.`room_id`))) where (`ri`.`status` = -(1)) union select `ri`.`id` AS `room_id`,`v`.`schedule_id` AS `schedule_id`,`v`.`status` AS `status`,`ri`.`club_id` AS `club_id` from (`zhihu_room_info` `ri` left join `view_room_busy_now` `v` on((`ri`.`id` = `v`.`room_id`))) where ((`ri`.`status` > 0) and `ri`.`id` in (select `view_room_busy_now`.`room_id` from `view_room_busy_now`)) union select `ri`.`id` AS `room_id`,`v`.`schedule_id` AS `schedule_id`,0 AS `status`,`ri`.`club_id` AS `club_id` from (`zhihu_room_info` `ri` left join `view_room_busy_now` `v` on((`ri`.`id` = `v`.`room_id`))) where ((`ri`.`status` > 0) and (not(`ri`.`id` in (select `view_room_busy_now`.`room_id` from `view_room_busy_now`))));

-- 2018-06-10 16:01:45



