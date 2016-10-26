<?php

/**
 * ECSHOP ��¼����Ա������־
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: admin_logs.php 17217 2011-01-19 06:29:08Z liubo $
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

/*------------------------------------------------------ */
//-- ��ȡ������־�б�
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'list')
{
    /* Ȩ�޵��ж� */
    admin_priv('logs_manage');

    $user_id   = !empty($_REQUEST['id'])       ? intval($_REQUEST['id']) : 0;
    $admin_ip  = !empty($_REQUEST['ip'])       ? $_REQUEST['ip']         : '';
    $log_date  = !empty($_REQUEST['log_date']) ? $_REQUEST['log_date']   : '';

    /* ��ѯIP��ַ�б� */
    $ip_list = array();
    $res = $db->query("SELECT DISTINCT ip_address FROM " .$ecs->table('admin_log'));
    while ($row = $db->FetchRow($res))
    {
        $ip_list[$row['ip_address']] = $row['ip_address'];
    }

    $smarty->assign('ur_here',   $_LANG['admin_logs']);
    $smarty->assign('ip_list',   $ip_list);
    $smarty->assign('full_page', 1);

    $log_list = get_admin_logs();

    $smarty->assign('log_list',        $log_list['list']);
    $smarty->assign('filter',          $log_list['filter']);
    $smarty->assign('record_count',    $log_list['record_count']);
    $smarty->assign('page_count',      $log_list['page_count']);

    $sort_flag  = sort_flag($log_list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    assign_query_info();
    $smarty->display('admin_logs.htm');
}

/*------------------------------------------------------ */
//-- ���򡢷�ҳ����ѯ
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'query')
{
    $log_list = get_admin_logs();

    $smarty->assign('log_list',        $log_list['list']);
    $smarty->assign('filter',          $log_list['filter']);
    $smarty->assign('record_count',    $log_list['record_count']);
    $smarty->assign('page_count',      $log_list['page_count']);

    $sort_flag  = sort_flag($log_list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    make_json_result($smarty->fetch('admin_logs.htm'), '',
        array('filter' => $log_list['filter'], 'page_count' => $log_list['page_count']));
}

/*------------------------------------------------------ */
//-- ����ɾ����־��¼
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'batch_drop')
{
    admin_priv('logs_drop');

    $drop_type_date = isset($_POST['drop_type_date']) ? $_POST['drop_type_date'] : '';

    /* ������ɾ����־ */
    if ($drop_type_date)
    {
        if ($_POST['log_date'] == '0')
        {
            ecs_header("Location: admin_logs.php?act=list\n");
            exit;
        }
        elseif ($_POST['log_date'] > '0')
        {
            $where = " WHERE 1 ";
            switch ($_POST['log_date'])
            {
                case '1':
                    $a_week = gmtime()-(3600 * 24 * 7);
                    $where .= " AND log_time <= '".$a_week."'";
                    break;
                case '2':
                    $a_month = gmtime()-(3600 * 24 * 30);
                    $where .= " AND log_time <= '".$a_month."'";
                    break;
                case '3':
                    $three_month = gmtime()-(3600 * 24 * 90);
                    $where .= " AND log_time <= '".$three_month."'";
                    break;
                case '4':
                    $half_year = gmtime()-(3600 * 24 * 180);
                    $where .= " AND log_time <= '".$half_year."'";
                    break;
                case '5':
                    $a_year = gmtime()-(3600 * 24 * 365);
                    $where .= " AND log_time <= '".$a_year."'";
                    break;
            }
            $sql = "DELETE FROM " .$ecs->table('admin_log').$where;
            $res = $db->query($sql);
            if ($res)
            {
                admin_log('','remove', 'adminlog');

                $link[] = array('text' => $_LANG['back_list'], 'href' => 'admin_logs.php?act=list');
                sys_msg($_LANG['drop_sueeccud'], 1, $link);
            }
        }
    }
    /* ������ǰ�������ɾ��, �Ͱ�IDɾ����־ */
    else
    {
        $count = 0;
        foreach ($_POST['checkboxes'] AS $key => $id)
        {
            $sql = "DELETE FROM " .$ecs->table('admin_log'). " WHERE log_id = '$id'";
            $result = $db->query($sql);

            $count++;
        }
        if ($result)
        {
            admin_log('', 'remove', 'adminlog');

            $link[] = array('text' => $_LANG['back_list'], 'href' => 'admin_logs.php?act=list');
            sys_msg(sprintf($_LANG['batch_drop_success'], $count), 0, $link);
        }
    }
}

/* ��ȡ����Ա������¼ */
function get_admin_logs()
{
    $user_id  = !empty($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
    $admin_ip = !empty($_REQUEST['ip']) ? $_REQUEST['ip']         : '';

    $filter = array();
    $filter['sort_by']      = empty($_REQUEST['sort_by']) ? 'al.log_id' : trim($_REQUEST['sort_by']);
    $filter['sort_order']   = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);

    //��ѯ����
    $where = " WHERE 1 ";
    if (!empty($user_id))
    {
        $where .= " AND al.user_id = '$user_id' ";
    }
    elseif (!empty($admin_ip))
    {
        $where .= " AND al.ip_address = '$admin_ip' ";
    }

    /* ����ܼ�¼���� */
    $sql = 'SELECT COUNT(*) FROM ' .$GLOBALS['ecs']->table('admin_log'). ' AS al ' . $where;
    $filter['record_count'] = $GLOBALS['db']->getOne($sql);

    $filter = page_and_size($filter);

    /* ��ȡ����Ա��־��¼ */
    $list = array();
    $sql  = 'SELECT al.*, u.user_name FROM ' .$GLOBALS['ecs']->table('admin_log'). ' AS al '.
            'LEFT JOIN ' .$GLOBALS['ecs']->table('admin_user'). ' AS u ON u.user_id = al.user_id '.
            $where .' ORDER by '.$filter['sort_by'].' '.$filter['sort_order'];
    $res  = $GLOBALS['db']->selectLimit($sql, $filter['page_size'], $filter['start']);

    while ($rows = $GLOBALS['db']->fetchRow($res))
    {
        $rows['log_time'] = local_date($GLOBALS['_CFG']['time_format'], $rows['log_time']);

        $list[] = $rows;
    }

    return array('list' => $list, 'filter' => $filter, 'page_count' =>  $filter['page_count'], 'record_count' => $filter['record_count']);
}

?>