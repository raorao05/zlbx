<?php

/**
 * ECSHOP ӆ�ι����Z���ļ�
 * ============================================================================
 * ������� 2005-2011 �Ϻ����ɾW�j�Ƽ����޹�˾���K�������Й�����
 * �Wվ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �@����һ������ܛ������ֻ���ڲ�����̘IĿ�ĵ�ǰ����������a�M���޸ĺ�
 * ʹ�ã������S��������a���κ���ʽ�κ�Ŀ�ĵ��ٰl�ѡ�
 * ============================================================================
 * $Author: liubo $
 * $Id: order.php 17217 2011-01-19 06:29:08Z liubo $
 */

/* ӆ������ */
$_LANG['order_sn'] = 'ӆ��̖';
$_LANG['consignee'] = '��؛��';
$_LANG['all_status'] = 'ӆ�Π�B';

$_LANG['cs'][OS_UNCONFIRMED] = '���_�J';
$_LANG['cs'][CS_AWAIT_PAY] = '������';
$_LANG['cs'][CS_AWAIT_SHIP] = '���l؛';
$_LANG['cs'][CS_FINISHED] = '�����';
$_LANG['cs'][PS_PAYING] = '������';
$_LANG['cs'][OS_CANCELED] = 'ȡ��';
$_LANG['cs'][OS_INVALID] = '�oЧ';
$_LANG['cs'][OS_RETURNED] = '��؛';
$_LANG['cs'][OS_SHIPPED_PART] = '���ְl؛';

/* ӆ�Π�B */
$_LANG['os'][OS_UNCONFIRMED] = 'δ�_�J';
$_LANG['os'][OS_CONFIRMED] = '�Ѵ_�J';
$_LANG['os'][OS_CANCELED] = 'ȡ��';
$_LANG['os'][OS_INVALID] = '�oЧ';
$_LANG['os'][OS_RETURNED] = '��؛';
$_LANG['os'][OS_SPLITED] = '�ѷֆ�';
$_LANG['os'][OS_SPLITING_PART] = '���ַֆ�';

$_LANG['ss'][SS_UNSHIPPED] = 'δ�l؛';
$_LANG['ss'][SS_PREPARING] = '��؛��';
$_LANG['ss'][SS_SHIPPED] = '�Ѱl؛';
$_LANG['ss'][SS_RECEIVED] = '��؛�_�J';
$_LANG['ss'][SS_SHIPPED_PART] = '�Ѱl؛��������Ʒ��';
$_LANG['ss'][SS_SHIPPED_ING] = 'δ�l؛';// �l؛��

$_LANG['ps'][PS_UNPAYED] = 'δ����';
$_LANG['ps'][PS_PAYING] = '������';
$_LANG['ps'][PS_PAYED] = '�Ѹ���';

$_LANG['ss_admin'][SS_SHIPPED_ING] = '�l؛�У�ǰ�_��B��δ�l؛��';
/* ӆ�β��� */
$_LANG['label_operable_act'] = '��ǰ�Ɉ��в�����';
$_LANG['label_action_note'] = '�������]��';
$_LANG['label_invoice_note'] = '�l؛���]��';
$_LANG['label_invoice_no'] = '�l؛��̖��';
$_LANG['label_cancel_note'] = 'ȡ��ԭ��';
$_LANG['notice_cancel_note'] = '����ӛ����̼ҽo�͑��������У�';
$_LANG['op_confirm'] = '�_�J';
$_LANG['op_pay'] = '����';
$_LANG['op_prepare'] = '��؛';
$_LANG['op_ship'] = '�l؛';
$_LANG['op_cancel'] = 'ȡ��';
$_LANG['op_invalid'] = '�oЧ';
$_LANG['op_return'] = '��؛';
$_LANG['op_unpay'] = '�O��δ����';
$_LANG['op_unship'] = 'δ�l؛';
$_LANG['op_receive'] = '����؛';
$_LANG['op_cancel_ship'] = 'ȡ���l؛';
$_LANG['op_assign'] = 'ָ�ɽo';
$_LANG['op_after_service'] = '����';
$_LANG['act_ok'] = '�����ɹ�';
$_LANG['act_false'] = '����ʧ��';
$_LANG['act_ship_num'] = '�ˆΰl؛�������ܳ���ӆ����Ʒ����';
$_LANG['act_good_vacancy'] = '��Ʒ��ȱ؛';
$_LANG['act_good_delivery'] = '؛�Ѱl��';
$_LANG['notice_gb_ship'] = '���]���Fُ���δ̎���ɹ�ǰ�����ܰl؛';
$_LANG['back_list'] = '����ӆ���б�';
$_LANG['op_remove'] = '�h��';
$_LANG['op_you_can'] = '�����M�еĲ���';
$_LANG['op_split'] = '�ֆ�';
$_LANG['op_to_delivery'] = 'ȥ�l؛';

