<?php
require(dirname(__FILE__) . '/api.class.php');
include_once(ROOT_PATH.'includes/cls_json.php');
$json = new JSON;
if(!$_SESSION['user_id']){

	die($json->encode(array('state'=>0,'msg'=>'ÇëÏÈµÇÂ¼')));
	
}
$aid = intval($_GET['aid']);
$api = new weixinapi();
$arr = $api->doAward($aid);
die($json->encode($arr));
