<?php
define ( 'IN_ECS', true );
require (dirname ( __FILE__ ) . '/includes/init.php');
$act = trim ( $_REQUEST ['act'] );
switch ($act){
	case "list"://list
		$aid = intval($_GET['aid']);
		if($_POST){
			$title = getstr($_POST ['title']);
			$content = getstr($_POST ['content']);
			$isopen = intval($_POST ['isopen']);
			$type = intval($_POST ['type']);
			$num = intval($_POST ['num']);
            $jifen = intval($_POST ['jifen']);
			$overymd = getstr($_POST ['overymd']);
			$tpl = intval($_POST ['tpl']) ? intval($_POST ['tpl']) : 1;
			if($aid > 0){
				$ret = $db->query (
					"UPDATE  " . $ecs->table('weixin_act') . "  SET 
					`title`='$title',
					`content`='$content',
					`isopen`='$isopen',
					`type`='$type',
					`tpl`='$tpl',
					`overymd`='$overymd',
					`num`='$num',
					`jifen`='$jifen'
					 WHERE `aid`=$aid;" );
			}else{
				$ret = $db->query (
					"insert into  " . $ecs->table('weixin_act') . "  (title,content,isopen,type,tpl,overymd,num) 
					value ('$title','$content','$isopen','$type','$tpl','$overymd','$num');"
				);
			}
			$link [] = array ('href' => 'weixin_egg.php?act=list','text' => '活动管理');
			sys_msg ( '处理成功', 0, $link );
		}elseif($aid > 0){
			$act = $db->getRow ( "SELECT * FROM  " . $ecs->table('weixin_act') . "  where aid=$aid" );
			$smarty->assign('action_link',  array('text' => "奖项管理", 'href'=>'weixin_egg.php?act=listall&aid='.$aid));
			$smarty->assign ( 'act', $act );
			$smarty->display ( 'weixin/act_show.html' );
			return;
		}
		$act = $db->getAll ( "SELECT * FROM  " . $ecs->table('weixin_act'));
		$smarty->assign ( 'actList', $act );
		$smarty->display ( 'weixin/act_list.html' );
		break;
	case "listall":
		$aid = intval($_GET['aid']);
		$actList = $db->getAll ( "SELECT * FROM  " . $ecs->table('weixin_actlist') . "  where aid=$aid" );
		$smarty->assign ( 'actList', $actList );
		$smarty->display ( 'weixin/act_listall.html' );
		break;
	case "add"://add and edit
		$lid = intval($_GET['lid']);
		$aid = intval($_GET['aid']) ? intval($_GET['aid']) : 1;
		$title = getstr($_POST ['title']);
		$awardname = getstr($_POST ['awardname']);
		$randnum = round($_POST ['randnum'],2);
		$isopen = intval($_POST ['isopen']);
		$num = intval($_POST ['num']);
        $awardtype = intval($_POST['prize_type']);
        $bonus_type_id = intval($_POST['bonus_type_id']);
		if($lid > 0){
			$actList = $db->getRow ( "SELECT * FROM  " . $ecs->table('weixin_actlist') . "  where lid=$lid" );
			$smarty->assign ( 'actList', $actList );
			$sql = "update ". $ecs->table('weixin_actlist') ."  set title='$title',randnum=$randnum,num=$num,isopen=$isopen,awardname='$awardname',awardtype='$awardtype',bonus_type_id='$bonus_type_id' where lid=$lid";
		}else{
			$sql = "insert into ". $ecs->table('weixin_actlist') ."  (title,randnum,isopen,num,aid,awardname,awardtype,bonus_type_id)
			value ('$title','$randnum','$isopen','$num',$aid,'$awardname','$awardtype','$bonus_type_id')";
		}
		if($_POST){
			$ret = $db->query($sql);
			$link [] = array ('href' => 'weixin_egg.php?act=list&aid='.$aid,'text' => '活动管理');
			sys_msg ( '处理成功', 0, $link );
		}else{
			$smarty->display ( 'weixin/act_add.html' );
		}
		break;
	case "log":
		$lid = intval($_GET['lid']);
		$tag = $_GET['tag'];
		if($lid > 0 && $tag == 'send'){
			$ret = $db->query("update " . $ecs->table('weixin_actlog') . " set issend=1 where lid=$lid");
			$link [] = array ('href' => 'weixin_egg.php?act=log','text' => '获奖管理');
			sys_msg ( '处理成功', 0, $link );
		}
		else if($lid > 0 && $tag == 'delete')
		{
			$ret = $db->query("DELETE FROM ".$ecs->table('weixin_actlog')." where lid = '".$lid."'");
			$link [] = array ('href' => 'weixin_egg.php?act=log','text' => '获奖管理');
			sys_msg ( '处理成功', 0, $link );
		}
		$sql = "SELECT " . $ecs->table('weixin_actlog') . ".*," . $ecs->table('users') . ". user_name as nickname FROM " . $ecs->table('weixin_actlog') . "
		left join " . $ecs->table('users') . " on " . $ecs->table('weixin_actlog') . ".uid=" . $ecs->table('users') . ".user_id
		where code!='' order by lid desc";
		$log = $db->getAll ( $sql );

		$qcode_list = qcode_list();
		$smarty->assign('log',   $qcode_list['qcode_list']);
		$smarty->assign('filter',       $qcode_list['filter']);
		$smarty->assign('record_count', $qcode_list['record_count']);
		$smarty->assign('page_count',   $qcode_list['page_count']);
		if($_GET['is_ajax'] == 1){
			make_json_result($smarty->fetch('weixin/act_log.html'), '', array('filter' => $qcode_list['filter'], 'page_count' => $qcode_list['page_count']));
		}else{
			$smarty->assign('full_page',    1);
			$smarty->display ( 'weixin/act_log.html' );
		}
		break;
}

function getstr($str){
	return htmlspecialchars($str,ENT_QUOTES);
}

function qcode_list(){
	$result = get_filter();
    $where = '';

    //兑奖码
	$keywords = empty($_REQUEST['keywords']) ? '' : trim($_REQUEST['keywords']);
	if($keywords){
		$where .= " and " . $GLOBALS['ecs']->table('weixin_actlog') . ".code like '%{$keywords}%'";
	}

    //奖品名
    $prizename = empty($_REQUEST['prizename']) ? '' : trim($_REQUEST['prizename']);
    if($prizename){
        $prizename = iconv('utf-8//IGNORE','gbk',$prizename);
        $where .= " and " . $GLOBALS['ecs']->table('weixin_actlog') . ".class_name like '%{$prizename}%'";
    }

    //中奖时间
    $use_start_date = empty($_REQUEST['use_start_date']) ? '' : trim($_REQUEST['use_start_date']);
    if($use_start_date){
        $where .= " and " . $GLOBALS['ecs']->table('weixin_actlog') . ".createymd = '{$use_start_date}'";
    }

    //活动名称
    $activename = empty($_REQUEST['activename']) ? '' : trim($_REQUEST['activename']);
    if($activename){
        $activename = iconv('utf-8//IGNORE','gbk',$activename);
        $where .= " and " . $GLOBALS['ecs']->table('weixin_act') . ".title = '{$activename}'";
    }



    //兑奖截止时间
    $use_end_date = empty($_REQUEST['use_end_date']) ? '' : trim($_REQUEST['use_end_date']);
    if($use_end_date){
        $where .= " and " . $GLOBALS['ecs']->table('weixin_act') . ".overymd = '{$use_end_date}'";
    }

    //是否开奖
    $is_send = empty($_REQUEST['is_send']) ? '' : trim($_REQUEST['is_send']);
    if($is_send){
        $where .= " and " . $GLOBALS['ecs']->table('weixin_actlog') . ".issend = '$is_send'";
    }


    //用户账号
    $username = empty($_REQUEST['username']) ? '' : trim($_REQUEST['username']);
    if($username){
        $username = iconv('utf-8//IGNORE','gbk',$username);
        $where .= " and " . $GLOBALS['ecs']->table('users') . ".user_name like '%{$username}%'";
    }



	$sql =  $GLOBALS['ecs']->table('weixin_actlog') . " left join " . $GLOBALS['ecs']->table('users') ." on " . $GLOBALS['ecs']->table('weixin_actlog') . ".uid=" . $GLOBALS['ecs']->table('users') . ".user_id left join " . $GLOBALS['ecs']->table('weixin_act') . " on " . $GLOBALS['ecs']->table('weixin_actlog') . ".aid=" . $GLOBALS['ecs']->table('weixin_act') . ".aid
		where code!='' {$where} order by lid desc";

    //die($sql);


	$filter['record_count'] = $GLOBALS['db']->getOne("SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('weixin_actlog'));
	$filter = page_and_size($filter);
	$filter['start'] = intval($filter['start']);
	$filter['page_size'] = intval($filter['page_size']);


	$user_list = $GLOBALS['db']->getAll("SELECT " . $GLOBALS['ecs']->table('weixin_actlog') . ".*," . $GLOBALS['ecs']->table('users') . ".user_name as nickname," . $GLOBALS['ecs']->table('weixin_act') . ".title,". $GLOBALS['ecs']->table('weixin_act') .".overymd FROM".$sql." limit {$filter['start']},{$filter['page_size']}");
	$arr = array(
        'qcode_list' => $user_list,
        'filter' => $filter,
		'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']
    );
	return $arr;
}