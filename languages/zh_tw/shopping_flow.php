<?php

/**
 * ECSHOP ُ���������P�Z��
 * ============================================================================
 * ������� 2005-2011 �Ϻ����ɾW�j�Ƽ����޹�˾���K�������Й�����
 * �Wվ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �@����һ������ܛ������ֻ���ڲ�����̘IĿ�ĵ�ǰ����������a�M���޸ĺ�
 * ʹ�ã������S��������a���κ���ʽ�κ�Ŀ�ĵ��ٰl�ѡ�
 * ============================================================================
 * $Author: liubo $
 * $Id: shopping_flow.php 17217 2011-01-19 06:29:08Z liubo $
*/

$_LANG['flow_login_register']['username_not_null'] = 'Ո��ݔ���Ñ�����';
$_LANG['flow_login_register']['username_invalid'] = '��ݔ����һ���oЧ���Ñ�����';
$_LANG['flow_login_register']['password_not_null'] = 'Ո��ݔ���ܴa��';
$_LANG['flow_login_register']['email_not_null'] = 'Ո��ݔ������]����';
$_LANG['flow_login_register']['email_invalid'] = '��ݔ�������]�������_��';
$_LANG['flow_login_register']['password_not_same'] = '��ݔ����ܴa�ʹ_�J�ܴa��һ�¡�';
$_LANG['flow_login_register']['password_lt_six'] = '�ܴa����С�6���ַ���';

$_LANG['regist_success'] = "��ϲ����%s �~̖�]�Գɹ�!";
$_LANG['login_success'] = '��ϲ�����ѽ��ɹ���ꑱ�վ��';

/* ُ��܇ */
$_LANG['update_cart'] = '����ُ��܇';
$_LANG['back_to_cart'] = '����ُ��܇';
$_LANG['update_cart_notice'] = 'ُ��܇���³ɹ���Ո�������x������Ҫ��ٛƷ��';
$_LANG['direct_shopping'] = '�������䛣�ֱ��ُ�I';
$_LANG['goods_not_exists'] = '������ָ������Ʒ������';
$_LANG['drop_goods_confirm'] = '���_��Ҫ��ԓ��Ʒ�Ƴ�ُ��܇�᣿';
$_LANG['goods_number_not_int'] = 'Ո��ݔ�����_����Ʒ������';
$_LANG['stock_insufficiency'] = '�ǳ���Ǹ�����x�����Ʒ %s �Ď�攵��ֻ�� %d�������ֻ��ُ�I %d ����';
$_LANG['package_stock_insufficiency'] = '�ǳ���Ǹ�����x��ĳ�ֵ�Y�������ѽ�������档Ո���p��ُ�I�����M�̼ҡ�';
$_LANG['shopping_flow'] = 'ُ������';
$_LANG['username_exists'] = '��ݔ����Ñ����Ѵ��ڣ�Ո�Qһ��ԇԇ��';
$_LANG['email_exists'] = '��ݔ�������]���Ѵ��ڣ�Ո�Qһ��ԇԇ��';
$_LANG['surplus_not_enough'] = '��ʹ�õ��N�~���ܳ��^���F�е��N�~��';
$_LANG['integral_not_enough'] = '��ʹ�õķe�ֲ��ܳ��^���F�еķe�֡�';
$_LANG['integral_too_much'] = "��ʹ�õķe�ֲ��ܳ��^%d";
$_LANG['invalid_bonus'] = "���x��ļt���K�����ڡ�";
$_LANG['no_goods_in_cart'] = '����ُ��܇�Л]����Ʒ��';
$_LANG['not_submit_order'] = '�����c���ΈFُ��Ʒ��ӆ�����ύ��Ո�����}������';
$_LANG['pay_success'] = '����֧���ѽ��ɹ����҂����M������l؛��';
$_LANG['pay_fail'] = '����֧��ʧ����Ո���r���҂�ȡ���M��';
$_LANG['pay_disabled'] = '���x�õ�֧����ʽ�ѽ���ͣ�á�';
$_LANG['pay_invalid'] = '���x����һ���oЧ��֧����ʽ��ԓ֧����ʽ�����ڻ����ѽ���ͣ�á�Ո���������҂�ȡ���M��';
$_LANG['flow_no_shipping'] = '������x��һ�����ͷ�ʽ��';
$_LANG['flow_no_payment'] = '������x��һ��֧����ʽ��';
$_LANG['pay_not_exist'] = '�x�õ�֧����ʽ�����ڡ�';
$_LANG['storage_short'] = '��治��';
$_LANG['subtotal'] = 'СӋ';
$_LANG['accessories'] = '���';
$_LANG['largess'] = 'ٛƷ';
$_LANG['shopping_money'] = 'ُ����~СӋ %s';
$_LANG['than_market_price'] = '���Ј��r %s ��ʡ�� %s (%s)';
$_LANG['your_discount'] = '�������ݻ��<a href="activity.php"><font color=red>%s</font></a>�������������ۿ� %s';
$_LANG['no'] = '�o';
$_LANG['not_support_virtual_goods'] = 'ُ��܇�д��ڷǌ��w��Ʒ,��֧������ُ�I,Ո�������ُ�I';
$_LANG['not_support_insure'] = '��֧�ֱ��r';
$_LANG['clear_cart'] = '���ُ��܇';
$_LANG['drop_to_collect'] = '�����ղ؊A';
$_LANG['password_js']['show_div_text'] = 'Ո�c������ُ��܇���o';
$_LANG['password_js']['show_div_exit'] = '�P�]';
$_LANG['goods_fittings'] = '��Ʒ���P���';
$_LANG['parent_name'] = '���P��Ʒ��';
$_LANG['remark_package'] = '�Y��';

