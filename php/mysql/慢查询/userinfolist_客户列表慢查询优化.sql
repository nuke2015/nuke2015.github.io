

-- 查数据,ok
select
user_info.id, user_info.user_name, user_info.phone, user_info.customer_origin, user_info.first_source, user_info.status_live, user_info.create_at,user_info.schedule_date,user_info.idcard,
user_map.create_time,
IFNULL(user_belong.category,0) as category,
member.name as saler_name,
IFNULL(attention_user.status,0) as attension
from zhihu_user_info as user_info
left join zhihu_user_map as user_map on user_info.id = user_map.user_id and user_map.club_id=131
left join zhihu_user_belong as user_belong on user_belong.user_id = user_info.id and user_belong.status = 1
left join zhihu_group_member as group_member on user_belong.group_member_id = group_member.id and group_member.group_id in(3,6,12)
left join zhihu_member as member on member.id = group_member.member_id and member.status = 1
left join zhihu_attention_user as attention_user on attention_user.user_id = user_info.id and attention_user.member_id = 2775
left join zhihu_user_label_map as user_label_map ON user_label_map.user_id = user_info.id
left join zhihu_user_will_map as user_will_map ON user_will_map.user_id = user_info.id
where user_info.club_id=131 and user_info.status=1 and user_info.phone!='' and user_info.id not in (select user_id from zhihu_user_collect_pool where club_id = 131)
GROUP BY user_info.id
limit 20



-- 查条数
select count(*) as count from (select
user_info.id, user_info.user_name, user_info.phone, user_info.customer_origin, user_info.first_source, user_info.status_live, user_info.create_at,user_info.schedule_date,user_info.idcard,
user_map.create_time,
IFNULL(user_belong.category,0) as category,
member.name as saler_name,
IFNULL(attention_user.status,0) as attension
from zhihu_user_info as user_info
left join zhihu_user_map as user_map on user_info.id = user_map.user_id  and user_map.club_id=131
left join zhihu_user_belong as user_belong on user_belong.user_id = user_info.id and user_belong.status = 1
left join zhihu_group_member as group_member on user_belong.group_member_id = group_member.id and group_member.group_id in(3,6,12)
left join zhihu_member as member on member.id = group_member.member_id and member.status = 1
left join zhihu_attention_user as attention_user on attention_user.user_id = user_info.id and attention_user.member_id = 2775
left join zhihu_user_label_map as user_label_map ON user_label_map.user_id = user_info.id
left join zhihu_user_will_map as user_will_map ON user_will_map.user_id = user_info.id
where user_info.club_id=131 and user_info.status=1 and user_info.phone!='' and user_info.id not in (select user_id from zhihu_user_collect_pool where club_id = 131)
GROUP BY user_info.id)_




-- 转写法0.221
select
count(distinct(user_info.id))
from zhihu_user_info as user_info
left join zhihu_user_map as user_map on user_info.id = user_map.user_id  and user_map.club_id=131
left join zhihu_user_belong as user_belong on user_belong.user_id = user_info.id and user_belong.status = 1
left join zhihu_group_member as group_member on user_belong.group_member_id = group_member.id and group_member.group_id in(3,6,12)
left join zhihu_member as member on member.id = group_member.member_id and member.status = 1
left join zhihu_attention_user as attention_user on attention_user.user_id = user_info.id and attention_user.member_id = 2775
left join zhihu_user_label_map as user_label_map ON user_label_map.user_id = user_info.id
left join zhihu_user_will_map as user_will_map ON user_will_map.user_id = user_info.id
where user_info.club_id=131 and user_info.status=1 and user_info.phone!='' and user_info.id not in (select user_id from zhihu_user_collect_pool where club_id = 131)


-- 进一步试探写法0.211
select
count(*)
from zhihu_user_info as user_info
left join zhihu_user_map as user_map on user_info.id = user_map.user_id  and user_map.club_id=131
left join zhihu_user_belong as user_belong on user_belong.user_id = user_info.id and user_belong.status = 1
left join zhihu_group_member as group_member on user_belong.group_member_id = group_member.id and group_member.group_id in(3,6,12)
left join zhihu_member as member on member.id = group_member.member_id and member.status = 1
left join zhihu_attention_user as attention_user on attention_user.user_id = user_info.id and attention_user.member_id = 2775
left join zhihu_user_label_map as user_label_map ON user_label_map.user_id = user_info.id
left join zhihu_user_will_map as user_will_map ON user_will_map.user_id = user_info.id
where user_info.club_id=131 and user_info.status=1 and user_info.phone!='' and user_info.id not in (select user_id from zhihu_user_collect_pool where club_id = 131)


