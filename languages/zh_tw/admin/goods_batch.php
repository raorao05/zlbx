<?php

/**
 * ECSHOP ��Ʒ�����ς����޸��Z���ļ�
 * ============================================================================
 * ������� 2005-2011 �Ϻ����ɾW�j�Ƽ����޹�˾���K�������Й�����
 * �Wվ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �@����һ������ܛ������ֻ���ڲ�����̘IĿ�ĵ�ǰ����������a�M���޸ĺ�
 * ʹ�ã������S��������a���κ���ʽ�κ�Ŀ�ĵ��ٰl�ѡ�
 * ============================================================================
 * $Author: liubo $
 * $Id: goods_batch.php 17217 2011-01-19 06:29:08Z liubo $
 */

$_LANG['select_method'] = '�x����Ʒ�ķ�ʽ��';
$_LANG['by_cat'] = '������Ʒ���Ʒ��';
$_LANG['by_sn'] = '������Ʒ؛̖';
$_LANG['select_cat'] = '�x����Ʒ���';
$_LANG['select_brand'] = '�x����ƷƷ�ƣ�';
$_LANG['goods_list'] = '��Ʒ�б�';
$_LANG['src_list'] = '���x�б�';
$_LANG['dest_list'] = '�x���б�';
$_LANG['input_sn'] = 'ݔ����Ʒ؛̖��<br />��ÿ��һ����';
$_LANG['edit_method'] = '��݋��ʽ��';
$_LANG['edit_each'] = '������݋';
$_LANG['edit_all'] = '�yһ��݋';
$_LANG['go_edit'] = '�M�뾎݋';

$_LANG['notice_edit'] = '���T�r���-1��ʾ���T�r�񌢸������T�ȼ��ۿ۱���Ӌ��';

$_LANG['goods_class'] = '��Ʒe';
$_LANG['g_class'][G_REAL] = '���w��Ʒ';
$_LANG['g_class'][G_CARD] = '̓�M��';

$_LANG['goods_sn'] = '؛̖';
$_LANG['goods_name'] = '��Ʒ���Q';
$_LANG['market_price'] = '�Ј��r��';
$_LANG['shop_price'] = '����r��';
$_LANG['integral'] = '�e��ُ�I';
$_LANG['give_integral'] = 'ٛ�ͷe��';
$_LANG['goods_number'] = '���';
$_LANG['brand'] = 'Ʒ��';

$_LANG['batch_edit_ok'] = '�����޸ĳɹ�';

$_LANG['export_format'] = '������ʽ';
$_LANG['export_ecshop'] = 'ecshop֧�֔�����ʽ';
$_LANG['export_taobao'] = '�Ԍ�����֧�֔�����ʽ';
$_LANG['export_taobao46'] = '�Ԍ�����4.6֧�֔�����ʽ';
$_LANG['export_paipai'] = '��������֧�֔�����ʽ';
$_LANG['export_paipai3'] = '��������3.0֧�֔�����ʽ';
$_LANG['goods_cat'] = '���ٷ��';
$_LANG['csv_file'] = '�ς�����csv�ļ���';
$_LANG['notice_file'] = '��CSV�ļ���һ���ς���Ʒ������ò�Ҫ���^1000��CSV�ļ���С��ò�Ҫ���^500K.��';
$_LANG['file_charset'] = '�ļ����a��';
$_LANG['download_file'] = '���d����CSV�ļ���%s��';
$_LANG['use_help'] = 'ʹ���f����' .
        '<ol>' .
          '<li>����ʹ�����T�����d�����Z�Ե�csv�ļ��������Ї��ȵ��Ñ����d���w�����Z�Ե��ļ�����̨�Ñ����d���w�Z�Ե��ļ���</li>' .
          '<li>�csv�ļ�������ʹ��excel���ı���݋�����_csv�ļ���<br />' .
              '�������Ƿ�Ʒ��֮������0����1��0�����񡹣�1�����ǡ���<br />' .
              '��Ʒ�DƬ����Ʒ�s�ԈDՈ���·���ĈDƬ�ļ���������·��������� [��Ŀ�]/images/ ��·��������DƬ·����[��Ŀ�]/images/200610/abc.jpg��ֻҪ� 200610/abc.jpg ���ɣ�<br />' .
              '<font style="color:#FE596A;">������Ԍ������ʽՈ�_��cvs���a���ھWվ�ľ��a���美�a�����_�������þ�݋ܛ���D�Q���a��</font></li>' .
          '<li>�������Ʒ�DƬ����Ʒ�s�ԈD�ς�������Ŀ䛣����磺[��Ŀ�]/images/200610/��</li>' .
              '<font style="color:#FE596A;">Ո�����ς���Ʒ�DƬ����Ʒ�s�ԈD���ς�csv�ļ�����t�DƬ�o��̎��</font></li>' .
          '<li>�x�����ς���Ʒ�ķ���Լ��ļ����a���ς�csv�ļ�</li>' .
        '</ol>';

$_LANG['js_languages']['please_select_goods'] = 'Ո���x����Ʒ';
$_LANG['js_languages']['please_input_sn'] = 'Ո��ݔ����Ʒ؛̖';
$_LANG['js_languages']['goods_cat_not_leaf'] = 'Ո�x��׼����';
$_LANG['js_languages']['please_select_cat'] = 'Ո���x�����ٷ��';
$_LANG['js_languages']['please_upload_file'] = 'Ո���ς�����csv�ļ�';

// �����ς���Ʒ���ֶ�
$_LANG['upload_goods']['goods_name'] = '��Ʒ���Q';
$_LANG['upload_goods']['goods_sn'] = '��Ʒ؛̖';
$_LANG['upload_goods']['brand_name'] = '��ƷƷ��';   // ��Ҫ�D�Q��brand_id
$_LANG['upload_goods']['market_price'] = '�Ј��ۃr';
$_LANG['upload_goods']['shop_price'] = '�����ۃr';
$_LANG['upload_goods']['integral'] = '�e��ُ�I�~��';
$_LANG['upload_goods']['original_img'] = '��Ʒԭʼ�D';
$_LANG['upload_goods']['goods_img'] = '��Ʒ�DƬ';
$_LANG['upload_goods']['goods_thumb'] = '��Ʒ�s�ԈD';
$_LANG['upload_goods']['keywords'] = '��Ʒ�P�I�~';
$_LANG['upload_goods']['goods_brief'] = '��������';
$_LANG['upload_goods']['goods_desc'] = 'Ԕ������';
$_LANG['upload_goods']['goods_weight'] = '��Ʒ������kg��';
$_LANG['upload_goods']['goods_number'] = '��攵��';
$_LANG['upload_goods']['warn_number'] = '��澯�攵��';
$_LANG['upload_goods']['is_best'] = '�Ƿ�Ʒ';
$_LANG['upload_goods']['is_new'] = '�Ƿ���Ʒ';
$_LANG['upload_goods']['is_hot'] = '�Ƿ���N';
$_LANG['upload_goods']['is_on_sale'] = '�Ƿ��ϼ�';
$_LANG['upload_goods']['is_alone_sale'] = '�ܷ�������ͨ��Ʒ�N��';
$_LANG['upload_goods']['is_real'] = '�Ƿ��w��Ʒ';

$_LANG['batch_upload_ok'] = '�����ς��ɹ�';
$_LANG['goods_upload_confirm'] = '�����ς��_�J';
?>