<?php
/**
 * ECSHOP OPEN APIͳһ�ӿ�
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: sxc_shop $
 * $Id: goods.php 15921 2009-05-07 05:35:58Z sxc_shop $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require(ROOT_PATH . 'includes/lib_license.php');
require_once('includes/cls_json.php');

define('RETURN_TYPE', empty($_POST['return_data']) ? 1 : ($_POST['return_data'] == 'json' ? 2 : 1));

/* ���մ��ݲ������������� */
if (empty($_POST) || empty($_POST['ac']))
{
    api_err('0x003', 'no parameter');   //���ϵͳ������:�����쳣
}

/* �����������ͽ�����Ӧ�Ľӿڴ������ */
switch ($_POST['act'])
{
    case 'search_goods_list': search_goods_list(); break;
    case 'search_goods_detail': search_goods_detail(); break;
    case 'search_deleted_goods_list': search_deleted_goods_list(); break;
    case 'search_products_list': search_products_list(); break;
    case 'search_site_info': search_site_info(); break;
    default: api_err('0x008', 'no this type api');   //���ϵͳ������:�����쳣
}


/**
 *  ��ȡ��Ʒ�б�ӿں���
 */
function search_goods_list()
{
    check_auth();   //������Ȩ��

    $version = '1.0';   //�汾��

    if ($_POST['api_version'] != $version)      //����Ľӿڰ汾��
    {
        api_err('0x008', 'a low version api');
    }

    if (is_numeric($_POST['last_modify_st_time']) && is_numeric($_POST['last_modify_en_time']))
    {
        $sql = 'SELECT COUNT(*) AS count' .
               ' FROM ' . $GLOBALS['ecs']->table('goods') .
               " WHERE is_delete = 0 AND is_on_sale = 1 AND (last_update > '" . $_POST['last_modify_st_time'] . "' OR last_update = 0)";
        $date_count = $GLOBALS['db']->getRow($sql);

        if (empty($date_count))
        {
            api_err('0x003', 'no data to back');    //�޷�����������
        }

        $page = empty($_POST['pages']) ? 1 : $_POST['pages'];       //ȷ����ȡ��Щ��¼
        $counts = empty($_POST['counts']) ? 100 : $_POST['counts'];

        $sql = 'SELECT goods_id, last_update AS last_modify' .
               ' FROM ' . $GLOBALS['ecs']->table('goods') .
               " WHERE is_delete = 0 AND is_on_sale = 1 AND (last_update > '" . $_POST['last_modify_st_time'] . "' OR last_update = 0)".
               " LIMIT ".($page - 1) * $counts . ', ' . $counts;
        $date_arr = $GLOBALS['db']->getAll($sql);

        if (!empty($_POST['columns']))
        {
            $column_arr = explode('|', $_POST['columns']);
            foreach ($date_arr as $k => $v)
            {
                foreach ($v as $key => $val)
                {
                    if (in_array($key, $column_arr))
                    {
                        $re_arr['data_info'][$k][$key] = $val;
                    }
                }
            }
        }
        else
        {
            $re_arr['data_info'] = $date_arr;
        }

        /* �������ʱ�����0������ */
        $sql = 'UPDATE ' . $GLOBALS['ecs']->table('goods') .
               " SET last_update = 1 WHERE is_delete = 0 AND is_on_sale = 1 AND last_update = 0";
        $GLOBALS['db']->query($sql, 'SILENT');

        $re_arr['counts'] = $date_count['count'];
        data_back($re_arr, '', RETURN_TYPE);  //��������
    }
    else
    {
        api_err('0x003', 'required date invalid');   //���������쳣
    }
}

/**
 *  ��Ʒ��ϸ��Ϣ�ӿں���
 */
