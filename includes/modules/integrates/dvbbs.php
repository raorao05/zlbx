<?php

/**
 * ECSHOP ��Ա���ݴ�����
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com
 * ----------------------------------------------------------------------------
 * ����һ����ѿ�Դ�����������ζ���������ڲ�������ҵĿ�ĵ�ǰ���¶Գ������
 * �����޸ġ�ʹ�ú��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: dvbbs.php 17217 2011-01-19 06:29:08Z liubo $
 */

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

/* ģ��Ļ�����Ϣ */
if (isset($set_modules) && $set_modules == TRUE)
{
    $i = (isset($modules)) ? count($modules) : 0;

    /* ��Ա�������ϲ���Ĵ��������ļ�������һ�� */
    $modules[$i]['code']    = 'dvbbs';

    /* �����ϵĵ�������������� */
    $modules[$i]['name']    = 'DVBBS for PHP';

    /* �����ϵĵ���������İ汾 */
    $modules[$i]['version'] = '1.0.x/2.0';

    /* ��������� */
    $modules[$i]['author']  = 'ECSHOP R&D TEAM';

    /* ������ߵĹٷ���վ */
    $modules[$i]['website'] = 'http://www.ecshop.com';

    /* ����ĳ�ʼ��Ĭ��ֵ */
    $modules[$i]['default']['db_host'] = 'localhost';
    $modules[$i]['default']['db_user'] = 'root';
    $modules[$i]['default']['prefix'] = 'dv_';
    $modules[$i]['default']['cookie_prefix'] = 'dvbbs_';

    return;
}

require_once(ROOT_PATH . 'includes/modules/integrates/integrate.php');
class dvbbs extends integrate
{
    var $cookie_prefix = '';
    var $authkey = '';

    function __construct($cfg)
    {
        $this->dvbbs($cfg);
    }

    /**
     *
     *
     * @access  public
     * @param
     *
     * @return void
     */
    function dvbbs($cfg)
    {
        parent::integrate($cfg);
        if ($this->error)
        {
            /* ���ݿ����ӳ��� */
            return false;
        }
        $this->cookie_prefix = $cfg['cookie_prefix'];
        $this->field_id = 'userid';
        $this->field_name = 'username';
        $this->field_email = 'useremail';
        $this->field_gender = 'usersex';
        $this->field_bday = 'userbirthday';
        $this->field_pass = 'userpassword';
        $this->field_reg_date = 'joindate';
        $this->user_table = 'user';


        /* ������ݱ��Ƿ���� */
        $sql = "SHOW TABLES LIKE '" . $this->prefix . "%'";

        $exist_tables = $this->db->getCol($sql);

        if (empty($exist_tables) || (!in_array($this->prefix.$this->user_table, $exist_tables)))
        {
            $this->error = 2;
            /* ȱ�����ݱ� */
            return false;
        }
    }

    /**
     *  ��ȡ��̳��Ч���ּ���λ
     *
     * @access  public
     * @param
     *
     * @return void
     */
    function get_points_name ()
    {
        static $ava_credits = NULL;
        if ($ava_credits === NULL)
        {
            $ava_credits = array();
            $ava_credits['usermoney'] = array('title'=>'��Ǯ', 'unit'=>'');
            $ava_credits['userep'] = array('title'=>'����', 'unit'=>'');
            $ava_credits['usercp'] = array('title'=>'����', 'unit'=>'');
        }

        return $ava_credits;
    }

