<?php

/**
 * ECSHOP ���������������
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: shopping_flow.php 17217 2011-01-19 06:29:08Z liubo $
*/

$_LANG['flow_login_register']['username_not_null'] = '���������û�����';
$_LANG['flow_login_register']['username_invalid'] = '��������һ����Ч���û�����';
$_LANG['flow_login_register']['password_not_null'] = '�����������롣';
$_LANG['flow_login_register']['email_not_null'] = '������������ʼ���';
$_LANG['flow_login_register']['email_invalid'] = '������ĵ����ʼ�����ȷ��';
$_LANG['flow_login_register']['password_not_same'] = '������������ȷ�����벻һ�¡�';
$_LANG['flow_login_register']['password_lt_six'] = '���벻��С��6���ַ���';

$_LANG['regist_success'] = "��ϲ����%s �˺�ע��ɹ�!";
$_LANG['login_success'] = '��ϲ�����Ѿ��ɹ���½��վ��';

/* ���ﳵ */
$_LANG['update_cart'] = '���¹��ﳵ';
$_LANG['back_to_cart'] = '���ع��ﳵ';
$_LANG['update_cart_notice'] = '���ﳵ���³ɹ�����������ѡ������Ҫ����Ʒ��';
$_LANG['direct_shopping'] = '�������¼��ֱ�ӹ���';
$_LANG['goods_not_exists'] = '�Բ���ָ������Ʒ������';
$_LANG['drop_goods_confirm'] = '��ȷʵҪ�Ѹ���Ʒ�Ƴ����ﳵ��';
$_LANG['goods_number_not_int'] = '����������ȷ����Ʒ������';
$_LANG['stock_insufficiency'] = '�ǳ���Ǹ����ѡ�����Ʒ %s �Ŀ������ֻ�� %d�������ֻ�ܹ��� %d ����';
$_LANG['package_stock_insufficiency'] = '�ǳ���Ǹ����ѡ��ĳ�ֵ��������Ѿ�������档�������ٹ���������ϵ�̼ҡ�';
$_LANG['shopping_flow'] = '��������';
$_LANG['username_exists'] = '��������û����Ѵ��ڣ��뻻һ�����ԡ�';
$_LANG['email_exists'] = '������ĵ����ʼ��Ѵ��ڣ��뻻һ�����ԡ�';
$_LANG['surplus_not_enough'] = '��ʹ�õ����ܳ��������е���';
$_LANG['integral_not_enough'] = '��ʹ�õĻ��ֲ��ܳ��������еĻ��֡�';
$_LANG['integral_too_much'] = "��ʹ�õĻ��ֲ��ܳ���%d";
$_LANG['invalid_bonus'] = "��ѡ��ĺ���������ڡ�";
$_LANG['no_goods_in_cart'] = '���Ĺ��ﳵ��û����Ʒ��';
$_LANG['not_submit_order'] = '�����뱾���Ź���Ʒ�Ķ������ύ�������ظ�������';
$_LANG['pay_success'] = '����֧���Ѿ��ɹ������ǽ�����Ϊ��������';
$_LANG['pay_fail'] = '����֧��ʧ�ܣ��뼰ʱ������ȡ����ϵ��';
$_LANG['pay_disabled'] = '��ѡ�õ�֧����ʽ�Ѿ���ͣ�á�';
$_LANG['pay_invalid'] = '��ѡ����һ����Ч��֧����ʽ����֧����ʽ�����ڻ����Ѿ���ͣ�á���������������ȡ����ϵ��';
$_LANG['flow_no_shipping'] = '������ѡ��һ�����ͷ�ʽ��';
$_LANG['flow_no_payment'] = '������ѡ��һ��֧����ʽ��';
$_LANG['pay_not_exist'] = 'ѡ�õ�֧����ʽ�����ڡ�';
$_LANG['storage_short'] = '��治��';
$_LANG['subtotal'] = 'С��';
$_LANG['accessories'] = '���';
$_LANG['largess'] = '��Ʒ';
$_LANG['shopping_money'] = '������С�� %s';
$_LANG['than_market_price'] = '���г��� %s ��ʡ�� %s (%s)';
$_LANG['your_discount'] = '�����Żݻ<a href="activity.php"><font color=red>%s</font></a>�������������ۿ� %s';
$_LANG['no'] = '��';
$_LANG['not_support_virtual_goods'] = '���ﳵ�д��ڷ�ʵ����Ʒ,��֧����������,���½���ڹ���';
$_LANG['not_support_insure'] = '��֧�ֱ���';
$_LANG['clear_cart'] = '��չ��ﳵ';
$_LANG['drop_to_collect'] = '�����ղؼ�';
$_LANG['password_js']['show_div_text'] = '�������¹��ﳵ��ť';
$_LANG['password_js']['show_div_exit'] = '�ر�';
$_LANG['goods_fittings'] = '��Ʒ������';
$_LANG['parent_name'] = '�����Ʒ��';
$_LANG['remark_package'] = '���';

