<?php

/**
 * ECSHOP ��ɱ��Ʒǰ̨�ļ�
 * ============================================================================
 * ��Ȩ���� 2005-2010 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: sxc_shop $
 * $Id: group_buy.php 17167 2010-05-28 06:10:40Z sxc_shop $
 */

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

if ((DEBUG_MODE & 2) != 2)
{
    $smarty->caching = true;
}

/*------------------------------------------------------ */
//-- act ������ĳ�ʼ��
/*------------------------------------------------------ */
if (empty($_REQUEST['act']))
{
    $_REQUEST['act'] = 'list';
}

/*------------------------------------------------------ */
//-- ��ɱ��Ʒ --> ��ɱ���Ʒ�б�
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'list')
{
    /* ȡ����ɱ����� */
    $count = seckill_count();
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
    if (!$smarty->is_cached('seckill_list.dwt', $cache_id))
    {
        if ($count > 0)
        {
            /* ȡ�õ�ǰҳ����ɱ� */
            $gb_list = seckill_list($size, $page);
            $smarty->assign('gb_list',  $gb_list);

            /* ���÷�ҳ���� */
            $pager = get_pager('seckill.php', array('act' => 'list'), $count, $page, $size);
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
        $smarty->assign('feed_url',         ($_CFG['rewrite'] == 1) ? "feed-typegroup_buy.xml" : 'feed.php?type=group_buy'); // RSS URL

        assign_dynamic('seckill_list');
    }
    //print_r($gb_list);exit;

    /* ��ʾģ�� */
    $smarty->display('seckill_list.dwt');
}

/*------------------------------------------------------ */
//-- ��ɱ��Ʒ --> ��Ʒ����
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'view')
{
    /* ȡ�ò�������ɱ�id */
    $seckill_id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
    if ($seckill_id <= 0)
    {
        ecs_header("Location: ./\n");
        exit;
    }

    /* ȡ����ɱ���Ϣ */
    $seckill = seckill_info($seckill_id);

    if (empty($seckill))
    {
        ecs_header("Location: ./\n");
        exit;
    }
//    elseif ($group_buy['is_on_sale'] == 0 || $group_buy['is_alone_sale'] == 0)
//    {
//        header("Location: ./\n");
//        exit;
//    }

    $seckill['gmt_end_date'] = $seckill['start_date'];
    $seckill['seckill_price']=intval($seckill['seckill_price']);
    $smarty->assign('seckill', $seckill);

    /* ȡ����ɱ��Ʒ��Ϣ */
    $goods_id = $seckill['goods_id'];
    $goods = goods_info($goods_id);
    if (empty($goods))
    {
        ecs_header("Location: ./\n");
        exit;
    }
    $goods['url'] = build_uri('goods', array('gid' => $goods_id), $goods['goods_name']);
    $goods['market_price']=intval($goods['market_price']);
    $goods['surplus']=intval($goods['market_price'])-intval($seckill['seckill_price']);
    $goods['discount']=sprintf("%.2f",($seckill['seckill_price']/$goods['market_price'])*10);
    $smarty->assign('gb_goods', $goods);

    /* ȡ����Ʒ�Ĺ�� */
    $properties = get_goods_properties($goods_id);
    $smarty->assign('specification', $properties['spe']); // ��Ʒ���

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
    assign_dynamic('seckill_goods');

    //������Ʒ�������
    $sql = 'UPDATE ' . $ecs->table('goods') . ' SET click_count = click_count + 1 '.
        "WHERE goods_id = '" . $group_buy['goods_id'] . "'";
    $db->query($sql);

    $smarty->assign('now_time',  gmtime());           // ��ǰϵͳʱ��
    $smarty->display('seckill_goods.dwt', $cache_id);
}

