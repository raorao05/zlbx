<?php

/**
 * ECSHOP ���������Ź���Ʒ����
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: group_buy.php 17217 2011-01-19 06:29:08Z liubo $
 */

define('IN_ECS', true);
require(dirname(__FILE__) . '/includes/init.php');
require_once(ROOT_PATH . 'includes/lib_goods.php');
require_once(ROOT_PATH . 'includes/lib_order.php');

/* ���Ȩ�� */
admin_priv('group_by');

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
//-- �Ź���б�
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'list')
{
    /* ģ�帳ֵ */
    $smarty->assign('full_page',    1);
    $smarty->assign('ur_here',      $_LANG['group_buy_list']);
    $smarty->assign('action_link',  array('href' => 'group_buy.php?act=add', 'text' => $_LANG['add_group_buy']));

    $list = group_buy_list();

    $smarty->assign('group_buy_list',   $list['item']);
    $smarty->assign('filter',           $list['filter']);
    $smarty->assign('record_count',     $list['record_count']);
    $smarty->assign('page_count',       $list['page_count']);

    $sort_flag  = sort_flag($list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    /* ��ʾ��Ʒ�б�ҳ�� */
    assign_query_info();
    $smarty->display('group_buy_list.htm');
}

elseif ($_REQUEST['act'] == 'query')
{
    $list = group_buy_list();

    $smarty->assign('group_buy_list', $list['item']);
    $smarty->assign('filter',         $list['filter']);
    $smarty->assign('record_count',   $list['record_count']);
    $smarty->assign('page_count',     $list['page_count']);

    $sort_flag  = sort_flag($list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    make_json_result($smarty->fetch('group_buy_list.htm'), '',
        array('filter' => $list['filter'], 'page_count' => $list['page_count']));
}

/*------------------------------------------------------ */
//-- ���/�༭�Ź��
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'add' || $_REQUEST['act'] == 'edit')
{
    /* ��ʼ��/ȡ���Ź����Ϣ */
    if ($_REQUEST['act'] == 'add')
    {
        $group_buy = array(
            'act_id'  => 0,
            'start_time'    => date('Y-m-d', time() + 86400),
            'end_time'      => date('Y-m-d', time() + 4 * 86400),
            'price_ladder'  => array(array('amount' => 0, 'price' => 0))
        );
    }
    else
    {
        $group_buy_id = intval($_REQUEST['id']);
        if ($group_buy_id <= 0)
        {
            die('invalid param');
        }
        $group_buy = group_buy_info($group_buy_id);
    }
    $smarty->assign('group_buy', $group_buy);

    /* ģ�帳ֵ */
    $smarty->assign('ur_here', $_LANG['add_group_buy']);
    $smarty->assign('action_link', list_link($_REQUEST['act'] == 'add'));
    $smarty->assign('cat_list', cat_list());
    $smarty->assign('brand_list', get_brand_list());

    /* ��ʾģ�� */
    assign_query_info();
    $smarty->display('group_buy_info.htm');
}

/*------------------------------------------------------ */
//-- ���/�༭�Ź�����ύ
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] =='insert_update')
{
    /* ȡ���Ź��id */
    $group_buy_id = intval($_POST['act_id']);
    if (isset($_POST['finish']) || isset($_POST['succeed']) || isset($_POST['fail']) || isset($_POST['mail']))
    {
        if ($group_buy_id <= 0)
        {
            sys_msg($_LANG['error_group_buy'], 1);
        }
        $group_buy = group_buy_info($group_buy_id);
        if (empty($group_buy))
        {
            sys_msg($_LANG['error_group_buy'], 1);
        }
    }

    if (isset($_POST['finish']))
    {
        /* �ж϶���״̬ */
        if ($group_buy['status'] != GBS_UNDER_WAY)
        {
            sys_msg($_LANG['error_status'], 1);
        }

        /* �����Ź�����޸Ľ���ʱ��Ϊ��ǰʱ�� */
        $sql = "UPDATE " . $ecs->table('goods_activity') .
                " SET end_time = '" . gmtime() . "' " .
                "WHERE act_id = '$group_buy_id' LIMIT 1";
        $db->query($sql);

        /* ������� */
        clear_cache_files();

        /* ��ʾ��Ϣ */
        $links = array(
            array('href' => 'group_buy.php?act=list', 'text' => $_LANG['back_list'])
        );
        sys_msg($_LANG['edit_success'], 0, $links);
    }
    elseif (isset($_POST['succeed']))
    {
        /* ���û�ɹ� */

        /* �ж϶���״̬ */
        if ($group_buy['status'] != GBS_FINISHED)
        {
            sys_msg($_LANG['error_status'], 1);
        }

        /* ����ж��������¶�����Ϣ */
        if ($group_buy['total_order'] > 0)
        {
            /* ���Ҹ��Ź������ȷ�ϻ�δȷ�϶�������ȡ���ľͲ����ˣ� */
            $sql = "SELECT order_id " .
                    "FROM " . $ecs->table('order_info') .
                    " WHERE extension_code = 'group_buy' " .
                    "AND extension_id = '$group_buy_id' " .
                    "AND (order_status = '" . OS_CONFIRMED . "' or order_status = '" . OS_UNCONFIRMED . "')";
            $order_id_list = $db->getCol($sql);

            /* ���¶�����Ʒ�� */
            $final_price = $group_buy['trans_price'];
            $sql = "UPDATE " . $ecs->table('order_goods') .
                    " SET goods_price = '$final_price' " .
                    "WHERE order_id " . db_create_in($order_id_list);
            $db->query($sql);

            /* ��ѯ������Ʒ�ܶ� */
            $sql = "SELECT order_id, SUM(goods_number * goods_price) AS goods_amount " .
                    "FROM " . $ecs->table('order_goods') .
                    " WHERE order_id " . db_create_in($order_id_list) .
                    " GROUP BY order_id";
            $res = $db->query($sql);
            while ($row = $db->fetchRow($res))
            {
                $order_id = $row['order_id'];
                $goods_amount = floatval($row['goods_amount']);

                /* ȡ�ö�����Ϣ */
                $order = order_info($order_id);

                /* �ж϶����Ƿ���Ч�����֧����� + �Ѹ����� >= ��֤�� */
                if ($order['surplus'] + $order['money_paid'] >= $group_buy['deposit'])
                {
                    /* ��Ч����Ϊ��ȷ�ϣ����¶��� */

                    // ������Ʒ�ܶ�
                    $order['goods_amount'] = $goods_amount;

                    // ������ۣ����¼��㱣�۷���
                    if ($order['insure_fee'] > 0)
                    {
                        $shipping = shipping_info($order['shipping_id']);
                        $order['insure_fee'] = shipping_insure_fee($shipping['shipping_code'], $goods_amount, $shipping['insure']);
                    }

                    // ����֧������
                    $order['order_amount'] = $order['goods_amount'] + $order['shipping_fee']
                        + $order['insure_fee'] + $order['pack_fee'] + $order['card_fee']
                        - $order['money_paid'] - $order['surplus'];
                    if ($order['order_amount'] > 0)
                    {
                        $order['pay_fee'] = pay_fee($order['pay_id'], $order['order_amount']);
                    }
                    else
                    {
                        $order['pay_fee'] = 0;
                    }

                    // ����Ӧ������
                    $order['order_amount'] += $order['pay_fee'];

                    // ���㸶��״̬
                    if ($order['order_amount'] > 0)
                    {
                        $order['pay_status'] = PS_UNPAYED;
                        $order['pay_time'] = 0;
                    }
                    else
                    {
                        $order['pay_status'] = PS_PAYED;
                        $order['pay_time'] = gmtime();
                    }

                    // �����Ҫ�˿�˵��ʻ����
                    if ($order['order_amount'] < 0)
                    {
                        // todo �������ֹ��˿
                    }

                    // ����״̬
                    $order['order_status'] = OS_CONFIRMED;
                    $order['confirm_time'] = gmtime();

                    // ���¶���
                    $order = addslashes_deep($order);
                    update_order($order_id, $order);
                }
                else
                {
                    /* ��Ч��ȡ���������˻��Ѹ��� */

                    // �޸Ķ���״̬Ϊ��ȡ��������״̬Ϊδ����
                    $order['order_status'] = OS_CANCELED;
                    $order['to_buyer'] = $_LANG['cancel_order_reason'];
                    $order['pay_status'] = PS_UNPAYED;
                    $order['pay_time'] = 0;

                    /* ���ʹ���������Ѹ�����˻��ʻ���� */
                    $money = $order['surplus'] + $order['money_paid'];
                    if ($money > 0)
                    {
                        $order['surplus'] = 0;
                        $order['money_paid'] = 0;
                        $order['order_amount'] = $money;

                        // �˿�ʻ����
                        order_refund($order, 1, $_LANG['cancel_order_reason'] . ':' . $order['order_sn']);
                    }

                    /* ���¶��� */
                    $order = addslashes_deep($order);
                    update_order($order['order_id'], $order);
                }
            }
        }

        /* �޸��Ź��״̬Ϊ�ɹ� */
        $sql = "UPDATE " . $ecs->table('goods_activity') .
                " SET is_finished = '" . GBS_SUCCEED . "' " .
                "WHERE act_id = '$group_buy_id' LIMIT 1";
        $db->query($sql);

        /* ������� */
        clear_cache_files();

        /* ��ʾ��Ϣ */
        $links = array(
            array('href' => 'group_buy.php?act=list', 'text' => $_LANG['back_list'])
        );
        sys_msg($_LANG['edit_success'], 0, $links);
    }
    elseif (isset($_POST['fail']))
    {
        /* ���ûʧ�� */

        /* �ж϶���״̬ */
        if ($group_buy['status'] != GBS_FINISHED)
        {
            sys_msg($_LANG['error_status'], 1);
        }

        /* �������Ч������ȡ������ */
        if ($group_buy['valid_order'] > 0)
        {
            /* ����δȷ�ϻ���ȷ�ϵĶ��� */
            $sql = "SELECT * " .
                    "FROM " . $ecs->table('order_info') .
                    " WHERE extension_code = 'group_buy' " .
                    "AND extension_id = '$group_buy_id' " .
                    "AND (order_status = '" . OS_CONFIRMED . "' OR order_status = '" . OS_UNCONFIRMED . "') ";
            $res = $db->query($sql);
            while ($order = $db->fetchRow($res))
            {
                // �޸Ķ���״̬Ϊ��ȡ��������״̬Ϊδ����
                $order['order_status'] = OS_CANCELED;
                $order['to_buyer'] = $_LANG['cancel_order_reason'];
                $order['pay_status'] = PS_UNPAYED;
                $order['pay_time'] = 0;

                /* ���ʹ���������Ѹ�����˻��ʻ���� */
                $money = $order['surplus'] + $order['money_paid'];
                if ($money > 0)
                {
                    $order['surplus'] = 0;
                    $order['money_paid'] = 0;
                    $order['order_amount'] = $money;

                    // �˿�ʻ����
                    order_refund($order, 1, $_LANG['cancel_order_reason'] . ':' . $order['order_sn'], $money);
                }

                /* ���¶��� */
                $order = addslashes_deep($order);
                update_order($order['order_id'], $order);
            }
        }

        /* �޸��Ź��״̬Ϊʧ�ܣ���¼ʧ��ԭ�򣨻˵���� */
        $sql = "UPDATE " . $ecs->table('goods_activity') .
                " SET is_finished = '" . GBS_FAIL . "', " .
                    "act_desc = '$_POST[act_desc]' " .
                "WHERE act_id = '$group_buy_id' LIMIT 1";
        $db->query($sql);

        /* ������� */
        clear_cache_files();

        /* ��ʾ��Ϣ */
        $links = array(
            array('href' => 'group_buy.php?act=list', 'text' => $_LANG['back_list'])
        );
        sys_msg($_LANG['edit_success'], 0, $links);
    }
    elseif (isset($_POST['mail']))
    {
        /* ����֪ͨ�ʼ� */

        /* �ж϶���״̬ */
        if ($group_buy['status'] != GBS_SUCCEED)
        {
            sys_msg($_LANG['error_status'], 1);
        }

        /* ȡ���ʼ�ģ�� */
        $tpl = get_mail_template('group_buy');

        /* ��ʼ���������ͳɹ������ʼ��� */
        $count = 0;
        $send_count = 0;

        /* ȡ����Ч���� */
        $sql = "SELECT o.consignee, o.add_time, g.goods_number, o.order_sn, " .
                    "o.order_amount, o.order_id, o.email " .
                "FROM " . $ecs->table('order_info') . " AS o, " .
                    $ecs->table('order_goods') . " AS g " .
                "WHERE o.order_id = g.order_id " .
                "AND o.extension_code = 'group_buy' " .
                "AND o.extension_id = '$group_buy_id' " .
                "AND o.order_status = '" . OS_CONFIRMED . "'";
        $res = $db->query($sql);
        while ($order = $db->fetchRow($res))
        {
            /* �ʼ�ģ�帳ֵ */
            $smarty->assign('consignee',    $order['consignee']);
            $smarty->assign('add_time',     local_date($_CFG['time_format'], $order['add_time']));
            $smarty->assign('goods_name',   $group_buy['goods_name']);
            $smarty->assign('goods_number', $order['goods_number']);
            $smarty->assign('order_sn',     $order['order_sn']);
            $smarty->assign('order_amount', price_format($order['order_amount']));
            $smarty->assign('shop_url',     $ecs->url() . 'user.php?act=order_detail&order_id='.$order['order_id']);
            $smarty->assign('shop_name',    $_CFG['shop_name']);
            $smarty->assign('send_date',    local_date($_CFG['date_format']));

            /* ȡ��ģ�����ݣ����ʼ� */
            $content = $smarty->fetch('str:' . $tpl['template_content']);
            if (send_mail($order['consignee'], $order['email'], $tpl['template_subject'], $content, $tpl['is_html']))
            {
                $send_count++;
            }
            $count++;
        }

        /* ��ʾ��Ϣ */
        sys_msg(sprintf($_LANG['mail_result'], $count, $send_count));
    }
    else
    {
        /* �����Ź���Ϣ */
        $goods_id = intval($_POST['goods_id']);
        if ($goods_id <= 0)
        {
            sys_msg($_LANG['error_goods_null']);
        }
        $info = goods_group_buy($goods_id);
        if ($info && $info['act_id'] != $group_buy_id)
        {
            sys_msg($_LANG['error_goods_exist']);
        }

        $goods_name = $db->getOne("SELECT goods_name FROM " . $ecs->table('goods') . " WHERE goods_id = '$goods_id'");

        $act_name = empty($_POST['act_name']) ? $goods_name : sub_str($_POST['act_name'], 0, 255, false);

        $deposit = floatval($_POST['deposit']);
        if ($deposit < 0)
        {
            $deposit = 0;
        }

        $restrict_amount = intval($_POST['restrict_amount']);
        if ($restrict_amount < 0)
        {
            $restrict_amount = 0;
        }

        $gift_integral = intval($_POST['gift_integral']);
        if ($gift_integral < 0)
        {
            $gift_integral = 0;
        }

        $price_ladder = array();
        $count = count($_POST['ladder_amount']);
        for ($i = $count - 1; $i >= 0; $i--)
        {
            /* �������С�ڵ���0����Ҫ */
            $amount = intval($_POST['ladder_amount'][$i]);
            if ($amount <= 0)
            {
                continue;
            }

            /* ����۸�С�ڵ���0����Ҫ */
            $price = round(floatval($_POST['ladder_price'][$i]), 2);
            if ($price <= 0)
            {
                continue;
            }

            /* ����۸���� */
            $price_ladder[$amount] = array('amount' => $amount, 'price' => $price);
        }
        if (count($price_ladder) < 1)
        {
            sys_msg($_LANG['error_price_ladder']);
        }

        /* �޹���������С�ڼ۸�����е�������� */
        $amount_list = array_keys($price_ladder);
        if ($restrict_amount > 0 && max($amount_list) > $restrict_amount)
        {
            sys_msg($_LANG['error_restrict_amount']);
        }

        ksort($price_ladder);
        $price_ladder = array_values($price_ladder);

        /* ��鿪ʼʱ��ͽ���ʱ���Ƿ���� */
        $start_time = local_strtotime($_POST['start_time']);
        $end_time = local_strtotime($_POST['end_time']);
        if ($start_time >= $end_time)
        {
            sys_msg($_LANG['invalid_time']);
        }

        $group_buy = array(
            'act_name'   => $act_name,
            'act_desc'   => $_POST['act_desc'],
            'act_type'   => GAT_GROUP_BUY,
            'goods_id'   => $goods_id,
            'goods_name' => $goods_name,
            'start_time'    => $start_time,
            'end_time'      => $end_time,
            'ext_info'   => serialize(array(
                    'price_ladder'      => $price_ladder,
                    'restrict_amount'   => $restrict_amount,
                    'gift_integral'     => $gift_integral,
                    'deposit'           => $deposit
                    ))
        );

        /* ������� */
        clear_cache_files();

        /* �������� */
        if ($group_buy_id > 0)
        {
            /* update */
            $db->autoExecute($ecs->table('goods_activity'), $group_buy, 'UPDATE', "act_id = '$group_buy_id'");

            /* log */
            admin_log(addslashes($goods_name) . '[' . $group_buy_id . ']', 'edit', 'group_buy');

            /* todo ���»�� */

            /* ��ʾ��Ϣ */
            $links = array(
                array('href' => 'group_buy.php?act=list&' . list_link_postfix(), 'text' => $_LANG['back_list'])
            );
            sys_msg($_LANG['edit_success'], 0, $links);
        }
        else
        {
            /* insert */
            $db->autoExecute($ecs->table('goods_activity'), $group_buy, 'INSERT');

            /* log */
            admin_log(addslashes($goods_name), 'add', 'group_buy');

            /* ��ʾ��Ϣ */
            $links = array(
                array('href' => 'group_buy.php?act=add', 'text' => $_LANG['continue_add']),
                array('href' => 'group_buy.php?act=list', 'text' => $_LANG['back_list'])
            );
            sys_msg($_LANG['add_success'], 0, $links);
        }
    }
}

