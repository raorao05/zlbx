<?php

/**
 * ECSHOP �������������ļ�
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: order.php 17217 2011-01-19 06:29:08Z liubo $
 */

/* �������� */
$_LANG['order_sn'] = '������';
$_LANG['consignee'] = '�ջ���';
$_LANG['all_status'] = '����״̬';

$_LANG['cs'][OS_UNCONFIRMED] = '��ȷ��';
$_LANG['cs'][CS_AWAIT_PAY] = '������';
$_LANG['cs'][CS_AWAIT_SHIP] = '������';
$_LANG['cs'][CS_FINISHED] = '�����';
$_LANG['cs'][PS_PAYING] = '������';
$_LANG['cs'][OS_CANCELED] = 'ȡ��';
$_LANG['cs'][OS_INVALID] = '��Ч';
$_LANG['cs'][OS_RETURNED] = '�˻�';
$_LANG['cs'][OS_SHIPPED_PART] = '���ַ���';

/* ����״̬ */
$_LANG['os'][OS_UNCONFIRMED] = 'δȷ��';
$_LANG['os'][OS_CONFIRMED] = '��ȷ��';
$_LANG['os'][OS_CANCELED] = '<font color="red"> ȡ��</font>';
$_LANG['os'][OS_INVALID] = '<font color="red">��Ч</font>';
$_LANG['os'][OS_RETURNED] = '<font color="red">�˻�</font>';
$_LANG['os'][OS_SPLITED] = '�ѷֵ�';
$_LANG['os'][OS_SPLITING_PART] = '���ֵַ�';

$_LANG['ss'][SS_UNSHIPPED] = 'δ����';
$_LANG['ss'][SS_PREPARING] = '�����';
$_LANG['ss'][SS_SHIPPED] = '�ѷ���';
$_LANG['ss'][SS_RECEIVED] = '�ջ�ȷ��';
$_LANG['ss'][SS_SHIPPED_PART] = '�ѷ���(������Ʒ)';
$_LANG['ss'][SS_SHIPPED_ING] = '������';

$_LANG['ps'][PS_UNPAYED] = 'δ����';
$_LANG['ps'][PS_PAYING] = '������';
$_LANG['ps'][PS_PAYED] = '�Ѹ���';

$_LANG['ss_admin'][SS_SHIPPED_ING] = '�����У�ǰ̨״̬��δ������';
/* �������� */
$_LANG['label_operable_act'] = '��ǰ��ִ�в�����';
$_LANG['label_action_note'] = '������ע��';
$_LANG['label_invoice_note'] = '������ע��';
$_LANG['label_invoice_no'] = '�������ţ�';
$_LANG['label_cancel_note'] = 'ȡ��ԭ��';
$_LANG['notice_cancel_note'] = '�����¼���̼Ҹ��ͻ��������У�';
$_LANG['op_confirm'] = 'ȷ��';
$_LANG['op_pay'] = '����';
$_LANG['op_prepare'] = '���';
$_LANG['op_ship'] = '����';
$_LANG['op_cancel'] = 'ȡ��';
$_LANG['op_invalid'] = '��Ч';
$_LANG['op_return'] = '�˻�';
$_LANG['op_unpay'] = '��Ϊδ����';
$_LANG['op_unship'] = 'δ����';
$_LANG['op_cancel_ship'] = 'ȡ������';
$_LANG['op_receive'] = '���ջ�';
$_LANG['op_assign'] = 'ָ�ɸ�';
$_LANG['op_after_service'] = '�ۺ�';
$_LANG['act_ok'] = '�����ɹ�';
$_LANG['act_false'] = '����ʧ��';
$_LANG['act_ship_num'] = '�˵������������ܳ���������Ʒ����';
$_LANG['act_good_vacancy'] = '��Ʒ��ȱ��';
$_LANG['act_good_delivery'] = '���ѷ���';
$_LANG['notice_gb_ship'] = '��ע���Ź��δ����Ϊ�ɹ�ǰ�����ܷ���';
$_LANG['back_list'] = '���ض����б�';
$_LANG['op_remove'] = 'ɾ��';
$_LANG['op_you_can'] = '���ɽ��еĲ���';
$_LANG['op_split'] = '���ɷ�����';
$_LANG['op_to_delivery'] = 'ȥ����';

