<?php
die('xxx');
/**
 * ECSHOP ��ҳ�ļ�
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: index.php 17217 2011-01-19 06:29:08Z liubo $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

if ((DEBUG_MODE & 2) != 2)
{
    $smarty->caching = true;
}
$ua = strtolower($_SERVER['HTTP_USER_AGENT']);

$uachar = "/(nokia|sony|ericsson|mot|samsung|sgh|lg|philips|panasonic|alcatel|lenovo|cldc|midp|mobile)/i";

if(($ua == '' || preg_match($uachar, $ua))&& !strpos(strtolower($_SERVER['REQUEST_URI']),'wap'))
{
    $Loaction = 'mobile/';

    if (!empty($Loaction))
    {
        ecs_header("Location: $Loaction\n");

        exit;
    }

}

/*------------------------------------------------------ */
//-- Shopexϵͳ��ַת��
/*------------------------------------------------------ */
if (!empty($_GET['gOo']))
{
    if (!empty($_GET['gcat']))
    {
        /* ��Ʒ���ࡣ*/
        $Loaction = 'category.php?id=' . $_GET['gcat'];
    }
    elseif (!empty($_GET['acat']))
    {
        /* ���·��ࡣ*/
        $Loaction = 'article_cat.php?id=' . $_GET['acat'];
    }
    elseif (!empty($_GET['goodsid']))
    {
        /* ��Ʒ���顣*/
        $Loaction = 'goods.php?id=' . $_GET['goodsid'];
    }
    elseif (!empty($_GET['articleid']))
    {
        /* �������顣*/
        $Loaction = 'article.php?id=' . $_GET['articleid'];
    }

    if (!empty($Loaction))
    {
        ecs_header("Location: $Loaction\n");

        exit;
    }
}

//�ж��Ƿ���ajax����
$act = !empty($_GET['act']) ? $_GET['act'] : '';
if ($act == 'cat_rec')
{
    $rec_array = array(1 => 'best', 2 => 'new', 3 => 'hot');
    $rec_type = !empty($_REQUEST['rec_type']) ? intval($_REQUEST['rec_type']) : '1';
    $cat_id = !empty($_REQUEST['cid']) ? intval($_REQUEST['cid']) : '0';
    include_once('includes/cls_json.php');
    $json = new JSON;
    $result   = array('error' => 0, 'content' => '', 'type' => $rec_type, 'cat_id' => $cat_id);

    $children = get_children($cat_id);
    $smarty->assign($rec_array[$rec_type] . '_goods',      get_category_recommend_goods($rec_array[$rec_type], $children));    // �Ƽ���Ʒ
    $smarty->assign('cat_rec_sign', 1);
    $result['content'] = $smarty->fetch('library/recommend_' . $rec_array[$rec_type] . '.lbi');
    die($json->encode($result));
}

/*------------------------------------------------------ */
//-- �ж��Ƿ���ڻ��棬�����������û��棬��֮��ȡ��Ӧ����
/*------------------------------------------------------ */
/* ������ */
/*$cache_id = sprintf('%X', crc32($_SESSION['user_rank'] . '-' . $_CFG['lang']));*/

