<?php
/**
 * ECSHOP ����ģ�������ļ�
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: sms.php 17217 2011-01-19 06:29:08Z liubo $
*/

/* ������ */
$_LANG['register_sms'] = 'ע������ö����˺�';

/* ע������ö��Ź��� */
$_LANG['email'] = '��������';
$_LANG['password'] = '��¼����';
$_LANG['domain'] = '��������';
$_LANG['register_new'] = 'ע�����˺�';
$_LANG['error_tips'] = '�����̵�����->�������ã���ע����ŷ�����ȷ���ö��ŷ���';
$_LANG['enable_old'] = '���������˺�';

/* �����ط���Ϣ */
$_LANG['sms_user_name'] = '�û�����';
$_LANG['sms_password'] = '���룺';
$_LANG['sms_domain'] = '������';
$_LANG['sms_num'] = '�����ط��ţ�';
$_LANG['sms_count'] = '���Ͷ���������';
$_LANG['sms_total_money'] = '�ܹ���ֵ��';
$_LANG['sms_balance'] = '��';
$_LANG['sms_last_request'] = '���һ������ʱ�䣺';
$_LANG['disable'] = 'ע�����ŷ���';

/* ���Ͷ��� */
$_LANG['phone'] = '�����ֻ�����';
$_LANG['user_rand'] = '���û��ȼ����Ͷ���Ϣ';
$_LANG['phone_notice'] = '����ֻ������ð�Ƕ��ŷֿ�';
$_LANG['msg'] = '��Ϣ����';
$_LANG['msg_notice'] = '�70�ַ�';
$_LANG['send_date'] = '��ʱ����ʱ��';
$_LANG['send_date_notice'] = '��ʽΪYYYY-MM-DD HH:II��Ϊ�ձ�ʾ�������͡�';
$_LANG['back_send_history'] = '���ط�����ʷ�б�';
$_LANG['back_charge_history'] = '���س�ֵ��ʷ�б�';

/* ��¼��ѯ���� */
$_LANG['start_date'] = '��ʼ����';
$_LANG['date_notice'] = '��ʽΪYYYY-MM-DD����Ϊ�ա�';
$_LANG['end_date'] = '��������';
$_LANG['page_size'] = 'ÿҳ��ʾ����';
$_LANG['page_size_notice'] = '��Ϊ�գ���ʾÿҳ��ʾ20����¼';
$_LANG['page'] = 'ҳ��';
$_LANG['page_notice'] = '��Ϊ�գ���ʾ��ʾ1ҳ';
$_LANG['charge'] = '����������Ҫ��ֵ�Ľ��';

/* ����ȷ����Ϣ */
$_LANG['history_query_error'] = '�Բ����ڲ�ѯ�����з�������';
$_LANG['enable_ok'] = '��ϲ�����ѳɹ����ö��ŷ���';
$_LANG['enable_error'] = '�Բ��������ö��ŷ���ʧ�ܡ�';
$_LANG['disable_ok'] = '���Ѿ��ɹ�ע�����ŷ���';
$_LANG['disable_error'] = 'ע�����ŷ���ʧ�ܡ�';
$_LANG['register_ok'] = '��ϲ�����ѳɹ�ע����ŷ���';
$_LANG['register_error'] = '�Բ�����ע����ŷ���ʧ�ܡ�';
$_LANG['send_ok'] = '��ϲ�����Ķ����Ѿ��ɹ����ͣ�';
$_LANG['send_error'] = '�Բ����ڷ��Ͷ��Ź����з�������';
$_LANG['error_no'] = '�����ʶ';
$_LANG['error_msg'] = '��������';
$_LANG['empty_info'] = '���Ķ����ط���ϢΪ�ա�';

/* ��ֵ��¼ */
$_LANG['order_id'] = '������';
$_LANG['money'] = '��ֵ���';
$_LANG['log_date'] = '��ֵ����';

/* ���ͼ�¼ */
$_LANG['sent_phones'] = '�����ֻ�����';
$_LANG['content'] = '��������';
$_LANG['charge_num'] = '�Ʒ�����';
$_LANG['sent_date'] = '��������';
$_LANG['send_status'] = '����״̬';
$_LANG['status'][0] = 'ʧ��';
$_LANG['status'][1] = '�ɹ�';
$_LANG['user_list'] = 'ȫ���Ա';
$_LANG['please_select'] = '��ѡ���Ա�ȼ�';

/* ��ʾ */
$_LANG['test_now'] = '<span style="color:red;"></span>';
$_LANG['msg_price'] = '<span style="color:green;">����ÿ��0.1Ԫ(RMB)</span>';

