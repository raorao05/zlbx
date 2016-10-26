<?php

/**
 * ECSHOP �ᱦ����������
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: snatch.php 17217 2011-01-19 06:29:08Z liubo $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
$exc = new exchange($ecs->table("goods_activity"), $db, 'act_id', 'act_name');

/*------------------------------------------------------ */
//-- ��ӻ
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'add')
{
    /* Ȩ���ж� */
    admin_priv('snatch_manage');

    /* ��ʼ����Ϣ */
    $start_time = local_date('Y-m-d H:i');
    $end_time   = local_date('Y-m-d H:i', strtotime('+1 week'));
    $snatch     = array('start_price'=>'1.00','end_price'=>'800.00','max_price'=>'0', 'cost_points'=>'1','start_time' => $start_time,'end_time' => $end_time,'option'=>'<option value="0">'.$_LANG['make_option'].'</option>');

    $smarty->assign('snatch',       $snatch);
    $smarty->assign('ur_here',      $_LANG['snatch_add']);
    $smarty->assign('action_link',  array('text' => $_LANG['02_snatch_list'], 'href'=>'snatch.php?act=list'));
    $smarty->assign('cat_list',     cat_list());
    $smarty->assign('brand_list',   get_brand_list());
    $smarty->assign('form_action',  'insert');

    assign_query_info();
    $smarty->display('snatch_info.htm');
}

elseif ($_REQUEST['act'] =='insert')
{
    /* Ȩ���ж� */
    admin_priv('snatch_manage');

    /* �����Ʒ�Ƿ���� */
    $sql = "SELECT goods_name FROM ".$ecs->table('goods')." WHERE goods_id = '$_POST[goods_id]'";
    $_POST['goods_name'] = $db->GetOne($sql);
    if (empty($_POST['goods_name']))
    {
        sys_msg($_LANG['no_goods'], 1);
        exit;
    }

    $sql = "SELECT COUNT(*) ".
           " FROM " . $ecs->table('goods_activity').
           " WHERE act_type='" . GAT_SNATCH . "' AND act_name='" . $_POST['snatch_name'] . "'" ;
    if ($db->getOne($sql))
    {
        sys_msg(sprintf($_LANG['snatch_name_exist'],  $_POST['snatch_name']) , 1);
    }

    /* ��ʱ��ת�������� */
    $_POST['start_time'] = local_strtotime($_POST['start_time']);
    $_POST['end_time']   = local_strtotime($_POST['end_time']);

    /* �����ύ���� */
    if (empty($_POST['start_price']))
    {
        $_POST['start_price'] = 0;
    }
    if (empty($_POST['end_price']))
    {
        $_POST['end_price'] = 0;
    }
    if (empty($_POST['max_price']))
    {
        $_POST['max_price'] = 0;
    }
    if (empty($_POST['cost_points']))
    {
        $_POST['cost_points'] = 0;
    }
    if (isset($_POST['product_id']) && empty($_POST['product_id']))
    {
        $_POST['product_id'] = 0;
    }

    $info = array('start_price'=>$_POST['start_price'], 'end_price'=>$_POST['end_price'], 'max_price'=>$_POST['max_price'], 'cost_points'=>$_POST['cost_points']);

    /* �������� */
    $record = array('act_name'=>$_POST['snatch_name'], 'act_desc'=>$_POST['desc'],
                    'act_type'=>GAT_SNATCH, 'goods_id'=>$_POST['goods_id'], 'goods_name'=>$_POST['goods_name'],
                    'start_time'=>$_POST['start_time'], 'end_time'=>$_POST['end_time'],
                    'product_id'=>$_POST['product_id'],
                    'is_finished'=>0, 'ext_info'=>serialize($info));

    $db->AutoExecute($ecs->table('goods_activity'),$record,'INSERT');

    admin_log($_POST['snatch_name'],'add','snatch');
    $link[] = array('text' => $_LANG['back_list'], 'href'=>'snatch.php?act=list');
    $link[] = array('text' => $_LANG['continue_add'], 'href'=>'snatch.php?act=add');
    sys_msg($_LANG['add_succeed'],0,$link);
}

