<?php

/**
 * ECSHOP ���ͷ�ʽ�������
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: shipping.php 17217 2011-01-19 06:29:08Z liubo $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
$exc = new exchange($ecs->table('shipping'), $db, 'shipping_code', 'shipping_name');

/*------------------------------------------------------ */
//-- ���ͷ�ʽ�б�
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'list')
{
    $modules = read_modules('../includes/modules/shipping');

    for ($i = 0; $i < count($modules); $i++)
    {
        $lang_file = ROOT_PATH.'languages/' .$_CFG['lang']. '/shipping/' .$modules[$i]['code']. '.php';

        if (file_exists($lang_file))
        {
            include_once($lang_file);
        }

        /* ���ò���Ƿ��Ѿ���װ */
        $sql = "SELECT shipping_id, shipping_name, shipping_desc, insure, support_cod,shipping_order FROM " .$ecs->table('shipping'). " WHERE shipping_code='" .$modules[$i]['code']. "' ORDER BY shipping_order";
        $row = $db->GetRow($sql);

        if ($row)
        {
            /* ����Ѿ���װ�ˣ���������Լ����� */
            $modules[$i]['id']      = $row['shipping_id'];
            $modules[$i]['name']    = $row['shipping_name'];
            $modules[$i]['desc']    = $row['shipping_desc'];
            $modules[$i]['insure_fee']  = $row['insure'];
            $modules[$i]['cod']     = $row['support_cod'];
            $modules[$i]['shipping_order'] = $row['shipping_order'];
            $modules[$i]['install'] = 1;

            if (isset($modules[$i]['insure']) && ($modules[$i]['insure'] === false))
            {
                $modules[$i]['is_insure']  = 0;
            }
            else
            {
                $modules[$i]['is_insure']  = 1;
            }
        }
        else
        {
            $modules[$i]['name']    = $_LANG[$modules[$i]['code']];
            $modules[$i]['desc']    = $_LANG[$modules[$i]['desc']];
            $modules[$i]['insure_fee']  = empty($modules[$i]['insure'])? 0 : $modules[$i]['insure'];
            $modules[$i]['cod']     = $modules[$i]['cod'];
            $modules[$i]['install'] = 0;
        }
    }

    $smarty->assign('ur_here', $_LANG['03_shipping_list']);
    $smarty->assign('modules', $modules);
    assign_query_info();
    $smarty->display('shipping_list.htm');
}

/*------------------------------------------------------ */
//-- ��װ���ͷ�ʽ
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'install')
{
    admin_priv('ship_manage');

    $set_modules = true;
    include_once(ROOT_PATH . 'includes/modules/shipping/' . $_GET['code'] . '.php');

    /* �������ͷ�ʽ�Ƿ��Ѿ���װ */
    $sql = "SELECT shipping_id FROM " .$ecs->table('shipping'). " WHERE shipping_code = '$_GET[code]'";
    $id = $db->GetOne($sql);

    if ($id > 0)
    {
        /* �����ͷ�ʽ�Ѿ���װ��, �������ͷ�ʽ��״̬����Ϊ enable */
        $db->query("UPDATE " .$ecs->table('shipping'). " SET enabled = 1 WHERE shipping_code = '$_GET[code]' LIMIT 1");
    }
    else
    {
        /* �����ͷ�ʽû�а�װ��, �������ͷ�ʽ����Ϣ��ӵ����ݿ� */
        $insure = empty($modules[0]['insure']) ? 0 : $modules[0]['insure'];
        $sql = "INSERT INTO " . $ecs->table('shipping') . " (" .
                    "shipping_code, shipping_name, shipping_desc, insure, support_cod, enabled, print_bg, config_lable, print_model" .
                ") VALUES (" .
                    "'" . addslashes($modules[0]['code']). "', '" . addslashes($_LANG[$modules[0]['code']]) . "', '" .
                    addslashes($_LANG[$modules[0]['desc']]) . "', '$insure', '" . intval($modules[0]['cod']) . "', 1, '" . addslashes($modules[0]['print_bg']) . "', '" . addslashes($modules[0]['config_lable']) . "', '" . $modules[0]['print_model'] . "')";
        $db->query($sql);
        $id = $db->insert_Id();
    }

    /* ��¼����Ա���� */
    admin_log(addslashes($_LANG[$modules[0]['code']]), 'install', 'shipping');

    /* ��ʾ��Ϣ */
    $lnk[] = array('text' => $_LANG['add_shipping_area'], 'href' => 'shipping_area.php?act=add&shipping=' . $id);
    $lnk[] = array('text' => $_LANG['go_back'], 'href' => 'shipping.php?act=list');
    sys_msg(sprintf($_LANG['install_succeess'], $_LANG[$modules[0]['code']]), 0, $lnk);
}

