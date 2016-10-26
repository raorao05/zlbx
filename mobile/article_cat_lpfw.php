<?php

/**
 * ECSHOP 文章分类
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: article_cat.php 17217 2011-01-19 06:29:08Z liubo $
*/


define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

if ((DEBUG_MODE & 2) != 2)
{
    $smarty->caching = true;
}

/* 清除缓存 */
clear_cache_files();

/*------------------------------------------------------ */
//-- INPUT
/*------------------------------------------------------ */

/* 获得指定的分类ID */
if (!empty($_GET['id']))
{
    $cat_id = intval($_GET['id']);
}
elseif (!empty($_GET['category']))
{
    $cat_id = intval($_GET['category']);
}
else
{
    ecs_header("Location: ./\n");

    exit;
}

/* 获得当前页码 */
$page   = !empty($_REQUEST['page'])  && intval($_REQUEST['page'])  > 0 ? intval($_REQUEST['page'])  : 1;

/*------------------------------------------------------ */
//-- PROCESSOR
/*------------------------------------------------------ */

/* 获得页面的缓存ID */
$cache_id = sprintf('%X', crc32($cat_id . '-' . $page . '-' . $_CFG['lang']));

if (!$smarty->is_cached('article_cat.dwt', $cache_id))
{
    /* 如果页面没有被缓存则重新获得页面的内容 */

    $arr=get_categories_tree();
	$i=1;
	foreach($arr as $key=>$v){
		$categories[$i++]=$v;
	}
	assign_template('a', array($cat_id));
    $position = assign_ur_here($cat_id);
    $smarty->assign('page_title',           $position['title']);     // 页面标题
    $smarty->assign('ur_here',              $position['ur_here']);   // 当前位置

    $smarty->assign('categories',           $categories); // 分类树
    $smarty->assign('article_categories',   article_categories_tree($cat_id)); //文章分类树
    $smarty->assign('top_goods',            get_top10());            // 销售排行

    /* Meta */
    $meta = $db->getRow("SELECT keywords, cat_desc, cat_name,parent_id FROM " . $ecs->table('article_cat') . " WHERE cat_id = '$cat_id'");

    if ($meta === false || empty($meta))
    {
        /* 如果没有找到任何记录则返回首页 */
        ecs_header("Location: ./\n");
        exit;
    }
	
	if($meta['parent_id'] == 23 || $meta['parent_id'] == 24){
		$cxlp = $db->getAll("SELECT article_id,title FROM " . $ecs->table('article') . " WHERE cat_id = 23 ");
		$fcxlp = $db->getAll("SELECT article_id,title FROM " . $ecs->table('article') . " WHERE cat_id = 24 ");
		$smarty->assign('cxlp',          $cxlp);    // 车险理赔文章
		$smarty->assign('fcxlp',         $fcxlp);    // 非车险理赔文章
		
		$cx_cat = $db->getAll("SELECT cat_id,cat_name FROM " . $ecs->table('article_cat') . " WHERE parent_id = 23 ");
		$fcx_cat = $db->getAll("SELECT cat_id,cat_name FROM " . $ecs->table('article_cat') . " WHERE parent_id = 24 ");
		$smarty->assign('cx_cat',          $cx_cat);    // 车险理赔分类
		$smarty->assign('fcx_cat',         $fcx_cat);    // 非车险理赔分类
		$smarty->assign('parent_id',         $meta['parent_id']);
	}
	
	@$district_id=$_GET['district_id'];
	
	$catname=get_article_parent_cats($cat_id);
	$smarty->assign('catname',            $catname[(count($catname)-1)]['cat_name']);
	$smarty->assign('catid',            $catname[(count($catname)-1)]['cat_id']);
	
	$cat_list = $db->getAll("SELECT cat_id,cat_name FROM " . $ecs->table('article_cat') . " WHERE parent_id = '".intval($catname[(count($catname)-1)]['cat_id'])."' ");
	$xg_list = $db->getAll("SELECT article_id,title FROM " . $ecs->table('article') . " WHERE article_type = 1 limit 10 ");
	
    $smarty->assign('cat_list',         $cat_list);    // 分类
	$smarty->assign('xg_list',          $xg_list);    // 相关资讯
    $smarty->assign('keywords',    htmlspecialchars($meta['keywords']));
    $smarty->assign('description', htmlspecialchars($meta['cat_desc']));
	$smarty->assign('name',          $meta['cat_name']);

    /* 获得文章总数 */
    $size   = isset($_CFG['article_page_size']) && intval($_CFG['article_page_size']) > 0 ? intval($_CFG['article_page_size']) : 1;
    $count  = get_article_count($cat_id);
    $pages  = ($count > 0) ? ceil($count / $size) : 1;

    if ($page > $pages)
    {
        $page = $pages;
    }
    $pager['search']['id'] = $cat_id;
    $keywords = '';
    $goon_keywords = ''; //继续传递的搜索关键词

    /* 获得文章列表 */
    if (isset($_REQUEST['keywords']))
    {
        $keywords = addslashes(htmlspecialchars(urldecode(trim($_REQUEST['keywords']))));
        $pager['search']['keywords'] = $keywords;
        $search_url = substr(strrchr($_POST['cur_url'], '/'), 1);

        $smarty->assign('search_value',    stripslashes(stripslashes($keywords)));
        $smarty->assign('search_url',       $search_url);
        $count  = get_article_count($cat_id, $keywords);
        $pages  = ($count > 0) ? ceil($count / $size) : 1;
        if ($page > $pages)
        {
                $page = $pages;
        }

        $goon_keywords = urlencode($_REQUEST['keywords']);
    }

    if(@$_GET['p']){
        $page = $_GET['p'];
    }
    $artciles_list = get_cat_articles($cat_id, $page, $size ,$keywords,$district_id);
    if(@$_GET['c']){
        $html = " ";
        if(!empty($artciles_list)) {
            foreach ($artciles_list as $k => $v) {
                $v['title']=sub_str($v['title'],6);
                $v['description']=sub_str($v['description'],25);
                $html .= "<li><a href=\"article.php?id={$v['id']}\">";
                $html .= "<p class=\"col-xs-3 photo\"><a href=\"article.php?id={$v['id']}\"><img src=\"/{$v['file_url']}\"></a></p>";
                $html .= "<article><div class=\"col-xs-9 text\"><a href=\"article.php?id={$v['id']}\">";
                $html .= "<h3><span class=\"time\">{$v['add_time']}</span>{$v['title']}</h3>";
                $html .= "<p>{$v['description']} </p></a></div></article></a></li>";
            }
        }else{
            $html=false;
        }
        echo $html;
        exit;
    }
    $smarty->assign('artciles_list',$artciles_list);//print_r(get_cat_articles($cat_id, $page, $size ,$keywords));exit;
    $smarty->assign('cat_id',    $cat_id);
    /* 分页 */
    assign_pager('article_cat', $cat_id, $count, $size, '', '', $page, $goon_keywords);
    assign_dynamic('article_cat');
}

