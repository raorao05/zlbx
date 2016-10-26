<?php

/**
 * ECSHOP �ύ�û�����
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: comment.php 17217 2011-01-19 06:29:08Z liubo $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require(ROOT_PATH . 'includes/cls_json.php');
if (!isset($_REQUEST['cmt']) && !isset($_REQUEST['act']))
{
    /* ֻ����û���ύ���������Լ�û��act������²���ת */
    ecs_header("Location: ./\n");
    exit;
}
$_REQUEST['cmt'] = isset($_REQUEST['cmt']) ? json_str_iconv($_REQUEST['cmt']) : '';

$json   = new JSON;
$result = array('error' => 0, 'message' => '', 'content' => '');

if (empty($_REQUEST['act']))
{
    /*
     * act ����Ϊ��
     * Ĭ��Ϊ�����������
     */
    $cmt  = $json->decode($_REQUEST['cmt']);
    $cmt->page = 1;
    $cmt->id   = !empty($cmt->id)   ? intval($cmt->id) : 0;
    $cmt->type = !empty($cmt->type) ? intval($cmt->type) : 0;

    if (empty($cmt) || !isset($cmt->type) || !isset($cmt->id))
    {
        $result['error']   = 1;
        $result['message'] = $_LANG['invalid_comments'];
    }
    elseif (!is_email($cmt->email))
    {
        $result['error']   = 1;
        $result['message'] = $_LANG['error_email'];
    }
    else
    {
        if ((intval($_CFG['captcha']) & CAPTCHA_COMMENT) && gd_version() > 0)
        {
            /* �����֤�� */
            include_once('includes/cls_captcha.php');

            $validator = new captcha();
            if (!$validator->check_word($cmt->captcha))
            {
                $result['error']   = 1;
                $result['message'] = $_LANG['invalid_captcha'];
            }
            else
            {
                $factor = intval($_CFG['comment_factor']);
                if ($cmt->type == 0 && $factor > 0)
                {
                    /* ֻ����Ʒ�ż���������� */
                    switch ($factor)
                    {
                        case COMMENT_LOGIN :
                            if ($_SESSION['user_id'] == 0)
                            {
                                $result['error']   = 1;
                                $result['message'] = $_LANG['comment_login'];
                            }
                            break;

                        case COMMENT_CUSTOM :
                            if ($_SESSION['user_id'] > 0)
                            {
                                $sql = "SELECT o.order_id FROM " . $ecs->table('order_info') . " AS o ".
                                       " WHERE user_id = '" . $_SESSION['user_id'] . "'".
                                       " AND (o.order_status = '" . OS_CONFIRMED . "' or o.order_status = '" . OS_SPLITED . "') ".
                                       " AND (o.pay_status = '" . PS_PAYED . "' OR o.pay_status = '" . PS_PAYING . "') ".
                                       " AND (o.shipping_status = '" . SS_SHIPPED . "' OR o.shipping_status = '" . SS_RECEIVED . "') ".
                                       " LIMIT 1";


                                 $tmp = $db->getOne($sql);
                                 if (empty($tmp))
                                 {
                                    $result['error']   = 1;
                                    $result['message'] = $_LANG['comment_custom'];
                                 }
                            }
                            else
                            {
                                $result['error'] = 1;
                                $result['message'] = $_LANG['comment_custom'];
                            }
                            break;
                        case COMMENT_BOUGHT :
                            if ($_SESSION['user_id'] > 0)
                            {
                                $sql = "SELECT o.order_id".
                                       " FROM " . $ecs->table('order_info'). " AS o, ".
                                       $ecs->table('order_goods') . " AS og ".
                                       " WHERE o.order_id = og.order_id".
                                       " AND o.user_id = '" . $_SESSION['user_id'] . "'".
                                       " AND og.goods_id = '" . $cmt->id . "'".
                                       " AND (o.order_status = '" . OS_CONFIRMED . "' or o.order_status = '" . OS_SPLITED . "') ".
                                       " AND (o.pay_status = '" . PS_PAYED . "' OR o.pay_status = '" . PS_PAYING . "') ".
                                       " AND (o.shipping_status = '" . SS_SHIPPED . "' OR o.shipping_status = '" . SS_RECEIVED . "') ".
                                       " LIMIT 1";
                                 $tmp = $db->getOne($sql);
                                 if (empty($tmp))
                                 {
                                    $result['error']   = 1;
                                    $result['message'] = $_LANG['comment_brought'];
                                 }
                            }
                            else
                            {
                                $result['error']   = 1;
                                $result['message'] = $_LANG['comment_brought'];
                            }
                    }
                }

                /* �޴���ͱ������� */
                if (empty($result['error']))
                {
                    add_comment($cmt);
                }
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
                $result['error']   = 1;
                $result['message'] = $_LANG['cmt_spam_warning'];
            }
            else
            {
                $factor = intval($_CFG['comment_factor']);
                if ($cmt->type == 0 && $factor > 0)
                {
                    /* ֻ����Ʒ�ż���������� */
                    switch ($factor)
                    {
                        case COMMENT_LOGIN :
                            if ($_SESSION['user_id'] == 0)
                            {
                                $result['error']   = 1;
                                $result['message'] = $_LANG['comment_login'];
                            }
                            break;

                        case COMMENT_CUSTOM :
                            if ($_SESSION['user_id'] > 0)
                            {
                                $sql = "SELECT o.order_id FROM " . $ecs->table('order_info') . " AS o ".
                                       " WHERE user_id = '" . $_SESSION['user_id'] . "'".
                                       " AND (o.order_status = '" . OS_CONFIRMED . "' or o.order_status = '" . OS_SPLITED . "') ".
                                       " AND (o.pay_status = '" . PS_PAYED . "' OR o.pay_status = '" . PS_PAYING . "') ".
                                       " AND (o.shipping_status = '" . SS_SHIPPED . "' OR o.shipping_status = '" . SS_RECEIVED . "') ".
                                       " LIMIT 1";


                                 $tmp = $db->getOne($sql);
                                 if (empty($tmp))
                                 {
                                    $result['error']   = 1;
                                    $result['message'] = $_LANG['comment_custom'];
                                 }
                            }
                            else
                            {
                                $result['error'] = 1;
                                $result['message'] = $_LANG['comment_custom'];
                            }
                            break;

                        case COMMENT_BOUGHT :
                            if ($_SESSION['user_id'] > 0)
                            {
                                $sql = "SELECT o.order_id".
                                       " FROM " . $ecs->table('order_info'). " AS o, ".
                                       $ecs->table('order_goods') . " AS og ".
                                       " WHERE o.order_id = og.order_id".
                                       " AND o.user_id = '" . $_SESSION['user_id'] . "'".
                                       " AND og.goods_id = '" . $cmt->id . "'".
                                       " AND (o.order_status = '" . OS_CONFIRMED . "' or o.order_status = '" . OS_SPLITED . "') ".
                                       " AND (o.pay_status = '" . PS_PAYED . "' OR o.pay_status = '" . PS_PAYING . "') ".
                                       " AND (o.shipping_status = '" . SS_SHIPPED . "' OR o.shipping_status = '" . SS_RECEIVED . "') ".
                                       " LIMIT 1";
                                 $tmp = $db->getOne($sql);
                                 if (empty($tmp))
                                 {
                                    $result['error']   = 1;
                                    $result['message'] = $_LANG['comment_brought'];
                                 }
                            }
                            else
                            {
                                $result['error']   = 1;
                                $result['message'] = $_LANG['comment_brought'];
                            }
                    }
                }
                /* �޴���ͱ������� */
                if (empty($result['error']))
                {
                    add_comment($cmt);
                    $_SESSION['send_time'] = $cur_time;
                }
            }
        }
    }
}
else
{
    /*
     * act ������Ϊ��
     * Ĭ��Ϊ���������б�
     * ���� _GET ����һ����̬����
     */
    $cmt = new stdClass();
    $cmt->id   = !empty($_GET['id'])   ? intval($_GET['id'])   : 0;
    $cmt->type = !empty($_GET['type']) ? intval($_GET['type']) : 0;
    $cmt->page = isset($_GET['page'])   && intval($_GET['page'])  > 0 ? intval($_GET['page'])  : 1;
}

