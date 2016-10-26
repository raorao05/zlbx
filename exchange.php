<?php

/**
 * ECSHOP �����̳�
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: exchange.php 17217 2011-01-19 06:29:08Z liubo $
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
//-- PROCESSOR
/*------------------------------------------------------ */

/*------------------------------------------------------ */
//-- ���ֶһ���Ʒ�б�
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'list')
{
    /* ��ʼ����ҳ��Ϣ */
    $page         = isset($_REQUEST['page'])   && intval($_REQUEST['page'])  > 0 ? intval($_REQUEST['page'])  : 1;
    $size         = isset($_CFG['page_size'])  && intval($_CFG['page_size']) > 0 ? intval($_CFG['page_size']) : 10;
    $cat_id       = isset($_REQUEST['cat_id']) && intval($_REQUEST['cat_id']) > 0 ? intval($_REQUEST['cat_id']) : 0;
    $integral_max = isset($_REQUEST['integral_max']) && intval($_REQUEST['integral_max']) > 0 ? intval($_REQUEST['integral_max']) : 0;
    $integral_min = isset($_REQUEST['integral_min']) && intval($_REQUEST['integral_min']) > 0 ? intval($_REQUEST['integral_min']) : 0;

    /* ������ʾ��ʽ�Լ����� */
    $default_display_type      = $_CFG['show_order_type'] == '0' ? 'list' : ($_CFG['show_order_type'] == '1' ? 'grid' : 'text');
    $default_sort_order_method = $_CFG['sort_order_method'] == '0' ? 'DESC' : 'ASC';
    $default_sort_order_type   = $_CFG['sort_order_type'] == '0' ? 'goods_id' : ($_CFG['sort_order_type'] == '1' ? 'exchange_integral' : 'last_update');

    $sort    = (isset($_REQUEST['sort'])  && in_array(trim(strtolower($_REQUEST['sort'])), array('goods_id', 'exchange_integral', 'last_update'))) ? trim($_REQUEST['sort'])  : $default_sort_order_type;
    $order   = (isset($_REQUEST['order']) && in_array(trim(strtoupper($_REQUEST['order'])), array('ASC', 'DESC')))                              ? trim($_REQUEST['order']) : $default_sort_order_method;
    $display = (isset($_REQUEST['display']) && in_array(trim(strtolower($_REQUEST['display'])), array('list', 'grid', 'text'))) ? trim($_REQUEST['display'])  : (isset($_COOKIE['ECS']['display']) ? $_COOKIE['ECS']['display'] : $default_display_type);
    $display  = in_array($display, array('list', 'grid', 'text')) ? $display : 'text';
    setcookie('ECS[display]', $display, gmtime() + 86400 * 7);

    /* ҳ��Ļ���ID */
    $cache_id = sprintf('%X', crc32($cat_id . '-' . $display . '-' . $sort  .'-' . $order  .'-' . $page . '-' . $size . '-' . $_SESSION['user_rank'] . '-' .
        $_CFG['lang'] . '-' . $integral_max . '-' .$integral_min));

    if (!$smarty->is_cached('exchange.dwt', $cache_id))
    {
        /* ���ҳ��û�б����������»�ȡҳ������� */

        $children = get_children($cat_id);

        $cat = get_cat_info($cat_id);   // ��÷���������Ϣ

        if (!empty($cat))
        {
            $smarty->assign('keywords',    htmlspecialchars($cat['keywords']));
            $smarty->assign('description', htmlspecialchars($cat['cat_desc']));
        }

        assign_template();

        $position = assign_ur_here('exchange');
        $smarty->assign('page_title',       $position['title']);    // ҳ�����
        $smarty->assign('ur_here',          $position['ur_here']);  // ��ǰλ��

        $smarty->assign('categories',       get_categories_tree());        // ������
        $smarty->assign('helps',            get_shop_help());              // �������
        $smarty->assign('top_goods',        get_top10());                  // ��������
        $smarty->assign('promotion_info',   get_promotion_info());         // �������Ϣ

        /* ���� */
        $vote = get_vote();
        if (!empty($vote))
        {
            $smarty->assign('vote_id',     $vote['id']);
            $smarty->assign('vote',        $vote['content']);
        }

        $ext = ''; //��Ʒ��ѯ������չ

        //$smarty->assign('best_goods',      get_exchange_recommend_goods('best', $children, $integral_min, $integral_max));
        //$smarty->assign('new_goods',       get_exchange_recommend_goods('new',  $children, $integral_min, $integral_max));
        $smarty->assign('hot_goods',       get_exchange_recommend_goods('hot',  $children, $integral_min, $integral_max));


        $count = get_exchange_goods_count($children, $integral_min, $integral_max);
        $max_page = ($count> 0) ? ceil($count / $size) : 1;
        if ($page > $max_page)
        {
            $page = $max_page;
        }
        $goodslist = exchange_get_goods($children, $integral_min, $integral_max, $ext, $size, $page, $sort, $order);
        if($display == 'grid')
        {
            if(count($goodslist) % 2 != 0)
            {
                $goodslist[] = array();
            }
        }
        $smarty->assign('goods_list',       $goodslist);
        $smarty->assign('category',         $cat_id);
        $smarty->assign('integral_max',     $integral_max);
        $smarty->assign('integral_min',     $integral_min);


        assign_pager('exchange',            $cat_id, $count, $size, $sort, $order, $page, '', '', $integral_min, $integral_max, $display); // ��ҳ
        assign_dynamic('exchange_list'); // ��̬����
    }

    $smarty->assign('feed_url',         ($_CFG['rewrite'] == 1) ? "feed-typeexchange.xml" : 'feed.php?type=exchange'); // RSS URL
    $smarty->display('exchange_list.dwt', $cache_id);
}

