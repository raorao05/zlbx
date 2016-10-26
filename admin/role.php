<?php

/**
 * ECSHOP ��ɫ������Ϣ�Լ�Ȩ�޹������
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: wangleisvn $
 * $Id: privilege.php 16529 2009-08-12 05:38:57Z wangleisvn $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

/* act������ĳ�ʼ�� */
if (empty($_REQUEST['act']))
{
    $_REQUEST['act'] = 'login';
}
else
{
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

/* ��ʼ�� $exc ���� */
$exc = new exchange($ecs->table("role"), $db, 'role_id', 'role_name');

/*------------------------------------------------------ */
//-- �˳���¼
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'logout')
{
    /* ���cookie */
    setcookie('ECSCP[admin_id]',   '', 1);
    setcookie('ECSCP[admin_pass]', '', 1);

    $sess->destroy_session();

    $_REQUEST['act'] = 'login';
}

/*------------------------------------------------------ */
//-- ��½����
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'login')
{
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header("Cache-Control: no-cache, must-revalidate");
    header("Pragma: no-cache");

    if ((intval($_CFG['captcha']) & CAPTCHA_ADMIN) && gd_version() > 0)
    {
        $smarty->assign('gd_version', gd_version());
        $smarty->assign('random',     mt_rand());
    }

    $smarty->display('login.htm');
}


/*------------------------------------------------------ */
//-- ��ɫ�б�ҳ��
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'list')
{
    /* ģ�帳ֵ */
    $smarty->assign('ur_here',     $_LANG['admin_role']);
    $smarty->assign('action_link', array('href'=>'role.php?act=add', 'text' => $_LANG['admin_add_role']));
    $smarty->assign('full_page',   1);
    $smarty->assign('admin_list',  get_role_list());

    /* ��ʾҳ�� */
    assign_query_info();
    $smarty->display('role_list.htm');
}

/*------------------------------------------------------ */
//-- ��ѯ
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'query')
{
    $smarty->assign('admin_list',  get_role_list());

    make_json_result($smarty->fetch('role_list.htm'));
}

/*------------------------------------------------------ */
//-- ��ӽ�ɫҳ��
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'add')
{
    /* ���Ȩ�� */
    admin_priv('admin_manage');
    include_once(ROOT_PATH . 'languages/' .$_CFG['lang']. '/admin/priv_action.php');

    $priv_str = '';

    /* ��ȡȨ�޵ķ������� */
    $sql_query = "SELECT action_id, parent_id, action_code, relevance FROM " .$ecs->table('admin_action').
                 " WHERE parent_id = 0";
    $res = $db->query($sql_query);
    while ($rows = $db->FetchRow($res))
    {
        $priv_arr[$rows['action_id']] = $rows;
    }


    /* ��Ȩ�����ѯ�׼���Ȩ������ */
    $sql = "SELECT action_id, parent_id, action_code, relevance FROM " .$ecs->table('admin_action').
           " WHERE parent_id " .db_create_in(array_keys($priv_arr));
    $result = $db->query($sql);
    while ($priv = $db->FetchRow($result))
    {
        $priv_arr[$priv["parent_id"]]["priv"][$priv["action_code"]] = $priv;
    }

    // ��ͬһ���Ȩ��ʹ�� "," ������������JSȫѡ
    foreach ($priv_arr AS $action_id => $action_group)
    {
        $priv_arr[$action_id]['priv_list'] = join(',', @array_keys($action_group['priv']));

        foreach ($action_group['priv'] AS $key => $val)
        {
            $priv_arr[$action_id]['priv'][$key]['cando'] = (strpos($priv_str, $val['action_code']) !== false || $priv_str == 'all') ? 1 : 0;
        }
    }

     /* ģ�帳ֵ */
    $smarty->assign('ur_here',     $_LANG['admin_add_role']);
    $smarty->assign('action_link', array('href'=>'role.php?act=list', 'text' => $_LANG['admin_list_role']));
    $smarty->assign('form_act',    'insert');
    $smarty->assign('action',      'add');
    $smarty->assign('lang',        $_LANG);
    $smarty->assign('priv_arr',    $priv_arr);

    /* ��ʾҳ�� */
    assign_query_info();
    $smarty->display('role_info.htm');




}

/*------------------------------------------------------ */
//-- ��ӽ�ɫ�Ĵ���
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'insert')
{
    admin_priv('admin_manage');
    $act_list = @join(",", $_POST['action_code']);
    $sql = "INSERT INTO ".$ecs->table('role')." (role_name, action_list, role_describe) ".
           "VALUES ('".trim($_POST['user_name'])."','$act_list','".trim($_POST['role_describe'])."')";

    $db->query($sql);
    /* ת��Ȩ�޷����б� */
    $new_id = $db->Insert_ID();

    /*�������*/

    $link[0]['text'] = $_LANG['admin_list_role'];
    $link[0]['href'] = 'role.php?act=list';

    sys_msg($_LANG['add'] . "&nbsp;" .$_POST['user_name'] . "&nbsp;" . $_LANG['action_succeed'],0, $link);

    /* ��¼����Ա���� */
    admin_log($_POST['user_name'], 'add', 'role');
 }