-- 找原因
explain
select
count(*)
from zhihu_user_info as user_info
left join zhihu_user_map as user_map on user_info.id = user_map.user_id  and user_map.club_id=131
left join zhihu_user_belong as user_belong on user_belong.user_id = user_info.id and user_belong.status = 1
left join zhihu_group_member as group_member on user_belong.group_member_id = group_member.id and group_member.group_id in(3,6,12)
left join zhihu_member as member on member.id = group_member.member_id and member.status = 1
left join zhihu_attention_user as attention_user on attention_user.user_id = user_info.id and attention_user.member_id = 2775
left join zhihu_user_label_map as user_label_map ON user_label_map.user_id = user_info.id
left join zhihu_user_will_map as user_will_map ON user_will_map.user_id = user_info.id
where user_info.club_id=131 and user_info.status=1 and user_info.phone!='' 


-- 结果良好
id  select_type table   type    possible_keys   key key_len ref rows    Extra
1   SIMPLE  user_info   ref club_id club_id 4   const   12513   Using where
1   SIMPLE  user_map    ref user_id,club_id user_id 4   didiys_tester.user_info.id  1   Using where
1   SIMPLE  user_belong eq_ref  user_id user_id 4   didiys_tester.user_info.id  1   Using where
1   SIMPLE  group_member    eq_ref  PRIMARY,group_id    PRIMARY 4   didiys_tester.user_belong.group_member_id   1   Using where
1   SIMPLE  member  eq_ref  PRIMARY PRIMARY 4   didiys_tester.group_member.member_id    1   Using where
1   SIMPLE  attention_user  ref user_id,member_id   user_id 4   didiys_tester.user_info.id  1   Using where
1   SIMPLE  user_label_map  ref user_id user_id 4   didiys_tester.user_info.id  1   Using index
1   SIMPLE  user_will_map   ref user_id user_id 4   didiys_tester.user_info.id  1   Using index


-- 浓缩0.023
select
count(*)
from zhihu_user_info as user_info
where user_info.club_id=131 and user_info.status=1 and user_info.phone!='' 


-- 探索0.006
select
count(*)
from zhihu_user_info as user_info
where user_info.club_id=131  

-- 尝试给user_info的status加索引,结果一样.
-- 说明给status字段加索引,并不是有效的解决办法.


-- 结果explain
id  select_type table   type    possible_keys   key key_len ref rows    Extra
1   SIMPLE  user_info   ref club_id club_id 4   const   12513   Using where



-- 造个视图用少的字段，慎用视图，可能有性能问题。
select
user_info.id,  user_info.phone, user_info.status,user_info.club_id
from zhihu_user_info as user_info



-- 试试视图效果,0.028
select count(*) as count from (select
user_info.id
from test as user_info
left join zhihu_user_map as user_map on user_info.id = user_map.user_id  and user_map.club_id=131
left join zhihu_user_belong as user_belong on user_belong.user_id = user_info.id and user_belong.status = 1
left join zhihu_group_member as group_member on user_belong.group_member_id = group_member.id and group_member.group_id in(3,6,12)
left join zhihu_member as member on member.id = group_member.member_id and member.status = 1
left join zhihu_attention_user as attention_user on attention_user.user_id = user_info.id and attention_user.member_id = 2775
left join zhihu_user_label_map as user_label_map ON user_label_map.user_id = user_info.id
left join zhihu_user_will_map as user_will_map ON user_will_map.user_id = user_info.id
where user_info.club_id=131 and user_info.status=1 and user_info.phone!='' and user_info.id not in (select user_id from zhihu_user_collect_pool where club_id = 131)
GROUP BY user_info.id)_



-- 回归检验,浓缩0.023
select
count(*)
from test as user_info
where user_info.club_id=131 and user_info.status=1 and user_info.phone!='' 




-- 结论:就是user_info表的status检索如何变快的问题.
-- 附user_info字段类型:
-- 列   类型  注释
-- id  int(11) 自动增量     
-- user_name   varchar(50) 客户姓名
-- nickname    varchar(50) []  昵称
-- phone   char(11)    用户手机号
-- status  tinyint(4) [1]  状态[-1删除0草稿1正常]
-- status_live tinyint(4) [1]  入住状态:[0不确定1未入住2入住中3已离店]
-- review_time int(11) 复查时间
-- update_time int(11) 更新时间
-- create_at   int(11) 注册时间
-- role    tinyint(1) [1]  角色[1普通2销售推广员]
-- remark  varchar(250)    备注信息
-- desp    varchar(250) [] 个性签名
-- thumb   varchar(250) [] 用户头像
-- admin_id    int(11) 创建者id
-- club_id int(11) 会所id




