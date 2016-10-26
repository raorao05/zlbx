<!-- $Id: link_info.htm 16752 2009-10-20 09:59:38Z wangleisvn $ -->
<?php echo $this->fetch('pageheader.htm'); ?>
<div class="main-div">
<form action="friend_link.php" method="post" name="theForm" enctype="multipart/form-data" onsubmit="return validate()">
<table width="100%" id="general-table">
  <tr>
    <td class="label"><a href="javascript:showNotice('LogoNameNotic');" title="<?php echo $this->_var['lang']['form_notice']; ?>">
      <img src="images/notice.gif" width="16" height="16" border="0" alt="<?php echo $this->_var['lang']['form_notice']; ?>"></a><?php echo $this->_var['lang']['link_name']; ?></td>
    <td>
      <input type="text" name="link_name" value="<?php echo htmlspecialchars($this->_var['link_arr']['link_name']); ?>" size="30"  />
      <br /><span class="notice-span" <?php if ($this->_var['help_open']): ?>style="display:block" <?php else: ?> style="display:none" <?php endif; ?> id="LogoNameNotic"><?php echo $this->_var['lang']['link_name_desc']; ?></span>
    </td>
  </tr>
  <tr>
    <td class="label"><?php echo $this->_var['lang']['link_url']; ?></td>
    <td>
      <input type='text' name='link_url' value='<?php echo $this->_var['link_arr']['link_url']; ?>' size="30"  />
    </td>
  </tr>
  <tr>
    <td class="label"><?php echo $this->_var['lang']['show_order']; ?></td>
    <td>
      <input type='text' name='show_order' <?php if ($this->_var['link_arr']['show_order']): ?> value="<?php echo $this->_var['link_arr']['show_order']; ?>" <?php else: ?> value="50" <?php endif; ?> size="30"  />
    </td>
  </tr>
<?php if ($this->_var['action'] == "add"): ?>
  <tr>
    <td class="label"><?php echo $this->_var['lang']['link_logo']; ?></td>
    <td>
      <input type='file' name='link_img' size="35" />
    </td>
  </tr>
  <tr>
    <td class="label"><a href="javascript:showNotice('LogoUrlNotic');" title="<?php echo $this->_var['lang']['form_notice']; ?>">
        <img src="images/notice.gif" width="16" height="16" border="0" alt="<?php echo $this->_var['lang']['form_notice']; ?>"></a><?php echo $this->_var['lang']['url_logo']; ?></td>
    <td>
      <input type='text' name='url_logo' size="42"  />
      <br /><span class="notice-span" <?php if ($this->_var['help_open']): ?>style="display:block" <?php else: ?> style="display:none" <?php endif; ?> id="LogoUrlNotic"><?php echo $this->_var['lang']['url_logo_value']; ?></span>
    </td>
  </tr>
 <?php endif; ?>
 <?php if ($this->_var['action'] == "edit"): ?>
    <tr>
      <td class="label"><?php echo $this->_var['lang']['link_logo']; ?></td>
      <td>
        <input type='file' name='link_img' size="35" />
      </td>
    </tr>
    <tr>
      <td class="label"><a href="javascript:showNotice('LogoUrlNotic');" title="<?php echo $this->_var['lang']['form_notice']; ?>">
        <img src="images/notice.gif" width="16" height="16" border="0" alt="<?php echo $this->_var['lang']['form_notice']; ?>"></a><?php echo $this->_var['lang']['url_logo']; ?></td>
      <td>
        <input type='text' name='url_logo' value="<?php echo $this->_var['link_logo']; ?>" size="42"  />
        <br /><span class="notice-span" <?php if ($this->_var['help_open']): ?>style="display:block" <?php else: ?> style="display:none" <?php endif; ?> id="LogoUrlNotic"><?php echo $this->_var['lang']['url_logo_value']; ?></span>
      </td>
    </tr>
 <?php endif; ?>
  <tr>
    <td class="label">&nbsp;</td>
    <td>
      <input type="submit" value="<?php echo $this->_var['lang']['button_submit']; ?>" class="button" />
      <input type="reset" value="<?php echo $this->_var['lang']['button_reset']; ?>" class="button" />
      <input type="hidden" name="act" value="<?php echo $this->_var['form_act']; ?>" />
      <input type="hidden" name="id" value="<?php echo $this->_var['link_arr']['link_id']; ?>" />
      <input type="hidden" name="type" value="<?php echo $this->_var['type']; ?>" />
    </td>
  </tr>
</table>
</form>
</div>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,validator.js')); ?>
<script language="JavaScript">
<!--


/**
 * 检查表单输入的数据
 */
function validate()
{
    validator = new Validator("theForm");
    validator.required("link_name",      link_name_empty);
    validator.required("link_url",       link_url_empty);
    validator.isNumber("show_order",     show_order_type);
    return validator.passed();
}

onload = function()
{
    // 开始检查订单
    startCheckOrder();
}

//-->
</script>
<?php echo $this->fetch('pagefooter.htm'); ?>