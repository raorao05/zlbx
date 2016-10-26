<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="Generator" content="LECAOLEJIA since 2013" />
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />

<title><?php echo $this->_var['page_title']; ?></title>
<link href="/css/w_css_1.css" type="text/css" rel="stylesheet" />
<link rel="stylesheet" href="/css/zlbx_pc.css" />
<script src="/js/jquery.min.js.js"></script>
<script src="/js/w_index.js"></script>
<script type="text/javascript" src="/js/tab.js"></script>
<script type='text/javascript' src='/js/webwidget_scroller_tab.js'></script>
<script type="text/javascript" src="/js/jquery.SuperSlide.2.1.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$(".div2").click(function(){ 
		$(this).next("div").slideToggle("slow")  
		.siblings(".div3:visible").slideUp("slow");
	});
	var $tab_li = $('#tab ul li');
	$tab_li.hover(function(){
		$(this).addClass('selected').siblings().removeClass('selected');
		var index = $tab_li.index(this);
		$('div.tab_box > div').eq(index).show().siblings().hide();
	});
});
</script>


<?php echo $this->smarty_insert_scripts(array('files'=>'common.js,user.js')); ?>
</head>
<body>
<?php echo $this->fetch('library/page_header.lbi'); ?>

<div class="w_dqwz">
    <?php echo $this->fetch('library/ur_here.lbi'); ?>
   </div>


<?php if ($this->_var['action'] != 'order_detail'): ?>
<div class="content_pc">
  
  <div class="left_pc">
   <div class="div1">
        <?php echo $this->fetch('library/user_menu.lbi'); ?>
    </div>
  </div>
  
  
