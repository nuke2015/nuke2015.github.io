


-- 查找数据表中的重复数据
Select * From 表 Where 重复字段 In (Select 重复字段 From 表 Group By 重复字段 Having Count(*)>1)

-- 如
select id,group_id,member_id,club_id from zhihu_group_member where member_id in
(
    select member_id from zhihu_group_member group by member_id having count(*)>1
)


