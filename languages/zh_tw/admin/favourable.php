<?php

/**
 * ECSHOP �������ă��ݻ���Z���ļ�
 * ============================================================================
 * ������� 2005-2011 �Ϻ����ɾW�j�Ƽ����޹�˾���K�������Й�����
 * �Wվ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �@����һ������ܛ������ֻ���ڲ�����̘IĿ�ĵ�ǰ����������a�M���޸ĺ�
 * ʹ�ã������S��������a���κ���ʽ�κ�Ŀ�ĵ��ٰl�ѡ�
 * ============================================================================
 * $Author: liubo $
 * $Id: favourable.php 17217 2011-01-19 06:29:08Z liubo $
 */

/* menu */
$_LANG['favourable_list'] = '���ݻ���б�';
$_LANG['add_favourable'] = '��Ӄ��ݻ��';
$_LANG['edit_favourable'] = '��݋���ݻ��';
$_LANG['favourable_log'] = '���ݻ�ӳ��rӛ�';
$_LANG['continue_add_favourable'] = '�^�m��Ӄ��ݻ��';
$_LANG['back_favourable_list'] = '���؃��ݻ���б�';
$_LANG['add_favourable_ok'] = '��Ӄ��ݻ�ӳɹ�';
$_LANG['edit_favourable_ok'] = '��݋���ݻ�ӳɹ�';

/* list */
$_LANG['act_is_going'] = '�H�@ʾ�M���еĻ��';
$_LANG['act_name'] = '���ݻ�����Q';
$_LANG['goods_name'] = '��Ʒ���Q';
$_LANG['start_time'] = '�_ʼ�r�g';
$_LANG['end_time'] = '�Y���r�g';
$_LANG['min_amount'] = '���~����';
$_LANG['max_amount'] = '���~����';
$_LANG['favourable_not_exist'] = '��Ҫ�����ă��ݻ�Ӳ�����';
$_LANG['js_languages']['batch_drop_confirm'] = '���_��Ҫ�h���x�еă��ݻ�ӆ᣿';
$_LANG['batch_drop_ok'] = '�����h���ɹ�';
$_LANG['no_record_selected'] = '�]���x��ӛ�';

/* info */
$_LANG['label_act_name'] = '���ݻ�����Q��';
$_LANG['label_start_time'] = '�����_ʼ�r�g��';
$_LANG['label_end_time'] = '���ݽY���r�g��';
$_LANG['label_user_rank'] = '���܃��ݵĕ��T�ȼ���';
$_LANG['not_user'] = '�Ǖ��T';
$_LANG['label_act_range'] = '���ݹ�����';
$_LANG['far_all'] = 'ȫ����Ʒ';
$_LANG['far_category'] = '���·��';
$_LANG['far_brand'] = '����Ʒ��';
$_LANG['far_goods'] = '������Ʒ';
$_LANG['label_search_and_add'] = '�����K���냞�ݹ���';
$_LANG['js_languages']['all_need_not_search'] = '���ݹ�����ȫ����Ʒ������Ҫ�˲���';
$_LANG['js_languages']['range_exists'] = 'ԓ�x��Ѵ���';
$_LANG['label_min_amount'] = '���~���ޣ�';
$_LANG['label_max_amount'] = '���~���ޣ�';
$_LANG['notice_max_amount'] = '0��ʾ�]������';
$_LANG['label_act_type'] = '���ݷ�ʽ��';
$_LANG['notice_act_type'] = '�����ݷ�ʽ�顸����ٛƷ���ػ�Ʒ�����r��Ոݔ�����S�I���x��ٛƷ���ػ�Ʒ�����������������0��ʾ���ޔ�����' .
        '�����ݷ�ʽ�顸���ܬF��p�⡹�r��Ոݔ��F��p��Ľ��~��' .
        '�����ݷ�ʽ�顸���܃r���ۿۡ��r��Ոݔ���ۿۣ�1��99�����磺��9�ۣ���ݔ��90��';
$_LANG['fat_goods'] = '����ٛƷ���ػ�Ʒ��';
$_LANG['fat_price'] = '���ܬF��p��';
$_LANG['fat_discount'] = '���܃r���ۿ�';
$_LANG['js_languages']['pls_search'] = 'Ո������';
$_LANG['search_result_empty'] = '�]���ҵ�����ӛ䛣�Ո��������';
$_LANG['label_search_and_add_gift'] = '�����K����ٛƷ���ػ�Ʒ��';
$_LANG['js_languages']['price_need_not_search'] = '���ݷ�ʽ�����܃r���ۿۣ�����Ҫ�˲���';
$_LANG['js_languages']['gift'] = 'ٛƷ���ػ�Ʒ��';
$_LANG['js_languages']['price'] = '�r��';

$_LANG['js_languages']['act_name_not_null'] = 'Ոݔ�냞�ݻ�����Q';
$_LANG['js_languages']['min_amount_not_number'] = '���~���޸�ʽ�����_�����֣�';
$_LANG['js_languages']['max_amount_not_number'] = '���~���޸�ʽ�����_�����֣�';
$_LANG['js_languages']['act_type_ext_not_number'] = '���ݷ�ʽ�����ֵ�����_�����֣�';
$_LANG['js_languages']['amount_invalid'] = '���~����С춽��~���ޡ�';
$_LANG['js_languages']['start_lt_end'] = '�����_ʼ�r�g���ܴ�춽Y���r�g';

/* post */
$_LANG['pls_set_user_rank'] = 'Ո�O�����܃��ݵĕ��T�ȼ�';
$_LANG['pls_set_act_range'] = 'Ո�O�Ã��ݹ���';
$_LANG['amount_error'] = '���~���޲��ܴ�춽��~����';
$_LANG['act_name_exists'] = 'ԓ���ݻ�����Q�Ѵ��ڣ�Ո���Qһ��';

$_LANG['nolimit'] = '�]������';
?>