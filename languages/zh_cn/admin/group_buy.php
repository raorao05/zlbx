<?php

/**
 * ECSHOP ���������Ź���Ʒ�����ļ�
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: group_buy.php 17217 2011-01-19 06:29:08Z liubo $
*/

/* ��ǰҳ����⼰������������ */
$_LANG['group_buy_list'] = '�Ź���б�';
$_LANG['add_group_buy'] = '����Ź��';
$_LANG['edit_group_buy'] = '�༭�Ź��';

/* ��б�ҳ */
$_LANG['goods_name'] = '��Ʒ����';
$_LANG['start_date'] = '��ʼʱ��';
$_LANG['end_date'] = '����ʱ��';
$_LANG['deposit'] = '��֤��';
$_LANG['restrict_amount'] = '�޹�';
$_LANG['gift_integral'] = '���ͻ���';
$_LANG['valid_order'] = '����';
$_LANG['valid_goods'] = '������Ʒ';
$_LANG['current_price'] = '��ǰ�۸�';
$_LANG['current_status'] = '״̬';
$_LANG['view_order'] = '�鿴����';

/* ���/�༭�ҳ */
$_LANG['goods_cat'] = '��Ʒ����';
$_LANG['all_cat'] = '���з���';
$_LANG['goods_brand'] = '��ƷƷ��';
$_LANG['all_brand'] = '����Ʒ��';

$_LANG['label_goods_name'] = '�Ź���Ʒ��';
$_LANG['notice_goods_name'] = '����������Ʒ,�ڴ�����ѡ���б�...';
$_LANG['label_start_date'] = '���ʼʱ�䣺';
$_LANG['label_end_date'] = '�����ʱ�䣺';
$_LANG['notice_datetime'] = '�������գ�ʱ��';
$_LANG['label_deposit'] = '��֤��';
$_LANG['label_restrict_amount'] = '�޹�������';
$_LANG['notice_restrict_amount']= '�ﵽ���������Ź���Զ�������0��ʾû���������ơ�';
$_LANG['label_gift_integral'] = '���ͻ�������';
$_LANG['label_price_ladder'] = '�۸���ݣ�';
$_LANG['notice_ladder_amount'] = '�����ﵽ';
$_LANG['notice_ladder_price'] = '���ܼ۸�';
$_LANG['label_desc'] = '�˵����';
$_LANG['label_status'] = '���ǰ״̬��';
$_LANG['gbs'][GBS_PRE_START] = 'δ��ʼ';
$_LANG['gbs'][GBS_UNDER_WAY] = '������';
$_LANG['gbs'][GBS_FINISHED] = '����δ����';
$_LANG['gbs'][GBS_SUCCEED] = '�ɹ�����';
$_LANG['gbs'][GBS_FAIL] = 'ʧ�ܽ���';
$_LANG['label_order_qty'] = '������ / ��Ч��������';
$_LANG['label_goods_qty'] = '��Ʒ�� / ��Ч��Ʒ����';
$_LANG['label_cur_price'] = '��ǰ�ۣ�';
$_LANG['label_end_price'] = '���ռۣ�';
$_LANG['label_handler'] = '������';
$_LANG['error_group_buy'] = '��Ҫ�������Ź��������';
$_LANG['error_status'] = '��ǰ״̬����ִ�иò�����';
$_LANG['button_finish'] = '�����';
$_LANG['notice_finish'] = '���޸Ļ����ʱ��Ϊ��ǰʱ�䣩';
$_LANG['button_succeed'] = '��ɹ�';
$_LANG['notice_succeed'] = '�����¶����۸�';
$_LANG['button_fail'] = '�ʧ��';
$_LANG['notice_fail'] = '��ȡ����������֤���˻��ʻ���ʧ��ԭ�����д���˵���У�';
$_LANG['cancel_order_reason'] = '�Ź�ʧ��';
$_LANG['js_languages']['succeed_confirm'] = '�˲��������棬��ȷ��Ҫ���ø��Ź���ɹ���';
$_LANG['js_languages']['fail_confirm'] = '�˲��������棬��ȷ��Ҫ���ø��Ź��ʧ����';
$_LANG['button_mail'] = '�����ʼ�';
$_LANG['notice_mail'] = '��֪ͨ�ͻ��������Ա㷢����';
$_LANG['mail_result'] = '���Ź������ %s ����Ч�������ɹ������� %s ���ʼ���';
$_LANG['invalid_time'] = '��������һ����Ч���Ź�ʱ�䡣';

$_LANG['add_success'] = '����Ź���ɹ���';
$_LANG['edit_success'] = '�༭�Ź���ɹ���';
$_LANG['back_list'] = '�����Ź���б�';
$_LANG['continue_add'] = '��������Ź����';

/* ���/�༭��ύ */
$_LANG['error_goods_null'] = '��û��ѡ���Ź���Ʒ��';
$_LANG['error_goods_exist'] = '��ѡ�����ƷĿǰ��һ���Ź�����ڽ��У�';
$_LANG['error_price_ladder'] = '��û��������Ч�ļ۸���ݣ�';
$_LANG['error_restrict_amount'] = '�޹���������С�ڼ۸�����е��������';

$_LANG['js_languages']['error_goods_null'] = '��û��ѡ���Ź���Ʒ��';
$_LANG['js_languages']['error_deposit'] = '������ı�֤�������֣�';
$_LANG['js_languages']['error_restrict_amount'] = '��������޹���������������';
$_LANG['js_languages']['error_gift_integral'] = '����������ͻ���������������';
$_LANG['js_languages']['search_is_null'] = 'û���������κ���Ʒ������������';

/* ɾ���Ź�� */
$_LANG['js_languages']['batch_drop_confirm'] = '��ȷ��Ҫɾ��ѡ�����Ź����';
$_LANG['error_exist_order'] = '���Ź���Ѿ��ж���������ɾ����';
$_LANG['batch_drop_success'] = '�ɹ�ɾ���� %s ���Ź����¼���Ѿ��ж������Ź������ɾ������';
$_LANG['no_select_group_buy'] = '������û���Ź����¼��';

/* ������־ */
$_LANG['log_action']['group_buy'] = '�Ź���Ʒ';

?>