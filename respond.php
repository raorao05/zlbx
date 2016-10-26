<?php

/**
 * ECSHOP ֧����Ӧҳ��
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: respond.php 17217 2011-01-19 06:29:08Z liubo $
 */

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require(ROOT_PATH . 'includes/lib_payment.php');
require(ROOT_PATH . 'includes/lib_order.php');
/* ֧����ʽ���� */
$pay_code = !empty($_REQUEST['code']) ? trim($_REQUEST['code']) : 'weixin';

//��ȡ����֧����ʽ
if (empty($pay_code) && !empty($_REQUEST['v_pmode']) && !empty($_REQUEST['v_pstring']))
{
    $pay_code = 'cappay';
}

//��ȡ��Ǯ������֧����ʽ
if (empty($pay_code) && ($_REQUEST['ext1'] == 'shenzhou') && ($_REQUEST['ext2'] == 'ecshop'))
{
    $pay_code = 'shenzhou';
}

/* �����Ƿ�Ϊ�� */
if (empty($pay_code))
{
    $msg = $_LANG['pay_not_exist'];
}
else
{
    /* ���code������û���ʺ� */
    if (strpos($pay_code, '?') !== false)
    {
        $arr1 = explode('?', $pay_code);
        $arr2 = explode('=', $arr1[1]);

        $_REQUEST['code']   = $arr1[0];
        $_REQUEST[$arr2[0]] = $arr2[1];
        $_GET['code']       = $arr1[0];
        $_GET[$arr2[0]]     = $arr2[1];
        $pay_code           = $arr1[0];
    }

    /* �ж��Ƿ����� */
    $sql = "SELECT COUNT(*) FROM " . $ecs->table('payment') . " WHERE pay_code = '$pay_code' AND enabled = 1";
    if ($db->getOne($sql) == 0)
    {
        $msg = $_LANG['pay_disabled'];
    }
    else
    {
        $plugin_file = 'includes/modules/payment/' . $pay_code . '.php';

        /* ������ļ��Ƿ���ڣ������������֤֧���Ƿ�ɹ��������򷵻�ʧ����Ϣ */
        if (file_exists($plugin_file))
        {
            /* ����֧����ʽ���봴��֧����Ķ��󲢵�������Ӧ�������� */
            include_once($plugin_file);

            $payment = new $pay_code();
            $msg     = (@$payment->respond()) ? $_LANG['pay_success'] : $_LANG['pay_fail'];
        }
        else
        {
            $msg = $_LANG['pay_not_exist'];
        }
    }
}

assign_template();
$position = assign_ur_here();
$smarty->assign('page_title', $position['title']);   // ҳ�����
$smarty->assign('ur_here',    $position['ur_here']); // ��ǰλ��
$smarty->assign('page_title', $position['title']);   // ҳ�����
$smarty->assign('ur_here',    $position['ur_here']); // ��ǰλ��
$smarty->assign('helps',      get_shop_help());      // �������

$smarty->assign('message',    $msg);
$smarty->assign('shop_url',   $ecs->url());

$smarty->display('respond.dwt');

?>