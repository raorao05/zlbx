<?php

/**
 * ECSHOP ����������ʼҳ�����ļ�
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: goods.php 17217 2011-01-19 06:29:08Z liubo $
*/

$_LANG['edit_goods'] = '�༭��Ʒ��Ϣ';
$_LANG['copy_goods'] = '������Ʒ��Ϣ';
$_LANG['continue_add_goods'] = '�����������Ʒ';
$_LANG['back_goods_list'] = '������Ʒ�б�';
$_LANG['add_goods_ok'] = '�����Ʒ�ɹ���';
$_LANG['edit_goods_ok'] = '�༭��Ʒ�ɹ���';
$_LANG['trash_goods_ok'] = '����Ʒ�������վ�ɹ���';
$_LANG['restore_goods_ok'] = '��ԭ��Ʒ�ɹ���';
$_LANG['drop_goods_ok'] = 'ɾ����Ʒ�ɹ���';
$_LANG['batch_handle_ok'] = '���������ɹ���';
$_LANG['drop_goods_confirm'] = '��ȷʵҪɾ������Ʒ��';
$_LANG['batch_drop_confirm'] = '����ɾ����Ʒ��ɾ�������Ʒ�йص�������Ϣ��\n��ȷʵҪɾ��ѡ�е���Ʒ��';
$_LANG['trash_goods_confirm'] = '��ȷʵҪ�Ѹ���Ʒ�������վ��';
$_LANG['trash_product_confirm'] = '��ȷʵҪ�Ѹû�Ʒɾ����';
$_LANG['batch_trash_confirm'] = '��ȷʵҪ��ѡ�е���Ʒ�������վ��';
$_LANG['restore_goods_confirm'] = '��ȷʵҪ�Ѹ���Ʒ��ԭ��';
$_LANG['batch_restore_confirm'] = '��ȷʵҪ��ѡ�е���Ʒ��ԭ��';
$_LANG['batch_on_sale_confirm'] = '��ȷʵҪ��ѡ�е���Ʒ�ϼ���';
$_LANG['batch_not_on_sale_confirm'] = '��ȷʵҪ��ѡ�е���Ʒ�¼���';
$_LANG['batch_best_confirm'] = '��ȷʵҪ��ѡ�е���Ʒ��Ϊ��Ʒ��';
$_LANG['batch_not_best_confirm'] = '��ȷʵҪ��ѡ�е���Ʒȡ����Ʒ��';
$_LANG['batch_new_confirm'] = '��ȷʵҪ��ѡ�е���Ʒ��Ϊ��Ʒ��';
$_LANG['batch_not_new_confirm'] = '��ȷʵҪ��ѡ�е���Ʒȡ����Ʒ��';
$_LANG['batch_hot_confirm'] = '��ȷʵҪ��ѡ�е���Ʒ��Ϊ������';
$_LANG['batch_not_hot_confirm'] = '��ȷʵҪ��ѡ�е���Ʒȡ��������';
$_LANG['cannot_found_goods'] = '�Ҳ���ָ������Ʒ��';
$_LANG['sel_goods_type'] = '��ѡ����Ʒ����';
$_LANG['sel_goods_suppliers'] = '��ѡ�񹩻���';
/*------------------------------------------------------ */
//-- ͼƬ���������ʾ��Ϣ
/*------------------------------------------------------ */
$_LANG['no_gd'] = '���ķ�������֧�� GD ����û�а�װ�����ͼƬ���͵���չ�⡣';
$_LANG['img_not_exists'] = 'û���ҵ�ԭʼͼƬ����������ͼʧ�ܡ�';
$_LANG['img_invalid'] = '��������ͼʧ�ܣ���Ϊ���ϴ���һ����Ч��ͼƬ�ļ���';
$_LANG['create_dir_failed'] = 'images �ļ��в���д����������ͼʧ�ܡ�';
$_LANG['safe_mode_warning'] = '���ķ����������ڰ�ȫģʽ�£����� %s Ŀ¼�����ڡ���������Ҫ���д�����Ŀ¼�����ϴ�ͼƬ��';
$_LANG['not_writable_warning'] = 'Ŀ¼ %s ����д������Ҫ�Ѹ�Ŀ¼��Ϊ��д�����ϴ�ͼƬ��';

