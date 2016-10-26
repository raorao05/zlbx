<?php

/**
 * ECSHOP ����������Ʒ��غ���
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: lib_goods.php 17217 2011-01-19 06:29:08Z liubo $
 */

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

/**
 * ȡ���Ƽ������б�
 * @return  array   �Ƽ������б�
 */
function get_intro_list()
{
    return array(
        'is_best'    => $GLOBALS['_LANG']['is_best'],
        'is_new'     => $GLOBALS['_LANG']['is_new'],
        'is_hot'     => $GLOBALS['_LANG']['is_hot'],
        'is_promote' => $GLOBALS['_LANG']['is_promote'],
        'all_type' => $GLOBALS['_LANG']['all_type'],
    );
}

/**
 * ȡ��������λ�б�
 * @return  array   ������λ�б�
 */
function get_unit_list()
{
    return array(
        '1'     => $GLOBALS['_LANG']['unit_kg'],
        '0.001' => $GLOBALS['_LANG']['unit_g'],
    );
}

/**
 * ȡ�û�Ա�ȼ��б�
 * @return  array   ��Ա�ȼ��б�
 */
function get_user_rank_list()
{
    $sql = "SELECT * FROM " . $GLOBALS['ecs']->table('user_rank') .
           " ORDER BY min_points";

    return $GLOBALS['db']->getAll($sql);
}

/**
 * ȡ��ĳ��Ʒ�Ļ�Ա�۸��б�
 * @param   int     $goods_id   ��Ʒ���
 * @return  array   ��Ա�۸��б� user_rank => user_price
 */
function get_member_price_list($goods_id)
{
    /* ȡ�û�Ա�۸� */
    $price_list = array();
    $sql = "SELECT user_rank, user_price FROM " .
           $GLOBALS['ecs']->table('member_price') .
           " WHERE goods_id = '$goods_id'";
    $res = $GLOBALS['db']->query($sql);
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        $price_list[$row['user_rank']] = $row['user_price'];
    }

    return $price_list;
}

/**
 * ����������Ʒ����
 *
 * @param   int     $goods_id           ��Ʒ���
 * @param   array   $id_list            ���Ա������
 * @param   array   $is_spec_list       �Ƿ������� 'true' | 'false'
 * @param   array   $value_price_list   ����ֵ����
 * @return  array                       �����ܵ�Ӱ���goods_attr_id����
 */
function handle_goods_attr($goods_id, $id_list, $is_spec_list, $value_price_list)
{
    $goods_attr_id = array();

    /* ѭ������ÿ������ */
    foreach ($id_list AS $key => $id)
    {
        $is_spec = $is_spec_list[$key];
        if ($is_spec == 'false')
        {
            $value = $value_price_list[$key];
            $price = '';
        }
        else
        {
            $value_list = array();
            $price_list = array();
            if ($value_price_list[$key])
            {
                $vp_list = explode(chr(13), $value_price_list[$key]);
                foreach ($vp_list AS $v_p)
                {
                    $arr = explode(chr(9), $v_p);
                    $value_list[] = $arr[0];
                    $price_list[] = $arr[1];
                }
            }
            $value = join(chr(13), $value_list);
            $price = join(chr(13), $price_list);
        }

        // �������¼�¼
        $sql = "SELECT goods_attr_id FROM " . $GLOBALS['ecs']->table('goods_attr') . " WHERE goods_id = '$goods_id' AND attr_id = '$id' AND attr_value = '$value' LIMIT 0, 1";
        $result_id = $GLOBALS['db']->getOne($sql);
        if (!empty($result_id))
        {
            $sql = "UPDATE " . $GLOBALS['ecs']->table('goods_attr') . "
                    SET attr_value = '$value'
                    WHERE goods_id = '$goods_id'
                    AND attr_id = '$id'
                    AND goods_attr_id = '$result_id'";

            $goods_attr_id[$id] = $result_id;
        }
        else
        {
            $sql = "INSERT INTO " . $GLOBALS['ecs']->table('goods_attr') . " (goods_id, attr_id, attr_value, attr_price) " .
                    "VALUES ('$goods_id', '$id', '$value', '$price')";
        }

        $GLOBALS['db']->query($sql);

        if ($goods_attr_id[$id] == '')
        {
            $goods_attr_id[$id] = $GLOBALS['db']->insert_id();
        }
    }

    return $goods_attr_id;
}

/**
 * ����ĳ��Ʒ�Ļ�Ա�۸�
 * @param   int     $goods_id   ��Ʒ���
 * @param   array   $rank_list  �ȼ��б�
 * @param   array   $price_list �۸��б�
 * @return  void
 */
function handle_member_price($goods_id, $rank_list, $price_list)
{
    /* ѭ������ÿ����Ա�ȼ� */
    foreach ($rank_list AS $key => $rank)
    {
        /* ��Ա�ȼ���Ӧ�ļ۸� */
        $price = $price_list[$key];

        // �������¼�¼
        $sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('member_price') .
               " WHERE goods_id = '$goods_id' AND user_rank = '$rank'";
        if ($GLOBALS['db']->getOne($sql) > 0)
        {
            /* �����Ա�۸���С��0��ɾ��ԭ���۸񣬲��������Ϊ�µļ۸� */
            if ($price < 0)
            {
                $sql = "DELETE FROM " . $GLOBALS['ecs']->table('member_price') .
                       " WHERE goods_id = '$goods_id' AND user_rank = '$rank' LIMIT 1";
            }
            else
            {
                $sql = "UPDATE " . $GLOBALS['ecs']->table('member_price') .
                       " SET user_price = '$price' " .
                       "WHERE goods_id = '$goods_id' " .
                       "AND user_rank = '$rank' LIMIT 1";
            }
        }
        else
        {
            if ($price == -1)
            {
                $sql = '';
            }
            else
            {
                $sql = "INSERT INTO " . $GLOBALS['ecs']->table('member_price') . " (goods_id, user_rank, user_price) " .
                       "VALUES ('$goods_id', '$rank', '$price')";
            }
        }

        if ($sql)
        {
            $GLOBALS['db']->query($sql);
        }
    }
}