if (!$smarty->is_cached('index.dwt', $cache_id))
{
    assign_template();

    $position = assign_ur_here();
    $smarty->assign('page_title',      $position['title']);    // ҳ�����
    $smarty->assign('ur_here',         $position['ur_here']);  // ��ǰλ��

    /* meta information */
    $smarty->assign('keywords',        htmlspecialchars($_CFG['shop_keywords']));
    $smarty->assign('description',     htmlspecialchars($_CFG['shop_desc']));
    $smarty->assign('flash_theme',     $_CFG['flash_theme']);  // Flash�ֲ�ͼƬģ��

    $smarty->assign('feed_url',        ($_CFG['rewrite'] == 1) ? 'feed.xml' : 'feed.php'); // RSS URL

    $arr=get_categories_tree();
	$i=1;
	foreach($arr as $key=>$v){
		$categories[$i++]=$v;
	}

    /*foreach($categories as $k=>$v){
        foreach($v['cat_id'] as $k1=>$v1){
            $v1['']
        }
    }*/
	$smarty->assign('categories',      $categories); // ������
    $smarty->assign('helps',           get_shop_help());       // �������
    $smarty->assign('top_goods',       get_top10());           // ��������

    $smarty->assign('best_goods',      get_recommend_goods('best'));    // �Ƽ���Ʒ
    $smarty->assign('new_goods',       get_recommend_goods('new'));     // ������Ʒ
    $smarty->assign('hot_goods',       get_recommend_goods('hot'));     // �ȵ�����
    $smarty->assign('promotion_goods', get_promote_goods()); // �ؼ���Ʒ
    $smarty->assign('brand_list',      get_brands());
    $smarty->assign('promotion_info',  get_promotion_info()); // ����һ����̬��ʾ���д�����Ϣ�ı�ǩ��

    $smarty->assign('invoice_list',    index_get_invoice_query());  // ������ѯ
    $smarty->assign('new_articles',    index_get_new_articles());   // ��������
    $smarty->assign('group_buy_goods', index_get_group_buy());      // �Ź���Ʒ
    $smarty->assign('auction_list',    index_get_auction());        // �����
    $smarty->assign('shop_notice',     $_CFG['shop_notice']);       // �̵깫��

    $time = gmtime();
    $sql = 'SELECT ad_code, ad_link,ad_name FROM ' . $ecs->table("ad") . " WHERE enabled = 1 and position_id=1 and start_time<$time and end_time>$time";
    $ad = $db->getAll($sql);
	foreach($ad as $key=>$v){
		$ad1[($key+1)]=$v;
	}
    $smarty->assign('ad', $ad1);

    $smarty->assign('news_gs',      get_article_list(6)); // ��˾����
	$smarty->assign('news_hy',      get_article_list(7)); // ��ҵ��̬
	$smarty->assign('news_bx',      get_article_list(8)); // ���շ���
	$smarty->assign('news_qt',      get_article_list(9)); // ��������

    $sql = 'SELECT link_logo, link_name  FROM ' . $GLOBALS['ecs']->table('hzhb') . ' ORDER BY link_id desc';
    $res = $GLOBALS['db']->getAll($sql);

    $hz=array();
    foreach ($res AS $row)
    {
        if (!empty($row['link_logo']))
        {
            $hz[] = array('name' => $row['link_name'],
                'url'  => $row['link_url'],
                'logo' => $row['link_logo']);
        }
    }
    $smarty->assign('hz',     $hz);
    /* ��ҳ�Ƽ����� */
    $cat_recommend_res = $db->getAll("SELECT c.cat_id, c.cat_name, cr.recommend_type FROM " . $ecs->table("cat_recommend") . " AS cr INNER JOIN " . $ecs->table("category") . " AS c ON cr.cat_id=c.cat_id");
    if (!empty($cat_recommend_res))
    {
        $cat_rec_array = array();
        foreach($cat_recommend_res as $cat_recommend_data)
        {
            $cat_rec[$cat_recommend_data['recommend_type']][] = array('cat_id' => $cat_recommend_data['cat_id'], 'cat_name' => $cat_recommend_data['cat_name']);
        }
        $smarty->assign('cat_rec', $cat_rec);
    }
	
	$cx=$db->getAll('SELECT cat_id,cat_name FROM ' . $ecs->table("category") . " WHERE parent_id=1 limit 16");
	foreach($cx as $key=>$v){
		$cx_list[($key+1)]=$v;
	}
	$smarty->assign('cx', $cx_list);
	$cx_wz=get_article_list(16,5);       //���з����µ�����
	foreach($cx_wz as $key=>$v){
		$cx_wz_list[($key+1)]=$v;
	}
	$smarty->assign('cx_wz_list', $cx_wz_list);
	
	$ly_wz=get_article_list(17,5);       //���η����µ�����
	foreach($ly_wz as $key=>$v){
		$ly_wz_list[($key+1)]=$v;
	}
	$smarty->assign('ly_wz_list', $ly_wz_list);
	
	$smarty->assign('jn_list',        catecory_type(6));       //�������α����Ƽ�
	$smarty->assign('jw_list',        catecory_type(7));       //�������α����Ƽ�
	$smarty->assign('gat_list',       catecory_type(8));       //�۰�̨���α����Ƽ�
	$smarty->assign('ly_list',        catecory_type_hot(5));    //��������
	
	$jc_wz=get_article_list(19,5);       //�ҲƷ����µ�����
	foreach($jc_wz as $key=>$v){
		$jc_wz_list[($key+1)]=$v;
	}
	$smarty->assign('jc_wz_list', $jc_wz_list);
	
	$smarty->assign('dz_list',         catecory_type(12));       //�������Ƽ�
	$smarty->assign('czw_list',        catecory_type(11));       //�����ݱ����Ƽ�
	$smarty->assign('hz_list',         catecory_type(10));       //���ֱ����Ƽ�
	$smarty->assign('jc_list',         catecory_type_hot(9));    //�ҲƱ�������
	
	$region = $db->getCol("SELECT region_name FROM " . $ecs->table('region') . " WHERE region_type=2");
	$jy_region=explode(",",$_CFG['shop_notice']);
	
	
    /* ҳ���еĶ�̬���� */
    assign_dynamic('index');
}

