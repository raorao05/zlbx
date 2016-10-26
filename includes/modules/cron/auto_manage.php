<?php

/**
 * ECSHOP ����˵��
 * ===========================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ==========================================================
 * $Author: liubo $
 * $Id: auto_manage.php 17217 2011-01-19 06:29:08Z liubo $
 */

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}
$cron_lang = ROOT_PATH . 'languages/' .$GLOBALS['_CFG']['lang']. '/cron/auto_manage.php';
if (file_exists($cron_lang))
{
    global $_LANG;

    include_once($cron_lang);
}

/* ģ��Ļ�����Ϣ */
if (isset($set_modules) && $set_modules == TRUE)
{
    $i = isset($modules) ? count($modules) : 0;

    /* ���� */
    $modules[$i]['code']    = basename(__FILE__, '.php');

    /* ������Ӧ�������� */
    $modules[$i]['desc']    = 'auto_manage_desc';

    /* ���� */
    $modules[$i]['author']  = 'ECSHOP TEAM';

    /* ��ַ */
    $modules[$i]['website'] = 'http://www.ecshop.com';

    /* �汾�� */
    $modules[$i]['version'] = '1.0.0';

    /* ������Ϣ */
    $modules[$i]['config']  = array(
        array('name' => 'auto_manage_count', 'type' => 'select', 'value' => '5'),
    );

    return;
}
$time = gmtime();
$limit = !empty($cron['auto_manage_count']) ? $cron['auto_manage_count'] : 5;
$sql = "SELECT * FROM " . $GLOBALS['ecs']->table('auto_manage') . " WHERE starttime > '0' AND starttime <= '$time' OR endtime > '0' AND endtime <= '$time' LIMIT $limit";
$autodb = $db->getAll($sql);
foreach ($autodb as $key => $val)
{
    $del = $up = false;
    if ($val['type'] == 'goods')
    {
        $goods = true;
        $where = " WHERE goods_id = '$val[item_id]'";
    }
    else
    {
        $goods = false;
        $where = " WHERE article_id = '$val[item_id]'";
    }


    //���¼��ж�
    if(!empty($val['starttime']) && !empty($val['endtime']))
    {
        //���¼�ʱ�������
        if($val['starttime'] <= $time && $time < $val['endtime'])
        {
            //�ϼ�ʱ�� <= ��ǰʱ�� < �¼�ʱ��
            $up = true;
            $del = false;
        }
        elseif($val['starttime'] >= $time && $time > $val['endtime'])
        {
            //�¼�ʱ�� <= ��ǰʱ�� < �ϼ�ʱ��
            $up = false;
            $del = false;
        }
        elseif($val['starttime'] == $time && $time == $val['endtime'])
        {
            //�¼�ʱ�� == ��ǰʱ�� == �ϼ�ʱ��
            $sql = "DELETE FROM " . $GLOBALS['ecs']->table('auto_manage') . "WHERE item_id = '$val[item_id]' AND type = '$val[type]'";
            $db->query($sql);
            continue;
        }
        elseif($val['starttime'] > $val['endtime'])
        {
            // �¼�ʱ�� < �ϼ�ʱ�� < ��ǰʱ��
            $up = true;
            $del = true;
        }
        elseif($val['starttime'] < $val['endtime'])
        {
            // �ϼ�ʱ�� < �¼�ʱ�� < ��ǰʱ��
            $up = false;
            $del = true;
        }
        else
        {
            // �ϼ�ʱ�� = �¼�ʱ�� < ��ǰʱ��
            $sql = "DELETE FROM " . $GLOBALS['ecs']->table('auto_manage') . "WHERE item_id = '$val[item_id]' AND type = '$val[type]'";
            $db->query($sql);

            continue;
        }
    }
    elseif(!empty($val['starttime']))
    {
        //ֻ�������ϼ�ʱ��
        $up = true;
        $del = true;
    }
    else
    {
        //ֻ�������¼�ʱ��
        $up = false;
        $del = true;
    }

    if ($goods)
    {
        if ($up)
        {
            $sql = "UPDATE " . $GLOBALS['ecs']->table('goods') . " SET is_on_sale = 1 $where";
        }
        else
        {
            $sql = "UPDATE " . $GLOBALS['ecs']->table('goods') . " SET is_on_sale = 0 $where";
        }
    }
    else
    {
        if ($up)
        {
            $sql = "UPDATE " . $GLOBALS['ecs']->table('article') . " SET is_open = 1 $where";
        }
        else
        {
            $sql = "UPDATE " . $GLOBALS['ecs']->table('article') . " SET is_open = 0 $where";
        }
    }
    $db->query($sql);
    if ($del)
    {
        $sql = "DELETE FROM " . $GLOBALS['ecs']->table('auto_manage') . "WHERE item_id = '$val[item_id]' AND type = '$val[type]'";
        $db->query($sql);
    }
    else
    {
        if($up)
        {
            $sql = "UPDATE " . $GLOBALS['ecs']->table('auto_manage') . " SET starttime = 0 WHERE item_id = '$val[item_id]' AND type = '$val[type]'";
        }
        else
        {
            $sql = "UPDATE " . $GLOBALS['ecs']->table('auto_manage') . " SET endtime = 0 WHERE item_id = '$val[item_id]' AND type = '$val[type]'";
        }
        $db->query($sql);
    }
}
?>