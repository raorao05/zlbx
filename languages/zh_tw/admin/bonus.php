<?php

/**
 * ECSHOP �t�����/�t���������
 * ============================================================================
 * ������� 2005-2011 �Ϻ����ɾW�j�Ƽ����޹�˾���K�������Й�����
 * �Wվ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �@����һ������ܛ������ֻ���ڲ�����̘IĿ�ĵ�ǰ����������a�M���޸ĺ�
 * ʹ�ã������S��������a���κ���ʽ�κ�Ŀ�ĵ��ٰl�ѡ�
 * ============================================================================
 * $Author: liubo $
 * $Id: bonus.php 17217 2011-01-19 06:29:08Z liubo $
*/
/* �t������ֶ���Ϣ */
$_LANG['bonus_type'] = '�t�����';
$_LANG['bonus_list'] = '�t���б�';
$_LANG['type_name'] = '������Q';
$_LANG['type_money'] = '�t�����~';
$_LANG['min_goods_amount'] = '��Сӆ�ν��~';
$_LANG['notice_min_goods_amount'] = 'ֻ����Ʒ�����~�_���@������ӆ�β���ʹ���@�N�t��';
$_LANG['min_amount'] = 'ӆ������';
$_LANG['max_amount'] = 'ӆ������';
$_LANG['send_startdate'] = '�l����ʼ����';
$_LANG['send_enddate'] = '�l�ŽY������';

$_LANG['use_startdate'] = 'ʹ����ʼ����';
$_LANG['use_enddate'] = 'ʹ�ýY������';
$_LANG['send_count'] = '�l�Ŕ���';
$_LANG['use_count'] = 'ʹ�Ô���';
$_LANG['send_method'] = '��ΰl�Ŵ���ͼt��';
$_LANG['send_type'] = '�l�����';
$_LANG['param'] = '����';
$_LANG['no_use'] = 'δʹ��';
$_LANG['yuan'] = 'Ԫ';
$_LANG['user_list'] = '���T�б�';
$_LANG['type_name_empty'] = '�t��������Q���ܞ�գ�';
$_LANG['type_money_empty'] = '�t�����~���ܞ�գ�';
$_LANG['min_amount_empty'] = '�t����͵�ӆ�����޲��ܞ�գ�';
$_LANG['max_amount_empty'] = '�t����͵�ӆ�����޲��ܞ�գ�';
$_LANG['send_count_empty'] = '�t����͵İl�Ŕ������ܞ�գ�';

$_LANG['send_by'][SEND_BY_USER] = '���Ñ��l��';
$_LANG['send_by'][SEND_BY_GOODS] = '����Ʒ�l��';
$_LANG['send_by'][SEND_BY_ORDER] = '��ӆ�ν��~�l��';
$_LANG['send_by'][SEND_BY_PRINT] = '���°l�ŵļt��';
$_LANG['report_form'] = '���';
$_LANG['send'] = '�l��';
$_LANG['bonus_excel_file'] = '���¼t����Ϣ�б�';

$_LANG['goods_cat'] = '�x����Ʒ���';
$_LANG['goods_brand'] = '��ƷƷ��';
$_LANG['goods_key'] = '��Ʒ�P�I��';
$_LANG['all_goods'] = '���x��Ʒ';
$_LANG['send_bouns_goods'] = '�l�Ŵ���ͼt������Ʒ';
$_LANG['remove_bouns'] = '�Ƴ��t��';
$_LANG['all_remove_bouns'] = 'ȫ���Ƴ�';
$_LANG['goods_already_bouns'] = 'ԓ��Ʒ�ѽ��l���^������͵ļt����!';
$_LANG['send_user_empty'] = '���]���x����Ҫ�l�żt���ĕ��T��Ո����!';
$_LANG['batch_drop_success'] = '�ɹ��h���� %d ���Ñ��t��';
$_LANG['sendbonus_count'] = '���l���� %d ���t����';
$_LANG['send_bouns_error'] = '�l�͕��T�t�����e, Ո������ԇ��';
$_LANG['no_select_bonus'] = '���]���x����Ҫ�h�����Ñ��t��';
$_LANG['bonustype_edit'] = '��݋�t�����';
$_LANG['bonustype_view'] = '�鿴Ԕ��';
$_LANG['drop_bonus'] = '�h���t��';
$_LANG['send_bonus'] = '�l�żt��';
$_LANG['continus_add'] = '�^�m��Ӽt�����';
$_LANG['back_list'] = '���ؼt������б�';
$_LANG['continue_add'] = '�^�m��Ӽt��';
$_LANG['back_bonus_list'] = '���ؼt���б�';
$_LANG['validated_email'] = 'ֻ�oͨ�^�]����C���Ñ��l�żt��';

