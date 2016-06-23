-- Adminer 3.6.1 MySQL dump

SET NAMES utf8;
SET foreign_key_checks = 0;
SET time_zone = 'SYSTEM';
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DELIMITER ;;

DROP PROCEDURE IF EXISTS `pro_get_postdetail`;;
CREATE PROCEDURE `pro_get_postdetail`(in postId long)
begin

 select 
         sp.*,
         tp.id as tp_id,tp.post_id,tp.topic_id,tp.topic_name,tp.locx,tp.locy,tp.width,
         pu.user_id as pu_user_id,pu.nick as pu_nick,pu.head_img as pu_head_img,pu.istalent as pu_istalent
         
         ,
         cc.cc_id,cc.content as cc_content,cc.parent_id as cc_parent_id,
          cu.user_id as cu_user_id,cu.nick as cu_nick,cu.head_img as cu_head_img,cu.istalent as cu_istalent,
          
         parentC.id as pcc_id,parentC.content as pcc_content,parentC.parent_id as pcc_parent_id,
         pcu.user_id as pcu_user_id,pcu.nick as pcu_nick,pcu.head_img as pcu_head_img,pcu.istalent as pcu_istalent,
         
         ll.ll_id ,
         llu.user_id as llu_user_id,llu.nick as llu_nick,llu.head_img as llu_head_img,llu.istalent as llu_istalent
         
         from shequ_post sp
          inner join shequ_post_topic tp on tp.post_id = sp.id
		   left join user pu on pu.user_id=sp.user_id
                  left JOIN (
            SELECT id, MAX(rn) AS mx
            FROM (
                SELECT 
                    IF(@C != sp.id, @ROWNUM := 1, @ROWNUM := @ROWNUM +1) AS rn,
                    @C := sp.id,
                    sp.id
              FROM  (select * from shequ_post where id=postId) sp
                    left JOIN comment cc ON sp.id = cc.relate_id and sp.id=postId and cc.type=3 
                    CROSS JOIN (SELECT @C := '') t2
                     
                ORDER BY cc.create_time desc
            ) t
            GROUP BY id
        ) maxcomment ON maxcomment.id = sp.id 
   left JOIN (
            SELECT 
                IF(@C != sp.id, @ROWNUM := 1, @ROWNUM := @ROWNUM +1) AS RN,
                @C := sp.id,
                sp.id,
                cc.id as cc_id,cc.content ,cc.relate_id,cc.user_id,cc.parent_id,cc.create_time
             FROM  (select * from shequ_post where id=postId) sp
                left JOIN comment cc ON sp.id = cc.relate_id  and sp.id=postId and cc.type=3 
                CROSS JOIN (SELECT @C := '') t2
                 
            ORDER BY cc.create_time desc
        ) cc ON sp.id = cc.relate_id  AND cc.rn >maxcomment.mx+(maxcomment.mx-10)
 
left join user cu on cu.user_id=cc.user_id
left join comment parentC on parentC.id=cc.parent_id and cc.parent_id >0
left join user pcu on pcu.user_id=parentC.user_id

left  JOIN (
            SELECT id, MAX(rn) AS mx
            FROM (
                SELECT 
                    IF(@C != sp.id, @ROWNUM := 1, @ROWNUM := @ROWNUM +1) AS rn,
                    @C := sp.id,
                    sp.id
                   FROM  (select * from shequ_post where id=postId) sp
                   left JOIN shequ_like_post ll ON sp.id = ll.post_id and sp.id=postId
                    CROSS JOIN (SELECT @C := '') t2
                    
                ORDER BY ll.create_time desc
            ) t
            GROUP BY id
        ) maxlike ON maxlike.id = sp.id
left JOIN (
            SELECT 
                IF(@C != sp.id, @ROWNUM := 1, @ROWNUM := @ROWNUM +1) AS RN,
                @C := sp.id,
                sp.id,
                ll.id as ll_id,ll.post_id,ll.user_id,ll.create_time
               FROM  (select * from shequ_post where id=postId) sp
                left JOIN shequ_like_post ll ON sp.id = ll.post_id and sp.id=postId
                CROSS JOIN (SELECT @C := '') t2
              
            ORDER BY ll.create_time desc
        ) ll ON sp.id = ll.post_id and ll.rn>maxcomment.mx+(maxcomment.mx-10)
       left join user llu on llu.user_id=ll.user_id
       where sp.id=postId;
       
end;;

DROP PROCEDURE IF EXISTS `pro_test_addvoucher`;;
CREATE PROCEDURE `pro_test_addvoucher`()
begin
 declare a int default 4;
 while a<10 do
   insert into store_voucher(voucher_type,amount,voucher_desc,owner,create_time,valid_date,status,is_delete,check_code,salt_str)
select voucher_type, 1,voucher_desc,551416,create_time,valid_date,status,is_delete,check_code,salt_str from store_voucher where status=0 LIMIT 1;
   set a=a+1;
 end while;
end;;

DELIMITER ;

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `phone` varchar(15) NOT NULL COMMENT '�û��ֻ���',
  `email` varchar(50) NOT NULL COMMENT '�û�ע������',
  `open_id` varchar(150) NOT NULL COMMENT '΢�š�qq��¼���ص�openid',
  `reg_type` smallint(6) NOT NULL COMMENT '0�ֻ�,1����,2΢��,3QQ,4΢��,5tcl�˺�,6�Ա�',
  `nick` varchar(50) NOT NULL,
  `head_img` varchar(200) NOT NULL COMMENT 'ͷ��ͼƬid',
  `user_tag` varchar(150) NOT NULL COMMENT 'ע��ʱ��ѡ            ��ĸ��ֱ�ǩ��, ,�ָ��һ��id            ,id1,id2,......id10,',
  `user_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0���� 1���� 2ɾ��',
  `reg_time` datetime NOT NULL COMMENT '�û�ע���ʱ��, Ĭ�ϵ�ǰ���ݿ������ʱ��',
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '�û����¸������ϵ����²���ʱ��',
  `gender` tinyint(4) NOT NULL COMMENT '�Ա�,0-δ�1-�У�2-Ů',
  `birthday` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '��������',
  `user_role` bigint(20) NOT NULL COMMENT '�û���ɫ,������Ⱥ������е�����id',
  `isinitshequ` int(11) DEFAULT NULL COMMENT '0��ʾû�г�ʼ��������1��ʾ��ʼ�����������û�',
  `background` varchar(200) NOT NULL COMMENT '���˱���ͼ',
  `areaid` int(11) DEFAULT NULL,
  `declaration` varchar(1000) DEFAULT NULL COMMENT '��ʳ����',
  `istalent` int(11) DEFAULT '0' COMMENT 'Ĭ�ϲ��Ǵ���[0��ʾ��ͨ�û�1��ʾ����2,��ʾϵͳ�ٷ���]',
  `wx_unionid` varchar(150) DEFAULT NULL,
  `salt` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `open_id_reg_type` (`open_id`,`reg_type`),
  KEY `phone` (`phone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='֧���ֻ���+��֤���¼,��������֧���ʼ�ע�ᡢ��¼��';


-- 2016-05-06 15:44:06
