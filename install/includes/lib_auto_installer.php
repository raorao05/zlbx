<?php

/**
 * ECSHOP ��װ���� ֮ ģ��
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liuhui $
 * $Id: lib_installer.php 16368 2009-06-26 03:39:19Z liuhui $
 */

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

/**
 * ���GD�İ汾��
 *
 * @access  public
 * @return  string     ���ذ汾�ţ����ܵ�ֵΪ0��1��2
 */
function get_gd_version()
{
    include_once(ROOT_PATH . 'includes/cls_image.php');

    return cls_image::gd_version();
}

/**
 * �Ƿ�֧��GD
 *
 * @access  public
 * @return  boolean     �ɹ�����true��ʧ�ܷ���false
 */
function has_supported_gd()
{
    return get_gd_version() === 0 ? false : true;
}

/**
 * �����������Ƿ����ָ�����ļ�����
 *
 * @access  public
 * @param   array     $file_types        �ļ�·�����飬����array('dwt'=>'', 'lbi'=>'', 'dat'=>'')
 * @return  string    ȫ����д���ؿմ������򷵻��Զ��ŷָ����ļ�������ɵ���Ϣ��
 */
function file_types_exists($file_types)
{
    global $_LANG;

    $msg = '';
    foreach ($file_types as $file_type => $file_path)
    {
        if (!file_exists($file_path))
        {
            $msg .= $_LANG['cannt_support_' . $file_type] . ', ';
        }
    }

    $msg = preg_replace("/,\s*$/", '', $msg);

    return $msg;
}

/**
 * ���ϵͳ����Ϣ
 *
 * @access  public
 * @return  array     ϵͳ������Ϣ��ɵ�����
 */
function get_system_info()
{
    global $_LANG;

    $system_info = array();

    /* ���ϵͳ�������� */
    $system_info[] = array($_LANG['php_os'], PHP_OS);
    $system_info[] = array($_LANG['php_ver'], PHP_VERSION);

    /* ���MYSQL֧����� */
    $mysql_enabled = function_exists('mysql_connect') ? $_LANG['support'] : $_LANG['not_support'];
    $system_info[] = array($_LANG['does_support_mysql'], $mysql_enabled);

    /* ���ͼƬ�������� */
    $gd_ver = get_gd_version();
    $gd_ver = empty($gd_ver) ? $_LANG['not_support'] : $gd_ver;
    if ($gd_ver > 0)
    {
        if (PHP_VERSION >= '4.3' && function_exists('gd_info'))
        {
            $gd_info = gd_info();
            $jpeg_enabled = ($gd_info['JPG Support']        === true) ? $_LANG['support'] : $_LANG['not_support'];
            $gif_enabled  = ($gd_info['GIF Create Support'] === true) ? $_LANG['support'] : $_LANG['not_support'];
            $png_enabled  = ($gd_info['PNG Support']        === true) ? $_LANG['support'] : $_LANG['not_support'];
        }
        else
        {
            if (function_exists('imagetypes'))
            {
                $jpeg_enabled = ((imagetypes() & IMG_JPG) > 0) ? $_LANG['support'] : $_LANG['not_support'];
                $gif_enabled  = ((imagetypes() & IMG_GIF) > 0) ? $_LANG['support'] : $_LANG['not_support'];
                $png_enabled  = ((imagetypes() & IMG_PNG) > 0) ? $_LANG['support'] : $_LANG['not_support'];
            }
            else
            {
                $jpeg_enabled = $_LANG['not_support'];
                $gif_enabled  = $_LANG['not_support'];
                $png_enabled  = $_LANG['not_support'];
            }
        }
    }
    else
    {
        $jpeg_enabled = $_LANG['not_support'];
        $gif_enabled  = $_LANG['not_support'];
        $png_enabled  = $_LANG['not_support'];
    }
    $system_info[] = array($_LANG['gd_version'], $gd_ver);
    $system_info[] = array($_LANG['jpeg'], $jpeg_enabled);
    $system_info[] = array($_LANG['gif'],  $gif_enabled);
    $system_info[] = array($_LANG['png'],  $png_enabled);

    /* ���ϵͳ�Ƿ�֧����dwt,lib,datΪ��չ�����ļ� */
    $file_types = array(
            'dwt' => ROOT_PATH . 'themes/default/index.dwt',
            'lbi' => ROOT_PATH . 'themes/default/library/member.lbi',
            'dat' => ROOT_PATH . 'includes/codetable/ipdata.dat'
        );
    $exists_info = file_types_exists($file_types);
    $exists_info = empty($exists_info) ? $_LANG['support_dld'] : $exists_info;
    $system_info[] = array($_LANG['does_support_dld'], $exists_info);

    /* �������Ƿ�ȫģʽ���� */
    $safe_mode = ini_get('safe_mode') == '1' ? $_LANG['safe_mode_on'] : $_LANG['safe_mode_off'];
    $system_info[] = array($_LANG['safe_mode'], $safe_mode);

    return $system_info;
}