/* ӆ���б� */
$_LANG['order_amount'] = '�������~';
$_LANG['total_fee'] = '�����~';
$_LANG['shipping_name'] = '���ͷ�ʽ';
$_LANG['pay_name'] = '֧����ʽ';
$_LANG['address'] = '��ַ';
$_LANG['order_time'] = '�Εr�g';
$_LANG['detail'] = '�鿴';
$_LANG['phone'] = '�Ԓ';
$_LANG['group_buy'] = '���Fُ��';
$_LANG['error_get_goods_info'] = '�@ȡӆ����Ʒ��Ϣ�e�`';
$_LANG['exchange_goods'] = '���e�փ��Q��';

$_LANG['js_languages']['remove_confirm'] = '�h��ӆ�Ό����ԓӆ�ε�������Ϣ�����_��Ҫ�@�N���᣿';

/* ӆ������ */
$_LANG['label_order_sn'] = 'ӆ��̖��';
$_LANG['label_all_status'] = 'ӆ�Π�B��';
$_LANG['label_user_name'] = 'ُ؛�ˣ�';
$_LANG['label_consignee'] = '��؛�ˣ�';
$_LANG['label_email'] = '����]����';
$_LANG['label_address'] = '��ַ��';
$_LANG['label_zipcode'] = '�]����';
$_LANG['label_tel'] = '�Ԓ��';
$_LANG['label_mobile'] = '�֙C��';
$_LANG['label_shipping'] = '���ͷ�ʽ��';
$_LANG['label_payment'] = '֧����ʽ��';
$_LANG['label_order_status'] = 'ӆ�Π�B��';
$_LANG['label_pay_status'] = '�����B��';
$_LANG['label_shipping_status'] = '�l؛��B��';
$_LANG['label_area'] = '���ڵ؅^��';
$_LANG['label_time'] = '�Εr�g��';

/* ӆ��Ԕ�� */
$_LANG['prev'] = 'ǰһ��ӆ��';
$_LANG['next'] = '��һ��ӆ��';
$_LANG['print_order'] = '��ӡӆ��';
$_LANG['print_shipping'] = '��ӡ���f��';
$_LANG['print_order_sn'] = 'ӆ�ξ�̖��';
$_LANG['print_buy_name'] = 'ُ ؛ �ˣ�';
$_LANG['label_consignee_address'] = '��؛��ַ��';
$_LANG['no_print_shipping'] = '�ܱ�Ǹ,Ŀǰ��߀�]���O�ô�ӡ���f��ģ��.�����M�д�ӡ';
$_LANG['suppliers_no'] = '��ָ����؛�̱�������̎��';
$_LANG['restaurant'] = '����';

$_LANG['order_info'] = 'ӆ����Ϣ';
$_LANG['base_info'] = '������Ϣ';
$_LANG['other_info'] = '������Ϣ';
$_LANG['consignee_info'] = '��؛����Ϣ';
$_LANG['fee_info'] = '�M����Ϣ';
$_LANG['action_info'] = '������Ϣ';
$_LANG['shipping_info'] = '������Ϣ';

$_LANG['label_how_oos'] = 'ȱ؛̎��';
$_LANG['label_how_surplus'] = '�N�~̎��';
$_LANG['label_pack'] = '���b��';
$_LANG['label_card'] = '�R����';
$_LANG['label_card_message'] = '�R��ף���Z��';
$_LANG['label_order_time'] = '�Εr�g��';
$_LANG['label_pay_time'] = '����r�g��';
$_LANG['label_shipping_time'] = '�l؛�r�g��';
$_LANG['label_sign_building'] = '���I�Խ��B��';
$_LANG['label_best_time'] = '�����؛�r�g��';
$_LANG['label_inv_type'] = '�lƱ��ͣ�';
$_LANG['label_inv_payee'] = '�lƱ̧�^��';
$_LANG['label_inv_content'] = '�lƱ���ݣ�';
$_LANG['label_postscript'] = '�͑��o�̼ҵ����ԣ�';
$_LANG['label_region'] = '���ڵ؅^��';

