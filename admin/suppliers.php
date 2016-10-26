<?php

/**
 * ECSHOP �������Ĺ����̹���
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: wanglei $
 * $Id: suppliers.php 15013 2009-05-13 09:31:42Z wanglei $
 */

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

define('SUPPLIERS_ACTION_LIST', 'delivery_view,back_view');
/*------------------------------------------------------ */
//-- �������б�
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'list')
{
     /* ���Ȩ�� */
     admin_priv('suppliers_manage');

    /* ��ѯ */
    $result = suppliers_list();

    /* ģ�帳ֵ */
    $smarty->assign('ur_here', $_LANG['suppliers_list']); // ��ǰ����
    $smarty->assign('action_link', array('href' => 'suppliers.php?act=add', 'text' => $_LANG['add_suppliers']));

    $smarty->assign('full_page',        1); // ��ҳ����

    $smarty->assign('suppliers_list',    $result['result']);
    $smarty->assign('filter',       $result['filter']);
    $smarty->assign('record_count', $result['record_count']);
    $smarty->assign('page_count',   $result['page_count']);
    $smarty->assign('sort_suppliers_id', '<img src="images/sort_desc.gif">');

    /* ��ʾģ�� */
    assign_query_info();
    $smarty->display('suppliers_list.htm');
}

