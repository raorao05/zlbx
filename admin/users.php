<?php

/**
 * ECSHOP ��Ա�������
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: users.php 17217 2011-01-19 06:29:08Z liubo $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

/*------------------------------------------------------ */
//-- �û��ʺ��б�
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'list')
{
    /* ���Ȩ�� */
    admin_priv('users_manage');
    $sql = "SELECT rank_id, rank_name, min_points FROM ".$ecs->table('user_rank')." ORDER BY min_points ASC ";
    $rs = $db->query($sql);

    $ranks = array();
    while ($row = $db->FetchRow($rs))
    {
        $ranks[$row['rank_id']] = $row['rank_name'];
    }


    $smarty->assign('user_ranks',   $ranks);
    $smarty->assign('ur_here',      $_LANG['03_users_list']);
    $smarty->assign('action_link',  array('text' => $_LANG['04_users_add'], 'href'=>'users.php?act=add'));
    $smarty->assign('action_link2',  array('text' => '�����б�', 'href'=>'users.php?act=export'));
    $smarty->assign('action_link3',  array('text' => '��������', 'href'=>'users.php?act=import'));

    $user_list = user_list();

    $smarty->assign('user_list',    $user_list['user_list']);
    $smarty->assign('filter',       $user_list['filter']);
    $smarty->assign('record_count', $user_list['record_count']);
    $smarty->assign('page_count',   $user_list['page_count']);
    $smarty->assign('full_page',    1);
    $smarty->assign('sort_user_id', '<img src="images/sort_desc.gif">');

    assign_query_info();
    $smarty->display('users_list.htm');
}

/*------------------------------------------------------ */
//-- �û��б���
/*------------------------------------------------------ */


if ($_REQUEST['act'] == 'export')
{
    /* ���Ȩ�� */
    admin_priv('users_manage');
    $sql = "SELECT rank_id, rank_name, min_points FROM ".$ecs->table('user_rank')." ORDER BY min_points ASC ";
    $rs = $db->query($sql);

    $ranks = array();
    while ($row = $db->FetchRow($rs))
    {
        $ranks[$row['rank_id']] = $row['rank_name'];
    }

    require(dirname(__FILE__) . '/phpexcel/Classes/PHPExcel.php');

    //��������
    $excel = new PHPExcel();
    //Excel���ʽ,8��
    $letter = array('A','B1','C1','D1','E1','F1','G1','H1');
    //��ͷ����
    $tableheader = array('��Ա����','�ֻ���','�ʼ���ַ','�����ʽ�','�����ʽ�','�ȼ�����','���ѻ���','ע������');
    //����ͷ��Ϣ

    $excel->getActiveSheet()->setCellValue("A1",iconv("gbk","utf-8//IGNORE",'��Ա����'));
    $excel->getActiveSheet()->setCellValue("B1",iconv("gbk","utf-8//IGNORE",'�ֻ���'));
    $excel->getActiveSheet()->setCellValue("C1",iconv("gbk","utf-8//IGNORE",'�ʼ���ַ'));
    $excel->getActiveSheet()->setCellValue("D1",iconv("gbk","utf-8//IGNORE",'�˻����'));
    $excel->getActiveSheet()->setCellValue("E1",iconv("gbk","utf-8//IGNORE",'�����ʽ�'));
    $excel->getActiveSheet()->setCellValue("F1",iconv("gbk","utf-8//IGNORE",'�ȼ�����'));
    $excel->getActiveSheet()->setCellValue("G1",iconv("gbk","utf-8//IGNORE",'���ѻ���'));
    $excel->getActiveSheet()->setCellValue("H1",iconv("gbk","utf-8//IGNORE",'ע������'));

    //�����
    $excel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
    $excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
    $excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
    $excel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
    $excel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
    $excel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
    $excel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
    $excel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
    //��?ֵ
    $user_list = user_list();
    $user_list = $user_list['user_list'];
    //�������Ϣ
    $hang = 2;
    $shuliang   = 0;
    $chanpin    = $hang;
    foreach ($user_list as $key=>$value) {
        // $shuliang = $shuliang + 1;

        $excel->getActiveSheet()->setCellValue('A' . $hang,iconv("gbk","utf-8//IGNORE", $value['user_name'])." ");//�Ӹ��ո񣬷�ֹʱ�����ת��
        $excel->getActiveSheet()->setCellValue('B' . $hang, $value['mobile_phone']." ");
        $excel->getActiveSheet()->setCellValue('C' . $hang, $value['email']);
        $excel->getActiveSheet()->setCellValue('D' . $hang, $value['user_money']." ");
        $excel->getActiveSheet()->setCellValue('E' . $hang, $value['frozen_money']." ");
        $excel->getActiveSheet()->setCellValue('F' . $hang, $value['rank_points']." ");
        $excel->getActiveSheet()->setCellValue('G' . $hang, $value['pay_points']." ");
        $excel->getActiveSheet()->setCellValue('H' . $hang, $value['reg_time']." ");
        $hang = $hang + 1;
    }
        //����Excel�������
        $write = new PHPExcel_Writer_Excel5($excel);
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");;
        header('Content-Disposition:attachment;filename=��Ա�б�'.date('Y-m-d',time()).'.xls');
        header("Content-Transfer-Encoding:binary");
        $write->save('php://output');

}


