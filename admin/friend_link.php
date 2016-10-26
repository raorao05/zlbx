<?php

/**
 * ECSHOP �������ӹ���
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: friend_link.php 17217 2011-01-19 06:29:08Z liubo $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
include_once(ROOT_PATH . 'includes/cls_image.php');
$image = new cls_image($_CFG['bgcolor']);

$exc = new exchange($ecs->table('friend_link'), $db, 'link_id', 'link_name');

/* act������ĳ�ʼ�� */
if (empty($_REQUEST['act']))
{
    $_REQUEST['act'] = 'list';
}
else
{
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

/*------------------------------------------------------ */
//-- ���������б�ҳ��
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'list')
{
    /* ģ�帳ֵ */
    $smarty->assign('ur_here',     $_LANG['list_link']);
    $smarty->assign('action_link', array('text' => $_LANG['add_link'], 'href' => 'friend_link.php?act=add'));
     $smarty->assign('full_page',   1);

    /* ��ȡ������������ */
    $links_list = get_links_list();

    $smarty->assign('links_list',      $links_list['list']);
    $smarty->assign('filter',          $links_list['filter']);
    $smarty->assign('record_count',    $links_list['record_count']);
    $smarty->assign('page_count',      $links_list['page_count']);

    $sort_flag  = sort_flag($links_list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    assign_query_info();
    $smarty->display('link_list.htm');
}

/*------------------------------------------------------ */
//-- ���򡢷�ҳ����ѯ
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'query')
{
    /* ��ȡ������������ */
    $links_list = get_links_list();

    $smarty->assign('links_list',      $links_list['list']);
    $smarty->assign('filter',          $links_list['filter']);
    $smarty->assign('record_count',    $links_list['record_count']);
    $smarty->assign('page_count',      $links_list['page_count']);

    $sort_flag  = sort_flag($links_list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    make_json_result($smarty->fetch('link_list.htm'), '',
        array('filter' => $links_list['filter'], 'page_count' => $links_list['page_count']));
}

/*------------------------------------------------------ */
//-- ���������ҳ��
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'add')
{
    admin_priv('friendlink');

    $smarty->assign('ur_here',     $_LANG['add_link']);
    $smarty->assign('action_link', array('href'=>'friend_link.php?act=list', 'text' => $_LANG['list_link']));
    $smarty->assign('action',      'add');
    $smarty->assign('form_act',    'insert');

    assign_query_info();
    $smarty->display('link_info.htm');
}

/*------------------------------------------------------ */
//-- ������ӵ�����
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'insert')
{
    /* ������ʼ�� */
    $link_logo = '';
    $show_order = (!empty($_POST['show_order'])) ? intval($_POST['show_order']) : 0;
    $link_name  = (!empty($_POST['link_name']))  ? sub_str(trim($_POST['link_name']), 250, false) : '';

    /* �鿴���������Ƿ����ظ� */
    if ($exc->num("link_name", $link_name) == 0)
    {
        /* �����ϴ���LOGOͼƬ */
        if ((isset($_FILES['link_img']['error']) && $_FILES['link_img']['error'] == 0) || (!isset($_FILES['link_img']['error']) && isset($_FILES['link_img']['tmp_name']) && $_FILES['link_img']['tmp_name'] != 'none'))
        {
            $img_up_info = @basename($image->upload_image($_FILES['link_img'], 'afficheimg'));
            $link_logo   = DATA_DIR . '/afficheimg/' .$img_up_info;
        }

        /* ʹ��Զ�̵�LOGOͼƬ */
        if (!empty($_POST['url_logo']))
        {
            if (strpos($_POST['url_logo'], 'http://') === false && strpos($_POST['url_logo'], 'https://') === false)
            {
                $link_logo = 'http://' .trim($_POST['url_logo']);
            }
            else
            {
                $link_logo = trim($_POST['url_logo']);
            }
        }

        /* �������LOGOΪ��, LOGOΪ���ӵ����� */
        if (((isset($_FILES['upfile_flash']['error']) && $_FILES['upfile_flash']['error'] > 0) || (!isset($_FILES['upfile_flash']['error']) && isset($_FILES['upfile_flash']['tmp_name']) && $_FILES['upfile_flash']['tmp_name'] == 'none')) && empty($_POST['url_logo']))
        {
            $link_logo = '';
        }

        /* ����������ӵ����ӵ�ַû��http://������ */
        if (strpos($_POST['link_url'], 'http://') === false && strpos($_POST['link_url'], 'https://') === false)
        {
            $link_url = 'http://' . trim($_POST['link_url']);
        }
        else
        {
            $link_url = trim($_POST['link_url']);
        }

        /* �������� */
        $sql    = "INSERT INTO ".$ecs->table('friend_link')." (link_name, link_url, link_logo, show_order) ".
                  "VALUES ('$link_name', '$link_url', '$link_logo', '$show_order')";
        $db->query($sql);

        /* ��¼����Ա���� */
        admin_log($_POST['link_name'], 'add', 'friendlink');

        /* ������� */
        clear_cache_files();

        /* ��ʾ��Ϣ */
        $link[0]['text'] = $_LANG['continue_add'];
        $link[0]['href'] = 'friend_link.php?act=add';

        $link[1]['text'] = $_LANG['back_list'];
        $link[1]['href'] = 'friend_link.php?act=list';

        sys_msg($_LANG['add'] . "&nbsp;" .stripcslashes($_POST['link_name']) . " " . $_LANG['attradd_succed'],0, $link);

    }
    else
    {
        $link[] = array('text' => $_LANG['go_back'], 'href'=>'javascript:history.back(-1)');
        sys_msg($_LANG['link_name_exist'], 0, $link);
    }
}

