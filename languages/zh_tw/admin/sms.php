<?php
/**
 * ECSHOP ����ģ�K�Z���ļ�
 * ============================================================================
 * ������� 2005-2011 �Ϻ����ɾW�j�Ƽ����޹�˾���K�������Й�����
 * �Wվ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �@����һ������ܛ������ֻ���ڲ�����̘IĿ�ĵ�ǰ����������a�M���޸ĺ�
 * ʹ�ã������S��������a���κ���ʽ�κ�Ŀ�ĵ��ٰl�ѡ�
 * ============================================================================
 * $Author: liubo $
 * $Id: sms.php 17217 2011-01-19 06:29:08Z liubo $
*/

/* �����l */
$_LANG['register_sms'] = '�]�Ի��ö����~̖';

/* �]�Ժ͆��ö��Ź��� */
$_LANG['email'] = '����]��';
$_LANG['password'] = '����ܴa';
$_LANG['domain'] = '�W������';
$_LANG['register_new'] = '�]�����~̖';
$_LANG['error_tips'] = 'Ո���̵��O��->�����O�ã���ע�Զ��ŷ��ղ����_���ö��ŷ��գ�';
$_LANG['enable_old'] = '���������~̖';

/* �����ط���Ϣ */
$_LANG['sms_user_name'] = '�Ñ�����';
$_LANG['sms_password'] = '�ܴa��';
$_LANG['sms_domain'] = '������';
$_LANG['sms_num'] = '�����ط�̖��';
$_LANG['sms_count'] = '�l�Ͷ��ŗl����';
$_LANG['sms_total_money'] = '�����_ֵ���~��';
$_LANG['sms_balance'] = '�N�~��';
$_LANG['sms_last_request'] = '����һ��Ո��r�g��';
$_LANG['disable'] = '�]�N���ŷ���';

/* �l�Ͷ��� */
$_LANG['phone'] = '�֙C̖�a';
$_LANG['user_rand'] = '���Ñ��ȼ��l�Ͷ���Ϣ';
$_LANG['phone_notice'] = '�����֙C̖�a�ð�Ƕ�̖���_';
$_LANG['msg'] = '��Ϣ����';
$_LANG['msg_notice'] = '���L70�ַ�';
$_LANG['send_date'] = '���r�l�͕r�g';
$_LANG['send_date_notice'] = '��ʽ��YYYY-MM-DD HH:II����ձ�ʾ�����l�͡�';
$_LANG['back_send_history'] = '���ذl�͚vʷ�б�';
$_LANG['back_charge_history'] = '���س�ֵ�vʷ�б�';

/* ӛ䛲�ԃ���� */
$_LANG['start_date'] = '�_ʼ����';
$_LANG['date_notice'] = '��ʽ��YYYY-MM-DD���ɞ�ա�';
$_LANG['end_date'] = '�Y������';
$_LANG['page_size'] = 'ÿ��@ʾ����';
$_LANG['page_size_notice'] = '�ɞ�գ���ʾÿ��@ʾ20�lӛ�';
$_LANG['page'] = '퓔�';
$_LANG['page_notice'] = '�ɞ�գ���ʾ�@ʾ1�';
$_LANG['charge'] = 'Ոݔ������Ҫ��ֵ�Ľ��~';

/* �����_�J��Ϣ */
$_LANG['history_query_error'] = '�������ڲ�ԃ�^���аl���e�`��';
$_LANG['enable_ok'] = '��ϲ�����ѳɹ����ö��ŷ��գ�';
$_LANG['enable_error'] = '�����������ö��ŷ���ʧ����';
$_LANG['disable_ok'] = '���ѽ��ɹ��]�N���ŷ��ա�';
$_LANG['disable_error'] = '�]�N���ŷ���ʧ����';
$_LANG['register_ok'] = '��ϲ�����ѳɹ��]�Զ��ŷ��գ�';
$_LANG['register_error'] = '���������]�Զ��ŷ���ʧ����';
$_LANG['send_ok'] = '��ϲ�����Ķ����ѽ��ɹ��l�ͣ�';
$_LANG['send_error'] = '�������ڰl�Ͷ����^���аl���e�`��';
$_LANG['error_no'] = '�e�`���R';
$_LANG['error_msg'] = '�e�`����';
$_LANG['empty_info'] = '���Ķ����ط���Ϣ��ա�';

/* ��ֵӛ� */
$_LANG['order_id'] = 'ӆ��̖';
$_LANG['money'] = '��ֵ���~';
$_LANG['log_date'] = '��ֵ����';

/* �l��ӛ� */
$_LANG['sent_phones'] = '�l���֙C̖�a';
$_LANG['content'] = '�l�̓���';
$_LANG['charge_num'] = 'Ӌ�M�l��';
$_LANG['sent_date'] = '�l������';
$_LANG['send_status'] = '�l�͠�B';
$_LANG['status'][0] = 'ʧ��';
$_LANG['status'][1] = '�ɹ�';
$_LANG['user_list'] = 'ȫ�w���T';
$_LANG['please_select'] = 'Ո�x����T�ȼ�';