/* �Żݻ */
$_LANG['favourable_name'] = '����ƣ�';
$_LANG['favourable_period'] = '�Ż����ޣ�';
$_LANG['favourable_range'] = '�Żݷ�Χ��';
$_LANG['far_ext'][FAR_ALL] = 'ȫ����Ʒ';
$_LANG['far_ext'][FAR_BRAND] = '����Ʒ��';
$_LANG['far_ext'][FAR_CATEGORY] = '���·���';
$_LANG['far_ext'][FAR_GOODS] = '������Ʒ';
$_LANG['favourable_amount'] = '������䣺';
$_LANG['favourable_type'] = '�Żݷ�ʽ��';
$_LANG['fat_ext'][FAT_DISCOUNT] = '���� %d%% ���ۿ�';
$_LANG['fat_ext'][FAT_GOODS] = '���������Ʒ���ػ�Ʒ����ѡ�� %d ����0��ʾ������������';
$_LANG['fat_ext'][FAT_PRICE] = 'ֱ�Ӽ����ֽ� %d';

$_LANG['favourable_not_exist'] = '��Ҫ���빺�ﳵ���Żݻ������';
$_LANG['favourable_not_available'] = '���������ܸ��Ż�';
$_LANG['favourable_used'] = '���Żݻ�Ѽ��빺�ﳵ��';
$_LANG['pls_select_gift'] = '��ѡ����Ʒ���ػ�Ʒ��';
$_LANG['gift_count_exceed'] = '��ѡ�����Ʒ���ػ�Ʒ����������������';
$_LANG['gift_in_cart'] = '��ѡ�����Ʒ���ػ�Ʒ���Ѿ��ڹ��ﳵ���ˣ�%s';
$_LANG['label_favourable'] = '�Żݻ';
$_LANG['label_collection'] = '�ҵ��ղ�';
$_LANG['collect_to_flow'] = '��������';

/* ��¼ע�� */
$_LANG['forthwith_login'] = '��¼';
$_LANG['forthwith_register'] = 'ע�����û�';
$_LANG['signin_failed'] = '�Բ��𣬵�¼ʧ�ܣ����������û����������Ƿ���ȷ';
$_LANG['gift_remainder'] = '˵����������¼��ע����뵽���ﳵҳ������ѡ����Ʒ��';

/* �ջ�����Ϣ */
$_LANG['flow_js']['consignee_not_null'] = '�ջ�����������Ϊ�գ�';
$_LANG['flow_js']['country_not_null'] = '����ѡ���ջ������ڹ��ң�';
$_LANG['flow_js']['province_not_null'] = '����ѡ���ջ�������ʡ�ݣ�';
$_LANG['flow_js']['city_not_null'] = '����ѡ���ջ������ڳ��У�';
$_LANG['flow_js']['district_not_null'] = '����ѡ���ջ�����������';
$_LANG['flow_js']['invalid_email'] = '��������ʼ���ַ����һ���Ϸ����ʼ���ַ��';
$_LANG['flow_js']['address_not_null'] = '�ջ��˵���ϸ��ַ����Ϊ�գ�';
$_LANG['flow_js']['tele_not_null'] = '�绰����Ϊ�գ�';
$_LANG['flow_js']['shipping_not_null'] = '����ѡ�����ͷ�ʽ��';
$_LANG['flow_js']['payment_not_null'] = '����ѡ��֧����ʽ��';
$_LANG['flow_js']['goodsattr_style'] = 1;
$_LANG['flow_js']['tele_invaild'] = '�绰���벻��Ч�ĺ���';
$_LANG['flow_js']['zip_not_num'] = '��������ֻ����д����';
$_LANG['flow_js']['mobile_invaild'] = '�ֻ����벻�ǺϷ�����';

