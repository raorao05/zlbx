<?php

/**
 * ECSHOP �ֲ�ͼƬ����
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: cycle_image.php 17217 2011-01-19 06:29:08Z liubo $
*/

define('IN_ECS', true);
define('INIT_NO_USERS', true);
define('INIT_NO_SMARTY', true);

require(dirname(__FILE__) . '/includes/init.php');

header('Content-Type: application/xml; charset=' . EC_CHARSET);
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Thu, 27 Mar 1975 07:38:00 GMT');
header('Last-Modified: ' . date('r'));
header('Pragma: no-cache');

if (file_exists(ROOT_PATH . DATA_DIR . '/cycle_image.xml'))
{
    echo file_get_contents(ROOT_PATH . DATA_DIR . '/cycle_image.xml');
}
else
{
    echo '<?xml version="1.0" encoding="' . EC_CHARSET . '"?><bcaster><item item_url="images/200609/05.jpg" link="http://www.ecshop.com" /></bcaster>';
}
?>