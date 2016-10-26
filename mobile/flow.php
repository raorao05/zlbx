<?php

/**
 * ECSHOP ��������
 * ============================================================================
 * ��Ȩ���� 2005-2010 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ��������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã��������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: douqinghua $
 * $Id: flow.php 17218 2011-01-24 04:10:41Z douqinghua $
 */

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require(ROOT_PATH . 'includes/lib_order.php');

/* ���������ļ� */
require_once(ROOT_PATH . 'languages/' .$_CFG['lang']. '/user.php');
require_once(ROOT_PATH . 'languages/' .$_CFG['lang']. '/shopping_flow.php');

/*------------------------------------------------------ */
//-- INPUT
/*------------------------------------------------------ */

if (!isset($_REQUEST['step']))
{
    $_REQUEST['step'] = "cart";
}

/*------------------------------------------------------ */
//-- PROCESSOR
/*------------------------------------------------------ */

assign_template();
assign_dynamic('flow');
$position = assign_ur_here(0, $_LANG['shopping_flow']);
$smarty->assign('page_title',       $position['title']);    // ҳ�����
$smarty->assign('ur_here',          $position['ur_here']);  // ��ǰλ��

$arr=get_categories_tree();
$i=1;
foreach($arr as $key=>$v){
	$categories[$i++]=$v;
}
$smarty->assign('categories',       $categories);  // ������
$smarty->assign('helps',            get_shop_help());       // �������
$smarty->assign('lang',             $_LANG);
$smarty->assign('show_marketprice', $_CFG['show_marketprice']);
$smarty->assign('data_dir',    DATA_DIR);       // ����Ŀ¼

