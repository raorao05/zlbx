<?php

/**
 * ECSHOP �û��ʺ���غ�����
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: lib_passport.php 17217 2011-01-19 06:29:08Z liubo $
*/

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

/**
 * �û�ע�ᣬ��¼����
 *
 * @access  public
 * @param   string       $username          ע���û���
 * @param   string       $password          �û�����
 * @param   string       $email             ע��email
 * @param   array        $other             ע���������Ϣ
 *
 * @return  bool         $bool
 */
function register($username, $password, $email, $other = array())
{
    /* ���ע���Ƿ�ر� */
    if (!empty($GLOBALS['_CFG']['shop_reg_closed']))
    {
        $GLOBALS['err']->add($GLOBALS['_LANG']['shop_register_closed']);
    }
    /* ���username */
    if (empty($username))
    {
        $GLOBALS['err']->add($GLOBALS['_LANG']['username_empty']);
    }
    else
    {
        if (preg_match('/\'\/^\\s*$|^c:\\\\con\\\\con$|[%,\\*\\"\\s\\t\\<\\>\\&\'\\\\]/', $username))
        {
            $GLOBALS['err']->add(sprintf($GLOBALS['_LANG']['username_invalid'], htmlspecialchars($username)));
        }
    }

    /* ���email */
    /*if (empty($email))
    {
        $GLOBALS['err']->add($GLOBALS['_LANG']['email_empty']);
    }
    else
    {
        if (!is_email($email))
        {
            $GLOBALS['err']->add(sprintf($GLOBALS['_LANG']['email_invalid'], htmlspecialchars($email)));
        }
    }*/

    if ($GLOBALS['err']->error_no > 0)
    {
        return false;
    }

    /* ����Ƿ�͹���Ա���� */
    if (admin_registered($username))
    {
        $GLOBALS['err']->add(sprintf($GLOBALS['_LANG']['username_exist'], $username));
        return false;
    }

    if (!$GLOBALS['user']->add_user($username, $password, $email))
    {
        if ($GLOBALS['user']->error == ERR_INVALID_USERNAME)
        {
            $GLOBALS['err']->add(sprintf($GLOBALS['_LANG']['username_invalid'], $username));
        }
        elseif ($GLOBALS['user']->error == ERR_USERNAME_NOT_ALLOW)
        {
            $GLOBALS['err']->add(sprintf($GLOBALS['_LANG']['username_not_allow'], $username));
        }
        elseif ($GLOBALS['user']->error == ERR_USERNAME_EXISTS)
        {
            $GLOBALS['err']->add(sprintf($GLOBALS['_LANG']['username_exist'], $username));
        }
        elseif ($GLOBALS['user']->error == ERR_INVALID_EMAIL)
        {
            $GLOBALS['err']->add(sprintf($GLOBALS['_LANG']['email_invalid'], $email));
        }
        elseif ($GLOBALS['user']->error == ERR_EMAIL_NOT_ALLOW)
        {
            $GLOBALS['err']->add(sprintf($GLOBALS['_LANG']['email_not_allow'], $email));
        }
        elseif ($GLOBALS['user']->error == ERR_EMAIL_EXISTS)
        {
            $GLOBALS['err']->add(sprintf($GLOBALS['_LANG']['email_exist'], $email));
        }
        else
        {
            $GLOBALS['err']->add('UNKNOWN ERROR!');
        }

        //ע��ʧ��
        return false;
    }
    else
    {
        //ע��ɹ�

        /* ���óɵ�¼״̬ */
        $GLOBALS['user']->set_session($username);
        $GLOBALS['user']->set_cookie($username);

        /* ע���ͻ��� */
        if (!empty($GLOBALS['_CFG']['register_points']))
        {
            log_account_change($_SESSION['user_id'], 0, 0, $GLOBALS['_CFG']['register_points'], $GLOBALS['_CFG']['register_points'], $GLOBALS['_LANG']['register_points']);
        }

        /*�Ƽ�����*/
        $affiliate  = unserialize($GLOBALS['_CFG']['affiliate']);
        if (isset($affiliate['on']) && $affiliate['on'] == 1)
        {
            // �Ƽ����ؿ���
            $up_uid     = get_affiliate();
            empty($affiliate) && $affiliate = array();
            $affiliate['config']['level_register_all'] = intval($affiliate['config']['level_register_all']);
            $affiliate['config']['level_register_up'] = intval($affiliate['config']['level_register_up']);
            if ($up_uid)
            {
                if (!empty($affiliate['config']['level_register_all']))
                {
                    if (!empty($affiliate['config']['level_register_up']))
                    {
                        $rank_points = $GLOBALS['db']->getOne("SELECT rank_points FROM " . $GLOBALS['ecs']->table('users') . " WHERE user_id = '$up_uid'");
                        if ($rank_points + $affiliate['config']['level_register_all'] <= $affiliate['config']['level_register_up'])
                        {
                            log_account_change($up_uid, 0, 0, $affiliate['config']['level_register_all'], 0, sprintf($GLOBALS['_LANG']['register_affiliate'], $_SESSION['user_id'], $username));
                        }
                    }
                    else
                    {
                        log_account_change($up_uid, 0, 0, $affiliate['config']['level_register_all'], 0, $GLOBALS['_LANG']['register_affiliate']);
                    }
                }

                //�����Ƽ���
                $sql = 'UPDATE '. $GLOBALS['ecs']->table('users') . ' SET parent_id = ' . $up_uid . ' WHERE user_id = ' . $_SESSION['user_id'];

                $GLOBALS['db']->query($sql);
            }
        }

        //����other�Ϸ��ı�������
        $other_key_array = array('msn', 'qq', 'office_phone', 'home_phone', 'mobile_phone','sfz_pic');
        $update_data['reg_time'] = local_strtotime(local_date('Y-m-d H:i:s'));
        if ($other)
        {
            foreach ($other as $key=>$val)
            {
                //ɾ���Ƿ�keyֵ
                if (!in_array($key, $other_key_array))
                {
                    unset($other[$key]);
                }
                else
                {
                    $other[$key] =  htmlspecialchars(trim($val)); //��ֹ�û�����javascript����
                }
            }
            $update_data = array_merge($update_data, $other);
        }
        $GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('users'), $update_data, 'UPDATE', 'user_id = ' . $_SESSION['user_id']);

        update_user_info();      // �����û���Ϣ
        recalculate_price();     // ���¼��㹺�ﳵ�е���Ʒ�۸�

        return true;
    }
}

