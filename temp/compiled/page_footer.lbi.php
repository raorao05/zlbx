<div class="clear"></div>
 <div class="w_bottom_b">
   <div class="w_bottom_c">
     <div class="w_bottom_s">
	   <img src="/images/w_ewms.jpg" title="二维码" alt="二维码"/>
	   <dl>
	     <dt>购物指南</dt>
		 <dd><a href="" title="如何注册">如何注册</a></dd>
		 <dd><a href="" title="如何投保">如何投保</a></dd>
		 <dd><a href="" title="优惠券使用">优惠券使用</a></dd>
		 <dd><a href="" title="索要发票">索要发票</a></dd>
		 <dd><a href="" title="积分说明">积分说明</a></dd>
	   </dl>
	   <dl>
	     <dt>理赔服务</dt>
		 <dd><a href="article.php?id=34" title="理赔指南">理赔指南</a></dd>
		 <dd><a href="article.php?id=35" title="车险理赔">车险理赔</a></dd>
		 <dd><a href="article_cat.php?id=25" title="理赔案例">理赔案例</a></dd>
		 <dd><a href="article_cat.php?id=26" title="下载专区">下载专区</a></dd>
	   </dl>
	   <dl>
	     <dt>服务中心</dt>
		 <dd><a href="article.php?id=17" title="汽车保险综合服务">汽车保险综合服务</a></dd>
		 <dd><a href="article.php?id=18" title="新车代购综合服务">新车代购综合服务</a></dd>
		 <dd><a href="article.php?id=19" title="汽车融资租凭综合服务">汽车融资租凭综合服务</a></dd>
		 <dd><a href="article.php?id=20" title="增值服务">增值服务</a></dd>
		 <dd><a href="article.php?id=21" title="二手车综合服务">二手车综合服务</a></dd>
         <dd><a href="article_cat.php?id=11" title="网点服务">网点服务</a></dd>
	   </dl>
	   <dl>
	     <dt>关于我们</dt>
		 <dd><a href="article.php?id=5"  title="公司简介">公司简介</a></dd>
		 <dd><a href="article.php?id=15" title="公司资质">公司资质</a></dd>
		 <dd><a href="article.php?id=14" title="业务范围">业务范围</a></dd>
		 <dd><a href="article.php?id=16" title="企业文化">企业文化</a></dd>
         <dd><a href="article.php?id=43" title="互联网信息披露">互联网信息披露</a></dd>
	   </dl>
	   
	 </div>
	 <div class="w_bottom_x">
		 <?php if ($this->_var['txt_links']): ?><p class="f_link">友情链接:
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
	   <a href="article.php?id=5" title="关于我们">关于我们</a>-
	   <a href="article.php?id=15" title="执业证书">执业证书</a>-
	   <a href="article.php?id=34" title="帮助中心">帮助中心</a>-
	   <a href="article_cat.php?id=10" title="客户服务">客户服务</a>-
	   <a href="article.php?id=5" title="联系我们">联系我们</a>-
       <a href="http://761671.cicp.net/login.html" title="OA办公">OA办公</a>-
	   <a href="" title="法律声明">法律声明</a>-
	   <a href="article.php?cat_id=-1" title="用户协议">用户协议</a>-
	   <a href="" title="隐私策略">隐私策略</a>-
	   <a href="sitemap.php" title="站点地图">站点地图</a>
		   <script type="text/javascript">
			   var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
			   document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F7e9c257b1e8cb4d2b017d6c46db859dd' type='text/javascript'%3E%3C/script%3E"));
		   </script>
	   </p>
	   <p>版权所有 Copyright(C)2014-2016 湘ICP备16001636 中联保险经纪</p>
	 </div>
   </div>
 </div>
 <div class="w_sycb">
   <ul>
     <li>
	   <a href="javascript:;" title="微信二维码" class="w_sycb_1"></a>
	   <div class="w_sycb_d1"><img src="/images/w_ewms.jpg" alt="微信二维码" title="微信二维码" /></div>
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
	   <a  href="javascript:;" title="返回顶部" class="w_sycb_3"></a>
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