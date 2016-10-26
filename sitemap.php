<?php
define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

/* 商品分类 */
//$sql = "SELECT cat_id,cat_name FROM " .$ecs->table('category'). " where parent_id=0 ORDER BY cat_id";
//$goods_cat = $db->getAll($sql);

//print_r(get_child_tree(0));exit;

$smarty->assign('goods_cat1',get_child_tree(0));

//$smarty->assign('goods_cat',$goods_cat);
$smarty->assign('categories4',      get_child_tree(4)); // 分类树
$smarty->assign('categories5',      get_child_tree(5)); // 分类树
/* 文章分类 */
$sql = "SELECT cat_id,cat_name FROM " .$ecs->table('article_cat'). " WHERE cat_type=1";
$article_cat = $db->getAll($sql);
$smarty->assign('article_cat',$article_cat);

$smarty->display("sitemap.dwt");
?>