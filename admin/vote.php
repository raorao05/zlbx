<?php

/**
 * ECSHOP  ����������
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: vote.php 17217 2011-01-19 06:29:08Z liubo $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

/* act������ĳ�ʼ�� */
if (empty($_REQUEST['act']))
{
    $_REQUEST['act'] = 'list';
}
else
{
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

$exc = new exchange($ecs->table("vote"), $db, 'vote_id', 'vote_name');
$exc_opn = new exchange($ecs->table("vote_option"), $db, 'option_id', 'option_name');

/*------------------------------------------------------ */
//-- ͶƱ�б�ҳ��
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'list')
{
    /* ģ�帳ֵ */
    $smarty->assign('ur_here',      $_LANG['list_vote']);
    $smarty->assign('action_link',  array('text' => $_LANG['add_vote'], 'href'=>'vote.php?act=add'));
    $smarty->assign('full_page',    1);

    $vote_list = get_votelist();

    $smarty->assign('list',            $vote_list['list']);
    $smarty->assign('filter',          $vote_list['filter']);
    $smarty->assign('record_count',    $vote_list['record_count']);
    $smarty->assign('page_count',      $vote_list['page_count']);

    /* ��ʾҳ�� */
    assign_query_info();
    $smarty->display('vote_list.htm');
}

/*------------------------------------------------------ */
//-- ���򡢷�ҳ����ѯ
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'query')
{
    $vote_list = get_votelist();

    $smarty->assign('list',            $vote_list['list']);
    $smarty->assign('filter',          $vote_list['filter']);
    $smarty->assign('record_count',    $vote_list['record_count']);
    $smarty->assign('page_count',      $vote_list['page_count']);

    make_json_result($smarty->fetch('vote_list.htm'), '',
        array('filter' => $vote_list['filter'], 'page_count' => $vote_list['page_count']));
}

