<?php

/**
 * ECSHOP ģ����
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: cls_template.php 17217 2011-01-19 06:29:08Z liubo $
 */

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

class template
{
    /**
    * �����洢�����Ŀռ�
    *
    * @access  private
    * @var     array      $vars
    */
    var $vars = array();

   /**
    * ģ���ŵ�Ŀ¼·��
    *
    * @access  private
    * @var     string      $path
    */
    var $path = '';

    /**
     * ���캯��
     *
     * @access  public
     * @param   string       $path
     * @return  void
     */
    function __construct($path)
    {
        $this->template($path);
    }

    /**
     * ���캯��
     *
     * @access  public
     * @param   string       $path
     * @return  void
     */
    function template($path)
    {
        $this->path = $path;
    }

    /**
     * ģ��smarty��assign����
     *
     * @access  public
     * @param   string       $name    ����������
     * @param   mix           $value   ������ֵ
     * @return  void
     */
    function assign($name, $value)
    {
        $this->vars[$name] = $value;
    }

    /**
     * ģ��smarty��fetch����
     *
     * @access  public
     * @param   string       $file   �ļ����·��
     * @return  string      ģ�������(�ı���ʽ)
     */
    function fetch($file)
    {
        extract($this->vars);
        ob_start();
        include($this->path . $file);
        $contents = ob_get_contents();
        ob_end_clean();

        return $contents;
    }

    /**
     * ģ��smarty��display����
     *
     * @access  public
     * @param   string       $file   �ļ����·��
     * @return  void
     */
    function display($file)
    {
        echo $this->fetch($file);
    }
}

?>