<?php

/**
 * ECSHOP ����������ɱ������ļ�
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: seckill.php 17217 2011-01-19 06:29:08Z liubo $
 */

/* menu */
$_LANG['seckill_list'] = '��ɱ��б�';
$_LANG['add_seckill'] = '�����ɱ�';
$_LANG['edit_seckill'] = '�༭��ɱ�';
$_LANG['seckill_log'] = '��ɱ����ۼ�¼';
$_LANG['continue_add_seckill'] = '���������ɱ�';
$_LANG['back_seckill_list'] = '������ɱ��б�';
$_LANG['add_seckill_ok'] = '�����ɱ��ɹ�';
$_LANG['edit_seckill_ok'] = '�༭��ɱ��ɹ�';
$_LANG['settle_deposit_ok'] = '������ı�֤��ɹ�';

/* list */
$_LANG['act_is_going'] = '����ʾ�����еĻ';
$_LANG['act_name'] = '��ɱ�����';
$_LANG['goods_name'] = '��Ʒ����';
$_LANG['start_time'] = '��ʼʱ��';
$_LANG['end_time'] = '����ʱ��';
$_LANG['deposit'] = '��֤��';
$_LANG['start_price'] = '���ļ�';
$_LANG['end_price'] = 'һ�ڼ�';
$_LANG['amplitude'] = '�Ӽ۷���';
$_LANG['seckill_not_exist'] = '��Ҫ��������ɱ�������';
$_LANG['seckill_cannot_remove'] = '����ɱ��Ѿ����˳��ۣ�����ɾ��';
$_LANG['js_languages']['batch_drop_confirm'] = '��ȷʵҪɾ��ѡ�е���ɱ���';
$_LANG['batch_drop_ok'] = '������ɣ��Ѿ����˳��۵���ɱ�����ɾ����';
$_LANG['no_record_selected'] = 'û��ѡ���¼';
$_LANG['label_goods_num']='��ɱ������';
/* info */
$_LANG['label_act_name'] = '��ɱ����ƣ�';
$_LANG['notice_act_name'] = '������գ�ȡ��ɱ��Ʒ�����ƣ������ƽ����ں�̨��ǰ̨������ʾ��';
$_LANG['label_act_desc'] = '��ɱ�������';
$_LANG['label_search_goods'] = '������Ʒ��š����ƻ����������Ʒ';
$_LANG['label_goods_name'] = '��ɱ��Ʒ���ƣ�';
$_LANG['label_start_time'] = '��ɱ��ʼʱ�䣺';
$_LANG['label_end_time'] = '��ɱ����ʱ�䣺';
$_LANG['label_status'] = '��ǰ״̬��';
$_LANG['label_start_price'] = '���ļۣ�';
$_LANG['label_end_price'] = 'һ�ڼۣ�';
$_LANG['label_no_top'] = '�޷ⶥ';
$_LANG['label_amplitude'] = '�Ӽ۷��ȣ�';
$_LANG['label_deposit'] = '��֤��';
$_LANG['bid_user_count'] = '���� %s ����ҳ���';
$_LANG['settle_frozen_money'] = '����������ҵĶ����ʽ�';
$_LANG['unfreeze'] = '�ⶳ��֤��';
$_LANG['deduct'] = '�۳���֤��';
$_LANG['invalid_status'] = '��ǰ״̬����ȷ';
$_LANG['no_deposit'] = 'û�б�֤����Ҫ����';
$_LANG['unfreeze_seckill_deposit'] = '�ⶳ��ɱ��ı�֤��%s';
$_LANG['deduct_seckill_deposit'] = '�۳���ɱ��ı�֤��%s';

$_LANG['seckill_status'][PRE_START] = 'δ��ʼ';
$_LANG['seckill_status'][UNDER_WAY] = '������';
$_LANG['seckill_status'][FINISHED] = '�ѽ���';
$_LANG['seckill_status'][SETTLED] = '�ѽ���';

$_LANG['pls_search_goods'] = '����������Ʒ';
$_LANG['search_result_empty'] = 'û���ҵ���Ʒ������������';

$_LANG['pls_select_goods'] = '��ѡ����ɱ��Ʒ';
$_LANG['goods_not_exist'] = '��Ҫ��ɱ����Ʒ������';

$_LANG['js_languages']['start_price_not_number'] = '���ļ۸�ʽ����ȷ�����֣�';
$_LANG['js_languages']['end_price_not_number'] = 'һ�ڼ۸�ʽ����ȷ�����֣�';
$_LANG['js_languages']['end_gt_start'] = 'һ�ڼ�Ӧ�ô������ļ�';
$_LANG['js_languages']['amplitude_not_number'] = '�Ӽ۷��ȸ�ʽ����ȷ�����֣�';
$_LANG['js_languages']['deposit_not_number'] = '��֤���ʽ����ȷ�����֣�';
$_LANG['js_languages']['start_lt_end'] = '��ɱ��ʼʱ�䲻�ܴ��ڽ���ʱ��';
$_LANG['js_languages']['search_is_null'] = 'û���������κ���Ʒ������������';

/* log */
$_LANG['bid_user'] = '���';
$_LANG['bid_price'] = '����';
$_LANG['bid_time'] = 'ʱ��';
$_LANG['status'] = '״̬';

?>