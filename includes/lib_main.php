<?php

/**
 * ECSHOP ǰ̨���ú�����
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: lib_main.php 17217 2011-01-19 06:29:08Z liubo $
*/

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

/**
 * �����û�SESSION,COOKIE����¼ʱ�䡢��¼������
 *
 * @access  public
 * @return  void
 */
function update_user_info()
{
    if (!$_SESSION['user_id'])
    {
        return false;
    }

    /* ��ѯ��Ա��Ϣ */
    $time = date('Y-m-d');
    $sql = 'SELECT u.user_money,u.email, u.pay_points, u.user_rank, u.rank_points, '.
            ' IFNULL(b.type_money, 0) AS user_bonus, u.last_login, u.last_ip'.
            ' FROM ' .$GLOBALS['ecs']->table('users'). ' AS u ' .
            ' LEFT JOIN ' .$GLOBALS['ecs']->table('user_bonus'). ' AS ub'.
            ' ON ub.user_id = u.user_id AND ub.used_time = 0 ' .
            ' LEFT JOIN ' .$GLOBALS['ecs']->table('bonus_type'). ' AS b'.
            " ON b.type_id = ub.bonus_type_id AND b.use_start_date <= '$time' AND b.use_end_date >= '$time' ".
            " WHERE u.user_id = '$_SESSION[user_id]'";
    if ($row = $GLOBALS['db']->getRow($sql))
    {
        /* ����SESSION */
        $_SESSION['last_time']   = $row['last_login'];
        $_SESSION['last_ip']     = $row['last_ip'];
        $_SESSION['login_fail']  = 0;
        $_SESSION['email']       = $row['email'];

        /*�ж��Ƿ�������ȼ������ܺ�̨�������Ա�������ͨ��Ա��*/
        if($row['user_rank'] >0)
        {
            $sql="SELECT special_rank from ".$GLOBALS['ecs']->table('user_rank')."where rank_id='$row[user_rank]'";
            if($GLOBALS['db']->getOne($sql)==='0' || $GLOBALS['db']->getOne($sql)===null)
            {   
                $sql="update ".$GLOBALS['ecs']->table('users')."set user_rank='0' where user_id='$_SESSION[user_id]'";
                $GLOBALS['db']->query($sql);
                $row['user_rank']=0;
            }
        }

        /* ȡ���û��ȼ����ۿ� */
        if ($row['user_rank'] == 0)
        {
            // ������ȼ������ݵȼ����ּ����û��ȼ���ע�⣺����������ȼ���
            $sql = 'SELECT rank_id, discount FROM ' . $GLOBALS['ecs']->table('user_rank') . " WHERE special_rank = '0' AND min_points <= " . intval($row['rank_points']) . ' AND max_points > ' . intval($row['rank_points']);
            if ($row = $GLOBALS['db']->getRow($sql))
            {
                $_SESSION['user_rank'] = $row['rank_id'];
                $_SESSION['discount']  = $row['discount'] / 100.00;
            }
            else
            {
                $_SESSION['user_rank'] = 0;
                $_SESSION['discount']  = 1;
            }
        }
        else
        {
            // ����ȼ�
            $sql = 'SELECT rank_id, discount FROM ' . $GLOBALS['ecs']->table('user_rank') . " WHERE rank_id = '$row[user_rank]'";
            if ($row = $GLOBALS['db']->getRow($sql))
            {
                $_SESSION['user_rank'] = $row['rank_id'];
                $_SESSION['discount']  = $row['discount'] / 100.00;
            }
            else
            {
                $_SESSION['user_rank'] = 0;
                $_SESSION['discount']  = 1;
            }
        }
    }

    /* ���µ�¼ʱ�䣬��¼��������¼ip */
    $sql = "UPDATE " .$GLOBALS['ecs']->table('users'). " SET".
           " visit_count = visit_count + 1, ".
           " last_ip = '" .real_ip(). "',".
           " last_login = '" .gmtime(). "'".
           " WHERE user_id = '" . $_SESSION['user_id'] . "'";
    $GLOBALS['db']->query($sql);
}

/**
 *  ��ȡ�û���Ϣ����
 *
 * @access  public
 * @param
 *
 * @return array        $user       �û���Ϣ����
 */
function get_user_info($id=0)
{
    if ($id == 0)
    {
        $id = $_SESSION['user_id'];
    }
    $time = date('Y-m-d');
    $sql  = 'SELECT u.user_id, u.email, u.user_name, u.user_money, u.pay_points'.
            ' FROM ' .$GLOBALS['ecs']->table('users'). ' AS u ' .
            " WHERE u.user_id = '$id'";
    $user = $GLOBALS['db']->getRow($sql);
    $bonus = get_user_bonus($id);

    $user['username']    = $user['user_name'];
    $user['user_points'] = $user['pay_points'] . $GLOBALS['_CFG']['integral_name'];
    $user['user_money']  = price_format($user['user_money'], false);
    $user['user_bonus']  = price_format($bonus['bonus_value'], false);

    return $user;
}
/**
 * ȡ�õ�ǰλ�ú�ҳ�����
 *
 * @access  public
 * @param   integer     $cat    �����ţ�ֻ����Ʒ�����ࡢ���¼������õ���
 * @param   string      $str    ��Ʒ�������±�����������ӵ����ݣ������ӣ�
 * @return  array
 */
function assign_ur_here($cat = 0, $str = '')
{
    /* �ж��Ƿ���д��ȡ���ļ��� */
    $cur_url = basename(PHP_SELF);
    if (intval($GLOBALS['_CFG']['rewrite']))
    {
        $filename = strpos($cur_url,'-') ? substr($cur_url, 0, strpos($cur_url,'-')) : substr($cur_url, 0, -4);
    }
    else
    {
        $filename = substr($cur_url, 0, -4);
    }

    /* ��ʼ����ҳ����⡱�͡���ǰλ�á� */
    $page_title = $GLOBALS['_CFG']['shop_title'] ;
    @$ur_here    = '<a href=".">' . $GLOBALS['_LANG']['home'] . '</a>';

    /* �����ļ����ֱ����м�Ĳ��� */
    if ($filename != 'index')
    {
        /* �����з���� */
        if (in_array($filename, array('category', 'goods', 'article_cat', 'article', 'brand')))
        {
            /* ��Ʒ�������Ʒ */
            if ('category' == $filename || 'goods' == $filename || 'brand' == $filename)
            {
                if ($cat > 0)
                {
                    $cat_arr = get_parent_cats($cat);

                    $key     = 'cid';
                    $type    = 'category';
                }
                else
                {
                    $cat_arr = array();
                }
            }
            /* ���·�������� */
            elseif ('article_cat' == $filename || 'article' == $filename)
            {
                if ($cat > 0)
                {
                    $cat_arr = get_article_parent_cats($cat);

                    $key  = 'acid';
                    $type = 'article_cat';
                }
                else
                {
                    $cat_arr = array();
                }
            }

            /* ѭ������ */
            if (!empty($cat_arr))
            {
                krsort($cat_arr);
                foreach ($cat_arr AS $val)
                {
                    $page_title = htmlspecialchars($val['cat_name']) . '_' . $page_title;
                    $args       = array($key => $val['cat_id']);
                    $ur_here   .= ' &gt;&gt; <a href="' . build_uri($type, $args, $val['cat_name']) . '">' .
                                    htmlspecialchars($val['cat_name']) . '</a>';
                }
            }
        }
        /* �����޷���� */
        else
        {
            /* �Ź� */
            if ('group_buy' == $filename)
            {
                $page_title = $GLOBALS['_LANG']['group_buy_goods'] . '_' . $page_title;
                $args       = array('gbid' => '0');
                $ur_here   .= ' &gt;&gt; <a href="group_buy.php">' .
                                $GLOBALS['_LANG']['group_buy_goods'] . '</a>';
            }
            /* ���� */
            elseif ('auction' == $filename)
            {
                $page_title = $GLOBALS['_LANG']['auction'] . '_' . $page_title;
                $args       = array('auid' => '0');
                $ur_here   .= ' &gt;&gt;> <a href="auction.php">' .
                                $GLOBALS['_LANG']['auction'] . '</a>';
            }
            /* �ᱦ */
            elseif ('snatch' == $filename)
            {
                $page_title = $GLOBALS['_LANG']['snatch'] . '_' . $page_title;
                $args       = array('id' => '0');
                $ur_here   .= '  &gt;&gt; <a href="snatch.php">' .                                 $GLOBALS['_LANG']['snatch_list'] . '</a>';
            }
            /* ���� */
            elseif ('wholesale' == $filename)
            {
                $page_title = $GLOBALS['_LANG']['wholesale'] . '_' . $page_title;
                $args       = array('wsid' => '0');
                $ur_here   .= ' &gt;&gt; <a href="wholesale.php">' .
                                $GLOBALS['_LANG']['wholesale'] . '</a>';
            }
            /* ���ֶһ� */
            elseif ('exchange' == $filename)
            {
                $page_title = $GLOBALS['_LANG']['exchange'] . '_' . $page_title;
                $args       = array('wsid' => '0');
                $ur_here   .= ' &gt;&gt; <a href="exchange.php">' .
                                $GLOBALS['_LANG']['exchange'] . '</a>';
            }
            /* �����������ﲹ�� */
        }
    }

    /* �������һ���� */
    if (!empty($str))
    {
        $page_title  = $str . '_' . $page_title;
        $ur_here    .= ' &gt;&gt; ' .'<em>'. $str.'</em>';
    }
    /* ����ֵ */
    return array('title' => $page_title, 'ur_here' => $ur_here,);
}

