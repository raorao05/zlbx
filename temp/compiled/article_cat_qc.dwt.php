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
   <div class="w_qcgg"><?php 
$k = array (
  'name' => 'ads',
  'id' => '2',
  'num' => '1',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?></div>
   <div class="w_qcgg_1">
     <li>
	  <a href="article.php?id=17" title="���������ۺϷ���"><p>���������ۺϷ���</p><span></span><img src="/images/w_qcfw_2.jpg" title="���������ۺϷ���" alt="���������ۺϷ���"/></a>
	 </li>
	 <li>
	  <a href="article.php?id=18" title="�³������ۺϷ���"><p>�³������ۺϷ���</p><span></span><img src="/images/w_qcfw_3.jpg" title="�³������ۺϷ���" alt="�³������ۺϷ���"/></a>
	 </li>
	 <li>
	  <a href="article.php?id=19" title="�������������ۺϷ���"><p>�������������ۺϷ���</p><span></span><img src="/images/w_qcfw_4.jpg" title="�������������ۺϷ���" alt="�������������ۺϷ���"/></a>
	 </li>
	 <li>
	  <a href="article.php?id=20" title="��ֵ����"><p>��ֵ����</p><span></span><img src="/images/w_qcfw_5.jpg" title="��ֵ����" alt="��ֵ����"/></a>
	 </li>
	 <li>
	  <a href="article.php?id=21" title="���ֳ��ۺϷ���"><p>���ֳ��ۺϷ���</p><span></span><img src="/images/w_qcfw_6.jpg" title="���ֳ��ۺϷ���" alt="���ֳ��ۺϷ���"/></a>
	 </li>
	 <li>
	  <a href="article_cat.php?id=11" title="��������"><p>��������</p><span></span><img src="/images/w_qcfw_7.jpg" title="��������" alt="��������"/></a>
	 </li>
   </div>
</div>
<script type="text/javascript">
$(function(){
    $(".w_qcgg_1 li").each(function(index){
      if(index%2==0){
        $(this).css('marginLeft','0px');
      }
    })    
})


</script>
<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>
</html>
