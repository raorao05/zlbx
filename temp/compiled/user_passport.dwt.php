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

<?php echo $this->smarty_insert_scripts(array('files'=>'common.js,user.js,transport.js')); ?>
</head>
<body>
<?php echo $this->fetch('library/page_header.lbi'); ?>

<div class="w_dl_bd"> 

<?php if ($this->_var['action'] == 'login'): ?>
<div class="w_dl_c">
	  <h2>登录</h2>
	  <div class="w_dl_1">
		  <img src="/images/w-dl_t.jpg" title="登录" alt="登录" />
		  <ul>
          <form name="formLogin" action="user.php" method="post" onSubmit="return userLogin()">
		    <li>
			 <label>登录名</label><input type="text" name="username" class="w_dl_in1"/>
			</li>
			<li>
			 <label>密码</label><input type="password" name="password" class="w_dl_in1"/>
			 <div class="w_dl_wh"><a href="user.php?act=get_password" title="忘记密码">忘记密码？</a></div>
			</li>
			<li>
			 <label>&nbsp;</label><input type="submit" value="登录" class="w_dl_in2"/>
			</li>
			<li>
			 <label>&nbsp;</label>还不是中联会员？<a href="user.php?act=register" title="免费注册" class="w_mfzc">免费注册></a>
			</li>
            <input type="hidden" name="act" value="act_login" />
            <input type="hidden" name="back_act" value="<?php echo $this->_var['back_act']; ?>" />
		  </form>
          </ul>
	</div>
</div>
<?php endif; ?>



    <?php if ($this->_var['action'] == 'register'): ?>
    <?php if ($this->_var['shop_reg_closed'] == 1): ?>
    <div class="usBox">
      <div class="usBox_2 clearfix">
        <div class="f1 f5" align="center"><?php echo $this->_var['lang']['shop_register_closed']; ?></div>
      </div>
    </div>
    <?php else: ?>
<script type="text/javascript">
function g(element){return document.getElementById(element);}
function ksmssend(){
	if(!g('mobile').value){
		alert('手机号码不能为空！');
		return false;
	}
	Ajax.call('user.php?act=sendsms_zc', 'mobile='+g('mobile').value, getksms, 'POST', 'JSON');
}
function getksms(data){
	alert(data.content);
	if(data.error == 1){
		countdesc(120);
	}
}
function countdesc(num){
	if(num<=0){
		g("sendsms").onclick= function(){ 
			ksmssend();
		}; 
		g("sendsms").innerHTML='重新发送信息';
	}else{
		num=num-1;
		g("sendsms").onclick=null;
		g("sendsms").innerHTML="("+num+")秒后重发";
		setTimeout('countdesc('+num+')',1000);
	}
}
function yz_username(){
	var usename=g("username").value;
	if(usename.length < 6 ){
		$('#yz_username').html("用户名不能少于6位数！");
	}else{
		Ajax.call('user.php?act=yz_username', 'username='+g('username').value, yz_return, 'POST');
	}
}
function yz_return(msg){
	$('#yz_username').html(msg);
}
function lx_type(){
	var lx=g('lx').value;
	if(lx == '1'){
		g('lx_sfz').style.display='';
	}else{
		g('lx_sfz').style.display='none';
	}
}
</script>
    <?php echo $this->smarty_insert_scripts(array('files'=>'utils.js')); ?>
    <div class="w_dl_c">
	     <h2>注册</h2>
		  <div class="w_dl_1 w_zc_li">
		   <img src="/images/w-dl_t.jpg" title="注册" alt="注册" />
		   <ul>
           <form action="user.php" method="post" name="formUser" enctype="multipart/form-data" onsubmit="return register();">
		     <li>
			  <label>注册类型</label>
              <select id="lx" class="w_dl_in1" onchange="lx_type();">
                <option value="0">普通用户</option>
                <option value="1">代理人</option>
             </select>
			 </li>
             <div id="lx_sfz" style="display:none;">
             <li>
			  <label style="width:115px;">上传身份证照片</label><input type="file" name="sfz_pic" id="sfz_pic" class="w_dl_in1" />
			 </li>
             </div>
             <li>
			  <label>登录名</label><input type="text" name="username" id="username" class="w_dl_in1" onblur="yz_username();" />
			  <p id="yz_username"></p>
			 </li>
			  <li>
			  <label>手机</label><input type="text" name="mobile" id="mobile" class="w_dl_in1"/>
			  <div class="w_hqyzm"><a onclick="ksmssend();" title="获取验证码" id="sendsms">获取验证码</a></div>
			 </li>
			 <li>
			  <label>验证码</label><input type="text" name="yzm" class="w_dl_in1"/>
			 </li>
			 <li>
			  <label>密码</label><input type="text" name="password" class="w_dl_in1"/>
			 </li>
			 
			 <li>
			  <label>确认密码</label><input type="text" name="confirm_password" class="w_dl_in1"/>
			 </li>
			 <li>
			 <p><a href="article.php?cat_id=-1" title="查看中联用户协议>>">查看中联用户协议>>></a></p>
			  <label>&nbsp;</label><input type="Submit" value="同意协议并注册" class="w_dl_in2"/>
			 </li>
             <input name="act" type="hidden" value="act_register" >
             <input type="hidden" name="back_act" value="<?php echo $this->_var['back_act']; ?>" />
           </form>
		   </ul>
		  </div>
	 </div>
