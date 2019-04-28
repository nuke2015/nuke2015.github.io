

-- 优惠券,先按status指定顺序排,再按最新
select * from (SELECT gu.`id`,gn.`title`,gu.groupon_id,gu.wxcard_code,gn.`serial_no`,gn.`card_type`,gn.`quantity`,gn.`remark`,gn.`least_cost`,gn.`reduce_cost`,gn.`discount`,gn.`get_limit`,gn.`gifts`,
gu.status as status,gu.time_start as time_start_user,gu.time_end as time_end_user
from zhihu_groupon_user as gu
left join zhihu_groupon as gn
on gu.groupon_id=gn.id
WHERE gu.club_id=2 and gu.user_id=33)_ order by INSTR("0,1,-1",CONCAT(status)),id DESC limit 0,20


