<?php

/**
 * ECSHOP ��Ǯ������֧�����
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: shenzhou.php 17217 2011-01-19 06:29:08Z liubo $
 */

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

$payment_lang = ROOT_PATH . 'languages/' . $GLOBALS['_CFG']['lang'] . '/payment/shenzhou.php';

if (file_exists($payment_lang))
{
   global $_LANG;

   include_once($payment_lang);
}

/* ģ��Ļ�����Ϣ */
if (isset($set_modules) && $set_modules == true)
{
    $i = isset($modules) ? count($modules) : 0;

    /* ���� */
    $modules[$i]['code'] = basename(__FILE__, '.php');

    /* ������Ӧ�������� */
    $modules[$i]['desc'] = 'shenzhou_desc';

    /* �Ƿ�֧�ֻ������� */
    $modules[$i]['is_cod'] = '0';

    /* �Ƿ�֧������֧�� */
    $modules[$i]['is_online'] = '1';

    /* ���� */
    $modules[$i]['author']  = 'ECSHOP TEAM';

    /* ��ַ */
    $modules[$i]['website'] = 'http://www.99bill.com';

    /* �汾�� */
    $modules[$i]['version'] = '1.0.1';

    /* ������Ϣ */
    $modules[$i]['config'] = array(
        array('name' => 'shenzhou_account', 'type' => 'text', 'value' => ''),
        array('name' => 'shenzhou_key',     'type' => 'text', 'value' => ''),
    );

    return;

}

class shenzhou
{
    /**
     * ���캯��
     *
     * @access  public
     * @param
     *
     * @return void
     */

    function shenzhou()
    {
    }

    function __construct()
    {
        $this->shenzhou();
    }

