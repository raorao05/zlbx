<?php

/**
 * ECSHOP �������ĈFُ��Ʒ�Z���ļ�
 * ============================================================================
 * ������� 2005-2011 �Ϻ����ɾW�j�Ƽ����޹�˾���K�������Й�����
 * �Wվ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �@����һ������ܛ������ֻ���ڲ�����̘IĿ�ĵ�ǰ����������a�M���޸ĺ�
 * ʹ�ã������S��������a���κ���ʽ�κ�Ŀ�ĵ��ٰl�ѡ�
 * ============================================================================
 * $Author: liubo $
 * $Id: group_buy.php 17217 2011-01-19 06:29:08Z liubo $
*/

/* ��ǰ�����}������朽����Q */
$_LANG['group_buy_list'] = '�Fُ����б�';
$_LANG['add_group_buy'] = '��ӈFُ���';
$_LANG['edit_group_buy'] = '��݋�Fُ���';

/* ����б�� */
$_LANG['goods_name'] = '��Ʒ���Q';
$_LANG['start_date'] = '�_ʼ�r�g';
$_LANG['end_date'] = '�Y���r�g';
$_LANG['deposit'] = '���C��';
$_LANG['restrict_amount'] = '��ُ';
$_LANG['gift_integral'] = 'ٛ�ͷe��';
$_LANG['valid_order'] = 'ӆ��';
$_LANG['valid_goods'] = 'ӆُ��Ʒ';
$_LANG['current_price'] = '��ǰ�r��';
$_LANG['current_status'] = '��B';
$_LANG['view_order'] = '�鿴ӆ��';

/* ���/��݋���� */
$_LANG['goods_cat'] = '��Ʒ���';
$_LANG['all_cat'] = '���з��';
$_LANG['goods_brand'] = '��ƷƷ��';
$_LANG['all_brand'] = '����Ʒ��';

$_LANG['label_goods_name'] = '�Fُ��Ʒ��';
$_LANG['notice_goods_name'] = 'Ո��������Ʒ,�ڴ������x��б�...';
$_LANG['label_start_date'] = '����_ʼ�r�g��';
$_LANG['label_end_date'] = '��ӽY���r�g��';
$_LANG['notice_datetime'] = '�������գ��r��';
$_LANG['label_deposit'] = '���C��';
$_LANG['label_restrict_amount'] = '��ُ������';
$_LANG['notice_restrict_amount']= '�_���˔������Fُ����ԄӽY����0��ʾ�]�Д������ơ�';
$_LANG['label_gift_integral'] = 'ٛ�ͷe�֔���';
$_LANG['label_price_ladder'] = '�r���A�ݣ�';
$_LANG['notice_ladder_amount'] = '�����_��';
$_LANG['notice_ladder_price'] = '���܃r��';
$_LANG['label_desc'] = '����f����';
$_LANG['label_status'] = '��Ӯ�ǰ��B��';
$_LANG['gbs'][GBS_PRE_START] = 'δ�_ʼ';
$_LANG['gbs'][GBS_UNDER_WAY] = '�M����';
$_LANG['gbs'][GBS_FINISHED] = '�Y��δ̎��';
$_LANG['gbs'][GBS_SUCCEED] = '�ɹ��Y��';
$_LANG['gbs'][GBS_FAIL] = 'ʧ���Y��';
$_LANG['label_order_qty'] = 'ӆ�Δ� / ��Чӆ�Δ���';
$_LANG['label_goods_qty'] = '��Ʒ�� / ��Ч��Ʒ����';
$_LANG['label_cur_price'] = '��ǰ�r��';
$_LANG['label_end_price'] = '��K�r��';
$_LANG['label_handler'] = '������';
$_LANG['error_group_buy'] = '��Ҫ�����ĈFُ��Ӳ�����';
$_LANG['error_status'] = '��ǰ��B���܈���ԓ������';
$_LANG['button_finish'] = '�Y�����';
$_LANG['notice_finish'] = '���޸Ļ�ӽY���r�g�鮔ǰ�r�g��';
$_LANG['button_succeed'] = '��ӳɹ�';
$_LANG['notice_succeed'] = '������ӆ�΃r��';
$_LANG['button_fail'] = '���ʧ��';
$_LANG['notice_fail'] = '��ȡ��ӆ�Σ����C���˻؎����N�~��ʧ��ԭ����Ԍ�������f���У�';
$_LANG['cancel_order_reason'] = '�Fُʧ��';
$_LANG['js_languages']['succeed_confirm'] = '�˲��������棬���_��Ҫ�O��ԓ�Fُ��ӳɹ��᣿';
$_LANG['js_languages']['fail_confirm'] = '�˲��������棬���_��Ҫ�O��ԓ�Fُ���ʧ���᣿';
$_LANG['button_mail'] = '�l���]��';
$_LANG['notice_mail'] = '��֪ͨ�͑������N��Ա�l؛��';
$_LANG['mail_result'] = 'ԓ�Fُ��ӹ��� %s ����Чӆ�Σ��ɹ��l���� %s ���]����';
$_LANG['invalid_time'] = '��ݔ����һ���oЧ�ĈFُ�r�g��';

$_LANG['add_success'] = '��ӈFُ��ӳɹ���';
$_LANG['edit_success'] = '��݋�Fُ��ӳɹ���';
$_LANG['back_list'] = '���؈Fُ����б�';
$_LANG['continue_add'] = '�^�m��ӈFُ��ӡ�';

/* ���/��݋����ύ */
$_LANG['error_goods_null'] = '���]���x��Fُ��Ʒ��';
$_LANG['error_goods_exist'] = '���x�����ƷĿǰ��һ���Fُ��������M�У�';
$_LANG['error_price_ladder'] = '���]��ݔ����Ч�ăr���A�ݣ�';
$_LANG['error_restrict_amount'] = '��ُ��������С춃r���A���е������';

$_LANG['js_languages']['error_goods_null'] = '���]���x��Fُ��Ʒ��';
$_LANG['js_languages']['error_deposit'] = '��ݔ��ı��C���ǔ��֣�';
$_LANG['js_languages']['error_restrict_amount'] = '��ݔ�����ُ��������������';
$_LANG['js_languages']['error_gift_integral'] = '��ݔ���ٛ�ͷe�֔�����������';
$_LANG['js_languages']['search_is_null'] = '�]���������κ���Ʒ��Ո��������';

/* �h���Fُ��� */
$_LANG['js_languages']['batch_drop_confirm'] = '���_��Ҫ�h���x���ĈFُ��ӆ᣿';
$_LANG['error_exist_order'] = 'ԓ�Fُ����ѽ���ӆ�Σ����܄h����';
$_LANG['batch_drop_success'] = '�ɹ��h���� %s �l�Fُ���ӛ䛣��ѽ���ӆ�εĈFُ��Ӳ��܄h������';
$_LANG['no_select_group_buy'] = '���F�ڛ]�ЈFُ���ӛ䛣�';

/* �������I */
$_LANG['log_action']['group_buy'] = '�Fُ��Ʒ';

?>