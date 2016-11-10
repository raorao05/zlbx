<?php

/**
 * ECSHOP 车险统计程序
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: ry $
 * $Id: sale_list.php 17217 2016-11-08 22:46:08Z liubo $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require_once(ROOT_PATH . 'includes/lib_order.php');
require_once(ROOT_PATH . 'languages/' .$_CFG['lang']. '/admin/statistic.php');
$smarty->assign('lang', $_LANG);

if (isset($_REQUEST['act']) && ($_REQUEST['act'] == 'query' ||  $_REQUEST['act'] == 'download'))
{
    /* 检查权限 */
    check_authz_json('sale_order_stats');
    if (strstr($_REQUEST['start_date'], '-') === false)
    {
        $_REQUEST['start_date'] = local_date('Y-m-d', $_REQUEST['start_date']);
        $_REQUEST['end_date'] = local_date('Y-m-d', $_REQUEST['end_date']);
    }
    /*------------------------------------------------------ */
    //--Excel文件下载
    /*------------------------------------------------------ */
    if ($_REQUEST['act'] == 'download')
    {
        $file_name = $_REQUEST['start_date'].'_'.$_REQUEST['end_date'] . '_sale';
        $goods_sales_list = get_sale_list(false);
        header("Content-type: application/vnd.ms-excel; charset=GB2312");
        header("Content-Disposition: attachment; filename=$file_name.xls");

        /* 文件标题 */
        echo ecs_iconv(EC_CHARSET, 'GB2312', $_REQUEST['start_date']. $_LANG['to'] .$_REQUEST['end_date']. '车险销售明细') . "\t\n";

        /* 商品名称,订单号,商品数量,销售价格,销售日期 */
        echo ecs_iconv(EC_CHARSET, 'GB2312', '签单时间') . "\t";
        echo ecs_iconv(EC_CHARSET, 'GB2312', '险种类别') . "\t";
        echo ecs_iconv(EC_CHARSET, 'GB2312', '险种名称') . "\t";
        echo ecs_iconv(EC_CHARSET, 'GB2312', '车牌号') . "\t";
        echo ecs_iconv(EC_CHARSET, 'GB2312', '被保险人名字') . "\t";
        echo ecs_iconv(EC_CHARSET, 'GB2312', '保单号') . "\t";
        echo ecs_iconv(EC_CHARSET, 'GB2312', '保费') . "\t";
        echo ecs_iconv(EC_CHARSET, 'GB2312', '保险生效日') . "\t";
        echo ecs_iconv(EC_CHARSET, 'GB2312', '代理/经纪') . "\t";
        echo ecs_iconv(EC_CHARSET, 'GB2312', '佣金率') . "\t";
        echo ecs_iconv(EC_CHARSET, 'GB2312', '佣金金额') . "\t";
        echo "\n";


        foreach ($goods_sales_list['sale_list_data'] AS $key => $value)
        {
            echo ecs_iconv(EC_CHARSET, 'GB2312', $value['sales_time']) . "\t";
            echo ecs_iconv(EC_CHARSET, 'GB2312', '机动车辆保险') . "\t";
            echo ecs_iconv(EC_CHARSET, 'GB2312', $value['cx_info']['cp_number']) . "\t";
            echo ecs_iconv(EC_CHARSET, 'GB2312', $value['cx_info']['cz_name']) . "\t";
            echo ecs_iconv(EC_CHARSET, 'GB2312', $value['order_sn']) . "\t";
            echo ecs_iconv(EC_CHARSET, 'GB2312', $value['order_amount']) . "\t";
            echo ecs_iconv(EC_CHARSET, 'GB2312', $value['goods_name']) . "\t";
            echo ecs_iconv(EC_CHARSET, 'GB2312', '经纪') . "\t";
            echo ecs_iconv(EC_CHARSET, 'GB2312', $value['yjl']) . "\t";
            echo ecs_iconv(EC_CHARSET, 'GB2312', $value['yj_money']) . "\t";
            echo "\n";
        }
        exit;
    }
    $sale_list_data = get_sale_list();
    $smarty->assign('goods_sales_list', $sale_list_data['sale_list_data']);
    $smarty->assign('filter',       $sale_list_data['filter']);
    $smarty->assign('record_count', $sale_list_data['record_count']);
    $smarty->assign('page_count',   $sale_list_data['page_count']);

    make_json_result($smarty->fetch('cx_stat.htm'), '', array('filter' => $sale_list_data['filter'], 'page_count' => $sale_list_data['page_count']));
}
/*------------------------------------------------------ */
//--商品明细列表
/*------------------------------------------------------ */
else
{
    //die('1');
    /* 权限判断 */
    admin_priv('sale_order_stats');
    /* 时间参数 */
    if (!isset($_REQUEST['start_date']))
    {
        $start_date = local_strtotime('-7 days');
    }
    if (!isset($_REQUEST['end_date']))
    {
        $end_date = local_strtotime('today');
    }
    
    $sale_list_data = get_sale_list();
    /* 赋值到模板 */
    $smarty->assign('filter',       $sale_list_data['filter']);
    $smarty->assign('record_count', $sale_list_data['record_count']);
    $smarty->assign('page_count',   $sale_list_data['page_count']);
    $smarty->assign('goods_sales_list', $sale_list_data['sale_list_data']);
    $smarty->assign('ur_here',          $_LANG['sell_stats']);
    $smarty->assign('full_page',        1);
    $smarty->assign('start_date',       local_date('Y-m-d', $start_date));
    $smarty->assign('end_date',         local_date('Y-m-d', $end_date));
    $smarty->assign('ur_here',      '车险统计');
    $smarty->assign('cfg_lang',     $_CFG['lang']);
    $smarty->assign('action_link',  array('text' => '下载明细','href'=>'#download'));

    /* 显示页面 */
    assign_query_info();
    $smarty->display('cx_stat.htm');
}
/*------------------------------------------------------ */
//--获取销售明细需要的函数
/*------------------------------------------------------ */
/**
 * 取得销售明细数据信息
 * @param   bool  $is_pagination  是否分页
 * @return  array   销售明细数据
 */
