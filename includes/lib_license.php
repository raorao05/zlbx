<?php

/**
 * ECSHOP LICENSE ��غ�����
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: lib_article.php 16336 2009-06-24 07:09:13Z liubo $
*/

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

/**
 * ������� license ��Ϣ
 *
 * @access  public
 * @param   integer     $size
 *
 * @return  array
 */
function get_shop_license()
{
    // ȡ������ license
    $sql = "SELECT code, value
            FROM " . $GLOBALS['ecs']->table('shop_config') . "
            WHERE code IN ('certificate_id', 'token', 'certi')
            LIMIT 0,3";
    $license_info = $GLOBALS['db']->getAll($sql);
    $license_info = is_array($license_info) ? $license_info : array();
    $license = array();
    foreach ($license_info as $value)
    {
        $license[$value['code']] = $value['value'];
    }

    return $license;
}

/**
 * ���ܣ�����certi_ac��֤�ֶ�
 * @param   string     POST���ݲ���
 * @param   string     ֤��token
 * @return  string
 */
function make_shopex_ac($post_params, $token)
{
    if (!is_array($post_params))
    {
        return;
    }

    // core
    ksort($post_params);
    $str = '';
    foreach($post_params as $key=>$value){
        if($key != 'certi_ac')
        {
            $str .= $value;
        }
    }

    return md5($str . $token);
}

/**
 * ���ܣ��� ECShop ��������
 *
 * @param   array     $certi    ��¼����
 * @param   array     $license  ����license��Ϣ
 * @param   bool      $use_lib  ʹ����һ��json�⣬0Ϊec��1Ϊshopex
 * @return  array
 */
function exchange_shop_license($certi, $license, $use_lib = 0)
{
    if (!is_array($certi))
    {
        return array();
    }

    include_once(ROOT_PATH . 'includes/cls_transport.php');
    include_once(ROOT_PATH . 'includes/cls_json.php');

    $params = '';
    foreach ($certi as $key => $value)
    {
        $params .= '&' . $key . '=' . $value;
    }
    $params = trim($params, '&');

    $transport = new transport;
    //$transport->connect_timeout = 1;
    $request = $transport->request($license['certi'], $params, 'POST');
    $request_str = json_str_iconv($request['body']);

    if (empty($use_lib))
    {
        $json = new JSON();
        $request_arr = $json->decode($request_str, 1);
    }
    else
    {
        include_once(ROOT_PATH . 'includes/shopex_json.php');
        $request_arr = json_decode($request_str, 1);
    }

    return $request_arr;
}

/**
 * ���ܣ������¼���ؽ��
 *
 * @param   array     $cert_auth    ��¼���ص��û���Ϣ
 * @return  array
 */
function process_login_license($cert_auth)
{
    if (!is_array($cert_auth))
    {
        return array();
    }

    $cert_auth['auth_str'] = trim($cert_auth['auth_str']);
    if (!empty($cert_auth['auth_str']))
    {
        $cert_auth['auth_str'] = $GLOBALS['_LANG']['license_' . $cert_auth['auth_str']];
    }

    $cert_auth['auth_type'] = trim($cert_auth['auth_type']);
    if (!empty($cert_auth['auth_type']))
    {
        $cert_auth['auth_type'] = $GLOBALS['_LANG']['license_' . $cert_auth['auth_type']];
    }

    return $cert_auth;
}

/**
 * ���ܣ�license ��¼
 *
 * @param   array     $certi_added    ������Ϣ�������� array_key ��¼��Ϣ��key��array_key => array_value��
 * @return  array     $return_array['flag'] = login_succ��login_fail��login_ping_fail��login_param_fail��
 *                    $return_array['request']��
 */
