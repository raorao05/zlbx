<?php

/**
 * ECSHOP �������/����������
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: bonus.php 17217 2011-01-19 06:29:08Z liubo $
*/
/* ��������ֶ���Ϣ */
$_LANG['bonus_type'] = '�������';
$_LANG['bonus_list'] = '����б�';
$_LANG['type_name'] = '��������';
$_LANG['type_money'] = '������';
$_LANG['min_goods_amount'] = '��С�������';
$_LANG['notice_min_goods_amount'] = 'ֻ����Ʒ�ܽ��ﵽ������Ķ�������ʹ�����ֺ��';
$_LANG['min_amount'] = '��������';
$_LANG['max_amount'] = '��������';
$_LANG['send_startdate'] = '������ʼ����';
$_LANG['send_enddate'] = '���Ž�������';

$_LANG['use_startdate'] = 'ʹ����ʼ����';
$_LANG['use_enddate'] = 'ʹ�ý�������';
$_LANG['send_count'] = '��������';
$_LANG['use_count'] = 'ʹ������';
$_LANG['send_method'] = '��η��Ŵ����ͺ��';
$_LANG['send_type'] = '��������';
$_LANG['param'] = '����';
$_LANG['no_use'] = 'δʹ��';
$_LANG['yuan'] = 'Ԫ';
$_LANG['user_list'] = '��Ա�б�';
$_LANG['type_name_empty'] = '����������Ʋ���Ϊ�գ�';
$_LANG['type_money_empty'] = '�������Ϊ�գ�';
$_LANG['min_amount_empty'] = '������͵Ķ������޲���Ϊ�գ�';
$_LANG['max_amount_empty'] = '������͵Ķ������޲���Ϊ�գ�';
$_LANG['send_count_empty'] = '������͵ķ�����������Ϊ�գ�';

$_LANG['send_by'][SEND_BY_USER] = '���û�����';
$_LANG['send_by'][SEND_BY_GOODS] = '����Ʒ����';
$_LANG['send_by'][SEND_BY_ORDER] = '����������';
$_LANG['send_by'][SEND_BY_PRINT] = '���·��ŵĺ��';
$_LANG['report_form'] = '����';
$_LANG['send'] = '����';
$_LANG['bonus_excel_file'] = '���º����Ϣ�б�';

$_LANG['goods_cat'] = 'ѡ����Ʒ����';
$_LANG['goods_brand'] = '��ƷƷ��';
$_LANG['goods_key'] = '��Ʒ�ؼ���';
$_LANG['all_goods'] = '��ѡ��Ʒ';
$_LANG['send_bouns_goods'] = '���Ŵ����ͺ������Ʒ';
$_LANG['remove_bouns'] = '�Ƴ����';
$_LANG['all_remove_bouns'] = 'ȫ���Ƴ�';
$_LANG['goods_already_bouns'] = '����Ʒ�Ѿ����Ź��������͵ĺ����!';
$_LANG['send_user_empty'] = '��û��ѡ����Ҫ���ź���Ļ�Ա���뷵��!';
$_LANG['batch_drop_success'] = '�ɹ�ɾ���� %d ���û����';
$_LANG['sendbonus_count'] = '�������� %d �������';
$_LANG['send_bouns_error'] = '���ͻ�Ա�������, �뷵�����ԣ�';
$_LANG['no_select_bonus'] = '��û��ѡ����Ҫɾ�����û����';
$_LANG['bonustype_edit'] = '�༭�������';
$_LANG['bonustype_view'] = '�鿴����';
$_LANG['drop_bonus'] = 'ɾ�����';
$_LANG['send_bonus'] = '���ź��';
$_LANG['continus_add'] = '������Ӻ������';
$_LANG['back_list'] = '���غ�������б�';
$_LANG['continue_add'] = '������Ӻ��';
$_LANG['back_bonus_list'] = '���غ���б�';
$_LANG['validated_email'] = 'ֻ��ͨ���ʼ���֤���û����ź��';

