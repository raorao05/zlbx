<?php

/**
 * ECSHOP ���T�~̖�����Z���ļ�
 * ============================================================================
 * ������� 2005-2011 �Ϻ����ɾW�j�Ƽ����޹�˾���K�������Й�����
 * �Wվ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �@����һ������ܛ������ֻ���ڲ�����̘IĿ�ĵ�ǰ����������a�M���޸ĺ�
 * ʹ�ã������S��������a���κ���ʽ�κ�Ŀ�ĵ��ٰl�ѡ�
 * ============================================================================
 * $Author: liubo $
 * $Id: users.php 17217 2011-01-19 06:29:08Z liubo $
*/
/* �б���� */
$_LANG['label_user_name'] = '���T���Q';
$_LANG['label_pay_points_gt'] = '���T�e�ִ��';
$_LANG['label_pay_points_lt'] = '���T�e��С�';
$_LANG['label_rank_name'] = '���T�ȼ�';
$_LANG['all_option'] = '���еȼ�';

$_LANG['view_order'] = '�鿴ӆ��';
$_LANG['view_deposit'] = '�鿴�~Ŀ����';
$_LANG['username'] = '���T���Q';
$_LANG['email'] = '�]����ַ';
$_LANG['is_validated'] = '�Ƿ�����C';
$_LANG['reg_date'] = '�]������';
$_LANG['button_remove'] = '�h�����T';
$_LANG['users_edit'] = '��݋���T�~̖';
$_LANG['goto_list'] = '���ؕ��T�~̖�б�';
$_LANG['username_empty'] = '���T���Q���ܞ�գ�';

/* ������P�Z��� */
$_LANG['password'] = '����ܴa';
$_LANG['newpass'] = '���ܴa';
$_LANG['confirm_password'] = '�_�J�ܴa';
$_LANG['question'] = '�ܴa��ʾ���}';
$_LANG['answer'] = '�ܴa��ʾ���}��';
$_LANG['gender'] = '�Ԅe';
$_LANG['birthday'] = '��������';
$_LANG['sex'][0] = '����';
$_LANG['sex'][1] = '��';
$_LANG['sex'][2] = 'Ů';
$_LANG['pay_points'] = '���M�e��';
$_LANG['rank_points'] = '�ȼ��e��';
$_LANG['user_money'] = '�����Y��';
$_LANG['frozen_money'] = '���Y�Y��';
$_LANG['credit_line'] = '�����~��';
$_LANG['user_rank'] = '���T�ȼ�';
$_LANG['not_special_rank'] = '������ȼ�';
$_LANG['view_detail_account'] = '�鿴����';
$_LANG['parent_user'] = '���]��';
$_LANG['parent_remove'] = 'Ó�x���]�P�S';
$_LANG['affiliate_user'] = '���]���T';
$_LANG['show_affiliate_users'] = '�鿴���]Ԕ������';
$_LANG['show_affiliate_orders'] = '�鿴���]ӆ��Ԕ��';
$_LANG['affiliate_lever'] = '�ȼ�';
$_LANG['affiliate_num'] = '�˔�';
$_LANG['page_note'] = '���б��@ʾ�Ñ����]��ȫ����Ϣ��';
$_LANG['how_many_user'] = '�����T��';
$_LANG['back_note'] = '���ؕ��T��݋���';
$_LANG['affiliate_level'] = '���]�ȼ�';

$_LANG['msn'] = 'MSN';
$_LANG['qq'] = 'QQ';
$_LANG['home_phone'] = '��ͥ�Ԓ';
$_LANG['office_phone'] = '�k���Ԓ';
$_LANG['mobile_phone'] = '�֙C';

$_LANG['notice_pay_points'] = '���M�e����һ�Nվ��؛�ţ����S�Ñ���ُ��r֧��һ�������ķe�֡�';
$_LANG['notice_rank_points'] = '�ȼ��e����һ�N��Ӌ�ķe�֣�ϵ�y����ԓ�e�ց��ж��Ñ��ĕ��T�ȼ���';
$_LANG['notice_user_money'] = '�Ñ���վ���A���µĽ��~';