$_LANG['label_shop_url'] = '�Wַ��';
$_LANG['label_shop_address'] = '��ַ��';
$_LANG['label_service_phone'] = '�Ԓ��';
$_LANG['label_print_time'] = '��ӡ�r�g��';

$_LANG['label_suppliers'] = '�x��؛�̣�';
$_LANG['label_agency'] = '�k��̎��';
$_LANG['suppliers_name'] = '��؛��';

$_LANG['product_sn'] = '؛Ʒ̖';
$_LANG['goods_info'] = '��Ʒ��Ϣ';
$_LANG['goods_name'] = '��Ʒ���Q';
$_LANG['goods_name_brand'] = '��Ʒ���Q [ Ʒ�� ]';
$_LANG['goods_sn'] = '؛̖';
$_LANG['goods_price'] = '�r��';
$_LANG['goods_number'] = '����';
$_LANG['goods_attr'] = '����';
$_LANG['goods_delivery'] = 'һ�l؛����';
$_LANG['goods_delivery_curr'] = '�ˆΰl؛����';
$_LANG['storage'] = '���';
$_LANG['subtotal'] = 'СӋ';
$_LANG['label_total'] = '��Ӌ��';
$_LANG['label_total_weight'] = '��Ʒ��������';

$_LANG['label_goods_amount'] = '��Ʒ�����~��';
$_LANG['label_discount'] = '�ۿۣ�';
$_LANG['label_tax'] = '�lƱ���~��';
$_LANG['label_shipping_fee'] = '�����M�ã�';
$_LANG['label_insure_fee'] = '���r�M�ã�';
$_LANG['label_insure_yn'] = '�Ƿ񱣃r��';
$_LANG['label_pay_fee'] = '֧���M�ã�';
$_LANG['label_pack_fee'] = '���b�M�ã�';
$_LANG['label_card_fee'] = '�R���M�ã�';
$_LANG['label_money_paid'] = '�Ѹ�����~��';
$_LANG['label_surplus'] = 'ʹ���N�~��';
$_LANG['label_integral'] = 'ʹ�÷e�֣�';
$_LANG['label_bonus'] = 'ʹ�üt����';
$_LANG['label_order_amount'] = 'ӆ�ο����~��';
$_LANG['label_money_dues'] = '��������~��';
$_LANG['label_money_refund'] = '���˿���~��';
$_LANG['label_to_buyer'] = '�̼ҽo�͑������ԣ�';
$_LANG['save_order'] = '����ӆ��';
$_LANG['notice_gb_order_amount'] = '�����]���Fُ����б��C�𣬵�һ��ֻ��֧�����C���������֧���M�ã�';

$_LANG['action_user'] = '�����ߣ�';
$_LANG['action_time'] = '�����r�g';
$_LANG['order_status'] = 'ӆ�Π�B';
$_LANG['pay_status'] = '�����B';
$_LANG['shipping_status'] = '�l؛��B';
$_LANG['action_note'] = '���]';
$_LANG['pay_note'] = '֧�����]��';

$_LANG['sms_time_format'] = 'm��j��G�r';
$_LANG['order_shipped_sms'] = '����ӆ��%s���%s�l؛ [%s]';
$_LANG['order_splited_sms'] = '����ӆ��%s,%s����%s [%s]';
$_LANG['order_removed'] = 'ӆ�΄h���ɹ���';
$_LANG['return_list'] = '����ӆ���б�';

/* ӆ��̎����ʾ */
$_LANG['surplus_not_enough'] = 'ԓӆ��ʹ�� %s �N�~֧�����F���Ñ��N�~����';
$_LANG['integral_not_enough'] = 'ԓӆ��ʹ�� %s �e��֧�����F���Ñ��e�ֲ���';
$_LANG['bonus_not_available'] = 'ԓӆ��ʹ�üt��֧�����F�ڼt��������';

