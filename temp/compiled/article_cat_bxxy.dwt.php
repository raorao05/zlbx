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

<?php echo $this->smarty_insert_scripts(array('files'=>'common.js')); ?>
</head>
<body>
<?php echo $this->fetch('library/page_header.lbi'); ?>
<div class="w_center"> 
   
   <div class="w_dqwz">
    <?php echo $this->fetch('library/ur_here.lbi'); ?>
   </div>
   <div class="w_bxbanner"><div class="w_qcgg"><?php 
$k = array (
  'name' => 'ads',
  'id' => '3',
  'num' => '1',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?></div></div>
   <div class="w_bxxy_n">
     <div class="w_bxxy_n1">
	   <div class="w_bxxy_tit"><a href="article_cat.php?id=13" title="更多>>">更多>></a><i class="w_bxxyi_1"></i>保险基础知识</div>
	   <div class="w_bxxy_n1_n">
	    <a href="article.php?id=<?php echo $this->_var['rd']['0']['article_id']; ?>" title="<?php echo $this->_var['rd']['0']['title']; ?>"><img src="<?php echo $this->_var['rd']['0']['file_url']; ?>" title="<?php echo $this->_var['rd']['0']['title']; ?>" alt="<?php echo $this->_var['rd']['0']['title']; ?>"/></a>
		<ul>
		  <?php $_from = $this->_var['rd']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('k', 'r');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['r']):
?>
          <li>
		    <a href="article.php?id=<?php echo $this->_var['r']['article_id']; ?>" title="<?php echo $this->_var['r']['title']; ?>"><i>·</i><?php echo $this->_var['r']['title']; ?></a>
			<?php if ($this->_var['k'] == 0): ?><p><?php echo sub_str($this->_var['r']['description'],48); ?></p><?php endif; ?>
		  </li>
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</ul>
	   </div>
	 </div>
	 <div class="w_bxxy_n2">
	   <div class="w_bxxy_tit"><a href="article_cat.php?id=14" title="更多>>">更多>></a><i class="w_bxxyi_2"></i>保险规划</div>
	   <div class="w_bxxy_n1_n">
	    <a href="article.php?id=<?php echo $this->_var['hy']['0']['article_id']; ?>" title="<?php echo $this->_var['hy']['0']['title']; ?>"><img src="<?php echo $this->_var['hy']['0']['file_url']; ?>" title="<?php echo $this->_var['hy']['0']['title']; ?>" alt="<?php echo $this->_var['hy']['0']['title']; ?>"/></a>
		<ul>
		  <?php $_from = $this->_var['hy']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('k', 'r');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['r']):
?>
          <li>
		    <a href="article.php?id=<?php echo $this->_var['r']['article_id']; ?>" title="<?php echo $this->_var['r']['title']; ?>"><i>·</i><?php echo $this->_var['r']['title']; ?></a>
			<?php if ($this->_var['k'] == 0): ?><p><?php echo sub_str($this->_var['r']['description'],48); ?></p><?php endif; ?>
		  </li>
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</ul>
	   </div>
	 </div>
	 <div class="w_bxxy_n3">
	   <div class="w_bxxy_tit"><a href="article_cat.php?id=15" title="更多>>">更多>></a><i class="w_bxxyi_3"></i>保险词条</div>
	   <div class="w_bxxy_n1_n">
	    <a href="article.php?id=<?php echo $this->_var['bk']['0']['article_id']; ?>" title="<?php echo $this->_var['bk']['0']['title']; ?>"><img src="<?php echo $this->_var['bk']['0']['file_url']; ?>" title="<?php echo $this->_var['bk']['0']['title']; ?>" alt="<?php echo $this->_var['bk']['0']['title']; ?>"/></a>
		<ul>
		  <?php $_from = $this->_var['bk']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('k', 'r');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['r']):
?>
          <li>
		    <a href="article.php?id=<?php echo $this->_var['r']['article_id']; ?>" title="<?php echo $this->_var['r']['title']; ?>"><i>·</i><?php echo sub_str($this->_var['r']['title'],22); ?></a>
			<?php if ($this->_var['k'] == 0): ?><p><?php echo sub_str($this->_var['r']['description'],48); ?></p><?php endif; ?>
		  </li>
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</ul>
	   </div>
	 </div>
	 <div class="w_bxxy_n4">
	   <div class="w_bxxy_tit"><a href="article_cat.php?id=16" title="更多>>">更多>></a><i class="w_bxxyi_4"></i>车险专区</div>
	   <div class="w_bxxy_n1_n">
	    <a href="article.php?id=<?php echo $this->_var['cx']['0']['article_id']; ?>" title="<?php echo $this->_var['cx']['0']['title']; ?>"><img src="<?php echo $this->_var['cx']['0']['file_url']; ?>" title="<?php echo $this->_var['cx']['0']['title']; ?>" alt="<?php echo $this->_var['cx']['0']['title']; ?>"/></a>
		<ul>
		  <?php $_from = $this->_var['cx']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('k', 'r');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['r']):