/**
 * ���ָ������������ϼ�����
 *
 * @access  public
 * @param   integer $cat    ������
 * @return  array
 */
function get_parent_cats($cat)
{
    if ($cat == 0)
    {
        return array();
    }

    $arr = $GLOBALS['db']->GetAll('SELECT cat_id, cat_name, parent_id FROM ' . $GLOBALS['ecs']->table('category'));

    if (empty($arr))
    {
        return array();
    }

    $index = 0;
    $cats  = array();

    while (1)
    {
        foreach ($arr AS $row)
        {
            if ($cat == $row['cat_id'])
            {
                $cat = $row['parent_id'];

                $cats[$index]['cat_id']   = $row['cat_id'];
                $cats[$index]['cat_name'] = $row['cat_name'];

                $index++;
                break;
            }
        }

        if ($index == 0 || $cat == 0)
        {
            break;
        }
    }

    return $cats;
}

/**
 * �����ṩ����������ҳ�����
 *
 * @access  public
 * @param   string  $type   ����
 * @param   array   $arr    ��������
 * @return  string
 */
function build_pagetitle($arr, $type = 'category')
{
    $str = '';

    foreach ($arr AS $val)
    {
        $str .= htmlspecialchars($val['cat_name']) . '_';
    }

    return $str;
}

/**
 * �����ṩ���������ɵ�ǰλ��
 *
 * @access  public
 * @param   string  $type   ����
 * @param   array   $arr    ��������
 * @return  void
 */
function build_urhere($arr, $type = 'category')
{
    krsort($arr);

    $str = '';
    foreach ($arr AS $val)
    {
        switch ($type)
        {
            case 'category':
            case 'brand':
                $args = array('cid' => $val['cat_id']);
                break;
            case 'article_cat':
                $args = array('acid' => $val['cat_id']);
                break;
        }

        $str .= ' <code>&gt;</code> <a href="' . build_uri($type, $args). '">' . htmlspecialchars($val['cat_name']) . '</a>';
    }

    return $str;
}

/**
 * ���ָ��ҳ��Ķ�̬����
 *
 * @access  public
 * @param   string  $tmp    ģ������
 * @return  void
 */
function assign_dynamic($tmp)
{
    $sql = 'SELECT id, number, type FROM ' . $GLOBALS['ecs']->table('template') .
        " WHERE filename = '$tmp' AND type > 0 AND remarks ='' AND theme='" . $GLOBALS['_CFG']['template'] . "'";
    $res = $GLOBALS['db']->getAll($sql);

   foreach ($res AS $row)
    {
        switch ($row['type'])
        {
            case 1:
                /* �����µ���Ʒ */
                $GLOBALS['smarty']->assign('goods_cat_' . $row['id'], assign_cat_goods($row['id'], $row['number']));
            break;
            case 2:
                /* Ʒ�Ƶ���Ʒ */
                $brand_goods = assign_brand_goods($row['id'], $row['number']);

                $GLOBALS['smarty']->assign('brand_goods_' . $row['id'], $brand_goods['goods']);
                $GLOBALS['smarty']->assign('goods_brand_' . $row['id'], $brand_goods['brand']);
            break;
            case 3:
                /* �����б� */
                $cat_articles = assign_articles($row['id'], $row['number']);

                $GLOBALS['smarty']->assign('articles_cat_' . $row['id'], $cat_articles['cat']);
                $GLOBALS['smarty']->assign('articles_' . $row['id'], $cat_articles['arr']);
            break;
        }
    }
}

/**
 * ���������б��smarty
 *
 * @access  public
 * @param   integer     $id     ���·���ı��
 * @param   integer     $num    ��������
 * @return  array
 */
function assign_articles($id, $num)
{
    $sql = 'SELECT cat_name FROM ' . $GLOBALS['ecs']->table('article_cat') . " WHERE cat_id = '" . $id ."'";

    $cat['id']       = $id;
    $cat['name']     = $GLOBALS['db']->getOne($sql);
    $cat['url']      = build_uri('article_cat', array('acid' => $id), $cat['name']);

    $articles['cat'] = $cat;
    $articles['arr'] = get_cat_articles($id, 1, $num);

    return $articles;
}

/**
 * ���������Ϣ
 *
 * @access  public
 * @return  array
 */
function get_shop_help()
{
    $sql = 'SELECT c.cat_id, c.cat_name, c.sort_order, a.article_id, a.title, a.file_url, a.open_type ' .
            'FROM ' .$GLOBALS['ecs']->table('article'). ' AS a ' .
            'LEFT JOIN ' .$GLOBALS['ecs']->table('article_cat'). ' AS c ' .
            'ON a.cat_id = c.cat_id WHERE c.cat_type = 5 AND a.is_open = 1 ' .
            'ORDER BY c.sort_order ASC, a.article_id';
    $res = $GLOBALS['db']->getAll($sql);

    $arr = array();
    foreach ($res AS $key => $row)
    {
        $arr[$row['cat_id']]['cat_id']                       = build_uri('article_cat', array('acid'=> $row['cat_id']), $row['cat_name']);
        $arr[$row['cat_id']]['cat_name']                     = $row['cat_name'];
        $arr[$row['cat_id']]['article'][$key]['article_id']  = $row['article_id'];
        $arr[$row['cat_id']]['article'][$key]['title']       = $row['title'];
        $arr[$row['cat_id']]['article'][$key]['short_title'] = $GLOBALS['_CFG']['article_title_length'] > 0 ?
            sub_str($row['title'], $GLOBALS['_CFG']['article_title_length']) : $row['title'];
        $arr[$row['cat_id']]['article'][$key]['url']         = $row['open_type'] != 1 ?
            build_uri('article', array('aid' => $row['article_id']), $row['title']) : trim($row['file_url']);
    }

    return $arr;
}

/**
 * ������ҳ��Ϣ
 *
 * @access  public
 * @param   string  $app            �������ƣ���category
 * @param   string  $cat            ����ID
 * @param   string  $record_count   ��¼����
 * @param   string  $size           ÿҳ��¼��
 * @param   string  $sort           ��������
 * @param   string  $order          ����˳��
 * @param   string  $page           ��ǰҳ
 * @param   string  $keywords       ��ѯ�ؼ���
 * @param   string  $brand          Ʒ��
 * @param   string  $price_min      ��С�۸�
 * @param   string  $price_max      ��߼۸�
 * @return  void
 */
