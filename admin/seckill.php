<?php

/**
 * ECSHOP 管理中心秒杀商品管理
 * ============================================================================
 * 版权所有 2005-2010 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.lqcms.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: lqcms $
 * $Id: seckill.php 17063 2010-03-25 06:35:46Z liuhui $
 */

define('IN_ECS', true);
require(dirname(__FILE__) . '/includes/init.php');
require_once(ROOT_PATH . 'includes/lib_goods.php');
require_once(ROOT_PATH . 'includes/lib_order.php');
include_once(ROOT_PATH . '/includes/cls_image.php');
$image = new cls_image($_CFG['bgcolor']);

/* 检查权限 */
admin_priv('seckill');

/* act操作项的初始化 */
if (empty($_REQUEST['act']))
{
    $_REQUEST['act'] = 'list';
}
else
{
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

/*------------------------------------------------------ */
//-- 秒杀活动列表
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'list')
{
    /* 模板赋值 */
    $smarty->assign('full_page',    1);
    $smarty->assign('ur_here',      $_LANG['seckill_list']);
    $smarty->assign('action_link',  array('href' => 'seckill.php?act=add', 'text' => $_LANG['add_seckill']));

    $list = seckill_list();
    $smarty->assign('seckill_list',   	$list['item']);
    $smarty->assign('filter',           $list['filter']);
    $smarty->assign('record_count',     $list['record_count']);
    $smarty->assign('page_count',       $list['page_count']);

    $sort_flag  = sort_flag($list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    /* 显示商品列表页面 */
    assign_query_info();
    $smarty->display('seckill_list.htm');
}

elseif ($_REQUEST['act'] == 'query')
{
    $list = seckill_list();

    $smarty->assign('seckill_list', $list['item']);
    $smarty->assign('filter',         $list['filter']);
    $smarty->assign('record_count',   $list['record_count']);
    $smarty->assign('page_count',     $list['page_count']);

    $sort_flag  = sort_flag($list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    make_json_result($smarty->fetch('seckill_list.htm'), '',
        array('filter' => $list['filter'], 'page_count' => $list['page_count']));
}

/*------------------------------------------------------ */
//-- 添加/编辑秒杀活动
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'add' || $_REQUEST['act'] == 'edit')
{
    include_once(ROOT_PATH . 'includes/fckeditor/fckeditor.php'); // 包含 html editor 类文件
    /* 初始化/取得秒杀活动信息 */
    if ($_REQUEST['act'] == 'add')
    {
        $seckill = array(
            'id'  		=> 0,
            'start_time'    => date('Y-m-d  h:i:s', time() + 86400),
            'end_time'      => date('Y-m-d  h:i:s', time() + 1.005 * 86400)
        );
        create_html_editor('seckill_content');
    }
    else
    {
        $seckill_id = intval($_REQUEST['id']);
        if ($seckill_id <= 0)
        {
            die('invalid param');
        }
        $seckill = seckill_info($seckill_id);
        create_html_editor('seckill_content',$seckill['seckill_content']);
    }
    $smarty->assign('seckill', $seckill);

    /* 模板赋值 */
    $smarty->assign('ur_here', $_LANG['add_seckill']);
    $smarty->assign('action_link', list_link($_REQUEST['act'] == 'add'));
    $smarty->assign('cat_list', cat_list());
    $smarty->assign('brand_list', get_brand_list());

    /* 显示模板 */
    assign_query_info();
    $smarty->display('seckill_info.htm');
}

/*------------------------------------------------------ */
//-- 添加/编辑秒杀活动的提交
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] =='insert_update')
{
    /* 取得秒杀活动id */
    $seckill_id = intval($_POST['seckill_id']);
    /* 保存秒杀信息 */
    $goods_id = intval($_POST['goods_id']);
    if ($goods_id <= 0)
    {
        sys_msg($_LANG['error_goods_null']);
    }

    $goods_name = $db->getOne("SELECT goods_name FROM " . $ecs->table('goods') . " WHERE goods_id = '$goods_id'");

    /* 检查开始时间和结束时间是否合理 */
    $start_time = local_strtotime($_POST['start_time']);
    $end_time = local_strtotime($_POST['end_time']);
    if ($start_time >= $end_time)
    {
        sys_msg($_LANG['invalid_time']);
    }
    //新增秒杀图片
    $seckill_img ='data/seckill_img/'.basename($image->upload_image($_FILES['seckill_img'],'seckill_img'));
    //验证图片是否存在
    if ($seckill_id > 0)
    {
        if($seckill_img=='data/seckill_img/')
        {
            $seckill_img=$db->getOne("SELECT seckill_img FROM " . $ecs->table('seckill') . " WHERE id = '$seckill_id'");
        }
        else
        {
            $seckill_img_old=$db->getOne("SELECT seckill_img FROM " . $ecs->table('seckill') . " WHERE id = '$seckill_id'");
            @unlink("../".$seckill_img_old);
        }
    }
    else
    {
        if($seckill_img=='data/seckill_img/')
        {
            sys_msg($_LANG['error_seckill_img']);
        }
    }

    $seckill = array(
        'seckill_img'   		=> $seckill_img,
        'number'   				=> $_POST['number'],
        'seckill_price'   		=> $_POST['seckill_price'],
        'goods_id'   			=> $goods_id,
        'goods_name' 			=> $goods_name,
        'start_time'    		=> $start_time,
        'end_time'      		=> $end_time,
        'seckill_content'      	=> $_POST['seckill_content'],
    );

    /* 清除缓存 */
    clear_cache_files();

    /* 保存数据 */
    if ($seckill_id > 0)
    {
        /* update */
        $db->autoExecute($ecs->table('seckill'), $seckill, 'UPDATE', "id = '$seckill_id'");

        /* log */
        admin_log(addslashes($goods_name) . '[' . $seckill_id . ']', 'edit', 'seckill');

        /* todo 更新活动表 */

        /* 提示信息 */
        $links = array(
            array('href' => 'seckill.php?act=list&' . list_link_postfix(), 'text' => $_LANG['back_list'])
        );
        sys_msg($_LANG['edit_success'], 0, $links);
    }
    else
    {
        /* insert */
        $db->autoExecute($ecs->table('seckill'), $seckill, 'INSERT');

        /* log */
        admin_log(addslashes($goods_name), 'add', 'seckill');

        /* 提示信息 */
        $links = array(
            array('href' => 'seckill.php?act=add', 'text' => $_LANG['continue_add']),
            array('href' => 'seckill.php?act=list', 'text' => $_LANG['back_list'])
        );
        sys_msg($_LANG['add_success'], 0, $links);
    }
}