$smarty->assign('feed_url',         ($_CFG['rewrite'] == 1) ? "feed-typearticle_cat" . $cat_id . ".xml" : 'feed.php?type=article_cat' . $cat_id); // RSS URL

if($cat_id == 10){
	$smarty->display('article_cat_qc.dwt');
}elseif($cat_id == 11){
	$cat_info = $db->getAll("SELECT article_id,title FROM " . $ecs->table('article') . " WHERE cat_id = '".intval($meta['parent_id'])."' ");
	$smarty->assign('cat_info',         $cat_info);    // 分类下的文章
	/* 载入国家 */
    $smarty->assign('country_list', get_regions());
	$smarty->display('article_cat_wd.dwt');
}elseif($cat_id == 12){
	$rd = $db->getAll("SELECT article_id,title,description,file_url FROM " . $ecs->table('article') . " WHERE cat_id = 13 order by article_id desc limit 5 ");
	$hy = $db->getAll("SELECT article_id,title,description,file_url FROM " . $ecs->table('article') . " WHERE cat_id = 14 order by article_id desc limit 5 ");
	$bk = $db->getAll("SELECT article_id,title,description,file_url FROM " . $ecs->table('article') . " WHERE cat_id = 15 order by article_id desc limit 5 ");
	$cx = $db->getAll("SELECT article_id,title,description,file_url FROM " . $ecs->table('article') . " WHERE cat_id = 16 order by article_id desc limit 5 ");
	$ly = $db->getAll("SELECT article_id,title,description,file_url FROM " . $ecs->table('article') . " WHERE cat_id = 17 order by article_id desc limit 3 ");
	$yil = $db->getAll("SELECT article_id,title,description,file_url FROM " . $ecs->table('article') . " WHERE cat_id = 18 order by article_id desc limit 3 ");
	$jc = $db->getAll("SELECT article_id,title,description,file_url FROM " . $ecs->table('article') . " WHERE cat_id = 19 order by article_id desc limit 3 ");
	$yl = $db->getAll("SELECT article_id,title,description,file_url FROM " . $ecs->table('article') . " WHERE cat_id = 20 order by article_id desc limit 3 ");
	$jy = $db->getAll("SELECT article_id,title,description,file_url FROM " . $ecs->table('article') . " WHERE cat_id = 21 order by article_id desc limit 3 ");
	
	$smarty->assign('rd',         $rd);    // 热点文章
	$smarty->assign('hy',         $hy);    // 行业文章
	$smarty->assign('bk',         $bk);    // 百科文章
	$smarty->assign('cx',         $cx);    // 出行文章
	$smarty->assign('ly',         $ly);    // 旅游文章
	$smarty->assign('yil',        $yil);    // 医疗文章
	$smarty->assign('jc',         $jc);    // 家财文章
	$smarty->assign('yl',         $yl);    // 养老文章
	$smarty->assign('jy',         $jy);    // 教育文章
	
	$smarty->display('article_cat.dwt');
}
elseif($cat_id == 29 && $_GET['act2'] == 'lp'){
    $smarty->display('article_cat_lpfw.dwt');
}
elseif($cat_id == 29){
	if (empty($_SESSION['user_id']))
    {
        /* 如果没有找到任何记录则返回首页 */
        ecs_header("Location: user.php\n");
        exit;
    }
	$smarty->display('article_cat_xsba.dwt');
}else{
	$smarty->display('article_cat_cxlp.dwt', $cache_id);
}

?>