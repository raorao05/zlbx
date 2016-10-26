<?php

/**
 * ECSHOP ���ݿ⵼����
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: cls_sql_dump.php 17217 2011-01-19 06:29:08Z liubo $
*/

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

/**
 * ��mysql�����ַ���ת��
 *
 * @access  public
 * @param   string      $str
 *
 * @return string
 */
function dump_escape_string($str)
{
    return cls_mysql::escape_string($str);
}

/**
 * ��mysql��¼�е�nullֵ���д���
 *
 * @access  public
 * @param   string      $str
 *
 * @return string
 */
function dump_null_string($str)
{
    if (!isset($str) || is_null($str))
    {
        $str = 'NULL';
    }

    return $str;
}


class cls_sql_dump
{
    var $max_size  = 2097152; // 2M
    var $is_short  = false;
    var $offset    = 300;
    var $dump_sql  = '';
    var $sql_num   = 0;
    var $error_msg = '';

    var $db;

    /**
     *  ��Ĺ��캯��
     *
     * @access  public
     * @param
     *
     * @return void
     */
    function cls_sql_dump(&$db, $max_size=0)
    {
        $this->db = &$db;
        if ($max_size > 0 )
        {
            $this->max_size = $max_size;
        }

    }

    /**
     *  ��Ĺ��캯��
     *
     * @access  public
     * @param
     *
     * @return void
     */
    function __construct(&$db, $max_size =0)
    {
        $this->cls_sql_dump($db, $max_size);
    }

    /**
     *  ��ȡָ����Ķ���
     *
     * @access  public
     * @param   string      $table      ���ݱ���
     * @param   boolen      $add_drop   �Ƿ����drop table
     *
     * @return  string      $sql
     */
    function get_table_df($table, $add_drop = false)
    {
        if ($add_drop)
        {
            $table_df = "DROP TABLE IF EXISTS `$table`;\r\n";
        }
        else
        {
            $table_df = '';
        }

        $tmp_arr = $this->db->getRow("SHOW CREATE TABLE `$table`");
        $tmp_sql = $tmp_arr['Create Table'];
        $tmp_sql = substr($tmp_sql, 0, strrpos($tmp_sql, ")") + 1); //ȥ����β���塣

        if ($this->db->version() >= '4.1')
        {
            $table_df .= $tmp_sql . " ENGINE=MyISAM DEFAULT CHARSET=" . str_replace('-', '', EC_CHARSET) . ";\r\n";
        }
        else
        {
            $table_df .= $tmp_sql . " TYPE=MyISAM;\r\n";
        }

        return $table_df;
    }