/*------------------------------------------------------ */
//-- ��б�
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'list')
{
    $smarty->assign('ur_here',      $_LANG['02_snatch_list']);
    $smarty->assign('action_link',  array('text' => $_LANG['snatch_add'], 'href'=>'snatch.php?act=add'));

    $snatchs = get_snatchlist();

    $smarty->assign('snatch_list',  $snatchs['snatchs']);
    $smarty->assign('filter',       $snatchs['filter']);
    $smarty->assign('record_count', $snatchs['record_count']);
    $smarty->assign('page_count',   $snatchs['page_count']);

    $sort_flag  = sort_flag($snatchs['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    $smarty->assign('full_page',    1);
    assign_query_info();
    $smarty->display('snatch_list.htm');
}

/*------------------------------------------------------ */
//-- ��ѯ����ҳ������
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'query')
{
    $snatchs = get_snatchlist();

    $smarty->assign('snatch_list',  $snatchs['snatchs']);
    $smarty->assign('filter',       $snatchs['filter']);
    $smarty->assign('record_count', $snatchs['record_count']);
    $smarty->assign('page_count',   $snatchs['page_count']);

    $sort_flag  = sort_flag($snatchs['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    make_json_result($smarty->fetch('snatch_list.htm'), '',
        array('filter' => $snatchs['filter'], 'page_count' => $snatchs['page_count']));
}

/*------------------------------------------------------ */
//-- �༭�����
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'edit_snatch_name')
{
    check_authz_json('snatch_manage');

    $id = intval($_POST['id']);
    $val = json_str_iconv(trim($_POST['val']));

    /* ������� */
    $sql = "SELECT COUNT(*) ".
           " FROM " . $ecs->table('goods_activity').
           " WHERE act_type='" . GAT_SNATCH . "' AND act_name='$val' AND act_id <> '$id'" ;
    if ($db->getOne($sql))
    {
        make_json_error(sprintf($_LANG['snatch_name_exist'],  $val));
    }

    $exc->edit("act_name='$val'", $id);
    make_json_result(stripslashes($val));
}

/*------------------------------------------------------ */
//-- ɾ��ָ���Ļ
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'remove')
{
    check_authz_json('attr_manage');

    $id = intval($_GET['id']);

    $exc->drop($id);

    $url = 'snatch.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);

    ecs_header("Location: $url\n");
    exit;
}

/*------------------------------------------------------ */
//-- �༭�
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'edit')
{
    /* Ȩ���ж� */
    admin_priv('snatch_manage');

    $snatch        = get_snatch_info($_REQUEST['id']);

    $snatch['option'] = '<option value="'.$snatch['goods_id'].'">'.$snatch['goods_name'].'</option>';
    $smarty->assign('snatch',               $snatch);
    $smarty->assign('ur_here',              $_LANG['snatch_edit']);
    $smarty->assign('action_link',          array('text' => $_LANG['02_snatch_list'], 'href'=>'snatch.php?act=list&' . list_link_postfix()));
    $smarty->assign('form_action',        'update');

    /* ��Ʒ��Ʒ�� */
    $smarty->assign('good_products_select', get_good_products_select($snatch['goods_id']));

    assign_query_info();
    $smarty->display('snatch_info.htm');
}
elseif ($_REQUEST['act'] =='update')
{
    /* Ȩ���ж� */
    admin_priv('snatch_manage');

    /* ��ʱ��ת�������� */
    $_POST['start_time'] = local_strtotime($_POST['start_time']);
    $_POST['end_time']   = local_strtotime($_POST['end_time']);

    /* �����ύ���� */
    if (empty($_POST['snatch_name']))
    {
        $_POST['snatch_name'] = '';
    }
    if (empty($_POST['goods_id']))
    {
        $_POST['goods_id'] = 0;
    }
    else
    {
        $_POST['goods_name'] = $db->getOne("SELECT goods_name FROM " . $ecs->table('goods') . "WHERE goods_id= '$_POST[goods_id]'");
    }
    if (empty($_POST['start_price']))
    {
        $_POST['start_price'] = 0;
    }
    if (empty($_POST['end_price']))
    {
        $_POST['end_price'] = 0;
    }
    if (empty($_POST['max_price']))
    {
        $_POST['max_price'] = 0;
    }
    if (empty($_POST['cost_points']))
    {
        $_POST['cost_points'] = 0;
    }
    if (isset($_POST['product_id']) && empty($_POST['product_id']))
    {
        $_POST['product_id'] = 0;
    }

    /* ������� */
    $sql = "SELECT COUNT(*) ".
           " FROM " . $ecs->table('goods_activity').
           " WHERE act_type='" . GAT_SNATCH . "' AND act_name='" . $_POST['snatch_name'] . "' AND act_id <> '" .  $_POST['id'] . "'" ;
    if ($db->getOne($sql))
    {
        sys_msg(sprintf($_LANG['snatch_name_exist'],  $_POST['snatch_name']) , 1);
    }

    $info = array('start_price'=>$_POST['start_price'], 'end_price'=>$_POST['end_price'], 'max_price'=>$_POST['max_price'], 'cost_points'=>$_POST['cost_points']);

    /* �������� */
    $record = array('act_name' => $_POST['snatch_name'], 'goods_id' => $_POST['goods_id'],
                    'goods_name' =>$_POST['goods_name'], 'start_time' => $_POST['start_time'],
                    'end_time' => $_POST['end_time'], 'act_desc' => $_POST['desc'],
                    'product_id'=>$_POST['product_id'],
                    'ext_info'=>serialize($info));
    $db->autoExecute($ecs->table('goods_activity'), $record, 'UPDATE', "act_id = '" . $_POST['id'] . "' AND act_type = " . GAT_SNATCH );

    admin_log($_POST['snatch_name'],'edit','snatch');
    $link[] = array('text' => $_LANG['back_list'], 'href'=>'snatch.php?act=list&' . list_link_postfix());
    sys_msg($_LANG['edit_succeed'],0,$link);
 }

