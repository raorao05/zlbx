<?php

/**
 * ECSHOP
 * ============================================================================
 * ������� 2005-2011 �Ϻ����ɾW�j�Ƽ����޹�˾���K�������Й�����
 * �Wվ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �@����һ������ܛ������ֻ���ڲ�����̘IĿ�ĵ�ǰ����������a�M���޸ĺ�
 * ʹ�ã������S��������a���κ���ʽ�κ�Ŀ�ĵ��ٰl�ѡ�
 * ============================================================================
 * $Author: liubo $
 * $Id: database.php 17217 2011-01-19 06:29:08Z liubo $
*/

$_LANG['db_manage'] = '���������';
$_LANG['start_backup'] = '�_ʼ���';
$_LANG['backup_name'] = '������Q';
$_LANG['backup_time'] = '��ݕr�g';
$_LANG['backup_size'] = '��ݴ�С';
$_LANG['restore'] = '�֏͂��';
$_LANG['restore_ok'] = '�֏ͳɹ�';
$_LANG['download'] = '���d';
$_LANG['restored'] = '����ѽ��֏��^��';
$_LANG['upload_sql'] = '�ς�����ļ�';

$_LANG['table'] = '������';
$_LANG['type'] = '���������';
$_LANG['rec_num'] = 'ӛ䛔�';
$_LANG['rec_size'] = '����';
$_LANG['rec_chip'] = '��Ƭ';
$_LANG['start_optimize'] = '�_ʼ�M�Д����탞��';
$_LANG['chip_count'] = '����Ƭ��';
$_LANG['charset'] = '�ַ���';
$_LANG['status'] = '��B';

$_LANG['backup_type'] ='������';
$_LANG['full_backup'] ='ȫ�����';
$_LANG['full_backup_note'] ='��ݔ��������б�';
$_LANG['stand_backup'] ='�˜ʂ��(���])';
$_LANG['stand_backup_note'] ='��ݳ��õĔ�����';
$_LANG['min_backup'] ='��С���';
$_LANG['min_backup_note'] ='�H������Ʒ��ӆ�α��Ñ���';
$_LANG['custom_backup'] ='�Զ��x���';
$_LANG['custom_backup_note'] ='���������x���ݔ�����';

$_LANG['option'] = '�����x�';
$_LANG['ext_insert'] = 'ʹ�ÔUչ����(Extended Insert)��ʽ';
$_LANG['is_pack'] = '�Ƿ񌢂�ݔ������';
$_LANG['notice_is_pack'] = '����ܜpС��ݴ�С�����֏͂�ݕr��Ҫ�Ƚ≺��ݲ����ς�';
$_LANG['vol_size'] = '�־��� - �ļ��L������(kb)';
$_LANG['sql_name'] = '����ļ���';
$_LANG['backup_failure'] = '��ݳ��e';

$_LANG['sqlfile'] = '����sql�ļ�';
$_LANG['update_table_pre'] = '���ı�ǰ�Y';
$_LANG['old_table_pre'] = 'ԭ��ǰ�Y';
$_LANG['new_table_pre'] = '�±�ǰ�Y';
$_LANG['use_new_pre'] = 'ʹ���±�ǰ�Y';
$_LANG['notice_use_new_pre'] = 'ֻ���ڻ֏�ȫ����ݕr�ſ����x���ǡ�����t�]�Ђ�ݵı팢�o��ʹ�á�<br />��Ҳ�����ք��޸� data/config.php �е� $prefix ׃����Q��ʹ���Ă���ǰ�Y';$_LANG['upload_and_exe'] = '�ς��K����sql�ļ�';