/*------------------------------------------------------ */
//-- ж�����ͷ�ʽ
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'uninstall')
{
    global $ecs, $_LANG;

    admin_priv('ship_manage');

    /* ��ø����ͷ�ʽ��ID */
    $row = $db->GetRow("SELECT shipping_id, shipping_name, print_bg FROM " .$ecs->table('shipping'). " WHERE shipping_code='$_GET[code]'");
    $shipping_id = $row['shipping_id'];
    $shipping_name = $row['shipping_name'];

    /* ɾ�� shipping_fee �Լ� shipping ���е����� */
    if ($row)
    {
        $all = $db->getCol("SELECT shipping_area_id FROM " .$ecs->table('shipping_area'). " WHERE shipping_id='$shipping_id'");
        $in  = db_create_in(join(',', $all));

        $db->query("DELETE FROM " .$ecs->table('area_region'). " WHERE shipping_area_id $in");
        $db->query("DELETE FROM " .$ecs->table('shipping_area'). " WHERE shipping_id='$shipping_id'");
        $db->query("DELETE FROM " .$ecs->table('shipping'). " WHERE shipping_id='$shipping_id'");

        //ɾ���ϴ��ķ�Ĭ�Ͽ�ݵ�
        if (($row['print_bg'] != '') && (!is_print_bg_default($row['print_bg'])))
        {
            @unlink(ROOT_PATH . $row['print_bg']);
        }

        //��¼����Ա����
        admin_log(addslashes($shipping_name), 'uninstall', 'shipping');

        $lnk[] = array('text' => $_LANG['go_back'], 'href'=>'shipping.php?act=list');
        sys_msg(sprintf($_LANG['uninstall_success'], $shipping_name), 0, $lnk);
    }
}

/*------------------------------------------------------ */
//-- ģ��Flash�༭��
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'print_index')
{
    //����¼Ȩ��
    admin_priv('ship_manage');

    $shipping_id = !empty($_GET['shipping']) ? intval($_GET['shipping']) : 0;

    /* ���ò���Ƿ��Ѿ���װ ȡֵ */
    $sql = "SELECT * FROM " .$ecs->table('shipping'). " WHERE shipping_id = '$shipping_id' LIMIT 0,1";
    $row = $db->GetRow($sql);
    if ($row)
    {
        include_once(ROOT_PATH . 'includes/modules/shipping/' . $row['shipping_code'] . '.php');
        $row['shipping_print'] = !empty($row['shipping_print']) ? $row['shipping_print'] : '';
        $row['print_bg'] = empty($row['print_bg']) ? '' : get_site_root_url() . $row['print_bg'];
    }
    $smarty->assign('shipping', $row);
    $smarty->assign('shipping_id', $shipping_id);

    $smarty->display('print_index.htm');
}

/*------------------------------------------------------ */
//-- ģ��Flash�༭��
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'recovery_default_template')
{
    /* ����¼Ȩ�� */
    admin_priv('ship_manage');

    $shipping_id = !empty($_POST['shipping']) ? intval($_POST['shipping']) : 0;

    /* ȡ���ʹ��� */
    $sql = "SELECT shipping_code FROM " .$ecs->table('shipping'). " WHERE shipping_id = '$shipping_id'";
    $code = $db->GetOne($sql);

    $set_modules = true;
    include_once(ROOT_PATH . 'includes/modules/shipping/' . $code . '.php');

    /* �ָ�Ĭ�� */
    $db->query("UPDATE " .$ecs->table('shipping'). " SET print_bg = '" . addslashes($modules[0]['print_bg']) . "',  config_lable = '" . addslashes($modules[0]['config_lable']) . "' WHERE shipping_code = '$code' LIMIT 1");

    $url = "shipping.php?act=edit_print_template&shipping=$shipping_id";
    ecs_header("Location: $url\n");
}

