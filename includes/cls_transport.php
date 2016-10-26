<?php

/**
 * ECSHOP ������֮�����ݴ��������ɼ�������Ϣ����HTTPͷ��HTTP�壬
 * ����һά�������ʽ���أ��磺array('header' => 'bar', 'body' => 'foo')��
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: cls_transport.php 17217 2011-01-19 06:29:08Z liubo $
 */

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

class transport
{
    /**
     * �ű�ִ��ʱ�䡣��1��ʾ����PHP��Ĭ��ֵ��
     *
     * @access  private
     * @var     integer     $time_limit
     */
    var $time_limit                  = -1;

    /**
     * �ڶ�����֮�ڣ�������Ӳ����ã��ű���ֹͣ���ӡ���1��ʾ����PHP��Ĭ��ֵ��
     *
     * @access  private
     * @var     integer     $connect_timeout
     */
    var $connect_timeout             = -1;

    /**
     * ���Ӻ��޶������볬ʱ����1��ʾ����PHP��Ĭ��ֵ�������������CURL��ʱ���á�
     *
     * @access  private
     * @var     integer    $stream_timeout
     */
    var $stream_timeout              = -1;

    /**
     * �Ƿ�ʹ��CURL�������ӡ�false��ʾ����fsockopen�������ӡ�
     *
     * @access  private
     * @var     boolean     $use_curl
     */
    var $use_curl                    = false;

    /**
     * ���캯��
     *
     * @access  public
     * @param   integer     $time_limit
     * @param   integer     $connect_timeout
     * @param   integer     $stream_timeout
     * @param   boolean     $use_curl
     * @return  void
     */
    function __construct($time_limit = -1, $connect_timeout = -1, $stream_timeout = -1, $use_curl = false)
    {
        $this->transport($time_limit, $connect_timeout, $stream_timeout, $use_curl);
    }

    /**
     * ���캯��
     *
     * @access  public
     * @param   integer     $time_limit
     * @param   integer     $connect_timeout
     * @param   integer     $stream_timeout
     * @param   boolean     $use_curl
     * @return  void
     */
    function transport($time_limit = -1, $connect_timeout = -1, $stream_timeout = -1, $use_curl = false)
    {
        $this->time_limit = $time_limit;
        $this->connect_timeout = $connect_timeout;
        $this->stream_timeout = $stream_timeout;
        $this->use_curl = $use_curl;
    }

    /**
     * ����Զ�̷�����
     *
     * @access  public
     * @param   string      $url            Զ�̷�������URL
     * @param   mix         $params         ��ѯ����������bar=foo&foo=bar��������һά�������飬����array('a'=>'aa',...)
     * @param   string      $method         ����ʽ����POST����GET
     * @param   array       $my_header      �û�Ҫ���͵�ͷ����Ϣ��Ϊһά�������飬����array('a'=>'aa',...)
     * @return  array                       �ɹ�����һά�������飬����array('header'=>'bar', 'body'=>'foo')��
     *                                      �ش�������ֱ��ֹͣ���У����򷵻�false��
     */
    function request($url, $params = '', $method = 'POST', $my_header = '')
    {
        $fsock_exists = function_exists('fsockopen');
        $curl_exists = function_exists('curl_init');

        if (!$fsock_exists && !$curl_exists)
        {
            die('No method available!');
        }

        if (!$url)
        {
            die('Invalid url!');
        }

        if ($this->time_limit > -1)//���Ϊ0��������ִ��ʱ��
        {
            set_time_limit($this->time_limit);
        }

        $method = $method === 'GET' ? $method : 'POST';
        $response = '';
        $temp_str = '';

        /* ��ʽ����Ҫ��Ҫ�͵Ĳ��� */
        if ($params && is_array($params))
        {
            foreach ($params AS $key => $value)
            {
                $temp_str .= '&' . $key . '=' . $value;
            }
            $params = preg_replace('/^&/', '', $temp_str);
        }

        /* ���fsockopen���ڣ����û���ָ��ʹ��curl�������use_socket���� */
        if ($fsock_exists && !$this->use_curl)
        {
            $response = $this->use_socket($url, $params, $method, $my_header);
        }
        /* ֻҪ���������е���һ�������������̾�ת�������ʱ���curlģ����ã��͵���use_curl���� */
        elseif ($curl_exists)
        {
            $response = $this->use_curl($url, $params, $method, $my_header);
        }

        /* ����Ӧ���ߴ�������з������󣬳��򽫷���false */
        if (!$response)
        {
            return false;
        }

        return $response;
    }

