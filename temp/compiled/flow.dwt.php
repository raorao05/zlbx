<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="Generator" content="LECAOLEJIA since 2013" />
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />

<title><?php echo $this->_var['page_title']; ?></title>
<link href="/css/w_css.css" type="text/css" rel="stylesheet" />
<script src="/js/jquery.min.js.js"></script>
<script src="/js/w_index.js"></script>
<script type="text/javascript" src="/js/tab.js"></script>	


<?php echo $this->smarty_insert_scripts(array('files'=>'transport.org.js,common.js,shopping_flow.js')); ?>
</head>
<body>
<?php echo $this->fetch('library/page_header.lbi'); ?>
  <?php if ($this->_var['step'] == "cart"): ?>
  
  
  <?php echo $this->smarty_insert_scripts(array('files'=>'showdiv.js')); ?>
  <script type="text/javascript">
  <?php $_from = $this->_var['lang']['password_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
    var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  var checkflag = "false";
  function check_1(fieldName) {
		var field=document.getElementsByName(fieldName);
		if (checkflag == "false") {
		for (i = 0; i < field.length; i++) {
		field[i].checked = true;}
		checkflag = "true";
		return "Uncheck All"; }
		else {
		for (i = 0; i < field.length; i++) {
		field[i].checked = false; }
		checkflag = "false";
		return "Check All"; }
	}
  </script>
  <div class="w_center"> 
  <div class="w_gwcb_z">�ҵĹ��ﳵ</div>
  <div class="w_gwc_bd">
    <div class="w_gwc_1">
	 <span class="w_gwc_1_s1">��Ʒ����</span>
	 <span class="w_gwc_1_s2">����</span>
	 <span class="w_gwc_1_s3">��������</span>
	 <span class="w_gwc_1_s4">��Ͷ����</span>
	 <span class="w_gwc_1_s6">����</span>                                                                                                                       
	</div>
	<form id="formCart" name="formCart" method="post" action="flow.php">
    <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
    <div class="w_gwc_2">
	 <span class="w_gwc_2_s1">
	   <input type="checkbox" name="order_goods_id[]" value="<?php echo $this->_var['goods']['rec_id']; ?>" />
	   <a href="goods.php?id=<?php echo $this->_var['goods']['goods_id']; ?>" title="<?php echo $this->_var['goods']['goods_name']; ?>">
	   <img src="/<?php echo $this->_var['goods']['goods_thumb']; ?>" title="<?php echo $this->_var['goods']['goods_name']; ?>" alt="<?php echo $this->_var['goods']['goods_name']; ?>"/>
	   <p><?php echo $this->_var['goods']['goods_name']; ?></p><?php echo $this->_var['goods']['brand_name']; ?>
	   </a>
	 </span>
	 <span class="w_gwc_2_s2"><i><?php echo $this->_var['goods']['goods_price']; ?></i></span>
	 <span class="w_gwc_2_s3"><?php if ($this->_var['goods']['goods_attr']): ?><?php echo $this->_var['goods']['goods_attr']; ?><?php else: ?>��<?php endif; ?></span>
	 <span class="w_gwc_2_s4">δ��д</span>
	 <span class="w_gwc_2_s6">
	  <a href="flow.php?step=add_insure&rec_id=<?php echo $this->_var['goods']['rec_id']; ?>" title="��дͶ����Ϣ" class="w_gwc_2_s61">��дͶ����Ϣ</a><br/>
	  <a href="javascript:if (confirm('<?php echo $this->_var['lang']['drop_goods_confirm']; ?>')) location.href='flow.php?step=drop_goods&amp;id=<?php echo $this->_var['goods']['rec_id']; ?>'; " title="ɾ��" class="w_gwc_2_s62">ɾ��</a>
	  <a href="javascript:collect(<?php echo $this->_var['goods']['goods_id']; ?>);" title="�ղ�" class="w_gwc_2_s63">�ղ�</a>
	 </span>
	</div>
	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    <input type="hidden" name="step" value="drop_goods_list" />
    </form>
	<div class="w_gwc_3">
	  <span class="w_gwc_3_s1">
	   <input type="checkbox" onClick="this.value=check_1('order_goods_id[]')" /><label>ȫѡ</label>
	   <a href="javascript:document.getElementById('formCart').submit();" title="ɾ��ѡ�е���Ʒ"><i class="gwc_sc1"></i>ɾ��ѡ�е���Ʒ</a>
	   <a href="index.php" title="�������"><i class="gwc_sc2"></i>�������</a>
	  </span>
	  <span class="w_gwc_3_s2"><i><?php echo $this->_var['total']['real_goods_count']; ?></i>����Ʒ&nbsp;&nbsp;�ܹ�<em>��<?php echo $this->_var['total']['goods_amount']; ?></em>Ԫ</span>
	</div>
  </div>
 </div>
  
       <?php if ($_SESSION['user_id'] > 0): ?>
       <?php echo $this->smarty_insert_scripts(array('files'=>'transport.org.js')); ?>
       <script type="text/javascript" charset="utf-8">
        function collect_to_flow(goodsId)
        {
          var goods        = new Object();
          var spec_arr     = new Array();
          var fittings_arr = new Array();
          var number       = 1;
          goods.spec     = spec_arr;
          goods.goods_id = goodsId;
          goods.number   = number;
          goods.parent   = 0;
          Ajax.call('flow.php?step=add_to_cart', 'goods=' + $.toJSON(goods), collect_to_flow_response, 'POST', 'JSON');
        }
        function collect_to_flow_response(result)
        {
          if (result.error > 0)
          {
            // �����Ҫȱ���Ǽǣ���ת
            if (result.error == 2)
            {
              if (confirm(result.message))
              {
                location.href = 'user.php?act=add_booking&id=' + result.goods_id;
              }
            }
            else if (result.error == 6)
            {
              openSpeDiv(result.message, result.goods_id);
            }
            else
            {
              alert(result.message);
            }
          }
          else
          {
            location.href = 'flow.php';
          }
        }
      </script>
  <?php endif; ?>
  <?php endif; ?>
<?php if ($this->_var['step'] == "add_insure"): ?>
<script src="/js/MyDate/WdatePicker.js"></script>
<script>
function g(element){return document.getElementById(element);}
function check(zhi,id){
	if(!zhi){
		document.getElementById(id).style.display = "";
	}else{
		document.getElementById(id).style.display = "none";
	}
}
function tijiao(){
	if(!g('insure_time').value){
		alert('����д������ʼ����')
	}else if(!g('tb_name').value){
		alert('����дͶ��������')
	}else if(!g('tbzj_number').value){
		alert('����д֤������')
	}else if(!g('address').value){
		alert('����д��ס��ַ')
	}else if(!g('tb_mobile').value){
		alert('����д�ֻ�')
	}else if(!g('tb_name').value){
		alert('����дͶ��������')
	}else{
		g("add_insure").submit();
	}
}
function contacts_dy(id){
	Ajax.call('flow.php?step=contacts_dy', 'id='+id, get_back, 'POST', 'JSON');
}
function get_back(msg){
	if(msg.error == 1){
		alert(msg.message);
	}else{
		g('tb_name').value=msg.name;
		g('tbzj_number').value=msg.zj_number;
		g('address').value=msg.address;
		g('tb_mobile').value=msg.mobile;
		g('email').value=msg.email;
	}
}
</script>
<div class="w_center">
    <div class="w_cxjbx_n">
	 <div class="w_cxjbx_n1">
	  <img src="/images/w_qrt_h1.jpg" title="��дͶ����Ϣ" alt="��дͶ����Ϣ"/>
     </div>
   <div class="w_txbd_1">
    <h2><?php echo $this->_var['cart_info']['goods_name']; ?></h2>
	<p><i></i>Ϊ�˱�������Ȩ�棬����д��ʵ��Ч����Ϣ������д�����ݽ���Ͷ��ʹ�ã�����������Ϣ���ǻ��ϸ��ܡ���<span>*</span>Ϊ�����</p>
   </div>
   <form action="flow.php" method="post" id="add_insure" onsubmit="return tijiao();">
   <div class="w_txbd_2">
    <h2>Ͷ���ƻ�</h2>
    <ul>
	  <li><span class="w_txbd_2s"><i>*</i>Ϊ˭Ͷ��</span><div class="w_txbd_2d"><input type="checkbox" name="ws_insure" value="��Ů" <?php if ($this->_var['arr'] [ 'ws_insure' ] == '��Ů'): ?>checked="checked"<?php endif; ?> /><label>��Ů</label></div></li>
	  <li><span class="w_txbd_2s"><i>*</i>���ռƻ�</span><div class="w_txbd_2d"><?php echo $this->_var['cart_info']['goods_attr']; ?></div></li>
	  <li><span class="w_txbd_2s"><i>*</i>������ʼ����</span>
	  <div class="w_txbd_2d"><input type="text" placeholder="��ѡ����ʼ����" id="insure_time" name="insure_time" validate=" required:true" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" class="w_tx_in1" onblur="check(this.value,'insure_time_xs')" value="<?php echo $this->_var['arr']['insure_time']; ?>" />00ʱ</div>
	  <div class="w_txbd_d1" style="display:none;" id="insure_time_xs"><i></i>����д������ʼ����</div>
	  </li>
	</ul>
   </div>
   <div class="w_txbd_2">
    <h2>Ͷ������Ϣ����д�ҵ���Ϣ��</h2>
    <ul>
	  <li><span class="w_txbd_2s">������ϵ��</span><div class="w_txbd_2d">
      <?php $_from = $this->_var['contacts']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'r');if (count($_from)):
    foreach ($_from AS $this->_var['r']):
