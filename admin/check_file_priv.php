<?php

/**
 * ECSHOP ϵͳ�ļ����
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: check_file_priv.php 17217 2011-01-19 06:29:08Z liubo $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

if ($_REQUEST['act']== 'check')
{
    /* ���Ȩ�� */
    admin_priv('file_priv');

    /* Ҫ���Ŀ¼�ļ��б� */
    $goods_img_dir = array();
    $folder = opendir(ROOT_PATH . 'images');
    while ($dir = readdir($folder))
    {
        if (is_dir(ROOT_PATH . IMAGE_DIR . '/' . $dir) && preg_match('/^[0-9]{6}$/', $dir))
        {
            $goods_img_dir[] = IMAGE_DIR . '/' . $dir;
        }
    }
    closedir($folder);

    $dir[]                     = ADMIN_PATH;
    $dir[]                     = 'cert';

    $dir_subdir['images'][]    = IMAGE_DIR;
    $dir_subdir['images'][]    = IMAGE_DIR . '/upload';
    $dir_subdir['images'][]    = IMAGE_DIR . '/upload/Image';
    $dir_subdir['images'][]    = IMAGE_DIR . '/upload/File';
    $dir_subdir['images'][]    = IMAGE_DIR . '/upload/Flash';
    $dir_subdir['images'][]    = IMAGE_DIR . '/upload/Media';
    $dir_subdir['data'][]      = DATA_DIR;
    $dir_subdir['data'][]      = DATA_DIR . '/afficheimg';
    $dir_subdir['data'][]      = DATA_DIR . '/brandlogo';
    $dir_subdir['data'][]      = DATA_DIR . '/cardimg';
    $dir_subdir['data'][]      = DATA_DIR . '/feedbackimg';
    $dir_subdir['data'][]      = DATA_DIR . '/packimg';
    $dir_subdir['data'][]      = DATA_DIR . '/sqldata';
    $dir_subdir['temp'][] = 'temp';
    $dir_subdir['temp'][] = 'temp/backup';
    $dir_subdir['temp'][] = 'temp/caches';
    $dir_subdir['temp'][] = 'temp/compiled';
    $dir_subdir['temp'][] = 'temp/compiled/admin';
    $dir_subdir['temp'][] = 'temp/query_caches';
    $dir_subdir['temp'][] = 'temp/static_caches';

    /* ����ƷͼƬĿ¼�����鷶Χ */
    foreach ($goods_img_dir as $val)
    {
        $dir_subdir['images'][] = $val;
    }

    $tpl = 'themes/'.$_CFG['template'].'/';



    $list = array();

    /* ���Ŀ¼ */
    foreach ($dir AS $val)
    {
        $mark = file_mode_info(ROOT_PATH .$val);
        $list[] = array('item' => $val.$_LANG['dir'], 'r' => $mark&1, 'w' => $mark&2, 'm' => $mark&4);
    }

    /* ���Ŀ¼����Ŀ¼ */
    $keys = array_unique(array_keys($dir_subdir));
    foreach ($keys AS $key)
    {
        $err_msg = array();
        $mark = check_file_in_array($dir_subdir[$key], $err_msg);
        $list[] = array('item' => $key.$_LANG['dir_subdir'], 'r' => $mark&1, 'w' => $mark&2, 'm' => $mark&4, 'err_msg' => $err_msg);
    }

    /* ��鵱ǰģ���д�� */
    $dwt = @opendir(ROOT_PATH .$tpl);
    $tpl_file = array(); //��ȡҪ�����ļ�
    while ($file = readdir($dwt))
    {
        if (is_file(ROOT_PATH .$tpl .$file) && strrpos($file, '.dwt') > 0)
        {
            $tpl_file[] = $tpl .$file;
        }
    }
    @closedir($dwt);
    $lib = @opendir(ROOT_PATH .$tpl.'library/');
    while ($file = readdir($lib))
    {
        if (is_file(ROOT_PATH .$tpl.'library/'.$file) && strrpos($file, '.lbi') > 0 )
        {
             $tpl_file[] = $tpl . 'library/' . $file;
        }
    }
    @closedir($lib);

    /* ��ʼ��� */
    $err_msg = array();
    $mark = check_file_in_array($tpl_file, $err_msg);
    $list[] = array('item' => $tpl.$_LANG['tpl_file'], 'r' => $mark&1, 'w' => $mark & 2, 'm' => $mark & 4, 'err_msg' => $err_msg);

    /* ���smarty�Ļ���Ŀ¼�ͱ���Ŀ¼��imageĿ¼�Ƿ���ִ��rename()������Ȩ�� */
    $tpl_list   = array();
    $tpl_dirs[] = 'temp/caches';
    $tpl_dirs[] = 'temp/compiled';
    $tpl_dirs[] = 'temp/compiled/admin';

    /* ����ƷͼƬĿ¼�����鷶Χ */
    foreach ($goods_img_dir as $val)
    {
        $tpl_dirs[] = $val;
    }

    foreach ($tpl_dirs AS $dir)
    {
        $mask = file_mode_info(ROOT_PATH .$dir);

        if (($mask & 4) > 0)
        {
            /* ֮ǰ�Ѿ������޸�Ȩ�ޣ�ֻ�����޸�Ȩ�޲ż��renameȨ�� */
            if (($mask & 8) < 1)
            {
                $tpl_list[] = $dir;
            }
        }
    }
    $tpl_msg = implode(', ', $tpl_list);
    $smarty->assign('ur_here',      $_LANG['check_file_priv']);
    $smarty->assign('list',    $list);
    $smarty->assign('tpl_msg', $tpl_msg);
    $smarty->display('file_priv.html');
}

/**
 *  ���������Ŀ¼Ȩ��
 *
 * @access  public
 * @param   array    $arr           Ҫ�����ļ��б�����
 * @param   array    $err_msg       ������Ϣ��������
 *
 * @return int       $mark          �ļ�Ȩ������
 */
function check_file_in_array($arr, &$err_msg)
{
    $read   = true;
    $writen = true;
    $modify = true;
    foreach ($arr AS $val)
    {
        $mark = file_mode_info(ROOT_PATH . $val);
        if (($mark & 1) < 1)
        {
            $read = false;
            $err_msg['r'][] = $val;
        }
        if (($mark & 2) <1)
        {
            $writen = false;
            $err_msg['w'][] = $val;

        }
        if (($mark & 4) <1)
        {
            $modify = false;
            $err_msg['m'][] = $val;
        }
    }

    $mark = 0;
    if ($read)
    {
        $mark ^= 1;
    }
    if ($writen)
    {
        $mark ^= 2;
    }
    if ($modify)
    {
        $mark ^= 4;
    }

    return $mark;
}

?>