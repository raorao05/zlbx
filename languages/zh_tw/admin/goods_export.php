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
 *
 * $Author: liubo $
 * $Id: goods_export.php 17217 2011-01-19 06:29:08Z liubo $
*/

$_LANG['user_guide'] =
        '<br/>ʹ��˵����' .
        '<ol>' .
          '<li>ʹ����������ÿ��ֻ������������������50����Ʒ��</li>' .
          '<li>����û���Ҫ����ĳ�����µ����е���Ʒ����������ѡ�����󣬲�����������ֱ��ѡ�����ݸ�ʽ�ͱ��뵼�����ɡ�</li>' .
        '</ol>';
$_LANG['export_taobao'] = '�����Ԍ�����֧�֔�����ʽ';
$_LANG['export_taobao_v43'] = '�����Ԍ�����V4.3֧�֔�����ʽ';
$_LANG['good_cat'] = '��Ʒ���';
$_LANG['select_please'] = 'Ո�x��Ҫ�����ķ��';
$_LANG['select_charset'] = 'Ո�x��Ҫ�����ľ��a';
$_LANG['export_taobao_v46'] = '�����Ԍ�����V4.6֧�֔�����ʽ';
$_LANG['goods_class'] = '��ؐ��ĿID';
$_LANG['tabobao_shipping'] = '�Ԍ�����';
$_LANG['post_express'] = 'ƽ�]�r��';
$_LANG['express'] = '���f�r��';
$_LANG['ems'] = 'EMS�r��';
$_LANG['notice_goods_class'] = '��ؐ��ĿID���Ԍ����ID���������_����Ո�0';

$_LANG['post_express_not_null'] = 'ƽ�]�r���횴��0';
$_LANG['express_not_null'] = '���f�r���횴��0';
$_LANG['ems_not_null'] = 'EMS�r���횴��0';

/* �Ԍ� */
$_LANG['taobao']['goods_name'] = '��ؐ���Q';
$_LANG['taobao']['goods_class'] = '��ؐ�Ŀ';
$_LANG['taobao']['shop_class'] = '���m�Ŀ';
$_LANG['taobao']['new_level'] = '���f�̶�';
$_LANG['taobao']['province'] = 'ʡ';
$_LANG['taobao']['city'] = '����';
$_LANG['taobao']['sell_type'] = '���۷�ʽ';
$_LANG['taobao']['shop_price'] = '��ؐ�r��';
$_LANG['taobao']['add_price'] = '�Ӄr����';
$_LANG['taobao']['goods_number'] = '��ؐ����';
$_LANG['taobao']['die_day'] = '��Ч��';
$_LANG['taobao']['load_type'] = '�\�M�Г�';
$_LANG['taobao']['post_express'] = 'ƽ�]';
$_LANG['taobao']['ems'] = 'EMS';
$_LANG['taobao']['express'] = '���f';
$_LANG['taobao']['pay_type'] = '���ʽ';
$_LANG['taobao']['allow_alipay'] = '֧����';
$_LANG['taobao']['invoice'] = '�lƱ';
$_LANG['taobao']['repair'] = '����';
$_LANG['taobao']['resend'] = '�Ԅ��ذl';
$_LANG['taobao']['is_store'] = '����}��';
$_LANG['taobao']['window'] = '�������]';
$_LANG['taobao']['add_time'] = '�l�ѕr�g';
$_LANG['taobao']['story'] = '�������';
$_LANG['taobao']['goods_desc'] = '��ؐ����';
$_LANG['taobao']['goods_img'] = '��ؐ�DƬ';
$_LANG['taobao']['goods_attr'] = '��ؐ����';
$_LANG['taobao']['group_buy'] = '�Fُ�r';
$_LANG['taobao']['group_buy_num'] = '��С�Fُ����';
$_LANG['taobao']['template'] = '�]�Mģ��ID';
$_LANG['taobao']['discount'] = '���T����';
$_LANG['taobao']['modify_time'] = '�޸ĕr�g';
$_LANG['taobao']['upload_status'] = '�ς���B';
$_LANG['taobao']['img_status'] = '�DƬ��B';

