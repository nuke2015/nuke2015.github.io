



当前房间总数:
select count(ri.id) as room_count,rt.id,rt.name from zhihu_room_info as ri
left join zhihu_room_type as rt
on ri.room_type=rt.id
group by rt.id



room_count  id  name
10  5   舒适房
4   6   家居房
6   7   豪华套房
3   8   套房
2   9   360度无死角海景房

select
count(ri.id) as room_count,
rt.id as room_type,rt.name as room_type_name,
count(us.room_id) as room_schedule

from zhihu_room_info as ri

left join zhihu_room_type as rt
on ri.room_type=rt.id

left join view_room_useable_now as us
on ri.id=us.room_id and us.status=1

group by rt.id



room_count  room_type   room_type_name  room_schedule
10  5   舒适房 2
4   6   家居房 1
6   7   豪华套房    1
3   8   套房  0
2   9   360度无死角海景房  0




select
count(ri.id) as room_count,
rt.id as room_type,rt.name as room_type_name,
count(sc.room_id) as room_schedule,
count(li.room_id) as room_live

from zhihu_room_info as ri

left join zhihu_room_type as rt
on ri.room_type=rt.id

left join view_room_useable_now as sc
on ri.id=sc.room_id and sc.status=1

left join view_room_useable_now as li
on ri.id=li.room_id and li.status=2

group by rt.id



room_count  room_type   room_type_name  room_schedule   room_live
10  5   舒适房 2   0
4   6   家居房 1   0
6   7   豪华套房    1   1
3   8   套房  0   0
2   9   360度无死角海景房  0   0





select
count(ri.id) as room_count,
rt.id as room_type,rt.name as room_type_name,
count(sc.room_id) as room_schedule,
count(li.room_id) as room_live,
count(fr.room_id) as room_free

from zhihu_room_info as ri

left join zhihu_room_type as rt
on ri.room_type=rt.id

left join view_room_useable_now as sc
on ri.id=sc.room_id and sc.status=1

left join view_room_useable_now as li
on ri.id=li.room_id and li.status=2

left join view_room_useable_now as fr
on ri.id=fr.room_id and fr.status=0

group by rt.id



room_count  room_type   room_type_name  room_schedule   room_live   room_free
10  5   舒适房 2   0   6
4   6   家居房 1   0   3
6   7   豪华套房    1   1   4
3   8   套房  0   0   3
2   9   360度无死角海景房  0   0   1



select
count(ri.id) as room_count,
rt.id as room_type,rt.name as room_type_name,
count(sc.room_id) as room_schedule,
count(li.room_id) as room_live,
count(fr.room_id) as room_free,
count(rp.room_id) as room_repair

from zhihu_room_info as ri

left join zhihu_room_type as rt
on ri.room_type=rt.id

left join view_room_useable_now as sc
on ri.id=sc.room_id and sc.status=1

left join view_room_useable_now as li
on ri.id=li.room_id and li.status=2

left join view_room_useable_now as fr
on ri.id=fr.room_id and fr.status=0

left join view_room_useable_now as rp
on ri.id=rp.room_id and rp.status=-1

group by rt.id



room_count  room_type   room_type_name  room_schedule   room_live   room_free   room_repair
10  5   舒适房 2   0   6   1
4   6   家居房 1   0   3   0
6   7   豪华套房    1   1   4   0
3   8   套房  0   0   3   0
2   9   360度无死角海景房  0   0   1   0




