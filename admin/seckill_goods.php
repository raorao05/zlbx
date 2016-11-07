<?php

/**
 * ECSHOP �����������������
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: auction.php 17217 2011-01-19 06:29:08Z liubo $
 */

define('IN_ECS', true);
require(dirname(__FILE__) . '/includes/init.php');
require(ROOT_PATH . 'includes/lib_goods.php');

$exc = new exchange($ecs->table('goods_activity'), $db, 'act_id', 'act_name');

/*------------------------------------------------------ */
//-- ��б�ҳ
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'list')
{
    /* ���Ȩ�� */
    admin_priv('seckill');

    /* ģ�帳ֵ */
    $smarty->assign('full_page',   1);
    $smarty->assign('ur_here',     $_LANG['seckill_list']);
    $smarty->assign('action_link', array('href' => 'seckill.php?act=add', 'text' => $_LANG['add_seckill']));

    $list = seckill_list();
    //print_r($list);exit;


    $smarty->assign('seckill_list', $list['item']);
    $smarty->assign('filter',       $list['filter']);
    $smarty->assign('record_count', $list['record_count']);
    $smarty->assign('page_count',   $list['page_count']);
    $smarty->assign('form_action','add');
    $sort_flag  = sort_flag($list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);


    /* ��ʾ��Ʒ�б�ҳ�� */
    assign_query_info();
    $smarty->display('seckill_list.htm');
}

/*------------------------------------------------------ */
//-- ��ҳ�����򡢲�ѯ
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'query')
{
    $list = seckill_list();

    $smarty->assign('seckill_list', $list['item']);
    $smarty->assign('filter',       $list['filter']);
    $smarty->assign('record_count', $list['record_count']);
    $smarty->assign('page_count',   $list['page_count']);

    $sort_flag  = sort_flag($list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    make_json_result($smarty->fetch('seckill_list.htm'), '',
        array('filter' => $list['filter'], 'page_count' => $list['page_count']));
}

/*------------------------------------------------------ */
//-- ɾ��
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'remove')
{
    check_authz_json('seckill');

    $id = intval($_GET['id']);
    $name = $auction['act_name'];
    $exc->drop($id);

    /* ����־ */
    admin_log($name, 'remove', 'seckill');

    /* ������� */
    clear_cache_files();

    $url = 'seckill_goods.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);

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
        admin_priv('auction');

        $ids = $_POST['checkboxes'];

        /* ɾ����¼ */
        $sql = "DELETE FROM " . $ecs->table('goods_activity') .
            " WHERE act_id " . db_create_in($ids) .
            " AND act_type = '" . GAT_SECKILL . "'";
        $db->query($sql);

        /* ����־ */
        admin_log('', 'batch_remove', 'seckill');

        /* ������� */
        clear_cache_files();
        $links[] = array('text' => $_LANG['back_seckill_list'], 'href' => 'seckill_goods.php?act=list&' . list_link_postfix());
        sys_msg($_LANG['batch_drop_ok'], 0, $links);
    }
}




/*------------------------------------------------------ */
//-- ��ӡ��༭
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'add' || $_REQUEST['act'] == 'edit')
{
    /* ���Ȩ�� */
    admin_priv('seckill');
    //die('abc');

    /* �Ƿ���� */
    $is_add = $_REQUEST['act'] == 'add';
    $smarty->assign('form_action', $is_add ? 'insert' : 'update');

    /* ��ʼ����ȡ���������Ϣ */
    if ($is_add)
    {
        $auction = array(
            'act_id'        => 0,
            'act_name'      => '',
            'act_desc'      => '',
            'goods_id'      => 0,
            'product_id'    => 0,
            'goods_name'    => $_LANG['pls_search_goods'],
            'start_time'    => date('Y-m-d', time() + 86400),
            'end_time'      => date('Y-m-d', time() + 4 * 86400),
        );
    }
    /*
    else
    {
        if (empty($_GET['id']))
        {
            sys_msg('invalid param');
        }
        $id = intval($_GET['id']);
        $auction = auction_info($id, true);
        if (empty($auction))
        {
            sys_msg($_LANG['auction_not_exist']);
        }
        $auction['status'] = $_LANG['auction_status'][$auction['status_no']];
        $smarty->assign('bid_user_count', sprintf($_LANG['bid_user_count'], $auction['bid_user_count']));
    }
    */
    $smarty->assign('seckill', $seckill);

    /* ��ֵʱ��ؼ������� */
    $smarty->assign('cfg_lang', $_CFG['lang']);

    /* ��Ʒ��Ʒ�� */
    $smarty->assign('good_products_select', get_good_products_select($seckill['goods_id']));

    /* ��ʾģ�� */
    if ($is_add)
    {
        $smarty->assign('ur_here', $_LANG['add_seckill']);
    }
    $smarty->assign('action_link', list_link($is_add));
    assign_query_info();
    $smarty->display('seckill_goods_info.htm');
}