/**
 * ������ݿ��б�
 *
 * @access  public
 * @param   string      $db_host        ����
 * @param   string      $db_port        �˿ں�
 * @param   string      $db_user        �û���
 * @param   string      $db_pass        ����
 * @return  mixed       �ɹ��������ݿ��б���ɵ����飬ʧ�ܷ���false
 */
function get_db_list($db_host, $db_port, $db_user, $db_pass)
{
    global $err, $_LANG;
    $databases = array();
    $filter_dbs = array('information_schema', 'mysql');
    $db_host = construct_db_host($db_host, $db_port);
    $conn = @mysql_connect($db_host, $db_user, $db_pass);

    if ($conn === false)
    {
        $err->add($_LANG['connect_failed']);
        return false;
    }
    keep_right_conn($conn);

    $result = mysql_query('SHOW DATABASES', $conn);
    if ($result !== false)
    {
        while (($row = mysql_fetch_assoc($result)) !== false)
        {
            if (in_array($row['Database'], $filter_dbs))
            {
                continue;
            }
            $databases[] = $row['Database'];
        }
    }
    else
    {
        $err->add($_LANG['query_failed']);
        return false;
    }
    @mysql_close($conn);

    return $databases;
}

/**
 * ���ʱ���б������ظ�ֵ��ֻ������һ��
 *
 * @access  public
 * @return  array
 */
function get_timezone_list($lang)
{
    if (file_exists(ROOT_PATH . 'install/data/inc_timezones_' . $lang . '.php'))
    {
        include_once(ROOT_PATH . 'install/data/inc_timezones_' . $lang . '.php');
    }
    else
    {
        include_once(ROOT_PATH . 'install/data/inc_timezones_zh_cn.php');
    }

    return array_unique($timezones);
}

/**
 * ��÷���������ʱ��
 *
 * @access  public
 * @return  string     ����ʱ����������Asia/Shanghai
 */
function get_local_timezone()
{
    if (PHP_VERSION >= '5.1')
    {
        $local_timezone = date_default_timezone_get();
    }
    else
    {
         $local_timezone = '';
    }

    return $local_timezone;
}

/**
 * ����ָ�����ֵ����ݿ�
 *
 * @access  public
 * @param   string      $db_host        ����
 * @param   string      $db_port        �˿ں�
 * @param   string      $db_user        �û���
 * @param   string      $db_pass        ����
 * @param   string      $db_name        ���ݿ���
 * @return  boolean     �ɹ�����true��ʧ�ܷ���false
 */
function create_database($db_host, $db_port, $db_user, $db_pass, $db_name)
{
    global $err, $_LANG;
    $db_host = construct_db_host($db_host, $db_port);
    $conn = @mysql_connect($db_host, $db_user, $db_pass);

    if ($conn === false)
    {
        $err->add($_LANG['connect_failed']);

        return false;
    }

    $mysql_version = mysql_get_server_info($conn);
    keep_right_conn($conn, $mysql_version);
    if (mysql_select_db($db_name, $conn) === false)
    {
        $sql = $mysql_version >= '4.1' ? "CREATE DATABASE $db_name DEFAULT CHARACTER SET " . EC_DB_CHARSET : "CREATE DATABASE $db_name";
        if (mysql_query($sql, $conn) === false)
        {
            $err->add($_LANG['cannt_create_database']);
            return false;
        }
    }
    @mysql_close($conn);

    return true;
}

