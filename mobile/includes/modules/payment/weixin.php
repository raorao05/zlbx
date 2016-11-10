<?php

/**
 * ECSHOP ΢��֧����� V3.3�汾
 * ============================================================================
 * * ��Ȩ���� 2005-2014 ���빤���� ��Ȩ����
 * ��վ��ַ: http://www.maisui.net.cn��
 */

if (!defined('IN_ECS')) {
	die('Hacking attempt');
}

$payment_lang = ROOT_PATH . 'languages/' .$GLOBALS['_CFG']['lang']. '/payment/wxpay.php';

if (file_exists($payment_lang))
{
	global $_LANG;

	include_once($payment_lang);
}

/* ģ��Ļ�����Ϣ */
if (isset($set_modules) && $set_modules == TRUE)
{
	$i = isset($modules) ? count($modules) : 0;

	/* ���� */
	$modules[$i]['code']    = basename(__FILE__, '.php');

	/* ������Ӧ�������� */
	$modules[$i]['desc']    = 'wxpay_desc';

	/* �Ƿ�֧�ֻ������� */
	$modules[$i]['is_cod']  = '0';

	/* �Ƿ�֧������֧�� */
	$modules[$i]['is_online']  = '1';

	/* ���� */
	$modules[$i]['author']  = '���빤����';

	/* ��ַ */
	$modules[$i]['website'] = 'http://mp.weixin.qq.com/';

	/* �汾�� */
	$modules[$i]['version'] = '3.3';

	/* ������Ϣ */
	$modules[$i]['config']  = array(
		array('name' => 'wxpay_appid',           'type' => 'text',   'value' => 'wxca93dccf7f945c0c'),
		array('name' => 'wxpay_appsecret',       'type' => 'text',   'value' => '2a1d71868657ae6139cd58a1dc384208'),
		array('name' => 'wxpay_mchid',      'type' => 'text',   'value' => 'wd9'),
		array('name' => 'wxpay_key',      'type' => 'text', 'value' => 'a79e4484bb8577618a7c5f11036249f1'),
		array('name' => 'wxpay_signtype',      'type' => 'text', 'value' => 'sha1')
	);

	return;
}

/**
 * ��
 */

class weixin
{

	/**
	 * ���캯��
	 *
	 * @access  public
	 * @param
	 *
	 * @return void
	 */
	var $parameters; //cft ����
	var $payments; //������Ϣ
	function wxpay()
	{
	}

	function __construct()
	{
		$this->wxpay();
	}

	/**
	 * ����֧������
	 * @param   array   $order      ������Ϣ
	 * @param   array   $payment    ֧����ʽ��Ϣ
	 */
	function get_code($order, $payment)
	{
		if (!defined('EC_CHARSET'))
		{
			$charset = 'utf-8';
		}
		else
		{
			$charset = EC_CHARSET;
		}
		$charset = strtoupper($charset);

		//���ò���
		$this->payments = $payment;
		//��Ŀ¼url
		$root_url = str_replace('mobile/', '', $GLOBALS['ecs']->url());
		//����openid
		$orderuserid = $GLOBALS['db']->getOne("SELECT user_id FROM".$GLOBALS['ecs']->table('order_info')."WHERE order_id='$order[order_id]'");
		$openid = $GLOBALS['db']->getOne("SELECT wx_open_id FROM".$GLOBALS['ecs']->table('users')."WHERE user_id='$orderuserid'");
		$this->setParameter("openid",$openid);
		//��Ʒ����
		$this->setParameter("body", $order['order_sn']);

		//�̻�������
        //$this->setParameter("out_trade_no", $order['order_sn'] .'O'. $order['log_id']);
        $this->setParameter("out_trade_no", $order['log_id'].'-'.$order['order_amount']*100);
		//�����ܽ��
		$this->setParameter("total_fee", $order['order_amount'] * 100);
		//֧������
		//$this->setParameter("fee_type", "1");
		//֪ͨURL
		$this->setParameter("notify_url", $root_url.'respond.php');
		//�������ɵĻ���IP
		$this->setParameter("spbill_create_ip", real_ip());
		//��������ַ�����
		//$this->setParameter("input_charset", $charset);
        $this->setParameter("input_charset", 'UTF-8');
		//��������
		$this->setParameter("trade_type","JSAPI");

		$prepay_id = $this->getPrepayId();

		$this->setPrepayId($prepay_id);
		//����jsapi֧������json

		$jsapi = $this->getParameters();
		//echo $jsapi;exit;
		//wxjsbridge
		$js = '<script language="javascript">
			function callpay(){
			    WeixinJSBridge.invoke("getBrandWCPayRequest",'.$jsapi.',function(res){
			        if(res.err_msg == "get_brand_wcpay_request:ok"){
			            location.href="respond.php?code=weixin&status=1"
			        }else if(res.err_msg == "get_brand_wcpay_request:cancel"){
			            location.href="respond.php?code=weixin&status=2"
			        } else if (res.err_msg == "get_brand_wcpay_request:fail") {
						location.href="respond.php?code=weixin&status=3"
					} else {
						location.href="respond.php?code=weixin&status=4&errmsg=" + encodeURIComponent(res.err_msg);
					}
			     });
			}
			</script>';

		$button = '<div style="text-align:center"><button class="c-btn4" type="button" onclick="callpay()">���֧��</button></div>'.$js;

		return $button;


	}

