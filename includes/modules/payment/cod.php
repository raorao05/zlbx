<?php

/**
 * ECSHOP ����������
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: cod.php 17217 2011-01-19 06:29:08Z liubo $
 */

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

$payment_lang = ROOT_PATH . 'languages/' .$GLOBALS['_CFG']['lang']. '/payment/cod.php';

if (file_exists($payment_lang))
{
    global $_LANG;

    include_once($payment_lang);
}

/* ģ��Ļ�����Ϣ */
if (isset($set_modules) && $set_modules == TRUE)
{
    $i = isset($modules) ? count($modules) : 0;

    /* ���� */
    $modules[$i]['code']    = basename(__FILE__, '.php');

    /* ������Ӧ�������� */
    $modules[$i]['desc']    = 'cod_desc';

    /* �Ƿ�֧�ֻ������� */
    $modules[$i]['is_cod']  = '1';

    /* �Ƿ�֧������֧�� */
    $modules[$i]['is_online']  = '0';

    /* ֧�����ã������;��� */
    $modules[$i]['pay_fee'] = '0';

    /* ���� */
    $modules[$i]['author']  = 'ECSHOP TEAM';

    /* ��ַ */
    $modules[$i]['website'] = 'http://www.ecshop.com';

    /* �汾�� */
    $modules[$i]['version'] = '1.0.0';

    /* ������Ϣ */
    $modules[$i]['config']  = array();

    return;
}

/**
 * ��
 */
class cod
{
    /**
     * ���캯��
     *
     * @access  public
     * @param
     *
     * @return void
     */
    function cod()
    {
    }

    function __construct()
    {
        $this->cod();
    }

    /**
     * �ύ����
     */
    function get_code()
    {
        return '';
    }

    /**
     * ������
     */
    function response()
    {
        return;
    }
}

?>