/*------------------------------------------------------ */
//-- �༭��ɫ��Ϣ
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'edit')
{
     include_once(ROOT_PATH . 'languages/' .$_CFG['lang']. '/admin/priv_action.php');
    $_REQUEST['id'] = !empty($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
        /* ��øù���Ա��Ȩ�� */
    $priv_str = $db->getOne("SELECT action_list FROM " .$ecs->table('role'). " WHERE role_id = '$_GET[id]'");

    /* �鿴�Ƿ���Ȩ�ޱ༭��������Ա����Ϣ */
    if ($_SESSION['admin_id'] != $_REQUEST['id'])
    {
        admin_priv('admin_manage');
    }

    /* ��ȡ��ɫ��Ϣ */
    $sql = "SELECT role_id, role_name, role_describe FROM " .$ecs->table('role').
           " WHERE role_id = '".$_REQUEST['id']."'";
    $user_info = $db->getRow($sql);

    /* ��ȡȨ�޵ķ������� */
    $sql_query = "SELECT action_id, parent_id, action_code,relevance FROM " .$ecs->table('admin_action').
                 " WHERE parent_id = 0";
    $res = $db->query($sql_query);
    while ($rows = $db->FetchRow($res))
    {
        $priv_arr[$rows['action_id']] = $rows;
    }

    /* ��Ȩ�����ѯ�׼���Ȩ������ */
    $sql = "SELECT action_id, parent_id, action_code,relevance FROM " .$ecs->table('admin_action').
           " WHERE parent_id " .db_create_in(array_keys($priv_arr));
    $result = $db->query($sql);
    while ($priv = $db->FetchRow($result))
    {
        $priv_arr[$priv["parent_id"]]["priv"][$priv["action_code"]] = $priv;
    }

    // ��ͬһ���Ȩ��ʹ�� "," ������������JSȫѡ
    foreach ($priv_arr AS $action_id => $action_group)
    {
        $priv_arr[$action_id]['priv_list'] = join(',', @array_keys($action_group['priv']));

        foreach ($action_group['priv'] AS $key => $val)
        {
            $priv_arr[$action_id]['priv'][$key]['cando'] = (strpos($priv_str, $val['action_code']) !== false || $priv_str == 'all') ? 1 : 0;
        }
    }


    /* ģ�帳ֵ */

    $smarty->assign('user',        $user_info);
    $smarty->assign('form_act',    'update');
    $smarty->assign('action',      'edit');
    $smarty->assign('ur_here',     $_LANG['admin_edit_role']);
    $smarty->assign('action_link', array('href'=>'role.php?act=list', 'text' => $_LANG['admin_list_role']));
    $smarty->assign('lang',        $_LANG);
    $smarty->assign('priv_arr',    $priv_arr);
    $smarty->assign('user_id',     $_GET['id']);

    assign_query_info();
    $smarty->display('role_info.htm');
}

/*------------------------------------------------------ */
//-- ���½�ɫ��Ϣ
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'update')
{
    /* ���¹���Ա��Ȩ�� */
    $act_list = @join(",", $_POST['action_code']);
    $sql = "UPDATE " .$ecs->table('role'). " SET action_list = '$act_list', role_name = '".$_POST['user_name']."', role_describe = '".$_POST['role_describe']." ' ".
           "WHERE role_id = '$_POST[id]'";
    $db->query($sql);
    $user_sql = "UPDATE " .$ecs->table('admin_user'). " SET action_list = '$act_list' ".
           "WHERE role_id = '$_POST[id]'";
    $db->query($user_sql);
    /* ��ʾ��Ϣ */
    $link[] = array('text' => $_LANG['back_admin_list'], 'href'=>'role.php?act=list');
    sys_msg($_LANG['edit'] . "&nbsp;" . $_POST['user_name'] . "&nbsp;" . $_LANG['action_succeed'], 0, $link);
}

/*------------------------------------------------------ */
//-- ɾ��һ����ɫ
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'remove')
{
    check_authz_json('admin_drop');

    $id = intval($_GET['id']);
    $num_sql = "SELECT count(*) FROM " .$ecs->table('admin_user'). " WHERE role_id = '$_GET[id]'";
    $remove_num = $db->getOne($num_sql);
    if($remove_num > 0)
    {
        make_json_error($_LANG['remove_cannot_user']);
    }
    else
    {
        $exc->drop($id);
        $url = 'role.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);
    }

    ecs_header("Location: $url\n");
    exit;
}

/* ��ȡ��ɫ�б� */
function get_role_list()
{
    $list = array();
    $sql  = 'SELECT role_id, role_name, action_list, role_describe '.
            'FROM ' .$GLOBALS['ecs']->table('role').' ORDER BY role_id DESC';
    $list = $GLOBALS['db']->getAll($sql);

    return $list;
}

?>
