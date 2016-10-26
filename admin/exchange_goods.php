<?php

/**
 * ECSHOP �������Ļ��ֶһ���Ʒ�����ļ�
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author $
 * $Id $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

/*��ʼ�����ݽ������� */
$exc   = new exchange($ecs->table("exchange_goods"), $db, 'goods_id', 'exchange_integral');
//$image = new cls_image();

/*------------------------------------------------------ */
//-- ��Ʒ�б�
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'list')
{
    /* Ȩ���ж� */
    admin_priv('exchange_goods');

    /* ȡ�ù������� */
    $filter = array();
    $smarty->assign('ur_here',      $_LANG['15_exchange_goods_list']);
    $smarty->assign('action_link',  array('text' => $_LANG['exchange_goods_add'], 'href' => 'exchange_goods.php?act=add'));
    $smarty->assign('full_page',    1);
    $smarty->assign('filter',       $filter);

    $goods_list = get_exchange_goodslist();

    $smarty->assign('goods_list',    $goods_list['arr']);
    $smarty->assign('filter',        $goods_list['filter']);
    $smarty->assign('record_count',  $goods_list['record_count']);
    $smarty->assign('page_count',    $goods_list['page_count']);

    $sort_flag  = sort_flag($goods_list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    assign_query_info();
    $smarty->display('exchange_goods_list.htm');
}

/*------------------------------------------------------ */
//-- ��ҳ������
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'query')
{
    check_authz_json('exchange_goods');

    $goods_list = get_exchange_goodslist();

    $smarty->assign('goods_list',    $goods_list['arr']);
    $smarty->assign('filter',        $goods_list['filter']);
    $smarty->assign('record_count',  $goods_list['record_count']);
    $smarty->assign('page_count',    $goods_list['page_count']);

    $sort_flag  = sort_flag($goods_list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    make_json_result($smarty->fetch('exchange_goods_list.htm'), '',
        array('filter' => $goods_list['filter'], 'page_count' => $goods_list['page_count']));
}

/*------------------------------------------------------ */
//-- �����Ʒ
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'add')
{
    /* Ȩ���ж� */
    admin_priv('exchange_goods');

    /*��ʼ��*/
    $goods = array();
    $goods['is_exchange'] = 1;
    $goods['is_hot']      = 0;
    $goods['option']      = '<option value="0">'.$_LANG['make_option'].'</option>';

    $smarty->assign('goods',       $goods);
    $smarty->assign('ur_here',     $_LANG['exchange_goods_add']);
    $smarty->assign('action_link', array('text' => $_LANG['15_exchange_goods_list'], 'href' => 'exchange_goods.php?act=list'));
    $smarty->assign('form_action', 'insert');

    assign_query_info();
    $smarty->display('exchange_goods_info.htm');
}

/*------------------------------------------------------ */
//-- �����Ʒ
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'insert')
{
    /* Ȩ���ж� */
    admin_priv('exchange_goods');

    /*����Ƿ��ظ�*/
    $is_only = $exc->is_only('goods_id', $_POST['goods_id'],0, " goods_id ='$_POST[goods_id]'");

    if (!$is_only)
    {
        sys_msg($_LANG['goods_exist'], 1);
    }

    /*��������*/
    $add_time = gmtime();
    if (empty($_POST['goods_id']))
    {
        $_POST['goods_id'] = 0;
    }
    $sql = "INSERT INTO ".$ecs->table('exchange_goods')."(goods_id, exchange_integral, is_exchange, is_hot) ".
            "VALUES ('$_POST[goods_id]', '$_POST[exchange_integral]', '$_POST[is_exchange]', '$_POST[is_hot]')";
    $db->query($sql);

    $link[0]['text'] = $_LANG['continue_add'];
    $link[0]['href'] = 'exchange_goods.php?act=add';

    $link[1]['text'] = $_LANG['back_list'];
    $link[1]['href'] = 'exchange_goods.php?act=list';

    admin_log($_POST['goods_id'],'add','exchange_goods');

    clear_cache_files(); // �����صĻ����ļ�

    sys_msg($_LANG['articleadd_succeed'],0, $link);
}

/*------------------------------------------------------ */
//-- �༭
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'edit')
{
    /* Ȩ���ж� */
    admin_priv('exchange_goods');

    /* ȡ��Ʒ���� */
    $sql = "SELECT eg.goods_id, eg.exchange_integral,eg.is_exchange, eg.is_hot, g.goods_name ".
           " FROM " . $ecs->table('exchange_goods') . " AS eg ".
           "  LEFT JOIN " . $ecs->table('goods') . " AS g ON g.goods_id = eg.goods_id ".
           " WHERE eg.goods_id='$_REQUEST[id]'";
    $goods = $db->GetRow($sql);
    $goods['option']  = '<option value="'.$goods['goods_id'].'">'.$goods['goods_name'].'</option>';

    $smarty->assign('goods',       $goods);
    $smarty->assign('ur_here',     $_LANG['exchange_goods_add']);
    $smarty->assign('action_link', array('text' => $_LANG['15_exchange_goods_list'], 'href' => 'exchange_goods.php?act=list&' . list_link_postfix()));
    $smarty->assign('form_action', 'update');

    assign_query_info();
    $smarty->display('exchange_goods_info.htm');
}