/*------------------------------------------------------ */
//-- ������Ʒ�����ﳵ
/*------------------------------------------------------ */
if ($_REQUEST['step'] == 'add_to_cart')
{
    include_once('includes/cls_json.php');
    $_POST['goods']=strip_tags(urldecode($_POST['goods']));
    $_POST['goods'] = json_str_iconv($_POST['goods']);

    if (!empty($_REQUEST['goods_id']) && empty($_POST['goods']))
    {
        if (!is_numeric($_REQUEST['goods_id']) || intval($_REQUEST['goods_id']) <= 0)
        {
            ecs_header("Location:./\n");
        }
        $goods_id = intval($_REQUEST['goods_id']);
        exit;
    }

    $result = array('error' => 0, 'message' => '', 'content' => '', 'goods_id' => '');
    $json  = new JSON;

    if (empty($_POST['goods']))
    {
        $result['error'] = 1;
        die($json->encode($result));
    }

    $goods = $json->decode($_POST['goods']);

    /* ��飺�����Ʒ�й�񣬶�post������û�й�񣬰���Ʒ�Ĺ������ͨ��JSON����ǰ̨ */
    if (empty($goods->spec) AND empty($goods->quick))
    {
        $sql = "SELECT a.attr_id, a.attr_name, a.attr_type, ".
            "g.goods_attr_id, g.attr_value, g.attr_price " .
        'FROM ' . $GLOBALS['ecs']->table('goods_attr') . ' AS g ' .
        'LEFT JOIN ' . $GLOBALS['ecs']->table('attribute') . ' AS a ON a.attr_id = g.attr_id ' .
        "WHERE a.attr_type != 0 AND g.goods_id = '" . $goods->goods_id . "' " .
        'ORDER BY a.sort_order, g.attr_price, g.goods_attr_id';

        $res = $GLOBALS['db']->getAll($sql);

        if (!empty($res))
        {
            $spe_arr = array();
            foreach ($res AS $row)
            {
                $spe_arr[$row['attr_id']]['attr_type'] = $row['attr_type'];
                $spe_arr[$row['attr_id']]['name']     = $row['attr_name'];
                $spe_arr[$row['attr_id']]['attr_id']     = $row['attr_id'];
                $spe_arr[$row['attr_id']]['values'][] = array(
                                                            'label'        => $row['attr_value'],
                                                            'price'        => $row['attr_price'],
                                                            'format_price' => price_format($row['attr_price'], false),
                                                            'id'           => $row['goods_attr_id']);
            }
            $i = 0;
            $spe_array = array();
            foreach ($spe_arr AS $row)
            {
                $spe_array[]=$row;
            }
            $result['error']   = ERR_NEED_SELECT_ATTR;
            $result['goods_id'] = $goods->goods_id;
            $result['parent'] = $goods->parent;
            $result['message'] = $spe_array;

            die($json->encode($result));
        }
    }

    /* ���£������һ���������չ��ﳵ */
    if ($_CFG['one_step_buy'] == '1')
    {
        clear_cart();
    }

    /* ��飺��Ʒ�����Ƿ�Ϸ� */
    if (!is_numeric($goods->number) || intval($goods->number) <= 0)
    {
        $result['error']   = 1;
        $result['message'] = $_LANG['invalid_number'];
    }
    /* ���£����ﳵ */
    else
    {
        // ���£����ӵ����ﳵ
        if (addto_cart($goods->goods_id, $goods->number, $goods->spec, $goods->parent))
        {
            if ($_CFG['cart_confirm'] > 2)
            {
                $result['message'] = '';
            }
            else
            {
                $result['message'] = $_CFG['cart_confirm'] == 1 ? $_LANG['addto_cart_success_1'] : $_LANG['addto_cart_success_2'];
            }

            $result['content'] = insert_cart_info();
            $result['one_step_buy'] = $_CFG['one_step_buy'];
        }
        else
        {
            $result['message']  = $err->last_message();
            $result['error']    = $err->error_no;
            $result['goods_id'] = stripslashes($goods->goods_id);
            if (is_array($goods->spec))
            {
                $result['product_spec'] = implode(',', $goods->spec);
            }
            else
            {
                $result['product_spec'] = $goods->spec;
            }
        }
    }

    $result['confirm_type'] = !empty($_CFG['cart_confirm']) ? $_CFG['cart_confirm'] : 2;
    die($json->encode($result));
}
elseif ($_REQUEST['step'] == 'link_buy')
{
    $goods_id = intval($_GET['goods_id']);

    if (!cart_goods_exists($goods_id,array()))
    {
        addto_cart($goods_id);
    }
    ecs_header("Location:./flow.php\n");
    exit;
}
elseif ($_REQUEST['step'] == 'login')
{
    include_once('languages/'. $_CFG['lang']. '/user.php');

    /*
     * �û���¼ע��
     */
    if ($_SERVER['REQUEST_METHOD'] == 'GET')
    {
        $smarty->assign('anonymous_buy', $_CFG['anonymous_buy']);

        /* ����Ƿ�����Ʒ���������ʾ��¼������ѡ����Ʒ */
        $sql = "SELECT COUNT(*) FROM " . $ecs->table('cart') .
                " WHERE session_id = '" . SESS_ID . "' AND is_gift > 0";
        if ($db->getOne($sql) > 0)
        {
            $smarty->assign('need_rechoose_gift', 1);
        }

        /* ����Ƿ���Ҫע���� */
        $captcha = intval($_CFG['captcha']);
        if (($captcha & CAPTCHA_LOGIN) && (!($captcha & CAPTCHA_LOGIN_FAIL) || (($captcha & CAPTCHA_LOGIN_FAIL) && $_SESSION['login_fail'] > 2)) && gd_version() > 0)
        {
            $smarty->assign('enabled_login_captcha', 1);
            $smarty->assign('rand', mt_rand());
        }
        if ($captcha & CAPTCHA_REGISTER)
        {
            $smarty->assign('enabled_register_captcha', 1);
            $smarty->assign('rand', mt_rand());
        }
    }
    else
    {
        include_once('includes/lib_passport.php');
        if (!empty($_POST['act']) && $_POST['act'] == 'signin')
        {
            $captcha = intval($_CFG['captcha']);
            if (($captcha & CAPTCHA_LOGIN) && (!($captcha & CAPTCHA_LOGIN_FAIL) || (($captcha & CAPTCHA_LOGIN_FAIL) && $_SESSION['login_fail'] > 2)) && gd_version() > 0)
            {
                if (empty($_POST['captcha']))
                {
                    show_message($_LANG['invalid_captcha']);
                }

                /* �����֤�� */
                include_once('includes/cls_captcha.php');

                $validator = new captcha();
                $validator->session_word = 'captcha_login';
                if (!$validator->check_word($_POST['captcha']))
                {
                    show_message($_LANG['invalid_captcha']);
                }
            }

            if ($user->login($_POST['username'], $_POST['password'],isset($_POST['remember'])))
            {
                update_user_info();  //�����û���Ϣ
                recalculate_price(); // ���¼��㹺�ﳵ�е���Ʒ�۸�

                /* ��鹺�ﳵ���Ƿ�����Ʒ û����Ʒ����ת����ҳ */
                $sql = "SELECT COUNT(*) FROM " . $ecs->table('cart') . " WHERE session_id = '" . SESS_ID . "' ";
                if ($db->getOne($sql) > 0)
                {
                    ecs_header("Location: flow.php?step=checkout\n");
                }
                else
                {
                    ecs_header("Location:index.php\n");
                }

                exit;
            }
            else
            {
                $_SESSION['login_fail']++;
                show_message($_LANG['signin_failed'], '', 'flow.php?step=login');
            }
        }
        elseif (!empty($_POST['act']) && $_POST['act'] == 'signup')
        {
            if ((intval($_CFG['captcha']) & CAPTCHA_REGISTER) && gd_version() > 0)
            {
                if (empty($_POST['captcha']))
                {
                    show_message($_LANG['invalid_captcha']);
                }

                /* �����֤�� */
                include_once('includes/cls_captcha.php');

                $validator = new captcha();
                if (!$validator->check_word($_POST['captcha']))
                {
                    show_message($_LANG['invalid_captcha']);
                }
            }

            if (register(trim($_POST['username']), trim($_POST['password']), trim($_POST['email'])))
            {
                /* �û�ע��ɹ� */
                ecs_header("Location: flow.php?step=consignee\n");
                exit;
            }
            else
            {
                $err->show();
            }
        }
        else
        {
            // TODO: �Ƿ����ʵĴ���
        }
    }
}
elseif ($_REQUEST['step'] == 'consignee')
{
    /*------------------------------------------------------ */
    //-- �ջ�����Ϣ
    /*------------------------------------------------------ */
    include_once('includes/lib_transaction.php');

    if ($_SERVER['REQUEST_METHOD'] == 'GET')
    {
        /* ȡ�ù������� */
        $flow_type = isset($_SESSION['flow_type']) ? intval($_SESSION['flow_type']) : CART_GENERAL_GOODS;

        /*
         * �ջ�����Ϣ��д����
         */

        if (isset($_REQUEST['direct_shopping']))
        {
            $_SESSION['direct_shopping'] = 1;
        }

        /* ȡ�ù����б����̵����ڹ��ҡ��̵����ڹ��ҵ�ʡ�б� */
        $smarty->assign('country_list',       get_regions());
        $smarty->assign('shop_country',       $_CFG['shop_country']);
        $smarty->assign('shop_province_list', get_regions(1, $_CFG['shop_country']));

        /* ����û����е��ջ�����Ϣ */
        if ($_SESSION['user_id'] > 0)
        {
            $consignee_list = get_consignee_list($_SESSION['user_id']);

            if (count($consignee_list) < 5)
            {
                /* ����û��ջ�����Ϣ������С�� 5 ������һ���µ��ջ�����Ϣ */
                $consignee_list[] = array('country' => $_CFG['shop_country'], 'email' => isset($_SESSION['email']) ? $_SESSION['email'] : '');
            }
        }
        else
        {
            if (isset($_SESSION['flow_consignee'])){
                $consignee_list = array($_SESSION['flow_consignee']);
            }
            else
            {
                $consignee_list[] = array('country' => $_CFG['shop_country']);
            }
        }
        $smarty->assign('name_of_region',   array($_CFG['name_of_region_1'], $_CFG['name_of_region_2'], $_CFG['name_of_region_3'], $_CFG['name_of_region_4']));
        $smarty->assign('consignee_list', $consignee_list);

        /* ȡ��ÿ���ջ���ַ��ʡ�����б� */
        $province_list = array();
        $city_list = array();
        $district_list = array();
        foreach ($consignee_list as $region_id => $consignee)
        {
            $consignee['country']  = isset($consignee['country'])  ? intval($consignee['country'])  : 0;
            $consignee['province'] = isset($consignee['province']) ? intval($consignee['province']) : 0;
            $consignee['city']     = isset($consignee['city'])     ? intval($consignee['city'])     : 0;

            $province_list[$region_id] = get_regions(1, $consignee['country']);
            $city_list[$region_id]     = get_regions(2, $consignee['province']);
            $district_list[$region_id] = get_regions(3, $consignee['city']);
        }
        $smarty->assign('province_list', $province_list);
        $smarty->assign('city_list',     $city_list);
        $smarty->assign('district_list', $district_list);

        /* �����ջ���ҳ����� */
        $smarty->assign('real_goods_count', exist_real_goods(0, $flow_type) ? 1 : 0);
    }
    else
    {
        /*
         * �����ջ�����Ϣ
         */
        $consignee = array(
            'address_id'    => empty($_POST['address_id']) ? 0  :   intval($_POST['address_id']),
            'consignee'     => empty($_POST['consignee'])  ? '' :   compile_str(trim($_POST['consignee'])),
            'country'       => empty($_POST['country'])    ? '' :   intval($_POST['country']),
            'province'      => empty($_POST['province'])   ? '' :   intval($_POST['province']),
            'city'          => empty($_POST['city'])       ? '' :   intval($_POST['city']),
            'district'      => empty($_POST['district'])   ? '' :   intval($_POST['district']),
            'email'         => empty($_POST['email'])      ? '' :   compile_str($_POST['email']),
            'address'       => empty($_POST['address'])    ? '' :   compile_str($_POST['address']),
            'zipcode'       => empty($_POST['zipcode'])    ? '' :   compile_str(make_semiangle(trim($_POST['zipcode']))),
            'tel'           => empty($_POST['tel'])        ? '' :   compile_str(make_semiangle(trim($_POST['tel']))),
            'mobile'        => empty($_POST['mobile'])     ? '' :   compile_str(make_semiangle(trim($_POST['mobile']))),
            'sign_building' => empty($_POST['sign_building']) ? '' :compile_str($_POST['sign_building']),
            'best_time'     => empty($_POST['best_time'])  ? '' :   compile_str($_POST['best_time']),
        );

        if ($_SESSION['user_id'] > 0)
        {
            include_once(ROOT_PATH . 'includes/lib_transaction.php');

            /* ����û��Ѿ���¼���򱣴��ջ�����Ϣ */
            $consignee['user_id'] = $_SESSION['user_id'];

            save_consignee($consignee, true);
        }

        /* ���浽session */
        $_SESSION['flow_consignee'] = stripslashes_deep($consignee);

        ecs_header("Location: flow.php?step=checkout\n");
        exit;
    }
}
elseif ($_REQUEST['step'] == 'drop_consignee')
{
    /*------------------------------------------------------ */
    //-- ɾ���ջ�����Ϣ
    /*------------------------------------------------------ */
    include_once('includes/lib_transaction.php');

    $consignee_id = intval($_GET['id']);

    if (drop_consignee($consignee_id))
    {
        ecs_header("Location: flow.php?step=consignee\n");
        exit;
    }
    else
    {
        show_message($_LANG['not_fount_consignee']);
    }
}
elseif ($_REQUEST['step'] == 'checkout')
{
    /*------------------------------------------------------ */
    //-- ����ȷ��
    /*------------------------------------------------------ */

    /* ȡ�ù������� */
    $flow_type = isset($_SESSION['flow_type']) ? intval($_SESSION['flow_type']) : CART_GENERAL_GOODS;

    /* �Ź���־ */
    if ($flow_type == CART_GROUP_BUY_GOODS)
    {
        $smarty->assign('is_group_buy', 1);
    }
    /* ���ֶһ���Ʒ */
    elseif ($flow_type == CART_EXCHANGE_GOODS)
    {
        $smarty->assign('is_exchange_goods', 1);
    }
    else
    {
        //������������  ������������������
        $_SESSION['flow_order']['extension_code'] = '';
    }
	
	$rec_id=$_GET['rec_id'];
	if(!$rec_id){
		echo "<script>history.go(-1);</script>";
		exit;
	}

    /* ��鹺�ﳵ���Ƿ�����Ʒ */
    $sql = "SELECT COUNT(*) FROM " . $ecs->table('cart') .
        " WHERE session_id = '" . SESS_ID . "' " .
        "AND parent_id = 0 AND is_gift = 0 AND rec_type = '$flow_type'";

    if ($db->getOne($sql) == 0)
    {
        show_message($_LANG['no_goods_in_cart'], '', '', 'warning');
    }

    /*
     * ����û��Ƿ��Ѿ���¼
     * ����û��Ѿ���¼�������Ƿ���Ĭ�ϵ��ջ���ַ
     * ���û�е�¼����ת����¼��ע��ҳ��
     */
    if (empty($_SESSION['direct_shopping']) && $_SESSION['user_id'] == 0)
    {
        /* �û�û�е�¼��û��ѡ���������ת�򵽵�¼ҳ�� */
        ecs_header("Location: flow.php?step=login\n");
        exit;
    }

    /* ����Ʒ��Ϣ��ֵ */
    $cart_goods = cart_goods($flow_type,$rec_id); // ȡ����Ʒ�б�������ϼ�
    $smarty->assign('goods', $cart_goods);
	$info=$db->getRow("select insure_id,bb_name,insure_time,is_invoice from ".$ecs->table('insure')." where insure_id='".$cart_goods['insure_id']."'");
	$smarty->assign('info', $info);
	
	$brand_name = $GLOBALS['db']->getOne("select b.brand_name from ".$GLOBALS['ecs']->table('goods')." as g,".$GLOBALS['ecs']->table('brand')." as b where g.brand_id=b.brand_id and g.goods_id=".$cart_goods['goods_id']."");
	$smarty->assign('brand_name', $brand_name);
	
	$img=$db->getOne("select goods_img from ".$ecs->table('goods')." where goods_id='".$cart_goods['goods_id']."'");
	$smarty->assign('img', $img);
	$smarty->assign('rec_id', $rec_id);
	

    /* ���Ƿ������޸Ĺ��ﳵ��ֵ */
    if ($flow_type != CART_GENERAL_GOODS || $_CFG['one_step_buy'] == '1')
    {
        $smarty->assign('allow_edit_cart', 0);
    }
    else
    {
        $smarty->assign('allow_edit_cart', 1);
    }

    /*
     * ȡ�ù�����������
     */
    $smarty->assign('config', $_CFG);
    /*
     * ȡ�ö�����Ϣ
     */
    $order = flow_order_info();
    $smarty->assign('order', $order);

    /* �����ۿ� */
    if ($flow_type != CART_EXCHANGE_GOODS && $flow_type != CART_GROUP_BUY_GOODS)
    {
        $discount = compute_discount();
        $smarty->assign('discount', $discount['discount']);
        $favour_name = empty($discount['name']) ? '' : join(',', $discount['name']);
        $smarty->assign('your_discount', sprintf($_LANG['your_discount'], $favour_name, price_format($discount['discount'])));
    }

    /*
     * ���㶩���ķ���
     */
	
    $total = order_fee($order, $cart_goods, $consignee);

    $smarty->assign('total', $total);
    $smarty->assign('shopping_money', sprintf($_LANG['shopping_money'], $total['formated_goods_price']));
    $smarty->assign('market_price_desc', sprintf($_LANG['than_market_price'], $total['formated_market_price'], $total['formated_saving'], $total['save_rate']));

    /* ȡ�������б� */
    $region            = array($consignee['country'], $consignee['province'], $consignee['city'], $consignee['district']);
    $shipping_list     = available_shipping_list($region);
    $cart_weight_price = cart_weight_price($flow_type);
    $insure_disabled   = true;
    $cod_disabled      = true;

    // �鿴���ﳵ���Ƿ�ȫΪ���˷���Ʒ����������˷Ѹ�Ϊ��
    $sql = 'SELECT count(*) FROM ' . $ecs->table('cart') . " WHERE `session_id` = '" . SESS_ID. "' AND `extension_code` != 'package_buy' AND `is_shipping` = 0";
    $shipping_count = $db->getOne($sql);

    foreach ($shipping_list AS $key => $val)
    {
        $shipping_cfg = unserialize_config($val['configure']);
        $shipping_fee = ($shipping_count == 0 AND $cart_weight_price['free_shipping'] == 1) ? 0 : shipping_fee($val['shipping_code'], unserialize($val['configure']),
        $cart_weight_price['weight'], $cart_weight_price['amount'], $cart_weight_price['number']);

        $shipping_list[$key]['format_shipping_fee'] = price_format($shipping_fee, false);
        $shipping_list[$key]['shipping_fee']        = $shipping_fee;
        $shipping_list[$key]['free_money']          = price_format($shipping_cfg['free_money'], false);
        $shipping_list[$key]['insure_formated']     = strpos($val['insure'], '%') === false ?
            price_format($val['insure'], false) : $val['insure'];

        /* ��ǰ�����ͷ�ʽ�Ƿ�֧�ֱ��� */
        if ($val['shipping_id'] == $order['shipping_id'])
        {
            $insure_disabled = ($val['insure'] == 0);
            $cod_disabled    = ($val['support_cod'] == 0);
        }
    }

    $smarty->assign('shipping_list',   $shipping_list);
    $smarty->assign('insure_disabled', $insure_disabled);
    $smarty->assign('cod_disabled',    $cod_disabled);

    /* ȡ��֧���б� */
    if ($order['shipping_id'] == 0)
    {
        $cod        = true;
        $cod_fee    = 0;
    }
    else
    {
        $shipping = shipping_info($order['shipping_id']);
        $cod = $shipping['support_cod'];

        if ($cod)
        {
            /* ������Ź����ұ�֤�����0������ʹ�û������� */
            if ($flow_type == CART_GROUP_BUY_GOODS)
            {
                $group_buy_id = $_SESSION['extension_id'];
                if ($group_buy_id <= 0)
                {
                    show_message('error group_buy_id');
                }
                $group_buy = group_buy_info($group_buy_id);
                if (empty($group_buy))
                {
                    show_message('group buy not exists: ' . $group_buy_id);
                }

                if ($group_buy['deposit'] > 0)
                {
                    $cod = false;
                    $cod_fee = 0;

                    /* ��ֵ��֤�� */
                    $smarty->assign('gb_deposit', $group_buy['deposit']);
                }
            }

            if ($cod)
            {
                $shipping_area_info = shipping_area_info($order['shipping_id'], $region);
                $cod_fee            = $shipping_area_info['pay_fee'];
            }
        }
        else
        {
            $cod_fee = 0;
        }
    }

    // ����������������Ѽ�<span id>���Ա�ı����͵�ʱ��̬��ʾ
    $payment_list = available_payment_list(1, $cod_fee);
    if(isset($payment_list))
    {
        foreach ($payment_list as $key => $payment)
        {
            if ($payment['is_cod'] == '1')
            {
                $payment_list[$key]['format_pay_fee'] = '<span id="ECS_CODFEE">' . $payment['format_pay_fee'] . '</span>';
            }
            /* ������ױ�������֧�� �������������300 ����ʾ */
            if ($payment['pay_code'] == 'yeepayszx' && $total['amount'] > 300)
            {
                unset($payment_list[$key]);
            }
            /* ��������֧�� */
            if ($payment['pay_code'] == 'balance')
            {
                /* ���δ��¼������ʾ */
                if ($_SESSION['user_id'] == 0)
                {
                    unset($payment_list[$key]);
                }
                else
                {
                    if ($_SESSION['flow_order']['pay_id'] == $payment['pay_id'])
                    {
                        $smarty->assign('disable_surplus', 1);
                    }
                }
            }
        }
    }
    $smarty->assign('payment_list', $payment_list);

    /* ȡ�ð�װ��ؿ� */
    if ($total['real_goods_count'] > 0)
    {
        /* ֻ����ʵ����Ʒ,��Ҫ�жϰ�װ�ͺؿ� */
        if (!isset($_CFG['use_package']) || $_CFG['use_package'] == '1')
        {
            /* ���ʹ�ð�װ��ȡ�ð�װ�б����û�ѡ��İ�װ */
            $smarty->assign('pack_list', pack_list());
        }

        /* ���ʹ�úؿ���ȡ�úؿ��б����û�ѡ��ĺؿ� */
        if (!isset($_CFG['use_card']) || $_CFG['use_card'] == '1')
        {
            $smarty->assign('card_list', card_list());
        }
    }

    $user_info = user_info($_SESSION['user_id']);

    /* ���ʹ����ȡ���û���� */
    if ((!isset($_CFG['use_surplus']) || $_CFG['use_surplus'] == '1')
        && $_SESSION['user_id'] > 0
        && $user_info['user_money'] > 0)
    {
        // ��ʹ�����
        $smarty->assign('allow_use_surplus', 1);
        $smarty->assign('your_surplus', $user_info['user_money']);
    }

    /* ���ʹ�û��֣�ȡ���û����û��ּ�������������ʹ�õĻ��� */
    if ((!isset($_CFG['use_integral']) || $_CFG['use_integral'] == '1')
        && $_SESSION['user_id'] > 0
        && $user_info['pay_points'] > 0
        && ($flow_type != CART_GROUP_BUY_GOODS && $flow_type != CART_EXCHANGE_GOODS))
    {
        // ��ʹ�û���
        $smarty->assign('allow_use_integral', 1);
        $smarty->assign('order_max_integral', flow_available_points());  // ���û���
        $smarty->assign('your_integral',      $user_info['pay_points']); // �û�����
    }

    /* ���ʹ�ú����ȡ���û�����ʹ�õĺ�����û�ѡ��ĺ�� */
    if ((!isset($_CFG['use_bonus']) || $_CFG['use_bonus'] == '1')
        && ($flow_type != CART_GROUP_BUY_GOODS && $flow_type != CART_EXCHANGE_GOODS))
    {
        // ȡ���û����ú��
        $user_bonus = user_bonus($_SESSION['user_id'], $total['goods_price']);
        if (!empty($user_bonus))
        {
            foreach ($user_bonus AS $key => $val)
            {
                $user_bonus[$key]['bonus_money_formated'] = price_format($val['type_money'], false);
            }
            $smarty->assign('bonus_list', $user_bonus);
        }

        // ��ʹ�ú��
        $smarty->assign('allow_use_bonus', 1);
    }

    /* ���ʹ��ȱ��������ȡ��ȱ�������б� */
    if (!isset($_CFG['use_how_oos']) || $_CFG['use_how_oos'] == '1')
    {
        if (is_array($GLOBALS['_LANG']['oos']) && !empty($GLOBALS['_LANG']['oos']))
        {
            $smarty->assign('how_oos_list', $GLOBALS['_LANG']['oos']);
        }
    }

    /* ����ܿ���Ʊ��ȡ�÷�Ʊ�����б� */
    if ((!isset($_CFG['can_invoice']) || $_CFG['can_invoice'] == '1')
        && isset($_CFG['invoice_content'])
        && trim($_CFG['invoice_content']) != '' && $flow_type != CART_EXCHANGE_GOODS)
    {
        $inv_content_list = explode("\n", str_replace("\r", '', $_CFG['invoice_content']));
        $smarty->assign('inv_content_list', $inv_content_list);

        $inv_type_list = array();
        foreach ($_CFG['invoice_type']['type'] as $key => $type)
        {
            if (!empty($type))
            {
                $inv_type_list[$type] = $type . ' [' . floatval($_CFG['invoice_type']['rate'][$key]) . '%]';
            }
        }
        $smarty->assign('inv_type_list', $inv_type_list);
    }

    /* ���� session */
    $_SESSION['flow_order'] = $order;
}
elseif ($_REQUEST['step'] == 'select_shipping')
{
    /*------------------------------------------------------ */
    //-- �ı����ͷ�ʽ
    /*------------------------------------------------------ */
    include_once('includes/cls_json.php');
    $json = new JSON;
    $result = array('error' => '', 'content' => '', 'need_insure' => 0);

    /* ȡ�ù������� */
    $flow_type = isset($_SESSION['flow_type']) ? intval($_SESSION['flow_type']) : CART_GENERAL_GOODS;

    /* ����ջ�����Ϣ */
    $consignee = get_consignee($_SESSION['user_id']);

    /* ����Ʒ��Ϣ��ֵ */
    $cart_goods = cart_goods($flow_type); // ȡ����Ʒ�б�������ϼ�

    if (empty($cart_goods) || !check_consignee_info($consignee, $flow_type))
    {
        $result['error'] = $_LANG['no_goods_in_cart'];
    }
    else
    {
        /* ȡ�ù����������� */
        $smarty->assign('config', $_CFG);

        /* ȡ�ö�����Ϣ */
        $order = flow_order_info();

        $order['shipping_id'] = intval($_REQUEST['shipping']);
        $regions = array($consignee['country'], $consignee['province'], $consignee['city'], $consignee['district']);
        $shipping_info = shipping_area_info($order['shipping_id'], $regions);

        /* ���㶩���ķ��� */
        $total = order_fee($order, $cart_goods, $consignee);
        $smarty->assign('total', $total);

        /* ȡ�ÿ��Եõ��Ļ��ֺͺ�� */
        $smarty->assign('total_integral', cart_amount(false, $flow_type) - $total['bonus'] - $total['integral_money']);
        $smarty->assign('total_bonus',    price_format(get_total_bonus(), false));

        /* �Ź���־ */
        if ($flow_type == CART_GROUP_BUY_GOODS)
        {
            $smarty->assign('is_group_buy', 1);
        }

        $result['cod_fee']     = $shipping_info['pay_fee'];
        if (strpos($result['cod_fee'], '%') === false)
        {
            $result['cod_fee'] = price_format($result['cod_fee'], false);
        }
        $result['need_insure'] = ($shipping_info['insure'] > 0 && !empty($order['need_insure'])) ? 1 : 0;
        $result['content']     = $smarty->fetch('library/order_total.lbi');
    }

    echo $json->encode($result);
    exit;
}
elseif ($_REQUEST['step'] == 'select_insure')
{
    /*------------------------------------------------------ */
    //-- ѡ��/ȡ�����͵ı���
    /*------------------------------------------------------ */

    include_once('includes/cls_json.php');
    $json = new JSON;
    $result = array('error' => '', 'content' => '', 'need_insure' => 0);

    /* ȡ�ù������� */
    $flow_type = isset($_SESSION['flow_type']) ? intval($_SESSION['flow_type']) : CART_GENERAL_GOODS;

    /* ����ջ�����Ϣ */
    $consignee = get_consignee($_SESSION['user_id']);

    /* ����Ʒ��Ϣ��ֵ */
    $cart_goods = cart_goods($flow_type); // ȡ����Ʒ�б�������ϼ�

    if (empty($cart_goods) || !check_consignee_info($consignee, $flow_type))
    {
        $result['error'] = $_LANG['no_goods_in_cart'];
    }
    else
    {
        /* ȡ�ù����������� */
        $smarty->assign('config', $_CFG);

        /* ȡ�ö�����Ϣ */
        $order = flow_order_info();

        $order['need_insure'] = intval($_REQUEST['insure']);

        /* ���� session */
        $_SESSION['flow_order'] = $order;

        /* ���㶩���ķ��� */
        $total = order_fee($order, $cart_goods, $consignee);
        $smarty->assign('total', $total);

        /* ȡ�ÿ��Եõ��Ļ��ֺͺ�� */
        $smarty->assign('total_integral', cart_amount(false, $flow_type) - $total['bonus'] - $total['integral_money']);
        $smarty->assign('total_bonus',    price_format(get_total_bonus(), false));

        /* �Ź���־ */
        if ($flow_type == CART_GROUP_BUY_GOODS)
        {
            $smarty->assign('is_group_buy', 1);
        }

        $result['content'] = $smarty->fetch('library/order_total.lbi');
    }

    echo $json->encode($result);
    exit;
}
elseif ($_REQUEST['step'] == 'select_payment')
{
    /*------------------------------------------------------ */
    //-- �ı�֧����ʽ
    /*------------------------------------------------------ */

    include_once('includes/cls_json.php');
    $json = new JSON;
    $result = array('error' => '', 'content' => '', 'need_insure' => 0, 'payment' => 1);

    /* ȡ�ù������� */
    $flow_type = isset($_SESSION['flow_type']) ? intval($_SESSION['flow_type']) : CART_GENERAL_GOODS;

    /* ����ջ�����Ϣ */
    //$consignee = get_consignee($_SESSION['user_id']);

    /* ����Ʒ��Ϣ��ֵ */
    $cart_goods = cart_goods($flow_type,$_GET['rec_id']); // ȡ����Ʒ�б�������ϼ�
	
    if (empty($cart_goods))
    {
        $result['error'] = $_LANG['no_goods_in_cart'];
    }
    else
    {
        /* ȡ�ù����������� */
        $smarty->assign('config', $_CFG);

        /* ȡ�ö�����Ϣ */
        $order = flow_order_info();

        $order['pay_id'] = intval($_REQUEST['payment']);
        $payment_info = payment_info($order['pay_id']);
        $result['pay_code'] = $payment_info['pay_code'];

        /* ���� session */
        $_SESSION['flow_order'] = $order;

        /* ���㶩���ķ��� */
        $total = order_fee($order, $cart_goods, $consignee);
        $smarty->assign('total', $total);

        /* ȡ�ÿ��Եõ��Ļ��ֺͺ�� */
        $smarty->assign('total_integral', cart_amount(false, $flow_type) - $total['bonus'] - $total['integral_money']);
        $smarty->assign('total_bonus',    price_format(get_total_bonus(), false));

        /* �Ź���־ */
        if ($flow_type == CART_GROUP_BUY_GOODS)
        {
            $smarty->assign('is_group_buy', 1);
        }

        $result['content'] = $smarty->fetch('library/order_total.lbi');
    }

    echo $json->encode($result);
    exit;
}
elseif ($_REQUEST['step'] == 'select_pack')
{
    /*------------------------------------------------------ */
    //-- �ı���Ʒ��װ
    /*------------------------------------------------------ */

    include_once('includes/cls_json.php');
    $json = new JSON;
    $result = array('error' => '', 'content' => '', 'need_insure' => 0);

    /* ȡ�ù������� */
    $flow_type = isset($_SESSION['flow_type']) ? intval($_SESSION['flow_type']) : CART_GENERAL_GOODS;

    /* ����ջ�����Ϣ */
    $consignee = get_consignee($_SESSION['user_id']);

    /* ����Ʒ��Ϣ��ֵ */
    $cart_goods = cart_goods($flow_type); // ȡ����Ʒ�б�������ϼ�

    if (empty($cart_goods) || !check_consignee_info($consignee, $flow_type))
    {
        $result['error'] = $_LANG['no_goods_in_cart'];
    }
    else
    {
        /* ȡ�ù����������� */
        $smarty->assign('config', $_CFG);

        /* ȡ�ö�����Ϣ */
        $order = flow_order_info();

        $order['pack_id'] = intval($_REQUEST['pack']);

        /* ���� session */
        $_SESSION['flow_order'] = $order;

        /* ���㶩���ķ��� */
        $total = order_fee($order, $cart_goods, $consignee);
        $smarty->assign('total', $total);

        /* ȡ�ÿ��Եõ��Ļ��ֺͺ�� */
        $smarty->assign('total_integral', cart_amount(false, $flow_type) - $total['bonus'] - $total['integral_money']);
        $smarty->assign('total_bonus',    price_format(get_total_bonus(), false));

        /* �Ź���־ */
        if ($flow_type == CART_GROUP_BUY_GOODS)
        {
            $smarty->assign('is_group_buy', 1);
        }

        $result['content'] = $smarty->fetch('library/order_total.lbi');
    }

    echo $json->encode($result);
    exit;
}
elseif ($_REQUEST['step'] == 'select_card')
{
    /*------------------------------------------------------ */
    //-- �ı�ؿ�
    /*------------------------------------------------------ */

    include_once('includes/cls_json.php');
    $json = new JSON;
    $result = array('error' => '', 'content' => '', 'need_insure' => 0);

    /* ȡ�ù������� */
    $flow_type = isset($_SESSION['flow_type']) ? intval($_SESSION['flow_type']) : CART_GENERAL_GOODS;

    /* ����ջ�����Ϣ */
    $consignee = get_consignee($_SESSION['user_id']);

    /* ����Ʒ��Ϣ��ֵ */
    $cart_goods = cart_goods($flow_type); // ȡ����Ʒ�б�������ϼ�

    if (empty($cart_goods) || !check_consignee_info($consignee, $flow_type))
    {
        $result['error'] = $_LANG['no_goods_in_cart'];
    }
    else
    {
        /* ȡ�ù����������� */
        $smarty->assign('config', $_CFG);

        /* ȡ�ö�����Ϣ */
        $order = flow_order_info();

        $order['card_id'] = intval($_REQUEST['card']);

        /* ���� session */
        $_SESSION['flow_order'] = $order;

        /* ���㶩���ķ��� */
        $total = order_fee($order, $cart_goods, $consignee);
        $smarty->assign('total', $total);

        /* ȡ�ÿ��Եõ��Ļ��ֺͺ�� */
        $smarty->assign('total_integral', cart_amount(false, $flow_type) - $order['bonus'] - $total['integral_money']);
        $smarty->assign('total_bonus',    price_format(get_total_bonus(), false));

        /* �Ź���־ */
        if ($flow_type == CART_GROUP_BUY_GOODS)
        {
            $smarty->assign('is_group_buy', 1);
        }

        $result['content'] = $smarty->fetch('library/order_total.lbi');
    }

    echo $json->encode($result);
    exit;
}
elseif ($_REQUEST['step'] == 'change_surplus')
{
    /*------------------------------------------------------ */
    //-- �ı����
    /*------------------------------------------------------ */
    include_once('includes/cls_json.php');

    $surplus   = floatval($_GET['surplus']);
    $user_info = user_info($_SESSION['user_id']);

    if ($user_info['user_money'] + $user_info['credit_line'] < $surplus)
    {
        $result['error'] = $_LANG['surplus_not_enough'];
    }
    else
    {
        /* ȡ�ù������� */
        $flow_type = isset($_SESSION['flow_type']) ? intval($_SESSION['flow_type']) : CART_GENERAL_GOODS;

        /* ȡ�ù����������� */
        $smarty->assign('config', $_CFG);

        /* ����ջ�����Ϣ */
        $consignee = get_consignee($_SESSION['user_id']);

        /* ����Ʒ��Ϣ��ֵ */
        $cart_goods = cart_goods($flow_type); // ȡ����Ʒ�б�������ϼ�

        if (empty($cart_goods) || !check_consignee_info($consignee, $flow_type))
        {
            $result['error'] = $_LANG['no_goods_in_cart'];
        }
        else
        {
            /* ȡ�ö�����Ϣ */
            $order = flow_order_info();
            $order['surplus'] = $surplus;

            /* ���㶩���ķ��� */
            $total = order_fee($order, $cart_goods, $consignee);
            $smarty->assign('total', $total);

            /* �Ź���־ */
            if ($flow_type == CART_GROUP_BUY_GOODS)
            {
                $smarty->assign('is_group_buy', 1);
            }

            $result['content'] = $smarty->fetch('library/order_total.lbi');
        }
    }

    $json = new JSON();
    die($json->encode($result));
}
elseif ($_REQUEST['step'] == 'change_integral')
{
    /*------------------------------------------------------ */
    //-- �ı����
    /*------------------------------------------------------ */
    include_once('includes/cls_json.php');

    $points    = floatval($_GET['points']);
    $user_info = user_info($_SESSION['user_id']);

    /* ȡ�ö�����Ϣ */
    $order = flow_order_info();

    $flow_points = flow_available_points();  // �ö�������ʹ�õĻ���
    $user_points = $user_info['pay_points']; // �û��Ļ�������

    if ($points > $user_points)
    {
        $result['error'] = $_LANG['integral_not_enough'];
    }
    elseif ($points > $flow_points)
    {
        $result['error'] = sprintf($_LANG['integral_too_much'], $flow_points);
    }
    else
    {
        /* ȡ�ù������� */
        $flow_type = isset($_SESSION['flow_type']) ? intval($_SESSION['flow_type']) : CART_GENERAL_GOODS;

        $order['integral'] = $points;

        /* ����ջ�����Ϣ */
        $consignee = get_consignee($_SESSION['user_id']);

        /* ����Ʒ��Ϣ��ֵ */
        $cart_goods = cart_goods($flow_type); // ȡ����Ʒ�б�������ϼ�

        if (empty($cart_goods) || !check_consignee_info($consignee, $flow_type))
        {
            $result['error'] = $_LANG['no_goods_in_cart'];
        }
        else
        {
            /* ���㶩���ķ��� */
            $total = order_fee($order, $cart_goods, $consignee);
            $smarty->assign('total',  $total);
            $smarty->assign('config', $_CFG);

            /* �Ź���־ */
            if ($flow_type == CART_GROUP_BUY_GOODS)
            {
                $smarty->assign('is_group_buy', 1);
            }

            $result['content'] = $smarty->fetch('library/order_total.lbi');
            $result['error'] = '';
        }
    }

    $json = new JSON();
    die($json->encode($result));
}
elseif ($_REQUEST['step'] == 'change_bonus')
{
    /*------------------------------------------------------ */
    //-- �ı���
    /*------------------------------------------------------ */
    include_once('includes/cls_json.php');
    $result = array('error' => '', 'content' => '');

    /* ȡ�ù������� */
    $flow_type = isset($_SESSION['flow_type']) ? intval($_SESSION['flow_type']) : CART_GENERAL_GOODS;

    /* ����ջ�����Ϣ */
    $consignee = get_consignee($_SESSION['user_id']);

    /* ����Ʒ��Ϣ��ֵ */
    $cart_goods = cart_goods($flow_type); // ȡ����Ʒ�б�������ϼ�

    if (empty($cart_goods) || !check_consignee_info($consignee, $flow_type))
    {
        $result['error'] = $_LANG['no_goods_in_cart'];
    }
    else
    {
        /* ȡ�ù����������� */
        $smarty->assign('config', $_CFG);

        /* ȡ�ö�����Ϣ */
        $order = flow_order_info();

        $bonus = bonus_info(intval($_GET['bonus']));

        if ((!empty($bonus) && $bonus['user_id'] == $_SESSION['user_id']) || $_GET['bonus'] == 0)
        {
            $order['bonus_id'] = intval($_GET['bonus']);
        }
        else
        {
            $order['bonus_id'] = 0;
            $result['error'] = $_LANG['invalid_bonus'];
        }

        /* ���㶩���ķ��� */
        $total = order_fee($order, $cart_goods, $consignee);
        $smarty->assign('total', $total);

        /* �Ź���־ */
        if ($flow_type == CART_GROUP_BUY_GOODS)
        {
            $smarty->assign('is_group_buy', 1);
        }

        $result['content'] = $smarty->fetch('library/order_total.lbi');
    }

    $json = new JSON();
    die($json->encode($result));
}
elseif ($_REQUEST['step'] == 'change_needinv')
{
    /*------------------------------------------------------ */
    //-- �ı䷢Ʊ������
    /*------------------------------------------------------ */
    include_once('includes/cls_json.php');
    $result = array('error' => '', 'content' => '');
    $json = new JSON();
    $_GET['inv_type'] = !empty($_GET['inv_type']) ? json_str_iconv(urldecode($_GET['inv_type'])) : '';
    $_GET['invPayee'] = !empty($_GET['invPayee']) ? json_str_iconv(urldecode($_GET['invPayee'])) : '';
    $_GET['inv_content'] = !empty($_GET['inv_content']) ? json_str_iconv(urldecode($_GET['inv_content'])) : '';

    /* ȡ�ù������� */
    $flow_type = isset($_SESSION['flow_type']) ? intval($_SESSION['flow_type']) : CART_GENERAL_GOODS;

    /* ����ջ�����Ϣ */
    $consignee = get_consignee($_SESSION['user_id']);

    /* ����Ʒ��Ϣ��ֵ */
    $cart_goods = cart_goods($flow_type); // ȡ����Ʒ�б�������ϼ�

    if (empty($cart_goods) || !check_consignee_info($consignee, $flow_type))
    {
        $result['error'] = $_LANG['no_goods_in_cart'];
        die($json->encode($result));
    }
    else
    {
        /* ȡ�ù����������� */
        $smarty->assign('config', $_CFG);

        /* ȡ�ö�����Ϣ */
        $order = flow_order_info();

        if (isset($_GET['need_inv']) && intval($_GET['need_inv']) == 1)
        {
            $order['need_inv']    = 1;
            $order['inv_type']    = trim(stripslashes($_GET['inv_type']));
            $order['inv_payee']   = trim(stripslashes($_GET['inv_payee']));
            $order['inv_content'] = trim(stripslashes($_GET['inv_content']));
        }
        else
        {
            $order['need_inv']    = 0;
            $order['inv_type']    = '';
            $order['inv_payee']   = '';
            $order['inv_content'] = '';
        }

        /* ���㶩���ķ��� */
        $total = order_fee($order, $cart_goods, $consignee);
        $smarty->assign('total', $total);

        /* �Ź���־ */
        if ($flow_type == CART_GROUP_BUY_GOODS)
        {
            $smarty->assign('is_group_buy', 1);
        }

        die($smarty->fetch('library/order_total.lbi'));
    }
}
elseif ($_REQUEST['step'] == 'change_oos')
{
    /*------------------------------------------------------ */
    //-- �ı�ȱ������ʱ�ķ�ʽ
    /*------------------------------------------------------ */

    /* ȡ�ö�����Ϣ */
    $order = flow_order_info();

    $order['how_oos'] = intval($_GET['oos']);

    /* ���� session */
    $_SESSION['flow_order'] = $order;
}
elseif ($_REQUEST['step'] == 'check_surplus')
{
    /*------------------------------------------------------ */
    //-- ����û���������
    /*------------------------------------------------------ */
    $surplus   = floatval($_GET['surplus']);
    $user_info = user_info($_SESSION['user_id']);

    if (($user_info['user_money'] + $user_info['credit_line'] < $surplus))
    {
        die($_LANG['surplus_not_enough']);
    }

    exit;
}
elseif ($_REQUEST['step'] == 'check_integral')
{
    /*------------------------------------------------------ */
    //-- ����û���������
    /*------------------------------------------------------ */
    $points      = floatval($_GET['integral']);
    $user_info   = user_info($_SESSION['user_id']);
    $flow_points = flow_available_points();  // �ö�������ʹ�õĻ���
    $user_points = $user_info['pay_points']; // �û��Ļ�������

    if ($points > $user_points)
    {
        die($_LANG['integral_not_enough']);
    }

    if ($points > $flow_points)
    {
        die(sprintf($_LANG['integral_too_much'], $flow_points));
    }

    exit;
}
/*------------------------------------------------------ */
//-- ������ж����������ύ�����ݿ�
/*------------------------------------------------------ */
elseif ($_REQUEST['step'] == 'done')
{
    include_once('includes/lib_clips.php');
    include_once('includes/lib_payment.php');

    /* ȡ�ù������� */
    $flow_type = isset($_SESSION['flow_type']) ? intval($_SESSION['flow_type']) : CART_GENERAL_GOODS;
    
	if(!$_POST['is_check']){
		echo "<script>alert('�빴ѡ���˽Ᵽ�����');history.go(-1);</script>";exit;
	}
	$rec_id=$_POST['rec_id'];
    /* ��鹺�ﳵ���Ƿ�����Ʒ */
    $sql = "SELECT COUNT(*) FROM " . $ecs->table('cart') .
        " WHERE session_id = '" . SESS_ID . "' " .
        "AND parent_id = 0 AND is_gift = 0 AND rec_type = '$flow_type' and rec_id=$rec_id";
    if ($db->getOne($sql) == 0)
    {
        show_message($_LANG['no_goods_in_cart'], '', '', 'warning');
    }

    /* �����Ʒ��� */
    /* ���ʹ�ÿ�棬���¶���ʱ����棬����ٿ�� */
    if ($_CFG['use_storage'] == '1' && $_CFG['stock_dec_time'] == SDT_PLACE)
    {
        $cart_goods_stock = get_cart_goods();
        $_cart_goods_stock = array();
        foreach ($cart_goods_stock['goods_list'] as $value)
        {
            $_cart_goods_stock[$value['rec_id']] = $value['goods_number'];
        }
        flow_cart_stock($_cart_goods_stock);
        unset($cart_goods_stock, $_cart_goods_stock);
    }

    /*
     * ����û��Ƿ��Ѿ���¼
     * ����û��Ѿ���¼�������Ƿ���Ĭ�ϵ��ջ���ַ
     * ���û�е�¼����ת����¼��ע��ҳ��
     */
    if ($_SESSION['user_id'] == 0)
    {
        /* �û�û�е�¼��û��ѡ���������ת�򵽵�¼ҳ�� */
        ecs_header("Location: user.php\n");
        exit;
    }

    $_POST['how_oos'] = isset($_POST['how_oos']) ? intval($_POST['how_oos']) : 0;
    $_POST['card_message'] = isset($_POST['card_message']) ? compile_str($_POST['card_message']) : '';
    $_POST['inv_type'] = !empty($_POST['inv_type']) ? compile_str($_POST['inv_type']) : '';
    $_POST['inv_payee'] = isset($_POST['inv_payee']) ? compile_str($_POST['inv_payee']) : '';
    $_POST['inv_content'] = isset($_POST['inv_content']) ? compile_str($_POST['inv_content']) : '';
    $_POST['postscript'] = isset($_POST['postscript']) ? compile_str($_POST['postscript']) : '';

    $order = array(
        'shipping_id'     => intval($_POST['shipping']),
        'pay_id'          => intval($_POST['payment']),
        'pack_id'         => isset($_POST['pack']) ? intval($_POST['pack']) : 0,
        'card_id'         => isset($_POST['card']) ? intval($_POST['card']) : 0,
        'card_message'    => trim($_POST['card_message']),
        'surplus'         => isset($_POST['surplus']) ? floatval($_POST['surplus']) : 0.00,
        'integral'        => isset($_POST['integral']) ? intval($_POST['integral']) : 0,
        'bonus_id'        => isset($_POST['bonus']) ? intval($_POST['bonus']) : 0,
        'need_inv'        => empty($_POST['need_inv']) ? 0 : 1,
        'inv_type'        => $_POST['inv_type'],
        'inv_payee'       => trim($_POST['inv_payee']),
        'inv_content'     => $_POST['inv_content'],
        'postscript'      => trim($_POST['postscript']),
        'how_oos'         => isset($_LANG['oos'][$_POST['how_oos']]) ? addslashes($_LANG['oos'][$_POST['how_oos']]) : '',
        'need_insure'     => isset($_POST['need_insure']) ? intval($_POST['need_insure']) : 0,
        'user_id'         => $_SESSION['user_id'],
        'add_time'        => gmtime(),
        'order_status'    => OS_UNCONFIRMED,
        'shipping_status' => SS_UNSHIPPED,
        'pay_status'      => PS_UNPAYED,
        'agency_id'       => get_agency_by_regions(array($consignee['country'], $consignee['province'], $consignee['city'], $consignee['district']))
        );

    /* ��չ��Ϣ */
    if (isset($_SESSION['flow_type']) && intval($_SESSION['flow_type']) != CART_GENERAL_GOODS)
    {
        $order['extension_code'] = $_SESSION['extension_code'];
        $order['extension_id'] = $_SESSION['extension_id'];
    }
    else
    {
        $order['extension_code'] = '';
        $order['extension_id'] = 0;
    }

    /* ����������Ƿ�Ϸ� */
    $user_id = $_SESSION['user_id'];
    if ($user_id > 0)
    {
        $user_info = user_info($user_id);

        $order['surplus'] = min($order['surplus'], $user_info['user_money'] + $user_info['credit_line']);
        if ($order['surplus'] < 0)
        {
            $order['surplus'] = 0;
        }

        // ��ѯ�û��ж��ٻ���
        $flow_points = flow_available_points();  // �ö�������ʹ�õĻ���
        $user_points = $user_info['pay_points']; // �û��Ļ�������

        $order['integral'] = min($order['integral'], $user_points, $flow_points);
        if ($order['integral'] < 0)
        {
            $order['integral'] = 0;
        }
    }
    else
    {
        $order['surplus']  = 0;
        $order['integral'] = 0;
    }

    /* ������Ƿ���� */
    if ($order['bonus_id'] > 0)
    {
        $bonus = bonus_info($order['bonus_id']);

        if (empty($bonus) || $bonus['user_id'] != $user_id || $bonus['order_id'] > 0 || $bonus['min_goods_amount'] > cart_amount(true, $flow_type))
        {
            $order['bonus_id'] = 0;
        }
    }
    elseif (isset($_POST['bonus_sn']))
    {
        $bonus_sn = trim($_POST['bonus_sn']);
        $bonus = bonus_info(0, $bonus_sn);
        $now = gmtime();
        if (empty($bonus) || $bonus['user_id'] > 0 || $bonus['order_id'] > 0 || $bonus['min_goods_amount'] > cart_amount(true, $flow_type) || $now > $bonus['use_end_date'])
        {
        }
        else
        {
            if ($user_id > 0)
            {
                $sql = "UPDATE " . $ecs->table('user_bonus') . " SET user_id = '$user_id' WHERE bonus_id = '$bonus[bonus_id]' LIMIT 1";
                $db->query($sql);
            }
            $order['bonus_id'] = $bonus['bonus_id'];
            $order['bonus_sn'] = $bonus_sn;
        }
    }

    /* �����е���Ʒ */
    $cart_goods = cart_goods($flow_type,$rec_id);

    if (empty($cart_goods))
    {
        show_message($_LANG['no_goods_in_cart'], $_LANG['back_home'], './', 'warning');
    }

    /* �����Ʒ�ܶ��Ƿ�ﵽ����޹���� */
    if ($flow_type == CART_GENERAL_GOODS && cart_amount(true, CART_GENERAL_GOODS) < $_CFG['min_goods_amount'])
    {
        show_message(sprintf($_LANG['goods_amount_not_enough'], price_format($_CFG['min_goods_amount'], false)));
    }

    /* �ջ�����Ϣ */
    /*foreach ($consignee as $key => $value)
    {
        $order[$key] = addslashes($value);
    }*/

   /* �ж��ǲ���ʵ����Ʒ */
    /*foreach ($cart_goods AS $val)
    {
        // ͳ��ʵ����Ʒ�ĸ��� 
        if ($cart_goods['is_real'])
        {
            $is_real_good=0;
        }
    }
    if(isset($is_real_good))
    {
        $sql="SELECT shipping_id FROM " . $ecs->table('shipping') . " WHERE shipping_id=".$order['shipping_id'] ." AND enabled =1"; 
        if(!$db->getOne($sql))
        {
           show_message($_LANG['flow_no_shipping']);
        }
    }*/
    /* �����е��ܶ� */
    $total = order_fee($order, $cart_goods, $consignee);
    $order['bonus']        = $total['bonus'];
    $order['goods_amount'] = $total['goods_price'];
    $order['discount']     = $total['discount'];
    $order['surplus']      = $total['surplus'];
    $order['tax']          = $total['tax'];

    // ���ﳵ�е���Ʒ�����ܺ��֧�����ܶ�
    $discount_amout = compute_discount_amount();
    // ����ͻ��������֧���Ľ��Ϊ��Ʒ�ܶ�
    $temp_amout = $order['goods_amount'] - $discount_amout;
    if ($temp_amout <= 0)
    {
        $order['bonus_id'] = 0;
    }

    /* ���ͷ�ʽ */
    if ($order['shipping_id'] > 0)
    {
        $shipping = shipping_info($order['shipping_id']);
        $order['shipping_name'] = addslashes($shipping['shipping_name']);
    }
    $order['shipping_fee'] = $total['shipping_fee'];
    $order['insure_fee']   = $total['shipping_insure'];

    /* ֧����ʽ */
    if ($order['pay_id'] > 0)
    {
        $payment = payment_info($order['pay_id']);
        $order['pay_name'] = addslashes($payment['pay_name']);
    }
    $order['pay_fee'] = $total['pay_fee'];
    $order['cod_fee'] = $total['cod_fee'];

    /* ��Ʒ��װ */
    if ($order['pack_id'] > 0)
    {
        $pack               = pack_info($order['pack_id']);
        $order['pack_name'] = addslashes($pack['pack_name']);
    }
    $order['pack_fee'] = $total['pack_fee'];

    /* ף���ؿ� */
    if ($order['card_id'] > 0)
    {
        $card               = card_info($order['card_id']);
        $order['card_name'] = addslashes($card['card_name']);
    }
    $order['card_fee']      = $total['card_fee'];

    $order['order_amount']  = number_format($total['amount'], 2, '.', '');

    /* ���ȫ��ʹ�����֧�����������Ƿ��㹻 */
    if ($payment['pay_code'] == 'balance' && $order['order_amount'] > 0)
    {
        if($order['surplus'] >0) //���֧�������������һ�����
        {
            $order['order_amount'] = $order['order_amount'] + $order['surplus'];
            $order['surplus'] = 0;
        }
        if ($order['order_amount'] > ($user_info['user_money'] + $user_info['credit_line']))
        {
            show_message($_LANG['balance_not_enough']);
        }
        else
        {
            $order['surplus'] = $order['order_amount'];
            $order['order_amount'] = 0;
        }
    }

    /* ����������Ϊ0��ʹ��������ֻ���֧�������޸Ķ���״̬Ϊ��ȷ�ϡ��Ѹ��� */
    if ($order['order_amount'] <= 0)
    {
        $order['order_status'] = OS_CONFIRMED;
        $order['confirm_time'] = gmtime();
        $order['pay_status']   = PS_PAYED;
        $order['pay_time']     = gmtime();
        $order['order_amount'] = 0;
    }

    $order['integral_money']   = $total['integral_money'];
    $order['integral']         = $total['integral'];

    if ($order['extension_code'] == 'exchange_goods')
    {
        $order['integral_money']   = 0;
        $order['integral']         = $total['exchange_integral'];
    }

    $order['from_ad']          = !empty($_SESSION['from_ad']) ? $_SESSION['from_ad'] : '0';
    $order['referer']          = !empty($_SESSION['referer']) ? addslashes($_SESSION['referer']) : '';

    /* ��¼��չ��Ϣ */
    if ($flow_type != CART_GENERAL_GOODS)
    {
        $order['extension_code'] = $_SESSION['extension_code'];
        $order['extension_id'] = $_SESSION['extension_id'];
    }

    $affiliate = unserialize($_CFG['affiliate']);
    if(isset($affiliate['on']) && $affiliate['on'] == 1 && $affiliate['config']['separate_by'] == 1)
    {
        //�Ƽ������ֳ�
        $parent_id = get_affiliate();
        if($user_id == $parent_id)
        {
            $parent_id = 0;
        }
    }
    elseif(isset($affiliate['on']) && $affiliate['on'] == 1 && $affiliate['config']['separate_by'] == 0)
    {
        //�Ƽ�ע��ֳ�
        $parent_id = 0;
    }
    else
    {
        //�ֳɹ��ܹر�
        $parent_id = 0;
    }
    $order['parent_id'] = $parent_id;
	$order['insure_id'] = $cart_goods['insure_id'];
	$order['bx_type'] = $_POST['bx_type'];

    /* ���붩���� */
    $error_no = 0;
    do
    {
        $order['order_sn'] = get_order_sn(); //��ȡ�¶�����
        $GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('order_info'), $order, 'INSERT');

        $error_no = $GLOBALS['db']->errno();

        if ($error_no > 0 && $error_no != 1062)
        {
            die($GLOBALS['db']->errorMsg());
        }
    }
    while ($error_no == 1062); //����Ƕ������ظ��������ύ����

    $new_order_id = $db->insert_id();
    $order['order_id'] = $new_order_id;

    /* ���붩����Ʒ */
    $sql = "INSERT INTO " . $ecs->table('order_goods') . "( " .
                "order_id, goods_id, goods_name, goods_sn, product_id, goods_number, market_price, ".
                "goods_price, goods_attr, is_real, extension_code, parent_id, is_gift, goods_attr_id ) ".
            " SELECT '$new_order_id', goods_id, goods_name, goods_sn, product_id, goods_number, market_price, ".
                "goods_price, goods_attr, is_real, extension_code, parent_id, is_gift, goods_attr_id".
            " FROM " .$ecs->table('cart') .
            " WHERE session_id = '".SESS_ID."' AND rec_type = '$flow_type'";
    $db->query($sql);
	
	/* ������Ʒ����salesnum �ֶΣ�ͳ���������� */
    $sql = "update " .$GLOBALS['ecs']->table('goods') . " AS a, ".$GLOBALS['ecs']->table('cart') . " AS b ".
           " set a.salesnum= a.salesnum + b.goods_number".
           " WHERE a.goods_id=b.goods_id AND b.session_id = '".SESS_ID."' AND b.rec_type = '$flow_type'";
    $db->query($sql);
	
    /* �޸������״̬ */
    if ($order['extension_code']=='auction')
    {
        $sql = "UPDATE ". $ecs->table('goods_activity') ." SET is_finished='2' WHERE act_id=".$order['extension_id'];
        $db->query($sql);
    }

    /* ���������֡���� */
    if ($order['user_id'] > 0 && $order['surplus'] > 0)
    {
        log_account_change($order['user_id'], $order['surplus'] * (-1), 0, 0, 0, sprintf($_LANG['pay_order'], $order['order_sn']));
    }
    if ($order['user_id'] > 0 && $order['integral'] > 0)
    {
        log_account_change($order['user_id'], 0, 0, 0, $order['integral'] * (-1), sprintf($_LANG['pay_order'], $order['order_sn']));
    }


    if ($order['bonus_id'] > 0 && $temp_amout > 0)
    {
        use_bonus($order['bonus_id'], $new_order_id);
    }

    /* ���ʹ�ÿ�棬���¶���ʱ����棬����ٿ�� */
    if ($_CFG['use_storage'] == '1' && $_CFG['stock_dec_time'] == SDT_PLACE)
    {
        change_order_goods_storage($order['order_id'], true, SDT_PLACE);
    }

    /* ���̼ҷ��ʼ� */
    /* �����Ƿ���ͷ������ʼ�ѡ�� */
    if ($_CFG['send_service_email'] && $_CFG['service_email'] != '')
    {
        $tpl = get_mail_template('remind_of_new_order');
        $smarty->assign('order', $order);
        $smarty->assign('goods_list', $cart_goods);
        $smarty->assign('shop_name', $_CFG['shop_name']);
        $smarty->assign('send_date', date($_CFG['time_format']));
        $content = $smarty->fetch('str:' . $tpl['template_content']);
        send_mail($_CFG['shop_name'], $_CFG['service_email'], $tpl['template_subject'], $content, $tpl['is_html']);
    }

    /* �����Ҫ�������� */
    if ($_CFG['sms_order_placed'] == '1' && $_CFG['sms_shop_mobile'] != '')
    {
        include_once('includes/cls_sms.php');
        $sms = new sms();
        $msg = $order['pay_status'] == PS_UNPAYED ?
            $_LANG['order_placed_sms'] : $_LANG['order_placed_sms'] . '[' . $_LANG['sms_paid'] . ']';
        $sms->send($_CFG['sms_shop_mobile'], sprintf($msg, $order['consignee'], $order['tel']),'', 13,1);
    }

    /* ����������Ϊ0 �������⿨ */
    if ($order['order_amount'] <= 0)
    {
        $sql = "SELECT goods_id, goods_name, goods_number AS num FROM ".
               $GLOBALS['ecs']->table('cart') .
                " WHERE is_real = 0 AND extension_code = 'virtual_card'".
                " AND session_id = '".SESS_ID."' AND rec_type = '$flow_type'";

        $res = $GLOBALS['db']->getAll($sql);

        $virtual_goods = array();
        foreach ($res AS $row)
        {
            $virtual_goods['virtual_card'][] = array('goods_id' => $row['goods_id'], 'goods_name' => $row['goods_name'], 'num' => $row['num']);
        }

        if ($virtual_goods AND $flow_type != CART_GROUP_BUY_GOODS)
        {
            /* ���⿨���� */
            if (virtual_goods_ship($virtual_goods,$msg, $order['order_sn'], true))
            {
                /* ���û��ʵ����Ʒ���޸ķ���״̬���ͻ��ֺͺ�� */
                $sql = "SELECT COUNT(*)" .
                        " FROM " . $ecs->table('order_goods') .
                        " WHERE order_id = '$order[order_id]' " .
                        " AND is_real = 1";
                if ($db->getOne($sql) <= 0)
                {
                    /* �޸Ķ���״̬ */
                    update_order($order['order_id'], array('shipping_status' => SS_SHIPPED, 'shipping_time' => gmtime()));

                    /* ��������û���Ϊ�գ�������֣��������û�������� */
                    if ($order['user_id'] > 0)
                    {
                        /* ȡ���û���Ϣ */
                        $user = user_info($order['user_id']);

                        /* ���㲢���Ż��� */
                        $integral = integral_to_give($order);
                        log_account_change($order['user_id'], 0, 0, intval($integral['rank_points']), intval($integral['custom_points']), sprintf($_LANG['order_gift_integral'], $order['order_sn']));

                        /* ���ź�� */
                        send_order_bonus($order['order_id']);
                    }
                }
            }
        }

    }

    /* ��չ��ﳵ */
    clear_cart($flow_type,$rec_id);
    /* ������棬����������Ʒ������ǰ̨ҳ���ȡ���棬��Ʒ���������� */
    clear_all_files();

    /* ����֧����־ */
    $order['log_id'] = insert_pay_log($new_order_id, $order['order_amount'], PAY_ORDER);

    /* ȡ��֧����Ϣ������֧������ */
    if ($order['order_amount'] > 0)
    {
        $payment = payment_info($order['pay_id']);

        include_once('includes/modules/payment/' . $payment['pay_code'] . '.php');

        $pay_obj    = new $payment['pay_code'];
        $pay_online= 1;
        if($payment['pay_code'] != 'weixin'){
            $pay_online = $pay_obj->get_code($order, unserialize_config($payment['pay_config']));
        }


        $order['pay_desc'] = $payment['pay_desc'];

        $smarty->assign('pay_online', $pay_online);
    }
    if(!empty($order['shipping_name']))
    {
        $order['shipping_name']=trim(stripcslashes($order['shipping_name']));
    }

    /* ������Ϣ */
    $smarty->assign('order',      $order);
    $smarty->assign('total',      $total);
    $smarty->assign('goods_list', $cart_goods);
    $smarty->assign('order_submit_back', sprintf($_LANG['order_submit_back'], $_LANG['back_home'], $_LANG['goto_user_center'])); // ������ʾ

    user_uc_call('add_feed', array($order['order_id'], BUY_GOODS)); //����feed��uc
    unset($_SESSION['flow_consignee']); // ���session�б�����ջ�����Ϣ
    unset($_SESSION['flow_order']);
    unset($_SESSION['direct_shopping']);
}