/**
 * ��֤������ȷ�����ݿ����ӣ����ַ������ã�
 *
 * @access  public
 * @param   string      $conn                      ���ݿ�����
 * @param   string      $mysql_version        mysql�汾��
 * @return  void
 */
function keep_right_conn($conn, $mysql_version='')
{
    if ($mysql_version === '')
    {
        $mysql_version = mysql_get_server_info($conn);
    }

    if ($mysql_version >= '4.1')
    {
        mysql_query('SET character_set_connection=' . EC_DB_CHARSET . ', character_set_results=' . EC_DB_CHARSET . ', character_set_client=binary', $conn);

        if ($mysql_version > '5.0.1')
        {
            mysql_query("SET sql_mode=''", $conn);
        }
    }
}

/**
 * ���������ļ�
 *
 * @access  public
 * @param   string      $db_host        ����
 * @param   string      $db_port        �˿ں�
 * @param   string      $db_user        �û���
 * @param   string      $db_pass        ����
 * @param   string      $db_name        ���ݿ���
 * @param   string      $prefix         ���ݱ�ǰ׺
 * @param   string      $timezone       ʱ��
 * @return  boolean     �ɹ�����true��ʧ�ܷ���false
 */
function create_config_file($db_host, $db_port, $db_user, $db_pass, $db_name, $prefix, $timezone)
{
    global $err, $_LANG;
    $db_host = construct_db_host($db_host, $db_port);

    $content = '<?' ."php\n";
    $content .= "// database host\n";
    $content .= "\$db_host   = \"$db_host\";\n\n";
    $content .= "// database name\n";
    $content .= "\$db_name   = \"$db_name\";\n\n";
    $content .= "// database username\n";
    $content .= "\$db_user   = \"$db_user\";\n\n";
    $content .= "// database password\n";
    $content .= "\$db_pass   = \"$db_pass\";\n\n";
    $content .= "// table prefix\n";
    $content .= "\$prefix    = \"$prefix\";\n\n";
    $content .= "\$timezone    = \"$timezone\";\n\n";
    $content .= "\$cookie_path    = \"/\";\n\n";
    $content .= "\$cookie_domain    = \"\";\n\n";
    $content .= "\$session = \"1440\";\n\n";
    $content .= "define('EC_CHARSET','".EC_CHARSET."');\n\n";
    $content .= "define('ADMIN_PATH','admin');\n\n";
    $content .= '?>';

    $fp = @fopen(ROOT_PATH . 'data/config.php', 'wb+');
    if (!$fp)
    {
        $err->add($_LANG['open_config_file_failed']);
        return false;
    }
    if (!@fwrite($fp, trim($content)))
    {
        $err->add($_LANG['write_config_file_failed']);
        return false;
    }
    @fclose($fp);

    return true;
}

/**
 * ��host��port�����ָ���Ĵ�
 *
 * @access  public
 * @param   string      $db_host        ����
 * @param   string      $db_port        �˿ں�
 * @return  string      host��port�����Ĵ�������host:port
 */
function construct_db_host($db_host, $db_port)
{
    return $db_host . ':' . $db_port;
}

/**
 * ��װ����
 *
 * @access  public
 * @param   array         $sql_files        SQL�ļ�·����ɵ�����
 * @return  boolean       �ɹ�����true��ʧ�ܷ���false
 */
function install_data($sql_files)
{
    global $err;

    include(ROOT_PATH . 'data/config.php');
    include_once(ROOT_PATH . 'includes/cls_mysql.php');
    include_once(ROOT_PATH . 'includes/cls_sql_executor.php');

    $db = new cls_mysql($db_host, $db_user, $db_pass, $db_name);
    $se = new sql_executor($db, EC_DB_CHARSET, 'ecs_', $prefix);
    $result = $se->run_all($sql_files);
    if ($result === false)
    {
        $err->add($se->error);
        return false;
    }

    return true;
}

