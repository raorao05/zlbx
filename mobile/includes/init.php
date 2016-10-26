<?php

/**
 * ECSHOP mobileǰ̨��������
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liuhui $
 * $Id: init.php 15013 2008-10-23 09:31:42Z liuhui $
*/

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

error_reporting(E_ALL ^ E_NOTICE);

if (__FILE__ == '')
{
    die('Fatal error code: 0');
}

/* ȡ�õ�ǰecshop���ڵĸ�Ŀ¼ */
define('ROOT_PATH', str_replace('mobile/includes/init.php', '', str_replace('\\', '/', __FILE__)));

/* ��ʼ������ */
@ini_set('memory_limit',          '64M');
@ini_set('session.cache_expire',  180);
@ini_set('session.use_cookies',   1);
@ini_set('session.auto_start',    0);
@ini_set('display_errors',        1);
@ini_set("arg_separator.output","&amp;");

if (DIRECTORY_SEPARATOR == '\\')
{
    @ini_set('include_path',      '.;' . ROOT_PATH);
}
else
{
    @ini_set('include_path',      '.:' . ROOT_PATH);
}

if (file_exists(ROOT_PATH . 'data/config.php'))
{
    include(ROOT_PATH . 'data/config.php');
}
else
{
    include(ROOT_PATH . 'includes/config.php');
}

if (defined('DEBUG_MODE') == false)
{
    define('DEBUG_MODE', 7);
}

if (PHP_VERSION >= '5.1' && !empty($timezone))
{
    date_default_timezone_set($timezone);
}

$php_self = isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
if ('/' == substr($php_self, -1))
{
    $php_self .= 'index.php';
}
define('PHP_SELF', $php_self);

require(ROOT_PATH . 'includes/cls_ecshop.php');
require(ROOT_PATH . 'includes/lib_goods.php');
require(ROOT_PATH . 'includes/lib_base.php');
require(ROOT_PATH . 'includes/lib_common.php');
require(ROOT_PATH . 'includes/lib_time.php');
require(ROOT_PATH . 'includes/lib_main.php');
require(ROOT_PATH . 'includes/lib_insert.php');
require(ROOT_PATH . 'mobile/includes/lib_main.php');
require(ROOT_PATH . 'includes/inc_constant.php');
require(ROOT_PATH . 'includes/cls_error.php');
require(ROOT_PATH . 'includes/lib_article.php');

/* ���û�����ı�������ת�������*/
if (!get_magic_quotes_gpc())
{
    if (!empty($_GET))
    {
        $_GET  = addslashes_deep($_GET);
    }
    if (!empty($_POST))
    {
        $_POST = addslashes_deep($_POST);
    }

    $_COOKIE   = addslashes_deep($_COOKIE);
    $_REQUEST  = addslashes_deep($_REQUEST);
}

/* ���� ECSHOP ���� */
$ecs = new ECS($db_name, $prefix);
define('DATA_DIR', $ecs->data_dir());
define('IMAGE_DIR', $ecs->image_dir());

/* ��ʼ�����ݿ��� */
require(ROOT_PATH . 'includes/cls_mysql.php');
$db = new cls_mysql($db_host, $db_user, $db_pass, $db_name);
$db_host = $db_user = $db_pass = $db_name = NULL;

/* ������������� */
$err = new ecs_error('message.html');


/* ����ϵͳ���� */
$_CFG = load_config();

/* ���������ļ� */
require(ROOT_PATH . 'languages/' . $_CFG['lang'] . '/common.php');

/* ��ʼ��session */
require(ROOT_PATH . 'includes/cls_session.php');
$sess = new cls_session($db, $ecs->table('sessions'), $ecs->table('sessions_data'), 'ecsid');
define('SESS_ID', $sess->get_session_id());