/*------------------------------------------------------ */
//-- ���¹��ﳵ
/*------------------------------------------------------ */

elseif ($_REQUEST['step'] == 'update_cart')
{
    if (isset($_POST['goods_number']) && is_array($_POST['goods_number']))
    {
        flow_update_cart($_POST['goods_number']);
    }

    show_message($_LANG['update_cart_notice'], $_LANG['back_to_cart'], 'flow.php');
    exit;
}

/*------------------------------------------------------ */
//-- ɾ�����ﳵ�е���Ʒ
/*------------------------------------------------------ */

elseif ($_REQUEST['step'] == 'drop_goods')
{
    $rec_id = intval($_GET['id']);
    flow_drop_cart_goods($rec_id);

    ecs_header("Location: flow.php\n");
    exit;
}

/*------------------------------------------------------ */
//-- ɾ�����ﳵ�ж����Ʒ
/*------------------------------------------------------ */

elseif ($_REQUEST['step'] == 'drop_goods_list')
{
    $rec_id = $_POST['order_goods_id'];
	if($rec_id){
		foreach($rec_id as $id){
			flow_drop_cart_goods($id);
		}
	}
    ecs_header("Location: flow.php\n");
    exit;
}

/* ���Żݻ���빺�ﳵ */
elseif ($_REQUEST['step'] == 'add_favourable')
{
    /* ȡ���Żݻ��Ϣ */
    $act_id = intval($_POST['act_id']);
    $favourable = favourable_info($act_id);
    if (empty($favourable))
    {
        show_message($_LANG['favourable_not_exist']);
    }

    /* �ж��û��ܷ����ܸ��Ż� */
    if (!favourable_available($favourable))
    {
        show_message($_LANG['favourable_not_available']);
    }

    /* ��鹺�ﳵ���Ƿ����и��Ż� */
    $cart_favourable = cart_favourable();
    if (favourable_used($favourable, $cart_favourable))
    {
        show_message($_LANG['favourable_used']);
    }

    /* ��Ʒ���ػ�Ʒ���Ż� */
    if ($favourable['act_type'] == FAT_GOODS)
    {
        /* ����Ƿ�ѡ������Ʒ */
        if (empty($_POST['gift']))
        {
            show_message($_LANG['pls_select_gift']);
        }

        /* ����Ƿ����ڹ��ﳵ */
        $sql = "SELECT goods_name" .
                " FROM " . $ecs->table('cart') .
                " WHERE session_id = '" . SESS_ID . "'" .
                " AND rec_type = '" . CART_GENERAL_GOODS . "'" .
                " AND is_gift = '$act_id'" .
                " AND goods_id " . db_create_in($_POST['gift']);
        $gift_name = $db->getCol($sql);
        if (!empty($gift_name))
        {
            show_message(sprintf($_LANG['gift_in_cart'], join(',', $gift_name)));
        }

        /* ��������Ƿ񳬹����� */
        $count = isset($cart_favourable[$act_id]) ? $cart_favourable[$act_id] : 0;
        if ($favourable['act_type_ext'] > 0 && $count + count($_POST['gift']) > $favourable['act_type_ext'])
        {
            show_message($_LANG['gift_count_exceed']);
        }

        /* ������Ʒ�����ﳵ */
        foreach ($favourable['gift'] as $gift)
        {
            if (in_array($gift['id'], $_POST['gift']))
            {
                add_gift_to_cart($act_id, $gift['id'], $gift['price']);
            }
        }
    }
    elseif ($favourable['act_type'] == FAT_DISCOUNT)
    {
        add_favourable_to_cart($act_id, $favourable['act_name'], cart_favourable_amount($favourable) * (100 - $favourable['act_type_ext']) / 100);
    }
    elseif ($favourable['act_type'] == FAT_PRICE)
    {
        add_favourable_to_cart($act_id, $favourable['act_name'], $favourable['act_type_ext']);
    }

    /* ˢ�¹��ﳵ */
    ecs_header("Location: flow.php\n");
    exit;
}
elseif ($_REQUEST['step'] == 'clear')
{
    $sql = "DELETE FROM " . $ecs->table('cart') . " WHERE session_id='" . SESS_ID . "'";
    $db->query($sql);

    ecs_header("Location:./\n");
}
elseif ($_REQUEST['step'] == 'drop_to_collect')
{
    if ($_SESSION['user_id'] > 0)
    {
        $rec_id = intval($_GET['id']);
        $goods_id = $db->getOne("SELECT  goods_id FROM " .$ecs->table('cart'). " WHERE rec_id = '$rec_id' AND session_id = '" . SESS_ID . "' ");
        $count = $db->getOne("SELECT goods_id FROM " . $ecs->table('collect_goods') . " WHERE user_id = '$_SESSION[user_id]' AND goods_id = '$goods_id'");
        if (empty($count))
        {
            $time = gmtime();
            $sql = "INSERT INTO " .$GLOBALS['ecs']->table('collect_goods'). " (user_id, goods_id, add_time)" .
                    "VALUES ('$_SESSION[user_id]', '$goods_id', '$time')";
            $db->query($sql);
        }
        flow_drop_cart_goods($rec_id);
    }else{
		ecs_header("Location: user.php\n");
		exit;
	}
    ecs_header("Location: flow.php\n");
    exit;
}

