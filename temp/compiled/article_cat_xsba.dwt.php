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
<script src="/js/MyDate/WdatePicker.js"></script>

<?php echo $this->smarty_insert_scripts(array('files'=>'common.js')); ?>
<script>
function g(element){return document.getElementById(element);}
function tijiao(){
	if(!document.message.ba_name.value){alert("报案人姓名不能为空！");return false;}
	if(!document.message.ba_tel.value){alert("报案人手机不能为空！");return false;}
	if(!document.message.email.value){alert("报案人邮箱不能为空！");return false;}
	if(!document.message.cx_name.value){alert("出险人姓名不能为空！");return false;}
	if(!document.message.zj_number.value){alert("出险人证件号码不能为空！");return false;}
	if(!document.message.cx_tel.value){alert("出险人手机不能为空！");return false;}
	if(!document.message.bdh.value){alert("出险保单号不能为空！");return false;}
	if(!document.message.lp_type.value){alert("理赔类型不能为空！");return false;}
	if(!document.message.fs_time.value){alert("发生时间不能为空！");return false;}
	if(!document.message.reason.value){alert("延误原因不能为空！");return false;}
	
	return true;
}
</script>
</head>
<body>
<?php echo $this->fetch('library/page_header.lbi'); ?>
<div class="w_center"> 
   
   <div class="w_dqwz">
    <?php echo $this->fetch('library/ur_here.lbi'); ?>
   </div>
   <div class="w_bxxy_l">
     <div class="w_bxxyl_1">
	   <h2><?php echo $this->_var['catname']; ?></h2>
	   <ul class="w_bxxyl_1l">
       <li  class="w_bxxyl_1l_1" >
	    	<a href="javascript:;" title="车险理赔" onclick="$('.w_bxxyl_12').slideToggle(500)">车险理赔<i class="w_lpxl"></i></a>
	        <ul class="w_bxxyl_12" <?php if ($this->_var['parent_id'] == 24): ?>style="display:none"<?php endif; ?>>
			   <?php $_from = $this->_var['cxlp']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'r');if (count($_from)):
    foreach ($_from AS $this->_var['r']):
?>
			   <li><a href="article.php?id=<?php echo $this->_var['r']['article_id']; ?>" title="<?php echo $this->_var['r']['title']; ?>"><?php echo $this->_var['r']['title']; ?></a></li>
               <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
               <?php $_from = $this->_var['cx_cat']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'r');if (count($_from)):
    foreach ($_from AS $this->_var['r']):
?>
			   <li <?php if ($this->_var['r']['cat_id'] == $this->_var['cat_id']): ?>class="w_bxxyl_12_a"<?php endif; ?>><a href="article_cat.php?id=<?php echo $this->_var['r']['cat_id']; ?>" title="<?php echo $this->_var['r']['cat_name']; ?>"><?php echo $this->_var['r']['cat_name']; ?></a></li>
               <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			</ul>
		</li>
		<li  class="w_bxxyl_1l_1" >
		<a href="javascript:;" title="非车险理赔"  onclick="$('.w_bxxyl_12').slideToggle(500)">非车险理赔<i class="w_lpxl"></i></a>
		  <ul class="w_bxxyl_12" <?php if ($this->_var['parent_id'] == 23): ?>style="display:none"<?php endif; ?>>
			   <?php $_from = $this->_var['fcxlp']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'r');if (count($_from)):
    foreach ($_from AS $this->_var['r']):
?>
			   <li><a href="article.php?id=<?php echo $this->_var['r']['article_id']; ?>" title="<?php echo $this->_var['r']['title']; ?>"><?php echo $this->_var['r']['title']; ?></a></li>
               <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
               <?php $_from = $this->_var['fcx_cat']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'r');if (count($_from)):
    foreach ($_from AS $this->_var['r']):
?>
			   <li <?php if ($this->_var['r']['cat_id'] == $this->_var['cat_id']): ?>class="w_bxxyl_12_a"<?php endif; ?>><a href="article_cat.php?id=<?php echo $this->_var['r']['cat_id']; ?>" title="<?php echo $this->_var['r']['cat_name']; ?>"><?php echo $this->_var['r']['cat_name']; ?></a></li>
               <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			</ul>
		</li>
       </ul>
	 </div>
   </div>
   <div class="w_bxxy_r">
     <div class="w_bxxy_r_t1"><i></i><b><?php echo $this->_var['name']; ?></b>Online report </div>
	 <div class="w_fcx_xs">
	   <form action="message.php" method="post" onsubmit="return tijiao();" name="message">
       <ul>
	    <div class="w_fcx_xs_d"><b><i></i>报案人信息</b></div>
		<li><label><i>*</i>报案人姓名</label><div class="w_fcx_xs_in"><input type="text" name="ba_name" value=""/></div></li>
		<li><label><i>*</i>手机</label><div class="w_fcx_xs_in"><input type="text" name="ba_tel" value=""/></div></li>
		<li><label><i>*</i>邮箱</label><div class="w_fcx_xs_in"><input type="text" name="email" value=""/></div></li>
	   </ul>
	   <ul>
	    <div class="w_fcx_xs_d"><b><i></i>出险人信息</b></div>
		<li><label><i>*</i>出险人姓名</label><div class="w_fcx_xs_in"><input type="text" name="cx_name" value=""/></div></li>
		<li><label><i>*</i>证件号码</label><div class="w_fcx_xs_in"><input type="text" name="zj_number"  placeholder="请填写购买产品时填写的证件号"  value=""/></div></li>
		<li><label><i>*</i>手机</label><div class="w_fcx_xs_in"><input type="text" name="cx_tel" value=""/></div></li>
		<li><label><i>*</i>保单号</label><div class="w_fcx_xs_in"><input type="text" name="bdh" value=""/></div></li>
	   </ul>
	   <ul>
	    <div class="w_fcx_xs_d"><b><i></i>理赔申请信息</b><label></label></div>
		<li><label><i>*</i>理赔类型</label>
		<select name="lp_type">
		 <option value="航班延误">航班延误</option>
		</select>
       </li>
		<li><label><i>*</i>发生时间</label><div class="w_fcx_xs_in"><em class="w_em_1"></em><input type="text" name="fs_time" value="" validate=" required:true" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})" /></div></li>
		<li><label><i>*</i>航班号</label><div class="w_fcx_xs_in"><input type="text" name="hbh" value=""/></div></li>
		<li><label><i>*</i>延误原因</label><textarea name="reason"></textarea></li>
	   </ul>
	   <ul>
	    <div class="w_fcx_xs_d"><b><i></i>理赔款打款银行</b><label>请填写购买产品时填写的证件号</label></div>
		<li><label>开户人</label><div class="w_fcx_xs_in"><input type="text" name="account_name" value=""/></div></li>
		<li><label>开户银行</label><div class="w_fcx_xs_in"><em class="w_em_2"></em><input type="text" name="bank" value=""/></div></li>
		<li><label>银行账户</label><div class="w_fcx_xs_in"><input type="text" name="bank_account" value=""/></div></li>
        <input type="hidden" name="act" value="act_add_message" />
		<li><label>&nbsp;</label><input type="submit" class="w_butt1" value="提交申请" /></li>
	   </ul>
       </form>
	 </div>
	 </div>
	</div> 
</div>
<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>
</html>
