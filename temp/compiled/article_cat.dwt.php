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
       <?php if ($this->_var['parent_id'] == 23 || $this->_var['parent_id'] == 24): ?>
       <li  class="w_bxxyl_1l_1" >
	    	<a href="javascript:;" title="车险理赔" onclick="$('.w_bxxyl_12').slideToggle(500)">车险理赔<i class="w_lpxl"></i></a>
	        <ul class="w_bxxyl_12" <?php if ($this->_var['parent_id'] == 24): ?>style="display:none"<?php endif; ?>>
			   <?php $_from = $this->_var['cxlp']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'r');if (count($_from)):
    foreach ($_from AS $this->_var['r']):
?>
			   <li><a href="article.php?id=<?php echo $this->_var['r']['article_id']; ?>" title="<?php echo $this->_var['r']['title']; ?>"><?php echo $this->_var['r']['title']; ?></a></li>
               <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
               <?php $_from = $this->_var['cx_cat']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'r');if (count($_from)):
    foreach ($_from AS $this->_var['r']):
?>
			   <li <?php if ($this->_var['r']['cat_id'] == $this->_var['cat_id']): ?>class="w_bxxyl_12_a"<?php endif; ?>><a href="article_cat.php?id=<?php echo $this->_var['r']['cat_id']; ?>" title="<?php echo $this->_var['r']['cat_name']; ?>"><?php echo $this->_var['r']['cat_name']; ?></a></li>
               <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			</ul>
		</li>
		<li  class="w_bxxyl_1l_1" >
		<a href="javascript:;" title="非车险理赔"  onclick="$('.w_bxxyl_12').slideToggle(500)">非车险理赔<i class="w_lpxl"></i></a>
		  <ul class="w_bxxyl_12" <?php if ($this->_var['parent_id'] == 23): ?>style="display:none"<?php endif; ?>>
			   <?php $_from = $this->_var['fcxlp']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'r');if (count($_from)):
    foreach ($_from AS $this->_var['r']):
?>
			   <li><a href="article.php?id=<?php echo $this->_var['r']['article_id']; ?>" title="<?php echo $this->_var['r']['title']; ?>"><?php echo $this->_var['r']['title']; ?></a></li>
               <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
               <?php $_from = $this->_var['fcx_cat']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'r');if (count($_from)):
    foreach ($_from AS $this->_var['r']):
?>
			   <li <?php if ($this->_var['r']['cat_id'] == $this->_var['cat_id']): ?>class="w_bxxyl_12_a"<?php endif; ?>><a href="article_cat.php?id=<?php echo $this->_var['r']['cat_id']; ?>" title="<?php echo $this->_var['r']['cat_name']; ?>"><?php echo $this->_var['r']['cat_name']; ?></a></li>
               <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			</ul>
		</li>
       <?php else: ?>
	    <?php $_from = $this->_var['cat_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cats');if (count($_from)):
    foreach ($_from AS $this->_var['cats']):
?>
           <li <?php if ($this->_var['cats']['cat_id'] == $this->_var['cat_id']): ?>class="w_bxxyl_1l_1"<?php endif; ?>><a href="article_cat.php?id=<?php echo $this->_var['cats']['cat_id']; ?>" title="<?php echo $this->_var['cats']['cat_name']; ?>"><?php echo $this->_var['cats']['cat_name']; ?><i></i></a></li>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	   <?php endif; ?>
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
   <div class="w_bxxy_r">
     <div class="w_bxxy_r_t1"><i></i><b><?php echo $this->_var['name']; ?></b></div>
	 
     <?php if ($this->_var['cat_id'] == 25): ?>
     <div class="w_lp_fx">
	   <ul>
	     <?php $_from = $this->_var['artciles_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'r');if (count($_from)):
    foreach ($_from AS $this->_var['r']):
?>
         <li>
		   <h2><?php echo $this->_var['r']['title']; ?></h2>
		   <div class="w_lp_fx_w"><i></i><?php echo $this->_var['r']['description']; ?></div>
		 </li>
         <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	   </ul>
       <div class="clear"></div>
	   <div class="w_peag">
       <?php echo $this->fetch('library/pages.lbi'); ?>
	 </div>
     <?php elseif ($this->_var['cat_id'] == 26 || $this->_var['cat_id'] == 28): ?>
     <div class="w_xzzq">
	   <ul>
	    <?php $_from = $this->_var['artciles_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'r');if (count($_from)):
    foreach ($_from AS $this->_var['r']):
?>
        <li><a href="<?php echo $this->_var['r']['file_url']; ?>" title="<?php echo $this->_var['r']['title']; ?>"><i></i><?php echo $this->_var['r']['title']; ?></a></li>
		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	   </ul>
	 </div>
     <?php elseif ($this->_var['cat_id'] == 27): ?>
     <div class="w_fcxal">
	   <p>注：以下案例仅供参考</p>
	   <table cellpadding="0" cellspacing="0" class="w_fcxal_tb">
	     <tr class="w_fcxal_tr">
		   <td>报案时间</td>
		   <td>赔付时间</td>
		   <td>险 种</td>
		   <td>案件类型</td>
		   <td>保单号</td>
		   <td>承保公司</td>
		   <td>保险产品</td>
		   <td>赔付金额</td>
		 </tr>
		 <?php $_from = $this->_var['artciles_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'r');if (count($_from)):
    foreach ($_from AS $this->_var['r']):
?>
         <tr>
		   <td><?php echo $this->_var['r']['basj']; ?></td>
		   <td><?php echo $this->_var['r']['pfsj']; ?></td>
		   <td><?php echo $this->_var['r']['xz']; ?></td>
		   <td><?php echo $this->_var['r']['ajlx']; ?></td>
		   <td><?php echo $this->_var['r']['bdh']; ?></td>
		   <td><?php echo $this->_var['r']['cbgs']; ?></td>
		   <td><?php echo $this->_var['r']['bxcp']; ?></td>
		   <td><?php echo $this->_var['r']['pfje']; ?></td>
		 </tr>
         <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	   </table>
	 </div>
     <?php else: ?>
     <div class="w_bxxy_r_n">
	  <ul>
	    <?php $_from = $this->_var['artciles_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'article');if (count($_from)):
    foreach ($_from AS $this->_var['article']):
?>
        <li>
		  <h2><a href="article.php?id=<?php echo $this->_var['article']['id']; ?>" title="<?php echo $this->_var['article']['title']; ?>"><i></i><?php echo $this->_var['article']['title']; ?></a></h2>
		  <p><?php echo $this->_var['article']['description']; ?></p>
		  <div class="w_bxxy_r_n1">
		    <span><b>标签：</b><a href="javascript:;" title="<?php echo $this->_var['article']['keywords']; ?>"><?php echo $this->_var['article']['keywords']; ?></a></span>
			<span><b>创建者：</b><?php echo $this->_var['article']['author']; ?></span>
			<span><b>创建时间：</b><?php echo $this->_var['article']['add_time']; ?></span>
		  </div>
		</li>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	  </ul>
	  <div class="clear"></div>
	  <div class="w_peag">
      <?php echo $this->fetch('library/pages.lbi'); ?>
	  </div>
      <?php endif; ?>
      
	 </div>
	</div> 
   </div>
<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>
</html>
