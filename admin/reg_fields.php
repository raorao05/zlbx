<?php

/**
 * ECSHOP ��Ա�ȼ��������
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: testyang $
 * $Id: reg_fields.php 15013 2008-10-23 09:31:42Z testyang $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

$exc = new exchange($ecs->table("reg_fields"), $db, 'id', 'reg_field_name');

/*------------------------------------------------------ */
//-- ��Աע�����б�
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'list')
{
    $fields = array();
    $fields = $db->getAll("SELECT * FROM " . $ecs->table('reg_fields') . " ORDER BY dis_order, id");

    $smarty->assign('ur_here',      $_LANG['021_reg_fields']);
    $smarty->assign('action_link',  array('text' => $_LANG['add_reg_field'], 'href'=>'reg_fields.php?act=add'));
    $smarty->assign('full_page',    1);

    $smarty->assign('reg_fields',   $fields);

    assign_query_info();
    $smarty->display('reg_fields.htm');
}


/*------------------------------------------------------ */
//-- ��ҳ������
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'query')
{
    $fields = array();
    $fields = $db->getAll("SELECT * FROM " .$ecs->table('reg_fields') . "ORDER BY id");

    $smarty->assign('reg_fields',   $fields);
    make_json_result($smarty->fetch('reg_fields.htm'));
}

/*------------------------------------------------------ */
//-- ��ӻ�Աע����
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'add')
{
    admin_priv('reg_fields');

    $form_action = 'insert';

    $reg_field['reg_field_order'] = 100;
    $reg_field['reg_field_display'] = 1;
    $reg_field['reg_field_need'] = 1;

    $smarty->assign('reg_field',  $reg_field);
    $smarty->assign('ur_here',     $_LANG['add_reg_field']);
    $smarty->assign('action_link', array('text' => $_LANG['021_reg_fields'], 'href'=>'reg_fields.php?act=list'));
    $smarty->assign('form_action', $form_action);

    assign_query_info();
    $smarty->display('reg_field_info.htm');
}

/*------------------------------------------------------ */
//-- ���ӻ�Աע������ݿ�
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'insert')
{
    admin_priv('reg_fields');

    /* ����Ƿ���������Ļ�Աע���� */
    if (!$exc->is_only('reg_field_name', trim($_POST['reg_field_name'])))
    {
        sys_msg(sprintf($_LANG['field_name_exist'], trim($_POST['reg_field_name'])), 1);
    }

    $sql = "INSERT INTO " .$ecs->table('reg_fields') ."( ".
                "reg_field_name, dis_order, display, is_need".
            ") VALUES (".
                "'$_POST[reg_field_name]', '$_POST[reg_field_order]', '$_POST[reg_field_display]', '$_POST[reg_field_need]')";
    $db->query($sql);

    /* ����Ա��־ */
    admin_log(trim($_POST['reg_field_name']), 'add', 'reg_fields');
    clear_cache_files();

    $lnk[] = array('text' => $_LANG['back_list'],    'href'=>'reg_fields.php?act=list');
    $lnk[] = array('text' => $_LANG['add_continue'], 'href'=>'reg_fields.php?act=add');
    sys_msg($_LANG['add_field_success'], 0, $lnk);
}

/*------------------------------------------------------ */
//-- �༭��Աע����
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'edit')
{
    admin_priv('reg_fields');

    $form_action = 'update';

    $sql = "SELECT id AS reg_field_id, reg_field_name, dis_order AS reg_field_order, display AS reg_field_display, is_need AS reg_field_need FROM ".
           $ecs->table('reg_fields'). " WHERE id='$_REQUEST[id]'";
    $reg_field = $db->GetRow($sql);

    $smarty->assign('reg_field',  $reg_field);
    $smarty->assign('ur_here',     $_LANG['add_reg_field']);
    $smarty->assign('action_link', array('text' => $_LANG['021_reg_fields'], 'href'=>'reg_fields.php?act=list'));
    $smarty->assign('form_action', $form_action);

    assign_query_info();
    $smarty->display('reg_field_info.htm');
}