/* �����б� */
$_LANG['order_amount'] = 'Ӧ�����';
$_LANG['total_fee'] = '�ܽ��';
$_LANG['shipping_name'] = '���ͷ�ʽ';
$_LANG['pay_name'] = '֧����ʽ';
$_LANG['address'] = '��ַ';
$_LANG['order_time'] = '�µ�ʱ��';
$_LANG['detail'] = '�鿴';
$_LANG['phone'] = '�绰';
$_LANG['group_buy'] = '���Ź���';
$_LANG['error_get_goods_info'] = '��ȡ������Ʒ��Ϣ����';
$_LANG['exchange_goods'] = '�����ֶһ���';

$_LANG['js_languages']['remove_confirm'] = 'ɾ������������ö�����������Ϣ����ȷ��Ҫ��ô����';

/* �������� */
$_LANG['label_order_sn'] = '�����ţ�';
$_LANG['label_all_status'] = '����״̬��';
$_LANG['label_user_name'] = '�����ˣ�';
$_LANG['label_consignee'] = '�ջ��ˣ�';
$_LANG['label_email'] = '�����ʼ���';
$_LANG['label_address'] = '��ַ��';
$_LANG['label_zipcode'] = '�ʱࣺ';
$_LANG['label_tel'] = '�绰��';
$_LANG['label_mobile'] = '�ֻ���';
$_LANG['label_shipping'] = '���ͷ�ʽ��';
$_LANG['label_payment'] = '֧����ʽ��';
$_LANG['label_order_status'] = '����״̬��';
$_LANG['label_pay_status'] = '����״̬��';
$_LANG['label_shipping_status'] = '����״̬��';
$_LANG['label_area'] = '���ڵ�����';
$_LANG['label_time'] = '�µ�ʱ�䣺';

/* �������� */
$_LANG['prev'] = 'ǰһ������';
$_LANG['next'] = '��һ������';
$_LANG['print_order'] = '��ӡ����';
$_LANG['print_shipping'] = '��ӡ��ݵ�';
$_LANG['print_order_sn'] = '������ţ�';
$_LANG['print_buy_name'] = '�� �� �ˣ�';
$_LANG['label_consignee_address'] = '�ջ���ַ��';
$_LANG['no_print_shipping'] = '�ܱ�Ǹ,Ŀǰ����û�����ô�ӡ��ݵ�ģ��.���ܽ��д�ӡ';
$_LANG['suppliers_no'] = '��ָ�������̱������д���';
$_LANG['restaurant'] = '����';

$_LANG['order_info'] = '������Ϣ';
$_LANG['base_info'] = '������Ϣ';
$_LANG['other_info'] = '������Ϣ';
$_LANG['consignee_info'] = '�ջ�����Ϣ';
$_LANG['fee_info'] = '������Ϣ';
$_LANG['action_info'] = '������Ϣ';
$_LANG['shipping_info'] = '������Ϣ';

$_LANG['label_how_oos'] = 'ȱ������';
$_LANG['label_how_surplus'] = '����';
$_LANG['label_pack'] = '��װ��';
$_LANG['label_card'] = '�ؿ���';
$_LANG['label_card_message'] = '�ؿ�ף���';
$_LANG['label_order_time'] = '�µ�ʱ�䣺';
$_LANG['label_pay_time'] = '����ʱ�䣺';
$_LANG['label_shipping_time'] = '����ʱ�䣺';
$_LANG['label_sign_building'] = '��־�Խ�����';
$_LANG['label_best_time'] = '����ͻ�ʱ�䣺';
$_LANG['label_inv_type'] = '��Ʊ���ͣ�';
$_LANG['label_inv_payee'] = '��Ʊ̧ͷ��';
$_LANG['label_inv_content'] = '��Ʊ���ݣ�';
$_LANG['label_postscript'] = '�ͻ����̼ҵ����ԣ�';
$_LANG['label_region'] = '���ڵ�����';