/*------------------------------------------------------ */
//-- ��Ʒ�б�
/*------------------------------------------------------ */
$_LANG['goods_cat'] = '���з���';
$_LANG['goods_brand'] = '����Ʒ��';
$_LANG['intro_type'] = 'ȫ��';
$_LANG['keyword'] = '�ؼ���';
$_LANG['is_best'] = '��Ʒ';
$_LANG['is_new'] = '��Ʒ';
$_LANG['is_hot'] = '����';
$_LANG['is_promote'] = '�ؼ�';
$_LANG['all_type'] = 'ȫ���Ƽ�';
$_LANG['sort_order'] = '�Ƽ�����';

$_LANG['goods_name'] = '��Ʒ����';
$_LANG['goods_sn'] = '����';
$_LANG['shop_price'] = '�۸�';
$_LANG['is_on_sale'] = '�ϼ�';
$_LANG['goods_number'] = '���';

$_LANG['copy'] = '����';
$_LANG['item_list'] = '��Ʒ�б�';

$_LANG['integral'] = '���ֶ��';
$_LANG['on_sale'] = '�ϼ�';
$_LANG['not_on_sale'] = '�¼�';
$_LANG['best'] = '��Ʒ';
$_LANG['not_best'] = 'ȡ����Ʒ';
$_LANG['new'] = '��Ʒ';
$_LANG['not_new'] = 'ȡ����Ʒ';
$_LANG['hot'] = '����';
$_LANG['not_hot'] = 'ȡ������';
$_LANG['move_to'] = 'ת�Ƶ�����';

// ajax
$_LANG['goods_name_null'] = '��������Ʒ����';
$_LANG['goods_sn_null'] = '���������';
$_LANG['shop_price_not_number'] = '�۸�������';
$_LANG['shop_price_invalid'] = '��������һ���Ƿ����г��۸�';
$_LANG['goods_sn_exists'] = '������Ļ����Ѵ��ڣ��뻻һ��';

/*------------------------------------------------------ */
//-- ���/�༭��Ʒ��Ϣ
/*------------------------------------------------------ */
$_LANG['tab_general'] = 'ͨ����Ϣ';
$_LANG['tab_detail'] = '��ϸ����';
$_LANG['tab_mix'] = '������Ϣ';
$_LANG['tab_properties'] = '��Ʒ����';
$_LANG['tab_gallery'] = '��Ʒ���';
$_LANG['tab_linkgoods'] = '������Ʒ';
$_LANG['tab_groupgoods'] = '���';
$_LANG['tab_article'] = '��������';
$_LANG['tab_detail_list'] = '�б�����';
$_LANG['tab_jd'] = '��Ʒ���';


$_LANG['lab_goods_name'] = '��Ʒ���ƣ�';
$_LANG['lab_goods_sn'] = '��Ʒ���ţ�';
$_LANG['lab_goods_cat'] = '��Ʒ���ࣺ';
$_LANG['lab_other_cat'] = '��չ���ࣺ';
$_LANG['lab_goods_brand'] = '��ƷƷ�ƣ�';
$_LANG['lab_shop_price'] = '�����ۼۣ�';
$_LANG['lab_market_price'] = '�г��ۼۣ�';
$_LANG['lab_user_price'] = '��Ա�۸�';
$_LANG['lab_promote_price'] = '�����ۣ�';
$_LANG['lab_promote_date'] = '�������ڣ�';
$_LANG['lab_picture'] = '�ϴ���ƷͼƬ��';
$_LANG['lab_thumb'] = '�ϴ���Ʒ����ͼ��';
$_LANG['auto_thumb'] = '�Զ�������Ʒ����ͼ';
$_LANG['lab_keywords'] = '��Ʒ�ؼ��ʣ�';
$_LANG['lab_goods_brief'] = '��Ʒ��������';
$_LANG['lab_seller_note'] = '�̼ұ�ע��';
$_LANG['lab_goods_type'] = '��Ʒ���ͣ�';
$_LANG['lab_picture_url'] = '��ƷͼƬ�ⲿURL';
$_LANG['lab_thumb_url'] = '��Ʒ����ͼ�ⲿURL';
$_LANG['lab_goods_syrq'] = '������Ⱥ��';
$_LANG['lab_goods_tbxz'] = 'Ͷ����֪��';
$_LANG['lab_goods_alfx'] = '����������';

