<?php

/**
 * ECSHOP ����������ʼ��Z���ļ�
 * ============================================================================
 * ������� 2005-2011 �Ϻ����ɾW�j�Ƽ����޹�˾���K�������Й�����
 * �Wվ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �@����һ������ܛ������ֻ���ڲ�����̘IĿ�ĵ�ǰ����������a�M���޸ĺ�
 * ʹ�ã������S��������a���κ���ʽ�κ�Ŀ�ĵ��ٰl�ѡ�
 * ============================================================================
 * $Author: liubo $
 * $Id: goods.php 17217 2011-01-19 06:29:08Z liubo $
 */

$_LANG['edit_goods'] = '��݋��Ʒ��Ϣ';
$_LANG['copy_goods'] = '�}�u��Ʒ��Ϣ';
$_LANG['continue_add_goods'] = '�^�m�������Ʒ';
$_LANG['back_goods_list'] = '������Ʒ�б�';
$_LANG['add_goods_ok'] = '�����Ʒ�ɹ���';
$_LANG['edit_goods_ok'] = '��݋��Ʒ�ɹ���';
$_LANG['trash_goods_ok'] = '����Ʒ�������վ�ɹ���';
$_LANG['restore_goods_ok'] = '߀ԭ��Ʒ�ɹ���';
$_LANG['drop_goods_ok'] = '�h����Ʒ�ɹ���';
$_LANG['batch_handle_ok'] = '���������ɹ���';
$_LANG['drop_goods_confirm'] = '���_��Ҫ�h��ԓ��Ʒ�᣿';
$_LANG['batch_drop_confirm'] = '�صׄh����Ʒ���h���cԓ��Ʒ���P��������Ϣ��\n���_��Ҫ�h���x�е���Ʒ�᣿';
$_LANG['trash_goods_confirm'] = '���_��Ҫ��ԓ��Ʒ�������վ�᣿';
$_LANG['batch_trash_confirm'] = '���_��Ҫ���x�е���Ʒ�������վ�᣿';
$_LANG['trash_product_confirm'] = '���_�JҪ��ԓ��Ʒ�h���᣿';
$_LANG['restore_goods_confirm'] = '���_��Ҫ��ԓ��Ʒ߀ԭ�᣿';
$_LANG['batch_restore_confirm'] = '���_��Ҫ���x�е���Ʒ߀ԭ�᣿';
$_LANG['batch_on_sale_confirm'] = '���_��Ҫ���x�е���Ʒ�ϼ܆᣿';
$_LANG['batch_not_on_sale_confirm'] = '���_��Ҫ���x�е���Ʒ�¼܆᣿';
$_LANG['batch_best_confirm'] = '���_��Ҫ���x�е���Ʒ�O�龫Ʒ�᣿';
$_LANG['batch_not_best_confirm'] = '���_��Ҫ���x�е���Ʒȡ����Ʒ�᣿';
$_LANG['batch_new_confirm'] = '���_��Ҫ���x�е���Ʒ�O����Ʒ�᣿';
$_LANG['batch_not_new_confirm'] = '���_��Ҫ���x�е���Ʒȡ����Ʒ�᣿';
$_LANG['batch_hot_confirm'] = '���_��Ҫ���x�е���Ʒ�O����N�᣿';
$_LANG['batch_not_hot_confirm'] = '���_��Ҫ���x�е���Ʒȡ�����N�᣿';
$_LANG['cannot_found_goods'] = '�Ҳ���ָ������Ʒ��';
$_LANG['sel_goods_type'] = 'Ո�x����Ʒ���';
$_LANG['sel_goods_suppliers'] = 'Ո�x��؛��';
/*------------------------------------------------------ */
//-- �DƬ̎�����P��ʾ��Ϣ
/*------------------------------------------------------ */
$_LANG['no_gd'] = '���ķ�������֧�� GD ���ߛ]�а��b̎��ԓ�DƬ��͵ĔUչ�졣';
$_LANG['img_not_exists'] = '�]���ҵ�ԭʼ�DƬ�������s�ԈDʧ����';
$_LANG['img_invalid'] = '�����s�ԈDʧ����������ς���һ���oЧ�ĈDƬ�ļ���';
$_LANG['create_dir_failed'] = 'images �ļ��A���Ɍ��������s�ԈDʧ����';
$_LANG['safe_mode_warning'] = '���ķ������\���ڰ�ȫģʽ�£����� %s Ŀ䛲����ڡ���������Ҫ���Є���ԓĿ䛲����ς��DƬ��';
$_LANG['not_writable_warning'] = 'Ŀ� %s ���Ɍ�������Ҫ��ԓĿ��O��Ɍ������ς��DƬ��';

