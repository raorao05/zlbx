<?php

/**
 * ECSHOP ��֤��ͼƬ��
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: cls_captcha.php 17217 2011-01-19 06:29:08Z liubo $
*/

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

class captcha
{
    /**
     * ����ͼƬ����Ŀ¼
     *
     * @var string  $folder
     */
    var $folder     = 'data/captcha';

    /**
     * ͼƬ���ļ�����
     *
     * @var string  $img_type
     */
    var $img_type   = 'png';

    /*------------------------------------------------------ */
    //-- ����session�е�����
    /*------------------------------------------------------ */
    var $session_word = 'captcha_word';

    /**
     * ����ͼƬ�Լ�������ɫ
     *
     * 0 => ����ͼƬ���ļ���
     * 1 => Red, 2 => Green, 3 => Blue
     * @var array   $themes
     */
    var $themes_jpg = array(
        1 => array('captcha_bg1.jpg', 255, 255, 255),
        2 => array('captcha_bg2.jpg', 0, 0, 0),
        3 => array('captcha_bg3.jpg', 0, 0, 0),
        4 => array('captcha_bg4.jpg', 255, 255, 255),
        5 => array('captcha_bg5.jpg', 255, 255, 255),
    );

    var $themes_gif = array(
        1 => array('captcha_bg1.gif', 255, 255, 255),
        2 => array('captcha_bg2.gif', 0, 0, 0),
        3 => array('captcha_bg3.gif', 0, 0, 0),
        4 => array('captcha_bg4.gif', 255, 255, 255),
        5 => array('captcha_bg5.gif', 255, 255, 255),
    );

    /**
     * ͼƬ�Ŀ��
     *
     * @var integer $width
     */
    var $width      = 130;

    /**
     * ͼƬ�ĸ߶�
     *
     * @var integer $height
     */
    var $height     = 20;

    /**
     * ���캯��
     *
     * @access  public
     * @param   string  $folder     ����ͼƬ����Ŀ¼
     * @param   integer $width      ͼƬ���
     * @param   integer $height     ͼƬ�߶�
     * @return  bool
     */
    function captcha($folder = '', $width = 145, $height = 20)
    {
        if (!empty($folder))
        {
            $this->folder = $folder;
        }

        $this->width    = $width;
        $this->height   = $height;

        /* ����Ƿ�֧�� GD */
        if (PHP_VERSION >= '4.3')
        {

            return (function_exists('imagecreatetruecolor') || function_exists('imagecreate'));
        }
        else
        {

            return (((imagetypes() & IMG_GIF) > 0) || ((imagetypes() & IMG_JPG)) > 0 );
        }
    }

    /**
     * ���캯��
     *
     * @access  public
     * @param
     *
     * @return void
     */
    function __construct($folder = '', $width = 145, $height = 20)
    {
        $this->captcha($folder, $width, $height);
    }


    /**
     * ����������֤���Ƿ��session�е�һ��
     *
     * @access  public
     * @param   string  $word   ��֤��
     * @return  bool
     */
    function check_word($word)
    {
        $recorded = isset($_SESSION[$this->session_word]) ? base64_decode($_SESSION[$this->session_word]) : '';
        $given    = $this->encrypts_word(strtoupper($word));

        $check = preg_match("/$given/", $recorded);
        if($check){
            $_SESSION[$this->session_word] = 'unset';
        }
        return $check;
        //return (preg_match("/$given/", $recorded));
    }