/* API���صĴ�����Ϣ */
//--ע��
$_LANG['api_errors']['register'][1] = '��������Ϊ�ա�';
$_LANG['api_errors']['register'][2] = '������д����ȷ��';
$_LANG['api_errors']['register'][3] = '�û����Ѵ��ڡ�';
$_LANG['api_errors']['register'][4] = 'δ֪����';
$_LANG['api_errors']['register'][5] = '�ӿڴ���';
//--��ȡ���
$_LANG['api_errors']['get_balance'][1] = '�û������벻��ȷ��';
$_LANG['api_errors']['get_balance'][2] = '�û������á�';
//--���Ͷ���
$_LANG['api_errors']['send'][1] = '�û������벻��ȷ��';
$_LANG['api_errors']['send'][2] = '�������ݹ�����';
$_LANG['api_errors']['send'][3] = '��������Ӧ���ڵ�ǰʱ�䡣';
$_LANG['api_errors']['send'][4] = '����ĺ��롣';
$_LANG['api_errors']['send'][5] = '�˻����㡣';
$_LANG['api_errors']['send'][6] = '�˻��ѱ�ͣ�á�';
$_LANG['api_errors']['send'][7] = '�ӿڴ���';
//--��ʷ��¼
$_LANG['api_errors']['get_history'][1] = '�û������벻��ȷ��';
$_LANG['api_errors']['get_history'][2] = '���޼�¼��';
//--�û���֤
$_LANG['api_errors']['auth'][1] = '�������';
$_LANG['api_errors']['auth'][2] = '�û������ڡ�';

/* �û���������⵽�Ĵ�����Ϣ */
$_LANG['server_errors'][1] = 'ע����Ϣ��Ч��';//ERROR_INVALID_REGISTER_INFO
$_LANG['server_errors'][2] = '������Ϣ��Ч��';//ERROR_INVALID_ENABLE_INFO
$_LANG['server_errors'][3] = '���͵���Ϣ����';//ERROR_INVALID_SEND_INFO
$_LANG['server_errors'][4] = '��д�Ĳ�ѯ��Ϣ����';//ERROR_INVALID_HISTORY_QUERY
$_LANG['server_errors'][5] = '��Ч�������Ϣ��';//ERROR_INVALID_PASSPORT
$_LANG['server_errors'][6] = 'URL���ԡ�';//ERROR_INVALID_URL
$_LANG['server_errors'][7] = 'HTTP��Ӧ��Ϊ�ա�';//ERROR_EMPTY_RESPONSE
$_LANG['server_errors'][8] = '��Ч��XML�ļ���';//ERROR_INVALID_XML_FILE
$_LANG['server_errors'][9] = '��Ч�Ľڵ����֡�';//ERROR_INVALID_NODE_NAME
$_LANG['server_errors'][10] = '�洢ʧ�ܡ�';//ERROR_CANT_STORE
$_LANG['server_errors'][11] = '���Ź�����δ���';//ERROR_INVALID_PASSPORT

/* �ͻ���JS������ */
//--ע�������
$_LANG['js_languages']['password_empty_error'] = '���벻��Ϊ�ա�';
$_LANG['js_languages']['username_empty_error'] = '�û�������Ϊ�ա�';
$_LANG['js_languages']['username_format_error'] = '�û�����ʽ���ԡ�';
$_LANG['js_languages']['domain_empty_error'] = '��������Ϊ�ա�';
$_LANG['js_languages']['domain_format_error'] = '������ʽ���ԡ�';
$_LANG['js_languages']['send_empty_error'] = '�����ֻ����뷢�͵ȼ�������дһ�';
//--����
$_LANG['js_languages']['phone_empty_error'] = '����д�ֻ��š�';
$_LANG['js_languages']['phone_format_error'] = '�ֻ������ʽ���ԡ�';
$_LANG['js_languages']['msg_empty_error'] = '����д��Ϣ���ݡ�';
$_LANG['js_languages']['send_date_format_error'] = '��ʱ����ʱ���ʽ���ԡ�';
//--��ʷ��¼
$_LANG['js_languages']['start_date_format_error'] = '��ʼ���ڸ�ʽ���ԡ�';
$_LANG['js_languages']['end_date_format_error'] = '�������ڸ�ʽ���ԡ�';
//--��ֵ
$_LANG['js_languages']['money_empty_error'] = '��������Ҫ��ֵ�Ľ�';
$_LANG['js_languages']['money_format_error'] = '����ʽ���ԡ�';

?>