
//子查询
select * from comment as c where c.relate_id in(select sptmp.id from (SELECT sp.* FROM `shequ_post` as sp ORDER BY `id` DESC LIMIT 10) as sptmp) and c.type=3;


//分组统计汇总 
select * from comment as c where c.relate_id in(select sptmp.id from (SELECT sp.* FROM `shequ_post` as sp ORDER BY `id` DESC LIMIT 10) as sptmp) and c.type=3 group by c.relate_id;


//分组展开
select * from comment as c where c.relate_id in(select sptmp.id from (SELECT sp.* FROM `shequ_post` as sp ORDER BY `id` DESC LIMIT 10) as sptmp) and c.type=3 group by c.relate_id,c.id


//临时表,查出所有收藏量>500的用户.
select * from (select user_id,count(*) as count from user_collection group by user_id ) _ where count>500 order by count DESC limit 0,30


//连跨两表
SELECT i.id as coupon_id,s.service_group_id FROM `ddys_coupon_item` as i left join ddys_coupon_group as g on i.coupon_group_id=g.id right join ddys_coupon_group_service as s on g.id=s.coupon_group_id  WHERE i.id IN (93)


//时间戳格式化
SELECT id,process,status,product_days,from_unixtime(service_start),from_unixtime(service_end),from_unixtime(schedule_date) FROM `ddys_order` WHERE `caregiver_id` = '99' LIMIT 50