?>
      <?php echo $this->_var['r']['name']; ?><input type="radio" name="contacts" value="<?php echo $this->_var['r']['contacts_id']; ?>" onclick="contacts_dy('<?php echo $this->_var['r']['contacts_id']; ?>');" />
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      </div></li>
      <li><span class="w_txbd_2s"><i>*</i>����</span><div class="w_txbd_2d"><input type="text" onblur="check(this.value,'tb_name_xs')" value="<?php echo $this->_var['arr']['tb_name']; ?>" id="tb_name" name="tb_name" class="w_tx_in1"/></div>
      <div class="w_txbd_d1" style="display:none;" id="tb_name_xs"><i></i>����дͶ��������</div>
      </li>
	  <li><span class="w_txbd_2s"><i>*</i>֤������</span><div class="w_txbd_2d">
	     <select>
		   <option>���֤</option>
		 </select>
	  <input type="text" name="tbzj_number" id="tbzj_number" onblur="check(this.value,'tbzj_number_xs')" value="<?php echo $this->_var['arr']['tbzj_number']; ?>" class="w_tx_in1" /></div>
      <div class="w_txbd_d1" style="display:none;" id="tbzj_number_xs"><i></i>����д֤������</div>
      </li>
	  <li><span class="w_txbd_2s"><i>*</i>��ס��ַ</span>
	  <div class="w_txbd_2d"><input type="text" name="address" id="address" onblur="check(this.value,'address_xs')" value="<?php echo $this->_var['arr']['tbzj_number']; ?>" class="w_tx_in1"/></div>
      <div class="w_txbd_d1" style="display:none;" id="address_xs"><i></i>����д��ס��ַ</div>
	  </li>
	  <li><span class="w_txbd_2s"><i>*</i>�ֻ�</span><div class="w_txbd_2d"><input type="text" id="tb_mobile" name="tb_mobile" value="<?php echo $this->_var['arr']['tb_mobile']; ?>" onblur="check(this.value,'tb_mobile_xs')" class="w_tx_in1"/>
      <em>����д��ʵ��Ч���ֻ����룬�������ն�����Ϣ</em></div><div class="w_txbd_d1" style="display:none;" id="tb_mobile_xs"><i></i>����д�ֻ�</div></li>
	  <li><span class="w_txbd_2s"><i>*</i>����</span><div class="w_txbd_2d"><input type="text" name="email" value="<?php echo $this->_var['arr']['email']; ?>" id="email" onblur="check(this.value,'email_xs')" class="w_tx_in1"/>
      <em>����д��ʵ��Ч�����䣬�������ն�����Ϣ</em></div><div class="w_txbd_d1" style="display:none;" id="email_xs"><i></i>����д����</div></li>
	</ul>
   </div>
   <div class="w_txbd_2">
    <h2>����������Ϣ����Ҫ��TA���գ�</h2>
    <ul>
	  <li><span class="w_txbd_2s"><i>*</i>TA����</span><div class="w_txbd_2d"><input type="checkbox" name="relation" value="��Ů" <?php if ($this->_var['arr'] [ 'relation' ] == '��Ů'): ?>checked="checked"<?php endif; ?> /><label>��Ů</label></div></li>
	  <li><span class="w_txbd_2s"><i>*</i>����</span>
      <div class="w_txbd_2d"><input type="text" name="bb_name" value="<?php echo $this->_var['arr']['bb_name']; ?>" onblur="check(this.value,'bb_name_xs')" class="w_tx_in1"/></div>
      <div class="w_txbd_d1" style="display:none;" id="bb_name_xs"><i></i>����д������������</div>
      </li>
	  <li><span class="w_txbd_2s"><i>*</i>֤������</span><div class="w_txbd_2d">
	     <select>
		   <option>���֤</option>
		 </select>
	  <input type="text" name="bbzj_number" onblur="check(this.value,'bbzj_number_xs')" value="<?php echo $this->_var['arr']['bbzj_number']; ?>" class="w_tx_in1" /></div>
	  <div class="w_txbd_d1">������ʾ��֤������ֱ��Ӱ�����⣬����ϸȷ�ϡ�</div>
      <div class="w_txbd_d1" style="display:none;" id="bbzj_number_xs"><i></i>����д��������֤������</div>
	  </li>
	  <li><span class="w_txbd_2s"><i>*</i>�ֻ�</span><div class="w_txbd_2d">
      <input type="text" name="bb_mobile" value="<?php echo $this->_var['arr']['bb_mobile']; ?>" onblur="check(this.value,'bb_mobile_xs')" class="w_tx_in1"/>
      <em>����д��ʵ��Ч���ֻ����룬�������ն�����Ϣ</em></div><div class="w_txbd_d1" style="display:none;" id="bb_mobile_xs"><i></i>����д���������ֻ�</div>
      </li>
      <li><span class="w_txbd_2s"><i>*</i>������</span><div class="w_txbd_2d"><i></i><em>���������ա��л����񹲺͹��̳з����涨��������һ˳��̳���Ϊ��ż����Ů����ĸ���ڶ�˳��̳���Ϊ�ֵܽ��á��游ĸ�����游ĸ����</em></div></li>
	  <li><span class="w_txbd_2s">���ý�����ϵ��</span><div class="w_txbd_2d"><input type="text" name="jj_contacts" value="<?php echo $this->_var['arr']['jj_contacts']; ?>" class="w_tx_in1"/></div></li>
	</ul>
   </div>
   <div class="w_txbd_2">
    <h2>������Ϣ</h2>
    <ul>
     <li><span class="w_txbd_2s"> �Ƿ���Ҫ��Ʊ</span><div class="w_txbd_2d">
     <input type="radio" name="is_invoice" <?php if ($this->_var['arr'] [ 'is_invoice' ] == 1): ?>checked="checked"<?php endif; ?> value="1" /><label>��</label>
     <input type="radio" <?php if ($this->_var['arr'] [ 'is_invoice' ] == 0): ?>checked="checked"<?php endif; ?> name="is_invoice" value="0" /><label>��</label></div></li>
	</ul>
   </div>
   <input type="hidden" name="insure_plan" value="<?php echo $this->_var['cart_info']['goods_attr']; ?>" />
   <input type="hidden" name="rec_id" value="<?php echo $this->_var['rec_id']; ?>" />
   <input type="hidden" name="insure_id" value="<?php echo $this->_var['arr']['insure_id']; ?>" />
   <input type="hidden" name="step" value="<?php if ($this->_var['arr'] [ 'insure_id' ]): ?>up_insure_cl<?php else: ?>add_insure_cl<?php endif; ?>" />
   </form>
   <div class="w_txbd_3">
    <b>Ͷ������</b>
	<p>1��Ͷ��ʱ����Ͷ�����Ѿ͸ò�Ʒ�ı��������Լ����ս���򱻱����˽�������ȷ˵������������ͬ�⡣</p>
	<p>2����Ͷ������������������������д��ʵ����֪�����Ͷ����Ϣ����ʵ�����չ�˾����Ȩ���⣬һ�к���ɱ��˳е���</p>
	<p>3����Ͷ�������Ķ��ò�Ʒ��ϸ������ر���������й����������Ͷ���ˡ�����������������ݽ����Ķ�����Ͷ�����ش�ͬ���������ȫ�����ݡ�</p>
	<p>4������&laquo;�л����񹲺͹���ͬ��&raquo;��ʮһ���涨�����ݵ����ǺϷ��ĺ�ͬ������ʽ�����˽��ܱ��չ�˾����һվ�ṩ�ĵ��ӱ�����Ϊ��Ͷ���������Ч�ĺϷ�</p>
	<p>5����Чƾ֤��������ȫ֤��Ч����</p>
   </div>
   <div class="w_txbd_4">
     <a href="javascript:tijiao();" title="��һ��">��һ��</a>
   </div>
  </div>
 </div>

