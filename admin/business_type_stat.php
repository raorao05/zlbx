<?php

/**
 * ECSHOP ҵ��ͳ��-- ���ղ�Ʒͳ�Ƴ���
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
        $data = get_sale_list(false);
        header("Content-type: application/vnd.ms-excel; charset=GB2312");
        header("Content-Disposition: attachment; filename=$file_name.xls");

        /* �ļ����� */
        echo ecs_iconv(EC_CHARSET, 'GB2312', $_REQUEST['start_date']. $_LANG['to'] .$_REQUEST['end_date']. '���ղ�Ʒ��ϸ') . "\t\n";

        /* ��Ʒ����,������,��Ʒ����,���ۼ۸�,�������� */
        echo ecs_iconv(EC_CHARSET, 'GB2312', '���') . "\t";
        echo ecs_iconv(EC_CHARSET, 'GB2312', '��������') . "\t";
        echo ecs_iconv(EC_CHARSET, 'GB2312', '��������') . "\t";
        echo ecs_iconv(EC_CHARSET, 'GB2312', '���Ѻϼ�') . "\t";
        echo ecs_iconv(EC_CHARSET, 'GB2312', '���Ѻϼ�����') . "\t";
        echo ecs_iconv(EC_CHARSET, 'GB2312', '��ע') . "\t";
        echo "\n";


        foreach ($data['sale_list_data'] AS $key => $value)
        {
            echo ecs_iconv(EC_CHARSET, 'GB2312', $value['id']) . "\t";
            echo ecs_iconv(EC_CHARSET, 'GB2312', $value['cat_name']) . "\t";
            echo ecs_iconv(EC_CHARSET, 'GB2312', $value['total_orders']) . "\t";
            echo ecs_iconv(EC_CHARSET, 'GB2312', $value['money']) . "\t";
            echo ecs_iconv(EC_CHARSET, 'GB2312', $value['id']) . "\t";
            echo ecs_iconv(EC_CHARSET, 'GB2312', '') . "\t";
            echo "\n";
        }
        exit;
    }

    $data = get_sale_list();
    //print_r($data);
    /* ��ֵ��ģ�� */
    $smarty->assign('cat_list',     cat_list(0, $cat_id));
    $smarty->assign('filter',       $data['filter']);
    $smarty->assign('record_count', $data['record_count']);
    $smarty->assign('page_count',   $data['page_count']);
    $smarty->assign('goods_sales_list', $data['sale_list_data']);


    /* ��ʾҳ�� */
    //assign_query_info();
    //$smarty->display('business_brand_stat.htm');


    make_json_result($smarty->fetch('business_type_stat.htm'), '', array('filter' => $data['filter'], 'page_count' => $data['page_count']));
}
/*------------------------------------------------------ */
//--��Ʒ��ϸ�б�
/*------------------------------------------------------ */
else
{

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

    $cat_id = empty($_REQUEST['cat_id']) ? 0 : intval($_REQUEST['cat_id']);
    
    $data = get_sale_list();
    //print_r($data);exit;
    /* ��ֵ��ģ�� */
    $smarty->assign('cat_list',     cat_list(0, $cat_id));
    $smarty->assign('filter',       $data['filter']);
    $smarty->assign('record_count', $data['record_count']);
    $smarty->assign('page_count',   $data['page_count']);
    $smarty->assign('goods_sales_list', $data['sale_list_data']);
    $smarty->assign('ur_here',          $_LANG['sell_stats']);
    $smarty->assign('full_page',        1);
    $smarty->assign('start_date',       local_date('Y-m-d', $start_date));
    $smarty->assign('end_date',         local_date('Y-m-d', $end_date));
    $smarty->assign('ur_here',      'ҵ��ͳ��(������)');
    $smarty->assign('cfg_lang',     $_CFG['lang']);
    $smarty->assign('action_link',  array('text' => '������ϸ','href'=>'#download'));

    /* ��ʾҳ�� */
    assign_query_info();
    $smarty->display('business_type_stat.htm');
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


    $sale_list_data = array();
    /* ʱ����� */
    $filter['start_date'] = empty($_REQUEST['start_date']) ? local_strtotime('-7 days') : local_strtotime($_REQUEST['start_date']);
    $filter['end_date'] = empty($_REQUEST['end_date']) ? local_strtotime('today') : local_strtotime($_REQUEST['end_date']);



    /* ��ȡ��������һ������Ĳ�Ʒ */
    $cat_id = empty($_REQUEST['cat_id']) ? 0 : intval($_REQUEST['cat_id']);
    $sql = "SELECT * FROM  `shop_category` WHERE  `parent_id` = '$cat_id'";
    $cat_list_level1 = $GLOBALS['db']->getAll($sql);

    if($cat_list_level1) {
        foreach ($cat_list_level1 as $k => $v) {
            $sale_list_data[$k]['cat_id'] = $v['cat_id'];
            $sale_list_data[$k]['cat_name'] = $v['cat_name'];

            $d = cat_list($v['cat_id'], 0, false); // ��ȡ�÷��������еķ���,����1��2��3��4��5�����м�

            //��ȡ�÷��������е�goods_id
            $child_good_id_lists = '';
            foreach ($d as $key => $item) {
                $child_id = $item['cat_id'];
                $sql = "SELECT goods_id FROM " . $GLOBALS['ecs']->table('goods') . "WHERE cat_id = '$child_id'";

                $m = $GLOBALS['db']->getAll($sql);

                foreach ($m as $n) {
                    $child_good_id_lists .= $n['goods_id'] . ',';
                }

            }
            $child_good_id_lists = trim($child_good_id_lists, ',');
            if ($child_good_id_lists) {
                /* ��ѯ���ݵ����� */
                $where = " WHERE og.order_id = oi.order_id" . order_query_sql('finished', 'oi.') .
                    "  AND oi.add_time >= '" . $filter['start_date'] . "' AND oi.add_time < ' " . ($filter['end_date'] + 86400) .
                    "' AND og.goods_id in ($child_good_id_lists)";

                $sql = "SELECT COUNT(og.goods_id) FROM " .
                    $GLOBALS['ecs']->table('order_info') . ' AS oi,' .
                    $GLOBALS['ecs']->table('order_goods') . ' AS og ' .
                    $where;
                $total_orders = $GLOBALS['db']->getOne($sql);

                /* ��ҳ��С*/
                $filter = page_and_size($filter);


                $sql = "SELECT SUM(oi.order_amount) AS money FROM " . $GLOBALS['ecs']->table('order_goods') . " AS og, " . $GLOBALS['ecs']->table('order_info') . " AS oi " .
                    $where;

                if ($is_pagination) {
                    $sql .= " LIMIT " . $filter['start'] . ', ' . $filter['page_size'];
                }
                $data = $GLOBALS['db']->getAll($sql);

                $data = $data[0];
                if ($data['money']) {
                    $data['total_orders'] = $total_orders;
                    $filter['page_count'] = 1;
                    $filter['record_count'] = 1;
                } else {
                    $data = array(
                        'total_orders' => 0,
                        'money' => 0
                    );
                }

            } else {
                $data = array(
                    'total_orders' => 0,
                    'money' => 0
                );
            }
            $sale_list_data[$k]['money'] = $data['money'];
            $sale_list_data[$k]['total_orders'] = $data['total_orders'];
        }
    }else{ // �����Ѿ�����ϸ���ȵķ���
        $sql = "SELECT goods_id FROM " . $GLOBALS['ecs']->table('goods') . "WHERE cat_id = '$cat_id'";
        $m = $GLOBALS['db']->getAll($sql);
        $child_good_id_lists = '';
        foreach ($m as $n) {
            $child_good_id_lists .= $n['goods_id'] . ',';
        }
        $child_good_id_lists = trim($child_good_id_lists, ',');
        if ($child_good_id_lists) {
            /* ��ѯ���ݵ����� */
            $where = " WHERE og.order_id = oi.order_id" . order_query_sql('finished', 'oi.') .
                "  AND oi.add_time >= '" . $filter['start_date'] . "' AND oi.add_time < ' " . ($filter['end_date'] + 86400) .
                "' AND og.goods_id in ($child_good_id_lists)";

            $sql = "SELECT COUNT(og.goods_id) FROM " .
                $GLOBALS['ecs']->table('order_info') . ' AS oi,' .
                $GLOBALS['ecs']->table('order_goods') . ' AS og ' .
                $where;
            $total_orders = $GLOBALS['db']->getOne($sql);

            /* ��ҳ��С*/
            $filter = page_and_size($filter);
            $sql = "SELECT SUM(oi.order_amount) AS money FROM " . $GLOBALS['ecs']->table('order_goods') . " AS og, " . $GLOBALS['ecs']->table('order_info') . " AS oi " .
                $where;

            if ($is_pagination) {
                $sql .= " LIMIT " . $filter['start'] . ', ' . $filter['page_size'];
            }
            $data = $GLOBALS['db']->getAll($sql);

            $data = $data[0];
            if ($data['money']) {
                $data['total_orders'] = $total_orders;
                $filter['page_count'] = 1;
                $filter['record_count'] = 1;
            } else {
                $data = array(
                    'total_orders' => 0,
                    'money' => 0
                );
            }

        } else {
            $data = array(
                'total_orders' => 0,
                'money' => 0
            );
        }
        $t = cat_list($cat_id,0,false);
        $sale_list_data[0]['cat_id'] = $cat_id;
        $sale_list_data[0]['cat_name'] = $t[$cat_id]['cat_name'];
        $sale_list_data[0]['money'] = $data['money'];
        $sale_list_data[0]['total_orders'] = $data['total_orders'];
    }

    /* ���ն���������� */
    $money_list = array();
    foreach ($sale_list_data as $k => $v) {
        $money_list[$k] = $v['money'];
    }
    array_multisort($money_list, SORT_DESC, SORT_NUMERIC, $sale_list_data);

    /* ���Ӷ�������֧�� */
    foreach ($sale_list_data as $k => $v) {
        $sale_list_data[$k]['id'] = $k + 1;
        $sale_list_data[$k]['money'] = price_format($v['money']);
    }

    //print_r($sale_list_data);
    //exit;


    $arr = array('sale_list_data' => $sale_list_data, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);

    return $arr;
}


function get_affiliate()
{
    $config = unserialize($GLOBALS['_CFG']['affiliate']);
    empty($config) && $config = array();

    return $config;
}
?>