	/**
	 * ��Ӧ����
	 */
	function respond()
	{
        include_once ("weixin/WxPayPubHelper.php");
        // ʹ��ͨ��֪ͨ�ӿ�
        $notify = new Notify_pub ();
        // �洢΢�ŵĻص�
        $xml = $GLOBALS ['HTTP_RAW_POST_DATA'];
        $notify->saveData ( $xml );
        $payment = get_payment ( 'weixin' );
        define ( KEY, $payment ['partnerKey'] ); // ͨ���ܴ�
        if ($notify->checkSign () == TRUE) {
            if ($notify->data ["return_code"] == "FAIL") {
                $this->addLog ( $notify, 401 );
            } elseif ($notify->data ["result_code"] == "FAIL") {
                $this->addLog ( $notify, 402 );
            } else {
                $this->addLog ( $notify, 200 );
                $out_trade_no = $notify->data['out_trade_no'];
                $order_sns = explode('-',$out_trade_no);
                $order_sn = $order_sns[0];
                if (! check_money ( $order_sn, $notify->data ['total_fee']/100 )) {
                    $this->addLog ( $notify, 404 );
                    return true;
                }

                order_paid ($order_sn, 2);
                echo 'success';exit;
            }
        }else{
            $this->addLog ( $notify, 403 );
        }
        return true;
	}

	// �����������
	function setParameter($parameter, $parameterValue) {
		$this->parameters[$this->trimString($parameter)] = $this->trimString($parameterValue);
	}

	// ���ò���ʱ��Ҫ�õ����ַ�������
	function trimString($value){
		$ret = null;
		if (null != $value) {
			$ret = $value;
			if (strlen($ret) == 0) {
				$ret = null;
			}
		}
		return $ret;
	}