/**
 * ����ĳ��Ʒ����չ����
 * @param   int     $goods_id   ��Ʒ���
 * @param   array   $cat_list   ����������
 * @return  void
 */
function handle_other_cat($goods_id, $cat_list)
{
    /* ��ѯ���е���չ���� */
    $sql = "SELECT cat_id FROM " . $GLOBALS['ecs']->table('goods_cat') .
            " WHERE goods_id = '$goods_id'";
    $exist_list = $GLOBALS['db']->getCol($sql);

    /* ɾ�������еķ��� */
    $delete_list = array_diff($exist_list, $cat_list);
    if ($delete_list)
    {
        $sql = "DELETE FROM " . $GLOBALS['ecs']->table('goods_cat') .
                " WHERE goods_id = '$goods_id' " .
                "AND cat_id " . db_create_in($delete_list);
        $GLOBALS['db']->query($sql);
    }

    /* ����¼ӵķ��� */
    $add_list = array_diff($cat_list, $exist_list, array(0));
    foreach ($add_list AS $cat_id)
    {
        // �����¼
        $sql = "INSERT INTO " . $GLOBALS['ecs']->table('goods_cat') .
                " (goods_id, cat_id) " .
                "VALUES ('$goods_id', '$cat_id')";
        $GLOBALS['db']->query($sql);
    }
}

/**
 * ����ĳ��Ʒ�Ĺ�����Ʒ
 * @param   int     $goods_id
 * @return  void
 */
function handle_link_goods($goods_id)
{
    $sql = "UPDATE " . $GLOBALS['ecs']->table('link_goods') . " SET " .
            " goods_id = '$goods_id' " .
            " WHERE goods_id = '0'" .
            " AND admin_id = '$_SESSION[admin_id]'";
    $GLOBALS['db']->query($sql);

    $sql = "UPDATE " . $GLOBALS['ecs']->table('link_goods') . " SET " .
            " link_goods_id = '$goods_id' " .
            " WHERE link_goods_id = '0'" .
            " AND admin_id = '$_SESSION[admin_id]'";
    $GLOBALS['db']->query($sql);
}

/**
 * ����ĳ��Ʒ�����
 * @param   int     $goods_id
 * @return  void
 */
function handle_group_goods($goods_id)
{
    $sql = "UPDATE " . $GLOBALS['ecs']->table('group_goods') . " SET " .
            " parent_id = '$goods_id' " .
            " WHERE parent_id = '0'" .
            " AND admin_id = '$_SESSION[admin_id]'";
    $GLOBALS['db']->query($sql);
}

/**
 * ����ĳ��Ʒ�Ĺ�������
 * @param   int     $goods_id
 * @return  void
 */
function handle_goods_article($goods_id)
{
    $sql = "UPDATE " . $GLOBALS['ecs']->table('goods_article') . " SET " .
            " goods_id = '$goods_id' " .
            " WHERE goods_id = '0'" .
            " AND admin_id = '$_SESSION[admin_id]'";
    $GLOBALS['db']->query($sql);
}

/**
 * ����ĳ��Ʒ�����ͼƬ
 * @param   int     $goods_id
 * @param   array   $image_files
 * @param   array   $image_descs
 * @return  void
 */
function handle_gallery_image($goods_id, $image_files, $image_descs, $image_urls)
{
    /* �Ƿ�������ͼ */
    $proc_thumb = (isset($GLOBALS['shop_id']) && $GLOBALS['shop_id'] > 0)? false : true;
    foreach ($image_descs AS $key => $img_desc)
    {
        /* �Ƿ�ɹ��ϴ� */
        $flag = false;
        if (isset($image_files['error']))
        {
            if ($image_files['error'][$key] == 0)
            {
                $flag = true;
            }
        }
        else
        {
            if ($image_files['tmp_name'][$key] != 'none')
            {
                $flag = true;
            }
        }

        if ($flag)
        {
            // ��������ͼ
            if ($proc_thumb)
            {
                $thumb_url = $GLOBALS['image']->make_thumb($image_files['tmp_name'][$key], $GLOBALS['_CFG']['thumb_width'],  $GLOBALS['_CFG']['thumb_height']);
                $thumb_url = is_string($thumb_url) ? $thumb_url : '';
            }

            $upload = array(
                'name' => $image_files['name'][$key],
                'type' => $image_files['type'][$key],
                'tmp_name' => $image_files['tmp_name'][$key],
                'size' => $image_files['size'][$key],
            );
            if (isset($image_files['error']))
            {
                $upload['error'] = $image_files['error'][$key];
            }
            $img_original = $GLOBALS['image']->upload_image($upload);
            if ($img_original === false)
            {
                sys_msg($GLOBALS['image']->error_msg(), 1, array(), false);
            }
            $img_url = $img_original;

            if (!$proc_thumb)
            {
                $thumb_url = $img_original;
            }
            // ���������֧��GD �����ˮӡ
            if ($proc_thumb && gd_version() > 0)
            {
                $pos        = strpos(basename($img_original), '.');
                $newname    = dirname($img_original) . '/' . $GLOBALS['image']->random_filename() . substr(basename($img_original), $pos);
                copy('../' . $img_original, '../' . $newname);
                $img_url    = $newname;

                $GLOBALS['image']->add_watermark('../'.$img_url,'',$GLOBALS['_CFG']['watermark'], $GLOBALS['_CFG']['watermark_place'], $GLOBALS['_CFG']['watermark_alpha']);
            }

            /* ���¸�ʽ��ͼƬ���� */
            $img_original = reformat_image_name('gallery', $goods_id, $img_original, 'source');
            $img_url = reformat_image_name('gallery', $goods_id, $img_url, 'goods');
            $thumb_url = reformat_image_name('gallery_thumb', $goods_id, $thumb_url, 'thumb');
            $sql = "INSERT INTO " . $GLOBALS['ecs']->table('goods_gallery') . " (goods_id, img_url, img_desc, thumb_url, img_original) " .
                    "VALUES ('$goods_id', '$img_url', '$img_desc', '$thumb_url', '$img_original')";
            $GLOBALS['db']->query($sql);
            /* ��������Ʒԭͼ��ʱ��ɾ��ԭͼ */
            if ($proc_thumb && !$GLOBALS['_CFG']['retain_original_img'] && !empty($img_original))
            {
                $GLOBALS['db']->query("UPDATE " . $GLOBALS['ecs']->table('goods_gallery') . " SET img_original='' WHERE `goods_id`='{$goods_id}'");
                @unlink('../' . $img_original);
            }
        }
        elseif (!empty($image_urls[$key]) && ($image_urls[$key] != $GLOBALS['_LANG']['img_file']) && ($image_urls[$key] != 'http://') && copy(trim($image_urls[$key]), ROOT_PATH . 'temp/' . basename($image_urls[$key])))
        {
            $image_url = trim($image_urls[$key]);

            //����ԭͼ·��
            $down_img = ROOT_PATH . 'temp/' . basename($image_url);

            // ��������ͼ
            if ($proc_thumb)
            {
                $thumb_url = $GLOBALS['image']->make_thumb($down_img, $GLOBALS['_CFG']['thumb_width'],  $GLOBALS['_CFG']['thumb_height']);
                $thumb_url = is_string($thumb_url) ? $thumb_url : '';
                $thumb_url = reformat_image_name('gallery_thumb', $goods_id, $thumb_url, 'thumb');
            }

            if (!$proc_thumb)
            {
                $thumb_url = htmlspecialchars($image_url);
            }

            /* ���¸�ʽ��ͼƬ���� */
            $img_url = $img_original = htmlspecialchars($image_url);
            $sql = "INSERT INTO " . $GLOBALS['ecs']->table('goods_gallery') . " (goods_id, img_url, img_desc, thumb_url, img_original) " .
                    "VALUES ('$goods_id', '$img_url', '$img_desc', '$thumb_url', '$img_original')";
            $GLOBALS['db']->query($sql);

            @unlink($down_img);
        }
    }
}