<?php endif; ?>
<?php endif; ?>



    <?php if ($this->_var['action'] == 'get_password'): ?>
    <?php echo $this->smarty_insert_scripts(array('files'=>'utils.js')); ?>
    <script type="text/javascript">
    <?php $_from = $this->_var['lang']['password_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
      var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </script>
    <div class="w_dl_c">
	  <h2>找回密码</h2>
	  <div class="w_dl_1">
		  <img src="/images/w-dl_t.jpg" title="登录" alt="登录" />
		  <ul>
          <form action="user.php" method="post" name="getPassword" onsubmit="return submitPwdInfo();">
		    <li>
			 <label>用户名</label><input type="text" name="user_name" class="w_dl_in1"/>
			</li>
			<li>
			 <label>邮箱地址</label><input type="text" name="email" class="w_dl_in1"/>
			</li>
			<li>
			 <label>&nbsp;</label><input type="submit" value="确定" class="w_dl_in2"/>
			</li>
            <input type="hidden" name="act" value="send_pwd_email" />
		  </form>
          </ul>
        </div>
    </div>
<?php endif; ?>


    <?php if ($this->_var['action'] == 'qpassword_name'): ?>
<div class="usBox">
  <div class="usBox_2 clearfix">
    <form action="user.php" method="post">
        <br />
        <table width="70%" border="0" align="center">
          <tr>
            <td colspan="2" align="center"><strong><?php echo $this->_var['lang']['get_question_username']; ?></strong></td>
          </tr>
          <tr>
            <td width="29%" align="right"><?php echo $this->_var['lang']['username']; ?></td>
            <td width="61%"><input name="user_name" type="text" size="30" class="inputBg" /></td>
          </tr>
          <tr>
            <td></td>
            <td><input type="hidden" name="act" value="get_passwd_question" />
              <input type="submit" name="submit" value="<?php echo $this->_var['lang']['submit']; ?>" class="bnt_blue" style="border:none;" />
              <input name="button" type="button" onclick="history.back()" value="<?php echo $this->_var['lang']['back_page_up']; ?>" style="border:none;" class="bnt_blue_1" />
	    </td>
          </tr>
        </table>
        <br />
      </form>
  </div>
</div>
<?php endif; ?>


    <?php if ($this->_var['action'] == 'get_passwd_question'): ?>
<div class="usBox">
  <div class="usBox_2 clearfix">
    <form action="user.php" method="post">
        <br />
        <table width="70%" border="0" align="center">
          <tr>
            <td colspan="2" align="center"><strong><?php echo $this->_var['lang']['input_answer']; ?></strong></td>
          </tr>
          <tr>
            <td width="29%" align="right"><?php echo $this->_var['lang']['passwd_question']; ?>：</td>
            <td width="61%"><?php echo $this->_var['passwd_question']; ?></td>
          </tr>
          <tr>
            <td align="right"><?php echo $this->_var['lang']['passwd_answer']; ?>：</td>
            <td><input name="passwd_answer" type="text" size="20" class="inputBg" /></td>
          </tr>
          <?php if ($this->_var['enabled_captcha']): ?>
          <tr>
            <td align="right"><?php echo $this->_var['lang']['comment_captcha']; ?></td>
            <td><input type="text" size="8" name="captcha" class="inputBg" />
            <img src="captcha.php?is_login=1&<?php echo $this->_var['rand']; ?>" alt="captcha" style="vertical-align: middle;cursor: pointer;" onClick="this.src='captcha.php?is_login=1&'+Math.random()" /> </td>
          </tr>
          <?php endif; ?>
          <tr>
            <td></td>
            <td><input type="hidden" name="act" value="check_answer" />
              <input type="submit" name="submit" value="<?php echo $this->_var['lang']['submit']; ?>" class="bnt_blue" style="border:none;" />
              <input name="button" type="button" onclick="history.back()" value="<?php echo $this->_var['lang']['back_page_up']; ?>" style="border:none;" class="bnt_blue_1" />
	    </td>
          </tr>
        </table>
        <br />
      </form>
  </div>
</div>
<?php endif; ?>

<?php if ($this->_var['action'] == 'reset_password'): ?>
    <script type="text/javascript">
    <?php $_from = $this->_var['lang']['password_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
      var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </script>
    <div class="w_dl_c">
	  <h2>找回密码</h2>
	  <div class="w_dl_1">
		  <img src="/images/w-dl_t.jpg" title="找回密码" alt="找回密码" />
		  <ul>
          <form action="user.php" method="post" name="getPassword2" onSubmit="return submitPwd()">
		    <li>
			 <label>新密码</label><input type="password" name="new_password" class="w_dl_in1"/>
			</li>
			<li>
			 <label>确认新密码</label><input type="password" name="confirm_password" class="w_dl_in1"/>
			</li>
			<li>
			 <label>&nbsp;</label><input type="submit" value="确定" class="w_dl_in2"/>
			</li>
            <input type="hidden" name="act" value="act_edit_password" />
            <input type="hidden" name="uid" value="<?php echo $this->_var['uid']; ?>" />
            <input type="hidden" name="code" value="<?php echo $this->_var['code']; ?>" />
		  </form>
          </ul>
        </div>
    </div>
<!--<div class="usBox">
  <div class="usBox_2 clearfix">
    <form action="user.php" method="post" name="getPassword2" onSubmit="return submitPwd()">
      <br />
      <table width="80%" border="0" align="center">
        <tr>
          <td><?php echo $this->_var['lang']['new_password']; ?></td>
          <td><input name="new_password" type="password" size="25" class="inputBg" /></td>
        </tr>
        <tr>
          <td><?php echo $this->_var['lang']['confirm_password']; ?>:</td>
          <td><input name="confirm_password" type="password" size="25"  class="inputBg"/></td>
        </tr>
        <tr>
          <td colspan="2" align="center">
            <input type="hidden" name="act" value="act_edit_password" />
            <input type="hidden" name="uid" value="<?php echo $this->_var['uid']; ?>" />
            <input type="hidden" name="code" value="<?php echo $this->_var['code']; ?>" />
            <input type="submit" name="submit" value="<?php echo $this->_var['lang']['confirm_submit']; ?>" />
          </td>
        </tr>
      </table>
      <br />
    </form>
  </div>
</div>-->
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
</script>
</html>