/*------------------------------------------------------ */
//-- ���ֶһ���Ʒ����
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'view')
{
    $goods_id = isset($_REQUEST['id'])  ? intval($_REQUEST['id']) : 0;

    $cache_id = $goods_id . '-' . $_SESSION['user_rank'] . '-' . $_CFG['lang'] . '-exchange';
    $cache_id = sprintf('%X', crc32($cache_id));

    if (!$smarty->is_cached('exchange_goods.dwt', $cache_id))
    {
        $smarty->assign('image_width',  $_CFG['image_width']);
        $smarty->assign('image_height', $_CFG['image_height']);
        $smarty->assign('helps',        get_shop_help()); // �������
        $smarty->assign('id',           $goods_id);
        $smarty->assign('type',         0);
        $smarty->assign('cfg',          $_CFG);

        /* �����Ʒ����Ϣ */
        $goods = get_exchange_goods_info($goods_id);

        if ($goods === false)
        {
            /* ���û���ҵ��κμ�¼�����ص���ҳ */
            ecs_header("Location: ./\n");
            exit;
        }
        else
        {
            if ($goods['brand_id'] > 0)
            {
                $goods['goods_brand_url'] = build_uri('brand', array('bid'=>$goods['brand_id']), $goods['goods_brand']);
            }

            $goods['goods_style_name'] = add_style($goods['goods_name'], $goods['goods_name_style']);

            $smarty->assign('goods',              $goods);
            $smarty->assign('goods_id',           $goods['goods_id']);
            $smarty->assign('categories',         get_categories_tree());  // ������

            /* meta */
            $smarty->assign('keywords',           htmlspecialchars($goods['keywords']));
            $smarty->assign('description',        htmlspecialchars($goods['goods_brief']));

            assign_template();

            /* ��һ����Ʒ��һ����Ʒ */
            $sql = "SELECT eg.goods_id FROM " .$ecs->table('exchange_goods'). " AS eg," . $GLOBALS['ecs']->table('goods') . " AS g WHERE eg.goods_id = g.goods_id AND eg.goods_id > " . $goods['goods_id'] . " AND eg.is_exchange = 1 AND g.is_delete = 0 LIMIT 1";
            $prev_gid = $db->getOne($sql);
            if (!empty($prev_gid))
            {
                $prev_good['url'] = build_uri('exchange_goods', array('gid' => $prev_gid), $goods['goods_name']);
                $smarty->assign('prev_good', $prev_good);//��һ����Ʒ
            }

            $sql = "SELECT max(eg.goods_id) FROM " . $ecs->table('exchange_goods') . " AS eg," . $GLOBALS['ecs']->table('goods') . " AS g WHERE eg.goods_id = g.goods_id AND eg.goods_id < ".$goods['goods_id'] . " AND eg.is_exchange = 1 AND g.is_delete = 0";
            $next_gid = $db->getOne($sql);
            if (!empty($next_gid))
            {
                $next_good['url'] = build_uri('exchange_goods', array('gid' => $next_gid), $goods['goods_name']);
                $smarty->assign('next_good', $next_good);//��һ����Ʒ
            }

            /* current position */
            $position = assign_ur_here('exchange', $goods['goods_name']);
            $smarty->assign('page_title',          $position['title']);                    // ҳ�����
            $smarty->assign('ur_here',             $position['ur_here']);                  // ��ǰλ��

            $properties = get_goods_properties($goods_id);  // �����Ʒ�Ĺ�������
            $smarty->assign('properties',          $properties['pro']);                              // ��Ʒ����
            $smarty->assign('specification',       $properties['spe']);                              // ��Ʒ���

            $smarty->assign('pictures',            get_goods_gallery($goods_id));                    // ��Ʒ���

            assign_dynamic('exchange_goods');
        }
    }

    $smarty->display('exchange_goods.dwt',      $cache_id);
}

