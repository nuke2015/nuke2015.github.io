


-- 查找数据表中的重复数据
Select * From 表 Where 重复字段 In (Select 重复字段 From 表 Group By 重复字段 Having Count(*)>1)

-- 如
select id,group_id,member_id,club_id from zhihu_group_member where member_id in
(
    select member_id from zhihu_group_member group by member_id having count(*)>1
)





-- 删除重复

delete from zhihu_rbac_role_member
where id in 
(
        
    -- 重复
    select id from zhihu_rbac_role_member where concat(member_id,club_id) in
    (
        select concat(member_id,club_id)  from zhihu_rbac_role_member group by concat(member_id,club_id)  having count(*)>1
    ) 
)

-- 查询出错 (1093): You can't specify target table 'zhihu_rbac_role_member' for update in FROM clause



