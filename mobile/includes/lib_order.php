<?php

/**
 * ECSHOP �������̺�����
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: lib_order.php 17217 2011-01-19 06:29:08Z liubo $
 */

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

/**
 * �������л���֧�������͵����ò���
 * ����һ����nameΪ����������
 *
 * @access  public
 * @param   string       $cfg
 * @return  void
 */
function unserialize_config($cfg)
{
    if (is_string($cfg) && ($arr = unserialize($cfg)) !== false)
    {
        $config = array();

        foreach ($arr AS $key => $val)
        {
            $config[$val['name']] = $val['value'];
        }

        return $config;
    }
    else
    {
        return false;
    }
}
/**
 * ȡ���Ѱ�װ�����ͷ�ʽ
 * @return  array   �Ѱ�װ�����ͷ�ʽ
 */
function shipping_list()
{
    $sql = 'SELECT shipping_id, shipping_name ' .
            'FROM ' . $GLOBALS['ecs']->table('shipping') .
            ' WHERE enabled = 1';

    return $GLOBALS['db']->getAll($sql);
}

/**
 * ȡ�����ͷ�ʽ��Ϣ
 * @param   int     $shipping_id    ���ͷ�ʽid
 * @return  array   ���ͷ�ʽ��Ϣ
 */
function shipping_info($shipping_id)
{
    $sql = 'SELECT * FROM ' . $GLOBALS['ecs']->table('shipping') .
            " WHERE shipping_id = '$shipping_id' " .
            'AND enabled = 1';

    return $GLOBALS['db']->getRow($sql);
}

/**
 * ȡ�ÿ��õ����ͷ�ʽ�б�
 * @param   array   $region_id_list     �ջ��˵���id���飨�������ҡ�ʡ���С�����
 * @return  array   ���ͷ�ʽ����
 */
function available_shipping_list($region_id_list)
{
    $sql = 'SELECT s.shipping_id, s.shipping_code, s.shipping_name, ' .
                's.shipping_desc, s.insure, s.support_cod, a.configure ' .
            'FROM ' . $GLOBALS['ecs']->table('shipping') . ' AS s, ' .
                $GLOBALS['ecs']->table('shipping_area') . ' AS a, ' .
                $GLOBALS['ecs']->table('area_region') . ' AS r ' .
            'WHERE r.region_id ' . db_create_in($region_id_list) .
            ' AND r.shipping_area_id = a.shipping_area_id AND a.shipping_id = s.shipping_id AND s.enabled = 1 ORDER BY s.shipping_order';

    return $GLOBALS['db']->getAll($sql);
}

/**
 * ȡ��ĳ���ͷ�ʽ��Ӧ��ĳ�ջ���ַ��������Ϣ
 * @param   int     $shipping_id        ���ͷ�ʽid
 * @param   array   $region_id_list     �ջ��˵���id����
 * @return  array   ����������Ϣ��config ��Ӧ�ŷ����л��� configure��
 */
function shipping_area_info($shipping_id, $region_id_list)
{
    $sql = 'SELECT s.shipping_code, s.shipping_name, ' .
                's.shipping_desc, s.insure, s.support_cod, a.configure ' .
            'FROM ' . $GLOBALS['ecs']->table('shipping') . ' AS s, ' .
                $GLOBALS['ecs']->table('shipping_area') . ' AS a, ' .
                $GLOBALS['ecs']->table('area_region') . ' AS r ' .
            "WHERE s.shipping_id = '$shipping_id' " .
            'AND r.region_id ' . db_create_in($region_id_list) .
            ' AND r.shipping_area_id = a.shipping_area_id AND a.shipping_id = s.shipping_id AND s.enabled = 1';
    $row = $GLOBALS['db']->getRow($sql);

    if (!empty($row))
    {
        $shipping_config = unserialize_config($row['configure']);
        if (isset($shipping_config['pay_fee']))
        {
            if (strpos($shipping_config['pay_fee'], '%') !== false)
            {
                $row['pay_fee'] = floatval($shipping_config['pay_fee']) . '%';
            }
            else
            {
                 $row['pay_fee'] = floatval($shipping_config['pay_fee']);
            }
        }
        else
        {
            $row['pay_fee'] = 0.00;
        }
    }

    return $row;
}

/**
 * �����˷�
 * @param   string  $shipping_code      ���ͷ�ʽ����
 * @param   mix     $shipping_config    ���ͷ�ʽ������Ϣ
 * @param   float   $goods_weight       ��Ʒ����
 * @param   float   $goods_amount       ��Ʒ���
 * @param   float   $goods_number       ��Ʒ����
 * @return  float   �˷�
 */
function shipping_fee($shipping_code, $shipping_config, $goods_weight, $goods_amount, $goods_number='')
{
    if (!is_array($shipping_config))
    {
        $shipping_config = unserialize($shipping_config);
    }

    $filename = ROOT_PATH . 'includes/modules/shipping/' . $shipping_code . '.php';
    if (file_exists($filename))
    {
        include_once($filename);

        $obj = new $shipping_code($shipping_config);

        return $obj->calculate($goods_weight, $goods_amount, $goods_number);
    }
    else
    {
        return 0;
    }
}

/**
 * ��ȡָ�����͵ı��۷���
 *
 * @access  public
 * @param   string      $shipping_code  ���ͷ�ʽ��code
 * @param   float       $goods_amount   ���۽��
 * @param   mix         $insure         ���۱���
 * @return  float
 */
function shipping_insure_fee($shipping_code, $goods_amount, $insure)
{
    if (strpos($insure, '%') === false)
    {
        /* ������۷��ò��ǰٷֱ���ֱ�ӷ��ظ���ֵ */
        return floatval($insure);
    }
    else
    {
        $path = ROOT_PATH . 'includes/modules/shipping/' . $shipping_code . '.php';

        if (file_exists($path))
        {
            include_once($path);

            $shipping = new $shipping_code;
            $insure   = floatval($insure) / 100;

            if (method_exists($shipping, 'calculate_insure'))
            {
                return $shipping->calculate_insure($goods_amount, $insure);
            }
            else
            {
                return ceil($goods_amount * $insure);
            }
        }
        else
        {
            return false;
        }
    }
}

/**
 * ȡ���Ѱ�װ��֧����ʽ�б�
 * @return  array   �Ѱ�װ�����ͷ�ʽ�б�
 */
function payment_list()
{
    $sql = 'SELECT pay_id, pay_name ' .
            'FROM ' . $GLOBALS['ecs']->table('payment') .
            ' WHERE enabled = 1';

    return $GLOBALS['db']->getAll($sql);
}

/**
 * ȡ��֧����ʽ��Ϣ
 * @param   int     $pay_id     ֧����ʽid
 * @return  array   ֧����ʽ��Ϣ
 */
function payment_info($pay_id)
{
    $sql = 'SELECT * FROM ' . $GLOBALS['ecs']->table('payment') .
            " WHERE pay_id = '$pay_id' AND enabled = 1";

    return $GLOBALS['db']->getRow($sql);
}

/**
 * ��ö�����Ҫ֧����֧������
 *
 * @access  public
 * @param   integer $payment_id
 * @param   float   $order_amount
 * @param   mix     $cod_fee
 * @return  float
 */
function pay_fee($payment_id, $order_amount, $cod_fee=null)
{
    $pay_fee = 0;
    $payment = payment_info($payment_id);
    $rate    = ($payment['is_cod'] && !is_null($cod_fee)) ? $cod_fee : $payment['pay_fee'];

    if (strpos($rate, '%') !== false)
    {
        /* ֧��������һ������ */
        $val     = floatval($rate) / 100;
        $pay_fee = $val > 0 ? $order_amount * $val /(1- $val) : 0;
    }
    else
    {
        $pay_fee = floatval($rate);
    }

    return round($pay_fee, 2);
}

/**
 * ȡ�ÿ��õ�֧����ʽ�б�
 * @param   bool    $support_cod        ���ͷ�ʽ�Ƿ�֧�ֻ�������
 * @param   int     $cod_fee            �������������ѣ������ͷ�ʽ֧�ֻ�������ʱ�Ŵ��˲�����
 * @param   int     $is_online          �Ƿ�֧������֧��
 * @return  array   ���ͷ�ʽ����
 */
function available_payment_list($support_cod, $cod_fee = 0, $is_online = false)
{
    $sql = 'SELECT pay_id, pay_code, pay_name, pay_fee, pay_desc, pay_config, is_cod' .
            ' FROM ' . $GLOBALS['ecs']->table('payment') .
            ' WHERE enabled = 1 ';
    if (!$support_cod)
    {
        $sql .= 'AND is_cod = 0 '; // �����֧�ֻ�������
    }
    if ($is_online)
    {
        $sql .= "AND is_online = '1' ";
    }
    $sql .= 'ORDER BY pay_order'; // ����
    $res = $GLOBALS['db']->query($sql);

    $pay_list = array();
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        if ($row['is_cod'] == '1')
        {
            $row['pay_fee'] = $cod_fee;
        }

        $row['format_pay_fee'] = strpos($row['pay_fee'], '%') !== false ? $row['pay_fee'] :
        price_format($row['pay_fee'], false);
        $modules[] = $row;
    }

    include_once(ROOT_PATH.'includes/lib_compositor.php');

    if(isset($modules))
    {
        return $modules;
    }
}

/**
 * ȡ�ð�װ�б�
 * @return  array   ��װ�б�
 */
function pack_list()
{
    $sql = 'SELECT * FROM ' . $GLOBALS['ecs']->table('pack');
    $res = $GLOBALS['db']->query($sql);

    $list = array();
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        $row['format_pack_fee'] = price_format($row['pack_fee'], false);
        $row['format_free_money'] = price_format($row['free_money'], false);
        $list[] = $row;
    }

    return $list;
}

/**
 * ȡ�ð�װ��Ϣ
 * @param   int     $pack_id    ��װid
 * @return  array   ��װ��Ϣ
 */
function pack_info($pack_id)
{
    $sql = "SELECT * FROM " . $GLOBALS['ecs']->table('pack') .
            " WHERE pack_id = '$pack_id'";

    return $GLOBALS['db']->getRow($sql);
}

/**
 * ���ݶ����е���Ʒ�ܶ�����ð�װ�ķ���
 *
 * @access  public
 * @param   integer $pack_id
 * @param   float   $goods_amount
 * @return  float
 */
function pack_fee($pack_id, $goods_amount)
{
    $pack = pack_info($pack_id);

    $val = (floatval($pack['free_money']) <= $goods_amount && $pack['free_money'] > 0) ? 0 : floatval($pack['pack_fee']);

    return $val;
}

/**
 * ȡ�úؿ��б�
 * @return  array   �ؿ��б�
 */
function card_list()
{
    $sql = "SELECT * FROM " . $GLOBALS['ecs']->table('card');
    $res = $GLOBALS['db']->query($sql);

    $list = array();
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        $row['format_card_fee'] = price_format($row['card_fee'], false);
        $row['format_free_money'] = price_format($row['free_money'], false);
        $list[] = $row;
    }

    return $list;
}

/**
 * ȡ�úؿ���Ϣ
 * @param   int     $card_id    �ؿ�id
 * @return  array   �ؿ���Ϣ
 */
function card_info($card_id)
{
    $sql = "SELECT * FROM " . $GLOBALS['ecs']->table('card') .
            " WHERE card_id = '$card_id'";

    return $GLOBALS['db']->getRow($sql);
}

/**
 * ���ݶ�������Ʒ�ܶ�����Ҫ֧���ĺؿ�����
 *
 * @access  public
 * @param   integer $card_id
 * @param   float   $goods_amount
 * @return  float
 */
function card_fee($card_id, $goods_amount)
{
    $card = card_info($card_id);

    return ($card['free_money'] <= $goods_amount && $card['free_money'] > 0) ? 0 : $card['card_fee'];
}

/**
 * ȡ�ö�����Ϣ
 * @param   int     $order_id   ����id�����order_id > 0 �Ͱ�id�飬����sn�飩
 * @param   string  $order_sn   ������
 * @return  array   ������Ϣ��������Ӧ��ʽ�����ֶΣ�ǰ׺��formated_��
 */
function order_info($order_id, $order_sn = '')
{
    /* ���㶩�����ַ���֮�͵���� */
    $total_fee = " (goods_amount - discount + tax + shipping_fee + insure_fee + pay_fee + pack_fee + card_fee) AS total_fee ";
    $order_id = intval($order_id);
    if ($order_id > 0)
    {
        $sql = "SELECT *, " . $total_fee . " FROM " . $GLOBALS['ecs']->table('order_info') .
                " WHERE order_id = '$order_id'";
    }
    else
    {
        $sql = "SELECT *, " . $total_fee . "  FROM " . $GLOBALS['ecs']->table('order_info') .
                " WHERE order_sn = '$order_sn'";
    }
    $order = $GLOBALS['db']->getRow($sql);

    /* ��ʽ������ֶ� */
    if ($order)
    {
        $order['formated_goods_amount']   = price_format($order['goods_amount'], false);
        $order['formated_discount']       = price_format($order['discount'], false);
        $order['formated_tax']            = price_format($order['tax'], false);
        $order['formated_shipping_fee']   = price_format($order['shipping_fee'], false);
        $order['formated_insure_fee']     = price_format($order['insure_fee'], false);
        $order['formated_pay_fee']        = price_format($order['pay_fee'], false);
        $order['formated_pack_fee']       = price_format($order['pack_fee'], false);
        $order['formated_card_fee']       = price_format($order['card_fee'], false);
        $order['formated_total_fee']      = price_format($order['total_fee'], false);
        $order['formated_money_paid']     = price_format($order['money_paid'], false);
        $order['formated_bonus']          = price_format($order['bonus'], false);
        $order['formated_integral_money'] = price_format($order['integral_money'], false);
        $order['formated_surplus']        = price_format($order['surplus'], false);
        $order['formated_order_amount']   = price_format(abs($order['order_amount']), false);
        $order['formated_add_time']       = local_date($GLOBALS['_CFG']['time_format'], $order['add_time']);
    }

    return $order;
}