$_LANG['lab_goods_weight'] = '��Ʒ������';
$_LANG['unit_g'] = '��';
$_LANG['unit_kg'] = 'ǧ��';
$_LANG['lab_goods_number'] = '��Ʒ���������';
$_LANG['lab_warn_number'] = '��澯��������';
$_LANG['lab_integral'] = '���ֹ����';
$_LANG['lab_give_integral'] = '�������ѻ�������';
$_LANG['lab_rank_integral'] = '���͵ȼ���������';
$_LANG['lab_intro'] = '�����Ƽ���';
$_LANG['lab_is_on_sale'] = '�ϼܣ�';
$_LANG['lab_is_alone_sale'] = '����Ϊ��ͨ��Ʒ���ۣ�';
$_LANG['lab_is_free_shipping'] = '�Ƿ�Ϊ���˷���Ʒ';

$_LANG['compute_by_mp'] = '���г��ۼ���';

$_LANG['notice_goods_sn'] = '�������������Ʒ���ţ�ϵͳ���Զ�����һ��Ψһ�Ļ��š�';
$_LANG['notice_integral'] = '(�˴�����д���)�������Ʒʱ������ʹ�û��ֵĽ��';
$_LANG['notice_give_integral'] = '�������Ʒʱ�������ѻ�����,-1��ʾ����Ʒ�۸�����';
$_LANG['notice_rank_integral'] = '�������Ʒʱ���͵ȼ�������,-1��ʾ����Ʒ�۸�����';
$_LANG['notice_seller_note'] = '�����̼��Լ�������Ϣ';
$_LANG['notice_storage'] = '�������ƷΪ�������Ʒ���ڻ�ƷʱΪ���ɱ༭״̬�������ֵȡ����������������Ʒ����';
$_LANG['notice_keywords'] = '�ÿո�ָ�';
$_LANG['notice_user_price'] = '��Ա�۸�Ϊ-1ʱ��ʾ��Ա�۸񰴻�Ա�ȼ��ۿ��ʼ��㡣��Ҳ����Ϊÿ���ȼ�ָ��һ���̶��۸�';
$_LANG['notice_goods_type'] = '��ѡ����Ʒ���������ͣ��������ƴ���Ʒ������';

$_LANG['on_sale_desc'] = '�򹴱�ʾ�������ۣ������������ۡ�';
$_LANG['alone_sale'] = '�򹴱�ʾ����Ϊ��ͨ��Ʒ���ۣ�����ֻ����Ϊ�������Ʒ���ۡ�';
$_LANG['free_shipping'] = '�򹴱�ʾ����Ʒ��������˷ѻ����������������˷Ѽ��㡣';

$_LANG['invalid_goods_img'] = '��ƷͼƬ��ʽ����ȷ��';
$_LANG['invalid_goods_thumb'] = '��Ʒ����ͼ��ʽ����ȷ��';
$_LANG['invalid_img_url'] = '��Ʒ����е�%s��ͼƬ��ʽ����ȷ!';

$_LANG['goods_img_too_big'] = '��ƷͼƬ�ļ�̫���ˣ����ֵ��%s�����޷��ϴ���';
$_LANG['goods_thumb_too_big'] = '��Ʒ����ͼ�ļ�̫���ˣ����ֵ��%s�����޷��ϴ���';
$_LANG['img_url_too_big'] = '��Ʒ����е�%s��ͼƬ�ļ�̫���ˣ����ֵ��%s�����޷��ϴ���';

