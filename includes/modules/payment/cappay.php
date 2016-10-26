<?php

/**
 * ECSHOP ������֧�����
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: cappay.php 17217 2011-01-19 06:29:08Z liubo $
 */

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}
$payment_lang = ROOT_PATH . 'languages/' .$GLOBALS['_CFG']['lang']. '/payment/cappay.php';

if (file_exists($payment_lang))
{
    global $_LANG;

    include_once($payment_lang);
}

/**
 * ģ����Ϣ
 */
if (isset($set_modules) && $set_modules == TRUE)
{
    $i = isset($modules) ? count($modules) : 0;

    /* ���� */
    $modules[$i]['code']    = basename(__FILE__, '.php');

    /* ������Ӧ�������� */
    $modules[$i]['desc']    = 'cappay_desc';

    /* �Ƿ�֧�ֻ������� */
    $modules[$i]['is_cod']  = '0';

    /* �Ƿ�֧������֧�� */
    $modules[$i]['is_online']  = '1';

    /* ���� */
    $modules[$i]['author']  = 'ECSHOP TEAM';

    /* ��ַ */
    $modules[$i]['website'] = 'http://www.beijing.com.cn';

    /* �汾�� */
    $modules[$i]['version'] = 'V4.3';

    /* ������Ϣ */
    $modules[$i]['config'] = array(
        array('name' => 'cappay_account',  'type' => 'text',   'value' => ''),
        array('name' => 'cappay_key',      'type' => 'text',   'value' => ''),
        array('name' => 'cappay_currency', 'type' => 'select', 'value' => 'USD')
    );

    return;
}

class cappay
{
    /**
     * ���캯��
     *
     * @access  public
     * @param
     *
     * @return void
     */
    function cappay()
    {
    }

    function __construct()
    {
        $this->cappay();
    }