<div class="right_pc">
<?php endif; ?>
         
         <?php if ($this->_var['action'] == 'profile'): ?>
         <?php echo $this->smarty_insert_scripts(array('files'=>'utils.js')); ?>
        <script type="text/javascript">
          <?php $_from = $this->_var['lang']['profile_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
            var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </script>
 <div class="right_pc">
    <div class="r_bt_pc">
       <span>��Ա����</span><em>Member information</em>
    </div>
    <div class="bdgl_xq">
<form name="formEdit" action="user.php" method="post" id="formEdit" enctype="multipart/form-data">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr class="bt_b">
    <td colspan="2"><strong>��������   �������Ƹ�����Ϣ</strong></td>
    </tr>
  <tr>
    <td width="23%" class="td_r" align="right" style=" text-align:right;">* ��Ա����</td>
    <td width="77%" class="td_l" style=" text-align:left;">���˻�Ա</td>
  </tr>
  <tr>
    <td class="td_r" align="right" style=" text-align:right;">* ����</td>
    <td class="td_l" style=" text-align:left;"><input class="text_ge" type="text" name="alias" id="alias" value="<?php echo $this->_var['profile']['alias']; ?>" /></td>
  </tr>
  <tr>
    <td class="td_r" align="right" style=" text-align:right;">* ֤������</td>
    <td class="td_l" style=" text-align:left;"><label for="select"></label>
      <select name="select" id="select">
        <option>���֤</option>
      </select></td>
  </tr>
  <tr>
    <td class="td_r" align="right" style=" text-align:right;">* ֤������</td>
    <td class="td_l" style=" text-align:left;"><input class="text_ge" type="text" name="zj_number" id="zj_number" value="<?php echo $this->_var['profile']['zj_number']; ?>" /></td>
  </tr>
  <tr>
    <td class="td_r" align="right" style=" text-align:right;">* �Ա�</td>
    <td class="td_l" style=" text-align:left;"><input type="radio" name="sex" value="0" <?php if ($this->_var['profile']['sex'] == 0): ?>checked="checked"<?php endif; ?> />
                    <?php echo $this->_var['lang']['secrecy']; ?>&nbsp;&nbsp;
                    <input type="radio" name="sex" value="1" <?php if ($this->_var['profile']['sex'] == 1): ?>checked="checked"<?php endif; ?> />
                    <?php echo $this->_var['lang']['male']; ?>&nbsp;&nbsp;
                    <input type="radio" name="sex" value="2" <?php if ($this->_var['profile']['sex'] == 2): ?>checked="checked"<?php endif; ?> />
                  <?php echo $this->_var['lang']['female']; ?>&nbsp;&nbsp; </td>
  </tr>
  <tr>
    <td class="td_r" align="right" style=" text-align:right;">* ��������</td>
    <td class="td_l" style=" text-align:left;"><?php echo $this->html_select_date(array('field_order'=>'YMD','prefix'=>'birthday','start_year'=>'-60','end_year'=>'+1','display_days'=>'true','month_format'=>'%m','day_value_format'=>'%02d','time'=>$this->_var['profile']['birthday'])); ?>
      �����֤�ϳ�������Ϊ׼</td>
  </tr>
  <tr>
            <td class="td_r" align="right" style=" text-align:right;">��Աͷ��</td>
            <td class="td_l" style=" text-align:left;">
            <div style="width:50%;float:left;">
                <input id="avatar" type="file" size="40" value="" name="avatar">
                <br/>
                <span style="color:#FF0000"> ͼƬ�������Ϊ74px * 74px��<br/>��С���ó���1M</span>
            </div>
            <div style="width:50%;float:left;">
                <img src="<?php if ($this->_var['profile']['avatar']): ?><?php echo $this->_var['profile']['avatar']; ?><?php else: ?>/images/change_avtar.png<?php endif; ?>" alt="" width="55" height="55">
            </div>
            </td>
        </tr>
</table>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr class="bt_b">
    <td colspan="2"><strong>��ϵ��ʽ</strong></td>
  </tr>
  <tr>
    <td width="23%" class="td_r" align="right" style=" text-align:right;">* �ֻ�</td>
    <td class="td_l" style=" text-align:left;"><input class="text_ge" type="text" name="extend_field5" id="extend_field5" value="<?php echo $this->_var['profile']['mobile_phone']; ?>" /></td>
  </tr>

  <tr>
    <td class="td_r" align="right" style=" text-align:right;">* ����</td>
    <td class="td_l" style=" text-align:left;"><input class="text_ge" type="text" name="email" id="email" value="<?php echo $this->_var['profile']['email']; ?>" /></td>
  </tr>
</table>
 
 <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr class="bt_b">
    <td colspan="2"><strong>��ϵ��ʽ</strong></td>
  </tr>
  <tr>
    <td width="23%" class="td_r" align="right" style=" text-align:right;">* �ҵ��Ƽ���</td>
    <td class="td_l" style=" text-align:left;"><input class="text_ge" type="text" name="parent_id" id="parent_id" value="<?php echo $this->_var['profile']['tuijian']; ?>" /></td>
  </tr>
</table>  
    <div class="tj_pc"> 
      <a href="javascript:document.getElementById('formEdit').submit();" title="��  ��" >��  ��</a>
    </div>
    <input name="act" type="hidden" value="act_edit_profile" />
    </form>   
  </div>
</div>
     <?php endif; ?>
     
     <?php if ($this->_var['action'] == 'bonus'): ?>
      <script type="text/javascript">
        <?php $_from = $this->_var['lang']['profile_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
          var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      </script>
      <h5><span><?php echo $this->_var['lang']['label_bonus']; ?></span></h5>
      <div class="blank"></div>
       <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
        <tr>
          <th align="center" bgcolor="#FFFFFF"><?php echo $this->_var['lang']['bonus_sn']; ?></th>
          <th align="center" bgcolor="#FFFFFF"><?php echo $this->_var['lang']['bonus_name']; ?></th>
          <th align="center" bgcolor="#FFFFFF"><?php echo $this->_var['lang']['bonus_amount']; ?></th>
          <th align="center" bgcolor="#FFFFFF"><?php echo $this->_var['lang']['min_goods_amount']; ?></th>
          <th align="center" bgcolor="#FFFFFF"><?php echo $this->_var['lang']['bonus_end_date']; ?></th>
          <th align="center" bgcolor="#FFFFFF"><?php echo $this->_var['lang']['bonus_status']; ?></th>
        </tr>
        <?php if ($this->_var['bonus']): ?>
        <?php $_from = $this->_var['bonus']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
        <tr>
          <td align="center" bgcolor="#FFFFFF"><?php echo empty($this->_var['item']['bonus_sn']) ? 'N/A' : $this->_var['item']['bonus_sn']; ?></td>
          <td align="center" bgcolor="#FFFFFF"><?php echo $this->_var['item']['type_name']; ?></td>
          <td align="center" bgcolor="#FFFFFF"><?php echo $this->_var['item']['type_money']; ?></td>
          <td align="center" bgcolor="#FFFFFF"><?php echo $this->_var['item']['min_goods_amount']; ?></td>
          <td align="center" bgcolor="#FFFFFF"><?php echo $this->_var['item']['use_enddate']; ?></td>
          <td align="center" bgcolor="#FFFFFF"><?php echo $this->_var['item']['status']; ?></td>
        </tr>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        <?php else: ?>
        <tr>
          <td colspan="6" bgcolor="#FFFFFF"><?php echo $this->_var['lang']['user_bonus_empty']; ?></td>
        </tr>
        <?php endif; ?>
      </table>
      <div class="blank5"></div>
      <?php echo $this->fetch('library/pages.lbi'); ?>
      <div class="blank5"></div>
      <h5><span><?php echo $this->_var['lang']['add_bonus']; ?></span></h5>
      <div class="blank"></div>
      <form name="addBouns" action="user.php" method="post" onSubmit="return addBonus()">
        <div style="padding: 15px;">
        <?php echo $this->_var['lang']['bonus_number']; ?>
          <input name="bonus_sn" type="text" size="30" class="inputBg" />
          <input type="hidden" name="act" value="act_add_bonus" class="inputBg" />
          <input type="submit" class="bnt_blue_1" style="border:none;" value="<?php echo $this->_var['lang']['add_bonus']; ?>" />
        </div>
      </form>
    <?php endif; ?>
   
   
   
       <?php if ($this->_var['action'] == 'bd_list'): ?>
<div class="right_pc">
    <div class="r_bt_pc">
       <span>��������</span><em>Insurance management</em>
    </div>
    <div class="bdgl_tab_pc">
          <div id="tab">
              <ul class="tab_menu">
                  <li <?php if (! $this->_var['zt']): ?>class="selected"<?php endif; ?>><a href="user.php?act=bd_list" title="ȫ��">ȫ����<?php echo $this->_var['qb']; ?>��</a></li>
                  <li <?php if ($this->_var['zt'] == 'ycb'): ?>class="selected"<?php endif; ?>><a href="user.php?act=bd_list&zt=ycb" title="�ѳб�">�ѳб���<?php echo $this->_var['ycb']; ?>��</a></li>
                  <li <?php if ($this->_var['zt'] == 'ygq'): ?>class="selected"<?php endif; ?>><a href="user.php?act=bd_list&zt=ygq" title="�ѹ���">�ѹ��ڣ�<?php echo $this->_var['ygq']; ?>��</a></li>
              </ul>
              <div class="tab_box">
                  <div class="hide" <?php if (! $this->_var['zt']): ?>style="display:block;"<?php endif; ?>>ʲô�Ǳ���?<br />
                    ����Ͷ���������չ�˾�б���ǩ������ʽ���պ�ͬ����������<br />
������PDF�ļ���ʽ����Ҫ��Adobe Acrobat����Ķ���������޷��Ķ�����<a href="" title="" style="color:#F30;">�������</a>���ز���װ�������
                  </div>
                  <div class="hide" <?php if ($this->_var['zt'] == 'ycb'): ?>style="display:block;"<?php endif; ?>>dd1</div>
                  <div class="hide" <?php if ($this->_var['zt'] == 'ygq'): ?>style="display:block;"<?php endif; ?>>dd2</div>
              </div>
          </div>
    </div>
    <div class="bdgl_xq">
      <table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#ccc" >
      <tr class="bt_b">
        <td>������</td>
        <td>���ղ�Ʒ����</td>
        <td>�б���˾</td>
        <td>Ͷ������</td>
        <td>�б�����</td>
        <td>״̬</td>
        <td>����</td>
      </tr>
      <?php $_from = $this->_var['orders']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
      <tr>
        <td><?php echo $this->_var['item']['bd_number']; ?></td>
        <td><?php echo $this->_var['item']['name']; ?></td>
        <td><?php echo $this->_var['item']['company']; ?></td>
        <td><?php echo $this->_var['item']['order_time']; ?></td>
        <td><?php echo $this->_var['item']['start_time']; ?> 00ʱ<br />
          ��<br />
          <?php echo $this->_var['item']['last_time']; ?> 24ʱ</td>
        <td><?php if ($this->_var['time'] > $this->_var['item']['last_time']): ?>�ѹ���<?php elseif ($this->_var['time'] < $this->_var['item']['start_time']): ?>δ��ʼ<?php else: ?>�б���<?php endif; ?></td>
        <td><a href="" title="">��������</a></td>
      </tr>
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </table>
    </div>
</div>
       <?php echo $this->fetch('library/pages.lbi'); ?>
       <?php endif; ?>
      
   
      
       <?php if ($this->_var['action'] == 'order_list'): ?>
<div class="right_pc">
    <div class="r_bt_pc">
       <span>��������</span><em>Order management</em>
    </div>
    <div class="bdgl_xq">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr class="bt_b">
        <td width="17%">��Ʒ</td>
        <td width="21%">�µ�ʱ��</td>
        <td width="13%">Ͷ������</td>
        <td width="13%">����</td>
        <td width="13%">ʵ����</td>
        <td width="12%">״̬</td>
        <td width="11%">����</td>
      </tr>
    </table>
    <?php $_from = $this->_var['orders']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr class="bt_b">
        <td colspan="7"><span class="ddh_pc">�����ţ�<?php echo $this->_var['item']['order_sn']; ?></span></td>
        </tr>
      <tr>
         <td width="17%"><?php echo $this->_var['item']['name']; ?></td>
        <td width="21%"><?php echo $this->_var['item']['order_time']; ?></td>
        <td width="13%">1��</td>
        <td width="13%"><?php echo $this->_var['item']['total_fee']; ?></td>
        <td width="13%"><?php echo $this->_var['item']['total_fee']; ?></td>
        <td width="12%"><?php echo $this->_var['item']['order_status']; ?></td>
        <td width="11%"><a href="user.php?act=order_detail&order_id=<?php echo $this->_var['item']['order_id']; ?>" title="��������">��������</a><br /><?php echo $this->_var['item']['handler']; ?></td>
      </tr>
    </table>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </div>
</div>
       <?php echo $this->fetch('library/pages.lbi'); ?>
       
       <?php endif; ?>
      
       
     
      <?php if ($this->_var['action'] == order_detail): ?>
        

<div class="dyxq_pc_bb">
<table width="1200" border="0" cellpadding="0" cellspacing="0">
  <tr >
      <td>
         <div class="ddh_xq">�����ţ�<?php echo $this->_var['order']['order_sn']; ?></div>
         <ul class="ddxq_bb">
            <li><strong>�ܼ�Ͷ��1��</strong></li>
            <li>���Ѻϼƣ�<em><?php echo $this->_var['order']['formated_order_amount']; ?></em></li>
         </ul>
         <div style="float:left; width:200px; height:40px;margin-top:15px;"><?php if ($this->_var['order']['order_amount'] > 0): ?><?php echo $this->_var['order']['pay_online']; ?><?php endif; ?></div>
         <div class="ddsfk_a">ʵ��� <em><?php echo $this->_var['order']['formated_order_amount']; ?></em></div>
      </td>
  </tr>
  
  <tr>
    <td>
        <h3><?php echo $this->_var['goods']['goods_name']; ?></h3>
        <?php if ($this->_var['order']['bx_type'] == 1): ?>
        <h4>������ϸ</h4>
         
         <table width="96%" border="0">
          <tr>
            <td width="14%" style=" text-align:right;">Ͷ������</td>
            <td width="62%"><?php echo $this->_var['order']['formated_add_time']; ?></td>
            <td width="24%" rowspan="5" style=" text-align:center; font-size:18px;">
            
            ��Ͷ��<em>1</em>��<br />
            ���Ѻϼƣ�<em><?php echo $this->_var['order']['formated_order_amount']; ?></em>
            </td>
          </tr>
          <tr>
            <td style=" text-align:right;">��������</td>
            <td>2016-01-17 00ʱ   �D�D  2017-01-16 24ʱ</td>
           </tr>
          <tr>
            <td style=" text-align:right;">Ͷ���ƻ�</td>
            <td><?php echo $this->_var['goods']['goods_attr']; ?></td>
           </tr>
          <tr>
            <td style=" text-align:right;">������ʽ</td>
            <td>���ӱ���</td>
           </tr>
          <tr>
            <td style=" text-align:right;">��Ʊ</td>
            <td><?php if ($this->_var['arr']['invoice']): ?>��<?php else: ?>��<?php endif; ?></td>
           </tr>
        </table>
        <h4>Ͷ������Ϣ</h4>
        <table width="96%" border="0">
  <tr>
    <td width="14%" style=" text-align:right;">����</td>
    <td width="86%"><?php echo $this->_var['arr']['tb_name']; ?></td>
  </tr>
  <tr>
    <td style=" text-align:right;">����</td>
    <td><?php echo $this->_var['arr']['email']; ?></td>
  </tr>
  <tr>
    <td style=" text-align:right;">֤������</td>
    <td>���֤</td>
  </tr>
  <tr>
    <td style=" text-align:right;">֤������</td>
    <td><?php echo $this->_var['arr']['tbzj_number']; ?></td>
  </tr>
  <tr>
    <td style=" text-align:right;">�ֻ�</td>
    <td><?php echo $this->_var['arr']['tb_mobile']; ?></td>
  </tr>
  <tr>
    <td style=" text-align:right;">���ڳ���</td>
    <td><?php echo $this->_var['arr']['address']; ?></td>
  </tr>
</table>

        <h4>��������Ϣ</h4>
        <table width="96%" border="0">
        <tr class="tr_ys">
          <td colspan="2">&nbsp; <strong>�����ˣ�������     ���ѣ�<?php echo $this->_var['order']['formated_order_amount']; ?></strong></td>
          </tr>
        <tr >
          <td width="14%" style=" text-align:right;" class="tr_ys">��������</td>
          <td width="86%">
          
                   <table width="96%" border="0" style=" margin-top:10px;">
                      <tr class="tr_ys">
                        <td>TA����</td>
                        <td>����</td>
                        <td>֤������</td>
                        <td>֤������</td>
                        <td>��ϵ��ʽ</td>
                      </tr>
                      <tr>
                        <td><?php echo $this->_var['arr']['relation']; ?></td>
                        <td><?php echo $this->_var['arr']['bb_name']; ?></td>
                        <td>���֤</td>
                        <td><?php echo $this->_var['arr']['bbzj_number']; ?></td>
                        <td><?php echo $this->_var['arr']['bb_mobile']; ?></td>
                      </tr>
                    </table>
          </td>
        </tr>
        <tr>
          <td style=" text-align:right;" class="tr_ys">������</td>
          <td>����</td>
        </tr>
      </table>
      <?php else: ?>
        <h4>��ʻ֤������Ϣ</h4>
        <table width="96%" border="0">
  <tr>
    <td width="14%" style=" text-align:right;">����</td>
    <td width="86%"><?php echo $this->_var['arr']['c_city']; ?></td>
  </tr>
  <tr>
    <td style=" text-align:right;">���ƺ�</td>
    <td><?php echo $this->_var['arr']['cp_number']; ?></td>
  </tr>
  <tr>
    <td style=" text-align:right;">�Ǽ�����</td>
    <td><?php echo $this->_var['arr']['dj_time']; ?></td>
  </tr>
  <tr>
    <td style=" text-align:right;">��������</td>
    <td><?php echo $this->_var['arr']['cz_name']; ?></td>
  </tr>
  <tr>
    <td style=" text-align:right;">���֤��</td>
    <td><?php echo $this->_var['arr']['sfz_number']; ?></td>
  </tr>
  <tr>
    <td style=" text-align:right;">�ֻ���</td>
    <td><?php echo $this->_var['arr']['mobile']; ?></td>
  </tr>
  <tr>
    <td style=" text-align:right;">���ܺ�</td>
    <td><?php echo $this->_var['arr']['frame_number']; ?></td>
  </tr>
  <tr>
    <td style=" text-align:right;">��������</td>
    <td><?php echo $this->_var['arr']['engine_number']; ?></td>
  </tr>
  <tr>
    <td style=" text-align:right;">Ʒ���ͺ�</td>
    <td><?php echo $this->_var['arr']['brand']; ?></td>
  </tr>
  <tr>
    <td style=" text-align:right;">�����ͺ�</td>
    <td><?php echo $this->_var['arr']['configure']; ?></td>
  </tr>
  <tr>
    <td style=" text-align:right;">������</td>
    <td><?php if ($this->_var['arr']['is_transfer'] == 1): ?>��<?php else: ?>��<?php endif; ?></td>
  </tr>
</table>

<h4>��������Ʊ��Ϣ</h4>
<table width="96%" border="0">
  <tr>
    <td width="14%" style=" text-align:right;">����</td>
    <td width="86%"><?php echo $this->_var['order']['consignee']; ?></td>
  </tr>
  <tr>
    <td style=" text-align:right;">�ֻ�</td>
    <td><?php echo $this->_var['order']['mobile']; ?></td>
  </tr>
  <tr>
    <td style=" text-align:right;">��ϸ��ַ</td>
    <td><?php echo $this->_var['order']['address']; ?></td>
  </tr>
  <tr>
    <td style=" text-align:right;">����ʱ��</td>
    <td><?php echo $this->_var['order']['best_time']; ?></td>
  </tr>
  <tr>
    <td style=" text-align:right;">���߷�Ʊ</td>
    <td><?php if ($this->_var['arr']['is_invoice'] == 1): ?>��<?php else: ?>��<?php endif; ?></td>
  </tr>
  <tr>
    <td style=" text-align:right;">��Ʊ̧ͷ</td>
    <td><?php echo $this->_var['arr']['invoice_title']; ?></td>
  </tr>
  
</table>
      <?php endif; ?>
      <div class="tbsm_pc">
         <ul>
            <li><strong>Ͷ������</strong></li>
            <li>1��Ͷ��ʱ����Ͷ�����Ѿ͸ò�Ʒ�ı��������Լ����ս���򱻱����˽�������ȷ˵������������ͬ�⡣</li>
            <li>2����Ͷ������������������������д��ʵ����֪�����Ͷ����Ϣ����ʵ�����չ�˾����Ȩ���⣬һ�к���ɱ��˳е���</li>
            <li>3����Ͷ�������Ķ��ò�Ʒ��ϸ������ر���������й����������Ͷ���ˡ�����������������ݽ����Ķ�����Ͷ�����ش�ͬ���������ȫ�����ݡ�</li>
            <li>4������&laquo;�л����񹲺͹���ͬ��&raquo;��ʮһ���涨�����ݵ����ǺϷ��ĺ�ͬ������ʽ�����˽��ܱ��չ�˾����һվ�ṩ�ĵ��ӱ�����Ϊ��Ͷ���������Ч�ĺϷ�</li>
            <li>5����Чƾ֤��������ȫ֤��Ч����</li>
         </ul>
      </div>

<div class="tj_pc"> 
  <a href="user.php?act=order_list" title="�����б�" >�����б�</a>
</div>  
<br />
    </td>
  </tr>
  
</table>
</div>
      <?php endif; ?>
    
    
      <?php if ($this->_var['action'] == "account_raply" || $this->_var['action'] == "account_log" || $this->_var['action'] == "account_deposit" || $this->_var['action'] == "account_detail"): ?>
        <script type="text/javascript">
          <?php $_from = $this->_var['lang']['account_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
            var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </script>
        <h5><span><?php echo $this->_var['lang']['user_balance']; ?></span></h5>
        <div class="blank"></div>
         <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
          <tr>
            <td align="right" bgcolor="#ffffff"><a href="user.php?act=account_deposit" class="f6"><?php echo $this->_var['lang']['surplus_type_0']; ?></a> | <a href="user.php?act=account_raply" class="f6"><?php echo $this->_var['lang']['surplus_type_1']; ?></a> | <a href="user.php?act=account_detail" class="f6"><?php echo $this->_var['lang']['add_surplus_log']; ?></a> | <a href="user.php?act=account_log" class="f6"><?php echo $this->_var['lang']['view_application']; ?></a> </td>
          </tr>
        </table>
        <?php endif; ?>
        <?php if ($this->_var['action'] == "account_raply"): ?>
        <form name="formSurplus" method="post" action="user.php" onSubmit="return submitSurplus()">
        <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
          <tr>
            <td width="15%" bgcolor="#ffffff"><?php echo $this->_var['lang']['repay_money']; ?>:</td>
            <td bgcolor="#ffffff" align="left"><input type="text" name="amount" value="<?php echo htmlspecialchars($this->_var['order']['amount']); ?>" class="inputBg" size="30" />
            </td>
          </tr>
          <tr>
            <td bgcolor="#ffffff"><?php echo $this->_var['lang']['process_notic']; ?>:</td>
            <td bgcolor="#ffffff" align="left"><textarea name="user_note" cols="55" rows="6" style="border:1px solid #ccc;"><?php echo htmlspecialchars($this->_var['order']['user_note']); ?></textarea></td>
          </tr>
          <tr>
            <td bgcolor="#ffffff" colspan="2" align="center">
            <input type="hidden" name="surplus_type" value="1" />
              <input type="hidden" name="act" value="act_account" />
              <input type="submit" name="submit"  class="bnt_blue_1" value="<?php echo $this->_var['lang']['submit_request']; ?>" />
              <input type="reset" name="reset" class="bnt_blue_1" value="<?php echo $this->_var['lang']['button_reset']; ?>" />
            </td>
          </tr>
        </table>
        </form>
        <?php endif; ?>
        <?php if ($this->_var['action'] == "account_deposit"): ?>
        <form name="formSurplus" method="post" action="user.php" onSubmit="return submitSurplus()">
        <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
            <tr>
              <td width="15%" bgcolor="#ffffff"><?php echo $this->_var['lang']['deposit_money']; ?>:</td>
              <td align="left" bgcolor="#ffffff"><input type="text" name="amount"  class="inputBg" value="<?php echo htmlspecialchars($this->_var['order']['amount']); ?>" size="30" /></td>
            </tr>
            <tr>
              <td bgcolor="#ffffff"><?php echo $this->_var['lang']['process_notic']; ?>:</td>
              <td align="left" bgcolor="#ffffff"><textarea name="user_note" cols="55" rows="6" style="border:1px solid #ccc;"><?php echo htmlspecialchars($this->_var['order']['user_note']); ?></textarea></td>
            </tr>
          </table>
          <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
            <tr align="center">
              <td bgcolor="#ffffff"  colspan="3" align="left"><?php echo $this->_var['lang']['payment']; ?>:</td>
            </tr>
            <tr align="center">
              <td bgcolor="#ffffff"><?php echo $this->_var['lang']['pay_name']; ?></td>
              <td bgcolor="#ffffff" width="60%"><?php echo $this->_var['lang']['pay_desc']; ?></td>
              <td bgcolor="#ffffff" width="17%"><?php echo $this->_var['lang']['pay_fee']; ?></td>
            </tr>
            <?php $_from = $this->_var['payment']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
            <tr>
              <td bgcolor="#ffffff" align="left">
              <input type="radio" name="payment_id" value="<?php echo $this->_var['list']['pay_id']; ?>" /><?php echo $this->_var['list']['pay_name']; ?></td>
              <td bgcolor="#ffffff" align="left"><?php echo $this->_var['list']['pay_desc']; ?></td>
              <td bgcolor="#ffffff" align="center"><?php echo $this->_var['list']['pay_fee']; ?></td>
            </tr>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            <tr>
        <td bgcolor="#ffffff" colspan="3"  align="center">
        <input type="hidden" name="surplus_type" value="0" />
          <input type="hidden" name="rec_id" value="<?php echo $this->_var['order']['id']; ?>" />
          <input type="hidden" name="act" value="act_account" />
          <input type="submit" class="bnt_blue_1" name="submit" value="<?php echo $this->_var['lang']['submit_request']; ?>" />
          <input type="reset" class="bnt_blue_1" name="reset" value="<?php echo $this->_var['lang']['button_reset']; ?>" />
        </td>
      </tr>
          </table>
        </form>
        <?php endif; ?>
        <?php if ($this->_var['action'] == "act_account"): ?>
        <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
          <tr>
            <td width="25%" align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['surplus_amount']; ?></td>
            <td width="80%" bgcolor="#ffffff"><?php echo $this->_var['amount']; ?></td>
          </tr>
          <tr>
            <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['payment_name']; ?></td>
            <td bgcolor="#ffffff"><?php echo $this->_var['payment']['pay_name']; ?></td>
          </tr>
          <tr>
            <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['payment_fee']; ?></td>
            <td bgcolor="#ffffff"><?php echo $this->_var['pay_fee']; ?></td>
          </tr>
          <tr>
            <td align="right" valign="middle" bgcolor="#ffffff"><?php echo $this->_var['lang']['payment_desc']; ?></td>
            <td bgcolor="#ffffff"><?php echo $this->_var['payment']['pay_desc']; ?></td>
          </tr>
          <tr>
            <td colspan="2" bgcolor="#ffffff"><?php echo $this->_var['payment']['pay_button']; ?></td>
          </tr>
        </table>
        <?php endif; ?>
       <?php if ($this->_var['action'] == "account_detail"): ?>
        <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
          <tr align="center">
            <td bgcolor="#ffffff"><?php echo $this->_var['lang']['process_time']; ?></td>
            <td bgcolor="#ffffff"><?php echo $this->_var['lang']['surplus_pro_type']; ?></td>
            <td bgcolor="#ffffff"><?php echo $this->_var['lang']['money']; ?></td>
            <td bgcolor="#ffffff"><?php echo $this->_var['lang']['change_desc']; ?></td>
          </tr>
          <?php $_from = $this->_var['account_log']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
          <tr>
            <td align="center" bgcolor="#ffffff"><?php echo $this->_var['item']['change_time']; ?></td>
            <td align="center" bgcolor="#ffffff"><?php echo $this->_var['item']['type']; ?></td>
            <td align="right" bgcolor="#ffffff"><?php echo $this->_var['item']['amount']; ?></td>
            <td bgcolor="#ffffff" title="<?php echo $this->_var['item']['change_desc']; ?>">&nbsp;&nbsp;<?php echo $this->_var['item']['short_change_desc']; ?></td>
          </tr>
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
          <tr>
            <td colspan="4" align="center" bgcolor="#ffffff"><div align="right"><?php echo $this->_var['lang']['current_surplus']; ?><?php echo $this->_var['surplus_amount']; ?></div></td>
          </tr>
        </table>
        <?php echo $this->fetch('library/pages.lbi'); ?>
        <?php endif; ?>
        <?php if ($this->_var['action'] == "account_log"): ?>
        <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
          <tr align="center">
            <td bgcolor="#ffffff"><?php echo $this->_var['lang']['process_time']; ?></td>
            <td bgcolor="#ffffff"><?php echo $this->_var['lang']['surplus_pro_type']; ?></td>
            <td bgcolor="#ffffff"><?php echo $this->_var['lang']['money']; ?></td>
            <td bgcolor="#ffffff"><?php echo $this->_var['lang']['process_notic']; ?></td>
            <td bgcolor="#ffffff"><?php echo $this->_var['lang']['admin_notic']; ?></td>
            <td bgcolor="#ffffff"><?php echo $this->_var['lang']['is_paid']; ?></td>
            <td bgcolor="#ffffff"><?php echo $this->_var['lang']['handle']; ?></td>
          </tr>
          <?php $_from = $this->_var['account_log']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
          <tr>
            <td align="center" bgcolor="#ffffff"><?php echo $this->_var['item']['add_time']; ?></td>
            <td align="left" bgcolor="#ffffff"><?php echo $this->_var['item']['type']; ?></td>
            <td align="right" bgcolor="#ffffff"><?php echo $this->_var['item']['amount']; ?></td>
            <td align="left" bgcolor="#ffffff"><?php echo $this->_var['item']['short_user_note']; ?></td>
            <td align="left" bgcolor="#ffffff"><?php echo $this->_var['item']['short_admin_note']; ?></td>
            <td align="center" bgcolor="#ffffff"><?php echo $this->_var['item']['pay_status']; ?></td>
            <td align="right" bgcolor="#ffffff"><?php echo $this->_var['item']['handle']; ?>
              <?php if (( $this->_var['item']['is_paid'] == 0 && $this->_var['item']['process_type'] == 1 ) || $this->_var['item']['handle']): ?>
              <a href="user.php?act=cancel&id=<?php echo $this->_var['item']['id']; ?>" onclick="if (!confirm('<?php echo $this->_var['lang']['confirm_remove_account']; ?>')) return false;"><?php echo $this->_var['lang']['is_cancel']; ?></a>
              <?php endif; ?>
                            </td>
          </tr>
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
          <tr>
            <td colspan="7" align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['current_surplus']; ?><?php echo $this->_var['surplus_amount']; ?></td>
          </tr>
        </table>
        <?php echo $this->fetch('library/pages.lbi'); ?>
      <?php endif; ?>
      
      
      <?php if ($this->_var['action'] == 'address_list'): ?>
         
<div class="right_pc">
    <div class="r_bt_pc">
       <span>���͵�ַ</span><em>Ship-to address</em>
    </div>
    <div class="bdgl_xq">
   <div class="tjlxr_pc"><span><img src="/images/tjr.jpg" alt="�������͵�ַ"/><a href="user.php?act=address_info" title="�������͵�ַ" />�������͵�ַ</a></span></div> 
   <div style="clear:both;"></div> 
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr class="bt_b">
    <td width="11%">�ջ���</td>
    <td width="41%">��ַ</td>
    <td width="13%">�ʱ�</td>
    <td width="15%">��ϵ��ʽ</td>
    <td width="20%">����</td>
  </tr>
  <?php $_from = $this->_var['consignee_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'consignee');if (count($_from)):
    foreach ($_from AS $this->_var['consignee']):
?>
  <tr>
    <td><?php echo $this->_var['consignee']['consignee']; ?></td>
    <td><?php echo $this->_var['consignee']['address']; ?></td>
    <td><?php echo $this->_var['consignee']['zipcode']; ?></td>
    <td><?php echo $this->_var['consignee']['mobile']; ?></td>
    <td><a href="user.php?act=drop_consignee&id=<?php echo $this->_var['consignee']['address_id']; ?>">ɾ��</a>  <a href="user.php?act=address_info&id=<?php echo $this->_var['consignee']['address_id']; ?>">�޸�</a>
     <?php if ($this->_var['consignee']['address_id'] == $this->_var['address']): ?><font color="#FF0000">Ĭ��</font><?php endif; ?></td>
  </tr>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</table>
    </div>
</div>
      <?php endif; ?>


<?php if ($this->_var['action'] == 'address_info'): ?> 
<?php echo $this->smarty_insert_scripts(array('files'=>'transport.js,region.js')); ?>
<div class="right_pc">
    <div class="r_bt_pc">
       <span>���͵�ַ</span><em>Ship-to address</em>
    </div>
    <div class="bdgl_xq">
<form id="formSurplus" method="post" action="user.php">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr class="bt_b">
    <td colspan="2"><strong>���/�޸ļ��͵�ַ</strong></td>
    </tr>
  <tr>
    <td width="23%" class="td_r" align="right" style=" text-align:right;">* �ջ���</td>
    <td width="77%" class="td_l" style=" text-align:left;">
      <input class="text_ge" type="text" name="consignee" id="consignee" value="<?php echo $this->_var['address_info']['consignee']; ?>" />
    </td>
  </tr>
  <tr>
    <td class="td_r" align="right" style=" text-align:right;">* ����</td>
    <td class="td_l" style=" text-align:left;"><span class="td_l" style=" text-align:left;"><span class="td_l" style=" text-align:left;">
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
      </span></span></td>
  </tr>
  <tr>
    <td class="td_r" align="right" style=" text-align:right;">*�ֵ���ַ</td>
    <td class="td_l" style=" text-align:left;"><input class="text_ge" type="text" name="address" id="address" value="<?php echo $this->_var['address_info']['address']; ?>" /></td>
  </tr>
  <tr>
    <td class="td_r" align="right" style=" text-align:right;">* �ʱ�</td>
    <td class="td_l" style=" text-align:left;"><input class="text_ge" type="text" name="zipcode" id="zipcode" value="<?php echo $this->_var['address_info']['zipcode']; ?>" /></td>
  </tr>
  <tr>
    <td class="td_r" align="right" style=" text-align:right;">* �ֻ�</td>
    <td class="td_l" style=" text-align:left;"><span class="td_l" style=" text-align:left;">
      <input class="text_ge" type="text" name="mobile" id="mobile" value="<?php echo $this->_var['address_info']['mobile']; ?>" />
      </span></td>
  </tr>
  <tr>
    <td colspan="2" align="center">
      Ĭ�ϵ�ַ<input type="checkbox" name="defalut" value="1" <?php if ($this->_var['address_info']['address_id'] == $this->_var['address']): ?>checked="checked"<?php endif; ?> />
    </td>
  </tr>
  <input type="hidden" name="act" value="act_edit_address" />
  <input type="hidden" name="address_id" value="<?php echo $this->_var['address_info']['address_id']; ?>" />
</table>
</form>
    <div class="tj_pc"> 
      <a href="javascript:document.getElementById('formSurplus').submit();" title="��  ��" >��  ��</a>
    </div>    
    </div>
</div>
<script>
region.isAdmin = true;
if(!"<?php echo $this->_var['address_info']['address_id']; ?>"){
	$("#selCountries").change();
}
</script>
<?php endif; ?>


    
      
       <?php if ($this->_var['action'] == 'transform_points'): ?>
       <h5><span><?php echo $this->_var['lang']['transform_points']; ?></span></h5>
             <div class="blank"></div>
       <?php if ($this->_var['exchange_type'] == 'ucenter'): ?>
        <form action="user.php" method="post" name="transForm" onsubmit="return calcredit();">
       <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
                <tr>
                    <th width="120" bgcolor="#FFFFFF" align="right" valign="top"><?php echo $this->_var['lang']['cur_points']; ?>:</th>
                    <td bgcolor="#FFFFFF">
                    <label for="pay_points"><?php echo $this->_var['lang']['exchange_points']['1']; ?>:</label><input type="text" size="15" id="pay_points" name="pay_points" value="<?php echo $this->_var['shop_points']['pay_points']; ?>" style="border:0;border-bottom:1px solid #DADADA;" readonly="readonly" /><br />
                    <div class="blank"></div>
                    <label for="rank_points"><?php echo $this->_var['lang']['exchange_points']['0']; ?>:</label><input type="text" size="15" id="rank_points" name="rank_points" value="<?php echo $this->_var['shop_points']['rank_points']; ?>" style="border:0;border-bottom:1px solid #DADADA;" readonly="readonly" />
                    </td>
                    </tr>
          <tr><td bgcolor="#FFFFFF">&nbsp;</td>
          <td bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
          <tr>
            <th align="right" bgcolor="#FFFFFF"><label for="amount"><?php echo $this->_var['lang']['exchange_amount']; ?>:</label></th>
            <td bgcolor="#FFFFFF"><input size="15" name="amount" id="amount" value="0" onkeyup="calcredit();" type="text" />
                <select name="fromcredits" id="fromcredits" onchange="calcredit();">
                  <?php echo $this->html_options(array('options'=>$this->_var['lang']['exchange_points'],'selected'=>$this->_var['selected_org'])); ?>
                </select>
            </td>
          </tr>
          <tr>
            <th align="right" bgcolor="#FFFFFF"><label for="desamount"><?php echo $this->_var['lang']['exchange_desamount']; ?>:</label></th>
            <td bgcolor="#FFFFFF"><input type="text" name="desamount" id="desamount" disabled="disabled" value="0" size="15" />
              <select name="tocredits" id="tocredits" onchange="calcredit();">
                <?php echo $this->html_options(array('options'=>$this->_var['to_credits_options'],'selected'=>$this->_var['selected_dst'])); ?>
              </select>
            </td>
          </tr>
          <tr>
            <th align="right" bgcolor="#FFFFFF"><?php echo $this->_var['lang']['exchange_ratio']; ?>:</th>
            <td bgcolor="#FFFFFF">1 <span id="orgcreditunit"><?php echo $this->_var['orgcreditunit']; ?></span> <span id="orgcredittitle"><?php echo $this->_var['orgcredittitle']; ?></span> <?php echo $this->_var['lang']['exchange_action']; ?> <span id="descreditamount"><?php echo $this->_var['descreditamount']; ?></span> <span id="descreditunit"><?php echo $this->_var['descreditunit']; ?></span> <span id="descredittitle"><?php echo $this->_var['descredittitle']; ?></span></td>
          </tr>
          <tr><td bgcolor="#FFFFFF">&nbsp;</td>
          <td bgcolor="#FFFFFF"><input type="hidden" name="act" value="act_transform_ucenter_points" /><input type="submit" name="transfrom" value="<?php echo $this->_var['lang']['transform']; ?>" /></td></tr>
  </table>
        </form>
       <script type="text/javascript">
        <?php $_from = $this->_var['lang']['exchange_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'lang_js');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['lang_js']):
?>
        var <?php echo $this->_var['key']; ?> = '<?php echo $this->_var['lang_js']; ?>';
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

        var out_exchange_allow = new Array();
        <?php $_from = $this->_var['out_exchange_allow']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'ratio');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['ratio']):
?>
        out_exchange_allow['<?php echo $this->_var['key']; ?>'] = '<?php echo $this->_var['ratio']; ?>';
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

        function calcredit()
        {
            var frm = document.forms['transForm'];
            var src_credit = frm.fromcredits.value;
            var dest_credit = frm.tocredits.value;
            var in_credit = frm.amount.value;
            var org_title = frm.fromcredits[frm.fromcredits.selectedIndex].innerHTML;
            var dst_title = frm.tocredits[frm.tocredits.selectedIndex].innerHTML;
            var radio = 0;
            var shop_points = ['rank_points', 'pay_points'];
            if (parseFloat(in_credit) > parseFloat(document.getElementById(shop_points[src_credit]).value))
            {
                alert(balance.replace('{%s}', org_title));
                frm.amount.value = frm.desamount.value = 0;
                return false;
            }
            if (typeof(out_exchange_allow[dest_credit+'|'+src_credit]) == 'string')
            {
                radio = (1 / parseFloat(out_exchange_allow[dest_credit+'|'+src_credit])).toFixed(2);
            }
            document.getElementById('orgcredittitle').innerHTML = org_title;
            document.getElementById('descreditamount').innerHTML = radio;
            document.getElementById('descredittitle').innerHTML = dst_title;
            if (in_credit > 0)
            {
                if (typeof(out_exchange_allow[dest_credit+'|'+src_credit]) == 'string')
                {
                    frm.desamount.value = Math.floor(parseFloat(in_credit) / parseFloat(out_exchange_allow[dest_credit+'|'+src_credit]));
                    frm.transfrom.disabled = false;
                    return true;
                }
                else
                {
                    frm.desamount.value = deny;
                    frm.transfrom.disabled = true;
                    return false;
                }
            }
            else
            {
                return false;
            }
        }
       </script>
       <?php else: ?>
        <b><?php echo $this->_var['lang']['cur_points']; ?>:</b>
        <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
          <tr>
            <td width="30%" valign="top" bgcolor="#FFFFFF"><table border="0">
              <?php $_from = $this->_var['bbs_points']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'points');if (count($_from)):
    foreach ($_from AS $this->_var['points']):
?>
              <tr>
                <th><?php echo $this->_var['points']['title']; ?>:</th>
                <td width="120" style="border-bottom:1px solid #DADADA;"><?php echo $this->_var['points']['value']; ?></td>
              </tr>
              <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </table></td>
            <td width="50%" valign="top" bgcolor="#FFFFFF"><table>
                    <tr>
                <th><?php echo $this->_var['lang']['pay_points']; ?>:</th>
                <td width="120" style="border-bottom:1px solid #DADADA;"><?php echo $this->_var['shop_points']['pay_points']; ?></td>
                    </tr>
              <tr>
                <th><?php echo $this->_var['lang']['rank_points']; ?>:</th>
                <td width="120" style="border-bottom:1px solid #DADADA;"><?php echo $this->_var['shop_points']['rank_points']; ?></td>
              </tr>
            </table></td>
          </tr>
        </table>
        <br />
        <b><?php echo $this->_var['lang']['rule_list']; ?>:</b>
        <ul class="point clearfix">
          <?php $_from = $this->_var['rule_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'rule');if (count($_from)):
    foreach ($_from AS $this->_var['rule']):
?>
          <li><font class="f1">��</font>"<?php echo $this->_var['rule']['from']; ?>" <?php echo $this->_var['lang']['transform']; ?> "<?php echo $this->_var['rule']['to']; ?>" <?php echo $this->_var['lang']['rate_is']; ?> <?php echo $this->_var['rule']['rate']; ?>
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </ul>

        <form action="user.php" method="post" name="theForm">
        <table width="100%" border="1" align="center" cellpadding="5" cellspacing="0" style="border-collapse:collapse;border:1px solid #DADADA;">
          <tr style="background:#F1F1F1;">
            <th><?php echo $this->_var['lang']['rule']; ?></th>
            <th><?php echo $this->_var['lang']['transform_num']; ?></th>
            <th><?php echo $this->_var['lang']['transform_result']; ?></th>
          </tr>
          <tr>
            <td>
              <select name="rule_index" onchange="changeRule()">
                <?php $_from = $this->_var['rule_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'rule');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['rule']):
?>
                <option value="<?php echo $this->_var['key']; ?>"><?php echo $this->_var['rule']['from']; ?>-><?php echo $this->_var['rule']['to']; ?></option>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
              </select>
          </td>
          <td>
            <input type="text" name="num" value="0" onkeyup="calPoints()"/>
          </td>
          <td><span id="ECS_RESULT">0</span></td>
          </tr>
          <tr>
            <td colspan="3" align="center"><input type="hidden" name="act" value="act_transform_points"  /><input type="submit" value="<?php echo $this->_var['lang']['transform']; ?>" /></td>
          </tr>
        </table>
        </form>
       <script type="text/javascript">
          //<![CDATA[
            var rule_list = new Object();
            var invalid_input = '<?php echo $this->_var['lang']['invalid_input']; ?>';
            <?php $_from = $this->_var['rule_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'rule');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['rule']):
?>
            rule_list['<?php echo $this->_var['key']; ?>'] = '<?php echo $this->_var['rule']['rate']; ?>';
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            function calPoints()
            {
              var frm = document.forms['theForm'];
              var rule_index = frm.elements['rule_index'].value;
              var num = parseInt(frm.elements['num'].value);
              var rate = rule_list[rule_index];

              if (isNaN(num) || num < 0 || num != frm.elements['num'].value)
              {
                document.getElementById('ECS_RESULT').innerHTML = invalid_input;
                rerutn;
              }
              var arr = rate.split(':');
              var from = parseInt(arr[0]);
              var to = parseInt(arr[1]);

              if (from <=0 || to <=0)
              {
                from = 1;
                to = 0;
              }
              document.getElementById('ECS_RESULT').innerHTML = parseInt(num * to / from);
            }

            function changeRule()
            {
              document.forms['theForm'].elements['num'].value = 0;
              document.getElementById('ECS_RESULT').innerHTML = 0;
            }
          //]]>
       </script>
       <?php endif; ?>
        <?php endif; ?>
        
<?php if ($this->_var['action'] != 'order_detail'): ?>
  </div>
  
</div>
<?php endif; ?>
<div class="blank"></div>
<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>
<script type="text/javascript">
<?php $_from = $this->_var['lang']['clips_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</script>
</html>
