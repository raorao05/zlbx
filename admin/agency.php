<?php

/**
 * ECSHOP �������İ��´�����
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: agency.php 17217 2011-01-19 06:29:08Z liubo $
 */

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

$exc = new exchange($ecs->table('agency'), $db, 'agency_id', 'agency_name');

/*------------------------------------------------------ */
//-- ���´��б�
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'list')
{
    $smarty->assign('ur_here',      $_LANG['agency_list']);
    $smarty->assign('action_link',  array('text' => $_LANG['add_agency'], 'href' => 'agency.php?act=add'));
    $smarty->assign('full_page',    1);

    $agency_list = get_agencylist();
    $smarty->assign('agency_list',  $agency_list['agency']);
    $smarty->assign('filter',       $agency_list['filter']);
    $smarty->assign('record_count', $agency_list['record_count']);
    $smarty->assign('page_count',   $agency_list['page_count']);

    /* ������ */
    $sort_flag  = sort_flag($agency_list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    assign_query_info();
    $smarty->display('agency_list.htm');
}

/*------------------------------------------------------ */
//-- ���򡢷�ҳ����ѯ
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'query')
{
    $agency_list = get_agencylist();
    $smarty->assign('agency_list',  $agency_list['agency']);
    $smarty->assign('filter',       $agency_list['filter']);
    $smarty->assign('record_count', $agency_list['record_count']);
    $smarty->assign('page_count',   $agency_list['page_count']);

    /* ������ */
    $sort_flag  = sort_flag($agency_list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    make_json_result($smarty->fetch('agency_list.htm'), '',
        array('filter' => $agency_list['filter'], 'page_count' => $agency_list['page_count']));
}

/*------------------------------------------------------ */
//-- �б�ҳ�༭����
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'edit_agency_name')
{
    check_authz_json('agency_manage');

    $id     = intval($_POST['id']);
    $name   = json_str_iconv(trim($_POST['val']));

    /* ��������Ƿ��ظ� */
    if ($exc->num("agency_name", $name, $id) != 0)
    {
        make_json_error(sprintf($_LANG['agency_name_exist'], $name));
    }
    else
    {
        if ($exc->edit("agency_name = '$name'", $id))
        {
            admin_log($name, 'edit', 'agency');
            clear_cache_files();
            make_json_result(stripslashes($name));
        }
        else
        {
            make_json_result(sprintf($_LANG['agency_edit_fail'], $name));
        }
    }
}

/*------------------------------------------------------ */
//-- ɾ�����´�
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'remove')
{
    check_authz_json('agency_manage');

    $id = intval($_GET['id']);
    $name = $exc->get_name($id);
    $exc->drop($id);

    /* ���¹���Ա�����͵��������������˻����Ͷ��������İ��´� */
    $table_array = array('admin_user', 'region', 'order_info', 'delivery_order', 'back_order');
    foreach ($table_array as $value)
    {
        $sql = "UPDATE " . $ecs->table($value) . " SET agency_id = 0 WHERE agency_id = '$id'";
        $db->query($sql);
    }

    /* ����־ */
    admin_log($name, 'remove', 'agency');

    /* ������� */
    clear_cache_files();

    $url = 'agency.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);

    ecs_header("Location: $url\n");
    exit;
}

/*------------------------------------------------------ */
//-- ��������
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'batch')
{
    /* ȡ��Ҫ�����ļ�¼��� */
    if (empty($_POST['checkboxes']))
    {
        sys_msg($_LANG['no_record_selected']);
    }
    else
    {
        /* ���Ȩ�� */
        admin_priv('agency_manage');

        $ids = $_POST['checkboxes'];

        if (isset($_POST['remove']))
        {
            /* ɾ����¼ */
            $sql = "DELETE FROM " . $ecs->table('agency') .
                    " WHERE agency_id " . db_create_in($ids);
            $db->query($sql);

            /* ���¹���Ա�����͵��������������˻����Ͷ��������İ��´� */
            $table_array = array('admin_user', 'region', 'order_info', 'delivery_order', 'back_order');
            foreach ($table_array as $value)
            {
                $sql = "UPDATE " . $ecs->table($value) . " SET agency_id = 0 WHERE agency_id " . db_create_in($ids) . " ";
                $db->query($sql);
            }

            /* ����־ */
            admin_log('', 'batch_remove', 'agency');

            /* ������� */
            clear_cache_files();

            sys_msg($_LANG['batch_drop_ok']);
        }
    }
}