/**
 * �ж϶����Ƿ������
 * @param   array   $order  ������Ϣ
 * @return  bool
 */
function order_finished($order)
{
    return $order['order_status']  == OS_CONFIRMED &&
        ($order['shipping_status'] == SS_SHIPPED || $order['shipping_status'] == SS_RECEIVED) &&
        ($order['pay_status']      == PS_PAYED   || $order['pay_status'] == PS_PAYING);
}

/**
 * ȡ�ö�����Ʒ
 * @param   int     $order_id   ����id
 * @return  array   ������Ʒ����
 */
function order_goods($order_id)
{
    $sql = "SELECT rec_id, goods_id, goods_name, goods_sn, market_price, goods_number, " .
            "goods_price, goods_attr, is_real, parent_id, is_gift, " .
            "goods_price * goods_number AS subtotal, extension_code " .
            "FROM " . $GLOBALS['ecs']->table('order_goods') .
            " WHERE order_id = '$order_id'";

    $res = $GLOBALS['db']->query($sql);

    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        if ($row['extension_code'] == 'package_buy')
        {
            $row['package_goods_list'] = get_package_goods($row['goods_id']);
        }
        $goods_list[] = $row;
    }

    //return $GLOBALS['db']->getAll($sql);
    return $goods_list;
}

/**
 * ȡ�ö����ܽ��
 * @param   int     $order_id   ����id
 * @param   bool    $include_gift   �Ƿ������Ʒ
 * @return  float   �����ܽ��
 */
function order_amount($order_id, $include_gift = true)
{
    $sql = "SELECT SUM(goods_price * goods_number) " .
            "FROM " . $GLOBALS['ecs']->table('order_goods') .
            " WHERE order_id = '$order_id'";
    if (!$include_gift)
    {
        $sql .= " AND is_gift = 0";
    }

    return floatval($GLOBALS['db']->getOne($sql));
}

/**
 * ȡ��ĳ������Ʒ���������ܽ���Ӧ cart_weight_price��
 * @param   int     $order_id   ����id
 * @return  array   ('weight' => **, 'amount' => **, 'formated_weight' => **)
 */
function order_weight_price($order_id)
{
    $sql = "SELECT SUM(g.goods_weight * o.goods_number) AS weight, " .
                "SUM(o.goods_price * o.goods_number) AS amount ," .
                "SUM(o.goods_number) AS number " .
            "FROM " . $GLOBALS['ecs']->table('order_goods') . " AS o, " .
                $GLOBALS['ecs']->table('goods') . " AS g " .
            "WHERE o.order_id = '$order_id' " .
            "AND o.goods_id = g.goods_id";

    $row = $GLOBALS['db']->getRow($sql);
    $row['weight'] = floatval($row['weight']);
    $row['amount'] = floatval($row['amount']);
    $row['number'] = intval($row['number']);

    /* ��ʽ������ */
    $row['formated_weight'] = formated_weight($row['weight']);

    return $row;
}

/**
 * ��ö����еķ�����Ϣ
 *
 * @access  public
 * @param   array   $order
 * @param   array   $goods
 * @param   array   $consignee
 * @param   bool    $is_gb_deposit  �Ƿ��Ź���֤������ǣ�Ӧ������ֻ������Ʒ�ܶ��֧�����ã����Ի�õĻ���ȡ $gift_integral��
 * @return  array
 */
function order_fee($order, $goods, $consignee)
{
    /* ��ʼ����������չcode */
    if (!isset($order['extension_code']))
    {
        $order['extension_code'] = '';
    }

    if ($order['extension_code'] == 'group_buy')
    {
        $group_buy = group_buy_info($order['extension_id']);
    }

    $total  = array('real_goods_count' => 0,
                    'gift_amount'      => 0,
                    'goods_price'      => 0,
                    'market_price'     => 0,
                    'discount'         => 0,
                    'pack_fee'         => 0,
                    'card_fee'         => 0,
                    'shipping_fee'     => 0,
                    'shipping_insure'  => 0,
                    'integral_money'   => 0,
                    'bonus'            => 0,
                    'surplus'          => 0,
                    'cod_fee'          => 0,
                    'pay_fee'          => 0,
                    'tax'              => 0);
    $weight = 0;

    /* ��Ʒ�ܼ� */
    //foreach ($goods AS $val)
    //{
        /* ͳ��ʵ����Ʒ�ĸ��� */
        if ($val['is_real'])
        {
            $total['real_goods_count']++;
        }

        $total['goods_price']  += $goods['goods_price'] * $goods['goods_number'];
        $total['market_price'] += $goods['market_price'] * $goods['goods_number'];
    //}

    $total['saving']    = $total['market_price'] - $total['goods_price'];
    $total['save_rate'] = $total['market_price'] ? round($total['saving'] * 100 / $total['market_price']) . '%' : 0;

    $total['goods_price_formated']  = price_format($total['goods_price'], false);
    $total['market_price_formated'] = price_format($total['market_price'], false);
    $total['saving_formated']       = price_format($total['saving'], false);

    /* �ۿ� */
    if ($order['extension_code'] != 'group_buy')
    {
        $discount = compute_discount();
        $total['discount'] = $discount['discount'];
        if ($total['discount'] > $total['goods_price'])
        {
            $total['discount'] = $total['goods_price'];
        }
    }
    $total['discount_formated'] = price_format($total['discount'], false);

    /* ˰�� */
    if (!empty($order['need_inv']) && $order['inv_type'] != '')
    {
        /* ��˰�� */
        $rate = 0;
        foreach ($GLOBALS['_CFG']['invoice_type']['type'] as $key => $type)
        {
            if ($type == $order['inv_type'])
            {
                $rate = floatval($GLOBALS['_CFG']['invoice_type']['rate'][$key]) / 100;
                break;
            }
        }
        if ($rate > 0)
        {
            $total['tax'] = $rate * $total['goods_price'];
        }
    }
    $total['tax_formated'] = price_format($total['tax'], false);

    /* ��װ���� */
    if (!empty($order['pack_id']))
    {
        $total['pack_fee']      = pack_fee($order['pack_id'], $total['goods_price']);
    }
    $total['pack_fee_formated'] = price_format($total['pack_fee'], false);

    /* �ؿ����� */
    if (!empty($order['card_id']))
    {
        $total['card_fee']      = card_fee($order['card_id'], $total['goods_price']);
    }
    $total['card_fee_formated'] = price_format($total['card_fee'], false);

    /* ��� */

    if (!empty($order['bonus_id']))
    {
        $bonus          = bonus_info($order['bonus_id']);
        $total['bonus'] = $bonus['type_money'];
    }
    $total['bonus_formated'] = price_format($total['bonus'], false);

    /* ���º�� */
     if (!empty($order['bonus_kill']))
    {
        $bonus          = bonus_info(0,$order['bonus_kill']);
        $total['bonus_kill'] = $order['bonus_kill'];
        $total['bonus_kill_formated'] = price_format($total['bonus_kill'], false);
    }



    /* ���ͷ��� */
    /*$shipping_cod_fee = NULL;

    if ($order['shipping_id'] > 0 && $total['real_goods_count'] > 0)
    {
        $region['country']  = $consignee['country'];
        $region['province'] = $consignee['province'];
        $region['city']     = $consignee['city'];
        $region['district'] = $consignee['district'];
        $shipping_info = shipping_area_info($order['shipping_id'], $region);

        if (!empty($shipping_info))
        {
            if ($order['extension_code'] == 'group_buy')
            {
                $weight_price = cart_weight_price(CART_GROUP_BUY_GOODS);
            }
            else
            {
                $weight_price = cart_weight_price();
            }

            // �鿴���ﳵ���Ƿ�ȫΪ���˷���Ʒ����������˷Ѹ�Ϊ��
            $sql = 'SELECT count(*) FROM ' . $GLOBALS['ecs']->table('cart') . " WHERE  `session_id` = '" . SESS_ID. "' AND `extension_code` != 'package_buy' AND `is_shipping` = 0";
            $shipping_count = $GLOBALS['db']->getOne($sql);

            $total['shipping_fee'] = ($shipping_count == 0 AND $weight_price['free_shipping'] == 1) ?0 :  shipping_fee($shipping_info['shipping_code'],$shipping_info['configure'], $weight_price['weight'], $total['goods_price'], $weight_price['number']);

            if (!empty($order['need_insure']) && $shipping_info['insure'] > 0)
            {
                $total['shipping_insure'] = shipping_insure_fee($shipping_info['shipping_code'],
                    $total['goods_price'], $shipping_info['insure']);
            }
            else
            {
                $total['shipping_insure'] = 0;
            }

            if ($shipping_info['support_cod'])
            {
                $shipping_cod_fee = $shipping_info['pay_fee'];
            }
        }
    }*/

    $total['shipping_fee_formated']    = price_format($total['shipping_fee'], false);
    $total['shipping_insure_formated'] = price_format($total['shipping_insure'], false);

    // ���ﳵ�е���Ʒ�����ܺ��֧�����ܶ�
    $bonus_amount = compute_discount_amount();
    // ����ͻ��������֧���Ľ��Ϊ��Ʒ�ܶ�
    $max_amount = $total['goods_price'] == 0 ? $total['goods_price'] : $total['goods_price'] - $bonus_amount;

    /* ���㶩���ܶ� */
    if ($order['extension_code'] == 'group_buy' && $group_buy['deposit'] > 0)
    {
        $total['amount'] = $total['goods_price'];
    }
    else
    {
        $total['amount'] = $total['goods_price'] - $total['discount'] + $total['tax'] + $total['pack_fee'] + $total['card_fee'] +
            $total['shipping_fee'] + $total['shipping_insure'] + $total['cod_fee'];

        // ��ȥ������
        $use_bonus        = min($total['bonus'], $max_amount); // ʵ�ʼ�ȥ�ĺ�����
        if(isset($total['bonus_kill']))
        {
            $use_bonus_kill   = min($total['bonus_kill'], $max_amount);
            $total['amount'] -=  $price = number_format($total['bonus_kill'], 2, '.', ''); // ����Ҫ֧���Ķ������
        }

        $total['bonus']   = $use_bonus;
        $total['bonus_formated'] = price_format($total['bonus'], false);

        $total['amount'] -= $use_bonus; // ����Ҫ֧���Ķ������
        $max_amount      -= $use_bonus; // ������໹��֧���Ľ��

    }

    /* ��� */
    $order['surplus'] = $order['surplus'] > 0 ? $order['surplus'] : 0;
    if ($total['amount'] > 0)
    {
        if (isset($order['surplus']) && $order['surplus'] > $total['amount'])
        {
            $order['surplus'] = $total['amount'];
            $total['amount']  = 0;
        }
        else
        {
            $total['amount'] -= floatval($order['surplus']);
        }
    }
    else
    {
        $order['surplus'] = 0;
        $total['amount']  = 0;
    }
    $total['surplus'] = $order['surplus'];
    $total['surplus_formated'] = price_format($order['surplus'], false);

    /* ���� */
    $order['integral'] = $order['integral'] > 0 ? $order['integral'] : 0;
    if ($total['amount'] > 0 && $max_amount > 0 && $order['integral'] > 0)
    {
        $integral_money = value_of_integral($order['integral']);

        // ʹ�û���֧��
        $use_integral            = min($total['amount'], $max_amount, $integral_money); // ʵ��ʹ�û���֧���Ľ��
        $total['amount']        -= $use_integral;
        $total['integral_money'] = $use_integral;
        $order['integral']       = integral_of_value($use_integral);
    }
    else
    {
        $total['integral_money'] = 0;
        $order['integral']       = 0;
    }
    $total['integral'] = $order['integral'];
    $total['integral_formated'] = price_format($total['integral_money'], false);

    /* ���涩����Ϣ */
    $_SESSION['flow_order'] = $order;

    $se_flow_type = isset($_SESSION['flow_type']) ? $_SESSION['flow_type'] : '';
    
    /* ֧������ */
    if (!empty($order['pay_id']) && ($total['real_goods_count'] > 0 || $se_flow_type != CART_EXCHANGE_GOODS))
    {
        $total['pay_fee']      = pay_fee($order['pay_id'], $total['amount'], $shipping_cod_fee);
    }

    $total['pay_fee_formated'] = price_format($total['pay_fee'], false);

    $total['amount']           += $total['pay_fee']; // �����ܶ��ۼ���֧������
    $total['amount_formated']  = price_format($total['amount'], false);

    /* ȡ�ÿ��Եõ��Ļ��ֺͺ�� */
    if ($order['extension_code'] == 'group_buy')
    {
        $total['will_get_integral'] = $group_buy['gift_integral'];
    }
    elseif ($order['extension_code'] == 'exchange_goods')
    {
        $total['will_get_integral'] = 0;
    }
    else
    {
        $total['will_get_integral'] = get_give_integral($goods);
    }
    $total['will_get_bonus']        = $order['extension_code'] == 'exchange_goods' ? 0 : price_format(get_total_bonus(), false);
    $total['formated_goods_price']  = price_format($total['goods_price'], false);
    $total['formated_market_price'] = price_format($total['market_price'], false);
    $total['formated_saving']       = price_format($total['saving'], false);

    if ($order['extension_code'] == 'exchange_goods')
    {
        $sql = 'SELECT SUM(eg.exchange_integral) '.
               'FROM ' . $GLOBALS['ecs']->table('cart') . ' AS c,' . $GLOBALS['ecs']->table('exchange_goods') . 'AS eg '.
               "WHERE c.goods_id = eg.goods_id AND c.session_id= '" . SESS_ID . "' " .
               "  AND c.rec_type = '" . CART_EXCHANGE_GOODS . "' " .
               '  AND c.is_gift = 0 AND c.goods_id > 0 ' .
               'GROUP BY eg.goods_id';
        $exchange_integral = $GLOBALS['db']->getOne($sql);
        $total['exchange_integral'] = $exchange_integral;
    }

    return $total;
}

