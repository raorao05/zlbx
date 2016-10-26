<?php

/**
 * ECSHOP ���·���
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
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

/* ������� */
clear_cache_files();

/*------------------------------------------------------ */
//-- INPUT
/*------------------------------------------------------ */

/* ���ָ���ķ���ID */
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

/* ��õ�ǰҳ�� */
$page   = !empty($_REQUEST['page'])  && intval($_REQUEST['page'])  > 0 ? intval($_REQUEST['page'])  : 1;

/*------------------------------------------------------ */
//-- PROCESSOR
/*------------------------------------------------------ */

/* ���ҳ��Ļ���ID */
$cache_id = sprintf('%X', crc32($cat_id . '-' . $page . '-' . $_CFG['lang']));

if (!$smarty->is_cached('article_cat.dwt', $cache_id))
{
    /* ���ҳ��û�б����������»��ҳ������� */

    $arr=get_categories_tree();
	$i=1;
	foreach($arr as $key=>$v){
		$categories[$i++]=$v;
	}
	assign_template('a', array($cat_id));
    $position = assign_ur_here($cat_id);
    $smarty->assign('page_title',           $position['title']);     // ҳ�����
    $smarty->assign('ur_here',              $position['ur_here']);   // ��ǰλ��

    $smarty->assign('categories',           $categories); // ������
    $smarty->assign('article_categories',   article_categories_tree($cat_id)); //���·�����
    $smarty->assign('top_goods',            get_top10());            // ��������

    /* Meta */
    $meta = $db->getRow("SELECT keywords, cat_desc, cat_name,parent_id FROM " . $ecs->table('article_cat') . " WHERE cat_id = '$cat_id'");

    if ($meta === false || empty($meta))
    {
        /* ���û���ҵ��κμ�¼�򷵻���ҳ */
        ecs_header("Location: ./\n");
        exit;
    }
	
	if($meta['parent_id'] == 23 || $meta['parent_id'] == 24){
		$cxlp = $db->getAll("SELECT article_id,title FROM " . $ecs->table('article') . " WHERE cat_id = 23 ");
		$fcxlp = $db->getAll("SELECT article_id,title FROM " . $ecs->table('article') . " WHERE cat_id = 24 ");
		$smarty->assign('cxlp',          $cxlp);    // ������������
		$smarty->assign('fcxlp',         $fcxlp);    // �ǳ�����������
		
		$cx_cat = $db->getAll("SELECT cat_id,cat_name FROM " . $ecs->table('article_cat') . " WHERE parent_id = 23 ");
		$fcx_cat = $db->getAll("SELECT cat_id,cat_name FROM " . $ecs->table('article_cat') . " WHERE parent_id = 24 ");
		$smarty->assign('cx_cat',          $cx_cat);    // �����������
		$smarty->assign('fcx_cat',         $fcx_cat);    // �ǳ����������
		$smarty->assign('parent_id',         $meta['parent_id']);
	}
	
	@$district_id=$_GET['district_id'];
	
	$catname=get_article_parent_cats($cat_id);
	$smarty->assign('catname',            $catname[(count($catname)-1)]['cat_name']);
	$smarty->assign('catid',            $catname[(count($catname)-1)]['cat_id']);
	
	$cat_list = $db->getAll("SELECT cat_id,cat_name FROM " . $ecs->table('article_cat') . " WHERE parent_id = '".intval($catname[(count($catname)-1)]['cat_id'])."' ");
	$xg_list = $db->getAll("SELECT article_id,title FROM " . $ecs->table('article') . " WHERE article_type = 1 limit 10 ");
	
    $smarty->assign('cat_list',         $cat_list);    // ����
	$smarty->assign('xg_list',          $xg_list);    // �����Ѷ
    $smarty->assign('keywords',    htmlspecialchars($meta['keywords']));
    $smarty->assign('description', htmlspecialchars($meta['cat_desc']));
	$smarty->assign('name',          $meta['cat_name']);

    /* ����������� */
    $size   = isset($_CFG['article_page_size']) && intval($_CFG['article_page_size']) > 0 ? intval($_CFG['article_page_size']) : 1;
    $count  = get_article_count($cat_id);
    $pages  = ($count > 0) ? ceil($count / $size) : 1;

    if ($page > $pages)
    {
        $page = $pages;
    }
    $pager['search']['id'] = $cat_id;
    $keywords = '';
    $goon_keywords = ''; //�������ݵ������ؼ���

    /* ��������б� */
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
    /* ��ҳ */
    assign_pager('article_cat', $cat_id, $count, $size, '', '', $page, $goon_keywords);
    assign_dynamic('article_cat');
}

$smarty->assign('feed_url',         ($_CFG['rewrite'] == 1) ? "feed-typearticle_cat" . $cat_id . ".xml" : 'feed.php?type=article_cat' . $cat_id); // RSS URL

if($cat_id == 10){
	$smarty->display('article_cat_qc.dwt');
}elseif($cat_id == 11){
	$cat_info = $db->getAll("SELECT article_id,title FROM " . $ecs->table('article') . " WHERE cat_id = '".intval($meta['parent_id'])."' ");
	$smarty->assign('cat_info',         $cat_info);    // �����µ�����
	/* ������� */
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
	
	$smarty->assign('rd',         $rd);    // �ȵ�����
	$smarty->assign('hy',         $hy);    // ��ҵ����
	$smarty->assign('bk',         $bk);    // �ٿ�����
	$smarty->assign('cx',         $cx);    // ��������
	$smarty->assign('ly',         $ly);    // ��������
	$smarty->assign('yil',        $yil);    // ҽ������
	$smarty->assign('jc',         $jc);    // �Ҳ�����
	$smarty->assign('yl',         $yl);    // ��������
	$smarty->assign('jy',         $jy);    // ��������
	
	$smarty->display('article_cat.dwt');
}
elseif($cat_id == 29 && $_GET['act2'] == 'lp'){
    $smarty->display('article_cat_lpfw.dwt');
}
elseif($cat_id == 29){
	if (empty($_SESSION['user_id']))
    {
        /* ���û���ҵ��κμ�¼�򷵻���ҳ */
        ecs_header("Location: user.php\n");
        exit;
    }
	$smarty->display('article_cat_xsba.dwt');
}else{
	$smarty->display('article_cat_cxlp.dwt', $cache_id);
}

?>