function license_login($certi_added = '')
{
    // ��¼��Ϣ����
    $certi['certi_app'] = ''; // ֤�鷽��
    $certi['app_id'] = 'ecshop_b2c'; // ˵���ͻ�����Դ
    $certi['app_instance_id'] = ''; // Ӧ�÷���ID
    $certi['version'] = LICENSE_VERSION; // license�ӿڰ汾��
    $certi['shop_version'] = VERSION . '#' .  RELEASE; // ��������汾��
    $certi['certi_url'] = sprintf($GLOBALS['ecs']->url()); // ����URL
    $certi['certi_session'] = $GLOBALS['sess']->get_session_id(); // ����SESSION��ʶ
    $certi['certi_validate_url'] = sprintf($GLOBALS['ecs']->url() . 'certi.php'); // �����ṩ�ڹٷ�����ӿ�
    $certi['format'] = 'json'; // �ٷ��������ݸ�ʽ
    $certi['certificate_id'] = ''; // ����֤��ID
    // ��ʶ
    $certi_back['succ']   = 'succ';
    $certi_back['fail']   = 'fail';
    // return ��������
    $return_array = array();

    if (is_array($certi_added))
    {
        foreach ($certi_added as $key => $value)
        {
            $certi[$key] = $value;
        }
    }

    // ȡ������ license
    $license = get_shop_license();

    // ������� license
    if (!empty($license['certificate_id']) && !empty($license['token']) && !empty($license['certi']))
    {
        // ��¼
        $certi['certi_app'] = 'certi.login'; // ֤�鷽��
        $certi['app_instance_id'] = 'cert_auth'; // Ӧ�÷���ID
        $certi['certificate_id'] = $license['certificate_id']; // ����֤��ID
        $certi['certi_ac'] = make_shopex_ac($certi, $license['token']); // ������֤�ַ���

        $request_arr = exchange_shop_license($certi, $license);
        if (is_array($request_arr) && $request_arr['res'] == $certi_back['succ'])
        {
            $return_array['flag'] = 'login_succ';
            $return_array['request'] = $request_arr;
        }
        elseif (is_array($request_arr) && $request_arr['res'] == $certi_back['fail'])
        {
            $return_array['flag'] = 'login_fail';
            $return_array['request'] = $request_arr;
        }
        else
        {
            $return_array['flag'] = 'login_ping_fail';
            $return_array['request'] = array('res' => 'fail');
        }
    }
    else
    {
        $return_array['flag'] = 'login_param_fail';
        $return_array['request'] = array('res' => 'fail');
    }

    return $return_array;
}

/**
 * ���ܣ�license ע��
 *
 * @param   array     $certi_added    ������Ϣ�������� array_key ��¼��Ϣ��key��array_key => array_value��
 * @return  array     $return_array['flag'] = reg_succ��reg_fail��reg_ping_fail��
 *                    $return_array['request']��
 */
function license_reg($certi_added = '')
{
    // ��¼��Ϣ����
    $certi['certi_app'] = ''; // ֤�鷽��
    $certi['app_id'] = 'ecshop_b2c'; // ˵���ͻ�����Դ
    $certi['app_instance_id'] = ''; // Ӧ�÷���ID
    $certi['version'] = LICENSE_VERSION; // license�ӿڰ汾��
    $certi['shop_version'] = VERSION . '#' .  RELEASE; // ��������汾��
    $certi['certi_url'] = sprintf($GLOBALS['ecs']->url()); // ����URL
    $certi['certi_session'] = $GLOBALS['sess']->get_session_id(); // ����SESSION��ʶ
    $certi['certi_validate_url'] = sprintf($GLOBALS['ecs']->url() . 'certi.php'); // �����ṩ�ڹٷ�����ӿ�
    $certi['format'] = 'json'; // �ٷ��������ݸ�ʽ
    $certi['certificate_id'] = ''; // ����֤��ID
    // ��ʶ
    $certi_back['succ']   = 'succ';
    $certi_back['fail']   = 'fail';
    // return ��������
    $return_array = array();

    if (is_array($certi_added))
    {
        foreach ($certi_added as $key => $value)
        {
            $certi[$key] = $value;
        }
    }

    // ȡ������ license
    $license = get_shop_license();

    // ע��
    $certi['certi_app'] = 'certi.reg'; // ֤�鷽��
    $certi['certi_ac'] = make_shopex_ac($certi, ''); // ������֤�ַ���
    unset($certi['certificate_id']);

    $request_arr = exchange_shop_license($certi, $license);
    if (is_array($request_arr) && $request_arr['res'] == $certi_back['succ'])
    {
        // ע����Ϣ���
        $sql = "UPDATE " . $GLOBALS['ecs']->table('shop_config') . "
                SET value = '" . $request_arr['info']['certificate_id'] . "' WHERE code = 'certificate_id'";
        $GLOBALS['db']->query($sql);
        $sql = "UPDATE " . $GLOBALS['ecs']->table('shop_config') . "
                SET value = '" . $request_arr['info']['token'] . "' WHERE code = 'token'";
        $GLOBALS['db']->query($sql);

        $return_array['flag'] = 'reg_succ';
        $return_array['request'] = $request_arr;
        clear_cache_files();
    }
    elseif (is_array($request_arr) && $request_arr['res'] == $certi_back['fail'])
    {
        $return_array['flag'] = 'reg_fail';
        $return_array['request'] = $request_arr;
    }
    else
    {
        $return_array['flag'] = 'reg_ping_fail';
        $return_array['request'] = array('res' => 'fail');
    }

    return $return_array;
}
?>