<?php

/**
 * ECSHOP ���ϲ����Ļ���
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com
 * ----------------------------------------------------------------------------
 * ����һ����ѿ�Դ�����������ζ���������ڲ�������ҵĿ�ĵ�ǰ���¶Գ������
 * �����޸ġ�ʹ�ú��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: integrate.php 17217 2011-01-19 06:29:08Z liubo $
*/

class integrate
{

    /*------------------------------------------------------ */
    //-- PUBLIC ATTRIBUTEs
    /*------------------------------------------------------ */

    /* ���϶���ʹ�õ����ݿ����� */
    var $db_host        = '';

    /* ���϶���ʹ�õ����ݿ��� */
    var $db_name        = '';

    /* ���϶���ʹ�õ����ݿ��û��� */
    var $db_user        = '';

    /* ���϶���ʹ�õ����ݿ����� */
    var $db_pass        = '';

    /* ���϶������ݱ�ǰ׺ */
    var $prefix         = '';

    /* ���ݿ���ʹ�ñ��� */
    var $charset        = '';

    /* ���϶���ʹ�õ�cookie��domain */
    var $cookie_domain  = '';

    /* ���϶���ʹ�õ�cookie��path */
    var $cookie_path    = '/';

    /* ���϶����Ա���� */
    var $user_table = '';

    /* ��ԱID���ֶ��� */
    var $field_id       = '';

    /* ��Ա���Ƶ��ֶ��� */
    var $field_name     = '';

    /* ��Ա������ֶ��� */
    var $field_pass     = '';

    /* ��Ա������ֶ��� */
    var $field_email    = '';

    /* ��Ա�Ա� */
    var $field_gender = '';

    /* ��Ա���� */
    var $field_bday = '';

    /* ע�����ڵ��ֶ��� */
    var $field_reg_date = '';

    /* �Ƿ���Ҫͬ�����ݵ��̳� */
    var $need_sync = true;

    var $error          = 0;
	
	/* ��Աͷ�� by neo */
    var $field_avatar = '';

    /*------------------------------------------------------ */
    //-- PRIVATE ATTRIBUTEs
    /*------------------------------------------------------ */

    var $db;

    /*------------------------------------------------------ */
    //-- PUBLIC METHODs
    /*------------------------------------------------------ */

    /**
     * ��Ա�������ϲ����Ĺ��캯��
     *
     * @access      public
     * @param       string  $db_host    ���ݿ�����
     * @param       string  $db_name    ���ݿ���
     * @param       string  $db_user    ���ݿ��û���
     * @param       string  $db_pass    ���ݿ�����
     * @return      void
     */
    function integrate($cfg)
    {
        $this->charset = isset($cfg['db_charset']) ? $cfg['db_charset'] : 'UTF8';
        $this->prefix = isset($cfg['prefix']) ? $cfg['prefix'] : '';
        $this->db_name = isset($cfg['db_name']) ? $cfg['db_name'] : '';
        $this->cookie_domain = isset($cfg['cookie_domain']) ? $cfg['cookie_domain'] : '';
        $this->cookie_path = isset($cfg['cookie_path']) ? $cfg['cookie_path'] : '/';
        $this->need_sync = true;

        $quiet = empty($cfg['quiet']) ? 0 : 1;

        /* ��ʼ�����ݿ� */
        if (empty($cfg['db_host']))
        {
            $this->db_name = $GLOBALS['ecs']->db_name;
            $this->prefix = $GLOBALS['ecs']->prefix;
            $this->db = &$GLOBALS['db'];
        }
        else
        {
            if (empty($cfg['is_latin1']))
            {
                $this->db = new cls_mysql($cfg['db_host'], $cfg['db_user'], $cfg['db_pass'], $cfg['db_name'], $this->charset, NULL,  $quiet);
            }
            else
            {
                $this->db = new cls_mysql($cfg['db_host'], $cfg['db_user'], $cfg['db_pass'], $cfg['db_name'], 'latin1', NULL, $quiet) ;
            }
        }

        if (!is_resource($this->db->link_id))
        {
            $this->error = 1; //���ݿ��ַ�ʺ�
        }
        else
        {
            $this->error = $this->db->errno();
        }
    }