$_LANG['integral_market_price'] = 'ȡ����';
$_LANG['upload_images'] = '�ϴ�ͼƬ';
$_LANG['spec_price'] = '���Լ۸�';
$_LANG['drop_img_confirm'] = '��ȷʵҪɾ����ͼƬ��';

$_LANG['select_font'] = '������ʽ';
$_LANG['font_styles'] = array('strong' => '�Ӵ�', 'em' => 'б��', 'u' => '�»���', 'strike' => 'ɾ����');

$_LANG['rapid_add_cat'] = '��ӷ���';
$_LANG['rapid_add_brand'] = '���Ʒ��';
$_LANG['category_manage'] = '�������';
$_LANG['brand_manage'] = 'Ʒ�ƹ���';
$_LANG['hide'] = '����';

$_LANG['lab_volume_price']         = '��Ʒ�Żݼ۸�';
$_LANG['volume_number']            = '�Ż�����';
$_LANG['volume_price']             = '�Żݼ۸�';
$_LANG['notice_volume_price']      = '���������ﵽ�Ż�����ʱ���ܵ��Żݼ۸�';
$_LANG['volume_number_continuous'] = '�Ż������ظ���';

$_LANG['label_suppliers']          = 'ѡ�񹩻��̣�';
$_LANG['suppliers_no']             = '��ָ�����������ڱ�����Ʒ';
$_LANG['suppliers_move_to']        = 'ת�Ƶ�������';
$_LANG['lab_to_shopex']         = 'ת�Ƶ�����';

/*------------------------------------------------------ */
//-- ������Ʒ
/*------------------------------------------------------ */

$_LANG['all_goods'] = '��ѡ��Ʒ';
$_LANG['link_goods'] = '������Ʒ��������Ʒ';
$_LANG['single'] = '�������';
$_LANG['double'] = '˫�����';
$_LANG['all_article'] = '��ѡ����';
$_LANG['goods_article'] = '������Ʒ����������';
$_LANG['top_cat'] = '��������';

/*------------------------------------------------------ */
//-- �����Ʒ
/*------------------------------------------------------ */

$_LANG['group_goods'] = '����Ʒ�����';
$_LANG['price'] = '�۸�';

/*------------------------------------------------------ */
//-- ��Ʒ���
/*------------------------------------------------------ */

$_LANG['img_desc'] = 'ͼƬ����';
$_LANG['img_url'] = '�ϴ��ļ�';
$_LANG['img_file'] = '���������ⲿͼƬ���ӵ�ַ';

/*------------------------------------------------------ */
//-- ��������
/*------------------------------------------------------ */
$_LANG['article_title'] = '���±���';

$_LANG['goods_not_exist'] = '����Ʒ������';
$_LANG['goods_not_in_recycle_bin'] = '����Ʒ��δ�������վ������ɾ��';

$_LANG['js_languages']['goods_name_not_null'] = '��Ʒ���Ʋ���Ϊ�ա�';
$_LANG['js_languages']['goods_cat_not_null'] = '��Ʒ�������ѡ��';
$_LANG['js_languages']['category_cat_not_null'] = '�������Ʋ���Ϊ��';
$_LANG['js_languages']['brand_cat_not_null'] = 'Ʒ�����Ʋ���Ϊ��';
$_LANG['js_languages']['goods_cat_not_leaf'] = '��ѡ�����Ʒ���಻�ǵ׼����࣬��ѡ��׼����ࡣ';
$_LANG['js_languages']['shop_price_not_null'] = '�����ۼ۲���Ϊ�ա�';
$_LANG['js_languages']['shop_price_not_number'] = '�����ۼ۲�����ֵ��';

