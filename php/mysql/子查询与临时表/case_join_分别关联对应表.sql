

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


#发现问题,分开联表时,t.role的数据交叉有问题,因为t.role=1时只联月嫂,不联育婴师.但是以上语句同时联表,月嫂+育婴师.
select dc.id,dc.order_id,dc.user_id,dc.yuesao_id,dc.role,do.username,do.product_days,du.nickname,du.headphoto from ddys_comment_yuesao as dc left join ddys_order as do on dc.order_id=do.id left join ddys_user_info du on dc.user_id=du.id where dc.id in (334,236,331)
// 最终整合版
select
    t.*,
    details.*
from
    (select dc.id,dc.order_id,dc.user_id,dc.yuesao_id,dc.role,do.username,do.product_days,du.nickname,du.headphoto from ddys_comment_yuesao as dc left join ddys_order as do on dc.order_id=do.id left join ddys_user_info du on dc.user_id=du.id where dc.id in (334,236,331)
    ) as t
    inner join(
        (select ys.id as detail_id,IF(1,1,0) as detail_role,ys.icon,ys.name from ddys_caregiver as ys)
        union
        (select yy.id as detail_id,IF(1,2,0) as detail_role,yy.icon,yy.name from ddys_skiller_yuying as yy)
    ) as details on details.detail_id=t.yuesao_id and details.detail_role=t.role
#它的奥秒在于子查询中多了一个模拟的变量.detail_role.而这个变量很关键,如果没有这个变量,则查询结果 完全是错的.



-- 改进,初筛
SELECT dc.id, dc.order_id, dc.user_id, dc.yuesao_id, dc.role
    , do.username, do.product_days, du.nickname, du.headphoto
FROM ddys_comment_yuesao dc
    LEFT JOIN ddys_order do ON dc.order_id = do.id
    LEFT JOIN ddys_user_info du ON dc.user_id = du.id
WHERE dc.id IN (334, 236, 331)


-- id  order_id    user_id yuesao_id   role    username    product_days    nickname    headphoto
-- 236 1349    65  121 1   第11单    26  唐艳  1470969134099P6da5U
-- 331 1395    65  35  1   测试广州    27  唐艳  1470969134099P6da5U
-- 334 1583    37  4   2   dfgdf   26      1465986801973I1505Z



-- 完全不烧脑的视图抽象思维
select * from
(
    SELECT 'yuesao' as role_name,dc.id, dc.order_id, dc.user_id, dc.yuesao_id, dc.role
        , do.username, do.product_days, du.nickname, du.headphoto
    FROM ddys_comment_yuesao dc
        LEFT JOIN ddys_order do ON dc.order_id = do.id
        LEFT JOIN ddys_user_info du ON dc.user_id = du.id
    left join ddys_caregiver as sk on dc.yuesao_id=sk.id
    where dc.role=1
    UNION
    SELECT 'yuying' as role_name,dc.id, dc.order_id, dc.user_id, dc.yuesao_id, dc.role
        , do.username, do.product_days, du.nickname, du.headphoto
    FROM ddys_comment_yuesao dc
        LEFT JOIN ddys_order do ON dc.order_id = do.id
        LEFT JOIN ddys_user_info du ON dc.user_id = du.id
    left join ddys_skiller_yuying as sk on dc.yuesao_id=sk.id
    where dc.role=2
)_
WHERE id IN (334, 236, 331)


-- role_name   id  order_id    user_id yuesao_id   role    username    product_days    nickname    headphoto
-- yuesao  236 1349    65  121 1   第11单    26  唐艳  1470969134099P6da5U
-- yuesao  331 1395    65  35  1   测试广州    27  唐艳  1470969134099P6da5U
-- yuying  334 1583    37  4   2   dfgdf   26      1465986801973I1505Z




