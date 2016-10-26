<?php

/**
 * ECSHOP ������͵Ĵ���
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: bonus.php 17217 2011-01-19 06:29:08Z liubo $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

/* act������ĳ�ʼ�� */
if (empty($_REQUEST['act']))
{
    $_REQUEST['act'] = 'list';
}
else
{
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

/* ��ʼ��$exc���� */
$exc = new exchange($ecs->table('bonus_type'), $db, 'type_id', 'type_name');

/*------------------------------------------------------ */
//-- ��������б�ҳ��
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'list')
{
    $smarty->assign('ur_here',     $_LANG['04_bonustype_list']);
    $smarty->assign('action_link', array('text' => $_LANG['bonustype_add'], 'href' => 'bonus.php?act=add'));
    $smarty->assign('full_page',   1);

    $list = get_type_list();

    $smarty->assign('type_list',    $list['item']);
    $smarty->assign('filter',       $list['filter']);
    $smarty->assign('record_count', $list['record_count']);
    $smarty->assign('page_count',   $list['page_count']);

    $sort_flag  = sort_flag($list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    assign_query_info();
    $smarty->display('bonus_type.htm');
}

/*------------------------------------------------------ */
//-- ��ҳ������
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'query')
{
    $list = get_type_list();

    $smarty->assign('type_list',    $list['item']);
    $smarty->assign('filter',       $list['filter']);
    $smarty->assign('record_count', $list['record_count']);
    $smarty->assign('page_count',   $list['page_count']);

    $sort_flag  = sort_flag($list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    make_json_result($smarty->fetch('bonus_type.htm'), '',
        array('filter' => $list['filter'], 'page_count' => $list['page_count']));
}

/*------------------------------------------------------ */
//-- �༭�����������
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'edit_type_name')
{
    check_authz_json('bonus_manage');

    $id = intval($_POST['id']);
    $val = json_str_iconv(trim($_POST['val']));

    /* ��������������Ƿ��ظ� */
    if (!$exc->is_only('type_name', $id, $val))
    {
        make_json_error($_LANG['type_name_exist']);
    }
    else
    {
        $exc->edit("type_name='$val'", $id);

        make_json_result(stripslashes($val));
    }
}

/*------------------------------------------------------ */
//-- �༭������
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'edit_type_money')
{
    check_authz_json('bonus_manage');

    $id = intval($_POST['id']);
    $val = floatval($_POST['val']);

    /* ��������������Ƿ��ظ� */
    if ($val <= 0)
    {
        make_json_error($_LANG['type_money_error']);
    }
    else
    {
        $exc->edit("type_money='$val'", $id);

        make_json_result(number_format($val, 2));
    }
}

/*------------------------------------------------------ */
//-- �༭��������
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'edit_min_amount')
{
    check_authz_json('bonus_manage');

    $id = intval($_POST['id']);
    $val = floatval($_POST['val']);

    if ($val < 0)
    {
        make_json_error($_LANG['min_amount_empty']);
    }
    else
    {
        $exc->edit("min_amount='$val'", $id);

        make_json_result(number_format($val, 2));
    }
}

/*------------------------------------------------------ */
//-- ɾ���������
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'remove')
{
    check_authz_json('bonus_manage');

    $id = intval($_GET['id']);

    $exc->drop($id);

    /* ������Ʒ��Ϣ */
    $db->query("UPDATE " .$ecs->table('goods'). " SET bonus_type_id = 0 WHERE bonus_type_id = '$id'");

    /* ɾ���û��ĺ�� */
    $db->query("DELETE FROM " .$ecs->table('user_bonus'). " WHERE bonus_type_id = '$id'");

    $url = 'bonus.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);

    ecs_header("Location: $url\n");
    exit;
}

/*------------------------------------------------------ */
//-- ����������ҳ��
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'add')
{
    admin_priv('bonus_manage');

    $smarty->assign('lang',         $_LANG);
    $smarty->assign('ur_here',      $_LANG['bonustype_add']);
    $smarty->assign('action_link',  array('href' => 'bonus.php?act=list', 'text' => $_LANG['04_bonustype_list']));
    $smarty->assign('action',       'add');

    $smarty->assign('form_act',     'insert');
    $smarty->assign('cfg_lang',     $_CFG['lang']);

    $next_month = local_strtotime('+1 months');
    $bonus_arr['send_start_date']   = local_date('Y-m-d');
    $bonus_arr['use_start_date']    = local_date('Y-m-d');
    $bonus_arr['send_end_date']     = local_date('Y-m-d', $next_month);
    $bonus_arr['use_end_date']      = local_date('Y-m-d', $next_month);

    $smarty->assign('bonus_arr',    $bonus_arr);

    assign_query_info();
    $smarty->display('bonus_type_info.htm');
}