$_LANG['js_languages']['select_please'] = '��ѡ��...';
$_LANG['js_languages']['button_add'] = '���';
$_LANG['js_languages']['button_del'] = 'ɾ��';
$_LANG['js_languages']['spec_value_not_null'] = '�����Ϊ��';
$_LANG['js_languages']['spec_price_not_number'] = '�Ӽ۲�������';
$_LANG['js_languages']['market_price_not_number'] = '�г��۸�������';
$_LANG['js_languages']['goods_number_not_int'] = '��Ʒ��治������';
$_LANG['js_languages']['warn_number_not_int'] = '��澯�治������';
$_LANG['js_languages']['promote_not_lt'] = '������ʼ���ڲ��ܴ��ڽ�������';
$_LANG['js_languages']['promote_start_not_null'] = '������ʼʱ�䲻��Ϊ��';
$_LANG['js_languages']['promote_end_not_null'] = '��������ʱ�䲻��Ϊ��';

$_LANG['js_languages']['drop_img_confirm'] = '��ȷʵҪɾ����ͼƬ��';
$_LANG['js_languages']['batch_no_on_sale'] = '��ȷʵҪ��ѡ������Ʒ�¼���';
$_LANG['js_languages']['batch_trash_confirm'] = '��ȷʵҪ��ѡ�е���Ʒ�������վ��';
$_LANG['js_languages']['go_category_page'] = '��ҳ���ݽ���ʧ��ȷ��Ҫȥ��Ʒ����ҳ��ӷ�����';
$_LANG['js_languages']['go_brand_page'] = '��ҳ���ݽ���ʧ��ȷ��Ҫȥ��ƷƷ��ҳ���Ʒ����';

$_LANG['js_languages']['volume_num_not_null'] = '�������Ż�����';
$_LANG['js_languages']['volume_num_not_number'] = '�Ż�������������';
$_LANG['js_languages']['volume_price_not_null'] = '�������Żݼ۸�';
$_LANG['js_languages']['volume_price_not_number'] = '�Żݼ۸�������';

$_LANG['js_languages']['cancel_color'] = '����ʽ';

/* ���⿨ */
$_LANG['card'] = '�鿴���⿨��Ϣ';
$_LANG['replenish'] = '����';
$_LANG['batch_card_add'] = '��������';
$_LANG['add_replenish'] = '������⿨����';

$_LANG['goods_number_error'] = '��Ʒ�����������';

/*------------------------------------------------------ */
//-- ��Ʒ
/*------------------------------------------------------ */
$_LANG['product'] = '��Ʒ';
$_LANG['product_info'] = '��Ʒ��Ϣ';
$_LANG['specifications'] = '���';
$_LANG['total'] = '�ϼƣ�';
$_LANG['add_products'] = '��ӻ�Ʒ';
$_LANG['save_products'] = '�����Ʒ�ɹ�';
$_LANG['product_id_null'] = '��ƷidΪ��';
$_LANG['cannot_found_products'] = 'δ�ҵ�ָ����Ʒ';
$_LANG['product_batch_del_success'] = '��Ʒ����ɾ���ɹ�';
$_LANG['product_batch_del_failure'] = '��Ʒ����ɾ��ʧ��';
$_LANG['batch_product_add'] = '�������';
$_LANG['batch_product_edit'] = '�����༭';
$_LANG['products_title'] = '��Ʒ���ƣ�%s';
$_LANG['products_title_2'] = '���ţ�%s';
$_LANG['good_shop_price'] = '����Ʒ�۸�%d��';
$_LANG['good_goods_sn'] = '����Ʒ���ţ�%s��';
$_LANG['exist_same_goods_sn'] = '��Ʒ���Ų��������Ʒ�����ظ�';
$_LANG['exist_same_product_sn'] = '��Ʒ�����ظ�';
$_LANG['cannot_add_products'] = '��Ʒ���ʧ��';
$_LANG['exist_same_goods_attr'] = '��Ʒ��������ظ�';
$_LANG['cannot_goods_number'] = '����Ʒ���ڻ�Ʒ�������޸���Ʒ���';
$_LANG['not_exist_goods_attr'] = '����Ʒ�����ڹ����Ϊ����ӹ��';
$_LANG['goods_sn_exists'] = '������Ļ����Ѵ��ڣ��뻻һ��';
?>