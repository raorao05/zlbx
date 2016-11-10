<?php

/**
 * ECSHOP ����ͳ�Ƴ���
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
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
    /* ���Ȩ�� */
    check_authz_json('sale_order_stats');
    if (strstr($_REQUEST['start_date'], '-') === false)
    {
        $_REQUEST['start_date'] = local_date('Y-m-d', $_REQUEST['start_date']);
        $_REQUEST['end_date'] = local_date('Y-m-d', $_REQUEST['end_date']);
    }
    /*------------------------------------------------------ */
    //--Excel�ļ�����
    /*------------------------------------------------------ */
    if ($_REQUEST['act'] == 'download')
    {
        $file_name = $_REQUEST['start_date'].'_'.$_REQUEST['end_date'] . '_sale';
        $goods_sales_list = get_sale_list(false);
        header("Content-type: application/vnd.ms-excel; charset=GB2312");
        header("Content-Disposition: attachment; filename=$file_name.xls");

        /* �ļ����� */
        echo ecs_iconv(EC_CHARSET, 'GB2312', $_REQUEST['start_date']. $_LANG['to'] .$_REQUEST['end_date']. '����������ϸ') . "\t\n";

        /* ��Ʒ����,������,��Ʒ����,���ۼ۸�,�������� */
        echo ecs_iconv(EC_CHARSET, 'GB2312', 'ǩ��ʱ��') . "\t";
        echo ecs_iconv(EC_CHARSET, 'GB2312', '�������') . "\t";
        echo ecs_iconv(EC_CHARSET, 'GB2312', '��������') . "\t";
        echo ecs_iconv(EC_CHARSET, 'GB2312', '���ƺ�') . "\t";
        echo ecs_iconv(EC_CHARSET, 'GB2312', '������������') . "\t";
        echo ecs_iconv(EC_CHARSET, 'GB2312', '������') . "\t";
        echo ecs_iconv(EC_CHARSET, 'GB2312', '����') . "\t";
        echo ecs_iconv(EC_CHARSET, 'GB2312', '������Ч��') . "\t";
        echo ecs_iconv(EC_CHARSET, 'GB2312', '����/����') . "\t";
        echo ecs_iconv(EC_CHARSET, 'GB2312', 'Ӷ����') . "\t";
        echo ecs_iconv(EC_CHARSET, 'GB2312', 'Ӷ����') . "\t";
        echo "\n";


        foreach ($goods_sales_list['sale_list_data'] AS $key => $value)
        {
            echo ecs_iconv(EC_CHARSET, 'GB2312', $value['sales_time']) . "\t";
            echo ecs_iconv(EC_CHARSET, 'GB2312', '������������') . "\t";
            echo ecs_iconv(EC_CHARSET, 'GB2312', $value['cx_info']['cp_number']) . "\t";
            echo ecs_iconv(EC_CHARSET, 'GB2312', $value['cx_info']['cz_name']) . "\t";
            echo ecs_iconv(EC_CHARSET, 'GB2312', $value['order_sn']) . "\t";
            echo ecs_iconv(EC_CHARSET, 'GB2312', $value['order_amount']) . "\t";
            echo ecs_iconv(EC_CHARSET, 'GB2312', $value['goods_name']) . "\t";
            echo ecs_iconv(EC_CHARSET, 'GB2312', '����') . "\t";
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
//--��Ʒ��ϸ�б�
/*------------------------------------------------------ */
else
{
    //die('1');
    /* Ȩ���ж� */
    admin_priv('sale_order_stats');
    /* ʱ����� */
    if (!isset($_REQUEST['start_date']))
    {
        $start_date = local_strtotime('-7 days');
    }
    if (!isset($_REQUEST['end_date']))
    {
        $end_date = local_strtotime('today');
    }
    
    $sale_list_data = get_sale_list();
    /* ��ֵ��ģ�� */
    $smarty->assign('filter',       $sale_list_data['filter']);
    $smarty->assign('record_count', $sale_list_data['record_count']);
    $smarty->assign('page_count',   $sale_list_data['page_count']);
    $smarty->assign('goods_sales_list', $sale_list_data['sale_list_data']);
    $smarty->assign('ur_here',          $_LANG['sell_stats']);
    $smarty->assign('full_page',        1);
    $smarty->assign('start_date',       local_date('Y-m-d', $start_date));
    $smarty->assign('end_date',         local_date('Y-m-d', $end_date));
    $smarty->assign('ur_here',      '����ͳ��');
    $smarty->assign('cfg_lang',     $_CFG['lang']);
    $smarty->assign('action_link',  array('text' => '������ϸ','href'=>'#download'));

    /* ��ʾҳ�� */
    assign_query_info();
    $smarty->display('cx_stat.htm');
}
/*------------------------------------------------------ */
//--��ȡ������ϸ��Ҫ�ĺ���
/*------------------------------------------------------ */
/**
 * ȡ��������ϸ������Ϣ
 * @param   bool  $is_pagination  �Ƿ��ҳ
 * @return  array   ������ϸ����
 */
function get_sale_list($is_pagination = true){

    /* ʱ����� */
    $filter['start_date'] = empty($_REQUEST['start_date']) ? local_strtotime('-7 days') : local_strtotime($_REQUEST['start_date']);
    $filter['end_date'] = empty($_REQUEST['end_date']) ? local_strtotime('today') : local_strtotime($_REQUEST['end_date']);
  
    /* ��ѯ���ݵ����� */
    $where = " WHERE og.order_id = oi.order_id". order_query_sql('finished', 'oi.') .
             " AND oi.bx_type = 2 AND oi.add_time >= '".$filter['start_date']."' AND oi.add_time < ' " . ($filter['end_date'] + 86400) . "'";
    
    $sql = "SELECT COUNT(og.goods_id) FROM " .
           $GLOBALS['ecs']->table('order_info') . ' AS oi,'.
           $GLOBALS['ecs']->table('order_goods') . ' AS og '.
           $where;
    $filter['record_count'] = $GLOBALS['db']->getOne($sql);

    /* ��ҳ��С */
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
    $yjl = $affiliate_config['config']['level_money_all']; // Ӷ����
//    print_r($affiliate_config);
//    exit;

    foreach ($sale_list_data as $key => $item)
    {
        $sale_list_data[$key]['sales_price'] = price_format($sale_list_data[$key]['sales_price']);
        $sale_list_data[$key]['sales_time']  = local_date($GLOBALS['_CFG']['time_format'], $sale_list_data[$key]['sales_time']);

        //��ȡ�ͻ��ĳ�����Ϣ
        $user_id = $item['user_id'];
        $cx_id = $item['insure_id'];
        $sql = "SELECT * FROM " . $GLOBALS['ecs']->table('insure_cx') . "WHERE cx_id='$cx_id'";
        $cx_info = $GLOBALS['db']->getRow($sql);
        $sale_list_data[$key]['cx_info'] = $cx_info;

        //Ӷ����
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