    /**
     * ����֧������
     * @param   array   $order      ������Ϣ
     * @param   array   $payment    ֧����ʽ��Ϣ
     */
    function get_code($order, $payment)
    {
        $v_rcvname   = trim($payment['cappay_account']);
        $m_orderid   = $order['log_id'];
        $v_amount    = $order['order_amount'];
        $v_moneytype = trim($payment['cappay_currency']);;
        $v_url       = return_url(basename(__FILE__, '.php'));
        $m_ocomment  = '��ӭʹ��������֧��';
        $v_ymd       = date('Ymd',time());

          /*��֧��ƽ̨*/
        $MD5Key     = $payment['cappay_key'];     //<--֧����Կ--> ע:�˴���Կ�������̼Һ�̨�����Կһ��
        $v_oid      = "$v_ymd-$v_rcvname-$m_orderid";
        $sourcedata = $v_moneytype.$v_ymd.$v_amount.$v_rcvname.$v_oid.$v_rcvname.$v_url;
        $result     = $this->hmac_md5($MD5Key,$sourcedata);
        $def_url  = '<form method=post action="http://pay.beijing.com.cn/prs/user_payment.checkit" target="_blank">';
        $def_url .= "<input type= 'hidden' name = 'v_mid'     value= '".$v_rcvname."'>";     //�̻����
        $def_url .= "<input type= 'hidden' name = 'v_oid'     value= '".$v_oid."'>";         //�������
        $def_url .= "<input type= 'hidden' name = 'v_rcvname' value= '".$v_rcvname."'>";     //�ջ�������
        $def_url .= "<input type= 'hidden' name = 'v_rcvaddr' value= '".$v_rcvname."'>";     //�ջ��˵�ַ
        $def_url .= "<input type= 'hidden' name = 'v_rcvtel'  value= '".$v_rcvname."'>";     //�ջ��˵绰
        $def_url .= "<input type= 'hidden' name = 'v_rcvpost'  value= '".$v_rcvname."'>";    //�ջ����ʱ�
        $def_url .= "<input type= 'hidden' name = 'v_amount'   value= '".$v_amount."'>";     //�����ܽ��
        $def_url .= "<input type= 'hidden' name = 'v_ymd'      value= '".$v_ymd."'>";        //������������
        $def_url .= "<input type= 'hidden' name = 'v_orderstatus' value ='0'>";              //���״̬
        $def_url .= "<input type= 'hidden' name = 'v_ordername'   value ='".$v_rcvname."'>"; //����������
        $def_url .= "<input type= 'hidden' name = 'v_moneytype'   value ='".$v_moneytype."'>"; //����,0Ϊ�����,1Ϊ��Ԫ
        $def_url .= "<input type= 'hidden' name='v_url' value='".$v_url."'>";             //֧��������ɺ󷵻ص���url��֧�������GET��ʽ����
        $def_url .= "<input type='hidden' name='v_md5info' value=$result>";              //��������ָ��
        $def_url .= "<input type='submit' value='" . $GLOBALS['_LANG']['cappay_button'] . "'>";

        $def_url .= '</form>';

          /*��֧����Աͨ��
        $def_url  = "<form method=post action='http://pay.beijing.com.cn/customer/gb/pay_member.jsp' target='_blank'>";
        $def_url .= "<input type='hidden' name='v_mid' value='".$v_rcvname."'>";                   //�̻����
        $def_url .= "<input type='hidden' name='v_oid' value='".$v_oid."'>";                       //�������
        $def_url .= "<input type='hidden' name='v_rcvname' value='".$v_rcvname."'>";               //�ջ�������
        $def_url .= "<input type='hidden' name='v_rcvaddr' value='".$v_rcvname."'>";               //�ջ��˵�ַ
        $def_url .= "<input type='hidden' name='v_rcvtel' value='".$v_rcvname."'>";                //�ջ��˵绰
        $def_url .= "<input type='hidden' name='v_rcvpost' value='".$v_rcvname."'>";               //�ջ����ʱ�
        $def_url .= "<input type='hidden' name='v_amount' value='".$v_amount."'>";                 //�����ܽ��
        $def_url .= "<input type='hidden' name='v_ymd' value='".$v_ymd."'>";                       //������������
        $def_url .= "<input type='hidden' name='v_orderstatus' value='0'>";                        //���״̬
        $def_url .= "<input type='hidden' name='v_ordername' value='".$v_rcvname."'>";             //����������
        $def_url .= "<input type='hidden' name='v_moneytype' value='".$v_moneytype."'>";   //����,0Ϊ�����,1Ϊ��Ԫ
        $def_url .= "<input type='hidden' name='v_url' value='".$v_url."'>";              //֧��������ɺ󷵻ص���url��֧�������GET��ʽ����
        $def_url .= "<input type='hidden' name='v_md5info' value=$result[0]>";           //��������ָ��
        $def_url .= "<input type='submit' value='"  . $GLOBALS['_LANG']['cappay_member_button'] .  "'>";

        $def_url .= '</form>';

          //��֧���ֻ�ͨ��
        $def_url  = "<form method=post action='http://pay.beijing.com.cn/customer/gb/pay_mobile.jsp' target='_blank'>";
        $def_url .= "<input type='hidden' name='v_mid' value='".$v_rcvname."'>";                   //�̻����
        $def_url .= "<input type='hidden' name='v_oid' value='".$v_oid."'>";                       //�������
        $def_url .= "<input type='hidden' name='v_rcvname' value='".$v_rcvname."'>";               //�ջ�������
        $def_url .= "<input type='hidden' name='v_rcvaddr' value='".$v_rcvname."'>";               //�ջ��˵�ַ
        $def_url .= "<input type='hidden' name='v_rcvtel' value='".$v_rcvname."'>";                //�ջ��˵绰
        $def_url .= "<input type='hidden' name='v_rcvpost' value='".$v_rcvname."'>";               //�ջ����ʱ�
        $def_url .= "<input type='hidden' name='v_amount' value='".$v_amount."'>";                 //�����ܽ��
        $def_url .= "<input type='hidden' name='v_ymd' value='".$v_ymd."'>";                       //������������
        $def_url .= "<input type='hidden' name='v_orderstatus' value='0'>";                        //���״̬
        $def_url .= "<input type='hidden' name='v_ordername' value='".$v_rcvname."'>";             //����������
        $def_url .= "<input type='hidden' name='v_moneytype' value='".$v_moneytype."'>";   //����,0Ϊ�����,1Ϊ��Ԫ
        $def_url .= "<input type='hidden' name='v_url' value='".$v_url."'>";              //֧��������ɺ󷵻ص���url��֧�������GET��ʽ����
        $def_url .= "<input type='hidden' name='v_md5info' value=$result[0]>";           //��������ָ��
        $def_url .= "<input type='submit' value='"  . $GLOBALS['_LANG']['cappay_mobile_button'] .  "'>";

        $def_url .= '</form>';

          //��֧��Ӣ��ͨ��
        $def_url  = "<form method=post action='http://pay.beijing.com.cn/prs/e_user_payment.checkit' target='_blank'>";
        $def_url .= "<input type='hidden' name='v_mid' value='".$v_rcvname."'>";                   //�̻����
        $def_url .= "<input type='hidden' name='v_oid' value='".$v_oid."'>";                       //�������
        $def_url .= "<input type='hidden' name='v_rcvname' value='".$v_rcvname."'>";               //�ջ�������
        $def_url .= "<input type='hidden' name='v_rcvaddr' value='".$v_rcvname."'>";               //�ջ��˵�ַ
        $def_url .= "<input type='hidden' name='v_rcvtel' value='".$v_rcvname."'>";                //�ջ��˵绰
        $def_url .= "<input type='hidden' name='v_rcvpost' value='".$v_rcvname."'>";               //�ջ����ʱ�
        $def_url .= "<input type='hidden' name='v_amount' value='".$v_amount."'>";                 //�����ܽ��
        $def_url .= "<input type='hidden' name='v_ymd' value='".$v_ymd."'>";                       //������������
        $def_url .= "<input type='hidden' name='v_orderstatus' value='0'>";                        //���״̬
        $def_url .= "<input type='hidden' name='v_ordername' value='".$v_rcvname."'>";             //����������
        $def_url .= "<input type='hidden' name='v_moneytype' value='".$v_moneytype."'>";   //����,0Ϊ�����,1Ϊ��Ԫ
        $def_url .= "<input type='hidden' name='v_url' value='".$v_url."'>";              //֧��������ɺ󷵻ص���url��֧�������GET��ʽ����
        $def_url .= "<input type='hidden' name='v_md5info' value=$result[0]>";           //��������ָ��
        $def_url .= "<input type='submit' value='"  . $GLOBALS['_LANG']['cappay_en_button'] .  "'>";

        $def_url .= '</form>';*/

        return $def_url;
    }