/*------------------------------------------------------ */
//-- ���������ӵĴ���
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'insert')
{
    /* ȥ�������������ǰ��Ŀո� */
    $type_name   = !empty($_POST['type_name']) ? trim($_POST['type_name']) : '';

    /* ��ʼ������ */
    $type_id     = !empty($_POST['type_id'])    ? intval($_POST['type_id'])    : 0;
    $min_amount  = !empty($_POST['min_amount']) ? intval($_POST['min_amount']) : 0;

    /* ��������Ƿ����ظ� */
    $sql = "SELECT COUNT(*) FROM " .$ecs->table('bonus_type'). " WHERE type_name='$type_name'";
    if ($db->getOne($sql) > 0)
    {
        $link[] = array('text' => $_LANG['go_back'], 'href' => 'javascript:history.back(-1)');
        sys_msg($_LANG['type_name_exist'], 0, $link);
    }

    /* ���������Ϣ */
    $send_startdate = local_strtotime($_POST['send_start_date']);
    $send_enddate   = local_strtotime($_POST['send_end_date']);
    $use_startdate  = local_strtotime($_POST['use_start_date']);
    $use_enddate    = local_strtotime($_POST['use_end_date']);

    /* �������ݿ⡣ */
    $sql = "INSERT INTO ".$ecs->table('bonus_type')." (type_name, type_money,send_start_date,send_end_date,use_start_date,use_end_date,send_type,min_amount,min_goods_amount)
    VALUES ('$type_name',
            '$_POST[type_money]',
            '$send_startdate',
            '$send_enddate',
            '$use_startdate',
            '$use_enddate',
            '$_POST[send_type]',
            '$min_amount','" . floatval($_POST['min_goods_amount']) . "')";

    $db->query($sql);
    /* ��¼����Ա���� */
    admin_log($_POST['type_name'], 'add', 'bonustype');

    /* ������� */
    clear_cache_files();

    /* ��ʾ��Ϣ */
    $link[0]['text'] = $_LANG['continus_add'];
    $link[0]['href'] = 'bonus.php?act=add';

    $link[1]['text'] = $_LANG['back_list'];
    $link[1]['href'] = 'bonus.php?act=list';

    sys_msg($_LANG['add'] . "&nbsp;" .$_POST['type_name'] . "&nbsp;" . $_LANG['attradd_succed'],0, $link);

}

/*------------------------------------------------------ */
//-- ������ͱ༭ҳ��
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'edit')
{
    admin_priv('bonus_manage');

    /* ��ȡ����������� */
    $type_id = !empty($_GET['type_id']) ? intval($_GET['type_id']) : 0;
    $bonus_arr = $db->getRow("SELECT * FROM " .$ecs->table('bonus_type'). " WHERE type_id = '$type_id'");

    $bonus_arr['send_start_date']   = local_date('Y-m-d', $bonus_arr['send_start_date']);
    $bonus_arr['send_end_date']     = local_date('Y-m-d', $bonus_arr['send_end_date']);
    $bonus_arr['use_start_date']    = local_date('Y-m-d', $bonus_arr['use_start_date']);
    $bonus_arr['use_end_date']      = local_date('Y-m-d', $bonus_arr['use_end_date']);

    $smarty->assign('lang',        $_LANG);
    $smarty->assign('ur_here',     $_LANG['bonustype_edit']);
    $smarty->assign('action_link', array('href' => 'bonus.php?act=list&' . list_link_postfix(), 'text' => $_LANG['04_bonustype_list']));
    $smarty->assign('form_act',    'update');
    $smarty->assign('bonus_arr',   $bonus_arr);

    assign_query_info();
    $smarty->display('bonus_type_info.htm');
}

/*------------------------------------------------------ */
//-- ������ͱ༭�Ĵ���
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'update')
{
    /* ���������Ϣ */
    $send_startdate = local_strtotime($_POST['send_start_date']);
    $send_enddate   = local_strtotime($_POST['send_end_date']);
    $use_startdate  = local_strtotime($_POST['use_start_date']);
    $use_enddate    = local_strtotime($_POST['use_end_date']);

    /* �����ݵĴ��� */
    $type_name   = !empty($_POST['type_name'])  ? trim($_POST['type_name'])    : '';
    $type_id     = !empty($_POST['type_id'])    ? intval($_POST['type_id'])    : 0;
    $min_amount  = !empty($_POST['min_amount']) ? intval($_POST['min_amount']) : 0;

    $sql = "UPDATE " .$ecs->table('bonus_type'). " SET ".
           "type_name       = '$type_name', ".
           "type_money      = '$_POST[type_money]', ".
           "send_start_date = '$send_startdate', ".
           "send_end_date   = '$send_enddate', ".
           "use_start_date  = '$use_startdate', ".
           "use_end_date    = '$use_enddate', ".
           "send_type       = '$_POST[send_type]', ".
           "min_amount      = '$min_amount', " .
           "min_goods_amount = '" . floatval($_POST['min_goods_amount']) . "' ".
           "WHERE type_id   = '$type_id'";

   $db->query($sql);
   /* ��¼����Ա���� */
   admin_log($_POST['type_name'], 'edit', 'bonustype');

   /* ������� */
   clear_cache_files();

   /* ��ʾ��Ϣ */
   $link[] = array('text' => $_LANG['back_list'], 'href' => 'bonus.php?act=list&' . list_link_postfix());
   sys_msg($_LANG['edit'] .' '.$_POST['type_name'].' '. $_LANG['attradd_succed'], 0, $link);

}

