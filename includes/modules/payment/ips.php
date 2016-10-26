<?php

/**
 * ECSHOP ips֧��ϵͳ���
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * @author:     xuan yan <xuanyan1983@gmail.com>
 * @version:    v1.0
 * ---------------------------------------------
 */

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

$payment_lang = ROOT_PATH . 'languages/' .$GLOBALS['_CFG']['lang']. '/payment/ips.php';
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
    $modules[$i]['desc']    = 'ips_desc';

    /* �Ƿ�֧�ֻ������� */
    $modules[$i]['is_cod']  = '0';

    /* �Ƿ�֧������֧�� */
    $modules[$i]['is_online']  = '1';

    /* ���� */
    $modules[$i]['author']  = 'ECSHOP TEAM';

    /* ��ַ */
    $modules[$i]['website'] = 'http://www.ips.com.cn';

    /* �汾�� */
    $modules[$i]['version'] = '1.0.0';

    /* ������Ϣ */
    $modules[$i]['config']  = array(
        array('name' => 'ips_account',  'type' => 'text',   'value' => ''),
        array('name' => 'ips_key',      'type' => 'text',   'value' => ''),
        array('name' => 'ips_currency', 'type' => 'select', 'value' => '01'),
        array('name' => 'ips_lang',     'type' => 'select', 'value' => 'GB')
    );

    return;
}

class ips
{
   /**
    * ���캯��
    *
    * @access  public
    * @param
    *
    * @return void
    */
    function ips()
    {

    }

    function __construct()
    {
        $this->ips();
    }

    /**
    * ����֧������
    * @param   array   $order  ������Ϣ
    * @param   array   $payment    ֧����ʽ��Ϣ
    */

    function get_code($order, $payment)
    {
        $billstr    = date('His', time());
        $datestr    = date('Ymd', time());
        $mer_code   = $payment['ips_account'];
        $billno     = str_pad($order['log_id'], 10, '0', STR_PAD_LEFT) . $billstr;
        $amount     = sprintf("%0.02f", $order['order_amount']);
        $strcert    = $payment['ips_key'];
        $strcontent = $billno . $amount . $datestr . 'RMB' . $strcert; // ǩ����֤�� //
        $signmd5    = MD5($strcontent);

        $def_url  = '<br /><form style="text-align:center;" action="https://pay.ips.com.cn/ipayment.aspx" method="post" target="_blank">';
        $def_url .= "<input type='hidden' name='Mer_code' value='" . $mer_code . "'>\n";
        $def_url .= "<input type='hidden' name='Billno' value='" . $billno . "'>\n";
        $def_url .= "<input type='hidden' name='Gateway_type' value='" . $payment['ips_currency'] . "'>\n";
        $def_url .= "<input type='hidden' name='Currency_Type'  value='RMB'>\n";
        $def_url .= "<input type='hidden' name='Lang'  value='" . $payment['ips_lang'] . "'>\n";
        $def_url .= "<input type='hidden' name='Amount'  value='" . $amount . "'>\n";
        $def_url .= "<input type='hidden' name='Date' value='" . $datestr . "'>\n";
        $def_url .= "<input type='hidden' name='DispAmount' value='" . $amount . "'>\n";
        $def_url .= "<input type='hidden' name='OrderEncodeType' value='2'>\n";
        $def_url .= "<input type='hidden' name='RetEncodeType' value='12'>\n";
        $def_url .= "<input type='hidden' name='Merchanturl' value='" . return_url(basename(__FILE__, '.php')) . "'>\n";
        $def_url .= "<input type='hidden' name='SignMD5' value='" . $signmd5 . "'>\n";
        $def_url .= "<input type='submit' value='" . $GLOBALS['_LANG']['pay_button'] . "'>";
        $def_url .= "</form><br />";

        return $def_url;
    }

    function respond()
    {
        $payment       = get_payment($_GET['code']);
        $billno        = $_GET['billno'];
        $amount        = $_GET['amount'];
        $mydate        = $_GET['date'];
        $succ          = $_GET['succ'];
        $msg           = $_GET['msg'];
        $ipsbillno     = $_GET['ipsbillno'];
        $retEncodeType = $_GET['retencodetype'];
        $currency_type = $_GET['Currency_type'];
        $signature     = $_GET['signature'];
        $order_sn      = intval(substr($billno, 0, 10));

        if ($succ == 'Y')
        {
            $content = $billno . $amount . $mydate . $succ . $ipsbillno . $currency_type;
            $cert = $payment['ips_key'];
            $signature_1ocal = md5($content . $cert);

            if ($signature_1ocal == $signature)
            {
                if (!check_money($order_sn, $amount))
                {
                   return false;
                }
                order_paid($order_sn);

                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }
}

?>