<?php endif; ?>

        <?php if ($this->_var['step'] == "consignee"): ?>
        
        <?php echo $this->smarty_insert_scripts(array('files'=>'region.js,utils.js')); ?>
        <script type="text/javascript">
          region.isAdmin = false;
          <?php $_from = $this->_var['lang']['flow_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
          var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

          
          onload = function() {
            if (!document.all)
            {
              document.forms['theForm'].reset();
            }
          }
          
        </script>
        
        <?php $_from = $this->_var['consignee_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('sn', 'consignee');if (count($_from)):
    foreach ($_from AS $this->_var['sn'] => $this->_var['consignee']):
?>
        <form action="flow.php" method="post" name="theForm" id="theForm" onsubmit="return checkConsignee(this)">
        <?php echo $this->fetch('library/consignee.lbi'); ?>
        </form>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        <?php endif; ?>

        <?php if ($this->_var['step'] == "checkout"): ?>
  <div class="w_center">
    <div class="w_cxjbx_n">
	 <div class="w_cxjbx_n1">
	  <img src="/images/w_qrt_h2.jpg" title="" alt=""/>
  </div>
  <div class="w_qrtb_1">
    <p>.����ȷ�Ϻ󲻿��޸ģ�����ϸ�˶�����Ͷ����Ϣ��ȷ��֮���Ͷ����Ϣ����Ϊ���չ�˾�˱������ݡ�</p>
	<p>.Ϊ��������Ȩ�棬����ϸ�Ķ�����ָ�ϡ��������¹ʷ������뼰ʱ��ϵ��һվ�ͷ����չ�˾�����ǽ��ڵ�һʱ�����Э�������⡣</p>
  </div>
  <h2 class="w_h2_mx">������ϸ</h2>
  <div class="w_qrtb_2">
	<div class="w_qrtb_2_s">
	 <span class="w_qrtb_2_s1">��Ʒ����</span>
	 <span class="w_qrtb_2_s2">����</span>
	 <span class="w_qrtb_2_s3">������ʼ��</span>
	 <span class="w_qrtb_2_s4">��������</span>
	 <span class="w_qrtb_2_s5">��Ʊ</span>
	 <span class="w_qrtb_2_s6">����</span>                                         	              	                     	
	</div>
	
    <div class="w_qrtb_2_ds">
	  <span class="w_qrtb_2_ds1">
	   <a href="goods.php?id=<?php echo $this->_var['goods']['goods_id']; ?>" title="<?php echo $this->_var['goods']['goods_name']; ?>">
	    <img src="/<?php echo $this->_var['img']; ?>" title="<?php echo $this->_var['goods']['goods_name']; ?>" alt="<?php echo $this->_var['goods']['goods_name']; ?>"/>
		<p><?php echo $this->_var['goods']['goods_name']; ?></p><?php echo $this->_var['brand_name']; ?>
	   </a>
	  </span>
	 <span class="w_qrtb_2_ds2"><?php echo $this->_var['goods']['formated_goods_price']; ?></span>
	 <span class="w_qrtb_2_ds2"><?php echo $this->_var['info']['insure_time']; ?></span>
	 <span class="w_qrtb_2_ds4"><?php echo $this->_var['info']['bb_name']; ?></span>
	 <span class="w_qrtb_2_ds5"><?php if ($this->_var['info'] [ 'is_invoice' ]): ?>��<?php else: ?>��<?php endif; ?></span>
	 <span class="w_qrtb_2_ds6"><a href="flow.php?step=examine_insure&id=<?php echo $this->_var['info']['insure_id']; ?>" title="�鿴Ͷ����Ϣ" class="w_qrtb_2_ds6a">�鿴Ͷ����Ϣ</a></span>  
	</div>
    
  </div>
  <form action="flow.php" method="post" name="theForm" id="theForm1">
  <h2 class="w_h2_mx">���ý���</h2>
  <div class="w_qrxx_1">���ѣ�<span><i><?php echo $this->_var['goods']['formated_goods_price']; ?></i></span></div>
  <div class="w_qrxx_1">
  <?php $_from = $this->_var['payment_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('k', 'payment');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['payment']):
?>
            
            <span><input type="radio" name="payment" value="<?php echo $this->_var['payment']['pay_id']; ?>" <?php if ($this->_var['k'] == 0): ?>checked<?php endif; ?> isCod="<?php echo $this->_var['payment']['is_cod']; ?>" onclick="selectPayment(this,<?php echo $this->_var['rec_id']; ?>)" <?php if ($this->_var['cod_disabled'] && $this->_var['payment']['is_cod'] == "1"): ?>disabled="true"<?php endif; ?>/>
             <strong><?php echo $this->_var['payment']['pay_name']; ?></strong>
              �����ѣ�<?php echo $this->_var['payment']['format_pay_fee']; ?></span>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  </div>
  <div class="w_qrxx_2">
  
   <p>ʵ���<?php echo $this->fetch('library/order_total.lbi'); ?></p>
   <p><input type="checkbox" name="is_check" value="1" /><label>���˽�����������ڵı�����������</label></p>
   <p><a href="javascript:document.getElementById('theForm1').submit();" title="ȷ�ϲ�֧��" class="w_qran">ȷ�ϲ�֧��</a></p>
  </div>
  <input type="hidden" name="rec_id" value="<?php echo $this->_var['rec_id']; ?>" />
  <input type="hidden" name="bx_type" value="1" />
  <input type="hidden" name="step" value="done" />
  </form>
  </div>
 </div>	 
        <script type="text/javascript">
        var flow_no_payment = "<?php echo $this->_var['lang']['flow_no_payment']; ?>";
        var flow_no_shipping = "<?php echo $this->_var['lang']['flow_no_shipping']; ?>";
        </script>
        <?php endif; ?>
        
        
        <?php if ($this->_var['step'] == "examine_insure"): ?>
        <div class="w_center">
    <div class="w_cktbx_1">
	  <a href="flow.php?step=checkout&rec_id=<?php echo $this->_var['goods']['rec_id']; ?>" title="���ؽ���"><i></i>���ؽ���</a>�鿴Ͷ����Ϣ
	</div>
	<div class="w_cktbx_2">
	  <h2>�ܼ�Ͷ��һ��</h2>
	  <h3><?php echo $this->_var['goods']['goods_name']; ?></h3>
	  <div class="w_cktbx_21">
	    <div class="w_cktbx_21_t"><a href="flow.php?step=add_insure&rec_id=<?php echo $this->_var['goods']['rec_id']; ?>" title="�����޸�"><i></i>�����޸�</a><b>������ϸ</b></div>
		<table cellpadding="0" cellspacing="0" class="w_cktab1">
		  <tr>
		    <td class="w_cktab1_td1">Ͷ������</td>
			<td class="w_cktab1_td2"><?php echo $this->_var['time']; ?></td>
			<td class="w_cktab1_td3" rowspan="5">
			 <p>
			   ��Ͷ��<i>1</i>��<br/>���Ѻϼƣ�<b>&yen;<?php echo $this->_var['goods']['goods_price']; ?></b>
			 </p>
			</td>
		  </tr>
		  <tr>
		    <td class="w_cktab1_td1">������ʼ��</td>
			<td class="w_cktab1_td2"><?php echo $this->_var['arr']['insure_time']; ?></td>
		  </tr>
		  <tr>
		    <td class="w_cktab1_td1">Ͷ���ƻ�</td>
			<td class="w_cktab1_td2"><?php echo $this->_var['arr']['insure_plan']; ?></td>
		  </tr>
		  <tr>
		    <td class="w_cktab1_td1">������ʽ</td>
			<td class="w_cktab1_td2">���ӱ���</td>
		  </tr>
		  <tr>
		    <td class="w_cktab1_td1">��Ʊ̧ͷ</td>
			<td class="w_cktab1_td2"><?php if ($this->_var['arr'] [ 'is_invoice' ]): ?>��<?php else: ?>��<?php endif; ?></td>
		  </tr>
		</table>
	  </div>
	  <div class="w_cktbx_21">
	    <div class="w_cktbx_21_t"><a href="flow.php?step=add_insure&rec_id=<?php echo $this->_var['goods']['rec_id']; ?>" title="�����޸�"><i></i>�����޸�</a><b>Ͷ������Ϣ</b></div>
		<table cellpadding="0" cellspacing="0" class="w_cktab2">
		  <tr>
		    <td class="w_cktab2_td1">����</td>
			<td class="w_cktab2_td2"><?php echo $this->_var['arr']['tb_name']; ?></td>
		  </tr>
		  <tr>
		    <td class="w_cktab2_td1">����</td>
			<td class="w_cktab2_td2"><?php echo $this->_var['arr']['email']; ?></td>
		  </tr>
		  <tr>
		    <td class="w_cktab2_td1">֤������</td>
			<td class="w_cktab2_td2">���֤</td>
		  </tr>
		  <tr>
		    <td class="w_cktab2_td1">֤������</td>
			<td class="w_cktab2_td2"><?php echo $this->_var['arr']['tbzj_number']; ?></td>
		  </tr>
		  <tr>
		    <td class="w_cktab2_td1">�ֻ�</td>
			<td class="w_cktab2_td2"><?php echo $this->_var['arr']['tb_mobile']; ?></td>
		  </tr>
		  <tr>
		    <td class="w_cktab2_td1">���ڳ���</td>
			<td class="w_cktab2_td2"><?php echo $this->_var['arr']['address']; ?></td>
		  </tr>
		</table>
	  </div>
	  <div class="w_cktbx_21">
	    <div class="w_cktbx_21_t"><a href="flow.php?step=add_insure&rec_id=<?php echo $this->_var['goods']['rec_id']; ?>" title="�����޸�"><i></i>�����޸�</a><b>��������Ϣ</b></div>
		<table cellpadding="0" cellspacing="0" class="w_cktab3">
		  <tr>
		    <td colspan="2" class="w_cktab3_td5">�����ˣ�<?php echo $this->_var['arr']['bb_name']; ?><i>���ѣ�<span>&yen;<?php echo $this->_var['goods']['goods_price']; ?></span></i></td>
		  </tr>
		  <tr>
		    <td class="w_cktab3_td3">��������</td>
			<td class="w_cktab3_td4">
			  <table cellpadding="0" cellspacing="0" class="w_cktab3_tab">
			    <tr class="w_cktab3_tab_tr1">
				  <td>TA����</td>
				  <td>����</td>
				  <td>��ϵ��ʽ</td>
				  <td>֤������</td>
				  <td>֤������</td>
				</tr>
				<tr>
				  <td><?php echo $this->_var['arr']['relation']; ?></td>
				  <td><?php echo $this->_var['arr']['bb_name']; ?></td>
				  <td><?php echo $this->_var['arr']['bb_mobile']; ?></td>
				  <td>���֤</td>
				  <td><?php echo $this->_var['arr']['bbzj_number']; ?></td>
				</tr>
			  </table>
			</td>
		  </tr>
		  <tr>
		    <td class="w_cktab3_td1">������</td>
			<td class="w_cktab3_td2">����</td>
		  </tr>
		</table>
	  </div>
	  <div class="w_cktbx_22">
	    <b>Ͷ������</b>
	    <p>1��Ͷ��ʱ����Ͷ�����Ѿ͸ò�Ʒ�ı��������Լ����ս���򱻱����˽�������ȷ˵������������ͬ�⡣</p>
		<p>2����Ͷ������������������������д��ʵ����֪�����Ͷ����Ϣ����ʵ�����չ�˾����Ȩ���⣬һ�к���ɱ��˳е���</p>
		<p>3����Ͷ�������Ķ��ò�Ʒ��ϸ������ر���������й����������Ͷ���ˡ�����������������ݽ����Ķ�����Ͷ�����ش�ͬ���������ȫ�����ݡ�</p>
		<p>4������&laquo;�л����񹲺͹���ͬ��&raquo;��ʮһ���涨�����ݵ����ǺϷ��ĺ�ͬ������ʽ�����˽��ܱ��չ�˾����һվ�ṩ�ĵ��ӱ�����Ϊ��Ͷ���������Ч�ĺϷ�</p>
		<p>5����Чƾ֤��������ȫ֤��Ч����</p>
	  </div>
	  <div class="w_cktbx_23">
	    <a href="flow.php?step=checkout&rec_id=<?php echo $this->_var['goods']['rec_id']; ?>" title="���ؽ���">���ؽ���</a>
	  </div>
	</div>
  </div>
        
        <?php endif; ?>

        <?php if ($this->_var['step'] == "done"): ?>
        <link href="<?php echo $this->_var['ecs_css_path']; ?>" rel="stylesheet" type="text/css" />
        
        <div class="flowBox" style="margin:30px auto 70px auto;">
         <h6 style="text-align:center; height:30px; line-height:30px;"><?php echo $this->_var['lang']['remember_order_number']; ?>: <font style="color:red"><?php echo $this->_var['order']['order_sn']; ?></font></h6>
          <table width="99%" align="center" border="0" cellpadding="15" cellspacing="0" bgcolor="#fff" style="border:1px solid #ddd; margin:20px auto;" >
            <tr>
              <td align="center" bgcolor="#FFFFFF">
              <?php echo $this->_var['lang']['select_payment']; ?>: <strong><?php echo $this->_var['order']['pay_name']; ?></strong>��<?php echo $this->_var['lang']['order_amount']; ?>: <strong><?php echo $this->_var['total']['amount_formated']; ?></strong>
              </td>
            </tr>
            <tr>
              <td align="center" bgcolor="#FFFFFF"><?php echo $this->_var['order']['pay_desc']; ?></td>
            </tr>
            <?php if ($this->_var['pay_online']): ?>
            
            <tr>
              <td align="center" bgcolor="#FFFFFF"><?php echo $this->_var['pay_online']; ?></td>
            </tr>
            <?php endif; ?>
          </table>
          <?php if ($this->_var['virtual_card']): ?>
          <div style="text-align:center;overflow:hidden;border:1px solid #E2C822;background:#FFF9D7;margin:10px;padding:10px 50px 30px;">
          <?php $_from = $this->_var['virtual_card']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'vgoods');if (count($_from)):
    foreach ($_from AS $this->_var['vgoods']):
?>
            <h3 style="color:#2359B1; font-size:12px;"><?php echo $this->_var['vgoods']['goods_name']; ?></h3>
            <?php $_from = $this->_var['vgoods']['info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'card');if (count($_from)):
    foreach ($_from AS $this->_var['card']):
?>
              <ul style="list-style:none;padding:0;margin:0;clear:both">
              <?php if ($this->_var['card']['card_sn']): ?>
              <li style="margin-right:50px;float:left;">
              <strong><?php echo $this->_var['lang']['card_sn']; ?>:</strong><span style="color:red;"><?php echo $this->_var['card']['card_sn']; ?></span>
              </li><?php endif; ?>
              <?php if ($this->_var['card']['card_password']): ?>
              <li style="margin-right:50px;float:left;">
              <strong><?php echo $this->_var['lang']['card_password']; ?>:</strong><span style="color:red;"><?php echo $this->_var['card']['card_password']; ?></span>
              </li><?php endif; ?>
              <?php if ($this->_var['card']['end_date']): ?>
              <li style="float:left;">
              <strong><?php echo $this->_var['lang']['end_date']; ?>:</strong><?php echo $this->_var['card']['end_date']; ?>
              </li><?php endif; ?>
              </ul>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
          </div>
          <?php endif; ?>
          <p style="text-align:center; margin-bottom:20px;"><?php echo $this->_var['order_submit_back']; ?></p>
        </div>
        <?php endif; ?>
        

<?php if ($this->_var['step'] == "cx_insure_cl"): ?>
<div class="w_center"> 
    <div class="w_cxjbx_n">
	 <div class="w_cxjbx_n1">
	  <img src="/images/w_cxjb_h2.jpg" title="ѡ��Ͷ������" alt="ѡ��Ͷ������"/>
	 </div>
	 <div class="w_cxfa_1">
	  <h2>ѡ��Ͷ������</h2>
	   <div class="w_cxfa_1_n">
	     <div class="w_cxfa_1_n_s">
		  <span id="tb1" onclick="setTab('tb',1,4,'w_cxfa_1_n_s1')" >����ǿ</span>
		  <span id="tb2" onclick="setTab('tb',2,4,'w_cxfa_1_n_s1')" >���ڰ�</span>
		  <span id="tb3" onclick="setTab('tb',3,4,'w_cxfa_1_n_s1')"  class="w_cxfa_1_n_s1">��ǿ��</span>
		  <span id="tb4" onclick="setTab('tb',4,4,'w_cxfa_1_n_s1')" >�Զ���</span>                                                                   
		 </div>
		 <div class="w_cxfa_1_1n"  id="con_tb_1" style="display: none;">
		   <ul class="w_cxfa_1_1n_u">
		     <?php $_from = $this->_var['djq']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'r');if (count($_from)):
    foreach ($_from AS $this->_var['r']):
?>
             <li>
			   <div class="w_cxfa_1_1n_ud">
			    <img src="/<?php echo $this->_var['r']['goods_img']; ?>" title="<?php echo $this->_var['r']['goods_name']; ?>" alt="<?php echo $this->_var['r']['goods_name']; ?>"/>
				<?php echo $this->_var['r']['goods_desc']; ?>
			   </div>
			   <p>�ο����ۣ�<i>��<?php echo $this->_var['r']['shop_price']; ?></i></p>
			   <div class="w_cxfa_1_1n_ut"><?php echo $this->_var['r']['goods_name']; ?></div>
			 </li>
			 <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		   </ul>
		   <table cellpadding="0" cellspacing="0" class="w_tab-1">
		     <tr class="w_tab-1_tr1">
			   <td>Ͷ������</td>
			   <td>Ͷ�����</td>
			   <td>����</td>
			 </tr>
			 <?php $_from = $this->_var['djq_xz']['tbxz']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'r');if (count($_from)):
    foreach ($_from AS $this->_var['r']):
?>
             <tr>
			   <td><?php echo $this->_var['r']['xz_name']; ?></td>
			   <td><?php echo $this->_var['r']['tb_price']; ?>Ԫ<?php if ($this->_var['r']['is_mp'] == 1): ?><em><i></i>��������</em><?php endif; ?></td>
			   <td>��<?php echo $this->_var['r']['price']; ?></td>
			 </tr>
             <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			 
			 <tr class="w_tab-1_tr2">
			   <td>�ϼƱ��ѣ�<b>��<?php echo $this->_var['djq_total']; ?></b></td>
			   <td></td>
			   <td></td>
			 </tr>
			 <tr class="w_tab-1_tr3">
			   <td><a href="flow.php?step=tj_insure&goods_id=<?php echo $this->_var['djq_xz']['goods_id']; ?>&cx_id=<?php echo $this->_var['cx_id']; ?>" title="��һ��">��һ��</a></td>
			   <td></td>
			   <td></td>
			 </tr>
		   </table>
		 </div>
		 <div class="w_cxfa_1_1n"  id="con_tb_2" style="display: none;">
		   <ul class="w_cxfa_1_1n_u">
		     <?php $_from = $this->_var['dzb']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'r');if (count($_from)):
    foreach ($_from AS $this->_var['r']):