    /**
     *  ��ȡָ��������ݶ���
     *
     * @access  public
     * @param   string      $table      ����
     * @param   int         $pos        ���ݿ�ʼλ��
     *
     * @return  int         $post_pos   ��¼λ��
     */
    function get_table_data($table, $pos)
    {
        $post_pos = $pos;

        /* ��ȡ���ݱ��¼���� */
        $total = $this->db->getOne("SELECT COUNT(*) FROM $table");

        if ($total == 0 || $pos >= $total)
        {
            /* ���봦�� */
            return -1;
        }

        /* ȷ��ѭ������ */
        $cycle_time = ceil(($total-$pos) / $this->offset); //ÿ��ȡoffset��������Ҫȡ�Ĵ���

        /* ѭ�������ݱ� */
        for($i = 0; $i<$cycle_time; $i++)
        {
            /* ��ȡ���ݿ����� */
            $data = $this->db->getAll("SELECT * FROM $table LIMIT " . ($this->offset * $i + $pos) . ', ' . $this->offset);
            $data_count = count($data);

            $fields = array_keys($data[0]);
            $start_sql = "INSERT INTO `$table` ( `" . implode("`, `", $fields) . "` ) VALUES ";

            /* ѭ��������д�� */
            for($j=0; $j< $data_count; $j++)
            {
                $record = array_map("dump_escape_string", $data[$j]);   //���˷Ƿ��ַ�
                $record = array_map("dump_null_string", $record);     //����nullֵ

                /* ����Ƿ���д�룬����д�� */
                if ($this->is_short)
                {
                    if ($post_pos == $total-1)
                    {
                        $tmp_dump_sql = " ( '" . implode("', '" , $record) . "' );\r\n";
                    }
                    else
                    {
                        if ($j == $data_count - 1)
                        {
                            $tmp_dump_sql = " ( '" . implode("', '" , $record) . "' );\r\n";
                        }
                        else
                        {
                            $tmp_dump_sql = " ( '" . implode("', '" , $record) . "' ),\r\n";
                        }
                    }

                    if ($post_pos == $pos)
                    {
                        /* ��һ�β������� */
                        $tmp_dump_sql = $start_sql . "\r\n" . $tmp_dump_sql;
                    }
                    else
                    {
                        if ($j == 0)
                        {
                            $tmp_dump_sql = $start_sql . "\r\n" . $tmp_dump_sql;
                        }
                    }
                }
                else
                {
                    $tmp_dump_sql = $start_sql . " ('" . implode("', '" , $record) . "');\r\n";
                }

                $tmp_str_pos = strpos($tmp_dump_sql, 'NULL');         //�Ѽ�¼��nullֵ������ȥ��
                $tmp_dump_sql = empty($tmp_str_pos) ? $tmp_dump_sql : substr($tmp_dump_sql, 0, $tmp_str_pos - 1) . 'NULL' . substr($tmp_dump_sql, $tmp_str_pos + 5);

                if (strlen($this->dump_sql) + strlen($tmp_dump_sql) > $this->max_size - 32)
                {
                    if ($this->sql_num == 0)
                    {
                        $this->dump_sql .= $tmp_dump_sql; //���ǵ�һ����¼ʱǿ��д��
                        $this->sql_num++;
                        $post_pos++;
                        if ($post_pos == $total)
                        {
                            /* ���������Ѿ�д�� */
                            return -1;
                        }
                    }

                    return $post_pos;
                }
                else
                {
                    $this->dump_sql .= $tmp_dump_sql;
                    $this->sql_num++; //��¼sql����
                    $post_pos++;
                }
            }
        }

        /* ���������Ѿ�д�� */
        return -1;
    }

    /**
     *  ����һ�����ݱ�
     *
     * @access  public
     * @param   string      $path       ����·���������ļ�
     * @param   int         $vol        ���
     *
     * @return  array       $tables     δ������ı��б�
     */
    function dump_table($path, $vol)
    {
        $tables = $this->get_tables_list($path);

        if ($tables === false)
        {
            return false;
        }

        if (empty($tables))
        {
            return $tables;
        }

        $this->dump_sql = $this->make_head($vol);

        foreach($tables as $table => $pos)
        {

            if ($pos == -1)
            {
                /* ��ȡ���壬���û�г��������򱣴� */
                $table_df = $this->get_table_df($table, true);
                if (strlen($this->dump_sql) + strlen($table_df) > $this->max_size - 32)
                {
                    if ($this->sql_num == 0)
                    {
                        /* ��һ����¼��ǿ��д�� */
                        $this->dump_sql .= $table_df;
                        $this->sql_num +=2;
                        $tables[$table] = 0;
                    }
                    /* �Ѿ��ﵽ���� */

                    break;
                }
                else
                {
                    $this->dump_sql .= $table_df;
                    $this->sql_num +=2;
                    $pos = 0;
                }
            }

            /* �����ܶ��ȡ���ݱ����� */
            $post_pos = $this->get_table_data($table, $pos);

            if ($post_pos == -1)
            {
                /* �ñ��Ѿ���ɣ�����ñ� */
                unset($tables[$table]);
            }
            else
            {
                /* �ñ�δ��ɡ�˵����Ҫ��������,��¼��������λ�� */
                $tables[$table] = $post_pos;
                break;
            }
        }

        $this->dump_sql .= '-- END ecshop v2.x SQL Dump Program ';
        $this->put_tables_list($path, $tables);

        return $tables;
    }