function assign_pager($app, $cat, $record_count, $size, $sort, $order, $page = 1,
                        $keywords = '', $brand = 0, $price_min = 0, $price_max = 0, $display_type = 'list', $filter_attr='', $url_format='', $sch_array='')
{
    $sch = array('keywords'  => $keywords,
                 'sort'      => $sort,
                 'order'     => $order,
                 'cat'       => $cat,
                 'brand'     => $brand,
                 'price_min' => $price_min,
                 'price_max' => $price_max,
                 'filter_attr'=>$filter_attr,
                 'display'   => $display_type
        );

    $page = intval($page);
    if ($page < 1)
    {
        $page = 1;
    }

    $page_count = $record_count > 0 ? intval(ceil($record_count / $size)) : 1;

    $pager['page']         = $page;
    $pager['size']         = $size;
    $pager['sort']         = $sort;
    $pager['order']        = $order;
    $pager['record_count'] = $record_count;
    $pager['page_count']   = $page_count;
    $pager['display']      = $display_type;

    switch ($app)
    {
        case 'category':
            $uri_args = array('cid' => $cat, 'bid' => $brand, 'price_min'=>$price_min, 'price_max'=>$price_max, 'filter_attr'=>$filter_attr, 'sort' => $sort, 'order' => $order, 'display' => $display_type);
            break;
        case 'article_cat':
            $uri_args = array('acid' => $cat, 'sort' => $sort, 'order' => $order);
            break;
        case 'brand':
            $uri_args = array('cid' => $cat, 'bid' => $brand, 'sort' => $sort, 'order' => $order, 'display' => $display_type);
            break;
        case 'search':
            $uri_args = array('cid' => $cat, 'bid' => $brand, 'sort' => $sort, 'order' => $order);
            break;
        case 'exchange':
            $uri_args = array('cid' => $cat, 'integral_min'=>$price_min, 'integral_max'=>$price_max, 'sort' => $sort, 'order' => $order, 'display' => $display_type);
            break;
    }
    /* ��ҳ��ʽ */
    $pager['styleid'] = isset($GLOBALS['_CFG']['page_style'])? intval($GLOBALS['_CFG']['page_style']) : 0;

    $page_prev  = ($page > 1) ? $page - 1 : 1;
    $page_next  = ($page < $page_count) ? $page + 1 : $page_count;
    if ($pager['styleid'] == 0)
    {
        if (!empty($url_format))
        {
            $pager['page_first'] = $url_format . 1;
            $pager['page_prev']  = $url_format . $page_prev;
            $pager['page_next']  = $url_format . $page_next;
            $pager['page_last']  = $url_format . $page_count;
        }
        else
        {
            $pager['page_first'] = build_uri($app, $uri_args, '', 1, $keywords);
            $pager['page_prev']  = build_uri($app, $uri_args, '', $page_prev, $keywords);
            $pager['page_next']  = build_uri($app, $uri_args, '', $page_next, $keywords);
            $pager['page_last']  = build_uri($app, $uri_args, '', $page_count, $keywords);
        }
        $pager['array']      = array();

        for ($i = 1; $i <= $page_count; $i++)
        {
            $pager['array'][$i] = $i;
        }
    }
    else
    {
        $_pagenum = 10;     // ��ʾ��ҳ��
        $_offset = 2;       // ��ǰҳƫ��ֵ
        $_from = $_to = 0;  // ��ʼҳ, ����ҳ
        if($_pagenum > $page_count)
        {
            $_from = 1;
            $_to = $page_count;
        }
        else
        {
            $_from = $page - $_offset;
            $_to = $_from + $_pagenum - 1;
            if($_from < 1)
            {
                $_to = $page + 1 - $_from;
                $_from = 1;
                if($_to - $_from < $_pagenum)
                {
                    $_to = $_pagenum;
                }
            }
            elseif($_to > $page_count)
            {
                $_from = $page_count - $_pagenum + 1;
                $_to = $page_count;
            }
        }
        if (!empty($url_format))
        {
            $pager['page_first'] = ($page - $_offset > 1 && $_pagenum < $page_count) ? $url_format . 1 : '';
            $pager['page_prev']  = ($page > 1) ? $url_format . $page_prev : '';
            $pager['page_next']  = ($page < $page_count) ? $url_format . $page_next : '';
            $pager['page_last']  = ($_to < $page_count) ? $url_format . $page_count : '';
            $pager['page_kbd']  = ($_pagenum < $page_count) ? true : false;
            $pager['page_number'] = array();
            for ($i=$_from;$i<=$_to;++$i)
            {
                $pager['page_number'][$i] = $url_format . $i;
            }
        }
        else
        {
            $pager['page_first'] = ($page - $_offset > 1 && $_pagenum < $page_count) ? build_uri($app, $uri_args, '', 1, $keywords) : '';
            $pager['page_prev']  = ($page > 1) ? build_uri($app, $uri_args, '', $page_prev, $keywords) : '';
            $pager['page_next']  = ($page < $page_count) ? build_uri($app, $uri_args, '', $page_next, $keywords) : '';
            $pager['page_last']  = ($_to < $page_count) ? build_uri($app, $uri_args, '', $page_count, $keywords) : '';
            $pager['page_kbd']  = ($_pagenum < $page_count) ? true : false;
            $pager['page_number'] = array();
            for ($i=$_from;$i<=$_to;++$i)
            {
                $pager['page_number'][$i] = build_uri($app, $uri_args, '', $i, $keywords);
            }
        }
    }
    if (!empty($sch_array))
    {
        $pager['search'] = $sch_array;
    }
    else
    {
        $pager['search']['category'] = $cat;
        foreach ($sch AS $key => $row)
        {
            $pager['search'][$key] = $row;
        }
    }

    $GLOBALS['smarty']->assign('pager', $pager);
}

/**
 *  ���ɸ�pager.lbi��ֵ������
 *
 * @access  public
 * @param   string      $url        ��ҳ�����ӵ�ַ(�����Ǵ��в����ĵ�ַ�������ǿ���α��һ�����ò���)
 * @param   array       $param      ���Ӳ��� keyΪ��������valueΪ����ֵ
 * @param   int         $record     ��¼������
 * @param   int         $page       ��ǰҳ��
 * @param   int         $size       ÿҳ��С
 *
 * @return  array       $pager
 */
function get_pager($url, $param, $record_count, $page = 1, $size = 10)
{
    $size = intval($size);
    if ($size < 1)
    {
        $size = 10;
    }

    $page = intval($page);
    if ($page < 1)
    {
        $page = 1;
    }

    $record_count = intval($record_count);

    $page_count = $record_count > 0 ? intval(ceil($record_count / $size)) : 1;
    if ($page > $page_count)
    {
        $page = $page_count;
    }
    /* ��ҳ��ʽ */
    $pager['styleid'] = isset($GLOBALS['_CFG']['page_style'])? intval($GLOBALS['_CFG']['page_style']) : 0;

    $page_prev  = ($page > 1) ? $page - 1 : 1;
    $page_next  = ($page < $page_count) ? $page + 1 : $page_count;

    /* �������ϳ�url�ִ� */
    $param_url = '?';
    foreach ($param AS $key => $value)
    {
        $param_url .= $key . '=' . $value . '&';
    }

    $pager['url']          = $url;
    $pager['start']        = ($page -1) * $size;
    $pager['page']         = $page;
    $pager['size']         = $size;
    $pager['record_count'] = $record_count;
    $pager['page_count']   = $page_count;

    if ($pager['styleid'] == 0)
    {
        $pager['page_first']   = $url . $param_url . 'page=1';
        $pager['page_prev']    = $url . $param_url . 'page=' . $page_prev;
        $pager['page_next']    = $url . $param_url . 'page=' . $page_next;
        $pager['page_last']    = $url . $param_url . 'page=' . $page_count;
        $pager['array']  = array();
        for ($i = 1; $i <= $page_count; $i++)
        {
            $pager['array'][$i] = $i;
        }
    }
    else
    {
        $_pagenum = 10;     // ��ʾ��ҳ��
        $_offset = 2;       // ��ǰҳƫ��ֵ
        $_from = $_to = 0;  // ��ʼҳ, ����ҳ
        if($_pagenum > $page_count)
        {
            $_from = 1;
            $_to = $page_count;
        }
        else
        {
            $_from = $page - $_offset;
            $_to = $_from + $_pagenum - 1;
            if($_from < 1)
            {
                $_to = $page + 1 - $_from;
                $_from = 1;
                if($_to - $_from < $_pagenum)
                {
                    $_to = $_pagenum;
                }
            }
            elseif($_to > $page_count)
            {
                $_from = $page_count - $_pagenum + 1;
                $_to = $page_count;
            }
        }
        $url_format = $url . $param_url . 'page=';
        $pager['page_first'] = ($page - $_offset > 1 && $_pagenum < $page_count) ? $url_format . 1 : '';
        $pager['page_prev']  = ($page > 1) ? $url_format . $page_prev : '';
        $pager['page_next']  = ($page < $page_count) ? $url_format . $page_next : '';
        $pager['page_last']  = ($_to < $page_count) ? $url_format . $page_count : '';
        $pager['page_kbd']  = ($_pagenum < $page_count) ? true : false;
        $pager['page_number'] = array();
        for ($i=$_from;$i<=$_to;++$i)
        {
            $pager['page_number'][$i] = $url_format . $i;
        }
    }
    $pager['search'] = $param;

    return $pager;
}

/**
 * ���õ�������
 *
 * @access  public
 * @param   integer $id   ����ı��
 * @return  array
 */
