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

<?php echo $this->smarty_insert_scripts(array('files'=>'jquery.js,jquery.json-2.4.min.js')); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'common.js,global.js,compare.js')); ?>
	<?php echo $this->smarty_insert_scripts(array('files'=>'transport.js,region.js')); ?>
	<?php echo $this->smarty_insert_scripts(array('files'=>'index.js')); ?>
<script src="/js/MyDate/WdatePicker.js"></script>
<script>
function handlePromote(checked)
{
   document.forms['theForm'].elements['cp_number'].disabled = checked;
}
function check(zhi,id,msg){
	if(!zhi){
		document.getElementById(id).className = "w_bgt";
		document.getElementById(id).innerHTML = "<i></i>"+msg;
	}else{
		document.getElementById(id).className = "w_tgt";
		document.getElementById(id).innerHTML = "<i></i>";
	}
}
function g(element){return document.getElementById(element);}
function tijiao(){
	if(!g("cp_number").value && !g('wsp').checked){alert("请填写车牌号或者勾选新车未上牌！");return false;}
	if(!g("dj_time").value){alert("日期不能为空！");return false;}
	if(!g("cz_name").value){alert("车主姓名不能为空！");return false;}
	if(!g("sfz_number").value){alert("身份证号不能为空！");return false;}
	if(!g("mobile").value){alert("手机号不能为空！");return false;}
	if(!g("frame_number").value){alert("车架号不能为空！");return false;}
	if(!g("engine_number").value){alert("发动机号不能为空！");return false;}
	if(!g("brand").value){alert("品牌型号不能为空！");return false;}
	if(!g("configure").value){alert("配置型号不能为空！");return false;}
	return true;
}
</script>
</head>
<body>
<?php echo $this->fetch('library/page_header.lbi'); ?>
<div class="w_center">
    <div class="w_cxjbx_n">
	 <div class="w_cxjbx_n1">
	  <img src="/images/w_cxjb_h1.jpg" title="基本信息" alt="基本信息"/>
	 </div>
	 <div class="w_cxjbx_n2">
	   <h2>用户基本信息<i>（必填）</i></h2>
	   <form action="flow.php" method="post" name="theForm" onsubmit="return tijiao();">
       <ul class="w_cxjbx_n2_u">
	     <li>
		 <label><i>*</i>城市：</label>
		 <!--<select name="c_city">
		   &lt;!&ndash;<?php $_from = $this->_var['region_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'region');if (count($_from)):
    foreach ($_from AS $this->_var['region']):
?>&ndash;&gt;
           <option value="<?php echo $this->_var['region']; ?>" <?php if ($this->_var['region'] == $this->_var['city']): ?>selected="selected"<?php endif; ?>><?php echo $this->_var['region']; ?></option>
		   &lt;!&ndash;<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>&ndash;&gt;
		 </select>-->
			 <select name="province" id="selProvinces" onchange="region.changed(this, 2, 'selCities')">
				 <option value="0">请选择省</option>
				 <?php $_from = $this->_var['province']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'pro');if (count($_from)):
    foreach ($_from AS $this->_var['pro']):
?>
				 <option value="<?php echo $this->_var['pro']['region_id']; ?>" <?php if ($this->_var['pro_id'] == $this->_var['pro'] [ 'region_id' ]): ?>selected="selected"<?php endif; ?>><?php echo $this->_var['pro']['region_name']; ?></option>
				 <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			 </select>
			 <select name="c_city" id="selCities" onchange="region.changed(this, 3, 'selDistricts')">
				 <option value="0">请选择市</option>
				 <?php $_from = $this->_var['city']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'ci');if (count($_from)):
    foreach ($_from AS $this->_var['ci']):
?>
				 <option value="<?php echo $this->_var['ci']['region_id']; ?>" <?php if ($this->_var['reg_id'] == $this->_var['ci'] [ 'region_id' ]): ?>selected="selected"<?php endif; ?>><?php echo $this->_var['ci']['region_name']; ?></option>
				 <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			 </select>
		 </li>
		 <li><label><i>*</i>车牌号：</label><input type="text" name="cp_number" id="cp_number" class="w_cxjb_in1"/></li>
		 <li><label>&nbsp;</label><input type="checkbox" id="wsp" onclick="handlePromote(this.checked);" /><em><label>新车未上牌</label></em></li>
		 <li>
		 <label><i>*</i>登记日期：</label>
		  <input type="text" name="dj_time" id="dj_time" value="" validate=" required:true" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" onblur="check(this.value,'cx_dj_time','日期不能为空')" class="w_cxjb_in1" />
		 <span class="" id="cx_dj_time"><i></i></span>
         </li>
		 <li><label><i>*</i>车主姓名：</label><input type="text" name="cz_name" id="cz_name" onblur="check(this.value,'cx_cz_name','车主姓名不能为空')" class="w_cxjb_in1"/>
         <span class="" id="cx_cz_name"><i></i></span>
		 <li><label><i>*</i>身份证号：</label><input type="text" name="sfz_number" id="sfz_number" onblur="check(this.value,'cx_sfz_number','身份证号不能为空')" class="w_cxjb_in1"/>
         <span class="" id="cx_sfz_number"><i></i></span></li>
		 <li><label><i>*</i>手机号：</label><input type="text" name="mobile" id="mobile" onblur="check(this.value,'cx_mobile','手机号不能为空')" class="w_cxjb_in1"/>
         <span class="" id="cx_mobile"><i></i></span></li>
		 <li><label><i>*</i>车架号：</label><input type="text" name="frame_number" id="frame_number" onblur="check(this.value,'cx_frame_number','车架号不能为空')" class="w_cxjb_in1"/>
         <span class="" id="cx_frame_number"><i></i></span></li>
		 <li><label><i>*</i>发动机号：</label><input type="text" name="engine_number" id="engine_number" onblur="check(this.value,'cx_engine_number','发动机号不能为空')" class="w_cxjb_in1"/>
         <span class="" id="cx_engine_number"><i></i></span></li>
		 <li><label><i>*</i>品牌型号：</label><input type="text" name="brand" id="brand" onblur="check(this.value,'cx_brand','品牌型号不能为空')" class="w_cxjb_in1"/>
         <span class="" id="cx_brand"><i></i></span></li>
		 <li><label><i>*</i>配置型号：</label><input type="text" name="configure" id="configure" onblur="check(this.value,'cx_configure','配置型号不能为空')" class="w_cxjb_in1"/>
         <span class="" id="cx_configure"><i></i></span></li>
		 <li><label><i>*</i>过户车：</label><em style="margin-top:10px;"><input type="radio" name="is_transfer" checked="checked" value="0" /><em><label>否</label></em>
         <input type="radio" name="is_transfer" value="1" /><em><label>是</label></em></em></li>
		 <li><label>&nbsp;</label><input type="submit" value="下一步" class="w_cxjb_in2"/></li>
         <input type="hidden" name="cat_id" value="<?php echo $this->_var['category']; ?>" />
         <input type="hidden" name="step" value="cx_insure_cl" />
	   </ul>
       </form>
	   <div class="w_cxjbx_n2_d">
	     <b>说明</b>
		 <p>·<i>纯进口</i>车请使用"品牌+系列"填写，例如"宝马740 Li"</p>
		 <p>·<i>国产车或合资车</i>请按行驶证填写，如下图：</p>
		 <p><img src="/images/w_cxhb_1.jpg" title="" alt=""/></p>
	   </div>
	 </div>
	</div>
  </div>
<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>
</html>