/**
 * �޸���Ʒĳ�ֶ�ֵ
 * @param   string  $goods_id   ��Ʒ��ţ�����Ϊ������� ',' ����
 * @param   string  $field      �ֶ���
 * @param   string  $value      �ֶ�ֵ
 * @return  bool
 */
function update_goods($goods_id, $field, $value)
{
    if ($goods_id)
    {
        /* ������� */
        clear_cache_files();

        $sql = "UPDATE " . $GLOBALS['ecs']->table('goods') .
                " SET $field = '$value' , last_update = '". gmtime() ."' " .
                "WHERE goods_id " . db_create_in($goods_id);
        return $GLOBALS['db']->query($sql);
    }
    else
    {
        return false;
    }
}

/**
 * �ӻ���վɾ�������Ʒ
 * @param   mix     $goods_id   ��Ʒid�б����Զ��Ÿ񿪣�Ҳ����������
 * @return  void
 */
function delete_goods($goods_id)
{
    if (empty($goods_id))
    {
        return;
    }

    /* ȡ����Ч��Ʒid */
    $sql = "SELECT DISTINCT goods_id FROM " . $GLOBALS['ecs']->table('goods') .
            " WHERE goods_id " . db_create_in($goods_id) . " AND is_delete = 1";
    $goods_id = $GLOBALS['db']->getCol($sql);
    if (empty($goods_id))
    {
        return;
    }

    /* ɾ����ƷͼƬ���ֲ�ͼƬ�ļ� */
    $sql = "SELECT goods_thumb, goods_img, original_img " .
            "FROM " . $GLOBALS['ecs']->table('goods') .
            " WHERE goods_id " . db_create_in($goods_id);
    $res = $GLOBALS['db']->query($sql);
    while ($goods = $GLOBALS['db']->fetchRow($res))
    {
        if (!empty($goods['goods_thumb']))
        {
            @unlink('../' . $goods['goods_thumb']);
        }
        if (!empty($goods['goods_img']))
        {
            @unlink('../' . $goods['goods_img']);
        }
        if (!empty($goods['original_img']))
        {
            @unlink('../' . $goods['original_img']);
        }
    }

    /* ɾ����Ʒ */
    $sql = "DELETE FROM " . $GLOBALS['ecs']->table('goods') .
            " WHERE goods_id " . db_create_in($goods_id);
    $GLOBALS['db']->query($sql);

    /* ɾ����Ʒ�Ļ�Ʒ��¼ */
    $sql = "DELETE FROM " . $GLOBALS['ecs']->table('products') .
            " WHERE goods_id " . db_create_in($goods_id);
    $GLOBALS['db']->query($sql);

    /* ɾ����Ʒ����ͼƬ�ļ� */
    $sql = "SELECT img_url, thumb_url, img_original " .
            "FROM " . $GLOBALS['ecs']->table('goods_gallery') .
            " WHERE goods_id " . db_create_in($goods_id);
    $res = $GLOBALS['db']->query($sql);
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        if (!empty($row['img_url']))
        {
            @unlink('../' . $row['img_url']);
        }
        if (!empty($row['thumb_url']))
        {
            @unlink('../' . $row['thumb_url']);
        }
        if (!empty($row['img_original']))
        {
            @unlink('../' . $row['img_original']);
        }
    }

    /* ɾ����Ʒ��� */
    $sql = "DELETE FROM " . $GLOBALS['ecs']->table('goods_gallery') . " WHERE goods_id " . db_create_in($goods_id);
    $GLOBALS['db']->query($sql);

    /* ɾ����ر��¼ */
    $sql = "DELETE FROM " . $GLOBALS['ecs']->table('collect_goods') . " WHERE goods_id " . db_create_in($goods_id);
    $GLOBALS['db']->query($sql);
    $sql = "DELETE FROM " . $GLOBALS['ecs']->table('goods_article') . " WHERE goods_id " . db_create_in($goods_id);
    $GLOBALS['db']->query($sql);
    $sql = "DELETE FROM " . $GLOBALS['ecs']->table('goods_attr') . " WHERE goods_id " . db_create_in($goods_id);
    $GLOBALS['db']->query($sql);
    $sql = "DELETE FROM " . $GLOBALS['ecs']->table('goods_cat') . " WHERE goods_id " . db_create_in($goods_id);
    $GLOBALS['db']->query($sql);
    $sql = "DELETE FROM " . $GLOBALS['ecs']->table('member_price') . " WHERE goods_id " . db_create_in($goods_id);
    $GLOBALS['db']->query($sql);
    $sql = "DELETE FROM " . $GLOBALS['ecs']->table('group_goods') . " WHERE parent_id " . db_create_in($goods_id);
    $GLOBALS['db']->query($sql);
    $sql = "DELETE FROM " . $GLOBALS['ecs']->table('group_goods') . " WHERE goods_id " . db_create_in($goods_id);
    $GLOBALS['db']->query($sql);
    $sql = "DELETE FROM " . $GLOBALS['ecs']->table('link_goods') . " WHERE goods_id " . db_create_in($goods_id);
    $GLOBALS['db']->query($sql);
    $sql = "DELETE FROM " . $GLOBALS['ecs']->table('link_goods') . " WHERE link_goods_id " . db_create_in($goods_id);
    $GLOBALS['db']->query($sql);
    $sql = "DELETE FROM " . $GLOBALS['ecs']->table('tag') . " WHERE goods_id " . db_create_in($goods_id);
    $GLOBALS['db']->query($sql);
    $sql = "DELETE FROM " . $GLOBALS['ecs']->table('comment') . " WHERE comment_type = 0 AND id_value " . db_create_in($goods_id);
    $GLOBALS['db']->query($sql);

    /* ɾ����Ӧ������Ʒ��¼ */
    $sql = "DELETE FROM " . $GLOBALS['ecs']->table('virtual_card') . " WHERE goods_id " . db_create_in($goods_id);
    if (!$GLOBALS['db']->query($sql, 'SILENT') && $GLOBALS['db']->errno() != 1146)
    {
        die($GLOBALS['db']->error());
    }

    /* ������� */
    clear_cache_files();
}

