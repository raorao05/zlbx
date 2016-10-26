<?php

/**
 * ECSHOP ��������������༭(ǰ̨������)
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: edit_languages.php 17217 2011-01-19 06:29:08Z liubo $
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

admin_priv('lang_edit');

/*------------------------------------------------------ */
//-- �б�༭ ?act=list
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'list')
{
    //��languagesĿ¼�»�ȡ�������ļ�
    $lang_arr    = array();
    $lang_path   = '../languages/' .$_CFG['lang'];
    $lang_dir    = @opendir($lang_path);

    while ($file = @readdir($lang_dir))
    {
        if (substr($file, -3) == "php")
        {
            $filename = substr($file, 0, -4);
            $lang_arr[$filename] = $file. ' - ' .@$_LANG['language_files'][$filename];
        }
    }

    ksort($lang_arr);
    @closedir($lang_dir);

    /* �����Ҫ���������԰��ļ� */
    $lang_file = isset($_POST['lang_file']) ? trim($_POST['lang_file']) : '';
    if ($lang_file == 'common')
    {
        $file_path = '../languages/'.$_CFG['lang'].'/common.php';
    }
    elseif ($lang_file == 'shopping_flow')
    {
        $file_path = '../languages/'.$_CFG['lang'].'/shopping_flow.php';
    }
    else
    {
        $file_path = '../languages/'.$_CFG['lang'].'/user.php';
    }

    $file_attr = '';
    if (file_mode_info($file_path) < 7)
    {
        $file_attr = $lang_file .'.php��'. $_LANG['file_attribute'];
    }

    /* �����Ĺؼ��� */
    $keyword = !empty($_POST['keyword']) ? trim(stripslashes($_POST['keyword'])) : '';

    /* ���ú��� */
    $language_arr = get_language_item_list($file_path, $keyword);

    /* ģ�帳ֵ */
    $smarty->assign('ur_here',      $_LANG['edit_languages']);
    $smarty->assign('keyword',      $keyword);  //�ؼ���
    $smarty->assign('action_link',  array());
    $smarty->assign('file_attr',    $file_attr);//�ļ�Ȩ��
    $smarty->assign('lang_arr',     $lang_arr); //�����ļ��б�
    $smarty->assign('file_path',    $file_path);//�����ļ�
    $smarty->assign('lang_file',    $lang_file);//�����ļ�
    $smarty->assign('language_arr', $language_arr); //��Ҫ�༭���������б�

    assign_query_info();
    $smarty->display('language_list.htm');
}

/*------------------------------------------------------ */
//-- �༭������
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'edit')
{
    /* �������·�� */
    $lang_file = isset($_POST['file_path']) ? trim($_POST['file_path']) : '';

    /* �滻ǰ�������� */
    $src_items = !empty($_POST['item']) ? stripslashes_deep($_POST['item']) : '';

    /* �޸Ĺ���������� */
    $dst_items = array();
    $_POST['item_id'] = stripslashes_deep($_POST['item_id']);

    for ($i = 0; $i < count($_POST['item_id']); $i++)
    {
        /* �������������Ϊ�գ����޸� */
        if (trim($_POST['item_content'][$i]) == '')
        {
            unset($src_items[$i]);
        }
        else
        {
            $_POST['item_content'][$i] = str_replace('\\\\n', '\\n', $_POST['item_content'][$i]);
            $dst_items[$i] = $_POST['item_id'][$i] .' = '. '"' .$_POST['item_content'][$i]. '";';
        }
    }

    /* ���ú����༭������ */
    $result = set_language_items($lang_file, $src_items, $dst_items);

    if ($result === false)
    {
        /* �޸�ʧ����ʾ��Ϣ */
        $link[] = array('text' => $_LANG['back_list'], 'href' => 'javascript:history.back(-1)');
        sys_msg($_LANG['edit_languages_false'], 0, $link);
    }
    else
    {
        /* ��¼����Ա���� */
        admin_log('', 'edit', 'languages');

        /* ������� */
        clear_cache_files();

        /* �ɹ���ʾ��Ϣ */
        $link[] = array('text' => $_LANG['back_list'], 'href' => 'edit_languages.php?act=list');
        sys_msg($_LANG['edit_languages_success'], 0, $link);
    }
}

/*------------------------------------------------------ */
//-- ������Ĳ�������
/*------------------------------------------------------ */

/**
 * ����������б�
 * @access  public
 * @exception           ����������а������з����������쳣��
 * @param   string      $file_path   ����������б���ļ��ľ���·��
 * @param   string      $keyword    ����ʱָ���Ĺؼ���
 * @return  array       ��ȷ�����������б����󷵻�false
 */
function get_language_item_list($file_path, $keyword)
{
    if (empty($keyword))
    {
        return array();
    }

    /* ��ȡ�ļ����� */
    $line_array = file($file_path);
    if (!$line_array)
    {
        return false;
    }
    else
    {
        /* ��ֹ�û����������ַ������������ʧ�� */
        $keyword = preg_quote($keyword, '/');

        $matches    = array();
        $pattern    = '/\\[[\'|"](.*?)'.$keyword.'(.*?)[\'|"]\\]\\s|=\\s?[\'|"](.*?)'.$keyword.'(.*?)[\'|"];/';
        $regx       = '/(?P<item>(?P<item_id>\\$_LANG\\[[\'|"].*[\'|"]\\])\\s*?=\\s*?[\'|"](?P<item_content>.*)[\'|"];)/';

        foreach ($line_array AS $lang)
        {
            if (preg_match($pattern, $lang))
            {
                $out = array();

                if (preg_match($regx, $lang, $out))
                {
                    $matches[] = $out;
                }
            }
        }

        return $matches;
   }
}

/**
 * ����������
 * @access  public
 * @param   string      $file_path     ����������б���ļ��ľ���·��
 * @param   array       $src_items     �滻ǰ��������
 * @param   array       $dst_items     �滻���������
 * @return  void        �ɹ��Ͱѽ��д���ļ���ʧ�ܷ���false
 */
function set_language_items($file_path, $src_items, $dst_items)
{
    /* ����ļ��Ƿ��д���޸ģ� */
    if (file_mode_info($file_path) < 2)
    {
        return false;
    }

    /* ��ȡ�ļ����� */
    $line_array = file($file_path);
    if (!$line_array)
    {
        return false;
    }
    else
    {
        $file_content = implode('', $line_array);
    }

    $snum = count($src_items);
    $dnum = count($dst_items);
    if ($snum != $dnum)
    {
        return false;
    }
    /* �������������򣬷�ֹ��λ�滻 */
    ksort($src_items);
    ksort($dst_items);
    for ($i = 0; $i < $snum; $i++)
    {
        $file_content = str_replace($src_items[$i], $dst_items[$i], $file_content);

    }

    /* д���޸ĺ�������� */
    $f = fopen($file_path, 'wb');
    if (!$f)
    {
        return false;
    }
    if (!fwrite($f, $file_content))
    {
        return false;
    }
    else
    {
        return true;
    }
}

?>