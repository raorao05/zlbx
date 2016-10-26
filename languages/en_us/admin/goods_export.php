<?php

/**
 * ECSHOP Vote management
 * ============================================================================
 * All right reserved (C) 2005-2011 Beijing Yi Shang Interactive Technology
 * Development Ltd.
 * Web site: http://www.ecshop.com
 * ----------------------------------------------------------------------------
 * This is a free/open source software��it means that you can modify, use and
 * republish the program code, on the premise of that your behavior is not for
 * commercial purposes.
 * ============================================================================
 * $Author: liubo $
 * $Id: goods_export.php 17217 2011-01-19 06:29:08Z liubo $
*/

$_LANG['user_guide'] =
        '<br/>Help:' .
        '<ol>' .
          '<li>Use the search conditions permit only english eligible merchandise 50.</li>' .
          '<li>If the user required to export certain categories of merchandise all under the conditions choose to triage, no click search, the direct choice of data formats and encoding can be derived.</li>' .
        '</ol>';
$_LANG['export_taobao'] = 'Export Taobao Assistant Supporting data formats';
$_LANG['export_taobao_v43'] = 'Export Taobao AssistantV4.3 upporting data formats';
$_LANG['export_taobao_v46'] = 'Export Taobao AssistantV4.6 upporting data formats';
$_LANG['good_cat'] = 'Merchandise categories';
$_LANG['select_please'] = 'Please select Export Classification';
$_LANG['select_charset'] = 'Please choose to export charset';

$_LANG['goods_class'] = 'Precious columnsID';
$_LANG['tabobao_shipping'] = 'Taobao distribution';
$_LANG['post_express'] = 'Ordinary price';
$_LANG['express'] = 'Express Price';
$_LANG['ems'] = 'EMS Price';
$_LANG['notice_goods_class'] = 'ID for the baby section Taobao classification ID, if uncertain, please fill 0';

$_LANG['post_express_not_null'] = 'Ordinary price must be greater than 0';
$_LANG['express_not_null'] = 'Express the price must be greater than 0';
$_LANG['ems_not_null'] = 'EMS price must be greater than 0';


