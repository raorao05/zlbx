<?php

/**
 * ECSHOP ���⿨����
 * ============================================================================
 * ������� 2005-2011 �Ϻ����ɾW�j�Ƽ����޹�˾���K�������Й�����
 * �Wվ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �@����һ������ܛ������ֻ���ڲ�����̘IĿ�ĵ�ǰ����������a�M���޸ĺ�
 * ʹ�ã������S��������a���κ���ʽ�κ�Ŀ�ĵ��ٰl�ѡ�
 * ============================================================================
 * $Author: liubo $
 * $Id: virtual_card.php 17217 2011-01-19 06:29:08Z liubo $
*/

/*------------------------------------------------------ */
//-- ��Ƭ��Ϣ
/*------------------------------------------------------ */
$_LANG['virtual_card_list'] = '̓�M����Ʒ�б�';
$_LANG['lab_goods_name'] = '��Ʒ���Q';
$_LANG['replenish'] = '�a؛';
$_LANG['lab_card_id'] = '��̖';
$_LANG['lab_card_sn'] = '��Ƭ��̖';
$_LANG['lab_card_password'] = '��Ƭ�ܴa';
$_LANG['lab_end_date'] = '����ʹ������';
$_LANG['lab_is_saled'] = '�Ƿ��ѳ���';
$_LANG['lab_order_sn'] = 'ӆ��̖';
$_LANG['action_success'] = '�����ɹ�';
$_LANG['action_fail'] = '����ʧ��';
$_LANG['card'] = '��Ƭ�б�';

$_LANG['batch_card_add'] = '��������a؛';
$_LANG['download_file'] = '���d����CSV�ļ�';
$_LANG['separator'] = '�ָ���';
$_LANG['uploadfile'] = '�ς��ļ�';
$_LANG['sql_error'] = '�� %s �l��Ϣ���e��<br /> ';

/* ��ʾ��Ϣ */
$_LANG['replenish_no_goods_id'] = 'ȱ����ƷID�������o���M���a؛����';
$_LANG['replenish_no_get_goods_name'] = '��ƷID�������`���o���@ȡ��Ʒ��';
$_LANG['drop_card_success'] = 'ԓӛ��ѳɹ��h��';
$_LANG['batch_drop'] = '�����h��';
$_LANG['drop_card_confirm'] = '��_��Ҫ�h��ԓӛ䛆᣿';
$_LANG['card_sn_exist'] = '��Ƭ��̖ %s �ѽ����ڣ�Ո����ݔ��';
$_LANG['go_list'] = '�����a؛�б�';
$_LANG['continue_add'] = '�^�m�a؛';
$_LANG['uploadfile_fail'] = '�ļ��ς�ʧ��';
$_LANG['batch_card_add_ok'] = '�ѳɹ������ %s �l�a؛��Ϣ';

$_LANG['js_languages']['no_card_sn'] = '��Ƭ��̖�Ϳ�Ƭ�ܴa���ܶ���ա�';
$_LANG['js_languages']['separator_not_null'] = '�ָ���̖���ܞ�ա�';
$_LANG['js_languages']['uploadfile_not_null'] = 'Ո�x��Ҫ�ς����ļ���';

$_LANG['use_help'] = 'ʹ���f����' .
        '<ol>' .
          '<li>�ς��ļ�����CSV�ļ�<br />' .
              'CSV�ļ���һ�О鿨Ƭ��̖���ڶ��О鿨Ƭ�ܴa�������О�ʹ�ý������ڡ�<br />'.
              '(��EXCEL����csv�ļ���������EXCEL�а���̖����Ƭ�ܴa���������ڵ����������������ֱ�ӱ����csv�ļ�����)'.
          '<li>�ܴa���ͽ������ڿ��Ԟ�գ��������ڸ�ʽ��2006-11-6��2006/11/6'.
          '<li>��̖����Ƭ�ܴa�����������в�Ҫʹ������</li>' .
        '</ol>';

/*------------------------------------------------------ */
//-- ��׃���ܴ�
/*------------------------------------------------------ */

$_LANG['virtual_card_change'] = '���ļ��ܴ�';
$_LANG['user_guide'] = 'ʹ���f����' .
        '<ol>' .
          '<li>���ܴ����ڼ���̓�M�����Ʒ�Ŀ�̖���ܴa�rʹ�õ�</li>' .
          '<li>���ܴ��������ļ� data/config.php �У������ĳ����� AUTH_KEY</li>' .
          '<li>���Ҫ���ļ��ܴ�����������ı�����ݔ��ԭ���ܴ����¼��ܴ����c\'�_��\'���o�ἴ��</li>' .
        '</ol>';
$_LANG['label_old_string'] = 'ԭ���ܴ�';
$_LANG['label_new_string'] = '�¼��ܴ�';

$_LANG['invalid_old_string'] = 'ԭ���ܴ������_';
$_LANG['invalid_new_string'] = '�¼��ܴ������_';
$_LANG['change_key_ok'] = '���ļ��ܴ��ɹ�';
$_LANG['same_string'] = '�¼��ܴ���ԭ���ܴ���ͬ';

$_LANG['update_log'] = '����ӛ�';
$_LANG['old_stat'] = '������ӛ� %s �l����ʹ���´����ܵ�ӛ��� %s �l��ʹ��ԭ�����ܣ������£���ӛ��� %s �l��ʹ��δ֪�����ܵ�ӛ��� %s �l��';
$_LANG['new_stat'] = '<strong>�����ꮅ</strong>���F��ʹ���´����ܵ�ӛ��� %s �l��ʹ��δ֪�����ܵ�ӛ��� %s �l��';
$_LANG['update_error'] = '�����^���г��e��%s';
$_LANG['js_languages']['updating_info'] = '<strong>���ڸ���</strong>��ÿ�� 100 �lӛ䛣�';
$_LANG['js_languages']['updated_info'] = '<strong>�Ѹ���</strong> <span id=\"updated\">0</span> �lӛ䛡�';
?>