/* ��ʾ��Ϣ */
$_LANG['username_exists'] = '�ѽ�����һ����ͬ���Ñ�����';
$_LANG['email_exists'] = 'ԓ�]����ַ�ѽ����ڡ�';
$_LANG['edit_user_failed'] = '�޸ĕ��T�Y��ʧ����';
$_LANG['invalid_email'] = 'ݔ���˷Ƿ����]����ַ��';
$_LANG['update_success'] = '��݋�Ñ���Ϣ�ѽ��ɹ���';
$_LANG['still_accounts'] = 'ԓ���T���N�~��Ƿ��\n';
$_LANG['remove_confirm'] = '���_��Ҫ�h��ԓ���T�~̖�᣿';
$_LANG['list_still_accounts'] = '�x�еĕ��T�����������N�~��Ƿ��\n';
$_LANG['list_remove_confirm'] = '���_��Ҫ�h�������x�еĕ��T��̖�᣿';
$_LANG['remove_order_confirm'] = 'ԓ���T�~̖�ѽ���ӆ�δ��ڣ��h��ԓ���T�~̖��ͬ�r�����ӆ�Δ�����<br />���_��Ҫ�h���᣿';
$_LANG['remove_order'] = '�ǣ��Ҵ_��Ҫ�h�����T�~̖����ӆ�Δ���';
$_LANG['remove_cancel'] = '�����Ҳ���h��ԓ���T�~̖�ˡ�';
$_LANG['remove_success'] = '���T�~̖ %s �ѽ��h���ɹ���';
$_LANG['add_success'] = '���T�~̖ %s �ѽ���ӳɹ���';
$_LANG['batch_remove_success'] = '�ѽ��ɹ��h���� %d �����T�~̖��';
$_LANG['no_select_user'] = '���F�ڛ]����Ҫ�h���ĕ��T��';
$_LANG['register_points'] = '�]���ͷe��';
$_LANG['username_not_allow'] = '�Ñ��������S�]��';
$_LANG['username_invalid'] = '�oЧ���Ñ���';
$_LANG['email_invalid'] = '�oЧ��email��ַ';
$_LANG['email_not_allow'] = '�]�������S';

/* ��ַ�б� */
$_LANG['address_list'] = '��؛��ַ';
$_LANG['consignee'] = '��؛��';
$_LANG['address'] = '��ַ';
$_LANG['link'] = '�M��ʽ';
$_LANG['other'] = '����';
$_LANG['tel'] = '�Ԓ';
$_LANG['mobile'] = '�֙C';
$_LANG['best_time'] = '�����؛�r�g';
$_LANG['sign_building'] = '���I���B';

/* JS �Z��� */
$_LANG['js_languages']['no_username'] = '�]��ݔ���Ñ�����';
$_LANG['js_languages']['invalid_email'] = '�]��ݔ���]����ַ����ݔ����һ���oЧ���]����ַ��';
$_LANG['js_languages']['no_password'] = '�]��ݔ���ܴa��';
$_LANG['js_languages']['less_password'] = 'ݔ����ܴa���������λ��';
$_LANG['js_languages']['passwd_balnk'] = '�ܴa�в��ܰ����ո�';
$_LANG['js_languages']['no_confirm_password'] = '�]��ݔ��_�J�ܴa��';
$_LANG['js_languages']['password_not_same'] = 'ݔ����ܴa�ʹ_�J�ܴa��һ�¡�';
$_LANG['js_languages']['invalid_pay_points'] = '���M�e�֔�����һ��������';
$_LANG['js_languages']['invalid_rank_points'] = '�ȼ��e�֔�����һ��������';
$_LANG['js_languages']['password_len_err'] = '���ܴa�ʹ_�J�ܴa���L�Ȳ���С�6';
?>
