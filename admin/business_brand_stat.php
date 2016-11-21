<?php

/**
 * ECSHOP ҵ��ͳ��-- ����Ʒ��ͳ�Ƴ���
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
        echo ecs_iconv(EC_CHARSET, 'GB2312', $_REQUEST['start_date']. $_LANG['to'] .$_REQUEST['end_date']. '����Ʒ����ϸ') . "\t\n";

        /* ��Ʒ����,������,��Ʒ����,���ۼ۸�,�������� */
        echo ecs_iconv(EC_CHARSET, 'GB2312', '���') . "\t";
        echo ecs_iconv(EC_CHARSET, 'GB2312', '���չ�˾') . "\t";
        echo ecs_iconv(EC_CHARSET, 'GB2312', '��������') . "\t";
        echo ecs_iconv(EC_CHARSET, 'GB2312', '���Ѻϼ�') . "\t";
        echo ecs_iconv(EC_CHARSET, 'GB2312', '���Ѻϼ�����') . "\t";
        echo ecs_iconv(EC_CHARSET, 'GB2312', '�û�����') . "\t";
        echo "\n";


        $user_type = empty($_REQUEST['user_type']) ? 0 : $_REQUEST['user_type'];

        foreach ($data['sale_list_data'] AS $key => $value)
        {
            echo ecs_iconv(EC_CHARSET, 'GB2312', $value['id']) . "\t";
            echo ecs_iconv(EC_CHARSET, 'GB2312', $value['brand_name']) . "\t";
            echo ecs_iconv(EC_CHARSET, 'GB2312', $value['total_orders']) . "\t";
            echo ecs_iconv(EC_CHARSET, 'GB2312', $value['money']) . "\t";
            echo ecs_iconv(EC_CHARSET, 'GB2312', $value['id']) . "\t";
            if($user_type == 0)
            {
                echo ecs_iconv(EC_CHARSET, 'GB2312', 'ȫ���û�') . "\t";
            }
            else if($user_type == 1)
            {
                echo ecs_iconv(EC_CHARSET, 'GB2312', '��ͨע���û�') . "\t";
            }
            else if($user_type == 2)
            {
                echo ecs_iconv(EC_CHARSET, 'GB2312', '������') . "\t";
            }

            echo "\n";
        }
        exit;
    }

    $data = get_sale_list();
    /* ��ֵ��ģ�� */
    $smarty->assign('filter',       $data['filter']);
    $smarty->assign('record_count', $data['record_count']);
    $smarty->assign('page_count',   $data['page_count']);
    $smarty->assign('goods_sales_list', $data['sale_list_data']);


    /* ��ʾҳ�� */
    //assign_query_info();
    //$smarty->display('business_brand_stat.htm');


    make_json_result($smarty->fetch('business_brand_stat.htm'), '', array('filter' => $data['filter'], 'page_count' => $data['page_count']));
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
    
    $data = get_sale_list();
    /* ��ֵ��ģ�� */
    $smarty->assign('filter',       $data['filter']);
    $smarty->assign('record_count', $data['record_count']);
    $smarty->assign('page_count',   $data['page_count']);
    $smarty->assign('goods_sales_list', $data['sale_list_data']);
    $smarty->assign('ur_here',          $_LANG['sell_stats']);
    $smarty->assign('full_page',        1);
    $smarty->assign('start_date',       local_date('Y-m-d', $start_date));
    $smarty->assign('end_date',         local_date('Y-m-d', $end_date));
    $smarty->assign('ur_here',      'ҵ��ͳ��(��Ʒ��)');
    $smarty->assign('cfg_lang',     $_CFG['lang']);
    $smarty->assign('action_link',  array('text' => '������ϸ','href'=>'#download'));

    /* ��ʾҳ�� */
    assign_query_info();
    $smarty->display('business_brand_stat.htm');
}
/*------------------------------------------------------ */
//--��ȡ������ϸ��Ҫ�ĺ���
/*------------------------------------------------------ */
/**
 * ȡ��������ϸ������Ϣ
 * @param   bool  $is_pagination  �Ƿ��ҳ
 * @return  array   ������ϸ����
 */