/*�Ա�4.6*/
$_LANG['taobao46']['goods_name'] = '��ؐ���Q';
$_LANG['taobao46']['goods_class'] = '��ؐ�Ŀ';
$_LANG['taobao46']['shop_class'] = '����Ŀ';
$_LANG['taobao46']['new_level'] = '���f�̶�';
$_LANG['taobao46']['province'] = 'ʡ';
$_LANG['taobao46']['city'] = '����';
$_LANG['taobao46']['sell_type'] = '���۷�ʽ';
$_LANG['taobao46']['shop_price'] = '��ؐ�r��';
$_LANG['taobao46']['add_price'] = '�Ӄr����';
$_LANG['taobao46']['goods_number'] = '��ؐ����';
$_LANG['taobao46']['die_day'] = '��Ч��';
$_LANG['taobao46']['load_type'] = '�\�M�Г�';
$_LANG['taobao46']['post_express'] = 'ƽ�]';
$_LANG['taobao46']['ems'] = 'EMS';
$_LANG['taobao46']['express'] = '���f';
$_LANG['taobao46']['pay_type'] = '���ʽ';
$_LANG['taobao46']['allow_alipay'] = '֧����';
$_LANG['taobao46']['invoice'] = '�lƱ';
$_LANG['taobao46']['repair'] = '����';
$_LANG['taobao46']['resend'] = '�Ԅ��ذl';
$_LANG['taobao46']['is_store'] = '����}��';
$_LANG['taobao46']['window'] = '�������]';
$_LANG['taobao46']['add_time'] = '�l���r�g';
$_LANG['taobao46']['story'] = '�������';
$_LANG['taobao46']['goods_desc'] = '��ؐ����';
$_LANG['taobao46']['goods_img'] = '��ؐ�DƬ';
$_LANG['taobao46']['goods_attr'] = '��ؐ����';
$_LANG['taobao46']['group_buy'] = '�Fُ�r';
$_LANG['taobao46']['group_buy_num'] = '��С�Fُ����';
$_LANG['taobao46']['template'] = '�]�Mģ��ID';
$_LANG['taobao46']['discount'] = '���T����';
$_LANG['taobao46']['modify_time'] = '�޸ĕr�g';
$_LANG['taobao46']['upload_status'] = '�ς���B';
$_LANG['taobao46']['img_status'] = '�DƬ��B';

$_LANG['taobao46']['rebate_proportion'] = '���c����';
$_LANG['taobao46']['new_picture'] = '�DƬ';
$_LANG['taobao46']['video'] = 'ҕ�l';
$_LANG['taobao46']['marketing_property_mix'] = '�N�ی��ԽM��';
$_LANG['taobao46']['user_input_ID_numbers'] = '�Ñ�ݔ��ID��';
$_LANG['taobao46']['input_user_name_value'] = '�Ñ�ݔ����-ֵ��';
$_LANG['taobao46']['sellers_code'] = '�̼Ҿ��a';
$_LANG['taobao46']['another_of_marketing_property'] = '�N�ی��Ԅe��';
$_LANG['taobao46']['charge_type'] = '�������';
$_LANG['taobao46']['treasure_number'] = '��ؐ��̖';
$_LANG['taobao46']['ID_number'] = '����ID';

