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
<?php echo $this->smarty_insert_scripts(array('files'=>'common.js,index.js')); ?>
<script>
$(function(){
	$(".w_sy_bfd_2 span").click(function(){
		$(".w_sy_bfd_2").find("span").removeClass("w_span_dq");
		$(this).addClass('w_span_dq');
	});
});
function fuzhi(id,zhi){
	document.getElementById(id).value=zhi;
}
function quote(){
	var cat_id=document.getElementById('cat_id').value;
	var pro_id=document.getElementById('selProvinces').value;
	var reg_id=document.getElementById('selCities').value;
	
	window.location.href='category.php?id='+cat_id+'&reg_id='+reg_id+'&pro_id='+pro_id;
}
</script>
	<script>
		var _hmt = _hmt || [];
		(function() {
			var hm = document.createElement("script");
			hm.src = "//hm.baidu.com/hm.js?7e9c257b1e8cb4d2b017d6c46db859dd";
			var s = document.getElementsByTagName("script")[0];
			s.parentNode.insertBefore(hm, s);
		})();
	</script>
</head>
<body>
<div class="w_top1_bd">
    <div class="w_top1_center">
	  <div class="w_top1_l">
	    <span>��ã���ӭ�����������գ�</span><?php 
$k = array (
  'name' => 'member_info',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?>
	  </div>
	  <div class="w_top1_r">
	    <ul>
		  <li class="w_topr_1"><a href="flow.php" title="���ﳵ"><i></i>���ﳵ��<span><?php 
$k = array (
  'name' => 'cart_info',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?></span>��</a></li><em>|</em>
		  <li class="w_topr_2">
		  <a href="user.php?act=collection_list" title="�ղؼ�">�ղؼ�</a>
		  </li><em>|</em>
		  <li class="w_topr_2">
		   <a href="user.php" title="��Ա����">��Ա����<i></i></a>
		   <div class="w_scj_1">
		   <a href="user.php?act=profile" title="�û���Ϣ">�û���Ϣ</a>
		   <a href="user.php?act=order_list" title="�ҵĶ���">�ҵĶ���</a>
		   <a href="user.php?act=comment_list" title="�ҵ�����">�ҵ�����</a>
		  </div>
		  </li>
		  <li class="w_topr_3"><i></i><b>0731-82808053 </b></li>
		</ul>
	  </div>
	</div>
  </div>
  <div class="w_top2_bd"> 
    <div class="w_top2_center">
	  <div class="w_logo1"><a href="index.php" title="��������"><img src="/images/w_logo1.png" title="��������" alt="��������"/></a></div>
	  <div class="w_logo2"><img src="/images/w_logo2.png" title="��������" alt="��������"/></div>
	  <div class="w_sosou">
	   <div class="w_sosou1">
	    <i></i>
        <form id="searchForm" name="searchForm" method="get" action="search.php" onSubmit="return checkSearchForm()">
		<input type="text" name="keywords" placeholder="������ؼ���" class="w_ss_in1" />
		<input type="submit" value="����" class="w_ss_in2" />
        </form>
	   </div>
	   <?php if ($this->_var['searchkeywords']): ?>
           <div class="w_sosou2">
	        �ȴʣ�
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
  </div>	
  <div class="w_top3_bd"> 
    <div class="w_top3_center">
	  <div class="w_top3_l">
	    <span>���շ���</span>
		<div class="w_top3_2">
		 <?php $_from = $this->_var['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('k', 'cat');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['cat']):
?>
         <dl>
		    <dt class="w_top3_dt<?php echo $this->_var['k']; ?>">
				<a href="category.php?id=<?php echo $this->_var['cat']['id']; ?>"><?php echo $this->_var['cat']['name']; ?></a>
				<em>
				<?php $_from = $this->_var['cat']['cat_id']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'catss');$this->_foreach['sb'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['sb']['total'] > 0):
    foreach ($_from AS $this->_var['catss']):
        $this->_foreach['sb']['iteration']++;
?>
				
				<?php if ($this->_foreach['sb']['iteration'] < 4): ?>
					<?php if ($this->_var['catss'] [ 'id' ] == 31): ?>
					<a href="http://e.cic.cn/web/portal.do?url=HC6iFLQ3Q3KwTZ95K8XewQ==" title="<?php echo $this->_var['catss']['name']; ?>"><?php echo $this->_var['catss']['name']; ?></a>
					<?php else: ?>
				<a href="category.php?id=<?php echo $this->_var['catss']['id']; ?>" title="<?php echo $this->_var['catss']['name']; ?>"><?php echo $this->_var['catss']['name']; ?></a>
					<?php endif; ?>
				<?php endif; ?>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				</em>
			
			</dt>
			 <?php if ($this->_var['cat'] [ 'id' ] == 1): ?>
			<dd>
                <i></i>

				<a href="http://www.4008000000.com/zhuanxiang/dimian/cheshanghz.shtml?urltype=yb&provinceCode=430000&cityCode=430100&depCode=22019&partnerCode=1000098336&realCityname=" title="ƽ������">ƽ������</a>
				<a href="http://www.epicc.com.cn/ecar/proposal/branchProposal?ID=4301385087" title="�˱�����">�˱�����</a>
				<a href="http://www.chinalife.com.cn/publish/zhuzhan/883/index.html#pageSize=2&pageNo=1&parentAttrID=netSaleProduct&attrID=nsp_CarInsurance" title="���ٲƳ���">���ٲƳ���</a>
                 <a href="http://e.cic.cn/web/portal.do?url=HC6iFLQ3Q3KwTZ95K8XewQ==" title="�л����ϳ���">�л����ϳ���</a>
				
			</dd>
			 <?php endif; ?>
		  </dl>
         <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</div>
	  </div>
	  <ul class="w_top3_u">
	    <li class="w_dq_a"><a href="index.php" title="��ҳ">��ҳ</a></li>
		<li><a href="article.php?id=5" title="��������">��������</a></li>
		<li><a href="article_cat.php?id=6" title="��������">��������</a></li>
		<li><a href="article_cat.php?id=10" title="��������">��������</a></li>
		<li><a href="search.php?intro=best" title="�Ƽ���Ʒ">�Ƽ���Ʒ</a></li>
		<li><a href="article_cat.php?id=12" title="����ѧԺ">����ѧԺ</a></li>
		<li><a href="article.php?id=34" title="�������">�������</a></li>
		<li><a href="article.php?id=33" title="��Ա��Ƹ">��Ա��Ƹ</a></li>                                                                                         
	  </ul>
	</div>
 </div>	
 <div class="clear"></div>
<div class="w_sy_b1">
  <div class="indexSlide">
      <div class="slide_show" id="slide_show">
        <div class="slide_wrap" id="index_slide">
          <ol class="clearfix">
            <?php $_from = $this->_var['ad']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('k', 'ads');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['ads']):
?>
            <li> <a class="big_pic" href="<?php echo $this->_var['ads']['ad_link']; ?>" target="_blank"><img id="lunbo_<?php echo $this->_var['k']; ?>" src="/data/afficheimg/<?php echo $this->_var['ads']['ad_code']; ?>" /></a> </li>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
          </ol>
        </div>
        <ul class="none" id="lunboNum">
          <?php $_from = $this->_var['ad']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('k', 'ads');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['ads']):