/*------------------------------------------------------ */
//-- 批量删除秒杀活动
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'batch_drop')
{
    if (isset($_POST['checkboxes']))
    {
        $del_count = 0; //初始化删除数量
        foreach ($_POST['checkboxes'] AS $key => $id)
        {
            /* 取得秒杀活动信息 */
            $seckill = seckill_info($id);

            /* 如果秒杀活动已经有订单，不能删除 */
            if ($seckill['valid_order'] <= 0)
            {
                $seckill_img=$db->getOne("SELECT seckill_img FROM " . $ecs->table('seckill') . " WHERE id = '$id'");
                @unlink("../".$seckill_img);
                /* 删除秒杀活动 */
                $sql = "DELETE FROM " . $GLOBALS['ecs']->table('seckill') .
                    " WHERE id = '$id' LIMIT 1";
                $GLOBALS['db']->query($sql, 'SILENT');

                admin_log(addslashes($seckill['goods_name']) . '[' . $id . ']', 'remove', 'seckill');
                $del_count++;
            }
        }

        /* 如果删除了秒杀活动，清除缓存 */
        if ($del_count > 0)
        {
            clear_cache_files();
        }

        $links[] = array('text' => $_LANG['back_list'], 'href'=>'seckill.php?act=list');
        sys_msg(sprintf($_LANG['batch_drop_success'], $del_count), 0, $links);
    }
    else
    {
        $links[] = array('text' => $_LANG['back_list'], 'href'=>'seckill.php?act=list');
        sys_msg($_LANG['no_select_seckill'], 0, $links);
    }
}

