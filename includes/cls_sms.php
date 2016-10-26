<?php

/**
 * ECSHOP ����ģ�� ֮ ģ�ͣ���⣩
 * ============================================================================
 * ��Ȩ���� 2005-2010 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: douqinghua $
 * $Id: cls_sms.php 17155 2010-05-06 06:29:05Z douqinghua $
 */

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}
define('SOURCE_TOKEN', '814d4852d74f5914b41695ee7fa8508c');
define('SOURCE_ID', '863180');
require_once(ROOT_PATH . 'includes/cls_transport.php');
require_once(ROOT_PATH . 'includes/shopex_json.php');

/* ����ģ������ */
class sms
{
    /**
     * ����ṩԶ�̷����URL��
     *
     * @access  private
     * @var     array       $api_urls
     */
    var $api_urls   = array(
                            'info'              =>      'http://api.sms.shopex.cn',
                            'send'              =>      'http://api.sms.shopex.cn',
                            'servertime'        =>      'http://webapi.sms.shopex.cn'
    
    );
    /**
     * ���MYSQL����
     *
     * @access  private
     * @var     object      $db
     */
    var $db         = null;

    /**
     * ���ECS����
     *
     * @access  private
     * @var     object      $ecs
     */
    var $ecs        = null;

    /**
     * ���transport����
     *
     * @access  private
     * @var     object      $t
     */
    var $t          = null;

    /**
     * ��ų���ִ�й����еĴ�����Ϣ����������һ���ô��ǣ��������֧�ֶ����ԡ�
     * ������ִ����صĲ���ʱ��error_noֵ�����ı䣬���ܱ���Ϊ�ջ���0������.
     * Ϊ�ջ�0��ʾ�����ɹ�������0�����ֱ�ʾ����ʧ�ܣ������ִ������š�
     *
     * @access  public
     * @var     array       $errors
     */
    var $errors  = array('api_errors'       => array('error_no' => -1, 'error_msg' => ''),
                         'server_errors'    => array('error_no' => -1, 'error_msg' => ''));

    /**
     * ���캯��
     *
     * @access  public
     * @return  void
     */
    function __construct()
    {
        $this->sms();
    }

    /**
     * ���캯��
     *
     * @access  public
     * @return  void
     */
    function sms()
    {
        /* ����Ҫ����init.php����������������һ���Ǵ��ڵģ����ֱ�Ӹ�ֵ */
        $this->db = $GLOBALS['db'];
        $this->ecs = $GLOBALS['ecs'];

        /* �˴���ò�Ҫ��$GLOBALS���������ã���ֹ���� */
        $this->t = new transport(-1, -1, -1, false);
        $this->json    = new Services_JSON;
    }
   
     /* ���Ͷ���Ϣ
     *
     * @access  public
     * @param   string  $phone          Ҫ���͵���Щ���ֻ����룬����ֵ��һ������
     * @param   string  $msg            ���͵���Ϣ����
     */
    function send($phones,$msg,$send_date = '', $send_num = 1,$sms_type='',$version='1.0')
    {
       
        /* ��鷢����Ϣ�ĺϷ��� */
        $contents=$this->get_contents($phones, $msg);  
        if(!$contents)
        {
            $this->errors['server_errors']['error_no'] = 3;//���͵���Ϣ����
            return false;
        }
        
        $login_info = $this->getSmsInfo();
        if (!$login_info)
        {
            $this->errors['server_errors']['error_no'] = 5;//��Ч�������Ϣ

            return false;
        }
        else
        {
            if($login_info['info']['account_info']['active']!='1')
            {
                $this->errors['server_errors']['error_no'] = 11;//���Ź���û�м���
                return false;
            }
            
        }
         /* ��ȡAPI URL */
        $sms_url = $this->get_url('send');

        if (!$sms_url)
        {
            $this->errors['server_errors']['error_no'] = 6;//URL����

            return false;
        }
        
        $send_str['contents']= $this->json->encode($contents);
        $send_str['certi_app']='sms.send';
        $send_str['entId']=$GLOBALS['_CFG']['ent_id'];
        $send_str['entPwd']=$GLOBALS['_CFG']['ent_ac'];
        $send_str['license']=$GLOBALS['_CFG']['certificate_id'];
        $send_str['source']=SOURCE_ID;   
        $send_str['sendType'] = 'notice';
        $send_str['use_backlist'] = '1';
        $send_str['version'] = $version;
        $send_str['format']='json'; 
        $send_str['timestamp'] = $this->getTime(); 
        $send_str['certi_ac']=$this->make_shopex_ac($send_str,SOURCE_TOKEN);
        $sms_url= $this->get_url('send');
        /* ����HTTP���� */
        $response = $this->t->request($sms_url, $send_str,'POST');
        $result = $this->json->decode($response['body'], true);
        
        if($result['res'] == 'succ')
        {
            return true;
        }
        elseif($result['res'] == 'fail')
        {
            return false;
        }
       
    }
   

    

    /**
     * ������ö��ŷ�����Ҫ����Ϣ
     *
     * @access  private
     * @param   string      $email          ����
     * @param   string      $password       ����
     * @return  boolean                     ���������Ϣ��ʽ�Ϸ��ͷ���true�����򷵻�false��
     */
    function check_enable_info($email, $password)
    {
        if (empty($email) || empty($password))
        {
            return false;
        }

        return true;
    }