?>
          <li  <?php if ($this->_var['k'] == 1): ?>class="cur"<?php endif; ?>></li>
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </ul>
        <!--<a style="display: none;" href="javascript:void(0);" class="show_next"><s></s></a> <a style="display: none;" href="javascript:void(0);" class="show_pre"><s></s></a> --></div>
    </div>
  <div class="w_sy_bfd">
    <h2>���տ���Ͷ��</h2>
	<div class="w_sy_bfd_1">
	  <span>�ó�����</span>
	  <div class="w_sy_bfd_1x">
      <select name="country" id="selCountries" onchange="region.changed(this, 1, 'selProvinces')" style="display:none;">
          <option value="1">�й�</option>
      </select>
      <select name="province" id="selProvinces" onchange="region.changed(this, 2, 'selCities')" style="border:none; width:80px; margin:0 20px;">
          <option value="0">��ѡ��ʡ</option>
      </select>
      <select name="city" id="selCities" onchange="region.changed(this, 3, 'selDistricts')" style="border:none; width:80px;">
          <option value="0">��ѡ����</option>
      </select>
      <div style="display:none;">
      <select name="district" id="selDistricts" >
          <option value="0">��ѡ����</option>
      </select>
      </div>
      <!--<i></i><span>��ɳ</span>
	  <ul>
	    <li><a href="" title="">��ɳ</a></li>
		<li><a href="" title="">��ɳ</a></li>
		<li><a href="" title="">��ɳ</a></li>
		<li><a href="" title="">��ɳ</a></li>
	  </ul>-->
	  </div>
	</div>
	<div class="w_sy_bfd_2">
	   <?php $_from = $this->_var['cx']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('k', 'r');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['r']):
