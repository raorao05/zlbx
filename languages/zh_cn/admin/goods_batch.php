<?php

/**
 * ECSHOP ��Ʒ�����ϴ����޸������ļ�
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: goods_batch.php 17217 2011-01-19 06:29:08Z liubo $
 */

$_LANG['select_method'] = 'ѡ����Ʒ�ķ�ʽ��';
$_LANG['by_cat'] = '������Ʒ���ࡢƷ��';
$_LANG['by_sn'] = '������Ʒ����';
$_LANG['select_cat'] = 'ѡ����Ʒ���ࣺ';
$_LANG['select_brand'] = 'ѡ����ƷƷ�ƣ�';
$_LANG['goods_list'] = '��Ʒ�б�';
$_LANG['src_list'] = '��ѡ�б�';
$_LANG['dest_list'] = 'ѡ���б�';
$_LANG['input_sn'] = '������Ʒ���ţ�<br />��ÿ��һ����';
$_LANG['edit_method'] = '�༭��ʽ��';
$_LANG['edit_each'] = '����༭';
$_LANG['edit_all'] = 'ͳһ�༭';
$_LANG['go_edit'] = '����༭';

$_LANG['notice_edit'] = '��Ա�۸�Ϊ-1��ʾ��Ա�۸񽫸��ݻ�Ա�ȼ��ۿ۱�������';

$_LANG['goods_class'] = '��Ʒ���';
$_LANG['g_class'][G_REAL] = 'ʵ����Ʒ';
$_LANG['g_class'][G_CARD] = '���⿨';

$_LANG['goods_sn'] = '����';
$_LANG['goods_name'] = '��Ʒ����';
$_LANG['market_price'] = '�г��۸�';
$_LANG['shop_price'] = '����۸�';
$_LANG['integral'] = '���ֹ���';
$_LANG['give_integral'] = '���ͻ���';
$_LANG['goods_number'] = '���';
$_LANG['brand'] = 'Ʒ��';

$_LANG['batch_edit_ok'] = '�����޸ĳɹ�';

$_LANG['export_format'] = '���ݸ�ʽ';
$_LANG['export_ecshop'] = 'ecshop֧�����ݸ�ʽ';
$_LANG['export_taobao'] = '�Ա�����֧�����ݸ�ʽ';
$_LANG['export_taobao46'] = '�Ա�����4.6֧�����ݸ�ʽ';
$_LANG['export_paipai'] = '��������֧�����ݸ�ʽ';
$_LANG['export_paipai3'] = '��������3.0֧�����ݸ�ʽ';
$_LANG['goods_cat'] = '�������ࣺ';
$_LANG['csv_file'] = '�ϴ�����csv�ļ���';
$_LANG['notice_file'] = '��CSV�ļ���һ���ϴ���Ʒ������ò�Ҫ����1000��CSV�ļ���С��ò�Ҫ����500K.��';
$_LANG['file_charset'] = '�ļ����룺';
$_LANG['download_file'] = '��������CSV�ļ���%s��';
$_LANG['use_help'] = 'ʹ��˵����' .
        '<ol>' .
          '<li>����ʹ��ϰ�ߣ�������Ӧ���Ե�csv�ļ��������й��ڵ��û����ؼ����������Ե��ļ�����̨�û����ط������Ե��ļ���</li>' .
          '<li>��дcsv�ļ�������ʹ��excel���ı��༭����csv�ļ���<br />' .
              '�������Ƿ�Ʒ��֮�࣬��д����0����1��0�����񡱣�1�����ǡ���<br />' .
              '��ƷͼƬ����Ʒ����ͼ����д��·����ͼƬ�ļ���������·��������� [��Ŀ¼]/images/ ��·��������ͼƬ·��Ϊ[��Ŀ¼]/images/200610/abc.jpg��ֻҪ��д 200610/abc.jpg ���ɣ�<br />' .
               '<font style="color:#FE596A;">������Ա������ʽ��ȷ��cvs����Ϊ����վ�ı��룬����벻��ȷ�������ñ༭���ת�����롣</font></li>' .
          '<li>����д����ƷͼƬ����Ʒ����ͼ�ϴ�����ӦĿ¼�����磺[��Ŀ¼]/images/200610/��<br />'.
              '<font style="color:#FE596A;">�������ϴ���ƷͼƬ����Ʒ����ͼ���ϴ�csv�ļ�������ͼƬ�޷�����</font></li>' .
          '<li>ѡ�����ϴ���Ʒ�ķ����Լ��ļ����룬�ϴ�csv�ļ�</li>' .
        '</ol>';

$_LANG['js_languages']['please_select_goods'] = '����ѡ����Ʒ';
$_LANG['js_languages']['please_input_sn'] = '����������Ʒ����';
$_LANG['js_languages']['goods_cat_not_leaf'] = '��ѡ��׼�����';
$_LANG['js_languages']['please_select_cat'] = '����ѡ����������';
$_LANG['js_languages']['please_upload_file'] = '�����ϴ�����csv�ļ�';

// �����ϴ���Ʒ���ֶ�
$_LANG['upload_goods']['goods_name'] = '��Ʒ����';
$_LANG['upload_goods']['goods_sn'] = '��Ʒ����';
$_LANG['upload_goods']['brand_name'] = '��ƷƷ��';   // ��Ҫת����brand_id
$_LANG['upload_goods']['market_price'] = '�г��ۼ�';
$_LANG['upload_goods']['shop_price'] = '�����ۼ�';
$_LANG['upload_goods']['integral'] = '���ֹ�����';
$_LANG['upload_goods']['original_img'] = '��Ʒԭʼͼ';
$_LANG['upload_goods']['goods_img'] = '��ƷͼƬ';
$_LANG['upload_goods']['goods_thumb'] = '��Ʒ����ͼ';
$_LANG['upload_goods']['keywords'] = '��Ʒ�ؼ���';
$_LANG['upload_goods']['goods_brief'] = '������';
$_LANG['upload_goods']['goods_desc'] = '��ϸ����';
$_LANG['upload_goods']['goods_weight'] = '��Ʒ������kg��';
$_LANG['upload_goods']['goods_number'] = '�������';
$_LANG['upload_goods']['warn_number'] = '��澯������';
$_LANG['upload_goods']['is_best'] = '�Ƿ�Ʒ';
$_LANG['upload_goods']['is_new'] = '�Ƿ���Ʒ';
$_LANG['upload_goods']['is_hot'] = '�Ƿ�����';
$_LANG['upload_goods']['is_on_sale'] = '�Ƿ��ϼ�';
$_LANG['upload_goods']['is_alone_sale'] = '�ܷ���Ϊ��ͨ��Ʒ����';
$_LANG['upload_goods']['is_real'] = '�Ƿ�ʵ����Ʒ';

$_LANG['batch_upload_ok'] = '�����ϴ��ɹ�';
$_LANG['goods_upload_confirm'] = '�����ϴ�ȷ��';
?>