/**
 * �޸Ķ���
 * @param   int     $order_id   ����id
 * @param   array   $order      key => value
 * @return  bool
 */
function update_order($order_id, $order)
{
    return $GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('order_info'),
        $order, 'UPDATE', "order_id = '$order_id'");
}

/**
 * �õ��¶�����
 * @return  string
 */
function get_order_sn()
{
    /* ѡ��һ������ķ��� */
    mt_srand((double) microtime() * 1000000);

    return date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
}

/**
 * ȡ�ù��ﳵ��Ʒ
 * @param   int     $type   ���ͣ�Ĭ����ͨ��Ʒ
 * @return  array   ���ﳵ��Ʒ����
 */
function cart_goods($type = CART_GENERAL_GOODS,$rec_id='')
{
    $sql = "SELECT rec_id, user_id, goods_id, goods_name, goods_sn, goods_number, " .
            "market_price, goods_price, goods_attr, is_real, extension_code, parent_id, is_gift, is_shipping,insure_id, " .
            "goods_price * goods_number AS subtotal " .
            "FROM " . $GLOBALS['ecs']->table('cart') .
            " WHERE session_id = '" . SESS_ID . "' " .
            "AND rec_type = '$type' and rec_id=$rec_id";

    $arr = $GLOBALS['db']->getRow($sql);

    /* ��ʽ���۸������Ʒ */
    //foreach ($arr as $key => $value)
    //{
        $arr['formated_market_price'] = price_format($arr['market_price'], false);
        $arr['formated_goods_price']  = price_format($arr['goods_price'], false);
        $arr['formated_subtotal']     = price_format($arr['subtotal'], false);

        if ($arr['extension_code'] == 'package_buy')
        {
            $arr['package_goods_list'] = get_package_goods($arr['goods_id']);
        }
    //}

    return $arr;
}

/**
 * ȡ�ù��ﳵ�ܽ��
 * @params  boolean $include_gift   �Ƿ������Ʒ
 * @param   int     $type           ���ͣ�Ĭ����ͨ��Ʒ
 * @return  float   ���ﳵ�ܽ��
 */
function cart_amount($include_gift = true, $type = CART_GENERAL_GOODS)
{
    $sql = "SELECT SUM(goods_price * goods_number) " .
            " FROM " . $GLOBALS['ecs']->table('cart') .
            " WHERE session_id = '" . SESS_ID . "' " .
            "AND rec_type = '$type' ";

    if (!$include_gift)
    {
        $sql .= ' AND is_gift = 0 AND goods_id > 0';
    }

    return floatval($GLOBALS['db']->getOne($sql));
}

/**
 * ���ĳ��Ʒ�Ƿ��Ѿ������ڹ��ﳵ
 *
 * @access  public
 * @param   integer     $id
 * @param   array       $spec
 * @param   int         $type   ���ͣ�Ĭ����ͨ��Ʒ
 * @return  boolean
 */
function cart_goods_exists($id, $spec, $type = CART_GENERAL_GOODS)
{
    /* ������Ʒ�Ƿ��Ѿ������ڹ��ﳵ�� */
    $sql = "SELECT COUNT(*) FROM " .$GLOBALS['ecs']->table('cart').
            "WHERE session_id = '" .SESS_ID. "' AND goods_id = '$id' ".
            "AND parent_id = 0 AND goods_attr = '" .get_goods_attr_info($spec). "' " .
            "AND rec_type = '$type'";

    return ($GLOBALS['db']->getOne($sql) > 0);
}

/**
 * ��ù��ﳵ����Ʒ�����������ܼ۸�������
 *
 * @access  public
 * @param   int     $type   ���ͣ�Ĭ����ͨ��Ʒ
 * @return  array
 */
function cart_weight_price($type = CART_GENERAL_GOODS)
{
    $package_row['weight'] = 0;
    $package_row['amount'] = 0;
    $package_row['number'] = 0;

    $packages_row['free_shipping'] = 1;

    /* ���㳬ֵ�������Ʒ��������Ͳ��� */
    $sql = 'SELECT goods_id, goods_number, goods_price FROM ' . $GLOBALS['ecs']->table('cart') . " WHERE extension_code = 'package_buy' AND session_id = '" . SESS_ID . "'";
    $row = $GLOBALS['db']->getAll($sql);

    if ($row)
    {
        $packages_row['free_shipping'] = 0;
        $free_shipping_count = 0;

        foreach ($row as $val)
        {
            // �����ƷȫΪ���˷���Ʒ������һ����ʶ����
            $sql = 'SELECT count(*) FROM ' .
                    $GLOBALS['ecs']->table('package_goods') . ' AS pg, ' .
                    $GLOBALS['ecs']->table('goods') . ' AS g ' .
                    "WHERE g.goods_id = pg.goods_id AND g.is_shipping = 0 AND pg.package_id = '"  . $val['goods_id'] . "'";
            $shipping_count = $GLOBALS['db']->getOne($sql);

            if ($shipping_count > 0)
            {
                // ѭ������ÿ����ֵ�����Ʒ��������������ע��һ������п��ܰ������ɸ�ͬһ��Ʒ
                $sql = 'SELECT SUM(g.goods_weight * pg.goods_number) AS weight, ' .
                    'SUM(pg.goods_number) AS number FROM ' .
                    $GLOBALS['ecs']->table('package_goods') . ' AS pg, ' .
                    $GLOBALS['ecs']->table('goods') . ' AS g ' .
                    "WHERE g.goods_id = pg.goods_id AND g.is_shipping = 0 AND pg.package_id = '"  . $val['goods_id'] . "'";

                $goods_row = $GLOBALS['db']->getRow($sql);
                $package_row['weight'] += floatval($goods_row['weight']) * $val['goods_number'];
                $package_row['amount'] += floatval($val['goods_price']) * $val['goods_number'];
                $package_row['number'] += intval($goods_row['number']) * $val['goods_number'];
            }
            else
            {
                $free_shipping_count++;
            }
        }

        $packages_row['free_shipping'] = $free_shipping_count == count($row) ? 1 : 0;
    }

    /* ��ù��ﳵ�зǳ�ֵ�����Ʒ�������� */
    $sql    = 'SELECT SUM(g.goods_weight * c.goods_number) AS weight, ' .
                    'SUM(c.goods_price * c.goods_number) AS amount, ' .
                    'SUM(c.goods_number) AS number '.
                'FROM ' . $GLOBALS['ecs']->table('cart') . ' AS c '.
                'LEFT JOIN ' . $GLOBALS['ecs']->table('goods') . ' AS g ON g.goods_id = c.goods_id '.
                "WHERE c.session_id = '" . SESS_ID . "' " .
                "AND rec_type = '$type' AND g.is_shipping = 0 AND c.extension_code != 'package_buy'";
    $row = $GLOBALS['db']->getRow($sql);

    $packages_row['weight'] = floatval($row['weight']) + $package_row['weight'];
    $packages_row['amount'] = floatval($row['amount']) + $package_row['amount'];
    $packages_row['number'] = intval($row['number']) + $package_row['number'];
    /* ��ʽ������ */
    $packages_row['formated_weight'] = formated_weight($packages_row['weight']);

    return $packages_row;
}

/**
 * �����Ʒ�����ﳵ
 *
 * @access  public
 * @param   integer $goods_id   ��Ʒ���
 * @param   integer $num        ��Ʒ����
 * @param   array   $spec       ���ֵ��Ӧ��id����
 * @param   integer $parent     ������
 * @return  boolean
 */
