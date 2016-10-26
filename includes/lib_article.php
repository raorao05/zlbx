<?php

/**
 * ECSHOP ���¼����·�����غ�����
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: lib_article.php 17217 2011-01-19 06:29:08Z liubo $
*/

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

/**
 * ������·����µ������б�
 *
 * @access  public
 * @param   integer     $cat_id
 * @param   integer     $page
 * @param   integer     $size
 *
 * @return  array
 */
function get_cat_articles($cat_id, $page = 1, $size = 20 ,$requirement='',$district_id='')
{
    //ȡ�����з�0������
    if ($cat_id == '-1')
    {
        $cat_str = 'cat_id > 0';
    }
    else
    {
        $cat_str = get_article_children($cat_id);
    }
	
	$wd= $cat_id==11 ? ",file_url,tel,address,fwxm" : "";
	$district_id= $district_id ? " and district=$district_id" : "";
	$lpal= $cat_id==27 ? ",basj, pfsj, xz, ajlx, bdh, cbgs, bxcp, pfje" : "";
	
    //��������������������������ݾͽ�������    
    if ($requirement != '')
    {
        $sql = 'SELECT article_id, title, author, add_time, file_url, open_type, description,keywords '.$wd . $lpal .
               ' FROM ' .$GLOBALS['ecs']->table('article') .
               ' WHERE is_open = 1 AND title like \'%' . $requirement . '%\' $district_id' .
               ' ORDER BY article_type DESC, article_id DESC';
    }
    else 
    {
        
        $sql = 'SELECT article_id, title, author, add_time, file_url, open_type, description,keywords '.$wd . $lpal .
               ' FROM ' .$GLOBALS['ecs']->table('article') .
               ' WHERE is_open = 1 AND ' . $cat_str .$district_id.
               ' ORDER BY article_type DESC, article_id DESC';
    }

    $res = $GLOBALS['db']->selectLimit($sql, $size, ($page-1) * $size);

    $arr = array();
    if ($res)
    {
        while ($row = $GLOBALS['db']->fetchRow($res))
        {
            $article_id = $row['article_id'];

            $arr[$article_id]['id']          = $article_id;
            $arr[$article_id]['title']       = $row['title'];
            $arr[$article_id]['short_title'] = $GLOBALS['_CFG']['article_title_length'] > 0 ? sub_str($row['title'], $GLOBALS['_CFG']['article_title_length']) : $row['title'];
            $arr[$article_id]['author']      = empty($row['author']) || $row['author'] == '_SHOPHELP' ? $GLOBALS['_CFG']['shop_name'] : $row['author'];
            $arr[$article_id]['url']         = $row['open_type'] != 1 ? build_uri('article', array('aid'=>$article_id), $row['title']) : trim($row['file_url']);
            $arr[$article_id]['add_time']    = date($GLOBALS['_CFG']['date_format'], $row['add_time']);
			$arr[$article_id]['description']       = $row['description'];
			$arr[$article_id]['keywords']       = $row['keywords'];
			$arr[$article_id]['file_url']   = $row['file_url'];
			if($cat_id == 11){
				$arr[$article_id]['tel']        = $row['tel'];
				$arr[$article_id]['address']    = $row['address'];
				$arr[$article_id]['fwxm']       = $row['fwxm'];
			}
			if($cat_id == 27){
				$arr[$article_id]['basj']       = $row['basj'];
				$arr[$article_id]['pfsj']       = $row['pfsj'];
				$arr[$article_id]['xz']         = $row['xz'];
				$arr[$article_id]['ajlx']       = $row['ajlx'];
				$arr[$article_id]['bdh']        = $row['bdh'];
				$arr[$article_id]['cbgs']       = $row['cbgs'];
				$arr[$article_id]['bxcp']       = $row['bxcp'];
				$arr[$article_id]['pfje']       = $row['pfje'];
			}
        }
    }

    return $arr;
}

/**
 * ���ָ�������µ���������
 *
 * @param   integer     $cat_id
 *
 * @return  integer
 */
function get_article_count($cat_id ,$requirement='')
{
    global $db, $ecs;
    if ($requirement != '')
    {
        $count = $db->getOne('SELECT COUNT(*) FROM ' . $ecs->table('article') . ' WHERE ' . get_article_children($cat_id) . ' AND  title like \'%' . $requirement . '%\'  AND is_open = 1');
    }
    else
    {
        $count = $db->getOne("SELECT COUNT(*) FROM " . $ecs->table('article') . " WHERE " . get_article_children($cat_id) . " AND is_open = 1");
    }
    return $count;
}


/**
 * ���ָ�������µ�����
 *
 * @param   integer     $cat_id
 *
 * @return  integer
 */
function get_article_list($cat_id ,$num=12)
{
    global $db, $ecs;
	
    $arr = $db->getAll("SELECT * FROM " . $ecs->table('article') . " WHERE is_open = 1 and cat_id=$cat_id order by article_id desc limit $num");
    
    return $arr;
}
?>