/*------------------------------------------------------ */
//-- ���»�Աע����
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'update')
{
    admin_priv('reg_fields');

    /* ����Ƿ���������Ļ�Աע���� */
    if ($_POST['reg_field_name'] != $_POST['old_field_name'] && !$exc->is_only('reg_field_name', trim($_POST['reg_field_name'])))
    {
        sys_msg(sprintf($_LANG['field_name_exist'], trim($_POST['reg_field_name'])), 1);
    }

    $sql = "UPDATE " .$ecs->table('reg_fields') . " SET `reg_field_name` = '$_POST[reg_field_name]', `dis_order` = '$_POST[reg_field_order]', `display` = '$_POST[reg_field_display]', `is_need` = '$_POST[reg_field_need]' WHERE `id` = '$_POST[id]'";
    $db->query($sql);

    /* ����Ա��־ */
    admin_log(trim($_POST['reg_field_name']), 'edit', 'reg_fields');
    clear_cache_files();

    $lnk[] = array('text' => $_LANG['back_list'],    'href'=>'reg_fields.php?act=list');
    sys_msg($_LANG['update_field_success'], 0, $lnk);
}

/*------------------------------------------------------ */
//-- ɾ����Աע����
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'remove')
{
    check_authz_json('reg_fields');

    $field_id = intval($_GET['id']);
    $field_name = $exc->get_name($field_id);

    if ($exc->drop($field_id))
    {
        /* ɾ����Ա��չ��Ϣ�����Ӧ��Ϣ */
        $sql = "DELETE FROM " . $GLOBALS['ecs']->table('reg_extend_info') . " WHERE reg_field_id = '" . $field_id . "'";
        @$GLOBALS['db']->query($sql);

        admin_log(addslashes($field_name), 'remove', 'reg_fields');
        clear_cache_files();
    }

    $url = 'reg_fields.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);

    ecs_header("Location: $url\n");
    exit;

}

/*
 *  �༭��Աע��������
 */
elseif ($_REQUEST['act'] == 'edit_name')
{
    $id = intval($_REQUEST['id']);
    $val = empty($_REQUEST['val']) ? '' : json_str_iconv(trim($_REQUEST['val']));
    check_authz_json('reg_fields');
    if ($exc->is_only('reg_field_name', $val, $id))
    {
        if ($exc->edit("reg_field_name = '$val'", $id))
        {
            /* ����Ա��־ */
            admin_log($val, 'edit', 'reg_fields');
            clear_cache_files();
            make_json_result(stripcslashes($val));
        }
        else
        {
            make_json_error($db->error());
        }
    }
    else
    {
        make_json_error(sprintf($_LANG['field_name_exist'], htmlspecialchars($val)));
    }
}

/*
 *  �༭��Աע��������Ȩֵ
 */
elseif ($_REQUEST['act'] == 'edit_order')
{
    $id = intval($_REQUEST['id']);
    $val = isset($_REQUEST['val']) ? json_str_iconv(trim($_REQUEST['val'])) : '' ;
    check_authz_json('reg_fields');
    if (is_numeric($val))
    {
        if ($exc->edit("dis_order = '$val'", $id))
        {
            /* ����Ա��־ */
            admin_log($val, 'edit', 'reg_fields');
            clear_cache_files();
            make_json_result(stripcslashes($val));
        }
        else
        {
            make_json_error($db->error());
        }
    }
    else
    {
        make_json_error($_LANG['order_not_num']);
    }
}

/*------------------------------------------------------ */
//-- �޸Ļ�Աע������ʾ״̬
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'toggle_dis')
{
    check_authz_json('reg_fields');

    $id     = intval($_POST['id']);
    $is_dis = intval($_POST['val']);

    if ($exc->edit("display = '$is_dis'", $id))
    {
        clear_cache_files();
        make_json_result($is_dis);
    }
}

/*------------------------------------------------------ */
//-- �޸Ļ�Աע�������״̬
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'toggle_need')
{
    check_authz_json('reg_fields');

    $id     = intval($_POST['id']);
    $is_need = intval($_POST['val']);

    if ($exc->edit("is_need = '$is_need'", $id))
    {
        clear_cache_files();
        make_json_result($is_need);
    }
}
?>