/*------------------------------------------------------ */
//-- �鿴�����
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'view')
{
    /* Ȩ���ж� */
    admin_priv('snatch_manage');

    $id = empty($_REQUEST['snatch_id']) ? 0 : intval($_REQUEST['snatch_id']);

    $bid_list = get_snatch_detail();

    $smarty->assign('bid_list',     $bid_list['bid']);
    $smarty->assign('filter',       $bid_list['filter']);
    $smarty->assign('record_count', $bid_list['record_count']);
    $smarty->assign('page_count',   $bid_list['page_count']);

    $sort_flag  = sort_flag($bid_list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);
    /* ��ֵ */
    $smarty->assign('info',         get_snatch_info($id));
    $smarty->assign('full_page',    1);
    $smarty->assign('result',       get_snatch_result($id));
    $smarty->assign('ur_here',      $_LANG['view_detail'] );
    $smarty->assign('action_link',  array('text' => $_LANG['02_snatch_list'], 'href'=>'snatch.php?act=list'));
    $smarty->display('snatch_view.htm');
}

/*------------------------------------------------------ */
//-- ���򡢷�ҳ�����
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'query_bid')
{
    $bid_list = get_snatch_detail();

    $smarty->assign('bid_list',     $bid_list['bid']);
    $smarty->assign('filter',       $bid_list['filter']);
    $smarty->assign('record_count', $bid_list['record_count']);
    $smarty->assign('page_count',   $bid_list['page_count']);

    $sort_flag  = sort_flag($bid_list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    make_json_result($smarty->fetch('snatch_view.htm'), '',
        array('filter' => $bid_list['filter'], 'page_count' => $bid_list['page_count']));
}

/*------------------------------------------------------ */
//-- ������Ʒ
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'search_goods')
{
    include_once(ROOT_PATH . 'includes/cls_json.php');
    $json = new JSON;

    $filters = $json->decode($_GET['JSON']);

    $arr['goods'] = get_goods_list($filters);

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

/**
 * ��ȡ��б�
 *
 * @access  public
 *
 * @return void
 */
function get_snatchlist()
{
    $result = get_filter();
    if ($result === false)
    {
        /* ��ѯ���� */
        $filter['keywords']   = empty($_REQUEST['keywords']) ? '' : trim($_REQUEST['keywords']);
        if (isset($_REQUEST['is_ajax']) && $_REQUEST['is_ajax'] == 1)
        {
            $filter['keywords'] = json_str_iconv($filter['keywords']);
        }
        $filter['sort_by']    = empty($_REQUEST['sort_by']) ? 'act_id' : trim($_REQUEST['sort_by']);
        $filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);

        $where = (!empty($filter['keywords'])) ? " AND act_name like '%". mysql_like_quote($filter['keywords']) ."%'" : '';

        $sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('goods_activity') .
               " WHERE act_type =" . GAT_SNATCH . $where;
        $filter['record_count'] = $GLOBALS['db']->getOne($sql);

        $filter = page_and_size($filter);

        /* ������ */
        $sql = "SELECT act_id, act_name AS snatch_name, goods_name, start_time, end_time, is_finished, ext_info, product_id ".
               " FROM " . $GLOBALS['ecs']->table('goods_activity') .
               " WHERE act_type = " . GAT_SNATCH . $where .
               " ORDER by $filter[sort_by] $filter[sort_order] LIMIT ". $filter['start'] .", " . $filter['page_size'];

        $filter['keywords'] = stripslashes($filter['keywords']);
        set_filter($filter, $sql);
    }
    else
    {
        $sql    = $result['sql'];
        $filter = $result['filter'];
    }

    $row = $GLOBALS['db']->getAll($sql);

    foreach ($row AS $key => $val)
    {
        $row[$key]['start_time'] = local_date($GLOBALS['_CFG']['time_format'], $val['start_time']);
        $row[$key]['end_time']   = local_date($GLOBALS['_CFG']['time_format'], $val['end_time']);
        $info = unserialize($row[$key]['ext_info']);
        unset($row[$key]['ext_info']);
        if ($info)
        {
            foreach ($info as $info_key => $info_val)
            {
                $row[$key][$info_key] = $info_val;
            }
        }
    }

    $arr = array('snatchs' => $row, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);

    return $arr;
}