/* ُ؛����Ϣ */
$_LANG['display_buyer'] = '�@ʾُ؛����Ϣ';
$_LANG['buyer_info'] = 'ُ؛����Ϣ';
$_LANG['pay_points'] = '���M�e��';
$_LANG['rank_points'] = '�ȼ��e��';
$_LANG['user_money'] = '�~���N�~';
$_LANG['email'] = '����]��';
$_LANG['rank_name'] = '���T�ȼ�';
$_LANG['bonus_count'] = '�t������';
$_LANG['zipcode'] = '�]��';
$_LANG['tel'] = '�Ԓ';
$_LANG['mobile'] = '�����Ԓ';

/* �ρ�ӆ�� */
$_LANG['order_sn_not_null'] = 'Ո�Ҫ�ρ��ӆ��̖';
$_LANG['two_order_sn_same'] = 'Ҫ�ρ�ăɂ�ӆ��̖������ͬ';
$_LANG['order_not_exist'] = '���� %s ������';
$_LANG['os_not_unconfirmed_or_confirmed'] = '%s ��ӆ�Π�B���ǡ�δ�_�J�����Ѵ_�J��';
$_LANG['ps_not_unpayed'] = 'ӆ�� %s �ĸ����B���ǡ�δ���';
$_LANG['ss_not_unshipped'] = 'ӆ�� %s �İl؛��B���ǡ�δ�l؛��';
$_LANG['order_user_not_same'] = 'Ҫ�ρ�ăɂ�ӆ�β���ͬһ���Ñ��µ�';
$_LANG['merge_invalid_order'] = '���������x��ρ��ӆ�β����S�M�кρ�Ĳ�����';

$_LANG['from_order_sn'] = '��ӆ�Σ�';
$_LANG['to_order_sn'] = '��ӆ�Σ�';
$_LANG['merge'] = '�ρ�';
$_LANG['notice_order_sn'] = '���ɂ�ӆ�β�һ�r���ρ����ӆ����Ϣ���磺֧����ʽ�����ͷ�ʽ�����b���R�����t���ȣ�����ӆ�Ξ�ʡ�';
$_LANG['js_languages']['confirm_merge'] = '���_��Ҫ�ρ��@�ɂ�ӆ�Ά᣿';

/* ��̎�� */
$_LANG['pls_select_order'] = 'Ո�x����Ҫ������ӆ��';
$_LANG['no_fulfilled_order'] = '�]�НM������l����ӆ�Ρ�';
$_LANG['updated_order'] = '���µ�ӆ�Σ�';
$_LANG['order'] = 'ӆ�Σ�';
$_LANG['confirm_order'] = '����ӆ�Οo���O�Þ�_�J��B';
$_LANG['invalid_order'] = '����ӆ�Οo���O�Þ�oЧ';
$_LANG['cancel_order'] = '����ӆ�Οo��ȡ��';
$_LANG['remove_order'] = '����ӆ�Οo�����Ƴ�';

/* ��݋ӆ�δ�ӡģ�� */
$_LANG['edit_order_templates'] = '��݋ӆ�δ�ӡģ��';
$_LANG['template_resetore'] = '߀ԭģ��';
$_LANG['edit_template_success'] = '��݋ӆ�δ�ӡģ������ɹ�!';
$_LANG['remark_fittings'] = '�������';
$_LANG['remark_gift'] = '��ٛƷ��';
$_LANG['remark_favourable'] = '���ػ�Ʒ��';
$_LANG['remark_package'] = '���Y����';

/* ӆ�΁�Դ�yӋ */
$_LANG['from_order'] = 'ӆ�΁�Դ��';
$_LANG['from_ad_js'] = '�V�棺';
$_LANG['from_goods_js'] = '��Ʒվ��JSͶ��';
$_LANG['from_self_site'] = '���Ա�վ';
$_LANG['from'] = '����վ�c��';