function addto_cart($goods_id, $num = 1, $spec = array(), $parent = 0)
{
    $GLOBALS['err']->clean();
    $_parent_id = $parent;

    /* ȡ����Ʒ��Ϣ */
    $sql = "SELECT g.goods_name, g.goods_sn, g.is_on_sale, g.is_real, ".
                "g.market_price, g.shop_price AS org_price, g.promote_price, g.promote_start_date, ".
                "g.promote_end_date, g.goods_weight, g.integral, g.extension_code, ".
                "g.goods_number, g.is_alone_sale, g.is_shipping,".
                "IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS shop_price ".
            " FROM " .$GLOBALS['ecs']->table('goods'). " AS g ".
            " LEFT JOIN " . $GLOBALS['ecs']->table('member_price') . " AS mp ".
                    "ON mp.goods_id = g.goods_id AND mp.user_rank = '$_SESSION[user_rank]' ".
            " WHERE g.goods_id = '$goods_id'" .
            " AND g.is_delete = 0";
    $goods = $GLOBALS['db']->getRow($sql);

    if (empty($goods))
    {
        $GLOBALS['err']->add($GLOBALS['_LANG']['goods_not_exists'], ERR_NOT_EXISTS);

        return false;
    }

    /* �������Ϊ�����ӵ����ﳵ�ģ���Ҫ�ȼ�鹺�ﳵ�����Ƿ��Ѿ��л����� */
    if ($parent > 0)
    {
        $sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('cart') .
                " WHERE goods_id='$parent' AND session_id='" . SESS_ID . "' AND extension_code <> 'package_buy'";
        if ($GLOBALS['db']->getOne($sql) == 0)
        {
            $GLOBALS['err']->add($GLOBALS['_LANG']['no_basic_goods'], ERR_NO_BASIC_GOODS);

            return false;
        }
    }

    /* �Ƿ��������� */
    if ($goods['is_on_sale'] == 0)
    {
        $GLOBALS['err']->add($GLOBALS['_LANG']['not_on_sale'], ERR_NOT_ON_SALE);

        return false;
    }

    /* �������ʱ����Ƿ����������� */
    if (empty($parent) && $goods['is_alone_sale'] == 0)
    {
        $GLOBALS['err']->add($GLOBALS['_LANG']['cannt_alone_sale'], ERR_CANNT_ALONE_SALE);

        return false;
    }

    /* �����Ʒ�й����ȡ�����Ʒ��Ϣ ������� */
    $sql = "SELECT * FROM " .$GLOBALS['ecs']->table('products'). " WHERE goods_id = '$goods_id' LIMIT 0, 1";
    $prod = $GLOBALS['db']->getRow($sql);

    if (is_spec($spec) && !empty($prod))
    {
        $product_info = get_products_info($goods_id, $spec);
    }
    if (empty($product_info))
    {
        $product_info = array('product_number' => '', 'product_id' => 0);
    }

    /* ��飺��� */
    if ($GLOBALS['_CFG']['use_storage'] == 1)
    {
        //��飺��Ʒ���������Ƿ�����ܿ��
        if ($num > $goods['goods_number'])
        {
            $GLOBALS['err']->add(sprintf($GLOBALS['_LANG']['shortage'], $goods['goods_number']), ERR_OUT_OF_STOCK);

            return false;
        }

        //��Ʒ���ڹ�� �ǻ�Ʒ ���û�Ʒ���
        if (is_spec($spec) && !empty($prod))
        {
            if (!empty($spec))
            {
                /* ȡ���Ļ�Ʒ��� */
                if ($num > $product_info['product_number'])
                {
                    $GLOBALS['err']->add(sprintf($GLOBALS['_LANG']['shortage'], $product_info['product_number']), ERR_OUT_OF_STOCK);
    
                    return false;
                }
            }
        }       
    }

    /* ������Ʒ�Ĵ����۸� */
    $spec_price             = spec_price($spec);
    $goods_price            = get_final_price($goods_id, $num, true, $spec);
    $goods['market_price'] += $spec_price;
    $goods_attr             = get_goods_attr_info($spec);
    $goods_attr_id          = join(',', $spec);

    /* ��ʼ��Ҫ���빺�ﳵ�Ļ��������� */
    $parent = array(
        'user_id'       => $_SESSION['user_id'],
        'session_id'    => SESS_ID,
        'goods_id'      => $goods_id,
        'goods_sn'      => addslashes($goods['goods_sn']),
        'product_id'    => $product_info['product_id'],
        'goods_name'    => addslashes($goods['goods_name']),
        'market_price'  => $goods['market_price'],
        'goods_attr'    => addslashes($goods_attr),
        'goods_attr_id' => $goods_attr_id,
        'is_real'       => $goods['is_real'],
        'extension_code'=> $goods['extension_code'],
        'is_gift'       => 0,
        'is_shipping'   => $goods['is_shipping'],
        'rec_type'      => CART_GENERAL_GOODS
    );

    /* �������������Ϊ�����������ʱ�������õġ�����۸񡱱�ԭ�۵ͣ���������ڼ۸����ṩ���Żݣ� */
    /* ���ո�������Żݼ۸���������ÿһ��������ֻ�ܹ���һ���Żݼ۸�ġ��������������ġ������������ */
    /* �ܴ��Ż� */
    $basic_list = array();
    $sql = "SELECT parent_id, goods_price " .
            "FROM " . $GLOBALS['ecs']->table('group_goods') .
            " WHERE goods_id = '$goods_id'" .
            " AND goods_price < '$goods_price'" .
            " AND parent_id = '$_parent_id'" .
            " ORDER BY goods_price";
    $res = $GLOBALS['db']->query($sql);
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        $basic_list[$row['parent_id']] = $row['goods_price'];
    }

    /* ȡ�ù��ﳵ�и���Ʒÿ�������������� */
    $basic_count_list = array();
    if ($basic_list)
    {
        $sql = "SELECT goods_id, SUM(goods_number) AS count " .
                "FROM " . $GLOBALS['ecs']->table('cart') .
                " WHERE session_id = '" . SESS_ID . "'" .
                " AND parent_id = 0" .
                " AND extension_code <> 'package_buy' " .
                " AND goods_id " . db_create_in(array_keys($basic_list)) .
                " GROUP BY goods_id";
        $res = $GLOBALS['db']->query($sql);
        while ($row = $GLOBALS['db']->fetchRow($res))
        {
            $basic_count_list[$row['goods_id']] = $row['count'];
        }
    }

    /* ȡ�ù��ﳵ�и���Ʒÿ�����������и���Ʒ��������������ÿ�������������м�������Ʒ��� */
    /* һ����������Ӧһ������Ʒ��� */
    if ($basic_count_list)
    {
        $sql = "SELECT parent_id, SUM(goods_number) AS count " .
                "FROM " . $GLOBALS['ecs']->table('cart') .
                " WHERE session_id = '" . SESS_ID . "'" .
                " AND goods_id = '$goods_id'" .
                " AND extension_code <> 'package_buy' " .
                " AND parent_id " . db_create_in(array_keys($basic_count_list)) .
                " GROUP BY parent_id";
        $res = $GLOBALS['db']->query($sql);
        while ($row = $GLOBALS['db']->fetchRow($res))
        {
            $basic_count_list[$row['parent_id']] -= $row['count'];
        }
    }

    /* ѭ��������� �������������������������Ϊ���ﳵ������������Ļ���������㹻�����ĸ���� */
    foreach ($basic_list as $parent_id => $fitting_price)
    {
        /* �����ȫ�����룬�˳� */
        if ($num <= 0)
        {
            break;
        }

        /* ����û��������ٹ��ﳵ�У�ִ����һ�� */
        if (!isset($basic_count_list[$parent_id]))
        {
            continue;
        }

        /* ����û��������������������ִ����һ�������� */
        if ($basic_count_list[$parent_id] <= 0)
        {
            continue;
        }

        /* ��Ϊ�û�������������� */
        $parent['goods_price']  = max($fitting_price, 0) + $spec_price; //���������Żݼ۸�Ϊ0
        $parent['goods_number'] = min($num, $basic_count_list[$parent_id]);
        $parent['parent_id']    = $parent_id;

        /* ��� */
        $GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('cart'), $parent, 'INSERT');

        /* �ı����� */
        $num -= $parent['goods_number'];
    }

    /* ���������Ϊ0����Ϊ���������� */
    if ($num > 0)
    {
        /* ������Ʒ�Ƿ��Ѿ������ڹ��ﳵ�� */
        $sql = "SELECT goods_number FROM " .$GLOBALS['ecs']->table('cart').
                " WHERE session_id = '" .SESS_ID. "' AND goods_id = '$goods_id' ".
                " AND parent_id = 0 AND goods_attr = '" .get_goods_attr_info($spec). "' " .
                " AND extension_code <> 'package_buy' " .
                " AND rec_type = 'CART_GENERAL_GOODS'";

        $row = $GLOBALS['db']->getRow($sql);

        if($row) //������ﳵ�Ѿ��д���Ʒ�������
        {
            $num += $row['goods_number'];
            if(is_spec($spec) && !empty($prod) )
            {
             $goods_storage=$product_info['product_number'];
            }
            else
            {
                $goods_storage=$goods['goods_number'];
            }
            if ($GLOBALS['_CFG']['use_storage'] == 0 || $num <= $goods_storage)
            {
                $goods_price = get_final_price($goods_id, $num, true, $spec);
                $sql = "UPDATE " . $GLOBALS['ecs']->table('cart') . " SET goods_number = '1'" .
                       " , goods_price = '$goods_price'".
                       " WHERE session_id = '" .SESS_ID. "' AND goods_id = '$goods_id' ".
                       " AND parent_id = 0 AND goods_attr = '" .get_goods_attr_info($spec). "' " .
                       " AND extension_code <> 'package_buy' " .
                       "AND rec_type = 'CART_GENERAL_GOODS'";
                $GLOBALS['db']->query($sql);
            }
            else
            {
               $GLOBALS['err']->add(sprintf($GLOBALS['_LANG']['shortage'], $num), ERR_OUT_OF_STOCK);

                return false;
            }
        }
        else //���ﳵû�д���Ʒ�������
        {
            $goods_price = get_final_price($goods_id, $num, true, $spec);
            $parent['goods_price']  = max($goods_price, 0);
            $parent['goods_number'] = $num;
            $parent['parent_id']    = 0;
            $GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('cart'), $parent, 'INSERT');
        }
    }

    /* ����Ʒɾ�� */
    $sql = "DELETE FROM " . $GLOBALS['ecs']->table('cart') . " WHERE session_id = '" . SESS_ID . "' AND is_gift <> 0";
    $GLOBALS['db']->query($sql);

    return true;
}

/**
 * ��չ��ﳵ
 * @param   int     $type   ���ͣ�Ĭ����ͨ��Ʒ
 */
function clear_cart($type = CART_GENERAL_GOODS,$rec_id='')
{
    $sql = "DELETE FROM " . $GLOBALS['ecs']->table('cart') .
            " WHERE session_id = '" . SESS_ID . "' AND rec_type = '$type' and rec_id=$rec_id";
    $GLOBALS['db']->query($sql);
}

/**
 * ���ָ������Ʒ����
 *
 * @access      public
 * @param       array       $arr        �������ID����
 * @param       type        $type       ���÷��ؽ�����ͣ�pice����ʾ�۸�Ĭ�ϣ�no������ʾ�۸�
 *
 * @return      string
 */
function get_goods_attr_info($arr, $type = 'pice')
{
    $attr   = '';

    if (!empty($arr))
    {
        $fmt = "%s:%s[%s] \n";

        $sql = "SELECT a.attr_name, ga.attr_value, ga.attr_price ".
                "FROM ".$GLOBALS['ecs']->table('goods_attr')." AS ga, ".
                    $GLOBALS['ecs']->table('attribute')." AS a ".
                "WHERE " .db_create_in($arr, 'ga.goods_attr_id')." AND a.attr_id = ga.attr_id";
        $res = $GLOBALS['db']->query($sql);

        while ($row = $GLOBALS['db']->fetchRow($res))
        {
            $attr_price = round(floatval($row['attr_price']), 2);
            $attr .= sprintf($fmt, $row['attr_name'], $row['attr_value'], $attr_price);
        }

        $attr = str_replace('[0]', '', $attr);
    }

    return $attr;
}

/**
 * ȡ���û���Ϣ
 * @param   int     $user_id    �û�id
 * @return  array   �û���Ϣ
 */
function user_info($user_id)
{
    $sql = "SELECT * FROM " . $GLOBALS['ecs']->table('users') .
            " WHERE user_id = '$user_id'";
    $user = $GLOBALS['db']->getRow($sql);

    unset($user['question']);
    unset($user['answer']);

    /* ��ʽ���ʻ���� */
    if ($user)
    {
//        if ($user['user_money'] < 0)
//        {
//            $user['user_money'] = 0;
//        }
        $user['formated_user_money'] = price_format($user['user_money'], false);
        $user['formated_frozen_money'] = price_format($user['frozen_money'], false);
    }

    return $user;
}

/**
 * �޸��û�
 * @param   int     $user_id   ����id
 * @param   array   $user      key => value
 * @return  bool
 */
function update_user($user_id, $user)
{
    return $GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('users'),
        $user, 'UPDATE', "user_id = '$user_id'");
}

/**
 * ȡ���û���ַ�б�
 * @param   int     $user_id    �û�id
 * @return  array
 */
function address_list($user_id)
{
    $sql = "SELECT * FROM " . $GLOBALS['ecs']->table('user_address') .
            " WHERE user_id = '$user_id'";

    return $GLOBALS['db']->getAll($sql);
}

/**
 * ȡ���û���ַ��Ϣ
 * @param   int     $address_id     ��ַid
 * @return  array
 */
function address_info($address_id)
{
    $sql = "SELECT * FROM " . $GLOBALS['ecs']->table('user_address') .
            " WHERE address_id = '$address_id'";

    return $GLOBALS['db']->getRow($sql);
}

/**
 * ȡ���û���ǰ���ú��
 * @param   int     $user_id        �û�id
 * @param   float   $goods_amount   ������Ʒ���
 * @return  array   �������
 */
function user_bonus($user_id, $goods_amount = 0)
{
    $day    = getdate();
    $today  = local_mktime(23, 59, 59, $day['mon'], $day['mday'], $day['year']);

    $sql = "SELECT t.type_id, t.type_name, t.type_money, b.bonus_id " .
            "FROM " . $GLOBALS['ecs']->table('bonus_type') . " AS t," .
                $GLOBALS['ecs']->table('user_bonus') . " AS b " .
            "WHERE t.type_id = b.bonus_type_id " .
            "AND t.use_start_date <= '$today' " .
            "AND t.use_end_date >= '$today' " .
            "AND t.min_goods_amount <= '$goods_amount' " .
            "AND b.user_id<>0 " .
            "AND b.user_id = '$user_id' " .
            "AND b.order_id = 0";
    return $GLOBALS['db']->getAll($sql);
}

/**
 * ȡ�ú����Ϣ
 * @param   int     $bonus_id   ���id
 * @param   string  $bonus_sn   ������к�
 * @param   array   �����Ϣ
 */
function bonus_info($bonus_id, $bonus_sn = '')
{
    $sql = "SELECT t.*, b.* " .
            "FROM " . $GLOBALS['ecs']->table('bonus_type') . " AS t," .
                $GLOBALS['ecs']->table('user_bonus') . " AS b " .
            "WHERE t.type_id = b.bonus_type_id ";
    if ($bonus_id > 0)
    {
        $sql .= "AND b.bonus_id = '$bonus_id'";
    }
    else
    {
        $sql .= "AND b.bonus_sn = '$bonus_sn'";
    }

    return $GLOBALS['db']->getRow($sql);
}

/**
 * ������Ƿ���ʹ��
 * @param   int $bonus_id   ���id
 * @return  bool
 */
function bonus_used($bonus_id)
{
    $sql = "SELECT order_id FROM " . $GLOBALS['ecs']->table('user_bonus') .
            " WHERE bonus_id = '$bonus_id'";

    return  $GLOBALS['db']->getOne($sql) > 0;
}

/**
 * ���ú��Ϊ��ʹ��
 * @param   int     $bonus_id   ���id
 * @param   int     $order_id   ����id
 * @return  bool
 */
function use_bonus($bonus_id, $order_id)
{
    $sql = "UPDATE " . $GLOBALS['ecs']->table('user_bonus') .
            " SET order_id = '$order_id', used_time = '" . gmtime() . "' " .
            "WHERE bonus_id = '$bonus_id' LIMIT 1";

    return  $GLOBALS['db']->query($sql);
}

/**
 * ���ú��Ϊδʹ��
 * @param   int     $bonus_id   ���id
 * @param   int     $order_id   ����id
 * @return  bool
 */
function unuse_bonus($bonus_id)
{
    $sql = "UPDATE " . $GLOBALS['ecs']->table('user_bonus') .
            " SET order_id = 0, used_time = 0 " .
            "WHERE bonus_id = '$bonus_id' LIMIT 1";

    return  $GLOBALS['db']->query($sql);
}

/**
 * ������ֵļ�ֵ���ֶܵ���Ǯ��
 * @param   int     $integral   ����
 * @return  float   ���ּ�ֵ
 */
function value_of_integral($integral)
{
    $scale = floatval($GLOBALS['_CFG']['integral_scale']);

    return $scale > 0 ? round(($integral / 100) * $scale, 2) : 0;
}

/**
 * ����ָ���Ľ����Ҫ���ٻ���
 *
 * @access  public
 * @param   integer $value  ���
 * @return  void
 */
function integral_of_value($value)
{
    $scale = floatval($GLOBALS['_CFG']['integral_scale']);

    return $scale > 0 ? round($value / $scale * 100) : 0;
}