/* �Ա� */
$_LANG['taobao']['goods_name'] = '��������';
$_LANG['taobao']['goods_class'] = '������Ŀ';
$_LANG['taobao']['shop_class'] = '������Ŀ';
$_LANG['taobao']['new_level'] = '�¾ɳ̶�';
$_LANG['taobao']['province'] = 'ʡ';
$_LANG['taobao']['city'] = '����';
$_LANG['taobao']['sell_type'] = '���۷�ʽ';
$_LANG['taobao']['shop_price'] = '�����۸�';
$_LANG['taobao']['add_price'] = '�Ӽ۷���';
$_LANG['taobao']['goods_number'] = '��������';
$_LANG['taobao']['die_day'] = '��Ч��';
$_LANG['taobao']['load_type'] = '�˷ѳе�';
$_LANG['taobao']['post_express'] = 'ƽ��';
$_LANG['taobao']['ems'] = 'EMS';
$_LANG['taobao']['express'] = '���';
$_LANG['taobao']['pay_type'] = '���ʽ';
$_LANG['taobao']['allow_alipay'] = '֧����';
$_LANG['taobao']['invoice'] = '��Ʊ';
$_LANG['taobao']['repair'] = '����';
$_LANG['taobao']['resend'] = '�Զ��ط�';
$_LANG['taobao']['is_store'] = '����ֿ�';
$_LANG['taobao']['window'] = '�����Ƽ�';
$_LANG['taobao']['add_time'] = '����ʱ��';
$_LANG['taobao']['story'] = '�������';
$_LANG['taobao']['goods_desc'] = '��������';
$_LANG['taobao']['goods_img'] = '����ͼƬ';
$_LANG['taobao']['goods_attr'] = '��������';
$_LANG['taobao']['group_buy'] = '�Ź���';
$_LANG['taobao']['group_buy_num'] = '��С�Ź�����';
$_LANG['taobao']['template'] = '�ʷ�ģ��ID';
$_LANG['taobao']['discount'] = '��Ա����';
$_LANG['taobao']['modify_time'] = '�޸�ʱ��';
$_LANG['taobao']['upload_status'] = '�ϴ�״̬';
$_LANG['taobao']['img_status'] = 'ͼƬ״̬';
/* �Ա� */
$_LANG['taobao46']['goods_name'] = '��������';
$_LANG['taobao46']['goods_class'] = '������Ŀ';
$_LANG['taobao46']['shop_class'] = '������Ŀ';
$_LANG['taobao46']['new_level'] = '�¾ɳ̶�';
$_LANG['taobao46']['province'] = 'ʡ';
$_LANG['taobao46']['city'] = '����';
$_LANG['taobao46']['sell_type'] = '���۷�ʽ';
$_LANG['taobao46']['shop_price'] = '�����۸�';
$_LANG['taobao46']['add_price'] = '�Ӽ۷���';
$_LANG['taobao46']['goods_number'] = '��������';
$_LANG['taobao46']['die_day'] = '��Ч��';
$_LANG['taobao46']['load_type'] = '�˷ѳе�';
$_LANG['taobao46']['post_express'] = 'ƽ��';
$_LANG['taobao46']['ems'] = 'EMS';
$_LANG['taobao46']['express'] = '���';
$_LANG['taobao46']['pay_type'] = '���ʽ';
$_LANG['taobao46']['allow_alipay'] = '֧����';
$_LANG['taobao46']['invoice'] = '��Ʊ';
$_LANG['taobao46']['repair'] = '����';
$_LANG['taobao46']['resend'] = '�Զ��ط�';
$_LANG['taobao46']['is_store'] = '����ֿ�';
$_LANG['taobao46']['window'] = '�����Ƽ�';
$_LANG['taobao46']['add_time'] = '����ʱ��';
$_LANG['taobao46']['story'] = '�������';
$_LANG['taobao46']['goods_desc'] = '��������';
$_LANG['taobao46']['goods_img'] = '����ͼƬ';
$_LANG['taobao46']['goods_attr'] = '��������';
$_LANG['taobao46']['group_buy'] = '�Ź���';
$_LANG['taobao46']['group_buy_num'] = '��С�Ź�����';
$_LANG['taobao46']['template'] = '�ʷ�ģ��ID';
$_LANG['taobao46']['discount'] = '��Ա����';
$_LANG['taobao46']['modify_time'] = '�޸�ʱ��';
$_LANG['taobao46']['upload_status'] = '�ϴ�״̬';
$_LANG['taobao46']['img_status'] = 'ͼƬ״̬';

$_LANG['taobao46']['img_status'] = '�������';
$_LANG['taobao46']['img_status'] = '��ͼƬ';
$_LANG['taobao46']['img_status'] = '��Ƶ';
$_LANG['taobao46']['img_status'] = '�����������';
$_LANG['taobao46']['img_status'] = '�û�����ID��';
$_LANG['taobao46']['img_status'] = '�û�������-ֵ��';
$_LANG['taobao46']['img_status'] = '�̼ұ���';
$_LANG['taobao46']['img_status'] = '�������Ա���';
$_LANG['taobao46']['img_status'] = '��������';
$_LANG['taobao46']['img_status'] = '�������';
$_LANG['taobao46']['img_status'] = '����ID';

$_LANG['export_paipai'] = 'Export to patted Assistant Supporting data formats';
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


$_LANG['export_paipai4'] = 'Export to patted Assistant Supporting 3.0 data formats';
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