function get_sale_list($is_pagination = true){

    /* 时间参数 */
    $filter['start_date'] = empty($_REQUEST['start_date']) ? local_strtotime('-7 days') : local_strtotime($_REQUEST['start_date']);
    $filter['end_date'] = empty($_REQUEST['end_date']) ? local_strtotime('today') : local_strtotime($_REQUEST['end_date']);
  
    /* 查询数据的条件 */
    $where = " WHERE og.order_id = oi.order_id". order_query_sql('finished', 'oi.') .
             " AND oi.bx_type = 2 AND oi.add_time >= '".$filter['start_date']."' AND oi.add_time < ' " . ($filter['end_date'] + 86400) . "'";
    
    $sql = "SELECT COUNT(og.goods_id) FROM " .
           $GLOBALS['ecs']->table('order_info') . ' AS oi,'.
           $GLOBALS['ecs']->table('order_goods') . ' AS og '.
           $where;
    $filter['record_count'] = $GLOBALS['db']->getOne($sql);

    /* 分页大小 */
    $filter = page_and_size($filter);

    $sql = 'SELECT og.goods_id, og.goods_sn, og.goods_name, og.goods_number AS goods_num, og.goods_price '.
           'AS sales_price, oi.add_time AS sales_time, oi.order_amount,oi.order_id, oi.order_sn,oi.user_id AS user_id, '.
            'oi.pay_time ,oi.insure_id, oi.parent_id,oi.start_time,oi.last_time ' .
           "FROM " . $GLOBALS['ecs']->table('order_goods')." AS og, ".$GLOBALS['ecs']->table('order_info')." AS oi ".
           $where. " ORDER BY sales_time DESC, goods_num DESC";
    //echo $sql;
    if ($is_pagination)
    {
        $sql .= " LIMIT " . $filter['start'] . ', ' . $filter['page_size'];
    }

    $sale_list_data = $GLOBALS['db']->getAll($sql);

    $affiliate_config = get_affiliate();
    $yjl = $affiliate_config['config']['level_money_all']; // 佣金率
//    print_r($affiliate_config);
//    exit;

    foreach ($sale_list_data as $key => $item)
    {
        $sale_list_data[$key]['sales_price'] = price_format($sale_list_data[$key]['sales_price']);
        $sale_list_data[$key]['sales_time']  = local_date($GLOBALS['_CFG']['time_format'], $sale_list_data[$key]['sales_time']);

        //获取客户的车辆信息
        $user_id = $item['user_id'];
        $cx_id = $item['insure_id'];
        $sql = "SELECT * FROM " . $GLOBALS['ecs']->table('insure_cx') . "WHERE cx_id='$cx_id'";
        $cx_info = $GLOBALS['db']->getRow($sql);
        $sale_list_data[$key]['cx_info'] = $cx_info;

        //佣金返现
        if($sale_list_data['parent_id']) {
            $sale_list_data[$key]['yjl'] = $yjl;
            $sale_list_data[$key]['yj_money'] = (float)$yjl / 100 * $sale_list_data[$key]['order_amount'];
        }else{
            $sale_list_data[$key]['yjl'] = 0;
            $sale_list_data[$key]['yj_money'] = 0;
        }
    }
    $arr = array('sale_list_data' => $sale_list_data, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);
    //print_r($arr);exit;
    return $arr;
}


function get_affiliate()
{
    $config = unserialize($GLOBALS['_CFG']['affiliate']);
    empty($config) && $config = array();

    return $config;
}
?>