?>
             <li>
			   <div class="w_cxfa_1_1n_ud">
			    <img src="/<?php echo $this->_var['r']['goods_img']; ?>" title="<?php echo $this->_var['r']['goods_name']; ?>" alt="<?php echo $this->_var['r']['goods_name']; ?>"/>
				<?php echo $this->_var['r']['goods_desc']; ?>
			   </div>
			   <p>�ο����ۣ�<i>��<?php echo $this->_var['r']['shop_price']; ?></i></p>
			   <div class="w_cxfa_1_1n_ut"><?php echo $this->_var['r']['goods_name']; ?></div>
			 </li>
			 <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		   </ul>
		   <table cellpadding="0" cellspacing="0" class="w_tab-1">
		     <tr class="w_tab-1_tr1">
			   <td>Ͷ������</td>
			   <td>Ͷ�����</td>
			   <td>����</td>
			 </tr>
			 <?php $_from = $this->_var['dzb_xz']['tbxz']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'r');if (count($_from)):
    foreach ($_from AS $this->_var['r']):
?>
             <tr>
			   <td><?php echo $this->_var['r']['xz_name']; ?></td>
			   <td><?php echo $this->_var['r']['tb_price']; ?>Ԫ<?php if ($this->_var['r']['is_mp'] == 1): ?><em><i></i>��������</em><?php endif; ?></td>
			   <td>��<?php echo $this->_var['r']['price']; ?></td>
			 </tr>
             <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			 <tr class="w_tab-1_tr2">
			   <td>�ϼƱ��ѣ�<b>��<?php echo $this->_var['dzb_total']; ?></b></td>
			   <td></td>
			   <td></td>
			 </tr>
			 <tr class="w_tab-1_tr3">
			   <td><a href="flow.php?step=tj_insure&goods_id=<?php echo $this->_var['dzb_xz']['goods_id']; ?>&cx_id=<?php echo $this->_var['cx_id']; ?>" title="��һ��">��һ��</a></td>
			   <td></td>
			   <td></td>
			 </tr>
		   </table>
		 </div>
		 <div class="w_cxfa_1_1n"  id="con_tb_3" style="display:block;">
		   <ul class="w_cxfa_1_1n_u">
		     <?php $_from = $this->_var['jqb']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'r');if (count($_from)):
    foreach ($_from AS $this->_var['r']):
?>
             <li>
			   <div class="w_cxfa_1_1n_ud">
			    <img src="/<?php echo $this->_var['r']['goods_img']; ?>" title="<?php echo $this->_var['r']['goods_name']; ?>" alt="<?php echo $this->_var['r']['goods_name']; ?>"/>
				<?php echo $this->_var['r']['goods_desc']; ?>
			   </div>
			   <p>�ο����ۣ�<i>��<?php echo $this->_var['r']['shop_price']; ?></i></p>
			   <div class="w_cxfa_1_1n_ut"><?php echo $this->_var['r']['goods_name']; ?></div>
			 </li>
			 <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		   </ul>
		   <table cellpadding="0" cellspacing="0" class="w_tab-1">
		     <tr class="w_tab-1_tr1">
			   <td>Ͷ������</td>
			   <td>Ͷ�����</td>
			   <td>����</td>
			 </tr>
			 <?php $_from = $this->_var['jqb_xz']['tbxz']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'r');if (count($_from)):
    foreach ($_from AS $this->_var['r']):