/**
 * ��������Ա�ʺ�
 *
 * @access  public
 * @param   string      $admin_name
 * @param   string      $admin_password
 * @param   string      $admin_password2
 * @param   string      $admin_email
 * @return  boolean     �ɹ�����true��ʧ�ܷ���false
 */
function create_admin_passport($admin_name, $admin_password, $admin_password2, $admin_email)
{
    if(trim($_REQUEST['lang'])!='zh_cn')
    {
        global $err,$_LANG;
        $system_lang = isset($_POST['system_lang'])     ? $_POST['system_lang'] : 'zh_cn';
        include_once(ROOT_PATH . 'install/languages/' . $system_lang . '.php');
    }
    else
    {
        global $err,$_LANG;
    }

    if ($admin_password === '')
    {
        $err->add($_LANG['password_empty_error']);
        return false;
    }

    if ($admin_password === '')
    {
        $err->add($_LANG['password_empty_error']);
        return false;
    }

    if (!(strlen($admin_password) >= 8 && preg_match("/\d+/",$admin_password) && preg_match("/[a-zA-Z]+/",$admin_password)))
    {
        $err->add($_LANG['js_languages']['password_invaild']);
        return false;
    }



    include(ROOT_PATH . 'data/config.php');
    include_once(ROOT_PATH . 'includes/cls_mysql.php');
    include_once(ROOT_PATH . 'includes/lib_common.php');

    $nav_list = join(',', $_LANG['admin_user']);

    $db = new cls_mysql($db_host, $db_user, $db_pass, $db_name);
    $sql = "INSERT INTO $prefix"."admin_user ".
                "(user_name, email, password, add_time, action_list, nav_list)".
            "VALUES ".
                "('$admin_name', '$admin_email', '".$admin_password. "', " .gmtime(). ", 'all', '$nav_list')";
    if (!$db->query($sql,  'SILENT'))
    {
        $err->add($_LANG['create_passport_failed']);
        return false;
    }

    return true;
}

/**
 * ��װԤѡ��Ʒ����
 *
 * @access  public
 * @param   array      $goods_types     Ԥѡ��Ʒ����
 * @param   string     $lang            ����
 * @return  boolean    �ɹ�����true��ʧ�ܷ���false
 */
function install_goods_types($goods_types, $lang)
{
    global $err;

    if (!$goods_types)
    {
        return true;
    }

    include(ROOT_PATH . 'data/config.php');
    include_once(ROOT_PATH . 'includes/cls_mysql.php');
    $db = new cls_mysql($db_host, $db_user, $db_pass, $db_name);

    if (file_exists(ROOT_PATH . 'install/data/inc_goods_type_' . $lang . '.php'))
    {
        include(ROOT_PATH . 'install/data/inc_goods_type_' . $lang . '.php');
    }
    else
    {
        include(ROOT_PATH . 'install/data/inc_goods_type_zh_cn.php');
    }
    foreach ($attributes as $key=>$val)
    {
        if (!in_array($key, $goods_types))
        {
            continue;
        }

        if (!$db->query($val['cat'], 'SILENT'))
        {
            $err->add($db->errno() .' '. $db->error());
            return false;
        }
        $cat_id = $db->Insert_ID();

        $sql = str_replace("{cat_id}", $cat_id, $val['attr']);
        if (!$db->query($sql, 'SILENT'))
        {
            $err->add($db->errno() .' '. $db->error());
            return false;
        }
    }

    return true;
}

/**
 * ��һ���ļ���һ��Ŀ¼���Ƶ���һ��Ŀ¼
 *
 * @access  public
 * @param   string      $source    ԴĿ¼
 * @param   string      $target    Ŀ��Ŀ¼
 * @return  boolean     �ɹ�����true��ʧ�ܷ���false
 */
