<?php
/**
 * ECSHOP ������ʾ��Ʒ��js����
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: gen_goods_script.php 17217 2011-01-19 06:29:08Z liubo $
 */

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

/*------------------------------------------------------ */
//-- ���ɴ���
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'setup')
{
    /* ���Ȩ�� */
    admin_priv('gen_goods_script');

    /* ���� */
    $lang_list = array(
        'UTF8'   => $_LANG['charset']['utf8'],
        'GB2312' => $_LANG['charset']['zh_cn'],
        'BIG5'   => $_LANG['charset']['zh_tw'],
    );

    /* ������ֵ */
    $ur_here = $_LANG['16_goods_script'];
    $smarty->assign('ur_here',    $ur_here);
    $smarty->assign('cat_list',   cat_list());
    $smarty->assign('brand_list', get_brand_list());
    $smarty->assign('intro_list', $_LANG['intro']);
    $smarty->assign('url',        $ecs->url());
    $smarty->assign('lang_list',  $lang_list);

    /* ��ʾģ�� */
    assign_query_info();
    $smarty->display('gen_goods_script.htm');
}

?>