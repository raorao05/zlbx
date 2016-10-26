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
   <div class="w_bxxy_l">
     <div class="w_bxxyl_1">
	   <h2><?php echo $this->_var['catname']; ?></h2>
	   <ul class="w_bxxyl_1l">
	    <?php $_from = $this->_var['cat_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cats');if (count($_from)):
    foreach ($_from AS $this->_var['cats']):
?>
           <li <?php if ($this->_var['cats']['article_id'] == $this->_var['article']['article_id']): ?>class="w_bxxyl_1l_1"<?php endif; ?>><a href="article.php?id=<?php echo $this->_var['cats']['article_id']; ?>" title="<?php echo $this->_var['cats']['title']; ?>"><?php echo $this->_var['cats']['title']; ?><i></i></a></li>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        <?php $_from = $this->_var['cat_info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cats');if (count($_from)):
    foreach ($_from AS $this->_var['cats']):
?>
           <li <?php if ($this->_var['cats']['cat_id'] == $this->_var['article']['cat_id']): ?>class="w_bxxyl_1l_1"<?php endif; ?>><a href="article_cat.php?id=<?php echo $this->_var['cats']['cat_id']; ?>" title="<?php echo $this->_var['cats']['cat_name']; ?>"><?php echo $this->_var['cats']['cat_name']; ?><i></i></a></li>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	   </ul>
	 </div>
   </div>
   <div class="w_qcfw_r">
     <div class="w_bxzh_tit">
	   <span class="w_bxzh_s" id="wx1" onmouseover="setTab('wx',1,3,'w_bxzh_s')"><i></i>了解车险</span>
	   <span id="wx2" onmouseover="setTab('wx',2,3,'w_bxzh_s')"><i></i>理赔服务</span>
	   <span id="wx3" onmouseover="setTab('wx',3,3,'w_bxzh_s')"><i></i>合作保险公司</span>                                          
	 </div>
     
     <div class="w_bxzh_n"  id="con_wx_1" style="display: block;"><?php echo $this->_var['article']['content']; ?></div>
     <div class="w_bxzh_n"  id="con_wx_2" style="display:none;"><?php echo $this->_var['article']['lipei']; ?></div>
     <div class="w_bxzh_n"  id="con_wx_3" style="display:none;"><?php echo $this->_var['article']['hzbx']; ?></div>
   </div> 

</div>

<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>
</html>