    //��ѯ�Ƿ�����ͨ��֤
    function has_registered()
    {
        $sql = 'SELECT `value`
                FROM ' . $this->ecs->table('shop_config') . "
                WHERE `code` = 'ent_id'";

        $result = $this->db->getOne($sql);

        if (empty($result))
        {
            return false;
        }

        return true;
    }
    function get_site_info()
    {
        /* ��õ�ǰ���ڻỰ״̬�Ĺ���Ա������ */
        $email = $this->get_admin_email();
        $email = $email ? $email : '';
        /* ��õ�ǰ��������� */
        $domain = $this->ecs->get_domain();
        $domain = $domain ? $domain : '';
        /* ����smartyģ�� */
        $sms_site_info['email'] = $email;
        $sms_site_info['domain'] = $domain;

        return $sms_site_info;
    }
    function get_site_url()
    {
        $url = $this->ecs->url();
        $url = $url ? $url : '';
        return $url;
    }
    /**
     * ��õ�ǰ���ڻỰ״̬�Ĺ���Ա������
     *
     * @access  private
     * @return  string or boolean       �ɹ����ع���Ա�����䣬���򷵻�false��
     */
    function get_admin_email()
    {
        $sql = 'SELECT `email` FROM ' . $this->ecs->table('admin_user') . " WHERE `user_id` = '" . $_SESSION['admin_id'] . "'";
         $email = $this->db->getOne($sql);

         if (empty($email))
         {
            return false;
         }

         return $email;
    }
    //�û������˻���Ϣ��ȡ
    function getSmsInfo($certi_app='sms.info',$version='1.0', $format='json'){
        $send_str['certi_app'] = $certi_app;
        $send_str['entId'] = $GLOBALS['_CFG']['ent_id'];
        $send_str['entPwd'] = $GLOBALS['_CFG']['ent_ac'];
        $send_str['source'] = SOURCE_ID;
        $send_str['version'] = $version;
        $send_str['format'] = $format;
        $send_str['timestamp'] = $this->getTime();
        $send_str['certi_ac'] = $this->make_shopex_ac($send_str,SOURCE_TOKEN);
        $sms_url = $this->get_url('info');
        $response = $this->t->request($sms_url, $send_str,'POST');
        $result = $this->json->decode($response['body'],true);
        if($result['res'] == 'succ')
        {
            return $result;
        }
        elseif($result['res'] == 'fail')
        {
            return false;
        }
    }
    
    //����ֻ��źͷ��͵����ݲ��������ɶ��Ŷ���
     function get_contents($phones,$msg)
     {
        if (empty($phones) || empty($msg))
        {
            return false;
        }
        $phone_key=0;

        $phones=explode(',',$phones);
        foreach($phones as $key => $value)
        {
             if($i<200)
             {
                $i++;
             }
             else
             {
               $i=0;
               $phone_key++;
             }
             if($this->is_moblie($value))
             {
                $phone[$phone_key][]=$value;
             }
             else
             {
                 $i--;
             }
         }
         if(!empty($phone))
         {
             foreach($phone as $phone_key => $val)
             {
                   if (EC_CHARSET != 'utf-8')
                    {
                        $phone_array[$phone_key]['phones']=implode(',',$val);
                        $phone_array[$phone_key]['content']=iconv('gb2312','utf-8',$msg);
                    }
                  else
                   {
                        $phone_array[$phone_key]['phones']=implode(',',$val);
                        $phone_array[$phone_key]['content']=$msg;
                   }
                  
             }
             return $phone_array;
         }
         else
         {
            return false; 
         }
         
     }
    
    //��÷�����ʱ��
    function getTime(){
        $Tsend_str['certi_app'] = 'sms.servertime';
        $Tsend_str['version'] = '1.0' ;
        $Tsend_str['format'] = 'json' ;
        $Tsend_str['certi_ac'] = $this->make_shopex_ac($Tsend_str,'SMS_TIME');
        $sms_url = $this->get_url('servertime');
        $response = $this->t->request($sms_url, $Tsend_str,'POST');
        
        $result = $this->json->decode($response['body'], true);
        return $result['info'];
        
    }
     /**
     * ����ָ��������URL
     *
     * @access  public
     * @param   string      $key        URL�����֣�������ļ���
     * @return  string or boolean       ������β�ָ���ļ�����Ӧ��URLֵ���ھͷ��ظ�URL�����򷵻�false��
     */
    function get_url($key)
    {
        $url = $this->api_urls[$key];

        if (empty($url))
        {
            return false;
        }

        return $url;
    }
    /**
     * ����ֻ������Ƿ���ȷ
     *
     */
    function is_moblie($moblie)
    {
       return  preg_match("/^0?1((3|8)[0-9]|5[0-35-9]|4[57])\d{8}$/", $moblie);
    }
   
    //�����㷨
    function make_shopex_ac($temp_arr,$token)
    {
       ksort($temp_arr);
       $str = '';
       foreach($temp_arr as $key=>$value)
       {
            if($key!=' certi_ac') 
            {
               $str.= $value;
            }
        }
       return strtolower(md5($str.strtolower(md5($token))));
     }
    function base_encode($str)
    {
        $str = base64_encode($str);
        return strtr($str, $this->pattern());
    }
    function pattern()
    {
        return array(
        '+'=>'_1_',
        '/'=>'_2_',
        '='=>'_3_',
        );
    }
    
}

?>