/*------------------------------------------------------ */
//-- �������ҳ��
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'send')
{
    admin_priv('bonus_manage');

    /* ȡ�ò��� */
    $id = !empty($_REQUEST['id'])  ? intval($_REQUEST['id'])  : '';

    assign_query_info();

    $smarty->assign('ur_here',      $_LANG['send_bonus']);
    $smarty->assign('action_link',  array('href' => 'bonus.php?act=list', 'text' => $_LANG['04_bonustype_list']));

    if ($_REQUEST['send_by'] == SEND_BY_USER)
    {
        $smarty->assign('id',           $id);
        $smarty->assign('ranklist',     get_rank_list());

        $smarty->display('bonus_by_user.htm');
    }
    elseif ($_REQUEST['send_by'] == SEND_BY_GOODS)
    {
        /* ��ѯ�˺��������Ϣ */
        $bonus_type = $db->GetRow("SELECT type_id, type_name FROM ".$ecs->table('bonus_type').
            " WHERE type_id='$_REQUEST[id]'");

        /* ��ѯ������͵���Ʒ�б� */
        $goods_list = get_bonus_goods($_REQUEST['id']);

        /* ��ѯ����������͵���Ʒ */
        $sql = "SELECT goods_id FROM " .$ecs->table('goods').
               " WHERE bonus_type_id > 0 AND bonus_type_id <> '$_REQUEST[id]'";
        $other_goods_list = $db->getCol($sql);
        $smarty->assign('other_goods', join(',', $other_goods_list));

        /* ģ�帳ֵ */
        $smarty->assign('cat_list',    cat_list());
        $smarty->assign('brand_list',  get_brand_list());

        $smarty->assign('bonus_type',  $bonus_type);
        $smarty->assign('goods_list',  $goods_list);

        $smarty->display('bonus_by_goods.htm');
    }
    elseif ($_REQUEST['send_by'] == SEND_BY_PRINT)
    {
        $smarty->assign('type_list',    get_bonus_type());

        $smarty->display('bonus_by_print.htm');
    }
}

