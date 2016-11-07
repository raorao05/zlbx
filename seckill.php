<?php

/**
 * ECSHOP 秒杀商品前台文件
 * ============================================================================
 * 版权所有 2005-2010 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
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
//-- act 操作项的初始化
/*------------------------------------------------------ */
if (empty($_REQUEST['act']))
{
    $_REQUEST['act'] = 'list';
}

/*------------------------------------------------------ */
//-- 秒杀商品 --> 秒杀活动商品列表
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'list')
{
    /* 取得秒杀活动总数 */
    $count = seckill_count();
    if ($count > 0)
    {
        /* 取得每页记录数 */
        $size = isset($_CFG['page_size']) && intval($_CFG['page_size']) > 0 ? intval($_CFG['page_size']) : 10;

        /* 计算总页数 */
        $page_count = ceil($count / $size);

        /* 取得当前页 */
        $page = isset($_REQUEST['page']) && intval($_REQUEST['page']) > 0 ? intval($_REQUEST['page']) : 1;
        $page = $page > $page_count ? $page_count : $page;

        /* 缓存id：语言 - 每页记录数 - 当前页 */
        $cache_id = $_CFG['lang'] . '-' . $size . '-' . $page;
        $cache_id = sprintf('%X', crc32($cache_id));
    }
    else
    {
        /* 缓存id：语言 */
        $cache_id = $_CFG['lang'];
        $cache_id = sprintf('%X', crc32($cache_id));
    }

    /* 如果没有缓存，生成缓存 */
    if (!$smarty->is_cached('seckill_list.dwt', $cache_id))
    {
        if ($count > 0)
        {
            /* 取得当前页的秒杀活动 */
            $gb_list = seckill_list($size, $page);
            $smarty->assign('gb_list',  $gb_list);

            /* 设置分页链接 */
            $pager = get_pager('seckill.php', array('act' => 'list'), $count, $page, $size);
            $smarty->assign('pager', $pager);
        }

        /* 模板赋值 */
        $smarty->assign('cfg', $_CFG);
        assign_template();
        $position = assign_ur_here();
        $smarty->assign('page_title', $position['title']);    // 页面标题
        $smarty->assign('ur_here',    $position['ur_here']);  // 当前位置
        $smarty->assign('categories', get_categories_tree()); // 分类树
        $smarty->assign('helps',      get_shop_help());       // 网店帮助
        $smarty->assign('top_goods',  get_top10());           // 销售排行
        $smarty->assign('promotion_info', get_promotion_info());
        $smarty->assign('feed_url',         ($_CFG['rewrite'] == 1) ? "feed-typegroup_buy.xml" : 'feed.php?type=group_buy'); // RSS URL

        assign_dynamic('seckill_list');
    }
    //print_r($gb_list);exit;

    /* 显示模板 */
    $smarty->display('seckill_list.dwt');
}

/*------------------------------------------------------ */
//-- 秒杀商品 --> 商品详情
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'view')
{
    /* 取得参数：秒杀活动id */
    $seckill_id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
    if ($seckill_id <= 0)
    {
        ecs_header("Location: ./\n");
        exit;
    }

    /* 取得秒杀活动信息 */
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

    /* 取得秒杀商品信息 */
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

    /* 取得商品的规格 */
    $properties = get_goods_properties($goods_id);
    $smarty->assign('specification', $properties['spe']); // 商品规格

    //模板赋值
    $smarty->assign('cfg', $_CFG);
    assign_template();

    $position = assign_ur_here(0, $goods['goods_name']);
    $smarty->assign('page_title', $position['title']);    // 页面标题
    $smarty->assign('ur_here',    $position['ur_here']);  // 当前位置

    $smarty->assign('categories', get_categories_tree()); // 分类树
    $smarty->assign('helps',      get_shop_help());       // 网店帮助
    $smarty->assign('top_goods',  get_top10());           // 销售排行
    $smarty->assign('promotion_info', get_promotion_info());
    assign_dynamic('seckill_goods');

    //更新商品点击次数
    $sql = 'UPDATE ' . $ecs->table('goods') . ' SET click_count = click_count + 1 '.
        "WHERE goods_id = '" . $group_buy['goods_id'] . "'";
    $db->query($sql);

    $smarty->assign('now_time',  gmtime());           // 当前系统时间
    $smarty->display('seckill_goods.dwt', $cache_id);
}

