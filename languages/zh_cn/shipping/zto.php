<?php

/**
 * ECSHOP ��ͨ�ٵݲ���������ļ�
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

$_LANG['zto']          = '��ͨ�ٵ�';
$_LANG['zto_desc']     = '��ͨ��ݵ����˵�������۷Ѱ����걨��ֵ��2�����ɣ����ǣ����۷Ѳ�����100Ԫ�����۽��ø���10000Ԫ�����۽���10000Ԫ�ģ������Ĳ�����Ч';
$_LANG['item_fee'] = '������Ʒ���ã�';
$_LANG['base_fee'] = '���ط���';
$_LANG['step_fee'] = '����ÿ1000�˻��������ķ���';
$_LANG['shipping_print'] = '<table style="width:18.2cm" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="height:2.2cm;">&nbsp;</td>
  </tr>
</table>
<table style="width:18.2cm" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="height:4.4cm; width:9.1cm;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
    <td style="width:2cm; height:0.8cm;">&nbsp;</td>
    <td style="width:2.7cm;">{$shop_name}</td>
    <td style="width:1.2cm;">&nbsp;</td>
    <td>{$province}</td>
    </tr>
    <tr>
    <td>&nbsp;</td>
    <td colspan="3" style="height:1.6cm;">{$shop_address}</td>
    </tr>
    <tr>
    <td>&nbsp;</td>
    <td colspan="3" style="height:0.8cm;">{$shop_name}</td>
    </tr>
    <tr>
    <td>&nbsp;</td>
    <td style="height:1.2cm;">{$service_phone}</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
    </table>
    </td>
    <td style="height:4.4cm; width:9.1cm;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
    <td style="width:2cm; height:0.8cm;">&nbsp;</td>
    <td style="width:2.7cm;">{$order.consignee}</td>
    <td style="width:1.2cm;">&nbsp;</td>
    <td>{$order.region}</td>
    </tr>
    <tr>
    <td>&nbsp;</td>
    <td colspan="3" style="height:1.6cm;">{$order.address}</td>
    </tr>
    <tr>
    <td>&nbsp;</td>
    <td colspan="3" style="height:0.8cm;"></td>
    </tr>
    <tr>
    <td>&nbsp;</td>
    <td style="height:1.2cm;">{$order.mobile}</td>
    <td>&nbsp;</td>
    <td>{$order.zipcode}</td>
    </tr>
    </table>
    </td>
  </tr>
</table>
<table style="width:18.2cm" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="height:4.2cm;">&nbsp;</td>
  </tr>
</table>';

?>