$_LANG['label_shop_url'] = '��ַ��';
$_LANG['label_shop_address'] = '��ַ��';
$_LANG['label_service_phone'] = '�绰��';
$_LANG['label_print_time'] = '��ӡʱ�䣺';

$_LANG['label_suppliers'] = 'ѡ�񹩻��̣�';
$_LANG['label_agency'] = '���´���';
$_LANG['suppliers_name'] = '������';

$_LANG['product_sn'] = '��Ʒ��';
$_LANG['goods_info'] = '��Ʒ��Ϣ';
$_LANG['goods_name'] = '��Ʒ����';
$_LANG['goods_name_brand'] = '��Ʒ���� [ Ʒ�� ]';
$_LANG['goods_sn'] = '����';
$_LANG['goods_price'] = '�۸�';
$_LANG['goods_number'] = '����';
$_LANG['goods_attr'] = '����';
$_LANG['goods_delivery'] = '�ѷ�������';
$_LANG['goods_delivery_curr'] = '�˵���������';
$_LANG['storage'] = '���';
$_LANG['subtotal'] = 'С��';
$_LANG['label_total'] = '�ϼƣ�';
$_LANG['label_total_weight'] = '��Ʒ��������';

$_LANG['label_goods_amount'] = '��Ʒ�ܽ�';
$_LANG['label_discount'] = '�ۿۣ�';
$_LANG['label_tax'] = '��Ʊ˰�';
$_LANG['label_shipping_fee'] = '���ͷ��ã�';
$_LANG['label_insure_fee'] = '���۷��ã�';
$_LANG['label_insure_yn'] = '�Ƿ񱣼ۣ�';
$_LANG['label_pay_fee'] = '֧�����ã�';
$_LANG['label_pack_fee'] = '��װ���ã�';
$_LANG['label_card_fee'] = '�ؿ����ã�';
$_LANG['label_money_paid'] = '�Ѹ����';
$_LANG['label_surplus'] = 'ʹ����';
$_LANG['label_integral'] = 'ʹ�û��֣�';
$_LANG['label_bonus'] = 'ʹ�ú����';
$_LANG['label_order_amount'] = '�����ܽ�';
$_LANG['label_money_dues'] = 'Ӧ�����';
$_LANG['label_money_refund'] = 'Ӧ�˿��';
$_LANG['label_to_buyer'] = '�̼Ҹ��ͻ������ԣ�';
$_LANG['save_order'] = '���涩��';
$_LANG['notice_gb_order_amount'] = '����ע���Ź�����б�֤�𣬵�һ��ֻ��֧����֤�����Ӧ��֧�����ã�';

$_LANG['action_user'] = '�����ߣ�';
$_LANG['action_time'] = '����ʱ��';
$_LANG['order_status'] = '����״̬';
$_LANG['pay_status'] = '����״̬';
$_LANG['shipping_status'] = '����״̬';
$_LANG['action_note'] = '��ע';
$_LANG['pay_note'] = '֧����ע��';

$_LANG['sms_time_format'] = 'm��j��Gʱ';
$_LANG['order_shipped_sms'] = '���Ķ���%s����%s���� [%s]';
$_LANG['order_splited_sms'] = '���Ķ���%s,%s����%s [%s]';
$_LANG['order_removed'] = '����ɾ���ɹ���';
$_LANG['return_list'] = '���ض����б�';

/* ����������ʾ */
$_LANG['surplus_not_enough'] = '�ö���ʹ�� %s ���֧���������û�����';
$_LANG['integral_not_enough'] = '�ö���ʹ�� %s ����֧���������û����ֲ���';
$_LANG['bonus_not_available'] = '�ö���ʹ�ú��֧�������ں��������';