/*------------------------------------------------------ */
//-- ��Ʒ�б�
/*------------------------------------------------------ */
$_LANG['goods_cat'] = '���з��';
$_LANG['goods_brand'] = '����Ʒ��';
$_LANG['intro_type'] = 'ȫ��';
$_LANG['keyword'] = '�P�I��';
$_LANG['is_best'] = '��Ʒ';
$_LANG['is_new'] = '��Ʒ';
$_LANG['is_hot'] = '���N';
$_LANG['is_promote'] = '�؃r';
$_LANG['all_type'] = 'ȫ�����]';
$_LANG['sort_order'] = '���]����';

$_LANG['goods_name'] = '��Ʒ���Q';
$_LANG['goods_sn'] = '؛̖';
$_LANG['shop_price'] = '�r��';
$_LANG['is_on_sale'] = '�ϼ�';
$_LANG['goods_number'] = '���';

$_LANG['copy'] = '�}�u';
$_LANG['item_list'] = '؛Ʒ�б�';

$_LANG['integral'] = '�e���~��';
$_LANG['on_sale'] = '�ϼ�';
$_LANG['not_on_sale'] = '�¼�';
$_LANG['best'] = '��Ʒ';
$_LANG['not_best'] = 'ȡ����Ʒ';
$_LANG['new'] = '��Ʒ';
$_LANG['not_new'] = 'ȡ����Ʒ';
$_LANG['hot'] = '���N';
$_LANG['not_hot'] = 'ȡ�����N';
$_LANG['move_to'] = '�D�Ƶ����';

// ajax
$_LANG['goods_name_null'] = 'Ոݔ����Ʒ���Q';
$_LANG['goods_sn_null'] = 'Ոݔ��؛̖';
$_LANG['shop_price_not_number'] = '�r���ǔ���';
$_LANG['shop_price_invalid'] = '��ݔ����һ���Ƿ����Ј��r��';
$_LANG['goods_sn_exists'] = '��ݔ���؛̖�Ѵ��ڣ�Ո�Qһ��';

/*------------------------------------------------------ */
//-- ���/��݋��Ʒ��Ϣ
/*------------------------------------------------------ */
$_LANG['tab_general'] = 'ͨ����Ϣ';
$_LANG['tab_detail'] = 'Ԕ������';
$_LANG['tab_mix'] = '������Ϣ';
$_LANG['tab_properties'] = '��Ʒ����';
$_LANG['tab_gallery'] = '��Ʒ����';
$_LANG['tab_linkgoods'] = '�P��Ʒ';
$_LANG['tab_groupgoods'] = '���';
$_LANG['tab_article'] = '�P����';

$_LANG['lab_goods_name'] = '��Ʒ���Q��';
$_LANG['lab_goods_sn'] = '��Ʒ؛̖��';
$_LANG['lab_goods_cat'] = '��Ʒ���';
$_LANG['lab_other_cat'] = '�Uչ���';
$_LANG['lab_goods_brand'] = '��ƷƷ�ƣ�';
$_LANG['lab_shop_price'] = '�����ۃr��';
$_LANG['lab_market_price'] = '�Ј��ۃr��';
$_LANG['lab_user_price'] = '���T�r��';
$_LANG['lab_promote_price'] = '���N�r��';
$_LANG['lab_promote_date'] = '���N���ڣ�';
$_LANG['lab_picture'] = '�ς���Ʒ�DƬ��';
$_LANG['lab_thumb'] = '�ς���Ʒ�s�ԈD��';
$_LANG['auto_thumb'] = '�Ԅ�������Ʒ�s�ԈD';
$_LANG['lab_keywords'] = '��Ʒ�P�I�~��';
$_LANG['lab_goods_brief'] = '��Ʒ����������';
$_LANG['lab_seller_note'] = '�̼҂��]��';
$_LANG['lab_goods_type'] = '��Ʒ��ͣ�';
$_LANG['lab_picture_url'] = '��Ʒ�DƬ�ⲿURL';
$_LANG['lab_thumb_url'] = '��Ʒ�s�ԈD�ⲿURL';

