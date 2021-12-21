


-- 以下查询在高版本的mysql执行不了

update ddys_order
	set process=3
	where id in

	(
		select order_id
		from ddys_order as od
		right join
		ddys_order_caregiver_server as ocs
		on od.id=ocs.order_id
		where ocs.service_end>=1640066589
		and od.process=4
	)




-- 中间,绕两回,再执行,完美通过

update ddys_order
	set process=3
	where id in
(
	select * from

	(
		select order_id
		from ddys_order as od
		right join
		ddys_order_caregiver_server as ocs
		on od.id=ocs.order_id
		where ocs.service_end>=1640066589
		and od.process=4
	)_


)