/**
 * Ϊĳ��Ʒ����Ψһ�Ļ���
 * @param   int     $goods_id   ��Ʒ���
 * @return  string  Ψһ�Ļ���
 */
function generate_goods_sn($goods_id)
{
    $goods_sn = $GLOBALS['_CFG']['sn_prefix'] . str_repeat('0', 6 - strlen($goods_id)) . $goods_id;

    $sql = "SELECT goods_sn FROM " . $GLOBALS['ecs']->table('goods') .
            " WHERE goods_sn LIKE '" . mysql_like_quote($goods_sn) . "%' AND goods_id <> '$goods_id' " .
            " ORDER BY LENGTH(goods_sn) DESC";
    $sn_list = $GLOBALS['db']->getCol($sql);
    if (in_array($goods_sn, $sn_list))
    {
        $max = pow(10, strlen($sn_list[0]) - strlen($goods_sn) + 1) - 1;
        $new_sn = $goods_sn . mt_rand(0, $max);
        while (in_array($new_sn, $sn_list))
        {
            $new_sn = $goods_sn . mt_rand(0, $max);
        }
        $goods_sn = $new_sn;
    }

    return $goods_sn;
}

/**
 * ��Ʒ�����Ƿ��ظ�
 *
 * @param   string     $goods_sn        ��Ʒ���ţ����ڴ��뱾����ǰ�Ա���������SQl�ű�����
 * @param   int        $goods_id        ��Ʒid��Ĭ��ֵΪ��0��û����Ʒid
 * @return  bool                        true���ظ���false�����ظ�
 */
function check_goods_sn_exist($goods_sn, $goods_id = 0)
{
    $goods_sn = trim($goods_sn);
    $goods_id = intval($goods_id);
    if (strlen($goods_sn) == 0)
    {
        return true;    //�ظ�
    }

    if (empty($goods_id))
    {
        $sql = "SELECT goods_id FROM " . $GLOBALS['ecs']->table('goods') ."
                WHERE goods_sn = '$goods_sn'";
    }
    else
    {
        $sql = "SELECT goods_id FROM " . $GLOBALS['ecs']->table('goods') ."
                WHERE goods_sn = '$goods_sn'
                AND goods_id <> '$goods_id'";
    }

    $res = $GLOBALS['db']->getOne($sql);

    if (empty($res))
    {
        return false;    //���ظ�
    }
    else
    {
        return true;    //�ظ�
    }

}

/**
 * ȡ��ͨ�����Ժ�ĳ��������ԣ��Լ�ĳ��Ʒ������ֵ
 * @param   int     $cat_id     ������
 * @param   int     $goods_id   ��Ʒ���
 * @return  array   ����������б�
 */
function get_attr_list($cat_id, $goods_id = 0)
{
    if (empty($cat_id))
    {
        return array();
    }

    // ��ѯ����ֵ����Ʒ������ֵ
    $sql = "SELECT a.attr_id, a.attr_name, a.attr_input_type, a.attr_type, a.attr_values, v.attr_value, v.attr_price ".
            "FROM " .$GLOBALS['ecs']->table('attribute'). " AS a ".
            "LEFT JOIN " .$GLOBALS['ecs']->table('goods_attr'). " AS v ".
            "ON v.attr_id = a.attr_id AND v.goods_id = '$goods_id' ".
            "WHERE a.cat_id = " . intval($cat_id) ." OR a.cat_id = 0 ".
            "ORDER BY a.sort_order, a.attr_type, a.attr_id, v.attr_price, v.goods_attr_id";

    $row = $GLOBALS['db']->GetAll($sql);

    return $row;
}

/**
 * ��ȡ��Ʒ�����а������������б�
 *
 * @access  public
 * @return  array
 */