?>
       <?php if ($this->_var['k'] < 7): ?>
       <span <?php if ($this->_var['k'] == 1 || $this->_var['k'] == 4): ?>class="no_le"<?php endif; ?> onclick="fuzhi('cat_id','<?php echo $this->_var['r']['cat_id']; ?>');"><i></i><?php echo $this->_var['r']['cat_name']; ?></span>
       <?php endif; ?>
	   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
       <input type="hidden" id="cat_id" value="" />
	</div>
	<div class="w_sy_bfd_3">
	 <a href="javascript:quote();" title="��ȡ����" class="w_sy_bfd_31">��ȡ����</a>
	 <a href="" title="����">����</a>
	</div>
  </div>
<script>
region.isAdmin = true;
$("#selCountries").change();
</script>
 </div>
 <div class="clear"></div>
 <div class="w_center">
 <div class="w_sy_f1">
   <div class="w_sy_f1_t">
     <span class="w_syf1_ta" id="wr1" onmouseover="setTab('wr',1,4,'w_syf1_ta')"><i></i>��˾����</span>
	 <span id="wr2" onmouseover="setTab('wr',2,4,'w_syf1_ta')"><i></i>��ҵ��̬</span>
	 <span id="wr3" onmouseover="setTab('wr',3,4,'w_syf1_ta')"><i></i>���շ���</span>
	 <span id="wr4" onmouseover="setTab('wr',4,4,'w_syf1_ta')"><i></i>��������</span>
   </div>
   <div class="w_sy_f1_n" id="con_wr_1" style="display:block;">
     <div class="w_sy_f1_n1">
	   <ul>
	     <?php $_from = $this->_var['news_gs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('k', 'gs');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['gs']):
?>
         <?php if ($this->_var['k'] < 2): ?>
         <li>
		   <a href="article.php?id=<?php echo $this->_var['gs']['article_id']; ?>" title="<?php echo $this->_var['gs']['title']; ?>"><img src="/<?php echo $this->_var['gs']['file_url']; ?>" title="<?php echo $this->_var['gs']['title']; ?>" alt="<?php echo $this->_var['gs']['title']; ?>"/></a>
		   <a href="article.php?id=<?php echo $this->_var['gs']['article_id']; ?>" title="<?php echo $this->_var['gs']['title']; ?>"><h2><?php echo sub_str($this->_var['gs']['title'],22); ?></h2></a>
		   <p><?php echo sub_str($this->_var['gs']['description'],84); ?><a href="article.php?id=<?php echo $this->_var['gs']['article_id']; ?>" title="�鿴����>>">�鿴����>></a></p>
		 </li>
         <?php endif; ?>
         <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	   </ul>
	 </div>
	 <div class="w_sy_f1_n2">
	   <ul>
	    <?php $_from = $this->_var['news_gs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('k', 'gs');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['gs']):
?>
        <?php if ($this->_var['k'] > 1): ?>
        <li><a href="article.php?id=<?php echo $this->_var['gs']['article_id']; ?>" title="<?php echo $this->_var['gs']['title']; ?>"><i>*</i><?php echo $this->_var['gs']['title']; ?></a></li>
        <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	   </ul>
	 </div> 
	 <div class="w_sy_f1_n3">
	  <a href="article_cat.php?id=6" title="�鿴����>>">�鿴����>></a>
	 </div> 
   </div>
   <div class="w_sy_f1_n" id="con_wr_2" style="display: none;">
     <div class="w_sy_f1_n1">
	   <ul>
	     <?php $_from = $this->_var['news_hy']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('k', 'gs');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['gs']):
?>
         <?php if ($this->_var['k'] < 2): ?>
         <li>
		   <a href="article.php?id=<?php echo $this->_var['gs']['article_id']; ?>" title="<?php echo $this->_var['gs']['title']; ?>"><img src="/<?php echo $this->_var['gs']['file_url']; ?>" title="<?php echo $this->_var['gs']['title']; ?>" alt="<?php echo $this->_var['gs']['title']; ?>"/></a>
		   <a href="article.php?id=<?php echo $this->_var['gs']['article_id']; ?>" title="<?php echo $this->_var['gs']['title']; ?>"><h2><?php echo sub_str($this->_var['gs']['title'],22); ?></h2></a>
		   <p><?php echo sub_str($this->_var['gs']['description'],84); ?><a href="article.php?id=<?php echo $this->_var['gs']['article_id']; ?>" title="�鿴����>>">�鿴����>></a></p>
		 </li>
         <?php endif; ?>
         <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	   </ul>
	 </div>
	 <div class="w_sy_f1_n2">
	   <ul>
	    <?php $_from = $this->_var['news_hy']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('k', 'gs');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['gs']):