/*------------------------------------------------------ */
//-- �༭
/*------------------------------------------------------ */
if ($_REQUEST['act'] =='update')
{
    /* Ȩ���ж� */
    admin_priv('exchange_goods');

    if (empty($_POST['goods_id']))
    {
        $_POST['goods_id'] = 0;
    }

    if ($exc->edit("exchange_integral='$_POST[exchange_integral]', is_exchange='$_POST[is_exchange]', is_hot='$_POST[is_hot]' ", $_POST['goods_id']))
    {
        $link[0]['text'] = $_LANG['back_list'];
        $link[0]['href'] = 'exchange_goods.php?act=list&' . list_link_postfix();

        admin_log($_POST['goods_id'], 'edit', 'exchange_goods');

        clear_cache_files();
        sys_msg($_LANG['articleedit_succeed'], 0, $link);
    }
    else
    {
        die($db->error());
    }
}

/*------------------------------------------------------ */
//-- �༭ʹ�û���ֵ
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'edit_exchange_integral')
{
    check_authz_json('exchange_goods');

    $id                = intval($_POST['id']);
    $exchange_integral = floatval($_POST['val']);

    /* ������±����Ƿ��ظ� */
    if ($exchange_integral < 0 || $exchange_integral == 0 && $_POST['val'] != "$goods_price")
    {
        make_json_error($_LANG['exchange_integral_invalid']);
    }
    else
    {
        if ($exc->edit("exchange_integral = '$exchange_integral'", $id))
        {
            clear_cache_files();
            admin_log($id, 'edit', 'exchange_goods');
            make_json_result(stripslashes($exchange_integral));
        }
        else
        {
            make_json_error($db->error());
        }
    }
}

/*------------------------------------------------------ */
//-- �л��Ƿ�һ�
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'toggle_exchange')
{
    check_authz_json('exchange_goods');

    $id     = intval($_POST['id']);
    $val    = intval($_POST['val']);

    $exc->edit("is_exchange = '$val'", $id);
    clear_cache_files();

    make_json_result($val);
}

/*------------------------------------------------------ */
//-- �л��Ƿ�һ�
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'toggle_hot')
{
    check_authz_json('exchange_goods');

    $id     = intval($_POST['id']);
    $val    = intval($_POST['val']);

    $exc->edit("is_hot = '$val'", $id);
    clear_cache_files();

    make_json_result($val);
}

/*------------------------------------------------------ */
//-- ����ɾ����Ʒ
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'batch_remove')
{
    admin_priv('exchange_goods');

    if (!isset($_POST['checkboxes']) || !is_array($_POST['checkboxes']))
    {
        sys_msg($_LANG['no_select_goods'], 1);
    }

    $count = 0;
    foreach ($_POST['checkboxes'] AS $key => $id)
    {
        if ($exc->drop($id))
        {
            admin_log($id,'remove','exchange_goods');
            $count++;
        }
    }

    $lnk[] = array('text' => $_LANG['back_list'], 'href' => 'exchange_goods.php?act=list');
    sys_msg(sprintf($_LANG['batch_remove_succeed'], $count), 0, $lnk);
}

/*------------------------------------------------------ */
//-- ɾ����Ʒ
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'remove')
{
    check_authz_json('exchange_goods');

    $id = intval($_GET['id']);
    if ($exc->drop($id))
    {
        admin_log($id,'remove','article');
        clear_cache_files();
    }

    $url = 'exchange_goods.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);

    ecs_header("Location: $url\n");
    exit;
}

/*------------------------------------------------------ */
//-- ������Ʒ
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'search_goods')
{
    include_once(ROOT_PATH . 'includes/cls_json.php');
    $json = new JSON;

    $filters = $json->decode($_GET['JSON']);

    $arr = get_goods_list($filters);

    make_json_result($arr);
}

/* �����Ʒ�б� */
function get_exchange_goodslist()
{
    $result = get_filter();
    if ($result === false)
    {
        $filter = array();
        $filter['keyword']    = empty($_REQUEST['keyword']) ? '' : trim($_REQUEST['keyword']);
        if (isset($_REQUEST['is_ajax']) && $_REQUEST['is_ajax'] == 1)
        {
            $filter['keyword'] = json_str_iconv($filter['keyword']);
        }
        $filter['sort_by']    = empty($_REQUEST['sort_by']) ? 'eg.goods_id' : trim($_REQUEST['sort_by']);
        $filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);

        $where = '';
        if (!empty($filter['keyword']))
        {
            $where = " AND g.goods_name LIKE '%" . mysql_like_quote($filter['keyword']) . "%'";
        }

        /* �������� */
        $sql = 'SELECT COUNT(*) FROM ' .$GLOBALS['ecs']->table('exchange_goods'). ' AS eg '.
               'LEFT JOIN ' .$GLOBALS['ecs']->table('goods'). ' AS g ON g.goods_id = eg.goods_id '.
               'WHERE 1 ' .$where;
        $filter['record_count'] = $GLOBALS['db']->getOne($sql);

        $filter = page_and_size($filter);

        /* ��ȡ�������� */
        $sql = 'SELECT eg.* , g.goods_name '.
               'FROM ' .$GLOBALS['ecs']->table('exchange_goods'). ' AS eg '.
               'LEFT JOIN ' .$GLOBALS['ecs']->table('goods'). ' AS g ON g.goods_id = eg.goods_id '.
               'WHERE 1 ' .$where. ' ORDER by '.$filter['sort_by'].' '.$filter['sort_order'];

        $filter['keyword'] = stripslashes($filter['keyword']);
        set_filter($filter, $sql);
    }
    else
    {
        $sql    = $result['sql'];
        $filter = $result['filter'];
    }
    $arr = array();
    $res = $GLOBALS['db']->selectLimit($sql, $filter['page_size'], $filter['start']);

    while ($rows = $GLOBALS['db']->fetchRow($res))
    {
        $arr[] = $rows;
    }
    return array('arr' => $arr, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);
}
?>