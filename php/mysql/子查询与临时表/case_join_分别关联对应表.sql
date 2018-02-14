
需求描述:
评论表有order_id,user_id,yuesao_id,还有个role,如果role=2就是育婴师,如果role=1就是月嫂.
需要一键提取,评论+订单+用户+角色信息(自动区分月嫂或育婴师)
伪代码:
select * from commnet left join order on order_id left join user on user_id (case role=2 join yuying case role=1 join yuesao) where id in (1,3,5)
这是伪代码,但是运行不了.


以下是破解的过程用if分流:

// 在评论表提取评论
select * from ddys_comment_yuesao as t where id in (334,236,331,167)

// 根据评论表的role,区分月嫂与育婴师
select *,IF(t.role=2,"yuyingshi","yuesao") as rolename from ddys_comment_yuesao as t where id in (334,236,331,167)

// 根据评论表的role,分开关联月嫂表与育婴师表
select *,IF(t.role=2,
(select name from ddys_skiller_yuying as yy where t.yuesao_id=yy.id),
(select name from ddys_caregiver as ys where t.yuesao_id=ys.id)
) as rolename from ddys_comment_yuesao as t where id in (334,236,331,167)

// 根据目标评论数据,提取关联的月嫂+育婴师
select *,IF(t.role=2,
(select name from ddys_skiller_yuying as yy where t.yuesao_id=yy.id),
(select name from ddys_caregiver as ys where t.yuesao_id=ys.id)
) as rolename from (
select dc.id,dc.order_id,dc.user_id,dc.yuesao_id,dc.role,do.username,do.product_days,du.nickname,du.headphoto from ddys_comment_yuesao as dc left join ddys_order as do on dc.order_id=do.id left join ddys_user_info du on dc.user_id=du.id where dc.id in (334,236,331,167)
) as t 