/*------------------------------------------------------ */
//-- ��ɱ��Ʒ --> ����
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'buy')
{
    /* ��ѯ���ж��Ƿ��¼ */
    if ($_SESSION['user_id'] <= 0)
    {
        show_message($_LANG['gb_error_login'], '', '', 'error');
    }

    /* ��ѯ��ȡ�ò�������ɱ�id */
    $seckill_id = isset($_POST['seckill_id']) ? intval($_POST['seckill_id']) : 0;
    if ($seckill_id <= 0)
    {
        ecs_header("Location: ./\n");
        exit;
    }

    /* ��ѯ��ȡ������ */
    $number = isset($_POST['number']) ? intval($_POST['number']) : 1;
    $number = $number < 1 ? 1 : $number;

    /* ��ѯ��ȡ����ɱ���Ϣ */
    $seckill = seckill_info($seckill_id, $number);
    if (empty($seckill))
    {
        ecs_header("Location: ./\n");
        exit;
    }

    /* ��ѯ�������ɱ��Ƿ��ǽ����� */
    if ($seckill['cur_status'] != 1)
    {
        show_message($_LANG['gb_error_status'], '', '', 'error');
    }

    /* ��ѯ��ȡ����ɱ��Ʒ��Ϣ */
    $goods = goods_info($seckill['goods_id']);
    if (empty($goods))
    {
        ecs_header("Location: ./\n");
        exit;
    }

//    /* ��ѯ���ж������Ƿ��㹻 */
//    if (($group_buy['restrict_amount'] > 0 && $number > ($group_buy['restrict_amount'] - $group_buy['valid_goods'])) || $number > $goods['goods_number'])
//    {
//        show_message($_LANG['gb_error_goods_lacking'], '', '', 'error');
//    }
//
//    /* ��ѯ��ȡ�ù�� */
//    $specs = '';
//    foreach ($_POST as $key => $value)
//    {
//        if (strpos($key, 'spec_') !== false)
//        {
//            $specs .= ',' . intval($value);
//        }
//    }
//    $specs = trim($specs, ',');
//
//    /* ��ѯ�������Ʒ�й����ȡ�����Ʒ��Ϣ ������� */
//    if ($specs)
//    {
//        $_specs = explode(',', $specs);
//        $product_info = get_products_info($goods['goods_id'], $_specs);
//    }
//
//    empty($product_info) ? $product_info = array('product_number' => 0, 'product_id' => 0) : '';
//
//    /* ��ѯ���ж�ָ�����Ļ�Ʒ�����Ƿ��㹻 */
//    if ($specs && $number > $product_info['product_number'])
//    {
//        show_message($_LANG['gb_error_goods_lacking'], '', '', 'error');
//    }
//
//    /* ��ѯ����ѯ������ƺ�ֵ�������Ǽ۸� */
//    $attr_list = array();
//    $sql = "SELECT a.attr_name, g.attr_value " .
//            "FROM " . $ecs->table('goods_attr') . " AS g, " .
//                $ecs->table('attribute') . " AS a " .
//            "WHERE g.attr_id = a.attr_id " .
//            "AND g.goods_attr_id " . db_create_in($specs);
//    $res = $db->query($sql);
//    while ($row = $db->fetchRow($res))
//    {
//        $attr_list[] = $row['attr_name'] . ': ' . $row['attr_value'];
//    }
//    $goods_attr = join(chr(13) . chr(10), $attr_list);

    /* ���£���չ��ﳵ��������ɱ��Ʒ */
    include_once(ROOT_PATH . 'includes/lib_order.php');
    clear_cart(CART_SECKILL_GOODS);
    $seckill['deposit']==0;
    /* ���£����빺�ﳵ */
    $goods_price = $seckill['deposit'] > 0 ? $seckill['deposit'] : $seckill['seckill_price'];
    $cart = array(
        'user_id'        => $_SESSION['user_id'],
        'session_id'     => SESS_ID,
        'goods_id'       => $seckill['goods_id'],
        'product_id'     => $product_info['product_id'],
        'goods_sn'       => addslashes($goods['goods_sn']),
        'goods_name'     => addslashes($goods['goods_name']),
        'market_price'   => $goods['market_price'],
        'goods_price'    => $goods_price,
        'goods_number'   => $number,
        'goods_attr'     => addslashes($goods_attr),
        'goods_attr_id'  => $specs,
        'is_real'        => $goods['is_real'],
        'extension_code' => addslashes($goods['extension_code']),
        'parent_id'      => 0,
        'rec_type'       => CART_SECKILL_GOODS,
        'is_gift'        => 0
    );
    $db->autoExecute($ecs->table('cart'), $cart, 'INSERT');

    /* ���£���¼�����������ͣ���ɱ */
    $_SESSION['flow_type'] = CART_SECKILL_GOODS;
    $_SESSION['extension_code'] = 'seckill';
    $_SESSION['extension_id'] = $seckill_id;

    /* �����ջ���ҳ�� */
    ecs_header("Location: ./flow.php?step=consignee\n");
    exit;
}