/*------------------------------------------------------ */
//-- ��ӡ��༭���ύ
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'insert' || $_REQUEST['act'] == 'update')
{
    /* ���Ȩ�� */
    admin_priv('seckill');

    /* �Ƿ���� */
    $is_add = $_REQUEST['act'] == 'insert';

    /* ����Ƿ�ѡ������Ʒ */
    $goods_id = intval($_POST['goods_id']);
    if ($goods_id <= 0)
    {
        sys_msg($_LANG['pls_select_goods']);
    }
    $sql = "SELECT goods_name FROM " . $ecs->table('goods') . " WHERE goods_id = '$goods_id'";
    $row = $db->getRow($sql);
    if (empty($row))
    {
        sys_msg($_LANG['goods_not_exist']);
    }
    $goods_name = $row['goods_name'];

    /* �ύֵ */
    $seckill = array(
        'act_id'        => intval($_POST['id']),
        'act_name'      => empty($_POST['act_name']) ? $goods_name : sub_str($_POST['act_name'], 255, false),
        'act_desc'      => $_POST['act_desc'],
        'act_type'      => GAT_SECKILL,
        'goods_id'      => $goods_id,
        'product_id'    => empty($_POST['product_id']) ? 0 : $_POST['product_id'],
        'goods_name'    => $goods_name,
        'start_time'    => local_strtotime($_POST['start_time']),
        'end_time'      => local_strtotime($_POST['end_time']),
        'ext_info'      => serialize(array(
            'start_price'   => round(floatval($_POST['start_price']), 2),
            'seckill_num'     => round(floatval($_POST['seckill_num']), 2)
        ))
    );

    /* �������� */
    if ($is_add)
    {
        $seckill['is_finished'] = 0;
        $db->autoExecute($ecs->table('goods_activity'), $seckill, 'INSERT');
        $seckill['act_id'] = $db->insert_id();
    }
    else
    {
        $db->autoExecute($ecs->table('goods_activity'), $seckill, 'UPDATE', "act_id = '$seckill[act_id]'");
    }

    /* ����־ */
    if ($is_add)
    {
        admin_log($auction['act_name'], 'add', 'seckill');
    }
    else
    {
        admin_log($auction['act_name'], 'edit', 'seckill');
    }

    /* ������� */
    clear_cache_files();

    /* ��ʾ��Ϣ */
    if ($is_add)
    {
        $links = array(
            array('href' => 'seckill_goods.php?act=add', 'text' => $_LANG['continue_add_seckill']),
            array('href' => 'seckill_goods.php?act=list', 'text' => $_LANG['back_seckill_list'])
        );
        sys_msg($_LANG['add_seckill_ok'], 0, $links);
    }
    else
    {
        $links = array(
            array('href' => 'seckill_goods.php?act=list&' . list_link_postfix(), 'text' => $_LANG['back_seckill_list'])
        );
        sys_msg($_LANG['edit_seckill_ok'], 0, $links);
    }
}

/*------------------------------------------------------ */
//-- �������ʽ�
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'settle_money')
{
    /* ���Ȩ�� */
    admin_priv('auction');

    /* ������ */
    if (empty($_POST['id']))
    {
        sys_msg('invalid param');
    }
    $id = intval($_POST['id']);
    $auction = auction_info($id);
    if (empty($auction))
    {
        sys_msg($_LANG['auction_not_exist']);
    }
    if ($auction['status_no'] != FINISHED)
    {
        sys_msg($_LANG['invalid_status']);
    }
    if ($auction['deposit'] <= 0)
    {
        sys_msg($_LANG['no_deposit']);
    }

    /* ����֤�� */
    $exc->edit("is_finished = 2", $id); // �޸�״̬
    if (isset($_POST['unfreeze']))
    {
        /* �ⶳ */
        log_account_change($auction['last_bid']['bid_user'], $auction['deposit'],
            (-1) * $auction['deposit'], 0, 0, sprintf($_LANG['unfreeze_auction_deposit'], $auction['act_name']));
    }
    else
    {
        /* �۳� */
        log_account_change($auction['last_bid']['bid_user'], 0,
            (-1) * $auction['deposit'], 0, 0, sprintf($_LANG['deduct_auction_deposit'], $auction['act_name']));
    }

    /* ����־ */
    admin_log($auction['act_name'], 'edit', 'auction');

    /* ������� */
    clear_cache_files();

    /* ��ʾ��Ϣ */
    sys_msg($_LANG['settle_deposit_ok']);
}