$_LANG['lab_goods_weight'] = '��Ʒ������';
$_LANG['unit_g'] = '��';
$_LANG['unit_kg'] = 'ǧ��';
$_LANG['lab_goods_number'] = '��Ʒ��攵����';
$_LANG['lab_warn_number'] = '��澯�攵����';
$_LANG['lab_integral'] = '�e��ُ�I���~��';
$_LANG['lab_give_integral'] = 'ٛ�����M�e�֔���';
$_LANG['lab_rank_integral'] = 'ٛ�͵ȼ��e�֔���';
$_LANG['lab_intro'] = '�������]��';
$_LANG['lab_is_on_sale'] = '�ϼܣ�';
$_LANG['lab_is_alone_sale'] = '��������ͨ��Ʒ�N�ۣ�';
$_LANG['lab_is_free_shipping'] = '�Ƿ�����\�M��Ʒ��';

$_LANG['compute_by_mp'] = '���Ј��rӋ��';

$_LANG['notice_goods_sn'] = '�������ݔ����Ʒ؛̖��ϵ�y���Ԅ�����һ��Ψһ��؛̖��';
$_LANG['notice_integral'] = '����̎������~��ُ�Iԓ��Ʒ�r������ʹ�÷e�ֵĽ��~';
$_LANG['notice_give_integral'] = 'ُ�Iԓ��Ʒ�rٛ�����M�e�֔�,-1��ʾ����Ʒ�r��ٛ��';
$_LANG['notice_rank_integral'] = 'ُ�Iԓ��Ʒ�rٛ�͵ȼ��e�֔�,-1��ʾ����Ʒ�r��ٛ��';
$_LANG['notice_seller_note'] = '�H���̼��Լ�������Ϣ';
$_LANG['notice_storage'] = '�������Ʒ��̓؛����Ʒ����؛Ʒ�r�鲻�ɾ�݋��B����攵ֻȡ�Q����̓؛������؛Ʒ����';
$_LANG['notice_keywords'] = '�ÿո�ָ�';
$_LANG['notice_user_price'] = '���T�r���-1�r��ʾ���T�r�񰴕��T�ȼ��ۿ���Ӌ�㡣��Ҳ���Ԟ�ÿ���ȼ�ָ��һ���̶��r��';
$_LANG['notice_goods_type'] = 'Ո�x����Ʒ��������ͣ��M�����ƴ���Ʒ�Č���';

$_LANG['on_sale_desc'] = '�򹴱�ʾ���S�N�ۣ���t�����S�N�ۡ�';
$_LANG['alone_sale'] = '�򹴱�ʾ��������ͨ��Ʒ�N�ۣ���tֻ�����������ٛƷ�N�ۡ�';
$_LANG['free_shipping'] = '���^��ʾ����Ʒ�����a���\�M���N����t���������\�MӋ�㡣';

$_LANG['invalid_goods_img'] = '��Ʒ�DƬ��ʽ�����_��';
$_LANG['invalid_goods_thumb'] = '��Ʒ�s�ԈD��ʽ�����_��';
$_LANG['invalid_img_url'] = '��Ʒ�����е�%s���DƬ��ʽ�����_!';

$_LANG['goods_img_too_big'] = '��Ʒ�DƬ�ļ�̫���ˣ����ֵ��%s�����o���ς���';
$_LANG['goods_thumb_too_big'] = '��Ʒ�s�ԈD�ļ�̫���ˣ����ֵ��%s�����o���ς���';
$_LANG['img_url_too_big'] = '��Ʒ�����е�%s���DƬ�ļ�̫���ˣ����ֵ��%s�����o���ς���';

