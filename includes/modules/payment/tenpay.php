<?php

/**
 * ECSHOP �Ƹ�ͨ���
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: tenpay.php 17217 2011-01-19 06:29:08Z liubo $
 */

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

$payment_lang = ROOT_PATH . 'languages/' .$GLOBALS['_CFG']['lang']. '/payment/tenpay.php';

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
    $modules[$i]['version'] = '2.0.0';

    /* ������Ϣ */
    $modules[$i]['config']  = array(
        array('name' => 'tenpay_account',   'type' => 'text', 'value' => ''),
        array('name' => 'tenpay_key',       'type' => 'text', 'value' => ''),
        array('name' => 'magic_string',     'type' => 'text', 'value' => '')
    );

    return;
}

/**
 * ��
 */
class tenpay
{
    /**
     * ���캯��
     *
     * @access  public
     * @param
     *
     * @return void
     */
    function tenpay()
    {
    }

    function __construct()
    {
        $this->tenpay();
    }

    /**
     * ����֧������
     * @param   array    $order       ������Ϣ
     * @param   array    $payment     ֧����ʽ��Ϣ
     */
    function get_code($order, $payment)
    {
        $cmd_no = '1';

        /* ��ö�������ˮ�ţ����㵽10λ */
        $sp_billno = $order['order_sn'];

        /* �������� */
        $today = date('Ymd');

        /* ���̻���+������+��ˮ�� */
        $bill_no = str_pad($order['log_id'], 10, 0, STR_PAD_LEFT);
        $transaction_id = $payment['tenpay_account'].$today.$bill_no;

        /* ��������:֧�ִ����غͲƸ�ͨ */
        $bank_type = '0';

        /* �����������ö�������� */
        if (!empty($order['order_id']))
        {
            //$desc = get_goods_name_by_id($order['order_id']);
            $desc = $order['order_sn'];
            $attach = '';
        }
        else
        {
            $desc = $GLOBALS['_LANG']['account_voucher'];
            $attach = 'voucher';
        }
        /* �����׼ */
        if (!defined('EC_CHARSET') || EC_CHARSET == 'utf-8')
        {
            $desc = ecs_iconv('utf-8', 'gbk', $desc);
        }

        /* ���ص�·�� */
        $return_url = return_url('tenpay');

        /* �ܽ�� */
        $total_fee = floatval($order['order_amount']) * 100;

        /* �������� */
        $fee_type = '1';

        /* �Ƹ�ͨ���շ������� */
        $spbill_create_ip = $_SERVER['REMOTE_ADDR'];

        /* ����ǩ�� */
        $sign_text = "cmdno=" . $cmd_no . "&date=" . $today . "&bargainor_id=" . $payment['tenpay_account'] .
          "&transaction_id=" . $transaction_id . "&sp_billno=" . $sp_billno .
          "&total_fee=" . $total_fee . "&fee_type=" . $fee_type . "&return_url=" . $return_url .
          "&attach=" . $attach . "&spbill_create_ip=" . $spbill_create_ip . "&key=" . $payment['tenpay_key'];
        $sign = strtoupper(md5($sign_text));

        /* ���ײ��� */
        $parameter = array(
            'cmdno'             => $cmd_no,                     // ҵ�����, �Ƹ�֧ͨ��֧���ӿ���  1
            'date'              => $today,                      // �̻����ڣ���20051212
            'bank_type'         => $bank_type,                  // ��������:֧�ִ����غͲƸ�ͨ
            'desc'              => $desc,                       // ���׵���Ʒ����
            'purchaser_id'      => '',                          // �û�(��)�ĲƸ�ͨ�ʻ�,����Ϊ��
            'bargainor_id'      => $payment['tenpay_account'],  // �̼ҵĲƸ�ͨ�̻���
            'transaction_id'    => $transaction_id,             // ���׺�(������)�����̻���վ����(����˳���ۼ�)
            'sp_billno'         => $sp_billno,                  // �̻�ϵͳ�ڲ��Ķ�����,���10λ
            'total_fee'         => $total_fee,                  // �������
            'fee_type'          => $fee_type,                   // �ֽ�֧������
            'return_url'        => $return_url,                 // ���ղƸ�ͨ���ؽ����URL
            'attach'            => $attach,                     // �û��Զ���ǩ��
            'sign'              => $sign,                       // MD5ǩ��
            'spbill_create_ip'  => $spbill_create_ip,           //�Ƹ�ͨ���շ�������
            'sys_id'            => '542554970',                 //ecshop C�˺� ������ǩ��
            'sp_suggestuser'    => '1202822001'                 //�Ƹ�ͨ������̻���

        );

        $button  = '<br /><form style="text-align:center;" action="https://www.tenpay.com/cgi-bin/v1.0/pay_gate.cgi" target="_blank" style="margin:0px;padding:0px" >';

        foreach ($parameter AS $key=>$val)
        {
            $button  .= "<input type='hidden' name='$key' value='$val' />";
        }

        $button  .= '<input type="image" src="'. $GLOBALS['ecs']->url() .'images/tenpay.gif" value="' .$GLOBALS['_LANG']['pay_button']. '" /></form><br />';

        return $button;
    }

    /**
     * ��Ӧ����
     */
    function respond()
    {
        /*ȡ���ز���*/
        $cmd_no         = $_GET['cmdno'];
        $pay_result     = $_GET['pay_result'];
        $pay_info       = $_GET['pay_info'];
        $bill_date      = $_GET['date'];
        $bargainor_id   = $_GET['bargainor_id'];
        $transaction_id = $_GET['transaction_id'];
        $sp_billno      = $_GET['sp_billno'];
        $total_fee      = $_GET['total_fee'];
        $fee_type       = $_GET['fee_type'];
        $attach         = $_GET['attach'];
        $sign           = $_GET['sign'];

        $payment    = get_payment('tenpay');
        //$order_sn   = $bill_date . str_pad(intval($sp_billno), 5, '0', STR_PAD_LEFT);
        //$log_id = preg_replace('/0*([0-9]*)/', '\1', $sp_billno); //ȡ��֧����log_id
        if ($attach == 'voucher')
        {
            $log_id = get_order_id_by_sn($sp_billno, "true");
        }
        else
        {
            $log_id = get_order_id_by_sn($sp_billno);
        }

        /* ���pay_result����0���ʾ֧��ʧ�� */
        if ($pay_result > 0)
        {
            return false;
        }

        /* ���֧���Ľ���Ƿ���� */
        if (!check_money($log_id, $total_fee / 100))
        {
            return false;
        }

        /* �������ǩ���Ƿ���ȷ */
        $sign_text  = "cmdno=" . $cmd_no . "&pay_result=" . $pay_result .
                          "&date=" . $bill_date . "&transaction_id=" . $transaction_id .
                            "&sp_billno=" . $sp_billno . "&total_fee=" . $total_fee .
                            "&fee_type=" . $fee_type . "&attach=" . $attach .
                            "&key=" . $payment['tenpay_key'];
        $sign_md5 = strtoupper(md5($sign_text));
        if ($sign_md5 != $sign)
        {
            return false;
        }
        else
        {
            /* �ı䶩��״̬ */
            order_paid($log_id);
            return true;
        }
    }
}

?>