?>
        <?php if ($this->_var['k'] > 1): ?>
        <li><a href="article.php?id=<?php echo $this->_var['gs']['article_id']; ?>" title="<?php echo $this->_var['gs']['title']; ?>"><i>*</i><?php echo $this->_var['gs']['title']; ?></a></li>
        <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	   </ul>
	 </div> 
	 <div class="w_sy_f1_n3">
	  <a href="article_cat.php?id=7" title="�鿴����>>">�鿴����>></a>
	 </div> 
   </div>
   <div class="w_sy_f1_n" id="con_wr_3" style="display: none;">
     <div class="w_sy_f1_n1">
	   <ul>
	     <?php $_from = $this->_var['news_bx']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('k', 'gs');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['gs']):
?>
         <?php if ($this->_var['k'] < 2): ?>
         <li>
		   <a href="article.php?id=<?php echo $this->_var['gs']['article_id']; ?>" title="<?php echo $this->_var['gs']['title']; ?>"><img src="/<?php echo $this->_var['gs']['file_url']; ?>" title="<?php echo $this->_var['gs']['title']; ?>" alt="<?php echo $this->_var['gs']['title']; ?>"/></a>
		   <a href="article.php?id=<?php echo $this->_var['gs']['article_id']; ?>" title="<?php echo $this->_var['gs']['title']; ?>"><h2><?php echo sub_str($this->_var['gs']['title'],22); ?></h2></a>
		   <p><?php echo sub_str($this->_var['gs']['description'],84); ?><a href="article.php?id=<?php echo $this->_var['gs']['article_id']; ?>" title="�鿴����>>">�鿴����>></a></p>
		 </li>
         <?php endif; ?>
         <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	   </ul>
	 </div>
	 <div class="w_sy_f1_n2">
	   <ul>
	    <?php $_from = $this->_var['news_bx']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('k', 'gs');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['gs']):
?>
        <?php if ($this->_var['k'] > 1): ?>
        <li><a href="article.php?id=<?php echo $this->_var['gs']['article_id']; ?>" title="<?php echo $this->_var['gs']['title']; ?>"><i>*</i><?php echo $this->_var['gs']['title']; ?></a></li>
        <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	   </ul>
	 </div> 
	 <div class="w_sy_f1_n3">
	  <a href="article_cat.php?id=8" title="�鿴����>>">�鿴����>></a>
	 </div> 
   </div>
   <div class="w_sy_f1_n" id="con_wr_4" style="display: none;">
     <div class="w_sy_f1_n1">
	   <ul>
	     <?php $_from = $this->_var['news_qt']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('k', 'gs');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['gs']):
?>
         <?php if ($this->_var['k'] < 2): ?>
         <li>
		   <a href="article.php?id=<?php echo $this->_var['gs']['article_id']; ?>" title="<?php echo $this->_var['gs']['title']; ?>"><img src="/<?php echo $this->_var['gs']['file_url']; ?>" title="<?php echo $this->_var['gs']['title']; ?>" alt="<?php echo $this->_var['gs']['title']; ?>"/></a>
		   <a href="article.php?id=<?php echo $this->_var['gs']['article_id']; ?>" title="<?php echo $this->_var['gs']['title']; ?>"><h2><?php echo sub_str($this->_var['gs']['title'],22); ?></h2></a>
		   <p><?php echo sub_str($this->_var['gs']['description'],84); ?><a href="article.php?id=<?php echo $this->_var['gs']['article_id']; ?>" title="�鿴����>>">�鿴����>></a></p>
		 </li>
         <?php endif; ?>
         <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	   </ul>
	 </div>
	 <div class="w_sy_f1_n2">
	   <ul>
	    <?php $_from = $this->_var['news_qt']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('k', 'gs');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['gs']):
