<?php

/**
 * ECSHOP ���ʹ������
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: visit_sold.php 17217 2011-01-19 06:29:08Z liubo $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require_once(ROOT_PATH . 'includes/lib_order.php');
require_once('../languages/' .$_CFG['lang']. '/admin/statistic.php');
$smarty->assign('lang',    $_LANG);

/* act������ĳ�ʼ�� */
if (empty($_REQUEST['act']))
{
    $_REQUEST['act'] = 'list';
}
else
{
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

admin_priv('client_flow_stats');

/*------------------------------------------------------ */
//--���ʹ������
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'list' || $_REQUEST['act'] == 'download')
{
    /* �����ĳ�ʼ�� */
    $cat_id   = (!empty($_REQUEST['cat_id']))   ? intval($_REQUEST['cat_id'])   : 0;
    $brand_id = (!empty($_REQUEST['brand_id'])) ? intval($_REQUEST['brand_id']) : 0;
    $show_num = (!empty($_REQUEST['show_num'])) ? intval($_REQUEST['show_num']) : 15;

    /* ��ȡ���ʹ���ı������� */
    $click_sold_info = click_sold_info($cat_id, $brand_id, $show_num);

    /* ���ر��� */
    if ($_REQUEST['act'] == "download")
    {
        $filename = 'visit_sold';
        header("Content-type: application/vnd.ms-excel; charset=GB2312");
        header("Content-Disposition: attachment; filename=$filename.xls");
        $data = "$_LANG[visit_buy]\t\n";
        $data .= "$_LANG[order_by]\t$_LANG[goods_name]\t$_LANG[fav_exponential]\t$_LANG[buy_times]\t$_LANG[visit_buy]\n";
        foreach ($click_sold_info AS $k => $row)
        {
            $order_by = $k + 1;
            $data .= "$order_by\t$row[goods_name]\t$row[click_count]\t$row[sold_times]\t$row[scale]\n";
        }
        echo ecs_iconv(EC_CHARSET, 'GB2312', $data);
        exit;
    }

    /* ��ֵ��ģ�� */
    $smarty->assign('ur_here',      $_LANG['visit_buy_per']);

    $smarty->assign('show_num',         $show_num);
    $smarty->assign('brand_id',         $brand_id);
    $smarty->assign('click_sold_info',  $click_sold_info);

    $smarty->assign('cat_list',     cat_list(0, $cat_id));
    $smarty->assign('brand_list',   get_brand_list());

    $filename = 'visit_sold';
    $smarty->assign('action_link',  array('text' => $_LANG['download_visit_buy'], 'href' => 'visit_sold.php?act=download&show_num=' . $show_num . '&cat_id=' . $cat_id . '&brand_id=' . $brand_id . '&show_num=' . $show_num ));

    /* ��ʾҳ�� */
    assign_query_info();
    $smarty->display('visit_sold.htm');
}

/*------------------------------------------------------ */
//--����ͳ����Ҫ�ĺ���
/*------------------------------------------------------ */
/**
 * ȡ�÷��ʺ͹������ͳ������
 *
 * @param   int             $cat_id          ������
 * @param   int             $brand_id        Ʒ�Ʊ��
 * @param   int             $show_num        ��ʾ����
 * @return  array           $click_sold_info  ���ʹ����������
 */
 function click_sold_info($cat_id, $brand_id, $show_num)
 {
    global $db, $ecs;

    $where = " WHERE o.order_id = og.order_id AND g.goods_id = og.goods_id " . order_query_sql('finished', 'o.');
    $limit = " LIMIT " .$show_num;

    if ($cat_id > 0)
    {
        $where .= " AND " . get_children($cat_id);
    }
    if ($brand_id > 0)
    {
        $where .= " AND g.brand_id = '$brand_id' ";
    }

    $click_sold_info = array();
    $sql = "SELECT og.goods_id, g.goods_sn, g.goods_name, g.click_count,  COUNT(og.goods_id) AS sold_times ".
        " FROM ". $ecs->table('goods') ." AS g, ". $ecs->table('order_goods') ." AS og, " .$ecs->table('order_info') . " AS o " . $where .
        " GROUP BY og.goods_id ORDER BY g.click_count DESC " . $limit;
    $res = $db->query($sql);

    while ($item = $db->fetchRow($res))
    {
        if ($item['click_count'] <= 0)
        {
            $item['scale'] = 0;
        }
        else
        {
            /* ÿһ�ٸ�����Ķ������� */
            $item['scale'] = sprintf("%0.2f", ($item['sold_times'] / $item['click_count']) * 100) .'%';
        }

        $click_sold_info[] = $item;
    }

    return $click_sold_info;
}

?>