?>
             <tr>
			   <td><?php echo $this->_var['r']['xz_name']; ?></td>
			   <td><?php echo $this->_var['r']['tb_price']; ?>Ԫ<?php if ($this->_var['r']['is_mp'] == 1): ?><em><i></i>��������</em><?php endif; ?></td>
			   <td>��<?php echo $this->_var['r']['price']; ?></td>
			 </tr>
             <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			 <tr class="w_tab-1_tr2">
			   <td>�ϼƱ��ѣ�<b>��<?php echo $this->_var['jqb_total']; ?></b></td>
			   <td></td>
			   <td></td>
			 </tr>
			 <tr class="w_tab-1_tr3">
			   <td><a href="flow.php?step=tj_insure&goods_id=<?php echo $this->_var['jqb_xz']['goods_id']; ?>&cx_id=<?php echo $this->_var['cx_id']; ?>" title="��һ��">��һ��</a></td>
			   <td></td>
			   <td></td>
			 </tr>
		   </table>
		 </div>
		 <div class="w_cxfa_1_1n"  id="con_tb_4" style="display: none;">
		   <form action="flow.php" method="post" name="theForm" id="tbform">
           <table cellpadding="0" cellspacing="0" class="w_tab-1">
		     <tr class="w_tab-1_tr1">
			   <td>Ͷ������</td>
			   <td>Ͷ�����</td>
			   <td>����</td>
			 </tr>
			 <tr>
			   <td>������ʧ��
			   <div class="class_question">
			   <div class="insu_intr" style="display: none;">
			   <i></i>
			   <div class="con">
			   <h4>������Ա��������ʲô��  ����ָ��91%</h4>
			   <p>Ϊ��ʻԱ���˻�������������ˡ����ˡ�ֿ�����ṩ��ȫ��ı��ϡ�</p>
			   <h4>������Ա�����գ�˾������ʲô��</h4>
			   <p>�����ڼ��ڣ����������¹ʣ���ʹ��ʻԱ���˵�������������������������Σ����չ�˾������涨�����⳥��</p>
			   <h4>������Ա�����գ��˿ͣ���ʲô��</h4>
			   <p>���������¹ʣ���ɱ����˿ͣ��Ǽ�ʻԱ����������������������������Σ����չ�˾��������涨�����⳥��</p>
			   <h4>Ϊʲô��Ҫ��</h4>
			   <p>���ֻ򾭳���������ʿ�����ջ��ʽϴ󣬽��鹺�򣬸��ñ�������İ�ȫ�������������ϼ��˻����ѣ�ϣ���������ѵ�����ȫ�õ���Ч���ϣ����鹺��</p>
			   </div>
			   <div class="bottom"></div>
			   </div>
			   </div>
			   </td>
			   <td>
			    <select name="clss" id="cs_price" onchange="js_price('clss',this.value);">
				  <option>Ͷ��</option>
				  <option value="50000">50000</option>
				  <option value="100000">100000</option>
				  <option value="150000">150000</option>
                  <option value="200000">200000</option>
                  <option value="300000">300000</option>
                  <option value="500000">500000</option>
                  <option value="1000000">1000000</option>
				</select>
			<em><input type="checkbox" name="clss_bj" id="clss_bj" value="1" onclick="js_bjmp('clss',document.getElementById('cs_price').value,this.checked)" /><label>��������</label></em>
			   </td>
			   <td id="clss_price">��0.00</td>
			 </tr>
			 <tr>
			   <td>����������
			      <div class="class_question">
			   <div class="insu_intr" style="display: none;">
			   <i></i>
			   <div class="con">
			   <h4>������Ա��������ʲô��  ����ָ��91%</h4>
			   <p>Ϊ��ʻԱ���˻�������������ˡ����ˡ�ֿ�����ṩ��ȫ��ı��ϡ�</p>
			   <h4>������Ա�����գ�˾������ʲô��</h4>
			   <p>�����ڼ��ڣ����������¹ʣ���ʹ��ʻԱ���˵�������������������������Σ����չ�˾������涨�����⳥��</p>
			   <h4>������Ա�����գ��˿ͣ���ʲô��</h4>
			   <p>���������¹ʣ���ɱ����˿ͣ��Ǽ�ʻԱ����������������������������Σ����չ�˾��������涨�����⳥��</p>
			   <h4>Ϊʲô��Ҫ��</h4>
			   <p>���ֻ򾭳���������ʿ�����ջ��ʽϴ󣬽��鹺�򣬸��ñ�������İ�ȫ�������������ϼ��˻����ѣ�ϣ���������ѵ�����ȫ�õ���Ч���ϣ����鹺��</p>
			   </div>
			   <div class="bottom"></div>
			   </div>
			   </div>
			   </td>
			   <td>
			   <select name="dszr" id="dszr" onchange="js_price('dszr',this.value);">
				  <option>Ͷ��</option>
				  <option value="50000">50000</option>
				  <option value="100000">100000</option>
				  <option value="150000">150000</option>
                  <option value="200000">200000</option>
                  <option value="300000">300000</option>
                  <option value="500000">500000</option>
                  <option value="1000000">1000000</option>
				</select>
			<em><input type="checkbox" name="dszr_bj" id="dszr_bj" value="1" onclick="js_bjmp('dszr',document.getElementById('dszr').value,this.checked)" /><label>��������</label></em>
			   </td>
			   <td id="dszr_price">��0.00</td>
			 </tr>
			 <tr>
			   <td>˾����λ��
			      <div class="class_question">
			   <div class="insu_intr" style="display: none;">
			   <i></i>
			   <div class="con">
			   <h4>������Ա��������ʲô��  ����ָ��91%</h4>
			   <p>Ϊ��ʻԱ���˻�������������ˡ����ˡ�ֿ�����ṩ��ȫ��ı��ϡ�</p>
			   <h4>������Ա�����գ�˾������ʲô��</h4>
			   <p>�����ڼ��ڣ����������¹ʣ���ʹ��ʻԱ���˵�������������������������Σ����չ�˾������涨�����⳥��</p>
			   <h4>������Ա�����գ��˿ͣ���ʲô��</h4>
			   <p>���������¹ʣ���ɱ����˿ͣ��Ǽ�ʻԱ����������������������������Σ����չ�˾��������涨�����⳥��</p>
			   <h4>Ϊʲô��Ҫ��</h4>
			   <p>���ֻ򾭳���������ʿ�����ջ��ʽϴ󣬽��鹺�򣬸��ñ�������İ�ȫ�������������ϼ��˻����ѣ�ϣ���������ѵ�����ȫ�õ���Ч���ϣ����鹺��</p>
			   </div>
			   <div class="bottom"></div>
			   </div>
			   </div>
			   </td>
			   <td>
			   <select name="sjzw" id="sjzw" onchange="js_price('sjzw',this.value);">
				  <option>Ͷ��</option>
				  <option value="50000">50000</option>
				  <option value="100000">100000</option>
				  <option value="150000">150000</option>
                  <option value="200000">200000</option>
                  <option value="300000">300000</option>
                  <option value="500000">500000</option>
                  <option value="1000000">1000000</option>
				</select>
				<em><input type="checkbox" name="sjzw_bj" id="sjzw_bj" value="1" onclick="js_bjmp('sjzw',document.getElementById('sjzw').value,this.checked)" /><label>��������</label></em>
			   </td>
			   <td id="sjzw_price">��0.00</td>
			 </tr>
			 <tr>
			   <td>�˿���λ��
			       <div class="class_question">
			   <div class="insu_intr" style="display: none;">
			   <i></i>
			   <div class="con">
			   <h4>������Ա��������ʲô��  ����ָ��91%</h4>
			   <p>Ϊ��ʻԱ���˻�������������ˡ����ˡ�ֿ�����ṩ��ȫ��ı��ϡ�</p>
			   <h4>������Ա�����գ�˾������ʲô��</h4>
			   <p>�����ڼ��ڣ����������¹ʣ���ʹ��ʻԱ���˵�������������������������Σ����չ�˾������涨�����⳥��</p>
			   <h4>������Ա�����գ��˿ͣ���ʲô��</h4>
			   <p>���������¹ʣ���ɱ����˿ͣ��Ǽ�ʻԱ����������������������������Σ����չ�˾��������涨�����⳥��</p>
			   <h4>Ϊʲô��Ҫ��</h4>
			   <p>���ֻ򾭳���������ʿ�����ջ��ʽϴ󣬽��鹺�򣬸��ñ�������İ�ȫ�������������ϼ��˻����ѣ�ϣ���������ѵ�����ȫ�õ���Ч���ϣ����鹺��</p>
			   </div>
			   <div class="bottom"></div>
			   </div>
			   </div>
			   </td>
			   <td>
			   <select name="ckzw" id="ckzw" onchange="js_price('ckzw',this.value);">
				  <option>Ͷ��</option>
				  <option value="50000">50000</option>
				  <option value="100000">100000</option>
				  <option value="150000">150000</option>
                  <option value="200000">200000</option>
                  <option value="300000">300000</option>
                  <option value="500000">500000</option>
                  <option value="1000000">1000000</option>
				</select>
				<em><input type="checkbox" name="ckzw_bj" id="ckzw_bj" value="1" onclick="js_bjmp('ckzw',document.getElementById('ckzw').value,this.checked)" /><label>��������</label></em>
			   </td>
			   <td id="ckzw_price">��0.00</td>
			 </tr>
			 <tr>
			   <td>������
			       <div class="class_question">
			   <div class="insu_intr" style="display: none;">
			   <i></i>
			   <div class="con">
			   <h4>������Ա��������ʲô��  ����ָ��91%</h4>
			   <p>Ϊ��ʻԱ���˻�������������ˡ����ˡ�ֿ�����ṩ��ȫ��ı��ϡ�</p>
			   <h4>������Ա�����գ�˾������ʲô��</h4>
			   <p>�����ڼ��ڣ����������¹ʣ���ʹ��ʻԱ���˵�������������������������Σ����չ�˾������涨�����⳥��</p>
			   <h4>������Ա�����գ��˿ͣ���ʲô��</h4>
			   <p>���������¹ʣ���ɱ����˿ͣ��Ǽ�ʻԱ����������������������������Σ����չ�˾��������涨�����⳥��</p>
			   <h4>Ϊʲô��Ҫ��</h4>
			   <p>���ֻ򾭳���������ʿ�����ջ��ʽϴ󣬽��鹺�򣬸��ñ�������İ�ȫ�������������ϼ��˻����ѣ�ϣ���������ѵ�����ȫ�õ���Ч���ϣ����鹺��</p>
			   </div>
			   <div class="bottom"></div>
			   </div>
			   </div>
			   </td>
			   <td>
			    <select name="qdx" id="qdx" onchange="js_price('qdx',this.value);">
				  <option>Ͷ��</option>
				  <option value="50000">50000</option>
				  <option value="100000">100000</option>
				  <option value="150000">150000</option>
                  <option value="200000">200000</option>
                  <option value="300000">300000</option>
                  <option value="500000">500000</option>
                  <option value="1000000">1000000</option>
				</select>
				<em><input type="checkbox" name="qdx_bj" id="qdx_bj" value="1" onclick="js_bjmp('qdx',document.getElementById('qdx').value,this.checked)" /><label>��������</label></em>
			   </td>
			   <td id="qdx_price">��0.00</td>
			 </tr>
			 <tr>
			   <td>����������
			       <div class="class_question">
			   <div class="insu_intr" style="display: none;">
			   <i></i>
			   <div class="con">
			   <h4>������Ա��������ʲô��  ����ָ��91%</h4>
			   <p>Ϊ��ʻԱ���˻�������������ˡ����ˡ�ֿ�����ṩ��ȫ��ı��ϡ�</p>

			   <h4>������Ա�����գ�˾������ʲô��</h4>
			   <p>�����ڼ��ڣ����������¹ʣ���ʹ��ʻԱ���˵�������������������������Σ����չ�˾������涨�����⳥��</p>
			   <h4>������Ա�����գ��˿ͣ���ʲô��</h4>
			   <p>���������¹ʣ���ɱ����˿ͣ��Ǽ�ʻԱ����������������������������Σ����չ�˾��������涨�����⳥��</p>
			   <h4>Ϊʲô��Ҫ��</h4>
			   <p>���ֻ򾭳���������ʿ�����ջ��ʽϴ󣬽��鹺�򣬸��ñ�������İ�ȫ�������������ϼ��˻����ѣ�ϣ���������ѵ�����ȫ�õ���Ч���ϣ����鹺��</p>
			   </div>
			   <div class="bottom"></div>
			   </div>
			   </div>
			   </td>
			   <td>
			   <select name="blps" id="blps" onchange="js_price1('blps',this.value);">
				  <option>Ͷ��</option>
                  <option value="1">������</option>
                  <option value="2">���ڳ�</option>
				</select>
			   </td>
			   <td id="blps_price">��0.00</td>
			 </tr>
             <tr>
			   <td>ָ��ר����
			       <div class="class_question">
			   <div class="insu_intr" style="display: none;">
			   <i></i>
			   <div class="con">
			   <h4>������Ա��������ʲô��  ����ָ��91%</h4>
			   <p>Ϊ��ʻԱ���˻�������������ˡ����ˡ�ֿ�����ṩ��ȫ��ı��ϡ�</p>

			   <h4>������Ա�����գ�˾������ʲô��</h4>
			   <p>�����ڼ��ڣ����������¹ʣ���ʹ��ʻԱ���˵�������������������������Σ����չ�˾������涨�����⳥��</p>
			   <h4>������Ա�����գ��˿ͣ���ʲô��</h4>
			   <p>���������¹ʣ���ɱ����˿ͣ��Ǽ�ʻԱ����������������������������Σ����չ�˾��������涨�����⳥��</p>
			   <h4>Ϊʲô��Ҫ��</h4>
			   <p>���ֻ򾭳���������ʿ�����ջ��ʽϴ󣬽��鹺�򣬸��ñ�������İ�ȫ�������������ϼ��˻����ѣ�ϣ���������ѵ�����ȫ�õ���Ч���ϣ����鹺��</p>
			   </div>
			   <div class="bottom"></div>
			   </div>
			   </div>
			   </td>
			   <td>
			   <select name="zdzx" id="zdzx" onchange="js_price1('zdzx',this.value);">
				  <option>��Ͷ��</option>
				  <option value="1">������</option>
                  <option value="2">���ڳ�</option>
				</select>
			   </td>
			   <td id="zdzx_price">��0.00</td>
			 </tr>
			 <tr class="w_tab-1_tr2">
			   <td>�ϼƱ��ѣ�<b id="xz_total">��0.00</b></td>
			   <td></td>
			   <td></td>
			 </tr>
			 <tr class="w_tab-1_tr3">
			   <td><a href="javascript:document.getElementById('tbform').submit();" title="��һ��">��һ��</a></td>
               <input type="hidden" name="step" value="tj_insure" />
               <input type="hidden" name="cx_id" value="<?php echo $this->_var['cx_id']; ?>" />
               <input type="hidden" name="cat_id" value="<?php echo $this->_var['cat_id']; ?>" />
			   <td></td>
			   <td></td>
			 </tr>
		   </table>
           </form>
		 </div>
	   </div>
	 </div>
   </div>
 </div>