/**
 *
 *
 * @access  public
 * @param
 *
 * @return void
 */
function logout()
{
/* todo */
}

/**
 *  ��ָ��user_id�������޸�Ϊnew_password������ͨ�����������֤�ִ���֤�޸ġ�
 *
 * @access  public
 * @param   int     $user_id        �û�ID
 * @param   string  $new_password   �û�������
 * @param   string  $old_password   �û�������
 * @param   string  $code           ��֤�루md5($user_id . md5($password))��
 *
 * @return  boolen  $bool
 */
function edit_password($user_id, $old_password, $new_password='', $code ='')
{
    if (empty($user_id)) $GLOBALS['err']->add($GLOBALS['_LANG']['not_login']);

    if ($GLOBALS['user']->edit_password($user_id, $old_password, $new_password, $code))
    {
        return true;
    }
    else
    {
        $GLOBALS['err']->add($GLOBALS['_LANG']['edit_password_failure']);

        return false;
    }
}

/**
 *  ��Ա�һ�����ʱ����������û������ʼ���ַƥ��
 *
 * @access  public
 * @param   string  $user_name    �û��ʺ�
 * @param   string  $email        �û�Email
 *
 * @return  boolen
 */
function check_userinfo($user_name, $email)
{
    if (empty($user_name) || empty($email))
    {
        ecs_header("Location: user.php?act=get_password\n");

        exit;
    }

    /* ����û������ʼ���ַ�Ƿ�ƥ�� */
    $user_info = $GLOBALS['user']->check_pwd_info($user_name, $email);
    if (!empty($user_info))
    {
        return $user_info;
    }
    else
    {
        return false;
    }
}

/**
 *  �û����������һز���ʱ������һ��ȷ���ʼ�
 *
 * @access  public
 * @param   string  $uid          �û�ID
 * @param   string  $user_name    �û��ʺ�
 * @param   string  $email        �û�Email
 * @param   string  $code         key
 *
 * @return  boolen  $result;
 */