/* ��ӡ���݋ӆ�� */
$_LANG['add_order'] = '���ӆ��';
$_LANG['edit_order'] = '��݋ӆ��';
$_LANG['step']['user'] = 'Ո�x����Ҫ���Ă����T��ӆ��';
$_LANG['step']['goods'] = '�x����Ʒ';
$_LANG['step']['consignee'] = '�O����؛����Ϣ';
$_LANG['step']['shipping'] = '�x�����ͷ�ʽ';
$_LANG['step']['payment'] = '�x��֧����ʽ';
$_LANG['step']['other'] = '�O��������Ϣ';
$_LANG['step']['money'] = '�O���M��';
$_LANG['anonymous'] = '�����Ñ�';
$_LANG['by_useridname'] = '�����T��̖����T������';
$_LANG['button_prev'] = '��һ��';
$_LANG['button_next'] = '��һ��';
$_LANG['button_finish'] = '���';
$_LANG['button_cancel'] = 'ȡ��';
$_LANG['name'] = '���Q';
$_LANG['desc'] = '����';
$_LANG['shipping_fee'] = '�����M';
$_LANG['free_money'] = '���M�~��';
$_LANG['insure'] = '���r�M';
$_LANG['pay_fee'] = '���m�M';
$_LANG['pack_fee'] = '���b�M';
$_LANG['card_fee'] = '�R���M';
$_LANG['no_pack'] = '��Ҫ���b';
$_LANG['no_card'] = '��Ҫ�R��';
$_LANG['add_to_order'] = '����ӆ��';
$_LANG['calc_order_amount'] = 'Ӌ��ӆ�ν��~';
$_LANG['available_surplus'] = '�����N�~��';
$_LANG['available_integral'] = '���÷e�֣�';
$_LANG['available_bonus'] = '���üt����';
$_LANG['admin'] = '����T���';
$_LANG['search_goods'] = '����Ʒ��̖����Ʒ���Q����Ʒ؛̖����';
$_LANG['category'] = '���';
$_LANG['brand'] = 'Ʒ��';
$_LANG['user_money_not_enough'] = '�Ñ��N�~����';
$_LANG['pay_points_not_enough'] = '�Ñ��e�ֲ���';
$_LANG['money_paid_enough'] = '�Ѹ�����~����Ʒ�����~�͸��N�M��֮��߀�࣬Ո���˿�';
$_LANG['price_note'] = '���]����Ʒ�r�����Ѱ������ԼӃr';
$_LANG['select_pack'] = '�x����b';
$_LANG['select_card'] = '�x���R��';
$_LANG['select_shipping'] = 'Ո���x�����ͷ�ʽ';
$_LANG['want_insure'] = '��Ҫ���r';
$_LANG['update_goods'] = '������Ʒ';
$_LANG['notice_user'] = '<strong>ע�⣺</strong>�����Y��ֻ�@ʾǰ20�lӛ䛣�����]���ҵ���' .
        '�����T��Ո�����_�ز��ҡ����⣬���ԓ���T�Ǐ�Փ���]�Ե��қ]�����̳ǵ���^��' .
        'Ҳ�o���ҵ�����Ҫ�����̳ǵ�䛡�';
$_LANG['amount_increase'] = '������޸���ӆ�Σ�����ӆ�ο����~���ӣ���Ҫ�ٴθ���';
$_LANG['amount_decrease'] = '������޸���ӆ�Σ�����ӆ�ο����~�p�٣���Ҫ�˿�';
$_LANG['continue_shipping'] = '������޸�����؛�����ڵ؅^������ԭ������ͷ�ʽ���ٿ��ã�Ո�����x�����ͷ�ʽ';
$_LANG['continue_payment'] = '������޸������ͷ�ʽ������ԭ���֧����ʽ���ٿ��ã�Ո�����x�����ͷ�ʽ';
$_LANG['refund'] = '�˿�';
$_LANG['cannot_edit_order_shipped'] = '�������޸��Ѱl؛��ӆ��';
$_LANG['address_list'] = '��������؛��ַ���x��';
$_LANG['order_amount_change'] = 'ӆ�ο����~�� %s ׃�� %s';
$_LANG['shipping_note'] = '�f�������ӆ���Ѱl؛���޸����ͷ�ʽ��������׃�����M�ͱ��r�M��';
$_LANG['change_use_surplus'] = '��݋ӆ�� %s ����׃ʹ���A����֧���Ľ��~';
$_LANG['change_use_integral'] = '��݋ӆ�� %s ����׃ʹ�÷e��֧���Ĕ���';
$_LANG['return_order_surplus'] = '���ȡ�����oЧ����؛�������˻�֧��ӆ�� %s �rʹ�õ��A����';
$_LANG['return_order_integral'] = '���ȡ�����oЧ����؛�������˻�֧��ӆ�� %s �rʹ�õķe��';
$_LANG['order_gift_integral'] = 'ӆ�� %s ٛ�͵ķe��';
$_LANG['return_order_gift_integral'] = '�����؛��δ�l؛�������˻�ӆ�� %s ٛ�͵ķe��';
$_LANG['invoice_no_mall'] = '&nbsp;&nbsp;&nbsp;&nbsp;�����l؛��̖��Ո��Ӣ�Ķ�̖����,�������_��';