/**
 * ��ȡָ��id snatch ����Ϣ
 *
 * @access  public
 * @param   int         $id         snatch_id
 *
 * @return array       array(snatch_id, snatch_name, goods_id,start_time, end_time, min_price, integral)
 */
function get_snatch_info($id)
{
    global $ecs, $db,$_CFG;

    $sql = "SELECT act_id, act_name AS snatch_name, goods_id, product_id, goods_name, start_time, end_time, act_desc, ext_info" .
           " FROM " . $GLOBALS['ecs']->table('goods_activity') .
           " WHERE act_id='$id' AND act_type = " . GAT_SNATCH;

    $snatch = $db->GetRow($sql);

    /* ��ʱ��ת�ɿ��Ķ���ʽ */
    $snatch['start_time'] = local_date('Y-m-d H:i', $snatch['start_time']);
    $snatch['end_time']   = local_date('Y-m-d H:i', $snatch['end_time']);
    $row = unserialize($snatch['ext_info']);
    unset($snatch['ext_info']);
    if ($row)
    {
        foreach ($row as $key=>$val)
        {
            $snatch[$key] = $val;
        }
    }

    return $snatch;
}

/**
 * ���ػ��ϸ�б�
 *
 * @access  public
 *
 * @return array
 */
function get_snatch_detail()
{
    $filter['snatch_id']  = empty($_REQUEST['snatch_id']) ? 0 : intval($_REQUEST['snatch_id']);
    $filter['sort_by']    = empty($_REQUEST['sort_by']) ? 'bid_time' : trim($_REQUEST['sort_by']);
    $filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);

    $where = empty($filter['snatch_id']) ? '' : " WHERE snatch_id='$filter[snatch_id]'";

    /* ��ü�¼�����Լ���ҳ�� */
    $sql = "SELECT count(*) FROM ".$GLOBALS['ecs']->table('snatch_log'). $where;
    $filter['record_count'] = $GLOBALS['db']->getOne($sql);

    $filter = page_and_size($filter);

    /* ��û���� */
    $sql = "SELECT s.log_id, u.user_name, s.bid_price, s.bid_time ".
            " FROM ".$GLOBALS['ecs']->table('snatch_log')." AS s ".
            " LEFT JOIN ".$GLOBALS['ecs']->table('users')." AS u ON s.user_id = u.user_id  ". $where.
            " ORDER by ".$filter['sort_by']." ".$filter['sort_order'].
            " LIMIT ". $filter['start'] .", " . $filter['page_size'];
    $row = $GLOBALS['db']->getAll($sql);

    foreach ($row AS $key => $val)
    {
        $row[$key]['bid_time'] = date($GLOBALS['_CFG']['time_format'], $val['bid_time']);
    }

    $arr = array('bid' => $row, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);

    return $arr;
}

?>