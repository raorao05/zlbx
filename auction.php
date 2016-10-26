<?php

/**
 * ECSHOP ����ǰ̨�ļ�
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

/*------------------------------------------------------ */
//-- act ������ĳ�ʼ��
/*------------------------------------------------------ */
if (empty($_REQUEST['act']))
{
    $_REQUEST['act'] = 'list';
}

/*------------------------------------------------------ */
//-- ������б�
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'list')
{
    /* ȡ����������� */
    $count = auction_count();
    if ($count > 0)
    {
        /* ȡ��ÿҳ��¼�� */
        $size = isset($_CFG['page_size']) && intval($_CFG['page_size']) > 0 ? intval($_CFG['page_size']) : 10;

        /* ������ҳ�� */
        $page_count = ceil($count / $size);

        /* ȡ�õ�ǰҳ */
        $page = isset($_REQUEST['page']) && intval($_REQUEST['page']) > 0 ? intval($_REQUEST['page']) : 1;
        $page = $page > $page_count ? $page_count : $page;

        /* ����id������ - ÿҳ��¼�� - ��ǰҳ */
        $cache_id = $_CFG['lang'] . '-' . $size . '-' . $page;
        $cache_id = sprintf('%X', crc32($cache_id));
    }
    else
    {
        /* ����id������ */
        $cache_id = $_CFG['lang'];
        $cache_id = sprintf('%X', crc32($cache_id));
    }

    /* ���û�л��棬���ɻ��� */
    if (!$smarty->is_cached('auction_list.dwt', $cache_id))
    {
        if ($count > 0)
        {
            /* ȡ�õ�ǰҳ������� */
            $auction_list = auction_list($size, $page);
            $smarty->assign('auction_list',  $auction_list);

            /* ���÷�ҳ���� */
            $pager = get_pager('auction.php', array('act' => 'list'), $count, $page, $size);
            $smarty->assign('pager', $pager);
        }

        /* ģ�帳ֵ */
        $smarty->assign('cfg', $_CFG);
        assign_template();
        $position = assign_ur_here();
        $smarty->assign('page_title', $position['title']);    // ҳ�����
        $smarty->assign('ur_here',    $position['ur_here']);  // ��ǰλ��
        $smarty->assign('categories', get_categories_tree()); // ������
        $smarty->assign('helps',      get_shop_help());       // �������
        $smarty->assign('top_goods',  get_top10());           // ��������
        $smarty->assign('promotion_info', get_promotion_info());
        $smarty->assign('feed_url',         ($_CFG['rewrite'] == 1) ? "feed-typeauction.xml" : 'feed.php?type=auction'); // RSS URL

        assign_dynamic('auction_list');
    }

    /* ��ʾģ�� */
    $smarty->display('auction_list.dwt', $cache_id);
}