function get_vote($id = '')
{
    /* ���ȡ��һ����������� */
    if (empty($id))
    {
        $time = gmtime();
        $sql = 'SELECT vote_id, vote_name, can_multi, vote_count, RAND() AS rnd' .
               ' FROM ' . $GLOBALS['ecs']->table('vote') .
               " WHERE start_time <= '$time' AND end_time >= '$time' ".
               ' ORDER BY rnd LIMIT 1';
    }
    else
    {
        $sql = 'SELECT vote_id, vote_name, can_multi, vote_count' .
               ' FROM ' . $GLOBALS['ecs']->table('vote').
               " WHERE vote_id = '$id'";
    }

    $vote_arr = $GLOBALS['db']->getRow($sql);

    if ($vote_arr !== false && !empty($vote_arr))
    {
        /* ͨ�������ID,��ѯ����ѡ�� */
        $sql_option = 'SELECT v.*, o.option_id, o.vote_id, o.option_name, o.option_count ' .
                      'FROM ' . $GLOBALS['ecs']->table('vote') . ' AS v, ' .
                            $GLOBALS['ecs']->table('vote_option') . ' AS o ' .
                      "WHERE o.vote_id = v.vote_id AND o.vote_id = '$vote_arr[vote_id]' ORDER BY o.option_order ASC, o.option_id DESC";
        $res = $GLOBALS['db']->getAll($sql_option);

        /* ��Ʊ�� */
        $sql = 'SELECT SUM(option_count) AS all_option FROM ' . $GLOBALS['ecs']->table('vote_option') .
               " WHERE vote_id = '" . $vote_arr['vote_id'] . "' GROUP BY vote_id";
        $option_num = $GLOBALS['db']->getOne($sql);

        $arr = array();
        $count = 100;
        foreach ($res AS $idx => $row)
        {
            if ($option_num > 0 && $idx == count($res) - 1)
            {
                $percent = $count;
            }
            else
            {
                $percent = ($row['vote_count'] > 0 && $option_num > 0) ? round(($row['option_count'] / $option_num) * 100) : 0;

                $count -= $percent;
            }
            $arr[$row['vote_id']]['options'][$row['option_id']]['percent'] = $percent;

            $arr[$row['vote_id']]['vote_id']    = $row['vote_id'];
            $arr[$row['vote_id']]['vote_name']  = $row['vote_name'];
            $arr[$row['vote_id']]['can_multi']  = $row['can_multi'];
            $arr[$row['vote_id']]['vote_count'] = $row['vote_count'];

            $arr[$row['vote_id']]['options'][$row['option_id']]['option_id']    = $row['option_id'];
            $arr[$row['vote_id']]['options'][$row['option_id']]['option_name']  = $row['option_name'];
            $arr[$row['vote_id']]['options'][$row['option_id']]['option_count'] = $row['option_count'];
        }

        $vote_arr['vote_id'] = (!empty($vote_arr['vote_id'])) ? $vote_arr['vote_id'] : '';

        $vote = array('id' => $vote_arr['vote_id'], 'content' => $arr);

        return $vote;
    }
}

/**
 * �����������ƺͰ汾
 *
 * @access  public
 * @return  string
 */
function get_user_browser()
{
    if (empty($_SERVER['HTTP_USER_AGENT']))
    {
        return '';
    }

    $agent       = $_SERVER['HTTP_USER_AGENT'];
    $browser     = '';
    $browser_ver = '';

    if (preg_match('/MSIE\s([^\s|;]+)/i', $agent, $regs))
    {
        $browser     = 'Internet Explorer';
        $browser_ver = $regs[1];
    }
    elseif (preg_match('/FireFox\/([^\s]+)/i', $agent, $regs))
    {
        $browser     = 'FireFox';
        $browser_ver = $regs[1];
    }
    elseif (preg_match('/Maxthon/i', $agent, $regs))
    {
        $browser     = '(Internet Explorer ' .$browser_ver. ') Maxthon';
        $browser_ver = '';
    }
    elseif (preg_match('/Opera[\s|\/]([^\s]+)/i', $agent, $regs))
    {
        $browser     = 'Opera';
        $browser_ver = $regs[1];
    }
    elseif (preg_match('/OmniWeb\/(v*)([^\s|;]+)/i', $agent, $regs))
    {
        $browser     = 'OmniWeb';
        $browser_ver = $regs[2];
    }
    elseif (preg_match('/Netscape([\d]*)\/([^\s]+)/i', $agent, $regs))
    {
        $browser     = 'Netscape';
        $browser_ver = $regs[2];
    }
    elseif (preg_match('/safari\/([^\s]+)/i', $agent, $regs))
    {
        $browser     = 'Safari';
        $browser_ver = $regs[1];
    }
    elseif (preg_match('/NetCaptor\s([^\s|;]+)/i', $agent, $regs))
    {
        $browser     = '(Internet Explorer ' .$browser_ver. ') NetCaptor';
        $browser_ver = $regs[1];
    }
    elseif (preg_match('/Lynx\/([^\s]+)/i', $agent, $regs))
    {
        $browser     = 'Lynx';
        $browser_ver = $regs[1];
    }

    if (!empty($browser))
    {
       return addslashes($browser . ' ' . $browser_ver);
    }
    else
    {
        return 'Unknow browser';
    }
}

/**
 * �ж��Ƿ�Ϊ��������֩��
 *
 * @access  public
 * @return  string
 */
function is_spider($record = true)
{
    static $spider = NULL;

    if ($spider !== NULL)
    {
        return $spider;
    }

    if (empty($_SERVER['HTTP_USER_AGENT']))
    {
        $spider = '';

        return '';
    }

    $searchengine_bot = array(
        'googlebot',
        'mediapartners-google',
        'baiduspider+',
        'msnbot',
        'yodaobot',
        'yahoo! slurp;',
        'yahoo! slurp china;',
        'iaskspider',
        'sogou web spider',
        'sogou push spider'
    );

    $searchengine_name = array(
        'GOOGLE',
        'GOOGLE ADSENSE',
        'BAIDU',
        'MSN',
        'YODAO',
        'YAHOO',
        'Yahoo China',
        'IASK',
        'SOGOU',
        'SOGOU'
    );

    $spider = strtolower($_SERVER['HTTP_USER_AGENT']);

    foreach ($searchengine_bot AS $key => $value)
    {
        if (strpos($spider, $value) !== false)
        {
            $spider = $searchengine_name[$key];

            if ($record === true)
            {
                $GLOBALS['db']->autoReplace($GLOBALS['ecs']->table('searchengine'), array('date' => local_date('Y-m-d'), 'searchengine' => $spider, 'count' => 1), array('count' => 1));
            }

            return $spider;
        }
    }

    $spider = '';

    return '';
}

/**
 * ��ÿͻ��˵Ĳ���ϵͳ
 *
 * @access  private
 * @return  void
 */
function get_os()
{
    if (empty($_SERVER['HTTP_USER_AGENT']))
    {
        return 'Unknown';
    }

    $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
    $os    = '';

    if (strpos($agent, 'win') !== false)
    {
        if (strpos($agent, 'nt 5.1') !== false)
        {
            $os = 'Windows XP';
        }
        elseif (strpos($agent, 'nt 5.2') !== false)
        {
            $os = 'Windows 2003';
        }
        elseif (strpos($agent, 'nt 5.0') !== false)
        {
            $os = 'Windows 2000';
        }
        elseif (strpos($agent, 'nt 6.0') !== false)
        {
            $os = 'Windows Vista';
        }
        elseif (strpos($agent, 'nt') !== false)
        {
            $os = 'Windows NT';
        }
        elseif (strpos($agent, 'win 9x') !== false && strpos($agent, '4.90') !== false)
        {
            $os = 'Windows ME';
        }
        elseif (strpos($agent, '98') !== false)
        {
            $os = 'Windows 98';
        }
        elseif (strpos($agent, '95') !== false)
        {
            $os = 'Windows 95';
        }
        elseif (strpos($agent, '32') !== false)
        {
            $os = 'Windows 32';
        }
        elseif (strpos($agent, 'ce') !== false)
        {
            $os = 'Windows CE';
        }
    }
    elseif (strpos($agent, 'linux') !== false)
    {
        $os = 'Linux';
    }
    elseif (strpos($agent, 'unix') !== false)
    {
        $os = 'Unix';
    }
    elseif (strpos($agent, 'sun') !== false && strpos($agent, 'os') !== false)
    {
        $os = 'SunOS';
    }
    elseif (strpos($agent, 'ibm') !== false && strpos($agent, 'os') !== false)
    {
        $os = 'IBM OS/2';
    }
    elseif (strpos($agent, 'mac') !== false && strpos($agent, 'pc') !== false)
    {
        $os = 'Macintosh';
    }
    elseif (strpos($agent, 'powerpc') !== false)
    {
        $os = 'PowerPC';
    }
    elseif (strpos($agent, 'aix') !== false)
    {
        $os = 'AIX';
    }
    elseif (strpos($agent, 'hpux') !== false)
    {
        $os = 'HPUX';
    }
    elseif (strpos($agent, 'netbsd') !== false)
    {
        $os = 'NetBSD';
    }
    elseif (strpos($agent, 'bsd') !== false)
    {
        $os = 'BSD';
    }
    elseif (strpos($agent, 'osf1') !== false)
    {
        $os = 'OSF1';
    }
    elseif (strpos($agent, 'irix') !== false)
    {
        $os = 'IRIX';
    }
    elseif (strpos($agent, 'freebsd') !== false)
    {
        $os = 'FreeBSD';
    }
    elseif (strpos($agent, 'teleport') !== false)
    {
        $os = 'teleport';
    }
    elseif (strpos($agent, 'flashget') !== false)
    {
        $os = 'flashget';
    }
    elseif (strpos($agent, 'webzip') !== false)
    {
        $os = 'webzip';
    }
    elseif (strpos($agent, 'offline') !== false)
    {
        $os = 'offline';
    }
    else
    {
        $os = 'Unknown';
    }

    return $os;
}

/**
 * ͳ�Ʒ�����Ϣ
 *
 * @access  public
 * @return  void
 */
