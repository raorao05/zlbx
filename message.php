<?php

/**
 * ECSHOP ���԰�
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: message.php 17217 2011-01-19 06:29:08Z liubo $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

if (empty($_CFG['message_board']))
{
    show_message($_LANG['message_board_close']);
}
$action  = isset($_REQUEST['act']) ? trim($_REQUEST['act']) : 'default';
if ($action == 'act_add_message')
{
    include_once(ROOT_PATH . 'includes/lib_clips.php');

    /* ��֤���ֹ��ˮˢ�� */
    if ((intval($_CFG['captcha']) & CAPTCHA_MESSAGE) && gd_version() > 0)
    {
        include_once('includes/cls_captcha.php');
        $validator = new captcha();
        if (!$validator->check_word($_POST['captcha']))
        {
            show_message($_LANG['invalid_captcha']);
        }
    }
    else
    {
        /* û����֤��ʱ����ʱ�������ƻ����˷�������ⷢ���� */
        if (!isset($_SESSION['send_time']))
        {
            $_SESSION['send_time'] = 0;
        }

        $cur_time = gmtime();
        if (($cur_time - $_SESSION['send_time']) < 30) // С��30���ֹ������
        {
            show_message($_LANG['cmt_spam_warning']);
        }
    }
    $user_name = '';
    if (empty($_POST['anonymous']) && !empty($_SESSION['user_name']))
    {
        $user_name = $_SESSION['user_name'];
    }
    elseif (!empty($_POST['anonymous']) && !isset($_POST['user_name']))
    {
        $user_name = $_LANG['anonymous'];
    }
    elseif (empty($_POST['user_name']))
    {
        $user_name = $_LANG['anonymous'];
    }
    else
    {
        $user_name = htmlspecialchars(trim($_POST['user_name']));
    }

    $user_id = !empty($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
	if($user_id == 0){
		show_message('���ȵ�¼�����˺ţ�');
	}
    $message = array(
        'user_id'     => $user_id,
        'user_name'   => $user_name,
        'user_email'  => isset($_POST['user_email']) ? htmlspecialchars(trim($_POST['user_email']))     : '',
        'msg_type'    => isset($_POST['msg_type']) ? intval($_POST['msg_type'])     : 0,
        'msg_title'   => isset($_POST['msg_title']) ? trim($_POST['msg_title'])     : '',
        'msg_content' => isset($_POST['msg_content']) ? trim($_POST['msg_content']) : '',
        'order_id'    => 0,
        'msg_area'    => 1,
		'ba_name'     => isset($_POST['ba_name']) ? trim($_POST['ba_name'])     : '',
		'ba_tel'      => isset($_POST['ba_tel']) ? trim($_POST['ba_tel'])     : '',
		'email'       => isset($_POST['email']) ? trim($_POST['email'])     : '',
		'cx_name'     => isset($_POST['cx_name']) ? trim($_POST['cx_name'])     : '',
		'zj_number'   => isset($_POST['zj_number']) ? trim($_POST['zj_number'])     : '',
		'cx_tel'      => isset($_POST['cx_tel']) ? trim($_POST['cx_tel'])     : '',
		'bdh'         => isset($_POST['bdh']) ? trim($_POST['bdh'])     : '',
		'lp_type'     => isset($_POST['lp_type']) ? trim($_POST['lp_type'])     : '',
		'fs_time'     => isset($_POST['fs_time']) ? trim($_POST['fs_time'])     : '',
		'hbh'         => isset($_POST['hbh']) ? trim($_POST['hbh'])     : '',
		'reason'      => isset($_POST['reason']) ? trim($_POST['reason'])     : '',
		'account_name'   => isset($_POST['account_name']) ? trim($_POST['account_name'])     : '',
		'bank'        => isset($_POST['bank']) ? trim($_POST['bank'])     : '',
		'bank_account'   => isset($_POST['bank_account']) ? trim($_POST['bank_account'])     : '',
        'upload'      => array()
     );
    if (add_message($message))
    {
        if (intval($_CFG['captcha']) & CAPTCHA_MESSAGE)
        {
            unset($_SESSION[$validator->session_word]);
        }
        else
        {
            $_SESSION['send_time'] = $cur_time;
        }
        //$msg_info = $_CFG['message_check'] ? $_LANG['message_submit_wait'] : $_LANG['message_submit_done'];
        show_message('���������ϱ����ɹ�, ��ȴ����!', '�������ϱ���', 'user.php?act=claim_list');
    }
    else
    {
        $err->show($_LANG['message_list_lnk'], 'article_cat.php?id=29');
    }
}

