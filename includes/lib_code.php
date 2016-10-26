<?php

/**
 * ECSHOP ���ܽ�����
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: lib_code.php 17217 2011-01-19 06:29:08Z liubo $
 */

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}


/**
 * ���ܺ���
 * @param   string  $str    ����ǰ���ַ���
 * @param   string  $key    ��Կ
 * @return  string  ���ܺ���ַ���
 */
function encrypt($str, $key = AUTH_KEY)
{
    $coded = '';
    $keylength = strlen($key);

    for ($i = 0, $count = strlen($str); $i < $count; $i += $keylength)
    {
        $coded .= substr($str, $i, $keylength) ^ $key;
    }

    return str_replace('=', '', base64_encode($coded));
}

/**
 * ���ܺ���
 * @param   string  $str    ���ܺ���ַ���
 * @param   string  $key    ��Կ
 * @return  string  ����ǰ���ַ���
 */
function decrypt($str, $key = AUTH_KEY)
{
    $coded = '';
    $keylength = strlen($key);
    $str = base64_decode($str);

    for ($i = 0, $count = strlen($str); $i < $count; $i += $keylength)
    {
        $coded .= substr($str, $i, $keylength) ^ $key;
    }

    return $coded;
}

?>