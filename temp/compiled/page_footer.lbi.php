<div class="clear"></div>
 <div class="w_bottom_b">
   <div class="w_bottom_c">
     <div class="w_bottom_s">
	   <img src="/images/w_ewms.jpg" title="��ά��" alt="��ά��"/>
	   <dl>
	     <dt>����ָ��</dt>
		 <dd><a href="" title="���ע��">���ע��</a></dd>
		 <dd><a href="" title="���Ͷ��">���Ͷ��</a></dd>
		 <dd><a href="" title="�Ż�ȯʹ��">�Ż�ȯʹ��</a></dd>
		 <dd><a href="" title="��Ҫ��Ʊ">��Ҫ��Ʊ</a></dd>
		 <dd><a href="" title="����˵��">����˵��</a></dd>
	   </dl>
	   <dl>
	     <dt>�������</dt>
		 <dd><a href="article.php?id=34" title="����ָ��">����ָ��</a></dd>
		 <dd><a href="article.php?id=35" title="��������">��������</a></dd>
		 <dd><a href="article_cat.php?id=25" title="���ⰸ��">���ⰸ��</a></dd>
		 <dd><a href="article_cat.php?id=26" title="����ר��">����ר��</a></dd>
	   </dl>
	   <dl>
	     <dt>��������</dt>
		 <dd><a href="article.php?id=17" title="���������ۺϷ���">���������ۺϷ���</a></dd>
		 <dd><a href="article.php?id=18" title="�³������ۺϷ���">�³������ۺϷ���</a></dd>
		 <dd><a href="article.php?id=19" title="����������ƾ�ۺϷ���">����������ƾ�ۺϷ���</a></dd>
		 <dd><a href="article.php?id=20" title="��ֵ����">��ֵ����</a></dd>
		 <dd><a href="article.php?id=21" title="���ֳ��ۺϷ���">���ֳ��ۺϷ���</a></dd>
         <dd><a href="article_cat.php?id=11" title="�������">�������</a></dd>
	   </dl>
	   <dl>
	     <dt>��������</dt>
		 <dd><a href="article.php?id=5"  title="��˾���">��˾���</a></dd>
		 <dd><a href="article.php?id=15" title="��˾����">��˾����</a></dd>
		 <dd><a href="article.php?id=14" title="ҵ��Χ">ҵ��Χ</a></dd>
		 <dd><a href="article.php?id=16" title="��ҵ�Ļ�">��ҵ�Ļ�</a></dd>
         <dd><a href="article.php?id=43" title="��������Ϣ��¶">��������Ϣ��¶</a></dd>
	   </dl>
	   
	 </div>
	 <div class="w_bottom_x">
		 <?php if ($this->_var['txt_links']): ?><p class="f_link">��������:
		 <?php $_from = $this->_var['txt_links']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('k', 'link');$this->_foreach['link'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['link']['total'] > 0):
    foreach ($_from AS $this->_var['k'] => $this->_var['link']):
        $this->_foreach['link']['iteration']++;
?>
           <a href="<?php echo $this->_var['link']['url']; ?>" target="_blank" title="<?php echo $this->_var['link']['name']; ?>"><?php echo $this->_var['link']['name']; ?></a>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </p>
		 <?php endif; ?>
	   <p>
	   <a href="article.php?id=5" title="��������">��������</a>-
	   <a href="article.php?id=15" title="ִҵ֤��">ִҵ֤��</a>-
	   <a href="article.php?id=34" title="��������">��������</a>-
	   <a href="article_cat.php?id=10" title="�ͻ�����">�ͻ�����</a>-
	   <a href="article.php?id=5" title="��ϵ����">��ϵ����</a>-
       <a href="http://761671.cicp.net/login.html" title="OA�칫">OA�칫</a>-
	   <a href="" title="��������">��������</a>-
	   <a href="article.php?cat_id=-1" title="�û�Э��">�û�Э��</a>-
	   <a href="" title="��˽����">��˽����</a>-
	   <a href="sitemap.php" title="վ���ͼ">վ���ͼ</a>
		   <script type="text/javascript">
			   var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
			   document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F7e9c257b1e8cb4d2b017d6c46db859dd' type='text/javascript'%3E%3C/script%3E"));
		   </script>
	   </p>
	   <p>��Ȩ���� Copyright(C)2014-2016 ��ICP��16001636 �������վ���</p>
	 </div>
   </div>
 </div>
 <div class="w_sycb">
   <ul>
     <li>
	   <a href="javascript:;" title="΢�Ŷ�ά��" class="w_sycb_1"></a>
	   <div class="w_sycb_d1"><img src="/images/w_ewms.jpg" alt="΢�Ŷ�ά��" title="΢�Ŷ�ά��" /></div>
	 </li>
	   <?php $_from = $this->_var['qq']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'im');if (count($_from)):
    foreach ($_from AS $this->_var['im']):
?>
	   <?php if ($this->_var['im']): ?>
	   <li> <a href="http://wpa.qq.com/msgrd?v=1&amp;uin=<?php echo $this->_var['im']; ?>&amp;site=<?php echo $this->_var['shop_name']; ?>&amp;menu=yes" target="_blank"  class="w_sycb_2">
	   </a> </li>
	   <?php endif; ?>
	   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	 <li>
	   <a  href="javascript:;" title="���ض���" class="w_sycb_3"></a>
	 </li>
   </ul>
 </div>
 <script type="text/javascript" src="/js/qiye.js"></script>
 <script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?7e9c257b1e8cb4d2b017d6c46db859dd";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>