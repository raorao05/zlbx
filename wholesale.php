<?php

/**
 * ECSHOP ����ǰ̨�ļ�
 * ============================================================================
 * ��Ȩ���� 2005-2010 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * @author:     scott ye <scott.yell@gmail.com>
 * @version:    v2.x
 * ---------------------------------------------
 * $Author: yehuaixiao $
 * $Id: wholesale.php 17218 2011-01-24 04:10:41Z yehuaixiao $
 */

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

/* ���û��¼����ʾ��¼ */
if ($_SESSION['user_rank'] <= 0)
{
    show_message($_LANG['ws_user_rank'], $_LANG['ws_return_home'], 'index.php');
}

/*------------------------------------------------------ */
//-- act ������ĳ�ʼ��
/*------------------------------------------------------ */
if (empty($_REQUEST['act']))
{
    $_REQUEST['act'] = 'list';
}

/*------------------------------------------------------ */
//-- ������б�
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'list')
{
    $search_category = empty($_REQUEST['search_category']) ? 0 : intval($_REQUEST['search_category']);
    $search_keywords = isset($_REQUEST['search_keywords']) ? trim($_REQUEST['search_keywords']) : '';
    $param = array(); // ��ҳ�������������б�

    /* ��ѯ��������ǰ�û��Ļ�Ա�ȼ��������ؼ��֣� */
    $where = " WHERE g.goods_id = w.goods_id
               AND w.enabled = 1
               AND CONCAT(',', w.rank_ids, ',') LIKE '" . '%,' . $_SESSION['user_rank'] . ',%' . "' ";

    /* ���� */
    /* ������� */
    if ($search_category)
    {
        $where .= " AND g.cat_id = '$search_category' ";
        $param['search_category'] = $search_category;
        $smarty->assign('search_category', $search_category);
    }
    /* ������Ʒ���ƺ͹ؼ��� */
    if ($search_keywords)
    {
        $where .= " AND (g.keywords LIKE '%$search_keywords%'
                    OR g.goods_name LIKE '%$search_keywords%') ";
        $param['search_keywords'] = $search_keywords;
        $smarty->assign('search_keywords', $search_keywords);
    }

    /* ȡ��������Ʒ���� */
    $sql = "SELECT COUNT(*) FROM " . $ecs->table('wholesale') . " AS w, " . $ecs->table('goods') . " AS g " . $where;
    $count = $db->getOne($sql);

    if ($count > 0)
    {
        $default_display_type = $_CFG['show_order_type'] == '0' ? 'list' : 'text';
        $display  = (isset($_REQUEST['display']) && in_array(trim(strtolower($_REQUEST['display'])), array('list', 'text'))) ? trim($_REQUEST['display']) : (isset($_COOKIE['ECS']['display']) ? $_COOKIE['ECS']['display'] : $default_display_type);
        $display  = in_array($display, array('list', 'text')) ? $display : 'text';
        setcookie('ECS[display]', $display, gmtime() + 86400 * 7);

        /* ȡ��ÿҳ��¼�� */
        $size = isset($_CFG['page_size']) && intval($_CFG['page_size']) > 0 ? intval($_CFG['page_size']) : 10;

        /* ������ҳ�� */
        $page_count = ceil($count / $size);

        /* ȡ�õ�ǰҳ */
        $page = isset($_REQUEST['page']) && intval($_REQUEST['page']) > 0 ? intval($_REQUEST['page']) : 1;
        $page = $page > $page_count ? $page_count : $page;

        /* ȡ�õ�ǰҳ��������Ʒ */
        $wholesale_list = wholesale_list($size, $page, $where);
        $smarty->assign('wholesale_list', $wholesale_list);

        $param['act'] = 'list';
        $pager = get_pager('wholesale.php', array_reverse ($param, TRUE), $count, $page, $size);
        $pager['display'] = $display;
        $smarty->assign('pager', $pager);

        /* ������Ʒ���ﳵ */
        $smarty->assign('cart_goods', isset($_SESSION['wholesale_goods']) ? $_SESSION['wholesale_goods'] : array());
    }

    /* ģ�帳ֵ */
    assign_template();
    $position = assign_ur_here();
    $smarty->assign('page_title', $position['title']);    // ҳ�����
    $smarty->assign('ur_here',    $position['ur_here']);  // ��ǰλ��
    $smarty->assign('categories', get_categories_tree()); // ������
    $smarty->assign('helps',      get_shop_help());       // �������
    $smarty->assign('top_goods',  get_top10());           // ��������

    assign_dynamic('wholesale');

    /* ��ʾģ�� */
    $smarty->display('wholesale_list.dwt');
}

