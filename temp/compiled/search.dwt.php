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

<?php echo $this->smarty_insert_scripts(array('files'=>'jquery.js,jquery.json-2.4.min.js')); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'common.js,global.js,compare.js')); ?>
</head>
<body>
<?php echo $this->fetch('library/page_header.lbi'); ?>
<div class="w_center"> 
   <div class="w_dqwz"><?php echo $this->fetch('library/ur_here.lbi'); ?></div>
   <div class="w_cplb_l">
	 <div class="w_cplb_l2">
	   <span class="w_cplb_s1">共<?php echo $this->_var['pager']['record_count']; ?>个产品</span>
	   <div class="w_cplb_l2_1">
	     <b>排序：</b>
		 <a href="search.php?intro=<?php echo $this->_var['intro']; ?>&display=<?php echo $this->_var['pager']['display']; ?>&brand=<?php echo $this->_var['pager']['search']['brand']; ?>&min_price=<?php echo $this->_var['min_price']; ?>&max_price=<?php echo $this->_var['max_price']; ?>&page=<?php echo $this->_var['pager']['page']; ?>&sort=salesnum&order=<?php if ($this->_var['pager']['search']['sort'] == 'salesnum' && $this->_var['pager']['search']['order'] == 'DESC'): ?>ASC<?php else: ?>DESC<?php endif; ?>#goods_list&keywords=<?php echo $this->_var['keywords']; ?>" title="销量"><span><i class="w_cplb_is1"></i><i class="w_cplb_ix1"></i>销量</span></a>
		 <a href="search.php?intro=<?php echo $this->_var['intro']; ?>&display=<?php echo $this->_var['pager']['display']; ?>&brand=<?php echo $this->_var['pager']['search']['brand']; ?>&min_price=<?php echo $this->_var['min_price']; ?>&max_price=<?php echo $this->_var['max_price']; ?>&page=<?php echo $this->_var['pager']['page']; ?>&sort=shop_price&order=<?php if ($this->_var['pager']['search']['sort'] == 'shop_price' && $this->_var['pager']['search']['order'] == 'ASC'): ?>DESC<?php else: ?>ASC<?php endif; ?>#goods_list&keywords=<?php echo $this->_var['keywords']; ?>" title="价格"><span><i class="w_cplb_is1"></i><i class="w_cplb_ix1"></i>价格</span></a>
		 <a href="search.php?intro=<?php echo $this->_var['intro']; ?>&display=<?php echo $this->_var['pager']['display']; ?>&brand=<?php echo $this->_var['pager']['search']['brand']; ?>&min_price=<?php echo $this->_var['min_price']; ?>&max_price=<?php echo $this->_var['max_price']; ?>&page=<?php echo $this->_var['pager']['page']; ?>&sort=click_count&order=<?php if ($this->_var['pager']['search']['sort'] == 'click_count' && $this->_var['pager']['search']['order'] == 'DESC'): ?>ASC<?php else: ?>DESC<?php endif; ?>#goods_list&keywords=<?php echo $this->_var['keywords']; ?>" title="人气"><span><i class="w_cplb_is1"></i><i class="w_cplb_ix1"></i>人气</span></a>
	   </div>
	   <div class="w_cplb_l2_2">
	     <b>价格：</b><input type="text" id="min_price" value="<?php echo $this->_var['pager']['search']['min_price']; ?>" /><i>~</i><input type="text" id="max_price" value="<?php echo $this->_var['pager']['search']['max_price']; ?>" /><i>元</i>
         <input type="button" value="GO" class="w_jgqy2" onclick="window.location='search.php?intro=<?php echo $this->_var['intro']; ?>&display=<?php echo $this->_var['pager']['display']; ?>&brand=<?php echo $this->_var['pager']['search']['brand']; ?>&min_price='+$('#min_price').val()+'&max_price='+$('#max_price').val()+'&page=<?php echo $this->_var['pager']['page']; ?>&sort=<?php echo $this->_var['pager']['search']['sort']; ?>&order=<?php echo $this->_var['pager']['search']['order']; ?>#goods_list&keywords=<?php echo $this->_var['keywords']; ?>'"/>
	   </div>
	 </div>
	 <div class="w_cplb_l3">
	  <ul>
	    <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['goods']):
?>
        <li>
		  <div class="w_cplb_l3_d">
		  <a href="<?php echo $this->_var['goods']['url']; ?>" title="<?php echo $this->_var['goods']['goods_name']; ?>"><img src="/<?php echo $this->_var['goods']['goods_img']; ?>" title="<?php echo $this->_var['goods']['goods_name']; ?>" alt="<?php echo $this->_var['goods']['goods_name']; ?>"/></a>
		  <h2><a href="<?php echo $this->_var['goods']['url']; ?>" title="<?php echo $this->_var['goods']['goods_name']; ?>"><?php echo $this->_var['goods']['goods_name']; ?></a></h2>
		  <div class="w_cplb_l3_d1">
		    <span>编号：<?php echo $this->_var['goods']['goods_sn']; ?></span>|
			<span>销量：<?php echo $this->_var['goods']['salesnum']; ?>份</span>|
			<span>评价:<i class="w_xx5"></i>5.0分 （<em>7人评价</em>）</span>
		  </div>
		  <div class="w_cplb_l3_d2">
		    <?php echo $this->_var['goods']['list_desc']; ?>
		  </div>
		  </div>
		  <div class="w_cplb_l3_t">
		   <a href="<?php echo $this->_var['goods']['url']; ?>" title="了解详情>>">了解详情>></a>
		   <i><?php echo $this->_var['goods']['market_price']; ?></i>
		   <span><em><?php echo $this->_var['goods']['shop_price']; ?></em></span>
		  </div>
		</li>
		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	  </ul>
	  <div class="clear"></div>
	  <div class="w_peag">
	    <?php echo $this->fetch('library/pages.lbi'); ?>
	  </div>
	 </div>
   </div>
   <div class="w_cplb_r">
    <div class="w_bxxyl_1">
	   <h2>热销产品</h2>
	   <ul class="w_bxxyl_3l">
        <?php $_from = $this->_var['hot_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('k', 'r');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['r']):
?>
        <?php if ($this->_var['k'] < 4): ?>
        <li>
		  <a href="<?php echo $this->_var['r']['url']; ?>" title="<?php echo $this->_var['r']['name']; ?>">
		   <img src="/<?php echo $this->_var['r']['goods_img']; ?>" title="<?php echo $this->_var['r']['name']; ?>" alt="<?php echo $this->_var['r']['name']; ?>"/>
		   <p><?php echo $this->_var['r']['short_name']; ?></p>
		   <span><i><?php if ($this->_var['r']['promote_price']): ?><?php echo $this->_var['r']['promote_price']; ?><?php else: ?><?php echo $this->_var['r']['shop_price']; ?><?php endif; ?></i></span>
		  </a>
		</li>
        <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	   </ul>
	 </div>
	 <div class="clear"></div>
	<div class="w_bxxyl_1">
	   <h2>相关资讯</h2>
	   <ul class="w_bxxyl_2l">
	    <?php $_from = $this->_var['xg_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'r');if (count($_from)):
    foreach ($_from AS $this->_var['r']):
?>
        <li><a href="article.php?id=<?php echo $this->_var['r']['article_id']; ?>" title="<?php echo $this->_var['r']['title']; ?>"><?php echo $this->_var['r']['title']; ?></a></li>
		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	   </ul>
	 </div>
   </div>
 </div> 


<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>
</html>