/*------------------------------------------------------ */
//-- ����ɾ���Ź��
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'batch_drop')
{
    if (isset($_POST['checkboxes']))
    {
        $del_count = 0; //��ʼ��ɾ������
        foreach ($_POST['checkboxes'] AS $key => $id)
        {
            /* ȡ���Ź����Ϣ */
            $group_buy = group_buy_info($id);

            /* ����Ź���Ѿ��ж���������ɾ�� */
            if ($group_buy['valid_order'] <= 0)
            {
                /* ɾ���Ź�� */
                $sql = "DELETE FROM " . $GLOBALS['ecs']->table('goods_activity') .
                        " WHERE act_id = '$id' LIMIT 1";
                $GLOBALS['db']->query($sql, 'SILENT');

                admin_log(addslashes($group_buy['goods_name']) . '[' . $id . ']', 'remove', 'group_buy');
                $del_count++;
            }
        }

        /* ���ɾ�����Ź����������� */
        if ($del_count > 0)
        {
            clear_cache_files();
        }

        $links[] = array('text' => $_LANG['back_list'], 'href'=>'group_buy.php?act=list');
        sys_msg(sprintf($_LANG['batch_drop_success'], $del_count), 0, $links);
    }
    else
    {
        $links[] = array('text' => $_LANG['back_list'], 'href'=>'group_buy.php?act=list');
        sys_msg($_LANG['no_select_group_buy'], 0, $links);
    }
}