/* ��֤������к� */
elseif ($_REQUEST['step'] == 'validate_bonus')
{
    $bonus_sn = trim($_REQUEST['bonus_sn']);
    if (is_numeric($bonus_sn))
    {
        $bonus = bonus_info(0, $bonus_sn);
    }
    else
    {
        $bonus = array();
    }

//    if (empty($bonus) || $bonus['user_id'] > 0 || $bonus['order_id'] > 0)
//    {
//        die($_LANG['bonus_sn_error']);
//    }
//    if ($bonus['min_goods_amount'] > cart_amount())
//    {
//        die(sprintf($_LANG['bonus_min_amount_error'], price_format($bonus['min_goods_amount'], false)));
//    }
//    die(sprintf($_LANG['bonus_is_ok'], price_format($bonus['type_money'], false)));
    $bonus_kill = price_format($bonus['type_money'], false);

    include_once('includes/cls_json.php');
    $result = array('error' => '', 'content' => '');

    /* ȡ�ù������� */
    $flow_type = isset($_SESSION['flow_type']) ? intval($_SESSION['flow_type']) : CART_GENERAL_GOODS;

    /* ����ջ�����Ϣ */
    $consignee = get_consignee($_SESSION['user_id']);

    /* ����Ʒ��Ϣ��ֵ */
    $cart_goods = cart_goods($flow_type); // ȡ����Ʒ�б�������ϼ�

    if (empty($cart_goods) || !check_consignee_info($consignee, $flow_type))
    {
        $result['error'] = $_LANG['no_goods_in_cart'];
    }
    else
    {
        /* ȡ�ù����������� */
        $smarty->assign('config', $_CFG);

        /* ȡ�ö�����Ϣ */
        $order = flow_order_info();


        if (((!empty($bonus) && $bonus['user_id'] == $_SESSION['user_id']) || ($bonus['type_money'] > 0 && empty($bonus['user_id']))) && $bonus['order_id'] <= 0)
        {
            //$order['bonus_kill'] = $bonus['type_money'];
            $now = gmtime();
            if ($now > $bonus['use_end_date'])
            {
                $order['bonus_id'] = '';
                $result['error']=$_LANG['bonus_use_expire'];
            }
            else
            {
                $order['bonus_id'] = $bonus['bonus_id'];
                $order['bonus_sn'] = $bonus_sn;
            }
        }
        else
        {
            //$order['bonus_kill'] = 0;
            $order['bonus_id'] = '';
            $result['error'] = $_LANG['invalid_bonus'];
        }

        /* ���㶩���ķ��� */
        $total = order_fee($order, $cart_goods, $consignee);

        if($total['goods_price']<$bonus['min_goods_amount'])
        {
         $order['bonus_id'] = '';
         /* ���¼��㶩�� */
         $total = order_fee($order, $cart_goods, $consignee);
         $result['error'] = sprintf($_LANG['bonus_min_amount_error'], price_format($bonus['min_goods_amount'], false));
        }

        $smarty->assign('total', $total);

        /* �Ź���־ */
        if ($flow_type == CART_GROUP_BUY_GOODS)
        {
            $smarty->assign('is_group_buy', 1);
        }

        $result['content'] = $smarty->fetch('library/order_total.lbi');
    }
    $json = new JSON();
    die($json->encode($result));
}
/*------------------------------------------------------ */
//-- ������������ﳵ
/*------------------------------------------------------ */
elseif ($_REQUEST['step'] == 'add_package_to_cart')
{
    include_once('includes/cls_json.php');
    $_POST['package_info'] = json_str_iconv($_POST['package_info']);

    $result = array('error' => 0, 'message' => '', 'content' => '', 'package_id' => '');
    $json  = new JSON;

    if (empty($_POST['package_info']))
    {
        $result['error'] = 1;
        die($json->encode($result));
    }

    $package = $json->decode($_POST['package_info']);

    /* �����һ���������չ��ﳵ */
    if ($_CFG['one_step_buy'] == '1')
    {
        clear_cart();
    }

    /* ��Ʒ�����Ƿ�Ϸ� */
    if (!is_numeric($package->number) || intval($package->number) <= 0)
    {
        $result['error']   = 1;
        $result['message'] = $_LANG['invalid_number'];
    }
    else
    {
        /* ���ӵ����ﳵ */
        if (add_package_to_cart($package->package_id, $package->number))
        {
            if ($_CFG['cart_confirm'] > 2)
            {
                $result['message'] = '';
            }
            else
            {
                $result['message'] = $_CFG['cart_confirm'] == 1 ? $_LANG['addto_cart_success_1'] : $_LANG['addto_cart_success_2'];
            }

            $result['content'] = insert_cart_info();
            $result['one_step_buy'] = $_CFG['one_step_buy'];
        }
        else
        {
            $result['message']    = $err->last_message();
            $result['error']      = $err->error_no;
            $result['package_id'] = stripslashes($package->package_id);
        }
    }
    $result['confirm_type'] = !empty($_CFG['cart_confirm']) ? $_CFG['cart_confirm'] : 2;
    die($json->encode($result));
}