?>
          <li>
		    <a href="article.php?id=<?php echo $this->_var['r']['article_id']; ?>" title="<?php echo $this->_var['r']['title']; ?>"><i>·</i><?php echo $this->_var['r']['title']; ?></a>
			<?php if ($this->_var['k'] == 0): ?><p><?php echo sub_str($this->_var['r']['description'],48); ?></p><?php endif; ?>
		  </li>
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</ul>
	   </div>
	 </div>
   </div>
   <div class="clear"></div>
   <div class="w_bxxy_1n">
      <div class="w_bxxy_tit"><a href="article_cat.php?id=17" title="更多>>">更多>></a><i class="w_bxxyi_5"></i>保险手册
	  <div class="w_bxxy_5">
	    <span class="w_bxxy_5t" id="tl1" onclick="setTab('tl',1,5,'w_bxxy_5t')"><i></i>旅游</span>
		<span id="tl2" onclick="setTab('tl',2,5,'w_bxxy_5t')"><i></i>医疗</span>
		<span id="tl3" onclick="setTab('tl',3,5,'w_bxxy_5t')"><i></i>家财</span>
		<span id="tl4" onclick="setTab('tl',4,5,'w_bxxy_5t')"><i></i>养老</span>
		<span id="tl5" onclick="setTab('tl',5,5,'w_bxxy_5t')"><i></i>教育</span>                                                                               
	  </div>
	  </div>
	  <div class="w_bxxy_n1_n"  id="con_tl_1" style="display:block;">
	    <a href="article.php?id=<?php echo $this->_var['ly']['0']['article_id']; ?>" title="<?php echo $this->_var['ly']['0']['title']; ?>"><img src="<?php echo $this->_var['ly']['0']['file_url']; ?>" title="<?php echo $this->_var['ly']['0']['title']; ?>" alt="<?php echo $this->_var['ly']['0']['title']; ?>"/></a>
		<ul>
		  <?php $_from = $this->_var['ly']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('k', 'r');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['r']):
?>
          <li>
		    <a href="article.php?id=<?php echo $this->_var['r']['article_id']; ?>" title="<?php echo $this->_var['r']['title']; ?>"><i>·</i><?php echo $this->_var['r']['title']; ?></a>
			<p><?php echo $this->_var['r']['description']; ?></p>
		  </li>
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</ul>
	   </div>
	   <div class="w_bxxy_n1_n"  id="con_tl_2" style="display: none;">
	    <a href="article.php?id=<?php echo $this->_var['yil']['0']['article_id']; ?>" title="<?php echo $this->_var['yil']['0']['title']; ?>"><img src="<?php echo $this->_var['yil']['0']['file_url']; ?>" title="<?php echo $this->_var['yil']['0']['title']; ?>" alt="<?php echo $this->_var['yil']['0']['title']; ?>"/></a>
		<ul>
		  <?php $_from = $this->_var['yil']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('k', 'r');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['r']):
?>
          <li>
		    <a href="article.php?id=<?php echo $this->_var['r']['article_id']; ?>" title="<?php echo $this->_var['r']['title']; ?>"><i>·</i><?php echo $this->_var['r']['title']; ?></a>
			<p><?php echo $this->_var['r']['description']; ?></p>
		  </li>
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</ul>
	   </div>
	   <div class="w_bxxy_n1_n"  id="con_tl_3" style="display: none;">
	    <a href="article.php?id=<?php echo $this->_var['jc']['0']['article_id']; ?>" title="<?php echo $this->_var['jc']['0']['title']; ?>"><img src="<?php echo $this->_var['jc']['0']['file_url']; ?>" title="<?php echo $this->_var['jc']['0']['title']; ?>" alt="<?php echo $this->_var['jc']['0']['title']; ?>"/></a>
		<ul>
		  <?php $_from = $this->_var['jc']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('k', 'r');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['r']):
?>
          <li>
		    <a href="article.php?id=<?php echo $this->_var['r']['article_id']; ?>" title="<?php echo $this->_var['r']['title']; ?>"><i>·</i><?php echo $this->_var['r']['title']; ?></a>
			<p><?php echo $this->_var['r']['description']; ?></p>
		  </li>
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</ul>
	   </div>
	   <div class="w_bxxy_n1_n"  id="con_tl_4" style="display: none;">
	    <a href="article.php?id=<?php echo $this->_var['yl']['0']['article_id']; ?>" title="<?php echo $this->_var['yl']['0']['title']; ?>"><img src="<?php echo $this->_var['yl']['0']['file_url']; ?>" title="<?php echo $this->_var['yl']['0']['title']; ?>" alt="<?php echo $this->_var['yl']['0']['title']; ?>"/></a>
		<ul>
		  <?php $_from = $this->_var['yl']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('k', 'r');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['r']):
?>
          <li>
		    <a href="article.php?id=<?php echo $this->_var['r']['article_id']; ?>" title="<?php echo $this->_var['r']['title']; ?>"><i>·</i><?php echo $this->_var['r']['title']; ?></a>
			<p><?php echo $this->_var['r']['description']; ?></p>
		  </li>
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</ul>
	   </div>
	   <div class="w_bxxy_n1_n"  id="con_tl_5" style="display: none;">
	    <a href="article.php?id=<?php echo $this->_var['jy']['0']['article_id']; ?>" title="<?php echo $this->_var['jy']['0']['title']; ?>"><img src="<?php echo $this->_var['jy']['0']['file_url']; ?>" title="<?php echo $this->_var['jy']['0']['title']; ?>" alt="<?php echo $this->_var['jy']['0']['title']; ?>"/></a>
		<ul>
		  <?php $_from = $this->_var['jy']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('k', 'r');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['r']):
?>
          <li>
		    <a href="article.php?id=<?php echo $this->_var['r']['article_id']; ?>" title="<?php echo $this->_var['r']['title']; ?>"><i>·</i><?php echo $this->_var['r']['title']; ?></a>
			<p><?php echo $this->_var['r']['description']; ?></p>
		  </li>
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</ul>
	   </div>
   </div>
</div>
<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>
</html>