/*------------------------------------------------------ */
//-- ������Ʒ --> ��Ʒ����
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'view')
{
    /* ȡ�ò����������id */
    $id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
    if ($id <= 0)
    {
        ecs_header("Location: ./\n");
        exit;
    }

    /* ȡ���������Ϣ */
    $auction = auction_info($id);
    if (empty($auction))
    {
        ecs_header("Location: ./\n");
        exit;
    }

    /* ����id�����ԣ������id��״̬������ǽ����У���Ҫ�����۵�ʱ�䣨����еĻ��� */
    $cache_id = $_CFG['lang'] . '-' . $id . '-' . $auction['status_no'];
    if ($auction['status_no'] == UNDER_WAY)
    {
        if (isset($auction['last_bid']))
        {
            $cache_id = $cache_id . '-' . $auction['last_bid']['bid_time'];
        }
    }
    elseif ($auction['status_no'] == FINISHED && $auction['last_bid']['bid_user'] == $_SESSION['user_id']
        && $auction['order_count'] == 0)
    {
        $auction['is_winner'] = 1;
        $cache_id = $cache_id . '-' . $auction['last_bid']['bid_time'] . '-1';
    }

    $cache_id = sprintf('%X', crc32($cache_id));

    /* ���û�л��棬���ɻ��� */
    if (!$smarty->is_cached('auction.dwt', $cache_id))
    {
        //ȡ��Ʒ��Ϣ
        if ($auction['product_id'] > 0)
        {
            $goods_specifications = get_specifications_list($auction['goods_id']);

            $good_products = get_good_products($auction['goods_id'], 'AND product_id = ' . $auction['product_id']);

            $_good_products = explode('|', $good_products[0]['goods_attr']);
            $products_info = '';
            foreach ($_good_products as $value)
            {
                $products_info .= ' ' . $goods_specifications[$value]['attr_name'] . '��' . $goods_specifications[$value]['attr_value'];
            }
            $smarty->assign('products_info',     $products_info);
            unset($goods_specifications, $good_products, $_good_products,  $products_info);
        }

        $auction['gmt_end_time'] = local_strtotime($auction['end_time']);
        $smarty->assign('auction', $auction);

        /* ȡ��������Ʒ��Ϣ */
        $goods_id = $auction['goods_id'];
        $goods = goods_info($goods_id);
        if (empty($goods))
        {
            ecs_header("Location: ./\n");
            exit;
        }
        $goods['url'] = build_uri('goods', array('gid' => $goods_id), $goods['goods_name']);
        $smarty->assign('auction_goods', $goods);

        /* ���ۼ�¼ */
        $smarty->assign('auction_log', auction_log($id));

        //ģ�帳ֵ
        $smarty->assign('cfg', $_CFG);
        assign_template();

        $position = assign_ur_here(0, $goods['goods_name']);
        $smarty->assign('page_title', $position['title']);    // ҳ�����
        $smarty->assign('ur_here',    $position['ur_here']);  // ��ǰλ��

        $smarty->assign('categories', get_categories_tree()); // ������
        $smarty->assign('helps',      get_shop_help());       // �������
        $smarty->assign('top_goods',  get_top10());           // ��������
        $smarty->assign('promotion_info', get_promotion_info());

        assign_dynamic('auction');
    }

    //������Ʒ�������
    $sql = 'UPDATE ' . $ecs->table('goods') . ' SET click_count = click_count + 1 '.
           "WHERE goods_id = '" . $auction['goods_id'] . "'";
    $db->query($sql);

    $smarty->assign('now_time',  gmtime());           // ��ǰϵͳʱ��
    $smarty->display('auction.dwt', $cache_id);
}

