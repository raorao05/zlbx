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


<?php echo $this->smarty_insert_scripts(array('files'=>'transport.js,common.js,user.js')); ?>
</head>
<body>
<?php echo $this->fetch('library/page_header.lbi'); ?>

<div class="w_dqwz">
    <?php echo $this->fetch('library/ur_here.lbi'); ?>
   </div>


<div class="content_pc">
  
  <div class="left_pc">
   <div class="div1">
        <?php echo $this->fetch('library/user_menu.lbi'); ?>
    </div>
  </div>
  
  
  <div class="right_pc">
         
         <?php if ($this->_var['action'] == 'default'): ?>
          <div class="r_bt_pc">
             <span>会员中心</span><em>Member center</em>
          </div>
    <div class="bdgl_xq">
    <div class="grxx_pc_a">
       <div class="div_a">
         <img src="<?php if ($this->_var['info']['avatar']): ?><?php echo $this->_var['info']['avatar']; ?><?php else: ?>/images/change_avtar.png<?php endif; ?>" width="48" height="48" />
         <ul>
            <li><strong><?php echo $this->_var['info']['username']; ?></strong><em></em></li>
            <li>上次登录时间：<?php echo $this->_var['info']['last_time']; ?></li>
         </ul>
       </div>
       <div class="div_b">
         <p>当前积分：<em><?php echo $this->_var['info']['integral']; ?></em></p>
         <p>优惠券：<em><?php echo $this->_var['info']['bonus']; ?></em></p> 
       </div>
    </div>
    <div class="jytx_a">
          <h4>交易提醒</h4>
          <ul>
             <li><a href="flow.php" >购物车<em>（<?php 