/*------------------------------------------------------ */
//-- �û��б�����excel����
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'import')
{
    /* ���Ȩ�� */
    admin_priv('users_manage');
    $sql = "SELECT rank_id, rank_name, min_points FROM ".$ecs->table('user_rank')." ORDER BY min_points ASC ";
    $rs = $db->query($sql);

    if(isset($_REQUEST['submit'])){ //����
        require(dirname(__FILE__) . '/includes/imgUpload.config.php');
        $upimg = new imgupload();
        if(!empty($_FILES['uploadFile']['tmp_name']))
        {
            $upimg->get_ph_tmpname($_FILES['uploadFile']['tmp_name']);
            $upimg->get_ph_type($_FILES['uploadFile']['type']);
            $upimg->get_ph_size($_FILES['uploadFile']['size']);
            $upimg->get_ph_name($_FILES['uploadFile']['name']);
            $upimg->save();
            $imgpath = $upimg->get_ph_name($_FILES['uploadFile']['name']);
            $excelname = $imgpath;
            require(dirname(__FILE__) . '/phpexcel/Classes/PHPExcel.php');

            $reader = PHPExcel_IOFactory::createReaderForFile($excelname);
            $PHPExcel = $reader->load($excelname); // �ļ�����
            $sheet1 = $PHPExcel->getSheet(0); // ��ȡ��һ���������0����

            $highestRowsheet1 = $sheet1->getHighestRow(); // ȡ��������

            for ($row = 2; $row <= $highestRowsheet1; $row++) {
                //�ж�ϵͳ�Ƿ���ڻ�Ա,���������,����insert
                $user_name = iconv("utf-8//IGNORE","gbk",$sheet1->getCellByColumnAndRow(0, $row)->getValue());

                if(!$user_name){
                    continue;
                }else{
                    $sql = "SELECT user_id FROM " . $ecs->table('users') . " WHERE user_name = '$user_name' LIMIT 1";
                    $ret = $db->getOne($sql);
                    if($ret){
                        continue;
                    }
                }

                //�û�������Ϣ
                $sex          = iconv("utf-8//IGNORE","gbk",$sheet1->getCellByColumnAndRow(1, $row)->getValue());
                $birthday     = iconv("utf-8//IGNORE","gbk",$sheet1->getCellByColumnAndRow(2, $row)->getValue());
                $zj_number    = iconv("utf-8//IGNORE","gbk",$sheet1->getCellByColumnAndRow(3, $row)->getValue());
                $alias        = iconv("utf-8//IGNORE","gbk",$sheet1->getCellByColumnAndRow(4, $row)->getValue());
                $mobile_phone = iconv("utf-8//IGNORE","gbk",$sheet1->getCellByColumnAndRow(5, $row)->getValue());
                $reg_time     = local_strtotime(local_date('Y-m-d H:i:s'));
                $user_rank    = 0;
                $password     = md5('123456');

                $sql = "INSERT INTO " . $ecs->table('users') . "(user_name,password,sex,birthday,zj_number,mobile_phone,user_rank,reg_time,alias) VALUES ('$user_name','$password','$sex','$birthday','$zj_number','$mobile_phone','$user_rank','$reg_time','$alias')";
                $db->query($sql);
                $user_id = $db->insert_id();
                if(!$user_id){
                    continue;
                }

                //��ַ
                $address = iconv("utf-8//IGNORE","gbk",$sheet1->getCellByColumnAndRow(7, $row)->getValue());
                if($address){
                    $sql1 = "INSERT INTO " . $ecs->table('user_address') . "(user_id,address,mobile) VALUES($user_id,'$address','$mobile_phone')";
                    $db->query($sql1);
                    $address_id = $db->insert_id();
                    if($address){
                        $sql_update = "UPDATE " . $ecs->table('users') . "SET address_id=$address_id WHERE user_id = $user_id";
                        $db->query($sql_update);
                    }

                }

                //�û���չ��Ϣ
                $job_address = iconv("utf-8//IGNORE","gbk",$sheet1->getCellByColumnAndRow(6, $row)->getValue());
                $car_card = iconv("utf-8//IGNORE","gbk",$sheet1->getCellByColumnAndRow(8, $row)->getValue());
                $car_type = iconv("utf-8//IGNORE","gbk",$sheet1->getCellByColumnAndRow(9, $row)->getValue());
                $car_owner = iconv("utf-8//IGNORE","gbk",$sheet1->getCellByColumnAndRow(10, $row)->getValue());
                $car_frame_num = iconv("utf-8//IGNORE","gbk",$sheet1->getCellByColumnAndRow(11, $row)->getValue());
                $engine_num = iconv("utf-8//IGNORE","gbk",$sheet1->getCellByColumnAndRow(12, $row)->getValue());
                $first_register_time = iconv("utf-8//IGNORE","gbk",$sheet1->getCellByColumnAndRow(13, $row)->getValue());
                $buy_time = iconv("utf-8//IGNORE","gbk",$sheet1->getCellByColumnAndRow(14, $row)->getValue());
                $insurance_num = iconv("utf-8//IGNORE","gbk",$sheet1->getCellByColumnAndRow(15, $row)->getValue());
                $insurance_type = iconv("utf-8//IGNORE","gbk",$sheet1->getCellByColumnAndRow(16, $row)->getValue());
                $insurance_type_1     = iconv("utf-8//IGNORE","gbk",$sheet1->getCellByColumnAndRow(17, $row)->getValue());
                $product_name         = iconv("utf-8//IGNORE","gbk",$sheet1->getCellByColumnAndRow(18, $row)->getValue());
                $insurance_company    = iconv("utf-8//IGNORE","gbk",$sheet1->getCellByColumnAndRow(19, $row)->getValue());
                $insurance_begin_time = iconv("utf-8//IGNORE","gbk",$sheet1->getCellByColumnAndRow(20, $row)->getValue());
                $insurance_end_time   = iconv("utf-8//IGNORE","gbk",$sheet1->getCellByColumnAndRow(21, $row)->getValue());
                $insurance_money      = iconv("utf-8//IGNORE","gbk",$sheet1->getCellByColumnAndRow(22, $row)->getValue());
                $remarks              = iconv("utf-8//IGNORE","gbk",$sheet1->getCellByColumnAndRow(23, $row)->getValue());

                $sql2 =  "INSERT INTO " . $ecs->table('order_from_excel') . "(job_address,car_card,car_type,car_owner,car_frame_num,engine_num,first_register_time,buy_time,insurance_num,insurance_type,insurance_type_1,product_name,insurance_company,insurance_begin_time,insurance_end_time,insurance_money,remarks) VALUES " .
                         "('$job_address','$car_card','$car_type','$car_owner','$car_frame_num','$engine_num','$first_register_time','$buy_time','$insurance_num','$insurance_type','$insurance_type_1','$product_name','$insurance_company','$insurance_begin_time','$insurance_end_time','$insurance_money','$remarks')";
                $db->query($sql2);

                /* ��¼����Ա���� */
                admin_log($_FILES['uploadFile']['tmp_name'], 'implode', 'users');
            }
            /* ��ʾ��Ϣ */
            $link[] = array('text' => $_LANG['go_back'], 'href'=>'users.php?act=list');
            sys_msg(sprintf('�����˺ŵ���ɹ�'), 0, $link);
        }else{
            /* ��ʾ��Ϣ */
            $link[] = array('text' => $_LANG['go_back'], 'href'=>'users.php?act=list');
            sys_msg(sprintf('���ϴ���ȷ��ʽ���ļ�'), 0, $link);
        }

    }else{ //ҳ��չʾ
        assign_query_info();
        $smarty->display('user_import.htm');
    }
}

