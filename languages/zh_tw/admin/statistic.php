<?php

/**
 * ECSHOP �yӋ��Ϣ�Z���ļ�
 * ============================================================================
 * ������� 2005-2011 �Ϻ����ɾW�j�Ƽ����޹�˾���K�������Й�����
 * �Wվ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �@����һ������ܛ������ֻ���ڲ�����̘IĿ�ĵ�ǰ����������a�M���޸ĺ�
 * ʹ�ã������S��������a���κ���ʽ�κ�Ŀ�ĵ��ٰl�ѡ�
 * ============================================================================
 * $Author: liubo $
 * $Id: statistic.php 17217 2011-01-19 06:29:08Z liubo $
*/

/* �����yӋ */
$_LANG['stats_off'] = '�Wվ�����yӋ�ѱ��P�]��<BR>������ҪՈ��: ϵ�y�O��->�̵��O��->�����O�� �_��վ�c�����yӋ���ա�';
$_LANG['last_update'] = '�����������';
$_LANG['now_update'] = '����ӛ�';
$_LANG['update_success'] = '����ӛ��ѳɹ�����!';
$_LANG['view_log'] = '�鿴����ӛ�';
$_LANG['select_year_month'] = '��ԃ����';

$_LANG['pv_stats'] = '�C���L������';
$_LANG['integration_visit'] = '�C���L����';
$_LANG['seo_analyse'] = '�����������';
$_LANG['area_analyse'] = '����ց�';
$_LANG['visit_site'] = '���L�Wվ����';
$_LANG['key_analyse'] = '�P�I�ַ���';

$_LANG['start_date'] = '�_ʼ����';
$_LANG['end_date'] = '�Y������';
$_LANG['query'] = '��ԃ';
$_LANG['result_filter'] = '�^�V�Y��';
$_LANG['compare_query'] = '���^��ԃ';
$_LANG['year_status'] = '���߄�';
$_LANG['month_status'] = '���߄�';

$_LANG['year'] = '��';
$_LANG['month'] = '��';
$_LANG['day'] = '��';
$_LANG['year_format'] = '%Y';
$_LANG['month_format'] = '%c';

$_LANG['from'] = '��';
$_LANG['to'] = '��';
$_LANG['view'] = '�鿴';

/* �N�۸śr */
$_LANG['overall_sell_circs'] = '��ǰ���w�N����r';
$_LANG['order_count_trend'] = 'ӆ�Δ�(��λ:��)';
$_LANG['sell_out_amount'] = '�N���aƷ����';
$_LANG['period'] = '�r�g��';
$_LANG['order_amount_trend'] = '�I�I�~(��λ:Ԫ)';
$_LANG['order_status'] = 'ӆ���߄�';
$_LANG['turnover_status'] = '�N���~�߄�';
$_LANG['sales_statistics']= '�N�۽yӋ';
$_LANG['down_sales_stats']= '�N�۸śr������d';

/* ӆ�νyӋ */
$_LANG['overall_sum'] = '��Чӆ�ο����~';
$_LANG['overall_choose'] = '���c����';
$_LANG['kilo_buy_amount'] = 'ÿǧ�c��ӆ�Δ�';
$_LANG['kilo_buy_sum'] = 'ÿǧ�c��ُ���~';
$_LANG["pay_type"] = "֧����ʽ";
$_LANG["succeed"] = "�ѳɽ�";
$_LANG["confirmed"] = "�Ѵ_�J";
$_LANG["unconfirmed"] = "δ�_�J";
$_LANG["invalid"] = "�oЧ����ȡ��";
$_LANG['order_circs'] = 'ӆ�θśr';
$_LANG['shipping_method'] = '���ͷ�ʽ';
$_LANG['pay_method'] = '֧����ʽ ';
$_LANG['down_order_statistics'] = 'ӆ�νyӋ������d';