/*------------------------------------------------------ */
//-- ������Ʒ
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'search_goods')
{
    check_authz_json('auction');

    include_once(ROOT_PATH . 'includes/cls_json.php');

    $json   = new JSON;
    $filter = $json->decode($_GET['JSON']);
    $arr['goods']    = get_goods_list($filter);

    if (!empty($arr['goods'][0]['goods_id']))
    {
        $arr['products'] = get_good_products($arr['goods'][0]['goods_id']);
    }

    make_json_result($arr);
}

/*------------------------------------------------------ */
//-- ������Ʒ
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'search_products')
{
    include_once(ROOT_PATH . 'includes/cls_json.php');
    $json = new JSON;

    $filters = $json->decode($_GET['JSON']);

    if (!empty($filters->goods_id))
    {
        $arr['products'] = get_good_products($filters->goods_id);
    }

    make_json_result($arr);
}

/*
 * ȡ����ɱ��б�
 * @return   array
 */
function seckill_list()
{
    $result = get_filter();
    if ($result === false)
    {
        /* �������� */
        $filter['keyword']    = empty($_REQUEST['keyword']) ? '' : trim($_REQUEST['keyword']);
        if (isset($_REQUEST['is_ajax']) && $_REQUEST['is_ajax'] == 1)
        {
            $filter['keyword'] = json_str_iconv($filter['keyword']);
        }
        $filter['is_going']   = empty($_REQUEST['is_going']) ? 0 : 1;
        $filter['sort_by']    = empty($_REQUEST['sort_by']) ? 'act_id' : trim($_REQUEST['sort_by']);
        $filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);

        $where = "";
        if (!empty($filter['keyword']))
        {
            $where .= " AND goods_name LIKE '%" . mysql_like_quote($filter['keyword']) . "%'";
        }
        if ($filter['is_going'])
        {
            $now = gmtime();
            $where .= " AND is_finished = 0 AND start_time <= '$now' AND end_time >= '$now' ";
        }

        $sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('goods_activity') .
            " WHERE act_type = '" . GAT_SECKILL . "' $where";
        $filter['record_count'] = $GLOBALS['db']->getOne($sql);

        /* ��ҳ��С */
        $filter = page_and_size($filter);

        /* ��ѯ */
        $sql = "SELECT * ".
            "FROM " . $GLOBALS['ecs']->table('goods_activity') .
            " WHERE act_type = '" . GAT_SECKILL . "' $where ".
            " ORDER BY $filter[sort_by] $filter[sort_order] ".
            " LIMIT ". $filter['start'] .", $filter[page_size]";

        $filter['keyword'] = stripslashes($filter['keyword']);
        set_filter($filter, $sql);
    }
    else
    {
        $sql    = $result['sql'];
        $filter = $result['filter'];
    }
    $res = $GLOBALS['db']->query($sql);

    $list = array();
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        $ext_info = unserialize($row['ext_info']);
        $arr = array_merge($row, $ext_info);

        $arr['start_time']  = local_date('Y-m-d H:i', $arr['start_time']);
        $arr['end_time']    = local_date('Y-m-d H:i', $arr['end_time']);

        $list[] = $arr;
    }
    $arr = array('item' => $list, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);

    return $arr;
}

/**
 * �б�����
 * @param   bool    $is_add     �Ƿ���ӣ����룩
 * @param   string  $text       ����
 * @return  array('href' => $href, 'text' => $text)
 */
function list_link($is_add = true, $text = '')
{
    $href = 'seckill_goods.php?act=list';
    if (!$is_add)
    {
        $href .= '&' . list_link_postfix();
    }
    if ($text == '')
    {
        $text = $GLOBALS['_LANG']['seckill_list'];
    }

    return array('href' => $href, 'text' => $text);
}

?>