if ($action == 'default')
{
    assign_template();
    $position = assign_ur_here(0, $_LANG['message_board']);
    $smarty->assign('page_title', $position['title']);    // ҳ�����
    $smarty->assign('ur_here',    $position['ur_here']);  // ��ǰλ��
    $smarty->assign('helps',      get_shop_help());       // �������

    $smarty->assign('categories', get_categories_tree()); // ������
    $smarty->assign('top_goods',  get_top10());           // ��������
    $smarty->assign('cat_list',   cat_list(0, 0, true, 2, false));
    $smarty->assign('brand_list', get_brand_list());
    $smarty->assign('promotion_info', get_promotion_info());

    $smarty->assign('enabled_mes_captcha', (intval($_CFG['captcha']) & CAPTCHA_MESSAGE));

    $sql = "SELECT COUNT(*) FROM " .$GLOBALS['ecs']->table('comment')." WHERE STATUS =1 AND comment_type =0 ";
    $record_count = $db->getOne($sql);
    $sql = "SELECT COUNT(*) FROM " .$GLOBALS['ecs']->table('feedback')." WHERE `msg_area`='1' AND `msg_status` = '1' ";
    $record_count += $db->getOne($sql);

    /* ��ȡ���Ե����� */
    $page = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
    $pagesize = get_library_number('message_list', 'message_board');
    $pager = get_pager('message.php', array(), $record_count, $page, $pagesize);
    $msg_lists = get_msg_list($pagesize, $pager['start']);
    assign_dynamic('message_board');
    $smarty->assign('rand',      mt_rand());
    $smarty->assign('msg_lists', $msg_lists);
    $smarty->assign('pager', $pager);
    $smarty->display('message_board.dwt');
}

/**
 * ��ȡ���Ե���ϸ��Ϣ
 *
 * @param   integer $num
 * @param   integer $start
 *
 * @return  array
 */