/**
 * �����˿�
 * @param   array   $order          ����
 * @param   int     $refund_type    �˿ʽ 1 ���ʻ���� 2 ���˿����루�ȵ����������� 3 ������
 * @param   string  $refund_note    �˿�˵��
 * @param   float   $refund_amount  �˿�����Ϊ0��ȡ�����Ѹ����
 * @return  bool
 */
function order_refund($order, $refund_type, $refund_note, $refund_amount = 0)
{
    /* ������ */
    $user_id = $order['user_id'];
    if ($user_id == 0 && $refund_type == 1)
    {
        die('anonymous, cannot return to account balance');
    }

    $amount = $refund_amount > 0 ? $refund_amount : $order['money_paid'];
    if ($amount <= 0)
    {
        return true;
    }

    if (!in_array($refund_type, array(1, 2, 3)))
    {
        die('invalid params');
    }

    /* ��ע��Ϣ */
    if ($refund_note)
    {
        $change_desc = $refund_note;
    }
    else
    {
        include_once(ROOT_PATH . 'languages/' .$GLOBALS['_CFG']['lang']. '/admin/order.php');
        $change_desc = sprintf($GLOBALS['_LANG']['order_refund'], $order['order_sn']);
    }

    /* �����˿� */
    if (1 == $refund_type)
    {
        log_account_change($user_id, $amount, 0, 0, 0, $change_desc);

        return true;
    }
    elseif (2 == $refund_type)
    {
        /* ������������˻���� */
        if ($user_id > 0)
        {
            log_account_change($user_id, $amount, 0, 0, 0, $change_desc);
        }

        /* user_account ��������������¼ */
        $account = array(
            'user_id'      => $user_id,
            'amount'       => (-1) * $amount,
            'add_time'     => gmtime(),
            'user_note'    => $refund_note,
            'process_type' => SURPLUS_RETURN,
            'admin_user'   => $_SESSION['admin_name'],
            'admin_note'   => sprintf($GLOBALS['_LANG']['order_refund'], $order['order_sn']),
            'is_paid'      => 0
        );
        $GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('user_account'), $account, 'INSERT');

        return true;
    }
    else
    {
        return true;
    }
}

/**
 * ��ù��ﳵ�е���Ʒ
 *
 * @access  public
 * @return  array
 */
function get_cart_goods()
{
    /* ��ʼ�� */
    $goods_list = array();
    $total = array(
        'goods_price'  => 0, // �����ۼۺϼƣ��и�ʽ��
        'market_price' => 0, // �г��ۼۺϼƣ��и�ʽ��
        'saving'       => 0, // ��ʡ���и�ʽ��
        'save_rate'    => 0, // ��ʡ�ٷֱ�
        'goods_amount' => 0, // �����ۼۺϼƣ��޸�ʽ��
    );

    /* ѭ����ͳ�� */
    $sql = "SELECT *, IF(parent_id, parent_id, goods_id) AS pid " .
            " FROM " . $GLOBALS['ecs']->table('cart') . " " .
            " WHERE session_id = '" . SESS_ID . "' AND rec_type = '" . CART_GENERAL_GOODS . "'" .
            " ORDER BY pid, parent_id";
    $res = $GLOBALS['db']->query($sql);

    /* ����ͳ�ƹ��ﳵ��ʵ����Ʒ��������Ʒ�ĸ��� */
    $virtual_goods_count = 0;
    $real_goods_count    = 0;

    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        $total['goods_price']  += $row['goods_price'] * $row['goods_number'];
        $total['market_price'] += $row['market_price'] * $row['goods_number'];

        $row['subtotal']     = price_format($row['goods_price'] * $row['goods_number'], false);
        $row['goods_price']  = price_format($row['goods_price'], false);
        $row['market_price'] = price_format($row['market_price'], false);
		
		$row['brand_name'] = $GLOBALS['db']->getOne("select b.brand_name from ".$GLOBALS['ecs']->table('goods')." as g,".$GLOBALS['ecs']->table('brand')." as b where g.brand_id=b.brand_id and g.goods_id=".$row['goods_id']."");

        /* ͳ��ʵ����Ʒ��������Ʒ�ĸ��� */
        if ($row['is_real'])
        {
            $real_goods_count++;
        }
        else
        {
            $virtual_goods_count++;
        }

        /* ��ѯ��� */
        if (trim($row['goods_attr']) != '')
        {
            $row['goods_attr']=addslashes($row['goods_attr']);
            $sql = "SELECT attr_value FROM " . $GLOBALS['ecs']->table('goods_attr') . " WHERE goods_attr_id " .
            db_create_in($row['goods_attr']);
            $attr_list = $GLOBALS['db']->getCol($sql);
            foreach ($attr_list AS $attr)
            {
                $row['goods_name'] .= ' [' . $attr . '] ';
            }
        }
        /* �����Ƿ��ڹ��ﳵ����ʾ��Ʒͼ */
        if (($GLOBALS['_CFG']['show_goods_in_cart'] == "2" || $GLOBALS['_CFG']['show_goods_in_cart'] == "3") && $row['extension_code'] != 'package_buy')
        {
            $goods_thumb = $GLOBALS['db']->getOne("SELECT `goods_thumb` FROM " . $GLOBALS['ecs']->table('goods') . " WHERE `goods_id`='{$row['goods_id']}'");
            $row['goods_thumb'] = get_image_path($row['goods_id'], $goods_thumb, true);
        }
        if ($row['extension_code'] == 'package_buy')
        {
            $row['package_goods_list'] = get_package_goods($row['goods_id']);
        }
        $goods_list[] = $row;
    }
    $total['goods_amount'] = $total['goods_price'];
    $total['saving']       = price_format($total['market_price'] - $total['goods_price'], false);
    if ($total['market_price'] > 0)
    {
        $total['save_rate'] = $total['market_price'] ? round(($total['market_price'] - $total['goods_price']) *
        100 / $total['market_price']).'%' : 0;
    }
    $total['goods_price']  = price_format($total['goods_price'], false);
    $total['market_price'] = price_format($total['market_price'], false);
    $total['real_goods_count']    = $real_goods_count;
    $total['virtual_goods_count'] = $virtual_goods_count;

    return array('goods_list' => $goods_list, 'total' => $total);
}

/**
 * ȡ���ջ�����Ϣ
 * @param   int     $user_id    �û����
 * @return  array
 */
function get_consignee($user_id)
{
    if (isset($_SESSION['flow_consignee']))
    {
        /* �������session����ֱ�ӷ���session�е��ջ�����Ϣ */

        return $_SESSION['flow_consignee'];
    }
    else
    {
        /* ��������ڣ���ȡ���û���Ĭ���ջ�����Ϣ */
        $arr = array();

        if ($user_id > 0)
        {
            /* ȡĬ�ϵ�ַ */
            $sql = "SELECT ua.*".
                    " FROM " . $GLOBALS['ecs']->table('user_address') . "AS ua, ".$GLOBALS['ecs']->table('users').' AS u '.
                    " WHERE u.user_id='$user_id' AND ua.address_id = u.address_id";

            $arr = $GLOBALS['db']->getRow($sql);
        }

        return $arr;
    }
}

/**
 * ��ѯ���ﳵ������idΪ0���򶩵����Ƿ���ʵ����Ʒ
 * @param   int     $order_id   ����id
 * @param   int     $flow_type  ������������
 * @return  bool
 */
function exist_real_goods($order_id = 0, $flow_type = CART_GENERAL_GOODS)
{
    if ($order_id <= 0)
    {
        $sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('cart') .
                " WHERE session_id = '" . SESS_ID . "' AND is_real = 1 " .
                "AND rec_type = '$flow_type'";
    }
    else
    {
        $sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('order_goods') .
                " WHERE order_id = '$order_id' AND is_real = 1";
    }

    return $GLOBALS['db']->getOne($sql) > 0;
}

/**
 * ����ջ�����Ϣ�Ƿ�����
 * @param   array   $consignee  �ջ�����Ϣ
 * @param   int     $flow_type  ������������
 * @return  bool    true ���� false ������
 */
function check_consignee_info($consignee, $flow_type)
{
    if (exist_real_goods(0, $flow_type))
    {
        /* �������ʵ����Ʒ */
        $res = !empty($consignee['consignee']) &&
            !empty($consignee['country']) &&
            !empty($consignee['email']) &&
            !empty($consignee['tel']);

        if ($res)
        {
            if (empty($consignee['province']))
            {
                /* û������ʡ�ݣ���鵱ǰ����������û������ʡ�� */
                $pro = get_regions(1, $consignee['country']);
                $res = empty($pro);
            }
            elseif (empty($consignee['city']))
            {
                /* û�����ó��У���鵱ǰʡ������û�г��� */
                $city = get_regions(2, $consignee['province']);
                $res = empty($city);
            }
            elseif (empty($consignee['district']))
            {
                $dist = get_regions(3, $consignee['city']);
                $res = empty($dist);
            }
        }

        return $res;
    }
    else
    {
        /* ���������ʵ����Ʒ */
        return !empty($consignee['consignee']) &&
            !empty($consignee['email']) &&
            !empty($consignee['tel']);
    }
}

/**
 * �����һ���û����õ�֧�������ͷ�ʽ
 *
 * @access  public
 * @return  void
 */
function last_shipping_and_payment()
{
    $sql = "SELECT shipping_id, pay_id " .
            " FROM " . $GLOBALS['ecs']->table('order_info') .
            " WHERE user_id = '$_SESSION[user_id]' " .
            " ORDER BY order_id DESC LIMIT 1";
    $row = $GLOBALS['db']->getRow($sql);

    if (empty($row))
    {
        /* ��������һ�������飬�򷵻�Ĭ��ֵ */
        $row = array('shipping_id' => 0, 'pay_id' => 0);
    }

    return $row;
}

/**
 * ȡ�õ�ǰ�û�Ӧ�õõ��ĺ���ܶ�
 */
function get_total_bonus()
{
    $day    = getdate();
    $today  = local_mktime(23, 59, 59, $day['mon'], $day['mday'], $day['year']);

    /* ����Ʒ���ĺ�� */
    $sql = "SELECT SUM(c.goods_number * t.type_money)" .
            "FROM " . $GLOBALS['ecs']->table('cart') . " AS c, "
                    . $GLOBALS['ecs']->table('bonus_type') . " AS t, "
                    . $GLOBALS['ecs']->table('goods') . " AS g " .
            "WHERE c.session_id = '" . SESS_ID . "' " .
            "AND c.is_gift = 0 " .
            "AND c.goods_id = g.goods_id " .
            "AND g.bonus_type_id = t.type_id " .
            "AND t.send_type = '" . SEND_BY_GOODS . "' " .
            "AND t.send_start_date <= '$today' " .
            "AND t.send_end_date >= '$today' " .
            "AND c.rec_type = '" . CART_GENERAL_GOODS . "'";
    $goods_total = floatval($GLOBALS['db']->getOne($sql));

    /* ȡ�ù��ﳵ�з���Ʒ�ܽ�� */
    $sql = "SELECT SUM(goods_price * goods_number) " .
            "FROM " . $GLOBALS['ecs']->table('cart') .
            " WHERE session_id = '" . SESS_ID . "' " .
            " AND is_gift = 0 " .
            " AND rec_type = '" . CART_GENERAL_GOODS . "'";
    $amount = floatval($GLOBALS['db']->getOne($sql));

    /* ���������ĺ�� */
    $sql = "SELECT FLOOR('$amount' / min_amount) * type_money " .
            "FROM " . $GLOBALS['ecs']->table('bonus_type') .
            " WHERE send_type = '" . SEND_BY_ORDER . "' " .
            " AND send_start_date <= '$today' " .
            "AND send_end_date >= '$today' " .
            "AND min_amount > 0 ";
    $order_total = floatval($GLOBALS['db']->getOne($sql));

    return $goods_total + $order_total;
}

/**
 * ���������¶���ʱ��Ϊʹ�ã�ȡ������Ч���˻�������ʱ��Ϊδʹ��
 * @param   int     $bonus_id   ������
 * @param   int     $order_id   ������
 * @param   int     $is_used    �Ƿ�ʹ����
 */
function change_user_bonus($bonus_id, $order_id, $is_used = true)
{
    if ($is_used)
    {
        $sql = 'UPDATE ' . $GLOBALS['ecs']->table('user_bonus') . ' SET ' .
                'used_time = ' . gmtime() . ', ' .
                "order_id = '$order_id' " .
                "WHERE bonus_id = '$bonus_id'";
    }
    else
    {
        $sql = 'UPDATE ' . $GLOBALS['ecs']->table('user_bonus') . ' SET ' .
                'used_time = 0, ' .
                'order_id = 0 ' .
                "WHERE bonus_id = '$bonus_id'";
    }
    $GLOBALS['db']->query($sql);
}

/**
 * ��ö�����Ϣ
 *
 * @access  private
 * @return  array
 */
