<?php

/**
 * ECSHOP ��Ʒ������������ļ�
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: category.php 17217 2011-01-19 06:29:08Z liubo $
*/

/* ��Ʒ�����ֶ���Ϣ */
$_LANG['cat_id'] = '���';
$_LANG['cat_name'] = '��������';
$_LANG['isleaf'] = '������';
$_LANG['noleaf'] = '����';
$_LANG['keywords'] = '�ؼ���';
$_LANG['cat_desc'] = '��������';
$_LANG['parent_id'] = '�ϼ�����';
$_LANG['sort_order'] = '����';
$_LANG['measure_unit'] = '������λ';
$_LANG['delete_info'] = 'ɾ��ѡ��';
$_LANG['category_edit'] = '�༭��Ʒ����';
$_LANG['move_goods'] = 'ת����Ʒ';
$_LANG['cat_top'] = '��������';
$_LANG['show_in_nav'] = '�Ƿ���ʾ�ڵ�����';
$_LANG['cat_style'] = '�������ʽ���ļ�';
$_LANG['is_show'] = '�Ƿ���ʾ';
$_LANG['show_in_index'] = '����Ϊ��ҳ�Ƽ�';
$_LANG['notice_show_in_index'] = '�����ÿ�������ҳ�����¡����š��Ƽ�����ʾ�÷����µ��Ƽ���Ʒ';
$_LANG['goods_number'] = '��Ʒ����';
$_LANG['grade'] = '�۸��������';
$_LANG['notice_grade'] = '��ѡ���ʾ�÷�������Ʒ��ͼ�����߼�֮��Ļ��ֵĵȼ���������0��ʾ�����ּ�����಻�ܳ���10����';
$_LANG['short_grade'] = '�۸�ּ�';

$_LANG['nav'] = '������';
$_LANG['index_new'] = '����';
$_LANG['index_best'] = '��Ʒ';
$_LANG['index_hot'] = '����';

$_LANG['back_list'] = '���ط����б�';
$_LANG['continue_add'] = '������ӷ���';

$_LANG['notice_style'] = '������Ϊÿһ����Ʒ����ָ��һ����ʽ���ļ��������ļ������ themes Ŀ¼�������룺themes/style.css';

/* ������ʾ��Ϣ */
$_LANG['catname_empty'] = '�������Ʋ���Ϊ��!';
$_LANG['catname_exist'] = '�Ѵ�����ͬ�ķ�������!';
$_LANG["parent_isleaf"] = '��ѡ���಻����ĩ������!';
$_LANG["cat_isleaf"] = '����ĩ��������ߴ˷����»���������Ʒ,������ɾ��!';
$_LANG["cat_noleaf"] = '���»��������ӷ���,�����޸�Ϊĩ������!';
$_LANG["is_leaf_error"] = '��ѡ����ϼ����಻���ǵ�ǰ������ߵ�ǰ������¼�����!';
$_LANG['grade_error'] = '�۸�ּ�����ֻ����0-10֮�ڵ�����';

$_LANG['catadd_succed'] = '����Ʒ������ӳɹ�!';
$_LANG['catedit_succed'] = '��Ʒ����༭�ɹ�!';
$_LANG['catdrop_succed'] = '��Ʒ����ɾ���ɹ�!';
$_LANG['catremove_succed'] = '��Ʒ����ת�Ƴɹ�!';
$_LANG['move_cat_success'] = 'ת����Ʒ�����ѳɹ����!';

$_LANG['cat_move_desc'] = 'ʲô��ת����Ʒ����?';
$_LANG['select_source_cat'] = 'ѡ��Ҫת�Ƶķ���';
$_LANG['select_target_cat'] = 'ѡ��Ŀ�����';
$_LANG['source_cat'] = '�Ӵ˷���';
$_LANG['target_cat'] = 'ת�Ƶ�';
$_LANG['start_move_cat'] = '��ʼת��';
$_LANG['cat_move_notic'] = '�������Ʒ��������Ʒ������,�����Ҫ����Ʒ�ķ�����б��,��ô�����ͨ���˹���,��ȷ���������Ʒ���ࡣ';

$_LANG['cat_move_empty'] = '��û����ȷѡ����Ʒ����!';

$_LANG['sel_goods_type'] = '��ѡ����Ʒ����';
$_LANG['sel_filter_attr'] = '��ѡ��ɸѡ����';
$_LANG['filter_attr'] = 'ɸѡ����';
$_LANG['filter_attr_notic'] = 'ɸѡ���Կ���ǰ����ҳ��ɸѡ��Ʒ';
$_LANG['filter_attr_not_repeated'] = 'ɸѡ���Բ����ظ�';

/*JS ������*/
$_LANG['js_languages']['catname_empty'] = '�������Ʋ���Ϊ��!';
$_LANG['js_languages']['unit_empyt'] = '������λ����Ϊ��!';
$_LANG['js_languages']['is_leafcat'] = '��ѡ���ķ�����һ��ĩ�����ࡣ\r\n�·�����ϼ����಻����һ��ĩ������';
$_LANG['js_languages']['not_leafcat'] = '��ѡ���ķ��಻��һ��ĩ�����ࡣ\r\n��Ʒ�ķ���ת��ֻ����ĩ������֮��ſ��Բ�����';
$_LANG['js_languages']['filter_attr_not_repeated'] = 'ɸѡ���Բ����ظ�';
$_LANG['js_languages']['filter_attr_not_selected'] = '��ѡ��ɸѡ����';

?>