    /**
     *  �û���¼����
     *
     * @access  public
     * @param   string  $username
     * @param   string  $password
     *
     * @return void
     */
    function login($username, $password, $remember = null)
    {
        if ($this->check_user($username, $password) > 0)
        {
            if ($this->need_sync)
            {
                $this->sync($username,$password);
            }
            $this->set_session($username);
            $this->set_cookie($username, $remember);

            return true;
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
    function logout ()
    {
        $this->set_cookie(); //���cookie
        $this->set_session(); //���session
    }

    /**
     *  ���һ�����û�
     *
     * @access  public
     * @param
     *
     * @return int
     */
    function add_user($username, $password, $email, $gender = -1, $bday = 0, $reg_date=0, $md5password='')
    {
        /* ���û���ӵ����Ϸ� */
        if ($this->check_user($username) > 0)
        {
            $this->error = ERR_USERNAME_EXISTS;

            return false;
        }
        /* ���email�Ƿ��ظ� */
        /*$sql = "SELECT " . $this->field_id .
               " FROM " . $this->table($this->user_table).
               " WHERE " . $this->field_email . " = '$email'";
        if ($this->db->getOne($sql, true) > 0)
        {
            $this->error = ERR_EMAIL_EXISTS;

            return false;
        }*/

        $post_username = $username;

        if ($md5password)
        {
            $post_password = $this->compile_password(array('md5password'=>$md5password));
        }
        else
        {
            $post_password = $this->compile_password(array('password'=>$password));
        }

        $fields = array($this->field_name, $this->field_email, $this->field_pass);
        $values = array($post_username, $email, $post_password);

        if ($gender > -1)
        {
            $fields[] = $this->field_gender;
            $values[] = $gender;
        }
        if ($bday)
        {
            $fields[] = $this->field_bday;
            $values[] = $bday;
        }
        if ($reg_date)
        {
            $fields[] = $this->field_reg_date;
            $values[] = $reg_date;
        }

        $sql = "INSERT INTO " . $this->table($this->user_table).
               " (" . implode(',', $fields) . ")".
               " VALUES ('" . implode("', '", $values) . "')";

        $this->db->query($sql);

        if ($this->need_sync)
        {
            $this->sync($username, $password);
        }

        return true;
    }

    /**
     *  �༭�û���Ϣ($password, $email, $gender, $bday)
     *
     * @access  public
     * @param
     *
     * @return void
     */
    function edit_user($cfg)
    {
        if (empty($cfg['username']))
        {
            return false;
        }
        else
        {
            $cfg['post_username'] = $cfg['username'];

        }

        $values = array();
        if (!empty($cfg['password']) && empty($cfg['md5password']))
        {
            $cfg['md5password'] = md5($cfg['password']);
        }
        if ((!empty($cfg['md5password'])) && $this->field_pass != 'NULL')
        {
            $values[] = $this->field_pass . "='" . $this->compile_password(array('md5password'=>$cfg['md5password'])) . "'";
        }

        if ((!empty($cfg['email'])) && $this->field_email != 'NULL')
        {
            /* ���email�Ƿ��ظ� */
            $sql = "SELECT " . $this->field_id .
                   " FROM " . $this->table($this->user_table).
                   " WHERE " . $this->field_email . " = '$cfg[email]' ".
                   " AND " . $this->field_name . " != '$cfg[post_username]'";
            if ($this->db->getOne($sql, true) > 0)
            {
                $this->error = ERR_EMAIL_EXISTS;

                return false;
            }
            // ����Ƿ�Ϊ��E-mail
            $sql = "SELECT count(*)" .
                   " FROM " . $this->table($this->user_table).
                   " WHERE " . $this->field_email . " = '$cfg[email]' ";
            if($this->db->getOne($sql, true) == 0)
            {
                // �µ�E-mail
                $sql = "UPDATE " . $GLOBALS['ecs']->table('users') . " SET is_validated = 0 WHERE user_name = '$cfg[post_username]'";
                $this->db->query($sql);
            }
            $values[] = $this->field_email . "='". $cfg['email'] . "'";
        }

        if (isset($cfg['gender']) && $this->field_gender != 'NULL')
        {
            $values[] = $this->field_gender . "='" . $cfg['gender'] . "'";
        }

        if ((!empty($cfg['bday'])) && $this->field_bday != 'NULL')
        {
            $values[] = $this->field_bday . "='" . $cfg['bday'] . "'";
        }
		
		//��Աͷ�� by neo
		if ((!empty($cfg['avatar'])) && $this->field_avatar != 'NULL')
		{
			$values[] = $this->field_avatar . "='" . $cfg['avatar'] . "'";
		}
		
		//����
		if (!empty($cfg['alias']))
		{
			$values[] = 'alias' . "='" . $cfg['alias'] . "'";
		}
		
		//֤����
		if (!empty($cfg['zj_number']))
		{
			$values[] = 'zj_number' . "='" . $cfg['zj_number'] . "'";
		}
		
		//�Ƽ���
		if (!empty($cfg['parent_id']))
		{
			$values[] = 'parent_id' . "='" . $cfg['parent_id'] . "'";
		}

        if ($values)
        {
            $sql = "UPDATE " . $this->table($this->user_table).
                   " SET " . implode(', ', $values).
                   " WHERE " . $this->field_name . "='" . $cfg['post_username'] . "' LIMIT 1";

            $this->db->query($sql);

            if ($this->need_sync)
            {
                if (empty($cfg['md5password']))
                {
                    $this->sync($cfg['username']);
                }
                else
                {
                    $this->sync($cfg['username'], '', $cfg['md5password']);
                }
            }
        }

        return true;
    }

    /**
     * ɾ���û�
     *
     * @access  public
     * @param
     *
     * @return void
     */
    function remove_user($id)
    {
        $post_id = $id;

        if ($this->need_sync || (isset($this->is_ecshop) && $this->is_ecshop))
        {
            /* �����Ҫͬ������ecshop���ִ���ⲿ�ִ��� */
            $sql = "SELECT user_id FROM "  . $GLOBALS['ecs']->table('users') . " WHERE ";
            $sql .= (is_array($post_id)) ? db_create_in($post_id, 'user_name') : "user_name='". $post_id . "' LIMIT 1";
            $col = $GLOBALS['db']->getCol($sql);

            if ($col)
            {
                $sql = "UPDATE " . $GLOBALS['ecs']->table('users') . " SET parent_id = 0 WHERE " . db_create_in($col, 'parent_id'); //��ɾ���û����¼���parent_id ��Ϊ0
                $GLOBALS['db']->query($sql);
                $sql = "DELETE FROM " . $GLOBALS['ecs']->table('users') . " WHERE " . db_create_in($col, 'user_id'); //ɾ���û�
                $GLOBALS['db']->query($sql);
                /* ɾ���û����� */
                $sql = "SELECT order_id FROM " . $GLOBALS['ecs']->table('order_info') . " WHERE " . db_create_in($col, 'user_id');
                $GLOBALS['db']->query($sql);
                $col_order_id = $GLOBALS['db']->getCol($sql);
                if ($col_order_id)
                {
                    $sql = "DELETE FROM " . $GLOBALS['ecs']->table('order_info') . " WHERE " . db_create_in($col_order_id, 'order_id');
                    $GLOBALS['db']->query($sql);
                    $sql = "DELETE FROM " . $GLOBALS['ecs']->table('order_goods') . " WHERE " . db_create_in($col_order_id, 'order_id');
                    $GLOBALS['db']->query($sql);
                }

                $sql = "DELETE FROM " . $GLOBALS['ecs']->table('booking_goods') . " WHERE " . db_create_in($col, 'user_id'); //ɾ���û�
                $GLOBALS['db']->query($sql);
                $sql = "DELETE FROM " . $GLOBALS['ecs']->table('collect_goods') . " WHERE " . db_create_in($col, 'user_id'); //ɾ����Ա�ղ���Ʒ
                $GLOBALS['db']->query($sql);
                $sql = "DELETE FROM " . $GLOBALS['ecs']->table('feedback') . " WHERE " . db_create_in($col, 'user_id'); //ɾ���û�����
                $GLOBALS['db']->query($sql);
                $sql = "DELETE FROM " . $GLOBALS['ecs']->table('user_address') . " WHERE " . db_create_in($col, 'user_id'); //ɾ���û���ַ
                $GLOBALS['db']->query($sql);
                $sql = "DELETE FROM " . $GLOBALS['ecs']->table('user_bonus') . " WHERE " . db_create_in($col, 'user_id'); //ɾ���û����
                $GLOBALS['db']->query($sql);
                $sql = "DELETE FROM " . $GLOBALS['ecs']->table('user_account') . " WHERE " . db_create_in($col, 'user_id'); //ɾ���û��ʺŽ��
                $GLOBALS['db']->query($sql);
                $sql = "DELETE FROM " . $GLOBALS['ecs']->table('tag') . " WHERE " . db_create_in($col, 'user_id'); //ɾ���û����
                $GLOBALS['db']->query($sql);
                $sql = "DELETE FROM " . $GLOBALS['ecs']->table('account_log') . " WHERE " . db_create_in($col, 'user_id'); //ɾ���û���־
                $GLOBALS['db']->query($sql);
            }
        }

        if (isset($this->ecshop) && $this->ecshop)
        {
            /* �����ecshop���ֱ���˳� */
            return;
        }

        $sql = "DELETE FROM " . $this->table($this->user_table) . " WHERE ";
        if (is_array($post_id))
        {
            $sql .= db_create_in($post_id, $this->field_name);
        }
        else
        {
            $sql .= $this->field_name . "='" . $post_id . "' LIMIT 1";
        }

        $this->db->query($sql);
    }

    /**
     *  ��ȡָ���û�����Ϣ
     *
     * @access  public
     * @param
     *
     * @return void
     */
    function get_profile_by_name($username)
    {
        $post_username = $username;

        $sql = "SELECT " . $this->field_id . " AS user_id," . $this->field_name . " AS user_name," .
                    $this->field_email . " AS email," . $this->field_gender ." AS sex,".
                    $this->field_bday . " AS birthday," . $this->field_reg_date . " AS reg_time, ".
                    $this->field_pass . " AS password ".
               " FROM " . $this->table($this->user_table) .
               " WHERE " .$this->field_name . "='$post_username'";
        $row = $this->db->getRow($sql);

        return $row;
    }

    /**
     *  ��ȡָ���û�����Ϣ
     *
     * @access  public
     * @param
     *
     * @return void
     */
    function get_profile_by_id($id)
    {
        $sql = "SELECT " . $this->field_id . " AS user_id," . $this->field_name . " AS user_name," .
                    $this->field_email . " AS email," . $this->field_gender ." AS sex,".
                    $this->field_bday . " AS birthday," . $this->field_reg_date . " AS reg_time, ".
                    $this->field_pass . " AS password ".
               " FROM " . $this->table($this->user_table) .
               " WHERE " .$this->field_id . "='$id'";
        $row = $this->db->getRow($sql);

        return $row;
    }

    /**
     *  ���ݵ�¼״̬����cookie
     *
     * @access  public
     * @param
     *
     * @return void
     */
    function get_cookie()
    {
        $id = $this->check_cookie();
        if ($id)
        {
            if ($this->need_sync)
            {
                $this->sync($id);
            }
            $this->set_session($id);

            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     *  ���ָ���û��Ƿ���ڼ������Ƿ���ȷ
     *
     * @access  public
     * @param   string  $username   �û���
     *
     * @return  int
     */
    function check_user($username, $password = null)
    {

        $post_username = $username;

        /* ���û�ж���������ֻ����û��� */
        if ($password === null)
        {
            $sql = "SELECT " . $this->field_id .
                   " FROM " . $this->table($this->user_table).
                   " WHERE " . $this->field_name . "='" . $post_username . "'";

            return $this->db->getOne($sql);
        }
        else
        {
            $sql = "SELECT " . $this->field_id .
                   " FROM " . $this->table($this->user_table).
                   " WHERE " . $this->field_name . "='" . $post_username . "' AND " . $this->field_pass . " ='" . $this->compile_password(array('password'=>$password)) . "'";

            return  $this->db->getOne($sql);
        }
    }

    /**
     *  ���ָ�������Ƿ����
     *
     * @access  public
     * @param   string  $email   �û�����
     *
     * @return  boolean
     */
    function check_email($email)
    {
        if (!empty($email))
        {
          /* ���email�Ƿ��ظ� */
            $sql = "SELECT " . $this->field_id .
                       " FROM " . $this->table($this->user_table).
                       " WHERE " . $this->field_email . " = '$email' ";
            if ($this->db->getOne($sql, true) > 0)
            {
                $this->error = ERR_EMAIL_EXISTS;
                return true;
            }
            return false;
        }
    }


    /**
     *  ���cookie����ȷ�������û���
     *
     * @access  public
     * @param
     *
     * @return void
     */
    function check_cookie()
    {
        return '';
    }

    /**
     *  ����cookie
     *
     * @access  public
     * @param
     *
     * @return void
     */
    function set_cookie($username='', $remember= null )
    {
        if (empty($username))
        {
            /* �ݻ�cookie */
            $time = time() - 3600;
            setcookie("ECS[user_id]",  '', $time, $this->cookie_path);            
            setcookie("ECS[password]", '', $time, $this->cookie_path);

        }
        elseif ($remember)
        {
            /* ����cookie */
            $time = time() + 3600 * 24 * 15;

            setcookie("ECS[username]", $username, $time, $this->cookie_path, $this->cookie_domain);
            $sql = "SELECT user_id, password FROM " . $GLOBALS['ecs']->table('users') . " WHERE user_name='$username' LIMIT 1";
            $row = $GLOBALS['db']->getRow($sql);
            if ($row)
            {
                setcookie("ECS[user_id]", $row['user_id'], $time, $this->cookie_path, $this->cookie_domain);
                setcookie("ECS[password]", $row['password'], $time, $this->cookie_path, $this->cookie_domain);
            }
        }
    }

    /**
     *  ����ָ���û�SESSION
     *
     * @access  public
     * @param
     *
     * @return void
     */
    function set_session ($username='')
    {
        if (empty($username))
        {
            $GLOBALS['sess']->destroy_session();
        }
        else
        {
            $sql = "SELECT user_id, password, email FROM " . $GLOBALS['ecs']->table('users') . " WHERE user_name='$username' LIMIT 1";
            $row = $GLOBALS['db']->getRow($sql);

            if ($row)
            {
                $_SESSION['user_id']   = $row['user_id'];
                $_SESSION['user_name'] = $username;
                $_SESSION['email']     = $row['email'];
            }
        }
    }


    /**
     * �ڸ����ı���ǰ�������ݿ����Լ�ǰ׺
     *
     * @access  private
     * @param   string      $str    ����
     *
     * @return void
     */
    function table($str)
    {
        return '`' .$this->db_name. '`.`'.$this->prefix.$str.'`';
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
       if (isset($cfg['password']))
       {
            $cfg['md5password'] = md5($cfg['password']);
       }
       if (empty($cfg['type']))
       {
            $cfg['type'] = PWD_MD5;
       }

       switch ($cfg['type'])
       {
           case PWD_MD5 :
              	if(!empty($cfg['ec_salt']))
		       {
			       return md5($cfg['md5password'].$cfg['ec_salt']);
		       }
			   else
		       {
                    return $cfg['md5password'];
			   }

           case PWD_PRE_SALT :
               if (empty($cfg['salt']))
               {
                    $cfg['salt'] = '';
               }

               return md5($cfg['salt'] . $cfg['md5password']);

           case PWD_SUF_SALT :
               if (empty($cfg['salt']))
               {
                    $cfg['salt'] = '';
               }

               return md5($cfg['md5password'] . $cfg['salt']);

           default:
               return '';
       }
    }

    /**
     *  ��Աͬ��
     *
     * @access  public
     * @param
     *
     * @return void
     */
    function sync ($username, $password='', $md5password='')
    {
        if ((!empty($password)) && empty($md5password))
        {
            $md5password = md5($password);
        }

        $main_profile = $this->get_profile_by_name($username);

        if (empty($main_profile))
        {
            return false;
        }

        $sql = "SELECT user_name, email, password, sex, birthday".
               " FROM " . $GLOBALS['ecs']->table('users').
               " WHERE user_name = '$username'";

        $profile = $GLOBALS['db']->getRow($sql);
        if (empty($profile))
        {
            /* ���̳Ǳ����һ���¼�¼ */
            if (empty($md5password))
            {
               $sql = "INSERT INTO " . $GLOBALS['ecs']->table('users').
                            "(user_name, email, sex, birthday, reg_time)".
                      " VALUES('$username', '" .$main_profile['email']."','".
                            $main_profile['sex'] . "','" . $main_profile['birthday'] . "','" . $main_profile['reg_time'] . "')";
            }
            else
            {
               $sql = "INSERT INTO " . $GLOBALS['ecs']->table('users').
                            "(user_name, email, sex, birthday, reg_time, password)".
                      " VALUES('$username', '" .$main_profile['email']."','".
                            $main_profile['sex'] . "','" . $main_profile['birthday'] . "','" .
                            $main_profile['reg_time'] . "', '$md5password')";

            }

            $GLOBALS['db']->query($sql);

            return true;
        }
        else
        {
            $values = array();
            if ($main_profile['email'] != $profile['email'])
            {
                $values[] = "email='" . $main_profile['email'] . "'";
            }
            if ($main_profile['sex'] != $profile['sex'])
            {
                $values[] = "sex='" . $main_profile['sex'] . "'";
            }
            if ($main_profile['birthday'] != $profile['birthday'])
            {
                $values[] = "birthday='" . $main_profile['birthday'] . "'";
            }
            if ((!empty($md5password)) && ($md5password != $profile['password']))
            {
                $values[] = "password='" . $md5password . "'";
            }

            if (empty($values))
            {
                return  true;
            }
            else
            {
                $sql = "UPDATE " . $GLOBALS['ecs']->table('users').
                       " SET " . implode(", ", $values).
                       " WHERE user_name='$username'";

                $GLOBALS['db']->query($sql);

                return true;
            }
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
        return array();
    }

    /**
     *  ��ȡ�û�����
     *
     * @access  public
     * @param
     *
     * @return void
     */
    function get_points($username)
    {
        $credits = $this->get_points_name();
        $fileds = array_keys($credits);
        if ($fileds)
        {
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
     *�����û�����
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

    function get_user_info($username)
    {
        return $this->get_profile_by_name($username);
    }


    /**
     * ������������û������򷵻������û�
     *
     * @access  public
     * @param
     *
     * @return void
     */
    function test_conflict ($user_list)
    {
        if (empty($user_list))
        {
            return array();
        }


        $sql = "SELECT " . $this->field_name . " FROM " . $this->table($this->user_table) . " WHERE " . db_create_in($user_list, $this->field_name);
        $user_list = $this->db->getCol($sql);

        return $user_list;
    }
}