/* ��ʾ��Ϣ */
$_LANG['attradd_succed'] = '�����ɹ�!';
$_LANG['js_languages']['type_name_empty'] = '����������������!';
$_LANG['js_languages']['type_money_empty'] = '�����������ͼ۸�!';
$_LANG['js_languages']['order_money_empty'] = '�����붩�����!';
$_LANG['js_languages']['type_money_isnumber'] = '���ͽ�����Ϊ���ָ�ʽ!';
$_LANG['js_languages']['order_money_isnumber'] = '����������Ϊ���ָ�ʽ!';
$_LANG['js_languages']['bonus_sn_empty'] = '�������������к�!';
$_LANG['js_languages']['bonus_sn_number'] = '��������кű���������!';
$_LANG['send_count_error'] = '����ķ�������������һ������!';
$_LANG['js_languages']['bonus_sum_empty'] = '��������Ҫ���ŵĺ������!';
$_LANG['js_languages']['bonus_sum_number'] = '����ķ�������������һ������!';
$_LANG['js_languages']['bonus_type_empty'] = '��ѡ���������ͽ��!';
$_LANG['js_languages']['user_rank_empty'] = '��û��ָ����Ա�ȼ�!';
$_LANG['js_languages']['user_name_empty'] = '��������Ҫѡ��һ����Ա!';
$_LANG['js_languages']['invalid_min_amount'] = '�����붩�����ޣ�����0�����֣�';
$_LANG['js_languages']['send_start_lt_end'] = '������ſ�ʼ���ڲ��ܴ��ڽ�������';
$_LANG['js_languages']['use_start_lt_end'] = '���ʹ�ÿ�ʼ���ڲ��ܴ��ڽ�������';

$_LANG['order_money_notic'] = 'ֻҪ�������ﵽ����ֵ���ͻᷢ�ź�����û�';
$_LANG['type_money_notic'] = '�����͵ĺ�����Ե����Ľ��';
$_LANG['send_startdate_notic'] = 'ֻ�е�ǰʱ�������ʼ���ںͽ�ֹ����֮��ʱ�������͵ĺ���ſ��Է���';
$_LANG['use_startdate_notic'] = 'ֻ�е�ǰʱ�������ʼ���ںͽ�ֹ����֮��ʱ�������͵ĺ���ſ���ʹ��';
$_LANG['type_name_exist'] = '�����͵������Ѿ�����!';
$_LANG['type_money_error'] = '�����������ֲ��Ҳ���С�� 0 !';
$_LANG['bonus_sn_notic'] = '��ʾ:������к�����λ���к����Ӽ�����λ����������';
$_LANG['creat_bonus'] = '������ ';
$_LANG['creat_bonus_num'] = ' ��������к�';
$_LANG['bonus_sn_error'] = '������кű���������!';
$_LANG['send_user_notice'] = '��ָ�����û����ź��ʱ,���ڴ������û���, ����û�֮�����ö���(,)�ָ���<br />��:liry, wjz, zwj';

/* �����Ϣ�ֶ� */
$_LANG['bonus_id'] = '���';
$_LANG['bonus_type_id'] = '���ͽ��';
$_LANG['send_bonus_count'] = '�������';
$_LANG['start_bonus_sn'] = '��ʼ���к�';
$_LANG['bonus_sn'] = '������к�';
$_LANG['user_id'] = 'ʹ�û�Ա';
$_LANG['used_time'] = 'ʹ��ʱ��';
$_LANG['order_id'] = '������';
$_LANG['send_mail'] = '���ʼ�';
$_LANG['emailed'] = '�ʼ�֪ͨ';
$_LANG['mail_status'][BONUS_NOT_MAIL] = 'δ��';
$_LANG['mail_status'][BONUS_MAIL_FAIL] = '�ѷ�ʧ��';
$_LANG['mail_status'][BONUS_MAIL_SUCCEED] = '�ѷ��ɹ�';

$_LANG['sendtouser'] = '��ָ���û����ź��';
$_LANG['senduserrank'] = '���û��ȼ����ź��';
$_LANG['userrank'] = '�û��ȼ�';
$_LANG['select_rank'] = 'ѡ���Ա�ȼ�...';
$_LANG['keywords'] = '�ؼ��֣�';
$_LANG['userlist'] = '��Ա�б�';
$_LANG['send_to_user'] = '�������û����ź��';
$_LANG['search_users'] = '������Ա';
$_LANG['confirm_send_bonus'] = 'ȷ�����ͺ��';
$_LANG['bonus_not_exist'] = '�ú��������';
$_LANG['success_send_mail'] = '%d ���ʼ��ѱ������ʼ��б�';
$_LANG['send_continue'] = '�������ź��';
?>