function send_pwd_email($uid, $user_name, $email, $code)
{
    if (empty($uid) || empty($user_name) || empty($email) || empty($code))
    {
        ecs_header("Location: user.php?act=get_password\n");

        exit;
    }

    /* ���������ʼ�ģ������Ҫ��������Ϣ */
    $template    = get_mail_template('send_password');
    $reset_email = $GLOBALS['ecs']->url() . 'user.php?act=get_password&uid=' . $uid . '&code=' . $code;

    $GLOBALS['smarty']->assign('user_name',   $user_name);
    $GLOBALS['smarty']->assign('reset_email', $reset_email);
    $GLOBALS['smarty']->assign('shop_name',   $GLOBALS['_CFG']['shop_name']);
    $GLOBALS['smarty']->assign('send_date',   date('Y-m-d'));
    $GLOBALS['smarty']->assign('sent_date',   date('Y-m-d'));

    $content = $GLOBALS['smarty']->fetch('str:' . $template['template_content']);

    /* ����ȷ�����������ȷ���ʼ� */
    if (send_mail($user_name, $email, $template['template_subject'], $content, $template['is_html']))
    {
        return true;
    }
    else
    {
        return false;
    }
}

/**
 *  ���ͼ�����֤�ʼ�
 *
 * @access  public
 * @param   int     $user_id        �û�ID
 *
 * @return boolen
 */
function send_regiter_hash ($user_id)
{
    /* ������֤�ʼ�ģ������Ҫ��������Ϣ */
    $template    = get_mail_template('register_validate');
    $hash = register_hash('encode', $user_id);
    $validate_email = $GLOBALS['ecs']->url() . 'user.php?act=validate_email&hash=' . $hash;

    $sql = "SELECT user_name, email FROM " . $GLOBALS['ecs']->table('users') . " WHERE user_id = '$user_id'";
    $row = $GLOBALS['db']->getRow($sql);

    $GLOBALS['smarty']->assign('user_name',         $row['user_name']);
    $GLOBALS['smarty']->assign('validate_email',    $validate_email);
    $GLOBALS['smarty']->assign('shop_name',         $GLOBALS['_CFG']['shop_name']);
    $GLOBALS['smarty']->assign('send_date',         date($GLOBALS['_CFG']['date_format']));

    $content = $GLOBALS['smarty']->fetch('str:' . $template['template_content']);

    /* ���ͼ�����֤�ʼ� */
    if (send_mail($row['user_name'], $row['email'], $template['template_subject'], $content, $template['is_html']))
    {
        return true;
    }
    else
    {
        return false;
    }
}

/**
 *  �����ʼ���֤hash
 *
 * @access  public
 * @param
 *
 * @return void
 */
function register_hash ($operation, $key)
{
    if ($operation == 'encode')
    {
        $user_id = intval($key);
        $sql = "SELECT reg_time ".
               " FROM " . $GLOBALS['ecs'] ->table('users').
               " WHERE user_id = '$user_id' LIMIT 1";
        $reg_time = $GLOBALS['db']->getOne($sql);

        $hash = substr(md5($user_id . $GLOBALS['_CFG']['hash_code'] . $reg_time), 16, 4);

        return base64_encode($user_id . ',' . $hash);
    }
    else
    {
        $hash = base64_decode(trim($key));
        $row = explode(',', $hash);
        if (count($row) != 2)
        {
            return 0;
        }
        $user_id = intval($row[0]);
        $salt = trim($row[1]);

        if ($user_id <= 0 || strlen($salt) != 4)
        {
            return 0;
        }

        $sql = "SELECT reg_time ".
               " FROM " . $GLOBALS['ecs'] ->table('users').
               " WHERE user_id = '$user_id' LIMIT 1";
        $reg_time = $GLOBALS['db']->getOne($sql);

        $pre_salt = substr(md5($user_id . $GLOBALS['_CFG']['hash_code'] . $reg_time), 16, 4);

        if ($pre_salt == $salt)
        {
            return $user_id;
        }
        else
        {
            return 0;
        }
    }
}

/**
 * �жϳ�������Ա�û����Ƿ����
 * @param   string      $adminname ��������Ա�û���
 * @return  boolean
 */
function admin_registered( $adminname )
{
    $res = $GLOBALS['db']->getOne("SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('admin_user') .
                                  " WHERE user_name = '$adminname'");
    return $res;
}

?>