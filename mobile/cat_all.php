<?php

/**
 * ECSHOP ����ۺ�ҳ
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liuhui $
 * $Id: index.php 15013 2010-03-25 09:31:42Z liuhui $
*/

define('IN_ECS', true);
define('ECS_ADMIN', true);

require(dirname(__FILE__) . '/includes/init.php');



$pcat_array = get_categories_tree();
foreach ($pcat_array as $key => $pcat_data)
{
    $pcat_array[$key]['name'] = encode_output($pcat_data['name']);
    if ($pcat_data['cat_id'])
    {
        foreach ($pcat_data['cat_id'] as $k => $v)
        {
            $pcat_array[$key]['cat_id'][$k]['name'] = encode_output($v['name']);
        }
    }
}
$smarty->assign('pcat_array' , $pcat_array);

$smarty->assign('wap_logo', $_CFG['wap_logo']);
$smarty->assign('footer', get_footer());
$smarty->display("cat_all.html");

?>
