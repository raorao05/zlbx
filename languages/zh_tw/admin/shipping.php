<?php

/**
 * ECSHOP �����������ͷ�ʽ�����Z���ļ�
 * ============================================================================
 * ������� 2005-2011 �Ϻ����ɾW�j�Ƽ����޹�˾���K�������Й�����
 * �Wվ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �@����һ������ܛ������ֻ���ڲ�����̘IĿ�ĵ�ǰ����������a�M���޸ĺ�
 * ʹ�ã������S��������a���κ���ʽ�κ�Ŀ�ĵ��ٰl�ѡ�
 * ============================================================================
 * $Author: liubo $
 * $Id: shipping.php 17217 2011-01-19 06:29:08Z liubo $
*/

$_LANG['shipping_name'] = '���ͷ�ʽ���Q';
$_LANG['shipping_version'] = '����汾';
$_LANG['shipping_desc'] = '���ͷ�ʽ����';
$_LANG['shipping_author'] = '�������';
$_LANG['insure'] = '���r�M��';
$_LANG['support_cod'] = '؛�����';
$_LANG['shipping_area'] = '�O�Å^��';
$_LANG['shipping_print_edit'] = '��݋��ӡģ��';
$_LANG['shipping_print_template'] = '���f��ģ��';
$_LANG['shipping_template_info'] = 'ӆ��ģ��׃���f��:<br/>{$shop_name}��ʾ�W�����Q<br/>{$province}��ʾ�W������ʡ��<br/>{$city}��ʾ�W�����ٳ���<br/>{$shop_address}��ʾ�W���ַ<br/>{$service_phone}��ʾ�W���M�Ԓ<br/>{$order.order_amount}��ʾӆ�ν��~<br/>{$order.region}��ʾ�ռ��˵؅^<br/>{$order.tel}��ʾ�ռ����Ԓ<br/>{$order.mobile}��ʾ�ռ����֙C<br/>{$order.zipcode}��ʾ�ռ����]��<br/>{$order.address}��ʾ�ռ���Ԕ����ַ<br/>{$order.consignee}��ʾ�ռ������Q<br/>{$order.order_sn}��ʾӆ��̖';

/* ��β��� */
$_LANG['shipping_install'] = '���b���ͷ�ʽ';
$_LANG['install_succeess'] = '���ͷ�ʽ %s ���b�ɹ���';
$_LANG['del_lable'] = '�h���˺�';
$_LANG['upload_shipping_bg'] = '�ς���ӡ�ΈDƬ';
$_LANG['del_shipping_bg'] = '�h����ӡ�ΈDƬ';
$_LANG['save_setting'] = '�����O��';
$_LANG['recovery_default'] = '�֏�Ĭ�J';

/* ��ݵ����� */
$_LANG['lable_select_notice'] = '--�x�����˺�--';
$_LANG['lable_box']['shop_country'] = '�W��-����';
$_LANG['lable_box']['shop_province'] = '�W��-ʡ��';
$_LANG['lable_box']['shop_city'] = '�W��-����';
$_LANG['lable_box']['shop_name'] = '�W��-���Q';
$_LANG['lable_box']['shop_district'] = '�W��-�^/�h';
$_LANG['lable_box']['shop_tel'] = '�W��-ϵ�Ԓ';
$_LANG['lable_box']['shop_address'] = '�W��-��ַ';
$_LANG['lable_box']['customer_country'] = '�ռ���-����';
$_LANG['lable_box']['customer_province'] = '�ռ���-ʡ��';
$_LANG['lable_box']['customer_city'] = '�ռ���-����';
$_LANG['lable_box']['customer_district'] = '�ռ���-�^/�h';
$_LANG['lable_box']['customer_tel'] = '�ռ���-�Ԓ';
$_LANG['lable_box']['customer_mobel'] = '�ռ���-�֙C';
$_LANG['lable_box']['customer_post'] = '�ռ���-�]��';
$_LANG['lable_box']['customer_address'] = '�ռ���-Ԕ����ַ';
$_LANG['lable_box']['customer_name'] = '�ռ���-����';
$_LANG['lable_box']['year'] = '��-��������';
$_LANG['lable_box']['months'] = '��-��������';
$_LANG['lable_box']['day'] = '��-��������';
$_LANG['lable_box']['order_no'] = 'ӆ��̖-ӆ��';
$_LANG['lable_box']['order_postscript'] = '��ע-ӆ��';
$_LANG['lable_box']['order_best_time'] = '�l؛�r�g-ӆ��';
$_LANG['lable_box']['pigeon'] = '��-��̖';
//$_LANG['lable_box']['custom_content'] = '�Զ��x����';

/* ��ʾ��Ϣ */
$_LANG['no_shipping_name'] = '���������ͷ�ʽ���Q���ܞ�ա�';
$_LANG['no_shipping_desc'] = '���������ͷ�ʽ�������ݲ��ܞ�ա�';
$_LANG['repeat_shipping_name'] = '�������ѽ�����һ��ͬ�������ͷ�ʽ��';
$_LANG['uninstall_success'] = '���ͷ�ʽ %s �ѽ��ɹ�ж�d��';
$_LANG['add_shipping_area'] = '��ԓ���ͷ�ʽ�½����ͅ^��';
$_LANG['no_shipping_insure'] = '�����𣬱��r�M�ò��ܞ�գ�����ʹ��Ո�����O�Þ�0';
$_LANG['not_support_insure'] = 'ԓ���ͷ�ʽ��֧�ֱ��r,���r�M���O��ʧ��';
$_LANG['invalid_insure'] = '���ͱ��r�M�ò���һ���Ϸ��r��';
$_LANG['no_shipping_install'] = '�������ͷ�ʽ��δ���b�������ܾ�݋ģ��';
$_LANG['edit_template_success'] = '���fģ���ѽ��ɹ���݋��';

/* JS �Z�� */
$_LANG['js_languages']['lang_removeconfirm'] = '���_��Ҫж�dԓ���ͷ�ʽ�᣿';
$_LANG['js_languages']['shipping_area'] = '�O�Å^��';
$_LANG['js_languages']['upload_falid'] = '�e�`���ļ���Ͳ����_��Ո�ς���%s����͵��ļ���';
$_LANG['js_languages']['upload_del_falid'] = '�e�`���h��ʧ����';
$_LANG['js_languages']['upload_del_confirm'] = "��ʾ�����_�J�h����ӡ�ΈDƬ�᣿";
$_LANG['js_languages']['no_select_upload'] = "�e�`����߀�]���x���ӡ�ΈDƬ��Ոʹ�á��g�[...�����o�x��";
$_LANG['js_languages']['no_select_lable'] = "�����Kֹ����δ�x���κΘ˺���";
$_LANG['js_languages']['no_add_repeat_lable'] = "����ʧ���������S����؏͘˺���";
$_LANG['js_languages']['no_select_lable_del'] = "�h��ʧ�������]���x���κΘ˺���";
$_LANG['js_languages']['recovery_default_suer'] = "���_�J�֏�Ĭ�J�᣿�֏�Ĭ�J���@ʾ���b�r�ă��ݡ�";
?>