/*------------------------------------------------------ */
//-- ��дͶ����Ϣ
/*------------------------------------------------------ */
elseif ($_REQUEST['step'] == 'add_insure')
{
    if(!$_SESSION['user_id']){
		ecs_header("Location: user.php\n");
	}
	$rec_id=$_GET['rec_id'];
	$cart_info = $db->getRow("SELECT  goods_name,goods_attr,insure_id FROM " .$ecs->table('cart'). " WHERE rec_id = '$rec_id' AND session_id = '" . SESS_ID . "' ");
	if($cart_info['insure_id']){
		$arr = $db->getRow("SELECT * FROM " .$ecs->table('insure'). " WHERE insure_id = '".$cart_info['insure_id']."' ");
		$smarty->assign('arr',            $arr);
	}
	
	$contacts = $db->getAll("SELECT  name,contacts_id FROM " .$ecs->table('contacts'). " WHERE user_id = '".$_SESSION['user_id']."'");
	
	$smarty->assign('contacts',            $contacts);
	$smarty->assign('rec_id',              $rec_id);
	$smarty->assign('cart_info',           $cart_info);
}

/*------------------------------------------------------ */
//-- ajax���ó�����ϵ��
/*------------------------------------------------------ */
elseif ($_REQUEST['step'] == 'contacts_dy')
{
	include_once(ROOT_PATH .'includes/cls_json.php');
    include_once(ROOT_PATH .'includes/lib_passport.php');
    $json = new JSON();
    $result = array('error' => 0, 'message' => '', 'content' => '');

    if ($_SESSION['user_id'] == 0)
    {
        /* �û�û�е�¼ */
        $result['error']   = 1;
        $result['message'] = $_LANG['login_please'];
        die($json->encode($result));
    }
    
	$id=$_POST['id'];
	$contacts = $db->getRow("SELECT  name,zj_number,address,mobile,email FROM " .$ecs->table('contacts'). " WHERE contacts_id='".$id."' and user_id = '".$_SESSION['user_id']."'");
    if ($contacts)
    {
        foreach($contacts as $key=>$v){
			$result[$key] = $v;
		}
        die($json->encode($result));
    }
    else
    {
        $result['error'] = 1;
        $result['message'] = 'û���ҵ���Ӧ����ϵ��';
    }

    die($json->encode($result));
}
/*------------------------------------------------------ */
//-- ����Ͷ����Ϣ
/*------------------------------------------------------ */
elseif ($_REQUEST['step'] == 'add_insure_cl')
{
    if(!$_SESSION['user_id']){
		ecs_header("Location: user.php\n");
	}
	$sql = "INSERT INTO " . $ecs->table('insure') . " (ws_insure, insure_plan, insure_time,tb_name,tbzj_number,address,tb_mobile,email,relation, " .
                    "bb_name, bbzj_number, bb_mobile, jj_contacts, is_invoice,user_id ) " .
                    "VALUES ('$_POST[ws_insure]', '$_POST[insure_plan]', '$_POST[insure_time]', '$_POST[tb_name]','$_POST[tbzj_number]', " .
                    "'$_POST[address]', '$_POST[tb_mobile]', '$_POST[email]', '$_POST[relation]','$_POST[bb_name]','$_POST[bbzj_number]', ".
                    "'$_POST[bb_mobile]', '$_POST[jj_contacts]', '$_POST[is_invoice]','".$_SESSION['user_id']."') ";
	$db->query($sql);
	$insure_id=$db->insert_id();
	
	$rec_id=$_POST['rec_id'];
	$db->query("update ".$ecs->table('cart')." SET insure_id = '".$insure_id."' where rec_id='".$rec_id."'");
	
	ecs_header("Location: flow.php?step=checkout&rec_id=$rec_id\n");
}
/*------------------------------------------------------ */
//-- �޸�Ͷ����Ϣ
/*------------------------------------------------------ */
elseif ($_REQUEST['step'] == 'up_insure_cl')
{
    if(!$_SESSION['user_id']){
		ecs_header("Location: user.php\n");
	}
	$sql = "update " . $ecs->table('insure') . " SET ws_insure='$_POST[ws_insure]', insure_plan='$_POST[insure_plan]', insure_time='$_POST[insure_time]',tb_name='$_POST[tb_name]', ".
	       "tbzj_number='$_POST[tbzj_number]',address='$_POST[address]',tb_mobile='$_POST[tb_mobile]',email='$_POST[email]',relation='$_POST[relation]', bb_name='$_POST[bb_name]', ".
           "bbzj_number='$_POST[bbzj_number]', bb_mobile='$_POST[bb_mobile]', jj_contacts='$_POST[jj_contacts]', is_invoice='$_POST[is_invoice]' where insure_id='$_POST[insure_id]'";
	$db->query($sql);
	$rec_id=$_POST['rec_id'];
	ecs_header("Location: flow.php?step=checkout&rec_id=$rec_id\n");
}
/*------------------------------------------------------ */
//-- �鿴Ͷ����Ϣ
/*------------------------------------------------------ */
elseif ($_REQUEST['step'] == 'examine_insure')
{
    if(!$_SESSION['user_id']){
		ecs_header("Location: user.php\n");
	}
	$id=$_GET['id'];
	$arr = $db->getRow("SELECT * FROM " .$ecs->table('insure'). " WHERE insure_id = $id ");
	$goods = $db->getRow("SELECT goods_price,goods_name,rec_id FROM " .$ecs->table('cart'). " WHERE insure_id = $id ");
	$smarty->assign('arr',            $arr);
	$smarty->assign('goods',          $goods);
	$smarty->assign('time',            date("Y-m-d",gmtime()));
}

/*------------------------------------------------------ */
//-- ���ӳ��ջ�����Ϣ
/*------------------------------------------------------ */
elseif ($_REQUEST['step'] == 'cx_insure_cl')
{
    if(!$_SESSION['user_id']){
		ecs_header("Location: user.php\n");
	}
	if($_POST){
		$sql = "INSERT INTO " . $ecs->table('insure_cx') . " (c_city, cp_number, dj_time,cz_name,sfz_number,mobile,frame_number,engine_number,brand, " .
                    "configure, is_transfer,user_id ) " .
                    "VALUES ('$_POST[c_city]', '$_POST[cp_number]', '$_POST[dj_time]', '$_POST[cz_name]','$_POST[sfz_number]', " .
                    "'$_POST[mobile]', '$_POST[frame_number]', '$_POST[engine_number]', '$_POST[brand]','$_POST[configure]','$_POST[is_transfer]', ".
                    "'".$_SESSION['user_id']."') ";
	    $db->query($sql);
		$cx_id=$db->insert_id();
	}
	$djq = $db->getAll("SELECT goods_name,shop_price,goods_img,goods_desc FROM " .$ecs->table('goods'). " WHERE cx_type =1 limit 3 ");
	$dzb = $db->getAll("SELECT goods_name,shop_price,goods_img,goods_desc FROM " .$ecs->table('goods'). " WHERE cx_type =2 limit 3 ");
	$jqb = $db->getAll("SELECT goods_name,shop_price,goods_img,goods_desc FROM " .$ecs->table('goods'). " WHERE cx_type =3 limit 3 ");
	$cat_id=$_POST['cat_id'];
	$djq_xz = $db->getRow("SELECT tbxz,goods_id FROM " .$ecs->table('goods'). " WHERE cat_id =$cat_id and cx_type=1");
	$dzb_xz = $db->getRow("SELECT tbxz,goods_id FROM " .$ecs->table('goods'). " WHERE cat_id =$cat_id and cx_type=2");
	$jqb_xz = $db->getRow("SELECT tbxz,goods_id FROM " .$ecs->table('goods'). " WHERE cat_id =$cat_id and cx_type=3");
	
	$djq_xz['tbxz']=unserialize($djq_xz['tbxz']);
	$dzb_xz['tbxz']=unserialize($dzb_xz['tbxz']);
	$jqb_xz['tbxz']=unserialize($jqb_xz['tbxz']);
	
	$djq_total=0;
	$dzb_total=0;
	$jqb_total=0;
	foreach($djq_xz['tbxz'] as $key=>$v){
		$djq_total+=$v['price'];
		$dzb_total+=$dzb_xz['tbxz'][$key]['price'];
		$jqb_total+=$jqb_xz['tbxz'][$key]['price'];
	}
	
	$smarty->assign('cat_id',           $cat_id);
	$smarty->assign('cx_id',            $cx_id);
	$smarty->assign('djq',            $djq);  //����ǿ��Ʒ
	$smarty->assign('dzb',            $dzb);  //���ڰ��Ʒ
	$smarty->assign('jqb',            $jqb);  //��ǿ���Ʒ
	
	$smarty->assign('djq_xz',         $djq_xz);  //����ǿ����
	$smarty->assign('dzb_xz',         $dzb_xz);  //���ڰ�����
	$smarty->assign('jqb_xz',         $jqb_xz);  //��ǿ������
	
	$smarty->assign('djq_total',         $djq_total);  //����ǿ���ֺϼƱ���
	$smarty->assign('dzb_total',         $dzb_total);  //���ڰ����ֺϼƱ���
	$smarty->assign('jqb_total',         $jqb_total);  //��ǿ�����ֺϼƱ���
}