/*------------------------------------------------------ */
//--  �һ�
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'buy')
{
    /* ��ѯ���ж��Ƿ��¼ */
    if (!isset($back_act) && isset($GLOBALS['_SERVER']['HTTP_REFERER']))
    {
        $back_act = strpos($GLOBALS['_SERVER']['HTTP_REFERER'], 'exchange') ? $GLOBALS['_SERVER']['HTTP_REFERER'] : './index.php';
    }

    /* ��ѯ���ж��Ƿ��¼ */
    if ($_SESSION['user_id'] <= 0)
    {
        show_message($_LANG['eg_error_login'], array($_LANG['back_up_page']), array($back_act), 'error');
    }

    /* ��ѯ��ȡ�ò�������Ʒid */
    $goods_id = isset($_POST['goods_id']) ? intval($_POST['goods_id']) : 0;
    if ($goods_id <= 0)
    {
        ecs_header("Location: ./\n");
        exit;
    }

    /* ��ѯ��ȡ�öһ���Ʒ��Ϣ */
    $goods = get_exchange_goods_info($goods_id);
    if (empty($goods))
    {
        ecs_header("Location: ./\n");
        exit;
    }
    /* ��ѯ�����һ���Ʒ�Ƿ��п�� */
    if($goods['goods_number'] == 0 && $_CFG['use_storage'] == 1)
    {
        show_message($_LANG['eg_error_number'], array($_LANG['back_up_page']), array($back_act), 'error');
    }
    /* ��ѯ�����һ���Ʒ�Ƿ���ȡ�� */
    if ($goods['is_exchange'] == 0)
    {
        show_message($_LANG['eg_error_status'], array($_LANG['back_up_page']), array($back_act), 'error');
    }

    $user_info   = get_user_info($_SESSION['user_id']);
    $user_points = $user_info['pay_points']; // �û��Ļ�������
    if ($goods['exchange_integral'] > $user_points)
    {
        show_message($_LANG['eg_error_integral'], array($_LANG['back_up_page']), array($back_act), 'error');
    }

    /* ��ѯ��ȡ�ù�� */
    $specs = '';
    foreach ($_POST as $key => $value)
    {
        if (strpos($key, 'spec_') !== false)
        {
            $specs .= ',' . intval($value);
        }
    }
    $specs = trim($specs, ',');

    /* ��ѯ�������Ʒ�й����ȡ�����Ʒ��Ϣ ������� */
    if (!empty($specs))
    {
        $_specs = explode(',', $specs);

        $product_info = get_products_info($goods_id, $_specs);
    }
    if (empty($product_info))
    {
        $product_info = array('product_number' => '', 'product_id' => 0);
    }

    //��ѯ����Ʒ���ڹ�� �ǻ�Ʒ ���û�Ʒ���
    if((!empty($specs)) && ($product_info['product_number'] == 0) && ($_CFG['use_storage'] == 1))
    {
        show_message($_LANG['eg_error_number'], array($_LANG['back_up_page']), array($back_act), 'error');
    }

    /* ��ѯ����ѯ������ƺ�ֵ�������Ǽ۸� */
    $attr_list = array();
    $sql = "SELECT a.attr_name, g.attr_value " .
            "FROM " . $ecs->table('goods_attr') . " AS g, " .
                $ecs->table('attribute') . " AS a " .
            "WHERE g.attr_id = a.attr_id " .
            "AND g.goods_attr_id " . db_create_in($specs);
    $res = $db->query($sql);
    while ($row = $db->fetchRow($res))
    {
        $attr_list[] = $row['attr_name'] . ': ' . $row['attr_value'];
    }
    $goods_attr = join(chr(13) . chr(10), $attr_list);

    /* ���£���չ��ﳵ�������Ź���Ʒ */
    include_once(ROOT_PATH . 'includes/lib_order.php');
    clear_cart(CART_EXCHANGE_GOODS);

    /* ���£����빺�ﳵ */
    $number = 1;
    $cart = array(
        'user_id'        => $_SESSION['user_id'],
        'session_id'     => SESS_ID,
        'goods_id'       => $goods['goods_id'],
        'product_id'     => $product_info['product_id'],
        'goods_sn'       => addslashes($goods['goods_sn']),
        'goods_name'     => addslashes($goods['goods_name']),
        'market_price'   => $goods['market_price'],
        'goods_price'    => 0,//$goods['exchange_integral']
        'goods_number'   => $number,
        'goods_attr'     => addslashes($goods_attr),
        'goods_attr_id'  => $specs,
        'is_real'        => $goods['is_real'],
        'extension_code' => addslashes($goods['extension_code']),
        'parent_id'      => 0,
        'rec_type'       => CART_EXCHANGE_GOODS,
        'is_gift'        => 0
    );
    $db->autoExecute($ecs->table('cart'), $cart, 'INSERT');

    /* ��¼�����������ͣ��Ź� */
    $_SESSION['flow_type'] = CART_EXCHANGE_GOODS;
    $_SESSION['extension_code'] = 'exchange_goods';
    $_SESSION['extension_id'] = $goods_id;

    /* �����ջ���ҳ�� */
    ecs_header("Location: ./flow.php?step=consignee\n");
    exit;
}