$_LANG['new_consignee_address'] = '���ջ���ַ';
$_LANG['consignee_address'] = '�ջ���ַ';
$_LANG['consignee_name'] = '�ջ�������';
$_LANG['country_province'] = '��������';
$_LANG['please_select'] = '��ѡ��';
$_LANG['city_district'] = '����/����';
$_LANG['email_address'] = '�����ʼ���ַ';
$_LANG['detailed_address'] = '��ϸ��ַ';
$_LANG['postalcode'] = '��������';
$_LANG['phone'] = '�绰';
$_LANG['mobile'] = '�ֻ�';
$_LANG['backup_phone'] = '�ֻ�';
$_LANG['sign_building'] = '��־����';
$_LANG['deliver_goods_time'] = '����ͻ�ʱ��';
$_LANG['default'] = 'Ĭ��';
$_LANG['default_address'] = 'Ĭ�ϵ�ַ';
$_LANG['confirm_submit'] = 'ȷ���ύ';
$_LANG['confirm_edit'] = 'ȷ���޸�';
$_LANG['country'] = '����';
$_LANG['province'] = 'ʡ��';
$_LANG['city'] = '����';
$_LANG['area'] = '��������';
$_LANG['consignee_add'] = '������ջ���ַ';
$_LANG['shipping_address'] = '�����������ַ';
$_LANG['address_amount'] = '�����ջ���ַ���ֻ��������';
$_LANG['not_fount_consignee'] = '�Բ�����ѡ�����ջ���ַ�����ڡ�';

/*------------------------------------------------------ */
//-- �����ύ
/*------------------------------------------------------ */

$_LANG['goods_amount_not_enough'] = '���������Ʒû�дﵽ���������޹���� %s �������ύ������';
$_LANG['balance_not_enough'] = '����������֧��������������ѡ������֧����ʽ';
$_LANG['select_shipping'] = '��ѡ�������ͷ�ʽΪ';
$_LANG['select_payment'] = '��ѡ����֧����ʽΪ';
$_LANG['order_amount'] = '����Ӧ������Ϊ';
$_LANG['remember_order_number'] = '��л���ڱ��깺����Ķ������ύ�ɹ������ס���Ķ�����';
$_LANG['back_home'] = '<a href="index.php">������ҳ</a>';
$_LANG['goto_user_center'] = '<a href="user.php">�û�����</a>';
$_LANG['order_submit_back'] = '������ %s ��ȥ %s';

$_LANG['order_placed_sms'] = "�����¶���.�ջ���:%s �绰:%s";
$_LANG['sms_paid'] = '�Ѹ���';

$_LANG['notice_gb_order_amount'] = '����ע���Ź�����б�֤�𣬵�һ��ֻ��֧����֤�����Ӧ��֧�����ã�';

$_LANG['pay_order'] = '֧������ %s';
$_LANG['validate_bonus'] = '��֤���';
$_LANG['input_bonus_no'] = '�������������к�';
$_LANG['select_bonus'] = 'ѡ�����к��';
$_LANG['bonus_sn_error'] = '�ú�����кŲ���ȷ';
$_LANG['bonus_min_amount_error'] = '������Ʒ���û�дﵽʹ�øú������ͽ�� %s';
$_LANG['bonus_is_ok'] = '�ú�����кſ���ʹ�ã����Եֿ� %s';


$_LANG['shopping_myship'] = '�ҵ�����';
$_LANG['shopping_activity'] = '��б�';
$_LANG['shopping_package'] = '��ֵ����б�';
?>