/*------------------------------------------------------ */
//-- ���ؼ۸�
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'price_list')
{
    $data = $_LANG['goods_name'] . "\t" . $_LANG['goods_attr'] . "\t" . $_LANG['number'] . "\t" . $_LANG['ws_price'] . "\t\n";
    $sql = "SELECT * FROM " . $ecs->table('wholesale') .
            "WHERE enabled = 1 AND CONCAT(',', rank_ids, ',') LIKE '" . '%,' . $_SESSION['user_rank'] . ',%' . "'";
    $res = $db->query($sql);
    while ($row = $db->fetchRow($res))
    {
        $price_list = unserialize($row['prices']);
        foreach ($price_list as $attr_price)
        {
            if ($attr_price['attr'])
            {
                $sql = "SELECT attr_value FROM " . $ecs->table('goods_attr') .
                        " WHERE goods_attr_id " . db_create_in($attr_price['attr']);
                $goods_attr = join(',', $db->getCol($sql));
            }
            else
            {
                $goods_attr = '';
            }
            foreach ($attr_price['qp_list'] as $qp)
            {
                $data .= $row['goods_name'] . "\t" . $goods_attr . "\t" . $qp['quantity'] . "\t" . $qp['price'] . "\t\n";
            }
        }
    }

    header("Content-type: application/vnd.ms-excel; charset=GB2312");
    header("Content-Disposition: attachment; filename=price_list.xls");
    if (EC_CHARSET == 'utf-8')
    {
        echo ecs_iconv('UTF8', 'GB2312', $data);
    }
    else
    {
        echo $data;
    }
}