function flow_order_info()
{
    $order = isset($_SESSION['flow_order']) ? $_SESSION['flow_order'] : array();

    /* ��ʼ�����ͺ�֧����ʽ */
    if (!isset($order['shipping_id']) || !isset($order['pay_id']))
    {
        /* �����û���������ͺ�֧�� */
        if ($_SESSION['user_id'] > 0)
        {
            /* �û��Ѿ���¼�ˣ������ϴ�ʹ�õ����ͺ�֧�� */
            $arr = last_shipping_and_payment();

            if (!isset($order['shipping_id']))
            {
                $order['shipping_id'] = $arr['shipping_id'];
            }
            if (!isset($order['pay_id']))
            {
                $order['pay_id'] = $arr['pay_id'];
            }
        }
        else
        {
            if (!isset($order['shipping_id']))
            {
                $order['shipping_id'] = 0;
            }
            if (!isset($order['pay_id']))
            {
                $order['pay_id'] = 0;
            }
        }
    }

    if (!isset($order['pack_id']))
    {
        $order['pack_id'] = 0;  // ��ʼ����װ
    }
    if (!isset($order['card_id']))
    {
        $order['card_id'] = 0;  // ��ʼ���ؿ�
    }
    if (!isset($order['bonus']))
    {
        $order['bonus'] = 0;    // ��ʼ�����
    }
    if (!isset($order['integral']))
    {
        $order['integral'] = 0; // ��ʼ������
    }
    if (!isset($order['surplus']))
    {
        $order['surplus'] = 0;  // ��ʼ�����
    }

    /* ��չ��Ϣ */
    if (isset($_SESSION['flow_type']) && intval($_SESSION['flow_type']) != CART_GENERAL_GOODS)
    {
        $order['extension_code'] = $_SESSION['extension_code'];
        $order['extension_id'] = $_SESSION['extension_id'];
    }

    return $order;
}

/**
 * �ϲ�����
 * @param   string  $from_order_sn  �Ӷ�����
 * @param   string  $to_order_sn    ��������
 * @return  �ɹ�����true��ʧ�ܷ��ش�����Ϣ
 */
function merge_order($from_order_sn, $to_order_sn)
{
    /* �����Ų���Ϊ�� */
    if (trim($from_order_sn) == '' || trim($to_order_sn) == '')
    {
        return $GLOBALS['_LANG']['order_sn_not_null'];
    }

    /* �����Ų�����ͬ */
    if ($from_order_sn == $to_order_sn)
    {
        return $GLOBALS['_LANG']['two_order_sn_same'];
    }

    /* ȡ�ö�����Ϣ */
    $from_order = order_info(0, $from_order_sn);
    $to_order   = order_info(0, $to_order_sn);

    /* ��鶩���Ƿ���� */
    if (!$from_order)
    {
        return sprintf($GLOBALS['_LANG']['order_not_exist'], $from_order_sn);
    }
    elseif (!$to_order)
    {
        return sprintf($GLOBALS['_LANG']['order_not_exist'], $to_order_sn);
    }

    /* ���ϲ��Ķ����Ƿ�Ϊ��ͨ����������ͨ����������ϲ� */
    if ($from_order['extension_code'] != '' || $to_order['extension_code'] != 0)
    {
        return $GLOBALS['_LANG']['merge_invalid_order'];
    }

    /* ��鶩��״̬�Ƿ�����ȷ�ϻ�δȷ�ϡ�δ���δ���� */
    if ($from_order['order_status'] != OS_UNCONFIRMED && $from_order['order_status'] != OS_CONFIRMED)
    {
        return sprintf($GLOBALS['_LANG']['os_not_unconfirmed_or_confirmed'], $from_order_sn);
    }
    elseif ($from_order['pay_status'] != PS_UNPAYED)
    {
        return sprintf($GLOBALS['_LANG']['ps_not_unpayed'], $from_order_sn);
    }
    elseif ($from_order['shipping_status'] != SS_UNSHIPPED)
    {
        return sprintf($GLOBALS['_LANG']['ss_not_unshipped'], $from_order_sn);
    }

    if ($to_order['order_status'] != OS_UNCONFIRMED && $to_order['order_status'] != OS_CONFIRMED)
    {
        return sprintf($GLOBALS['_LANG']['os_not_unconfirmed_or_confirmed'], $to_order_sn);
    }
    elseif ($to_order['pay_status'] != PS_UNPAYED)
    {
        return sprintf($GLOBALS['_LANG']['ps_not_unpayed'], $to_order_sn);
    }
    elseif ($to_order['shipping_status'] != SS_UNSHIPPED)
    {
        return sprintf($GLOBALS['_LANG']['ss_not_unshipped'], $to_order_sn);
    }

    /* ��鶩���û��Ƿ���ͬ */
    if ($from_order['user_id'] != $to_order['user_id'])
    {
        return $GLOBALS['_LANG']['order_user_not_same'];
    }

    /* �ϲ����� */
    $order = $to_order;
    $order['order_id']  = '';
    $order['add_time']  = gmtime();

    // �ϲ���Ʒ�ܶ�
    $order['goods_amount'] += $from_order['goods_amount'];

    // �ϲ��ۿ�
    $order['discount'] += $from_order['discount'];

    if ($order['shipping_id'] > 0)
    {
        // ���¼������ͷ���
        $weight_price       = order_weight_price($to_order['order_id']);
        $from_weight_price  = order_weight_price($from_order['order_id']);
        $weight_price['weight'] += $from_weight_price['weight'];
        $weight_price['amount'] += $from_weight_price['amount'];
        $weight_price['number'] += $from_weight_price['number'];

        $region_id_list = array($order['country'], $order['province'], $order['city'], $order['district']);
        $shipping_area = shipping_area_info($order['shipping_id'], $region_id_list);

        $order['shipping_fee'] = shipping_fee($shipping_area['shipping_code'],
            unserialize($shipping_area['configure']), $weight_price['weight'], $weight_price['amount'], $weight_price['number']);

        // ��������ˣ����¼��㱣�۷�
        if ($order['insure_fee'] > 0)
        {
            $order['insure_fee'] = shipping_insure_fee($shipping_area['shipping_code'], $order['goods_amount'], $shipping_area['insure']);
        }
    }

    // ���¼����װ�ѡ��ؿ���
    if ($order['pack_id'] > 0)
    {
        $pack = pack_info($order['pack_id']);
        $order['pack_fee'] = $pack['free_money'] > $order['goods_amount'] ? $pack['pack_fee'] : 0;
    }
    if ($order['card_id'] > 0)
    {
        $card = card_info($order['card_id']);
        $order['card_fee'] = $card['free_money'] > $order['goods_amount'] ? $card['card_fee'] : 0;
    }

    // ������䣬�ϲ����֡����Ѹ�����
    $order['integral']      += $from_order['integral'];
    $order['integral_money'] = value_of_integral($order['integral']);
    $order['surplus']       += $from_order['surplus'];
    $order['money_paid']    += $from_order['money_paid'];

    // ����Ӧ�����������֧�����ã�
    $order['order_amount'] = $order['goods_amount'] - $order['discount']
                           + $order['shipping_fee']
                           + $order['insure_fee']
                           + $order['pack_fee']
                           + $order['card_fee']
                           - $order['bonus']
                           - $order['integral_money']
                           - $order['surplus']
                           - $order['money_paid'];

    // ���¼���֧����
    if ($order['pay_id'] > 0)
    {
        // ��������������
        $cod_fee          = $shipping_area ? $shipping_area['pay_fee'] : 0;
        $order['pay_fee'] = pay_fee($order['pay_id'], $order['order_amount'], $cod_fee);

        // Ӧ���������֧����
        $order['order_amount'] += $order['pay_fee'];
    }

    /* ���붩���� */
    do
    {
        $order['order_sn'] = get_order_sn();
        if ($GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('order_info'), addslashes_deep($order), 'INSERT'))
        {
            break;
        }
        else
        {
            if ($GLOBALS['db']->errno() != 1062)
            {
                die($GLOBALS['db']->errorMsg());
            }
        }
    }
    while (true); // ��ֹ�������ظ�

    /* ������ */
    $order_id = $GLOBALS['db']->insert_id();

    /* ���¶�����Ʒ */
    $sql = 'UPDATE ' . $GLOBALS['ecs']->table('order_goods') .
            " SET order_id = '$order_id' " .
            "WHERE order_id " . db_create_in(array($from_order['order_id'], $to_order['order_id']));
    $GLOBALS['db']->query($sql);

    include_once(ROOT_PATH . 'includes/lib_clips.php');
    /* ����֧����־ */
    insert_pay_log($order_id, $order['order_amount'], PAY_ORDER);

    /* ɾ��ԭ���� */
    $sql = 'DELETE FROM ' . $GLOBALS['ecs']->table('order_info') .
            " WHERE order_id " . db_create_in(array($from_order['order_id'], $to_order['order_id']));
    $GLOBALS['db']->query($sql);

    /* ɾ��ԭ����֧����־ */
    $sql = 'DELETE FROM ' . $GLOBALS['ecs']->table('pay_log') .
            " WHERE order_id " . db_create_in(array($from_order['order_id'], $to_order['order_id']));
    $GLOBALS['db']->query($sql);

    /* ���� from_order �ĺ������Ϊֻʹ�� to_order �ĺ�� */
    if ($from_order['bonus_id'] > 0)
    {
        unuse_bonus($from_order['bonus_id']);
    }

    /* ���سɹ� */
    return true;
}

/**
 * ��ѯ�������������ĸ����´���Ͻ
 * @param   array   $regions    ��������1��2��3��4����˳��
 * @return  int     ���´�id������Ϊ0
 */
function get_agency_by_regions($regions)
{
    if (!is_array($regions) || empty($regions))
    {
        return 0;
    }

    $arr = array();
    $sql = "SELECT region_id, agency_id " .
            "FROM " . $GLOBALS['ecs']->table('region') .
            " WHERE region_id " . db_create_in($regions) .
            " AND region_id > 0 AND agency_id > 0";
    $res = $GLOBALS['db']->query($sql);
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        $arr[$row['region_id']] = $row['agency_id'];
    }
    if (empty($arr))
    {
        return 0;
    }

    $agency_id = 0;
    for ($i = count($regions) - 1; $i >= 0; $i--)
    {
        if (isset($arr[$regions[$i]]))
        {
            return $arr[$regions[$i]];
        }
    }
}

/**
 * ��ȡ���Ͳ����ʵ��
 * @param   int   $shipping_id    ���Ͳ��ID
 * @return  object     ���Ͳ������ʵ��
 */
function &get_shipping_object($shipping_id)
{
    $shipping  = shipping_info($shipping_id);
    if (!$shipping)
    {
        $object = new stdClass();
        return $object;
    }

    $file_path = ROOT_PATH.'includes/modules/shipping/' . $shipping['shipping_code'] . '.php';

    include_once($file_path);

    $object = new $shipping['shipping_code'];
    return $object;
}

/**
 * �ı䶩������Ʒ���
 * @param   int     $order_id   ������
 * @param   bool    $is_dec     �Ƿ���ٿ��
 * @param   bool    $storage     ������ʱ����1���¶���ʱ��0������ʱ��
 */
function change_order_goods_storage($order_id, $is_dec = true, $storage = 0)
{
    /* ��ѯ������Ʒ��Ϣ */
    switch ($storage)
    {
        case 0 :
            $sql = "SELECT goods_id, SUM(send_number) AS num, MAX(extension_code) AS extension_code, product_id FROM " . $GLOBALS['ecs']->table('order_goods') .
                    " WHERE order_id = '$order_id' AND is_real = 1 GROUP BY goods_id, product_id";
        break;

        case 1 :
            $sql = "SELECT goods_id, SUM(goods_number) AS num, MAX(extension_code) AS extension_code, product_id FROM " . $GLOBALS['ecs']->table('order_goods') .
                    " WHERE order_id = '$order_id' AND is_real = 1 GROUP BY goods_id, product_id";
        break;
    }

    $res = $GLOBALS['db']->query($sql);
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        if ($row['extension_code'] != "package_buy")
        {
            if ($is_dec)
            {
                change_goods_storage($row['goods_id'], $row['product_id'], - $row['num']);
            }
            else
            {
                change_goods_storage($row['goods_id'], $row['product_id'], $row['num']);
            }
            $GLOBALS['db']->query($sql);
        }
        else
        {
            $sql = "SELECT goods_id, goods_number" .
                   " FROM " . $GLOBALS['ecs']->table('package_goods') .
                   " WHERE package_id = '" . $row['goods_id'] . "'";
            $res_goods = $GLOBALS['db']->query($sql);
            while ($row_goods = $GLOBALS['db']->fetchRow($res_goods))
            {
                $sql = "SELECT is_real" .
                   " FROM " . $GLOBALS['ecs']->table('goods') .
                   " WHERE goods_id = '" . $row_goods['goods_id'] . "'";
                $real_goods = $GLOBALS['db']->query($sql);
                $is_goods = $GLOBALS['db']->fetchRow($real_goods);

                if ($is_dec)
                {
                    change_goods_storage($row_goods['goods_id'], $row['product_id'], - ($row['num'] * $row_goods['goods_number']));
                }
                elseif ($is_goods['is_real'])
                {
                    change_goods_storage($row_goods['goods_id'], $row['product_id'], ($row['num'] * $row_goods['goods_number']));
                }
            }
        }
    }

}

/**
 * ��Ʒ�������� ��Ʒ��������
 *
 * @param   int    $good_id         ��ƷID
 * @param   int    $product_id      ��ƷID
 * @param   int    $number          ����������Ĭ��0��
 *
 * @return  bool               true���ɹ���false��ʧ�ܣ�
 */