function search_goods_detail()
{
    check_auth();   //������Ȩ��

    $version = '1.0';   //�汾��

    if ($_POST['api_version'] != $version)      //����Ľӿڰ汾��
    {
        api_err('0x008', 'a low version api');
    }

    if (!empty($_POST['goods_id']) && is_numeric($_POST['goods_id']))
    {
        $sql = 'SELECT g.goods_id, g.last_update AS last_modify, g.cat_id, c.cat_name AS category_name, g.brand_id, b.brand_name, g.shop_price AS price, g.goods_sn AS bn, g.goods_name AS name, g.is_on_sale AS marketable, g.goods_weight AS weight, g.goods_number AS store , g.give_integral AS score, g.add_time AS uptime, g.original_img AS image_default, g.goods_desc AS intro' .
        ' FROM ' . $GLOBALS['ecs']->table('category') . ' AS c, ' . $GLOBALS['ecs']->table('goods') . ' AS g LEFT JOIN ' . $GLOBALS['ecs']->table('brand') . ' AS b ON g.brand_id = b.brand_id'.
        ' WHERE g.cat_id = c.cat_id AND g.goods_id = ' . $_POST['goods_id'];
        $goods_data = $GLOBALS['db']->getRow($sql);

        if (empty($goods_data))
        {
            api_err('0x003', 'no data to back');    //�޷�����������
        }

        $goods_data['goods_link'] = 'http://' . $_SERVER['HTTP_HOST'] . '/goods.php?id=' . $goods_data['goods_id'];
        $goods_data['image_default'] = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $goods_data['image_default'];
        $goods_data['unit'] = 'ǧ��';
        $goods_data['brand_name'] = empty($goods_data['brand_name']) ? '' : $goods_data['brand_name'];

        $prop = create_goods_properties($_POST['goods_id']);
        $goods_data['props_name'] = $prop['props_name'];
        $goods_data['props'] = $prop['props'];

        if (!empty($_POST['columns']))
        {
            $column_arr = explode('|', $_POST['columns']);
            foreach ($goods_data as $key=>$val)
            {
                if (in_array($key, $column_arr))
                {
                    $re_arr['data_info'][$key] = $val;
                }
            }
        }
        else
        {
            $re_arr['data_info'] = $goods_data;
        }

        data_back($re_arr, '', RETURN_TYPE);  //��������
    }
    else
    {
        api_err('0x003', 'required date invalid');   //���������쳣
    }
}

/**
 *  ��ɾ����Ʒ�б�ӿں���
 */
function search_deleted_goods_list()
{
    api_err('0x007', '��ʱ���ṩ�˷�����');   //���񲻿���
}

/**
 *  ��ȡ��Ʒ�б�ӿں���
 */
function search_products_list()
{
    check_auth();   //������Ȩ��

    $version = '1.0';   //�汾��

    if ($_POST['api_version'] != $version)      //����Ľӿڰ汾��
    {
        api_err('0x008', 'a low version api');
    }

    if (!empty($_POST['goods_id']) && is_numeric($_POST['goods_id']) || !empty($_POST['bn']))
    {
        $sql = 'SELECT goods_id, last_update AS last_modify, shop_price AS price, goods_sn AS bn, goods_name AS name,  goods_weight         AS weight, goods_number AS store, add_time AS uptime' .
               ' FROM ' . $GLOBALS['ecs']->table('goods') .
               ' WHERE ' . empty($_POST['bn']) ? "goods_id = $_POST[goods_id]" : "goods_sn = $_POST[bn]";
        $goods_data = $GLOBALS['db']->getRow($sql);

        if (empty($goods_data))
        {
            api_err('0x003', 'no data to back');    //�޷�����������
        }

        $goods_data['product_id'] = $_POST['goods_id'];
        $goods_data['cost'] = $goods_data['price'];

        $prop = create_goods_properties($_POST['goods_id']);
        $goods_data['props'] = $prop['props'];

        if (!empty($_POST['columns']))
        {
            $column_arr = explode('|', $_POST['columns']);
            foreach ($goods_data as $key=>$val)
            {
                if (in_array($key, $column_arr))
                {
                    $re_arr['data_info'][$key] = $val;
                }
            }
        }
        else
        {
            $re_arr['data_info'] = $goods_data;
        }

        data_back($re_arr, '', RETURN_TYPE);  //��������
    }
    else
    {
        api_err('0x003', 'required date invalid');   //���������쳣
    }
}

/**
 *  ��ȡվ����Ϣ�ӿں���
 */
function search_site_info()
{
    check_auth();   //������Ȩ��

    $version = '1.0';   //�汾��

    if ($_POST['api_version'] != $version)      //����Ľӿڰ汾��
    {
        api_err('0x008', 'a low version api');
    }

    $sql = 'SELECT code, value'.
           ' FROM ' . $GLOBALS['ecs']->table('shop_config') .
           " WHERE code IN ('shop_name', 'service_phone')";

    $siteinfo['data_info'] = $GLOBALS['db']->getRow($sql);

    $siteinfo['data_info']['site_address'] = $_SERVER['SERVER_NAME'];

    data_back($siteinfo, '', RETURN_TYPE);  //��������
}

/**
 *  Ȩ��У�麯��
 */