/*------------------------------------------------------ */
//-- ���빺�ﳵ
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'add_to_cart')
{
    /* ȡ�ò��� */
    $act_id         = intval($_POST['act_id']);
    $goods_number   = $_POST['goods_number'][$act_id];
    $attr_id        = isset($_POST['attr_id']) ? $_POST['attr_id'] : array();
    if(isset($attr_id[$act_id]))
    {
        $goods_attr     = $attr_id[$act_id];
    }

    /* �û��ύ����ȫ��ͨ����飬������Ϊ��ɲ��� */

    /* ������� */
    if (empty($goods_number) || (is_array($goods_number) && array_sum($goods_number) <= 0))
    {
        show_message($_LANG['ws_invalid_goods_number']);
    }

    /* ȷ��������Ʒ�б� */
    $goods_list = array();
    if (is_array($goods_number))
    {
        foreach ($goods_number as $key => $value)
        {
            if (!$value)
            {
                unset($goods_number[$key], $goods_attr[$key]);
                continue;
            }

            $goods_list[] = array('number' => $goods_number[$key], 'goods_attr' => $goods_attr[$key]);
        }
    }
    else
    {
        $goods_list[0] = array('number' => $goods_number, 'goods_attr' => '');
    }

    /* ȡ����������� */
    $wholesale = wholesale_info($act_id);

    /* ���session�и���Ʒ���������Ƿ���� */
    if (isset($_SESSION['wholesale_goods']))
    {
        foreach ($_SESSION['wholesale_goods'] as $goods)
        {
            if ($goods['goods_id'] == $wholesale['goods_id'])
            {
                if (empty($goods_attr))
                {
                    show_message($_LANG['ws_goods_attr_exists']);
                }
                elseif (in_array($goods['goods_attr_id'], $goods_attr))
                {
                    show_message($_LANG['ws_goods_attr_exists']);
                }
            }
        }
    }

    /* ��ȡ������Ʒ�����������ļ۸���� ��һ���������������ϡ�һ��������ϡ�һ�����ԡ������ԣ� */
    $attr_matching = false;
    foreach ($wholesale['price_list'] as $attr_price)
    {
        // û������
        if (empty($attr_price['attr']))
        {
            $attr_matching = true;
            $goods_list[0]['qp_list'] = $attr_price['qp_list'];
            break;
        }
        // ������
        elseif (($key = is_attr_matching($goods_list, $attr_price['attr'])) !== false)
        {
            $attr_matching = true;
            $goods_list[$key]['qp_list'] = $attr_price['qp_list'];
        }
    }
    if (!$attr_matching)
    {
        show_message($_LANG['ws_attr_not_matching']);
    }

    /* ��������Ƿ�ﵽ���Ҫ�� */
    foreach ($goods_list as $goods_key => $goods)
    {
        if ($goods['number'] < $goods['qp_list'][0]['quantity'])
        {
            show_message($_LANG['ws_goods_number_not_enough']);
        }
        else
        {
            $goods_price = 0;
            foreach ($goods['qp_list'] as $qp)
            {
                if ($goods['number'] >= $qp['quantity'])
                {
                    $goods_list[$goods_key]['goods_price'] = $qp['price'];
                }
                else
                {
                    break;
                }
            }
        }
    }

    /* д��session */
    foreach ($goods_list as $goods_key => $goods)
    {
        // ��������
        $goods_attr_name = '';
        if (!empty($goods['goods_attr']))
        {
            foreach ($goods['goods_attr'] as $key=> $attr)
            {
                $attr['attr_name']=htmlspecialchars($attr['attr_name']);
                $goods['goods_attr'][$key]['attr_name']=$attr['attr_name'];
                $attr['attr_val'] =htmlspecialchars($attr['attr_val']);
                $goods['goods_attr'][$key]['attr_name']=$attr['attr_name'];
                $goods_attr_name .= $attr['attr_name'] . '��' . $attr['attr_val'] . '&nbsp;';
            }
        }

        // �ܼ�
        $total = $goods['number'] * $goods['goods_price'];

        $_SESSION['wholesale_goods'][] = array(
            'goods_id'      => $wholesale['goods_id'],
            'goods_name'    => $wholesale['goods_name'],
            'goods_attr_id' => $goods['goods_attr'],
            'goods_attr'    => $goods_attr_name,
            'goods_number'  => $goods['number'],
            'goods_price'   => $goods['goods_price'],
            'subtotal'      => $total,
            'formated_goods_price'  => price_format($goods['goods_price'], false),
            'formated_subtotal'     => price_format($total, false),
            'goods_url'     => build_uri('goods', array('gid' => $wholesale['goods_id']), $wholesale['goods_name']),
        );
    }

    unset($goods_attr, $attr_id, $goods_list, $wholesale, $goods_attr_name);

    /* ˢ��ҳ�� */
    ecs_header("Location: ./wholesale.php\n");
    exit;
}

/*------------------------------------------------------ */
//-- �ӹ��ﳵɾ��
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'drop_goods')
{
    $key = intval($_REQUEST['key']);
    if (isset($_SESSION['wholesale_goods'][$key]))
    {
        unset($_SESSION['wholesale_goods'][$key]);
    }

    /* ˢ��ҳ�� */
    ecs_header("Location: ./wholesale.php\n");
    exit;
}