function change_goods_storage($good_id, $product_id, $number = 0)
{
    if ($number == 0)
    {
        return true; // ֵΪ0����������������������true
    }

    if (empty($good_id) || empty($number))
    {
        return false;
    }

    $number = ($number > 0) ? '+ ' . $number : $number;

    /* �����Ʒ��� */
    $products_query = true;
    if (!empty($product_id))
    {
        $sql = "UPDATE " . $GLOBALS['ecs']->table('products') ."
                SET product_number = product_number $number
                WHERE goods_id = '$good_id'
                AND product_id = '$product_id'
                LIMIT 1";
        $products_query = $GLOBALS['db']->query($sql);
    }

    /* ������Ʒ��� */
    $sql = "UPDATE " . $GLOBALS['ecs']->table('goods') ."
            SET goods_number = goods_number $number
            WHERE goods_id = '$good_id'
            LIMIT 1";
    $query = $GLOBALS['db']->query($sql);

    if ($query && $products_query)
    {
        return true;
    }
    else
    {
        return false;
    }
}

/**
 * ȡ��֧����ʽid�б�
 * @param   bool    $is_cod �Ƿ��������
 * @return  array
 */
function payment_id_list($is_cod)
{
    $sql = "SELECT pay_id FROM " . $GLOBALS['ecs']->table('payment');
    if ($is_cod)
    {
        $sql .= " WHERE is_cod = 1";
    }
    else
    {
        $sql .= " WHERE is_cod = 0";
    }

    return $GLOBALS['db']->getCol($sql);
}

/**
 * ���ɲ�ѯ������sql
 * @param   string  $type   ����
 * @param   string  $alias  order��ı���������.���� o.��
 * @return  string
 */
function order_query_sql($type = 'finished', $alias = '')
{
    /* ����ɶ��� */
    if ($type == 'finished')
    {
        return " AND {$alias}order_status " . db_create_in(array(OS_CONFIRMED, OS_SPLITED)) .
               " AND {$alias}shipping_status " . db_create_in(array(SS_SHIPPED, SS_RECEIVED)) .
               " AND {$alias}pay_status " . db_create_in(array(PS_PAYED, PS_PAYING)) . " ";
    }
    /* ���������� */
    elseif ($type == 'await_ship')
    {
        return " AND   {$alias}order_status " .
                 db_create_in(array(OS_CONFIRMED, OS_SPLITED, OS_SPLITING_PART)) .
               " AND   {$alias}shipping_status " .
                 db_create_in(array(SS_UNSHIPPED, SS_PREPARING, SS_SHIPPED_ING)) .
               " AND ( {$alias}pay_status " . db_create_in(array(PS_PAYED, PS_PAYING)) . " OR {$alias}pay_id " . db_create_in(payment_id_list(true)) . ") ";
    }
    /* ������� */
    elseif ($type == 'await_pay')
    {
        return " AND   {$alias}order_status " . db_create_in(array(OS_CONFIRMED, OS_SPLITED)) .
               " AND   {$alias}pay_status = '" . PS_UNPAYED . "'" .
               " AND ( {$alias}shipping_status " . db_create_in(array(SS_SHIPPED, SS_RECEIVED)) . " OR {$alias}pay_id " . db_create_in(payment_id_list(false)) . ") ";
    }
    /* δȷ�϶��� */
    elseif ($type == 'unconfirmed')
    {
        return " AND {$alias}order_status = '" . OS_UNCONFIRMED . "' ";
    }
    /* δ���������û��ɲ��� */
    elseif ($type == 'unprocessed')
    {
        return " AND {$alias}order_status " . db_create_in(array(OS_UNCONFIRMED, OS_CONFIRMED)) .
               " AND {$alias}shipping_status = '" . SS_UNSHIPPED . "'" .
               " AND {$alias}pay_status = '" . PS_UNPAYED . "' ";
    }
    /* δ����δ��������������Ա�ɲ��� */
    elseif ($type == 'unpay_unship')
    {
        return " AND {$alias}order_status " . db_create_in(array(OS_UNCONFIRMED, OS_CONFIRMED)) .
               " AND {$alias}shipping_status " . db_create_in(array(SS_UNSHIPPED, SS_PREPARING)) .
               " AND {$alias}pay_status = '" . PS_UNPAYED . "' ";
    }
    /* �ѷ��������������Ƿ񸶿� */
    elseif ($type == 'shipped')
    {
        return " AND {$alias}order_status = '" . OS_CONFIRMED . "'" .
               " AND {$alias}shipping_status " . db_create_in(array(SS_SHIPPED, SS_RECEIVED)) . " ";
    }
    else
    {
        die('���� order_query_sql ��������');
    }
}

/**
 * ���ɲ�ѯ�����ܽ����ֶ�
 * @param   string  $alias  order��ı���������.���� o.��
 * @return  string
 */
function order_amount_field($alias = '')
{
    return "   {$alias}goods_amount + {$alias}tax + {$alias}shipping_fee" .
           " + {$alias}insure_fee + {$alias}pay_fee + {$alias}pack_fee" .
           " + {$alias}card_fee ";
}

/**
 * ���ɼ���Ӧ��������ֶ�
 * @param   string  $alias  order��ı���������.���� o.��
 * @return  string
 */
function order_due_field($alias = '')
{
    return order_amount_field($alias) .
            " - {$alias}money_paid - {$alias}surplus - {$alias}integral_money" .
            " - {$alias}bonus - {$alias}discount ";
}

/**
 * �����ۿۣ����ݹ��ﳵ���Żݻ
 * @return  float   �ۿ�
 */
function compute_discount()
{
    /* ��ѯ�Żݻ */
    $now = gmtime();
    $user_rank = ',' . $_SESSION['user_rank'] . ',';
    $sql = "SELECT *" .
            "FROM " . $GLOBALS['ecs']->table('favourable_activity') .
            " WHERE start_time <= '$now'" .
            " AND end_time >= '$now'" .
            " AND CONCAT(',', user_rank, ',') LIKE '%" . $user_rank . "%'" .
            " AND act_type " . db_create_in(array(FAT_DISCOUNT, FAT_PRICE));
    $favourable_list = $GLOBALS['db']->getAll($sql);
    if (!$favourable_list)
    {
        return 0;
    }

    /* ��ѯ���ﳵ��Ʒ */
    $sql = "SELECT c.goods_id, c.goods_price * c.goods_number AS subtotal, g.cat_id, g.brand_id " .
            "FROM " . $GLOBALS['ecs']->table('cart') . " AS c, " . $GLOBALS['ecs']->table('goods') . " AS g " .
            "WHERE c.goods_id = g.goods_id " .
            "AND c.session_id = '" . SESS_ID . "' " .
            "AND c.parent_id = 0 " .
            "AND c.is_gift = 0 " .
            "AND rec_type = '" . CART_GENERAL_GOODS . "'";
    $goods_list = $GLOBALS['db']->getAll($sql);
    if (!$goods_list)
    {
        return 0;
    }

    /* ��ʼ���ۿ� */
    $discount = 0;
    $favourable_name = array();

    /* ѭ������ÿ���Żݻ���ۿ� */
    foreach ($favourable_list as $favourable)
    {
        $goods_count = 0;
        $total_amount = 0;
        if ($favourable['act_range'] == FAR_ALL)
        {
            foreach ($goods_list as $goods)
            {
                $total_amount += $goods['subtotal'];
                $goods_count += 1;
            }
        }
        elseif ($favourable['act_range'] == FAR_CATEGORY)
        {
            /* �ҳ�����id���ӷ���id */
            $id_list = array();
            $raw_id_list = explode(',', $favourable['act_range_ext']);
            foreach ($raw_id_list as $id)
            {
                $id_list = array_merge($id_list, array_keys(cat_list($id, 0, false)));
            }
            $ids = join(',', array_unique($id_list));

            foreach ($goods_list as $goods)
            {
                if (strpos(',' . $ids . ',', ',' . $goods['cat_id'] . ',') !== false)
                {
                    $total_amount += $goods['subtotal'];
                    $goods_count += 1;
                }
            }
        }
        elseif ($favourable['act_range'] == FAR_BRAND)
        {
            foreach ($goods_list as $goods)
            {
                if (strpos(',' . $favourable['act_range_ext'] . ',', ',' . $goods['brand_id'] . ',') !== false)
                {
                    $total_amount += $goods['subtotal'];
                    $goods_count += 1;
                }
            }
        }
        elseif ($favourable['act_range'] == FAR_GOODS)
        {
            foreach ($goods_list as $goods)
            {
                if (strpos(',' . $favourable['act_range_ext'] . ',', ',' . $goods['goods_id'] . ',') !== false)
                {
                    $total_amount += $goods['subtotal'];
                }
            }
        }
        else
        {
            continue;
        }

        /* �����������������ۼ��ۿ� */
        $condition_1 = ($total_amount > 0 && $total_amount >= $favourable['min_amount'] && ($total_amount <= $favourable['max_amount'] || $favourable['max_amount'] == 0));
        $condition_2 = ($goods_count >= $favourable['max_amount'] );
        if ($condition_1 || $condition_2)
        {
            if ($favourable['act_type'] == FAT_DISCOUNT)
            {
                $discount += $total_amount * (1 - $favourable['act_type_ext'] / 100);

                $favourable_name[] = $favourable['act_name'];
            }
            elseif ($favourable['act_type'] == FAT_PRICE)
            {
                $discount += $favourable['act_type_ext'];

                $favourable_name[] = $favourable['act_name'];
            }
        }
    }

    return array('discount' => $discount, 'name' => $favourable_name);
}

/**
 * ȡ�ù��ﳵ�����͵Ļ�����
 * @return  int     ������
 */
function get_give_integral()
{
        $sql = "SELECT SUM(c.goods_number * IF(g.give_integral > -1, g.give_integral, c.goods_price))" .
                "FROM " . $GLOBALS['ecs']->table('cart') . " AS c, " .
                          $GLOBALS['ecs']->table('goods') . " AS g " .
                "WHERE c.goods_id = g.goods_id " .
                "AND c.session_id = '" . SESS_ID . "' " .
                "AND c.goods_id > 0 " .
                "AND c.parent_id = 0 " .
                "AND c.rec_type = 0 " .
                "AND c.is_gift = 0";

        return intval($GLOBALS['db']->getOne($sql));
}

/**
 * ȡ��ĳ����Ӧ�����͵Ļ�����
 * @param   array   $order  ����
 * @return  int     ������
 */
function integral_to_give($order)
{
    /* �ж��Ƿ��Ź� */
    if ($order['extension_code'] == 'group_buy')
    {
        include_once(ROOT_PATH . 'includes/lib_goods.php');
        $group_buy = group_buy_info(intval($order['extension_id']));

        return array('custom_points' => $group_buy['gift_integral'], 'rank_points' => $order['goods_amount']);
    }
    else
    {
        $sql = "SELECT SUM(og.goods_number * IF(g.give_integral > -1, g.give_integral, og.goods_price)) AS custom_points, SUM(og.goods_number * IF(g.rank_integral > -1, g.rank_integral, og.goods_price)) AS rank_points " .
                "FROM " . $GLOBALS['ecs']->table('order_goods') . " AS og, " .
                          $GLOBALS['ecs']->table('goods') . " AS g " .
                "WHERE og.goods_id = g.goods_id " .
                "AND og.order_id = '$order[order_id]' " .
                "AND og.goods_id > 0 " .
                "AND og.parent_id = 0 " .
                "AND og.is_gift = 0 AND og.extension_code != 'package_buy'";

        return $GLOBALS['db']->getRow($sql);
    }
}

/**
 * �����������ʱ�����
 * @param   int     $order_id   ������
 * @return  bool
 */
function send_order_bonus($order_id)
{
    /* ȡ�ö���Ӧ�÷��ŵĺ�� */
    $bonus_list = order_bonus($order_id);

    /* ����к����ͳ�Ʋ����� */
    if ($bonus_list)
    {
        /* �û���Ϣ */
        $sql = "SELECT u.user_id, u.user_name, u.email " .
                "FROM " . $GLOBALS['ecs']->table('order_info') . " AS o, " .
                          $GLOBALS['ecs']->table('users') . " AS u " .
                "WHERE o.order_id = '$order_id' " .
                "AND o.user_id = u.user_id ";
        $user = $GLOBALS['db']->getRow($sql);

        /* ͳ�� */
        $count = 0;
        $money = '';
        foreach ($bonus_list AS $bonus)
        {
            $count += $bonus['number'];
            $money .= price_format($bonus['type_money']) . ' [' . $bonus['number'] . '], ';

            /* �޸��û���� */
            $sql = "INSERT INTO " . $GLOBALS['ecs']->table('user_bonus') . " (bonus_type_id, user_id) " .
                    "VALUES('$bonus[type_id]', '$user[user_id]')";
            for ($i = 0; $i < $bonus['number']; $i++)
            {
                if (!$GLOBALS['db']->query($sql))
                {
                    return $GLOBALS['db']->errorMsg();
                }
            }
        }

        /* ����к���������ʼ� */
        if ($count > 0)
        {
            $tpl = get_mail_template('send_bonus');
            $GLOBALS['smarty']->assign('user_name', $user['user_name']);
            $GLOBALS['smarty']->assign('count', $count);
            $GLOBALS['smarty']->assign('money', $money);
            $GLOBALS['smarty']->assign('shop_name', $GLOBALS['_CFG']['shop_name']);
            $GLOBALS['smarty']->assign('send_date', local_date($GLOBALS['_CFG']['date_format']));
            $GLOBALS['smarty']->assign('sent_date', local_date($GLOBALS['_CFG']['date_format']));
            $content = $GLOBALS['smarty']->fetch('str:' . $tpl['template_content']);
            send_mail($user['user_name'], $user['email'], $tpl['template_subject'], $content, $tpl['is_html']);
        }
    }

    return true;
}