/*------------------------------------------------------ */
//-- ģ��Flash�༭�� �ϴ�ͼƬ
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'print_upload')
{
    //����¼Ȩ��
    admin_priv('ship_manage');

    //�����ϴ��ļ�����
    $allow_suffix = array('jpg', 'png', 'jpeg');

    $shipping_id = !empty($_POST['shipping']) ? intval($_POST['shipping']) : 0;

    //�����ϴ��ļ�
    if (!empty($_FILES['bg']['name']))
    {
        if(!get_file_suffix($_FILES['bg']['name'], $allow_suffix))
        {
            echo '<script language="javascript">';
            echo 'parent.alert("' . sprintf($_LANG['js_languages']['upload_falid'], implode('��', $allow_suffix)) . '");';
            echo '</script>';
            exit;
        }

        $name = date('Ymd');
        for ($i = 0; $i < 6; $i++)
        {
            $name .= chr(mt_rand(97, 122));
        }
        $name .= '.' . end(explode('.', $_FILES['bg']['name']));
        $target = ROOT_PATH . '/images/receipt/' . $name;

        if (move_upload_file($_FILES['bg']['tmp_name'], $target))
        {
            $src = '/images/receipt/' . $name;
        }
    }

    //����
    $sql = "UPDATE " .$ecs->table('shipping'). " SET print_bg = '$src' WHERE shipping_id = '$shipping_id'";
    $res = $db->query($sql);
    if ($res)
    {
        echo '<script language="javascript">';
        echo 'parent.call_flash("bg_add", "' . get_site_root_url() . $src . '");';
        echo '</script>';
    }
}

/*------------------------------------------------------ */
//-- ģ��Flash�༭�� ɾ��ͼƬ
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'print_del')
{
    /* ���Ȩ�� */
    check_authz_json('ship_manage');

    $shipping_id = !empty($_GET['shipping']) ? intval($_GET['shipping']) : 0;
    $shipping_id = json_str_iconv($shipping_id);

    /* ���ò���Ƿ��Ѿ���װ ȡֵ */
    $sql = "SELECT print_bg FROM " .$ecs->table('shipping'). " WHERE shipping_id = '$shipping_id' LIMIT 0,1";
    $row = $db->GetRow($sql);
    if ($row)
    {
        if (($row['print_bg'] != '') && (!is_print_bg_default($row['print_bg'])))
        {
            @unlink(ROOT_PATH . $row['print_bg']);
        }

        $sql = "UPDATE " .$ecs->table('shipping'). " SET print_bg = '' WHERE shipping_id = '$shipping_id'";
        $res = $db->query($sql);
    }
    else
    {
        make_json_error($_LANG['js_languages']['upload_del_falid']);
    }

    make_json_result($shipping_id);
}

/*------------------------------------------------------ */
//-- �༭��ӡģ��
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'edit_print_template')
{
    admin_priv('ship_manage');

    $shipping_id = !empty($_GET['shipping']) ? intval($_GET['shipping']) : 0;

    /* ���ò���Ƿ��Ѿ���װ */
    $sql = "SELECT * FROM " .$ecs->table('shipping'). " WHERE shipping_id=$shipping_id";
    $row = $db->GetRow($sql);
    if ($row)
    {
        include_once(ROOT_PATH . 'includes/modules/shipping/' . $row['shipping_code'] . '.php');
        $row['shipping_print'] = !empty($row['shipping_print']) ? $row['shipping_print'] : '';
        $row['print_model'] = empty($row['print_model']) ? 1 : $row['print_model']; //������ǰ�汾

        $smarty->assign('shipping', $row);
    }
    else
    {
        $lnk[] = array('text' => $_LANG['go_back'], 'href'=>'shipping.php?act=list');
        sys_msg($_LANG['no_shipping_install'] , 0, $lnk);
    }

    $smarty->assign('ur_here', $_LANG['03_shipping_list'] .' - '. $row['shipping_name'] .' - '. $_LANG['shipping_print_template']);
    $smarty->assign('action_link', array('text' => $_LANG['03_shipping_list'], 'href' => 'shipping.php?act=list'));
    $smarty->assign('shipping_id', $shipping_id);

    assign_query_info();

    $smarty->display('shipping_template.htm');
}

/*------------------------------------------------------ */
//-- �༭��ӡģ��
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'do_edit_print_template')
{
    /* ���Ȩ�� */
    admin_priv('ship_manage');

    /* �������� */
    $print_model = !empty($_POST['print_model']) ? intval($_POST['print_model']) : 0;
    $shipping_id = !empty($_REQUEST['shipping']) ? intval($_REQUEST['shipping']) : 0;

    /* ����ͬģʽ�༭�ı� */
    if ($print_model == 2)
    {
        //����������ģʽ
        $db->query("UPDATE " . $ecs->table('shipping'). " SET config_lable = '" . $_POST['config_lable'] . "', print_model = '$print_model'  WHERE shipping_id = '$shipping_id'");
    }
    elseif ($print_model == 1)
    {
        //����ģʽ
        $template = !empty($_POST['shipping_print']) ? $_POST['shipping_print'] : '';

        $db->query("UPDATE " . $ecs->table('shipping'). " SET shipping_print = '" . $template . "', print_model = '$print_model' WHERE shipping_id = '$shipping_id'");
    }

    /* ��¼����Ա���� */
    admin_log(addslashes($_POST['shipping_name']), 'edit', 'shipping');

    $lnk[] = array('text' => $_LANG['go_back'], 'href'=>'shipping.php?act=list');
    sys_msg($_LANG['edit_template_success'], 0, $lnk);

}

