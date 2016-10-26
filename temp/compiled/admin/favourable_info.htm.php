<!-- $Id: favourable_info.htm 14361 2008-04-07 09:26:17Z zhuwenyuan $ -->
<?php echo $this->fetch('pageheader.htm'); ?>
<script type="text/javascript" src="../js/calendar.php?lang=<?php echo $this->_var['cfg_lang']; ?>"></script>
<link href="../js/calendar/calendar.css" rel="stylesheet" type="text/css" />
<?php echo $this->smarty_insert_scripts(array('files'=>'validator.js,../js/transport.org.js')); ?>
<div class="main-div">
<form method="post" action="favourable.php" name="theForm" enctype="multipart/form-data" onSubmit="return validate()">
<table cellspacing="1" cellpadding="3" width="100%">
  <tr>
    <td class="label"><?php echo $this->_var['lang']['label_act_name']; ?></td>
    <td><input name="act_name" type="text" id="act_name" value="<?php echo $this->_var['favourable']['act_name']; ?>" size="40" /></td>
  </tr>
  <tr>
    <td class="label"><?php echo $this->_var['lang']['label_start_time']; ?></td>
    <td><input name="start_time" type="text" id="start_time" value="<?php echo $this->_var['favourable']['start_time']; ?>" readonly="readonly" />
        <input name="selbtn1" type="button" id="selbtn1" onclick="return showCalendar('start_time', '%Y-%m-%d %H:%M', '24', false, 'selbtn1');" value="<?php echo $this->_var['lang']['btn_select']; ?>" class="button" /></td>
  </tr>
  <tr>
    <td class="label"><?php echo $this->_var['lang']['label_end_time']; ?></td>
    <td><input name="end_time" type="text" id="end_time" value="<?php echo $this->_var['favourable']['end_time']; ?>" readonly="readonly" />
        <input name="selbtn2" type="button" id="selbtn2" onclick="return showCalendar('end_time', '%Y-%m-%d %H:%M', '24', false, 'selbtn2');" value="<?php echo $this->_var['lang']['btn_select']; ?>" class="button" /></td>
  </tr>
  <tr>
    <td class="label"><?php echo $this->_var['lang']['label_user_rank']; ?></td>
    <td><?php $_from = $this->_var['user_rank_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'user_rank');if (count($_from)):
    foreach ($_from AS $this->_var['user_rank']):
?><input type="checkbox" name="user_rank[]" value="<?php echo $this->_var['user_rank']['rank_id']; ?>" <?php if ($this->_var['user_rank']['checked']): ?>checked="true"<?php endif; ?> /><?php echo $this->_var['user_rank']['rank_name']; ?> <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?></td>
  </tr>
  <tr>
    <td class="label"><?php echo $this->_var['lang']['label_act_range']; ?></td>
    <td><select name="act_range" onchange="changeRange(this.value)">
          <option value="0" selected="selected" <?php if ($this->_var['favourable']['act_range'] == 0): ?>selected="selected"<?php endif; ?>><?php echo $this->_var['lang']['far_all']; ?></option>
          <option value="1" <?php if ($this->_var['favourable']['act_range'] == 1): ?>selected="selected"<?php endif; ?>><?php echo $this->_var['lang']['far_category']; ?></option>
          <option value="2" <?php if ($this->_var['favourable']['act_range'] == 2): ?>selected="selected"<?php endif; ?>><?php echo $this->_var['lang']['far_brand']; ?></option>
          <option value="3" <?php if ($this->_var['favourable']['act_range'] == 3): ?>selected="selected"<?php endif; ?>><?php echo $this->_var['lang']['far_goods']; ?></option>
        </select>
      <div id="range-div"><?php $_from = $this->_var['act_range_ext']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?><input name="act_range_ext[]" type="checkbox" value="<?php echo $this->_var['item']['id']; ?>" checked="checked" /><?php echo $this->_var['item']['name']; ?> <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?></div></td>
  </tr>
  <tr id="range_search"<?php if ($this->_var['favourable']['act_range'] == 0): ?> style="display:none"<?php endif; ?>>
    <td align="right"><?php echo $this->_var['lang']['label_search_and_add']; ?></td>
    <td><input name="keyword" type="text" id="keyword">
      <input name="search" type="button" id="search" value="<?php echo $this->_var['lang']['button_search']; ?>" class="button" onclick="searchItem()" />
      <select name="result" id="result">
      </select> <input type="button" name="add_range" value="+" class="button" onclick="addRange()" />
      </a></td>
  </tr>
  <tr>
    <td class="label"><?php echo $this->_var['lang']['label_min_amount']; ?></td>
    <td><input name="min_amount" type="text" id="min_amount" value="<?php echo $this->_var['favourable']['min_amount']; ?>"></td>
  </tr>
  <tr>
    <td class="label"><?php echo $this->_var['lang']['label_max_amount']; ?></td>
    <td><input name="max_amount" type="text" id="max_amount" value="<?php echo $this->_var['favourable']['max_amount']; ?>">
    <?php echo $this->_var['lang']['notice_max_amount']; ?></td>
  </tr>
  <tr>
    <td class="label"><a href="javascript:showNotice('NoticeActType');" title="<?php echo $this->_var['lang']['form_notice']; ?>">
        <img src="images/notice.gif" width="16" height="16" border="0" alt="<?php echo $this->_var['lang']['form_notice']; ?>"></a><?php echo $this->_var['lang']['label_act_type']; ?></td>
    <td><select name="act_type" id="act_type" onchange="changeType(this.value)">
      <option value="0" <?php if ($this->_var['favourable']['act_type'] == 0): ?>selected="selected"<?php endif; ?>><?php echo $this->_var['lang']['fat_goods']; ?></option>
      <option value="1" <?php if ($this->_var['favourable']['act_type'] == 1): ?>selected="selected"<?php endif; ?>><?php echo $this->_var['lang']['fat_price']; ?></option>
      <option value="2" <?php if ($this->_var['favourable']['act_type'] == 2): ?>selected="selected"<?php endif; ?>><?php echo $this->_var['lang']['fat_discount']; ?></option>
      </select>
      <input name="act_type_ext" type="text" id="act_type_ext" value="<?php echo $this->_var['favourable']['act_type_ext']; ?>" size="10" />
      <br />
      <span class="notice-span" <?php if ($this->_var['help_open']): ?>style="display:block" <?php else: ?> style="display:none" <?php endif; ?> id="NoticeActType"><?php echo $this->_var['lang']['notice_act_type']; ?></span>
      <div id="gift-div" style="width:60%">
      <table id="gift-table">
      <?php if ($this->_var['favourable']['gift']): ?>
        <tr align="center"><td><strong><?php echo $this->_var['lang']['js_languages']['gift']; ?></strong></td><td><strong><?php echo $this->_var['lang']['js_languages']['price']; ?></strong></td></tr>
        <?php $_from = $this->_var['favourable']['gift']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['goods']):
