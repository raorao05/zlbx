<?php

/**
 * ECSHOP 文章内容
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: article.php 17217 2011-01-19 06:29:08Z liubo $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

if ((DEBUG_MODE & 2) != 2)
{
    $smarty->caching = true;
}

/*------------------------------------------------------ */
//-- INPUT
/*------------------------------------------------------ */

if(@$_GET['act2'] == 'gy')
{
    $smarty->display('article_gyzl.dwt');exit;
}
$_REQUEST['id'] = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
$article_id     = $_REQUEST['id'];
if(isset($_REQUEST['cat_id']) && $_REQUEST['cat_id'] < 0)
{
    $article_id = $db->getOne("SELECT article_id FROM " . $ecs->table('article') . " WHERE cat_id = '".intval($_REQUEST['cat_id'])."' ");
}

/*------------------------------------------------------ */
//-- PROCESSOR
/*------------------------------------------------------ */

$cache_id = sprintf('%X', crc32($_REQUEST['id'] . '-' . $_CFG['lang']));

if (!$smarty->is_cached('article.dwt', $cache_id))
{
    /* 文章详情 */
    $article = get_article_info($article_id);

    if (empty($article))
    {
        ecs_header("Location: ./\n");
        exit;
    }

    if (!empty($article['link']) && $article['link'] != 'http://' && $article['link'] != 'https://')
    {
        ecs_header("location:$article[link]\n");
        exit;
    }
	$parent_id = $db->getOne("SELECT parent_id FROM " . $ecs->table('article_cat') . " WHERE cat_id = '".$article['cat_id']."' ");  //父类id
    if($parent_id == 0){
		$cat_list = $db->getAll("SELECT article_id,title FROM " . $ecs->table('article') . " WHERE cat_id = '".intval($article['cat_id'])."' ");
		$smarty->assign('cat_list',         $cat_list);    // 分类下的文章
	}elseif($parent_id == 22){
		$cxlp = $db->getAll("SELECT article_id,title FROM " . $ecs->table('article') . " WHERE cat_id = 23 ");
		$fcxlp = $db->getAll("SELECT article_id,title FROM " . $ecs->table('article') . " WHERE cat_id = 24 ");
		$smarty->assign('cxlp',          $cxlp);    // 车险理赔文章
		$smarty->assign('fcxlp',         $fcxlp);    // 非车险理赔文章
		
		$cx_cat = $db->getAll("SELECT cat_id,cat_name FROM " . $ecs->table('article_cat') . " WHERE parent_id = 23 ");
		$fcx_cat = $db->getAll("SELECT cat_id,cat_name FROM " . $ecs->table('article_cat') . " WHERE parent_id = 24 ");
		$smarty->assign('cx_cat',          $cx_cat);    // 车险理赔分类
		$smarty->assign('fcx_cat',         $fcx_cat);    // 非车险理赔分类
	}
	if($parent_id != 0){
		$cat_info = $db->getAll("SELECT cat_id,cat_name FROM " . $ecs->table('article_cat') . " WHERE parent_id = '".$parent_id."' ");
	}else{
		$cat_info = $db->getAll("SELECT cat_id,cat_name FROM " . $ecs->table('article_cat') . " WHERE parent_id = '".$article['cat_id']."' ");
	}
    $smarty->assign('cat_info',         $cat_info);    // 分类
	$smarty->assign('parent_id',         $parent_id);    // 父类id
	
	$xg_list = $db->getAll("SELECT article_id,title FROM " . $ecs->table('article') . " WHERE article_type = 1 limit 10 ");
	//print_r($cat_info);exit;
	
	$arr=get_categories_tree();
	$i=1;
	foreach($arr as $key=>$v){
		$categories[$i++]=$v;
	}
	$smarty->assign('article_categories',   article_categories_tree($article_id)); //文章分类树
    $smarty->assign('categories',       $categories);  // 分类树
    
	
	$smarty->assign('xg_list',          $xg_list);    // 相关资讯
    $smarty->assign('id',               $article_id);
    $smarty->assign('username',         $_SESSION['user_name']);
    $smarty->assign('email',            $_SESSION['email']);
    $smarty->assign('type',            '1');

   /* if($article['cat_id']='1'){
        $smarty->assign('catname','用户协议');
    }*/
	$catname=get_article_parent_cats($article['cat_id']);
	$smarty->assign('catname',            $catname[(count($catname)-1)]['cat_name']);


    /* 验证码相关设置 */
    if ((intval($_CFG['captcha']) & CAPTCHA_COMMENT) && gd_version() > 0)
    {
        $smarty->assign('enabled_captcha', 1);
        $smarty->assign('rand',            mt_rand());
    }
    //print_r($article);exit;
    $smarty->assign('article',      $article);
    $smarty->assign('keywords',     htmlspecialchars($article['keywords']));
    $smarty->assign('description', htmlspecialchars($article['description']));

    $catlist = array();
    foreach(get_article_parent_cats($article['cat_id']) as $k=>$v)
    {
        $catlist[] = $v['cat_id'];
    }

    assign_template('a', $catlist);

    $position = assign_ur_here($article['cat_id'], $article['title']);
    $smarty->assign('page_title',   $position['title']);    // 页面标题
    $smarty->assign('ur_here',      $position['ur_here']);  // 当前位置
    $smarty->assign('page_title2',      $position['page_title2']);  // 当前位置
    $smarty->assign('comment_type', 1);

    /* 上一篇下一篇文章 */
    $next_article = $db->getRow("SELECT article_id, title FROM " .$ecs->table('article'). " WHERE article_id > $article_id AND cat_id=$article[cat_id] AND is_open=1 LIMIT 1");
    if (!empty($next_article))
    {
        $next_article['url'] = build_uri('article', array('aid'=>$next_article['article_id']), $next_article['title']);
        $smarty->assign('next_article', $next_article);
    }

    $prev_aid = $db->getOne("SELECT max(article_id) FROM " . $ecs->table('article') . " WHERE article_id < $article_id AND cat_id=$article[cat_id] AND is_open=1");
    if (!empty($prev_aid))
    {
        $prev_article = $db->getRow("SELECT article_id, title FROM " .$ecs->table('article'). " WHERE article_id = $prev_aid");
        $prev_article['url'] = build_uri('article', array('aid'=>$prev_article['article_id']), $prev_article['title']);
        $smarty->assign('prev_article', $prev_article);
    }

    assign_dynamic('article');
}
if($article_id == 17)
{
	$smarty->display('article_bxzh.dwt', $cache_id);
}
elseif(isset($article) && $article['cat_id'] > 2)
{
    $smarty->display('article.dwt', $cache_id);
}
else
{
    $smarty->display('article_pro.dwt', $cache_id);
}