function get_goods_type_specifications()
{
    // ��ѯ
    $sql = "SELECT DISTINCT cat_id
            FROM " .$GLOBALS['ecs']->table('attribute'). "
            WHERE attr_type = 1";
    $row = $GLOBALS['db']->GetAll($sql);

    $return_arr = array();
    if (!empty($row))
    {
        foreach ($row as $value)
        {
            $return_arr[$value['cat_id']] = $value['cat_id'];
        }
    }
    return $return_arr;
}

/**
 * �����������鴴�����Եı�
 *
 * @access  public
 * @param   int     $cat_id     ������
 * @param   int     $goods_id   ��Ʒ���
 * @return  string
 */
function build_attr_html($cat_id, $goods_id = 0)
{
    $attr = get_attr_list($cat_id, $goods_id);
    $html = '<table width="100%" id="attrTable">';
    $spec = 0;

    foreach ($attr AS $key => $val)
    {
        $html .= "<tr><td class='label'>";
        if ($val['attr_type'] == 1 || $val['attr_type'] == 2)
        {
            $html .= ($spec != $val['attr_id']) ?
                "<a href='javascript:;' onclick='addSpec(this)'>[+]</a>" :
                "<a href='javascript:;' onclick='removeSpec(this)'>[-]</a>";
            $spec = $val['attr_id'];
        }

        $html .= "$val[attr_name]</td><td><input type='hidden' name='attr_id_list[]' value='$val[attr_id]' />";

        if ($val['attr_input_type'] == 0)
        {
            $html .= '<input name="attr_value_list[]" type="text" value="' .htmlspecialchars($val['attr_value']). '" size="40" /> ';
        }
        elseif ($val['attr_input_type'] == 2)
        {
            $html .= '<textarea name="attr_value_list[]" rows="3" cols="40">' .htmlspecialchars($val['attr_value']). '</textarea>';
        }
        else
        {
            $html .= '<select name="attr_value_list[]">';
            $html .= '<option value="">' .$GLOBALS['_LANG']['select_please']. '</option>';

            $attr_values = explode("\n", $val['attr_values']);

            foreach ($attr_values AS $opt)
            {
                $opt    = trim(htmlspecialchars($opt));

                $html   .= ($val['attr_value'] != $opt) ?
                    '<option value="' . $opt . '">' . $opt . '</option>' :
                    '<option value="' . $opt . '" selected="selected">' . $opt . '</option>';
            }
            $html .= '</select> ';
        }

        $html .= ($val['attr_type'] == 1 || $val['attr_type'] == 2) ?
            $GLOBALS['_LANG']['spec_price'].' <input type="text" name="attr_price_list[]" value="' . $val['attr_price'] . '" size="5" maxlength="10" />' :
            ' <input type="hidden" name="attr_price_list[]" value="0" />';

        $html .= '</td></tr>';
    }

    $html .= '</table>';

    return $html;
}

/**
 * ���ָ����Ʒ��ص���Ʒ
 *
 * @access  public
 * @param   integer $goods_id
 * @return  array
 */
function get_linked_goods($goods_id)
{
    $sql = "SELECT lg.link_goods_id AS goods_id, g.goods_name, lg.is_double " .
            "FROM " . $GLOBALS['ecs']->table('link_goods') . " AS lg, " .
                $GLOBALS['ecs']->table('goods') . " AS g " .
            "WHERE lg.goods_id = '$goods_id' " .
            "AND lg.link_goods_id = g.goods_id ";
    if ($goods_id == 0)
    {
        $sql .= " AND lg.admin_id = '$_SESSION[admin_id]'";
    }
    $row = $GLOBALS['db']->getAll($sql);

    foreach ($row AS $key => $val)
    {
        $linked_type = $val['is_double'] == 0 ? $GLOBALS['_LANG']['single'] : $GLOBALS['_LANG']['double'];

        $row[$key]['goods_name'] = $val['goods_name'] . " -- [$linked_type]";

        unset($row[$key]['is_double']);
    }

    return $row;
}

/**
 * ���ָ����Ʒ�����
 *
 * @access  public
 * @param   integer $goods_id
 * @return  array
 */
function get_group_goods($goods_id)
{
    $sql = "SELECT gg.goods_id, CONCAT(g.goods_name, ' -- [', gg.goods_price, ']') AS goods_name " .
            "FROM " . $GLOBALS['ecs']->table('group_goods') . " AS gg, " .
                $GLOBALS['ecs']->table('goods') . " AS g " .
            "WHERE gg.parent_id = '$goods_id' " .
            "AND gg.goods_id = g.goods_id ";
    if ($goods_id == 0)
    {
        $sql .= " AND gg.admin_id = '$_SESSION[admin_id]'";
    }
    $row = $GLOBALS['db']->getAll($sql);

    return $row;
}

/**
 * �����Ʒ�Ĺ�������
 *
 * @access  public
 * @param   integer $goods_id
 * @return  array
 */
function get_goods_articles($goods_id)
{
    $sql = "SELECT g.article_id, a.title " .
            "FROM " .$GLOBALS['ecs']->table('goods_article') . " AS g, " .
                $GLOBALS['ecs']->table('article') . " AS a " .
            "WHERE g.goods_id = '$goods_id' " .
            "AND g.article_id = a.article_id ";
    if ($goods_id == 0)
    {
        $sql .= " AND g.admin_id = '$_SESSION[admin_id]'";
    }
    $row = $GLOBALS['db']->getAll($sql);

    return $row;
}

/**
 * �����Ʒ�б�
 *
 * @access  public
 * @params  integer $isdelete
 * @params  integer $real_goods
 * @params  integer $conditions
 * @return  array
 */
