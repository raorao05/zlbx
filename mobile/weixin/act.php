<?php
require(dirname(__FILE__) . '/api.class.php');
if(!$_SESSION['user_id']){
	show_message('���ȵ�¼', '��ҳ', '../index.php');
}
$aid = intval($_GET['aid']);
$act = $db->getRow ( "SELECT * FROM " . $GLOBALS['ecs']->table('weixin_act') . " WHERE `aid` = $aid and isopen=1" );

if(!$act){
    show_message('��Ѿ�����');
}

$actList = (array)$db->getAll ( "SELECT * FROM " . $GLOBALS['ecs']->table('weixin_actlist') . " where aid=$aid and isopen=1" );
if(!$actList){
    show_message('�δ���ý���');
}

$sql = "SELECT " . $GLOBALS['ecs']->table('weixin_actlog') . ".*," . $GLOBALS['ecs']->table('users') . ".user_name as nickname FROM " . $GLOBALS['ecs']->table('weixin_actlog') . "
		left join " . $GLOBALS['ecs']->table('users') . " on " . $GLOBALS['ecs']->table('weixin_actlog') . ".uid=" . $GLOBALS['ecs']->table('users') . ".user_id
		where code!='' and aid=$aid order by lid desc";
$award = $db->getAll ( $sql );
$uid = intval($_SESSION['user_id']);
$api = new weixinapi();
$awardNum = intval($api->getAwardNum($aid));

// �鿴�����Ƿ��㹻
$jifen = intval($act['jifen']);
if($jifen > 0){
    $sql = "SELECT pay_points FROM " . $GLOBALS['ecs']->table('users') . " WHERE user_id= '$uid'";
    $user_jifen  = $GLOBALS['db']->getOne ( $sql );
    $user_jifen = intval($user_jifen);
    if($jifen > $user_jifen){
        $awardNum = 0;
    }
}

require("award_{$act['tpl']}.php");
?>