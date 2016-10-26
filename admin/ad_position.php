<?php

/**
 * ECSHOP ���λ�ù������
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: ad_position.php 17217 2011-01-19 06:29:08Z liubo $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require_once(ROOT_PATH . 'languages/' .$_CFG['lang']. '/admin/ads.php');

/* act������ĳ�ʼ�� */
if (empty($_REQUEST['act']))
{
    $_REQUEST['act'] = 'list';
}
else
{
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

$smarty->assign('lang', $_LANG);
$exc = new exchange($ecs->table("ad_position"), $db, 'position_id', 'position_name');

/*------------------------------------------------------ */
//-- ���λ���б�
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'list')
{
    $smarty->assign('ur_here',     $_LANG['ad_position']);
    $smarty->assign('action_link', array('text' => $_LANG['position_add'], 'href' => 'ad_position.php?act=add'));
    $smarty->assign('full_page',   1);

    $position_list = ad_position_list();

    $smarty->assign('position_list',   $position_list['position']);
    $smarty->assign('filter',          $position_list['filter']);
    $smarty->assign('record_count',    $position_list['record_count']);
    $smarty->assign('page_count',      $position_list['page_count']);

    assign_query_info();
    $smarty->display('ad_position_list.htm');
}

/*------------------------------------------------------ */
//-- ��ӹ��λҳ��
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'add')
{
    admin_priv('ad_manage');

    /* ģ�帳ֵ */
    $smarty->assign('ur_here',     $_LANG['position_add']);
    $smarty->assign('form_act',    'insert');

    $smarty->assign('action_link', array('href' => 'ad_position.php?act=list', 'text' => $_LANG['ad_position']));
    $smarty->assign('posit_arr',   array('position_style' => '<table cellpadding="0" cellspacing="0">' ."\n". '{foreach from=$ads item=ad}' ."\n". '<tr><td>{$ad}</td></tr>' ."\n". '{/foreach}' ."\n". '</table>'));

    assign_query_info();
    $smarty->display('ad_position_info.htm');
}
elseif ($_REQUEST['act'] == 'insert')
{
    admin_priv('ad_manage');

    /* ��POST������ֵ���д���ȥ���ո� */
    $position_name = !empty($_POST['position_name']) ? trim($_POST['position_name']) : '';
    $position_desc = !empty($_POST['position_desc']) ? nl2br(htmlspecialchars($_POST['position_desc'])) : '';
    $ad_width      = !empty($_POST['ad_width'])      ? intval($_POST['ad_width'])  : 0;
    $ad_height     = !empty($_POST['ad_height'])     ? intval($_POST['ad_height']) : 0;

    /* �鿴���λ�Ƿ����ظ� */
    if ($exc->num("position_name", $position_name) == 0)
    {
        /* �����λ�õ���Ϣ�������ݱ� */
        $sql = 'INSERT INTO '.$ecs->table('ad_position').' (position_name, ad_width, ad_height, position_desc, position_style) '.
               "VALUES ('$position_name', '$ad_width', '$ad_height', '$position_desc', '$_POST[position_style]')";

        $db->query($sql);
        /* ��¼����Ա���� */
        admin_log($position_name, 'add', 'ads_position');

        /* ��ʾ��Ϣ */
        $link[0]['text'] = $_LANG['ads_add'];
        $link[0]['href'] = 'ads.php?act=add';

        $link[1]['text'] = $_LANG['continue_add_position'];
        $link[1]['href'] = 'ad_position.php?act=add';

        $link[2]['text'] = $_LANG['back_position_list'];
        $link[2]['href'] = 'ad_position.php?act=list';

        sys_msg($_LANG['add'] . "&nbsp;" . stripslashes($position_name) . "&nbsp;" . $_LANG['attradd_succed'], 0, $link);
    }
    else
    {
        $link[] = array('text' => $_LANG['go_back'], 'href' => 'javascript:history.back(-1)');
        sys_msg($_LANG['posit_name_exist'], 0, $link);
    }
}

/*------------------------------------------------------ */
//-- ���λ�༭ҳ��
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'edit')
{
    admin_priv('ad_manage');

    $id = !empty($_GET['id']) ? intval($_GET['id']) : 0;

    /* ��ȡ���λ���� */
    $sql = 'SELECT * FROM ' .$ecs->table('ad_position'). " WHERE position_id='$id'";
    $posit_arr = $db->getRow($sql);

    $smarty->assign('ur_here',     $_LANG['position_edit']);
    $smarty->assign('action_link', array('href' => 'ad_position.php?act=list', 'text' => $_LANG['ad_position']));
    $smarty->assign('posit_arr',   $posit_arr);
    $smarty->assign('form_act',    'update');

    assign_query_info();
    $smarty->display('ad_position_info.htm');
}
elseif ($_REQUEST['act'] == 'update')
{
    admin_priv('ad_manage');

    /* ��POST������ֵ���д���ȥ���ո� */
    $position_name = !empty($_POST['position_name']) ? trim($_POST['position_name']) : '';
    $position_desc = !empty($_POST['position_desc']) ? nl2br(htmlspecialchars($_POST['position_desc'])) : '';
    $ad_width      = !empty($_POST['ad_width'])      ? intval($_POST['ad_width'])  : 0;
    $ad_height     = !empty($_POST['ad_height'])     ? intval($_POST['ad_height']) : 0;
    $position_id   = !empty($_POST['id'])            ? intval($_POST['id'])        : 0;
    /* �鿴���λ�Ƿ����������ظ� */
    $sql = 'SELECT COUNT(*) FROM ' .$ecs->table('ad_position').
           " WHERE position_name = '$position_name' AND position_id <> '$position_id'";
    if ($db->getOne($sql) == 0)
    {
        $sql = "UPDATE " .$ecs->table('ad_position'). " SET ".
               "position_name    = '$position_name', ".
               "ad_width         = '$ad_width', ".
               "ad_height        = '$ad_height', ".
               "position_desc    = '$position_desc', ".
               "position_style   = '$_POST[position_style]' ".
               "WHERE position_id = '$position_id'";
        if ($db->query($sql))
        {
           /* ��¼����Ա���� */
           admin_log($position_name, 'edit', 'ads_position');

           /* ������� */
           clear_cache_files();

           /* ��ʾ��Ϣ */
           $link[] = array('text' => $_LANG['back_position_list'], 'href' => 'ad_position.php?act=list');
           sys_msg($_LANG['edit'] . ' ' .stripslashes($position_name).' '. $_LANG['attradd_succed'], 0, $link);
        }
    }
    else
    {
        $link[] = array('text' => $_LANG['go_back'], 'href' => 'javascript:history.back(-1)');
        sys_msg($_LANG['posit_name_exist'], 0, $link);
    }
}