function get_sale_list($is_pagination = true)
{

    $sale_list_data = array(
        array(
            'id' => 0,
            'brand_name' => '',
            'total_orders' => 0,
            'money' => 0,
            'id' => 0
        )
    );


    /* ʱ����� */
    $filter['start_date'] = empty($_REQUEST['start_date']) ? local_strtotime('-7 days') : local_strtotime($_REQUEST['start_date']);
    $filter['end_date'] = empty($_REQUEST['end_date']) ? local_strtotime('today') : local_strtotime($_REQUEST['end_date']);


    /* �Ƿ����ִ����˺���ͨע���û� */
    $filter['user_type'] = empty($_REQUEST['user_type']) ? 0 : $_REQUEST['user_type'];

    /* �û��˺� */
    $filter['user_name'] = empty($_REQUEST['user_name']) ? '' : $_REQUEST['user_name'];


    $user_id = '';
    if($filter['user_name'])
    {
        $sql = "SELECT user_id FROM " . $GLOBALS['ecs']->table('users') . "WHERE user_name = '" . $filter['user_name'] . "'";
        $user_id = $GLOBALS['db']->getOne($sql);
        if(!$user_id)
        {
            $user_id = '123456789';
        }
    }



    /* ��ȡ���е�Ʒ�� */
    $sql = "SELECT brand_name,brand_id FROM " . $GLOBALS['ecs']->table('brand');
    $brand_list = $GLOBALS['db']->getAll($sql);

    foreach($brand_list as $k => $v)
    {
        $sale_list_data[$k] = array('brand_name' => $v['brand_name']);

        if($filter['user_type'])
        {
            if( $filter['user_type'] == '2')
            {
                if($user_id)
                {
                    $where = " WHERE og.order_id = oi.order_id" . order_query_sql('finished', 'oi.') .
                        " AND oi.user_id = u.user_id AND oi.user_id = '$user_id' AND u.user_rank='" . $filter['user_type'] . "'" .
                        " AND og.goods_id= g.goods_id AND g.brand_id = '" . $v['brand_id'] . "'" .
                        " AND oi.add_time >= '" . $filter['start_date'] . "' AND oi.add_time < ' " . ($filter['end_date'] + 86400) . "'";
                }
                else
                {
                    $where = " WHERE og.order_id = oi.order_id" . order_query_sql('finished', 'oi.') .
                        " AND oi.user_id = u.user_id AND u.user_rank='" . $filter['user_type'] . "'" .
                        " AND og.goods_id= g.goods_id AND g.brand_id = '" . $v['brand_id'] . "'" .
                        " AND oi.add_time >= '" . $filter['start_date'] . "' AND oi.add_time < ' " . ($filter['end_date'] + 86400) . "'";
                }

            }
            else if( $filter['user_type'] == '1')
            {
                /* ��ѯ���ݵ����� */
                if($user_id)
                {
                    $where = " WHERE og.order_id = oi.order_id" . order_query_sql('finished', 'oi.') .
                        " AND oi.user_id = u.user_id AND oi.user_id = '$user_id' AND u.user_rank <> 2" .
                        " AND og.goods_id= g.goods_id AND g.brand_id = '" . $v['brand_id'] . "'" .
                        " AND oi.add_time >= '" . $filter['start_date'] . "' AND oi.add_time < ' " . ($filter['end_date'] + 86400) . "'";

                }
                else
                {
                    $where = " WHERE og.order_id = oi.order_id" . order_query_sql('finished', 'oi.') .
                        " AND oi.user_id = u.user_id AND u.user_rank <> 2" .
                        " AND og.goods_id= g.goods_id AND g.brand_id = '" . $v['brand_id'] . "'" .
                        " AND oi.add_time >= '" . $filter['start_date'] . "' AND oi.add_time < ' " . ($filter['end_date'] + 86400) . "'";
                }

            }

            $sql = "SELECT COUNT(og.goods_id) FROM " .
                $GLOBALS['ecs']->table('order_info') . ' AS oi,'.
                $GLOBALS['ecs']->table('order_goods') . ' AS og, '.
                $GLOBALS['ecs']->table('users') . 'AS u,' .
                $GLOBALS['ecs']->table('goods') . 'AS g' .

                $where;
            $total_orders = $GLOBALS['db']->getOne($sql);

            /* ��ҳ��С
            $filter = page_and_size($filter);
            */

            $sql = "SELECT  SUM(oi.order_amount) AS money FROM " .
                    $GLOBALS['ecs']->table('order_goods')." AS og, ".
                    $GLOBALS['ecs']->table('order_info')." AS oi, ".
                    $GLOBALS['ecs']->table('users')." AS u, " .
                    $GLOBALS['ecs']->table('goods') . 'AS g' .
                    $where;

        }
        else
        {
            /* ��ѯ���ݵ����� */
            if($user_id)
            {
                $where = " WHERE og.order_id = oi.order_id". order_query_sql('finished', 'oi.') .
                    "  AND oi.add_time >= '".$filter['start_date'].
                    "' AND oi.user_id = u.user_id AND u.user_id='$user_id'" .
                    "  AND og.goods_id= g.goods_id AND g.brand_id = '" . $v['brand_id'] . "'" .
                    "  AND oi.add_time < ' " . ($filter['end_date'] + 86400) . "'";
            }
            else
            {
                $where = " WHERE og.order_id = oi.order_id". order_query_sql('finished', 'oi.') .
                    "  AND oi.add_time >= '".$filter['start_date'].
                    "' AND og.goods_id= g.goods_id AND g.brand_id = '" . $v['brand_id'] . "'" .
                    "  AND oi.add_time < ' " . ($filter['end_date'] + 86400) . "'";
            }



            $sql = "SELECT COUNT(og.goods_id) FROM " .
                $GLOBALS['ecs']->table('order_info') . ' AS oi,'.
                $GLOBALS['ecs']->table('order_goods') . ' AS og, '.
                $GLOBALS['ecs']->table('users') . ' AS u, '.
                $GLOBALS['ecs']->table('goods') . 'AS g' .
                $where;
            $total_orders = $GLOBALS['db']->getOne($sql);



            /* ��ҳ��С
            $filter = page_and_size($filter);
            */

            $sql = "SELECT  SUM(oi.order_amount) AS money FROM " .
                    $GLOBALS['ecs']->table('order_goods')." AS og, ".
                    $GLOBALS['ecs']->table('order_info')." AS oi, ".
                    $GLOBALS['ecs']->table('users') . ' AS u, '.
                    $GLOBALS['ecs']->table('goods') . 'AS g' .
                    $where;
        }


        //die($sql);


        /*
        if ($is_pagination)
        {
            $sql .= " LIMIT " . $filter['start'] . ', ' . $filter['page_size'];
        }
        */

        $data = $GLOBALS['db']->getAll($sql);


        foreach ($data as $key => $item)
        {
            //$data[$key]['money'] = price_format($data[$key]['money']);

            //$data[$key]['total_orders']  = $total_orders;
            $sale_list_data[$k]['total_orders'] = $total_orders;
            if($data[$key]['money']){
                $sale_list_data[$k]['money'] = $data[$key]['money'];
            }else{
                $sale_list_data[$k]['money'] = 0;
            }


        }
        //$sale_list_data[$k]['data'] = $data;
    }


    $filter['page_count'] = 1;
    $filter['record_count'] = 1;

    /* ���ն���������� */
    $money_list = array();
    foreach($sale_list_data as $k => $v){
        $money_list[$k] = $v['money'];
    }
    array_multisort($money_list,SORT_DESC,SORT_NUMERIC,$sale_list_data);

    /* ���Ӷ�������֧�� */
    foreach($sale_list_data as $k => $v){
        $sale_list_data[$k]['id'] = $k + 1;
        $sale_list_data[$k]['money'] = price_format($v['money']);
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