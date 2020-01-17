





-- 重复数据处理
jiazhen_member_role_map

-- 变换,14条
select concat(role_id,member_id) as m from jiazhen_member_role_map

-- 排重,12条
select id,concat(role_id,member_id) as m from jiazhen_member_role_map
group by m


-- 去掉,重复部分
delete from jiazhen_member_role_map where id not in
(
    select id from (
        select id,concat(role_id,member_id) as m from jiazhen_member_role_map
group by m
    )_
)






-- # 场景二
--总数
select id,member_id as m from jiazhen_member_role_map

-- 去重
select id,member_id from jiazhen_member_role_map
group by member_id

-- 捉虫
select id,member_id as m from jiazhen_member_role_map where id not in (
    select id from (
        select id,member_id from jiazhen_member_role_map
        group by member_id
    )_
)


