<?php

/**
 * ECSHOP �����������ͷ�ʽ���������ļ�
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: shipping.php 17217 2011-01-19 06:29:08Z liubo $
*/

$_LANG['shipping_name'] = '���ͷ�ʽ����';
$_LANG['shipping_version'] = '����汾';
$_LANG['shipping_desc'] = '���ͷ�ʽ����';
$_LANG['shipping_author'] = '�������';
$_LANG['insure'] = '���۷���';
$_LANG['support_cod'] = '�������';
$_LANG['shipping_area'] = '��������';
$_LANG['shipping_print_edit'] = '�༭��ӡģ��';
$_LANG['shipping_print_template'] = '��ݵ�ģ��';
$_LANG['shipping_template_info'] = '����ģ�����˵��:<br/>{$shop_name}��ʾ��������<br/>{$province}��ʾ��������ʡ��<br/>{$city}��ʾ������������<br/>{$shop_address}��ʾ�����ַ<br/>{$service_phone}��ʾ������ϵ�绰<br/>{$order.order_amount}��ʾ�������<br/>{$order.region}��ʾ�ռ��˵���<br/>{$order.tel}��ʾ�ռ��˵绰<br/>{$order.mobile}��ʾ�ռ����ֻ�<br/>{$order.zipcode}��ʾ�ռ����ʱ�<br/>{$order.address}��ʾ�ռ�����ϸ��ַ<br/>{$order.consignee}��ʾ�ռ�������<br/>{$order.order_sn}��ʾ������';

/* ������ */
$_LANG['shipping_install'] = '��װ���ͷ�ʽ';
$_LANG['install_succeess'] = '���ͷ�ʽ %s ��װ�ɹ���';
$_LANG['del_lable'] = 'ɾ����ǩ';
$_LANG['upload_shipping_bg'] = '�ϴ���ӡ��ͼƬ';
$_LANG['del_shipping_bg'] = 'ɾ����ӡ��ͼƬ';
$_LANG['save_setting'] = '��������';
$_LANG['recovery_default'] = '�ָ�Ĭ��';

/* ��ݵ����� */
$_LANG['lable_select_notice'] = '--ѡ������ǩ--';
$_LANG['lable_box']['shop_country'] = '����-����';
$_LANG['lable_box']['shop_province'] = '����-ʡ��';
$_LANG['lable_box']['shop_city'] = '����-����';
$_LANG['lable_box']['shop_name'] = '����-����';
$_LANG['lable_box']['shop_district'] = '����-��/��';
$_LANG['lable_box']['shop_tel'] = '����-��ϵ�绰';
$_LANG['lable_box']['shop_address'] = '����-��ַ';
$_LANG['lable_box']['customer_country'] = '�ռ���-����';
$_LANG['lable_box']['customer_province'] = '�ռ���-ʡ��';
$_LANG['lable_box']['customer_city'] = '�ռ���-����';
$_LANG['lable_box']['customer_district'] = '�ռ���-��/��';
$_LANG['lable_box']['customer_tel'] = '�ռ���-�绰';
$_LANG['lable_box']['customer_mobel'] = '�ռ���-�ֻ�';
$_LANG['lable_box']['customer_post'] = '�ռ���-�ʱ�';
$_LANG['lable_box']['customer_address'] = '�ռ���-��ϸ��ַ';
$_LANG['lable_box']['customer_name'] = '�ռ���-����';
$_LANG['lable_box']['year'] = '��-��������';
$_LANG['lable_box']['months'] = '��-��������';
$_LANG['lable_box']['day'] = '��-��������';
$_LANG['lable_box']['order_no'] = '������-����';
$_LANG['lable_box']['order_postscript'] = '��ע-����';
$_LANG['lable_box']['order_best_time'] = '�ͻ�ʱ��-����';
$_LANG['lable_box']['pigeon'] = '��-�Ժ�';
//$_LANG['lable_box']['custom_content'] = '�Զ�������';

/* ��ʾ��Ϣ */
$_LANG['no_shipping_name'] = '�Բ������ͷ�ʽ���Ʋ���Ϊ�ա�';
$_LANG['no_shipping_desc'] = '�Բ������ͷ�ʽ�������ݲ���Ϊ�ա�';
$_LANG['repeat_shipping_name'] = '�Բ����Ѿ�����һ��ͬ�������ͷ�ʽ��';
$_LANG['uninstall_success'] = '���ͷ�ʽ %s �Ѿ��ɹ�ж�ء�';
$_LANG['add_shipping_area'] = 'Ϊ�����ͷ�ʽ�½���������';
$_LANG['no_shipping_insure'] = '�Բ��𣬱��۷��ò���Ϊ�գ�����ʹ���뽫������Ϊ0';
$_LANG['not_support_insure'] = '�����ͷ�ʽ��֧�ֱ���,���۷�������ʧ��';
$_LANG['invalid_insure'] = '���ͱ��۷��ò���һ���Ϸ��۸�';
$_LANG['no_shipping_install'] = '�������ͷ�ʽ��δ��װ���ݲ��ܱ༭ģ��';
$_LANG['edit_template_success'] = '���ģ���Ѿ��ɹ��༭��';

/* JS ���� */
$_LANG['js_languages']['lang_removeconfirm'] = '��ȷ��Ҫж�ظ����ͷ�ʽ��';
$_LANG['js_languages']['shipping_area'] = '��������';
$_LANG['js_languages']['upload_falid'] = '�����ļ����Ͳ���ȷ�����ϴ���%s�����͵��ļ���';
$_LANG['js_languages']['upload_del_falid'] = '����ɾ��ʧ�ܣ�';
$_LANG['js_languages']['upload_del_confirm'] = "��ʾ����ȷ��ɾ����ӡ��ͼƬ��";
$_LANG['js_languages']['no_select_upload'] = "��������û��ѡ���ӡ��ͼƬ����ʹ�á����...����ťѡ��";
$_LANG['js_languages']['no_select_lable'] = "������ֹ����δѡ���κα�ǩ��";
$_LANG['js_languages']['no_add_repeat_lable'] = "����ʧ�ܣ�����������ظ���ǩ��";
$_LANG['js_languages']['no_select_lable_del'] = "ɾ��ʧ�ܣ���û��ѡ���κα�ǩ��";
$_LANG['js_languages']['recovery_default_suer'] = "��ȷ�ϻָ�Ĭ���𣿻ָ�Ĭ�Ϻ���ʾ��װʱ�����ݡ�";
?>