function visit_stats()
{
    if (isset($GLOBALS['_CFG']['visit_stats']) && $GLOBALS['_CFG']['visit_stats'] == 'off')
    {
        return;
    }
    $time = gmtime();
    /* ���ͻ����Ƿ���ڷ���ͳ�Ƶ�cookie */
    $visit_times = (!empty($_COOKIE['ECS']['visit_times'])) ? intval($_COOKIE['ECS']['visit_times']) + 1 : 1;
    setcookie('ECS[visit_times]', $visit_times, $time + 86400 * 365, '/');

    $browser  = get_user_browser();
    $os       = get_os();
    $ip       = real_ip();
    $area     = ecs_geoip($ip);

    /* ���� */
    if (!empty($_SERVER['HTTP_ACCEPT_LANGUAGE']))
    {
        $pos  = strpos($_SERVER['HTTP_ACCEPT_LANGUAGE'], ';');
        $lang = addslashes(($pos !== false) ? substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, $pos) : $_SERVER['HTTP_ACCEPT_LANGUAGE']);
    }
    else
    {
        $lang = '';
    }

    /* ��Դ */
    if (!empty($_SERVER['HTTP_REFERER']) && strlen($_SERVER['HTTP_REFERER']) > 9)
    {
        $pos = strpos($_SERVER['HTTP_REFERER'], '/', 9);
        if ($pos !== false)
        {
            $domain = substr($_SERVER['HTTP_REFERER'], 0, $pos);
            $path   = substr($_SERVER['HTTP_REFERER'], $pos);

            /* ��Դ�ؼ��� */
            if (!empty($domain) && !empty($path))
            {
                save_searchengine_keyword($domain, $path);
            }
        }
        else
        {
            $domain = $path = '';
        }
    }
    else
    {
        $domain = $path = '';
    }

    $sql = 'INSERT INTO ' . $GLOBALS['ecs']->table('stats') . ' ( ' .
                'ip_address, visit_times, browser, system, language, area, ' .
                'referer_domain, referer_path, access_url, access_time' .
            ') VALUES (' .
                "'$ip', '$visit_times', '$browser', '$os', '$lang', '$area', ".
                "'" . addslashes($domain) ."', '" . addslashes($path) ."', '" . addslashes(PHP_SELF) ."', '" . $time . "')";
    $GLOBALS['db']->query($sql);
}

/**
 * ������������ؼ���
 *
 * @access  public
 * @return  void
 */
function save_searchengine_keyword($domain, $path)
{
    if (strpos($domain, 'google.com.tw') !== false && preg_match('/q=([^&]*)/i', $path, $regs))
    {
        $searchengine = 'GOOGLE TAIWAN';
        $keywords = urldecode($regs[1]); // google taiwan
    }
    if (strpos($domain, 'google.cn') !== false && preg_match('/q=([^&]*)/i', $path, $regs))
    {
        $searchengine = 'GOOGLE CHINA';
        $keywords = urldecode($regs[1]); // google china
    }
    if (strpos($domain, 'google.com') !== false && preg_match('/q=([^&]*)/i', $path, $regs))
    {
        $searchengine = 'GOOGLE';
        $keywords = urldecode($regs[1]); // google
    }
    elseif (strpos($domain, 'baidu.') !== false && preg_match('/wd=([^&]*)/i', $path, $regs))
    {
        $searchengine = 'BAIDU';
        $keywords = urldecode($regs[1]); // baidu
    }
    elseif (strpos($domain, 'baidu.') !== false && preg_match('/word=([^&]*)/i', $path, $regs))
    {
        $searchengine = 'BAIDU';
        $keywords = urldecode($regs[1]); // baidu
    }
    elseif (strpos($domain, '114.vnet.cn') !== false && preg_match('/kw=([^&]*)/i', $path, $regs))
    {
        $searchengine = 'CT114';
        $keywords = urldecode($regs[1]); // ct114
    }
    elseif (strpos($domain, 'iask.com') !== false && preg_match('/k=([^&]*)/i', $path, $regs))
    {
        $searchengine = 'IASK';
        $keywords = urldecode($regs[1]); // iask
    }
    elseif (strpos($domain, 'soso.com') !== false && preg_match('/w=([^&]*)/i', $path, $regs))
    {
        $searchengine = 'SOSO';
        $keywords = urldecode($regs[1]); // soso
    }
    elseif (strpos($domain, 'sogou.com') !== false && preg_match('/query=([^&]*)/i', $path, $regs))
    {
        $searchengine = 'SOGOU';
        $keywords = urldecode($regs[1]); // sogou
    }
    elseif (strpos($domain, 'so.163.com') !== false && preg_match('/q=([^&]*)/i', $path, $regs))
    {
        $searchengine = 'NETEASE';
        $keywords = urldecode($regs[1]); // netease
    }
    elseif (strpos($domain, 'yodao.com') !== false && preg_match('/q=([^&]*)/i', $path, $regs))
    {
        $searchengine = 'YODAO';
        $keywords = urldecode($regs[1]); // yodao
    }
    elseif (strpos($domain, 'zhongsou.com') !== false && preg_match('/word=([^&]*)/i', $path, $regs))
    {
        $searchengine = 'ZHONGSOU';
        $keywords = urldecode($regs[1]); // zhongsou
    }
    elseif (strpos($domain, 'search.tom.com') !== false && preg_match('/w=([^&]*)/i', $path, $regs))
    {
        $searchengine = 'TOM';
        $keywords = urldecode($regs[1]); // tom
    }
    elseif (strpos($domain, 'live.com') !== false && preg_match('/q=([^&]*)/i', $path, $regs))
    {
        $searchengine = 'MSLIVE';
        $keywords = urldecode($regs[1]); // MSLIVE
    }
    elseif (strpos($domain, 'tw.search.yahoo.com') !== false && preg_match('/p=([^&]*)/i', $path, $regs))
    {
        $searchengine = 'YAHOO TAIWAN';
        $keywords = urldecode($regs[1]); // yahoo taiwan
    }
    elseif (strpos($domain, 'cn.yahoo.') !== false && preg_match('/p=([^&]*)/i', $path, $regs))
    {
        $searchengine = 'YAHOO CHINA';
        $keywords = urldecode($regs[1]); // yahoo china
    }
    elseif (strpos($domain, 'yahoo.') !== false && preg_match('/p=([^&]*)/i', $path, $regs))
    {
        $searchengine = 'YAHOO';
        $keywords = urldecode($regs[1]); // yahoo
    }
    elseif (strpos($domain, 'msn.com.tw') !== false && preg_match('/q=([^&]*)/i', $path, $regs))
    {
        $searchengine = 'MSN TAIWAN';
        $keywords = urldecode($regs[1]); // msn taiwan
    }
    elseif (strpos($domain, 'msn.com.cn') !== false && preg_match('/q=([^&]*)/i', $path, $regs))
    {
        $searchengine = 'MSN CHINA';
        $keywords = urldecode($regs[1]); // msn china
    }
    elseif (strpos($domain, 'msn.com') !== false && preg_match('/q=([^&]*)/i', $path, $regs))
    {
        $searchengine = 'MSN';
        $keywords = urldecode($regs[1]); // msn
    }

    if (!empty($keywords))
    {
        $gb_search = array('YAHOO CHINA', 'TOM', 'ZHONGSOU', 'NETEASE', 'SOGOU', 'SOSO', 'IASK', 'CT114', 'BAIDU');
        if (EC_CHARSET == 'utf-8' && in_array($searchengine, $gb_search))
        {
            $keywords = ecs_iconv('GBK', 'UTF8', $keywords);
        }
        if (EC_CHARSET == 'gbk' && !in_array($searchengine, $gb_search))
        {
            $keywords = ecs_iconv('UTF8', 'GBK', $keywords);
        }

        $GLOBALS['db']->autoReplace($GLOBALS['ecs']->table('keywords'), array('date' => local_date('Y-m-d'), 'searchengine' => $searchengine, 'keyword' => addslashes($keywords), 'count' => 1), array('count' => 1));
    }
}

/**
 * ���ָ���û�����Ʒ�����б��
 *
 * @access  public
 * @param   integer $goods_id
 * @param   integer $user_id
 * @return  array
 */
function get_tags($goods_id = 0, $user_id = 0)
{
    $where = '';
    if ($goods_id > 0)
    {
        $where .= " goods_id = '$goods_id'";
    }

    if ($user_id > 0)
    {
        if ($goods_id > 0)
        {
            $where .= " AND";
        }
        $where .= " user_id = '$user_id'";
    }

    if ($where > '')
    {
        $where = ' WHERE' . $where;
    }

    $sql = 'SELECT tag_id, user_id, tag_words, COUNT(tag_id) AS tag_count' .
            ' FROM ' . $GLOBALS['ecs']->table('tag') .
            "$where GROUP BY tag_words";
    $arr = $GLOBALS['db']->getAll($sql);

    return $arr;
}

/**
 * ��ȡָ������ĳ��ģ�������Ķ�̬ģ��
 *
 * @access  public
 * @param   string       $theme    ģ������
 * @param   string       $tmp      ģ������
 *
 * @return array()
 */