/*------------------------------------------------------ */
//-- PRIVATE FUNCTION
/*------------------------------------------------------ */

/**
 * ��÷������Ϣ
 *
 * @param   integer $cat_id
 *
 * @return  void
 */
function get_cat_info($cat_id)
{
    return $GLOBALS['db']->getRow('SELECT keywords, cat_desc, style, grade, filter_attr, parent_id FROM ' . $GLOBALS['ecs']->table('category') .
        " WHERE cat_id = '$cat_id'");
}

/**
 * ��÷����µ���Ʒ
 *
 * @access  public
 * @param   string  $children
 * @return  array
 */
function exchange_get_goods($children, $min, $max, $ext, $size, $page, $sort, $order)
{
    $display = $GLOBALS['display'];
    $where = "eg.is_exchange = 1 AND g.is_delete = 0 AND ".
             "($children OR " . get_extension_goods($children) . ')';

    if ($min > 0)
    {
        $where .= " AND eg.exchange_integral >= $min ";
    }

    if ($max > 0)
    {
        $where .= " AND eg.exchange_integral <= $max ";
    }

    /* �����Ʒ�б� */
    $sql = 'SELECT g.goods_id, g.goods_name, g.goods_name_style, eg.exchange_integral, ' .
                'g.goods_type, g.goods_brief, g.goods_thumb , g.goods_img, eg.is_hot ' .
            'FROM ' . $GLOBALS['ecs']->table('exchange_goods') . ' AS eg, ' .$GLOBALS['ecs']->table('goods') . ' AS g ' .
            "WHERE eg.goods_id = g.goods_id AND $where $ext ORDER BY $sort $order";
    $res = $GLOBALS['db']->selectLimit($sql, $size, ($page - 1) * $size);

    $arr = array();
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        /* ������ƷˮӡͼƬ */
        $watermark_img = '';

//        if ($row['is_new'] != 0)
//        {
//            $watermark_img = "watermark_new_small";
//        }
//        elseif ($row['is_best'] != 0)
//        {
//            $watermark_img = "watermark_best_small";
//        }
//        else
        if ($row['is_hot'] != 0)
        {
            $watermark_img = 'watermark_hot_small';
        }

        if ($watermark_img != '')
        {
            $arr[$row['goods_id']]['watermark_img'] =  $watermark_img;
        }

        $arr[$row['goods_id']]['goods_id']          = $row['goods_id'];
        if($display == 'grid')
        {
            $arr[$row['goods_id']]['goods_name']    = $GLOBALS['_CFG']['goods_name_length'] > 0 ? sub_str($row['goods_name'], $GLOBALS['_CFG']['goods_name_length']) : $row['goods_name'];
        }
        else
        {
            $arr[$row['goods_id']]['goods_name']    = $row['goods_name'];
        }
        $arr[$row['goods_id']]['name']              = $row['goods_name'];
        $arr[$row['goods_id']]['goods_brief']       = $row['goods_brief'];
        $arr[$row['goods_id']]['goods_style_name']  = add_style($row['goods_name'],$row['goods_name_style']);
        $arr[$row['goods_id']]['exchange_integral'] = $row['exchange_integral'];
        $arr[$row['goods_id']]['type']              = $row['goods_type'];
        $arr[$row['goods_id']]['goods_thumb']       = get_image_path($row['goods_id'], $row['goods_thumb'], true);
        $arr[$row['goods_id']]['goods_img']         = get_image_path($row['goods_id'], $row['goods_img']);
        $arr[$row['goods_id']]['url']               = build_uri('exchange_goods', array('gid'=>$row['goods_id']), $row['goods_name']);
    }

    return $arr;
}