   /**
     * ����֧������
     * @param   array   $order  ������Ϣ
     * @param   array   $payment    ֧����ʽ��Ϣ
     */
    function get_code($order, $payment)
    {
        $merchant_acctid    = trim($payment['shenzhou_account']);                 //��Ǯ�������˺� ���ɿ�
        $key                = trim($payment['shenzhou_key']);                     //��Կ ���ɿ�
        $input_charset      = 1;                                               //�ַ��� Ĭ��1=utf-8
        $bg_url             = '';
        $page_url           = $GLOBALS['ecs']->url() . 'respond.php';
        $version            = 'v2.0';
        $language           = 1;
        $sign_type          = 1;                                               //ǩ������ ���ɿ� �̶�ֵ 1:md5
        $payer_name         = '';
        $payer_contact_type = '';
        $payer_contact      = '';
        $order_id           = $order['order_sn'];                                //�̻������� ���ɿ�
        $order_amount       = $order['order_amount'] * 100;                    //�̻�������� ���ɿ�
        $pay_type           = '00';                                            //֧����ʽ ���ɿ�
        $card_number        = '';
        $card_pwd           = '';
        $full_amount_flag   = '0';
        $order_time         = local_date('YmdHis', $order['add_time']);        //�̻������ύʱ�� ���ɿ� 14λ
        $product_name       = '';
        $product_num        = '';
        $product_id         = '';
        $product_desc       = '';
        $ext1               = $order['log_id'];
        $ext2               = 'ecshop';

        /* ���ɼ���ǩ���� ����ذ�������˳��͹�����ɼ��ܴ���*/
        $signmsgval = '';
        $signmsgval = $this->append_param($signmsgval, "inputCharset", $input_charset);
        $signmsgval = $this->append_param($signmsgval, "bgUrl", $bg_url);
        $signmsgval = $this->append_param($signmsgval, "pageUrl", $page_url);
        $signmsgval = $this->append_param($signmsgval, "version", $version);
        $signmsgval = $this->append_param($signmsgval, "language", $language);
        $signmsgval = $this->append_param($signmsgval, "signType", $sign_type);
        $signmsgval = $this->append_param($signmsgval, "merchantAcctId", $merchant_acctid);
        $signmsgval = $this->append_param($signmsgval, "payerName", urlencode($payer_name));
        $signmsgval = $this->append_param($signmsgval, "payerContactType", $payer_contact_type);
        $signmsgval = $this->append_param($signmsgval, "payerContact", $payer_contact);
        $signmsgval = $this->append_param($signmsgval, "orderId", $order_id);
        $signmsgval = $this->append_param($signmsgval, "orderAmount", $order_amount);
        $signmsgval = $this->append_param($signmsgval, "payType", $pay_type);
        $signmsgval = $this->append_param($signmsgval, "cardNumber", $card_number);
        $signmsgval = $this->append_param($signmsgval, "cardPwd", $card_pwd);
        $signmsgval = $this->append_param($signmsgval, "fullAmountFlag", $full_amount_flag);
        $signmsgval = $this->append_param($signmsgval, "orderTime", $order_time);
        $signmsgval = $this->append_param($signmsgval, "productName", urlencode($product_name));
        $signmsgval = $this->append_param($signmsgval, "productNum", $product_num);
        $signmsgval = $this->append_param($signmsgval, "productId", $product_id);
        $signmsgval = $this->append_param($signmsgval, "productDesc", urlencode($product_desc));
        $signmsgval = $this->append_param($signmsgval, "ext1", urlencode($ext1));
        $signmsgval = $this->append_param($signmsgval, "ext2", urlencode($ext2));
        $signmsgval = $this->append_param($signmsgval, "key", $key);
        $sign_msg    = strtoupper(md5($signmsgval));    //��ȫУ���� ���ɿ�

        $def_url  = '<div style="text-align:center"><form name="kqPay" style="text-align:center;" method="post"'.
        'action="https://www.99bill.com/szxgateway/recvMerchantInfoAction.htm" target="_blank">';
        $def_url .= "<input type= 'hidden' name='inputCharset' value='" . $input_charset . "' />";
        $def_url .= "<input type='hidden' name='bgUrl' value='" . $bg_url . "' />";
        $def_url .= "<input type='hidden' name='pageUrl' value='" . $page_url . "' />";
        $def_url .= "<input type='hidden' name='version' value='" . $version . "' />";
        $def_url .= "<input type='hidden' name='language' value='" . $language . "' />";
        $def_url .= "<input type='hidden' name='signType' value='" . $sign_type . "' />";
        $def_url .= "<input type='hidden' name='merchantAcctId' value='" . $merchant_acctid . "' />";
        $def_url .= "<input type='hidden' name='payerName' value='" . $payer_name . "' />";
        $def_url .= "<input type='hidden' name='payerContactType' value='" . $payer_contact_type . "' />";
        $def_url .= "<input type='hidden' name='payerContact' value='" . $payer_contact . "' />";
        $def_url .= "<input type='hidden' name='orderId' value='" . $order_id . "' />";
        $def_url .= "<input type='hidden' name='orderAmount' value='" . $order_amount . "' />";
        $def_url .= "<input type='hidden' name='payType' value='" . $pay_type . "' />";
        $def_url .= "<input type='hidden' name='cardNumber' value='" . $card_number . "' />";
        $def_url .= "<input type='hidden' name='cardPwd' value='" . $card_pwd . "' />";
        $def_url .= "<input type='hidden' name='fullAmountFlag' value='" .$full_amount_flag ."' />";
        $def_url .= "<input type='hidden' name='orderTime' value='" . $order_time . "' />";
        $def_url .= "<input type='hidden' name='productName' value='" . urlencode($product_name) . "' />";
        $def_url .= "<input type='hidden' name='productNum' value='" . $product_num . "' />";
        $def_url .= "<input type='hidden' name='productId' value='" . $product_id . "' />";
        $def_url .= "<input type='hidden' name='productDesc' value='" . urlencode($product_desc) . "' />";
        $def_url .= "<input type='hidden' name='ext1' value='" . urlencode($ext1) . "' />";
        $def_url .= "<input type='hidden' name='ext2' value='" . urlencode($ext2) . "' />";
        $def_url .= "<input type='hidden' name='signMsg' value='" . $sign_msg ."' />";
        $def_url .= "<input type='submit' name='submit' value='".$GLOBALS['_LANG']['pay_button']."' />";
        $def_url .= "</form></div><br />";

        return $def_url;
    }