$_LANG['integral_market_price'] = 'ȡ����';
$_LANG['upload_images'] = '�ς��DƬ';
$_LANG['spec_price'] = '���ԃr��';
$_LANG['drop_img_confirm'] = '���_��Ҫ�h��ԓ�DƬ�᣿';

$_LANG['select_font'] = '���w��ʽ';
$_LANG['font_styles'] = array('strong' => '�Ӵ�', 'em' => 'б�w', 'u' => '����', 'strike' => '�h����');

$_LANG['rapid_add_cat'] = '��ӷ��';
$_LANG['rapid_add_brand'] = '���Ʒ��';
$_LANG['category_manage'] = '�����';
$_LANG['brand_manage'] = 'Ʒ�ƹ���';
$_LANG['hide'] = '�[��';

$_LANG['lab_volume_price'] = '��Ʒ���݃r��';
$_LANG['volume_number'] = '���ݔ���';
$_LANG['volume_price'] = '���݃r��';
$_LANG['notice_volume_price'] = 'ُ�I�����_�����ݔ����r���ܵă��݃r��';
$_LANG['volume_number_continuous'] = '���ݔ������}��';

$_LANG['label_suppliers']          = '�x��؛�̣�';
$_LANG['suppliers_no']             = '��ָ����؛�̌��ڱ�����Ʒ';
$_LANG['suppliers_move_to']        = '�D�Ƶ���؛��';
$_LANG['lab_to_shopex']         = '�D�Ƶ��W��';

/*------------------------------------------------------ */
//-- �P��Ʒ
/*------------------------------------------------------ */

$_LANG['all_goods'] = '���x��Ʒ';
$_LANG['link_goods'] = '��ԓ��Ʒ�P����Ʒ';
$_LANG['single'] = '�����P';
$_LANG['double'] = '�p���P';
$_LANG['all_article'] = '���x����';
$_LANG['goods_article'] = '��ԓ��Ʒ�P������';
$_LANG['top_cat'] = '피����';

/*------------------------------------------------------ */
//-- �M����Ʒ
/*------------------------------------------------------ */

$_LANG['group_goods'] = 'ԓ��Ʒ�����';
$_LANG['price'] = '�r��';

/*------------------------------------------------------ */
//-- ��Ʒ����
/*------------------------------------------------------ */

$_LANG['img_desc'] = '�DƬ����';
$_LANG['img_url'] = '�ς��ļ�';
$_LANG['img_file'] = '����ݔ���ⲿ�DƬ朽ӵ�ַ';

/*------------------------------------------------------ */
//-- �P����
/*------------------------------------------------------ */
$_LANG['article_title'] = '�����}';

$_LANG['goods_not_exist'] = 'ԓ��Ʒ������';
$_LANG['goods_not_in_recycle_bin'] = 'ԓ��Ʒ��δ�������վ�����܄h��';

$_LANG['js_languages']['goods_name_not_null'] = '��Ʒ���Q���ܞ�ա�';
$_LANG['js_languages']['goods_cat_not_null'] = '��Ʒ�����x��';
$_LANG['js_languages']['category_cat_not_null'] = '������Q���ܞ��';
$_LANG['js_languages']['brand_cat_not_null'] = 'Ʒ�����Q���ܞ��';
$_LANG['js_languages']['goods_cat_not_leaf'] = '���x�����Ʒ����ǵ׼����Ո�x��׼����';
$_LANG['js_languages']['shop_price_not_null'] = '�����ۃr���ܞ�ա�';
$_LANG['js_languages']['shop_price_not_number'] = '�����ۃr���ǔ�ֵ��';