/**
 * ��÷����µ���Ʒ����
 *
 * @access  public
 * @param   string     $cat_id
 * @return  integer
 */
function get_exchange_goods_count($children, $min = 0, $max = 0, $ext='')
{
    $where  = "eg.is_exchange = 1 AND g.is_delete = 0 AND ($children OR " . get_extension_goods($children) . ')';


    if ($min > 0)
    {
        $where .= " AND eg.exchange_integral >= $min ";
    }

    if ($max > 0)
    {
        $where .= " AND eg.exchange_integral <= $max ";
    }

    $sql = 'SELECT COUNT(*) FROM ' . $GLOBALS['ecs']->table('exchange_goods') . ' AS eg, ' .
           $GLOBALS['ecs']->table('goods') . " AS g WHERE eg.goods_id = g.goods_id AND $where $ext";

    /* ������Ʒ���� */
    return $GLOBALS['db']->getOne($sql);
}

/**
 * ���ָ�������µ��Ƽ���Ʒ
 *
 * @access  public
 * @param   string      $type       �Ƽ����ͣ������� best, new, hot, promote
 * @param   string      $cats       �����ID
 * @param   integer     $min        ��Ʒ��������
 * @param   integer     $max        ��Ʒ��������
 * @param   string      $ext        ��Ʒ��չ��ѯ
 * @return  array
 */