/*------------------------------------------------------ */
//-- �������ķ���ҳ��
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'send_by_user')
{
    $user_list  = array();
    $start      = empty($_REQUEST['start']) ? 0 : intval($_REQUEST['start']);
    $limit      = empty($_REQUEST['limit']) ? 10 : intval($_REQUEST['limit']);
    $validated_email = empty($_REQUEST['validated_email']) ? 0 : intval($_REQUEST['validated_email']);
    $send_count = 0;

    if (isset($_REQUEST['send_rank']))
    {
        /* ����Ա�ȼ������ź�� */
        $rank_id = intval($_REQUEST['rank_id']);

        if ($rank_id > 0)
        {
            $sql = "SELECT min_points, max_points, special_rank FROM " . $ecs->table('user_rank') . " WHERE rank_id = '$rank_id'";
            $row = $db->getRow($sql);
            if ($row['special_rank'])
            {
                /* �����Ա�鴦�� */
                $sql = 'SELECT COUNT(*) FROM ' . $ecs->table('users'). " WHERE user_rank = '$rank_id'";
                $send_count = $db->getOne($sql);
                if($validated_email)
                {
                    $sql = 'SELECT user_id, email, user_name FROM ' . $ecs->table('users').
                            " WHERE user_rank = '$rank_id' AND is_validated = 1".
                            " LIMIT $start, $limit";
                }
                else
                {
                     $sql = 'SELECT user_id, email, user_name FROM ' . $ecs->table('users').
                                " WHERE user_rank = '$rank_id'".
                                " LIMIT $start, $limit";
                }
            }
            else
            {
                $sql = 'SELECT COUNT(*) FROM ' . $ecs->table('users').
                       " WHERE rank_points >= " . intval($row['min_points']) . " AND rank_points < " . intval($row['max_points']);
                $send_count = $db->getOne($sql);

                if($validated_email)
                {
                    $sql = 'SELECT user_id, email, user_name FROM ' . $ecs->table('users').
                        " WHERE rank_points >= " . intval($row['min_points']) . " AND rank_points < " . intval($row['max_points']) .
                        " AND is_validated = 1 LIMIT $start, $limit";
                }
                else
                {
                     $sql = 'SELECT user_id, email, user_name FROM ' . $ecs->table('users').
                        " WHERE rank_points >= " . intval($row['min_points']) . " AND rank_points < " . intval($row['max_points']) .
                        " LIMIT $start, $limit";
                }

            }

            $user_list = $db->getAll($sql);
            $count = count($user_list);
        }
    }
    elseif (isset($_REQUEST['send_user']))
    {
        /* ����Ա�б��ź�� */
        /* ����ǿ����飬ֱ�ӷ��� */
        if (empty($_REQUEST['user']))
        {
            sys_msg($_LANG['send_user_empty'], 1);
        }

        $user_array = (is_array($_REQUEST['user'])) ? $_REQUEST['user'] : explode(',', $_REQUEST['user']);
        $send_count = count($user_array);

        $id_array   = array_slice($user_array, $start, $limit);

        /* ���ݻ�ԱIDȡ���û������ʼ���ַ */
        $sql = "SELECT user_id, email, user_name FROM " .$ecs->table('users').
               " WHERE user_id " .db_create_in($id_array);
        $user_list  = $db->getAll($sql);
        $count = count($user_list);
    }

    /* ���ͺ�� */
    $loop       = 0;
    $bonus_type = bonus_type_info($_REQUEST['id']);

    $tpl = get_mail_template('send_bonus');
    $today = local_date($_CFG['date_format']);

    foreach ($user_list AS $key => $val)
    {
        /* �����ʼ�֪ͨ */
        $smarty->assign('user_name',    $val['user_name']);
        $smarty->assign('shop_name',    $GLOBALS['_CFG']['shop_name']);
        $smarty->assign('send_date',    $today);
        $smarty->assign('sent_date',    $today);
        $smarty->assign('count',        1);
        $smarty->assign('money',        price_format($bonus_type['type_money']));

        $content = $smarty->fetch('str:' . $tpl['template_content']);

        if (add_to_maillist($val['user_name'], $val['email'], $tpl['template_subject'], $content, $tpl['is_html']))
        {
             /* ���Ա�����¼������ */
            $sql = "INSERT INTO " . $ecs->table('user_bonus') .
                    "(bonus_type_id, bonus_sn, user_id, used_time, order_id, emailed) " .
                    "VALUES ('$_REQUEST[id]', 0, '$val[user_id]', 0, 0, " .BONUS_MAIL_SUCCEED. ")";
            $db->query($sql);
        }
        else
        {
            /* �ʼ�����ʧ�ܣ��������ݿ� */
            $sql = "INSERT INTO " . $ecs->table('user_bonus') .
                    "(bonus_type_id, bonus_sn, user_id, used_time, order_id, emailed) " .
                    "VALUES ('$_REQUEST[id]', 0, '$val[user_id]', 0, 0, " .BONUS_MAIL_FAIL. ")";
            $db->query($sql);
        }

        if ($loop >= $limit)
        {
            break;
        }
        else
        {
            $loop++;
        }
    }

    //admin_log(addslashes($_LANG['send_bonus']), 'add', 'bonustype');
    if ($send_count > ($start + $limit))
    {
        /*  */
        $href = "bonus.php?act=send_by_user&start=" . ($start+$limit) . "&limit=$limit&id=$_REQUEST[id]&";

        if (isset($_REQUEST['send_rank']))
        {
            $href .= "send_rank=1&rank_id=$rank_id";
        }

        if (isset($_REQUEST['send_user']))
        {
            $href .= "send_user=1&user=" . implode(',', $user_array);
        }

        $link[] = array('text' => $_LANG['send_continue'], 'href' => $href);
    }

    $link[] = array('text' => $_LANG['back_list'], 'href' => 'bonus.php?act=list');

    sys_msg(sprintf($_LANG['sendbonus_count'], $count), 0, $link);
}

/*------------------------------------------------------ */
//-- �����ʼ�
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'send_mail')
{
    /* ȡ�ò��������id */
    $bonus_id = intval($_REQUEST['bonus_id']);
    if ($bonus_id <= 0)
    {
        die('invalid params');
    }

    /* ȡ�ú����Ϣ */
    include_once(ROOT_PATH . 'includes/lib_order.php');
    $bonus = bonus_info($bonus_id);
    if (empty($bonus))
    {
        sys_msg($_LANG['bonus_not_exist']);
    }

    /* ���ʼ� */
    $count = send_bonus_mail($bonus['bonus_type_id'], array($bonus_id));

    $link[0]['text'] = $_LANG['back_bonus_list'];
    $link[0]['href'] = 'bonus.php?act=bonus_list&bonus_type=' . $bonus['bonus_type_id'];

    sys_msg(sprintf($_LANG['success_send_mail'], $count), 0, $link);
}

