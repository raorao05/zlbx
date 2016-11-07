<?php

/**
 * ECSHOP 管理中心秒杀活动语言文件
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: seckill.php 17217 2011-01-19 06:29:08Z liubo $
 */

/* menu */
$_LANG['seckill_list'] = '秒杀活动列表';
$_LANG['add_seckill'] = '添加秒杀活动';
$_LANG['edit_seckill'] = '编辑秒杀活动';
$_LANG['seckill_log'] = '秒杀活动出价记录';
$_LANG['continue_add_seckill'] = '继续添加秒杀活动';
$_LANG['back_seckill_list'] = '返回秒杀活动列表';
$_LANG['add_seckill_ok'] = '添加秒杀活动成功';
$_LANG['edit_seckill_ok'] = '编辑秒杀活动成功';
$_LANG['settle_deposit_ok'] = '处理冻结的保证金成功';

/* list */
$_LANG['act_is_going'] = '仅显示进行中的活动';
$_LANG['act_name'] = '秒杀活动名称';
$_LANG['goods_name'] = '商品名称';
$_LANG['start_time'] = '开始时间';
$_LANG['end_time'] = '结束时间';
$_LANG['deposit'] = '保证金';
$_LANG['start_price'] = '起拍价';
$_LANG['end_price'] = '一口价';
$_LANG['amplitude'] = '加价幅度';
$_LANG['seckill_not_exist'] = '您要操作的秒杀活动不存在';
$_LANG['seckill_cannot_remove'] = '该秒杀活动已经有人出价，不能删除';
$_LANG['js_languages']['batch_drop_confirm'] = '您确实要删除选中的秒杀活动吗？';
$_LANG['batch_drop_ok'] = '操作完成（已经有人出价的秒杀活动不能删除）';
$_LANG['no_record_selected'] = '没有选择记录';
$_LANG['label_goods_num']='秒杀数量：';
/* info */
$_LANG['label_act_name'] = '秒杀活动名称：';
$_LANG['notice_act_name'] = '如果留空，取秒杀商品的名称（该名称仅用于后台，前台不会显示）';
$_LANG['label_act_desc'] = '秒杀活动描述：';
$_LANG['label_search_goods'] = '根据商品编号、名称或货号搜索商品';
$_LANG['label_goods_name'] = '秒杀商品名称：';
$_LANG['label_start_time'] = '秒杀开始时间：';
$_LANG['label_end_time'] = '秒杀结束时间：';
$_LANG['label_status'] = '当前状态：';
$_LANG['label_start_price'] = '起拍价：';
$_LANG['label_end_price'] = '一口价：';
$_LANG['label_no_top'] = '无封顶';
$_LANG['label_amplitude'] = '加价幅度：';
$_LANG['label_deposit'] = '保证金：';
$_LANG['bid_user_count'] = '已有 %s 个买家出价';
$_LANG['settle_frozen_money'] = '怎样处理买家的冻结资金？';
$_LANG['unfreeze'] = '解冻保证金';
$_LANG['deduct'] = '扣除保证金';
$_LANG['invalid_status'] = '当前状态不正确';
$_LANG['no_deposit'] = '没有保证金需要处理';
$_LANG['unfreeze_seckill_deposit'] = '解冻秒杀活动的保证金：%s';
$_LANG['deduct_seckill_deposit'] = '扣除秒杀活动的保证金：%s';

$_LANG['seckill_status'][PRE_START] = '未开始';
$_LANG['seckill_status'][UNDER_WAY] = '进行中';
$_LANG['seckill_status'][FINISHED] = '已结束';
$_LANG['seckill_status'][SETTLED] = '已结束';

$_LANG['pls_search_goods'] = '请先搜索商品';
$_LANG['search_result_empty'] = '没有找到商品，请重新搜索';

$_LANG['pls_select_goods'] = '请选择秒杀商品';
$_LANG['goods_not_exist'] = '您要秒杀的商品不存在';

$_LANG['js_languages']['start_price_not_number'] = '起拍价格式不正确（数字）';
$_LANG['js_languages']['end_price_not_number'] = '一口价格式不正确（数字）';
$_LANG['js_languages']['end_gt_start'] = '一口价应该大于起拍价';
$_LANG['js_languages']['amplitude_not_number'] = '加价幅度格式不正确（数字）';
$_LANG['js_languages']['deposit_not_number'] = '保证金格式不正确（数字）';
$_LANG['js_languages']['start_lt_end'] = '秒杀开始时间不能大于结束时间';
$_LANG['js_languages']['search_is_null'] = '没有搜索到任何商品，请重新搜索';

/* log */
$_LANG['bid_user'] = '买家';
$_LANG['bid_price'] = '出价';
$_LANG['bid_time'] = '时间';
$_LANG['status'] = '状态';

?>