function goods_list($is_delete, $real_goods=1, $conditions = '')
{
    /* �������� */
    $param_str = '-' . $is_delete . '-' . $real_goods;
    $result = get_filter($param_str);
    if ($result === false)
    {
        $day = getdate();
        $today = local_mktime(23, 59, 59, $day['mon'], $day['mday'], $day['year']);

        $filter['cat_id']           = empty($_REQUEST['cat_id']) ? 0 : intval($_REQUEST['cat_id']);
        $filter['intro_type']       = empty($_REQUEST['intro_type']) ? '' : trim($_REQUEST['intro_type']);
        $filter['is_promote']       = empty($_REQUEST['is_promote']) ? 0 : intval($_REQUEST['is_promote']);
        $filter['stock_warning']    = empty($_REQUEST['stock_warning']) ? 0 : intval($_REQUEST['stock_warning']);
        $filter['brand_id']         = empty($_REQUEST['brand_id']) ? 0 : intval($_REQUEST['brand_id']);
        $filter['keyword']          = empty($_REQUEST['keyword']) ? '' : trim($_REQUEST['keyword']);
        $filter['suppliers_id'] = isset($_REQUEST['suppliers_id']) ? (empty($_REQUEST['suppliers_id']) ? '' : trim($_REQUEST['suppliers_id'])) : '';
        $filter['is_on_sale'] = isset($_REQUEST['is_on_sale']) ? ((empty($_REQUEST['is_on_sale']) && $_REQUEST['is_on_sale'] === 0) ? '' : trim($_REQUEST['is_on_sale'])) : '';
        if (isset($_REQUEST['is_ajax']) && $_REQUEST['is_ajax'] == 1)
        {
            $filter['keyword'] = json_str_iconv($filter['keyword']);
        }
        $filter['sort_by']          = empty($_REQUEST['sort_by']) ? 'goods_id' : trim($_REQUEST['sort_by']);
        $filter['sort_order']       = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);
        $filter['extension_code']   = empty($_REQUEST['extension_code']) ? '' : trim($_REQUEST['extension_code']);
        $filter['is_delete']        = $is_delete;
        $filter['real_goods']       = $real_goods;

        $where = $filter['cat_id'] > 0 ? " AND " . get_children($filter['cat_id']) : '';

        /* �Ƽ����� */
        switch ($filter['intro_type'])
        {
            case 'is_best':
                $where .= " AND is_best=1";
                break;
            case 'is_hot':
                $where .= ' AND is_hot=1';
                break;
            case 'is_new':
                $where .= ' AND is_new=1';
                break;
            case 'is_promote':
                $where .= " AND is_promote = 1 AND promote_price > 0 AND promote_start_date <= '$today' AND promote_end_date >= '$today'";
                break;
            case 'all_type';
                $where .= " AND (is_best=1 OR is_hot=1 OR is_new=1 OR (is_promote = 1 AND promote_price > 0 AND promote_start_date <= '" . $today . "' AND promote_end_date >= '" . $today . "'))";
        }

        /* ��澯�� */
        if ($filter['stock_warning'])
        {
            $where .= ' AND goods_number <= warn_number ';
        }

        /* Ʒ�� */
        if ($filter['brand_id'])
        {
            $where .= " AND brand_id='$filter[brand_id]'";
        }

        /* ��չ */
        if ($filter['extension_code'])
        {
            $where .= " AND extension_code='$filter[extension_code]'";
        }

        /* �ؼ��� */
        if (!empty($filter['keyword']))
        {
            $where .= " AND (goods_sn LIKE '%" . mysql_like_quote($filter['keyword']) . "%' OR goods_name LIKE '%" . mysql_like_quote($filter['keyword']) . "%')";
        }

        if ($real_goods > -1)
        {
            $where .= " AND is_real='$real_goods'";
        }

        /* �ϼ� */
        if ($filter['is_on_sale'] !== '')
        {
            $where .= " AND (is_on_sale = '" . $filter['is_on_sale'] . "')";
        }

        /* ������ */
        if (!empty($filter['suppliers_id']))
        {
            $where .= " AND (suppliers_id = '" . $filter['suppliers_id'] . "')";
        }

        $where .= $conditions;

        /* ��¼���� */
        $sql = "SELECT COUNT(*) FROM " .$GLOBALS['ecs']->table('goods'). " AS g WHERE is_delete='$is_delete' $where";
        $filter['record_count'] = $GLOBALS['db']->getOne($sql);

        /* ��ҳ��С */
        $filter = page_and_size($filter);

        $sql = "SELECT goods_id, goods_name, goods_type, goods_sn, shop_price, is_on_sale, is_best, is_new, is_hot, sort_order, goods_number, integral, " .
                    " (promote_price > 0 AND promote_start_date <= '$today' AND promote_end_date >= '$today') AS is_promote ".
                    " FROM " . $GLOBALS['ecs']->table('goods') . " AS g WHERE is_delete='$is_delete' $where" .
                    " ORDER BY $filter[sort_by] $filter[sort_order] ".
                    " LIMIT " . $filter['start'] . ",$filter[page_size]";

        $filter['keyword'] = stripslashes($filter['keyword']);
        set_filter($filter, $sql, $param_str);
    }
    else
    {
        $sql    = $result['sql'];
        $filter = $result['filter'];
    }
    $row = $GLOBALS['db']->getAll($sql);

    return array('goods' => $row, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);
}

/**
 * �����Ʒ�Ƿ��л�Ʒ
 *
 * @access      public
 * @params      integer     $goods_id       ��Ʒid
 * @params      string      $conditions     sql������AND��俪ͷ
 * @return      string number               -1������1�����ڣ�0��������
 */
function check_goods_product_exist($goods_id, $conditions = '')
{
    if (empty($goods_id))
    {
        return -1;  //$goods_id����Ϊ��
    }

    $sql = "SELECT goods_id
            FROM " . $GLOBALS['ecs']->table('products') . "
            WHERE goods_id = '$goods_id'
            " . $conditions . "
            LIMIT 0, 1";
    $result = $GLOBALS['db']->getRow($sql);

    if (empty($result))
    {
        return 0;
    }

    return 1;
}

