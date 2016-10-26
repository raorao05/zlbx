<?php

/**
 * ECSHOP ת������
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: convert.php 17217 2011-01-19 06:29:08Z liubo $
 */

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

/*------------------------------------------------------ */
//-- ת��������ҳ��
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'main')
{
    admin_priv('convert');

    /* ȡ�ò���ļ��е�ת������ */
    $modules = read_modules('../includes/modules/convert');
    for ($i = 0; $i < count($modules); $i++)
    {
        $code = $modules[$i]['code'];
        $lang_file = ROOT_PATH.'languages/' . $_CFG['lang'] . '/convert/' . $code . '.php';
        if (file_exists($lang_file))
        {
            include_once($lang_file);
        }
        $modules[$i]['desc'] = $_LANG[$modules[$i]['desc']];
    }
    $smarty->assign('module_list', $modules);

    /* ����Ĭ��ֵ */
    $def_val = array(
        'host'      => $db_host,
        'db'        => '',
        'user'      => $db_user,
        'pass'      => $db_pass,
        'prefix'    => 'sdb_',
        'path'      => ''
    );
    $smarty->assign('def_val', $def_val);

    /* ȡ���ַ������� */
    $smarty->assign('charset_list', get_charset_list());

    /* ��ʾģ�� */
    $smarty->assign('ur_here', $_LANG['convert']);
    assign_query_info();
    $smarty->display('convert_main.htm');
}

/*------------------------------------------------------ */
//-- ת��ǰ���
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'check')
{
    /* ���Ȩ�� */
    check_authz_json('convert');

    /* ȡ�ò��� */
    include_once(ROOT_PATH . 'includes/cls_json.php');
    $json = new JSON;
//    $_POST['JSON'] = '{"host":"localhost","db":"shopex","user":"root","pass":"123456","prefix":"sdb_","code":"shopex48","path":"../shopex","charset":"UTF8"}';
    $config = $json->decode($_POST['JSON']);

    /* �����������ݿ� */
    $sdb = new cls_mysql($config->host, $config->user, $config->pass, $config->db);

    /* ������ı��Ƿ���� */
    $sprefix = $config->prefix;
    $config->path = rtrim(str_replace('\\', '/', $config->path), '/');  // ��б���滻Ϊ��б�ߣ�ȥ����β�ķ�б��
    include_once(ROOT_PATH . 'includes/modules/convert/' . $config->code . '.php');
    $convert = new $config->code($sdb, $sprefix, $config->path);
    $required_table_list = $convert->required_tables();

    $sql = "SHOW TABLES";
    $table_list = $sdb->getCol($sql);

    $diff_arr = array_diff($required_table_list, $table_list);
    if ($diff_arr)
    {
        make_json_error(sprintf($_LANG['table_error'], join(',', $table_list)));
    }

    /* ���ԴĿ¼�Ƿ���ڣ��Ƿ�ɶ� */
    $dir_list = $convert->required_dirs();
    foreach ($dir_list AS $dir)
    {
        $cur_dir = ($config->path . $dir);
        if (!file_exists($cur_dir) || !is_dir($cur_dir))
        {
            make_json_error(sprintf($_LANG['dir_error'], $cur_dir));
        }

        if (file_mode_info($cur_dir) & 1 != 1)
        {
            make_json_error(sprintf($_LANG['dir_not_readable'], $cur_dir));
        }

        $res = check_files_readable($cur_dir);
        if ($res !== true)
        {
            make_json_error(sprintf($_LANG['file_not_readable'], $res));
        }
    }

    /* ����ͼƬĿ¼ */
    $img_dir = ROOT_PATH . IMAGE_DIR . '/' . date('Ym') . '/';
    if (!file_exists($img_dir))
    {
        make_dir($img_dir);
    }

    /* ��Ҫ����д��Ŀ¼ */
    $to_dir_list = array(
        ROOT_PATH . IMAGE_DIR . '/upload/',
        $img_dir,
        ROOT_PATH . DATA_DIR . '/afficheimg/',
        ROOT_PATH . 'cert/'
    );

    /* ���Ŀ��Ŀ¼�Ƿ���ڣ��Ƿ��д */
    foreach ($to_dir_list AS $to_dir)
    {
        if (!file_exists($to_dir) || !is_dir($to_dir))
        {
            make_json_error(sprintf($_LANG['dir_error'], $to_dir));
        }

        if (file_mode_info($to_dir) & 4 != 4)
        {
            make_json_error(sprintf($_LANG['dir_not_writable'], $to_dir));
        }
    }

    /* ����������Ϣ */
    $_SESSION['convert_config'] = $config;

    /* ������������ļ� */
    include_once(ROOT_PATH . 'languages/' . $_CFG['lang'] . '/convert/' . $config->code . '.php');

    /* ȡ�õ�һ������ */
    $step = $convert->next_step('');

    /* ���� */
    make_json_result($step, $_LANG[$step]);
}