function get_msg_list($num, $start)
{
    /* ��ȡ�������� */
    $msg = array();
        
    $mysql_ver = $GLOBALS['db']->version();
    
    if($mysql_ver > '3.2.3')
    {
        $sql = "(SELECT 'comment' AS tablename,   comment_id AS ID, content AS msg_content, null AS msg_title, add_time AS msg_time, id_value AS id_value, comment_rank AS comment_rank, null AS message_img, user_name AS user_name, '6' AS msg_type ";
        $sql .= " FROM " .$GLOBALS['ecs']->table('comment');
        $sql .= "WHERE STATUS =1 AND comment_type =0) ";
        $sql .= " UNION ";
        $sql .= "(SELECT 'feedback' AS tablename, msg_id AS ID, msg_content AS msg_content, msg_title AS msg_title, msg_time AS msg_time, null AS id_value, null AS comment_rank, message_img AS message_img, user_name AS user_name, msg_type AS msg_type ";
        $sql .= " FROM " .$GLOBALS['ecs']->table('feedback');
        $sql .= " WHERE `msg_area`='1' AND `msg_status` = '1') ";
        $sql .= " ORDER BY msg_time DESC ";
    }
    else 
    {
        $con_sql = "SELECT 'comment' AS tablename,   comment_id AS ID, content AS msg_content, null AS msg_title, add_time AS msg_time, id_value AS id_value, comment_rank AS comment_rank, null AS message_img, user_name AS user_name, '6' AS msg_type ";
        $con_sql .= " FROM " .$GLOBALS['ecs']->table('comment');
        $con_sql .= "WHERE STATUS =1 AND comment_type =0 ";
    
        $fee_sql = "SELECT 'feedback' AS tablename, msg_id AS ID, msg_content AS msg_content, msg_title AS msg_title, msg_time AS msg_time, null AS id_value, null AS comment_rank, message_img AS message_img, user_name AS user_name, msg_type AS msg_type ";
        $fee_sql .= " FROM " .$GLOBALS['ecs']->table('feedback');
        $fee_sql .= " WHERE `msg_area`='1' AND `msg_status` = '1' ";
    
        
        $cre_con = "CREATE TEMPORARY TABLE tmp_table ".$con_sql;
        $GLOBALS['db']->query($cre_con);
    
        $cre_con = "INSERT INTO tmp_table ".$fee_sql;
        $GLOBALS['db']->query($cre_con);
    
        $sql = "SELECT * FROM  " .$GLOBALS['ecs']->table('tmp_table') . " ORDER BY msg_time DESC ";
    }

    $res = $GLOBALS['db']->SelectLimit($sql, $num, $start);

    while ($rows = $GLOBALS['db']->fetchRow($res))
    {
        for($i = 0; $i < count($rows); $i++)
        {
        $msg[$rows['msg_time']]['user_name'] = htmlspecialchars($rows['user_name']);
        $msg[$rows['msg_time']]['msg_content'] = str_replace('\r\n', '<br />', htmlspecialchars($rows['msg_content']));
        $msg[$rows['msg_time']]['msg_content'] = str_replace('\n', '<br />', $msg[$rows['msg_time']]['msg_content']);
        $msg[$rows['msg_time']]['msg_time']    = local_date($GLOBALS['_CFG']['time_format'], $rows['msg_time']);
        $msg[$rows['msg_time']]['msg_type']    = $GLOBALS['_LANG']['message_type'][$rows['msg_type']];
        $msg[$rows['msg_time']]['msg_title']   = nl2br(htmlspecialchars($rows['msg_title']));
        $msg[$rows['msg_time']]['message_img'] = $rows['message_img'];
        $msg[$rows['msg_time']]['tablename'] = $rows['tablename'];

            if(isset($rows['order_id']))
            {
                 $msg[$rows['msg_time']]['order_id'] = $rows['order_id'];
            }
            $msg[$rows['msg_time']]['comment_rank'] = $rows['comment_rank'];
            $msg[$rows['msg_time']]['id_value'] = $rows['id_value'];

            /*���id_valueΪtrueΪ��Ʒ����,������Ʒidȡ����Ʒ����*/
            if($rows['id_value'])
            {
                $sql_goods = "SELECT goods_name FROM ".$GLOBALS['ecs']->table('goods');
                $sql_goods .= "WHERE goods_id= ".$rows['id_value'];
                $goods_res = $GLOBALS['db']->getRow($sql_goods);
                $msg[$rows['msg_time']]['goods_name'] = $goods_res['goods_name'];
                $msg[$rows['msg_time']]['goods_url'] = build_uri('goods', array('gid' => $rows['id_value']), $goods_res['goods_name']);
            }
        }

        $msg[$rows['msg_time']]['tablename'] = $rows['tablename'];
        $id = $rows['ID'];
        $reply = array();
        if(isset($msg[$rows['msg_time']]['tablename']))
        {
            $table_name = $msg[$rows['msg_time']]['tablename'];

            if ($table_name == 'feedback')
            {
                $sql = "SELECT user_name AS re_name, user_email AS re_email, msg_time AS re_time, msg_content AS re_content ,parent_id".
                 " FROM " .$GLOBALS['ecs']->table('feedback') .
                 " WHERE parent_id = '" . $id. "'";
            }
            else
            {
                $sql = 'SELECT user_name AS re_name, email AS re_email, add_time AS re_time, content AS re_content ,parent_id
                FROM ' . $GLOBALS['ecs']->table('comment') .
                " WHERE parent_id = $id ";

            }
            $reply = $GLOBALS['db']->getRow($sql);
            if ($reply)
            {
                $msg[$rows['msg_time']]['re_name']   = $reply['re_name'];
                $msg[$rows['msg_time']]['re_email']  = $reply['re_email'];
                $msg[$rows['msg_time']]['re_time']    = local_date($GLOBALS['_CFG']['time_format'], $reply['re_time']);
                $msg[$rows['msg_time']]['re_content'] = nl2br(htmlspecialchars($reply['re_content']));
            }
        }

    }

    return $msg;
}

?>
