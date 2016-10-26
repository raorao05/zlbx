<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?php echo $this->_var['lang']['cp_home']; ?><?php if ($this->_var['ur_here']): ?> - <?php echo $this->_var['ur_here']; ?><?php endif; ?></title>
<link href="styles/home.css" rel="stylesheet" type="text/css" />
</head>
<body>

<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,validator.js')); ?>
<script language="JavaScript">
<!--
// 这里把JS用到的所有语言都赋值到这里
<?php $_from = $this->_var['lang']['js_languages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

if (window.parent != window)
{
  window.top.location.href = location.href;
}

//-->
</script>

<div class="box"></div>
<div class="login">
    <div class="loginbox">
    <form method="post" action="privilege.php" name='theForm' onsubmit="return validate()">
        <h6><a href="/"><img src="images/icon_back.gif" alt="返回" hspace="4" vspace="8" border="0"  /></a><a href="javascript:window.close()"><img src="images/icon_close.gif" alt="关闭" hspace="4" vspace="8" border="0"/></a></h6>
    
        <ul>
        <li><b><?php echo $this->_var['lang']['label_username']; ?></b><input type="text" name="username" id="username" class="ipt_login" /></li>
        <li><b><?php echo $this->_var['lang']['label_password']; ?></b><input type="password" name="password" id="password" class="ipt_login" /></li>
        
        
        <?php if ($this->_var['gd_version'] > 0): ?>
        <li><b><?php echo $this->_var['lang']['label_captcha']; ?></b><input name="captcha" size="5" type="text"/> <img src="index.php?act=captcha&<?php echo $this->_var['random']; ?>" alt="CAPTCHA" border="1" onclick= this.src="index.php?act=captcha&"+Math.random() style="cursor: pointer;" title="<?php echo $this->_var['lang']['click_for_another']; ?>" /></li>
        <?php endif; ?>
        
        
        <li><input type="submit" name="Submit" value=" " class="btn_login" /> <input type="reset" name="Submit" value=" " class="btn_set" /></li>
       
        </ul>
        <input type="hidden" name="act" value="signin" />
    </form>
    
    </div>
     <p style=" padding-top:20px;color:#FF0; text-align:center">*&nbsp; 为了保证系统的兼容性以及后台功能的完整性,强烈建议使用<b style="color:#F00">IE或者IE内核</b>的浏览器!</p>
</div>
<script language="JavaScript">
<!--
  document.forms['theForm'].elements['username'].focus();
  
  /**
   * 检查表单输入的内容
   */
  function validate()
  {
    var validator = new Validator('theForm');
    validator.required('username', user_name_empty);
    //validator.required('password', password_empty);
    if (document.forms['theForm'].elements['captcha'])
    {
      validator.required('captcha', captcha_empty);
    }
    return validator.passed();
  }
  
//-->
</script>
</body>
</html>