/* ��ʾ��Ϣ */
$_LANG['fail_get_tables'] = '�@ȡ��ݔ�����ʧ��';
$_LANG['fail_open_file'] = '�ļ����_ʧ��';
$_LANG['fail_remove'] = '�ļ��h��ʧ��';
$_LANG['fail_get_content'] = '�@ȡ���������ʧ��';
$_LANG['fail_upload'] = '�ļ��ς�ʧ��';
$_LANG['fail_upload_move'] = '�ļ��ς��Ƅ�ʧ��';
$_LANG['unrecognize_version'] = '�����R�e���sql��ECShop�汾';
$_LANG['unrecognize_mysql_version'] = '�����R�e���sql��mysql�汾';
$_LANG['mysql_version_error'] = '��ǰmysql�汾%s�c��ݔ�����mysql�汾%s��ͬ����_�JҪ����ԓ����ļ���?';
$_LANG['confirm_ver'] = '�ǣ��_�J����';
$_LANG['unconfirm_ver'] = '��ȡ������';
$_LANG['version_error'] = 'ECShop ��ǰ�汾%s�c��ݔ����汾%s��ͬ����ݻ֏�ʧ��';
$_LANG['not_sql_file'] = '���ς��ĺ�����sql�ļ�������ļ��_����sql�ļ���Ո���ļ��Uչ���Ğ�.sql';
$_LANG['sqlfile_error'] = '���ς���sql�ļ����г��e����ݻ֏�ʧ��';
$_LANG['restore_success'] = '�֏ͳɹ�';
$_LANG['fail_optimize'] = '���������� %s ʧ��';
$_LANG['optimize_ok'] = '�����탞���ɹ�����������Ƭ %d';
$_LANG['restore_confirm'] = '�֏͔����������F�е����Ѓ��ݣ����_��Ҫ�֏͆᣿';
$_LANG['fail_import'] = '��������ʧ��';
$_LANG['no_file'] = '�ļ�������';
$_LANG['not_support_zip_format'] = '��������֧��zip��ʽ��Ո���ļ��≺�����ς�';

/* js */
$_LANG['js_languages']['remove_confirm'] = '��_�JҪ�h��ԓ��݆᣿';
$_LANG['js_languages']['lang_remove'] = '�Ƴ�';
$_LANG['js_languages']['lang_restore'] = '�֏͂��';
$_LANG['js_languages']['lang_download'] = '���d';
$_LANG['js_languages']['sql_name_not_null'] = '�ļ������ܞ��';
$_LANG['js_languages']['vol_size_not_null'] = 'Ո�����ݴ�С';

/* ������� */
$_LANG['backup_title'] = '�����ļ� %s �ɹ������������Ԅ��^�m��';
$_LANG['backup_notice'] = '������Ğg�[���]���Ԅ����D��Ո�c���@�e';
$_LANG['backup_success'] = '��ݳɹ�';

$_LANG['name'] = '�ļ���';
$_LANG['ver'] = '�汾';
$_LANG['add_time'] = '�r�g';
$_LANG['file_size'] = '��С';
$_LANG['empty_upload'] = '���ς���һ�����ļ�';
$_LANG['fail_write_file'] = '����ļ� %s �o������';
$_LANG['vol'] = '��';
$_LANG['import'] = '����';
$_LANG['server_sql'] = '�������ς���ļ�';
$_LANG['submit_remove'] = '�h��';
$_LANG['remove_success'] = '�h���ɹ�';
$_LANG['confirm_import'] = '����һ���־���܌��������������Ƿ�һ�����������־픵��';
$_LANG['also_continue'] = '�ǣ���Ҫ���������־픵��';

$_LANG['dir_priv'] = 'Ŀ� %s �����������}��';
$_LANG['dir_not_exist'] = 'Ŀ� %s ������,Ո�քӄ���';
$_LANG['cannot_read'] = '�����x';
$_LANG['cannot_write'] = '���Ɍ�';
$_LANG['cannot_add'] = '׷�Ӕ���';
$_LANG['cannot_modify'] = '�����޸��ļ�';

$_LANG['confirm_remove'] = '��_��Ҫ�h���x�Д����᣿';

?>