<?php

/**
 * ECSHOP ��Ա�˺Ź��������ļ�
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: users.php 17217 2011-01-19 06:29:08Z liubo $
*/
/* �б�ҳ�� */
$_LANG['label_user_name'] = '��Ա����';
$_LANG['label_pay_points_gt'] = '��Ա���ִ���';
$_LANG['label_pay_points_lt'] = '��Ա����С��';
$_LANG['label_rank_name'] = '��Ա�ȼ�';
$_LANG['all_option'] = '���еȼ�';

$_LANG['view_order'] = '�鿴����';
$_LANG['view_deposit'] = '�鿴��Ŀ��ϸ';
$_LANG['username'] = '��Ա����';
$_LANG['email'] = '�ʼ���ַ';
$_LANG['is_validated'] = '�Ƿ�����֤';
$_LANG['reg_date'] = 'ע������';
$_LANG['button_remove'] = 'ɾ����Ա';
$_LANG['users_edit'] = '�༭��Ա�˺�';
$_LANG['goto_list'] = '���ػ�Ա�˺��б�';
$_LANG['username_empty'] = '��Ա���Ʋ���Ϊ�գ�';

/* ����������� */
$_LANG['password'] = '��¼����';
$_LANG['confirm_password'] = 'ȷ������';
$_LANG['newpass'] = '������';
$_LANG['question'] = '������ʾ����';
$_LANG['answer'] = '������ʾ�����';
$_LANG['gender'] = '�Ա�';
$_LANG['birthday'] = '��������';
$_LANG['sex'][0] = '����';
$_LANG['sex'][1] = '��';
$_LANG['sex'][2] = 'Ů';
$_LANG['pay_points'] = '���ѻ���';
$_LANG['rank_points'] = '�ȼ�����';
$_LANG['user_money'] = '�����ʽ�';
$_LANG['frozen_money'] = '�����ʽ�';
$_LANG['credit_line'] = '���ö��';
$_LANG['user_rank'] = '��Ա�ȼ�';
$_LANG['not_special_rank'] = '������ȼ�';
$_LANG['view_detail_account'] = '�鿴��ϸ';
$_LANG['parent_user'] = '�Ƽ���';
$_LANG['parent_remove'] = '�����Ƽ���ϵ';
$_LANG['affiliate_user'] = '�Ƽ���Ա';
$_LANG['show_affiliate_users'] = '�鿴�Ƽ���ϸ����';
$_LANG['show_affiliate_orders'] = '�鿴�Ƽ���������';
$_LANG['affiliate_lever'] = '�ȼ�';
$_LANG['affiliate_num'] = '����';
$_LANG['page_note'] = '���б���ʾ�û��Ƽ���ȫ����Ա��Ϣ��';
$_LANG['how_many_user'] = '����Ա��';
$_LANG['back_note'] = '���ػ�Ա�༭ҳ��';
$_LANG['affiliate_level'] = '�Ƽ��ȼ�';

$_LANG['msn'] = 'MSN';
$_LANG['qq'] = 'QQ';
$_LANG['home_phone'] = '��ͥ�绰';
$_LANG['office_phone'] = '�칫�绰';
$_LANG['mobile_phone'] = '�ֻ�';

$_LANG['notice_pay_points'] = '���ѻ�����һ��վ�ڻ��ң������û��ڹ���ʱ֧��һ�������Ļ��֡�';
$_LANG['notice_rank_points'] = '�ȼ�������һ���ۼƵĻ��֣�ϵͳ���ݸû������ж��û��Ļ�Ա�ȼ���';
$_LANG['notice_user_money'] = '�û���վ��Ԥ���µĽ��';

/* ��ʾ��Ϣ */
$_LANG['username_exists'] = '�Ѿ�����һ����ͬ���û�����';
$_LANG['email_exists'] = '���ʼ���ַ�Ѿ����ڡ�';
$_LANG['edit_user_failed'] = '�޸Ļ�Ա����ʧ�ܡ�';
$_LANG['invalid_email'] = '�����˷Ƿ����ʼ���ַ��';
$_LANG['update_success'] = '�༭�û���Ϣ�Ѿ��ɹ���';
$_LANG['still_accounts'] = '�û�Ա������Ƿ��\n';
$_LANG['remove_confirm'] = '��ȷ��Ҫɾ���û�Ա�˺���';
$_LANG['list_still_accounts'] = 'ѡ�еĻ�Ա�˻�����������Ƿ��\n';
$_LANG['list_remove_confirm'] = '��ȷ��Ҫɾ������ѡ�еĻ�Ա�˺���';
$_LANG['remove_order_confirm'] = '�û�Ա�˺��Ѿ��ж������ڣ�ɾ���û�Ա�˺ŵ�ͬʱ������������ݡ�<br />��ȷ��Ҫɾ����';
$_LANG['remove_order'] = '�ǣ���ȷ��Ҫɾ����Ա�˺ż��䶩������';
$_LANG['remove_cancel'] = '�����Ҳ���ɾ���û�Ա�˺��ˡ�';
$_LANG['remove_success'] = '��Ա�˺� %s �Ѿ�ɾ���ɹ���';
$_LANG['add_success'] = '��Ա�˺� %s �Ѿ���ӳɹ���';
$_LANG['batch_remove_success'] = '�Ѿ��ɹ�ɾ���� %d ����Ա�˺š�';
$_LANG['no_select_user'] = '������û����Ҫɾ���Ļ�Ա��';
$_LANG['register_points'] = 'ע���ͻ���';
$_LANG['username_not_allow'] = '�û���������ע��';
$_LANG['username_invalid'] = '��Ч���û���';
$_LANG['email_invalid'] = '��Ч��email��ַ';
$_LANG['email_not_allow'] = '�ʼ�������';

/* ��ַ�б� */
$_LANG['address_list'] = '�ջ���ַ';
$_LANG['consignee'] = '�ջ���';
$_LANG['address'] = '��ַ';
$_LANG['link'] = '��ϵ��ʽ';
$_LANG['other'] = '����';
$_LANG['tel'] = '�绰';
$_LANG['mobile'] = '�ֻ�';
$_LANG['best_time'] = '����ͻ�ʱ��';
$_LANG['sign_building'] = '��־����';

/* JS ������ */
$_LANG['js_languages']['no_username'] = 'û�������û�����';
$_LANG['js_languages']['invalid_email'] = 'û�������ʼ���ַ����������һ����Ч���ʼ���ַ��';
$_LANG['js_languages']['no_password'] = 'û���������롣';
$_LANG['js_languages']['less_password'] = '��������벻��������λ��';
$_LANG['js_languages']['passwd_balnk'] = '�����в��ܰ����ո�';
$_LANG['js_languages']['no_confirm_password'] = 'û������ȷ�����롣';
$_LANG['js_languages']['password_not_same'] = '����������ȷ�����벻һ�¡�';
$_LANG['js_languages']['invalid_pay_points'] = '���ѻ���������һ��������';
$_LANG['js_languages']['invalid_rank_points'] = '�ȼ�����������һ��������';
$_LANG['js_languages']['password_len_err'] = '�������ȷ������ĳ��Ȳ���С��6';
?>