?>
        <?php if ($this->_var['k'] > 1): ?>
        <li><a href="article.php?id=<?php echo $this->_var['gs']['article_id']; ?>" title="<?php echo $this->_var['gs']['title']; ?>"><i>*</i><?php echo $this->_var['gs']['title']; ?></a></li>
        <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	   </ul>
	 </div> 
	 <div class="w_sy_f1_n3">
	  <a href="article_cat.php?id=9" title="�鿴����>>">�鿴����>></a>
	 </div> 
   </div>
 </div>
 <div class="clear"></div>
 <div class="w_sy_f2">
   <h2 class="w_tit1">ȫ��λ����</h2>
   <ul>
     <li>
	  <a href="article_cat.php?id=12" title="�б�����"><img src="/images/w_f2_11.png" title="�б�����" alt="�б�����"/></a>
	  <div class="w_sy_f2_d"><a href="article_cat.php?id=12" title="�б�����"><img src="/images/w_f2_12.png" title="�б�����" alt="�б�����"/></a></div>
	 </li>
	 <li>
	  <a href="article.php?id=34" title="�������"><img src="/images/w_f2_21.png" title="�������" alt="�������"/></a>
	  <div class="w_sy_f2_d"><a href="article.php?id=34" title="�������"><img src="/images/w_f2_22.png" title="�������" alt="�������"/></a></div>
	 </li>
	 <li>
	  <a href="article_cat.php?id=10" title="�ó�����"><img src="/images/w_f2_31.png" title="�ó�����" alt="�ó�����"/></a>
	  <div class="w_sy_f2_d"><a href="article_cat.php?id=10" title="�ó�����"><img src="/images/w_f2_32.png" title="�ó�����" alt="�ó�����"/></a></div>
	 </li>
	 <li>
	  <a href="article_cat.php?id=6" title="��������"><img src="/images/w_f2_41.png" title="��������" alt="��������"/></a>
	  <div class="w_sy_f2_d"><a href="article_cat.php?id=6" title="��������"><img src="/images/w_f2_42.png" title="��������" alt="��������"/></a></div>
	 </li>
   </ul>
 </div>
 <div class="clear"></div>
 <div class="w_sy_f3">
  <div class="w_sy_f3_l"> 
   <div class="w_sy_f3_ltit"><i class="w_f3_i1"></i><b>��������</b>/ Ϊ���İ�����ݱ���</div>
   <div class="w_sy_f3_l_n">
     <div  class="w_sy_f3_l_n1">
	   <div class="w_sy_f3_l_n1_img"><a href="category.php?id=1" title="��������"><img src="/images/car_img.jpg"></a></div>
	   <ul>
	   <?php $_from = $this->_var['cx']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('k', 'r');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['r']):
?>
       <?php if ($this->_var['k'] < 9): ?>
       <li><a href="category.php?id=<?php echo $this->_var['r']['cat_id']; ?>" title="<?php echo $this->_var['r']['cat_name']; ?>"><?php echo $this->_var['r']['cat_name']; ?></a></li>
       <?php endif; ?>
	   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	   </ul>
	 </div>
	 <div class="w_sy_f3_l_n2 no_border_rgt">
	  <?php if ($this->_var['cx'] [ 9 ] [ 'cat_id' ]): ?>
       <h2>���չ�˾</h2>
	   <ul>
       <?php $_from = $this->_var['cx']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('k', 'r');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['r']):
?>
       <?php if ($this->_var['k'] > 8): ?>
	   <li><a href="category.php?id=<?php echo $this->_var['r']['cat_id']; ?>" title="<?php echo $this->_var['r']['cat_name']; ?>"><?php echo $this->_var['r']['cat_name']; ?></a></li>
       <?php endif; ?>
	   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	  </ul>
      <?php endif; ?>
	 </div>
   </div>
  </div>   
  <div class="w_sy_f3_r">
   <div class="w_sy_f3_rtit"><span class="w_sy_f3_rtit_s" id="tw1" onclick="setTab('tw',1,2,'w_sy_f3_rtit_s')">����TOP6</span><span id="tw2" onclick="setTab('tw',2,2,'w_sy_f3_rtit_s')">�����ֲ�</span></div>
   <ul id="con_tw_1" style="display:block;">
     <?php $_from = $this->_var['cx']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('k', 'r');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['r']):