/*------------------------------------------------------ */
//-- ������Ʒ
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'search_goods')
{
    check_authz_json('group_by');

    include_once(ROOT_PATH . 'includes/cls_json.php');

    $json   = new JSON;
    $filter = $json->decode($_GET['JSON']);
    $arr    = get_goods_list($filter);

    make_json_result($arr);
}

/*------------------------------------------------------ */
//-- �༭��֤��
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'edit_deposit')
{
    check_authz_json('group_by');

    $id = intval($_POST['id']);
    $val = floatval($_POST['val']);

    $sql = "SELECT ext_info FROM " . $ecs->table('goods_activity') .
            " WHERE act_id = '$id' AND act_type = '" . GAT_GROUP_BUY . "'";
    $ext_info = unserialize($db->getOne($sql));
    $ext_info['deposit'] = $val;

    $sql = "UPDATE " . $ecs->table('goods_activity') .
            " SET ext_info = '" . serialize($ext_info) . "'" .
            " WHERE act_id = '$id'";
    $db->query($sql);

    clear_cache_files();

    make_json_result(number_format($val, 2));
}

/*------------------------------------------------------ */
//-- �༭��֤��
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'edit_restrict_amount')
{
    check_authz_json('group_by');

    $id = intval($_POST['id']);
    $val = intval($_POST['val']);

    $sql = "SELECT ext_info FROM " . $ecs->table('goods_activity') .
            " WHERE act_id = '$id' AND act_type = '" . GAT_GROUP_BUY . "'";
    $ext_info = unserialize($db->getOne($sql));
    $ext_info['restrict_amount'] = $val;

    $sql = "UPDATE " . $ecs->table('goods_activity') .
            " SET ext_info = '" . serialize($ext_info) . "'" .
            " WHERE act_id = '$id'";
    $db->query($sql);

    clear_cache_files();

    make_json_result($val);
}

