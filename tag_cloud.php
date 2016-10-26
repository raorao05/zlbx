<?php

/**
 * ECSHOP ��ǩ��
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: tag_cloud.php 17217 2011-01-19 06:29:08Z liubo $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
    assign_template();
    $position = assign_ur_here(0, $_LANG['tag_cloud']);
    $smarty->assign('page_title', $position['title']);    // ҳ�����
    $smarty->assign('ur_here',    $position['ur_here']);  // ��ǰλ��
    $smarty->assign('categories', get_categories_tree()); // ������
    $smarty->assign('helps',      get_shop_help());       // �������
    $smarty->assign('top_goods',  get_top10());           // ��������
    $smarty->assign('promotion_info', get_promotion_info());

    /* ���� */
    $vote = get_vote();
    if (!empty($vote))
    {
        $smarty->assign('vote_id', $vote['id']);
        $smarty->assign('vote',    $vote['content']);
    }

    assign_dynamic('tag_cloud');

    $tags = get_tags();

    if (!empty($tags))
    {
        include_once(ROOT_PATH . 'includes/lib_clips.php');
        color_tag($tags);
    }

    $smarty->assign('tags', $tags);

    $smarty->display('tag_cloud.dwt');
?>