function get_dyna_libs($theme, $tmp)
{
    $ext = end(explode('.', $tmp));
    $tmp = basename($tmp,".$ext");
    $sql = 'SELECT region, library, sort_order, id, number, type' .
            ' FROM ' . $GLOBALS['ecs']->table('template') .
            " WHERE theme = '$theme' AND filename = '" . $tmp . "' AND type > 0 AND remarks=''".
            ' ORDER BY region, library, sort_order';
    $res = $GLOBALS['db']->getAll($sql);

    $dyna_libs = array();
    foreach ($res AS $row)
    {
        $dyna_libs[$row['region']][$row['library']][] = array(
            'id'     => $row['id'],
            'number' => $row['number'],
            'type'   => $row['type']
        );
    }

    return $dyna_libs;
}

/**
 * �滻��̬ģ��
 *
 * @access  public
 * @param   string       $matches    ƥ������
 *
 * @return string        ���
 */
function dyna_libs_replace($matches)
{
    $key = '/' . $matches[1];

    if ($row = array_shift($GLOBALS['libs'][$key]))
    {
        $str = '';
        switch($row['type'])
        {
            case 1:
                // �������Ʒ
                $str = '{assign var="cat_goods" value=$cat_goods_' .$row['id']. '}{assign var="goods_cat" value=$goods_cat_' .$row['id']. '}';
                break;
            case 2:
                // Ʒ�Ƶ���Ʒ
                $str = '{assign var="brand_goods" value=$brand_goods_' .$row['id']. '}{assign var="goods_brand" value=$goods_brand_' .$row['id']. '}';
                break;
            case 3:
                // �����б�
                $str = '{assign var="articles" value=$articles_' .$row['id']. '}{assign var="articles_cat" value=$articles_cat_' .$row['id']. '}';
                break;
            case 4:
                //���λ
                $str = '{assign var="ads_id" value=' . $row['id'] . '}{assign var="ads_num" value=' . $row['number'] . '}';
                break;
        }
        return $str . $matches[0];
    }
    else
    {
        return $matches[0];
    }
}

/**
 * �����ϴ��ļ����������ϴ�ͼƬ��(�ϴ�ʧ��ʱ����ͼƬ��Ϊ�գ�
 *
 * @access  public
 * @param array     $upload     $_FILES ����
 * @param array     $type       ͼƬ������𣬼�dataĿ¼�µ��ļ�����
 *
 * @return string               �ϴ�ͼƬ��
 */
function upload_file($upload, $type)
{
    if (!empty($upload['tmp_name']))
    {
        $ftype = check_file_type($upload['tmp_name'], $upload['name'], '|png|jpg|jpeg|gif|doc|xls|txt|zip|ppt|pdf|rar|docx|xlsx|pptx|');
        if (!empty($ftype))
        {
            $name = date('Ymd');
            for ($i = 0; $i < 6; $i++)
            {
                $name .= chr(mt_rand(97, 122));
            }

            $name = $_SESSION['user_id'] . '_' . $name . '.' . $ftype;

            $target = ROOT_PATH . DATA_DIR . '/' . $type . '/' . $name;
            if (!move_upload_file($upload['tmp_name'], $target))
            {
                $GLOBALS['err']->add($GLOBALS['_LANG']['upload_file_error'], 1);

                return false;
            }
            else
            {
                return $name;
            }
        }
        else
        {
            $GLOBALS['err']->add($GLOBALS['_LANG']['upload_file_type'], 1);

            return false;
        }
    }
    else
    {
        $GLOBALS['err']->add($GLOBALS['_LANG']['upload_file_error']);
        return false;
    }
}

/**
 * ��ʾһ����ʾ��Ϣ
 *
 * @access  public
 * @param   string  $content
 * @param   string  $link
 * @param   string  $href
 * @param   string  $type               ��Ϣ���ͣ�warning, error, info
 * @param   string  $auto_redirect      �Ƿ��Զ���ת
 * @return  void
 */
function show_message($content, $links = '', $hrefs = '', $type = 'info', $auto_redirect = true)
{
    assign_template();

    $msg['content'] = $content;
    if (is_array($links) && is_array($hrefs))
    {
        if (!empty($links) && count($links) == count($hrefs))
        {
            foreach($links as $key =>$val)
            {
                $msg['url_info'][$val] = $hrefs[$key];
            }
            $msg['back_url'] = $hrefs['0'];
        }
    }
    else
    {
        $link   = empty($links) ? $GLOBALS['_LANG']['back_up_page'] : $links;
        $href    = empty($hrefs) ? 'javascript:history.back()'       : $hrefs;
        $msg['url_info'][$link] = $href;
        $msg['back_url'] = $href;
    }

    $msg['type']    = $type;
    $position = assign_ur_here(0, $GLOBALS['_LANG']['sys_msg']);
    $GLOBALS['smarty']->assign('page_title', $position['title']);   // ҳ�����
    $GLOBALS['smarty']->assign('ur_here',    $position['ur_here']); // ��ǰλ��

    if (is_null($GLOBALS['smarty']->get_template_vars('helps')))
    {
        $GLOBALS['smarty']->assign('helps', get_shop_help()); // �������
    }

    $GLOBALS['smarty']->assign('auto_redirect', $auto_redirect);
    $GLOBALS['smarty']->assign('message', $msg);
    $GLOBALS['smarty']->display('message.dwt');

    exit;
}

/**
 * ��һ������+10, 10, -10, 10%���ִ�ת��Ϊ��Ӧ���֣������ز�������
 *
 * @access  public
 * @param   string      str     Ҫ��ʽ��������
 * @param   char        operate �������ţ�ֻ�ܷ��ء�+����*��;
 * @return  float       value   ������
 */
function parse_rate_value($str, &$operate)
{
    $operate = '+';
    $is_rate = false;

    $str = trim($str);
    if (empty($str))
    {
        return 0;
    }
    if ($str[strlen($str) - 1] == '%')
    {
        $value = floatval($str);
        if ($value > 0)
        {
            $operate = '*';

            return $value / 100;
        }
        else
        {
            return 0;
        }
    }
    else
    {
        return floatval($str);
    }
}

/**
 * ���¼��㹺�ﳵ�е���Ʒ�۸�Ŀ���ǵ��û���¼ʱ���ܻ�Ա�۸񣬵��û��˳���¼ʱ�����ܻ�Ա�۸�
 * �����Ʒ�д������۸񲻱�
 *
 * @access  public
 * @return  void
 */
function recalculate_price()
{
    /* ȡ���п��ܸı�۸����Ʒ�����������Ʒ֮�����Ʒ */
    $sql = 'SELECT c.rec_id, c.goods_id, c.goods_attr_id, g.promote_price, g.promote_start_date, c.goods_number,'.
                "g.promote_end_date, IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS member_price ".
            'FROM ' . $GLOBALS['ecs']->table('cart') . ' AS c '.
            'LEFT JOIN ' . $GLOBALS['ecs']->table('goods') . ' AS g ON g.goods_id = c.goods_id '.
            "LEFT JOIN " . $GLOBALS['ecs']->table('member_price') . " AS mp ".
                    "ON mp.goods_id = g.goods_id AND mp.user_rank = '" . $_SESSION['user_rank'] . "' ".
            "WHERE session_id = '" .SESS_ID. "' AND c.parent_id = 0 AND c.is_gift = 0 AND c.goods_id > 0 " .
            "AND c.rec_type = '" . CART_GENERAL_GOODS . "' AND c.extension_code <> 'package_buy'";

            $res = $GLOBALS['db']->getAll($sql);

    foreach ($res AS $row)
    {
        $attr_id    = empty($row['goods_attr_id']) ? array() : explode(',', $row['goods_attr_id']);


        $goods_price = get_final_price($row['goods_id'], $row['goods_number'], true, $attr_id);


        $goods_sql = "UPDATE " .$GLOBALS['ecs']->table('cart'). " SET goods_price = '$goods_price' ".
                     "WHERE goods_id = '" . $row['goods_id'] . "' AND session_id = '" . SESS_ID . "' AND rec_id = '" . $row['rec_id'] . "'";

        $GLOBALS['db']->query($goods_sql);
    }

    /* ɾ����Ʒ������ѡ�� */
    $GLOBALS['db']->query('DELETE FROM ' . $GLOBALS['ecs']->table('cart') .
        " WHERE session_id = '" . SESS_ID . "' AND is_gift > 0");
}

/**
 * ��ѯ��������
 *
 * @access  public
 * @params  integer     $id
 * @params  integer     $type
 * @params  integer     $page
 * @return  array
 */