?>
        <tr><td><input type="checkbox" name="gift_id[<?php echo $this->_var['key']; ?>]" value="<?php echo $this->_var['goods']['id']; ?>" checked="checked" /><?php echo $this->_var['goods']['name']; ?></td>
        <td align="right"><input name="gift_price[<?php echo $this->_var['key']; ?>]" type="text" value="<?php echo $this->_var['goods']['price']; ?>" size="10" style="text-align:right" />
        <input name="gift_name[<?php echo $this->_var['key']; ?>]" type="hidden" value="<?php echo $this->_var['goods']['name']; ?>" /></td></tr>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      <?php endif; ?>
      </table>
    </div></td>
  </tr>
  <tr id="type_search"<?php if ($this->_var['favourable']['act_type'] != 0): ?> style="display:none"<?php endif; ?>>
    <td align="right"><?php echo $this->_var['lang']['label_search_and_add_gift']; ?></td>
    <td><input name="keyword1" type="text" id="keyword1" />
      <input name="search1" type="button" id="search1" value="<?php echo $this->_var['lang']['button_search']; ?>" class="button" onclick="searchItem1()" />
        <select name="result1" id="result1">
                </select>
        <input name="add_gift" type="button" class="button" id="add_gift" onclick="addGift()" value="+" />
      </a></td>
  </tr>
  <tr>
    <td colspan="2" align="center">
      <input type="submit" class="button" value="<?php echo $this->_var['lang']['button_submit']; ?>" />
      <input type="reset" class="button" value="<?php echo $this->_var['lang']['button_reset']; ?>" />
      <input type="hidden" name="act" value="<?php echo $this->_var['form_action']; ?>" />
      <input type="hidden" name="id" value="<?php echo $this->_var['favourable']['act_id']; ?>" />    </td>
  </tr>
</table>
</form>
</div>


<script language="JavaScript">
<!--
onload = function()
{
    // ��ʼ��鶩��
    startCheckOrder();
//    changeRange(document.forms['theForm'].elements['act_range'].value);
//    changeType(document.forms['theForm'].elements['act_type'].value);
}
/**
 * �������������
 */
function validate()
{
    validator = new Validator("theForm");
    validator.required('act_name', act_name_not_null);
    validator.isNumber('min_amount', min_amount_not_number, true);
    validator.isNumber('max_amount', max_amount_not_number, true);
    validator.isNumber('act_type_ext', act_type_ext_not_number, true);
    validator.islt('start_time', 'end_time', start_lt_end);
    if (document.forms['theForm'].elements['max_amount'].value > 0)
    {
      validator.gt('max_amount', 'min_amount', amount_invalid);
    }

    return validator.passed();
}

function searchItem()
{
  var filter = new Object;
  filter.keyword  = document.forms['theForm'].elements['keyword'].value;
  filter.act_range = document.forms['theForm'].elements['act_range'].value;
  if (filter.act_range == 0)
  {
    alert(all_need_not_search);
    return;
  }

  Ajax.call('favourable.php?is_ajax=1&act=search', filter, searchResponse, 'GET', 'JSON');
}

