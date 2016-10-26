<?php

/**
 * ECSHOP ��Ʒҳ
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liuhui $
 * $Id: order.php 15013 2008-10-23 09:31:42Z liuhui $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require(ROOT_PATH . 'includes/lib_order.php');
require(ROOT_PATH . 'includes/lib_payment.php');

$flow_type = 0;
    $_LANG['gram'] = '��';
    $_LANG['kilogram'] = 'ǧ��';
    $tips = '�����Ѿ����ɣ�������Ѿ���½���������û����Ĳ鿴��������!';

if ($_SESSION['user_id'] > 0)
{
    $smarty->assign('user_name', $_SESSION['user_name']);
}

if($_REQUEST['act'] == 'order_lise')
{
    if(empty($_POST['country']) || empty($_POST['province']) || empty($_POST['city']))
    {
        echo '�������򲻿�Ϊ�գ�';
        exit;
    }
    if(empty($_POST['consignee']))
    {
        echo '�ջ�����������Ϊ�գ�';
        exit;
    }
    if(empty($_POST['email']))
    {
        echo 'email����Ϊ�գ�';
        exit;
    }
    if(empty($_POST['address']))
    {
        echo '��ϸ��ַ����Ϊ�գ�';
        exit;
    }
    if(empty($_POST['zipcode']))
    {
        echo '�ʱ಻��Ϊ�գ�';
        exit;
    }
    if(empty($_POST['tel']))
    {
        echo '�绰����Ϊ�գ�';
        exit;
    }
        /*
         * �����ջ�����Ϣ
         */
        $consignee = array(
            'address_id'    => empty($_POST['address_id']) ? 0  : intval($_POST['address_id']),
            'consignee'     => empty($_POST['consignee'])  ? '' : compile_str(trim($_POST['consignee'])),
            'country'       => empty($_POST['country'])    ? '' : intval($_POST['country']),
            'province'      => empty($_POST['province'])   ? '' : intval($_POST['province']),
            'city'          => empty($_POST['city'])       ? '' : intval($_POST['city']),
            'district'      => empty($_POST['district'])   ? '' : intval($_POST['district']),
            'email'         => empty($_POST['email'])      ? '' : compile_str($_POST['email']),
            'address'       => empty($_POST['address'])    ? '' : compile_str($_POST['address']),
            'zipcode'       => empty($_POST['zipcode'])    ? '' : compile_str(make_semiangle(trim($_POST['zipcode']))),
            'tel'           => empty($_POST['tel'])        ? '' : compile_str(make_semiangle(trim($_POST['tel']))),
            'mobile'        => empty($_POST['mobile'])     ? '' : compile_str(make_semiangle(trim($_POST['mobile']))),
            'sign_building' => empty($_POST['sign_building']) ? '' : compile_str($_POST['sign_building']),
            'best_time'     => empty($_POST['best_time'])  ? '' : compile_str($_POST['best_time']),
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

    /* ��鹺�ﳵ���Ƿ�����Ʒ */
    $sql = "SELECT COUNT(*) FROM " . $ecs->table('cart') .
        " WHERE session_id = '" . SESS_ID . "' " .
        "AND parent_id = 0 AND is_gift = 0 AND rec_type = '$flow_type'";

    if ($db->getOne($sql) == 0)
    {
        $tips = '���Ĺ��ﳵ��û����Ʒ';
    }

    $consignee = get_consignee($_SESSION['user_id']);

    $_SESSION['flow_consignee'] = $consignee;
    $smarty->assign('consignee', $consignee);

    /* ����Ʒ��Ϣ��ֵ */
    $cart_goods = cart_goods($flow_type); // ȡ����Ʒ�б�����ϼ�
    $smarty->assign('goods_list', $cart_goods);



    /*
     * ȡ�ö�����Ϣ
     */
    $order = flow_order_info();
    $smarty->assign('order', $order);

    $_LANG['shopping_money'] = '������С�� %s';
    $_LANG['than_market_price'] = '���г��� %s ��ʡ�� %s (%s)';
    /*
     * ���㶩���ķ���
     */
    $total = order_fee($order, $cart_goods, $consignee);
    $smarty->assign('shopping_money', sprintf($_LANG['shopping_money'], $total['formated_goods_price']));
    $smarty->assign('market_price_desc', sprintf($_LANG['than_market_price'], $total['formated_market_price'], $total['formated_saving'], $total['save_rate']));

    $smarty->assign('total', $total);

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

    /* ���� session */
    $_SESSION['flow_order'] = $order;

    $smarty->assign('footer', get_footer());
    $smarty->display('order.html');
    exit;
}
elseif($_REQUEST['act'] = 'done')
{
    /*------------------------------------------------------ */
    //-- ������ж����������ύ�����ݿ�
    /*------------------------------------------------------ */

    include_once('includes/lib_clips.php');

    /* ��鹺�ﳵ���Ƿ�����Ʒ */
    $sql = "SELECT COUNT(*) FROM " . $ecs->table('cart') .
        " WHERE session_id = '" . SESS_ID . "' " .
        "AND parent_id = 0 AND is_gift = 0 AND rec_type = '$flow_type'";
    if ($db->getOne($sql) == 0)
    {
        $tips = '���Ĺ��ﳵ��û����Ʒ';

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



    $consignee = get_consignee($_SESSION['user_id']);



    $_POST['how_oos'] = isset($_POST['how_oos']) ? intval($_POST['how_oos']) : 0;
    $_POST['card_message'] = isset($_POST['card_message']) ? htmlspecialchars($_POST['card_message']) : '';
    $_POST['inv_type'] = !empty($_POST['inv_type']) ? htmlspecialchars($_POST['inv_type']) : '';
    $_POST['inv_payee'] = isset($_POST['inv_payee']) ? htmlspecialchars($_POST['inv_payee']) : '';
    $_POST['inv_content'] = isset($_POST['inv_content']) ? htmlspecialchars($_POST['inv_content']) : '';
    $_POST['postscript'] = isset($_POST['postscript']) ? htmlspecialchars($_POST['postscript']) : '';

    $order = array(
        'shipping_id'     => intval($_POST['shipping']),
        'pay_id'          => isset($_POST['payment']) ? intval($_POST['payment']) : '0',
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


    /* �����е���Ʒ */
    $cart_goods = cart_goods($flow_type);

    if (empty($cart_goods))
    {
        $tips = '���Ĺ��ﳵ��û����Ʒ';
    }


    /* �ջ�����Ϣ */
    foreach ($consignee as $key => $value)
    {
        $order[$key] = addslashes($value);
    }

    /* �����е��ܶ� */
    $total = order_fee($order, $cart_goods, $consignee);

    $order['bonus']        = $total['bonus'];
    $order['goods_amount'] = $total['goods_price'];
    $order['discount']     = $total['discount'];
    $order['surplus']      = $total['surplus'];
    $order['tax']          = $total['tax'];


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

    $order['integral_money']   = $total['integral_money'];
    $order['integral']         = $total['integral'];

    if ($order['extension_code'] == 'exchange_goods')
    {
        $order['integral_money']   = 0;
        $order['integral']         = $total['exchange_integral'];
    }

    $order['from_ad']          = !empty($_SESSION['from_ad']) ? $_SESSION['from_ad'] : '0';
    $order['referer']          = !empty($_SESSION['referer']) ? addslashes($_SESSION['referer']) : '';
    
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
            $tips = '����������֧��������������δ���ʽ�µ�';

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
                "order_id, goods_id, goods_name, goods_sn, goods_number, market_price, ".
                "goods_price, goods_attr, is_real, extension_code, parent_id, is_gift, goods_attr_id) ".
            " SELECT '$new_order_id', goods_id, goods_name, goods_sn, goods_number, market_price, ".
                "goods_price, goods_attr, is_real, extension_code, parent_id, is_gift, goods_attr_id".
            " FROM " .$ecs->table('cart') .
            " WHERE session_id = '".SESS_ID."' AND rec_type = '$flow_type'";
    $db->query($sql);


    /* ���������֡���� */
    if ($order['user_id'] > 0 && $order['surplus'] > 0)
    {
        log_account_change($order['user_id'], $order['surplus'] * (-1), 0, 0, 0, sprintf('֧������ %s', $order['order_sn']));
    }
    if ($order['user_id'] > 0 && $order['integral'] > 0)
    {
        log_account_change($order['user_id'], 0, 0, 0, $order['integral'] * (-1), sprintf('֧������ %s', $order['order_sn']));
    }
    /* ���ʹ�ÿ�棬���¶���ʱ����棬����ٿ�� */
    if ($_CFG['use_storage'] == '1' && $_CFG['stock_dec_time'] == SDT_PLACE)
    {
        change_order_goods_storage($order['order_id'], true, SDT_PLACE);
    }


    /* ��չ��ﳵ */
    clear_cart($flow_type);
    /* ������棬����������Ʒ������ǰ̨ҳ���ȡ���棬��Ʒ���������� */
    clear_all_files();

    if(!empty($order['shipping_name']))
    {
        $order['shipping_name']=trim(stripcslashes($order['shipping_name']));
    }
    /* ȡ��֧����Ϣ������֧������ */
    if ($order['order_amount'] > 0)
    {
        $payment = payment_info($order['pay_id']);

        include_once('includes/modules/payment/' . $payment['pay_code'] . '.php');

        $pay_obj    = new $payment['pay_code'];
        $order['log_id'] = insert_pay_log($new_order_id, $order['order_amount'], PAY_ORDER);
        $pay_online = $pay_obj->get_code($order, unserialize_config($payment['pay_config']));

        $order['pay_desc'] = $payment['pay_desc'];

        $smarty->assign('pay_online', $pay_online);
    }

    /* ������Ϣ */
    $smarty->assign('order',      $order);
    $smarty->assign('total',      $total);
    $smarty->assign('goods_list', $cart_goods);
    $smarty->assign('order_submit_back', sprintf('������ %s ��ȥ %s', '<a href="index.php">������ҳ</a>', '<a href="user.php">�û�����</a>')); // ������ʾ

    unset($_SESSION['flow_consignee']); // ���session�б�����ջ�����Ϣ
    unset($_SESSION['flow_order']);
    unset($_SESSION['direct_shopping']);

    if ($_SESSION['user_id'] > 0)
    {
        $smarty->assign('user_name', $_SESSION['user_name']);
    }
    $smarty->assign('footer', get_footer());
    $smarty->assign('tips', $tips);
    $smarty->display('order_done.html');
    exit;

}

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
        if ($val <= 0)
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
?>