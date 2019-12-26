





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