$_LANG['export_paipai'] = '��������������֧�֔�����ʽ';
$_LANG['paipai']['id'] = 'id';
$_LANG['paipai']['tree_node_id'] = 'tree_node_id';
$_LANG['paipai']['old_tree_node_id'] = 'old_tree_node_id';
$_LANG['paipai']['title'] = 'title';
$_LANG['paipai']['id_in_web'] = 'id_in_web';
$_LANG['paipai']['auctionType'] = 'auctionType';
$_LANG['paipai']['category'] = 'category';
$_LANG['paipai']['shopCategoryId'] = 'shopCategoryId';
$_LANG['paipai']['pictURL'] = 'pictURL';
$_LANG['paipai']['quantity'] = 'quantity';
$_LANG['paipai']['duration'] = 'duration';
$_LANG['paipai']['startDate'] = 'startDate';
$_LANG['paipai']['stuffStatus'] = 'stuffStatus';
$_LANG['paipai']['price'] = 'price';
$_LANG['paipai']['increment'] = 'increment';
$_LANG['paipai']['prov'] = 'prov';
$_LANG['paipai']['city'] = 'city';
$_LANG['paipai']['shippingOption'] = 'shippingOption';
$_LANG['paipai']['ordinaryPostFee'] = 'ordinaryPostFee';
$_LANG['paipai']['fastPostFee'] = 'fastPostFee';
$_LANG['paipai']['paymentOption'] = 'paymentOption';
$_LANG['paipai']['haveInvoice'] = 'haveInvoice';
$_LANG['paipai']['haveGuarantee'] = 'haveGuarantee';
$_LANG['paipai']['secureTradeAgree'] = 'secureTradeAgree';
$_LANG['paipai']['autoRepost'] = 'autoRepost';
$_LANG['paipai']['shopWindow'] = 'shopWindow';
$_LANG['paipai']['failed_reason'] = 'failed_reason';
$_LANG['paipai']['pic_size'] = 'pic_size';
$_LANG['paipai']['pic_filename'] = 'pic_filename';
$_LANG['paipai']['pic'] = 'pic';
$_LANG['paipai']['description'] = 'description';
$_LANG['paipai']['story'] = 'story';
$_LANG['paipai']['putStore'] = 'putStore';
$_LANG['paipai']['pic_width'] = 'pic_width';
$_LANG['paipai']['pic_height'] = 'pic_height';
$_LANG['paipai']['skin'] = 'skin';
$_LANG['paipai']['prop'] = 'prop';

$_LANG['export_paipai4'] = '��������������3.0֧�֔�����ʽ';
$_LANG['paipai4']['id'] = 'id';
$_LANG['paipai4']['goods_name'] = '��Ʒ����';
$_LANG['paipai4']['auctionType'] = '���۷�ʽ';
$_LANG['paipai4']['category'] = '��Ʒ��Ŀ';
$_LANG['paipai4']['shopCategoryId'] = '������Ŀ';
$_LANG['paipai4']['quantity'] = '��Ʒ����';
$_LANG['paipai4']['duration'] = '��Ч��';
$_LANG['paipai4']['startDate'] = '��ʱ�ϼ�';
$_LANG['paipai4']['stuffStatus'] = '�¾ɳ̶�';
$_LANG['paipai4']['price'] = '�۸�';
$_LANG['paipai4']['increment'] = '�Ӽ۷���';
$_LANG['paipai4']['prov'] = 'ʡ';
$_LANG['paipai4']['city'] = '��';
$_LANG['paipai4']['shippingOption'] = '�˷ѳе�';
$_LANG['paipai4']['ordinaryPostFee'] = 'ƽ��';
$_LANG['paipai4']['fastPostFee'] = '���';
$_LANG['paipai4']['buyLimit'] = '��������';
$_LANG['paipai4']['paymentOption'] = '���ʽ';
$_LANG['paipai4']['haveInvoice'] = '�з�Ʊ';
$_LANG['paipai4']['haveGuarantee'] = '�б���';
$_LANG['paipai4']['secureTradeAgree'] = '֧�ֲƸ�ͨ';
$_LANG['paipai4']['autoRepost'] = '�Զ��ط�';
$_LANG['paipai4']['failed_reason'] = '����ԭ��';
$_LANG['paipai4']['pic_filename'] = 'ͼƬ';
$_LANG['paipai4']['description'] = '��Ʒ����';
$_LANG['paipai4']['shelfOption'] = '�ϼ�ѡ��';
$_LANG['paipai4']['skin'] = 'Ƥ�����';
$_LANG['paipai4']['attr'] = '����';
$_LANG['paipai4']['chengBao'] = '�ϱ�';
$_LANG['paipai4']['shopWindow'] = '����';