/*------------------------------------------------------ */
//-- ajax�����û��б�
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'query')
{
    $user_list = user_list();

    $smarty->assign('user_list',    $user_list['user_list']);
    $smarty->assign('filter',       $user_list['filter']);
    $smarty->assign('record_count', $user_list['record_count']);
    $smarty->assign('page_count',   $user_list['page_count']);

    $sort_flag  = sort_flag($user_list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    make_json_result($smarty->fetch('users_list.htm'), '', array('filter' => $user_list['filter'], 'page_count' => $user_list['page_count']));
}

/*------------------------------------------------------ */
//-- ��ӻ�Ա�ʺ�
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'add')
{
    /* ���Ȩ�� */
    admin_priv('users_manage');

    $user = array(  'rank_points'   => $_CFG['register_points'],
                    'pay_points'    => $_CFG['register_points'],
                    'sex'           => 0,
                    'credit_line'   => 0
                    );
    /* ȡ��ע����չ�ֶ� */
    $sql = 'SELECT * FROM ' . $ecs->table('reg_fields') . ' WHERE type < 2 AND display = 1 AND id != 6 ORDER BY dis_order, id';
    $extend_info_list = $db->getAll($sql);
    $smarty->assign('extend_info_list', $extend_info_list);

    $smarty->assign('ur_here',          $_LANG['04_users_add']);
    $smarty->assign('action_link',      array('text' => $_LANG['03_users_list'], 'href'=>'users.php?act=list'));
    $smarty->assign('form_action',      'insert');
    $smarty->assign('user',             $user);
    $smarty->assign('special_ranks',    get_rank_list(true));

    assign_query_info();
    $smarty->display('user_info.htm');
}