/**
 * ���ض������ŵĺ��
 * @param   int     $order_id   ����id
 */
function return_order_bonus($order_id)
{
    /* ȡ�ö���Ӧ�÷��ŵĺ�� */
    $bonus_list = order_bonus($order_id);

    /* ɾ�� */
    if ($bonus_list)
    {
        /* ȡ�ö�����Ϣ */
        $order = order_info($order_id);
        $user_id = $order['user_id'];

        foreach ($bonus_list AS $bonus)
        {
            $sql = "DELETE FROM " . $GLOBALS['ecs']->table('user_bonus') .
                    " WHERE bonus_type_id = '$bonus[type_id]' " .
                    "AND user_id = '$user_id' " .
                    "AND order_id = '0' LIMIT " . $bonus['number'];
            $GLOBALS['db']->query($sql);
        }
    }
}

/**
 * ȡ�ö���Ӧ�÷��ŵĺ��
 * @param   int     $order_id   ����id
 * @return  array
 */
function order_bonus($order_id)
{
    /* ��ѯ����Ʒ���ĺ�� */
    $day    = getdate();
    $today  = local_mktime(23, 59, 59, $day['mon'], $day['mday'], $day['year']);

    $sql = "SELECT b.type_id, b.type_money, SUM(o.goods_number) AS number " .
            "FROM " . $GLOBALS['ecs']->table('order_goods') . " AS o, " .
                      $GLOBALS['ecs']->table('goods') . " AS g, " .
                      $GLOBALS['ecs']->table('bonus_type') . " AS b " .
            " WHERE o.order_id = '$order_id' " .
            " AND o.is_gift = 0 " .
            " AND o.goods_id = g.goods_id " .
            " AND g.bonus_type_id = b.type_id " .
            " AND b.send_type = '" . SEND_BY_GOODS . "' " .
            " AND b.send_start_date <= '$today' " .
            " AND b.send_end_date >= '$today' " .
            " GROUP BY b.type_id ";
    $list = $GLOBALS['db']->getAll($sql);

    /* ��ѯ�����з���Ʒ�ܽ�� */
    $amount = order_amount($order_id, false);

    /* ��ѯ�������� */
    $sql = "SELECT add_time " .
            " FROM " . $GLOBALS['ecs']->table('order_info') .
            " WHERE order_id = '$order_id' LIMIT 1";
    $order_time = $GLOBALS['db']->getOne($sql);

    /* ��ѯ���������ĺ�� */
    $sql = "SELECT type_id, type_money, IFNULL(FLOOR('$amount' / min_amount), 1) AS number " .
            "FROM " . $GLOBALS['ecs']->table('bonus_type') .
            "WHERE send_type = '" . SEND_BY_ORDER . "' " .
            "AND send_start_date <= '$order_time' " .
            "AND send_end_date >= '$order_time' ";
    $list = array_merge($list, $GLOBALS['db']->getAll($sql));

    return $list;
}

/**
 * ���㹺�ﳵ�е���Ʒ�����ܺ��֧�����ܶ�
 * @return  float   ���ܺ��֧�����ܶ�
 */
function compute_discount_amount()
{
    /* ��ѯ�Żݻ */
    $now = gmtime();
    $user_rank = ',' . $_SESSION['user_rank'] . ',';
    $sql = "SELECT *" .
            "FROM " . $GLOBALS['ecs']->table('favourable_activity') .
            " WHERE start_time <= '$now'" .
            " AND end_time >= '$now'" .
            " AND CONCAT(',', user_rank, ',') LIKE '%" . $user_rank . "%'" .
            " AND act_type " . db_create_in(array(FAT_DISCOUNT, FAT_PRICE));
    $favourable_list = $GLOBALS['db']->getAll($sql);
    if (!$favourable_list)
    {
        return 0;
    }

    /* ��ѯ���ﳵ��Ʒ */
    $sql = "SELECT c.goods_id, c.goods_price * c.goods_number AS subtotal, g.cat_id, g.brand_id " .
            "FROM " . $GLOBALS['ecs']->table('cart') . " AS c, " . $GLOBALS['ecs']->table('goods') . " AS g " .
            "WHERE c.goods_id = g.goods_id " .
            "AND c.session_id = '" . SESS_ID . "' " .
            "AND c.parent_id = 0 " .
            "AND c.is_gift = 0 " .
            "AND rec_type = '" . CART_GENERAL_GOODS . "'";
    $goods_list = $GLOBALS['db']->getAll($sql);
    if (!$goods_list)
    {
        return 0;
    }

    /* ��ʼ���ۿ� */
    $discount = 0;
    $favourable_name = array();

    /* ѭ������ÿ���Żݻ���ۿ� */
    foreach ($favourable_list as $favourable)
    {
        $total_amount = 0;
        if ($favourable['act_range'] == FAR_ALL)
        {
            foreach ($goods_list as $goods)
            {
                $total_amount += $goods['subtotal'];
            }
        }
        elseif ($favourable['act_range'] == FAR_CATEGORY)
        {
            /* �ҳ�����id���ӷ���id */
            $id_list = array();
            $raw_id_list = explode(',', $favourable['act_range_ext']);
            foreach ($raw_id_list as $id)
            {
                $id_list = array_merge($id_list, array_keys(cat_list($id, 0, false)));
            }
            $ids = join(',', array_unique($id_list));

            foreach ($goods_list as $goods)
            {
                if (strpos(',' . $ids . ',', ',' . $goods['cat_id'] . ',') !== false)
                {
                    $total_amount += $goods['subtotal'];
                }
            }
        }
        elseif ($favourable['act_range'] == FAR_BRAND)
        {
            foreach ($goods_list as $goods)
            {
                if (strpos(',' . $favourable['act_range_ext'] . ',', ',' . $goods['brand_id'] . ',') !== false)
                {
                    $total_amount += $goods['subtotal'];
                }
            }
        }
        elseif ($favourable['act_range'] == FAR_GOODS)
        {
            foreach ($goods_list as $goods)
            {
                if (strpos(',' . $favourable['act_range_ext'] . ',', ',' . $goods['goods_id'] . ',') !== false)
                {
                    $total_amount += $goods['subtotal'];
                }
            }
        }
        else
        {
            continue;
        }
        if ($total_amount > 0 && $total_amount >= $favourable['min_amount'] && ($total_amount <= $favourable['max_amount'] || $favourable['max_amount'] == 0))
        {
            if ($favourable['act_type'] == FAT_DISCOUNT)
            {
                $discount += $total_amount * (1 - $favourable['act_type_ext'] / 100);
            }
            elseif ($favourable['act_type'] == FAT_PRICE)
            {
                $discount += $favourable['act_type_ext'];
            }
        }
    }


    return $discount;
}

/**
 * �����������ﳵ
 *
 * @access  public
 * @param   integer $package_id   ������
 * @param   integer $num          �������
 * @return  boolean
 */
function add_package_to_cart($package_id, $num = 1)
{
    $GLOBALS['err']->clean();

    /* ȡ�������Ϣ */
    $package = get_package_info($package_id);

    if (empty($package))
    {
        $GLOBALS['err']->add($GLOBALS['_LANG']['goods_not_exists'], ERR_NOT_EXISTS);

        return false;
    }

    /* �Ƿ��������� */
    if ($package['is_on_sale'] == 0)
    {
        $GLOBALS['err']->add($GLOBALS['_LANG']['not_on_sale'], ERR_NOT_ON_SALE);

        return false;
    }

    /* ���п���Ƿ��ܴ���һ����� */
    if ($GLOBALS['_CFG']['use_storage'] == '1' && judge_package_stock($package_id))
    {
        $GLOBALS['err']->add(sprintf($GLOBALS['_LANG']['shortage'], 1), ERR_OUT_OF_STOCK);

        return false;
    }

    /* ����� */
//    if ($GLOBALS['_CFG']['use_storage'] == 1 && $num > $package['goods_number'])
//    {
//        $num = $goods['goods_number'];
//        $GLOBALS['err']->add(sprintf($GLOBALS['_LANG']['shortage'], $num), ERR_OUT_OF_STOCK);
//
//        return false;
//    }

    /* ��ʼ��Ҫ���빺�ﳵ�Ļ��������� */
    $parent = array(
        'user_id'       => $_SESSION['user_id'],
        'session_id'    => SESS_ID,
        'goods_id'      => $package_id,
        'goods_sn'      => '',
        'goods_name'    => addslashes($package['package_name']),
        'market_price'  => $package['market_package'],
        'goods_price'   => $package['package_price'],
        'goods_number'  => $num,
        'goods_attr'    => '',
        'goods_attr_id' => '',
        'is_real'       => $package['is_real'],
        'extension_code'=> 'package_buy',
        'is_gift'       => 0,
        'rec_type'      => CART_GENERAL_GOODS
    );

    /* ���������Ϊ0����Ϊ���������� */
    if ($num > 0)
    {
         /* ������Ʒ�Ƿ��Ѿ������ڹ��ﳵ�� */
        $sql = "SELECT goods_number FROM " .$GLOBALS['ecs']->table('cart').
                " WHERE session_id = '" .SESS_ID. "' AND goods_id = '" . $package_id . "' ".
                " AND parent_id = 0 AND extension_code = 'package_buy' " .
                " AND rec_type = '" . CART_GENERAL_GOODS . "'";

        $row = $GLOBALS['db']->getRow($sql);

        if($row) //������ﳵ�Ѿ��д���Ʒ�������
        {
            $num += $row['goods_number'];
            if ($GLOBALS['_CFG']['use_storage'] == 0 || $num > 0)
            {
                $sql = "UPDATE " . $GLOBALS['ecs']->table('cart') . " SET goods_number = '" . $num . "'" .
                       " WHERE session_id = '" .SESS_ID. "' AND goods_id = '$package_id' ".
                       " AND parent_id = 0 AND extension_code = 'package_buy' " .
                       " AND rec_type = '" . CART_GENERAL_GOODS . "'";
                $GLOBALS['db']->query($sql);
            }
            else
            {
                $GLOBALS['err']->add(sprintf($GLOBALS['_LANG']['shortage'], $num), ERR_OUT_OF_STOCK);
                return false;
            }
        }
        else //���ﳵû�д���Ʒ�������
        {
            $GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('cart'), $parent, 'INSERT');
        }
    }

    /* ����Ʒɾ�� */
    $sql = "DELETE FROM " . $GLOBALS['ecs']->table('cart') . " WHERE session_id = '" . SESS_ID . "' AND is_gift <> 0";
    $GLOBALS['db']->query($sql);

    return true;
}

/**
 * �õ��·�������
 * @return  string
 */
function get_delivery_sn()
{
    /* ѡ��һ������ķ��� */
    mt_srand((double) microtime() * 1000000);

    return date('YmdHi') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
}

/**
 * ����������Ʒ�Ŀ��
 * @return  boolen
 */
function judge_package_stock($package_id, $package_num = 1)
{
    $sql = "SELECT goods_id, product_id, goods_number
            FROM " . $GLOBALS['ecs']->table('package_goods') . "
            WHERE package_id = '" . $package_id . "'";
    $row = $GLOBALS['db']->getAll($sql);
    if (empty($row))
    {
        return true;
    }

    /* �����Ʒ����Ʒ */
    $goods = array('product_ids' => '', 'goods_ids' => '');
    foreach ($row as $value)
    {
        if ($value['product_id'] > 0)
        {
            $goods['product_ids'] .= ',' . $value['product_id'];
            continue;
        }

        $goods['goods_ids'] .= ',' . $value['goods_id'];
    }

    /* ����Ʒ��� */
    if ($goods['product_ids'] != '')
    {
        $sql = "SELECT p.product_id
                FROM " . $GLOBALS['ecs']->table('products') . " AS p, " . $GLOBALS['ecs']->table('package_goods') . " AS pg
                WHERE pg.product_id = p.product_id
                AND pg.package_id = '$package_id'
                AND pg.goods_number * $package_num > p.product_number
                AND p.product_id IN (" . trim($goods['product_ids'], ',') . ")";
        $row = $GLOBALS['db']->getAll($sql);

        if (!empty($row))
        {
            return true;
        }
    }

    /* �����Ʒ��� */
    if ($goods['goods_ids'] != '')
    {
        $sql = "SELECT g.goods_id
                FROM " . $GLOBALS['ecs']->table('goods') . "AS g, " . $GLOBALS['ecs']->table('package_goods') . " AS pg
                WHERE pg.goods_id = g.goods_id
                AND pg.goods_number * $package_num > g.goods_number
                AND pg.package_id = '" . $package_id . "'
                AND pg.goods_id IN (" . trim($goods['goods_ids'], ',') . ")";
        $row = $GLOBALS['db']->getAll($sql);

        if (!empty($row))
        {
            return true;
        }
    }

    return false;
}
?>