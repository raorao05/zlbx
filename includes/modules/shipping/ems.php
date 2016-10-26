<?php

/**
 * ECSHOP EMS���
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: ems.php 17217 2011-01-19 06:29:08Z liubo $
 */

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

$shipping_lang = ROOT_PATH.'languages/' .$GLOBALS['_CFG']['lang']. '/shipping/ems.php';
if (file_exists($shipping_lang))
{
    global $_LANG;
    include_once($shipping_lang);
}

include_once(ROOT_PATH . 'languages/' . $GLOBALS['_CFG']['lang'] . '/admin/shipping.php');

/* ģ��Ļ�����Ϣ */
if (isset($set_modules) && $set_modules == TRUE)
{
    $i = (isset($modules)) ? count($modules) : 0;

    /* ���ͷ�ʽ����Ĵ��������ļ�������һ�� */
    $modules[$i]['code']    = basename(__FILE__, '.php');

    $modules[$i]['version'] = '1.0.0';

    /* ���ͷ�ʽ������ */
    $modules[$i]['desc']    = 'ems_express_desc';

    /* ���ͷ�ʽ�Ƿ�֧�ֻ������� */
    $modules[$i]['cod']     = false;

    /* ��������� */
    $modules[$i]['author']  = 'ECSHOP TEAM';

    /* ������ߵĹٷ���վ */
    $modules[$i]['website'] = 'http://www.ecshop.com';

    /* ���ͽӿ���Ҫ�Ĳ��� */
    $modules[$i]['configure'] = array(
                                    array('name' => 'item_fee',     'value'=>20),
                                    array('name' => 'base_fee',     'value'=>20),
                                    array('name' => 'step_fee',     'value'=>15),
                                );

    /* ģʽ�༭�� */
    $modules[$i]['print_model'] = 2;

    /* ��ӡ������ */
    $modules[$i]['print_bg'] = '/images/receipt/dly_ems.jpg';

   /* ��ӡ��ݵ���ǩλ����Ϣ */
    $modules[$i]['config_lable'] = 't_shop_name,' . $_LANG['lable_box']['shop_name'] . ',236,32,182,161,b_shop_name||,||t_shop_tel,' . $_LANG['lable_box']['shop_tel'] . ',127,21,295,135,b_shop_tel||,||t_shop_address,' . $_LANG['lable_box']['shop_address'] . ',296,68,124,190,b_shop_address||,||t_pigeon,' . $_LANG['lable_box']['pigeon'] . ',21,21,192,278,b_pigeon||,||t_customer_name,' . $_LANG['lable_box']['customer_name'] . ',107,23,494,136,b_customer_name||,||t_customer_tel,' . $_LANG['lable_box']['customer_tel'] . ',155,21,639,124,b_customer_tel||,||t_customer_mobel,' . $_LANG['lable_box']['customer_mobel'] . ',159,21,639,147,b_customer_mobel||,||t_customer_post,' . $_LANG['lable_box']['customer_post'] . ',88,21,680,258,b_customer_post||,||t_year,' . $_LANG['lable_box']['year'] . ',37,21,534,379,b_year||,||t_months,' . $_LANG['lable_box']['months'] . ',29,21,592,379,b_months||,||t_day,' . $_LANG['lable_box']['day'] . ',27,21,642,380,b_day||,||t_order_best_time,' . $_LANG['lable_box']['order_best_time'] . ',104,39,688,359,b_order_best_time||,||t_order_postscript,' . $_LANG['lable_box']['order_postscript'] . ',305,34,485,402,b_order_postscript||,||t_customer_address,' . $_LANG['lable_box']['customer_address'] . ',289,48,503,190,b_customer_address||,||';

    return;
}

/**
 * ������ݰ������ü��㷽ʽ
 * ====================================================================================
 * 500g��500g����                             20Ԫ
 * -------------------------------------------------------------------------------------
 * ����ÿ500�˻�������                        6Ԫ/9Ԫ/15Ԫ(��������ͬ�շѲ�ͬ�����������ʽ����ļ��˲���绰�򵽵����ʾ�Ӫҵ������ѯ���ͷ��绰11185��)
 * -------------------------------------------------------------------------------------
 *
 */
class ems
{
    /*------------------------------------------------------ */
    //-- PUBLIC ATTRIBUTEs
    /*------------------------------------------------------ */

    /**
     * ������Ϣ
     */
    var $configure;

    /*------------------------------------------------------ */
    //-- PUBLIC METHODs
    /*------------------------------------------------------ */

    /**
     * ���캯��
     *
     * @param: $configure[array]    ���ͷ�ʽ�Ĳ���������
     *
     * @return null
     */
    function ems($cfg=array())
    {
        foreach ($cfg AS $key=>$val)
        {
            $this->configure[$val['name']] = $val['value'];
        }
    }

    /**
     * ���㶩�������ͷ��õĺ���
     *
     * @param   float   $goods_weight   ��Ʒ����
     * @param   float   $goods_amount   ��Ʒ���
     * @param   float   $goods_number   ��Ʒ����
     * @return  decimal
     */
    function calculate($goods_weight, $goods_amount, $goods_number)
    {
        if ($this->configure['free_money'] > 0 && $goods_amount >= $this->configure['free_money'])
        {
            return 0;
        }
        else
        {
            $fee = $this->configure['base_fee'];
            $this->configure['fee_compute_mode'] = !empty($this->configure['fee_compute_mode']) ? $this->configure['fee_compute_mode'] : 'by_weight';

            if ($this->configure['fee_compute_mode'] == 'by_number')
            {
                $fee = $goods_number * $this->configure['item_fee'];
            }
            else
            {
                if ($goods_weight > 0.5)
                {
                    $fee += (ceil(($goods_weight - 0.5) / 0.5)) * $this->configure['step_fee'];
                }
            }
            return $fee;
        }
    }

    /**
     * ��ѯ����״̬
     *
     * @access  public
     * @param   string  $invoice_sn     ��������
     * @return  string
     */
    function query($invoice_sn)
    {
        $str = '<form style="margin:0px" method="post" '.
            'action="http://www.ems.com.cn/qcgzOutQueryAction.do" name="queryForm_' .$invoice_sn. '" target="_blank">'.
            '<input type="hidden" name="mailNum" value="' .$invoice_sn. '" />'.
            '<a href="javascript:document.forms[\'queryForm_' .$invoice_sn. '\'].submit();">' .$invoice_sn. '</a>'.
            '<input type="hidden" name="reqCode" value="browseBASE" />'.
            '<input type="hidden" name="checknum" value="0568792906411" />'.
            '</form>';

        return $str;
    }
}

?>