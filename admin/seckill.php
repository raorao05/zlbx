<?php

/**
 * ECSHOP ����������ɱ��Ʒ����
 * ============================================================================
 * ��Ȩ���� 2005-2010 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.lqcms.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
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

/* ���Ȩ�� */
admin_priv('seckill');

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
//-- ��ɱ��б�
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'list')
{
    /* ģ�帳ֵ */
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

    /* ��ʾ��Ʒ�б�ҳ�� */
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
//-- ���/�༭��ɱ�
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'add' || $_REQUEST['act'] == 'edit')
{
    include_once(ROOT_PATH . 'includes/fckeditor/fckeditor.php'); // ���� html editor ���ļ�
    /* ��ʼ��/ȡ����ɱ���Ϣ */
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

    /* ģ�帳ֵ */
    $smarty->assign('ur_here', $_LANG['add_seckill']);
    $smarty->assign('action_link', list_link($_REQUEST['act'] == 'add'));
    $smarty->assign('cat_list', cat_list());
    $smarty->assign('brand_list', get_brand_list());

    /* ��ʾģ�� */
    assign_query_info();
    $smarty->display('seckill_info.htm');
}

/*------------------------------------------------------ */
//-- ���/�༭��ɱ����ύ
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] =='insert_update')
{
    /* ȡ����ɱ�id */
    $seckill_id = intval($_POST['seckill_id']);
    /* ������ɱ��Ϣ */
    $goods_id = intval($_POST['goods_id']);
    if ($goods_id <= 0)
    {
        sys_msg($_LANG['error_goods_null']);
    }

    $goods_name = $db->getOne("SELECT goods_name FROM " . $ecs->table('goods') . " WHERE goods_id = '$goods_id'");

    /* ��鿪ʼʱ��ͽ���ʱ���Ƿ���� */
    $start_time = local_strtotime($_POST['start_time']);
    $end_time = local_strtotime($_POST['end_time']);
    if ($start_time >= $end_time)
    {
        sys_msg($_LANG['invalid_time']);
    }
    //������ɱͼƬ
    $seckill_img ='data/seckill_img/'.basename($image->upload_image($_FILES['seckill_img'],'seckill_img'));
    //��֤ͼƬ�Ƿ����
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

    /* ������� */
    clear_cache_files();

    /* �������� */
    if ($seckill_id > 0)
    {
        /* update */
        $db->autoExecute($ecs->table('seckill'), $seckill, 'UPDATE', "id = '$seckill_id'");

        /* log */
        admin_log(addslashes($goods_name) . '[' . $seckill_id . ']', 'edit', 'seckill');

        /* todo ���»�� */

        /* ��ʾ��Ϣ */
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

        /* ��ʾ��Ϣ */
        $links = array(
            array('href' => 'seckill.php?act=add', 'text' => $_LANG['continue_add']),
            array('href' => 'seckill.php?act=list', 'text' => $_LANG['back_list'])
        );
        sys_msg($_LANG['add_success'], 0, $links);
    }
}

/*------------------------------------------------------ */
//-- ����ɾ����ɱ�
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'batch_drop')
{
    if (isset($_POST['checkboxes']))
    {
        $del_count = 0; //��ʼ��ɾ������
        foreach ($_POST['checkboxes'] AS $key => $id)
        {
            /* ȡ����ɱ���Ϣ */
            $seckill = seckill_info($id);

            /* �����ɱ��Ѿ��ж���������ɾ�� */
            if ($seckill['valid_order'] <= 0)
            {
                $seckill_img=$db->getOne("SELECT seckill_img FROM " . $ecs->table('seckill') . " WHERE id = '$id'");
                @unlink("../".$seckill_img);
                /* ɾ����ɱ� */
                $sql = "DELETE FROM " . $GLOBALS['ecs']->table('seckill') .
                    " WHERE id = '$id' LIMIT 1";
                $GLOBALS['db']->query($sql, 'SILENT');

                admin_log(addslashes($seckill['goods_name']) . '[' . $id . ']', 'remove', 'seckill');
                $del_count++;
            }
        }

        /* ���ɾ������ɱ���������� */
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
//-- ������Ʒ
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
//-- ɾ����ɱ�
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'remove')
{
    check_authz_json('seckill');

    $id = intval($_GET['id']);

    /* ȡ����ɱ���Ϣ */
    $seckill = seckill_info($id);

    /* �����ɱ��Ѿ��ж���������ɾ�� */
    if ($seckill['valid_order'] > 0)
    {
        make_json_error($_LANG['error_exist_order']);
    }
    else
    {
        $seckill_img=$db->getOne("SELECT seckill_img FROM " . $ecs->table('seckill') . " WHERE id = '$id'");
        @unlink("../".$seckill_img);
    }
    /* ɾ����ɱ� */
    $sql = "DELETE FROM " . $ecs->table('seckill') . " WHERE id = '$id' LIMIT 1";
    $db->query($sql);

    admin_log(addslashes($seckill['goods_name']) . '[' . $id . ']', 'remove', 'seckill');

    clear_cache_files();

    $url = 'seckill.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);

    ecs_header("Location: $url\n");
    exit;
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

        /* ��ҳ��С */
        $filter = page_and_size($filter);

        /* ��ѯ */
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
            $arr['cur_status']  = "�δ��ʼ";
        }
        else
        {
            if(time()>=$row['end_time'] || $stat['valid_order']>=$row['number'])
            {
                $arr['cur_status']  = "��ѽ���";
            }
            else{
                $arr['cur_status']  = "�������";
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
 * �б�����
 * @param   bool    $is_add         �Ƿ���ӣ����룩
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