/* �N������ */
$_LANG['order_by'] = '����';
$_LANG['goods_name'] = '��Ʒ���Q';
$_LANG['sell_amount'] = '�N����';
$_LANG['sell_sum'] = '�N���~';
$_LANG['percent_count'] = '���r';
$_LANG["to"] = '��';
$_LANG['order_by_goodsnum'] = '���N��������';
$_LANG["order_by_money"] = '���N���~����';
$_LANG["download_sale_sort"] = "�N�����Ј�����d";

/* �͑��yӋ */
$_LANG['guest_order_sum'] = '�������Tƽ��ӆ���~';
$_LANG['member_count'] = '���T����';
$_LANG['member_order_count'] = '���Tӆ�ο���';
$_LANG['guest_member_ordercount'] = '�������Tӆ�ο���';
$_LANG['guest_member_orderamount'] = '�������Tُ�ￂ�~';
$_LANG['percent_buy_member'] = '���Tُ�I�� ';
$_LANG['buy_member_formula'] = '�����Tُ�I�� = ��ӆ�Ε��T�� �� ���T������';
$_LANG['member_order_amount'] = '��ÿ���Tӆ�Δ� = ���Tӆ�ο��� �� ���T������';
$_LANG['member_buy_amount'] = '��ÿ���Tُ���~ = ���Tُ�ￂ�~ �� ���T������';
$_LANG["order_turnover_peruser"] = "ÿ���Tƽ��ӆ�Δ���ُ���~";
$_LANG["order_turnover_percus"] = "�������Tƽ��ӆ���~��ُ�ￂ�~";
$_LANG['guest_all_ordercount'] = '���������Tƽ��ӆ���~ =  �������Tُ�ￂ�~ �� �������Tӆ�ο�����';

$_LANG['average_member_order'] = 'ÿ���Tӆ�Δ�';
$_LANG['member_order_sum'] = 'ÿ���Tُ���~';
$_LANG['order_member_count'] = '��ӆ�Ε��T��';
$_LANG['member_sum'] = '���Tُ�ￂ�~';

$_LANG['order_all_amount'] = 'ӆ�ο���';
$_LANG['order_all_turnover'] = '��ُ���~';

$_LANG['down_guest_stats']= '�͑��yӋ������d';
$_LANG['guest_statistics']= '�͑��yӋ���';

/* ���T���� */
$_LANG['show_num'] = '�@ʾ����';
$_LANG['member_name'] = '���T��';
$_LANG['order_amount'] = 'ӆ�Δ�(��λ:��)';
$_LANG['buy_sum'] = 'ُ����~';

$_LANG['order_amount_sort'] = '��ӆ�Δ�������';
$_LANG['buy_sum_sort'] = '��ُ����~����';
$_LANG['download_amount_sort'] = '���dُ����~���';

/* �N������ */
$_LANG['goods_name'] = '��Ʒ���Q';
$_LANG['goods_sn'] = '؛̖';
$_LANG['order_sn'] = 'ӆ��̖';
$_LANG['amount'] = '����';
$_LANG['to'] = '��';
$_LANG['sell_price'] = '�ۃr';
$_LANG['sell_date'] = '�۳�����';
$_LANG['down_sales'] = '���d�N������';
$_LANG['sales_list'] = '�N������';

/* �L��ُ�I���� */
$_LANG['fav_exponential'] = '�˚�ָ��';
$_LANG['buy_times'] = 'ُ�I�Δ�';
$_LANG['visit_buy'] = '�L��ُ�I��';
$_LANG['download_visit_buy'] = '���d�L��ُ�I�ʈ��';

$_LANG['goods_cat'] = '��Ʒ���';
$_LANG['goods_brand'] = '��ƷƷ��';

/* �������� */
$_LANG['down_search_stats'] = '���d�����P�I�ֈ��';
$_LANG['tab_keywords'] = '�P�I�ֽyӋ';
$_LANG['keywords'] = '�P�I��';
$_LANG['date'] = '����';
$_LANG['hits'] = '�����Δ�';

?>