$smarty->display('index.dwt', $cache_id);

/*------------------------------------------------------ */
//-- PRIVATE FUNCTIONS
/*------------------------------------------------------ */

/**
 * ���÷�������ѯ
 *
 * @access  private
 * @return  array
 */
function index_get_invoice_query()
{
    $sql = 'SELECT o.order_sn, o.invoice_no, s.shipping_code FROM ' . $GLOBALS['ecs']->table('order_info') . ' AS o' .
            ' LEFT JOIN ' . $GLOBALS['ecs']->table('shipping') . ' AS s ON s.shipping_id = o.shipping_id' .
            " WHERE invoice_no > '' AND shipping_status = " . SS_SHIPPED .
            ' ORDER BY shipping_time DESC LIMIT 10';
    $all = $GLOBALS['db']->getAll($sql);

    foreach ($all AS $key => $row)
    {
        $plugin = ROOT_PATH . 'includes/modules/shipping/' . $row['shipping_code'] . '.php';

        if (file_exists($plugin))
        {
            include_once($plugin);

            $shipping = new $row['shipping_code'];
            $all[$key]['invoice_no'] = $shipping->query((string)$row['invoice_no']);
        }
    }

    clearstatcache();

    return $all;
}

/**
 * ������µ������б�
 *
 * @access  private
 * @return  array
 */
function index_get_new_articles()
{
    $sql = 'SELECT a.article_id, a.title, ac.cat_name, a.add_time, a.file_url, a.open_type, ac.cat_id, ac.cat_name ' .
            ' FROM ' . $GLOBALS['ecs']->table('article') . ' AS a, ' .
                $GLOBALS['ecs']->table('article_cat') . ' AS ac' .
            ' WHERE a.is_open = 1 AND a.cat_id = ac.cat_id AND ac.cat_type = 1' .
            ' ORDER BY a.article_type DESC, a.add_time DESC LIMIT ' . $GLOBALS['_CFG']['article_number'];
    $res = $GLOBALS['db']->getAll($sql);

    $arr = array();
    foreach ($res AS $idx => $row)
    {    $arr[$idx]['id']          = $row['article_id'];
        $arr[$idx]['title']       = $row['title'];
        $arr[$idx]['short_title'] = $GLOBALS['_CFG']['article_title_length'] > 0 ?
                                        sub_str($row['title'], $GLOBALS['_CFG']['article_title_length']) : $row['title'];
        $arr[$idx]['cat_name']    = $row['cat_name'];
        $arr[$idx]['add_time']    = local_date($GLOBALS['_CFG']['date_format'], $row['add_time']);
        $arr[$idx]['url']         = $row['open_type'] != 1 ?
                                        build_uri('article', array('aid' => $row['article_id']), $row['title']) : trim($row['file_url']);
        $arr[$idx]['cat_url']     = build_uri('article_cat', array('acid' => $row['cat_id']), $row['cat_name']);
    }

    return $arr;
}

/**
 * ������µ��Ź��
 *
 * @access  private
 * @return  array
 */