    /**
     * ����ͼƬ������������
     *
     * @access  public
     * @param   string  $word   ��֤��
     * @return  mix
     */
    function generate_image($word = false)
    {
        if (!$word)
        {
            $word = $this->generate_word();
        }

        /* ��¼��֤�뵽session */
        $this->record_word($word);

        /* ��֤�볤�� */
        $letters = strlen($word);

        /* ѡ��һ������ķ��� */
        mt_srand((double) microtime() * 1000000);

        if (function_exists('imagecreatefromjpeg') && ((imagetypes() & IMG_JPG) > 0))
        {
            $theme  = $this->themes_jpg[mt_rand(1, count($this->themes_jpg))];
        }
        else
        {
            $theme  = $this->themes_gif[mt_rand(1, count($this->themes_gif))];
        }

        if (!file_exists($this->folder . $theme[0]))
        {
            return false;
        }
        else
        {
            $img_bg    = (function_exists('imagecreatefromjpeg') && ((imagetypes() & IMG_JPG) > 0)) ?
                            imagecreatefromjpeg($this->folder . $theme[0]) : imagecreatefromgif($this->folder . $theme[0]);
            $bg_width  = imagesx($img_bg);
            $bg_height = imagesy($img_bg);

            $img_org   = ((function_exists('imagecreatetruecolor')) && PHP_VERSION >= '4.3') ?
                          imagecreatetruecolor($this->width, $this->height) : imagecreate($this->width, $this->height);

            /* ������ͼ����ԭʼͼ�󲢵�����С */
            if (function_exists('imagecopyresampled') && PHP_VERSION >= '4.3') // GD 2.x
            {
                imagecopyresampled($img_org, $img_bg, 0, 0, 0, 0, $this->width, $this->height, $bg_width, $bg_height);
            }
            else // GD 1.x
            {
                imagecopyresized($img_org, $img_bg, 0, 0, 0, 0, $this->width, $this->height, $bg_width, $bg_height);
            }
            imagedestroy($img_bg);

            $clr = imagecolorallocate($img_org, $theme[1], $theme[2], $theme[3]);

            /* ���Ʊ߿� */
            //imagerectangle($img_org, 0, 0, $this->width - 1, $this->height - 1, $clr);

            /* �����֤��ĸ߶ȺͿ�� */
            $x = ($this->width - (imagefontwidth(5) * $letters)) / 2;
            $y = ($this->height - imagefontheight(5)) / 2;
            imagestring($img_org, 5, $x, $y, $word, $clr);

            header('Expires: Thu, 01 Jan 1970 00:00:00 GMT');

            // HTTP/1.1
            header('Cache-Control: private, no-store, no-cache, must-revalidate');
            header('Cache-Control: post-check=0, pre-check=0, max-age=0', false);

            // HTTP/1.0
            header('Pragma: no-cache');
            if ($this->img_type == 'jpeg' && function_exists('imagecreatefromjpeg'))
            {
                header('Content-type: image/jpeg');
                imageinterlace($img_org, 1);
                imagejpeg($img_org, false, 95);
            }
            else
            {
                header('Content-type: image/png');
                imagepng($img_org);
            }

            imagedestroy($img_org);

            return true;
        }
    }

    /*------------------------------------------------------ */
    //-- PRIVATE METHODs
    /*------------------------------------------------------ */

    /**
     * ����Ҫ��¼�Ĵ����м���
     *
     * @access  private
     * @param   string  $word   ԭʼ�ַ���
     * @return  string
     */
    function encrypts_word($word)
    {
        return substr(md5($word), 1, 10);
    }

    /**
     * ����֤�뱣�浽session
     *
     * @access  private
     * @param   string  $word   ԭʼ�ַ���
     * @return  void
     */
    function record_word($word)
    {
        $_SESSION[$this->session_word] = base64_encode($this->encrypts_word($word));
    }

    /**
     * �����������֤��
     *
     * @access  private
     * @param   integer $length     ��֤�볤��
     * @return  string
     */
    function generate_word($length = 4)
    {
        $chars = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ';

        for ($i = 0, $count = strlen($chars); $i < $count; $i++)
        {
            $arr[$i] = $chars[$i];
        }

        mt_srand((double) microtime() * 1000000);
        shuffle($arr);

        return substr(implode('', $arr), 5, $length);
    }
}

?>