function assign_comment($id, $type, $page = 1)
{
    /* ȡ�������б� */
    $count = $GLOBALS['db']->getOne('SELECT COUNT(*) FROM ' .$GLOBALS['ecs']->table('comment').
           " WHERE id_value = '$id' AND comment_type = '$type' AND status = 1 AND parent_id = 0");
    $size  = !empty($GLOBALS['_CFG']['comments_number']) ? $GLOBALS['_CFG']['comments_number'] : 5;

    $page_count = ($count > 0) ? intval(ceil($count / $size)) : 1;

    /*$sql = 'SELECT * FROM ' . $GLOBALS['ecs']->table('comment') .
            " WHERE id_value = '$id' AND comment_type = '$type' AND status = 1 AND parent_id = 0".
            ' ORDER BY comment_id DESC';*/
    $sql = 'SELECT c.*,u.avatar FROM ' . $GLOBALS['ecs']->table('comment') . ' as c left join ' . $GLOBALS['ecs']->table('users') .
        " as u on c.user_id = u.user_id WHERE c.id_value = '$id' AND c.comment_type = '$type' AND c.status = 1 AND c.parent_id = 0".
        ' ORDER BY c.comment_id DESC';//��Աͷ�� by neo
	$res = $GLOBALS['db']->selectLimit($sql, $size, ($page-1) * $size);

    $arr = array();
    $ids = '';
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        $ids .= $ids ? ",$row[comment_id]" : $row['comment_id'];
        $arr[$row['comment_id']]['id']       = $row['comment_id'];
        $arr[$row['comment_id']]['email']    = $row['email'];
        $arr[$row['comment_id']]['username'] = $row['user_name'];
        $arr[$row['comment_id']]['content']  = str_replace('\r\n', '<br />', htmlspecialchars($row['content']));
        $arr[$row['comment_id']]['content']  = nl2br(str_replace('\n', '<br />', $arr[$row['comment_id']]['content']));
        $arr[$row['comment_id']]['rank']     = $row['comment_rank'];
        $arr[$row['comment_id']]['add_time'] = local_date($GLOBALS['_CFG']['time_format'], $row['add_time']);
		
		$arr[$row['comment_id']]['avatar']     = $row['avatar'];//��Աͷ�� by neo
    }
    /* ȡ�����лظ������� */
    if ($ids)
    {
        $sql = 'SELECT * FROM ' . $GLOBALS['ecs']->table('comment') .
                " WHERE parent_id IN( $ids )";
        $res = $GLOBALS['db']->query($sql);
        while ($row = $GLOBALS['db']->fetch_array($res))
        {
            $arr[$row['parent_id']]['re_content']  = nl2br(str_replace('\n', '<br />', htmlspecialchars($row['content'])));
            $arr[$row['parent_id']]['re_add_time'] = local_date($GLOBALS['_CFG']['time_format'], $row['add_time']);
            $arr[$row['parent_id']]['re_email']    = $row['email'];
            $arr[$row['parent_id']]['re_username'] = $row['user_name'];
        }
    }
    /* ��ҳ��ʽ */
    //$pager['styleid'] = isset($GLOBALS['_CFG']['page_style'])? intval($GLOBALS['_CFG']['page_style']) : 0;
    $pager['page']         = $page;
    $pager['size']         = $size;
    $pager['record_count'] = $count;
    $pager['page_count']   = $page_count;
    $pager['page_first']   = "javascript:gotoPage(1,$id,$type)";
    $pager['page_prev']    = $page > 1 ? "javascript:gotoPage(" .($page-1). ",$id,$type)" : 'javascript:;';
    $pager['page_next']    = $page < $page_count ? 'javascript:gotoPage(' .($page + 1) . ",$id,$type)" : 'javascript:;';
    $pager['page_last']    = $page < $page_count ? 'javascript:gotoPage(' .$page_count. ",$id,$type)"  : 'javascript:;';

    $cmt = array('comments' => $arr, 'pager' => $pager);

    return $cmt;
}

function assign_template($ctype = '', $catlist = array())
{
    global $smarty;

    $smarty->assign('image_width',   $GLOBALS['_CFG']['image_width']);
    $smarty->assign('image_height',  $GLOBALS['_CFG']['image_height']);
    $smarty->assign('points_name',   $GLOBALS['_CFG']['integral_name']);
    $smarty->assign('qq',            explode(',', $GLOBALS['_CFG']['qq']));
    $smarty->assign('ww',            explode(',', $GLOBALS['_CFG']['ww']));
    $smarty->assign('ym',            explode(',', $GLOBALS['_CFG']['ym']));
    $smarty->assign('msn',           explode(',', $GLOBALS['_CFG']['msn']));
    $smarty->assign('skype',         explode(',', $GLOBALS['_CFG']['skype']));
    $smarty->assign('stats_code',    $GLOBALS['_CFG']['stats_code']);
    $smarty->assign('copyright',     sprintf($GLOBALS['_LANG']['copyright'], date('Y'), $GLOBALS['_CFG']['shop_name']));
    $smarty->assign('shop_name',     $GLOBALS['_CFG']['shop_name']);
    $smarty->assign('service_email', $GLOBALS['_CFG']['service_email']);
    $smarty->assign('service_phone', $GLOBALS['_CFG']['service_phone']);
    $smarty->assign('shop_address',  $GLOBALS['_CFG']['shop_address']);
    $smarty->assign('licensed',      license_info());
    $smarty->assign('ecs_version',   VERSION);
    $smarty->assign('icp_number',    $GLOBALS['_CFG']['icp_number']);
    $smarty->assign('username',      !empty($_SESSION['user_name']) ? $_SESSION['user_name'] : '');
    $smarty->assign('category_list', cat_list(0, 0, true,  2, false));
    $smarty->assign('catalog_list',  cat_list(0, 0, false, 1, false));
    //$smarty->assign('navigator_list',        get_navigator($ctype, $catlist));  //�Զ��嵼����

    if (!empty($GLOBALS['_CFG']['search_keywords']))
    {
        $searchkeywords = explode(',', trim($GLOBALS['_CFG']['search_keywords']));
    }
    else
    {
        $searchkeywords = array();
    }
    $smarty->assign('searchkeywords', $searchkeywords);
}

/**
 * ��һ������ʱ���ת��GMTʱ���
 *
 * @access  public
 * @param   int     $time
 *
 * @return int      $gmt_time;
 */
function time2gmt($time)
{
    return strtotime(gmdate('Y-m-d H:i:s', $time));
}

/**
 * ��ѯ��Ա�ĺ�����
 *
 * @access  public
 * @param   integer     $user_id
 * @return  void
 */
function get_user_bonus($user_id = 0)
{
    if ($user_id == 0)
    {
        $user_id = $_SESSION['user_id'];
    }

    $sql = "SELECT SUM(bt.type_money) AS bonus_value, COUNT(*) AS bonus_count ".
            "FROM " .$GLOBALS['ecs']->table('user_bonus'). " AS ub, ".
                $GLOBALS['ecs']->table('bonus_type') . " AS bt ".
            "WHERE ub.user_id = '$user_id' AND ub.bonus_type_id = bt.type_id AND ub.order_id = 0";
    $row = $GLOBALS['db']->getRow($sql);

    return $row;
}

/**
 * �����Ƽ�uid
 *
 * @access  public
 * @param   void
 *
 * @return void
 * @author xuanyan
 **/
function set_affiliate()
{
    $config = unserialize($GLOBALS['_CFG']['affiliate']);
    if (!empty($_GET['u']) && $config['on'] == 1)
    {
        if(!empty($config['config']['expire']))
        {
            if($config['config']['expire_unit'] == 'hour')
            {
                $c = 1;
            }
            elseif($config['config']['expire_unit'] == 'day')
            {
                $c = 24;
            }
            elseif($config['config']['expire_unit'] == 'week')
            {
                $c = 24 * 7;
            }
            else
            {
                $c = 1;
            }
            setcookie('ecshop_affiliate_uid', intval($_GET['u']), gmtime() + 3600 * $config['config']['expire'] * $c);
        }
        else
        {
            setcookie('ecshop_affiliate_uid', intval($_GET['u']), gmtime() + 3600 * 24); // ����ʱ��Ϊ 1 ��
        }
    }
}

/**
 * ��ȡ�Ƽ�uid
 *
 * @access  public
 * @param   void
 *
 * @return int
 * @author xuanyan
 **/
function get_affiliate()
{
    if (!empty($_COOKIE['ecshop_affiliate_uid']))
    {
        $uid = intval($_COOKIE['ecshop_affiliate_uid']);
        if ($GLOBALS['db']->getOne('SELECT user_id FROM ' . $GLOBALS['ecs']->table('users') . "WHERE user_id = '$uid'"))
        {
            return $uid;
        }
        else
        {
            setcookie('ecshop_affiliate_uid', '', 1);
        }
    }

    return 0;
}

/**
 * ���ָ������ͬ�������з����Լ��÷����µ��ӷ���
 *
 * @access  public
 * @param   integer     $cat_id     ������
 * @return  array
 */
