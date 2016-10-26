<?php

/**
 * ECSHOP �����������
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: post_express.php 17217 2011-01-19 06:29:08Z liubo $
 */

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

$shipping_lang = ROOT_PATH.'languages/' .$GLOBALS['_CFG']['lang']. '/shipping/post_express.php';
if (file_exists($shipping_lang))
{
    global $_LANG;
    include_once($shipping_lang);
}

/* ģ��Ļ�����Ϣ */
if (isset($set_modules) && $set_modules == TRUE)
{
    $i = (isset($modules)) ? count($modules) : 0;

    /* ���ͷ�ʽ����Ĵ��������ļ�������һ�� */
    $modules[$i]['code']    = basename(__FILE__, '.php');

    $modules[$i]['version'] = '1.0.0';

    /* ���ͷ�ʽ������ */
    $modules[$i]['desc']    = 'post_express_desc';

    /* ���۱���,�����֧�ֱ���������false,֧���������calculate_insure()�������̶��۸�ֱ������̶����֣�����Ʒ�ܼ�������ֵ�����%  */
    $modules[$i]['insure']  = '1%';

    /* ���ͷ�ʽ�Ƿ�֧�ֻ������� */
    $modules[$i]['cod']     = false;

    /* ��������� */
    $modules[$i]['author']  = 'ECSHOP TEAM';

    /* ������ߵĹٷ���վ */
    $modules[$i]['website'] = 'http://www.ecshop.com';

    /* ���ͽӿ���Ҫ�Ĳ��� */
    $modules[$i]['configure'] = array(
                                    array('name' => 'item_fee',     'value'=>5),
                                    array('name' => 'base_fee',     'value'=>5),
                                    array('name' => 'step_fee',    'value'=>2),
                                    array('name' => 'step_fee1',    'value'=>1),
                                );

    /* ģʽ�༭�� */
    $modules[$i]['print_model'] = 2;

    /* ��ӡ������ */
    $modules[$i]['print_bg'] = '';

   /* ��ӡ��ݵ���ǩλ����Ϣ */
    $modules[$i]['config_lable'] = '';

    return;
}

/**
 * ������ݰ������ü��㷽ʽ
 * ====================================================================================
 * �˾�                     ����1000��      5000����������ÿ500��   5001����������500��
 * -------------------------------------------------------------------------------------
 * 500���Ｐ500��������     5.00            2.00                    1.00
 * 500����������1000����    6.00            2.50                    1.30
 * 1000����������1500����   7.00            3.00                    1.60
 * 1500����������2000����   8.00            3.50                    1.90
 * 2000����������2500����   9.00            4.00                    2.20
 * 2500����������3000����   10.00           4.50                    2.50
 * 3000����������4000����   12.00           5.50                    3.10
 * 4000����������5000����   14.00           6.50                    3.70
 * 5000����������6000����   16.00           7.50                    4.30
 * 6000��������             20.00           9.00                    6.00
 * -------------------------------------------------------------------------------------
 * ÿ���Һŷ�               3.00
 */
class post_express
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
    function post_express($cfg=array())
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
            $fee    = $this->configure['base_fee'];
            $this->configure['fee_compute_mode'] = !empty($this->configure['fee_compute_mode']) ? $this->configure['fee_compute_mode'] : 'by_weight';

            if ($this->configure['fee_compute_mode'] == 'by_number')
            {
                $fee = $goods_number * $this->configure['item_fee'];
            }
            else
            {
               if ($goods_weight > 5)
                {
                    $fee += 8 * $this->configure['step_fee'];
                    $fee += (ceil(($goods_weight - 5) / 0.5)) * $this->configure['step_fee1'];
                }
                else
                {
                    if ($goods_weight > 1)
                    {
                        $fee += (ceil(($goods_weight - 1) / 0.5)) * $this->configure['step_fee'];
                    }
                }
            }


            return $fee;
        }
    }

    /**
     * ��ѯ����״̬
     * �����ͷ�ʽ��֧�ֲ�ѯ����״̬
     *
     * @access  public
     * @param   string  $invoice_sn     ��������
     * @return  string
     */
    function query($invoice_sn)
    {
        return $invoice_sn;
    }

    /**
     *  �����۱�����%����ʱ�����㱣�۷���
     *
     * @access  public
     * @param   decimal $tatal_price  ��Ҫ���۵���Ʒ�ܼ�
     * @param   decimal $insure_rate  ���ۼ������
     *
     * @return  decimal $price        ���۷���
     */
    function calculate_insure($total_price, $insure_rate)
    {
        $total_price = ceil($total_price);
        $price = $total_price * $insure_rate;
        if ($price < 1)
        {
            $price = 1;
        }
        return ceil($price);
    }
}

?>