function check_auth()
{
    $license = get_shop_license();  // ȡ������ license��Ϣ
    if (empty($license['certificate_id']) || empty($license['token']) || empty($license['certi']))
    {
        api_err('0x006', 'no certificate');   //û��֤�����ݣ����ϵͳ������:�û�Ȩ�޲���
    }

    if (!check_shopex_ac($_POST, $license['token']))
    {
        api_err('0x009');   //���ϵͳ������:ǩ����Ч
    }

    /* ��Ӧ�������session������֤ */
    $certi['certificate_id'] = $license['certificate_id']; // ����֤��ID
    $certi['app_id'] = 'ecshop_b2c'; // ˵���ͻ�����Դ
    $certi['app_instance_id'] = 'webcollect'; // Ӧ�÷���ID
    $certi['version'] = VERSION . '#' .  RELEASE; // ��������汾��
    $certi['format'] = 'json'; // �ٷ��������ݸ�ʽ
    $certi['certi_app'] = 'sess.valid_session'; // ֤�鷽��
    $certi['certi_session'] = $_POST['app_session']; //Ӧ�÷����������sessionֵ
    $certi['certi_ac'] = make_shopex_ac($certi, $license['token']); // ������֤�ַ���

    $request_arr = exchange_shop_license($certi, $license);
    if ($request_arr['res'] != 'succ')
    {
        api_err('0x001', 'session is invalid');   //���ϵͳ������:�����֤ʧ��
    }
}

/**
 *  ��֤POSTǩ��
 *
 *  @param   string   $post_params   POST���ݲ���
 *  @param   string   $token         ֤�������
 *
 *  @return  boolean                 �����Ƿ���Ч
 */
function check_shopex_ac($post_params,$token)
{
    ksort($post_params);
    $str = '';
    foreach($post_params as $key=>$value)
    {
        if ($key!='ac')
        {
            $str.=$value;
        }
    }
    if ($post_params['ac'] == md5($str.$token))
    {
        return true;
    }
    else
    {
        return false;
    }
}

/**
 *  ϵͳ��������
 *
 *  @param   string   $err_type   �������ʹ���
 *  @param   string   $err_info   ����˵��
 *
 */
function api_err($err_type, $err_info = '')
{
    /* ϵͳ�������б� */
    $err_arr = array();
    $err_arr['0x001'] = 'Verify fail';          //�����֤ʧ��
    $err_arr['0x002'] = 'Time out';             //����/ִ�г�ʱ
    $err_arr['0x003'] = 'Data fail';            //�����쳣
    $err_arr['0x004'] = 'Db error';             //���ݿ�ִ��ʧ��
    $err_arr['0x005'] = 'Service error';        //����������
    $err_arr['0x006'] = 'User permissions';     //�û�Ȩ�޲���
    $err_arr['0x007'] = 'Service unavailable';  //���񲻿���
    $err_arr['0x008'] = 'Missing Method';       //����������
    $err_arr['0x009'] = 'Missing signature';    //ǩ����Ч
    $err_arr['0x010'] = 'Missing api version';  //�汾��ʧ
    $err_arr['0x011'] = 'Api verion error';     //API�汾�쳣
    $err_arr['0x012'] = 'Api need update';      //API��Ҫ����
    $err_arr['0x013'] = 'Shop Error';           //���Z�����쳣
    $err_arr['0x014'] = 'Shop Space Error';     //����ռ䲻��

    data_back($err_info == '' ? $err_arr[$err_type] : $err_info, $err_type, RETURN_TYPE, 'fail');  //�ظ������Դ�����Ϣ
}

/**
 *  ���ؽ����
 *
 *  @param   mixed      $info       ���ص���Ч���ݼ����Ǵ���˵��
 *  @param   string     $msg        Ϊ�ջ��Ǵ������ʹ���
 *  @param   string     $result     ����ɹ�����ʧ�ܵı�ʶ
 *  @param   int        $post       1Ϊxml��ʽ��2Ϊjson��ʽ
 *
 */
function data_back($info, $msg = '', $post, $result = 'success')
{
    /* ��Ϊxml��json���ַ�ʽ */
    $data_arr = array('result'=>$result, 'msg'=>$msg, 'info'=>$info);
    $data_arr = to_utf8_iconv($data_arr);  //ȷ�����ݵı���ΪUTF-8

    if ($post == 1)
    {
        /* xml��ʽ */
        if (class_exists('DOMDocument'))
        {
            $doc=new DOMDocument('1.0','UTF-8');
            $doc->formatOutput=true;

            $shopex=$doc->createElement('shopex');
            $doc->appendChild($shopex);

            $result=$doc->createElement('result');
            $shopex->appendChild($result);
            $result->appendChild($doc->createCDATASection($data_arr['result']));

            $msg=$doc->createElement('msg');
            $shopex->appendChild($msg);
            $msg->appendChild($doc->createCDATASection($data_arr['msg']));

            $info=$doc->createElement('info');
            $shopex->appendChild($info);

            create_tree($doc, $info, $data_arr['info']);
            die($doc->saveXML());
        }

        die('<?xml version="1.0" encoding="UTF-8"?>' . array2xml($data_arr)) ;
    }
    else
    {
        /* json��ʽ */
        $json  = new JSON;
        die($json->encode($data_arr));    //�����ɵķ����ַ�����ӡ����
    }
}