/*------------------------------------------------------ */
//-- ��ӻ�Ա�ʺ�
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'insert')
{
    /* ���Ȩ�� */
    admin_priv('users_manage');
    $username = empty($_POST['username']) ? '' : trim($_POST['username']);
    $password = empty($_POST['password']) ? '' : trim($_POST['password']);
    $email = empty($_POST['email']) ? '' : trim($_POST['email']);
    $sex = empty($_POST['sex']) ? 0 : intval($_POST['sex']);
    $sex = in_array($sex, array(0, 1, 2)) ? $sex : 0;
    $birthday = $_POST['birthdayYear'] . '-' .  $_POST['birthdayMonth'] . '-' . $_POST['birthdayDay'];
    $rank = empty($_POST['user_rank']) ? 0 : intval($_POST['user_rank']);
    $credit_line = empty($_POST['credit_line']) ? 0 : floatval($_POST['credit_line']);

    $users =& init_users();

    if (!$users->add_user($username, $password, $email))
    {
        /* �����Ա����ʧ�� */
        if ($users->error == ERR_INVALID_USERNAME)
        {
            $msg = $_LANG['username_invalid'];
        }
        elseif ($users->error == ERR_USERNAME_NOT_ALLOW)
        {
            $msg = $_LANG['username_not_allow'];
        }
        elseif ($users->error == ERR_USERNAME_EXISTS)
        {
            $msg = $_LANG['username_exists'];
        }
        elseif ($users->error == ERR_INVALID_EMAIL)
        {
            $msg = $_LANG['email_invalid'];
        }
        elseif ($users->error == ERR_EMAIL_NOT_ALLOW)
        {
            $msg = $_LANG['email_not_allow'];
        }
        elseif ($users->error == ERR_EMAIL_EXISTS)
        {
            $msg = $_LANG['email_exists'];
        }
        else
        {
            //die('Error:'.$users->error_msg());
        }
        sys_msg($msg, 1);
    }

    /* ע���ͻ��� */
    if (!empty($GLOBALS['_CFG']['register_points']))
    {
        log_account_change($_SESSION['user_id'], 0, 0, $GLOBALS['_CFG']['register_points'], $GLOBALS['_CFG']['register_points'], $_LANG['register_points']);
    }

    /*����ע���û�����չ��Ϣ�������ݿ�*/
    $sql = 'SELECT id FROM ' . $ecs->table('reg_fields') . ' WHERE type = 0 AND display = 1 ORDER BY dis_order, id';   //����������չ�ֶε�id
    $fields_arr = $db->getAll($sql);

    $extend_field_str = '';    //������չ�ֶε������ַ���
    $user_id_arr = $users->get_profile_by_name($username);
    foreach ($fields_arr AS $val)
    {
        $extend_field_index = 'extend_field' . $val['id'];
        if(!empty($_POST[$extend_field_index]))
        {
            $temp_field_content = strlen($_POST[$extend_field_index]) > 100 ? mb_substr($_POST[$extend_field_index], 0, 99) : $_POST[$extend_field_index];
            $extend_field_str .= " ('" . $user_id_arr['user_id'] . "', '" . $val['id'] . "', '" . $temp_field_content . "'),";
        }
    }
    $extend_field_str = substr($extend_field_str, 0, -1);

    if ($extend_field_str)      //����ע����չ����
    {
        $sql = 'INSERT INTO '. $ecs->table('reg_extend_info') . ' (`user_id`, `reg_field_id`, `content`) VALUES' . $extend_field_str;
        $db->query($sql);
    }

    /* ���»�Ա��������Ϣ */
    $other =  array();
    $other['credit_line'] = $credit_line;
    $other['user_rank']  = $rank;
    $other['sex']        = $sex;
    $other['birthday']   = $birthday;
    $other['reg_time'] = local_strtotime(local_date('Y-m-d H:i:s'));

    $other['msn'] = isset($_POST['extend_field1']) ? htmlspecialchars(trim($_POST['extend_field1'])) : '';
    $other['qq'] = isset($_POST['extend_field2']) ? htmlspecialchars(trim($_POST['extend_field2'])) : '';
    $other['office_phone'] = isset($_POST['extend_field3']) ? htmlspecialchars(trim($_POST['extend_field3'])) : '';
    $other['home_phone'] = isset($_POST['extend_field4']) ? htmlspecialchars(trim($_POST['extend_field4'])) : '';
    $other['mobile_phone'] = isset($_POST['extend_field5']) ? htmlspecialchars(trim($_POST['extend_field5'])) : '';

    $db->autoExecute($ecs->table('users'), $other, 'UPDATE', "user_name = '$username'");

    /* ��¼����Ա���� */
    admin_log($_POST['username'], 'add', 'users');

    /* ��ʾ��Ϣ */
    $link[] = array('text' => $_LANG['go_back'], 'href'=>'users.php?act=list');
    sys_msg(sprintf($_LANG['add_success'], htmlspecialchars(stripslashes($_POST['username']))), 0, $link);

}