/*------------------------------------------------------ */
//-- ���򡢷�ҳ����ѯ
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'query')
{
    $position_list = ad_position_list();

    $smarty->assign('position_list',   $position_list['position']);
    $smarty->assign('filter',          $position_list['filter']);
    $smarty->assign('record_count',    $position_list['record_count']);
    $smarty->assign('page_count',      $position_list['page_count']);

    make_json_result($smarty->fetch('ad_position_list.htm'), '',
        array('filter' => $position_list['filter'], 'page_count' => $position_list['page_count']));
}

/*------------------------------------------------------ */
//-- �༭���λ������
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'edit_position_name')
{
    check_authz_json('ad_manage');

    $id     = intval($_POST['id']);
    $position_name   = json_str_iconv(trim($_POST['val']));

    /* ��������Ƿ��ظ� */
    if ($exc->num("position_name", $position_name, $id) != 0)
    {
        make_json_error(sprintf($_LANG['posit_name_exist'], $position_name));
    }
    else
    {
        if ($exc->edit("position_name = '$position_name'", $id))
        {
            admin_log($position_name,'edit','ads_position');
            make_json_result(stripslashes($position_name));
        }
        else
        {
            make_json_result(sprintf($_LANG['brandedit_fail'], $position_name));
        }
    }
}

/*------------------------------------------------------ */
//-- �༭���λ���
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'edit_ad_width')
{
    check_authz_json('ad_manage');

    $id         = intval($_POST['id']);
    $ad_width   = json_str_iconv(trim($_POST['val']));

    /* ���ֵ���������� */
    if (!preg_match("/^[\.0-9]+$/",$ad_width))
    {
        make_json_error($_LANG['width_number']);
    }

    /* ���λ���Ӧ��1-1024֮�� */
    if ($ad_width > 1024 || $ad_width < 1)
    {
        make_json_error($_LANG['width_value']);
    }

    if ($exc->edit("ad_width = '$ad_width'", $id))
    {
        clear_cache_files(); // ���ģ�滺��
        admin_log($ad_width, 'edit', 'ads_position');
        make_json_result(stripslashes($ad_width));
    }
    else
    {
        make_json_error($db->error());
    }
}

/*------------------------------------------------------ */
//-- �༭���λ���
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'edit_ad_height')
{
    check_authz_json('ad_manage');

    $id         = intval($_POST['id']);
    $ad_height  = json_str_iconv(trim($_POST['val']));

    /* �߶�ֵ���������� */
    if (!preg_match("/^[\.0-9]+$/",$ad_height))
    {
        make_json_error($_LANG['height_number']);
    }

    /* ���λ���Ӧ��1-1024֮�� */
    if ($ad_height > 1024 || $ad_height < 1)
    {
        make_json_error($_LANG['height_value']);
    }

    if ($exc->edit("ad_height = '$ad_height'", $id))
    {
        clear_cache_files(); // ���ģ�滺��
        admin_log($ad_height, 'edit', 'ads_position');
        make_json_result(stripslashes($ad_height));
    }
    else
    {
        make_json_error($db->error());
    }
}

/*------------------------------------------------------ */
//-- ɾ�����λ��
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'remove')
{
    check_authz_json('ad_manage');

    $id = intval($_GET['id']);

    /* ��ѯ���λ���Ƿ��й����� */
    $sql = "SELECT COUNT(*) FROM " .$GLOBALS['ecs']->table('ad'). " WHERE position_id = '$id'";

    if ($db->getOne($sql) > 0)
    {
        make_json_error($_LANG['not_del_adposit']);
    }
    else
    {
        $exc->drop($id);
        admin_log('', 'remove', 'ads_position');
    }

    $url = 'ad_position.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);

    ecs_header("Location: $url\n");
    exit;
}

/* ��ȡ���λ���б� */
function ad_position_list()
{
    $filter = array();

    /* ��¼�����Լ�ҳ�� */
    $sql = 'SELECT COUNT(*) FROM ' . $GLOBALS['ecs']->table('ad_position');
    $filter['record_count'] = $GLOBALS['db']->getOne($sql);

    $filter = page_and_size($filter);

    /* ��ѯ���� */
    $arr = array();
    $sql = 'SELECT * FROM ' .$GLOBALS['ecs']->table('ad_position'). ' ORDER BY position_id DESC';
    $res = $GLOBALS['db']->selectLimit($sql, $filter['page_size'], $filter['start']);
    while ($rows = $GLOBALS['db']->fetchRow($res))
    {
        $position_desc = !empty($rows['position_desc']) ? sub_str($rows['position_desc'], 50, true) : '';
        $rows['position_desc'] = nl2br(htmlspecialchars($position_desc));

        $arr[] = $rows;
    }

    return array('position' => $arr, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);
}

?>