/*------------------------------------------------------ */
//-- �������ӱ༭ҳ��
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'edit')
{
    admin_priv('friendlink');

    /* ȡ�������������� */
    $sql = "SELECT link_id, link_name, link_url, link_logo, show_order ".
           "FROM " .$ecs->table('friend_link'). " WHERE link_id = '".intval($_REQUEST['id'])."'";
    $link_arr = $db->getRow($sql);

    /* ���ΪͼƬ���ӻ����������� */
    if (!empty($link_arr['link_logo']))
    {
        $type      = 'img';
        $link_logo = $link_arr['link_logo'];
    }
    else
    {
        $type      = 'chara';
        $link_logo = '';
    }

    $link_arr['link_name'] = sub_str($link_arr['link_name'], 250, false); // ��ȡ�ַ���Ϊ250���ַ�������ַǷ��ַ������

    /* ģ�帳ֵ */
    $smarty->assign('ur_here',     $_LANG['edit_link']);
    $smarty->assign('action_link', array('href'=>'friend_link.php?act=list&' . list_link_postfix(), 'text' => $_LANG['list_link']));
    $smarty->assign('form_act',    'update');
    $smarty->assign('action',      'edit');

    $smarty->assign('type',        $type);
    $smarty->assign('link_logo',   $link_logo);
    $smarty->assign('link_arr',    $link_arr);

    assign_query_info();
    $smarty->display('link_info.htm');
}

/*------------------------------------------------------ */
//-- �༭���ӵĴ���ҳ��
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'update')
{
    /* ������ʼ�� */
    $id         = (!empty($_REQUEST['id']))      ? intval($_REQUEST['id'])      : 0;
    $show_order = (!empty($_POST['show_order'])) ? intval($_POST['show_order']) : 0;
    $link_name  = (!empty($_POST['link_name']))  ? trim($_POST['link_name'])    : '';

    /* �����ͼƬLOGOҪ�ϴ� */
    if ((isset($_FILES['link_img']['error']) && $_FILES['link_img']['error'] == 0) || (!isset($_FILES['link_img']['error']) && isset($_FILES['link_img']['tmp_name']) && $_FILES['link_img']['tmp_name'] != 'none'))
    {
        $img_up_info = @basename($image->upload_image($_FILES['link_img'], 'afficheimg'));
        $link_logo   = ", link_logo = ".'\''. DATA_DIR . '/afficheimg/'.$img_up_info.'\'';
    }
    elseif (!empty($_POST['url_logo']))
    {
        $link_logo = ", link_logo = '$_POST[url_logo]'";
    }
    else
    {
        /* �������������, LOGOΪ���ӵ����� */
        $link_logo = ", link_logo = ''";
    }

    //���Ҫ�޸�����ͼƬ, ɾ��ԭ����ͼƬ
    if (!empty($img_up_info))
    {
        //��ȡ����LOGO,��ɾ��
        $old_logo = $db->getOne("SELECT link_logo FROM " .$ecs->table('friend_link'). " WHERE link_id = '$id'");
        if ((strpos($old_logo, 'http://') === false) && (strpos($old_logo, 'https://') === false))
        {
            $img_name = basename($old_logo);
            @unlink(ROOT_PATH . DATA_DIR . '/afficheimg/' . $img_name);
        }
    }

    /* ����������ӵ����ӵ�ַû��http://������ */
    if (strpos($_POST['link_url'], 'http://') === false && strpos($_POST['link_url'], 'https://') === false)
    {
        $link_url = 'http://' . trim($_POST['link_url']);
    }
    else
    {
        $link_url = trim($_POST['link_url']);
    }

    /* ������Ϣ */
    $sql = "UPDATE " .$ecs->table('friend_link'). " SET ".
            "link_name = '$link_name', ".
            "link_url = '$link_url' ".
            $link_logo.','.
            "show_order = '$show_order' ".
            "WHERE link_id = '$id'";

    $db->query($sql);
    /* ��¼����Ա���� */
    admin_log($_POST['link_name'], 'edit', 'friendlink');

    /* ������� */
    clear_cache_files();

    /* ��ʾ��Ϣ */
    $link[0]['text'] = $_LANG['back_list'];
    $link[0]['href'] = 'friend_link.php?act=list&' . list_link_postfix();

    sys_msg($_LANG['edit'] . "&nbsp;" .stripcslashes($_POST['link_name']) . "&nbsp;" . $_LANG['attradd_succed'],0, $link);
}