/* ��ʾ��Ϣ */
$_LANG['attradd_succed'] = '�����ɹ�!';
$_LANG['js_languages']['type_name_empty'] = 'Ոݔ��t��������Q!';
$_LANG['js_languages']['type_money_empty'] = 'Ոݔ��t����̓r��!';
$_LANG['js_languages']['order_money_empty'] = 'Ոݔ��ӆ�ν��~!';
$_LANG['js_languages']['type_money_isnumber'] = '��ͽ��~��횞锵�ָ�ʽ!';
$_LANG['js_languages']['order_money_isnumber'] = 'ӆ�ν��~��횞锵�ָ�ʽ!';
$_LANG['js_languages']['bonus_sn_empty'] = 'Ոݔ��t��������̖!';
$_LANG['js_languages']['bonus_sn_number'] = '�t��������̖����ǔ���!';
$_LANG['send_count_error'] = '�t���İl�Ŕ��������һ������!';
$_LANG['js_languages']['bonus_sum_empty'] = 'Ոݔ����Ҫ�l�ŵļt������!';
$_LANG['js_languages']['bonus_sum_number'] = '�t���İl�Ŕ��������һ������!';
$_LANG['js_languages']['bonus_type_empty'] = 'Ո�x��t������ͽ��~!';
$_LANG['js_languages']['user_rank_empty'] = '���]��ָ�����T�ȼ�!';
$_LANG['js_languages']['user_name_empty'] = '��������Ҫ�x��һ�����T!';
$_LANG['js_languages']['invalid_min_amount'] = 'Ոݔ��ӆ�����ޣ����0�Ĕ��֣�';
$_LANG['js_languages']['send_start_lt_end'] = '�t���l���_ʼ���ڲ��ܴ�춽Y������';
$_LANG['js_languages']['use_start_lt_end'] = '�t��ʹ���_ʼ���ڲ��ܴ�춽Y������';

$_LANG['order_money_notic'] = 'ֻҪӆ�ν��~�_��ԓ��ֵ���͕��l�żt���o�Ñ�';
$_LANG['type_money_notic'] = '����͵ļt�����Ե��N�Ľ��~';
$_LANG['send_startdate_notic'] = 'ֻ�Ю�ǰ�r�g�����ʼ���ںͽ�ֹ����֮�g�r������͵ļt���ſ��԰l��';
$_LANG['use_startdate_notic'] = 'ֻ�Ю�ǰ�r�g�����ʼ���ںͽ�ֹ����֮�g�r������͵ļt���ſ���ʹ��';
$_LANG['type_name_exist'] = '����͵����Q�ѽ�����!';
$_LANG['type_money_error'] = '���~����ǔ��ցK�Ҳ���С� 0 !';
$_LANG['bonus_sn_notic'] = '��ʾ:�t������̖����λ����̖�N�Ӽ�����λ�S�C���ֽM��';
$_LANG['creat_bonus'] = '������ ';
$_LANG['creat_bonus_num'] = ' ���t������̖';
$_LANG['bonus_sn_error'] = '�t������̖����ǔ���!';
$_LANG['send_user_notice'] = '�oָ�����Ñ��l�żt���r,Ո�ڴ�ݔ���Ñ���, �����Ñ�֮�gՈ�ö�̖(,)�ָ��_<br />��:liry, wjz, zwj';

/* �t����Ϣ�ֶ� */
$_LANG['bonus_id'] = '��̖';
$_LANG['bonus_type_id'] = '��ͽ��~';
$_LANG['send_bonus_count'] = '�t������';
$_LANG['start_bonus_sn'] = '��ʼ����̖';
$_LANG['bonus_sn'] = '�t������̖';
$_LANG['user_id'] = 'ʹ�Õ��T';
$_LANG['used_time'] = 'ʹ�Õr�g';
$_LANG['order_id'] = 'ӆ��̖';
$_LANG['send_mail'] = '�l�]��';
$_LANG['emailed'] = '�]��֪ͨ';
$_LANG['mail_status'][BONUS_NOT_MAIL] = 'δ�l';
$_LANG['mail_status'][BONUS_MAIL_FAIL] = '�Ѱlʧ��';
$_LANG['mail_status'][BONUS_MAIL_SUCCEED] = '�Ѱl�ɹ�';

$_LANG['sendtouser'] = '�oָ���Ñ��l�żt��';
$_LANG['senduserrank'] = '���Ñ��ȼ��l�żt��';
$_LANG['userrank'] = '�Ñ��ȼ�';
$_LANG['select_rank'] = '�x����T�ȼ�...';
$_LANG['keywords'] = '�P�I�֣�';
$_LANG['userlist'] = '���T�б�';
$_LANG['send_to_user'] = '�o�����Ñ��l�żt��';
$_LANG['search_users'] = '�������T';
$_LANG['confirm_send_bonus'] = '�_���l�ͼt��';
$_LANG['bonus_not_exist'] = 'ԓ�t��������';
$_LANG['success_send_mail'] = '%d ���]���ѱ������]���б�';
$_LANG['send_continue'] = '�^�m�l�żt��';
?>