/* ȡ����ɱ����� */
function seckill_count()
{
    $now = gmtime();
    $sql = "SELECT COUNT(*) " .
        "FROM " . $GLOBALS['ecs']->table('seckill');

    return $GLOBALS['db']->getOne($sql);
}

/**
 * ȡ��ĳҳ��������ɱ�
 * @param   int     $size   ÿҳ��¼��
 * @param   int     $page   ��ǰҳ
 * @return  array
 */
function seckill_list($size, $page)
{
    /* ȡ����ɱ� */
    $gb_list = array();
    $now = gmtime();
    $sql = "SELECT b.*, IFNULL(g.goods_thumb, '') AS goods_thumb,g.market_price, ".
        "b.start_time AS start_date, b.end_time AS end_date " .
        "FROM " . $GLOBALS['ecs']->table('seckill') . " AS b " .
        "LEFT JOIN " . $GLOBALS['ecs']->table('goods') . " AS g ON b.goods_id = g.goods_id ORDER BY b.id DESC";
    $res = $GLOBALS['db']->selectLimit($sql, $size, ($page - 1) * $size);

    while ($seckill = $GLOBALS['db']->fetchRow($res))
    {


        /* ��ʽ��ʱ�� */
        $seckill['formated_start_date']   = local_date($GLOBALS['_CFG']['time_format'], $seckill['start_date']);
        $seckill['formated_end_date']     = local_date($GLOBALS['_CFG']['time_format'], $seckill['end_date']);
        $seckill['start_day'] =local_date('m��d��,h:i:s',$seckill['start_date']);
        $seckill['surplus']=intval($seckill['market_price'])-intval($seckill['seckill_price']);
        $seckill['discount']=sprintf("%.2f",($seckill['seckill_price']/$seckill['market_price'])*10);

        $stat = seckill_stat($seckill['id']);
        if(time()<$seckill['start_date'])
        {
            $seckill['cur_status']  = 0;
        }
        else
        {
            if(time()>=$seckill['end_date'] || $stat['valid_order']>=$seckill['number'])
            {
                $seckill['cur_status']  = 2;
            }
            else{
                $seckill['cur_status']  = 1;
            }
        }
        $surplus = time2string($seckill['start_date']-time());
        $seckill['surplus_day']			= $surplus['day'];
        $seckill['surplus_hour']		= $surplus['hour'];
        $seckill['surplus_minute']		= $surplus['minute'];
        $seckill['surplus_seconds']		= $surplus['second'];

        /* ����ͼƬ */
        if (empty($group_buy['goods_thumb']))
        {
            $group_buy['goods_thumb'] = get_image_path($group_buy['goods_id'], $group_buy['goods_thumb'], true);
        }
        /* �������� */
        $seckill['url'] = build_uri('seckill', array('msid'=>$seckill['id']));
        /* �������� */
        $gb_list[] = $seckill;
    }

    return $gb_list;
}