/*------------------------------------------------------ */
//-- �༭�û��ʺ�
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'edit')
{
    /* ���Ȩ�� */
    admin_priv('users_manage');

    $sql = "SELECT u.user_name, u.sex, u.birthday, u.pay_points, u.rank_points, u.user_rank , u.user_money, u.frozen_money, u.credit_line, u.parent_id, u2.user_name as parent_username, u.qq, u.msn, u.office_phone, u.home_phone, u.mobile_phone".
        " FROM " .$ecs->table('users'). " u LEFT JOIN " . $ecs->table('users') . " u2 ON u.parent_id = u2.user_id WHERE u.user_id='$_GET[id]'";

    $row = $db->GetRow($sql);
    $row['user_name'] = addslashes($row['user_name']);
    $users  =& init_users();
    $user   = $users->get_user_info($row['user_name']);

    $sql = "SELECT u.user_id, u.sex, u.birthday, u.pay_points, u.rank_points, u.user_rank , u.user_money, u.frozen_money, u.credit_line, u.parent_id, u2.user_name as parent_username, u.qq, u.msn,
    u.office_phone, u.home_phone, u.mobile_phone,u.sfz_pic".
        " FROM " .$ecs->table('users'). " u LEFT JOIN " . $ecs->table('users') . " u2 ON u.parent_id = u2.user_id WHERE u.user_id='$_GET[id]'";

    $row = $db->GetRow($sql);

    if ($row)
    {
        $user['user_id']        = $row['user_id'];
        $user['sex']            = $row['sex'];
        $user['birthday']       = date($row['birthday']);
        $user['pay_points']     = $row['pay_points'];
        $user['rank_points']    = $row['rank_points'];
        $user['user_rank']      = $row['user_rank'];
        $user['user_money']     = $row['user_money'];
        $user['frozen_money']   = $row['frozen_money'];
        $user['credit_line']    = $row['credit_line'];
        $user['formated_user_money'] = price_format($row['user_money']);
        $user['formated_frozen_money'] = price_format($row['frozen_money']);
        $user['parent_id']      = $row['parent_id'];
        $user['parent_username']= $row['parent_username'];
        $user['qq']             = $row['qq'];
        $user['msn']            = $row['msn'];
        $user['office_phone']   = $row['office_phone'];
        $user['home_phone']     = $row['home_phone'];
        $user['mobile_phone']   = $row['mobile_phone'];
		$user['sfz_pic']        = $row['sfz_pic'];
    }
    else
    {
          $link[] = array('text' => $_LANG['go_back'], 'href'=>'users.php?act=list');
          sys_msg($_LANG['username_invalid'], 0, $links);
//        $user['sex']            = 0;
//        $user['pay_points']     = 0;
//        $user['rank_points']    = 0;
//        $user['user_money']     = 0;
//        $user['frozen_money']   = 0;
//        $user['credit_line']    = 0;
//        $user['formated_user_money'] = price_format(0);
//        $user['formated_frozen_money'] = price_format(0);
     }

    /* ȡ��ע����չ�ֶ� */
    $sql = 'SELECT * FROM ' . $ecs->table('reg_fields') . ' WHERE type < 2 AND display = 1 AND id != 6 ORDER BY dis_order, id';
    $extend_info_list = $db->getAll($sql);

    $sql = 'SELECT reg_field_id, content ' .
           'FROM ' . $ecs->table('reg_extend_info') .
           " WHERE user_id = $user[user_id]";
    $extend_info_arr = $db->getAll($sql);

    $temp_arr = array();
    foreach ($extend_info_arr AS $val)
    {
        $temp_arr[$val['reg_field_id']] = $val['content'];
    }

    foreach ($extend_info_list AS $key => $val)
    {
        switch ($val['id'])
        {
            case 1:     $extend_info_list[$key]['content'] = $user['msn']; break;
            case 2:     $extend_info_list[$key]['content'] = $user['qq']; break;
            case 3:     $extend_info_list[$key]['content'] = $user['office_phone']; break;
            case 4:     $extend_info_list[$key]['content'] = $user['home_phone']; break;
            case 5:     $extend_info_list[$key]['content'] = $user['mobile_phone']; break;
            default:    $extend_info_list[$key]['content'] = empty($temp_arr[$val['id']]) ? '' : $temp_arr[$val['id']] ;
        }
    }

    $smarty->assign('extend_info_list', $extend_info_list);

    /* ��ǰ��Ա�Ƽ���Ϣ */
    $affiliate = unserialize($GLOBALS['_CFG']['affiliate']);
    $smarty->assign('affiliate', $affiliate);

    empty($affiliate) && $affiliate = array();

    if(empty($affiliate['config']['separate_by']))
    {
        //�Ƽ�ע��ֳ�
        $affdb = array();
        $num = count($affiliate['item']);
        $up_uid = "'$_GET[id]'";
        for ($i = 1 ; $i <=$num ;$i++)
        {
            $count = 0;
            if ($up_uid)
            {
                $sql = "SELECT user_id FROM " . $ecs->table('users') . " WHERE parent_id IN($up_uid)";
                $query = $db->query($sql);
                $up_uid = '';
                while ($rt = $db->fetch_array($query))
                {
                    $up_uid .= $up_uid ? ",'$rt[user_id]'" : "'$rt[user_id]'";
                    $count++;
                }
            }
            $affdb[$i]['num'] = $count;
        }
        if ($affdb[1]['num'] > 0)
        {
            $smarty->assign('affdb', $affdb);
        }
    }


    assign_query_info();
    $smarty->assign('ur_here',          $_LANG['users_edit']);
    $smarty->assign('action_link',      array('text' => $_LANG['03_users_list'], 'href'=>'users.php?act=list&' . list_link_postfix()));
    $smarty->assign('user',             $user);
    $smarty->assign('form_action',      'update');
    $smarty->assign('special_ranks',    get_rank_list(true));
    $smarty->display('user_info.htm');
}

