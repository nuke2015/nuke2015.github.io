select
    vs.*,
    si.title
from
    jiazhen_visit_scene as vs
    left join jiazhen_shop_info as si on vs.scene_id_refer = si.id
where
    vs.scene = 1
union
select
    vs.*,
    sk.name as title
from
    jiazhen_visit_scene as vs
    left join jiazhen_skiller as sk on vs.scene_id_refer = sk.id
where
    vs.scene = 2
union
select
    vs.*,
    vd.title
from
    jiazhen_visit_scene as vs
    left join jiazhen_video as vd on vs.scene_id_refer = vd.id
where
    vs.scene = 3
union
select
    vs.*,
    vr.title
from
    jiazhen_visit_scene as vs
    left join jiazhen_club_vr_scene as vr on vs.scene_id_refer = vr.id
where
    vs.scene = 4
union
select
    vs.*,
    ar.title
from
    jiazhen_visit_scene as vs
    left join jiazhen_article as ar on vs.scene_id_refer = ar.id
where
    vs.scene = 5

    