/*------------------------------------------------------ */
//-- ��ӡˢƷ���ź��
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'send_by_print')
{
    @set_time_limit(0);

    /* ���º��������ID�����ɵ������Ĵ��� */
    $bonus_typeid = !empty($_POST['bonus_type_id']) ? $_POST['bonus_type_id'] : 0;
    $bonus_sum    = !empty($_POST['bonus_sum'])     ? $_POST['bonus_sum']     : 1;

    /* ���ɺ�����к� */
    $num = $db->getOne("SELECT MAX(bonus_sn) FROM ". $ecs->table('user_bonus'));
    $num = $num ? floor($num / 10000) : 100000;

    for ($i = 0, $j = 0; $i < $bonus_sum; $i++)
    {
        $bonus_sn = ($num + $i) . str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
        $db->query("INSERT INTO ".$ecs->table('user_bonus')." (bonus_type_id, bonus_sn) VALUES('$bonus_typeid', '$bonus_sn')");

        $j++;
    }

    /* ��¼����Ա���� */
    admin_log($bonus_sn, 'add', 'userbonus');

    /* ������� */
    clear_cache_files();

    /* ��ʾ��Ϣ */
    $link[0]['text'] = $_LANG['back_bonus_list'];
    $link[0]['href'] = 'bonus.php?act=bonus_list&bonus_type=' . $bonus_typeid;

    sys_msg($_LANG['creat_bonus'] . $j . $_LANG['creat_bonus_num'], 0, $link);
}

/*------------------------------------------------------ */
//-- �������·��ŵ���Ϣ
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'gen_excel')
{
    @set_time_limit(0);

    /* ��ô����º�����͵�ID */
    $tid  = !empty($_GET['tid']) ? intval($_GET['tid']) : 0;
    $type_name = $db->getOne("SELECT type_name FROM ".$ecs->table('bonus_type')." WHERE type_id = '$tid'");

    /* �ļ����� */
    $bonus_filename = $type_name .'_bonus_list';
    if (EC_CHARSET != 'gbk')
    {
        $bonus_filename = ecs_iconv('UTF8', 'GB2312',$bonus_filename);
    }

    header("Content-type: application/vnd.ms-excel; charset=GB2312");
    header("Content-Disposition: attachment; filename=$bonus_filename.xls");

    /* �ļ����� */
    if (EC_CHARSET != 'gbk')
    {
        echo ecs_iconv('UTF8', 'GB2312', $_LANG['bonus_excel_file']) . "\t\n";
        /* ������к�, ������, ��������(�������), ʹ�ý������� */
        echo ecs_iconv('UTF8', 'GB2312', $_LANG['bonus_sn']) ."\t";
        echo ecs_iconv('UTF8', 'GB2312', $_LANG['type_money']) ."\t";
        echo ecs_iconv('UTF8', 'GB2312', $_LANG['type_name']) ."\t";
        echo ecs_iconv('UTF8', 'GB2312', $_LANG['use_enddate']) ."\t\n";
    }
    else
    {
        echo $_LANG['bonus_excel_file'] . "\t\n";
        /* ������к�, ������, ��������(�������), ʹ�ý������� */
        echo $_LANG['bonus_sn'] ."\t";
        echo $_LANG['type_money'] ."\t";
        echo $_LANG['type_name'] ."\t";
        echo $_LANG['use_enddate'] ."\t\n";
    }

    $val = array();
    $sql = "SELECT ub.bonus_id, ub.bonus_type_id, ub.bonus_sn, bt.type_name, bt.type_money, bt.use_end_date ".
           "FROM ".$ecs->table('user_bonus')." AS ub, ".$ecs->table('bonus_type')." AS bt ".
           "WHERE bt.type_id = ub.bonus_type_id AND ub.bonus_type_id = '$tid' ORDER BY ub.bonus_id DESC";
    $res = $db->query($sql);

    $code_table = array();
    while ($val = $db->fetchRow($res))
    {
        echo $val['bonus_sn'] . "\t";
        echo $val['type_money'] . "\t";
        if (!isset($code_table[$val['type_name']]))
        {
            if (EC_CHARSET != 'gbk')
            {
                $code_table[$val['type_name']] = ecs_iconv('UTF8', 'GB2312', $val['type_name']);
            }
            else
            {
                $code_table[$val['type_name']] = $val['type_name'];
            }
        }
        echo $code_table[$val['type_name']] . "\t";
        echo local_date('Y-m-d', $val['use_end_date']);
        echo "\t\n";
    }
}

/*------------------------------------------------------ */
//-- ������Ʒ
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'get_goods_list')
{
    include_once(ROOT_PATH . 'includes/cls_json.php');
    $json = new JSON;

    $filters = $json->decode($_GET['JSON']);

    $arr = get_goods_list($filters);
    $opt = array();

    foreach ($arr AS $key => $val)
    {
        $opt[] = array('value'  => $val['goods_id'],
                        'text'  => $val['goods_name'],
                        'data'  => $val['shop_price']);
    }

    make_json_result($opt);
}

/*------------------------------------------------------ */
//-- ��ӷ��ź������Ʒ
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'add_bonus_goods')
{
    include_once(ROOT_PATH . 'includes/cls_json.php');
    $json = new JSON;

    check_authz_json('bonus_manage');

    $add_ids    = $json->decode($_GET['add_ids']);
    $args       = $json->decode($_GET['JSON']);
    $type_id    = $args[0];

    foreach ($add_ids AS $key => $val)
    {
        $sql = "UPDATE " .$ecs->table('goods'). " SET bonus_type_id='$type_id' WHERE goods_id='$val'";
        $db->query($sql, 'SILENT') or make_json_error($db->error());
    }

    /* �������� */
    $arr = get_bonus_goods($type_id);
    $opt = array();

    foreach ($arr AS $key => $val)
    {
        $opt[] = array('value'  => $val['goods_id'],
                        'text'  => $val['goods_name'],
                        'data'  => '');
    }

    make_json_result($opt);
}

