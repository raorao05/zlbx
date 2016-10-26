<?php
define('IN_ECS', true);
require('../includes/init.php');
require('../includes/lib_order.php');
include_once('../includes/lib_payment.php');
error_reporting(E_ALL ^ E_NOTICE);
$out_trade_no = intval($_GET['out_trade_no']);

//����֧��id��ȡ����id
$order_id = $GLOBALS['db']->getOne("SELECT order_id FROM ".$GLOBALS['ecs']->table('pay_log')." WHERE log_id = '$out_trade_no'");

//��ȡ������Ϣ
$order = $GLOBALS['db']->getRow("SELECT * FROM " . $GLOBALS['ecs']->table('order_info') . " WHERE order_id = '$order_id' limit 1");

if($order)
{
	if ($order['order_amount'] > 0){
		//��ֹ�̻��������ظ�
		$order['order_id'] = $out_trade_no.'-'.$order['order_amount']*100;
		$payment = payment_info($order['pay_id']);
		include_once('includes/modules/payment/' . $payment['pay_code'] . '.php');
		$pay_obj    = new $payment['pay_code'];
		$code = $pay_obj->get_code($order, unserialize_config($payment['pay_config']));
	}
	else
	{
		show_message('�˶�����֧����');
	}
}
else
{
	echo 1;exit;
}
?>
<html>
<head>
	<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
	<title>΢�Ű�ȫ֧��</title>
	<script type="text/javascript">
		function jsApiCall()
		{
			WeixinJSBridge.invoke(
				'getBrandWCPayRequest',
				<?php echo $code;?>,
				function(res){
					//alert(res.err_msg);
					if(res.err_msg == "get_brand_wcpay_request:ok" ) {
						window.location.href = "./user.php";
					} else {
						alert("����ȡ��");
						window.location.href = "./index.php";
					}
				}
			);
		}
		//function callpay()
		window.onload = function ()

		{
			if (typeof WeixinJSBridge == "undefined"){
				if( document.addEventListener ){
					document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
				}else if (document.attachEvent){
					document.attachEvent('WeixinJSBridgeReady', jsApiCall);
					document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
				}
			}else{
				jsApiCall();
			}
		}
	</script>
</head>
<body>
<!--	</br></br></br></br>
	<div align="center">
		<button style="width:400px; height:100px; background-color:#FE6714; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:28px;" type="button" onclick="callpay()" >΢��֧��</button>
	</div>
	-->
</body>
</html>