$k = array (
  'name' => 'cart_info',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?>）</em></a></li>
             <li><a href="" >待支付<em>（<?php echo $this->_var['dzf_order']; ?>）</em></a></li>
             <li><a href="" >已关闭<em>（<?php echo $this->_var['ygb_order']; ?>）</em></a></li>
          </ul>
    </div>
    <h3 class="abb_c">最近操作订单</h3>
    
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr class="bt_b">
    <td width="17%">产品</td>
    <td width="21%">下单时间</td>
    <td width="13%">投保份数</td>
    <td width="13%">保费</td>
    <td width="13%">实付款</td>
    <td width="12%">状态</td>
    <td width="11%">操作</td>
  </tr>
</table>
    
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr class="bt_b">
    <td colspan="7"><span class="ddh_pc">订单号：<?php echo $this->_var['orders']['order_sn']; ?></span></td>
    </tr>
  <tr>
     <td width="17%"><?php echo $this->_var['orders']['name']; ?></td>
    <td width="21%"><?php echo $this->_var['orders']['order_time']; ?></td>
    <td width="13%">1份</td>
    <td width="13%"><?php echo $this->_var['orders']['total_fee']; ?></td>
    <td width="13%"><?php echo $this->_var['orders']['total_fee']; ?></td>
    <td width="12%"><?php echo $this->_var['orders']['order_status']; ?></td>
    <td width="11%"><a href="user.php?act=order_detail&order_id=<?php echo $this->_var['orders']['order_id']; ?>" title="订单详情">订单详情</a><br /><?php echo $this->_var['orders']['handler']; ?></td>
  </tr>
</table>



    </div>

</div>
          
          
         <?php endif; ?>
         
         
         <?php if ($this->_var['action'] == 'message_list'): ?>
          <h5><span><?php echo $this->_var['lang']['label_message']; ?></span></h5>
          <div class="blank"></div>
           <?php $_from = $this->_var['message_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'message');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['message']):
?>
          <div class="f_l">
          <b><?php echo $this->_var['message']['msg_type']; ?>:</b>&nbsp;&nbsp;<font class="f4"><?php echo $this->_var['message']['msg_title']; ?></font> (<?php echo $this->_var['message']['msg_time']; ?>)
          </div>
          <div class="f_r">
          <a href="user.php?act=del_msg&amp;id=<?php echo $this->_var['key']; ?>&amp;order_id=<?php echo $this->_var['message']['order_id']; ?>" title="<?php echo $this->_var['lang']['drop']; ?>" onclick="if (!confirm('<?php echo $this->_var['lang']['confirm_remove_msg']; ?>')) return false;" class="f6"><?php echo $this->_var['lang']['drop']; ?></a>
          </div>
          <div class="msgBottomBorder">
          <?php echo $this->_var['message']['msg_content']; ?>
           <?php if ($this->_var['message']['message_img']): ?>
           <div align="right">
           <a href="data/feedbackimg/<?php echo $this->_var['message']['message_img']; ?>" target="_bank" class="f6"><?php echo $this->_var['lang']['view_upload_file']; ?></a>
           </div>
           <?php endif; ?>
           <br />
           <?php if ($this->_var['message']['re_msg_content']): ?>
           <a href="mailto:<?php echo $this->_var['message']['re_user_email']; ?>" class="f6"><?php echo $this->_var['lang']['shopman_reply']; ?></a> (<?php echo $this->_var['message']['re_msg_time']; ?>)<br />
           <?php echo $this->_var['message']['re_msg_content']; ?>
           <?php endif; ?>
          </div>
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
          <?php if ($this->_var['message_list']): ?>
          <div class="f_r">
          <?php echo $this->fetch('library/pages.lbi'); ?>
          </div>
          <?php endif; ?>
          <div class="blank"></div>
          <form action="user.php" method="post" enctype="multipart/form-data" name="formMsg" onSubmit="return submitMsg()">
                  <table width="100%" border="0" cellpadding="3">
                    <?php if ($this->_var['order_info']): ?>
                    <tr>
                      <td align="right"><?php echo $this->_var['lang']['order_number']; ?></td>
                      <td>
                      <a href ="<?php echo $this->_var['order_info']['url']; ?>"><img src="themes/default/images/note.gif" /><?php echo $this->_var['order_info']['order_sn']; ?></a>
                      <input name="msg_type" type="hidden" value="5" />
                      <input name="order_id" type="hidden" value="<?php echo $this->_var['order_info']['order_id']; ?>" class="inputBg" />
                      </td>
                    </tr>
                    <?php else: ?>
                    <tr>
                      <td align="right"><?php echo $this->_var['lang']['message_type']; ?>：</td>
                      <td><input name="msg_type" type="radio" value="0" checked="checked" />
                        <?php echo $this->_var['lang']['type']['0']; ?>
                        <input type="radio" name="msg_type" value="1" />
                        <?php echo $this->_var['lang']['type']['1']; ?>
                        <input type="radio" name="msg_type" value="2" />
                        <?php echo $this->_var['lang']['type']['2']; ?>
                        <input type="radio" name="msg_type" value="3" />
                        <?php echo $this->_var['lang']['type']['3']; ?>
                        <input type="radio" name="msg_type" value="4" />
                        <?php echo $this->_var['lang']['type']['4']; ?> </td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                      <td align="right"><?php echo $this->_var['lang']['message_title']; ?>：</td>
                      <td><input name="msg_title" type="text" size="30" class="inputBg" /></td>
                    </tr>
                    <tr>
                      <td align="right" valign="top"><?php echo $this->_var['lang']['message_content']; ?>：</td>
                      <td><textarea name="msg_content" cols="50" rows="4" wrap="virtual" class="B_blue"></textarea></td>
                    </tr>
                    <tr>
                      <td align="right"><?php echo $this->_var['lang']['upload_img']; ?>：</td>
                      <td><input type="file" name="message_img"  size="45"  class="inputBg" /></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td><input type="hidden" name="act" value="act_add_message" />
                        <input type="submit" value="<?php echo $this->_var['lang']['submit']; ?>" class="bnt_bonus" />
                      </td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>
                      <?php echo $this->_var['lang']['img_type_tips']; ?><br />
                      <?php echo $this->_var['lang']['img_type_list']; ?>
                      </td>
                    </tr>
                  </table>
                </form>
         <?php endif; ?>
         
         
          <?php if ($this->_var['action'] == 'comment_list'): ?>
          <h5><span><?php echo $this->_var['lang']['label_comment']; ?></span></h5>
          <div class="blank"></div>
          <?php $_from = $this->_var['comment_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'comment');if (count($_from)):
    foreach ($_from AS $this->_var['comment']):
?>
          <div class="f_l">
          <b><?php if ($this->_var['comment']['comment_type'] == '0'): ?><?php echo $this->_var['lang']['goods_comment']; ?><?php else: ?><?php echo $this->_var['lang']['article_comment']; ?><?php endif; ?>: </b><font class="f4"><?php echo $this->_var['comment']['cmt_name']; ?></font>&nbsp;&nbsp;(<?php echo $this->_var['comment']['formated_add_time']; ?>)
          </div>
          <div class="f_r">
          <a href="user.php?act=del_cmt&amp;id=<?php echo $this->_var['comment']['comment_id']; ?>" title="<?php echo $this->_var['lang']['drop']; ?>" onclick="if (!confirm('<?php echo $this->_var['lang']['confirm_remove_msg']; ?>')) return false;" class="f6"><?php echo $this->_var['lang']['drop']; ?></a>
          </div>
          <div class="msgBottomBorder">
          <?php echo htmlspecialchars($this->_var['comment']['content']); ?><br />
          <?php if ($this->_var['comment']['reply_content']): ?>
          <b><?php echo $this->_var['lang']['reply_comment']; ?>：</b><br />
          <?php echo $this->_var['comment']['reply_content']; ?>
           <?php endif; ?>
          </div>
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
          <?php if ($this->_var['comment_list']): ?>
          <?php echo $this->fetch('library/pages.lbi'); ?>
          <?php else: ?>
          <?php echo $this->_var['lang']['no_comments']; ?>
          <?php endif; ?>
          <?php endif; ?>
    
    
    <?php if ($this->_var['action'] == 'tag_list'): ?>
    <h5><span><?php echo $this->_var['lang']['label_tag']; ?></span></h5>
    <div class="blank"></div>
     <?php if ($this->_var['tags']): ?>
    <?php $_from = $this->_var['tags']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'tag');if (count($_from)):
    foreach ($_from AS $this->_var['tag']):
?>
    <a href="search.php?keywords=<?php echo urlencode($this->_var['tag']['tag_words']); ?>" class="f6"><?php echo htmlspecialchars($this->_var['tag']['tag_words']); ?></a> <a href="user.php?act=act_del_tag&amp;tag_words=<?php echo urlencode($this->_var['tag']['tag_words']); ?>" onclick="if (!confirm('<?php echo $this->_var['lang']['confirm_drop_tag']; ?>')) return false;" title="<?php echo $this->_var['lang']['drop']; ?>"><img src="themes/default/images/drop.gif" alt="<?php echo $this->_var['lang']['drop']; ?>" /></a>&nbsp;&nbsp;
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    <?php else: ?>
    <span style="margin:2px 10px; font-size:14px; line-height:36px;"><?php echo $this->_var['lang']['no_tag']; ?></span>
    <?php endif; ?>
    <?php endif; ?>
    
    
    <?php if ($this->_var['action'] == 'collection_list'): ?>
  <?php echo $this->smarty_insert_scripts(array('files'=>'transport.js,utils.js')); ?>
  <script>
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
<div class="right_pc">
    <div class="r_bt_pc">
       <span>我的收藏夹</span><em>My favorites</em>
    </div>
    <div class="bdgl_xq">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr class="bt_b">
    <td colspan="7">
      <span class="l_ss"><input type="checkbox" onClick="this.value=check_1('rec_id[]')" />&nbsp; &nbsp;全选 &nbsp; &nbsp; 
      <a href="javascript:document.getElementById('formcollection').submit();" title="删除所有">删除所有</a></span> 
      <span class="r_ss">共<em><?php echo $this->_var['pager']['record_count']; ?></em>款产品</span>
     </td>
    </tr>
  <tr>
    <td colspan="3">产品名称</td>
    <td width="14%">保费</td>
    <td width="17%">收藏时间</td>
    <td width="13%">收藏人气</td>
    <td width="18%">操作</td>
  </tr>
  <form id="formcollection" method="post" action="user.php">
  <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
  <tr>
    <td width="9%">
      <input type="checkbox" name="rec_id[]" value="<?php echo $this->_var['goods']['rec_id']; ?>"  />
     </td>
    <td width="10%"><img src="/<?php echo $this->_var['goods']['goods_img']; ?>" width="80" height="80" /></td>
    <td width="19%"><p><?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?></p></td>
    <td><?php echo $this->_var['goods']['shop_price']; ?></td>
    <td><?php echo $this->_var['goods']['add_time']; ?></td>
    <td><?php echo $this->_var['goods']['popularity']; ?></td>
    <td><a href="javascript:if (confirm('<?php echo $this->_var['lang']['remove_collection_confirm']; ?>')) location.href='user.php?act=delete_collection&collection_id=<?php echo $this->_var['goods']['rec_id']; ?>'">删除</a>
    &nbsp;<a href="goods.php?id=<?php echo $this->_var['goods']['goods_id']; ?>" title="购买">购买</a></td>
  </tr>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  <input type="hidden" name="act" value="delete_collection" />
  </form>
</table>
    </div>
</div>
    <?php echo $this->fetch('library/pages.lbi'); ?>
  <?php endif; ?>


<?php if ($this->_var['action'] == 'contacts_list'): ?>
<div class="right_pc">
    <div class="r_bt_pc">
       <span>常用联系人</span><em>Frequent contacts</em>
    </div>
    <div class="bdgl_xq">
   <div class="tjlxr_pc"><span><img src="/images/tjr.jpg" alt="联系人"/><a href="user.php?act=contacts_info" title="添加常用联系人" />添加常用联系人</a></span></div> 
   <div style="clear:both;"></div> 
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr class="bt_b">
    <td width="12%">姓名</td>
    <td width="16%">手机号码</td>
    <td width="26%">证件类型及号码</td>
    <td width="29%">居住地址</td>
    <td width="17%">操作</td>
  </tr>
  <?php $_from = $this->_var['contacts_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'contacts');if (count($_from)):
    foreach ($_from AS $this->_var['contacts']):
?>
  <tr>
    <td><?php echo $this->_var['contacts']['name']; ?></td>
    <td><?php echo $this->_var['contacts']['mobile']; ?></td>
    <td>身份证：<?php echo $this->_var['contacts']['zj_number']; ?></td>
    <td><?php echo $this->_var['contacts']['address']; ?></td>
    <td><a href="user.php?act=drop_contacts&id=<?php echo $this->_var['contacts']['contacts_id']; ?>">删除</a>  <a href="user.php?act=contacts_info&id=<?php echo $this->_var['contacts']['contacts_id']; ?>">修改</a></td>
  </tr>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</table>
    </div>
</div>
<?php endif; ?>


<?php if ($this->_var['action'] == 'contacts_info'): ?>
<script>
function g(element){return document.getElementById(element);}
function tijiao(){
	if(!g('name').value){
		alert('请填写姓名')
	}else if(!g('zj_number').value){
		alert('请填写证件号码')
	}else if(!g('email').value){
		alert('请填写邮箱')
	}else if(!g('mobile').value){
		alert('请填写手机号码')
	}else if(!g('address').value){
		alert('请填写居住地址')
	}else{
		g("formcontacts").submit();
	}
}
</script>
<div class="right_pc">
    <div class="r_bt_pc">
       <span>寄送地址</span><em>Ship-to address</em>
    </div>
    <div class="bdgl_xq">
<form id="formcontacts" method="post" action="user.php">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr class="bt_b">
    <td colspan="2"><strong>添加/修改常用联系人</strong></td>
    </tr>
  <tr>
    <td width="23%" class="td_r" align="right" style=" text-align:right;">* 姓名</td>
    <td width="77%" class="td_l" style=" text-align:left;">
      <input class="text_ge" type="text" name="name" id="name" value="<?php echo $this->_var['contacts_info']['name']; ?>" /></td>
  </tr>
  <tr>
    <td class="td_r" align="right" style=" text-align:right;">* 证件号码</td>
    <td class="td_l" style=" text-align:left;"><span class="td_l" style=" text-align:left;">
      <select name="select" id="select">
        <option>身份证</option>
      </select>
      <span class="td_l" style=" text-align:left;">
      <input class="text_ge" type="text" name="zj_number" id="zj_number" value="<?php echo $this->_var['contacts_info']['zj_number']; ?>" />
      </span></span></td>
  </tr>
  <tr>
    <td class="td_r" align="right" style=" text-align:right;">* 邮箱</td>
    <td class="td_l" style=" text-align:left;"><input class="text_ge" type="text" name="email" id="email" value="<?php echo $this->_var['contacts_info']['email']; ?>" /></td>
  </tr>
  <tr>
    <td class="td_r" align="right" style=" text-align:right;">* 手机号码</td>
    <td class="td_l" style=" text-align:left;"><span class="td_l" style=" text-align:left;">
      <input class="text_ge" type="text" name="mobile" id="mobile" value="<?php echo $this->_var['contacts_info']['mobile']; ?>" />
    </span></td>
  </tr>
  <tr>
    <td class="td_r" align="right" style=" text-align:right;"><span class="td_r" style=" text-align:right;">* 居住地址</span></td>
    <td class="td_l" style=" text-align:left;"><span class="td_l" style=" text-align:left;">
      <input class="text_ge" type="text" name="address" id="address" value="<?php echo $this->_var['contacts_info']['address']; ?>" />
    </span></td>
  </tr>
  <input type="hidden" name="contacts_id" value="<?php echo $this->_var['contacts_info']['contacts_id']; ?>" />
  <input type="hidden" name="act" value="act_edit_contacts" />
</table>
</form>
    <div class="tj_pc"> 
      <a href="javascript:tijiao();" title="提  交" >提  交</a>
    </div>    
    </div>
</div>
<?php endif; ?>


<?php if ($this->_var['action'] == 'account_security'): ?>
<script>
function yz_email(){
	Ajax.call('user.php?act=send_hash_mail', 'yz=1', get_back, 'POST', 'JSON');
}
function get_back(msg){
	alert(msg.message);
}
</script>
<div class="right_pc">
    <div class="r_bt_pc">
       <span>账户安全</span><em>Account security</em>
    </div>

    <div class="bdgl_xq">
      <div class="aq_pc_a">
         <div class="yz_pc">
              <ul>
                 <li><img src="/images/yzok.jpg" alt="验证" /></li> 
                 <li class="r_dd">登录密码</li> 
                 <li>已设置</li>
                 <li class="r_cc"><a href="user.php?act=edit_password_info" title="修改">修改</a></li>
              </ul> 
         </div>
         <p>您的密码越复杂账号越安全。建议您设置的密码里包含数字、字母组合，并且长度大于6位。
上次登录时间：<?php echo $this->_var['last_login']; ?></p>
      </div> 
      
      <div class="aq_pc_a">
         <div class="yz_pc">
              <ul>
                 <li><img src="<?php if ($this->_var['is_validated'] == 1): ?>/images/yzok.jpg<?php else: ?>/images/yzng.jpg<?php endif; ?>" alt="验证" /></li> 
                 <li class="r_dd">电子邮箱</li> 
                 <li><?php if ($this->_var['is_validated'] == 1): ?>已验证<?php else: ?>未验证<?php endif; ?></li>
                 <li class="r_cc"><?php if ($this->_var['is_validated'] != 1): ?><a href="javascript:yz_email();" title="验证">验证</a><?php endif; ?><a href="user.php?act=profile" title="修改">修改</a></li>
              </ul> 
         </div>
         <p>当您忘记您的账户密码时，我们会根据您的申请，将重置密码邮件发送到您验证的邮箱中，帮助<br />
         您快速找回登录密码。请确保此邮箱是您的常用邮箱，避免因邮箱服务异常而收不到找回密码邮件。</p>
      </div> 
    </div>
</div>
<?php endif; ?>


<?php if ($this->_var['action'] == 'claim_list'): ?>
<div class="right_pc">
    <div class="r_bt_pc">
       <span>我的理赔申请</span><em>My claim</em>
    </div>
    <div class="bdgl_xq" style=" height:40px;">
        <ul id="tab_a">
        <li class="fli">正在进行（<?php echo $this->_var['jxz']; ?>）</li>
        <li>已结束（<?php echo $this->_var['yjs']; ?>）</li>
        </ul>
        <div id="tab_con">
          <div class="fdiv">
   <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr class="bt_b">
                <td width="15%">申请时间</td>
                <td width="14%">申请人</td>
                <td width="18%">联系电话</td>
                <td width="17%">理赔类型</td>
                <td width="18%">状态</td>
                <td width="18%">操作</td>
              </tr>
              <?php $_from = $this->_var['info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'r');if (count($_from)):
    foreach ($_from AS $this->_var['r']):
?>
              <?php if ($this->_var['r']['msg_status'] == 0): ?>
              <tr>
                <td><?php echo $this->_var['r']['msg_time']; ?></td>
                <td><?php echo $this->_var['r']['ba_name']; ?></td>
                <td><?php echo $this->_var['r']['ba_tel']; ?></td>
                <td><?php echo $this->_var['r']['lp_type']; ?></td>
                <td>进行中</td>
                <td><a href="">查询</a></td>
              </tr>
              <?php endif; ?>
              <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </table>
          </div>
   <div>
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                      <tr class="bt_b">
                        <td width="15%">申请时间</td>
                        <td width="14%">申请人</td>
                        <td width="18%">联系电话</td>
                        <td width="17%">理赔类型</td>
                        <td width="18%">状态</td>
                        <td width="18%">操作</td>
                      </tr>
                      <?php $_from = $this->_var['info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'r');if (count($_from)):
    foreach ($_from AS $this->_var['r']):
?>
                      <?php if ($this->_var['r']['msg_status'] == 1): ?>
                      <tr>
                        <td><?php echo $this->_var['r']['msg_time']; ?></td>
                        <td><?php echo $this->_var['r']['ba_name']; ?></td>
                        <td><?php echo $this->_var['r']['ba_tel']; ?></td>
                        <td><?php echo $this->_var['r']['lp_type']; ?></td>
                        <td>已结束</td>
                        <td><a href="">查询</a></td>
                      </tr>
                      <?php endif; ?>
                      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </table>
          </div>
        </div>
<script type="text/javascript">
var tabs=document.getElementById("tab_a").getElementsByTagName("li");
var divs=document.getElementById("tab_con").getElementsByTagName("div");
for(var i=0;i<tabs.length;i++){
    tabs[i].onclick=function(){change(this);}
}
function change(obj){
   for(var i=0;i<tabs.length;i++)
   {
      if(tabs[i]==obj){
        tabs[i].className="fli";
        divs[i].className="fdiv";
      }
      else{
        tabs[i].className="";
      divs[i].className="";
      }
   }
}
</script>
    </div>
</div>
<?php endif; ?>


<?php if ($this->_var['action'] == 'edit_password_info'): ?>
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
       <span>会员资料</span><em>Member information</em>
    </div>
    <div class="bdgl_xq">
<form name="formPassword" id="formPassword" action="user.php" method="post" onSubmit="return editPassword()" >
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr class="bt_b">
    <td colspan="2"><strong>修改密码</strong></td>
    </tr>
  <tr>
    <td width="23%" class="td_r" align="right" style=" text-align:right;">* 原密码</td>
    <td width="77%" class="td_l" style=" text-align:left;"><input class="text_ge" type="password" name="old_password" /></td>
  </tr>
  <tr>
    <td class="td_r" align="right" style=" text-align:right;">* 新密码</td>
    <td class="td_l" style=" text-align:left;"><input class="text_ge" type="password" name="new_password" /></td>
  </tr>
  <tr>
    <td class="td_r" align="right" style=" text-align:right;">* 确认密码</td>
    <td class="td_l" style=" text-align:left;"><input class="text_ge" type="password" name="comfirm_password" /></td>
  </tr>
  
</table>
    <div class="tj_pc"> 
      <a href="javascript:document.getElementById('formPassword').submit();" title="提  交" >提  交</a>
    </div>
    <input name="act" type="hidden" value="act_edit_password" />
    </form>   
  </div>
</div>
<?php endif; ?>
    
    
    <?php if ($this->_var['action'] == 'booking_list'): ?>
    <h5><span><?php echo $this->_var['lang']['label_booking']; ?></span></h5>
    <div class="blank"></div>
     <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
      <tr align="center">
        <td width="20%" bgcolor="#ffffff"><?php echo $this->_var['lang']['booking_goods_name']; ?></td>
        <td width="10%" bgcolor="#ffffff"><?php echo $this->_var['lang']['booking_amount']; ?></td>
        <td width="20%" bgcolor="#ffffff"><?php echo $this->_var['lang']['booking_time']; ?></td>
        <td width="35%" bgcolor="#ffffff"><?php echo $this->_var['lang']['process_desc']; ?></td>
        <td width="15%" bgcolor="#ffffff"><?php echo $this->_var['lang']['handle']; ?></td>
      </tr>
      <?php $_from = $this->_var['booking_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
      <tr>
        <td align="left" bgcolor="#ffffff"><a href="<?php echo $this->_var['item']['url']; ?>" target="_blank" class="f6"><?php echo $this->_var['item']['goods_name']; ?></a></td>
        <td align="center" bgcolor="#ffffff"><?php echo $this->_var['item']['goods_number']; ?></td>
        <td align="center" bgcolor="#ffffff"><?php echo $this->_var['item']['booking_time']; ?></td>
        <td align="left" bgcolor="#ffffff"><?php echo $this->_var['item']['dispose_note']; ?></td>
        <td align="center" bgcolor="#ffffff"><a href="javascript:if (confirm('<?php echo $this->_var['lang']['confirm_remove_account']; ?>')) location.href='user.php?act=act_del_booking&id=<?php echo $this->_var['item']['rec_id']; ?>'" class="f6"><?php echo $this->_var['lang']['drop']; ?></a> </td>
      </tr>
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </table>
    <?php endif; ?>
    <div class="blank5"></div>
   
  <?php if ($this->_var['action'] == 'add_booking'): ?>
    <?php echo $this->smarty_insert_scripts(array('files'=>'utils.js')); ?>
    <script type="text/javascript">
    <?php $_from = $this->_var['lang']['booking_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
    var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </script>
    <h5><span><?php echo $this->_var['lang']['add']; ?><?php echo $this->_var['lang']['label_booking']; ?></span></h5>
    <div class="blank"></div>
     <form action="user.php" method="post" name="formBooking" onsubmit="return addBooking();">
     <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
      <tr>
        <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['booking_goods_name']; ?></td>
        <td bgcolor="#ffffff"><?php echo $this->_var['info']['goods_name']; ?></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['booking_amount']; ?>:</td>
        <td bgcolor="#ffffff"><input name="number" type="text" value="<?php echo $this->_var['info']['goods_number']; ?>" class="inputBg" /></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['describe']; ?>:</td>
        <td bgcolor="#ffffff"><textarea name="desc" cols="50" rows="5" wrap="virtual" class="B_blue"><?php echo $this->_var['goods_attr']; ?><?php echo htmlspecialchars($this->_var['info']['goods_desc']); ?></textarea>
        </td>
      </tr>
      <tr>
        <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['contact_username']; ?>:</td>
        <td bgcolor="#ffffff"><input name="linkman" type="text" value="<?php echo htmlspecialchars($this->_var['info']['consignee']); ?>" size="25"  class="inputBg"/>
        </td>
      </tr>
      <tr>
        <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['email_address']; ?>:</td>
        <td bgcolor="#ffffff"><input name="email" type="text" value="<?php echo htmlspecialchars($this->_var['info']['email']); ?>" size="25" class="inputBg" /></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['contact_phone']; ?>:</td>
        <td bgcolor="#ffffff"><input name="tel" type="text" value="<?php echo htmlspecialchars($this->_var['info']['tel']); ?>" size="25" class="inputBg" /></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#ffffff">&nbsp;</td>
        <td bgcolor="#ffffff"><input name="act" type="hidden" value="act_add_booking" />
          <input name="id" type="hidden" value="<?php echo $this->_var['info']['id']; ?>" />
          <input name="rec_id" type="hidden" value="<?php echo $this->_var['info']['rec_id']; ?>" />
          <input type="submit" name="submit" class="submit" value="<?php echo $this->_var['lang']['submit_booking_goods']; ?>" />
          <input type="reset" name="reset" class="reset" value="<?php echo $this->_var['lang']['button_reset']; ?>" />
        </td>
      </tr>
    </table>
     </form>
    <?php endif; ?>
    
    <?php if ($this->_var['affiliate']['on'] == 1): ?>
     <?php if ($this->_var['action'] == 'affiliate'): ?>
      <?php if (! $this->_var['goodsid'] || $this->_var['goodsid'] == 0): ?>
      <h5><span><?php echo $this->_var['lang']['affiliate_detail']; ?></span></h5>
      <div class="blank"></div>
     <?php echo $this->_var['affiliate_intro']; ?>
    <?php if ($this->_var['affiliate']['config']['separate_by'] == 0): ?>
    
    <div class="blank"></div>
    <h5><span><a name="myrecommend"><?php echo $this->_var['lang']['affiliate_member']; ?></a></span></h5>
    <div class="blank"></div>
   <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
    <tr align="center">
      <td bgcolor="#ffffff"><?php echo $this->_var['lang']['affiliate_lever']; ?></td>
      <td bgcolor="#ffffff"><?php echo $this->_var['lang']['affiliate_num']; ?></td>
      <td bgcolor="#ffffff"><?php echo $this->_var['lang']['level_point']; ?></td>
      <td bgcolor="#ffffff"><?php echo $this->_var['lang']['level_money']; ?></td>
    </tr>
    <?php $_from = $this->_var['affdb']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('level', 'val');$this->_foreach['affdb'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['affdb']['total'] > 0):
    foreach ($_from AS $this->_var['level'] => $this->_var['val']):
        $this->_foreach['affdb']['iteration']++;
?>
    <tr align="center">
      <td bgcolor="#ffffff"><?php echo $this->_var['level']; ?></td>
      <td bgcolor="#ffffff"><?php echo $this->_var['val']['num']; ?></td>
      <td bgcolor="#ffffff"><?php echo $this->_var['val']['point']; ?></td>
      <td bgcolor="#ffffff"><?php echo $this->_var['val']['money']; ?></td>
    </tr>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  </table>

<?php else: ?>


<?php endif; ?>

<div class="blank"></div>
<h5><span>分成规则</span></h5>
<div class="blank"></div>
<table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
    <tr align="center">
      <td bgcolor="#ffffff"><?php echo $this->_var['lang']['order_number']; ?></td>
      <td bgcolor="#ffffff"><?php echo $this->_var['lang']['affiliate_money']; ?></td>
      <td bgcolor="#ffffff"><?php echo $this->_var['lang']['affiliate_point']; ?></td>
      <td bgcolor="#ffffff"><?php echo $this->_var['lang']['affiliate_mode']; ?></td>
      <td bgcolor="#ffffff"><?php echo $this->_var['lang']['affiliate_status']; ?></td>
    </tr>
    <?php $_from = $this->_var['logdb']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'val');$this->_foreach['logdb'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['logdb']['total'] > 0):
    foreach ($_from AS $this->_var['val']):
        $this->_foreach['logdb']['iteration']++;
?>
    <tr align="center">
      <td bgcolor="#ffffff"><?php echo $this->_var['val']['order_sn']; ?></td>
      <td bgcolor="#ffffff"><?php echo $this->_var['val']['money']; ?></td>
      <td bgcolor="#ffffff"><?php echo $this->_var['val']['point']; ?></td>
      <td bgcolor="#ffffff"><?php if ($this->_var['val']['separate_type'] == 1 || $this->_var['val']['separate_type'] === 0): ?><?php echo $this->_var['lang']['affiliate_type'][$this->_var['val']['separate_type']]; ?><?php else: ?><?php echo $this->_var['lang']['affiliate_type'][$this->_var['affiliate_type']]; ?><?php endif; ?></td>
      <td bgcolor="#ffffff"><?php echo $this->_var['lang']['affiliate_stats'][$this->_var['val']['is_separate']]; ?></td>
    </tr>
    <?php endforeach; else: ?>
<tr><td colspan="5" align="center" bgcolor="#ffffff"><?php echo $this->_var['lang']['no_records']; ?></td>
</tr>
    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
    <?php if ($this->_var['logdb']): ?>
    <tr>
    <td colspan="5" bgcolor="#ffffff">
 <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
  <div id="pager"> <?php echo $this->_var['lang']['pager_1']; ?><?php echo $this->_var['pager']['record_count']; ?><?php echo $this->_var['lang']['pager_2']; ?><?php echo $this->_var['lang']['pager_3']; ?><?php echo $this->_var['pager']['page_count']; ?><?php echo $this->_var['lang']['pager_4']; ?> <span> <a href="<?php echo $this->_var['pager']['page_first']; ?>"><?php echo $this->_var['lang']['page_first']; ?></a> <a href="<?php echo $this->_var['pager']['page_prev']; ?>"><?php echo $this->_var['lang']['page_prev']; ?></a> <a href="<?php echo $this->_var['pager']['page_next']; ?>"><?php echo $this->_var['lang']['page_next']; ?></a> <a href="<?php echo $this->_var['pager']['page_last']; ?>"><?php echo $this->_var['lang']['page_last']; ?></a> </span>
    <select name="page" id="page" onchange="selectPage(this)">
    <?php echo $this->html_options(array('options'=>$this->_var['pager']['array'],'selected'=>$this->_var['pager']['page'])); ?>
    </select>
    <input type="hidden" name="act" value="affiliate" />
  </div>
</form>
    </td>
    </tr>
    <?php endif; ?>
  </table>
 <script type="text/javascript" language="JavaScript">
<!--

function selectPage(sel)
{
  sel.form.submit();
}

//-->
</script>

<div class="blank"></div>
<h5><span><?php echo $this->_var['lang']['affiliate_code']; ?></span></h5>
<div class="blank"></div>
<table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
<tr>
<td width="30%" bgcolor="#ffffff"><a href="<?php echo $this->_var['shopurl']; ?>?u=<?php echo $this->_var['userid']; ?>" target="_blank" class="f6"><?php echo $this->_var['shopname']; ?></a></td>
<td bgcolor="#ffffff"><input size="40" onclick="this.select();" type="text" value="&lt;a href=&quot;<?php echo $this->_var['shopurl']; ?>?u=<?php echo $this->_var['userid']; ?>&quot; target=&quot;_blank&quot;&gt;<?php echo $this->_var['shopname']; ?>&lt;/a&gt;" style="border:1px solid #ccc;" /> <?php echo $this->_var['lang']['recommend_webcode']; ?></td>
</tr>
<tr>
<td bgcolor="#ffffff"><a href="<?php echo $this->_var['shopurl']; ?>?u=<?php echo $this->_var['userid']; ?>" target="_blank" title="<?php echo $this->_var['shopname']; ?>"  class="f6"><img src="<?php echo $this->_var['shopurl']; ?><?php echo $this->_var['logosrc']; ?>" /></a></td>
<td bgcolor="#ffffff"><input size="40" onclick="this.select();" type="text" value="&lt;a href=&quot;<?php echo $this->_var['shopurl']; ?>?u=<?php echo $this->_var['userid']; ?>&quot; target=&quot;_blank&quot; title=&quot;<?php echo $this->_var['shopname']; ?>&quot;&gt;&lt;img src=&quot;<?php echo $this->_var['shopurl']; ?><?php echo $this->_var['logosrc']; ?>&quot; /&gt;&lt;/a&gt;" style="border:1px solid #ccc;" /> <?php echo $this->_var['lang']['recommend_webcode']; ?></td>
</tr>
<tr>
<td bgcolor="#ffffff"><a href="<?php echo $this->_var['shopurl']; ?>?u=<?php echo $this->_var['userid']; ?>" target="_blank" class="f6"><?php echo $this->_var['shopname']; ?></a></td>
<td bgcolor="#ffffff"><input size="40" onclick="this.select();" type="text" value="[url=<?php echo $this->_var['shopurl']; ?>?u=<?php echo $this->_var['userid']; ?>]<?php echo $this->_var['shopname']; ?>[/url]" style="border:1px solid #ccc;" /> <?php echo $this->_var['lang']['recommend_bbscode']; ?></td>
</tr>
<tr>
<td bgcolor="#ffffff"><a href="<?php echo $this->_var['shopurl']; ?>?u=<?php echo $this->_var['userid']; ?>" target="_blank" title="<?php echo $this->_var['shopname']; ?>" class="f6"><img src="<?php echo $this->_var['shopurl']; ?><?php echo $this->_var['logosrc']; ?>" /></a></td>
<td bgcolor="#ffffff"><input size="40" onclick="this.select();" type="text" value="[url=<?php echo $this->_var['shopurl']; ?>?u=<?php echo $this->_var['userid']; ?>][img]<?php echo $this->_var['shopurl']; ?><?php echo $this->_var['logosrc']; ?>[/img][/url]" style="border:1px solid #ccc;" /> <?php echo $this->_var['lang']['recommend_bbscode']; ?></td>
</tr>
</table>

        <?php else: ?>
        
        <style type="text/css">
        .types a{text-decoration:none; color:#006bd0;}
        </style>
    <h5><span><?php echo $this->_var['lang']['affiliate_code']; ?></span></h5>
    <div class="blank"></div>
  <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
    <tr align="center">
      <td bgcolor="#ffffff"><?php echo $this->_var['lang']['affiliate_view']; ?></td>
      <td bgcolor="#ffffff"><?php echo $this->_var['lang']['affiliate_code']; ?></td>
    </tr>
    <?php $_from = $this->_var['types']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'val');$this->_foreach['types'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['types']['total'] > 0):
    foreach ($_from AS $this->_var['val']):
        $this->_foreach['types']['iteration']++;
?>
    <tr align="center">
      <td bgcolor="#ffffff" class="types"><script src="<?php echo $this->_var['shopurl']; ?>affiliate.php?charset=<?php echo $this->_var['ecs_charset']; ?>&gid=<?php echo $this->_var['goodsid']; ?>&u=<?php echo $this->_var['userid']; ?>&type=<?php echo $this->_var['val']; ?>"></script></td>
      <td bgcolor="#ffffff">javascript <?php echo $this->_var['lang']['affiliate_codetype']; ?><br>
        <textarea cols=30 rows=2 id="txt<?php echo $this->_foreach['types']['iteration']; ?>" style="border:1px solid #ccc;"><script src="<?php echo $this->_var['shopurl']; ?>affiliate.php?charset=<?php echo $this->_var['ecs_charset']; ?>&gid=<?php echo $this->_var['goodsid']; ?>&u=<?php echo $this->_var['userid']; ?>&type=<?php echo $this->_var['val']; ?>"></script></textarea>[<a href="#" title="Copy To Clipboard" onClick="Javascript:copyToClipboard(document.getElementById('txt<?php echo $this->_foreach['types']['iteration']; ?>').value);alert('<?php echo $this->_var['lang']['copy_to_clipboard']; ?>');"  class="f6"><?php echo $this->_var['lang']['code_copy']; ?></a>]
<br>iframe <?php echo $this->_var['lang']['affiliate_codetype']; ?><br><textarea cols=30 rows=2 id="txt<?php echo $this->_foreach['types']['iteration']; ?>_iframe"  style="border:1px solid #ccc;"><iframe width="250" height="270" src="<?php echo $this->_var['shopurl']; ?>affiliate.php?charset=<?php echo $this->_var['ecs_charset']; ?>&gid=<?php echo $this->_var['goodsid']; ?>&u=<?php echo $this->_var['userid']; ?>&type=<?php echo $this->_var['val']; ?>&display_mode=iframe" frameborder="0" scrolling="no"></iframe></textarea>[<a href="#" title="Copy To Clipboard" onClick="Javascript:copyToClipboard(document.getElementById('txt<?php echo $this->_foreach['types']['iteration']; ?>_iframe').value);alert('<?php echo $this->_var['lang']['copy_to_clipboard']; ?>');" class="f6"><?php echo $this->_var['lang']['code_copy']; ?></a>]
<br /><?php echo $this->_var['lang']['bbs']; ?>UBB <?php echo $this->_var['lang']['affiliate_codetype']; ?><br /><textarea cols=30 rows=2 id="txt<?php echo $this->_foreach['types']['iteration']; ?>_ubb"  style="border:1px solid #ccc;"><?php if ($this->_var['val'] != 5): ?>[url=<?php echo $this->_var['shopurl']; ?>goods.php?id=<?php echo $this->_var['goodsid']; ?>&u=<?php echo $this->_var['userid']; ?>][img]<?php if ($this->_var['val'] < 3): ?><?php echo $this->_var['goods']['goods_thumb']; ?><?php else: ?><?php echo $this->_var['goods']['goods_img']; ?><?php endif; ?>[/img][/url]<?php endif; ?>

[url=<?php echo $this->_var['shopurl']; ?>goods.php?id=<?php echo $this->_var['goodsid']; ?>&u=<?php echo $this->_var['userid']; ?>][b]<?php echo $this->_var['goods']['goods_name']; ?>[/b][/url]
<?php if ($this->_var['val'] != 1 && $this->_var['val'] != 3): ?>[s]<?php echo $this->_var['goods']['market_price']; ?>[/s]<?php endif; ?> [color=red]<?php echo $this->_var['goods']['shop_price']; ?>[/color]</textarea>[<a href="#" title="Copy To Clipboard" onClick="Javascript:copyToClipboard(document.getElementById('txt<?php echo $this->_foreach['types']['iteration']; ?>_ubb').value);alert('<?php echo $this->_var['lang']['copy_to_clipboard']; ?>');"  class="f6"><?php echo $this->_var['lang']['code_copy']; ?></a>]
<?php if ($this->_var['val'] == 5): ?><br /><?php echo $this->_var['lang']['im_code']; ?> <?php echo $this->_var['lang']['affiliate_codetype']; ?><br /><textarea cols=30 rows=2 id="txt<?php echo $this->_foreach['types']['iteration']; ?>_txt"  style="border:1px solid #ccc;"><?php echo $this->_var['lang']['show_good_to_you']; ?> <?php echo $this->_var['goods']['goods_name']; ?>

<?php echo $this->_var['shopurl']; ?>goods.php?id=<?php echo $this->_var['goodsid']; ?>&u=<?php echo $this->_var['userid']; ?></textarea>[<a href="#" title="Copy To Clipboard" onClick="Javascript:copyToClipboard(document.getElementById('txt<?php echo $this->_foreach['types']['iteration']; ?>_txt').value);alert('<?php echo $this->_var['lang']['copy_to_clipboard']; ?>');"  class="f6"><?php echo $this->_var['lang']['code_copy']; ?></a>]<?php endif; ?></td>
    </tr>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  </table>
<script language="Javascript">
copyToClipboard = function(txt)
{
 if(window.clipboardData)
 {
    window.clipboardData.clearData();
    window.clipboardData.setData("Text", txt);
 }
 else if(navigator.userAgent.indexOf("Opera") != -1)
 {
   //暂时无方法:-(
 }
 else if (window.netscape)
 {
  try
  {
    netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
  }
  catch (e)
  {
    alert("<?php echo $this->_var['lang']['firefox_copy_alert']; ?>");
    return false;
  }
  var clip = Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard);
  if (!clip)
    return;
  var trans = Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable);
  if (!trans)
    return;
  trans.addDataFlavor('text/unicode');
  var str = new Object();
  var len = new Object();
  var str = Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);
  var copytext = txt;
  str.data = copytext;
  trans.setTransferData("text/unicode",str,copytext.length*2);
  var clipid = Components.interfaces.nsIClipboard;
  if (!clip)
  return false;
  clip.setData(trans,null,clipid.kGlobalClipboard);
 }
}
                </script>
            
            <?php endif; ?>
        <?php endif; ?>

    <?php endif; ?>

  
  </div>
  
</div>

<?php if ($this->_var['action'] == 'default'): ?>

<div style="clear:both;"></div>

<br /><br /><br />

 
 <div class="cnxh_pc_bt">
 猜你喜欢：
 </div>
 
    <div class="rollBox">
      <div class="LeftBotton" onmousedown="ISL_GoUp()" onmouseup="ISL_StopUp()" onmouseout="ISL_StopUp()"></div>
      <div class="Cont" id="ISL_Cont" style="  margin-left:20px;">
        <div class="ScrCont">
          <div id="List1">
            
            <?php $_from = $this->_var['hot_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'r');if (count($_from)):
    foreach ($_from AS $this->_var['r']):
?>
            <div class="pic"> <a href="goods.php?id=<?php echo $this->_var['r']['id']; ?>" target="_blank"><img src="/<?php echo $this->_var['r']['goods_img']; ?>" width="109" height="87" /></a>
              <p><a href="goods.php?id=<?php echo $this->_var['r']['id']; ?>" target="_blank"><?php echo $this->_var['r']['short_name']; ?></a><br />
                <span><?php echo $this->_var['r']['shop_price']; ?></span></p>
            </div>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
              
       </div>
       <div id="List2"></div>
      </div>
     </div>
     <div class="RightBotton" onmousedown="ISL_GoDown()" onmouseup="ISL_StopDown()" onmouseout="ISL_StopDown()"></div>
    </div>

<script language="javascript" type="text/javascript">

//图片滚动列表 sitejs.cn
var Speed = 1; //速度(毫秒)
var Space = 5; //每次移动(px)
var PageWidth = 528; //翻页宽度
var fill = 0; //整体移位
var MoveLock = false;
var MoveTimeObj;
var Comp = 0;
var AutoPlayObj = null;
GetObj("List2").innerHTML = GetObj("List1").innerHTML;
GetObj('ISL_Cont').scrollLeft = fill;
GetObj("ISL_Cont").onmouseover = function(){clearInterval(AutoPlayObj);}
GetObj("ISL_Cont").onmouseout = function(){AutoPlay();}
AutoPlay();
function GetObj(objName){if(document.getElementById){return eval('document.getElementById("'+objName+'")')}else{return eval('document.all.'+objName)}}
function AutoPlay(){ //自动滚动
 clearInterval(AutoPlayObj);
 AutoPlayObj = setInterval('ISL_GoDown();ISL_StopDown();',3000); //间隔时间
}
function ISL_GoUp(){ //上翻开始
 if(MoveLock) return;
 clearInterval(AutoPlayObj);
 MoveLock = true;
 MoveTimeObj = setInterval('ISL_ScrUp();',Speed);
}
function ISL_StopUp(){ //上翻停止
 clearInterval(MoveTimeObj);
 if(GetObj('ISL_Cont').scrollLeft % PageWidth - fill != 0){
  Comp = fill - (GetObj('ISL_Cont').scrollLeft % PageWidth);
  CompScr();
 }else{
  MoveLock = false;
 }
 AutoPlay();
}
function ISL_ScrUp(){ //上翻动作
 if(GetObj('ISL_Cont').scrollLeft <= 0){GetObj('ISL_Cont').scrollLeft = GetObj('ISL_Cont').scrollLeft + GetObj('List1').offsetWidth}
 GetObj('ISL_Cont').scrollLeft -= Space ;
}
function ISL_GoDown(){ //下翻
 clearInterval(MoveTimeObj);
 if(MoveLock) return;
 clearInterval(AutoPlayObj);
 MoveLock = true;
 ISL_ScrDown();
 MoveTimeObj = setInterval('ISL_ScrDown()',Speed);
}
function ISL_StopDown(){ //下翻停止
 clearInterval(MoveTimeObj);
 if(GetObj('ISL_Cont').scrollLeft % PageWidth - fill != 0 ){
  Comp = PageWidth - GetObj('ISL_Cont').scrollLeft % PageWidth + fill;
  CompScr();
 }else{
  MoveLock = false;
 }
 AutoPlay();
}
function ISL_ScrDown(){ //下翻动作
 if(GetObj('ISL_Cont').scrollLeft >= GetObj('List1').scrollWidth){GetObj('ISL_Cont').scrollLeft = GetObj('ISL_Cont').scrollLeft - GetObj('List1').scrollWidth;}
 GetObj('ISL_Cont').scrollLeft += Space ;
}
function CompScr(){
 var num;
 if(Comp == 0){MoveLock = false;return;}
 if(Comp < 0){ //上翻
  if(Comp < -Space){
   Comp += Space;
   num = Space;
  }else{
   num = -Comp;
   Comp = 0;
  }
  GetObj('ISL_Cont').scrollLeft -= num;
  setTimeout('CompScr()',Speed);
 }else{ //下翻
  if(Comp > Space){
   Comp -= Space;
   num = Space;
  }else{
   num = Comp;
   Comp = 0;
  }
  GetObj('ISL_Cont').scrollLeft += num;
  setTimeout('CompScr()',Speed);
 }
}

</script>
<?php endif; ?>

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