$_LANG['js_languages']['select_please'] = 'Ո�x��...';
$_LANG['js_languages']['button_add'] = '���';
$_LANG['js_languages']['button_del'] = '�h��';
$_LANG['js_languages']['spec_value_not_null'] = 'Ҏ���ܞ��';
$_LANG['js_languages']['spec_price_not_number'] = '�Ӄr���ǔ���';
$_LANG['js_languages']['market_price_not_number'] = '�Ј��r���ǔ���';
$_LANG['js_languages']['goods_number_not_int'] = '��Ʒ��治������';
$_LANG['js_languages']['warn_number_not_int'] = '��澯�治������';
$_LANG['js_languages']['promote_not_lt'] = '���N�_ʼ���ڲ��ܴ�춽Y������';
$_LANG['js_languages']['promote_start_not_null'] = '���N�_ʼ�r�g���ܞ��';
$_LANG['js_languages']['promote_end_not_null'] = '���N�Y���r�g���ܞ��';

$_LANG['js_languages']['drop_img_confirm'] = '���_��Ҫ�h��ԓ�DƬ�᣿';
$_LANG['js_languages']['batch_no_on_sale'] = '���_��Ҫ���x������Ʒ�¼܆᣿';
$_LANG['js_languages']['batch_trash_confirm'] = '���_��Ҫ���x�е���Ʒ�������վ�᣿';
$_LANG['js_languages']['go_category_page'] = '��퓔������Gʧ���_�JҪȥ��Ʒ������ӷ�᣿';
$_LANG['js_languages']['go_brand_page'] = '��퓔������Gʧ���_�JҪȥ��ƷƷ������Ʒ�Ɔ᣿';

$_LANG['js_languages']['volume_num_not_null'] = 'Ոݔ�냞�ݔ���';
$_LANG['js_languages']['volume_num_not_number'] = '���ݔ������ǔ���';
$_LANG['js_languages']['volume_price_not_null'] = 'Ոݔ�냞�݃r��';
$_LANG['js_languages']['volume_price_not_number'] = '���݃r���ǔ���';

$_LANG['js_languages']['cancel_color'] = '�o��ʽ';

/* ̓�M�� */
$_LANG['card'] = '�鿴̓�M����Ϣ';
$_LANG['replenish'] = '�a؛';
$_LANG['batch_card_add'] = '�����a؛';
$_LANG['add_replenish'] = '���̓�M������';

$_LANG['goods_number_error'] = '��Ʒ��攵���e�`';

/*------------------------------------------------------ */
//-- ؛Ʒ
/*------------------------------------------------------ */
$_LANG['product'] = '؛Ʒ';
$_LANG['product_info'] = '؛Ʒ��Ϣ';
$_LANG['specifications'] = 'Ҏ��';
$_LANG['total'] = '��Ӌ��';
$_LANG['add_products'] = '���؛Ʒ';
$_LANG['save_products'] = '����؛Ʒ�ɹ�';
$_LANG['product_id_null'] = '؛Ʒid���';
$_LANG['cannot_found_products'] = 'δ�ҵ�ָ��؛Ʒ';
$_LANG['product_batch_del_success'] = '؛Ʒ�����h���ɹ�';
$_LANG['product_batch_del_failure'] = '؛Ʒ�����h��ʧ��';
$_LANG['batch_product_add'] = '�������';
$_LANG['batch_product_edit'] = '������݋';
$_LANG['products_title'] = '��Ʒ���Q��%s';
$_LANG['products_title_2'] = '؛Ʒ��%s';
$_LANG['good_shop_price'] = '����Ʒ�r��%d��';
$_LANG['good_goods_sn'] = '����Ʒ؛̖��%s��';
$_LANG['exist_same_goods_sn'] = '؛Ʒ؛̖�����S�c�aƷ؛̖�؏�';
$_LANG['exist_same_product_sn'] = '؛Ʒ؛̖�؏�';
$_LANG['cannot_add_products'] = '؛Ʒ���ʧ��';
$_LANG['exist_same_goods_attr'] = '؛ƷҎ������؏�';
$_LANG['cannot_goods_number'] = '����Ʒ����؛Ʒ�������޸���Ʒ���';
$_LANG['not_exist_goods_attr'] = '����Ʒ������Ҏ��Ո�������Ҏ��';
$_LANG['goods_sn_exists'] = '������Ļ����Ѵ��ڣ��뻻һ��';
?>