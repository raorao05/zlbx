<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="Generator" content="LECAOLEJIA since 2013" />
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<meta name="Keywords" content="网站地图" />
<meta name="Description" content="网站地图" />
<link href="/css/w_css.css" type="text/css" rel="stylesheet" />

<script src="/js/jquery.min.js.js"></script>
<script src="/js/w_index.js"></script>
<script type="text/javascript" src="/js/tab.js"></script>
<title>网站地图</title>

<?php echo $this->smarty_insert_scripts(array('files'=>'common.js,global.js,compare.js')); ?>
</head>

<body>
<?php echo $this->fetch('library/page_header.lbi'); ?>
<div class="w_center"> 
   <div class="w_dqwz">当前位置：网站地图</div>
   <div class="w_cplb_l">
     <div class="w_cplb_l1">
	   <h2>商品分类</h2>
	   <ul>
	      <?php $_from = $this->_var['goods_cat1']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');if (count($_from)):
    foreach ($_from AS $this->_var['cat']):
?>
          <li>
			<b><?php echo htmlspecialchars($this->_var['cat']['name']); ?> </b>
			<?php $_from = $this->_var['cat']['cat_id']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat1');if (count($_from)):
    foreach ($_from AS $this->_var['cat1']):
?>
				<em><a href="<?php echo $this->_var['cat1']['url']; ?>"><i class=""></i><?php echo htmlspecialchars($this->_var['cat1']['name']); ?></a></em>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	      </li>
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
         
	   </ul>
	 </div>
   </div>
   
   <div class="w_cplb_l">
     <div class="w_cplb_l1">
	   <h2>文章分类</h2>
	   <ul>
          <li>
			<b> </b>
			<?php $_from = $this->_var['article_cat']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');if (count($_from)):
    foreach ($_from AS $this->_var['cat']):
?>
				<?php if ($this->_var['cat']['cat_id'] != 4 && $this->_var['cat']['cat_id'] != 22 && $this->_var['cat']['cat_id'] != 23 && $this->_var['cat']['cat_id'] != 24): ?>
                <em><a href="article_cat.php?id=<?php echo $this->_var['cat']['cat_id']; ?>"><i class=""></i><?php echo $this->_var['cat']['cat_name']; ?></a></em>
                <?php endif; ?>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	      </li>
	   </ul>
	 </div>
   </div>
</div> 


<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>
</html>
