<?php

/**
 * ECSHOP ��Ʒ������Z���ļ�
 * ============================================================================
 * ������� 2005-2011 �Ϻ����ɾW�j�Ƽ����޹�˾���K�������Й�����
 * �Wվ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �@����һ������ܛ������ֻ���ڲ�����̘IĿ�ĵ�ǰ����������a�M���޸ĺ�
 * ʹ�ã������S��������a���κ���ʽ�κ�Ŀ�ĵ��ٰl�ѡ�
 * ============================================================================
 * $Author: liubo $
 * $Id: category.php 17217 2011-01-19 06:29:08Z liubo $
*/

/* ��Ʒ����ֶ���Ϣ */
$_LANG['cat_id'] = '��̖';
$_LANG['cat_name'] = '������Q';
$_LANG['isleaf'] = '�����S';
$_LANG['noleaf'] = '���S';
$_LANG['keywords'] = '�P�I��';
$_LANG['cat_desc'] = '�������';
$_LANG['parent_id'] = '�ϼ����';
$_LANG['sort_order'] = '����';
$_LANG['measure_unit'] = '������λ';
$_LANG['delete_info'] = '�h���x��';
$_LANG['category_edit'] = '��݋��Ʒ���';
$_LANG['move_goods'] = '�D����Ʒ';
$_LANG['cat_top'] = '피����';
$_LANG['show_in_nav'] = '�Ƿ��@ʾ�ڌ�����';
$_LANG['cat_style'] = '��Ę�ʽ���ļ�';
$_LANG['is_show'] = '�Ƿ��@ʾ';
$_LANG['show_in_index'] = '�O�Þ�������]';
$_LANG['notice_show_in_index'] = 'ԓ�O�ÿ�������퓵����¡����T�����]̎�@ʾԓ����µ����]��Ʒ';
$_LANG['goods_number'] = '��Ʒ����';
$_LANG['grade'] = '�r��^�g����';
$_LANG['notice_grade'] = 'ԓ�x헱�ʾԓ�������Ʒ��̓r�c��߃r֮�g�Ą��ֵĵȼ���������0��ʾ�����ּ�����಻�ܳ��^10����';
$_LANG['short_grade'] = '�r��ּ�';

$_LANG['nav'] = '������';
$_LANG['index_new'] = '����';
$_LANG['index_best'] = '��Ʒ';
$_LANG['index_hot'] = '���T';

$_LANG['back_list'] = '���ط���б�';
$_LANG['continue_add'] = '�^�m��ӷ��';

$_LANG['notice_style'] = '�����Ԟ�ÿһ����Ʒ���ָ��һ����ʽ���ļ��������ļ������ themes Ŀ��tݔ�룺themes/style.css';

/* ������ʾ��Ϣ */
$_LANG['catname_empty'] = '������Q���ܞ��!';
$_LANG['catname_exist'] = '�Ѵ�����ͬ�ķ�����Q!';
$_LANG["parent_isleaf"] = '���x�������ĩ�����!';
$_LANG["cat_isleaf"] = '����ĩ������ߴ˷����߀��������Ʒ,�����܄h��!';
$_LANG["cat_noleaf"] = '����߀�������ӷ��,�����޸Ğ�ĩ�����!';
$_LANG["is_leaf_error"] = '���x����ϼ�������Ǯ�ǰ����߮�ǰ����¼����!';
$_LANG['grade_error'] = '�r��ּ�����ֻ����0-10֮�ȵ�����';

$_LANG['catadd_succed'] = '����Ʒ�����ӳɹ�!';
$_LANG['catedit_succed'] = '��Ʒ���݋�ɹ�!';
$_LANG['catdrop_succed'] = '��Ʒ��h���ɹ�!';
$_LANG['catremove_succed'] = '��Ʒ����D�Ƴɹ�!';
$_LANG['move_cat_success'] = '�D����Ʒ����ѳɹ����!';

$_LANG['cat_move_desc'] = 'ʲ�N���D����Ʒ���?';
$_LANG['select_source_cat'] = '�x��Ҫ�D�Ƶķ��';
$_LANG['select_target_cat'] = '�x��Ŀ�˷��';
$_LANG['source_cat'] = '�Ĵ˷��';
$_LANG['target_cat'] = '�D�Ƶ�';
$_LANG['start_move_cat'] = '�_ʼ�D��';
$_LANG['cat_move_notic'] = '�������Ʒ��������Ʒ������,�����Ҫ����Ʒ�ķ���M��׃��,���N�����ͨ�^�˹���,���_���������Ʒ���';

$_LANG['cat_move_empty'] = '��]�����_�x����Ʒ���!';

$_LANG['sel_goods_type'] = 'Ո�x����Ʒ���';
$_LANG['sel_filter_attr'] = 'Ո�x��Y�x����';
$_LANG['filter_attr'] = '�Y�x����';
$_LANG['filter_attr_notic'] = '�Y�x���Կ���ǰ������Y�x��Ʒ';

/*JS �Z���*/
$_LANG['js_languages']['catname_empty'] = '������Q���ܞ��!';
$_LANG['js_languages']['unit_empyt'] = '������λ���ܞ��!';
$_LANG['js_languages']['is_leafcat'] = '���x���ķ����һ��ĩ�����\r\n�·���ϼ��������һ��ĩ�����';
$_LANG['js_languages']['not_leafcat'] = '���x���ķ����һ��ĩ�����\r\n��Ʒ�ķ���D��ֻ����ĩ�����֮�g�ſ��Բ�����';
$_LANG['js_languages']['filter_attr_not_repeated'] = '�Y�x���Բ������}';
$_LANG['js_languages']['filter_attr_not_selected'] = 'Ո�x��Y�x����';

?>