/*------------------------------------------------------ */
//-- ɾ�����ź������Ʒ
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'drop_bonus_goods')
{
    include_once(ROOT_PATH . 'includes/cls_json.php');
    $json = new JSON;

    check_authz_json('bonus_manage');

    $drop_goods     = $json->decode($_GET['drop_ids']);
    $drop_goods_ids = db_create_in($drop_goods);
    $arguments      = $json->decode($_GET['JSON']);
    $type_id        = $arguments[0];

    $db->query("UPDATE ".$ecs->table('goods')." SET bonus_type_id = 0 ".
                "WHERE bonus_type_id = '$type_id' AND goods_id " .$drop_goods_ids);

    /* �������� */
    $arr = get_bonus_goods($type_id);
    $opt = array();

    foreach ($arr AS $key => $val)
    {
        $opt[] = array('value'  => $val['goods_id'],
                        'text'  => $val['goods_name'],
                        'data'  => '');
    }

    make_json_result($opt);
}

/*------------------------------------------------------ */
//-- �����û�
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'search_users')
{
    $keywords = json_str_iconv(trim($_GET['keywords']));

    $sql = "SELECT user_id, user_name FROM " . $ecs->table('users') .
            " WHERE user_name LIKE '%" . mysql_like_quote($keywords) . "%' OR user_id LIKE '%" . mysql_like_quote($keywords) . "%'";
    $row = $db->getAll($sql);

    make_json_result($row);
}

/*------------------------------------------------------ */
//-- ����б�
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'bonus_list')
{
    $smarty->assign('full_page',    1);
    $smarty->assign('ur_here',      $_LANG['bonus_list']);
    $smarty->assign('action_link',   array('href' => 'bonus.php?act=list', 'text' => $_LANG['04_bonustype_list']));

    $list = get_bonus_list();

    /* ��ֵ�Ƿ���ʾ������к� */
    $bonus_type = bonus_type_info(intval($_REQUEST['bonus_type']));
    if ($bonus_type['send_type'] == SEND_BY_PRINT)
    {
        $smarty->assign('show_bonus_sn', 1);
    }

    /* ��ֵ�Ƿ���ʾ���ʼ��������Ƿ񷢹��ʼ� */
    elseif ($bonus_type['send_type'] == SEND_BY_USER)
    {
        $smarty->assign('show_mail', 1);
    }

    $smarty->assign('bonus_list',   $list['item']);
    $smarty->assign('filter',       $list['filter']);
    $smarty->assign('record_count', $list['record_count']);
    $smarty->assign('page_count',   $list['page_count']);

    $sort_flag  = sort_flag($list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    assign_query_info();
    $smarty->display('bonus_list.htm');
}

/*------------------------------------------------------ */
//-- ����б�ҳ������
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'query_bonus')
{
    $list = get_bonus_list();

    /* ��ֵ�Ƿ���ʾ������к� */
    $bonus_type = bonus_type_info(intval($_REQUEST['bonus_type']));
    if ($bonus_type['send_type'] == SEND_BY_PRINT)
    {
        $smarty->assign('show_bonus_sn', 1);
    }

    /* ��ֵ�Ƿ���ʾ���ʼ��������Ƿ񷢹��ʼ� */
    elseif ($bonus_type['send_type'] == SEND_BY_USER)
    {
        $smarty->assign('show_mail', 1);
    }

    $smarty->assign('bonus_list',   $list['item']);
    $smarty->assign('filter',       $list['filter']);
    $smarty->assign('record_count', $list['record_count']);
    $smarty->assign('page_count',   $list['page_count']);

    $sort_flag  = sort_flag($list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    make_json_result($smarty->fetch('bonus_list.htm'), '',
        array('filter' => $list['filter'], 'page_count' => $list['page_count']));
}

/*------------------------------------------------------ */
//-- ɾ�����
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'remove_bonus')
{
    check_authz_json('bonus_manage');

    $id = intval($_GET['id']);

    $db->query("DELETE FROM " .$ecs->table('user_bonus'). " WHERE bonus_id='$id'");

    $url = 'bonus.php?act=query_bonus&' . str_replace('act=remove_bonus', '', $_SERVER['QUERY_STRING']);

    ecs_header("Location: $url\n");
    exit;
}