/**
 *  ѭ������xml�ڵ�
 *
 *  @param  handle      $doc            xmlʵ�����
 *  @param  handle      $top            ��ǰ���ڵ�
 *  @param  array       $info_arr       ��Ҫ����������
 *  @param  boolean     $have_item      �Ƿ����������飬������Ҫ��ÿ�������ϼ�item���ڵ�
 *
 */
function create_tree($doc, $top, $info_arr, $have_item = false)
{
    if (is_array($info_arr))
    {
        foreach ($info_arr as $key => $val)
        {
            if (is_array($val))
            {
                if ($have_item == false)
                {
                    $data_info=$doc->createElement('data_info');
                    $top->appendChild($data_info);
                    create_tree($doc, $data_info, $val, true);
                }
                else
                {
                    $item=$doc->createElement('item');
                    $top->appendChild($item);
                    $key_code = $doc->createAttribute('key');
                    $item->appendChild($key_code);
                    $key_code->appendChild($doc->createTextNode($key));
                    create_tree($doc, $item, $val);
                }
            }
            else
            {
                $text_code=$doc->createElement($key);
                $top->appendChild($text_code);
                if (is_string($val))
                {
                    $text_code->appendChild($doc->createCDATASection($val));
                }
                else
                {
                    $text_code->appendChild($doc->createTextNode($val));
                }
            }
        }
    }
    else
    {
        $top->appendChild($doc->createCDATASection($info_arr));
    }
}

function array2xml($data,$root='shopex'){
    $xml='<'.$root.'>';
    _array2xml($data,$xml);
    $xml.='</'.$root.'>';
    return $xml;
}

function _array2xml(&$data,&$xml){
    if(is_array($data)){
        foreach($data as $k=>$v){
            if(is_numeric($k)){
                $xml.='<item key="' . $k . '">';
                $xml.=_array2xml($v,$xml);
                $xml.='</item>';
            }else{
                $xml.='<'.$k.'>';
                $xml.=_array2xml($v,$xml);
                $xml.='</'.$k.'>';
            }
        }
    }elseif(is_numeric($data)){
        $xml.=$data;
    }elseif(is_string($data)){
        $xml.='<![CDATA['.$data.']]>';
    }
}

function create_goods_properties($goods_id)
{
    /* �����Խ�����������ͷ���
    $sql = "SELECT attr_group ".
            "FROM " . $GLOBALS['ecs']->table('goods_type') . " AS gt, " . $GLOBALS['ecs']->table('goods') . " AS g ".
            "WHERE g.goods_id='$goods_id' AND gt.cat_id=g.goods_type";
    $grp = $GLOBALS['db']->getOne($sql);

    if (!empty($grp))
    {
        $groups = explode("\n", strtr($grp, "\r", ''));
    }
    */

    /* �����Ʒ�Ĺ�� */
    $sql = "SELECT a.attr_id, a.attr_name, a.attr_group, a.is_linked, a.attr_type, ".
                "g.goods_attr_id, g.attr_value, g.attr_price " .
            'FROM ' . $GLOBALS['ecs']->table('goods_attr') . ' AS g ' .
            'LEFT JOIN ' . $GLOBALS['ecs']->table('attribute') . ' AS a ON a.attr_id = g.attr_id ' .
            "WHERE g.goods_id = '$goods_id' " .
            'ORDER BY a.sort_order, g.attr_price, g.goods_attr_id';
    $res = $GLOBALS['db']->getAll($sql);

    $arr = array();
    $arr['props_name'] = array();     // props_name
    $arr['props'] = array();          // props

    foreach ($res AS $row)
    {
        if ($row['attr_type'] == 0)
        {
            //$group = (isset($groups[$row['attr_group']])) ? $groups[$row['attr_group']] : $GLOBALS['_LANG']['goods_attr'];

            //$arr['props_name'][$row['attr_group']]['name'] = $group;
            $arr['props_name'][] = array('name' => $row['attr_name'], 'value' => $row['attr_value']);

            $arr['props'][] = array('pid' => $row['attr_id'], 'vid' => $row['goods_attr_id']);
        }
    }

    return $arr;
}
?>