function index_get_group_buy()
{
    $time = gmtime();
    $limit = get_library_number('group_buy', 'index');

    $group_buy_list = array();
    if ($limit > 0)
    {
        $sql = 'SELECT gb.act_id AS group_buy_id, gb.goods_id, gb.ext_info, gb.goods_name, g.goods_thumb, g.goods_img ' .
                'FROM ' . $GLOBALS['ecs']->table('goods_activity') . ' AS gb, ' .
                    $GLOBALS['ecs']->table('goods') . ' AS g ' .
                "WHERE gb.act_type = '" . GAT_GROUP_BUY . "' " .
                "AND g.goods_id = gb.goods_id " .
                "AND gb.start_time <= '" . $time . "' " .
                "AND gb.end_time >= '" . $time . "' " .
                "AND g.is_delete = 0 " .
                "ORDER BY gb.act_id DESC " .
                "LIMIT $limit" ;
        $res = $GLOBALS['db']->query($sql);

        while ($row = $GLOBALS['db']->fetchRow($res))
        {
            /* �������ͼΪ�գ�ʹ��Ĭ��ͼƬ */
            $row['goods_img'] = get_image_path($row['goods_id'], $row['goods_img']);
            $row['thumb'] = get_image_path($row['goods_id'], $row['goods_thumb'], true);

            /* ���ݼ۸���ݣ�������ͼ� */
            $ext_info = unserialize($row['ext_info']);
            $price_ladder = $ext_info['price_ladder'];
            if (!is_array($price_ladder) || empty($price_ladder))
            {
                $row['last_price'] = price_format(0);
            }
            else
            {
                foreach ($price_ladder AS $amount_price)
                {
                    $price_ladder[$amount_price['amount']] = $amount_price['price'];
                }
            }
            ksort($price_ladder);
            $row['last_price'] = price_format(end($price_ladder));
            $row['url'] = build_uri('group_buy', array('gbid' => $row['group_buy_id']));
            $row['short_name']   = $GLOBALS['_CFG']['goods_name_length'] > 0 ?
                                           sub_str($row['goods_name'], $GLOBALS['_CFG']['goods_name_length']) : $row['goods_name'];
            $row['short_style_name']   = add_style($row['short_name'],'');
            $group_buy_list[] = $row;
        }
    }

    return $group_buy_list;
}

/**
 * ȡ��������б�
 * @return  array
 */
function index_get_auction()
{
    $now = gmtime();
    $limit = get_library_number('auction', 'index');
    $sql = "SELECT a.act_id, a.goods_id, a.goods_name, a.ext_info, g.goods_thumb ".
            "FROM " . $GLOBALS['ecs']->table('goods_activity') . " AS a," .
                      $GLOBALS['ecs']->table('goods') . " AS g" .
            " WHERE a.goods_id = g.goods_id" .
            " AND a.act_type = '" . GAT_AUCTION . "'" .
            " AND a.is_finished = 0" .
            " AND a.start_time <= '$now'" .
            " AND a.end_time >= '$now'" .
            " AND g.is_delete = 0" .
            " ORDER BY a.start_time DESC" .
            " LIMIT $limit";
    $res = $GLOBALS['db']->query($sql);

    $list = array();
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        $ext_info = unserialize($row['ext_info']);
        $arr = array_merge($row, $ext_info);
        $arr['formated_start_price'] = price_format($arr['start_price']);
        $arr['formated_end_price'] = price_format($arr['end_price']);
        $arr['thumb'] = get_image_path($row['goods_id'], $row['goods_thumb'], true);
        $arr['url'] = build_uri('auction', array('auid' => $arr['act_id']));
        $arr['short_name']   = $GLOBALS['_CFG']['goods_name_length'] > 0 ?
                                           sub_str($arr['goods_name'], $GLOBALS['_CFG']['goods_name_length']) : $arr['goods_name'];
        $arr['short_style_name']   = add_style($arr['short_name'],'');
        $list[] = $arr;
    }

    return $list;
}

/**
 * ������е���������
 *
 * @access  private
 * @return  array
 */


/*���������µ�����TOP3*/
function catecory_type_hot($parent_id){
	$sql = 'SELECT cat_id from ' . $GLOBALS['ecs']->table('category') . ' where parent_id='.$parent_id;
	$res = $GLOBALS['db']->getCol($sql);
	$id_list=implode(",",$res);
	
	$sql = 'SELECT goods_id,goods_name,shop_price,salesnum from ' . $GLOBALS['ecs']->table('goods') . ' where cat_id in('.$id_list.') and is_hot=1 limit 3';
	$re = $GLOBALS['db']->getAll($sql);
	$arr=array();
	foreach($re as $key=>$v){
		$arr[($key+1)]=$v;
	}
	
	return $arr;
}

/*ָ�������µ��Ƽ���Ʒ*/
function catecory_type($cat_id,$type='is_best',$num=5){
	$sql = 'SELECT goods_id,goods_name,shop_price,salesnum from ' . $GLOBALS['ecs']->table('goods') . ' where cat_id='.$cat_id.' and '.$type.'=1 limit '.$num;
	$res = $GLOBALS['db']->getAll($sql);
	$arr=array();
	foreach($res as $key=>$v){
		$arr[($key+1)]=$v;
	}
	
	return $arr;
}

?>