/* ��������Ϣ */
$_LANG['display_buyer'] = '��ʾ��������Ϣ';
$_LANG['buyer_info'] = '��������Ϣ';
$_LANG['pay_points'] = '���ѻ���';
$_LANG['rank_points'] = '�ȼ�����';
$_LANG['user_money'] = '�˻����';
$_LANG['email'] = '�����ʼ�';
$_LANG['rank_name'] = '��Ա�ȼ�';
$_LANG['bonus_count'] = '�������';
$_LANG['zipcode'] = '�ʱ�';
$_LANG['tel'] = '�绰';
$_LANG['mobile'] = '���õ绰';

/* �ϲ����� */
$_LANG['order_sn_not_null'] = '����дҪ�ϲ��Ķ�����';
$_LANG['two_order_sn_same'] = 'Ҫ�ϲ������������Ų�����ͬ';
$_LANG['order_not_exist'] = '���� %s ������';
$_LANG['os_not_unconfirmed_or_confirmed'] = '%s �Ķ���״̬���ǡ�δȷ�ϡ�����ȷ�ϡ�';
$_LANG['ps_not_unpayed'] = '���� %s �ĸ���״̬���ǡ�δ���';
$_LANG['ss_not_unshipped'] = '���� %s �ķ���״̬���ǡ�δ������';
$_LANG['order_user_not_same'] = 'Ҫ�ϲ���������������ͬһ���û��µ�';
$_LANG['merge_invalid_order'] = '�Բ�����ѡ��ϲ��Ķ�����������кϲ��Ĳ�����';

$_LANG['from_order_sn'] = '�Ӷ�����';
$_LANG['to_order_sn'] = '��������';
$_LANG['merge'] = '�ϲ�';
$_LANG['notice_order_sn'] = '������������һ��ʱ���ϲ���Ķ�����Ϣ���磺֧����ʽ�����ͷ�ʽ����װ���ؿ�������ȣ���������Ϊ׼��';
$_LANG['js_languages']['confirm_merge'] = '��ȷʵҪ�ϲ�������������';

/* ������ */
$_LANG['pls_select_order'] = '��ѡ����Ҫ�����Ķ���';
$_LANG['no_fulfilled_order'] = 'û��������������Ķ�����';
$_LANG['updated_order'] = '���µĶ�����';
$_LANG['order'] = '������';
$_LANG['confirm_order'] = '���¶����޷�����Ϊȷ��״̬';
$_LANG['invalid_order'] = '���¶����޷�����Ϊ��Ч';
$_LANG['cancel_order'] = '���¶����޷�ȡ��';
$_LANG['remove_order'] = '���¶����޷����Ƴ�';

/* �༭������ӡģ�� */
$_LANG['edit_order_templates'] = '�༭������ӡģ��';
$_LANG['template_resetore'] = '��ԭģ��';
$_LANG['edit_template_success'] = '�༭������ӡģ������ɹ�!';
$_LANG['remark_fittings'] = '�������';
$_LANG['remark_gift'] = '����Ʒ��';
$_LANG['remark_favourable'] = '���ػ�Ʒ��';
$_LANG['remark_package'] = '�������';

/* ������Դͳ�� */
$_LANG['from_order'] = '������Դ��';
$_LANG['from_ad_js'] = '��棺';
$_LANG['from_goods_js'] = '��Ʒվ��JSͶ��';
$_LANG['from_self_site'] = '���Ա�վ';
$_LANG['from'] = '����վ�㣺';