// �����ς���Ʒ���ֶ�
$_LANG['export_ecshop'] = '������ECShop������ʽ';
$_LANG['ecshop']['goods_name'] = '��Ʒ���Q';
$_LANG['ecshop']['goods_sn'] = '��Ʒ؛̖';
$_LANG['ecshop']['brand_name'] = '��ƷƷ��';   // ��Ҫ�D�Q��brand_id
$_LANG['ecshop']['market_price'] = '�Ј��ۃr';
$_LANG['ecshop']['shop_price'] = '�����ۃr';
$_LANG['ecshop']['integral'] = '�e��ُ�I�~��';
$_LANG['ecshop']['original_img'] = '��Ʒԭʼ�D';
$_LANG['ecshop']['goods_img'] = '��Ʒ�DƬ';
$_LANG['ecshop']['goods_thumb'] = '��Ʒ�s�ԈD';
$_LANG['ecshop']['keywords'] = '��Ʒ�P�I�~';
$_LANG['ecshop']['goods_brief'] = '��������';
$_LANG['ecshop']['goods_desc'] = 'Ԕ������';
$_LANG['ecshop']['goods_weight'] = '��Ʒ������kg��';
$_LANG['ecshop']['goods_number'] = '��攵��';
$_LANG['ecshop']['warn_number'] = '��澯�攵��';
$_LANG['ecshop']['is_best'] = '�Ƿ�Ʒ';
$_LANG['ecshop']['is_new'] = '�Ƿ���Ʒ';
$_LANG['ecshop']['is_hot'] = '�Ƿ���N';
$_LANG['ecshop']['is_on_sale'] = '�Ƿ��ϼ�';
$_LANG['ecshop']['is_alone_sale'] = '�ܷ�������ͨ��Ʒ�N��';
$_LANG['ecshop']['is_real'] = '�Ƿ��w��Ʒ';

//�Զ��x����������ʽ
$_LANG['export_custom'] = '�������Զ��x������ʽ';
$_LANG['custom']['goods_name'] = '��Ʒ���Q';
$_LANG['custom']['goods_sn'] = '��Ʒ؛̖';
$_LANG['custom']['brand_name'] = '��ƷƷ��';
$_LANG['custom']['market_price'] = '�Ј��ۃr';
$_LANG['custom']['shop_price'] = '�����ۃr';
$_LANG['custom']['integral'] = '�e��ُ�I�~��';
$_LANG['custom']['original_img'] = '��Ʒԭʼ�D';
$_LANG['custom']['goods_img'] = '��Ʒ�DƬ';
$_LANG['custom']['goods_thumb'] = '��Ʒ�s�ԈD';
$_LANG['custom']['keywords'] = '��Ʒ�P�I�~';
$_LANG['custom']['goods_brief'] = '��������';
$_LANG['custom']['goods_desc'] = 'Ԕ������';
$_LANG['custom']['goods_weight'] = '��Ʒ������kg��';
$_LANG['custom']['goods_number'] = '��攵��';
$_LANG['custom']['warn_number'] = '��澯�攵��';
$_LANG['custom']['is_best'] = '�Ƿ�Ʒ';
$_LANG['custom']['is_new'] = '�Ƿ���Ʒ';
$_LANG['custom']['is_hot'] = '�Ƿ���N';
$_LANG['custom']['is_on_sale'] = '�Ƿ��ϼ�';
$_LANG['custom']['is_alone_sale'] = '�ܷ�������ͨ��Ʒ�N��';
$_LANG['custom']['is_real'] = '�Ƿ��w��Ʒ';

$_LANG['custom_keyword'] = '�P�I��';
$_LANG['custom_goods_cat'] = '���з��';
$_LANG['custom_goods_brand'] = '����Ʒ��';
$_LANG['custom_goods_list'] = '�x����Ʒ������';
$_LANG['custom_goods_type'] = '������Ʒ���';
$_LANG['custom_export_list'] = 'ݔ����Ʒ������';
$_LANG['custom_up'] = '��';
$_LANG['custom_down'] = '��';
$_LANG['custom_goods_search'] = '�����l��';
$_LANG['custom_goods_field_not_null'] = 'ݔ������Ʒ�����в��ܞ��';

// �����l��
$_LANG['export_condition'] = '��Ʒ������������';
$_LANG['export_condition_search'] = '�� ��';
$_LANG['export_format'] = '������ʽ';

?>