/*------------------------------------------------------ */
//-- ������
/*------------------------------------------------------ */
elseif ($_REQUEST['step'] == 'js_price')
{
    /*------------------------------------------------------ */
    //-- ������
    /*------------------------------------------------------ */
    include_once('includes/cls_json.php');
    $json = new JSON;
    $result = array('price' => '', 'total' => '','xz_id'=>'');
	$xz=$_GET['xz'];
	$price=intval($_GET['price']);
	/*������ʧ��*/
	if($xz == 'clss'){
		$clss_price=$price ? $price*0.0147+619 : 0;
		$bjmp_price=$_GET['bjmp'] ? $clss_price*0.15 : 0;
		$_SESSION['clss_price']=$clss_price;
		$_SESSION['clss_bj']=$bjmp_price;      //�����������
		$clss_price=$clss_price+$bjmp_price;
		$result['price'] = $clss_price;
		$result['xz_id'] = 'clss_price';
	}
	/*����������*/
    if($xz == 'dszr'){
		if($price == 50000){
			$dszr_price=807;
		}elseif($price == 100000){
			$dszr_price=1166;
		}elseif($price == 150000){
			$dszr_price=1329;
		}elseif($price == 200000){
			$dszr_price=1445;
		}elseif($price == 300000){
			$dszr_price=1630;
		}elseif($price == 500000){
			$dszr_price=1956;
		}elseif($price == 1000000){
			$dszr_price=2548;
		}else{
			$dszr_price=0;
		}
		$bjmp_price=$_GET['bjmp'] ? $dszr_price*0.15 : 0;
		$_SESSION['dszr_price']=$dszr_price;
		$_SESSION['dszr_bj']=$bjmp_price;   //�����������
		$dszr_price=$dszr_price+$bjmp_price;
		$result['price'] = $dszr_price;
		$result['xz_id'] = 'dszr_price';
	}
	/*˾����λ��*/
	if($xz == 'sjzw'){
		$sjzw_price=$price ? $price*0.0042 : 0;
		$bjmp_price=$_GET['bjmp'] ? $sjzw_price*0.15 : 0;
		$_SESSION['sjzw_price']=$sjzw_price;
		$_SESSION['sjzw_bj']=$bjmp_price;    //�����������
		$sjzw_price=$sjzw_price+$bjmp_price;
		$result['price'] = $sjzw_price;
		$result['xz_id'] = 'sjzw_price';
	}
	/*�˿���λ��*/
	if($xz == 'ckzw'){
		$ckzw_price=$price ? $price*0.0027*6 : 0;
		$bjmp_price=$_GET['bjmp'] ? $ckzw_price*0.15 : 0;
		$_SESSION['ckzw_price']=$ckzw_price;
		$_SESSION['ckzw_bj']=$bjmp_price;   //�����������
		$ckzw_price=$ckzw_price+$bjmp_price;
		$result['price'] = $ckzw_price;
		$result['xz_id'] = 'ckzw_price';
	}
	/*������*/
	if($xz == 'qdx'){
		$qdx_price=$price ? $price*0.0041+120 : 0;
		$bjmp_price=$_GET['bjmp'] ? $qdx_price*0.15 : 0;
		$_SESSION['qdx_price']=$qdx_price;
		$_SESSION['qdx_bj']=$bjmp_price;   //�����������
		$qdx_price=$qdx_price+$bjmp_price;
		$result['price'] = $qdx_price;
		$result['xz_id'] = 'qdx_price';
	}
	/*����������*/
	if($xz == 'blps'){
		$cs_price=$_GET['cs_price'];
		if($cs_price && $price){
			$blps_price=$price ==1 ? $cs_price*0.0019 : $cs_price*0.0032; 
		}else{
			$blps_price=0;
		}
		$_SESSION['blps_price']=$blps_price;
		$result['price'] = $blps_price;
		$result['xz_id'] = 'blps_price';
	}
	/*ָ��ר����*/
	if($xz == 'zdzx'){
		if($price && $_SESSION['clss_price']){
			$zdzx_price=$price ==1 ? $_SESSION['clss_price']*0.1 : $_SESSION['clss_price']*0.2; 
		}else{
			$zdzx_price=0;
		}
		$_SESSION['zdzx_price']=$zdzx_price;
		$result['price'] = $zdzx_price;
		$result['xz_id'] = 'zdzx_price';
	}
	
	@$_SESSION['xz_total']=$_SESSION['clss_price']+$_SESSION['dszr_price']+$_SESSION['sjzw_price']+$_SESSION['ckzw_price']+$_SESSION['qdx_price']+$_SESSION['blps_price']+$_SESSION['zdzx_price']+$_SESSION['clss_bj']+$_SESSION['dszr_bj']+$_SESSION['sjzw_bj']+$_SESSION['ckzw_bj']+$_SESSION['qdx_bj'];
	$result['total']=$_SESSION['xz_total'];

    echo $json->encode($result);
    exit;
}

/*------------------------------------------------------ */
//-- �ύͶ������
/*------------------------------------------------------ */
elseif ($_REQUEST['step'] == 'tj_insure')
{
    if(!$_SESSION['user_id']){
		ecs_header("Location: user.php\n");
	}
	$cx_id=$_REQUEST['cx_id'];
	$goods_id=$_GET['goods_id'];
	$arr = $db->getRow("SELECT * FROM " .$ecs->table('insure_cx'). " WHERE cx_id = $cx_id and user_id='".$_SESSION['user_id']."' ");
	if(@$_POST['cat_id']){
		$tbxz_info = $db->getRow("SELECT cat_name FROM ".$ecs->table('category')." WHERE cat_id=".$_POST['cat_id']." ");
		$tbxz=array();
		if($_POST['clss']){
			$clss_bj=$_SESSION['clss_bj'] ? 1 : 0;
			$tbxz[]=array('xz_name'=>'������ʧ��','tb_price'=>$_POST['clss'],'is_mp'=>$clss_bj,'price'=>($_SESSION['clss_bj']+$_SESSION['clss_price']));
		}
		if($_POST['dszr']){
			$dszr_bj=$_SESSION['dszr_bj'] ? 1 : 0;
			$tbxz[]=array('xz_name'=>'����������','tb_price'=>$_POST['dszr'],'is_mp'=>$dszr_bj,'price'=>($_SESSION['dszr_bj']+$_SESSION['dszr_price']));
		}
		if($_POST['sjzw']){
			$sjzw_bj=$_SESSION['sjzw_bj'] ? 1 : 0;
			$tbxz[]=array('xz_name'=>'˾����λ��','tb_price'=>$_POST['sjzw'],'is_mp'=>$sjzw_bj,'price'=>($_SESSION['sjzw_bj']+$_SESSION['sjzw_price']));
		}
		if($_POST['ckzw']){
			$ckzw_bj=$_SESSION['ckzw_bj'] ? 1 : 0;
			$tbxz[]=array('xz_name'=>'�˿���λ��','tb_price'=>$_POST['ckzw'],'is_mp'=>$ckzw_bj,'price'=>($_SESSION['ckzw_bj']+$_SESSION['ckzw_price']));
		}
		if($_POST['qdx']){
			$qdx_bj=$_SESSION['qdx_bj'] ? 1 : 0;
			$tbxz[]=array('xz_name'=>'������','tb_price'=>$_POST['qdx'],'is_mp'=>$qdx_bj,'price'=>($_SESSION['qdx_bj']+$_SESSION['qdx_price']));
		}
		if($_POST['blps']){
			$blps=$_POST['blps'] ==1 ? '������' : '���ڳ�';
			$tbxz[]=array('xz_name'=>'����������','tb_price'=>$blps,'is_mp'=>0,'price'=>$_SESSION['blps_price']);
		}
		if($_POST['zdzx']){
			$zdzx=$_POST['zdzx'] ==1 ? '������' : '���ڳ�';
			$tbxz[]=array('xz_name'=>'ָ��ר����','tb_price'=>$zdzx,'is_mp'=>0,'price'=>$_SESSION['zdzx_price']);
		}
		$tbxz_total=$_SESSION['xz_total'];
		$_SESSION['tbxz_info']=serialize($tbxz);
		$smarty->assign('custom',            1); //�Զ���
	}else{
		$tbxz_info = $db->getRow("SELECT g.tbxz,g.cx_type,c.cat_name FROM ".$ecs->table('goods')." as g,".$ecs->table('category')." as c WHERE g.cat_id=c.cat_id and goods_id = $goods_id ");
		$tbxz=unserialize($tbxz_info['tbxz']);
		$tbxz_total=0;
		foreach($tbxz as $v){
			$tbxz_total+=$v['price'];
		}
	}
	
	 /* ��ȡĬ���ջ�ID */
    $address_info  = $db->getRow("SELECT a.* FROM ".$ecs->table('users')." as u,".$ecs->table('user_address')." as a WHERE u.address_id=a.address_id and u.user_id='".$_SESSION['user_id']."'");
	$smarty->assign('address_info',            $address_info);
	
	$payment_list = available_payment_list(1);
	
	/* ������� */
    $smarty->assign('country_list', get_regions());
	
	$smarty->assign('province_list',    get_regions(1,1));
    $smarty->assign('city_list',        get_regions(2,$address_info['province']));
    $smarty->assign('district_list',    get_regions(3,$address_info['city']));
	
	$smarty->assign('cat_id', $_POST['cat_id']);
	$smarty->assign('cx_id', $cx_id);
	$smarty->assign('arr',            $arr);
	$smarty->assign('tbxz',           $tbxz);
	$smarty->assign('tbxz_info',      $tbxz_info);
	$smarty->assign('goods_id',       $goods_id);
	$smarty->assign('tbxz_total',     $tbxz_total);
	$smarty->assign('payment_list',   $payment_list);
}

/*------------------------------------------------------ */
//-- �ύ����
/*------------------------------------------------------ */
elseif ($_REQUEST['step'] == 'cx_done')
{
    if(!$_SESSION['user_id']){
		ecs_header("Location: user.php\n");
	}
	if(!$_POST['is_check']){
		echo "<script>alert('�빴ѡ����Ͷ������Э�飡');history.go(-1);</script>";
		exit;
	}
	include_once('includes/lib_clips.php');
    include_once('includes/lib_payment.php');
	
	if($_POST['address_id']){
		include_once(ROOT_PATH . 'includes/lib_transaction.php');
		$address = array(
			'user_id'    => $_SESSION['user_id'],
			'address_id' => intval($_POST['address_id']),
			'country'    => isset($_POST['country'])   ? intval($_POST['country'])  : 0,
			'province'   => isset($_POST['province'])  ? intval($_POST['province']) : 0,
			'city'       => isset($_POST['city'])      ? intval($_POST['city'])     : 0,
			'district'   => isset($_POST['district'])  ? intval($_POST['district']) : 0,
			'address'    => isset($_POST['address'])   ? compile_str(trim($_POST['address']))    : '',
			'consignee'  => isset($_POST['bd_name']) ? compile_str(trim($_POST['bd_name']))  : '',
			'mobile'     => isset($_POST['bd_mobile'])    ? compile_str(make_semiangle(trim($_POST['bd_mobile']))) : '',
			'best_time'  => isset($_POST['ps_time']) ? $_POST['ps_time'] : '',
			);
	
		update_address($address);
	}
	
	$consignee = get_consignee($_SESSION['user_id']);

    /* ȡ�ù������� */
    $flow_type = isset($_SESSION['flow_type']) ? intval($_SESSION['flow_type']) : CART_GENERAL_GOODS;

    $_POST['how_oos'] = isset($_POST['how_oos']) ? intval($_POST['how_oos']) : 0;
    $_POST['card_message'] = isset($_POST['card_message']) ? compile_str($_POST['card_message']) : '';
    $_POST['inv_type'] = !empty($_POST['inv_type']) ? compile_str($_POST['inv_type']) : '';
    $_POST['inv_payee'] = isset($_POST['inv_payee']) ? compile_str($_POST['inv_payee']) : '';
    $_POST['inv_content'] = isset($_POST['inv_content']) ? compile_str($_POST['inv_content']) : '';
    $_POST['postscript'] = isset($_POST['postscript']) ? compile_str($_POST['postscript']) : '';

    $order = array(
        'cat_id'          => $_POST['cat_id'],
		'tbxz'            => $_SESSION['tbxz_info'],
		'shipping_id'     => intval($_POST['shipping']),
        'pay_id'          => intval($_POST['payment']),
        'pack_id'         => isset($_POST['pack']) ? intval($_POST['pack']) : 0,
        'card_id'         => isset($_POST['card']) ? intval($_POST['card']) : 0,
        'card_message'    => trim($_POST['card_message']),
        'surplus'         => isset($_POST['surplus']) ? floatval($_POST['surplus']) : 0.00,
        'integral'        => isset($_POST['integral']) ? intval($_POST['integral']) : 0,
        'bonus_id'        => isset($_POST['bonus']) ? intval($_POST['bonus']) : 0,
        'need_inv'        => empty($_POST['need_inv']) ? 0 : 1,
        'inv_type'        => $_POST['inv_type'],
        'inv_payee'       => trim($_POST['inv_payee']),
        'inv_content'     => $_POST['inv_content'],
        'postscript'      => trim($_POST['postscript']),
        'how_oos'         => isset($_LANG['oos'][$_POST['how_oos']]) ? addslashes($_LANG['oos'][$_POST['how_oos']]) : '',
        'need_insure'     => isset($_POST['need_insure']) ? intval($_POST['need_insure']) : 0,
        'user_id'         => $_SESSION['user_id'],
        'add_time'        => gmtime(),
        'order_status'    => OS_UNCONFIRMED,
        'shipping_status' => SS_UNSHIPPED,
        'pay_status'      => PS_UNPAYED,
        'agency_id'       => get_agency_by_regions(array($consignee['country'], $consignee['province'], $consignee['city'], $consignee['district']))
        );

    /* ��չ��Ϣ */
    if (isset($_SESSION['flow_type']) && intval($_SESSION['flow_type']) != CART_GENERAL_GOODS)
    {
        $order['extension_code'] = $_SESSION['extension_code'];
        $order['extension_id'] = $_SESSION['extension_id'];
    }
    else
    {
        $order['extension_code'] = '';
        $order['extension_id'] = 0;
    }

    /* ����������Ƿ�Ϸ� */
    $user_id = $_SESSION['user_id'];
    if ($user_id > 0)
    {
        $user_info = user_info($user_id);

        $order['surplus'] = min($order['surplus'], $user_info['user_money'] + $user_info['credit_line']);
        if ($order['surplus'] < 0)
        {
            $order['surplus'] = 0;
        }

        // ��ѯ�û��ж��ٻ���
        $flow_points = flow_available_points();  // �ö�������ʹ�õĻ���
        $user_points = $user_info['pay_points']; // �û��Ļ�������

        $order['integral'] = min($order['integral'], $user_points, $flow_points);
        if ($order['integral'] < 0)
        {
            $order['integral'] = 0;
        }
    }
    else
    {
        $order['surplus']  = 0;
        $order['integral'] = 0;
    }
	
	/*�ܽ�custom����1���Զ��壩*/
	if($_POST['custom'] ==1){
		$tbxz_total=$_SESSION['xz_total'];
	}else{
		$goods_id=$_POST['goods_id'];
		$goods_info=$db->getRow("select * from ".$ecs->table('goods')." where goods_id='".$goods_id."'");
		$tbxz=unserialize($goods_info['tbxz']);
		$tbxz_total=0;
		foreach($tbxz as $v){
			$tbxz_total+=$v['price'];
		}
	}
   
    /* �����е��ܶ� */
    //$total = order_fee($order, $cart_goods, $consignee);
    $order['bonus']        = 0;
    $order['goods_amount'] = $tbxz_total;
    $order['discount']     = 0;
    $order['surplus']      = 0;
    $order['tax']          = 0;


    /* ֧����ʽ */
    if ($order['pay_id'] > 0)
    {
        $payment = payment_info($order['pay_id']);
        $order['pay_name'] = addslashes($payment['pay_name']);
    }
    $order['pay_fee'] = $db->getOne("select pay_fee from ".$ecs->table('payment')." where pay_id='".$order['pay_id']."'");

    $order['order_amount']  = number_format(($order['goods_amount']+$order['pay_fee']), 2, '.', '');

    /* ���ȫ��ʹ�����֧�����������Ƿ��㹻 */
    if ($payment['pay_code'] == 'balance' && $order['order_amount'] > 0)
    {
        if($order['surplus'] >0) //���֧�������������һ�����
        {
            $order['order_amount'] = $order['order_amount'] + $order['surplus'];
            $order['surplus'] = 0;
        }
        if ($order['order_amount'] > ($user_info['user_money'] + $user_info['credit_line']))
        {
            show_message($_LANG['balance_not_enough']);
        }
        else
        {
            $order['surplus'] = $order['order_amount'];
            $order['order_amount'] = 0;
        }
    }

    /* ����������Ϊ0��ʹ��������ֻ���֧�������޸Ķ���״̬Ϊ��ȷ�ϡ��Ѹ��� */
    if ($order['order_amount'] <= 0)
    {
        $order['order_status'] = OS_CONFIRMED;
        $order['confirm_time'] = gmtime();
        $order['pay_status']   = PS_PAYED;
        $order['pay_time']     = gmtime();
        $order['order_amount'] = 0;
    }

    $order['from_ad']          = !empty($_SESSION['from_ad']) ? $_SESSION['from_ad'] : '0';
    $order['referer']          = !empty($_SESSION['referer']) ? addslashes($_SESSION['referer']) : '';

    /* ��¼��չ��Ϣ */
    if ($flow_type != CART_GENERAL_GOODS)
    {
        $order['extension_code'] = $_SESSION['extension_code'];
        $order['extension_id'] = $_SESSION['extension_id'];
    }
	/* �ջ�����Ϣ */
    foreach ($consignee as $key => $value)
    {
        $order[$key] = addslashes($value);
    }

    $affiliate = unserialize($_CFG['affiliate']);
    if(isset($affiliate['on']) && $affiliate['on'] == 1 && $affiliate['config']['separate_by'] == 1)
    {
        //�Ƽ������ֳ�
        $parent_id = get_affiliate();
        if($user_id == $parent_id)
        {
            $parent_id = 0;
        }
    }
    elseif(isset($affiliate['on']) && $affiliate['on'] == 1 && $affiliate['config']['separate_by'] == 0)
    {
        //�Ƽ�ע��ֳ�
        $parent_id = 0;
    }
    else
    {
        //�ֳɹ��ܹر�
        $parent_id = 0;
    }
    $order['parent_id'] = $parent_id;
	$order['insure_id'] = $_POST['cx_id'];
	$order['bx_type'] = 2;

    /* ���붩���� */
    $error_no = 0;
    do
    {
        $order['order_sn'] = get_order_sn(); //��ȡ�¶�����
        $GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('order_info'), $order, 'INSERT');

        $error_no = $GLOBALS['db']->errno();

        if ($error_no > 0 && $error_no != 1062)
        {
            die($GLOBALS['db']->errorMsg());
        }
    }
    while ($error_no == 1062); //����Ƕ������ظ��������ύ����

    $new_order_id = $db->insert_id();
    $order['order_id'] = $new_order_id;

    if($_POST['custom'] != 1){
		/* ���붩����Ʒ */
		$sql = "INSERT INTO " . $ecs->table('order_goods') . "( " .
					"order_id, goods_id, goods_name, goods_sn, product_id, goods_number, market_price, ".
					"goods_price, goods_attr, is_real, extension_code, parent_id, is_gift, goods_attr_id ) ".
					" VALUES ('$new_order_id','$goods_info[goods_id]','$goods_info[goods_name]','$goods_info[goods_sn]',".
					"'0','1','$goods_info[market_price]','$goods_info[shop_price]','','$goods_info[is_real]','$goods_info[extension_code]','0','0','')";
		$db->query($sql);
		
		/* ������Ʒ����salesnum �ֶΣ�ͳ���������� */
		$sql = "update " .$GLOBALS['ecs']->table('goods') . " ".
			   " set salesnum= salesnum + 1".
			   " WHERE goods_id='".$goods_info['goods_id']."' ";
		$db->query($sql);
	}
	
	/*���³�����Ϣ*/
	$sql = "update " . $ecs->table('insure_cx') . " SET c_city='$_POST[c_city]', frame_number='$_POST[frame_number]', cp_number='$_POST[cp_number]',engine_number='$_POST[engine_number]', ".
	       "dj_time='$_POST[dj_time]',brand='$_POST[brand]',cz_name='$_POST[cz_name]',configure='$_POST[configure]',sfz_number='$_POST[sfz_number]', is_transfer='$_POST[is_transfer]', ".
           "mobile='$_POST[mobile]',is_invoice='$_POST[is_invoice]', invoice_title='$_POST[invoice_title]' where cx_id='$_POST[cx_id]'";
		   
	$db->query($sql);
	
	
	
    /* �޸������״̬ */
    if ($order['extension_code']=='auction')
    {
        $sql = "UPDATE ". $ecs->table('goods_activity') ." SET is_finished='2' WHERE act_id=".$order['extension_id'];
        $db->query($sql);
    }

    /* ���������֡���� */
    if ($order['user_id'] > 0 && $order['surplus'] > 0)
    {
        log_account_change($order['user_id'], $order['surplus'] * (-1), 0, 0, 0, sprintf($_LANG['pay_order'], $order['order_sn']));
    }
    if ($order['user_id'] > 0 && $order['integral'] > 0)
    {
        log_account_change($order['user_id'], 0, 0, 0, $order['integral'] * (-1), sprintf($_LANG['pay_order'], $order['order_sn']));
    }


    if ($order['bonus_id'] > 0 && $temp_amout > 0)
    {
        use_bonus($order['bonus_id'], $new_order_id);
    }

    /* ���ʹ�ÿ�棬���¶���ʱ����棬����ٿ�� */
    if ($_CFG['use_storage'] == '1' && $_CFG['stock_dec_time'] == SDT_PLACE)
    {
        change_order_goods_storage($order['order_id'], true, SDT_PLACE);
    }

    /* ���̼ҷ��ʼ� */
    /* �����Ƿ���ͷ������ʼ�ѡ�� */
    if ($_CFG['send_service_email'] && $_CFG['service_email'] != '')
    {
        $tpl = get_mail_template('remind_of_new_order');
        $smarty->assign('order', $order);
        $smarty->assign('goods_list', $cart_goods);
        $smarty->assign('shop_name', $_CFG['shop_name']);
        $smarty->assign('send_date', date($_CFG['time_format']));
        $content = $smarty->fetch('str:' . $tpl['template_content']);
        send_mail($_CFG['shop_name'], $_CFG['service_email'], $tpl['template_subject'], $content, $tpl['is_html']);
    }

    /* ����������Ϊ0 �������⿨ */
    if ($order['order_amount'] <= 0)
    {
        $sql = "SELECT goods_id, goods_name, goods_number AS num FROM ".
               $GLOBALS['ecs']->table('cart') .
                " WHERE is_real = 0 AND extension_code = 'virtual_card'".
                " AND session_id = '".SESS_ID."' AND rec_type = '$flow_type'";

        $res = $GLOBALS['db']->getAll($sql);

        $virtual_goods = array();
        foreach ($res AS $row)
        {
            $virtual_goods['virtual_card'][] = array('goods_id' => $row['goods_id'], 'goods_name' => $row['goods_name'], 'num' => $row['num']);
        }

        if ($virtual_goods AND $flow_type != CART_GROUP_BUY_GOODS)
        {
            /* ���⿨���� */
            if (virtual_goods_ship($virtual_goods,$msg, $order['order_sn'], true))
            {
                /* ���û��ʵ����Ʒ���޸ķ���״̬���ͻ��ֺͺ�� */
                $sql = "SELECT COUNT(*)" .
                        " FROM " . $ecs->table('order_goods') .
                        " WHERE order_id = '$order[order_id]' " .
                        " AND is_real = 1";
                if ($db->getOne($sql) <= 0)
                {
                    /* �޸Ķ���״̬ */
                    update_order($order['order_id'], array('shipping_status' => SS_SHIPPED, 'shipping_time' => gmtime()));

                    /* ��������û���Ϊ�գ�������֣��������û�������� */
                    if ($order['user_id'] > 0)
                    {
                        /* ȡ���û���Ϣ */
                        $user = user_info($order['user_id']);

                        /* ���㲢���Ż��� */
                        $integral = integral_to_give($order);
                        log_account_change($order['user_id'], 0, 0, intval($integral['rank_points']), intval($integral['custom_points']), sprintf($_LANG['order_gift_integral'], $order['order_sn']));

                        /* ���ź�� */
                        send_order_bonus($order['order_id']);
                    }
                }
            }
        }

    }

    /* ������棬����������Ʒ������ǰ̨ҳ���ȡ���棬��Ʒ���������� */
    clear_all_files();

    /* ����֧����־ */
    $order['log_id'] = insert_pay_log($new_order_id, $order['order_amount'], PAY_ORDER);

    /* ȡ��֧����Ϣ������֧������ */
    if ($order['order_amount'] > 0)
    {
        $payment = payment_info($order['pay_id']);

        include_once('includes/modules/payment/' . $payment['pay_code'] . '.php');

        $pay_obj    = new $payment['pay_code'];

        $pay_online = $pay_obj->get_code($order, unserialize_config($payment['pay_config']));

        $order['pay_desc'] = $payment['pay_desc'];

        $smarty->assign('pay_online', $pay_online);
    }
    if(!empty($order['shipping_name']))
    {
        $order['shipping_name']=trim(stripcslashes($order['shipping_name']));
    }

    /* ������Ϣ */
    $smarty->assign('order',      $order);
    //$smarty->assign('total',      $total);
    $smarty->assign('goods_list', $goods_info);
    $smarty->assign('order_submit_back', sprintf($_LANG['order_submit_back'], $_LANG['back_home'], $_LANG['goto_user_center'])); // ������ʾ

    user_uc_call('add_feed', array($order['order_id'], BUY_GOODS)); //����feed��uc
    unset($_SESSION['flow_consignee']); // ���session�б�����ջ�����Ϣ
    unset($_SESSION['flow_order']);
    unset($_SESSION['direct_shopping']);
	
}