/*------------------------------------------------------ */
//-- ����µ�ͶƱҳ��
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'add')
{
    /* Ȩ�޼�� */
    admin_priv('vote_priv');

    /* ���ڳ�ʼ�� */
    $vote = array('start_time' => local_date('Y-m-d'), 'end_time' => local_date('Y-m-d', local_strtotime('+2 weeks')));

    /* ģ�帳ֵ */
    $smarty->assign('ur_here',      $_LANG['add_vote']);
    $smarty->assign('action_link',  array('href'=>'vote.php?act=list', 'text' => $_LANG['list_vote']));

    $smarty->assign('action',       'add');
    $smarty->assign('form_act',     'insert');
    $smarty->assign('vote_arr',     $vote);
    $smarty->assign('cfg_lang',     $_CFG['lang']);

    /* ��ʾҳ�� */
    assign_query_info();
    $smarty->display('vote_info.htm');
}
elseif ($_REQUEST['act'] == 'insert')
{
    admin_priv('vote_priv');

    /* ��ù��Ŀ�ʼʱ����������� */
    $start_time = local_strtotime($_POST['start_time']);
    $end_time   = local_strtotime($_POST['end_time']);

    /* �鿴��������Ƿ����ظ� */
    $sql = "SELECT COUNT(*) FROM " .$ecs->table('vote'). " WHERE vote_name='$_POST[vote_name]'";
    if ($db->getOne($sql) == 0)
    {
        /* �������� */
        $sql = "INSERT INTO ".$ecs->table('vote')." (vote_name, start_time, end_time, can_multi, vote_count)
        VALUES ('$_POST[vote_name]', '$start_time', '$end_time', '$_POST[can_multi]', '0')";
        $db->query($sql);

        $new_id = $db->Insert_ID();

        /* ��¼����Ա���� */
        admin_log($_POST['vote_name'], 'add', 'vote');

        /* ������� */
        clear_cache_files();

        /* ��ʾ��Ϣ */
        $link[0]['text'] = $_LANG['continue_add_option'];
        $link[0]['href'] = 'vote.php?act=option&id='.$new_id;

        $link[1]['text'] = $_LANG['continue_add_vote'];
        $link[1]['href'] = 'vote.php?act=add';

        $link[2]['text'] = $_LANG['back_list'];
        $link[2]['href'] = 'vote.php?act=list';

        sys_msg($_LANG['add'] . "&nbsp;" .$_POST['vote_name'] . "&nbsp;" . $_LANG['attradd_succed'],0, $link);

    }
    else
    {
        $link[] = array('text' => $_LANG['go_back'], 'href'=>'javascript:history.back(-1)');
        sys_msg($_LANG['vote_name_exist'], 0, $link);
    }
}
/*------------------------------------------------------ */
//-- ���ߵ���༭ҳ��
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'edit')
{
    admin_priv('vote_priv');

    /* ��ȡ���� */
    $vote_arr = $db->GetRow("SELECT * FROM ".$ecs->table('vote')." WHERE vote_id='$_REQUEST[id]'");
    $vote_arr['start_time'] = local_date('Y-m-d', $vote_arr['start_time']);
    $vote_arr['end_time']   = local_date('Y-m-d', $vote_arr['end_time']);

    /* ģ�帳ֵ */
    $smarty->assign('ur_here',      $_LANG['edit_vote']);
    $smarty->assign('action_link',  array('href'=>'vote.php?act=list', 'text' => $_LANG['list_vote']));
    $smarty->assign('form_act',     'update');
    $smarty->assign('vote_arr',     $vote_arr);

    assign_query_info();
    $smarty->display('vote_info.htm');
}
elseif ($_REQUEST['act'] == 'update')
{
    /* ��ù��Ŀ�ʼʱ����������� */
    $start_time = local_strtotime($_POST['start_time']);
    $end_time   = local_strtotime($_POST['end_time']);

    /* ������Ϣ */
    $sql = "UPDATE " .$ecs->table('vote'). " SET ".
            "vote_name     = '$_POST[vote_name]', ".
            "start_time    = '$start_time', ".
            "end_time      = '$end_time', ".
            "can_multi     = '$_POST[can_multi]' ".
            "WHERE vote_id = '$_REQUEST[id]'";
    $db->query($sql);

    /* ������� */
    clear_cache_files();

    /* ��¼����Ա���� */
    admin_log($_POST['vote_name'], 'edit', 'vote');

    /* ��ʾ��Ϣ */
    $link[] = array('text' => $_LANG['back_list'], 'href'=>'vote.php?act=list');
    sys_msg($_LANG['edit'] .' '.$_POST['vote_name'].' '. $_LANG['attradd_succed'], 0, $link);
}
/*------------------------------------------------------ */
//-- ����ѡ���б�ҳ��
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'option')
{
    $id = !empty($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;

    /* ģ�帳ֵ */
    $smarty->assign('ur_here',      $_LANG['list_vote_option']);
    $smarty->assign('action_link',  array('href'=>'vote.php?act=list', 'text' => $_LANG['list_vote']));
    $smarty->assign('full_page',    1);

    $smarty->assign('id',           $id);
    $smarty->assign('option_arr',   get_optionlist($id));

    /* ��ʾҳ�� */
    assign_query_info();
    $smarty->display('vote_option.htm');
}

/*------------------------------------------------------ */
//-- ����ѡ���ѯ
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'query_option')
{
    $id = intval($_GET['vid']);

    $smarty->assign('id',           $id);
    $smarty->assign('option_arr',   get_optionlist($id));

    make_json_result($smarty->fetch('vote_option.htm'));
}

/*------------------------------------------------------ */
//-- ����µ���ѡ��
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'new_option')
{
    check_authz_json('vote_priv');

    $option_name = json_str_iconv(trim($_POST['option_name']));
    $vote_id = intval($_POST['id']);

    if (!empty($option_name))
    {
        /* �鿴��������Ƿ����ظ� */
        $sql = 'SELECT COUNT(*) FROM ' .$ecs->table('vote_option').
               " WHERE option_name = '$option_name' AND vote_id = '$vote_id'";
        if ($db->getOne($sql) != 0)
        {
            make_json_error($_LANG['vote_option_exist']);
        }
        else
        {
            $sql = 'INSERT INTO ' .$ecs->table('vote_option'). ' (vote_id, option_name, option_count) '.
                   "VALUES ('$vote_id', '$option_name', 0)";
            $db->query($sql);

            clear_cache_files();
            admin_log($option_name, 'add', 'vote');

            $url = 'vote.php?act=query_option&vid='.$vote_id.'&' . str_replace('act=new_option', '', $_SERVER['QUERY_STRING']);

            ecs_header("Location: $url\n");
            exit;
        }
    }
    else
    {
        make_json_error($_LANG['js_languages']['option_name_empty']);
    }
}

