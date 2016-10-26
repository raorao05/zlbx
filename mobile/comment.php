<?php

/**
 * ECSHOP WAP����ҳ
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: testyang $
 * $Id: comment.php 15013 2008-10-23 09:31:42Z testyang $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

$goods_id = !empty($_GET['g_id']) ? intval($_GET['g_id']) : exit();
if ($goods_id <= 0)
{
    exit();
}
/* ��ȡ��Ʒ��Ϣ */
$_LANG['kilogram'] = 'ǧ��';
$_LANG['gram'] = '��';
$_LANG['home'] = '��ҳ';
$smarty->assign('goods_id', $goods_id);
$goods_info = get_goods_info($goods_id);
$goods_info['goods_name'] = encode_output($goods_info['goods_name']);
$goods_info['goods_brief'] = encode_output($goods_info['goods_brief']);
$smarty->assign('goods_info', $goods_info);

/* ��������Ϣ */
$comment = assign_comment($goods_id, 'comments');

$num = $comment['pager']['record_count'];
if ($num > 0)
{
    $page_num = '10';
    $page = !empty($_GET['page']) ? intval($_GET['page']) : 1;
    $pages = ceil($num / $page_num);
    if ($page <= 0)
    {
        $page = 1;
    }
    if ($pages == 0)
    {
        $pages = 1;
    }
    if ($page > $pages)
    {
        $page = $pages;
    }
    $i = 1;
    foreach ($comment['comments'] as $key => $data)
    {
        if (($i > ($page_num * ($page - 1 ))) && ($i <= ($page_num * $page)))
        {
            $re_content = !empty($data['re_content']) ? encode_output($data['re_content']) : '';
            $re_username = !empty($data['re_username']) ? encode_output($data['re_username']) : '';
            $re_add_time = !empty($data['re_add_time']) ? substr($data['re_add_time'], 5, 14) : '';
            $comment_data[] = array('i' => $i , 'content' => encode_output($data['content']) , 'username' => encode_output($data['username']) , 'add_time' => substr($data['add_time'], 5, 14) , 're_content' => $re_content , 're_username' => $re_username , 're_add_time' => $re_add_time);
        }
        $i++;
    }
    $smarty->assign('comment_data', $comment_data);
    $pagebar = get_wap_pager($num, $page_num, $page, 'comment.php?g_id='.$goods_id, 'page');
    $smarty->assign('pagebar' , $pagebar);
}

$smarty->assign('footer', get_footer());
$smarty->display('comment.html');

?>