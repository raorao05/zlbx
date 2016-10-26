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
     <div class="w_cplb_l1">
	   <h2><?php echo $this->_var['cat_name']; ?></h2>
	   <ul>
	      <?php $_from = $this->_var['filter_attr_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'filter_attr_0_84898100_1473307346');if (count($_from)):
    foreach ($_from AS $this->_var['filter_attr_0_84898100_1473307346']):
?>
          <li>
			<b><?php echo htmlspecialchars($this->_var['filter_attr_0_84898100_1473307346']['filter_attr_name']); ?> </b>
			<?php $_from = $this->_var['filter_attr_0_84898100_1473307346']['attr_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'attr');if (count($_from)):
    foreach ($_from AS $this->_var['attr']):
?>
				<?php if ($this->_var['attr']['selected']): ?>
				<em><i class="w_sr_i_no w_sr_i_yes"></i><?php echo $this->_var['attr']['attr_value']; ?></em>
				<?php else: ?>
				<em><a href="<?php echo $this->_var['attr']['url']; ?>"><i class="w_sr_i_no"></i><?php echo $this->_var['attr']['attr_value']; ?></a></em>
				<?php endif; ?>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	      </li>
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
         
		 <li>
		   <b>品牌商家</b>
           <?php $_from = $this->_var['brands']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'brand');if (count($_from)):
    foreach ($_from AS $this->_var['brand']):
?>
				<?php if ($this->_var['brand']['selected']): ?>
				<em><i class="w_sr_i_no w_sr_i_yes"></i><?php echo $this->_var['brand']['brand_name']; ?></em>
				<?php else: ?>
				<em><a href="<?php echo $this->_var['brand']['url']; ?>"><i class="w_sr_i_no"></i><?php echo $this->_var['brand']['brand_name']; ?></a></em>
				<?php endif; ?>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		 </li>
	   </ul>
	 </div>
	 <div class="w_cplb_l2">
	   <span class="w_cplb_s1">共<?php echo $this->_var['pager']['record_count']; ?>个产品</span>
	   <div class="w_cplb_l2_1">
	     <b>排序：</b>
		 <a href="<?php echo $this->_var['script_name']; ?>.php?category=<?php echo $this->_var['category']; ?>&display=<?php echo $this->_var['pager']['display']; ?>&brand=<?php echo $this->_var['brand_id']; ?>&price_min=<?php echo $this->_var['price_min']; ?>&price_max=<?php echo $this->_var['price_max']; ?>&filter_attr=<?php echo $this->_var['filter_attr']; ?>&page=<?php echo $this->_var['pager']['page']; ?>&sort=salesnum&order=<?php if ($this->_var['pager']['sort'] == 'salesnum' && $this->_var['pager']['order'] == 'ASC'): ?>DESC<?php else: ?>ASC<?php endif; ?>#goods_list" title="销量"><span><i class="w_cplb_is1"></i><i class="w_cplb_ix1"></i>销量</span></a>
		 <a href="<?php echo $this->_var['script_name']; ?>.php?category=<?php echo $this->_var['category']; ?>&display=<?php echo $this->_var['pager']['display']; ?>&brand=<?php echo $this->_var['brand_id']; ?>&price_min=<?php echo $this->_var['price_min']; ?>&price_max=<?php echo $this->_var['price_max']; ?>&filter_attr=<?php echo $this->_var['filter_attr']; ?>&page=<?php echo $this->_var['pager']['page']; ?>&sort=shop_price&order=<?php if ($this->_var['pager']['sort'] == 'shop_price' && $this->_var['pager']['order'] == 'ASC'): ?>DESC<?php else: ?>ASC<?php endif; ?>#goods_list" title="价格"><span><i class="w_cplb_is1"></i><i class="w_cplb_ix1"></i>价格</span></a>
		 <a href="<?php echo $this->_var['script_name']; ?>.php?category=<?php echo $this->_var['category']; ?>&display=<?php echo $this->_var['pager']['display']; ?>&brand=<?php echo $this->_var['brand_id']; ?>&price_min=<?php echo $this->_var['price_min']; ?>&price_max=<?php echo $this->_var['price_max']; ?>&filter_attr=<?php echo $this->_var['filter_attr']; ?>&page=<?php echo $this->_var['pager']['page']; ?>&sort=click_count&order=<?php if ($this->_var['pager']['sort'] == 'click_count' && $this->_var['pager']['order'] == 'ASC'): ?>DESC<?php else: ?>ASC<?php endif; ?>#goods_list" title="人气"><span><i class="w_cplb_is1"></i><i class="w_cplb_ix1"></i>人气</span></a>
	   </div>
	   <div class="w_cplb_l2_2">
	     <b>价格：</b><input type="text" id="price_min" value="<?php echo $this->_var['price_min']; ?>" /><i>~</i><input type="text" id="price_max" value="<?php echo $this->_var['price_max']; ?>" /><i>元</i>
         <input type="button" value="GO" class="w_jgqy2" onclick="window.location='<?php echo $this->_var['script_name']; ?>.php?category=<?php echo $this->_var['category']; ?>&display=<?php echo $this->_var['pager']['display']; ?>&brand=<?php echo $this->_var['brand_id']; ?>&price_min='+$('#price_min').val()+'&price_max='+$('#price_max').val()+'&filter_attr=<?php echo $this->_var['filter_attr']; ?>&page=<?php echo $this->_var['pager']['page']; ?>&sort=<?php echo $this->_var['pager']['sort']; ?>&order=<?php echo $this->_var['pager']['order']; ?>#goods_list'"/>
	   </div>
	 </div>
	 <div class="w_cplb_l3">
	  <ul>
	    <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['goods']):
?>
        <li>
		  <div class="w_cplb_l3_d">
		  <a href="<?php echo $this->_var['goods']['url']; ?>" title="<?php echo $this->_var['goods']['name']; ?>"><img src="/<?php echo $this->_var['goods']['goods_img']; ?>" title="<?php echo $this->_var['goods']['name']; ?>" alt="<?php echo $this->_var['goods']['name']; ?>"/></a>
		  <h2><a href="<?php echo $this->_var['goods']['url']; ?>" title="<?php echo $this->_var['goods']['name']; ?>"><?php echo $this->_var['goods']['name']; ?></a></h2>
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