if ($result['error'] == 0)
{
    $comments = assign_comment($cmt->id, $cmt->type, $cmt->page);

    $smarty->assign('comment_type', $cmt->type);
    $smarty->assign('id',           $cmt->id);
    $smarty->assign('username',     $_SESSION['user_name']);
    $smarty->assign('email',        $_SESSION['email']);
    $smarty->assign('comments',     $comments['comments']);
    $smarty->assign('pager',        $comments['pager']);

    /* ��֤��������� */
    if ((intval($_CFG['captcha']) & CAPTCHA_COMMENT) && gd_version() > 0)
    {
        $smarty->assign('enabled_captcha', 1);
        $smarty->assign('rand', mt_rand());
    }

    $result['message'] = $_CFG['comment_check'] ? $_LANG['cmt_submit_wait'] : $_LANG['cmt_submit_done'];
    $result['content'] = $smarty->fetch("library/comments_list.lbi");
}

echo $json->encode($result);

/*------------------------------------------------------ */
//-- PRIVATE FUNCTION
/*------------------------------------------------------ */

/**
 * �����������
 *
 * @access  public
 * @param   object  $cmt
 * @return  void
 */
function add_comment($cmt)
{
    /* �����Ƿ���Ҫ��� */
    $status = 1 - $GLOBALS['_CFG']['comment_check'];

    $user_id = empty($_SESSION['user_id']) ? 0 : $_SESSION['user_id'];
    $email = empty($cmt->email) ? $_SESSION['email'] : trim($cmt->email);
    $user_name = empty($cmt->username) ? $_SESSION['user_name'] : '';
    $email = htmlspecialchars($email);
    $user_name = htmlspecialchars($user_name);

    /* ������������ */
    $sql = "INSERT INTO " .$GLOBALS['ecs']->table('comment') .
           "(comment_type, id_value, email, user_name, content, comment_rank, add_time, ip_address, status, parent_id, user_id) VALUES " .
           "('" .$cmt->type. "', '" .$cmt->id. "', '$email', '$user_name', '" .$cmt->content."', '".$cmt->rank."', ".gmtime().", '".real_ip()."', '$status', '0', '$user_id')";

    $result = $GLOBALS['db']->query($sql);
    clear_cache_files('comments_list.lbi');
    /*if ($status > 0)
    {
        add_feed($GLOBALS['db']->insert_id(), COMMENT_GOODS);
    }*/
    return $result;
}

?>