/*------------------------------------------------------ */
//-- ������Ʒ --> ����
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'bid')
{
    include_once(ROOT_PATH . 'includes/lib_order.php');

    /* ȡ�ò����������id */
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    if ($id <= 0)
    {
        ecs_header("Location: ./\n");
        exit;
    }

    /* ȡ���������Ϣ */
    $auction = auction_info($id);
    if (empty($auction))
    {
        ecs_header("Location: ./\n");
        exit;
    }

    /* ��Ƿ����ڽ��� */
    if ($auction['status_no'] != UNDER_WAY)
    {
        show_message($_LANG['au_not_under_way'], '', '', 'error');
    }

    /* �Ƿ��¼ */
    $user_id = $_SESSION['user_id'];
    if ($user_id <= 0)
    {
        show_message($_LANG['au_bid_after_login']);
    }
    $user = user_info($user_id);

    /* ȡ�ó��� */
    $bid_price = isset($_POST['price']) ? round(floatval($_POST['price']), 2) : 0;
    if ($bid_price <= 0)
    {
        show_message($_LANG['au_bid_price_error'], '', '', 'error');
    }

    /* �����һ�ڼ��ҳ��۴��ڵ���һ�ڼۣ���һ�ڼ��� */
    $is_ok = false; // �����Ƿ�ok
    if ($auction['end_price'] > 0)
    {
        if ($bid_price >= $auction['end_price'])
        {
            $bid_price = $auction['end_price'];
            $is_ok = true;
        }
    }

    /* �����Ƿ���Ч�����ֵ�һ�κͷǵ�һ�� */
    if (!$is_ok)
    {
        if ($auction['bid_user_count'] == 0)
        {
            /* ��һ��Ҫ���ڵ������ļ� */
            $min_price = $auction['start_price'];
        }
        else
        {
            /* �ǵ�һ�γ���Ҫ���ڵ�����߼ۼ��ϼӼ۷��ȣ������ܳ���һ�ڼ� */
            $min_price = $auction['last_bid']['bid_price'] + $auction['amplitude'];
            if ($auction['end_price'] > 0)
            {
                $min_price = min($min_price, $auction['end_price']);
            }
        }

        if ($bid_price < $min_price)
        {
            show_message(sprintf($_LANG['au_your_lowest_price'], price_format($min_price, false)), '', '', 'error');
        }
    }

    /* �����ϵ�����������Ƿ���ͬ */
    if ($auction['last_bid']['bid_user'] == $user_id && $bid_price != $auction['end_price'])
    {
        show_message($_LANG['au_bid_repeat_user'], '', '', 'error');
    }

    /* �Ƿ���Ҫ��֤�� */
    if ($auction['deposit'] > 0)
    {
        /* �����ʽ��� */
        if ($user['user_money'] < $auction['deposit'])
        {
            show_message($_LANG['au_user_money_short'], '', '', 'error');
        }

        /* ������ǵ�һ�����ۣ��ⶳ��һ���û��ı�֤�� */
        if ($auction['bid_user_count'] > 0)
        {
            log_account_change($auction['last_bid']['bid_user'], $auction['deposit'], (-1) * $auction['deposit'],
                0, 0, sprintf($_LANG['au_unfreeze_deposit'], $auction['act_name']));
        }

        /* ���ᵱǰ�û��ı�֤�� */
        log_account_change($user_id, (-1) * $auction['deposit'], $auction['deposit'],
            0, 0, sprintf($_LANG['au_freeze_deposit'], $auction['act_name']));
    }

    /* ������ۼ�¼ */
    $auction_log = array(
        'act_id'    => $id,
        'bid_user'  => $user_id,
        'bid_price' => $bid_price,
        'bid_time'  => gmtime()
    );
    $db->autoExecute($ecs->table('auction_log'), $auction_log, 'INSERT');

    /* �����Ƿ����һ�ڼ� */
    if ($bid_price == $auction['end_price'])
    {
        /* ��������� */
        $sql = "UPDATE " . $ecs->table('goods_activity') . " SET is_finished = 1 WHERE act_id = '$id' LIMIT 1";
        $db->query($sql);
    }

    /* ��ת�������ҳ */
    ecs_header("Location: auction.php?act=view&id=$id\n");
    exit;
}

/*------------------------------------------------------ */
//-- ������Ʒ --> ����
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'buy')
{
    /* ��ѯ��ȡ�ò����������id */
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    if ($id <= 0)
    {
        ecs_header("Location: ./\n");
        exit;
    }

    /* ��ѯ��ȡ���������Ϣ */
    $auction = auction_info($id);
    if (empty($auction))
    {
        ecs_header("Location: ./\n");
        exit;
    }

    /* ��ѯ����Ƿ��ѽ��� */
    if ($auction['status_no'] != FINISHED)
    {
        show_message($_LANG['au_not_finished'], '', '', 'error');
    }

    /* ��ѯ�����˳����� */
    if ($auction['bid_user_count'] <= 0)
    {
        show_message($_LANG['au_no_bid'], '', '', 'error');
    }

    /* ��ѯ���Ƿ��Ѿ��ж��� */
    if ($auction['order_count'] > 0)
    {
        show_message($_LANG['au_order_placed']);
    }

    /* ��ѯ���Ƿ��¼ */
    $user_id = $_SESSION['user_id'];
    if ($user_id <= 0)
    {
        show_message($_LANG['au_buy_after_login']);
    }

    /* ��ѯ�������۵��Ǹ��û��� */
    if ($auction['last_bid']['bid_user'] != $user_id)
    {
        show_message($_LANG['au_final_bid_not_you'], '', '', 'error');
    }

    /* ��ѯ��ȡ����Ʒ��Ϣ */
    $goods = goods_info($auction['goods_id']);

    /* ��ѯ������������ */
    $goods_attr = '';
    $goods_attr_id = '';
    if ($auction['product_id'] > 0)
    {
        $product_info = get_good_products($auction['goods_id'], 'AND product_id = ' . $auction['product_id']);

        $goods_attr_id = str_replace('|', ',', $product_info[0]['goods_attr']);

        $attr_list = array();
        $sql = "SELECT a.attr_name, g.attr_value " .
                "FROM " . $ecs->table('goods_attr') . " AS g, " .
                    $ecs->table('attribute') . " AS a " .
                "WHERE g.attr_id = a.attr_id " .
                "AND g.goods_attr_id " . db_create_in($goods_attr_id);
        $res = $db->query($sql);
        while ($row = $db->fetchRow($res))
        {
            $attr_list[] = $row['attr_name'] . ': ' . $row['attr_value'];
        }
        $goods_attr = join(chr(13) . chr(10), $attr_list);
    }
    else
    {
        $auction['product_id'] = 0;
    }

    /* ��չ��ﳵ������������Ʒ */
    include_once(ROOT_PATH . 'includes/lib_order.php');
    clear_cart(CART_AUCTION_GOODS);

    /* ���빺�ﳵ */
    $cart = array(
        'user_id'        => $user_id,
        'session_id'     => SESS_ID,
        'goods_id'       => $auction['goods_id'],
        'goods_sn'       => addslashes($goods['goods_sn']),
        'goods_name'     => addslashes($goods['goods_name']),
        'market_price'   => $goods['market_price'],
        'goods_price'    => $auction['last_bid']['bid_price'],
        'goods_number'   => 1,
        'goods_attr'     => $goods_attr,
        'goods_attr_id'  => $goods_attr_id,
        'is_real'        => $goods['is_real'],
        'extension_code' => addslashes($goods['extension_code']),
        'parent_id'      => 0,
        'rec_type'       => CART_AUCTION_GOODS,
        'is_gift'        => 0
    );
    $db->autoExecute($ecs->table('cart'), $cart, 'INSERT');

    /* ��¼�����������ͣ��Ź� */
    $_SESSION['flow_type'] = CART_AUCTION_GOODS;
    $_SESSION['extension_code'] = 'auction';
    $_SESSION['extension_id'] = $id;

    /* �����ջ���ҳ�� */
    ecs_header("Location: ./flow.php?step=consignee\n");
    exit;
}