/**
 * ȡ����ɱ���Ϣ
 * @param   int     $seckill_id   ��ɱ�id
 * @return  array
 *                  status          ״̬��
 */
function seckill_info($seckill_id)
{
    /* ȡ����ɱ���Ϣ */
    $seckill_id = intval($seckill_id);
    $sql = "SELECT *, id AS seckill_id, start_time AS start_date, end_time AS end_date " .
        "FROM " . $GLOBALS['ecs']->table('seckill') .
        "WHERE id = '$seckill_id' ";
    $seckill = $GLOBALS['db']->getRow($sql);
    /* ���Ϊ�գ����ؿ����� */
    if (empty($seckill))
    {
        return array();
    }
    $stat = seckill_stat($seckill['id']);
    $seckill['valid_goods']  = $stat['valid_goods'];
    $seckill['valid_order']  = $stat['valid_order'];
    if(time()<$seckill['start_time'])
    {
        $seckill['cur_status']  = 0;
    }
    else
    {
        if(time()>=$seckill['end_time'] || $stat['valid_order']>=$seckill['number'])
        {
            $seckill['cur_status']  = 2;
        }
        else{
            $seckill['cur_status']  = 1;
        }
    }
    $seckill['start_day'] =local_date('m��d��,h:i:s',$seckill['start_date']);
    $seckill['start_time'] = local_date('Y-m-d H:i:s', $seckill['start_time']);
    $seckill['end_time'] = local_date('Y-m-d H:i:s', $seckill['end_time']);

    return $seckill;
}

/*ȡ��ʣ��ʱ��*/
function time2string($second){
    $surplus['day'] = floor($second/(3600*24));
    $second = $second%(3600*24);//��ȥ����֮��ʣ���ʱ��
    $surplus['hour'] = floor($second/3600);
    $second = $second%3600;//��ȥ��Сʱ֮��ʣ���ʱ��
    $surplus['minute'] = floor($second/60);
    $surplus['second'] = $second%60;//��ȥ������֮��ʣ���ʱ��
    //�����ַ���
    return $surplus;
}


/*
 * ȡ��ĳ��ɱ�ͳ����Ϣ
 * @param   int     $seckill_id  	��ɱid
 * @return  array   ͳ����Ϣ
 *                  total_order     �ܶ�����
 *                  total_goods     ����Ʒ��
 *                  valid_order     ��Ч������
 *                  valid_goods     ��Ч��Ʒ��
 */
function seckill_stat($seckill_id)
{
    $seckill_id = intval($seckill_id);

    /* ȡ����ɱ���ƷID */
    $sql = "SELECT goods_id " .
        "FROM " . $GLOBALS['ecs']->table('seckill') .
        "WHERE id = '$seckill_id' ";
    $seckill_goods_id = $GLOBALS['db']->getOne($sql);

    /* ȡ���ܶ�����������Ʒ�� */
    $sql = "SELECT COUNT(*) AS total_order, SUM(g.goods_number) AS total_goods " .
        "FROM " . $GLOBALS['ecs']->table('order_info') . " AS o, " .
        $GLOBALS['ecs']->table('order_goods') . " AS g " .
        " WHERE o.order_id = g.order_id " .
        "AND o.extension_code = 'seckill' " .
        "AND o.extension_id = '$seckill_id' " .
        "AND g.goods_id = '$seckill_goods_id' " .
        "AND (order_status = '" . OS_CONFIRMED . "' OR order_status = '" . OS_UNCONFIRMED . "')";
    $stat = $GLOBALS['db']->getRow($sql);
    if ($stat['total_order'] == 0)
    {
        $stat['total_goods'] = 0;
    }

    /* ȡ����Ч����������Ч��Ʒ�� */
    $stat['valid_order'] = $stat['total_order'];
    $stat['valid_goods'] = $stat['total_goods'];

    return $stat;
}

?>