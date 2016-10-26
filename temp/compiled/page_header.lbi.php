<?php echo $this->smarty_insert_scripts(array('files'=>'jquery.json-2.4.min.js')); ?>
<div class="w_top1_bd">
    <div class="w_top1_center">
	  <div class="w_top1_l">
	    <span>你好！欢迎来到中联保险！</span>
        <?php 
$k = array (
  'name' => 'member_info',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?>
        
	  </div>
	  <div class="w_top1_r">
	    <ul>
		  <li class="w_topr_1"><a href="flow.php" title="购物车"><i></i>购物车（<span><?php 
$k = array (
  'name' => 'cart_info',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?></span>）</a></li><em>|</em>
		  <li class="w_topr_2">
		  <a href="user.php?act=collection_list" title="收藏夹">收藏夹</a>
		  </li><em>|</em>
		  <li class="w_topr_2">
		   <a href="user.php" title="会员中心">会员中心<i></i></a>
		   <div class="w_scj_1">
		   <a href="user.php?act=profile" title="用户信息">用户信息</a>
		   <a href="user.php?act=order_list" title="我的订单">我的订单</a>
		   <a href="user.php?act=comment_list" title="我的评论">我的评论</a>
		  </div>
		  </li>
		  <li class="w_topr_3"><i></i><b>0731-82808053</b></li>
		</ul>
	  </div>
	</div>
  </div>
  <div class="w_top2_bd"> 
    <div class="w_top2_center">
	  <div class="w_logo1"><a href="index.php" title="中联保险"><img src="/images/w_logo1.png" title="中联保险" alt="中联保险"/></a></div>
	  <div class="w_logo2"><img src="/images/w_logo2.png" title="中联保险" alt="中联保险"/></div>
	  <div class="w_sosou">
	   <div class="w_sosou1">
	    <i></i>
		<form id="searchForm" name="searchForm" method="get" action="search.php" onSubmit="return checkSearchForm()">
        <input type="text" name="keywords" placeholder="请输入关键字" class="w_ss_in1" />
		<input type="submit" value="搜索" class="w_ss_in2" />
        </form>
	   </div>
	   
	   <?php if ($this->_var['searchkeywords']): ?>
           <div class="w_sosou2">
	        热词：
			<?php $_from = $this->_var['searchkeywords']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'val');$this->_foreach['searchkeywords'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['searchkeywords']['total'] > 0):
    foreach ($_from AS $this->_var['val']):
        $this->_foreach['searchkeywords']['iteration']++;
?>
			   <a href="search.php?keywords=<?php echo urlencode($this->_var['val']); ?>" target="_blank"><?php echo $this->_var['val']; ?></a><?php if (! ($this->_foreach['searchkeywords']['iteration'] == $this->_foreach['searchkeywords']['total'])): ?>|<?php endif; ?>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			</div>
		<?php endif; ?>
	   
	  </div>
    </div>
  </div>	
  <div class="w_top3_bd"> 
    <div class="w_top3_center">
	  <div class="w_top3_l">
	    <span style=" cursor:pointer" onclick="$('.w_top3_2').slideToggle(500)">保险分类</span>
		<div class="w_top3_2" style="display:none;">
		  <?php $_from = $this->_var['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('k', 'cat');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['cat']):
?>
         <dl>
		    <dt class="w_top3_dt<?php echo $this->_var['k']; ?>">	<a href="category.php?id=<?php echo $this->_var['cat']['id']; ?>"><?php echo $this->_var['cat']['name']; ?></a>
			<em>
				<?php $_from = $this->_var['cat']['cat_id']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'catss');$this->_foreach['sb'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['sb']['total'] > 0):
    foreach ($_from AS $this->_var['catss']):
        $this->_foreach['sb']['iteration']++;
?>
				<?php if ($this->_foreach['sb']['iteration'] < 4): ?>
				<a href="category.php?id=<?php echo $this->_var['catss']['id']; ?>" title="<?php echo $this->_var['catss']['name']; ?>"><?php echo $this->_var['catss']['name']; ?></a>
				<?php endif; ?>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				</em>
				</dt>
			<dd>
			  <?php $_from = $this->_var['cat']['cat_id']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cats');$this->_foreach['ssb'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['ssb']['total'] > 0):
    foreach ($_from AS $this->_var['cats']):
        $this->_foreach['ssb']['iteration']++;
?>
			  <?php if ($this->_foreach['ssb']['iteration'] >= 4): ?>
	
              <a href="category.php?id=<?php echo $this->_var['cats']['id']; ?>" title="<?php echo $this->_var['cats']['name']; ?>"><?php echo $this->_var['cats']['name']; ?></a>
			  <?php endif; ?>
			  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

			</dd>
		  </dl>
         <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</div>
	  </div>
	  <ul class="w_top3_u">
	    <li><a href="index.php" title="首页">首页</a></li>
		<li <?php if ($this->_var['article']['cat_id'] == 4 && $this->_var['article']['article_id'] != 33): ?>class="w_dq_a"<?php endif; ?>><a href="article.php?id=5" title="关于中联">关于中联</a></li>
		<li <?php if ($this->_var['catid'] == 5): ?>class="w_dq_a"<?php endif; ?>><a href="article_cat.php?id=6" title="新闻中心">新闻中心</a></li>
		<li <?php if ($this->_var['catid'] == 10): ?>class="w_dq_a"<?php endif; ?>><a href="article_cat.php?id=10" title="汽车服务">汽车服务</a></li>
		<li <?php if ($this->_var['intro'] == 'best'): ?>class="w_dq_a"<?php endif; ?>><a href="search.php?intro=best" title="推荐产品">推荐产品</a></li>
		<li <?php if ($this->_var['catid'] == 12): ?>class="w_dq_a"<?php endif; ?>><a href="article_cat.php?id=13" title="保险学院">保险学院</a></li>
		<li <?php if ($this->_var['parent_id'] == 22): ?>class="w_dq_a"<?php endif; ?>><a href="article.php?id=34" title="理赔服务">理赔服务</a></li>
		<li <?php if ($this->_var['article']['article_id'] == 33): ?>class="w_dq_a"<?php endif; ?>><a href="article.php?id=33" title="人员招聘">人员招聘</a></li>                                                                                         
	  </ul>
	</div>
 </div>	
 <div class="clear"></div>