function copy_files($source, $target)
{
    global $err, $_LANG;

    if (!file_exists($target))
    {
        //if (!mkdir(rtrim($target, '/'), 0777))
        if (!mkdir($target, 0777))
        {
            $err->add($_LANG['cannt_mk_dir']);
            return false;
        }
        @chmod($target, 0777);
    }
    $dir = opendir($source);
    while (($file = @readdir($dir)) !== false)
    {
        if (is_file($source . $file))
        {
            if (!copy($source . $file, $target . $file))
            {
                $err->add($_LANG['cannt_copy_file']);
                return false;
            }
            @chmod($target . $file, 0777);
        }
    }
    closedir($dir);

    return true;
}

/**
 * ��������
 *
 * @access  public
 * @param   string      $system_lang            ϵͳ����
 * @param   string      $disable_captcha        �Ƿ�����֤��
 * @param   array       $goods_types            Ԥѡ��Ʒ����
 * @param   string      $install_demo           �Ƿ�װ��������
 * @param   string      $integrate_code         �û��ӿ�
 * @return  boolean     �ɹ�����true��ʧ�ܷ���false
 */
function do_others($system_lang, $captcha, $goods_types, $install_demo, $integrate_code)
{
    global $err, $_LANG;

    /* ��װԤѡ��Ʒ���� */
    if (!install_goods_types($goods_types, $system_lang))
    {
        $err->add(implode('', $err->last_message()));
        return false;
    }

    /* ��װ�������� */
    if (intval($install_demo))
    {
        if (file_exists(ROOT_PATH . 'demo/'. $system_lang . '.sql'))
        {
            $sql_files = array(ROOT_PATH . 'demo/'. $system_lang . '.sql');
        }
        else
        {
            $sql_files = array(ROOT_PATH . 'demo/zh_cn.sql');
        }
        if (!install_data($sql_files))
        {
            $err->add(implode('', $err->last_message()));
            return false;
        }
        if (!copy_files(ROOT_PATH . 'demo/brandlogo/', ROOT_PATH . 'data/brandlogo/'))
        {
            $err->add(implode('', $err->last_message()));
            return false;
        }
        if (!copy_files(ROOT_PATH . 'demo/200905/goods_img/', ROOT_PATH . 'images/200905/goods_img/'))
        {
            $err->add(implode('', $err->last_message()));
            return false;
        }
        if (!copy_files(ROOT_PATH . 'demo/200905/thumb_img/', ROOT_PATH . 'images/200905/thumb_img/'))
        {
            $err->add(implode('', $err->last_message()));
            return false;
        }
        if (!copy_files(ROOT_PATH . 'demo/200905/source_img/', ROOT_PATH . 'images/200905/source_img/'))
        {
            $err->add(implode('', $err->last_message()));
            return false;
        }
        if (!copy_files(ROOT_PATH . 'demo/afficheimg/', ROOT_PATH . 'data/afficheimg/'))
        {
            $err->add(implode('', $err->last_message()));
            return false;
        }
        if (!copy_files(ROOT_PATH . 'demo/packimg/', ROOT_PATH . 'data/packimg/'))
        {
            $err->add(implode('', $err->last_message()));
            return false;
        }
        if (!copy_files(ROOT_PATH . 'demo/cardimg/', ROOT_PATH . 'data/cardimg/'))
        {
            $err->add(implode('', $err->last_message()));
            return false;
        }
    }

    include(ROOT_PATH . 'data/config.php');
    include_once(ROOT_PATH . 'includes/cls_mysql.php');
    $db = new cls_mysql($db_host, $db_user, $db_pass, $db_name);

    /* ���� ECSHOP ���� */
    $sql = "UPDATE $prefix"."shop_config SET value='" . $system_lang . "' WHERE code='lang'";
    if (!$db->query($sql, 'SILENT'))
    {
        $err->add($db->errno() .' '. $db->error());
        return false;
    }

    /* �����û��ӿ� */
    if (!empty($integrate_code))
    {
        $sql = "UPDATE $prefix"."shop_config SET value='" . $integrate_code . "' WHERE code='integrate_code'";
        if (!$db->query($sql, 'SILENT'))
        {
            $err->add($db->errno() .' '. $db->error());
            return false;
        }
    }

    /* ������֤�� */
    if (!empty($captcha))
    {
        $sql = "UPDATE $prefix" . "shop_config SET value = '12' WHERE code = 'captcha'";
        if (!$db->query($sql, 'SILENT'))
        {
            $err->add($db->errno() .' '. $db->error());
            return false;
        }
    }

    /* �����û��ӿ����� */
    if (file_exists(ROOT_PATH .'data/config_temp.php'))
    {
        include(ROOT_PATH .'data/config_temp.php');
        $sql = "UPDATE $prefix" . "shop_config SET value = '".serialize($cfg)."' WHERE code = 'integrate_config'";
        if (!$db->query($sql, 'SILENT'))
        {
            $err->add($db->errno() .' '. $db->error());
            return false;
        }
    }

    return true;
}