function article_categories_tree($cat_id = 0)
{
    if ($cat_id > 0)
    {
        $sql = 'SELECT parent_id FROM ' . $GLOBALS['ecs']->table('article_cat') . " WHERE cat_id = '$cat_id'";
        $parent_id = $GLOBALS['db']->getOne($sql);
    }
    else
    {
        $parent_id = 0;
    }

    /*
     �жϵ�ǰ������ȫ���Ƿ��ǵ׼����࣬
     �����ȡ���׼������ϼ����࣬
     �������ȡ��ǰ���༰���µ��ӷ���
    */
    $sql = 'SELECT count(*) FROM ' . $GLOBALS['ecs']->table('article_cat') . " WHERE parent_id = '$parent_id'";
    if ($GLOBALS['db']->getOne($sql))
    {
        /* ��ȡ��ǰ���༰���ӷ��� */
        $sql = 'SELECT a.cat_id, a.cat_name, a.sort_order AS parent_order, a.cat_id, ' .
                    'b.cat_id AS child_id, b.cat_name AS child_name, b.sort_order AS child_order ' .
                'FROM ' . $GLOBALS['ecs']->table('article_cat') . ' AS a ' .
                'LEFT JOIN ' . $GLOBALS['ecs']->table('article_cat') . ' AS b ON b.parent_id = a.cat_id ' .
                "WHERE a.parent_id = '$parent_id' AND a.cat_type=1 ORDER BY parent_order ASC, a.cat_id ASC, child_order ASC";
    }
    else
    {
        /* ��ȡ��ǰ���༰�丸���� */
        $sql = 'SELECT a.cat_id, a.cat_name, b.cat_id AS child_id, b.cat_name AS child_name, b.sort_order ' .
                'FROM ' . $GLOBALS['ecs']->table('article_cat') . ' AS a ' .
                'LEFT JOIN ' . $GLOBALS['ecs']->table('article_cat') . ' AS b ON b.parent_id = a.cat_id ' .
                "WHERE b.parent_id = '$parent_id' AND b.cat_type = 1 ORDER BY sort_order ASC";
    }
    $res = $GLOBALS['db']->getAll($sql);

    $cat_arr = array();
    foreach ($res AS $row)
    {
        $cat_arr[$row['cat_id']]['id']   = $row['cat_id'];
        $cat_arr[$row['cat_id']]['name'] = $row['cat_name'];
        $cat_arr[$row['cat_id']]['url']  = build_uri('article_cat', array('acid' => $row['cat_id']), $row['cat_name']);

        if ($row['child_id'] != NULL)
        {
            $cat_arr[$row['cat_id']]['children'][$row['child_id']]['id']   = $row['child_id'];
            $cat_arr[$row['cat_id']]['children'][$row['child_id']]['name'] = $row['child_name'];
            $cat_arr[$row['cat_id']]['children'][$row['child_id']]['url']  = build_uri('article_cat', array('acid' => $row['child_id']), $row['child_name']);
        }
    }

    return $cat_arr;
}

/**
 * ���ָ�����·���������ϼ�����
 *
 * @access  public
 * @param   integer $cat    ������
 * @return  array
 */
function get_article_parent_cats($cat)
{
    if ($cat == 0)
    {
        return array();
    }

    $arr = $GLOBALS['db']->GetAll('SELECT cat_id, cat_name, parent_id FROM ' . $GLOBALS['ecs']->table('article_cat'));

    if (empty($arr))
    {
        return array();
    }

    $index = 0;
    $cats  = array();

    while (1)
    {
        foreach ($arr AS $row)
        {
            if ($cat == $row['cat_id'])
            {
                $cat = $row['parent_id'];

                $cats[$index]['cat_id']   = $row['cat_id'];
                $cats[$index]['cat_name'] = $row['cat_name'];

                $index++;
                break;
            }
        }

        if ($index == 0 || $cat == 0)
        {
            break;
        }
    }

    return $cats;
}

/**
 * ȡ��ĳģ��ĳ�����õ�����
 * @param   string      $template   ģ��������index
 * @param   string      $library    ��������recommend_best
 * @param   int         $def_num    Ĭ�����������û������ģ�壬��ʾ������
 * @return  int         ����
 */
function get_library_number($library, $template = null)
{
    global $page_libs;

    if (empty($template))
    {
        $template = basename(PHP_SELF);
        $template = substr($template, 0, strrpos($template, '.'));
    }
    $template = addslashes($template);

    static $lib_list = array();

    /* ���û�и�ģ�����Ϣ��ȡ�ø�ģ�����Ϣ */
    if (!isset($lib_list[$template]))
    {
        $lib_list[$template] = array();
        $sql = "SELECT library, number FROM " . $GLOBALS['ecs']->table('template') .
                " WHERE theme = '" . $GLOBALS['_CFG']['template'] . "'" .
                " AND filename = '$template' AND remarks='' ";
        $res = $GLOBALS['db']->query($sql);
        while ($row = $GLOBALS['db']->fetchRow($res))
        {
            $lib = basename(strtolower(substr($row['library'], 0, strpos($row['library'], '.'))));
            $lib_list[$template][$lib] = $row['number'];
        }
    }

    $num = 0;
    if (isset($lib_list[$template][$library]))
    {
        $num = intval($lib_list[$template][$library]);
    }
    else
    {
        /* ģ�������ļ�����Ĭ��ֵ */
        include_once(ROOT_PATH . ADMIN_PATH . '/includes/lib_template.php');
        static $static_page_libs = null;
        if ($static_page_libs == null)
        {
            $static_page_libs = $page_libs;
        }
        $lib = '/library/' . $library . '.lbi';

        $num = isset($static_page_libs[$template][$lib]) ? $static_page_libs[$template][$lib] :  3;
    }

    return $num;
}

/**
 * ȡ���Զ��嵼�����б�
 * @param   string      $type    λ�ã���top��bottom��middle
 * @return  array         �б�
 */
function get_navigator($ctype = '', $catlist = array())
{
    $sql = 'SELECT * FROM '. $GLOBALS['ecs']->table('nav') . '
            WHERE ifshow = \'1\' ORDER BY type, vieworder';
    $res = $GLOBALS['db']->query($sql);

    $cur_url = substr(strrchr($_SERVER['REQUEST_URI'],'/'),1);

    if (intval($GLOBALS['_CFG']['rewrite']))
    {
        if(strpos($cur_url, '-'))
        {
            preg_match('/([a-z]*)-([0-9]*)/',$cur_url,$matches);
            $cur_url = $matches[1].'.php?id='.$matches[2];
        }
    }
    else
    {
        $cur_url = substr(strrchr($_SERVER['REQUEST_URI'],'/'),1);
    }

    $noindex = false;
    $active = 0;
    $navlist = array(
        'top' => array(),
        'middle' => array(),
        'bottom' => array()
    );
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        $navlist[$row['type']][] = array(
            'name'      =>  $row['name'],
            'opennew'   =>  $row['opennew'],
            'url'       =>  $row['url'],
            'ctype'     =>  $row['ctype'],
            'cid'       =>  $row['cid'],
            );
    }

    /*�����Զ����Ƿ����currentPage*/
    foreach($navlist['middle'] as $k=>$v)
    {
        $condition = empty($ctype) ? (strpos($cur_url, $v['url']) === 0) : (strpos($cur_url, $v['url']) === 0 && strlen($cur_url) == strlen($v['url']));
        if ($condition)
        {
            $navlist['middle'][$k]['active'] = 1;
            $noindex = true;
            $active += 1;
        }
    }

    if(!empty($ctype) && $active < 1)
    {
        foreach($catlist as $key => $val)
        {
            foreach($navlist['middle'] as $k=>$v)
            {
                if(!empty($v['ctype']) && $v['ctype'] == $ctype && $v['cid'] == $val && $active < 1)
                {
                    $navlist['middle'][$k]['active'] = 1;
                    $noindex = true;
                    $active += 1;
                }
            }
        }
    }

    if ($noindex == false) {
        $navlist['config']['index'] = 1;
    }

    return $navlist;
}

/**
 * ��Ȩ��Ϣ����
 *
 * @return  str
 */
function license_info()
{
    if($GLOBALS['_CFG']['licensed'] > 0)
    {
        /* ��ȡHOST */
        if (isset($_SERVER['HTTP_X_FORWARDED_HOST']))
        {
            $host = $_SERVER['HTTP_X_FORWARDED_HOST'];
        }
        elseif (isset($_SERVER['HTTP_HOST']))
        {
            $host = $_SERVER['HTTP_HOST'];
        }
        $url_domain=url_domain();
        $host = 'http://' . $host .$url_domain ;
        $license = '<a href="http://www.ecshop.com/license.php?product=ecshop_b2c&url=' . urlencode($host) . '" target="_blank"
>&nbsp;&nbsp;Licensed</a>';
        return $license;
    }
    else
    {
        return '';
    }
}
function url_domain()
{
    $curr = strpos(PHP_SELF, ADMIN_PATH . '/') !== false ?
            preg_replace('/(.*)(' . ADMIN_PATH . ')(\/?)(.)*/i', '\1', dirname(PHP_SELF)) :
            dirname(PHP_SELF);

    $root = str_replace('\\', '/', $curr);

    if (substr($root, -1) != '/')
    {
        $root .= '/';
    }

    return $root;
}

?>