/* ���ݻ�� */
$_LANG['favourable_name'] = '������Q��';
$_LANG['favourable_period'] = '�������ޣ�';
$_LANG['favourable_range'] = '���ݹ�����';
$_LANG['far_ext'][FAR_ALL] = 'ȫ����Ʒ';
$_LANG['far_ext'][FAR_BRAND] = '����Ʒ��';
$_LANG['far_ext'][FAR_CATEGORY] = '���·��';
$_LANG['far_ext'][FAR_GOODS] = '������Ʒ';
$_LANG['favourable_amount'] = '���~�^�g��';
$_LANG['favourable_type'] = '���ݷ�ʽ��';
$_LANG['fat_ext'][FAT_DISCOUNT] = '���� %d%% ���ۿ�';
$_LANG['fat_ext'][FAT_GOODS] = '�������ٛƷ���ػ�Ʒ�����x�� %d ����0��ʾ�����Ɣ�����';
$_LANG['fat_ext'][FAT_PRICE] = 'ֱ�Ӝp�٬F�� %d';

$_LANG['favourable_not_exist'] = '��Ҫ����ُ��܇�ă��ݻ�Ӳ�����';
$_LANG['favourable_not_available'] = '����������ԓ����';
$_LANG['favourable_used'] = 'ԓ���ݻ���Ѽ���ُ��܇��';
$_LANG['pls_select_gift'] = 'Ո�x��ٛƷ���ػ�Ʒ��';
$_LANG['gift_count_exceed'] = '���x���ٛƷ���ػ�Ʒ���������^������';
$_LANG['gift_in_cart'] = '���x���ٛƷ���ػ�Ʒ���ѽ���ُ��܇���ˣ�%s';
$_LANG['label_favourable'] = '�Żݻ';
$_LANG['label_collection'] = '�ҵ��ղ�';
$_LANG['collect_to_flow'] = '��������';

/* ����]�� */
$_LANG['forthwith_login'] = '���';
$_LANG['forthwith_register'] = '�]�����Ñ�';
$_LANG['signin_failed'] = '�����𣬵��ʧ����Ո�z�������Ñ������ܴa�Ƿ����_';
$_LANG['gift_remainder'] = '�f����������䛻��]���ᣬՈ��ُ��܇��������x��ٛƷ��';