/**
 * ��װ��ɺ��һЩ�ƺ���
 *
 * @access  public
 * @return  boolean     �ɹ�����true��ʧ�ܷ���false
 */
function deal_aftermath()
{
    global $err, $_LANG;

    include(ROOT_PATH . 'data/config.php');
    include_once(ROOT_PATH . 'includes/cls_ecshop.php');
    include_once(ROOT_PATH . 'includes/cls_mysql.php');

    $db = new cls_mysql($db_host, $db_user, $db_pass, $db_name);

    /* ��ʼ����������
    $sql = "INSERT INTO $prefix"."friend_link ".
                "(link_name, link_url, link_logo, show_order)".
            "VALUES ".
                "('".$_LANG['default_friend_link']."', 'http://www.ecshop.com/', 'http://www.ecshop.com/images/logo/ecshop_logo.gif','0')";
    if (!$db->query($sql, 'SILENT'))
    {
        $err->add($db->errno() .' '. $db->error());
    }

    $sql = "INSERT INTO $prefix"."friend_link ".
                "(link_name, link_url, show_order)".
            "VALUES ".
                "('".$_LANG['maifou_friend_link']."', 'http://www.maifou.net/','1')";
    if (!$db->query($sql, 'SILENT'))
    {
        $err->add($db->errno() .' '. $db->error());
    }*/

    /* ���� ECSHOP ��װ���� */
    $sql = "UPDATE $prefix"."shop_config SET value='" .time(). "' WHERE code='install_date'";
    if (!$db->query($sql, 'SILENT'))
    {
        $err->add($db->errno() .' '. $db->error());
    }

    /* ���� ECSHOP �汾 */
    $sql = "UPDATE $prefix"."shop_config SET value='" .VERSION. "' WHERE code='ecs_version'";
    if (!$db->query($sql, 'SILENT'))
    {
        $err->add($db->errno() .' '. $db->error());
        return false;
    }

    /* д�� hash_code����Ϊ��վΨһ����Կ */
    $hash_code = md5(md5(time()) . md5($db->dbhash) . md5(time()));
    $sql = "UPDATE $prefix"."shop_config SET value = '$hash_code' WHERE code = 'hash_code' ";
    if (!$db->query($sql, 'SILENT'))
    {
        $err->add($db->errno() .' '. $db->error());
        return false;
    }

    /* д�밲װ�����ļ� */
    $fp = @fopen(ROOT_PATH . 'data/install.lock', 'wb+');
    if (!$fp)
    {
        $err->add($_LANG['open_installlock_failed']);
        return false;
    }
    if (!@fwrite($fp, "TRADE SHOP INSTALLED"))
    {
        $err->add($_LANG['write_installlock_failed']);
        return false;
    }
    @fclose($fp);

    return true;
}

/**
 * ���spt����
 *
 * @access  public
 * @return  string   spt����
 */
function get_spt_code()
{
    include(ROOT_PATH . 'data/config.php');
    include_once(ROOT_PATH . 'includes/cls_ecshop.php');
    include_once(ROOT_PATH . 'includes/cls_mysql.php');
    $db = new cls_mysql($db_host, $db_user, $db_pass, $db_name);
    $ecs = new ECS($db_name, $prefix);
    $hash_code = $db->getOne("SELECT value FROM " . $ecs->table('shop_config') . " WHERE code='hash_code'");
    $spt = '<script type="text/javascript" src="http://api.ecshop.com/record.php?';
    $spt .= "url=" .urlencode($ecs->url()). "&mod=install&version=" .VERSION. "&hash_code=" . $hash_code . "&charset=" .EC_CHARSET. "&language=" . $GLOBALS['installer_lang'] . "\"></script>";

    return $spt;
}