/*------------------------------------------------------ */
//-- �ύ����
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'submit_order')
{
    include_once(ROOT_PATH . 'includes/lib_order.php');

    /* ��鹺�ﳵ���Ƿ�����Ʒ */
    if (count($_SESSION['wholesale_goods']) == 0)
    {
        show_message($_LANG['no_goods_in_cart']);
    }

    /* ��鱸ע��Ϣ */
    if (empty($_POST['remark']))
    {
        show_message($_LANG['ws_remark']);
    }

    /* ������Ʒ�ܶ� */
    $goods_amount = 0;
    foreach ($_SESSION['wholesale_goods'] as $goods)
    {
        $goods_amount += $goods['subtotal'];
    }

    $order = array(
        'postscript'      => htmlspecialchars($_POST['remark']),
        'user_id'         => $_SESSION['user_id'],
        'add_time'        => gmtime(),
        'order_status'    => OS_UNCONFIRMED,
        'shipping_status' => SS_UNSHIPPED,
        'pay_status'      => PS_UNPAYED,
        'goods_amount'    => $goods_amount,
        'order_amount'    => $goods_amount,
    );

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
    foreach ($_SESSION['wholesale_goods'] as $goods)
    {
        //������ڻ�Ʒ
        $product_id = 0;
        if (!empty($goods['goods_attr_id']))
        {
            $goods_attr_id = array();
            foreach ($goods['goods_attr_id'] as $value)
            {
                $goods_attr_id[$value['attr_id']] = $value['attr_val_id'];
            }

            ksort($goods_attr_id);
            $goods_attr = implode('|', $goods_attr_id);

            $sql = "SELECT product_id FROM " . $ecs->table('products') . " WHERE goods_attr = '$goods_attr' AND goods_id = '" . $goods['goods_id'] . "'";
            $product_id = $db->getOne($sql);
        }

        $sql = "INSERT INTO " . $ecs->table('order_goods') . "( " .
                    "order_id, goods_id, goods_name, goods_sn, product_id, goods_number, market_price, ".
                    "goods_price, goods_attr, is_real, extension_code, parent_id, is_gift) ".
                " SELECT '$new_order_id', goods_id, goods_name, goods_sn, '$product_id','$goods[goods_number]', market_price, ".
                    "'$goods[goods_price]', '$goods[goods_attr]', is_real, extension_code, 0, 0 ".
                " FROM " .$ecs->table('goods') .
                " WHERE goods_id = '$goods[goods_id]'";
        $db->query($sql);
    }

    /* ���̼ҷ��ʼ� */
    if ($_CFG['service_email'] != '')
    {
        $tpl = get_mail_template('remind_of_new_order');
        $smarty->assign('order', $order);
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
        $msg = $_LANG['order_placed_sms'];
        $sms->send($_CFG['sms_shop_mobile'], sprintf($msg, $order['consignee'], $order['tel']),'', 13,1);
    }

    /* ��չ��ﳵ */
    unset($_SESSION['wholesale_goods']);

    /* ��ʾ */
    show_message(sprintf($_LANG['ws_order_submitted'], $order['order_sn']), $_LANG['ws_return_home'], 'index.php');
}

/**
 * ȡ��ĳҳ��������Ʒ
 * @param   int     $size   ÿҳ��¼��
 * @param   int     $page   ��ǰҳ
 * @param   string  $where  ��ѯ����
 * @return  array
 */
function wholesale_list($size, $page, $where)
{
    $list = array();
    $sql = "SELECT w.*, g.goods_thumb, g.goods_name as goods_name " .
            "FROM " . $GLOBALS['ecs']->table('wholesale') . " AS w, " .
                      $GLOBALS['ecs']->table('goods') . " AS g " . $where .
            " AND w.goods_id = g.goods_id ";
    $res = $GLOBALS['db']->selectLimit($sql, $size, ($page - 1) * $size);
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        if (empty($row['goods_thumb']))
        {
            $row['goods_thumb'] = $GLOBALS['_CFG']['no_picture'];
        }
        $row['goods_url'] = build_uri('goods', array('gid'=>$row['goods_id']), $row['goods_name']);

        $properties = get_goods_properties($row['goods_id']);
        $row['goods_attr'] = $properties['pro'];

        $price_ladder = get_price_ladder($row['goods_id']);
        $row['price_ladder'] = $price_ladder;

        $list[] = $row;
    }

    return $list;
}