/*------------------------------------------------------ */
//-- �༭��������
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'edit_vote_name')
{
    check_authz_json('vote_priv');

    $id        = intval($_POST['id']);
    $vote_name = json_str_iconv(trim($_POST['val']));

    /* ��������Ƿ��ظ� */
    if ($exc->num("vote_name", $vote_name, $id) != 0)
    {
        make_json_error(sprintf($_LANG['vote_name_exist'], $vote_name));
    }
    else
    {
        if ($exc->edit("vote_name = '$vote_name'", $id))
        {
            admin_log($vote_name, 'edit', 'vote');
            make_json_result(stripslashes($vote_name));
        }
    }
}

/*------------------------------------------------------ */
//-- �༭����ѡ��
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'edit_option_name')
{
    check_authz_json('vote_priv');

    $id        = intval($_POST['id']);
    $option_name = json_str_iconv(trim($_POST['val']));

    /* ��������Ƿ��ظ� */
    $vote_id = $db->getOne('SELECT vote_id FROM ' .$ecs->table('vote_option'). " WHERE option_id='$id'");

    $sql = 'SELECT COUNT(*) FROM ' .$ecs->table('vote_option').
           " WHERE option_name = '$option_name' AND vote_id = '$vote_id' AND option_id <> $id";
    if ($db->getOne($sql) != 0)
    {
        make_json_error(sprintf($_LANG['vote_option_exist'], $option_name));
    }
    else
    {
        if ($exc_opn->edit("option_name = '$option_name'", $id))
        {
            admin_log($option_name, 'edit', 'vote');
            make_json_result(stripslashes($option_name));
        }
    }
}


/*------------------------------------------------------ */
//-- �༭����ѡ������ֵ
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'edit_option_order')
{
    check_authz_json('vote_priv');

    $id        = intval($_POST['id']);
    $option_order = json_str_iconv(trim($_POST['val']));

    if ($exc_opn->edit("option_order = '$option_order'", $id))
    {
        admin_log($_LANG['edit_option_order'], 'edit', 'vote');
        make_json_result(stripslashes($option_order));
    }

}


/*------------------------------------------------------ */
//-- ɾ�����ߵ�������
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'remove')
{
    check_authz_json('vote_priv');

    $id = intval($_GET['id']);

    if ($exc->drop($id))
    {
        /* ͬʱɾ������ѡ�� */
        $db->query("DELETE FROM " .$ecs->table('vote_option'). " WHERE vote_id = '$id'");
        clear_cache_files();
        admin_log('', 'remove', 'ads_position');
    }

    $url = 'vote.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);

    ecs_header("Location: $url\n");
    exit;
}

/*------------------------------------------------------ */
//-- ɾ�����ߵ���ѡ��
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'remove_option')
{
    check_authz_json('vote_priv');

    $id = intval($_GET['id']);
    $vote_id = $db->getOne('SELECT vote_id FROM ' .$ecs->table('vote_option'). " WHERE option_id='$id'");

    if ($exc_opn->drop($id))
    {
        clear_cache_files();
        admin_log('', 'remove', 'vote');
    }

    $url = 'vote.php?act=query_option&vid='.$vote_id.'&' . str_replace('act=remove_option', '', $_SERVER['QUERY_STRING']);

    ecs_header("Location: $url\n");
    exit;
}

/* ��ȡ���ߵ��������б� */
function get_votelist()
{
    $filter   = array();

    /* ��¼�����Լ�ҳ�� */
    $sql = 'SELECT COUNT(*) FROM ' . $GLOBALS['ecs']->table('vote');
    $filter['record_count'] = $GLOBALS['db']->getOne($sql);

    $filter = page_and_size($filter);

    /* ��ѯ���� */
    $sql  = 'SELECT * FROM ' .$GLOBALS['ecs']->table('vote'). ' ORDER BY vote_id DESC';
    $res  = $GLOBALS['db']->selectLimit($sql, $filter['page_size'], $filter['start']);

    $list = array();
    while ($rows = $GLOBALS['db']->fetchRow($res))
    {
        $rows['begin_date'] = local_date('Y-m-d', $rows['start_time']);
        $rows['end_date']   = local_date('Y-m-d', $rows['end_time']);
        $list[] = $rows;
    }

    return array('list' => $list, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);
}

/* ��ȡ����ѡ���б� */
function get_optionlist($id)
{
    $list = array();
    $sql  = 'SELECT option_id, vote_id, option_name, option_count, option_order'.
            ' FROM ' .$GLOBALS['ecs']->table('vote_option').
            " WHERE vote_id = '$id' ORDER BY option_order ASC, option_id DESC";
    $res  = $GLOBALS['db']->query($sql);
    while ($rows = $GLOBALS['db']->fetchRow($res))
    {
        $list[] = $rows;
    }

    return $list;
}

?>