    /**
     *  ���ɱ����ļ�ͷ��
     *
     * @access  public
     * @param   int     �ļ�����
     *
     * @return  string  $str    �����ļ�ͷ��
     */
    function make_head($vol)
    {
        /* ϵͳ��Ϣ */
        $sys_info['os']         = PHP_OS;
        $sys_info['web_server'] = $GLOBALS['ecs']->get_domain();
        $sys_info['php_ver']    = PHP_VERSION;
        $sys_info['mysql_ver']  = $this->db->version();
        $sys_info['date']       = date('Y-m-d H:i:s');

        $head = "-- ecshop v2.x SQL Dump Program\r\n".
                 "-- " . $sys_info['web_server'] . "\r\n".
                 "-- \r\n".
                 "-- DATE : ".$sys_info["date"]."\r\n".
                 "-- MYSQL SERVER VERSION : ".$sys_info['mysql_ver']."\r\n".
                 "-- PHP VERSION : ".$sys_info['php_ver']."\r\n".
                 "-- ECShop VERSION : ".VERSION."\r\n".
                 "-- Vol : " . $vol . "\r\n";

        return $head;
    }

    /**
     *  ��ȡ�����ļ���Ϣ
     *
     * @access  public
     * @param   string      $path       �����ļ�·��
     *
     * @return  array       $arr        ��Ϣ����
     */
    function get_head($path)
    {
        /* ��ȡsql�ļ�ͷ����Ϣ */
        $sql_info = array('date'=>'', 'mysql_ver'=> '', 'php_ver'=>0, 'ecs_ver'=>'', 'vol'=>0);
        $fp = fopen($path,'rb');
        $str = fread($fp, 250);
        fclose($fp);
        $arr = explode("\n", $str);

        foreach ($arr AS $val)
        {
            $pos = strpos($val, ':');
            if ($pos > 0)
            {
                $type = trim(substr($val, 0, $pos), "-\n\r\t ");
                $value = trim(substr($val, $pos+1), "/\n\r\t ");
                if ($type == 'DATE')
                {
                    $sql_info['date'] = $value;
                }
                elseif ($type == 'MYSQL SERVER VERSION')
                {
                    $sql_info['mysql_ver'] = $value;
                }
                elseif ($type == 'PHP VERSION')
                {
                    $sql_info['php_ver'] = $value;
                }
                elseif ($type == 'ECShop VERSION')
                {
                    $sql_info['ecs_ver'] = $value;
                }
                elseif ($type == 'Vol')
                {
                    $sql_info['vol'] = $value;
                }
            }
        }

        return $sql_info;
    }

    /**
     *  ���ļ������ݱ��б�ȡ��
     *
     * @access  public
     * @param   string      $path    �ļ�·��
     *
     * @return  array       $arr    ���ݱ��б�
     */
    function get_tables_list($path)
    {
        if (!file_exists($path))
        {
            $this->error_msg = $path . ' is not exists';

            return false;
        }

        $arr = array();
        $str = @file_get_contents($path);

        if (!empty($str))
        {
            $tmp_arr = explode("\n", $str);
            foreach ($tmp_arr as $val)
            {
                $val = trim ($val, "\r;");
                if (!empty($val))
                {
                    list($table, $count) = explode(':',$val);
                    $arr[$table] = $count;
                }
            }
        }

        return $arr;
    }

    /**
     *  �����ݱ�����д��ָ���ļ�
     *
     * @access  public
     * @param   string      $path    �ļ�·��
     * @param   array       $arr    Ҫд�������
     *
     * @return  boolen
     */
    function put_tables_list($path, $arr)
    {
        if (is_array($arr))
        {
            $str = '';
            foreach($arr as $key => $val)
            {
                $str .= $key . ':' . $val . ";\r\n";
            }

            if (@file_put_contents($path, $str))
            {
                return true;
            }
            else
            {
                $this->error_msg = 'Can not write ' . $path;

                return false;
            }
        }
        else
        {
            $this->error_msg = 'It need a array';

            return false;
        }
    }

    /**
     *  ����һ�����������
     *
     * @access  public
     * @param
     *
     * @return      string      $str    �������
     */
    function get_random_name()
    {
        $str = date('Ymd');

        for ($i = 0; $i < 6; $i++)
        {
            $str .= chr(mt_rand(97, 122));
        }

        return $str;
    }

    /**
     *  ���ش�����Ϣ
     *
     * @access  public
     * @param
     *
     * @return void
     */
    function errorMsg()
    {
        return $this->error_msg;
    }
}

?>