/*------------------------------------------------------ */
//-- ��ӡ��༭���´�
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'add' || $_REQUEST['act'] == 'edit')
{
    /* ���Ȩ�� */
    admin_priv('agency_manage');

    /* �Ƿ���� */
    $is_add = $_REQUEST['act'] == 'add';
    $smarty->assign('form_action', $is_add ? 'insert' : 'update');

    /* ��ʼ����ȡ�ð��´���Ϣ */
    if ($is_add)
    {
        $agency = array(
            'agency_id'     => 0,
            'agency_name'   => '',
            'agency_desc'   => '',
            'region_list'   => array()
        );
    }
    else
    {
        if (empty($_GET['id']))
        {
            sys_msg('invalid param');
        }

        $id = $_GET['id'];
        $sql = "SELECT * FROM " . $ecs->table('agency') . " WHERE agency_id = '$id'";
        $agency = $db->getRow($sql);
        if (empty($agency))
        {
            sys_msg('agency does not exist');
        }

        /* �����ĵ��� */
        $sql = "SELECT region_id, region_name FROM " . $ecs->table('region') .
                " WHERE agency_id = '$id'";
        $agency['region_list'] = $db->getAll($sql);
    }

    /* ȡ�����й���Ա����ע��Щ�Ǹð��´���('this')����Щ�ǿ��е�('free')����Щ�Ǳ�İ��´���('other') */
    $sql = "SELECT user_id, user_name, CASE " .
            "WHEN agency_id = 0 THEN 'free' " .
            "WHEN agency_id = '$agency[agency_id]' THEN 'this' " .
            "ELSE 'other' END " .
            "AS type " .
            "FROM " . $ecs->table('admin_user');
    $agency['admin_list'] = $db->getAll($sql);

    $smarty->assign('agency', $agency);

    /* ȡ�õ��� */
    $country_list = get_regions();
    $smarty->assign('countries', $country_list);

    /* ��ʾģ�� */
    if ($is_add)
    {
        $smarty->assign('ur_here', $_LANG['add_agency']);
    }
    else
    {
        $smarty->assign('ur_here', $_LANG['edit_agency']);
    }
    if ($is_add)
    {
        $href = 'agency.php?act=list';
    }
    else
    {
        $href = 'agency.php?act=list&' . list_link_postfix();
    }
    $smarty->assign('action_link', array('href' => $href, 'text' => $_LANG['agency_list']));
    assign_query_info();
    $smarty->display('agency_info.htm');
}

/*------------------------------------------------------ */
//-- �ύ��ӡ��༭���´�
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'insert' || $_REQUEST['act'] == 'update')
{
    /* ���Ȩ�� */
    admin_priv('agency_manage');

    /* �Ƿ���� */
    $is_add = $_REQUEST['act'] == 'insert';

    /* �ύֵ */
    $agency = array(
        'agency_id'     => intval($_POST['id']),
        'agency_name'   => sub_str($_POST['agency_name'], 255, false),
        'agency_desc'   => $_POST['agency_desc']
    );

    /* �ж������Ƿ��ظ� */
    if (!$exc->is_only('agency_name', $agency['agency_name'], $agency['agency_id']))
    {
        sys_msg($_LANG['agency_name_exist']);
    }

    /* ����Ƿ�ѡ���˵��� */
    if (empty($_POST['regions']))
    {
        sys_msg($_LANG['no_regions']);
    }

    /* ������´���Ϣ */
    if ($is_add)
    {
        $db->autoExecute($ecs->table('agency'), $agency, 'INSERT');
        $agency['agency_id'] = $db->insert_id();
    }
    else
    {
        $db->autoExecute($ecs->table('agency'), $agency, 'UPDATE', "agency_id = '$agency[agency_id]'");
    }

    /* ���¹���Ա��͵����� */
    if (!$is_add)
    {
        $sql = "UPDATE " . $ecs->table('admin_user') . " SET agency_id = 0 WHERE agency_id = '$agency[agency_id]'";
        $db->query($sql);

        $sql = "UPDATE " . $ecs->table('region') . " SET agency_id = 0 WHERE agency_id = '$agency[agency_id]'";
        $db->query($sql);
    }

    if (isset($_POST['admins']))
    {
        $sql = "UPDATE " . $ecs->table('admin_user') . " SET agency_id = '$agency[agency_id]' WHERE user_id " . db_create_in($_POST['admins']);
        $db->query($sql);
    }

    if (isset($_POST['regions']))
    {
        $sql = "UPDATE " . $ecs->table('region') . " SET agency_id = '$agency[agency_id]' WHERE region_id " . db_create_in($_POST['regions']);
        $db->query($sql);
    }

    /* ����־ */
    if ($is_add)
    {
        admin_log($agency['agency_name'], 'add', 'agency');
    }
    else
    {
        admin_log($agency['agency_name'], 'edit', 'agency');
    }

    /* ������� */
    clear_cache_files();

    /* ��ʾ��Ϣ */
    if ($is_add)
    {
        $links = array(
            array('href' => 'agency.php?act=add', 'text' => $_LANG['continue_add_agency']),
            array('href' => 'agency.php?act=list', 'text' => $_LANG['back_agency_list'])
        );
        sys_msg($_LANG['add_agency_ok'], 0, $links);
    }
    else
    {
        $links = array(
            array('href' => 'agency.php?act=list&' . list_link_postfix(), 'text' => $_LANG['back_agency_list'])
        );
        sys_msg($_LANG['edit_agency_ok'], 0, $links);
    }
}

/**
 * ȡ�ð��´��б�
 * @return  array
 */
function get_agencylist()
{
    $result = get_filter();
    if ($result === false)
    {
        /* ��ʼ����ҳ���� */
        $filter = array();
        $filter['sort_by']    = empty($_REQUEST['sort_by']) ? 'agency_id' : trim($_REQUEST['sort_by']);
        $filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);

        /* ��ѯ��¼�����������ҳ�� */
        $sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('agency');
        $filter['record_count'] = $GLOBALS['db']->getOne($sql);
        $filter = page_and_size($filter);

        /* ��ѯ��¼ */
        $sql = "SELECT * FROM " . $GLOBALS['ecs']->table('agency') . " ORDER BY $filter[sort_by] $filter[sort_order]";

        set_filter($filter, $sql);
    }
    else
    {
        $sql    = $result['sql'];
        $filter = $result['filter'];
    }
    $res = $GLOBALS['db']->selectLimit($sql, $filter['page_size'], $filter['start']);

    $arr = array();
    while ($rows = $GLOBALS['db']->fetchRow($res))
    {
        $arr[] = $rows;
    }

    return array('agency' => $arr, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);
}

?>