    /**
     *  ��ȡ�û�����
     *
     * @access  public
     * @param
     *
     * @return array
     */
    function get_points($username)
    {
        $credits = $this->get_points_name();
        $fileds = array_keys($credits);
        if ($fileds)
        {
            if ($this->charset != 'UTF8')
            {
                $username = ecs_iconv('UTF8', $this->charset,  $username);
            }
            $sql = "SELECT " . $this->field_id . ', ' . implode(', ',$fileds).
                   " FROM " . $this->table($this->user_table).
                   " WHERE " . $this->field_name . "='$username'";
            $row = $this->db->getRow($sql);
            return $row;
        }
        else
        {
            return false;
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
    function set_points ($username, $credits)
    {
        $user_set = array_keys($credits);
        $points_set = array_keys($this->get_points_name());

        $set = array_intersect($user_set, $points_set);

        if ($set)
        {
            if ($this->charset != 'UTF8')
            {
                $username = ecs_iconv('UTF8', $this->charset,  $username);
            }
            $tmp = array();
            foreach ($set as $credit)
            {
               $tmp[] = $credit . '=' . $credit . '+' . $credits[$credit];
            }
            $sql = "UPDATE " . $this->table($this->user_table).
                   " SET " . implode(', ', $tmp).
                   " WHERE " . $this->field_name . " = '$username'";
            $this->db->query($sql);
        }

        return true;
    }

    /**
     *  ������̳cookie
     *
     * @access  public
     * @param
     *
     * @return void
     */
    function set_cookie ($username="")
    {
        parent::set_cookie($username);
        if (empty($username))
        {
            $time = time() - 3600;
            setcookie($this->cookie_prefix . 'userid', '', $time, $this->cookie_path, $this->cookie_domain);
            setcookie($this->cookie_prefix . 'username', '', $time, $this->cookie_path, $this->cookie_domain);
            setcookie($this->cookie_prefix . 'password', '', $time, $this->cookie_path, $this->cookie_domain);
            setcookie($this->cookie_prefix . 'userhidden', '', $time, $this->cookie_path, $this->cookie_domain);
            setcookie($this->cookie_prefix . 'onlinecachetime', '', $time, $this->cookie_path, $this->cookie_domain);
        }
        else
        {
            if ($this->charset != 'UTF8')
            {
                $username = ecs_iconv('UTF8', $this->charset, $username);
            }
            $sql = "SELECT " . $this->field_id . " AS user_id, truepassword, userhidden ".
                   " FROM " . $this->table($this->user_table) . " WHERE " . $this->field_name . "='$username'";

            $row = $this->db->getRow($sql);

            setcookie($this->cookie_prefix . 'userid', $row['user_id'], time() + 3600 * 24 * 30, $this->cookie_path, $this->cookie_domain);
            setcookie($this->cookie_prefix . 'username', $username, time() + 3600 * 24 * 30, $this->cookie_path, $this->cookie_domain);
            setcookie($this->cookie_prefix . 'password', $row['truepassword'], time() + 3600 * 24 * 30, $this->cookie_path, $this->cookie_domain);
            setcookie($this->cookie_prefix . 'userhidden', $row['userhidden'], time() + 3600 * 24 * 30, $this->cookie_path, $this->cookie_domain);
        }
    }

    /**
     * ���cookie
     *
     * @access  public
     * @param
     *
     * @return void
     */
    function check_cookie ()
    {
        if (empty($_COOKIE[$this->cookie_prefix . 'userid']) || empty($_COOKIE[$this->cookie_prefix . 'password']))
        {
            return '';
        }

        $user_id = intval($_COOKIE[$this->cookie_prefix . 'userid']);
        $true_password = addslashes_deep($_COOKIE[$this->cookie_prefix . 'password']);

        $sql = "SELECT  ". $this->field_name . " AS user_name ".
               " FROM " . $this->table($this->user_table) .
               " WHERE " . $this->field_id . "='$user_id' AND truepassword='$true_password'";

        $username = $this->db->getOne($sql);

        if (empty($username))
        {
            return '';
        }

        if ($this->charset != 'UTF8')
        {
            $username = ecs_iconv($this->charset, 'UTF8', $username);
        }

        return $username;
    }

/**
     *  �������뺯��
     *
     * @access  public
     * @param   array   $cfg ��������Ϊ $password, $md5password, $salt, $type
     *
     * @return void
     */
    function compile_password ($cfg)
    {
       if ((!empty($cfg['password'])) && empty($cfg['md5password']))
       {
            $cfg['md5password'] = md5($cfg['password']);
       }

       if (empty($cfg['md5password']))
       {
           return '';
       }

       return substr($cfg['md5password'], 8, 16);

    }


}