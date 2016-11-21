<?php

/**
 * ECSHOP 业务统计-- 按照产品统计程序
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
        $data = get_sale_list(false);
        header("Content-type: application/vnd.ms-excel; charset=GB2312");
        header("Content-Disposition: attachment; filename=$file_name.xls");

        /* 文件标题 */
        echo ecs_iconv(EC_CHARSET, 'GB2312', $_REQUEST['start_date']. $_LANG['to'] .$_REQUEST['end_date']. '保险产品明细') . "\t\n";

        /* 商品名称,订单号,商品数量,销售价格,销售日期 */
        echo ecs_iconv(EC_CHARSET, 'GB2312', '序号') . "\t";
        echo ecs_iconv(EC_CHARSET, 'GB2312', '产品名称') . "\t";
        echo ecs_iconv(EC_CHARSET, 'GB2312', '订单数量') . "\t";
        echo ecs_iconv(EC_CHARSET, 'GB2312', '保费合计') . "\t";
        echo ecs_iconv(EC_CHARSET, 'GB2312', '保费合计排名') . "\t";
        echo ecs_iconv(EC_CHARSET, 'GB2312', '用户类型') . "\t";
        echo "\n";


        foreach ($data['sale_list_data'] AS $key => $value)
        {
            echo ecs_iconv(EC_CHARSET, 'GB2312', $value['id']) . "\t";
            echo ecs_iconv(EC_CHARSET, 'GB2312', $value['goods_name']) . "\t";
            echo ecs_iconv(EC_CHARSET, 'GB2312', $value['total_orders']) . "\t";
            echo ecs_iconv(EC_CHARSET, 'GB2312', $value['money']) . "\t";
            echo ecs_iconv(EC_CHARSET, 'GB2312', $value['id']) . "\t";
            if($user_type == 0)
            {
                echo ecs_iconv(EC_CHARSET, 'GB2312', '全部用户') . "\t";
            }
            else if($user_type == 1)
            {
                echo ecs_iconv(EC_CHARSET, 'GB2312', '普通注册用户') . "\t";
            }
            else if($user_type == 2)
            {
                echo ecs_iconv(EC_CHARSET, 'GB2312', '代理人') . "\t";
            }
            echo "\n";
        }
        exit;
    }

    $data = get_sale_list();
    /* 赋值到模板 */
    $smarty->assign('filter',       $data['filter']);
    $smarty->assign('record_count', $data['record_count']);
    $smarty->assign('page_count',   $data['page_count']);
    $smarty->assign('goods_sales_list', $data['sale_list_data']);


    /* 显示页面 */
    //assign_query_info();
    //$smarty->display('business_brand_stat.htm');


    make_json_result($smarty->fetch('business_product_stat.htm'), '', array('filter' => $data['filter'], 'page_count' => $data['page_count']));
}
/*------------------------------------------------------ */
//--商品明细列表
/*------------------------------------------------------ */
else
{
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
    
    $data = get_sale_list();
    /* 赋值到模板 */
    $smarty->assign('filter',       $data['filter']);
    $smarty->assign('record_count', $data['record_count']);
    $smarty->assign('page_count',   $data['page_count']);
    $smarty->assign('goods_sales_list', $data['sale_list_data']);
    $smarty->assign('ur_here',          $_LANG['sell_stats']);
    $smarty->assign('full_page',        1);
    $smarty->assign('start_date',       local_date('Y-m-d', $start_date));
    $smarty->assign('end_date',         local_date('Y-m-d', $end_date));
    $smarty->assign('ur_here',      '业务统计(按产品)');
    $smarty->assign('cfg_lang',     $_CFG['lang']);
    $smarty->assign('action_link',  array('text' => '下载明细','href'=>'#download'));

    /* 显示页面 */
    assign_query_info();
    $smarty->display('business_product_stat.htm');
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

    $sale_list_data = array(
        array(
            'id' => 0,
            'goods_name' => '',
            'total_orders' => 0,
            'money' => 0,
            'id' => 0
        )
    );
    /* 时间参数 */
    $filter['start_date'] = empty($_REQUEST['start_date']) ? local_strtotime('-7 days') : local_strtotime($_REQUEST['start_date']);
    $filter['end_date'] = empty($_REQUEST['end_date']) ? local_strtotime('today') : local_strtotime($_REQUEST['end_date']);

    /* 是否区分代理人和普通注册用户 */
    $filter['user_type'] = empty($_REQUEST['user_type']) ? 0 : $_REQUEST['user_type'];

    /* 用户账号 */
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

    if($filter['user_type']) {
        if ($filter['user_type'] == '2')
        {
            if($user_id)
            {
                $where = " WHERE og.order_id = oi.order_id" . order_query_sql('finished', 'oi.') .
                    "  AND oi.add_time >= '" . $filter['start_date'] . "' AND oi.add_time < ' " . ($filter['end_date'] + 86400) .
                    "' AND oi.user_id=u.user_id AND u.user_rank='2' AND oi.user_id='$user_id'" .
                    " GROUP BY og.goods_id";
            }
            else
            {
                $where = " WHERE og.order_id = oi.order_id" . order_query_sql('finished', 'oi.') .
                    "  AND oi.add_time >= '" . $filter['start_date'] . "' AND oi.add_time < ' " . ($filter['end_date'] + 86400) .
                    "' AND oi.user_id=u.user_id AND u.user_rank='2'" .
                    " GROUP BY og.goods_id";
            }
        }
        else if($filter['user_type'] == '1')
        {
            if($user_id)
            {
                $where = " WHERE og.order_id = oi.order_id" . order_query_sql('finished', 'oi.') .
                    "  AND oi.add_time >= '" . $filter['start_date'] . "' AND oi.add_time < ' " . ($filter['end_date'] + 86400) .
                    "' AND oi.user_id=u.user_id AND u.user_rank <> '2' AND oi.user_id='$user_id'" .
                    " GROUP BY og.goods_id";
            }
            else
            {
                $where = " WHERE og.order_id = oi.order_id" . order_query_sql('finished', 'oi.') .
                    "  AND oi.add_time >= '" . $filter['start_date'] . "' AND oi.add_time < ' " . ($filter['end_date'] + 86400) .
                    "' AND oi.user_id=u.user_id AND u.user_rank <> '2'" .
                    " GROUP BY og.goods_id";
            }
        }
    }
    else
    {
        if($user_id)
        {
            $where = " WHERE og.order_id = oi.order_id" . order_query_sql('finished', 'oi.') .
                "  AND oi.add_time >= '" . $filter['start_date'] . "' AND oi.add_time < ' " . ($filter['end_date'] + 86400) .
                "' AND oi.user_id=u.user_id  AND oi.user_id='$user_id'" .
                " GROUP BY og.goods_id";

        }
        else
        {
            $where = " WHERE og.order_id = oi.order_id" . order_query_sql('finished', 'oi.') .
                "  AND oi.add_time >= '" . $filter['start_date'] . "' AND oi.add_time < ' " . ($filter['end_date'] + 86400) .
                "' AND oi.user_id=u.user_id " .
                " GROUP BY og.goods_id";
        }
    }

    $sql = "SELECT COUNT(og.goods_id) FROM " .
                    $GLOBALS['ecs']->table('order_info') . ' AS oi,' .
                    $GLOBALS['ecs']->table('order_goods') . ' AS og, ' .
                    $GLOBALS['ecs']->table('users') . 'AS u' .
                    $where;
    $total_orders = $GLOBALS['db']->getOne($sql);

    /* 分页大小*/
    $filter = page_and_size($filter);


    $sql = "SELECT  og.goods_name,SUM(oi.order_amount) AS money FROM " .
                    $GLOBALS['ecs']->table('order_goods') . " AS og, " .
                    $GLOBALS['ecs']->table('order_info') . " AS oi, " .
                    $GLOBALS['ecs']->table('users') . 'AS u' .
        $where;

    if ($is_pagination)
    {
        $sql .= " LIMIT " . $filter['start'] . ', ' . $filter['page_size'];
    }
    $sale_list_data = $GLOBALS['db']->getAll($sql);

    foreach ($sale_list_data as $key => $item)
    {

        $sale_list_data[$key]['total_orders'] = $total_orders;
        if($sale_list_data[$key]['money']){
            $sale_list_data[$key]['money'] = $sale_list_data[$key]['money'];
        }else{
            $sale_list_data[$key]['money'] = 0;
        }


    }

    $filter['page_count'] = 1;
    $filter['record_count'] = 1;

    //print_r($sale_list_data);

    /* 按照订单金额排序 */
    $money_list = array();
    foreach($sale_list_data as $k => $v){
        $money_list[$k] = $v['money'];
    }
    array_multisort($money_list,SORT_DESC,SORT_NUMERIC,$sale_list_data);

    /* 增加额外数据支持 */
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