function get_exchange_recommend_goods($type = '', $cats = '', $min =0,  $max = 0, $ext='')
{
    $price_where = ($min > 0) ? " AND g.shop_price >= $min " : '';
    $price_where .= ($max > 0) ? " AND g.shop_price <= $max " : '';

    $sql =  'SELECT g.goods_id, g.goods_name, g.goods_name_style, eg.exchange_integral, ' .
                'g.goods_brief, g.goods_thumb, goods_img, b.brand_name ' .
            'FROM ' . $GLOBALS['ecs']->table('exchange_goods') . ' AS eg ' .
            'LEFT JOIN ' . $GLOBALS['ecs']->table('goods') . ' AS g ON g.goods_id = eg.goods_id ' .
            'LEFT JOIN ' . $GLOBALS['ecs']->table('brand') . ' AS b ON b.brand_id = g.brand_id ' .
            'WHERE eg.is_exchange = 1 AND g.is_delete = 0 ' . $price_where . $ext;
    $num = 0;
    $type2lib = array('best'=>'exchange_best', 'new'=>'exchange_new', 'hot'=>'exchange_hot');
    $num = get_library_number($type2lib[$type], 'exchange_list');

    switch ($type)
    {
        case 'best':
            $sql .= ' AND eg.is_best = 1';
            break;
        case 'new':
            $sql .= ' AND eg.is_new = 1';
            break;
        case 'hot':
            $sql .= ' AND eg.is_hot = 1';
            break;
    }

    if (!empty($cats))
    {
        $sql .= " AND (" . $cats . " OR " . get_extension_goods($cats) .")";
    }
    $order_type = $GLOBALS['_CFG']['recommend_order'];
    $sql .= ($order_type == 0) ? ' ORDER BY g.sort_order, g.last_update DESC' : ' ORDER BY RAND()';
    $res = $GLOBALS['db']->selectLimit($sql, $num);

    $idx = 0;
    $goods = array();
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        $goods[$idx]['id']                = $row['goods_id'];
        $goods[$idx]['name']              = $row['goods_name'];
        $goods[$idx]['brief']             = $row['goods_brief'];
        $goods[$idx]['brand_name']        = $row['brand_name'];
        $goods[$idx]['short_name']        = $GLOBALS['_CFG']['goods_name_length'] > 0 ?
                                                sub_str($row['goods_name'], $GLOBALS['_CFG']['goods_name_length']) : $row['goods_name'];
        $goods[$idx]['exchange_integral'] = $row['exchange_integral'];
        $goods[$idx]['thumb']             = get_image_path($row['goods_id'], $row['goods_thumb'], true);
        $goods[$idx]['goods_img']         = get_image_path($row['goods_id'], $row['goods_img']);
        $goods[$idx]['url']               = build_uri('exchange_goods', array('gid' => $row['goods_id']), $row['goods_name']);

        $goods[$idx]['short_style_name']  = add_style($goods[$idx]['short_name'], $row['goods_name_style']);
        $idx++;
    }

    return $goods;
}

/**
 * ��û��ֶһ���Ʒ����ϸ��Ϣ
 *
 * @access  public
 * @param   integer     $goods_id
 * @return  void
 */
function get_exchange_goods_info($goods_id)
{
    $time = gmtime();
    $sql = 'SELECT g.*, c.measure_unit, b.brand_id, b.brand_name AS goods_brand, eg.exchange_integral, eg.is_exchange ' .
            'FROM ' . $GLOBALS['ecs']->table('goods') . ' AS g ' .
            'LEFT JOIN ' . $GLOBALS['ecs']->table('exchange_goods') . ' AS eg ON g.goods_id = eg.goods_id ' .
            'LEFT JOIN ' . $GLOBALS['ecs']->table('category') . ' AS c ON g.cat_id = c.cat_id ' .
            'LEFT JOIN ' . $GLOBALS['ecs']->table('brand') . ' AS b ON g.brand_id = b.brand_id ' .
            "WHERE g.goods_id = '$goods_id' AND g.is_delete = 0 " .
            'GROUP BY g.goods_id';

    $row = $GLOBALS['db']->getRow($sql);

    if ($row !== false)
    {
        /* ������ƷˮӡͼƬ */
        $watermark_img = '';

        if ($row['is_new'] != 0)
        {
            $watermark_img = "watermark_new";
        }
        elseif ($row['is_best'] != 0)
        {
            $watermark_img = "watermark_best";
        }
        elseif ($row['is_hot'] != 0)
        {
            $watermark_img = 'watermark_hot';
        }

        if ($watermark_img != '')
        {
            $row['watermark_img'] =  $watermark_img;
        }

        /* ����������ʾ */
        $row['goods_weight']  = (intval($row['goods_weight']) > 0) ?
            $row['goods_weight'] . $GLOBALS['_LANG']['kilogram'] :
            ($row['goods_weight'] * 1000) . $GLOBALS['_LANG']['gram'];

        /* �����ϼ�ʱ����ʾ */
        $row['add_time']      = local_date($GLOBALS['_CFG']['date_format'], $row['add_time']);

        /* ������ƷͼƬ */
        $row['goods_img']   = get_image_path($goods_id, $row['goods_img']);
        $row['goods_thumb'] = get_image_path($goods_id, $row['goods_thumb'], true);

        return $row;
    }
    else
    {
        return false;
    }
}


?>