/**
 * ȡ�����������
 * @return  int
 */
function auction_count()
{
    $now = gmtime();
    $sql = "SELECT COUNT(*) " .
            "FROM " . $GLOBALS['ecs']->table('goods_activity') .
            "WHERE act_type = '" . GAT_AUCTION . "' " .
            "AND start_time <= '$now' AND end_time >= '$now' AND is_finished < 2";

    return $GLOBALS['db']->getOne($sql);
}

/**
 * ȡ��ĳҳ�������
 * @param   int     $size   ÿҳ��¼��
 * @param   int     $page   ��ǰҳ
 * @return  array
 */
function auction_list($size, $page)
{
    $auction_list = array();
    $auction_list['finished'] = $auction_list['finished'] = array();

    $now = gmtime();
    $sql = "SELECT a.*, IFNULL(g.goods_thumb, '') AS goods_thumb " .
            "FROM " . $GLOBALS['ecs']->table('goods_activity') . " AS a " .
                "LEFT JOIN " . $GLOBALS['ecs']->table('goods') . " AS g ON a.goods_id = g.goods_id " .
            "WHERE a.act_type = '" . GAT_AUCTION . "' " .
            "AND a.start_time <= '$now' AND a.end_time >= '$now' AND a.is_finished < 2 ORDER BY a.act_id DESC";
    $res = $GLOBALS['db']->selectLimit($sql, $size, ($page - 1) * $size);
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        $ext_info = unserialize($row['ext_info']);
        $auction = array_merge($row, $ext_info);
        $auction['status_no'] = auction_status($auction);

        $auction['start_time'] = local_date($GLOBALS['_CFG']['time_format'], $auction['start_time']);
        $auction['end_time']   = local_date($GLOBALS['_CFG']['time_format'], $auction['end_time']);
        $auction['formated_start_price'] = price_format($auction['start_price']);
        $auction['formated_end_price'] = price_format($auction['end_price']);
        $auction['formated_deposit'] = price_format($auction['deposit']);
        $auction['goods_thumb'] = get_image_path($row['goods_id'], $row['goods_thumb'], true);
        $auction['url'] = build_uri('auction', array('auid'=>$auction['act_id']));

        if($auction['status_no'] < 2)
        {
            $auction_list['under_way'][] = $auction;
        }
        else
        {
            $auction_list['finished'][] = $auction;
        }
    }

    $auction_list = @array_merge($auction_list['under_way'], $auction_list['finished']);

    return $auction_list;
}

?>