/*------------------------------------------------------ */
//-- ת������
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'process')
{
    /* ����ִ��ʱ�� */
    set_time_limit(0);

    /* ���Ȩ�� */
    check_authz_json('convert');

    /* ȡ�ò��� */
    $step = json_str_iconv($_POST['step']);

    /* ����ԭ���ݿ� */
    $config = $_SESSION['convert_config'];

    $sdb = new cls_mysql($config->host, $config->user, $config->pass, $config->db);
    $sdb->set_mysql_charset($config->charset);

    /* ����������� */
    include_once(ROOT_PATH . 'includes/modules/convert/' . $config->code . '.php');
    $convert = new $config->code($sdb, $config->prefix, $config->path, $config->charset);

    /* ������������ļ� */
    include_once(ROOT_PATH . 'languages/' . $_CFG['lang'] . '/convert/' . $config->code . '.php');

    /* ִ�в��� */
    $result = $convert->process($step);
    if ($result !== true)
    {
        make_json_error($result);
    }

    /* ȡ����һ������ */
    $step = $convert->next_step($step);

    /* ���� */
    make_json_result($step, empty($_LANG[$step]) ? '' : $_LANG[$step]);
}

/**
 * ���ĳ��Ŀ¼���ļ��Ƿ�ɶ�����������Ŀ¼��
 * ǰ�᣺$dirname ��Ŀ¼�Ҵ����ҿɶ�
 *
 * @param   string  $dirname    Ŀ¼������ / ��β���� / �ָ�
 * @return  mix     ��������ļ��ɶ�������true�����򣬷��ص�һ�����ɶ����ļ���
 */
function check_files_readable($dirname)
{
    /* �����ļ�������ļ��Ƿ�ɶ� */
    if ($dh = opendir($dirname))
    {
        while (($file = readdir($dh)) !== false)
        {
            if (filetype($dirname . $file) == 'file' && strtolower($file) != 'thumbs.db')
            {
                if (file_mode_info($dirname . $file) & 1 != 1)
                {
                    return $dirname . $file;
                }
            }
        }
        closedir($dh);
    }

    /* ȫ���ɶ��ķ���ֵ */
    return true;
}

/**
 * ��һ��Ŀ¼���ļ����Ƶ���һ��Ŀ¼����������Ŀ¼��
 * ǰ�᣺$from_dir ��Ŀ¼�Ҵ����ҿɶ���$to_dir ��Ŀ¼�Ҵ����ҿ�д
 *
 * @param   string  $from_dir   ԴĿ¼
 * @param   string  $to_dir     Ŀ��Ŀ¼
 * @param   string  $file_prefix    �ļ���ǰ׺
 * @return  mix     �ɹ�����true�����򷵻ص�һ��ʧ�ܵ��ļ���
 */
function copy_files($from_dir, $to_dir, $file_prefix = '')
{
    /* �����������ļ� */
    if ($dh = opendir($from_dir))
    {
        while (($file = readdir($dh)) !== false)
        {
            if (filetype($from_dir . $file) == 'file' && strtolower($file) != 'thumbs.db')
            {
                if (!copy($from_dir . $file, $to_dir . $file_prefix . $file))
                {
                    return $from_dir . $file;
                }
            }
        }
        closedir($dh);
    }

    /* ȫ�����Ƴɹ�������true */
    return true;
}

/**
 * ��һ��Ŀ¼���ļ����Ƶ���һ��Ŀ¼��������Ŀ¼��
 * ǰ�᣺$from_dir ��Ŀ¼�Ҵ����ҿɶ���$to_dir ��Ŀ¼�Ҵ����ҿ�д
 *
 * @param   string  $from_dir   ԴĿ¼
 * @param   string  $to_dir     Ŀ��Ŀ¼
 * @param   string  $file_prefix �ļ�ǰ׺
 * @return  mix     �ɹ�����true�����򷵻ص�һ��ʧ�ܵ��ļ���
 */
function copy_dirs($from_dir, $to_dir, $file_prefix = '')
{
    $result = true;
    if(! is_dir($from_dir))
    {
        die("It's not a dir");
    }
    if(! is_dir($to_dir))
    {
        if(! mkdir($to_dir, 0700))
        {
            die("can't mkdir");
        }
    }
    $handle = opendir($from_dir);
    while(($file = readdir($handle)) !== false)
    {
        if($file != '.' && $file != '..')
        {
            $src = $from_dir . DIRECTORY_SEPARATOR . $file;
            $dtn = $to_dir . DIRECTORY_SEPARATOR . $file_prefix . $file;
            if(is_dir($src))
            {
                copy_dirs($src, $dtn);
            }
            else
            {
                if(! copy($src, $dtn))
                {
                    $result = false;
                    break;
                }
            }
        }
    }
    closedir($handle);
    return $result;
}

?>