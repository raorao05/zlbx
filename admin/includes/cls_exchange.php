<?php

/**
 * ECSHOP ��̨�Զ��������ݿ�����ļ�
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: cls_exchange.php 17217 2011-01-19 06:29:08Z liubo $
*/

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

/*------------------------------------------------------ */
//-- �������������ݿ����ݽ��н���
/*------------------------------------------------------ */
class exchange
{
    var $table;
    var $db;
    var $id;
    var $name;
    var $error_msg;

    /**
     * ���캯��
     *
     * @access  public
     * @param   string       $table       ���ݿ����
     * @param   dbobject     $db          aodb�Ķ���
     * @param   string       $id          ���ݱ������ֶ���
     * @param   string       $name        ���ݱ���Ҫ����
     *
     * @return void
     */
    function exchange($table, &$db , $id, $name)
    {
        $this->table     = $table;
        $this->db        = &$db;
        $this->id        = $id;
        $this->name      = $name;
        $this->error_msg = '';
    }

    /**
     * �жϱ���ĳ�ֶ��Ƿ��ظ������ظ�����ֹ���򣬲�����������Ϣ
     *
     * @access  public
     * @param   string  $col    �ֶ���
     * @param   string  $name   �ֶ�ֵ
     * @param   integer $id
     *
     * @return void
     */
    function is_only($col, $name, $id = 0, $where='')
    {
        $sql = 'SELECT COUNT(*) FROM ' .$this->table. " WHERE $col = '$name'";
        $sql .= empty($id) ? '' : ' AND ' . $this->id . " <> '$id'";
        $sql .= empty($where) ? '' : ' AND ' .$where;

        return ($this->db->getOne($sql) == 0);
    }

    /**
     * ����ָ�����Ƽ�¼�����ݱ��м�¼����
     *
     * @access  public
     * @param   string      $col        �ֶ���
     * @param   string      $name       �ֶ�����
     *
     * @return   int        ��¼����
     */
    function num($col, $name, $id = 0)
    {
        $sql = 'SELECT COUNT(*) FROM ' .$this->table. " WHERE $col = '$name'";
        $sql .= empty($id) ? '' : ' AND '. $this->id ." != '$id' ";

        return $this->db->getOne($sql);
    }

    /**
     * �༭ĳ���ֶ�
     *
     * @access  public
     * @param   string      $set        Ҫ���¼�����" col = '$name', value = '$value'"
     * @param   int         $id         Ҫ���µļ�¼���
     *
     * @return bool     �ɹ���ʧ��
     */
    function edit($set, $id)
    {
        $sql = 'UPDATE ' . $this->table . ' SET ' . $set . " WHERE $this->id = '$id'";

        if ($this->db->query($sql))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * ȡ��ĳ���ֶε�ֵ
     *
     * @access  public
     * @param   int     $id     ��¼���
     * @param   string  $id     �ֶ���
     *
     * @return string   ȡ��������
     */
    function get_name($id, $name = '')
    {
        if (empty($name))
        {
            $name = $this->name;
        }

        $sql = "SELECT `$name` FROM " . $this->table . " WHERE $this->id = '$id'";

        return $this->db->getOne($sql);
    }

    /**
     * ɾ������¼
     *
     * @access  public
     * @param   int         $id         ��¼���
     *
     * @return bool
     */
    function drop($id)
    {
        $sql = 'DELETE FROM ' . $this->table . " WHERE $this->id = '$id'";

        return $this->db->query($sql);
    }
}

?>