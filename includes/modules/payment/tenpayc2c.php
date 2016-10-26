<?php

/**
 * ECSHOP �Ƹ�ͨ�н鵣��֧�����
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: tenpayc2c.php 17217 2011-01-19 06:29:08Z liubo $
 */

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

$payment_lang = ROOT_PATH . 'languages/' .$GLOBALS['_CFG']['lang']. '/payment/tenpayc2c.php';

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
    $modules[$i]['desc']    = 'tenpay_desc';

    /* �Ƿ�֧�ֻ������� */
    $modules[$i]['is_cod']  = '0';

    /* �Ƿ�֧������֧�� */
    $modules[$i]['is_online']  = '1';

    /* ���� */
    $modules[$i]['author']  = 'ECSHOP TEAM';

    /* ��ַ */
    $modules[$i]['website'] = 'http://www.tenpay.com';

    /* �汾�� */
    $modules[$i]['version'] = '1.0.0';

    /* ������Ϣ */
    $modules[$i]['config']  = array(
        array('name' => 'tenpay_account',   'type' => 'text', 'value' => ''),
        array('name' => 'tenpay_key',       'type' => 'text', 'value' => ''),
        array('name' => 'tenpay_type',       'type' => 'select', 'value'=>'1'),
    );

    return;
}

/**
 * ��
 */
class tenpayc2c
{
    /**
     * ���캯��
     *
     * @access  public
     * @param
     *
     * @return void
     */
    function tenpayc2c()
    {
    }

    function __construct()
    {
        $this->tenpayc2c();
    }

    /**
     * ����֧������
     * @param   array    $order       ������Ϣ
     * @param   array    $payment     ֧����ʽ��Ϣ
     */
    function get_code($order, $payment)
    {
        /* �汾�� */
        $version = '2';

        /* ������룬��ֵ��12 */
        $cmdno = '12';

        /* �����׼ */
        if (!defined('EC_CHARSET'))
        {
            $encode_type = 2;
        }
        else
        {
            if (EC_CHARSET == 'utf-8')
            {
                $encode_type = 2;
            }
            else
            {
                $encode_type = 1;
            }
        }

        /* ƽ̨�ṩ��,�����̵ĲƸ�ͨ�˺� */
        $chnid = $payment['tenpay_account'];

        /* �տ�Ƹ�ͨ�˺� */
        $seller = $payment['tenpay_account'];

        /* ��Ʒ���� */
        if (!empty($order['order_id']))
        {
            //$mch_name = get_goods_name_by_id($order['order_id']);
            $mch_name = $order['order_sn'];
        }
        else
        {
            $mch_name = $GLOBALS['_LANG']['account_voucher'];
        }

        /* �ܽ�� */
        $mch_price = floatval($order['order_amount']) * 100;

        /* ��������˵�� */
        $transport_desc = '';
        $transport_fee = '';

        /* ����˵�� */
        $mch_desc = $GLOBALS['_LANG']['shop_order_sn'] . $order['order_sn'];
        $need_buyerinfo = '2' ;

        /* �������ͣ�2�����⽻�ף�1��ʵ�ｻ�� */
        $mch_type = $payment['tenpay_type'];

        /* ��ö�������ˮ�ţ����㵽10λ */
        $mch_vno = $order['order_sn'];

        /* ���ص�·�� */
        $mch_returl = return_url('tenpayc2c');
        $show_url   = return_url('tenpayc2c');
        $attach = '';

        /* ����ǩ�� */
        $sign_text = "chnid=" . $chnid . "&cmdno=" . $cmdno . "&encode_type=" . $encode_type . "&mch_desc=" . $mch_desc . "&mch_name=" . $mch_name . "&mch_price=" . $mch_price ."&mch_returl=" . $mch_returl . "&mch_type=" . $mch_type . "&mch_vno=" . $mch_vno . "&need_buyerinfo=" . $need_buyerinfo ."&seller=" . $seller . "&show_url=" . $show_url . "&version=" . $version . "&key=" . $payment['tenpay_key'];

        $sign =md5($sign_text);

        /* ���ײ��� */
        $parameter = array(
            'attach'            => $attach,
            'chnid'             => $chnid,
            'cmdno'             => $cmdno,                     // ҵ�����, �Ƹ�֧ͨ��֧���ӿ���  1
            'encode_type'       => $encode_type,                //�����׼
            'mch_desc'          => $mch_desc,
            'mch_name'          => $mch_name,
            'mch_price'         => $mch_price,                  // �������
            'mch_returl'        => $mch_returl,                 // ���ղƸ�ͨ���ؽ����URL
            'mch_type'          => $mch_type,                   //��������
            'mch_vno'           => $mch_vno,             // ���׺�(������)�����̻���վ����(����˳���ۼ�)
            'need_buyerinfo'    => $need_buyerinfo,             //�Ƿ���Ҫ�ڲƸ�ͨ�������Ϣ
            'seller'            => $seller,  // �̼ҵĲƸ�ͨ�̻���
            'show_url'          => $show_url,
            'transport_desc'    => $transport_desc,
            'transport_fee'     => $transport_fee,
            'version'           => $version,                    //�汾�� 2
            'sign'              => $sign,                       // MD5ǩ��
            'sys_id'            => '542554970'                  //ecshop C�˺� ������ǩ��
        );

        $button  = '<br /><form style="text-align:center;" action="https://www.tenpay.com/cgi-bin/med/show_opentrans.cgi " target="_blank" style="margin:0px;padding:0px" >';

        foreach ($parameter AS $key=>$val)
        {
            $button  .= "<input type='hidden' name='$key' value='$val' />";
        }

        $button  .= '<input type="image" src="'. $GLOBALS['ecs']->url() .'images/tenpayc2c.jpg" value="' .$GLOBALS['_LANG']['pay_button']. '" /></form><br />';

        return $button;
    }