/*------------------------------------------------------ */
//-- PRIVATE FUNCTION
/*------------------------------------------------------ */

/**
 * 获得指定的文章的详细信息
 *
 * @access  private
 * @param   integer     $article_id
 * @return  array
 */
function get_article_info($article_id)
{
    /* 获得文章的信息 */
    $sql = "SELECT a.*, IFNULL(AVG(r.comment_rank), 0) AS comment_rank ".
            "FROM " .$GLOBALS['ecs']->table('article'). " AS a ".
            "LEFT JOIN " .$GLOBALS['ecs']->table('comment'). " AS r ON r.id_value = a.article_id AND comment_type = 1 ".
            "WHERE a.is_open = 1 AND a.article_id = '$article_id' GROUP BY a.article_id";
    $row = $GLOBALS['db']->getRow($sql);

    if ($row !== false)
    {
        $row['comment_rank'] = ceil($row['comment_rank']);                              // 用户评论级别取整
        $row['add_time']     = local_date($GLOBALS['_CFG']['date_format'], $row['add_time']); // 修正添加时间显示

        /* 作者信息如果为空，则用网站名称替换 */
        if (empty($row['author']) || $row['author'] == '_SHOPHELP')
        {
            $row['author'] = $GLOBALS['_CFG']['shop_name'];
        }
    }

    return $row;
}

/**
 * 获得文章关联的商品
 *
 * @access  public
 * @param   integer $id
 * @return  array
 */
function article_related_goods($id)
{
    $sql = 'SELECT g.goods_id, g.goods_name, g.goods_thumb, g.goods_img, g.shop_price AS org_price, ' .
                "IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS shop_price, ".
                'g.market_price, g.promote_price, g.promote_start_date, g.promote_end_date ' .
            'FROM ' . $GLOBALS['ecs']->table('goods_article') . ' ga ' .
            'LEFT JOIN ' . $GLOBALS['ecs']->table('goods') . ' AS g ON g.goods_id = ga.goods_id ' .
            "LEFT JOIN " . $GLOBALS['ecs']->table('member_price') . " AS mp ".
                    "ON mp.goods_id = g.goods_id AND mp.user_rank = '$_SESSION[user_rank]' ".
            "WHERE ga.article_id = '$id' AND g.is_on_sale = 1 AND g.is_alone_sale = 1 AND g.is_delete = 0";
    $res = $GLOBALS['db']->query($sql);

    $arr = array();
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        $arr[$row['goods_id']]['goods_id']      = $row['goods_id'];
        $arr[$row['goods_id']]['goods_name']    = $row['goods_name'];
        $arr[$row['goods_id']]['short_name']   = $GLOBALS['_CFG']['goods_name_length'] > 0 ?
            sub_str($row['goods_name'], $GLOBALS['_CFG']['goods_name_length']) : $row['goods_name'];
        $arr[$row['goods_id']]['goods_thumb']   = get_image_path($row['goods_id'], $row['goods_thumb'], true);
        $arr[$row['goods_id']]['goods_img']     = get_image_path($row['goods_id'], $row['goods_img']);
        $arr[$row['goods_id']]['market_price']  = price_format($row['market_price']);
        $arr[$row['goods_id']]['shop_price']    = price_format($row['shop_price']);
        $arr[$row['goods_id']]['url']           = build_uri('goods', array('gid' => $row['goods_id']), $row['goods_name']);

        if ($row['promote_price'] > 0)
        {
            $arr[$row['goods_id']]['promote_price'] = bargain_price($row['promote_price'], $row['promote_start_date'], $row['promote_end_date']);
            $arr[$row['goods_id']]['formated_promote_price'] = price_format($arr[$row['goods_id']]['promote_price']);
        }
        else
        {
            $arr[$row['goods_id']]['promote_price'] = 0;
        }
    }

    return $arr;
}

?>