/*------------------------------------------------------ */
//-- ���򡢷�ҳ����ѯ
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'query')
{
    check_authz_json('suppliers_manage');

    $result = suppliers_list();

    $smarty->assign('suppliers_list',    $result['result']);
    $smarty->assign('filter',       $result['filter']);
    $smarty->assign('record_count', $result['record_count']);
    $smarty->assign('page_count',   $result['page_count']);

    /* ������ */
    $sort_flag  = sort_flag($result['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    make_json_result($smarty->fetch('suppliers_list.htm'), '',
        array('filter' => $result['filter'], 'page_count' => $result['page_count']));
}

/*------------------------------------------------------ */
//-- �б�ҳ�༭����
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'edit_suppliers_name')
{
    check_authz_json('suppliers_manage');

    $id     = intval($_POST['id']);
    $name   = json_str_iconv(trim($_POST['val']));

    /* �ж������Ƿ��ظ� */
    $sql = "SELECT suppliers_id
            FROM " . $ecs->table('suppliers') . "
            WHERE suppliers_name = '$name'
            AND suppliers_id <> '$id' ";
    if ($db->getOne($sql))
    {
        make_json_error(sprintf($_LANG['suppliers_name_exist'], $name));
    }
    else
    {
        /* ���湩������Ϣ */
        $sql = "UPDATE " . $ecs->table('suppliers') . "
                SET suppliers_name = '$name'
                WHERE suppliers_id = '$id'";
        if ($result = $db->query($sql))
        {
            /* ����־ */
            admin_log($name, 'edit', 'suppliers');

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
//-- ɾ��������
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'remove')
{
    check_authz_json('suppliers_manage');

    $id = intval($_REQUEST['id']);
    $sql = "SELECT *
            FROM " . $ecs->table('suppliers') . "
            WHERE suppliers_id = '$id'";
    $suppliers = $db->getRow($sql, TRUE);

    if ($suppliers['suppliers_id'])
    {
        /* �жϹ������Ƿ���ڶ��� */
        $sql = "SELECT COUNT(*)
                FROM " . $ecs->table('order_info') . "AS O, " . $ecs->table('order_goods') . " AS OG, " . $ecs->table('goods') . " AS G
                WHERE O.order_id = OG.order_id
                AND OG.goods_id = G.goods_id
                AND G.suppliers_id = '$id'";
        $order_exists = $db->getOne($sql, TRUE);
        if ($order_exists > 0)
        {
            $url = 'suppliers.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);
            ecs_header("Location: $url\n");
            exit;
        }

        /* �жϹ������Ƿ������Ʒ */
        $sql = "SELECT COUNT(*)
                FROM " . $ecs->table('goods') . "AS G
                WHERE G.suppliers_id = '$id'";
        $goods_exists = $db->getOne($sql, TRUE);
        if ($goods_exists > 0)
        {
            $url = 'suppliers.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);
            ecs_header("Location: $url\n");
            exit;
        }

        $sql = "DELETE FROM " . $ecs->table('suppliers') . "
            WHERE suppliers_id = '$id'";
        $db->query($sql);

        /* ɾ������Ա���������������˻��������Ͷ��������Ĺ����� */
        $table_array = array('admin_user', 'delivery_order', 'back_order');
        foreach ($table_array as $value)
        {
            $sql = "DELETE FROM " . $ecs->table($value) . " WHERE suppliers_id = '$id'";
            $db->query($sql, 'SILENT');
        }

        /* ����־ */
        admin_log($suppliers['suppliers_name'], 'remove', 'suppliers');

        /* ������� */
        clear_cache_files();
    }

    $url = 'suppliers.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);
    ecs_header("Location: $url\n");

    exit;
}

/*------------------------------------------------------ */
//-- �޸Ĺ�����״̬
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'is_check')
{
    check_authz_json('suppliers_manage');

    $id = intval($_REQUEST['id']);
    $sql = "SELECT suppliers_id, is_check
            FROM " . $ecs->table('suppliers') . "
            WHERE suppliers_id = '$id'";
    $suppliers = $db->getRow($sql, TRUE);

    if ($suppliers['suppliers_id'])
    {
        $_suppliers['is_check'] = empty($suppliers['is_check']) ? 1 : 0;
        $db->autoExecute($ecs->table('suppliers'), $_suppliers, '', "suppliers_id = '$id'");
        clear_cache_files();
        make_json_result($_suppliers['is_check']);
    }

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
        admin_priv('suppliers_manage');

        $ids = $_POST['checkboxes'];

        if (isset($_POST['remove']))
        {
            $sql = "SELECT *
                    FROM " . $ecs->table('suppliers') . "
                    WHERE suppliers_id " . db_create_in($ids);
            $suppliers = $db->getAll($sql);

            foreach ($suppliers as $key => $value)
            {
                /* �жϹ������Ƿ���ڶ��� */
                $sql = "SELECT COUNT(*)
                        FROM " . $ecs->table('order_info') . "AS O, " . $ecs->table('order_goods') . " AS OG, " . $ecs->table('goods') . " AS G
                        WHERE O.order_id = OG.order_id
                        AND OG.goods_id = G.goods_id
                        AND G.suppliers_id = '" . $value['suppliers_id'] . "'";
                $order_exists = $db->getOne($sql, TRUE);
                if ($order_exists > 0)
                {
                    unset($suppliers[$key]);
                }

                /* �жϹ������Ƿ������Ʒ */
                $sql = "SELECT COUNT(*)
                        FROM " . $ecs->table('goods') . "AS G
                        WHERE G.suppliers_id = '" . $value['suppliers_id'] . "'";
                $goods_exists = $db->getOne($sql, TRUE);
                if ($goods_exists > 0)
                {
                    unset($suppliers[$key]);
                }
            }
            if (empty($suppliers))
            {
                sys_msg($_LANG['batch_drop_no']);
            }


            $sql = "DELETE FROM " . $ecs->table('suppliers') . "
                WHERE suppliers_id " . db_create_in($ids);
            $db->query($sql);

            /* ���¹���Ա���������������˻��������Ͷ��������Ĺ����� */
            $table_array = array('admin_user', 'delivery_order', 'back_order');
            foreach ($table_array as $value)
            {
                $sql = "DELETE FROM " . $ecs->table($value) . " WHERE suppliers_id " . db_create_in($ids) . " ";
                $db->query($sql, 'SILENT');
            }

            /* ����־ */
            $suppliers_names = '';
            foreach ($suppliers as $value)
            {
                $suppliers_names .= $value['suppliers_name'] . '|';
            }
            admin_log($suppliers_names, 'remove', 'suppliers');

            /* ������� */
            clear_cache_files();

            sys_msg($_LANG['batch_drop_ok']);
        }
    }
}