    /**
     * ��Ӧ����
     */

    function respond()
    {
        $payment    = get_payment(basename(__FILE__, '.php'));
        $v_tempdate = explode('-', $_REQUEST['v_oid']);

        //���ܷ���������֤��ʼ
        //v_md5info��֤
        $md5info_paramet = $_REQUEST['v_oid'].$_REQUEST['v_pstatus'].$_REQUEST['v_pstring'].$_REQUEST['v_pmode'];
        $md5info_tem     = $this->hmac_md5($payment['cappay_key'],$md5info_paramet);

        //v_md5money��֤
        $md5money_paramet = $_REQUEST['v_amount'].$_REQUEST['v_moneytype'];
        $md5money_tem     = $this->hmac_md5($payment['cappay_key'],$md5money_paramet);
        if ($md5info_tem == $_REQUEST['v_md5info'] && $md5money_tem == $_REQUEST['v_md5money'])
        {
            //�ı䶩��״̬
            order_paid($v_tempdate[2]);

            return true;
         }
         else
         {
            return false;
         }

    }
    function hmac_md5($key, $data)
    {
        if (extension_loaded('mhash'))
        {
            return bin2hex(mhash(MHASH_MD5, $data, $key));
        }

        // RFC 2104 HMAC implementation for php. Hacked by Lance Rushing
        $b = 64;
        if (strlen($key) > $b)
        {
            $key = pack('H*', md5($key));
        }
        $key  = str_pad($key, $b, chr(0x00));
        $ipad = str_pad('', $b, chr(0x36));
        $opad = str_pad('', $b, chr(0x5c));

        $k_ipad = $key ^ $ipad;
        $k_opad = $key ^ $opad;

        return md5($k_opad . pack('H*', md5($k_ipad . $data)));
    }

}

?>