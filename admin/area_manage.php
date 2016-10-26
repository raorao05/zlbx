<?php

/**
 * ECSHOP �����б�����ļ�
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: area_manage.php 17217 2011-01-19 06:29:08Z liubo $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
$exc = new exchange($ecs->table('region'), $db, 'region_id', 'region_name');

/* act������ĳ�ʼ�� */
if (empty($_REQUEST['act']))
{
    $_REQUEST['act'] = 'list';
}
else
{
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

/*------------------------------------------------------ */
//-- �г�ĳ�����µ����е����б�
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'list')
{
    admin_priv('area_manage');

    /* ȡ�ò������ϼ�����id */
    $region_id = empty($_REQUEST['pid']) ? 0 : intval($_REQUEST['pid']);
    $smarty->assign('parent_id',    $region_id);

    /* ȡ���б���ʾ�ĵ��������� */
    if ($region_id == 0)
    {
        $region_type = 0;
    }
    else
    {
        $region_type = $exc->get_name($region_id, 'region_type') + 1;
    }
    $smarty->assign('region_type',  $region_type);

    /* ��ȡ�����б� */
    $region_arr = area_list($region_id);
    $smarty->assign('region_arr',   $region_arr);

    /* ��ǰ�ĵ������� */
    if ($region_id > 0)
    {
        $area_name = $exc->get_name($region_id);
        $area = '[ '. $area_name . ' ] ';
        if ($region_arr)
        {
            $area .= $region_arr[0]['type'];
        }
    }
    else
    {
        $area = $_LANG['country'];
    }
    $smarty->assign('area_here',    $area);

    /* ������һ�������� */
    if ($region_id > 0)
    {
        $parent_id = $exc->get_name($region_id, 'parent_id');
        $action_link = array('text' => $_LANG['back_page'], 'href' => 'area_manage.php?act=list&&pid=' . $parent_id);
    }
    else
    {
        $action_link = '';
    }
    $smarty->assign('action_link',  $action_link);

    /* ��ֵģ����ʾ */
    $smarty->assign('ur_here',      $_LANG['05_area_list']);
    $smarty->assign('full_page',    1);

    assign_query_info();
    $smarty->display('area_list.htm');
}

/*------------------------------------------------------ */
//-- ����µĵ���
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'add_area')
{
    check_authz_json('area_manage');

    $parent_id      = intval($_POST['parent_id']);
    $region_name    = json_str_iconv(trim($_POST['region_name']));
    $region_type    = intval($_POST['region_type']);

    if (empty($region_name))
    {
        make_json_error($_LANG['region_name_empty']);
    }

    /* �鿴�����Ƿ��ظ� */
    if (!$exc->is_only('region_name', $region_name, 0, "parent_id = '$parent_id'"))
    {
        make_json_error($_LANG['region_name_exist']);
    }

    $sql = "INSERT INTO " . $ecs->table('region') . " (parent_id, region_name, region_type) ".
           "VALUES ('$parent_id', '$region_name', '$region_type')";
    if ($GLOBALS['db']->query($sql, 'SILENT'))
    {
        admin_log($region_name, 'add','area');

        /* ��ȡ�����б� */
        $region_arr = area_list($parent_id);
        $smarty->assign('region_arr',   $region_arr);

        $smarty->assign('region_type', $region_type);

        make_json_result($smarty->fetch('area_list.htm'));
    }
    else
    {
        make_json_error($_LANG['add_area_error']);
    }
}

/*------------------------------------------------------ */
//-- �༭��������
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'edit_area_name')
{
    check_authz_json('area_manage');

    $id = intval($_POST['id']);
    $region_name = json_str_iconv(trim($_POST['val']));

    if (empty($region_name))
    {
        make_json_error($_LANG['region_name_empty']);
    }

    $msg = '';

    /* �鿴�����Ƿ��ظ� */
    $parent_id = $exc->get_name($id, 'parent_id');
    if (!$exc->is_only('region_name', $region_name, $id, "parent_id = '$parent_id'"))
    {
        make_json_error($_LANG['region_name_exist']);
    }

    if ($exc->edit("region_name = '$region_name'", $id))
    {
        admin_log($region_name, 'edit', 'area');
        make_json_result(stripslashes($region_name));
    }
    else
    {
        make_json_error($db->error());
    }
}

/*------------------------------------------------------ */
//-- ɾ������
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'drop_area')
{
    check_authz_json('area_manage');

    $id = intval($_REQUEST['id']);

    $sql = "SELECT * FROM " . $ecs->table('region') . " WHERE region_id = '$id'";
    $region = $db->getRow($sql);

//    /* ����������¼�����,����ɾ�� */
//    $sql = "SELECT COUNT(*) FROM " . $ecs->table('region') . " WHERE parent_id = '$id'";
//    if ($db->getOne($sql) > 0)
//    {
//        make_json_error($_LANG['parent_id_exist']);
//    }
    $region_type=$region['region_type'];
    $delete_region[]=$id;
    $new_region_id  =$id;
    if($region_type<6)
    {
        for($i=1;$i<6-$region_type;$i++)
        {
             $new_region_id=new_region_id($new_region_id);
             if(count($new_region_id))
             {
                  $delete_region=array_merge($delete_region,$new_region_id);
             }
             else
             {
                 continue;
             }
        }
    }
    $sql="DELETE FROM ". $ecs->table("region")."WHERE region_id".db_create_in($delete_region);
     $db->query($sql);
    if ($exc->drop($id))
    {
        admin_log(addslashes($region['region_name']), 'remove', 'area');

        /* ��ȡ�����б� */
        $region_arr = area_list($region['parent_id']);
        $smarty->assign('region_arr',   $region_arr);
        $smarty->assign('region_type', $region['region_type']);

        make_json_result($smarty->fetch('area_list.htm'));
    }
    else
    {
        make_json_error($db->error());
    }
}


function new_region_id($region_id)
{
    $regions_id=array();
    if(empty($region_id))
    {
        return $regions_id;
    }
    $sql="SELECT region_id FROM ". $GLOBALS['ecs']->table("region")."WHERE parent_id ".db_create_in($region_id);
    $result=$GLOBALS['db']->getAll($sql);
    foreach($result as $val)
    {
        $regions_id[]=$val['region_id'];
    }
    return $regions_id;
}
?>