    /**
     * ��Ӧ����
     */
    function respond()
    {
        $payment             = get_payment(basename(__FILE__, '.php'));
        $merchant_acctid     = $payment['shenzhou_account'];                 //�տ��ʺ� ���ɿ�
        $key                 = $payment['shenzhou_key'];
        $get_merchant_acctid = trim($_REQUEST['merchantAcctId']);     //���յ��տ��ʺ�
        $pay_result          = trim($_REQUEST['payResult']);
        $version             = trim($_REQUEST['version']);
        $language            = trim($_REQUEST['language']);
        $sign_type           = trim($_REQUEST['signType']);
        $pay_type            = trim($_REQUEST['payType']);            //20���������п���ֱ��֧����22�����Ǯ�˻����������֧��
        $card_umber          = trim($_REQUEST['cardNumber']);
        $card_pwd            = trim($_REQUEST['cardPwd']);
        $order_id            = trim($_REQUEST['orderId']);            //������
        $order_time          = trim($_REQUEST['orderTime']);
        $order_amount        = trim($_REQUEST['orderAmount']);
        $deal_id             = trim($_REQUEST['dealId']);             //��ȡ�ý����ڿ�Ǯ�Ľ��׺�
        $ext1                = trim($_REQUEST['ext1']);
        $ext2                = trim($_REQUEST['ext2']);
        $pay_amount          = trim($_REQUEST['payAmount']);          //��ȡʵ��֧�����
        $bill_order_time     = trim($_REQUEST['billOrderTime']);
        $pay_result          = trim($_REQUEST['payResult']);         //10����֧���ɹ��� 11����֧��ʧ��
        $sign_type           = trim($_REQUEST['signType']);
        $sign_msg            = trim($_REQUEST['signMsg']);

        //���ɼ��ܴ������뱣������˳��
        $merchant_signmsgval = $this->append_param($merchant_signmsgval, "merchantAcctId", $merchant_acctid);
        $merchant_signmsgval = $this->append_param($merchant_signmsgval, "version", $version);
        $merchant_signmsgval = $this->append_param($merchant_signmsgval, "language", $language);
        $merchant_signmsgval = $this->append_param($merchant_signmsgval, "payType", $pay_type);
        $merchant_signmsgval = $this->append_param($merchant_signmsgval, "cardNumber", $card_number);
        $merchant_signmsgval = $this->append_param($merchant_signmsgval, "cardPwd", $card_pwd);
        $merchant_signmsgval = $this->append_param($merchant_signmsgval, "orderId", $order_id);
        $merchant_signmsgval = $this->append_param($merchant_signmsgval, "orderAmount", $order_amount);
        $merchant_signmsgval = $this->append_param($merchant_signmsgval, "dealId", $deal_id);
        $merchant_signmsgval = $this->append_param($merchant_signmsgval, "orderTime", $order_time);
        $merchant_signmsgval = $this->append_param($merchant_signmsgval, "ext1", $ext1);
        $merchant_signmsgval = $this->append_param($merchant_signmsgval, "ext2", $ext2);
        $merchant_signmsgval = $this->append_param($merchant_signmsgval, "payAmount", $pay_amount);
        $merchant_signmsgval = $this->append_param($merchant_signmsgval, "billOrderTime", $bill_order_time);
        $merchant_signmsgval = $this->append_param($merchant_signmsgval, "payResult", $pay_result);
        $merchant_signmsgval = $this->append_param($merchant_signmsgval, "signType", $sign_type);
        $merchant_signmsgval = $this->append_param($merchant_signmsgval, "key", $key);
        $merchant_signmsg    = md5($merchant_signmsgval);

        //���ȶԻ�õ��̻��Ž��бȶ�
        if ($get_merchant_acctid != $merchant_acctid)
        {
            //'�̻��Ŵ���';
            return false;
        }

        if (strtoupper($sign_msg) == strtoupper($merchant_signmsg))
        {
            if ($pay_result == 10)  //�гɹ�֧���Ľ������10
            {
                order_paid($ext1);

                return true;
            }
            elseif ($pay_result == 11  && $pay_amount > 0)
            {
                $sql = "SELECT order_amount FROM " . $GLOBALS['ecs']->table('order_info') ."WHERE order_id = '$order_id'";
                $get_order_amount = $GLOBALS['db']->getOne($sql);
                if ($get_order_amount == $pay_amount && $get_order_amount == $order_amount) //��鶩����ʵ��֧�����Ͷ����Ƿ����
                {
                    order_paid($ext1);

                    return true;
                }
                elseif ($get_order_amount == $order_amount && $pay_amount > 0) //���������� ʵ��֧����� > 0�����
                {
                    $surplus_amount = $get_order_amount - $pay_amount;        //���㶩��ʣ����
                    $sql = 'UPDATE' . $GLOBALS['ecs']->table('order_info') . "SET `money_paid` = (money_paid  + '$pay_amount')," .
                        " order_amount = (order_amount - '$pay_amount') WHERE order_id = '$order_id'";
                    $result = $GLOBALS['db']->query($sql);
                    $sql = 'UPDATE' . $GLOBALS['ecs']->table('order_info') . "SET `order_status` ='" . OS_CONFIRMED . "' WHERE order_id = '$orderId'";
                    $result = $GLOBALS['db']->query($sql);
                    //order_paid($orderId, PS_UNPAYED);
                    //'�������С��0';
                    return false;
                }
                else
                {
                    //'���������';
                    return false;
                }
            }
            else
            {
                //'ʵ��֧������С��0';
                return false;
            }
        }
        else
        {
            //'ǩ��У�Դ���';
            return false;
        }
    }

    /**
     * ������ֵ��Ϊ�յĲ�������ַ���
     * @param   string   $strs  �����ַ���
     * @param   string   $key   ��������
     * @param   string   $val   ��������Ӧֵ
    */
    function append_param($strs,$key,$val)
    {
        if($strs != "")
        {
            if($val != "")
            {
                $strs .= '&' . $key . '=' . $val;
            }
        }
        else
        {
            if($val != "")
            {
                $strs = $key . '=' . $val;
            }
        }

        return $strs;
    }
}

?>