    /**
     * ��Ӧ����
     */
    function respond()
    {
        /*ȡ���ز���*/
        $cmd_no         = $_GET['cmdno'];
        $retcode        = $_GET['retcode'];
        $status         = $_GET['status'];
        $seller         = $_GET['seller'];
        $total_fee      = $_GET['total_fee'];
        $trade_price    = $_GET['trade_price'];
        $transport_fee  = $_GET['transport_fee'];
        $buyer_id       = $_GET['buyer_id'];
        $chnid          = $_GET['chnid'];
        $cft_tid        = $_GET['cft_tid'];
        $mch_vno        = $_GET['mch_vno'];
        $attach         = !empty($_GET['attach']) ? $_GET['attach'] : '';
        $version        = $_GET['version'];
        $sign           = $_GET['sign'];

        $payment    = get_payment('tenpayc2c');
        $log_id     = get_order_id_by_sn($mch_vno);
        //$log_id = str_replace($attach, '', $mch_vno); //ȡ��֧����log_id

        /* ���$retcode����0���ʾ֧��ʧ�� */
        if ($retcode > 0)
        {
            //echo '����ʧ��';
            return false;
        }

        /* ���֧���Ľ���Ƿ���� */
        if (!check_money($log_id, $total_fee / 100))
        {
            //echo '�����';
            return false;
        }

        /* �������ǩ���Ƿ���ȷ */
        $sign_text = "buyer_id=" . $buyer_id . "&cft_tid=" . $cft_tid . "&chnid=" . $chnid . "&cmdno=" . $cmd_no . "&mch_vno=" . $mch_vno . "&retcode=" . $retcode . "&seller=" .$seller . "&status=" . $status . "&total_fee=" . $total_fee . "&trade_price=" . $trade_price . "&transport_fee=" . $transport_fee . "&version=" . $version . "&key=" . $payment['tenpay_key'];
        $sign_md5 = strtoupper(md5($sign_text));
        if ($sign_md5 != $sign)
        {
            //echo 'ǩ������';
            return false;
        }
        elseif ($status = 3)
        {
            /* �ı䶩��״̬Ϊ�Ѹ��� */
            order_paid($log_id, PS_PAYING);
            return true;
        }
        else
        {
            //Ϊֹerror
            return false;
        }
    }
}

?>