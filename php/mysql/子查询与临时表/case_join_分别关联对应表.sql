

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


##进一步升级,以上sql语句用了if,它是单字段的,如果 需要 月嫂表更多字段就不能用了.
// 用union
select name,icon from ddys_comment_yuesao as t 
left join ddys_caregiver as ys on t.yuesao_id=ys.id and t.role=1
where t.id in (331,334,236,167)
union
select name,icon from ddys_comment_yuesao as t
left join ddys_skiller_yuying as yy on t.yuesao_id=yy.id and t.role=2
where t.id in (331,334,236,167)
// 此sql的问题就是没有共用t变量.


// 进一步实现
select
    t.*,
    details.*,
    case t.role WHEN 2 then 'ddys_skiller_yuying' ELSE 'ddys_caregiver' end as rolename
from
    ddys_comment_yuesao as t
    inner join(
        (select ys.id,ys.icon,ys.name from ddys_caregiver as ys)
        union
        (select yy.id,yy.icon,yy.name from ddys_skiller_yuying as yy)
    ) as details on details.id=t.yuesao_id
where t.id in (331,334,236,167)
// 此sql特别完美能定义各自的字段,同时查询也符合人类的思维模式


// 评论初筛表
select dc.id,dc.order_id,dc.user_id,dc.yuesao_id,dc.role,do.username,do.product_days,du.nickname,du.headphoto from ddys_comment_yuesao as dc left join ddys_order as do on dc.order_id=do.id left join ddys_user_info du on dc.user_id=du.id where dc.id in (334,236,331)
// 最终整合版
select
    t.*,
    details.*
from
    (select dc.id,dc.order_id,dc.user_id,dc.yuesao_id,dc.role,do.username,do.product_days,du.nickname,du.headphoto from ddys_comment_yuesao as dc left join ddys_order as do on dc.order_id=do.id left join ddys_user_info du on dc.user_id=du.id where dc.id in (334,236,331)
    ) as t
    inner join(
        (select ys.id as detail_id,ys.icon,ys.name from ddys_caregiver as ys)
        union
        (select yy.id as detail_id,yy.icon,yy.name from ddys_skiller_yuying as yy)
    ) as details on details.detail_id=t.yuesao_id


#原理伪代码
SELECT
  users.*,
  details.info,
FROM
  users
  INNER JOIN (
    SELECT user_id, info FROM private
    UNION
    SELECT user_id, info FROM company
  ) AS details ON details.user_id = users.id