/**
 * �����Ʒ�Ļ�Ʒ�ܿ��
 *
 * @access      public
 * @params      integer     $goods_id       ��Ʒid
 * @params      string      $conditions     sql������AND��俪ͷ
 * @return      string number
 */
function product_number_count($goods_id, $conditions = '')
{
    if (empty($goods_id))
    {
        return -1;  //$goods_id����Ϊ��
    }

    $sql = "SELECT SUM(product_number)
            FROM " . $GLOBALS['ecs']->table('products') . "
            WHERE goods_id = '$goods_id'
            " . $conditions;
    $nums = $GLOBALS['db']->getOne($sql);
    $nums = empty($nums) ? 0 : $nums;

    return $nums;
}

/**
 * �����Ʒ�Ĺ������ֵ�б�
 *
 * @access      public
 * @params      integer         $goods_id
 * @return      array
 */
function product_goods_attr_list($goods_id)
{
    if (empty($goods_id))
    {
        return array();  //$goods_id����Ϊ��
    }

    $sql = "SELECT goods_attr_id, attr_value FROM " . $GLOBALS['ecs']->table('goods_attr') . " WHERE goods_id = '$goods_id'";
    $results = $GLOBALS['db']->getAll($sql);

    $return_arr = array();
    foreach ($results as $value)
    {
        $return_arr[$value['goods_attr_id']] = $value['attr_value'];
    }

    return $return_arr;
}

/**
 * �����Ʒ����ӵĹ���б�
 *
 * @access      public
 * @params      integer         $goods_id
 * @return      array
 */
function get_goods_specifications_list($goods_id)
{
    if (empty($goods_id))
    {
        return array();  //$goods_id����Ϊ��
    }

    $sql = "SELECT g.goods_attr_id, g.attr_value, g.attr_id, a.attr_name
            FROM " . $GLOBALS['ecs']->table('goods_attr') . " AS g
                LEFT JOIN " . $GLOBALS['ecs']->table('attribute') . " AS a
                    ON a.attr_id = g.attr_id
            WHERE goods_id = '$goods_id'
            AND a.attr_type = 1
            ORDER BY g.attr_id ASC";
    $results = $GLOBALS['db']->getAll($sql);

    return $results;
}

/**
 * �����Ʒ�Ļ�Ʒ�б�
 *
 * @access  public
 * @params  integer $goods_id
 * @params  string  $conditions
 * @return  array
 */
function product_list($goods_id, $conditions = '')
{
    /* �������� */
    $param_str = '-' . $goods_id;
    $result = get_filter($param_str);
    if ($result === false)
    {
        $day = getdate();
        $today = local_mktime(23, 59, 59, $day['mon'], $day['mday'], $day['year']);

        $filter['goods_id']         = $goods_id;
        $filter['keyword']          = empty($_REQUEST['keyword']) ? '' : trim($_REQUEST['keyword']);
        $filter['stock_warning']    = empty($_REQUEST['stock_warning']) ? 0 : intval($_REQUEST['stock_warning']);

        if (isset($_REQUEST['is_ajax']) && $_REQUEST['is_ajax'] == 1)
        {
            $filter['keyword'] = json_str_iconv($filter['keyword']);
        }
        $filter['sort_by']          = empty($_REQUEST['sort_by']) ? 'product_id' : trim($_REQUEST['sort_by']);
        $filter['sort_order']       = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);
        $filter['extension_code']   = empty($_REQUEST['extension_code']) ? '' : trim($_REQUEST['extension_code']);
        $filter['page_count'] = isset($filter['page_count']) ? $filter['page_count'] : 1;

        $where = '';

        /* ��澯�� */
        if ($filter['stock_warning'])
        {
            $where .= ' AND goods_number <= warn_number ';
        }

        /* �ؼ��� */
        if (!empty($filter['keyword']))
        {
            $where .= " AND (product_sn LIKE '%" . $filter['keyword'] . "%')";
        }

        $where .= $conditions;

        /* ��¼���� */
        $sql = "SELECT COUNT(*) FROM " .$GLOBALS['ecs']->table('products'). " AS p WHERE goods_id = $goods_id $where";
        $filter['record_count'] = $GLOBALS['db']->getOne($sql);

        $sql = "SELECT product_id, goods_id, goods_attr, product_sn, product_number
                FROM " . $GLOBALS['ecs']->table('products') . " AS g
                WHERE goods_id = $goods_id $where
                ORDER BY $filter[sort_by] $filter[sort_order]";

        $filter['keyword'] = stripslashes($filter['keyword']);
        //set_filter($filter, $sql, $param_str);
    }
    else
    {
        $sql    = $result['sql'];
        $filter = $result['filter'];
    }
    $row = $GLOBALS['db']->getAll($sql);

    /* ���������� */
    $goods_attr = product_goods_attr_list($goods_id);
    foreach ($row as $key => $value)
    {
        $_goods_attr_array = explode('|', $value['goods_attr']);
        if (is_array($_goods_attr_array))
        {
            $_temp = '';
            foreach ($_goods_attr_array as $_goods_attr_value)
            {
                 $_temp[] = $goods_attr[$_goods_attr_value];
            }
            $row[$key]['goods_attr'] = $_temp;
        }
    }

    return array('product' => $row, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);
}

/**
 * ȡ��Ʒ��Ϣ
 *
 * @access  public
 * @param   int         $product_id     ��Ʒid
 * @param   int         $filed          �ֶ�
 * @return  array
 */
function get_product_info($product_id, $filed = '')
{
    $return_array = array();

    if (empty($product_id))
    {
        return $return_array;
    }

    $filed = trim($filed);
    if (empty($filed))
    {
        $filed = '*';
    }

    $sql = "SELECT $filed FROM  " . $GLOBALS['ecs']->table('products') . " WHERE product_id = '$product_id'";
    $return_array = $GLOBALS['db']->getRow($sql);

    return $return_array;
}

/**
 * ��鵥����Ʒ�Ƿ���ڹ��
 *
 * @param   int        $goods_id          ��Ʒid
 * @return  bool                          true�����ڣ�false��������
 */