/**
 * ȡ�õ�ǰ������
 *
 * @access  public
 *
 * @return  string      ��ǰ������
 */
function get_domain()
{
    /* Э�� */
    $protocol = http();

    /* ������IP��ַ */
    if (isset($_SERVER['HTTP_X_FORWARDED_HOST']))
    {
        $host = $_SERVER['HTTP_X_FORWARDED_HOST'];
    }
    elseif (isset($_SERVER['HTTP_HOST']))
    {
        $host = $_SERVER['HTTP_HOST'];
    }
    else
    {
        /* �˿� */
        if (isset($_SERVER['SERVER_PORT']))
        {
            $port = ':' . $_SERVER['SERVER_PORT'];

            if ((':80' == $port && 'http://' == $protocol) || (':443' == $port && 'https://' == $protocol))
            {
                $port = '';
            }
        }
        else
        {
            $port = '';
        }

        if (isset($_SERVER['SERVER_NAME']))
        {
            $host = $_SERVER['SERVER_NAME'] . $port;
        }
        elseif (isset($_SERVER['SERVER_ADDR']))
        {
            $host = $_SERVER['SERVER_ADDR'] . $port;
        }
    }

    return $protocol . $host;
}

/**
 * ��� ECSHOP ��ǰ������ URL ��ַ
 *
 * @access  public
 *
 * @return  void
 */
function url()
{
    $PHP_SELF = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
    $ecserver = 'http://'.$_SERVER['HTTP_HOST'].($_SERVER['SERVER_PORT'] && $_SERVER['SERVER_PORT'] != 80 ? ':'.$_SERVER['SERVER_PORT'] : '');
    $default_appurl = $ecserver.substr($PHP_SELF, 0, strpos($PHP_SELF, 'install/') - 1);

    return $default_appurl;
}

/**
 * ��� ECSHOP ��ǰ������ HTTP Э�鷽ʽ
 *
 * @access  public
 *
 * @return  void
 */
function http()
{
    return (isset($_SERVER['HTTPS']) && (strtolower($_SERVER['HTTPS']) != 'off')) ? 'https://' : 'http://';
}


function insertconfig($s, $find, $replace)
{
    if(preg_match($find, $s))
    {
        $s = preg_replace($find, $replace, $s);
    }
    else
    {
        // ���뵽���һ��
        $s .= "\r\n".$replace;
    }
    return $s;
}

function getgpc($k, $var='G')
{
    switch($var)
    {
        case 'G': $var = &$_GET; break;
        case 'P': $var = &$_POST; break;
        case 'C': $var = &$_COOKIE; break;
        case 'R': $var = &$_REQUEST; break;
    }

    return isset($var[$k]) ? $var[$k] : '';
}

function var_to_hidden($k, $v)
{
    return "<input type=\"hidden\" name=\"$k\" value=\"$v\" />";
}

