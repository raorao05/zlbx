<?php

/**
 * 微信支付轮询接口
 * add by ry
 */

define('IN_ECS',1);
require(dirname(__FILE__) . '/includes/init.php');

$ret = array(
    'err' => 1,
    'order_status' => 0,
    'order_id' => 0
);

$order_sn = isset($_REQUEST['order_sn']) ? $_REQUEST['order_sn'] : '';
if($order_sn){
    $sql = "SELECT order_id,pay_status FROM " . $GLOBALS['ecs']->table('order_info') . "WHERE order_sn='$order_sn'";
    //die($sql);
    $data = $db->getRow($sql);
    //print_r($data);
    if($data){
        $ret['err'] = 0;
        $ret['order_status'] = $data['pay_status'];
        $ret['order_id'] = $data['order_id'];
    }
}
echo json_encode($ret);
?>