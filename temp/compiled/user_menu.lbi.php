<!--<div class="userMenu">
<a href="user.php" <?php if ($this->_var['action'] == 'default'): ?>class="curs"<?php endif; ?>><img src="themes/default/images/u1.gif"> <?php echo $this->_var['lang']['label_welcome']; ?></a>
<a href="user.php?act=profile"<?php if ($this->_var['action'] == 'profile'): ?>class="curs"<?php endif; ?>><img src="themes/default/images/u2.gif"> <?php echo $this->_var['lang']['label_profile']; ?></a>
<a href="user.php?act=order_list"<?php if ($this->_var['action'] == 'order_list' || $this->_var['action'] == 'order_detail'): ?>class="curs"<?php endif; ?>><img src="themes/default/images/u3.gif"> <?php echo $this->_var['lang']['label_order']; ?></a>
<a href="user.php?act=address_list"<?php if ($this->_var['action'] == 'address_list'): ?>class="curs"<?php endif; ?>><img src="themes/default/images/u4.gif"> <?php echo $this->_var['lang']['label_address']; ?></a>
<a href="user.php?act=collection_list"<?php if ($this->_var['action'] == 'collection_list'): ?>class="curs"<?php endif; ?>><img src="themes/default/images/u5.gif"> <?php echo $this->_var['lang']['label_collection']; ?></a>
<a href="user.php?act=comment_list"<?php if ($this->_var['action'] == 'comment_list'): ?>class="curs"<?php endif; ?>><img src="themes/default/images/u11.gif"> <?php echo $this->_var['lang']['label_comment']; ?></a>

<a href="user.php?act=logout" style="background:none; text-align:right; margin-right:10px;"><img src="themes/default/images/bnt_sign.gif"></a>
</div>-->
<div class="left_top">��Ա����</div>
  <div class="div2">Ͷ������</div>
      <div class="div3" <?php if ($this->_var['action'] == 'order_list' || $this->_var['action'] == 'bd_list'): ?>style="display:block;"<?php endif; ?>>
          <ul>
              <li><a href="user.php?act=order_list" title="��������" >��������</a></li>
              <li><a href="user.php?act=bd_list" title="��������" >��������</a></li>
          </ul>
     </div>
    <div class="div2">�˻�����</div>
      <div class="div3" <?php if ($this->_var['action'] == 'profile' || $this->_var['action'] == 'address_list' || $this->_var['action'] == 'account_security' || $this->_var['action'] == 'contacts_list' || $this->_var['action'] == 'collection_list'): ?>style="display:block;"<?php endif; ?>>
      <ul>
		<li><a href="user.php?act=profile" title="��Ա����" >��Ա����</a></li>
		<li><a href="user.php?act=address_list" title="���͵�ַ" >���͵�ַ</a></li>
        <li><a href="user.php?act=account_security" title="�˻���ȫ" >�˻���ȫ</a></li>
		<li><a href="user.php?act=contacts_list" title="������ϵ��" >������ϵ��</a></li>
        <li><a href="user.php?act=collection_list" title="�ҵ��ղؼ�" >�ҵ��ղؼ�</a></li>
        </ul>
  </div>
    <div class="div2">�������</div>
      <div class="div3" <?php if ($this->_var['action'] == 'claim_list'): ?>style="display:block;"<?php endif; ?>>
      <ul>
		<li><a href="article_cat.php?id=29" title="��Ҫ����" >��Ҫ����</a></li>
		<li><a href="user.php?act=claim_list" title="�ҵ���������" >�ҵ���������</a></li>
      </ul>
  </div>
  <div class="div2">����/�Ż�</div>
      <div class="div3">
      <ul>
		<li><a href="" title="" >�ҵĻ���</a></li>
		<li><a href="" title="" >�ҵ��Ż�ȯ</a></li>
       </ul>
     </div>
  <div class="div2"><span onClick="document.location.href='user.php?act=logout'">��ȫ�˳�</span></div>