/*------------------------------------------------------ */
//-- ɾ���Ź��
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'remove')
{
    check_authz_json('group_by');

    $id = intval($_GET['id']);

    /* ȡ���Ź����Ϣ */
    $group_buy = group_buy_info($id);

    /* ����Ź���Ѿ��ж���������ɾ�� */
    if ($group_buy['valid_order'] > 0)
    {
        make_json_error($_LANG['error_exist_order']);
    }

    /* ɾ���Ź�� */
    $sql = "DELETE FROM " . $ecs->table('goods_activity') . " WHERE act_id = '$id' LIMIT 1";
    $db->query($sql);

    admin_log(addslashes($group_buy['goods_name']) . '[' . $id . ']', 'remove', 'group_buy');

    clear_cache_files();

    $url = 'group_buy.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);

    ecs_header("Location: $url\n");
    exit;
}

/*
 * ȡ���Ź���б�
 * @return   array
 */
function group_buy_list()
{
    $result = get_filter();
    if ($result === false)
    {
        /* �������� */
        $filter['keyword']      = empty($_REQUEST['keyword']) ? '' : trim($_REQUEST['keyword']);
        if (isset($_REQUEST['is_ajax']) && $_REQUEST['is_ajax'] == 1)
        {
            $filter['keyword'] = json_str_iconv($filter['keyword']);
        }
        $filter['sort_by']      = empty($_REQUEST['sort_by']) ? 'act_id' : trim($_REQUEST['sort_by']);
        $filter['sort_order']   = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);

        $where = (!empty($filter['keyword'])) ? " AND goods_name LIKE '%" . mysql_like_quote($filter['keyword']) . "%'" : '';

        $sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('goods_activity') .
                " WHERE act_type = '" . GAT_GROUP_BUY . "' $where";
        $filter['record_count'] = $GLOBALS['db']->getOne($sql);

        /* ��ҳ��С */
        $filter = page_and_size($filter);

        /* ��ѯ */
        $sql = "SELECT * ".
                "FROM " . $GLOBALS['ecs']->table('goods_activity') .
                " WHERE act_type = '" . GAT_GROUP_BUY . "' $where ".
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
        $stat = group_buy_stat($row['act_id'], $ext_info['deposit']);
        $arr = array_merge($row, $stat, $ext_info);

        /* ����۸���� */
        $price_ladder = $arr['price_ladder'];
        if (!is_array($price_ladder) || empty($price_ladder))
        {
            $price_ladder = array(array('amount' => 0, 'price' => 0));
        }
        else
        {
            foreach ($price_ladder AS $key => $amount_price)
            {
                $price_ladder[$key]['formated_price'] = price_format($amount_price['price']);
            }
        }

        /* ���㵱ǰ�� */
        $cur_price  = $price_ladder[0]['price'];    // ��ʼ��
        $cur_amount = $stat['valid_goods'];         // ��ǰ����
        foreach ($price_ladder AS $amount_price)
        {
            if ($cur_amount >= $amount_price['amount'])
            {
                $cur_price = $amount_price['price'];
            }
            else
            {
                break;
            }
        }

        $arr['cur_price']   = $cur_price;

        $status = group_buy_status($arr);

        $arr['start_time']  = local_date($GLOBALS['_CFG']['date_format'], $arr['start_time']);
        $arr['end_time']    = local_date($GLOBALS['_CFG']['date_format'], $arr['end_time']);
        $arr['cur_status']  = $GLOBALS['_LANG']['gbs'][$status];

        $list[] = $arr;
    }
    $arr = array('item' => $list, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);

    return $arr;
}

/**
 * ȡ��ĳ��Ʒ���Ź��
 * @param   int     $goods_id   ��Ʒid
 * @return  array
 */
function goods_group_buy($goods_id)
{
    $sql = "SELECT * FROM " . $GLOBALS['ecs']->table('goods_activity') .
            " WHERE goods_id = '$goods_id' " .
            " AND act_type = '" . GAT_GROUP_BUY . "'" .
            " AND start_time <= " . gmtime() .
            " AND end_time >= " . gmtime();

    return $GLOBALS['db']->getRow($sql);
}

/**
 * �б�����
 * @param   bool    $is_add         �Ƿ���ӣ����룩
 * @return  array('href' => $href, 'text' => $text)
 */
function list_link($is_add = true)
{
    $href = 'group_buy.php?act=list';
    if (!$is_add)
    {
        $href .= '&' . list_link_postfix();
    }

    return array('href' => $href, 'text' => $GLOBALS['_LANG']['group_buy_list']);
}

?>