/*------------------------------------------------------ */
//-- 搜索商品
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'search_goods')
{
    check_authz_json('seckill');

    include_once(ROOT_PATH . 'includes/cls_json.php');

    $json   = new JSON;
    $filter = $json->decode($_GET['JSON']);
    $arr    = get_goods_list($filter);

    make_json_result($arr);
}

/*------------------------------------------------------ */
//-- 删除秒杀活动
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'remove')
{
    check_authz_json('seckill');

    $id = intval($_GET['id']);

    /* 取得秒杀活动信息 */
    $seckill = seckill_info($id);

    /* 如果秒杀活动已经有订单，不能删除 */
    if ($seckill['valid_order'] > 0)
    {
        make_json_error($_LANG['error_exist_order']);
    }
    else
    {
        $seckill_img=$db->getOne("SELECT seckill_img FROM " . $ecs->table('seckill') . " WHERE id = '$id'");
        @unlink("../".$seckill_img);
    }
    /* 删除秒杀活动 */
    $sql = "DELETE FROM " . $ecs->table('seckill') . " WHERE id = '$id' LIMIT 1";
    $db->query($sql);

    admin_log(addslashes($seckill['goods_name']) . '[' . $id . ']', 'remove', 'seckill');

    clear_cache_files();

    $url = 'seckill.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);

    ecs_header("Location: $url\n");
    exit;
}

/*
 * 取得秒杀活动列表
 * @return   array
 */

function seckill_list()
{
    $result = get_filter();
    if ($result === false)
    {
        /* 过滤条件 */
        $filter['keyword']      = empty($_REQUEST['keyword']) ? '' : trim($_REQUEST['keyword']);
        if (isset($_REQUEST['is_ajax']) && $_REQUEST['is_ajax'] == 1)
        {
            $filter['keyword'] = json_str_iconv($filter['keyword']);
        }
        $filter['sort_by']      = empty($_REQUEST['sort_by']) ? 'id' : trim($_REQUEST['sort_by']);
        $filter['sort_order']   = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);

        $where = (!empty($filter['keyword'])) ? " WHERE goods_name LIKE '%" . mysql_like_quote($filter['keyword']) . "%'" : '';

        $sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('seckill') .
            " $where ";
        $filter['record_count'] = $GLOBALS['db']->getOne($sql);

        /* 分页大小 */
        $filter = page_and_size($filter);

        /* 查询 */
        $sql = "SELECT * ".
            "FROM " . $GLOBALS['ecs']->table('seckill') .
            " $where ".
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
        $stat = seckill_stat($row['id']);
        if(time()<$row['start_time'])
        {
            $arr['cur_status']  = "活动未开始";
        }
        else
        {
            if(time()>=$row['end_time'] || $stat['valid_order']>=$row['number'])
            {
                $arr['cur_status']  = "活动已结束";
            }
            else{
                $arr['cur_status']  = "活动进行中";
            }
        }
        $arr['start_time']  = local_date($GLOBALS['_CFG']['date_format'], $row['start_time']);
        $arr['end_time']  = local_date($GLOBALS['_CFG']['date_format'], $row['end_time']);
        $arr['goods_name']  = $row['goods_name'];
        $arr['id']  = $row['id'];
        $arr['number']  = $row['number'];
        $arr['seckill_price']  = $row['seckill_price'];
        $arr['valid_goods']  = $stat['valid_goods'];
        $arr['valid_order']  = $stat['valid_order'];
        $list[] = $arr;
    }
    $arr = array('item' => $list, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);

    return $arr;
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
    if(time()<$row['start_time'])
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
    $seckill['start_time'] = local_date('Y-m-d H:i:s', $seckill['start_time']);
    $seckill['end_time'] = local_date('Y-m-d H:i:s', $seckill['end_time']);

    return $seckill;
}

/**
 * 列表链接
 * @param   bool    $is_add         是否添加（插入）
 * @return  array('href' => $href, 'text' => $text)
 */
function list_link($is_add = true)
{
    $href = 'seckill.php?act=list';
    if (!$is_add)
    {
        $href .= '&' . list_link_postfix();
    }

    return array('href' => $href, 'text' => $GLOBALS['_LANG']['seckill_list']);
}

?>