else
{
    /* ��ǹ�������Ϊ��ͨ��Ʒ */
    $_SESSION['flow_type'] = CART_GENERAL_GOODS;

    /* �����һ����������������� */
    if ($_CFG['one_step_buy'] == '1')
    {
        ecs_header("Location: flow.php?step=checkout\n");
        exit;
    }

    /* ȡ����Ʒ�б�������ϼ� */
    $cart_goods = get_cart_goods();
    $smarty->assign('goods_list', $cart_goods['goods_list']);
    $smarty->assign('total', $cart_goods['total']);

    //���ﳵ�������ĸ�ʽ��
    $smarty->assign('shopping_money',         sprintf($_LANG['shopping_money'], $cart_goods['total']['goods_price']));
    $smarty->assign('market_price_desc',      sprintf($_LANG['than_market_price'],
        $cart_goods['total']['market_price'], $cart_goods['total']['saving'], $cart_goods['total']['save_rate']));

    // ��ʾ�ղؼ��ڵ���Ʒ
    if ($_SESSION['user_id'] > 0)
    {
        require_once(ROOT_PATH . 'includes/lib_clips.php');
        $collection_goods = get_collection_goods($_SESSION['user_id']);
        $smarty->assign('collection_goods', $collection_goods);
    }

    /* ȡ���Żݻ */
    $favourable_list = favourable_list($_SESSION['user_rank']);
    usort($favourable_list, 'cmp_favourable');

    $smarty->assign('favourable_list', $favourable_list);

    /* �����ۿ� */
    $discount = compute_discount();
    $smarty->assign('discount', $discount['discount']);
    $favour_name = empty($discount['name']) ? '' : join(',', $discount['name']);
    $smarty->assign('your_discount', sprintf($_LANG['your_discount'], $favour_name, price_format($discount['discount'])));

    /* �����Ƿ��ڹ��ﳵ����ʾ��Ʒͼ */
    $smarty->assign('show_goods_thumb', $GLOBALS['_CFG']['show_goods_in_cart']);

    /* �����Ƿ��ڹ��ﳵ����ʾ��Ʒ���� */
    $smarty->assign('show_goods_attribute', $GLOBALS['_CFG']['show_attr_in_cart']);

    /* ���ﳵ����Ʒ����б� */
    //ȡ�ù��ﳵ�л�����ID
    $sql = "SELECT goods_id " .
            "FROM " . $GLOBALS['ecs']->table('cart') .
            " WHERE session_id = '" . SESS_ID . "' " .
            "AND rec_type = '" . CART_GENERAL_GOODS . "' " .
            "AND is_gift = 0 " .
            "AND extension_code <> 'package_buy' " .
            "AND parent_id = 0 ";
    $parent_list = $GLOBALS['db']->getCol($sql);

    $fittings_list = get_goods_fittings($parent_list);

    $smarty->assign('fittings_list', $fittings_list);
}

$smarty->assign('currency_format', $_CFG['currency_format']);
$smarty->assign('integral_scale',  $_CFG['integral_scale']);
$smarty->assign('step',            $_REQUEST['step']);
assign_dynamic('shopping_flow');

$smarty->display('flow.dwt');

/*------------------------------------------------------ */
//-- PRIVATE FUNCTION
/*------------------------------------------------------ */

/**
 * ����û��Ŀ��û���
 *
 * @access  private
 * @return  integral
 */
function flow_available_points()
{
    $sql = "SELECT SUM(g.integral * c.goods_number) ".
            "FROM " . $GLOBALS['ecs']->table('cart') . " AS c, " . $GLOBALS['ecs']->table('goods') . " AS g " .
            "WHERE c.session_id = '" . SESS_ID . "' AND c.goods_id = g.goods_id AND c.is_gift = 0 AND g.integral > 0 " .
            "AND c.rec_type = '" . CART_GENERAL_GOODS . "'";

    $val = intval($GLOBALS['db']->getOne($sql));

    return integral_of_value($val);
}

/**
 * ���¹��ﳵ�е���Ʒ����
 *
 * @access  public
 * @param   array   $arr
 * @return  void
 */
function flow_update_cart($arr)
{
    /* ���� */
    foreach ($arr AS $key => $val)
    {
        $val = intval(make_semiangle($val));
        if ($val <= 0 || !is_numeric($key))
        {
            continue;
        }

        //��ѯ��
        $sql = "SELECT `goods_id`, `goods_attr_id`, `product_id`, `extension_code` FROM" .$GLOBALS['ecs']->table('cart').
               " WHERE rec_id='$key' AND session_id='" . SESS_ID . "'";
        $goods = $GLOBALS['db']->getRow($sql);

        $sql = "SELECT g.goods_name, g.goods_number ".
                "FROM " .$GLOBALS['ecs']->table('goods'). " AS g, ".
                    $GLOBALS['ecs']->table('cart'). " AS c ".
                "WHERE g.goods_id = c.goods_id AND c.rec_id = '$key'";
        $row = $GLOBALS['db']->getRow($sql);

        //��ѯ��ϵͳ�����˿�棬����������Ʒ�����Ƿ���Ч
        if (intval($GLOBALS['_CFG']['use_storage']) > 0 && $goods['extension_code'] != 'package_buy')
        {
            if ($row['goods_number'] < $val)
            {
                show_message(sprintf($GLOBALS['_LANG']['stock_insufficiency'], $row['goods_name'],
                $row['goods_number'], $row['goods_number']));
                exit;
            }
            /* �ǻ�Ʒ */
            $goods['product_id'] = trim($goods['product_id']);
            if (!empty($goods['product_id']))
            {
                $sql = "SELECT product_number FROM " .$GLOBALS['ecs']->table('products'). " WHERE goods_id = '" . $goods['goods_id'] . "' AND product_id = '" . $goods['product_id'] . "'";

                $product_number = $GLOBALS['db']->getOne($sql);
                if ($product_number < $val)
                {
                    show_message(sprintf($GLOBALS['_LANG']['stock_insufficiency'], $row['goods_name'],
                    $product_number['product_number'], $product_number['product_number']));
                    exit;
                }
            }
        }
        elseif (intval($GLOBALS['_CFG']['use_storage']) > 0 && $goods['extension_code'] == 'package_buy')
        {
            if (judge_package_stock($goods['goods_id'], $val))
            {
                show_message($GLOBALS['_LANG']['package_stock_insufficiency']);
                exit;
            }
        }

        /* ��ѯ���������Ƿ�Ϊ������ �Լ��Ƿ������� */
        /* �˴������ָ������Ʒʱ���ӵĲ������������Żݼ۸����� �����������parent_id goods_numberΪ1 */
        $sql = "SELECT b.goods_number, b.rec_id
                FROM " .$GLOBALS['ecs']->table('cart') . " a, " .$GLOBALS['ecs']->table('cart') . " b
                WHERE a.rec_id = '$key'
                AND a.session_id = '" . SESS_ID . "'
                AND a.extension_code <> 'package_buy'
                AND b.parent_id = a.goods_id
                AND b.session_id = '" . SESS_ID . "'";

        $offers_accessories_res = $GLOBALS['db']->query($sql);

        //������������0
        if ($val > 0)
        {
            /* �ж��Ƿ�Ϊ�����������Żݼ۸����� ɾ��*/
            $row_num = 1;
            while ($offers_accessories_row = $GLOBALS['db']->fetchRow($offers_accessories_res))
            {
                if ($row_num > $val)
                {
                    $sql = "DELETE FROM " . $GLOBALS['ecs']->table('cart') .
                            " WHERE session_id = '" . SESS_ID . "' " .
                            "AND rec_id = '" . $offers_accessories_row['rec_id'] ."' LIMIT 1";
                    $GLOBALS['db']->query($sql);
                }

                $row_num ++;
            }

            /* ������ֵ��� */
            if ($goods['extension_code'] == 'package_buy')
            {
                //���¹��ﳵ�е���Ʒ����
                $sql = "UPDATE " .$GLOBALS['ecs']->table('cart').
                        " SET goods_number = '$val' WHERE rec_id='$key' AND session_id='" . SESS_ID . "'";
            }
            /* ������ͨ��Ʒ����Żݵ���� */
            else
            {
                $attr_id    = empty($goods['goods_attr_id']) ? array() : explode(',', $goods['goods_attr_id']);
                $goods_price = get_final_price($goods['goods_id'], $val, true, $attr_id);

                //���¹��ﳵ�е���Ʒ����
                $sql = "UPDATE " .$GLOBALS['ecs']->table('cart').
                        " SET goods_number = '$val', goods_price = '$goods_price' WHERE rec_id='$key' AND session_id='" . SESS_ID . "'";
            }
        }
        //������������0
        else
        {
            /* ����ǻ������������Żݼ۸�������ɾ���Żݼ۸����� */
            while ($offers_accessories_row = $GLOBALS['db']->fetchRow($offers_accessories_res))
            {
                $sql = "DELETE FROM " . $GLOBALS['ecs']->table('cart') .
                        " WHERE session_id = '" . SESS_ID . "' " .
                        "AND rec_id = '" . $offers_accessories_row['rec_id'] ."' LIMIT 1";
                $GLOBALS['db']->query($sql);
            }

            $sql = "DELETE FROM " .$GLOBALS['ecs']->table('cart').
                " WHERE rec_id='$key' AND session_id='" .SESS_ID. "'";
        }

        $GLOBALS['db']->query($sql);
    }

    /* ɾ��������Ʒ */
    $sql = "DELETE FROM " . $GLOBALS['ecs']->table('cart') . " WHERE session_id = '" .SESS_ID. "' AND is_gift <> 0";
    $GLOBALS['db']->query($sql);
}