function searchResponse(result)
{
  if (result.error == '1' && result.message != '')
  {
    alert(result.message);
	return;
  }

  var sel = document.forms['theForm'].elements['result'];

  sel.length = 0;

  /* ���� options */
  var goods = result.content;
  if (goods)
  {
    for (i = 0; i < goods.length; i++)
    {
      var opt = document.createElement("OPTION");
      opt.value = goods[i].id;
      opt.text  = goods[i].name;
      sel.options.add(opt);
    }
  }

  return;
}

/**
 * �ı��Żݷ�Χ
 * @param int rangeId
 */
function changeRange(rangeId)
{
  document.getElementById('range-div').innerHTML = '';
  document.getElementById('result').length = 0;
  var row = document.getElementById('range_search');
  if (rangeId <= 0)
  {
    row.style.display = 'none';
  }
  else
  {
    row.style.display = '';
  }
}

function addRange()
{
  var selRange = document.forms['theForm'].elements['act_range'];
  if (selRange.value == 0)
  {
    alert(all_need_not_search);
    return;
  }
  var selResult = document.getElementById('result');
  if (selResult.value == 0)
  {
    alert(pls_search);
    return;
  }
  var id = selResult.options[selResult.selectedIndex].value;
  var name = selResult.options[selResult.selectedIndex].text;

  // ����Ƿ��Ѿ�����
  var exists = false;
  var eles = document.forms['theForm'].elements;
  for (var i = 0; i < eles.length; i++)
  {
    if (eles[i].type=="checkbox" && eles[i].name.substr(0, 13) == 'act_range_ext')
    {
      if (eles[i].value == id)
      {
        exists = true;
        alert(range_exists);
        break;
      }
    }
  }

  // ����checkbox
  if (!exists)
  {
    var html = '<input name="act_range_ext[]" type="checkbox" value="' + id + '" checked="checked" />' + name + '<br />';
    document.getElementById('range-div').innerHTML += html;
  }
}

/**
 * ������Ʒ
 */
function searchItem1()
{
  if (document.forms['theForm'].elements['act_type'].value == 1)
  {
    alert(price_need_not_search);
    return;
  }
  var filter = new Object;
  filter.keyword  = document.forms['theForm'].elements['keyword1'].value;
  filter.act_range = 3;
  Ajax.call('favourable.php?is_ajax=1&act=search', filter, searchResponse1, 'GET', 'JSON');
}

function searchResponse1(result)
{
  if (result.error == '1' && result.message != '')
  {
    alert(result.message);
	return;
  }

  var sel = document.forms['theForm'].elements['result1'];

  sel.length = 0;

  /* ���� options */
  var goods = result.content;
  if (goods)
  {
    for (i = 0; i < goods.length; i++)
    {
      var opt = document.createElement("OPTION");
      opt.value = goods[i].id;
      opt.text  = goods[i].name;
      sel.options.add(opt);
    }
  }

  return;
}

function addGift()
{
  var selType = document.forms['theForm'].elements['act_type'];
  if (selType.value == 1)
  {
    alert(price_need_not_search);
    return;
  }
  var selResult = document.getElementById('result1');
  if (selResult.value == 0)
  {
    alert(pls_search);
    return;
  }
  var id = selResult.options[selResult.selectedIndex].value;
  var name = selResult.options[selResult.selectedIndex].text;

  // ����Ƿ��Ѿ�����
  var exists = false;
  var eles = document.forms['theForm'].elements;
  for (var i = 0; i < eles.length; i++)
  {
    if (eles[i].type=="checkbox" && eles[i].name.substr(0, 7) == 'gift_id')
    {
      if (eles[i].value == id)
      {
        exists = true;
        alert(range_exists);
        break;
      }
    }
  }

  // ����checkbox
  if (!exists)
  {
    var table = document.getElementById('gift-table');
    if (table.rows.length == 0)
    {
        var row = table.insertRow(-1);
        var cell = row.insertCell(-1);
        cell.align = 'center';
        cell.innerHTML = '<strong>' + gift + '</strong>';
        var cell = row.insertCell(-1);
        cell.align = 'center';
        cell.innerHTML = '<strong>' + price + '</strong>';
    }
    var row = table.insertRow(-1);
    var cell = row.insertCell(-1);
    cell.innerHTML = '<input name="gift_id[]" type="checkbox" value="' + id + '" checked="checked" />' + name;
    var cell = row.insertCell(-1);
    cell.align = 'right';
    cell.innerHTML = '<input name="gift_price[]" type="text" value="0" size="10" style="text-align:right" />' +
                     '<input name="gift_name[]" type="hidden" value="' + name + '" />';
  }
}

function changeType(typeId)
{
  document.getElementById('gift-div').innerHTML = '<table id="gift-table"></table>';
  document.getElementById('result1').length = 0;
  var row = document.getElementById('type_search');
  if (typeId <= 0)
  {
    row.style.display = '';
  }
  else
  {
    row.style.display = 'none';
  }
}

//-->
</script>

<?php echo $this->fetch('pagefooter.htm'); ?>