/*------------------------------------------------------ */
//-- �����û��ʺ�
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'update')
{
    /* ���Ȩ�� */
    admin_priv('users_manage');
    $username = empty($_POST['username']) ? '' : trim($_POST['username']);
    $password = empty($_POST['password']) ? '' : trim($_POST['password']);
    $email = empty($_POST['email']) ? '' : trim($_POST['email']);
    $sex = empty($_POST['sex']) ? 0 : intval($_POST['sex']);
    $sex = in_array($sex, array(0, 1, 2)) ? $sex : 0;
    $birthday = $_POST['birthdayYear'] . '-' .  $_POST['birthdayMonth'] . '-' . $_POST['birthdayDay'];
    $rank = empty($_POST['user_rank']) ? 0 : intval($_POST['user_rank']);
    $credit_line = empty($_POST['credit_line']) ? 0 : floatval($_POST['credit_line']);

    $users  =& init_users();

    if (!$users->edit_user(array('username'=>$username, 'password'=>$password, 'email'=>$email, 'gender'=>$sex, 'bday'=>$birthday ), 1))
    {
        if ($users->error == ERR_EMAIL_EXISTS)
        {
            $msg = $_LANG['email_exists'];
        }
        else
        {
            $msg = $_LANG['edit_user_failed'];
        }
        sys_msg($msg, 1);
    }
    if(!empty($password))
    {
			$sql="UPDATE ".$ecs->table('users'). "SET `ec_salt`='0' WHERE user_name= '".$username."'";
			$db->query($sql);
	}
    /* �����û���չ�ֶε����� */
    $sql = 'SELECT id FROM ' . $ecs->table('reg_fields') . ' WHERE type = 0 AND display = 1 ORDER BY dis_order, id';   //����������չ�ֶε�id
    $fields_arr = $db->getAll($sql);
    $user_id_arr = $users->get_profile_by_name($username);
    $user_id = $user_id_arr['user_id'];

    foreach ($fields_arr AS $val)       //ѭ��������չ�û���Ϣ
    {
        $extend_field_index = 'extend_field' . $val['id'];
        if(isset($_POST[$extend_field_index]))
        {
            $temp_field_content = strlen($_POST[$extend_field_index]) > 100 ? mb_substr($_POST[$extend_field_index], 0, 99) : $_POST[$extend_field_index];

            $sql = 'SELECT * FROM ' . $ecs->table('reg_extend_info') . "  WHERE reg_field_id = '$val[id]' AND user_id = '$user_id'";
            if ($db->getOne($sql))      //���֮ǰû�м�¼�������
            {
                $sql = 'UPDATE ' . $ecs->table('reg_extend_info') . " SET content = '$temp_field_content' WHERE reg_field_id = '$val[id]' AND user_id = '$user_id'";
            }
            else
            {
                $sql = 'INSERT INTO '. $ecs->table('reg_extend_info') . " (`user_id`, `reg_field_id`, `content`) VALUES ('$user_id', '$val[id]', '$temp_field_content')";
            }
            $db->query($sql);
        }
    }


    /* ���»�Ա��������Ϣ */
    $other =  array();
    $other['credit_line'] = $credit_line;
    $other['user_rank'] = $rank;

    $other['msn'] = isset($_POST['extend_field1']) ? htmlspecialchars(trim($_POST['extend_field1'])) : '';
    $other['qq'] = isset($_POST['extend_field2']) ? htmlspecialchars(trim($_POST['extend_field2'])) : '';
    $other['office_phone'] = isset($_POST['extend_field3']) ? htmlspecialchars(trim($_POST['extend_field3'])) : '';
    $other['home_phone'] = isset($_POST['extend_field4']) ? htmlspecialchars(trim($_POST['extend_field4'])) : '';
    $other['mobile_phone'] = isset($_POST['extend_field5']) ? htmlspecialchars(trim($_POST['extend_field5'])) : '';

    $db->autoExecute($ecs->table('users'), $other, 'UPDATE', "user_name = '$username'");

    /* ��¼����Ա���� */
    admin_log($username, 'edit', 'users');

    /* ��ʾ��Ϣ */
    $links[0]['text']    = $_LANG['goto_list'];
    $links[0]['href']    = 'users.php?act=list&' . list_link_postfix();
    $links[1]['text']    = $_LANG['go_back'];
    $links[1]['href']    = 'javascript:history.back()';

    sys_msg($_LANG['update_success'], 0, $links);

}

/*------------------------------------------------------ */
//-- ����ɾ����Ա�ʺ�
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'batch_remove')
{
    /* ���Ȩ�� */
    admin_priv('users_drop');

    if (isset($_POST['checkboxes']))
    {
        $sql = "SELECT user_name FROM " . $ecs->table('users') . " WHERE user_id " . db_create_in($_POST['checkboxes']);
        $col = $db->getCol($sql);
        $usernames = implode(',',addslashes_deep($col));
        $count = count($col);
        /* ͨ�������ɾ���û� */
        $users =& init_users();
        $users->remove_user($col);

        admin_log($usernames, 'batch_remove', 'users');

        $lnk[] = array('text' => $_LANG['go_back'], 'href'=>'users.php?act=list');
        sys_msg(sprintf($_LANG['batch_remove_success'], $count), 0, $lnk);
    }
    else
    {
        $lnk[] = array('text' => $_LANG['go_back'], 'href'=>'users.php?act=list');
        sys_msg($_LANG['no_select_user'], 0, $lnk);
    }
}

