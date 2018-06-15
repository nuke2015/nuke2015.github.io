
/**
 * 2018年6月9日 17:06:12
 * 业务描述:
 * 有product表负责做产品,产品包含有两类(物料/服务).
 * 有product_attrsku负责做产品关联属性(物料/服务都可以有很多的扩展属性)
 * 有package表负责做套餐(套餐有两类,免费(赠品)+付费),套餐来自,product+product_attrsku的组合选择.
 * 不同的组合产生不同的报价.
 * 套餐只有一个总价,属性有独立的单元报价.prodcut可关联attrsku,也可以不关联attrsku.
 * 需求是:
 * 把订单购买的服务类产品都抽离出来
 * 订单可购买,product,product_attrsku,package,同时这几种都是(物料/服务)都有.
 * 比如,套餐可以有物料+服务+物料细分属性+服务细分属性这几种.
 * 最终展现的数据,如果有细分属性attrsku,需要展示购买产品的细分属性.
 * 
 */




-- 真不敢相信,这么复杂的sql语句,居然是我写的.


--   #view_to_service_from_order_goods
SELECT `og`.`id` AS `goods_id`, `og`.`refer_type` AS `refer_type`, `og`.`refer_id` AS `refer_id`, `og`.`title` AS `title`, `og`.`amount` AS `amount`
    , `pr`.`title` AS `pr_title`, `pr`.`category_id` AS `pr_category_id`, `pr`.`id` AS `pr_id`, 0 AS `pa_id`, 0 AS `pa_title`
    , `og`.`club_id` AS `club_id`
FROM `bestphp_order_goods` `og`
    LEFT JOIN `bestphp_product` `pr` ON `og`.`refer_id` = `pr`.`id`
WHERE `og`.`refer_type` = 1
    AND `og`.`id` IN (
        SELECT `view_order_goods_service`.`id` AS `goods_id_tmp`
        FROM `view_order_goods_service`
    )
UNION
SELECT `og`.`id` AS `goods_id`, `og`.`refer_type` AS `refer_type`, `og`.`refer_id` AS `refer_id`, `og`.`title` AS `title`, `og`.`amount` AS `amount`
    , `v`.`pr_title` AS `pr_title`, `v`.`pr_category_id` AS `pr_category_id`, `v`.`pr_id` AS `pr_id`, `v`.`pa_id` AS `pa_id`, `v`.`pa_title` AS `pa_title`
    , `og`.`club_id` AS `club_id`
FROM `bestphp_order_goods` `og`
    LEFT JOIN `view_to_product_from_attrsku` `v` ON `og`.`refer_id` = `v`.`pa_id`
WHERE `og`.`refer_type` = 2
    AND `og`.`id` IN (
        SELECT `view_order_goods_service`.`id` AS `goods_id_tmp`
        FROM `view_order_goods_service`
    )
UNION ALL
SELECT `og`.`id` AS `goods_id`, `og`.`refer_type` AS `refer_type`, `og`.`refer_id` AS `refer_id`
    , concat(`og`.`title`, '(', `v`.`pr_title`, ')') AS `title`
    , `pl`.`amount` AS `amount`, `v`.`pr_title` AS `pr_title`, `v`.`pr_category_id` AS `pr_category_id`, `v`.`pr_id` AS `pr_id`, `v`.`pa_id` AS `pa_id`
    , `v`.`pa_title` AS `pa_title`, `og`.`club_id` AS `club_id`
FROM `bestphp_order_goods` `og`
    LEFT JOIN `view_to_product_from_package_relate` `v` ON `og`.`refer_id` = `v`.`pk_id`
    LEFT JOIN `bestphp_package_relate` `pl` ON `v`.`pl_id` = `pl`.`id`
WHERE (`og`.`refer_type` = 3)
    AND `og`.`id` IN (
        SELECT `view_order_goods_service`.`id` AS `goods_id_tmp`
        FROM `view_order_goods_service`
    )
    AND `v`.`pl_id` IN (
        SELECT `view_package_relate_service`.`id` AS `relate_id`
        FROM `view_package_relate_service`
    )