/* ��؛����Ϣ */
$_LANG['flow_js']['consignee_not_null'] = '��؛���������ܞ�գ�';
$_LANG['flow_js']['country_not_null'] = 'Ո���x����؛�����ڇ��ң�';
$_LANG['flow_js']['province_not_null'] = 'Ո���x����؛������ʡ�ݣ�';
$_LANG['flow_js']['city_not_null'] = 'Ո���x����؛�����ڳ��У�';
$_LANG['flow_js']['district_not_null'] = 'Ո���x����؛�����څ^��';
$_LANG['flow_js']['invalid_email'] = '��ݔ����]����ַ����һ���Ϸ����]����ַ��';
$_LANG['flow_js']['address_not_null'] = '��؛�˵�Ԕ����ַ���ܞ�գ�';
$_LANG['flow_js']['tele_not_null'] = '�Ԓ���ܞ�գ�';
$_LANG['flow_js']['shipping_not_null'] = 'Ո���x�����ͷ�ʽ��';
$_LANG['flow_js']['payment_not_null'] = 'Ո���x��֧����ʽ��';
$_LANG['flow_js']['goodsattr_style'] = 1;
$_LANG['flow_js']['tele_invaild'] = '�Ԓ̖�a����Ч��̖�a';
$_LANG['flow_js']['zip_not_num'] = '�]�����aֻ�������';
$_LANG['flow_js']['mobile_invaild'] = '�֙C̖�a���ǺϷ�̖�a';

$_LANG['new_consignee_address'] = '����؛��ַ';
$_LANG['consignee_address'] = '��؛��ַ';
$_LANG['consignee_name'] = '��؛������';
$_LANG['country_province'] = '���ͅ^��';
$_LANG['please_select'] = 'Ո�x��';
$_LANG['city_district'] = '����/�؅^';
$_LANG['email_address'] = '����]����ַ';
$_LANG['detailed_address'] = 'Ԕ����ַ';
$_LANG['postalcode'] = '�]�����a';
$_LANG['phone'] = '�Ԓ';
$_LANG['mobile'] = '�֙C';
$_LANG['backup_phone'] = '�֙C';
$_LANG['sign_building'] = '���I���B';
$_LANG['deliver_goods_time'] = '�����؛�r�g';
$_LANG['default'] = 'Ĭ�J';
$_LANG['default_address'] = 'Ĭ�J��ַ';
$_LANG['confirm_submit'] = '�_�J�ύ';
$_LANG['confirm_edit'] = '�_�J�޸�';
$_LANG['country'] = '����';
$_LANG['province'] = 'ʡ��';
$_LANG['city'] = '����';
$_LANG['area'] = '���څ^��';
$_LANG['consignee_add'] = '�������؛��ַ';
$_LANG['shipping_address'] = '�������@����ַ';
$_LANG['address_amount'] = '������؛��ַ���ֻ��������';
$_LANG['not_fount_consignee'] = '���������x������؛��ַ�����ڡ�';

/*------------------------------------------------------ */
//-- ӆ���ύ
/*------------------------------------------------------ */

$_LANG['goods_amount_not_enough'] = '��ُ�I����Ʒ�]���_������������ُ���~ %s �������ύӆ�Ρ�';
$_LANG['balance_not_enough'] = '�����N�~������֧������ӆ�Σ�Ո�x������֧����ʽ';
$_LANG['select_shipping'] = '���x�������ͷ�ʽ��';
$_LANG['select_payment'] = '���x����֧����ʽ��';
$_LANG['order_amount'] = '���đ�������~��';
$_LANG['remember_order_number'] = '���x���ڱ���ُ�����ӆ�����ύ�ɹ���Ոӛס����ӆ��̖';
$_LANG['back_home'] = '<a href="index.php">�������</a>';
$_LANG['goto_user_center'] = '<a href="user.php">�Ñ�����</a>';
$_LANG['order_submit_back'] = '������ %s ��ȥ %s';

$_LANG['order_placed_sms'] = "������ӆ��.��؛��:%s �Ԓ:%s";
$_LANG['sms_paid'] = '�Ѹ���';

$_LANG['notice_gb_order_amount'] = '�����]���Fُ����б��C�𣬵�һ��ֻ��֧�����C���������֧���M�ã�';

$_LANG['pay_order'] = '֧��ӆ�� %s';
$_LANG['validate_bonus'] = '��C�t��';
$_LANG['input_bonus_no'] = '����ݔ��t������̖';
$_LANG['select_bonus'] = '�x�����мt��';
$_LANG['bonus_sn_error'] = 'ԓ�t������̖�����_';
$_LANG['bonus_min_amount_error'] = 'ӆ����Ʒ���~�]���_��ʹ��ԓ�t������ͽ��~ %s';
$_LANG['bonus_is_ok'] = 'ԓ�t������̖����ʹ�ã����Եֿ� %s';


$_LANG['shopping_myship'] = '�ҵ�����';
$_LANG['shopping_activity'] = '����б�';
$_LANG['shopping_package'] = '��ֵ�Y���б�';
?>
