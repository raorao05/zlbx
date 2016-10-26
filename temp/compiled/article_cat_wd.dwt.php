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
<script type="text/javascript" src="/js/jquery.js"></script>
<script type="text/javascript" src="/js/jquery.json-2.4.min.js"></script>

<?php echo $this->smarty_insert_scripts(array('files'=>'transport.js,region.js')); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'common.js')); ?>

</head>
<body>
<?php echo $this->fetch('library/page_header.lbi'); ?>
<div class="w_center"> 
   
   <div class="w_dqwz">
    <?php echo $this->fetch('library/ur_here.lbi'); ?>
   </div>
   <div class="w_bxxy_l">
     <div class="w_bxxyl_1">
	   <h2><?php echo $this->_var['catname']; ?></h2>
	   <ul class="w_bxxyl_1l">
	    
        <?php $_from = $this->_var['cat_info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cats');if (count($_from)):
    foreach ($_from AS $this->_var['cats']):
?>
           <li><a href="article.php?id=<?php echo $this->_var['cats']['article_id']; ?>" title="<?php echo $this->_var['cats']['title']; ?>"><?php echo $this->_var['cats']['title']; ?><i></i></a></li>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        
        <?php $_from = $this->_var['cat_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cats');if (count($_from)):
    foreach ($_from AS $this->_var['cats']):
?>
           <li <?php if ($this->_var['cats']['cat_id'] == $this->_var['cat_id']): ?>class="w_bxxyl_1l_1"<?php endif; ?>><a href="article_cat.php?id=<?php echo $this->_var['cats']['cat_id']; ?>" title="<?php echo $this->_var['cats']['cat_name']; ?>"><?php echo $this->_var['cats']['cat_name']; ?><i></i></a></li>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	   </ul>
	 </div>
	 <div class="w_bxxyl_1">
	   <h2>相关资讯</h2>
	   <ul class="w_bxxyl_2l">
	    <?php $_from = $this->_var['xg_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'xg');if (count($_from)):
    foreach ($_from AS $this->_var['xg']):
?>
        <li><a href="article.php?id=<?php echo $this->_var['xg']['article_id']; ?>" title="<?php echo $this->_var['xg']['title']; ?>"><?php echo $this->_var['xg']['title']; ?></a></li>
		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	   </ul>
	 </div>
   </div>
   <div class="w_qcfw_r">
    <div class="w_bxxy_r_t1"><i></i><b>服务网点</b>Service outlets</div>
    <div class="w_fwwd">
	  <i>共<?php echo $this->_var['pager']['record_count']; ?>个网点</i>
	  筛选：
	 
      <select name="country" id="selCountries" onchange="region.changed(this, 1, 'selProvinces')" style="display:none;">
          <option value="1">中国</option>
      </select>
      <select name="province" id="selProvinces" onchange="region.changed(this, 2, 'selCities')">
          <option value="0">请选择省</option>
      </select>
      <select name="city" id="selCities" onchange="region.changed(this, 3, 'selDistricts')">
          <option value="0">请选择市</option>
      </select>
      <select name="district" id="selDistricts">
          <option value="0">请选择区</option>
      </select>
      <input type="button" value="搜索" onclick="sousuo();" />
	</div>
	<div class="w_fwwd_d">
	 <ul>
	  <?php $_from = $this->_var['artciles_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'article');if (count($_from)):
    foreach ($_from AS $this->_var['article']):
?>
      <li>
	   <a href="" title="<?php echo $this->_var['article']['title']; ?>"><img src="<?php echo $this->_var['article']['file_url']; ?>" title="<?php echo $this->_var['article']['title']; ?>" alt="<?php echo $this->_var['article']['title']; ?>"/></a>
	   <h2><a href="" title="<?php echo $this->_var['article']['title']; ?>"><?php echo $this->_var['article']['title']; ?></a></h2>
	   <p>联系电话:<?php echo $this->_var['article']['tel']; ?></p>
	   <p>地址:<a href="" title="<?php echo $this->_var['article']['title']; ?>"><?php echo $this->_var['article']['address']; ?></a></p>
	   <p>服务项目:<a href="" title="<?php echo $this->_var['article']['title']; ?>"><?php echo $this->_var['article']['fwxm']; ?></a></p>
	  </li>
	  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	 </ul>
	</div>
   </div>
   </div>
<script>
region.isAdmin = true;
$("#selCountries").change();

function sousuo(){
	var id=$("#selDistricts").val();
	document.location.href='article_cat.php?id=<?php echo $this->_var['cat_id']; ?>&district_id='+id;
}
</script>
<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>
</html>