<script>
/* *
 * �������
 */
function js_price(xz,price)
{
  var cs_price=document.getElementById('cs_price').value;
  document.getElementById(xz+'_bj').checked == true ? bjmp=1 : bjmp=0;
  Ajax.call('flow.php?step=js_price', 'xz=' + xz+'&price='+price+'&cs_price='+cs_price+'&bjmp='+bjmp, js_priceResponse, 'GET', 'JSON');
}

function js_price1(xz,price)
{
  var cs_price=document.getElementById('cs_price').value;
  Ajax.call('flow.php?step=js_price', 'xz=' + xz+'&price='+price+'&cs_price='+cs_price, js_priceResponse, 'GET', 'JSON');
}

/*��������*/
function js_bjmp(xz,price,checked)
{
  checked == true ? bjmp=1 : bjmp=0;
  Ajax.call('flow.php?step=js_price', 'xz=' + xz+'&price='+price+'&bjmp='+bjmp, js_priceResponse, 'GET', 'JSON');
}

function js_priceResponse(result){
	document.getElementById(result.xz_id).innerHTML='��'+result.price;
	document.getElementById('xz_total').innerHTML='��'+result.total;
	if(result.xz_id == 'clss_price'){
  	  $("#blps").change();
	  $("#zdzx").change();
    }
}
</script>
<?php endif; ?>

