<?php

/**
 * ECSHOP
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: database.php 17217 2011-01-19 06:29:08Z liubo $
*/

$_LANG['db_manage'] = '���ݿ����';
$_LANG['start_backup'] = '��ʼ����';
$_LANG['backup_name'] = '��������';
$_LANG['backup_time'] = '����ʱ��';
$_LANG['backup_size'] = '���ݴ�С';
$_LANG['restore'] = '�ָ�����';
$_LANG['restore_ok'] = '�ָ��ɹ�';
$_LANG['download'] = '����';
$_LANG['restored'] = '�����Ѿ��ָ�����';
$_LANG['upload_sql'] = '�ϴ������ļ�';

$_LANG['table'] = '���ݱ�';
$_LANG['type'] = '���ݱ�����';
$_LANG['rec_num'] = '��¼��';
$_LANG['rec_size'] = '����';
$_LANG['rec_chip'] = '��Ƭ';
$_LANG['start_optimize'] = '��ʼ�������ݱ��Ż�';
$_LANG['chip_count'] = '����Ƭ��';
$_LANG['charset'] = '�ַ���';
$_LANG['status'] = '״̬';

$_LANG['backup_type'] ='��������';
$_LANG['full_backup'] ='ȫ������';
$_LANG['full_backup_note'] ='�������ݿ����б�';
$_LANG['stand_backup'] ='��׼����(�Ƽ�)';
$_LANG['stand_backup_note'] ='���ݳ��õ����ݱ�';
$_LANG['min_backup'] ='��С����';
$_LANG['min_backup_note'] ='��������Ʒ���������û���';
$_LANG['custom_backup'] ='�Զ��屸��';
$_LANG['custom_backup_note'] ='��������ѡ�񱸷����ݱ�';

$_LANG['option'] = '����ѡ��';
$_LANG['ext_insert'] = 'ʹ����չ����(Extended Insert)��ʽ';
$_LANG['is_pack'] = '�Ƿ񽫱������ݴ��';
$_LANG['notice_is_pack'] = '����ܼ�С���ݴ�С�����ָ�����ʱ��Ҫ�Ƚ�ѹ���ݲ����ϴ�';
$_LANG['vol_size'] = '�־��� - �ļ���������(kb)';
$_LANG['sql_name'] = '�����ļ���';
$_LANG['backup_failure'] = '���ݳ���';

$_LANG['sqlfile'] = '����sql�ļ�';
$_LANG['update_table_pre'] = '���ı�ǰ׺';
$_LANG['old_table_pre'] = 'ԭ��ǰ׺';
$_LANG['new_table_pre'] = '�±�ǰ׺';
$_LANG['use_new_pre'] = 'ʹ���±�ǰ׺';
$_LANG['notice_use_new_pre'] = 'ֻ���ڻָ�ȫ������ʱ�ſ���ѡ���ǡ�������û�б��ݵı��޷�ʹ�á�<br />��Ҳ�����ֶ��޸� data/config.php �е� $prefix ����������ʹ���ĸ���ǰ׺';$_LANG['upload_and_exe'] = '�ϴ���ִ��sql�ļ�';

/* ��ʾ��Ϣ */
$_LANG['fail_get_tables'] = '��ȡ�������ݱ�ʧ��';
$_LANG['fail_open_file'] = '�ļ���ʧ��';
$_LANG['fail_remove'] = '�ļ�ɾ��ʧ��';
$_LANG['fail_get_content'] = '��ȡ���ݱ�����ʧ��';
$_LANG['fail_upload'] = '�ļ��ϴ�ʧ��';
$_LANG['fail_upload_move'] = '�ļ��ϴ��ƶ�ʧ��';
$_LANG['unrecognize_version'] = '����ʶ�𱸷�sql��ECShop�汾';
$_LANG['unrecognize_mysql_version'] = '����ʶ�𱸷�sql��mysql�汾';
$_LANG['mysql_version_error'] = '��ǰmysql�汾%s�뱸�����ݵ�mysql�汾%s��ͬ����ȷ��Ҫ����ñ����ļ���?';
$_LANG['confirm_ver'] = '�ǣ�ȷ�ϵ���';
$_LANG['unconfirm_ver'] = '��ȡ������';
$_LANG['version_error'] = 'ECShop ��ǰ�汾%s�뱸�����ݰ汾%s��ͬ�����ݻָ�ʧ��';
$_LANG['not_sql_file'] = '���ϴ��ĺ�����sql�ļ�������ļ�ȷʵ��sql�ļ����뽫�ļ���չ����Ϊ.sql';
$_LANG['sqlfile_error'] = '���ϴ���sql�ļ�ִ�г������ݻָ�ʧ��';
$_LANG['restore_success'] = '�ָ��ɹ�';
$_LANG['fail_optimize'] = '�Ż����ݱ� %s ʧ��';
$_LANG['optimize_ok'] = '���ݱ��Ż��ɹ�����������Ƭ %d';
$_LANG['restore_confirm'] = '�ָ����ݿ��������е��������ݣ���ȷ��Ҫ�ָ���';
$_LANG['fail_import'] = '���ݵ���ʧ��';
$_LANG['no_file'] = '�ļ�������';
$_LANG['not_support_zip_format'] = '��������֧��zip��ʽ���뽫�ļ���ѹ�����ϴ�';

/* js */
$_LANG['js_languages']['remove_confirm'] = '��ȷ��Ҫɾ���ñ�����';
$_LANG['js_languages']['lang_remove'] = '�Ƴ�';
$_LANG['js_languages']['lang_restore'] = '�ָ�����';
$_LANG['js_languages']['lang_download'] = '����';
$_LANG['js_languages']['sql_name_not_null'] = '�ļ�������Ϊ��';
$_LANG['js_languages']['vol_size_not_null'] = '�����뱸�ݴ�С';

/* ���ݱ��� */
$_LANG['backup_title'] = '�����ļ� %s �ɹ������������Զ�������';
$_LANG['backup_notice'] = '������������û���Զ���ת����������';
$_LANG['backup_success'] = '���ݳɹ�';

$_LANG['name'] = '�ļ���';
$_LANG['ver'] = '�汾';
$_LANG['add_time'] = 'ʱ��';
$_LANG['file_size'] = '��С';
$_LANG['empty_upload'] = '���ϴ���һ�����ļ�';
$_LANG['fail_write_file'] = '�����ļ� %s �޷�д��';
$_LANG['vol'] = '��';
$_LANG['import'] = '����';
$_LANG['server_sql'] = '�������ϱ����ļ�';
$_LANG['submit_remove'] = 'ɾ��';
$_LANG['remove_success'] = 'ɾ���ɹ�';
$_LANG['confirm_import'] = '����һ���־���ܵ������ݲ��������Ƿ�һ���������־�����';
$_LANG['also_continue'] = '�ǣ���Ҫ���������־�����';

$_LANG['dir_priv'] = 'Ŀ¼ %s Ȩ�����������⣺';
$_LANG['dir_not_exist'] = 'Ŀ¼ %s ������,���ֶ�����';
$_LANG['cannot_read'] = '���ɶ�';
$_LANG['cannot_write'] = '����д';
$_LANG['cannot_add'] = '׷������';
$_LANG['cannot_modify'] = '�����޸��ļ�';

$_LANG['confirm_remove'] = '��ȷ��Ҫɾ��ѡ��������';

?>