/*------------------------------------------------------ */
//-- ��������
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'batch')
{
    /* ���Ȩ�� */
    admin_priv('bonus_manage');

    /* ȥ��������������� */
    $bonus_type_id = intval($_REQUEST['bonus_type']);

    /* ȡ��ѡ�еĺ��id */
    if (isset($_POST['checkboxes']))
    {
        $bonus_id_list = $_POST['checkboxes'];

        /* ɾ����� */
        if (isset($_POST['drop']))
        {
            $sql = "DELETE FROM " . $ecs->table('user_bonus'). " WHERE bonus_id " . db_create_in($bonus_id_list);
            $db->query($sql);

            admin_log(count($bonus_id_list), 'remove', 'userbonus');

            clear_cache_files();

            $link[] = array('text' => $_LANG['back_bonus_list'],
                'href' => 'bonus.php?act=bonus_list&bonus_type='. $bonus_type_id);
            sys_msg(sprintf($_LANG['batch_drop_success'], count($bonus_id_list)), 0, $link);
        }

        /* ���ʼ� */
        elseif (isset($_POST['mail']))
        {
            $count = send_bonus_mail($bonus_type_id, $bonus_id_list);
            $link[] = array('text' => $_LANG['back_bonus_list'],
                'href' => 'bonus.php?act=bonus_list&bonus_type='. $bonus_type_id);
            sys_msg(sprintf($_LANG['success_send_mail'], $count), 0, $link);
        }
    }
    else
    {
        sys_msg($_LANG['no_select_bonus'], 1);
    }
}

/**
 * ��ȡ��������б�
 * @access  public
 * @return void
 */
function get_type_list()
{
    /* ������к�����͵ķ������� */
    $sql = "SELECT bonus_type_id, COUNT(*) AS sent_count".
            " FROM " .$GLOBALS['ecs']->table('user_bonus') .
            " GROUP BY bonus_type_id";
    $res = $GLOBALS['db']->query($sql);

    $sent_arr = array();
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        $sent_arr[$row['bonus_type_id']] = $row['sent_count'];
    }

    /* ������к�����͵ķ������� */
    $sql = "SELECT bonus_type_id, COUNT(*) AS used_count".
            " FROM " .$GLOBALS['ecs']->table('user_bonus') .
            " WHERE used_time > 0".
            " GROUP BY bonus_type_id";
    $res = $GLOBALS['db']->query($sql);

    $used_arr = array();
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        $used_arr[$row['bonus_type_id']] = $row['used_count'];
    }

    $result = get_filter();
    if ($result === false)
    {
        /* ��ѯ���� */
        $filter['sort_by']    = empty($_REQUEST['sort_by']) ? 'type_id' : trim($_REQUEST['sort_by']);
        $filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);

        $sql = "SELECT COUNT(*) FROM ".$GLOBALS['ecs']->table('bonus_type');
        $filter['record_count'] = $GLOBALS['db']->getOne($sql);

        /* ��ҳ��С */
        $filter = page_and_size($filter);

        $sql = "SELECT * FROM " .$GLOBALS['ecs']->table('bonus_type'). " ORDER BY $filter[sort_by] $filter[sort_order]";

        set_filter($filter, $sql);
    }
    else
    {
        $sql    = $result['sql'];
        $filter = $result['filter'];
    }
    $arr = array();
    $res = $GLOBALS['db']->selectLimit($sql, $filter['page_size'], $filter['start']);

    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        $row['send_by'] = $GLOBALS['_LANG']['send_by'][$row['send_type']];
        $row['send_count'] = isset($sent_arr[$row['type_id']]) ? $sent_arr[$row['type_id']] : 0;
        $row['use_count'] = isset($used_arr[$row['type_id']]) ? $used_arr[$row['type_id']] : 0;

        $arr[] = $row;
    }

    $arr = array('item' => $arr, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);

    return $arr;
}

/**
 * ��ѯ������͵���Ʒ�б�
 *
 * @access  public
 * @param   integer $type_id
 * @return  array
 */
function get_bonus_goods($type_id)
{
    $sql = "SELECT goods_id, goods_name FROM " .$GLOBALS['ecs']->table('goods').
            " WHERE bonus_type_id = '$type_id'";
    $row = $GLOBALS['db']->getAll($sql);

    return $row;
}

/**
 * ��ȡ�û�����б�
 * @access  public
 * @param   $page_param
 * @return void
 */
