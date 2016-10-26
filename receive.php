<?php

/**
 * ECSHOP �����ջ�ȷ�ϵ�ҳ��
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: receive.php 17217 2011-01-19 06:29:08Z liubo $
 */

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

/* ȡ�ò��� */
$order_id  = !empty($_REQUEST['id'])  ? intval($_REQUEST['id'])              : 0;  // ������
$consignee = !empty($_REQUEST['con']) ? rawurldecode(trim($_REQUEST['con'])) : ''; // �ջ���

/* ��ѯ������Ϣ */
$sql   = 'SELECT * FROM ' . $ecs->table('order_info') . " WHERE order_id = '$order_id'";
$order = $db->getRow($sql);

if (empty($order))
{
    $msg = $_LANG['order_not_exists'];
}
/* ��鶩�� */
elseif ($order['shipping_status'] == SS_RECEIVED)
{
    $msg = $_LANG['order_already_received'];
}
elseif ($order['shipping_status'] != SS_SHIPPED)
{
    $msg = $_LANG['order_invalid'];
}
elseif ($order['consignee'] != $consignee)
{
    $msg = $_LANG['order_invalid'];
}
else
{
    /* �޸Ķ�������״̬Ϊ��ȷ���ջ��� */
    $sql = "UPDATE " . $ecs->table('order_info') . " SET shipping_status = '" . SS_RECEIVED . "' WHERE order_id = '$order_id'";
    $db->query($sql);

    /* ��¼��־ */
    order_action($order['order_sn'], $order['order_status'], SS_RECEIVED, $order['pay_status'], '', $_LANG['buyer']);

    $msg = $_LANG['act_ok'];
}

/* ��ʾģ�� */
assign_template();
$position = assign_ur_here();
$smarty->assign('page_title', $position['title']);    // ҳ�����
$smarty->assign('ur_here',    $position['ur_here']);  // ��ǰλ��

$smarty->assign('categories', get_categories_tree()); // ������
$smarty->assign('helps',      get_shop_help());       // �������

assign_dynamic('receive');

$smarty->assign('msg', $msg);
$smarty->display('receive.dwt');

?>