/*------------------------------------------------------ */
//-- �༭���ͷ�ʽ����
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'edit_name')
{
    /* ���Ȩ�� */
    check_authz_json('ship_manage');

    /* ȡ�ò��� */
    $id  = json_str_iconv(trim($_POST['id']));
    $val = json_str_iconv(trim($_POST['val']));

    /* ��������Ƿ�Ϊ�� */
    if (empty($val))
    {
        make_json_error($_LANG['no_shipping_name']);
    }

    /* ��������Ƿ��ظ� */
    if (!$exc->is_only('shipping_name', $val, $id))
    {
        make_json_error($_LANG['repeat_shipping_name']);
    }

    /* ����֧����ʽ���� */
    $exc->edit("shipping_name = '$val'", $id);
    make_json_result(stripcslashes($val));
}

/*------------------------------------------------------ */
//-- �༭���ͷ�ʽ����
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'edit_desc')
{
    /* ���Ȩ�� */
    check_authz_json('ship_manage');

    /* ȡ�ò��� */
    $id = json_str_iconv(trim($_POST['id']));
    $val = json_str_iconv(trim($_POST['val']));

    /* �������� */
    $exc->edit("shipping_desc = '$val'", $id);
    make_json_result(stripcslashes($val));
}

/*------------------------------------------------------ */
//-- �޸����ͷ�ʽ���۷�
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'edit_insure')
{
    /* ���Ȩ�� */
    check_authz_json('ship_manage');

    /* ȡ�ò��� */
    $id = json_str_iconv(trim($_POST['id']));
    $val = json_str_iconv(trim($_POST['val']));
    if (empty($val))
    {
        $val = 0;
    }
    else
    {
        $val = make_semiangle($val); //ȫ��ת���
        if (strpos($val, '%') === false)
        {
            $val = floatval($val);
        }
        else
        {
            $val = floatval($val) . '%';
        }
    }

    /* ���ò���Ƿ�֧�ֱ��� */
    $set_modules = true;
    include_once(ROOT_PATH . 'includes/modules/shipping/' .$id. '.php');
    if (isset($modules[0]['insure']) && $modules[0]['insure'] === false)
    {
        make_json_error($_LANG['not_support_insure']);
    }

    /* ���±��۷��� */
    $exc->edit("insure = '$val'", $id);
    make_json_result(stripcslashes($val));
}
elseif($_REQUEST['act'] == 'shipping_priv')
{
    check_authz_json('ship_manage');

    make_json_result('');
}
/*------------------------------------------------------ */
//-- �޸����ͷ�ʽ����
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'edit_order')
{
    /* ���Ȩ�� */
    check_authz_json('ship_manage');

    /* ȡ�ò��� */
    $code = json_str_iconv(trim($_POST['id']));
    $order = intval($_POST['val']);

    /* �������� */
    $exc->edit("shipping_order = '$order'", $code);
    make_json_result(stripcslashes($order));
}
/**
 * ��ȡվ���Ŀ¼��ַ
 *
 * @access  private
 * @return  Bool
 */
function get_site_root_url()
{
    return 'http://' . $_SERVER['HTTP_HOST'] . str_replace('/' . ADMIN_PATH . '/shipping.php', '', PHP_SELF);

}

/**
 * �ж��Ƿ�ΪĬ�ϰ�װ��ݵ�����ͼƬ
 *
 * @param   string      $print_bg      ��ݵ�����ͼƬ·����
 * @access  private
 *
 * @return  Bool
 */
function is_print_bg_default($print_bg)
{
    $_bg = basename($print_bg);

    $_bg_array = explode('.', $_bg);

    if (count($_bg_array) != 2)
    {
        return false;
    }

    if (strpos('|' . $_bg_array[0], 'dly_') != 1)
    {
        return false;
    }

    $_bg_array[0] = ltrim($_bg_array[0], 'dly_');
    $list = explode('|', SHIP_LIST);

    if (in_array($_bg_array[0], $list))
    {
        return true;
    }

    return false;
}
?>