/**
 * ��Ʒ�۸����
 * @param   int     $goods_id     ��ƷID
 * @return  array
 */
function get_price_ladder($goods_id)
{
    /* ��ʾ��Ʒ��� */
    $goods_attr_list = array_values(get_goods_attr($goods_id));
    $sql = "SELECT prices FROM " . $GLOBALS['ecs']->table('wholesale') .
            "WHERE goods_id = " . $goods_id;
    $row = $GLOBALS['db']->getRow($sql);

    $arr = array();
    $_arr = unserialize($row['prices']);
    if (is_array($_arr))
    {
        foreach(unserialize($row['prices']) as $key => $val)
        {
            // ��ʾ����
            if (!empty($val['attr']))
            {
                foreach ($val['attr'] as $attr_key => $attr_val)
                {
                    // ��ȡ��ǰ���� $attr_key ����Ϣ
                    $goods_attr = array();
                    foreach ($goods_attr_list as $goods_attr_val)
                    {
                        if ($goods_attr_val['attr_id'] == $attr_key)
                        {
                            $goods_attr = $goods_attr_val;
                            break;
                        }
                    }

                    // ��д��Ʒ���ļ۸������Ϣ
                    if (!empty($goods_attr))
                    {
                        $arr[$key]['attr'][] = array(
                            'attr_id'       => $goods_attr['attr_id'],
                            'attr_name'     => $goods_attr['attr_name'],
                            'attr_val'      => (isset($goods_attr['goods_attr_list'][$attr_val]) ? $goods_attr['goods_attr_list'][$attr_val] : ''),
                            'attr_val_id'   => $attr_val
                        );
                    }
                }
            }

            // ��ʾ������۸�
            foreach($val['qp_list'] as $index => $qp)
            {
                $arr[$key]['qp_list'][$qp['quantity']] = price_format($qp['price']);
            }
        }
    }

    return $arr;
}

/**
 * ��Ʒ�����Ƿ�ƥ��
 * @param   array   $goods_list     �û�ѡ�����Ʒ
 * @param   array   $reference      ���յ���Ʒ����
 * @return  bool
 */
function is_attr_matching(&$goods_list, $reference)
{
    foreach ($goods_list as $key => $goods)
    {
        // ��Ҫ��ͬ��Ԫ�ظ���
        if (count($goods['goods_attr']) != count($reference))
        {
            break;
        }

        // �ж��û��ύ�����������Ƿ���ͬ
        $is_check = true;
        if (is_array($goods['goods_attr']))
        {
            foreach ($goods['goods_attr'] as $attr)
            {
                if (!(array_key_exists($attr['attr_id'], $reference) && $attr['attr_val_id'] == $reference[$attr['attr_id']]))
                {
                    $is_check = false;
                    break;
                }
            }
        }
        if ($is_check)
        {
            return $key;
            break;
        }
    }


//    foreach ($goods_attr as $attr_id => $goods_attr_id)
//    {
//        if (isset($reference[$attr_id]) && $reference[$attr_id] != 0 && $reference[$attr_id] != $goods_attr_id)
//        {
//            return false;
//        }
//    }

    return false;
}

///**
// * ���ﳵ�е���Ʒ�����뵱ǰ�������Ʒ�����Ƿ�ƥ��
// * @param   array   $goods_attr     �û�ѡ�����Ʒ����
// * @param   array   $reference      ���յ���Ʒ����
// * @return  bool
// */
//function is_attr_same($goods_attr, $reference)
//{
//    /* �Ƚ�Ԫ�ظ����Ƿ���ͬ */
//    if (count($goods_attr) == count($reference)) {
//    }
//
//    return true;
//}
?>