	//���������
	function create_noncestr( $length = 32 ) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$str ="";
		for ( $i = 0; $i < $length; $i++ )  {
			$str.= substr($chars, mt_rand(0, strlen($chars)-1), 1);
		}
		return $str;
	}


	// ��ȡprepay_id
	function getPrepayId()
	{
		$this->postXml();
		$this->result = $this->xmlToArray($this->response);
        //$t = $this->result['return_msg'];
        //$d = iconv('utf-8','gb2312//IGNORE',$t);
        //var_dump($d);
		//print_r($this->result);
		$prepay_id = $this->result["prepay_id"];
		return $prepay_id;
	}


	//	post����xml
	function postXml()
	{
		$xml = $this->createXml();
		$this->response = $this->postXmlCurl($xml,'https://api.mch.weixin.qq.com/pay/unifiedorder','30');
		//var_dump($this->response);
		return $this->response;
	}


	// ���ñ�����������������ǩ�������ɽӿڲ���xml
	function createXml()
	{
		$this->parameters["appid"] = $this->payments['appId'];//�����˺�ID
		$this->parameters["mch_id"] = $this->payments['partnerId'];//�̻���
		$this->parameters["nonce_str"] = $this->create_noncestr();//����ַ���
		$this->parameters["sign"] = $this->getSign($this->parameters);//ǩ��
        //print_r($this->parameters);
		return  $this->arrayToXml($this->parameters);
	}

	function xmlToArray($xml)
	{
		//��XMLתΪarray
		$array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
		return $array_data;
	}

	function arrayToXml($arr)
	{
		$xml = "<xml>";
		foreach ($arr as $key=>$val)
		{
			if (is_numeric($val))
			{
				$xml.="<".$key.">".$val."</".$key.">";

			}
			else
				$xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
		}
		$xml.="</xml>";
		return $xml;
	}

	function postXmlCurl($xml,$url,$second=30)
	{
		//��ʼ��curl
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
		//����header
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		//Ҫ����Ϊ�ַ������������Ļ��
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		//post�ύ��ʽ
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		//����curl
		$data = curl_exec($ch);
		curl_close($ch);
		//var_dump($data);
		if($data)
		{
			//curl_close($ch);
			return $data;
		}
		else
		{
			$error = curl_errno($ch);
			echo "curl����������:$error"."<br>";
			echo "<a href='http://curl.haxx.se/libcurl/c/libcurl-errors.html'>����ԭ���ѯ</a></br>";
			curl_close($ch);
			return false;
		}
	}

	//	���ã�����ǩ��
	public function getSign($Obj)
	{
		foreach ($Obj as $k => $v)
		{
			$Parameters[$k] = $v;
		}
		//ǩ������һ�����ֵ����������
		ksort($Parameters);
		$String = $this->formatBizQueryParaMap($Parameters, false);
		//echo '��string1��'.$String.'</br>';
		//ǩ�����������string�����KEY
        //var_dump($this->payments['partnerKey']);
		$String = $String."&key=".$this->payments['partnerKey'];
		//echo "��string2��".$String."</br>";
		//ǩ����������MD5����
		$String = md5($String);
		//echo "��string3�� ".$String."</br>";
		//ǩ�������ģ������ַ�תΪ��д
		$result_ = strtoupper($String);
		//echo "��result�� ".$result_."</br>";
		return $result_;
	}

	/**
	 * 	��ʽ��������ǩ��������Ҫʹ��
	 */
	function formatBizQueryParaMap($paraMap, $urlencode)
	{
		$buff = "";
		ksort($paraMap);
		foreach ($paraMap as $k => $v)
		{
			if($urlencode)
			{
				$v = urlencode($v);
			}
			//$buff .= strtolower($k) . "=" . $v . "&";
			$buff .= $k . "=" . $v . "&";
		}
		$reqPar = '';
		if (strlen($buff) > 0)
		{
			$reqPar = substr($buff, 0, strlen($buff)-1);
		}
		return $reqPar;
	}

	function setPrepayId($prepayId)
	{
		$this->prepay_id = $prepayId;
	}
	/**
	 * 	����jsapi�Ĳ���
	 */
	function getParameters()
	{
		$jsApiObj["appId"] = $this->payments['appId'];
		$timeStamp = time();
		$jsApiObj["timeStamp"] = "$timeStamp";
		$jsApiObj["nonceStr"] = $this->create_noncestr();
		$jsApiObj["package"] = "prepay_id=$this->prepay_id";
		//$jsApiObj["signType"] = $this->payments['wxpay_signtype'];
		$jsApiObj["signType"] = 'MD5';
		$jsApiObj["paySign"] = $this->getSign($jsApiObj);
		$this->parameters = json_encode($jsApiObj);
		return $this->parameters;
	}


}

?>