function check_goods_specifications_exist($goods_id)
{
    $goods_id = intval($goods_id);

    $sql = "SELECT COUNT(a.attr_id)
            FROM " .$GLOBALS['ecs']->table('attribute'). " AS a, " .$GLOBALS['ecs']->table('goods'). " AS g
            WHERE a.cat_id = g.goods_type
            AND g.goods_id = '$goods_id'";

    $count = $GLOBALS['db']->getOne($sql);

    if ($count > 0)
    {
        return true;    //����
    }
    else
    {
        return false;    //������
    }
}

/**
 * ��Ʒ�Ļ�Ʒ����Ƿ����
 *
 * @param   string     $goods_attr        ��Ʒ�Ļ�Ʒ���
 * @param   string     $goods_id          ��Ʒid
 * @param   int        $product_id        ��Ʒ�Ļ�Ʒid��Ĭ��ֵΪ��0��û�л�Ʒid
 * @return  bool                          true���ظ���false�����ظ�
 */
function check_goods_attr_exist($goods_attr, $goods_id, $product_id = 0)
{
    $goods_id = intval($goods_id);
    if (strlen($goods_attr) == 0 || empty($goods_id))
    {
        return true;    //�ظ�
    }

    if (empty($product_id))
    {
        $sql = "SELECT product_id FROM " . $GLOBALS['ecs']->table('products') ."
                WHERE goods_attr = '$goods_attr'
                AND goods_id = '$goods_id'";
    }
    else
    {
        $sql = "SELECT product_id FROM " . $GLOBALS['ecs']->table('products') ."
                WHERE goods_attr = '$goods_attr'
                AND goods_id = '$goods_id'
                AND product_id <> '$product_id'";
    }

    $res = $GLOBALS['db']->getOne($sql);

    if (empty($res))
    {
        return false;    //���ظ�
    }
    else
    {
        return true;    //�ظ�
    }
}

/**
 * ��Ʒ�Ļ�Ʒ�����Ƿ��ظ�
 *
 * @param   string     $product_sn        ��Ʒ�Ļ�Ʒ���ţ����ڴ��뱾����ǰ�Ա���������SQl�ű�����
 * @param   int        $product_id        ��Ʒ�Ļ�Ʒid��Ĭ��ֵΪ��0��û�л�Ʒid
 * @return  bool                          true���ظ���false�����ظ�
 */
function check_product_sn_exist($product_sn, $product_id = 0)
{
    $product_sn = trim($product_sn);
    $product_id = intval($product_id);
    if (strlen($product_sn) == 0)
    {
        return true;    //�ظ�
    }
    $sql="SELECT goods_id FROM ". $GLOBALS['ecs']->table('goods')."WHERE goods_sn='$product_sn'";
    if($GLOBALS['db']->getOne($sql))
    {
        return true;    //�ظ�
    }


    if (empty($product_id))
    {
        $sql = "SELECT product_id FROM " . $GLOBALS['ecs']->table('products') ."
                WHERE product_sn = '$product_sn'";
    }
    else
    {
        $sql = "SELECT product_id FROM " . $GLOBALS['ecs']->table('products') ."
                WHERE product_sn = '$product_sn'
                AND product_id <> '$product_id'";
    }

    $res = $GLOBALS['db']->getOne($sql);

    if (empty($res))
    {
        return false;    //���ظ�
    }
    else
    {
        return true;    //�ظ�
    }
}

/**
 * ��ʽ����ƷͼƬ���ƣ���Ŀ¼�洢��
 *
 */
function reformat_image_name($type, $goods_id, $source_img, $position='')
{
    $rand_name = gmtime() . sprintf("%03d", mt_rand(1,999));
    $img_ext = substr($source_img, strrpos($source_img, '.'));
    $dir = 'images';
    if (defined('IMAGE_DIR'))
    {
        $dir = IMAGE_DIR;
    }
    $sub_dir = date('Ym', gmtime());
    if (!make_dir(ROOT_PATH.$dir.'/'.$sub_dir))
    {
        return false;
    }
    if (!make_dir(ROOT_PATH.$dir.'/'.$sub_dir.'/source_img'))
    {
        return false;
    }
    if (!make_dir(ROOT_PATH.$dir.'/'.$sub_dir.'/goods_img'))
    {
        return false;
    }
    if (!make_dir(ROOT_PATH.$dir.'/'.$sub_dir.'/thumb_img'))
    {
        return false;
    }
    switch($type)
    {
        case 'goods':
            $img_name = $goods_id . '_G_' . $rand_name;
            break;
        case 'goods_thumb':
            $img_name = $goods_id . '_thumb_G_' . $rand_name;
            break;
        case 'gallery':
            $img_name = $goods_id . '_P_' . $rand_name;
            break;
        case 'gallery_thumb':
            $img_name = $goods_id . '_thumb_P_' . $rand_name;
            break;
    }
    if ($position == 'source')
    {
        if (move_image_file(ROOT_PATH.$source_img, ROOT_PATH.$dir.'/'.$sub_dir.'/source_img/'.$img_name.$img_ext))
        {
            return $dir.'/'.$sub_dir.'/source_img/'.$img_name.$img_ext;
        }
    }
    elseif ($position == 'thumb')
    {
        if (move_image_file(ROOT_PATH.$source_img, ROOT_PATH.$dir.'/'.$sub_dir.'/thumb_img/'.$img_name.$img_ext))
        {
            return $dir.'/'.$sub_dir.'/thumb_img/'.$img_name.$img_ext;
        }
    }
    else
    {
        if (move_image_file(ROOT_PATH.$source_img, ROOT_PATH.$dir.'/'.$sub_dir.'/goods_img/'.$img_name.$img_ext))
        {
            return $dir.'/'.$sub_dir.'/goods_img/'.$img_name.$img_ext;
        }
    }
    return false;
}

function move_image_file($source, $dest)
{
    if (@copy($source, $dest))
    {
        @unlink($source);
        return true;
    }
    return false;
}

?>