<?php if ($this->_var['step'] == "tj_insure"): ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'region.js')); ?>
<script src="/js/MyDate/WdatePicker.js"></script>
<script>
function g(element){return document.getElementById(element);}
function tijiao(){
	if(!g('c_city').value){
		alert('����д����');
	}else if(!g('frame_number').value){
		alert('����д���ܺ�');
	}else if(!g('cp_number').value){
		alert('����д���ƺ�');
	}else if(!g('engine_number').value){
		alert('����д��������');
	}else if(!g('dj_time').value){
		alert('����д�Ǽ�����');
	}else if(!g('brand').value){
		alert('����дƷ���ͺ�');
	}else if(!g('cz_name').value){
		alert('����д��������');
	}else if(!g('configure').value){
		alert('����д�����ͺ�');
	}else if(!g('sfz_number').value){
		alert('����д���֤��');
	}else if(!g('mobile').value){
		alert('����д�ֻ���');
	}else if(!g('bd_name').value){
		alert('����д��������');
	}else if(!g('bd_mobile').value){
		alert('����д�����ֻ���');
	}else if(!g('address').value){
		alert('����д��ϸ��ַ');
	}else if(!g('ps_time').value){
		alert('����д����ʱ��');
	}else{
		g("insure_cx").submit();
	}
}
</script>
<div class="w_center"> 
    <div class="w_cxjbx_n">
	 <div class="w_cxjbx_n1">
	  <img src="/images/w_cxjb_h3.jpg" title="�ύͶ��" alt="�ύͶ��"/>
	 </div>
	 <form action="flow.php" method="post" name="theForm" id="insure_cx">
     <div class="w_cxjbx_n3">
	  <h2>��Ա��Ϣ<i>�����</i></h2>
	  <div class="w_cxjbx_n3_d"><b><i></i>��ʻ֤����</b></div>
	  <ul class="w_cxjbx_n3_1">
	   <li><label><i>*</i>���У�</label><input type="text" name="c_city" id="c_city" value="<?php echo $this->_var['arr']['c_city']; ?>" /></li>
	   <li><label><i>*</i>���ܺţ�</label><input type="text" name="frame_number" id="frame_number" value="<?php echo $this->_var['arr']['frame_number']; ?>" /></li>
	   <li><label><i>*</i>���ƺţ�</label><input type="text" name="cp_number" id="cp_number" value="<?php echo $this->_var['arr']['cp_number']; ?>" /></li>
	   <li><label><i>*</i>�������ţ�</label><input type="text" name="engine_number" id="engine_number" value="<?php echo $this->_var['arr']['engine_number']; ?>" /></li>
	   <li><label><i>*</i>�Ǽ����ڣ�</label><input type="text" name="dj_time" id="dj_time" value="<?php echo $this->_var['arr']['dj_time']; ?>" /></li>
	   <li><label><i>*</i>Ʒ���ͺţ�</label><input type="text" name="brand" id="brand" value="<?php echo $this->_var['arr']['brand']; ?>" /></li>
	   <li><label><i>*</i>����������</label><input type="text" name="cz_name" id="cz_name"  value="<?php echo $this->_var['arr']['cz_name']; ?>" /></li>
	   <li><label><i>*</i>�����ͺţ�</label><input type="text" name="configure" id="configure" value="<?php echo $this->_var['arr']['configure']; ?>" /></li>
	   <li><label><i>*</i>���֤�ţ�</label><input type="text" name="sfz_number" id="sfz_number" value="<?php echo $this->_var['arr']['sfz_number']; ?>" /></li>
	   <li><label><i>*</i>��������</label><span><input type="radio" name="is_transfer" <?php if ($this->_var['arr']['is_transfer'] == 0): ?>checked="checked"<?php endif; ?> value="0" style="width:30px;" />��</span>
                                          <span><input type="radio" name="is_transfer" <?php if ($this->_var['arr']['is_transfer'] == 1): ?>checked="checked"<?php endif; ?> value="1" style="width:30px;" />��</span>
                                  <!--<input type="text" name="is_transfer" value="��" />--></li>
	   <li><label><i>*</i>�ֻ��ţ�</label><input type="text" name="mobile" id="mobile" value="<?php echo $this->_var['arr']['mobile']; ?>" /></li>
	  </ul>
	  <div class="clear"></div>
	  <div class="w_cxjbx_n3_d">
	    <span>ͬ��
		<select>
		   <option>��ʻ֤����</option> 
		</select>
		</span>
		<b><i></i>��������</b><em><?php echo $this->_var['arr']['cz_name']; ?></em>
	</div>
	<div class="clear"></div>
	  <div class="w_cxjbx_n3_d">
	  <span>ͬ��
		<select>
		   <option>��ʻ֤����</option> 
		</select>
		</span>
	  <b><i></i>Ͷ����</b><em><?php echo $this->_var['arr']['cz_name']; ?></em></div>
	 </div>
	 <div class="w_cxjbx_n3">
	  <h2>��������Ʊ��Ϣ<i>�����</i></h2>
	  <ul class="w_cxjbx_n2_u">
	    <li><label><i>*</i>������</label><input type="text" name="bd_name" id="bd_name" value="<?php echo $this->_var['address_info']['consignee']; ?>" class="w_cxjb_in1" /></li>
		 <li><label><i>*</i>�ֻ���</label><input type="text" name="bd_mobile" id="bd_mobile" value="<?php echo $this->_var['address_info']['mobile']; ?>" class="w_cxjb_in1" /></li>
	     <li>
		 <label><i>*</i>���͵�ַ��</label>
		 <select name="country" id="selCountries" onchange="region.changed(this, 1, 'selProvinces')" style="display:none">
          <option value="1">�й�</option>
         </select>
        <select name="province" id="selProvinces" onchange="region.changed(this, 2, 'selCities')">
          <option value="0">��ѡ��ʡ</option>
          <?php $_from = $this->_var['province_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'province');if (count($_from)):
    foreach ($_from AS $this->_var['province']):
?>
                  <option value="<?php echo $this->_var['province']['region_id']; ?>" <?php if ($this->_var['address_info']['province'] == $this->_var['province']['region_id']): ?>selected<?php endif; ?>><?php echo $this->_var['province']['region_name']; ?></option>
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </select>
        <select name="city" id="selCities" onchange="region.changed(this, 3, 'selDistricts')">
          <option value="0">��ѡ����</option>
          <?php $_from = $this->_var['city_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'province');if (count($_from)):
    foreach ($_from AS $this->_var['province']):
?>
                  <option value="<?php echo $this->_var['province']['region_id']; ?>" <?php if ($this->_var['address_info']['city'] == $this->_var['province']['region_id']): ?>selected<?php endif; ?>><?php echo $this->_var['province']['region_name']; ?></option>
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </select>
        <select name="district" id="selDistricts">
          <option value="0">��ѡ����</option>
          <?php $_from = $this->_var['district_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'province');if (count($_from)):
    foreach ($_from AS $this->_var['province']):
?>
                  <option value="<?php echo $this->_var['province']['region_id']; ?>" <?php if ($this->_var['address_info']['district'] == $this->_var['province']['region_id']): ?>selected<?php endif; ?>><?php echo $this->_var['province']['region_name']; ?></option>
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </select>
         
         <!--<select name="country" id="selCountries" onchange="region.changed(this, 1, 'selProvinces')" style="display:none;">
              <option value="1">�й�</option>
          </select>
          <select name="province" id="selProvinces" onchange="region.changed(this, 2, 'selCities')">
              <option value="0">��ѡ��ʡ</option>
          </select>
          <select name="city" id="selCities" onchange="region.changed(this, 3, 'selDistricts')">
              <option value="0">��ѡ����</option>
          </select>
          <select name="district" id="selDistricts">
              <option value="0">��ѡ����</option>
          </select>-->
		 </li>
		 
		 <li><label>&nbsp;</label><input type="text" name="address" id="address" value="<?php echo $this->_var['address_info']['address']; ?>" placeholder="��������ϸ��ַ" class="w_cxjb_in1"/></li>
		 <li><label><i>*</i>����ʱ�䣺</label><input type="text" name="ps_time" id="ps_time" value="<?php echo $this->_var['address_info']['best_time']; ?>" validate=" required:true" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" class="w_cxjb_in1"/></li>
		 <li><label><i>*</i>���߷�Ʊ��</label><em style="margin-top:10px;"><input type="radio" name="is_invoice" value="0" /><em><label>��</label></em>
         <input type="radio" name="is_invoice" value="1" /><em><label>��</label></em></em></li>
		 <li><label><i>*</i> ��Ʊ̧ͷ��</label><input type="text" name="invoice_title" class="w_cxjb_in1"/></li>
         <li>
            <label><i>*</i>֧����ʽ��</label>
            <?php $_from = $this->_var['payment_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('k', 'payment');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['payment']):
?>
            
            <input type="radio" name="payment" value="<?php echo $this->_var['payment']['pay_id']; ?>" <?php if ($this->_var['k'] == 0): ?>checked<?php endif; ?> isCod="<?php echo $this->_var['payment']['is_cod']; ?>" onclick="selectPayment(this,<?php echo $this->_var['rec_id']; ?>)" <?php if ($this->_var['cod_disabled'] && $this->_var['payment']['is_cod'] == "1"): ?>disabled="true"<?php endif; ?> style="float:none;" />
             <strong><?php echo $this->_var['payment']['pay_name']; ?></strong>
              �����ѣ�<?php echo $this->_var['payment']['format_pay_fee']; ?>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
         </li>
         <input type="hidden" name="address_id" value="<?php echo $this->_var['address_info']['address_id']; ?>" />
         <input type="hidden" name="step" value="cx_done" />
         <input type="hidden" name="goods_id" value="<?php echo $this->_var['goods_id']; ?>" />
         <input type="hidden" name="cx_id" value="<?php echo $this->_var['cx_id']; ?>" />
         <input type="hidden" name="custom" value="<?php echo $this->_var['custom']; ?>" />
         <input type="hidden" name="cat_id" value="<?php echo $this->_var['cat_id']; ?>" />
	   </ul>

	</div>
    
	<div class="w_cxjbx_n3">
	  <h2>������Ϣȷ��<i>�����</i></h2>
	  <h3><?php echo $this->_var['tbxz_info']['cat_name']; ?></h3>
	  <div class="w_cxjbx_n3_2">
	    <h4><i style=" cursor:pointer" onclick="$('.w_cx_tab').slideToggle(500)"></i>
        <span class="w_cxjbx_n3_2s1"><?php if ($this->_var['tbxz_info']['cx_type'] == 1): ?>����ǿ<?php elseif ($this->_var['tbxz_info']['cx_type'] == 2): ?>���ڰ�<?php elseif ($this->_var['tbxz_info']['cx_type'] == 3): ?>��ǿ��<?php else: ?>�Զ���<?php endif; ?></span>
        <span  class="w_cxjbx_n3_2s2">���ѣ���λ��Ԫ��</span></h4>
		
        <table cellpadding="0" cellspacing="0" class="w_cx_tab">
		  <?php $_from = $this->_var['tbxz']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('k', 'r');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['r']):
?>
          <tr>
		    <td class="w_cx_tab_b1"><?php echo $this->_var['r']['xz_name']; ?></td>
			<td class="w_cx_tab_b2"><?php echo $this->_var['r']['tb_price']; ?></td>
			<td class="w_cx_tab_b3"><?php if ($this->_var['r']['is_mp'] == 1): ?>��������<?php endif; ?></td>
			<td class="w_cx_tab_b4"><?php echo $this->_var['r']['price']; ?></td>
		  </tr>
		  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		  <tr>
		    <td class="w_cx_tab_b1"><b>���ƣ�</b></td>
			<td class="w_cx_tab_b2"></td>
			<td class="w_cx_tab_b3"></td>
			<td class="w_cx_tab_b4"><em><?php echo $this->_var['tbxz_total']; ?></em></td>
		  </tr>
		</table>
	  </div>
	</div> 
	<div class="w_cxjbx_n3_div1">
	<span>ʵ����<i>�� <?php echo $this->_var['tbxz_total']; ?></i></span>
	<input type="checkbox" name="is_check" value="1" />
	<label>�����Ķ���ͬ��<a href="" title="����Ͷ������Э��">������Ͷ������Э�顷</a></label>
	</div> 
	<div class="w_cxjbx_n3_div2">
	  <a href="javascript:history.go(-1);" title="��һ��">��һ��</a>
	  <a href="javascript:tijiao();" title="�ύ����"  class="w_cxjbx_n3_div2a">�ύ����</a>
	</div>
    </form>
</div>
</div>
<script>
region.isAdmin = true;
if(!"<?php echo $this->_var['address_info']['address_id']; ?>"){
	$("#selCountries").change();
}
//$("#selCountries").change();
</script>
<?php endif; ?>

<?php if ($this->_var['step'] == "cx_done"): ?>
        <link href="<?php echo $this->_var['ecs_css_path']; ?>" rel="stylesheet" type="text/css" />
        
        <div class="flowBox" style="margin:30px auto 70px auto;">
         <h6 style="text-align:center; height:30px; line-height:30px;"><?php echo $this->_var['lang']['remember_order_number']; ?>: <font style="color:red"><?php echo $this->_var['order']['order_sn']; ?></font></h6>
          <table width="99%" align="center" border="0" cellpadding="15" cellspacing="0" bgcolor="#fff" style="border:1px solid #ddd; margin:20px auto;" >
            <tr>
              <td align="center" bgcolor="#FFFFFF">
              <?php echo $this->_var['lang']['select_payment']; ?>: <strong><?php echo $this->_var['order']['pay_name']; ?></strong>��<?php echo $this->_var['lang']['order_amount']; ?>: <strong><?php echo $this->_var['order']['order_amount']; ?></strong>
              </td>
            </tr>
            <tr>
              <td align="center" bgcolor="#FFFFFF"><?php echo $this->_var['order']['pay_desc']; ?></td>
            </tr>
            <?php if ($this->_var['pay_online']): ?>
            
            <tr>
              <td align="center" bgcolor="#FFFFFF"><?php echo $this->_var['pay_online']; ?></td>
            </tr>
            <?php endif; ?>
          </table>
          <p style="text-align:center; margin-bottom:20px;"><?php echo $this->_var['order_submit_back']; ?></p>
        </div>
<?php endif; ?>


        <?php if ($this->_var['step'] == "login"): ?>
        <?php echo $this->smarty_insert_scripts(array('files'=>'utils.js,user.js')); ?>
        <script type="text/javascript">
        <?php $_from = $this->_var['lang']['flow_login_register']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
          var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

        
        function checkLoginForm(frm) {
          if (Utils.isEmpty(frm.elements['username'].value)) {
            alert(username_not_null);
            return false;
          }

          if (Utils.isEmpty(frm.elements['password'].value)) {
            alert(password_not_null);
            return false;
          }

          return true;
        }

        function checkSignupForm(frm) {
          if (Utils.isEmpty(frm.elements['username'].value)) {
            alert(username_not_null);
            return false;
          }

          if (Utils.trim(frm.elements['username'].value).match(/^\s*$|^c:\\con\\con$|[%,\'\*\"\s\t\<\>\&\\]/))
          {
            alert(username_invalid);
            return false;
          }

          if (Utils.isEmpty(frm.elements['email'].value)) {
            alert(email_not_null);
            return false;
          }

          if (!Utils.isEmail(frm.elements['email'].value)) {
            alert(email_invalid);
            return false;
          }

          if (Utils.isEmpty(frm.elements['password'].value)) {
            alert(password_not_null);
            return false;
          }

          if (frm.elements['password'].value.length < 6) {
            alert(password_lt_six);
            return false;
          }

          if (frm.elements['password'].value != frm.elements['confirm_password'].value) {
            alert(password_not_same);
            return false;
          }
          return true;
        }
        
        </script>
        
        <div class="flowBox">
        <table width="99%" align="center" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
          <tr>
            <td width="50%" valign="top" bgcolor="#ffffff">
            <h6><span>�û���¼��</span></h6>
            <form action="flow.php?step=login" method="post" name="loginForm" id="loginForm" onsubmit="return checkLoginForm(this)">
                <table width="90%" border="0" cellpadding="8" cellspacing="1" bgcolor="#B0D8FF" class="table">
                  <tr>
                    <td bgcolor="#ffffff"><div align="right"><strong><?php echo $this->_var['lang']['username']; ?></strong></div></td>
                    <td bgcolor="#ffffff"><input name="username" type="text" class="inputBg" id="username" /></td>
                  </tr>
                  <tr>
                    <td bgcolor="#ffffff"><div align="right"><strong><?php echo $this->_var['lang']['password']; ?></strong></div></td>
                    <td bgcolor="#ffffff"><input name="password" class="inputBg" type="password" /></td>
                  </tr>
                  <?php if ($this->_var['enabled_login_captcha']): ?>
                  <tr>
                    <td bgcolor="#ffffff"><div align="right"><strong><?php echo $this->_var['lang']['comment_captcha']; ?>:</strong></div></td>
                    <td bgcolor="#ffffff"><input type="text" size="8" name="captcha" class="inputBg" />
                    <img src="captcha.php?is_login=1&<?php echo $this->_var['rand']; ?>" alt="captcha" style="vertical-align: middle;cursor: pointer;" onClick="this.src='captcha.php?is_login=1&'+Math.random()" /> </td>
                  </tr>
                  <?php endif; ?>
                  <tr>
            <td colspan="2"  bgcolor="#ffffff"><input type="checkbox" value="1" name="remember" id="remember" /><label for="remember"><?php echo $this->_var['lang']['remember']; ?></label></td>
          </tr>
                  <tr>
                    <td bgcolor="#ffffff" colspan="2" align="center"><a href="user.php?act=qpassword_name" class="f6"><?php echo $this->_var['lang']['get_password_by_question']; ?></a>&nbsp;&nbsp;&nbsp;<a href="user.php?act=get_password" class="f6"><?php echo $this->_var['lang']['get_password_by_mail']; ?></a></td>
                  </tr>
                  <tr>
                    <td bgcolor="#ffffff" colspan="2"><div align="center">
                        <input type="submit" class="bnt_blue" name="login" value="<?php echo $this->_var['lang']['forthwith_login']; ?>" />
                        <?php if ($this->_var['anonymous_buy'] == 1): ?>
                        <input type="button" class="bnt_blue_2" value="<?php echo $this->_var['lang']['direct_shopping']; ?>" onclick="location.href='flow.php?step=consignee&amp;direct_shopping=1'" />
                        <?php endif; ?>
                        <input name="act" type="hidden" value="signin" />
                      </div></td>
                  </tr>
                </table>
              </form>

              </td>
            <td valign="top" bgcolor="#ffffff">
            <h6><span>�û�ע�᣺</span></h6>
            <form action="flow.php?step=login" method="post" name="formUser" id="registerForm" onsubmit="return checkSignupForm(this)">
               <table width="98%" border="0" cellpadding="8" cellspacing="1" bgcolor="#B0D8FF" class="table">
                  <tr>
                    <td bgcolor="#ffffff" align="right" width="25%"><strong><?php echo $this->_var['lang']['username']; ?></strong></td>
                    <td bgcolor="#ffffff"><input name="username" type="text" class="inputBg" id="username" onblur="is_registered(this.value);" /><br />
            <span id="username_notice" style="color:#FF0000"></span></td>
                  </tr>
                  <tr>
                    <td bgcolor="#ffffff" align="right"><strong><?php echo $this->_var['lang']['email_address']; ?></strong></td>
                    <td bgcolor="#ffffff"><input name="email" type="text" class="inputBg" id="email" onblur="checkEmail(this.value);" /><br />
            <span id="email_notice" style="color:#FF0000"></span></td>
                  </tr>
                  <tr>
                    <td bgcolor="#ffffff" align="right"><strong><?php echo $this->_var['lang']['password']; ?></strong></td>
                    <td bgcolor="#ffffff"><input name="password" class="inputBg" type="password" id="password1" onblur="check_password(this.value);" onkeyup="checkIntensity(this.value)" /><br />
            <span style="color:#FF0000" id="password_notice"></span></td>
                  </tr>
                  <tr>
                    <td bgcolor="#ffffff" align="right"><strong><?php echo $this->_var['lang']['confirm_password']; ?></strong></td>
                    <td bgcolor="#ffffff"><input name="confirm_password" class="inputBg" type="password" id="confirm_password" onblur="check_conform_password(this.value);" /><br />
            <span style="color:#FF0000" id="conform_password_notice"></span></td>
                  </tr>
                  <?php if ($this->_var['enabled_register_captcha']): ?>
                  <tr>
                    <td bgcolor="#ffffff" align="right"><strong><?php echo $this->_var['lang']['comment_captcha']; ?>:</strong></td>
                    <td bgcolor="#ffffff"><input type="text" size="8" name="captcha" class="inputBg" />
                    <img src="captcha.php?<?php echo $this->_var['rand']; ?>" alt="captcha" style="vertical-align: middle;cursor: pointer;" onClick="this.src='captcha.php?'+Math.random()" /> </td>
                  </tr>
                  <?php endif; ?>
                  <tr>
                    <td colspan="2" bgcolor="#ffffff" align="center">
                        <input type="submit" name="Submit" class="bnt_blue_1" value="<?php echo $this->_var['lang']['forthwith_register']; ?>" />
                        <input name="act" type="hidden" value="signup" />
                    </td>
                  </tr>
                </table>
              </form>
              </td>
          </tr>
          <?php if ($this->_var['need_rechoose_gift']): ?>
          <tr>
            <td colspan="2" align="center" style="border-top:1px #ccc solid; padding:5px; color:red;"><?php echo $this->_var['lang']['gift_remainder']; ?></td>
          </tr>
          <?php endif; ?>
        </table>
        </div>
        
        <?php endif; ?>




</div>


<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>
<script type="text/javascript">
var process_request = "<?php echo $this->_var['lang']['process_request']; ?>";
<?php $_from = $this->_var['lang']['passport_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
var username_exist = "<?php echo $this->_var['lang']['username_exist']; ?>";
var compare_no_goods = "<?php echo $this->_var['lang']['compare_no_goods']; ?>";
var btn_buy = "<?php echo $this->_var['lang']['btn_buy']; ?>";
var is_cancel = "<?php echo $this->_var['lang']['is_cancel']; ?>";
var select_spe = "<?php echo $this->_var['lang']['select_spe']; ?>";
</script>
</html>