/*------------------------------------------------------ */
//-- ��ӡ��༭������
/*------------------------------------------------------ */
elseif (in_array($_REQUEST['act'], array('add', 'edit')))
{
    /* ���Ȩ�� */
    admin_priv('suppliers_manage');

    if ($_REQUEST['act'] == 'add')
    {
        $suppliers = array();

        /* ȡ�����й���Ա��*/
        /* ��ע��Щ�Ǹù����̵�('this')����Щ�ǿ��е�('free')����Щ�Ǳ�Ĺ����̵�('other') */
        /* �ų��ǰ��´��Ĺ���Ա */
        $sql = "SELECT user_id, user_name, CASE
                WHEN suppliers_id = 0 THEN 'free'
                ELSE 'other' END AS type
                FROM " . $ecs->table('admin_user') . "
                WHERE agency_id = 0
                AND action_list <> 'all'";
        $suppliers['admin_list'] = $db->getAll($sql);

        $smarty->assign('ur_here', $_LANG['add_suppliers']);
        $smarty->assign('action_link', array('href' => 'suppliers.php?act=list', 'text' => $_LANG['suppliers_list']));

        $smarty->assign('form_action', 'insert');
        $smarty->assign('suppliers', $suppliers);

        assign_query_info();

        $smarty->display('suppliers_info.htm');

    }
    elseif ($_REQUEST['act'] == 'edit')
    {
        $suppliers = array();

        /* ȡ�ù�������Ϣ */
        $id = $_REQUEST['id'];
        $sql = "SELECT * FROM " . $ecs->table('suppliers') . " WHERE suppliers_id = '$id'";
        $suppliers = $db->getRow($sql);
        if (count($suppliers) <= 0)
        {
            sys_msg('suppliers does not exist');
        }

        /* ȡ�����й���Ա��*/
        /* ��ע��Щ�Ǹù����̵�('this')����Щ�ǿ��е�('free')����Щ�Ǳ�Ĺ����̵�('other') */
        /* �ų��ǰ��´��Ĺ���Ա */
        $sql = "SELECT user_id, user_name, CASE
                WHEN suppliers_id = '$id' THEN 'this'
                WHEN suppliers_id = 0 THEN 'free'
                ELSE 'other' END AS type
                FROM " . $ecs->table('admin_user') . "
                WHERE agency_id = 0
                AND action_list <> 'all'";
        $suppliers['admin_list'] = $db->getAll($sql);

        $smarty->assign('ur_here', $_LANG['edit_suppliers']);
        $smarty->assign('action_link', array('href' => 'suppliers.php?act=list', 'text' => $_LANG['suppliers_list']));

        $smarty->assign('form_action', 'update');
        $smarty->assign('suppliers', $suppliers);

        assign_query_info();

        $smarty->display('suppliers_info.htm');
    }

}

/*------------------------------------------------------ */
//-- �ύ��ӡ��༭������
/*------------------------------------------------------ */
elseif (in_array($_REQUEST['act'], array('insert', 'update')))
{
    /* ���Ȩ�� */
    admin_priv('suppliers_manage');

    if ($_REQUEST['act'] == 'insert')
    {
        /* �ύֵ */
        $suppliers = array('suppliers_name'   => trim($_POST['suppliers_name']),
                           'suppliers_desc'   => trim($_POST['suppliers_desc']),
                           'parent_id'        => 0
                           );

        /* �ж������Ƿ��ظ� */
        $sql = "SELECT suppliers_id
                FROM " . $ecs->table('suppliers') . "
                WHERE suppliers_name = '" . $suppliers['suppliers_name'] . "' ";
        if ($db->getOne($sql))
        {
            sys_msg($_LANG['suppliers_name_exist']);
        }

        $db->autoExecute($ecs->table('suppliers'), $suppliers, 'INSERT');
        $suppliers['suppliers_id'] = $db->insert_id();

        if (isset($_POST['admins']))
        {
            $sql = "UPDATE " . $ecs->table('admin_user') . " SET suppliers_id = '" . $suppliers['suppliers_id'] . "', action_list = '" . SUPPLIERS_ACTION_LIST . "' WHERE user_id " . db_create_in($_POST['admins']);
            $db->query($sql);
        }

        /* ����־ */
        admin_log($suppliers['suppliers_name'], 'add', 'suppliers');

        /* ������� */
        clear_cache_files();

        /* ��ʾ��Ϣ */
        $links = array(array('href' => 'suppliers.php?act=add',  'text' => $_LANG['continue_add_suppliers']),
                       array('href' => 'suppliers.php?act=list', 'text' => $_LANG['back_suppliers_list'])
                       );
        sys_msg($_LANG['add_suppliers_ok'], 0, $links);

    }

    if ($_REQUEST['act'] == 'update')
    {
        /* �ύֵ */
        $suppliers = array('id'   => trim($_POST['id']));

        $suppliers['new'] = array('suppliers_name'   => trim($_POST['suppliers_name']),
                           'suppliers_desc'   => trim($_POST['suppliers_desc'])
                           );

        /* ȡ�ù�������Ϣ */
        $sql = "SELECT * FROM " . $ecs->table('suppliers') . " WHERE suppliers_id = '" . $suppliers['id'] . "'";
        $suppliers['old'] = $db->getRow($sql);
        if (empty($suppliers['old']['suppliers_id']))
        {
            sys_msg('suppliers does not exist');
        }

        /* �ж������Ƿ��ظ� */
        $sql = "SELECT suppliers_id
                FROM " . $ecs->table('suppliers') . "
                WHERE suppliers_name = '" . $suppliers['new']['suppliers_name'] . "'
                AND suppliers_id <> '" . $suppliers['id'] . "'";
        if ($db->getOne($sql))
        {
            sys_msg($_LANG['suppliers_name_exist']);
        }

        /* ���湩������Ϣ */
        $db->autoExecute($ecs->table('suppliers'), $suppliers['new'], 'UPDATE', "suppliers_id = '" . $suppliers['id'] . "'");

        /* ��չ����̵Ĺ���Ա */
        $sql = "UPDATE " . $ecs->table('admin_user') . " SET suppliers_id = 0, action_list = '" . SUPPLIERS_ACTION_LIST . "' WHERE suppliers_id = '" . $suppliers['id'] . "'";
        $db->query($sql);

        /* ��ӹ����̵Ĺ���Ա */
        if (isset($_POST['admins']))
        {
            $sql = "UPDATE " . $ecs->table('admin_user') . " SET suppliers_id = '" . $suppliers['old']['suppliers_id'] . "' WHERE user_id " . db_create_in($_POST['admins']);
            $db->query($sql);
        }

        /* ����־ */
        admin_log($suppliers['old']['suppliers_name'], 'edit', 'suppliers');

        /* ������� */
        clear_cache_files();

        /* ��ʾ��Ϣ */
        $links[] = array('href' => 'suppliers.php?act=list', 'text' => $_LANG['back_suppliers_list']);
        sys_msg($_LANG['edit_suppliers_ok'], 0, $links);
    }

}