$_LANG['js_languages']['input_price'] = '�Զ��x�r��';
$_LANG['js_languages']['pls_search_user'] = 'Ո�����K�x����T';
$_LANG['js_languages']['confirm_drop'] = '�_�JҪ�h��ԓ��Ʒ�᣿';
$_LANG['js_languages']['invalid_goods_number'] = '��Ʒ���������_';
$_LANG['js_languages']['pls_search_goods'] = 'Ո�����K�x����Ʒ';
$_LANG['js_languages']['pls_select_area'] = 'Ո�����x�����ڵ؅^';
$_LANG['js_languages']['pls_select_shipping'] = 'Ո�x�����ͷ�ʽ';
$_LANG['js_languages']['pls_select_payment'] = 'Ո�x��֧����ʽ';
$_LANG['js_languages']['pls_select_pack'] = 'Ո�x����b';
$_LANG['js_languages']['pls_select_card'] = 'Ո�x���R��';
$_LANG['js_languages']['pls_input_note'] = 'Ո������]��';
$_LANG['js_languages']['pls_input_cancel'] = 'Ո���ȡ��ԭ��';
$_LANG['js_languages']['pls_select_refund'] = 'Ո�x���˿ʽ��';
$_LANG['js_languages']['pls_select_agency'] = 'Ո�x���k��̎��';
$_LANG['js_languages']['pls_select_other_agency'] = 'ԓӆ�άF�ھ͌���@���k��̎��Ո�x�������k��̎��';
$_LANG['js_languages']['loading'] = '���d��...';

/* ӆ�β��� */
$_LANG['order_operate'] = 'ӆ�β�����';
$_LANG['label_refund_amount'] = '�˿���~��';
$_LANG['label_handle_refund'] = '�˿ʽ��';
$_LANG['label_refund_note'] = '�˿��f����';
$_LANG['return_user_money'] = '�˻��Ñ��N�~';
$_LANG['create_user_account'] = '�����˿���Ո';
$_LANG['not_handle'] = '��̎���`�����r�x����';

$_LANG['order_refund'] = 'ӆ���˿%s';
$_LANG['order_pay'] = 'ӆ��֧����%s';

$_LANG['send_mail_fail'] = '�l���]��ʧ��';

$_LANG['send_message'] = '�l��/�鿴����';

/* �l؛�β��� */
$_LANG['delivery_operate'] = '�l؛�β�����';
$_LANG['delivery_sn_number'] = '��������ˮ�ţ�';
$_LANG['invoice_no_sms'] = '����д�������ã�';

/* �l؛������ */
$_LANG['delivery_sn'] = '�l؛��';

/* �l؛�Π�B */
$_LANG['delivery_status'][0] = '����';
$_LANG['delivery_status'][1] = '��؛';
$_LANG['delivery_status'][2] = '�Ѱl؛';

/* �l؛�Θ˺� */
$_LANG['label_delivery_status'] = '�l؛�Π�B';
$_LANG['label_delivery_time'] = '���ɕr�g';
$_LANG['label_delivery_sn'] = '�l؛����ˮ̖';
$_LANG['label_add_time'] = '�Εr�g';
$_LANG['label_update_time'] = '�l؛�Εr�g';
$_LANG['label_send_number'] = '�l؛�Δ���';

/* �l؛����ʾ */
$_LANG['tips_delivery_del'] = '�l؛�΄h���ɹ���';

/* ��؛�β��� */
$_LANG['back_operate'] = '��؛��������';

/* ��؛�Θ˺� */
$_LANG['return_time'] = '��؛�r�g��';
$_LANG['label_return_time'] = '��؛�r�g';

/* ��؛����ʾ */
$_LANG['tips_back_del'] = '��؛�΄h���ɹ���';

$_LANG['goods_num_err'] = '��治�㣬Ո�����x��';
?>