/* ��ӡ��༭���� */
$_LANG['add_order'] = '��Ӷ���';
$_LANG['edit_order'] = '�༭����';
$_LANG['step']['user'] = '��ѡ����ҪΪ�ĸ���Ա�¶���';
$_LANG['step']['goods'] = 'ѡ����Ʒ';
$_LANG['step']['consignee'] = '�����ջ�����Ϣ';
$_LANG['step']['shipping'] = 'ѡ�����ͷ�ʽ';
$_LANG['step']['payment'] = 'ѡ��֧����ʽ';
$_LANG['step']['other'] = '����������Ϣ';
$_LANG['step']['money'] = '���÷���';
$_LANG['anonymous'] = '�����û�';
$_LANG['by_useridname'] = '����Ա��Ż��Ա������';
$_LANG['button_prev'] = '��һ��';
$_LANG['button_next'] = '��һ��';
$_LANG['button_finish'] = '���';
$_LANG['button_cancel'] = 'ȡ��';
$_LANG['name'] = '����';
$_LANG['desc'] = '����';
$_LANG['shipping_fee'] = '���ͷ�';
$_LANG['free_money'] = '��Ѷ��';
$_LANG['insure'] = '���۷�';
$_LANG['pay_fee'] = '������';
$_LANG['pack_fee'] = '��װ��';
$_LANG['card_fee'] = '�ؿ���';
$_LANG['no_pack'] = '��Ҫ��װ';
$_LANG['no_card'] = '��Ҫ�ؿ�';
$_LANG['add_to_order'] = '���붩��';
$_LANG['calc_order_amount'] = '���㶩�����';
$_LANG['available_surplus'] = '������';
$_LANG['available_integral'] = '���û��֣�';
$_LANG['available_bonus'] = '���ú����';
$_LANG['admin'] = '����Ա���';
$_LANG['search_goods'] = '����Ʒ��Ż���Ʒ���ƻ���Ʒ��������';
$_LANG['category'] = '����';
$_LANG['brand'] = 'Ʒ��';
$_LANG['user_money_not_enough'] = '�û�����';
$_LANG['pay_points_not_enough'] = '�û����ֲ���';
$_LANG['money_paid_enough'] = '�Ѹ��������Ʒ�ܽ��͸��ַ���֮�ͻ��࣬�����˿�';
$_LANG['price_note'] = '��ע����Ʒ�۸����Ѱ������ԼӼ�';
$_LANG['select_pack'] = 'ѡ���װ';
$_LANG['select_card'] = 'ѡ��ؿ�';
$_LANG['select_shipping'] = '����ѡ�����ͷ�ʽ';
$_LANG['want_insure'] = '��Ҫ����';
$_LANG['update_goods'] = '������Ʒ';
$_LANG['notice_user'] = '<strong>ע�⣺</strong>�������ֻ��ʾǰ20����¼�����û���ҵ���' .
        'Ӧ��Ա�������ȷ�ز��ҡ����⣬����û�Ա�Ǵ���̳ע�����û�����̳ǵ�¼����' .
        'Ҳ�޷��ҵ�����Ҫ�����̳ǵ�¼��';
$_LANG['amount_increase'] = '�������޸��˶��������¶����ܽ�����ӣ���Ҫ�ٴθ���';
$_LANG['amount_decrease'] = '�������޸��˶��������¶����ܽ����٣���Ҫ�˿�';
$_LANG['continue_shipping'] = '�������޸����ջ������ڵ���������ԭ�������ͷ�ʽ���ٿ��ã�������ѡ�����ͷ�ʽ';
$_LANG['continue_payment'] = '�������޸������ͷ�ʽ������ԭ����֧����ʽ���ٿ��ã�������ѡ�����ͷ�ʽ';
$_LANG['refund'] = '�˿�';
$_LANG['cannot_edit_order_shipped'] = '�������޸��ѷ����Ķ���';
$_LANG['address_list'] = '�������ջ���ַ��ѡ��';
$_LANG['order_amount_change'] = '�����ܽ���� %s ��Ϊ %s';
$_LANG['shipping_note'] = '˵������Ϊ�����ѷ������޸����ͷ�ʽ������ı����ͷѺͱ��۷ѡ�';
$_LANG['change_use_surplus'] = '�༭���� %s ���ı�ʹ��Ԥ����֧���Ľ��';
$_LANG['change_use_integral'] = '�༭���� %s ���ı�ʹ�û���֧��������';
$_LANG['return_order_surplus'] = '����ȡ������Ч���˻��������˻�֧������ %s ʱʹ�õ�Ԥ����';
$_LANG['return_order_integral'] = '����ȡ������Ч���˻��������˻�֧������ %s ʱʹ�õĻ���';
$_LANG['order_gift_integral'] = '���� %s ���͵Ļ���';
$_LANG['return_order_gift_integral'] = '�����˻���δ�����������˻ض��� %s ���͵Ļ���';
$_LANG['invoice_no_mall'] = '&nbsp;&nbsp;&nbsp;&nbsp;����������ţ�����Ӣ�Ķ��ţ���,����������';