/**
 *  ��ȡ��Ӧ���б���Ϣ
 *
 * @access  public
 * @param
 *
 * @return void
 */
function suppliers_list()
{
    $result = get_filter();
    if ($result === false)
    {
        $aiax = isset($_GET['is_ajax']) ? $_GET['is_ajax'] : 0;

        /* ������Ϣ */
        $filter['sort_by'] = empty($_REQUEST['sort_by']) ? 'suppliers_id' : trim($_REQUEST['sort_by']);
        $filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'ASC' : trim($_REQUEST['sort_order']);

        $where = 'WHERE 1 ';

        /* ��ҳ��С */
        $filter['page'] = empty($_REQUEST['page']) || (intval($_REQUEST['page']) <= 0) ? 1 : intval($_REQUEST['page']);

        if (isset($_REQUEST['page_size']) && intval($_REQUEST['page_size']) > 0)
        {
            $filter['page_size'] = intval($_REQUEST['page_size']);
        }
        elseif (isset($_COOKIE['ECSCP']['page_size']) && intval($_COOKIE['ECSCP']['page_size']) > 0)
        {
            $filter['page_size'] = intval($_COOKIE['ECSCP']['page_size']);
        }
        else
        {
            $filter['page_size'] = 15;
        }

        /* ��¼���� */
        $sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('suppliers') . $where;
        $filter['record_count']   = $GLOBALS['db']->getOne($sql);
        $filter['page_count']     = $filter['record_count'] > 0 ? ceil($filter['record_count'] / $filter['page_size']) : 1;

        /* ��ѯ */
        $sql = "SELECT suppliers_id, suppliers_name, suppliers_desc, is_check
                FROM " . $GLOBALS['ecs']->table("suppliers") . "
                $where
                ORDER BY " . $filter['sort_by'] . " " . $filter['sort_order']. "
                LIMIT " . ($filter['page'] - 1) * $filter['page_size'] . ", " . $filter['page_size'] . " ";

        set_filter($filter, $sql);
    }
    else
    {
        $sql    = $result['sql'];
        $filter = $result['filter'];
    }

    $row = $GLOBALS['db']->getAll($sql);

    $arr = array('result' => $row, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);

    return $arr;
}
?>