/**
 * ��鶩������Ʒ���
 *
 * @access  public
 * @param   array   $arr
 *
 * @return  void
 */
function flow_cart_stock($arr)
{
    foreach ($arr AS $key => $val)
    {
        $val = intval(make_semiangle($val));
        if ($val <= 0 || !is_numeric($key))
        {
            continue;
        }

        $sql = "SELECT `goods_id`, `goods_attr_id`, `extension_code` FROM" .$GLOBALS['ecs']->table('cart').
               " WHERE rec_id='$key' AND session_id='" . SESS_ID . "'";
        $goods = $GLOBALS['db']->getRow($sql);

        $sql = "SELECT g.goods_name, g.goods_number, c.product_id ".
                "FROM " .$GLOBALS['ecs']->table('goods'). " AS g, ".
                    $GLOBALS['ecs']->table('cart'). " AS c ".
                "WHERE g.goods_id = c.goods_id AND c.rec_id = '$key'";
        $row = $GLOBALS['db']->getRow($sql);

        //ϵͳ�����˿�棬����������Ʒ�����Ƿ���Ч
        if (intval($GLOBALS['_CFG']['use_storage']) > 0 && $goods['extension_code'] != 'package_buy')
        {
            if ($row['goods_number'] < $val)
            {
                show_message(sprintf($GLOBALS['_LANG']['stock_insufficiency'], $row['goods_name'],
                $row['goods_number'], $row['goods_number']));
                exit;
            }

            /* �ǻ�Ʒ */
            $row['product_id'] = trim($row['product_id']);
            if (!empty($row['product_id']))
            {
                $sql = "SELECT product_number FROM " .$GLOBALS['ecs']->table('products'). " WHERE goods_id = '" . $goods['goods_id'] . "' AND product_id = '" . $row['product_id'] . "'";
                $product_number = $GLOBALS['db']->getOne($sql);
                if ($product_number < $val)
                {
                    show_message(sprintf($GLOBALS['_LANG']['stock_insufficiency'], $row['goods_name'],
                    $row['goods_number'], $row['goods_number']));
                    exit;
                }
            }
        }
        elseif (intval($GLOBALS['_CFG']['use_storage']) > 0 && $goods['extension_code'] == 'package_buy')
        {
            if (judge_package_stock($goods['goods_id'], $val))
            {
                show_message($GLOBALS['_LANG']['package_stock_insufficiency']);
                exit;
            }
        }
    }

}

/**
 * ɾ�����ﳵ�е���Ʒ
 *
 * @access  public
 * @param   integer $id
 * @return  void
 */
function flow_drop_cart_goods($id)
{
    /* ȡ����Ʒid */
    $sql = "SELECT * FROM " .$GLOBALS['ecs']->table('cart'). " WHERE rec_id = '$id'";
    $row = $GLOBALS['db']->getRow($sql);
    if ($row)
    {
        //����ǳ�ֵ���
        if ($row['extension_code'] == 'package_buy')
        {
            $sql = "DELETE FROM " . $GLOBALS['ecs']->table('cart') .
                    " WHERE session_id = '" . SESS_ID . "' " .
                    "AND rec_id = '$id' LIMIT 1";
        }

        //�������ͨ��Ʒ��ͬʱɾ��������Ʒ�������
        elseif ($row['parent_id'] == 0 && $row['is_gift'] == 0)
        {
            /* ��鹺�ﳵ�и���ͨ��Ʒ�Ĳ��ɵ������۵������ɾ�� */
            $sql = "SELECT c.rec_id
                    FROM " . $GLOBALS['ecs']->table('cart') . " AS c, " . $GLOBALS['ecs']->table('group_goods') . " AS gg, " . $GLOBALS['ecs']->table('goods'). " AS g
                    WHERE gg.parent_id = '" . $row['goods_id'] . "'
                    AND c.goods_id = gg.goods_id
                    AND c.parent_id = '" . $row['goods_id'] . "'
                    AND c.extension_code <> 'package_buy'
                    AND gg.goods_id = g.goods_id
                    AND g.is_alone_sale = 0";
            $res = $GLOBALS['db']->query($sql);
            $_del_str = $id . ',';
            while ($id_alone_sale_goods = $GLOBALS['db']->fetchRow($res))
            {
                $_del_str .= $id_alone_sale_goods['rec_id'] . ',';
            }
            $_del_str = trim($_del_str, ',');

            $sql = "DELETE FROM " . $GLOBALS['ecs']->table('cart') .
                    " WHERE session_id = '" . SESS_ID . "' " .
                    "AND (rec_id IN ($_del_str) OR parent_id = '$row[goods_id]' OR is_gift <> 0)";
        }

        //���������ͨ��Ʒ��ֻɾ������Ʒ����
        else
        {
            $sql = "DELETE FROM " . $GLOBALS['ecs']->table('cart') .
                    " WHERE session_id = '" . SESS_ID . "' " .
                    "AND rec_id = '$id' LIMIT 1";
        }

        $GLOBALS['db']->query($sql);
		if($row['insure_id']){
			$GLOBALS['db']->query("DELETE FROM " . $GLOBALS['ecs']->table('insure') ." where insure_id='".$row['insure_id']."'");
		}
    }

    flow_clear_cart_alone();
}

/**
 * ɾ�����ﳵ�в��ܵ������۵���Ʒ
 *
 * @access  public
 * @return  void
 */
function flow_clear_cart_alone()
{
    /* ��ѯ�����ﳵ�����в����Ե������۵���� */
    $sql = "SELECT c.rec_id, gg.parent_id
            FROM " . $GLOBALS['ecs']->table('cart') . " AS c
                LEFT JOIN " . $GLOBALS['ecs']->table('group_goods') . " AS gg ON c.goods_id = gg.goods_id
                LEFT JOIN" . $GLOBALS['ecs']->table('goods') . " AS g ON c.goods_id = g.goods_id
            WHERE c.session_id = '" . SESS_ID . "'
            AND c.extension_code <> 'package_buy'
            AND gg.parent_id > 0
            AND g.is_alone_sale = 0";
    $res = $GLOBALS['db']->query($sql);
    $rec_id = array();
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        $rec_id[$row['rec_id']][] = $row['parent_id'];
    }

    if (empty($rec_id))
    {
        return;
    }

    /* ��ѯ�����ﳵ��������Ʒ */
    $sql = "SELECT DISTINCT goods_id
            FROM " . $GLOBALS['ecs']->table('cart') . "
            WHERE session_id = '" . SESS_ID . "'
            AND extension_code <> 'package_buy'";
    $res = $GLOBALS['db']->query($sql);
    $cart_good = array();
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        $cart_good[] = $row['goods_id'];
    }

    if (empty($cart_good))
    {
        return;
    }

    /* ������ﳵ�в����Ե�����������Ļ�������������ɾ������� */
    $del_rec_id = '';
    foreach ($rec_id as $key => $value)
    {
        foreach ($value as $v)
        {
            if (in_array($v, $cart_good))
            {
                continue 2;
            }
        }

        $del_rec_id = $key . ',';
    }
    $del_rec_id = trim($del_rec_id, ',');

    if ($del_rec_id == '')
    {
        return;
    }

    /* ɾ�� */
    $sql = "DELETE FROM " . $GLOBALS['ecs']->table('cart') ."
            WHERE session_id = '" . SESS_ID . "'
            AND rec_id IN ($del_rec_id)";
    $GLOBALS['db']->query($sql);
}

/**
 * �Ƚ��Żݻ�ĺ������������򣨰ѿ��õ�����ǰ�棩
 * @param   array   $a      �Żݻa
 * @param   array   $b      �Żݻb
 * @return  int     ��ȷ���0��С�ڷ���-1�����ڷ���1
 */
function cmp_favourable($a, $b)
{
    if ($a['available'] == $b['available'])
    {
        if ($a['sort_order'] == $b['sort_order'])
        {
            return 0;
        }
        else
        {
            return $a['sort_order'] < $b['sort_order'] ? -1 : 1;
        }
    }
    else
    {
        return $a['available'] ? -1 : 1;
    }
}

/**
 * ȡ��ĳ�û��ȼ���ǰʱ��������ܵ��Żݻ
 * @param   int     $user_rank      �û��ȼ�id��0��ʾ�ǻ�Ա
 * @return  array
 */
function favourable_list($user_rank)
{
    /* ���ﳵ�����е��Żݻ������ */
    $used_list = cart_favourable();

    /* ��ǰ�û������ܵ��Żݻ */
    $favourable_list = array();
    $user_rank = ',' . $user_rank . ',';
    $now = gmtime();
    $sql = "SELECT * " .
            "FROM " . $GLOBALS['ecs']->table('favourable_activity') .
            " WHERE CONCAT(',', user_rank, ',') LIKE '%" . $user_rank . "%'" .
            " AND start_time <= '$now' AND end_time >= '$now'" .
            " AND act_type = '" . FAT_GOODS . "'" .
            " ORDER BY sort_order";
    $res = $GLOBALS['db']->query($sql);
    while ($favourable = $GLOBALS['db']->fetchRow($res))
    {
        $favourable['start_time'] = local_date($GLOBALS['_CFG']['time_format'], $favourable['start_time']);
        $favourable['end_time']   = local_date($GLOBALS['_CFG']['time_format'], $favourable['end_time']);
        $favourable['formated_min_amount'] = price_format($favourable['min_amount'], false);
        $favourable['formated_max_amount'] = price_format($favourable['max_amount'], false);
        $favourable['gift']       = unserialize($favourable['gift']);

        foreach ($favourable['gift'] as $key => $value)
        {
            $favourable['gift'][$key]['formated_price'] = price_format($value['price'], false);
            $sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('goods') . " WHERE is_on_sale = 1 AND goods_id = ".$value['id'];
            $is_sale = $GLOBALS['db']->getOne($sql);
            if(!$is_sale)
            {
                unset($favourable['gift'][$key]);
            }
        }

        $favourable['act_range_desc'] = act_range_desc($favourable);
        $favourable['act_type_desc'] = sprintf($GLOBALS['_LANG']['fat_ext'][$favourable['act_type']], $favourable['act_type_ext']);

        /* �Ƿ������� */
        $favourable['available'] = favourable_available($favourable);
        if ($favourable['available'])
        {
            /* �Ƿ���δ���� */
            $favourable['available'] = !favourable_used($favourable, $used_list);
        }

        $favourable_list[] = $favourable;
    }

    return $favourable_list;
}

/**
 * ���ݹ��ﳵ�ж��Ƿ��������ĳ�Żݻ
 * @param   array   $favourable     �Żݻ��Ϣ
 * @return  bool
 */
function favourable_available($favourable)
{
    /* ��Ա�ȼ��Ƿ���� */
    $user_rank = $_SESSION['user_rank'];
    if (strpos(',' . $favourable['user_rank'] . ',', ',' . $user_rank . ',') === false)
    {
        return false;
    }

    /* �Żݷ�Χ�ڵ���Ʒ�ܶ� */
    $amount = cart_favourable_amount($favourable);

    /* �������Ϊ0��ʾû������ */
    return $amount >= $favourable['min_amount'] &&
        ($amount <= $favourable['max_amount'] || $favourable['max_amount'] == 0);
}

/**
 * ȡ���Żݷ�Χ����
 * @param   array   $favourable     �Żݻ
 * @return  string
 */
function act_range_desc($favourable)
{
    if ($favourable['act_range'] == FAR_BRAND)
    {
        $sql = "SELECT brand_name FROM " . $GLOBALS['ecs']->table('brand') .
                " WHERE brand_id " . db_create_in($favourable['act_range_ext']);
        return join(',', $GLOBALS['db']->getCol($sql));
    }
    elseif ($favourable['act_range'] == FAR_CATEGORY)
    {
        $sql = "SELECT cat_name FROM " . $GLOBALS['ecs']->table('category') .
                " WHERE cat_id " . db_create_in($favourable['act_range_ext']);
        return join(',', $GLOBALS['db']->getCol($sql));
    }
    elseif ($favourable['act_range'] == FAR_GOODS)
    {
        $sql = "SELECT goods_name FROM " . $GLOBALS['ecs']->table('goods') .
                " WHERE goods_id " . db_create_in($favourable['act_range_ext']);
        return join(',', $GLOBALS['db']->getCol($sql));
    }
    else
    {
        return '';
    }
}

/**
 * ȡ�ù��ﳵ�����е��Żݻ������
 * @return  array
 */
function cart_favourable()
{
    $list = array();
    $sql = "SELECT is_gift, COUNT(*) AS num " .
            "FROM " . $GLOBALS['ecs']->table('cart') .
            " WHERE session_id = '" . SESS_ID . "'" .
            " AND rec_type = '" . CART_GENERAL_GOODS . "'" .
            " AND is_gift > 0" .
            " GROUP BY is_gift";
    $res = $GLOBALS['db']->query($sql);
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        $list[$row['is_gift']] = $row['num'];
    }

    return $list;
}

/**
 * ���ﳵ���Ƿ��Ѿ���ĳ�Ż�
 * @param   array   $favourable     �Żݻ
 * @param   array   $cart_favourable���ﳵ�����е��Żݻ������
 */
function favourable_used($favourable, $cart_favourable)
{
    if ($favourable['act_type'] == FAT_GOODS)
    {
        return isset($cart_favourable[$favourable['act_id']]) &&
            $cart_favourable[$favourable['act_id']] >= $favourable['act_type_ext'] &&
            $favourable['act_type_ext'] > 0;
    }
    else
    {
        return isset($cart_favourable[$favourable['act_id']]);
    }
}

/**
 * �����Żݻ����Ʒ�������ﳵ
 * @param   int     $act_id     �Żݻid
 * @param   int     $id         ��Ʒid
 * @param   float   $price      ��Ʒ�۸�
 */
function add_gift_to_cart($act_id, $id, $price)
{
    $sql = "INSERT INTO " . $GLOBALS['ecs']->table('cart') . " (" .
                "user_id, session_id, goods_id, goods_sn, goods_name, market_price, goods_price, ".
                "goods_number, is_real, extension_code, parent_id, is_gift, rec_type ) ".
            "SELECT '$_SESSION[user_id]', '" . SESS_ID . "', goods_id, goods_sn, goods_name, market_price, ".
                "'$price', 1, is_real, extension_code, 0, '$act_id', '" . CART_GENERAL_GOODS . "' " .
            "FROM " . $GLOBALS['ecs']->table('goods') .
            " WHERE goods_id = '$id'";
    $GLOBALS['db']->query($sql);
}

/**
 * �����Żݻ������Ʒ�������ﳵ
 * @param   int     $act_id     �Żݻid
 * @param   string  $act_name   �Żݻname
 * @param   float   $amount     �Żݽ��
 */
function add_favourable_to_cart($act_id, $act_name, $amount)
{
    $sql = "INSERT INTO " . $GLOBALS['ecs']->table('cart') . "(" .
                "user_id, session_id, goods_id, goods_sn, goods_name, market_price, goods_price, ".
                "goods_number, is_real, extension_code, parent_id, is_gift, rec_type ) ".
            "VALUES('$_SESSION[user_id]', '" . SESS_ID . "', 0, '', '$act_name', 0, ".
                "'" . (-1) * $amount . "', 1, 0, '', 0, '$act_id', '" . CART_GENERAL_GOODS . "')";
    $GLOBALS['db']->query($sql);
}

/**
 * ȡ�ù��ﳵ��ĳ�Żݻ��Χ�ڵ��ܽ��
 * @param   array   $favourable     �Żݻ
 * @return  float
 */
function cart_favourable_amount($favourable)
{
    /* ��ѯ�Żݷ�Χ����Ʒ�ܶ��sql */
    $sql = "SELECT SUM(c.goods_price * c.goods_number) " .
            "FROM " . $GLOBALS['ecs']->table('cart') . " AS c, " . $GLOBALS['ecs']->table('goods') . " AS g " .
            "WHERE c.goods_id = g.goods_id " .
            "AND c.session_id = '" . SESS_ID . "' " .
            "AND c.rec_type = '" . CART_GENERAL_GOODS . "' " .
            "AND c.is_gift = 0 " .
            "AND c.goods_id > 0 ";

    /* �����Żݷ�Χ����sql */
    if ($favourable['act_range'] == FAR_ALL)
    {
        // sql do not change
    }
    elseif ($favourable['act_range'] == FAR_CATEGORY)
    {
        /* ȡ���Żݷ�Χ����������¼����� */
        $id_list = array();
        $cat_list = explode(',', $favourable['act_range_ext']);
        foreach ($cat_list as $id)
        {
            $id_list = array_merge($id_list, array_keys(cat_list(intval($id), 0, false)));
        }

        $sql .= "AND g.cat_id " . db_create_in($id_list);
    }
    elseif ($favourable['act_range'] == FAR_BRAND)
    {
        $id_list = explode(',', $favourable['act_range_ext']);

        $sql .= "AND g.brand_id " . db_create_in($id_list);
    }
    else
    {
        $id_list = explode(',', $favourable['act_range_ext']);

        $sql .= "AND g.goods_id " . db_create_in($id_list);
    }

    /* �Żݷ�Χ�ڵ���Ʒ�ܶ� */
    return $GLOBALS['db']->getOne($sql);
}
?>