?>
     <?php if ($this->_var['k'] < 6): ?>
     <li <?php if ($this->_var['k'] == 5): ?>class="no_bott"<?php endif; ?>>
	 <div class="w_sy_f3_rn1"><i <?php if ($this->_var['k'] == 1): ?>style="background:#f69311"<?php endif; ?>><?php echo $this->_var['k']; ?></i><a href="category.php?id=<?php echo $this->_var['r']['cat_id']; ?>" title="<?php echo $this->_var['r']['cat_name']; ?>"><?php echo $this->_var['r']['cat_name']; ?></a></div>
	 </li>
     <?php endif; ?>
     <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	  
	 <div class="w_xbl"><?php 
$k = array (
  'name' => 'ads',
  'id' => '4',
  'num' => '1',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?></div>
   </ul>
   <ul id="con_tw_2" style="display: none;">
     <?php $_from = $this->_var['cx_wz_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('k', 'r');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['r']):
?>
     <li <?php if ($this->_var['k'] == 5): ?>class="no_bott"<?php endif; ?>>
	 <div class="w_sy_f3_rn1"><i <?php if ($this->_var['k'] == 1): ?>style="background:#f69311"<?php endif; ?>><?php echo $this->_var['k']; ?></i><a href="article.php?id=<?php echo $this->_var['r']['article_id']; ?>" title="<?php echo $this->_var['r']['title']; ?>"><?php echo $this->_var['r']['title']; ?></a></div>
	 </li>
     <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	 <div class="w_xbl"><?php 
$k = array (
  'name' => 'ads',
  'id' => '5',
  'num' => '1',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?></div>
   </ul>
  </div>
 </div>
 <div class="clear"></div>
 <div class="w_xbanner"><?php 
$k = array (
  'name' => 'ads',
  'id' => '6',
  'num' => '1',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?></div>
 <div class="clear"></div>
 <div class="w_sy_f3">
  <div class="w_sy_f3_l"> 
   <div class="w_sy_f3_ltit"><i class="w_f3_i2"></i><b>���α���</b></div>
   <div class="w_sy_f3_l_n w_sy_3k">
     <div  class="w_sy_f3_l_n3">
	   <h2><span><i>��88</i>��</span>�������б���</h2>
	   <ul>
	   <?php $_from = $this->_var['jn_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'r');if (count($_from)):
    foreach ($_from AS $this->_var['r']):
?>
       <li><a href="goods.php?id=<?php echo $this->_var['r']['goods_id']; ?>" title="<?php echo $this->_var['r']['goods_name']; ?>"><?php echo $this->_var['r']['goods_name']; ?></a></li>
	   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	   </ul>
	 </div>
	 <div class="w_sy_f3_l_n4">
	   <h2><span><i>��100</i>��</span>�������б���</h2>
	   <ul>
	   <?php $_from = $this->_var['jw_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'r');if (count($_from)):
    foreach ($_from AS $this->_var['r']):
?>
       <li><a href="goods.php?id=<?php echo $this->_var['r']['goods_id']; ?>" title="<?php echo $this->_var['r']['goods_name']; ?>"><?php echo $this->_var['r']['goods_name']; ?></a></li>
	   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	  </ul> 
	 </div>
	 <div class="w_sy_f3_l_n5 no_border_rgt">
	   <h2><span><i>��100</i>��</span>�۰�̨���б���</h2>
	   <ul>
	   <?php $_from = $this->_var['gat_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'r');if (count($_from)):
    foreach ($_from AS $this->_var['r']):
?>
       <li><a href="goods.php?id=<?php echo $this->_var['r']['goods_id']; ?>" title="<?php echo $this->_var['r']['goods_name']; ?>"><?php echo $this->_var['r']['goods_name']; ?></a></li>
	   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	  </ul> 
	 </div>
   </div>
  </div>   
  <div class="w_sy_f3_r">
   <div class="w_sy_f3_rtit"><span class="w_sy_f3_rtit_s" id="tj1" onclick="setTab('tj',1,2,'w_sy_f3_rtit_s')">����TOP3</span><span id="tj2" onclick="setTab('tj',2,2,'w_sy_f3_rtit_s')">�����ֲ�</span></div>
   <ul id="con_tj_1" style="display:block;">
     <?php $_from = $this->_var['ly_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('k', 'r');$this->_foreach['ly_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['ly_list']['total'] > 0):
    foreach ($_from AS $this->_var['k'] => $this->_var['r']):
        $this->_foreach['ly_list']['iteration']++;
?>
     <li <?php if (($this->_foreach['ly_list']['iteration'] == $this->_foreach['ly_list']['total'])): ?>class="no_bott"<?php endif; ?>>
	 <div class="w_sy_f3_rn1"><i <?php if ($this->_var['k'] == 1): ?>style="background:#f69311"<?php endif; ?>><?php echo $this->_var['k']; ?></i><a href="goods.php?id=<?php echo $this->_var['r']['goods_id']; ?>" title="<?php echo $this->_var['r']['goods_name']; ?>"><?php echo $this->_var['r']['goods_name']; ?></a></div>
	 <div class="w_sy_f3_rn2"><i>������<?php echo $this->_var['r']['salesnum']; ?></i>��<em><?php echo $this->_var['r']['shop_price']; ?></em>��</div>
	 </li>
     <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	  
	 <div class="w_xbl"><?php 
$k = array (
  'name' => 'ads',
  'id' => '7',
  'num' => '1',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?></div>
   </ul>
   <ul id="con_tj_2" style="display: none;">
     <?php $_from = $this->_var['ly_wz_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('k', 'r');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['r']):
?>
     <li <?php if ($this->_var['k'] == 5): ?>class="no_bott"<?php endif; ?>>
	 <div class="w_sy_f3_rn1"><i <?php if ($this->_var['k'] == 1): ?>style="background:#f69311"<?php endif; ?>><?php echo $this->_var['k']; ?></i><a href="article.php?id=<?php echo $this->_var['r']['article_id']; ?>" title="<?php echo $this->_var['r']['title']; ?>"><?php echo $this->_var['r']['title']; ?></a></div>
	 </li>
     <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	 <div class="w_xbl"><?php 
$k = array (
  'name' => 'ads',
  'id' => '8',
  'num' => '1',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?></div>
   </ul>
  </div>
 </div>
 <div class="clear"></div>
 <div class="w_xbanner"><?php 
$k = array (
  'name' => 'ads',
  'id' => '9',
  'num' => '1',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?></div>
 <div class="clear"></div>
 <div class="w_sy_f3">
  <div class="w_sy_f3_l"> 
   <div class="w_sy_f3_ltit"><i class="w_f3_i3"></i><b>���Ᵽ��</b></div>
   <div class="w_sy_f3_l_n w_sy_3k">
     <div  class="w_sy_f3_l_n6">
	   <h2>������</h2>
	   <ul>
	   <?php $_from = $this->_var['dz_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'r');if (count($_from)):
    foreach ($_from AS $this->_var['r']):
?>
       <li><a href="goods.php?id=<?php echo $this->_var['r']['goods_id']; ?>" title="<?php echo $this->_var['r']['goods_name']; ?>"><?php echo $this->_var['r']['goods_name']; ?></a></li>
	   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
       </ul>
	 </div>
	 <div class="w_sy_f3_l_n7">
	   <h2>��ͨ����</h2>
	   <ul>
	   <?php $_from = $this->_var['czw_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'r');if (count($_from)):
    foreach ($_from AS $this->_var['r']):
?>
       <li><a href="goods.php?id=<?php echo $this->_var['r']['goods_id']; ?>" title="<?php echo $this->_var['r']['goods_name']; ?>"><?php echo $this->_var['r']['goods_name']; ?></a></li>
	   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	  </ul> 
	 </div>
	 <div class="w_sy_f3_l_n8 no_border_rgt">
	   <h2>��������</h2>
	   <ul>
	   <?php $_from = $this->_var['hz_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'r');if (count($_from)):
    foreach ($_from AS $this->_var['r']):
?>
       <li><a href="goods.php?id=<?php echo $this->_var['r']['goods_id']; ?>" title="<?php echo $this->_var['r']['goods_name']; ?>"><?php echo $this->_var['r']['goods_name']; ?></a></li>
	   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	  </ul> 
	 </div>
   </div>
  </div>   
  <div class="w_sy_f3_r">
   <div class="w_sy_f3_rtit"><span class="w_sy_f3_rtit_s" id="tx1" onclick="setTab('tx',1,2,'w_sy_f3_rtit_s')">����TOP3</span><span id="tx2" onclick="setTab('tx',2,2,'w_sy_f3_rtit_s')">�����ֲ�</span></div>
   <ul id="con_tx_1" style="display:block;">
     <?php $_from = $this->_var['jc_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('k', 'r');$this->_foreach['jc_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['jc_list']['total'] > 0):
    foreach ($_from AS $this->_var['k'] => $this->_var['r']):
        $this->_foreach['jc_list']['iteration']++;
?>
     <li <?php if (($this->_foreach['jc_list']['iteration'] == $this->_foreach['jc_list']['total'])): ?>class="no_bott"<?php endif; ?>>
	 <div class="w_sy_f3_rn1"><i <?php if ($this->_var['k'] == 1): ?>style="background:#f69311"<?php endif; ?>><?php echo $this->_var['k']; ?></i><a href="goods.php?id=<?php echo $this->_var['r']['goods_id']; ?>" title="<?php echo $this->_var['r']['goods_name']; ?>"><?php echo $this->_var['r']['goods_name']; ?></a></div>
	 <div class="w_sy_f3_rn2"><i>������<?php echo $this->_var['r']['salesnum']; ?></i>��<em><?php echo $this->_var['r']['shop_price']; ?></em>��</div>
	 </li>
     <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	 <div class="w_xbl"><a href="" title=""><img src="/images/w_xbanner_3.jpg" title="" alt=""/></a></div>
   </ul>
   <ul id="con_tx_2" style="display: none;">
     <?php $_from = $this->_var['jc_wz_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('k', 'r');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['r']):
?>
     <li <?php if ($this->_var['k'] == 5): ?>class="no_bott"<?php endif; ?>>
	 <div class="w_sy_f3_rn1"><i <?php if ($this->_var['k'] == 1): ?>style="background:#f69311"<?php endif; ?>><?php echo $this->_var['k']; ?></i><a href="article.php?id=<?php echo $this->_var['r']['article_id']; ?>" title="<?php echo $this->_var['r']['title']; ?>"><?php echo $this->_var['r']['title']; ?></a></div>
	 </li>
     <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	 <div class="w_xbl"><a href="" title=""><img src="/images/w_xbanner_1.jpg" title="" alt=""/></a></div>
   </ul>
  </div>
 </div>
 <div class="clear"></div>
 <div class="w_sy_f4">
   <h2 class="w_tit1">֪���������</h2>
   <div class="w_bd_3">
       <div onmouseup="StopUp_3()" class="LeftBotton3" onmousedown="GoUp_3()" onmouseout="StopUp_3()"></div>
      <div class="Cont3" id="Cont_3">
        <div class="ScrCont">
          <div id="List1_3">
            
           <?php $_from = $this->_var['hz']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('k', 'link');$this->_foreach['link'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['link']['total'] > 0):
    foreach ($_from AS $this->_var['k'] => $this->_var['link']):
        $this->_foreach['link']['iteration']++;
?>
            <?php if (($this->_foreach['link']['iteration'] == $this->_foreach['link']['total']) && ( $this->_var['k'] + 1 ) % 2): ?>
            <div class="box3">
             <img src="<?php echo $this->_var['link']['logo']; ?>" title="<?php echo $this->_var['link']['name']; ?>" alt="<?php echo $this->_var['link']['name']; ?>" />
             </div>
            <?php elseif (( $this->_var['k'] + 1 ) % 2): ?>
            <div class="box3">
              <img src="<?php echo $this->_var['link']['logo']; ?>" title="<?php echo $this->_var['link']['name']; ?>" alt="<?php echo $this->_var['link']['name']; ?>" />
            <?php else: ?>
			 <img src="<?php echo $this->_var['link']['logo']; ?>" title="<?php echo $this->_var['link']['name']; ?>" alt="<?php echo $this->_var['link']['name']; ?>" />
            </div>
            <?php endif; ?>
           <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			
            
          </div>
          <div id="List2_3"></div>
        </div>
      </div>
      <div onmouseup="ISL_StopDown_3()" class="RightBotton3" onmousedown="ISL_GoDown_3()" onmouseout="ISL_StopDown_3()"></div>
      <script type="text/javascript" src="/js/rollpic3.js"></script>
    </div>
 </div>
 <div class="clear"></div>
 <div class="w_sy_f5">
   <h2 class="w_tit2">�߳�Ϊ�� ���ǹ���</h2>
   <div class="w_sy_f5_n">
    <img src="/images/w_ty_bt.jpg" title="�߳�Ϊ�� ���ǹ���" alt="�߳�Ϊ�� ���ǹ���"/>
   </div>
 </div>  
 </div>
<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>
</html>