/*------------------------------------------------------ */
//-- �༭��������
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'edit_link_name')
{
    check_authz_json('friendlink');

    $id        = intval($_POST['id']);
    $link_name = json_str_iconv(trim($_POST['val']));

    /* ������������Ƿ��ظ� */
    if ($exc->num("link_name", $link_name, $id) != 0)
    {
        make_json_error(sprintf($_LANG['link_name_exist'], $link_name));
    }
    else
    {
        if ($exc->edit("link_name = '$link_name'", $id))
        {
            admin_log($link_name, 'edit', 'friendlink');
            clear_cache_files();
            make_json_result(stripslashes($link_name));
        }
        else
        {
            make_json_error($db->error());
        }
    }
}

/*------------------------------------------------------ */
//-- ɾ����������
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'remove')
{
    check_authz_json('friendlink');

    $id = intval($_GET['id']);

    /* ��ȡ����LOGO,��ɾ�� */
    $link_logo = $exc->get_name($id, "link_logo");

    if ((strpos($link_logo, 'http://') === false) && (strpos($link_logo, 'https://') === false))
    {
        $img_name = basename($link_logo);
        @unlink(ROOT_PATH. DATA_DIR . '/afficheimg/'.$img_name);
    }

    $exc->drop($id);
    clear_cache_files();
    admin_log('', 'remove', 'friendlink');

    $url = 'friend_link.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);

    ecs_header("Location: $url\n");
    exit;
}

/*------------------------------------------------------ */
//-- �༭����
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'edit_show_order')
{
    check_authz_json('friendlink');

    $id    = intval($_POST['id']);
    $order = json_str_iconv(trim($_POST['val']));

    /* ��������ֵ�Ƿ�Ϸ� */
    if (!preg_match("/^[0-9]+$/", $order))
    {
        make_json_error(sprintf($_LANG['enter_int'], $order));
    }
    else
    {
        if ($exc->edit("show_order = '$order'", $id))
        {
            clear_cache_files();
            make_json_result(stripslashes($order));
        }
    }
}

/* ��ȡ�������������б� */
function get_links_list()
{
    $result = get_filter();
    if ($result === false)
    {
        $filter = array();
        $filter['sort_by']    = empty($_REQUEST['sort_by']) ? 'link_id' : trim($_REQUEST['sort_by']);
        $filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);

        /* ����ܼ�¼���� */
        $sql = 'SELECT COUNT(*) FROM ' .$GLOBALS['ecs']->table('friend_link');
        $filter['record_count'] = $GLOBALS['db']->getOne($sql);

        $filter = page_and_size($filter);

        /* ��ȡ���� */
        $sql  = 'SELECT link_id, link_name, link_url, link_logo, show_order'.
               ' FROM ' .$GLOBALS['ecs']->table('friend_link').
                " ORDER by $filter[sort_by] $filter[sort_order]";

        set_filter($filter, $sql);
    }
    else
    {
        $sql    = $result['sql'];
        $filter = $result['filter'];
    }
    $res = $GLOBALS['db']->selectLimit($sql, $filter['page_size'], $filter['start']);

    $list = array();
    while ($rows = $GLOBALS['db']->fetchRow($res))
    {
        if (empty($rows['link_logo']))
        {
            $rows['link_logo'] = '';
        }
        else
        {
            if ((strpos($rows['link_logo'], 'http://') === false) && (strpos($rows['link_logo'], 'https://') === false))
            {
                $rows['link_logo'] = "<img src='" .'../'.$rows['link_logo']. "' width=88 height=31 />";
            }
            else
            {
                $rows['link_logo'] = "<img src='".$rows['link_logo']."' width=88 height=31 />";
            }
        }

        $list[] = $rows;
    }

    return array('list' => $list, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);
}

?>