/* �༭�û��� */
elseif ($_REQUEST['act'] == 'edit_username')
{
    /* ���Ȩ�� */
    check_authz_json('users_manage');

    $username = empty($_REQUEST['val']) ? '' : json_str_iconv(trim($_REQUEST['val']));
    $id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);

    if ($id == 0)
    {
        make_json_error('NO USER ID');
        return;
    }

    if ($username == '')
    {
        make_json_error($GLOBALS['_LANG']['username_empty']);
        return;
    }

    $users =& init_users();

    if ($users->edit_user($id, $username))
    {
        if ($_CFG['integrate_code'] != 'ecshop')
        {
            /* �����̳ǻ�Ա�� */
            $db->query('UPDATE ' .$ecs->table('users'). " SET user_name = '$username' WHERE user_id = '$id'");
        }

        admin_log(addslashes($username), 'edit', 'users');
        make_json_result(stripcslashes($username));
    }
    else
    {
        $msg = ($users->error == ERR_USERNAME_EXISTS) ? $GLOBALS['_LANG']['username_exists'] : $GLOBALS['_LANG']['edit_user_failed'];
        make_json_error($msg);
    }
}

/*------------------------------------------------------ */
//-- �༭email
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'edit_email')
{
    /* ���Ȩ�� */
    check_authz_json('users_manage');

    $id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
    $email = empty($_REQUEST['val']) ? '' : json_str_iconv(trim($_REQUEST['val']));

    $users =& init_users();

    $sql = "SELECT user_name FROM " . $ecs->table('users') . " WHERE user_id = '$id'";
    $username = $db->getOne($sql);


    if (is_email($email))
    {
        if ($users->edit_user(array('username'=>$username, 'email'=>$email)))
        {
            admin_log(addslashes($username), 'edit', 'users');

            make_json_result(stripcslashes($email));
        }
        else
        {
            $msg = ($users->error == ERR_EMAIL_EXISTS) ? $GLOBALS['_LANG']['email_exists'] : $GLOBALS['_LANG']['edit_user_failed'];
            make_json_error($msg);
        }
    }
    else
    {
        make_json_error($GLOBALS['_LANG']['invalid_email']);
    }
}

/*------------------------------------------------------ */
//-- ɾ����Ա�ʺ�
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'remove')
{
    /* ���Ȩ�� */
    admin_priv('users_drop');

    $sql = "SELECT user_name FROM " . $ecs->table('users') . " WHERE user_id = '" . $_GET['id'] . "'";
    $username = $db->getOne($sql);
    /* ͨ�������ɾ���û� */
    $users =& init_users();
    $users->remove_user($username); //�Ѿ�ɾ���û���������

    /* ��¼����Ա���� */
    admin_log(addslashes($username), 'remove', 'users');

    /* ��ʾ��Ϣ */
    $link[] = array('text' => $_LANG['go_back'], 'href'=>'users.php?act=list');
    sys_msg(sprintf($_LANG['remove_success'], $username), 0, $link);
}

/*------------------------------------------------------ */
//--  �ջ���ַ�鿴
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'address_list')
{
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $sql = "SELECT a.*, c.region_name AS country_name, p.region_name AS province, ct.region_name AS city_name, d.region_name AS district_name ".
           " FROM " .$ecs->table('user_address'). " as a ".
           " LEFT JOIN " . $ecs->table('region') . " AS c ON c.region_id = a.country " .
           " LEFT JOIN " . $ecs->table('region') . " AS p ON p.region_id = a.province " .
           " LEFT JOIN " . $ecs->table('region') . " AS ct ON ct.region_id = a.city " .
           " LEFT JOIN " . $ecs->table('region') . " AS d ON d.region_id = a.district " .
           " WHERE user_id='$id'";
    $address = $db->getAll($sql);
    $smarty->assign('address',          $address);
    assign_query_info();
    $smarty->assign('ur_here',          $_LANG['address_list']);
    $smarty->assign('action_link',      array('text' => $_LANG['03_users_list'], 'href'=>'users.php?act=list&' . list_link_postfix()));
    $smarty->display('user_address_list.htm');
}

/*------------------------------------------------------ */
//-- �����Ƽ���ϵ
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'remove_parent')
{
    /* ���Ȩ�� */
    admin_priv('users_manage');

    $sql = "UPDATE " . $ecs->table('users') . " SET parent_id = 0 WHERE user_id = '" . $_GET['id'] . "'";
    $db->query($sql);

    /* ��¼����Ա���� */
    $sql = "SELECT user_name FROM " . $ecs->table('users') . " WHERE user_id = '" . $_GET['id'] . "'";
    $username = $db->getOne($sql);
    admin_log(addslashes($username), 'edit', 'users');

    /* ��ʾ��Ϣ */
    $link[] = array('text' => $_LANG['go_back'], 'href'=>'users.php?act=list');
    sys_msg(sprintf($_LANG['update_success'], $username), 0, $link);
}