    /**
     * ʹ��fsockopen��������
     *
     * @access  private
     * @param   string      $url            Զ�̷�������URL
     * @param   string      $params         ��ѯ����������bar=foo&foo=bar
     * @param   string      $method         ����ʽ����POST����GET
     * @param   array       $my_header      �û�Ҫ���͵�ͷ����Ϣ��Ϊһά�������飬����array('a'=>'aa',...)
     * @return  array                       �ɹ�����һά�������飬����array('header'=>'bar', 'body'=>'foo')��
     *                                      ���򷵻�false��
     */
    function use_socket($url, $params, $method, $my_header)
    {
        $query = '';
        $auth = '';
        $content_type = '';
        $content_length = '';
        $request_body = '';
        $request = '';
        $http_response = '';
        $temp_str = '';
        $error = '';
        $errstr = '';
        $crlf = $this->generate_crlf();

        if ($method === 'GET')
        {
            $query = $params ? "?$params" : '';
        }
        else
        {
            $request_body  = $params;
            $content_type = 'Content-Type: application/x-www-form-urlencoded' . $crlf;
            $content_length = 'Content-Length: ' . strlen($request_body) . $crlf . $crlf;
        }

        $url_parts = $this->parse_raw_url($url);
        $path = $url_parts['path'] . $query;

        if (!empty($url_parts['user']))
        {
            $auth = 'Authorization: Basic '
                    . base64_encode($url_parts['user'] . ':' . $url_parts['pass']) . $crlf;
        }

        /* ��ʽ���Զ���ͷ����Ϣ */
        if ($my_header && is_array($my_header))
        {
            foreach ($my_header AS $key => $value)
            {
                $temp_str .= $key . ': ' . $value . $crlf;
            }
            $my_header = $temp_str;
        }

        /* ����HTTP����ͷ�� */
        $request = "$method $path HTTP/1.0$crlf"
                . 'Host: ' . $url_parts['host'] . $crlf
                . $auth
                . $my_header
                . $content_type
                . $content_length
                . $request_body;

        if ($this->connect_timeout > -1)
        {
            $fp = @fsockopen($url_parts['host'], $url_parts['port'], $error, $errstr, $this->connect_timeout);
        }
        else
        {
            $fp = @fsockopen($url_parts['host'], $url_parts['port'], $error, $errstr);
        }

        if (!$fp)
        {
            return false;//��ʧ��
        }

        if (!@fwrite($fp, $request))
        {
            return false;//д��ʧ��
        }

        while (!feof($fp))
        {
            $http_response .= fgets($fp);
        }

        if (!$http_response)
        {
            return false;//����Ӧ
        }

        $separator = '/\r\n\r\n|\n\n|\r\r/';
        list($http_header, $http_body) = preg_split($separator, $http_response, 2);

        $http_response = array('header' => $http_header,//header�϶���ֵ
                               'body'   => $http_body);//body����Ϊ��
        @fclose($fp);

        return $http_response;
    }

    /**
     * ʹ��curl��������
     *
     * @access  private
     * @param   string      $url            Զ�̷�������URL
     * @param   string      $params         ��ѯ����������bar=foo&foo=bar
     * @param   string      $method         ����ʽ����POST����GET
     * @param   array       $my_header      �û�Ҫ���͵�ͷ����Ϣ��Ϊһά�������飬����array('a'=>'aa',...)
     * @return  array                       �ɹ�����һά�������飬����array('header'=>'bar', 'body'=>'foo')��
     *                                      ʧ�ܷ���false��
     */
    function use_curl($url, $params, $method, $my_header)
    {
        /* ��ʼһ���»Ự */
        $curl_session = curl_init();

        /* �������� */
        curl_setopt($curl_session, CURLOPT_FORBID_REUSE, true); // ������󣬹ر����ӣ��ͷ���Դ
        curl_setopt($curl_session, CURLOPT_HEADER, true);//����а���ͷ����Ϣ
        curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, true);//�ѽ�����أ�����ֱ�����
        curl_setopt($curl_session, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);//����1.0���HTTPЭ��

        $url_parts = $this->parse_raw_url($url);

        /* ������֤���� */
        if (!empty($url_parts['user']))
        {
            $auth = $url_parts['user'] . ':' . $url_parts['pass'];
            curl_setopt($curl_session, CURLOPT_USERPWD, $auth);
            curl_setopt($curl_session, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        }

        $header = array();

        /* �������� */
        $header[] = 'Host: ' . $url_parts['host'];

        /* ��ʽ���Զ���ͷ����Ϣ */
        if ($my_header && is_array($my_header))
        {
            foreach ($my_header AS $key => $value)
            {
                $header[] = $key . ': ' . $value;
            }
        }

        if ($method === 'GET')
        {
            curl_setopt($curl_session, CURLOPT_HTTPGET, true);
            $url .= $params ? '?' . $params : '';
        }
        else
        {
            curl_setopt($curl_session, CURLOPT_POST, true);
            $header[] = 'Content-Type: application/x-www-form-urlencoded';
            $header[] = 'Content-Length: ' . strlen($params);
            curl_setopt($curl_session, CURLOPT_POSTFIELDS, $params);
        }

        /* ���������ַ */
        curl_setopt($curl_session, CURLOPT_URL, $url);

        /* ����ͷ����Ϣ */
        curl_setopt($curl_session, CURLOPT_HTTPHEADER, $header);

        if ($this->connect_timeout > -1)
        {
            curl_setopt($curl_session, CURLOPT_CONNECTTIMEOUT, $this->connect_timeout);
        }

        if ($this->stream_timeout > -1)
        {
            curl_setopt($curl_session, CURLOPT_TIMEOUT, $this->stream_timeout);
        }

        /* �������� */
        $http_response = curl_exec($curl_session);

        if (curl_errno($curl_session) != 0)
        {
            return false;
        }

        $separator = '/\r\n\r\n|\n\n|\r\r/';
        list($http_header, $http_body) = preg_split($separator, $http_response, 2);

        $http_response = array('header' => $http_header,//�϶���ֵ
                               'body'   => $http_body); //����Ϊ��

        curl_close($curl_session);

        return $http_response;
    }

    /**
     * Similar to PHP's builtin parse_url() function, but makes sure what the schema,
     * path and port keys are set to http, /, 80 respectively if they're missing
     *
     * @access     private
     * @param      string    $raw_url    Raw URL to be split into an array
     * @author     http://www.cpaint.net/
     * @return     array
     */
    function parse_raw_url($raw_url)
    {
        $retval   = array();
        $raw_url  = (string) $raw_url;

        // make sure parse_url() recognizes the URL correctly.
        if (strpos($raw_url, '://') === false)
        {
          $raw_url = 'http://' . $raw_url;
        }

        // split request into array
        $retval = parse_url($raw_url);

        // make sure a path key exists
        if (!isset($retval['path']))
        {
          $retval['path'] = '/';
        }

        // set port to 80 if none exists
        if (!isset($retval['port']))
        {
          $retval['port'] = '80';
        }

        return $retval;
    }

    /**
     * ����һ�����з�����ͬ�Ĳ���ϵͳ���в�ͬ�Ļ��з�
     *
     * @access     private
     * @return     string       ��˫�������õĻ��з�
     */
    function generate_crlf()
    {
        $crlf = '';

        if (strtoupper(substr(PHP_OS, 0, 3) === 'WIN'))
        {
            $crlf = "\r\n";
        }
        elseif (strtoupper(substr(PHP_OS, 0, 3) === 'MAC'))
        {
            $crlf = "\r";
        }
        else
        {
            $crlf = "\n";
        }

        return $crlf;
    }
}

?>