function get_bonus_list()
{
    /* ��ѯ���� */
    $filter['sort_by']    = empty($_REQUEST['sort_by']) ? 'bonus_type_id' : trim($_REQUEST['sort_by']);
    $filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);
    $filter['bonus_type'] = empty($_REQUEST['bonus_type']) ? 0 : intval($_REQUEST['bonus_type']);

    $where = empty($filter['bonus_type']) ? '' : " WHERE bonus_type_id='$filter[bonus_type]'";

    $sql = "SELECT COUNT(*) FROM ".$GLOBALS['ecs']->table('user_bonus'). $where;
    $filter['record_count'] = $GLOBALS['db']->getOne($sql);

    /* ��ҳ��С */
    $filter = page_and_size($filter);

    $sql = "SELECT ub.*, u.user_name, u.email, o.order_sn, bt.type_name ".
          " FROM ".$GLOBALS['ecs']->table('user_bonus'). " AS ub ".
          " LEFT JOIN " .$GLOBALS['ecs']->table('bonus_type'). " AS bt ON bt.type_id=ub.bonus_type_id ".
          " LEFT JOIN " .$GLOBALS['ecs']->table('users'). " AS u ON u.user_id=ub.user_id ".
          " LEFT JOIN " .$GLOBALS['ecs']->table('order_info'). " AS o ON o.order_id=ub.order_id $where ".
          " ORDER BY ".$filter['sort_by']." ".$filter['sort_order'].
          " LIMIT ". $filter['start'] .", $filter[page_size]";
    $row = $GLOBALS['db']->getAll($sql);

    foreach ($row AS $key => $val)
    {
        $row[$key]['used_time'] = $val['used_time'] == 0 ?
            $GLOBALS['_LANG']['no_use'] : local_date($GLOBALS['_CFG']['date_format'], $val['used_time']);
        $row[$key]['emailed'] = $GLOBALS['_LANG']['mail_status'][$row[$key]['emailed']];
    }

    $arr = array('item' => $row, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);

    return $arr;
}

/**
 * ȡ�ú��������Ϣ
 * @param   int     $bonus_type_id  �������id
 * @return  array
 */
function bonus_type_info($bonus_type_id)
{
    $sql = "SELECT * FROM " . $GLOBALS['ecs']->table('bonus_type') .
            " WHERE type_id = '$bonus_type_id'";

    return $GLOBALS['db']->getRow($sql);
}

/**
 * ���ͺ���ʼ�
 * @param   int     $bonus_type_id  �������id
 * @param   array   $bonus_id_list  ���id����
 * @return  int     �ɹ���������
 */
function send_bonus_mail($bonus_type_id, $bonus_id_list)
{
    /* ȡ�ú��������Ϣ */
    $bonus_type = bonus_type_info($bonus_type_id);
    if ($bonus_type['send_type'] != SEND_BY_USER)
    {
        return 0;
    }

    /* ȡ�����ڸ����͵ĺ����Ϣ */
    $sql = "SELECT b.bonus_id, u.user_name, u.email " .
            "FROM " . $GLOBALS['ecs']->table('user_bonus') . " AS b, " .
                $GLOBALS['ecs']->table('users') . " AS u " .
            " WHERE b.user_id = u.user_id " .
            " AND b.bonus_id " . db_create_in($bonus_id_list) .
            " AND b.order_id = 0 " .
            " AND u.email <> ''";
    $bonus_list = $GLOBALS['db']->getAll($sql);
    if (empty($bonus_list))
    {
        return 0;
    }

    /* ��ʼ���ɹ��������� */
    $send_count = 0;

    /* �����ʼ� */
    $tpl   = get_mail_template('send_bonus');
    $today = local_date($GLOBALS['_CFG']['date_format']);
    foreach ($bonus_list AS $bonus)
    {
        $GLOBALS['smarty']->assign('user_name',    $bonus['user_name']);
        $GLOBALS['smarty']->assign('shop_name',    $GLOBALS['_CFG']['shop_name']);
        $GLOBALS['smarty']->assign('send_date',    $today);
        $GLOBALS['smarty']->assign('sent_date',    $today);
        $GLOBALS['smarty']->assign('count',        1);
        $GLOBALS['smarty']->assign('money',        price_format($bonus_type['type_money']));

        $content = $GLOBALS['smarty']->fetch('str:' . $tpl['template_content']);
        if (add_to_maillist($bonus['user_name'], $bonus['email'], $tpl['template_subject'], $content, $tpl['is_html'], false))
        {
            $sql = "UPDATE " . $GLOBALS['ecs']->table('user_bonus') .
                    " SET emailed = '" . BONUS_MAIL_SUCCEED . "'" .
                    " WHERE bonus_id = '$bonus[bonus_id]'";
            $GLOBALS['db']->query($sql);
            $send_count++;
        }
        else
        {
            $sql = "UPDATE " . $GLOBALS['ecs']->table('user_bonus') .
                    " SET emailed = '" . BONUS_MAIL_FAIL . "'" .
                    " WHERE bonus_id = '$bonus[bonus_id]'";
            $GLOBALS['db']->query($sql);
        }
    }

    return $send_count;
}

function add_to_maillist($username, $email, $subject, $content, $is_html)
{
    $time = time();
    $content = addslashes($content);
    $template_id = $GLOBALS['db']->getOne("SELECT template_id FROM " . $GLOBALS['ecs']->table('mail_templates') . " WHERE template_code = 'send_bonus'");
    $sql = "INSERT INTO "  . $GLOBALS['ecs']->table('email_sendlist') . " ( email, template_id, email_content, pri, last_send) VALUES ('$email', $template_id, '$content', 1, '$time')";
    $GLOBALS['db']->query($sql);
    return true;
}

?>