/*------------------------------------------------------ */
//-- �鿴�û��Ƽ���Ա�б�
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'aff_list')
{
    /* ���Ȩ�� */
    admin_priv('users_manage');
    $smarty->assign('ur_here',      $_LANG['03_users_list']);

    $auid = $_GET['auid'];
    $user_list['user_list'] = array();

    $affiliate = unserialize($GLOBALS['_CFG']['affiliate']);
    $smarty->assign('affiliate', $affiliate);

    empty($affiliate) && $affiliate = array();

    $num = count($affiliate['item']);
    $up_uid = "'$auid'";
    $all_count = 0;
    for ($i = 1; $i<=$num; $i++)
    {
        $count = 0;
        if ($up_uid)
        {
            $sql = "SELECT user_id FROM " . $ecs->table('users') . " WHERE parent_id IN($up_uid)";
            $query = $db->query($sql);
            $up_uid = '';
            while ($rt = $db->fetch_array($query))
            {
                $up_uid .= $up_uid ? ",'$rt[user_id]'" : "'$rt[user_id]'";
                $count++;
            }
        }
        $all_count += $count;

        if ($count)
        {
            $sql = "SELECT user_id, user_name, '$i' AS level, email, is_validated, user_money, frozen_money, rank_points, pay_points, reg_time ".
                    " FROM " . $GLOBALS['ecs']->table('users') . " WHERE user_id IN($up_uid)" .
                    " ORDER by level, user_id";
            $user_list['user_list'] = array_merge($user_list['user_list'], $db->getAll($sql));
        }
    }

    $temp_count = count($user_list['user_list']);
    for ($i=0; $i<$temp_count; $i++)
    {
        $user_list['user_list'][$i]['reg_time'] = local_date($_CFG['date_format'], $user_list['user_list'][$i]['reg_time']);
    }

    $user_list['record_count'] = $all_count;

    $smarty->assign('user_list',    $user_list['user_list']);
    $smarty->assign('record_count', $user_list['record_count']);
    $smarty->assign('full_page',    1);
    $smarty->assign('action_link',  array('text' => $_LANG['back_note'], 'href'=>"users.php?act=edit&id=$auid"));

    assign_query_info();
    $smarty->display('affiliate_list.htm');
}

/**
 *  �����û��б�����
 *
 * @access  public
 * @param
 *
 * @return void
 */
function user_list()
{
    $result = get_filter();
    if ($result === false)
    {
        /* �������� */
        $filter['keywords'] = empty($_REQUEST['keywords']) ? '' : trim($_REQUEST['keywords']);
        if (isset($_REQUEST['is_ajax']) && $_REQUEST['is_ajax'] == 1)
        {
            $filter['keywords'] = json_str_iconv($filter['keywords']);
        }
        $filter['rank'] = empty($_REQUEST['rank']) ? 0 : intval($_REQUEST['rank']);
        $filter['pay_points_gt'] = empty($_REQUEST['pay_points_gt']) ? 0 : intval($_REQUEST['pay_points_gt']);
        $filter['pay_points_lt'] = empty($_REQUEST['pay_points_lt']) ? 0 : intval($_REQUEST['pay_points_lt']);

        $filter['sort_by']    = empty($_REQUEST['sort_by'])    ? 'user_id' : trim($_REQUEST['sort_by']);
        $filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'DESC'     : trim($_REQUEST['sort_order']);

        $ex_where = ' WHERE 1 ';
        if ($filter['keywords'])
        {
            $ex_where .= " AND user_name LIKE '%" . mysql_like_quote($filter['keywords']) ."%'";
        }
        if ($filter['rank'])
        {
            $sql = "SELECT min_points, max_points, special_rank FROM ".$GLOBALS['ecs']->table('user_rank')." WHERE rank_id = '$filter[rank]'";
            $row = $GLOBALS['db']->getRow($sql);
            if ($row['special_rank'] > 0)
            {
                /* ����ȼ� */
                $ex_where .= " AND user_rank = '$filter[rank]' ";
            }
            else
            {
                $ex_where .= " AND rank_points >= " . intval($row['min_points']) . " AND rank_points < " . intval($row['max_points']);
            }
        }
        if ($filter['pay_points_gt'])
        {
             $ex_where .=" AND pay_points >= '$filter[pay_points_gt]' ";
        }
        if ($filter['pay_points_lt'])
        {
            $ex_where .=" AND pay_points < '$filter[pay_points_lt]' ";
        }

        $filter['record_count'] = $GLOBALS['db']->getOne("SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('users') . $ex_where);

        /* ��ҳ��С */
        $filter = page_and_size($filter);
        $sql = "SELECT user_id, user_name, email, is_validated, user_money, frozen_money, rank_points, pay_points, reg_time,sfz_pic,user_rank ".
                " FROM " . $GLOBALS['ecs']->table('users') . $ex_where .
                " ORDER by " . $filter['sort_by'] . ' ' . $filter['sort_order'] .
                " LIMIT " . $filter['start'] . ',' . $filter['page_size'];

        $filter['keywords'] = stripslashes($filter['keywords']);
        set_filter($filter, $sql);
    }
    else
    {
        $sql    = $result['sql'];
        $filter = $result['filter'];
    }

    $user_list = $GLOBALS['db']->getAll($sql);

    $count = count($user_list);
    for ($i=0; $i<$count; $i++)
    {
        $user_list[$i]['reg_time'] = local_date($GLOBALS['_CFG']['date_format'], $user_list[$i]['reg_time']);
    }

    $arr = array('user_list' => $user_list, 'filter' => $filter,
        'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);

    return $arr;
}

?>