function dfopen($url, $limit = 0, $post = '', $cookie = '', $bysocket = FALSE, $ip = '', $timeout = 15, $block = TRUE)
{
    $return = '';
    $matches = parse_url($url);
    $host = $matches['host'];
    $path = $matches['path'] ? $matches['path'].'?'.$matches['query'].($matches['fragment'] ? '#'.$matches['fragment'] : '') : '/';
    $port = !empty($matches['port']) ? $matches['port'] : 80;

    if($post)
    {
        $out = "POST $path HTTP/1.0\r\n";
        $out .= "Accept: */*\r\n";
        //$out .= "Referer: $boardurl\r\n";
        $out .= "Accept-Language: zh-cn\r\n";
        $out .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
        $out .= "Host: $host\r\n";
        $out .= 'Content-Length: '.strlen($post)."\r\n";
        $out .= "Connection: Close\r\n";
        $out .= "Cache-Control: no-cache\r\n";
        $out .= "Cookie: $cookie\r\n\r\n";
        $out .= $post;
    }
    else
    {
        $out = "GET $path HTTP/1.0\r\n";
        $out .= "Accept: */*\r\n";
        //$out .= "Referer: $boardurl\r\n";
        $out .= "Accept-Language: zh-cn\r\n";
        $out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
        $out .= "Host: $host\r\n";
        $out .= "Connection: Close\r\n";
        $out .= "Cookie: $cookie\r\n\r\n";
    }
    $fp = @fsockopen(($ip ? $ip : $host), $port, $errno, $errstr, $timeout);
    if(!$fp)
    {
        return '';//note $errstr : $errno \r\n
    }
    else
    {
        stream_set_blocking($fp, $block);
        stream_set_timeout($fp, $timeout);
        @fwrite($fp, $out);
        $status = stream_get_meta_data($fp);
        if(!$status['timed_out'])
        {
            while (!feof($fp))
            {
                if(($header = @fgets($fp)) && ($header == "\r\n" ||  $header == "\n"))
                {
                    break;
                }
            }

            $stop = false;
            while(!feof($fp) && !$stop)
            {
                $data = fread($fp, ($limit == 0 || $limit > 8192 ? 8192 : $limit));
                $return .= $data;
                if($limit)
                {
                    $limit -= strlen($data);
                    $stop = $limit <= 0;
                }
            }
        }
        @fclose($fp);
        return $return;
    }
}

function save_uc_config($config)
{
    $success = false;

    list($appauthkey, $appid, $ucdbhost, $ucdbname, $ucdbuser, $ucdbpw, $ucdbcharset, $uctablepre, $uccharset, $ucapi, $ucip) = explode('|', $config);

/*
    $content = '<?' ."php\n";
    $content .= "define('UC_CONNECT', 'mysql');\n\n";
    $content .= "define('UC_DBHOST', '$ucdbhost');\n\n";
    $content .= "define('UC_DBUSER', '$ucdbuser');\n\n";
    $content .= "define('UC_DBPW', '$ucdbpw');\n\n";
    $content .= "define('UC_DBNAME', '$ucdbname');\n\n";
    $content .= "define('UC_DBCHARSET', '$ucdbcharset');\n\n";
    $content .= "define('UC_DBTABLEPRE', '`$ucdbname`.$uctablepre');\n\n";
    $content .= "define('UC_DBCONNECT', '0');\n\n";
    $content .= "define('UC_KEY', '$appauthkey');\n\n";
    $content .= "define('UC_API', '$ucapi');\n\n";
    $content .= "define('UC_CHARSET', '$uccharset');\n\n";
    $content .= "define('UC_IP', '$ucip');\n\n";
    $content .= "define('UC_APPID', '$appid');\n\n";
    $content .= "define('UC_PPP', '20');\n\n";
    $content .= '?>';
*/
    $cfg = array(
                    'uc_id' => $appid,
                    'uc_key' => $appauthkey,
                    'uc_url' => $ucapi,
                    'uc_ip' => $ucip,
                    'uc_connect' => 'mysql',
                    'uc_charset' => $uccharset,
                    'db_host' => $ucdbhost,
                    'db_user' => $ucdbuser,
                    'db_name' => $ucdbname,
                    'db_pass' => $ucdbpw,
                    'db_pre' => $uctablepre,
                    'db_charset' => $ucdbcharset,
                );
    $content = "<?php\r\n";
    $content .= "\$cfg = " . var_export($cfg, true) . ";\r\n";
    $content .= "?>";

    $fp = @fopen(ROOT_PATH . 'data/config_temp.php', 'wb+');
    if (!$fp)
    {
        $result['error'] = 1;
        $result['message'] = $_LANG['ucenter_datadir_access'];
        die($GLOBALS['json']->encode($result));
    }
    if (!@fwrite($fp, $content))
    {
        $result['error'] = 1;
        $result['message'] = $_LANG['ucenter_tmp_config_error'];
        die($GLOBALS['json']->encode($result));
    }
    @fclose($fp);

    return true;
}
?>