$_LANG['js_languages']['input_price'] = '�Զ���۸�';
$_LANG['js_languages']['pls_search_user'] = '��������ѡ���Ա';
$_LANG['js_languages']['confirm_drop'] = 'ȷ��Ҫɾ������Ʒ��';
$_LANG['js_languages']['invalid_goods_number'] = '��Ʒ��������ȷ';
$_LANG['js_languages']['pls_search_goods'] = '��������ѡ����Ʒ';
$_LANG['js_languages']['pls_select_area'] = '������ѡ�����ڵ���';
$_LANG['js_languages']['pls_select_shipping'] = '��ѡ�����ͷ�ʽ';
$_LANG['js_languages']['pls_select_payment'] = '��ѡ��֧����ʽ';
$_LANG['js_languages']['pls_select_pack'] = '��ѡ���װ';
$_LANG['js_languages']['pls_select_card'] = '��ѡ��ؿ�';
$_LANG['js_languages']['pls_input_note'] = '������д��ע��';
$_LANG['js_languages']['pls_input_cancel'] = '������дȡ��ԭ��';
$_LANG['js_languages']['pls_select_refund'] = '��ѡ���˿ʽ��';
$_LANG['js_languages']['pls_select_agency'] = '��ѡ����´���';
$_LANG['js_languages']['pls_select_other_agency'] = '�ö������ھ�����������´�����ѡ���������´���';
$_LANG['js_languages']['loading'] = '������...';

/* �������� */
$_LANG['order_operate'] = '����������';
$_LANG['label_refund_amount'] = '�˿��';
$_LANG['label_handle_refund'] = '�˿ʽ��';
$_LANG['label_refund_note'] = '�˿�˵����';
$_LANG['return_user_money'] = '�˻��û����';
$_LANG['create_user_account'] = '�����˿�����';
$_LANG['not_handle'] = '�����������ʱѡ�����';

$_LANG['order_refund'] = '�����˿%s';
$_LANG['order_pay'] = '����֧����%s';

$_LANG['send_mail_fail'] = '�����ʼ�ʧ��';

$_LANG['send_message'] = '����/�鿴����';

/* ���������� */
$_LANG['delivery_operate'] = '������������';
$_LANG['delivery_sn_number'] = '��������ˮ�ţ�';
$_LANG['invoice_no_sms'] = '����д�������ţ�';

/* ���������� */
$_LANG['delivery_sn'] = '������';

/* ������״̬ */
$_LANG['delivery_status'][0] = '�ѷ���';
$_LANG['delivery_status'][1] = '�˻�';
$_LANG['delivery_status'][2] = '����';

/* ��������ǩ */
$_LANG['label_delivery_status'] = '������״̬';
$_LANG['label_suppliers_name'] = '������';
$_LANG['label_delivery_time'] = '����ʱ��';
$_LANG['label_delivery_sn'] = '��������ˮ��';
$_LANG['label_add_time'] = '�µ�ʱ��';
$_LANG['label_update_time'] = '����ʱ��';
$_LANG['label_send_number'] = '��������';

/* ��������ʾ */
$_LANG['tips_delivery_del'] = '������ɾ���ɹ���';

/* �˻������� */
$_LANG['back_operate'] = '�˻���������';

/* �˻�����ǩ */
$_LANG['return_time'] = '�˻�ʱ�䣺';
$_LANG['label_return_time'] = '�˻�ʱ��';

/* �˻�����ʾ */
$_LANG['tips_back_del'] = '�˻���ɾ���ɹ���';

$_LANG['goods_num_err'] = '��治�㣬������ѡ��';
?>