if (!defined('INIT_NO_SMARTY'))
{
    header('Cache-control: private');
    header('Content-type: text/html; charset=utf-8');

    /* ���� Smarty ����*/
    require(ROOT_PATH . 'includes/cls_template.php');
    $smarty = new cls_template;

    $smarty->cache_lifetime = $_CFG['cache_time'];
    $smarty->template_dir   = ROOT_PATH . 'mobile/templates';
    $smarty->cache_dir      = ROOT_PATH . 'temp/caches';
    $smarty->compile_dir    = ROOT_PATH . 'temp/compiled/mobile';

    if ((DEBUG_MODE & 2) == 2)
    {
        $smarty->direct_output = true;
        $smarty->force_compile = true;
    }
    else
    {
        $smarty->direct_output = false;
        $smarty->force_compile = false;
    }
}

if (!defined('INIT_NO_USERS'))
{
    /* ��Ա��Ϣ */
    $user =& init_users();
    if (empty($_SESSION['user_id']))
    {
        if ($user->get_cookie())
        {
            /* �����Ա�Ѿ���¼���һ�û�л�û�Ա���ʻ��������Լ��Ż�ȯ */
            if ($_SESSION['user_id'] > 0 && !isset($_SESSION['user_money']))
            {
                update_user_info();
            }
        }
        else
        {
            $_SESSION['user_id']     = 0;
            $_SESSION['user_name']   = '';
            $_SESSION['email']       = '';
            $_SESSION['user_rank']   = 0;
            $_SESSION['discount']    = 1.00;
        }
    }
}

if ((DEBUG_MODE & 1) == 1)
{
    error_reporting(E_ALL ^ E_NOTICE);
}
else
{
    error_reporting(E_ALL ^ E_NOTICE);
}
if ((DEBUG_MODE & 4) == 4)
{
    include(ROOT_PATH . 'includes/lib.debug.php');
}

/* �ж��Ƿ�֧��gzipģʽ */
if (gzip_enabled())
{
    ob_start('ob_gzhandler');
}

/* wapͷ�ļ� */
//if (substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], '/')) != '/user.php')
//{}
header("Content-Type:text/html; charset=gb2312");

if (empty($_CFG['wap_config']))
{
    echo "<meta http-equiv='Content-Type' content='text/html; charset=gb2312' /><title>ECShop_mobile</title></head><body><p align='left'>�Բ���,{$_CFG['shop_name']}��ʱû�п����ֻ����﹦��</p></body></html>";
    exit();
}
if(strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger'))
{
    /**
     * ��ȡ��ǰҳ������URL��ַ
     */
    function get_url() {
        $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
        $php_self = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
        $path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
        $relate_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $php_self.(isset($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : $path_info);
        return $sys_protocal.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '').$relate_url;
    }

    function httpGet($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        $res = curl_exec($curl);
        curl_close($curl);
        return $res;
    }


//΢��appid
    $appid = 'wx2c0db652b5b5b41c';
    $secret ='717ecbe36a79e26523f211e3f4c00e7b';
    $openid=$_COOKIE['sopenid'];
    if(!$openid){
        $code=isset($_GET['code'])?$_GET['code']:null;
        $url = get_url();
        if($code==null){
            $str="https://open.weixin.qq.com/connect/oauth2/authorize?appid={$appid}&redirect_uri=".$url."&scope=snsapi_userinfo&state=123&response_type=code#wechat_redirect";
            header ("Location:".$str);
        }else{
            $str="https://api.weixin.qq.com/sns/oauth2/access_token?appid={$appid}&secret={$secret}&code=".$code."&grant_type=authorization_code";
            /*$ch = curl_init() ;
            curl_setopt($ch, CURLOPT_URL, $str);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //��curl_exec()��ȡ����Ϣ���ļ�������ʽ���أ�������ֱ�������
            $output = curl_exec($ch);*/
            $output=httpGet($str);
            $output=json_decode($output,true);
            //print_r($output);
            setcookie("sopenid",$output['openid'],time()+864000,"/");
            $openid=$output['openid'];
            $access_token=$output['access_token'];
            $str="https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$openid}&lang=zh_CN ";
            $output=httpGet($str);
            $output=json_decode($output,true);
            //print_r($output);
        }
    }
    if($openid){
        $sql = "SELECT * FROM".$ecs->table('users')." where wx_open_id = '".$openid."'";
        $row = $db->getRow($sql);
        if($row){
                $_SESSION['user_id']=$row['user_id'];
                recalculate_price();

        }
    }
}
?>