<?php

/**
 * ECSHOP ��ͨ�ٵݲ��
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: zto.php 17217 2011-01-19 06:29:08Z liubo $
*/

$shipping_lang = ROOT_PATH.'languages/' .$GLOBALS['_CFG']['lang']. '/shipping/zto.php';
if (file_exists($shipping_lang))
{
    global $_LANG;
    include_once($shipping_lang);
}


/* ģ��Ļ�����Ϣ */
if (isset($set_modules) && $set_modules == TRUE)
{
    include_once(ROOT_PATH . 'languages/' . $GLOBALS['_CFG']['lang'] . '/admin/shipping.php');

    $i = (isset($modules)) ? count($modules) : 0;

    /* ���ͷ�ʽ����Ĵ��������ļ�������һ�� */
    $modules[$i]['code']    = 'zto';

    $modules[$i]['version'] = '1.0.0';

    /* ���ͷ�ʽ������ */
    $modules[$i]['desc']    = 'zto_desc';

    /* �Ƿ�֧�ֱ��� */
    $modules[$i]['insure']  = '2%';

    /* ���ͷ�ʽ�Ƿ�֧�ֻ������� */
    $modules[$i]['cod']     = false;

    /* ��������� */
    $modules[$i]['author']  = '��ɫ��Ȼ';

    /* ������ߵĹٷ���վ */
    $modules[$i]['website'] = 'http://www.ecshop.com';

    /* ���ͽӿ���Ҫ�Ĳ��� */
    $modules[$i]['configure'] = array(
                                    array('name' => 'item_fee',     'value'=>15),    /* ������Ʒ���͵ļ۸� */
                                    array('name' => 'base_fee',    'value'=>10),    /* 1000�����ڵļ۸� */
                                    array('name' => 'step_fee',     'value'=>5),    /* ����ÿ1000�����ӵļ۸� */
                                );

    /* ģʽ�༭�� */
    $modules[$i]['print_model'] = 2;

    /* ��ӡ������ */
    $modules[$i]['print_bg'] = '/images/receipt/dly_zto.jpg';

   /* ��ӡ��ݵ���ǩλ����Ϣ */
    $modules[$i]['config_lable'] = 't_shop_province,' . $_LANG['lable_box']['shop_province'] . ',116,30,296.55,117.2,b_shop_province||,||t_customer_province,' . $_LANG['lable_box']['customer_province'] . ',114,32,649.95,114.3,b_customer_province||,||t_shop_address,' . $_LANG['lable_box']['shop_address'] . ',260,57,151.75,152.05,b_shop_address||,||t_shop_name,' . $_LANG['lable_box']['shop_name'] . ',259,28,152.65,212.4,b_shop_name||,||t_shop_tel,' . $_LANG['lable_box']['shop_tel'] . ',131,37,138.65,246.5,b_shop_tel||,||t_customer_post,' . $_LANG['lable_box']['customer_post'] . ',104,39,659.2,242.2,b_customer_post||,||t_customer_tel,' . $_LANG['lable_box']['customer_tel'] . ',158,22,461.9,241.9,b_customer_tel||,||t_customer_mobel,' . $_LANG['lable_box']['customer_mobel'] . ',159,21,463.25,265.4,b_customer_mobel||,||t_customer_name,' . $_LANG['lable_box']['customer_name'] . ',109,32,498.9,115.8,b_customer_name||,||t_customer_address,' . $_LANG['lable_box']['customer_address'] . ',264,58,499.6,150.1,b_customer_address||,||t_months,' . $_LANG['lable_box']['months'] . ',35,23,135.85,392.8,b_months||,||t_day,' . $_LANG['lable_box']['day'] . ',24,23,180.1,392.8,b_day||,||';

    return;
}

class zto
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
    function zto($cfg = array())
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
            @$fee = $this->configure['base_fee'];
            $this->configure['fee_compute_mode'] = !empty($this->configure['fee_compute_mode']) ? $this->configure['fee_compute_mode'] : 'by_weight';

            if ($this->configure['fee_compute_mode'] == 'by_number')
            {
                $fee = $goods_number * $this->configure['item_fee'];
            }
            else
            {
                if ($goods_weight > 1)
                {
                    $fee += (ceil(($goods_weight - 1))) * $this->configure['step_fee'];
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
        $str = '<form style="margin:0px" methods="post" '.
            'action="http://www.zto.cn/bill.asp" name="queryForm_' .$invoice_sn. '" target="_blank">'.
            '<input type="hidden" name="ID" value="' .str_replace("<br>","\n",$invoice_sn). '" />'.
            '<a href="javascript:document.forms[\'queryForm_' .$invoice_sn. '\'].submit();">' .$invoice_sn. '</a>'.
            '<input type="hidden" name="imageField.x" value="26" />'.
            '<input type="hidden" name="imageField.x" value="43" />'.
            '</form>';

        return $str;
    }

    /**
     * ���㱣�۷���
     * ���۷Ѳ�����100Ԫ�����۽��ø���10000Ԫ�����۽���10000Ԫ�ģ������Ĳ�����Ч
     * @access  public
     * @param   int     $goods_amount       ���۷���
     * @param   int     $insure             ���۱���
     *
     * @return void
     */
    function calculate_insure ($goods_amount, $insure)
    {
        if ($goods_amount > 10000)
        {
            $goods_amount = 10000;
        }

        $fee = $goods_amount * $insure;

        if ($fee < 100)
        {
            $fee = 100;
        }

        return $fee;
    }

}

?>