// �����ϴ���Ʒ���ֶ�
$_LANG['export_ecshop'] = 'Export to ECShop data format';
$_LANG['ecshop']['goods_name'] = '��Ʒ����';
$_LANG['ecshop']['goods_sn'] = '��Ʒ����';
$_LANG['ecshop']['brand_name'] = '��ƷƷ��';   // ��Ҫת����brand_id
$_LANG['ecshop']['market_price'] = '�г��ۼ�';
$_LANG['ecshop']['shop_price'] = '�����ۼ�';
$_LANG['ecshop']['integral'] = '���ֹ�����';
$_LANG['ecshop']['original_img'] = '��Ʒԭʼͼ';
$_LANG['ecshop']['goods_img'] = '��ƷͼƬ';
$_LANG['ecshop']['goods_thumb'] = '��Ʒ����ͼ';
$_LANG['ecshop']['keywords'] = '��Ʒ�ؼ���';
$_LANG['ecshop']['goods_brief'] = '������';
$_LANG['ecshop']['goods_desc'] = '��ϸ����';
$_LANG['ecshop']['goods_weight'] = '��Ʒ������kg��';
$_LANG['ecshop']['goods_number'] = '�������';
$_LANG['ecshop']['warn_number'] = '��澯������';
$_LANG['ecshop']['is_best'] = '�Ƿ�Ʒ';
$_LANG['ecshop']['is_new'] = '�Ƿ���Ʒ';
$_LANG['ecshop']['is_hot'] = '�Ƿ�����';
$_LANG['ecshop']['is_on_sale'] = '�Ƿ��ϼ�';
$_LANG['ecshop']['is_alone_sale'] = '�ܷ���Ϊ��ͨ��Ʒ����';
$_LANG['ecshop']['is_real'] = '�Ƿ�ʵ����Ʒ';

//�Զ��嵼�����ݸ�ʽ
$_LANG['export_custom'] = 'Export to a custom data format';
$_LANG['custom']['goods_name'] = 'goods_name';
$_LANG['custom']['goods_sn'] = 'goods_sn';
$_LANG['custom']['brand_name'] = 'brand_name';
$_LANG['custom']['market_price'] = 'market_price';
$_LANG['custom']['shop_price'] = 'shop_price';
$_LANG['custom']['integral'] = 'integral';
$_LANG['custom']['original_img'] = 'riginal_img';
$_LANG['custom']['goods_img'] = 'goods_img';
$_LANG['custom']['goods_thumb'] = 'goods_thumb';
$_LANG['custom']['keywords'] = 'keywords';
$_LANG['custom']['goods_brief'] = 'goods_brief';
$_LANG['custom']['goods_desc'] = 'goods_desc';
$_LANG['custom']['goods_weight'] = 'goods_weight(kg)';
$_LANG['custom']['goods_number'] = 'goods_number';
$_LANG['custom']['warn_number'] = 'warn_number';
$_LANG['custom']['is_best'] = 'is_best';
$_LANG['custom']['is_new'] = 'is_new';
$_LANG['custom']['is_hot'] = 'is_hot';
$_LANG['custom']['is_on_sale'] = 'is_on_sale';
$_LANG['custom']['is_alone_sale'] = 'is_alone_sale';
$_LANG['custom']['is_real'] = 'is_real';

$_LANG['custom_keyword'] = 'Keyword';
$_LANG['custom_goods_cat'] = 'All Categories';
$_LANG['custom_goods_brand'] = 'All brands';
$_LANG['custom_goods_list'] = 'Select merchandise data columns';
$_LANG['custom_goods_type'] = 'All types of merchandise';
$_LANG['custom_export_list'] = 'Merchandise export data columns';
$_LANG['custom_up'] = 'On';
$_LANG['custom_down'] = 'Under';
$_LANG['custom_goods_search'] = 'Export conditions';
$_LANG['custom_goods_field_not_null'] = 'Output data out of the merchandise should not be empty';

// ��������
$_LANG['export_condition'] = 'Export volume of goods data';
$_LANG['export_condition_search'] = 'Search';
$_LANG['export_format'] = 'Data Format';

?>
