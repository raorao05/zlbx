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
 * $Id: discuz55.php 17217 2011-01-19 06:29:08Z liubo $
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
    $modules[$i]['code']    = 'discuz55';

    /* �����ϵĵ�������������� */
    $modules[$i]['name']    = 'Discuz!';

    /* �����ϵĵ���������İ汾 */
    $modules[$i]['version'] = '5.5/6.0';

    /* ��������� */
    $modules[$i]['author']  = 'ECSHOP R&D TEAM';

    /* ������ߵĹٷ���վ */
    $modules[$i]['website'] = 'http://www.ecshop.com';

    /* ����ĳ�ʼ��Ĭ��ֵ */
    $modules[$i]['default']['db_host'] = 'localhost';
    $modules[$i]['default']['db_user'] = 'root';
    $modules[$i]['default']['prefix'] = 'cdb_';
    $modules[$i]['default']['cookie_prefix'] = 'xnW_';

    return;
}

require_once(ROOT_PATH . 'includes/modules/integrates/integrate.php');
class discuz55 extends integrate
{
    var $cookie_prefix = '';
    var $authkey = '';

    function __construct($cfg)
    {
        $this->discuz55($cfg);
    }

    /**
     *
     *
     * @access  public
     * @param
     *
     * @return void
     */
    function discuz55($cfg)
    {
        parent::integrate($cfg);
        if ($this->error)
        {
            /* ���ݿ����ӳ��� */
            return false;
        }
        $this->cookie_prefix = $cfg['cookie_prefix'];
        $this->field_id = 'uid';
        $this->field_name = 'username';
        $this->field_email = 'email';
        $this->field_gender = 'gender';
        $this->field_bday = 'bday';
        $this->field_pass = 'password';
        $this->field_reg_date = 'regdate';
        $this->user_table = 'members';

        /* ������ݱ��Ƿ���� */
        $sql = "SHOW TABLES LIKE '" . $this->prefix . "%'";

        $exist_tables = $this->db->getCol($sql);

        if (empty($exist_tables) || (!in_array($this->prefix.$this->user_table, $exist_tables)) || (!in_array($this->prefix.'settings', $exist_tables)))
        {
            $this->error = 2;
            /* ȱ�����ݱ� */
            return false;
        }

        $key = $this->db->GetOne('SELECT value FROM ' . $this->table('settings') . " WHERE variable = 'authkey'");
        if (empty($_SERVER['HTTP_USER_AGENT']))
        {
            $this->authkey = md5($key);
        }
        else
        {
            $this->authkey = md5($key . $_SERVER['HTTP_USER_AGENT']);
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
            $sql = "SELECT value FROM " . $this->table('settings') . " WHERE variable='extcredits'";
            $str = $this->db->getOne($sql);
            $extcredits = @unserialize($str);

            $ava_credits = array();
            if ($extcredits)
            {
                $count = count($extcredits);
                for ($i=1; $i <= $count; $i++)
                {
                    if (!empty($extcredits[$i]['available']))
                    {
                        $ava_credits['extcredits' . $i]['title']  = empty($extcredits[$i]['title'])? '' : $extcredits[$i]['title'];
                        $ava_credits['extcredits' . $i]['unit']  = empty($extcredits[$i]['unit'])? '' : $extcredits[$i]['unit'];
                    }
                }
            }
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
                $username = ecs_iconv('UTF8', $this->charset, $username);
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
                $username = ecs_iconv('UTF8', $this->charset, $username);
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
            setcookie($this->cookie_prefix.'sid', '', $time, $this->cookie_path, $this->cookie_domain);
            setcookie($this->cookie_prefix.'auth', '', $time, $this->cookie_path, $this->cookie_domain);
        }
        else
        {
            if ($this->charset != 'UTF8')
            {
                $username = ecs_iconv('UTF8', $this->charset, $username);
            }
            $sql = "SELECT " . $this->field_id . " AS user_id, secques AS salt, " . $this->field_pass . " As password ".
                   " FROM " . $this->table($this->user_table) . " WHERE " . $this->field_name . "='$username'";

            $row = $this->db->getRow($sql);

            setcookie($this->cookie_prefix.'sid', $this->random(6), time() + 3600 * 24 * 30, $this->cookie_path, $this->cookie_domain);
            setcookie($this->cookie_prefix.'auth', $this->authcode($row['password']."\t".$row['salt']."\t".$row['user_id'], 'ENCODE'), time() + 3600 * 24 * 30, $this->cookie_path, $this->cookie_domain);
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
        if (isset($_COOKIE[$this->cookie_prefix . 'auth']))
        {
            $arr = addslashes_deep(explode("\t", $this->authcode($_COOKIE[$this->cookie_prefix . 'auth'], 'DECODE')));
            if (count($arr) != 3)
            {
                return false;
            }
            else
            {
                list($discuz_pw, $discuz_secques, $discuz_uid) = $arr;
            }

            $sql = "SELECT " . $this->field_name ." AS user_name".
                   " FROM " . $this->table($this->user_table) .
                   " WHERE ".$this->field_id." = '$discuz_uid' AND ".$this->field_pass." = '$discuz_pw'";
            $username = $this->db->getOne($sql);
            if ($username && ($this->charset != 'UTF8'))
            {
                $username = ecs_iconv($this->charset, 'UTF8', $username);
            }

            return $username;
        }
        else
        {
            return '';
        }
    }

    /**
     * ������û��ĺ���
     *
     * @access      public
     * @param       string      username    �û���
     * @param       string      password    ��¼����
     * @param       string      email       �ʼ���ַ
     * @param       string      bday        ����
     * @param       string      gender      �Ա�
     * @return      int         �������µ�ID
     */
    function add_user($username, $password, $email, $gender = -1, $bday = 0, $reg_date=0, $md5password='')
    {
        $result = parent::add_user($username, $password, $email, $gender, $bday, $reg_date, $md5password);

        if (!$result)
        {
            return false;
        }

        /* ���Ĭ�ϵ��û��� */
        $sql = 'SELECT groupid FROM ' .$this->table('usergroups'). ' WHERE creditshigher <= 0 AND creditslower > 0';

        $grp = $this->db->getOne($sql);

        if ($this->charset != 'UTF8')
        {
            $username = ecs_iconv('UTF8', $this->charset, $username);
        }

        /* ������id */
        $sql = "UPDATE " . $this->table($this->user_table) .
               " SET groupid= '$grp', ".
               " regip = '" . real_ip() . "',".
               " regdate = '" . time() . "'".
               " WHERE " . $this->field_name . "='$username'";
        $this->db->query($sql);

        /* ����memberfields�� */
        $sql = 'INSERT INTO '. $this->table('memberfields') .' ('. $this->field_id .") " .
               " SELECT " . $this->field_id .
               " FROM " . $this->table($this->user_table) .
               " WHERE " . $this->field_name . "='$username'";
        $this->db->query($sql);

        return true;
    }

    /**
     * discuz 5.5 ���ܺ���,��/include/global.func.php���
     *
     * @access  public
     * @param
     *
     * @return void
     */
    function authcode($string, $operation, $key = '')
    {
        $key = md5($key ? $key : $this->authkey);
        $key_length = strlen($key);

        $string = $operation == 'DECODE' ? base64_decode($string) : substr(md5($string.$key), 0, 8) . $string;
        $string_length = strlen($string);

        $rndkey = $box = array();
        $result = '';

        for ($i = 0; $i <= 255; $i++)
        {
            $rndkey[$i] = ord($key[$i % $key_length]);
            $box[$i] = $i;
        }

        for ($j = $i = 0; $i < 256; $i++)
        {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }

        for ($a = $j = $i = 0; $i < $string_length; $i++)
        {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }

        if ($operation == 'DECODE')
        {
            if (substr($result, 0, 8) == substr(md5(substr($result, 8).$key), 0, 8))
            {
                return substr($result, 8);
            }
            else
            {
                return '';
            }
        }
        else
        {
            return str_replace('=', '', base64_encode($result));
        }
    }

    /**
     * discuz 5.5 �������,��/include/global.func.php���
     *
     * @access  public
     * @param
     *
     * @return void
     */

    function random($length, $numeric = 0) {
        PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);
        if($numeric) {
            $hash = sprintf('%0'.$length.'d', mt_rand(0, pow(10, $length) - 1));
        } else {
            $hash = '';
            $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
            $max = strlen($chars) - 1;
            for($i = 0; $i < $length; $i++) {
                $hash .= $chars[mt_rand(0, $max)];
            }
        }
        return $hash;
    }

}