/*------------------------------------------------------ */
//-- 秒杀商品 --> 购买
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'buy')
{
    /* 查询：判断是否登录 */
    if ($_SESSION['user_id'] <= 0)
    {
        show_message($_LANG['gb_error_login'], '', '', 'error');
    }

    /* 查询：取得参数：秒杀活动id */
    $seckill_id = isset($_POST['seckill_id']) ? intval($_POST['seckill_id']) : 0;
    if ($seckill_id <= 0)
    {
        ecs_header("Location: ./\n");
        exit;
    }

    /* 查询：取得数量 */
    $number = isset($_POST['number']) ? intval($_POST['number']) : 1;
    $number = $number < 1 ? 1 : $number;

    /* 查询：取得秒杀活动信息 */
    $seckill = seckill_info($seckill_id, $number);
    if (empty($seckill))
    {
        ecs_header("Location: ./\n");
        exit;
    }

    /* 查询：检查秒杀活动是否是进行中 */
    if ($seckill['cur_status'] != 1)
    {
        show_message($_LANG['gb_error_status'], '', '', 'error');
    }

    /* 查询：取得秒杀商品信息 */
    $goods = goods_info($seckill['goods_id']);
    if (empty($goods))
    {
        ecs_header("Location: ./\n");
        exit;
    }

//    /* 查询：判断数量是否足够 */
//    if (($group_buy['restrict_amount'] > 0 && $number > ($group_buy['restrict_amount'] - $group_buy['valid_goods'])) || $number > $goods['goods_number'])
//    {
//        show_message($_LANG['gb_error_goods_lacking'], '', '', 'error');
//    }
//
//    /* 查询：取得规格 */
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
//    /* 查询：如果商品有规格则取规格商品信息 配件除外 */
//    if ($specs)
//    {
//        $_specs = explode(',', $specs);
//        $product_info = get_products_info($goods['goods_id'], $_specs);
//    }
//
//    empty($product_info) ? $product_info = array('product_number' => 0, 'product_id' => 0) : '';
//
//    /* 查询：判断指定规格的货品数量是否足够 */
//    if ($specs && $number > $product_info['product_number'])
//    {
//        show_message($_LANG['gb_error_goods_lacking'], '', '', 'error');
//    }
//
//    /* 查询：查询规格名称和值，不考虑价格 */
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

    /* 更新：清空购物车中所有秒杀商品 */
    include_once(ROOT_PATH . 'includes/lib_order.php');
    clear_cart(CART_SECKILL_GOODS);
    $seckill['deposit']==0;
    /* 更新：加入购物车 */
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

    /* 更新：记录购物流程类型：秒杀 */
    $_SESSION['flow_type'] = CART_SECKILL_GOODS;
    $_SESSION['extension_code'] = 'seckill';
    $_SESSION['extension_id'] = $seckill_id;

    /* 进入收货人页面 */
    ecs_header("Location: ./flow.php?step=consignee\n");
    exit;
}

/* 取得秒杀活动总数 */
function seckill_count()
{
    $now = gmtime();
    $sql = "SELECT COUNT(*) " .
        "FROM " . $GLOBALS['ecs']->table('seckill');

    return $GLOBALS['db']->getOne($sql);
}

/**
 * 取得某页的所有秒杀活动
 * @param   int     $size   每页记录数
 * @param   int     $page   当前页
 * @return  array
 */
function seckill_list($size, $page)
{
    /* 取得秒杀活动 */
    $gb_list = array();
    $now = gmtime();
    $sql = "SELECT b.*, IFNULL(g.goods_thumb, '') AS goods_thumb,g.market_price, ".
        "b.start_time AS start_date, b.end_time AS end_date " .
        "FROM " . $GLOBALS['ecs']->table('seckill') . " AS b " .
        "LEFT JOIN " . $GLOBALS['ecs']->table('goods') . " AS g ON b.goods_id = g.goods_id ORDER BY b.id DESC";
    $res = $GLOBALS['db']->selectLimit($sql, $size, ($page - 1) * $size);

    while ($seckill = $GLOBALS['db']->fetchRow($res))
    {


        /* 格式化时间 */
        $seckill['formated_start_date']   = local_date($GLOBALS['_CFG']['time_format'], $seckill['start_date']);
        $seckill['formated_end_date']     = local_date($GLOBALS['_CFG']['time_format'], $seckill['end_date']);
        $seckill['start_day'] =local_date('m月d日,h:i:s',$seckill['start_date']);
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

        /* 处理图片 */
        if (empty($group_buy['goods_thumb']))
        {
            $group_buy['goods_thumb'] = get_image_path($group_buy['goods_id'], $group_buy['goods_thumb'], true);
        }
        /* 处理链接 */
        $seckill['url'] = build_uri('seckill', array('msid'=>$seckill['id']));
        /* 加入数组 */
        $gb_list[] = $seckill;
    }

    return $gb_list;
}

/**
 * 取得秒杀活动信息
 * @param   int     $seckill_id   秒杀活动id
 * @return  array
 *                  status          状态：
 */
function seckill_info($seckill_id)
{
    /* 取得秒杀活动信息 */
    $seckill_id = intval($seckill_id);
    $sql = "SELECT *, id AS seckill_id, start_time AS start_date, end_time AS end_date " .
        "FROM " . $GLOBALS['ecs']->table('seckill') .
        "WHERE id = '$seckill_id' ";
    $seckill = $GLOBALS['db']->getRow($sql);
    /* 如果为空，返回空数组 */
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
    $seckill['start_day'] =local_date('m月d日,h:i:s',$seckill['start_date']);
    $seckill['start_time'] = local_date('Y-m-d H:i:s', $seckill['start_time']);
    $seckill['end_time'] = local_date('Y-m-d H:i:s', $seckill['end_time']);

    return $seckill;
}

/*取得剩余时间*/
function time2string($second){
    $surplus['day'] = floor($second/(3600*24));
    $second = $second%(3600*24);//除去整天之后剩余的时间
    $surplus['hour'] = floor($second/3600);
    $second = $second%3600;//除去整小时之后剩余的时间
    $surplus['minute'] = floor($second/60);
    $surplus['second'] = $second%60;//除去整分钟之后剩余的时间
    //返回字符串
    return $surplus;
}


/*
 * 取得某秒杀活动统计信息
 * @param   int     $seckill_id  	秒杀id
 * @return  array   统计信息
 *                  total_order     总订单数
 *                  total_goods     总商品数
 *                  valid_order     有效订单数
 *                  valid_goods     有效商品数
 */
function seckill_stat($seckill_id)
{
    $seckill_id = intval($seckill_id);

    /* 取得秒杀活动商品ID */
    $sql = "SELECT goods_id " .
        "FROM " . $GLOBALS['ecs']->table('seckill') .
        "WHERE id = '$seckill_id' ";
    $seckill_goods_id = $GLOBALS['db']->getOne($sql);

    /* 取得总订单数和总商品数 */
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

    /* 取得有效订单数和有效商品数 */
    $stat['valid_order'] = $stat['total_order'];
    $stat['valid_goods'] = $stat['total_goods'];

    return $stat;
}

?>