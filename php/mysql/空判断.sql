

-- 非空判断
select t.*,di.jjysid,di.idcard as b
from ddys_exam_student as t
left join ddys_idcard_jjysid as di
on t.idcard=di.idcard
where t.idcard<>'' and not ISNULL(di.jjysid)



-- 空判断
select t.*,di.jjysid,di.idcard as b
from ddys_exam_student as t
left join ddys_idcard_jjysid as di
on t.idcard=di.idcard
where t.idcard<>'' and ISNULL(di.jjysid)


