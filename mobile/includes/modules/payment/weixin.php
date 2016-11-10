<?php

/**
 * ECSHOP 微信支付插件 V3.3版本
 * ============================================================================
 * * 版权所有 2005-2014 麦穗工作室 版权所有
 * 网站地址: http://www.maisui.net.cn；
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

/* 模块的基本信息 */
if (isset($set_modules) && $set_modules == TRUE)
{
	$i = isset($modules) ? count($modules) : 0;

	/* 代码 */
	$modules[$i]['code']    = basename(__FILE__, '.php');

	/* 描述对应的语言项 */
	$modules[$i]['desc']    = 'wxpay_desc';

	/* 是否支持货到付款 */
	$modules[$i]['is_cod']  = '0';

	/* 是否支持在线支付 */
	$modules[$i]['is_online']  = '1';

	/* 作者 */
	$modules[$i]['author']  = '麦穗工作室';

	/* 网址 */
	$modules[$i]['website'] = 'http://mp.weixin.qq.com/';

	/* 版本号 */
	$modules[$i]['version'] = '3.3';

	/* 配置信息 */
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
 * 类
 */

class weixin
{

	/**
	 * 构造函数
	 *
	 * @access  public
	 * @param
	 *
	 * @return void
	 */
	var $parameters; //cft 参数
	var $payments; //配置信息
	function wxpay()
	{
	}

	function __construct()
	{
		$this->wxpay();
	}

	/**
	 * 生成支付代码
	 * @param   array   $order      订单信息
	 * @param   array   $payment    支付方式信息
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

		//配置参数
		$this->payments = $payment;
		//根目录url
		$root_url = str_replace('mobile/', '', $GLOBALS['ecs']->url());
		//查找openid
		$orderuserid = $GLOBALS['db']->getOne("SELECT user_id FROM".$GLOBALS['ecs']->table('order_info')."WHERE order_id='$order[order_id]'");
		$openid = $GLOBALS['db']->getOne("SELECT wx_open_id FROM".$GLOBALS['ecs']->table('users')."WHERE user_id='$orderuserid'");
		$this->setParameter("openid",$openid);
		//商品描述
		$this->setParameter("body", $order['order_sn']);

		//商户订单号
        //$this->setParameter("out_trade_no", $order['order_sn'] .'O'. $order['log_id']);
        $this->setParameter("out_trade_no", $order['log_id'].'-'.$order['order_amount']*100);
		//订单总金额
		$this->setParameter("total_fee", $order['order_amount'] * 100);
		//支付币种
		//$this->setParameter("fee_type", "1");
		//通知URL
		$this->setParameter("notify_url", $root_url.'respond.php');
		//订单生成的机器IP
		$this->setParameter("spbill_create_ip", real_ip());
		//传入参数字符编码
		//$this->setParameter("input_charset", $charset);
        $this->setParameter("input_charset", 'UTF-8');
		//交易类型
		$this->setParameter("trade_type","JSAPI");

		$prepay_id = $this->getPrepayId();

		$this->setPrepayId($prepay_id);
		//生成jsapi支付请求json

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

		$button = '<div style="text-align:center"><button class="c-btn4" type="button" onclick="callpay()">点击支付</button></div>'.$js;

		return $button;


	}

	/**
	 * 响应操作
	 */
	function respond()
	{
        include_once ("weixin/WxPayPubHelper.php");
        // 使用通用通知接口
        $notify = new Notify_pub ();
        // 存储微信的回调
        $xml = $GLOBALS ['HTTP_RAW_POST_DATA'];
        $notify->saveData ( $xml );
        $payment = get_payment ( 'weixin' );
        define ( KEY, $payment ['partnerKey'] ); // 通加密串
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

	// 设置请求参数
	function setParameter($parameter, $parameterValue) {
		$this->parameters[$this->trimString($parameter)] = $this->trimString($parameterValue);
	}

	// 设置参数时需要用到的字符处理函数
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

	//生成随机数
	function create_noncestr( $length = 32 ) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$str ="";
		for ( $i = 0; $i < $length; $i++ )  {
			$str.= substr($chars, mt_rand(0, strlen($chars)-1), 1);
		}
		return $str;
	}


	// 获取prepay_id
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


	//	post请求xml
	function postXml()
	{
		$xml = $this->createXml();
		$this->response = $this->postXmlCurl($xml,'https://api.mch.weixin.qq.com/pay/unifiedorder','30');
		//var_dump($this->response);
		return $this->response;
	}


	// 设置标配的请求参数，生成签名，生成接口参数xml
	function createXml()
	{
		$this->parameters["appid"] = $this->payments['appId'];//公众账号ID
		$this->parameters["mch_id"] = $this->payments['partnerId'];//商户号
		$this->parameters["nonce_str"] = $this->create_noncestr();//随机字符串
		$this->parameters["sign"] = $this->getSign($this->parameters);//签名
        //print_r($this->parameters);
		return  $this->arrayToXml($this->parameters);
	}

	function xmlToArray($xml)
	{
		//将XML转为array
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
		//初始化curl
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
		//设置header
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		//要求结果为字符串且输出到屏幕上
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		//post提交方式
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		//运行curl
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
			echo "curl出错，错误码:$error"."<br>";
			echo "<a href='http://curl.haxx.se/libcurl/c/libcurl-errors.html'>错误原因查询</a></br>";
			curl_close($ch);
			return false;
		}
	}

	//	作用：生成签名
	public function getSign($Obj)
	{
		foreach ($Obj as $k => $v)
		{
			$Parameters[$k] = $v;
		}
		//签名步骤一：按字典序排序参数
		ksort($Parameters);
		$String = $this->formatBizQueryParaMap($Parameters, false);
		//echo '【string1】'.$String.'</br>';
		//签名步骤二：在string后加入KEY
        //var_dump($this->payments['partnerKey']);
		$String = $String."&key=".$this->payments['partnerKey'];
		//echo "【string2】".$String."</br>";
		//签名步骤三：MD5加密
		$String = md5($String);
		//echo "【string3】 ".$String."</br>";
		//签名步骤四：所有字符转为大写
		$result_ = strtoupper($String);
		//echo "【result】 ".$result_."</br>";
		return $result_;
	}

	/**
	 * 	格式化参数，签名过程需要使用
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
	 * 	设置jsapi的参数
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