/* ��ʾ */
$_LANG['test_now'] = '<span style="color:red;"></span>';
$_LANG['msg_price'] = '<span style="color:green;">����ÿ�l0.1Ԫ(RMB)</span>';

/* API���ص��e�`��Ϣ */
//--�]��
$_LANG['api_errors']['register'][1] = '�������ܞ�ա�';
$_LANG['api_errors']['register'][2] = '�]��������_��';
$_LANG['api_errors']['register'][3] = '�Ñ����Ѵ��ڡ�';
$_LANG['api_errors']['register'][4] = 'δ֪�e�`��';
$_LANG['api_errors']['register'][5] = '�ӿ��e�`��';
//--�@ȡ�N�~
$_LANG['api_errors']['get_balance'][1] = '�Ñ����ܴa�����_��';
$_LANG['api_errors']['get_balance'][2] = '�Ñ������á�';
//--�l�Ͷ���
$_LANG['api_errors']['send'][1] = '�Ñ����ܴa�����_��';
$_LANG['api_errors']['send'][2] = '���Ń����^�L��';
$_LANG['api_errors']['send'][3] = '�l�����ڑ���춮�ǰ�r�g��';
$_LANG['api_errors']['send'][4] = '�e�`��̖�a��';
$_LANG['api_errors']['send'][5] = '�~���N�~���㡣';
$_LANG['api_errors']['send'][6] = '�~���ѱ�ͣ�á�';
$_LANG['api_errors']['send'][7] = '�ӿ��e�`��';
//--�vʷӛ�
$_LANG['api_errors']['get_history'][1] = '�Ñ����ܴa�����_��';
$_LANG['api_errors']['get_history'][2] = '��oӛ䛡�';
//--�Ñ���C
$_LANG['api_errors']['auth'][1] = '�ܴa�e�`��';
$_LANG['api_errors']['auth'][2] = '�Ñ������ڡ�';

/* �Ñ��������z�y�����e�`��Ϣ */
$_LANG['server_errors'][1] = '�]����Ϣ�oЧ��';//ERROR_INVALID_REGISTER_INFO
$_LANG['server_errors'][2] = '������Ϣ�oЧ��';//ERROR_INVALID_ENABLE_INFO
$_LANG['server_errors'][3] = '�l�͵���Ϣ���`��';//ERROR_INVALID_SEND_INFO
$_LANG['server_errors'][4] = '��Ĳ�ԃ��Ϣ���`��';//ERROR_INVALID_HISTORY_QUERY
$_LANG['server_errors'][5] = '�oЧ�������Ϣ��';//ERROR_INVALID_PASSPORT
$_LANG['server_errors'][6] = 'URL������';//ERROR_INVALID_URL
$_LANG['server_errors'][7] = 'HTTP푑��w��ա�';//ERROR_EMPTY_RESPONSE
$_LANG['server_errors'][8] = '�oЧ��XML�ļ���';//ERROR_INVALID_XML_FILE
$_LANG['server_errors'][9] = '�oЧ�Ĺ��c���֡�';//ERROR_INVALID_NODE_NAME
$_LANG['server_errors'][10] = '�惦ʧ����';//ERROR_CANT_STORE
$_LANG['server_errors'][11] = '���Ź�����δ���';//ERROR_INVALID_PASSPORT

/* �͑���JS�Z��� */
//--�]�Ի���
$_LANG['js_languages']['password_empty_error'] = '�ܴa���ܞ�ա�';
$_LANG['js_languages']['username_empty_error'] = '�Ñ������ܞ�ա�';
$_LANG['js_languages']['username_format_error'] = '�Ñ�����ʽ������';
$_LANG['js_languages']['domain_empty_error'] = '�������ܞ�ա�';
$_LANG['js_languages']['domain_format_error'] = '������ʽ������';
$_LANG['js_languages']['send_empty_error'] = '�l���֙C̖�c�l�͵ȼ������һ헣�';

//--�l��
$_LANG['js_languages']['phone_empty_error'] = 'Ո��֙C̖��';
$_LANG['js_languages']['phone_format_error'] = '�֙C̖�a��ʽ������';
$_LANG['js_languages']['msg_empty_error'] = 'Ո���Ϣ���ݡ�';
$_LANG['js_languages']['send_date_format_error'] = '���r�l�͕r�g��ʽ������';
//--�vʷӛ�
$_LANG['js_languages']['start_date_format_error'] = '�_ʼ���ڸ�ʽ������';
$_LANG['js_languages']['end_date_format_error'] = '�Y�����ڸ�ʽ������';
//--��ֵ
$_LANG['js_languages']['money_empty_error'] = 'Ոݔ����Ҫ��ֵ�Ľ��~��';
$_LANG['js_languages']['money_format_error'] = '���~��ʽ������';

?>