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

	<?php echo $this->smarty_insert_scripts(array('files'=>'transport.js,region.js')); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'jquery.js,jquery.json-2.4.min.js')); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'common.js,global.js,compare.js')); ?>
</head>

<body>
<?php echo $this->fetch('library/page_header.lbi'); ?>
<div class="w_center">
	<div class="w_dqwz"><?php echo $this->fetch('library/ur_here.lbi'); ?></div>
	<div class="w_qcgg" style="position: relative"><img src="/images/w_cxlb_1.jpg" title="" alt=""/>
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
			function quote(){
				var cat_id=document.getElementById('cat_id').value;
				var reg_id=document.getElementById('selCities').value;

				window.location.href='category.php?id='+cat_id+'&reg_id='+reg_id;
			}
			function fuzhi(id,zhi){
				document.getElementById(id).value=zhi;
			}
			$(function(){
				$(".w_sy_bfd_2 span").click(function(){
					$(".w_sy_bfd_2").find("span").removeClass("w_span_dq");
					$(this).addClass('w_span_dq');
				});
			});
		</script>
	</div>
	

	<div class="w_cxlb_boxl">
		<div class="title_box"><b>���ձ�ʲô��<i>���ղ����ӣ��������չܼ�Ϊ�����������ѡ�����衣</i> </b></div>
		<div class="cxlb_box2">
			<div class="title_1 title">˾����λ������
				<div class="content">
                    <laber>��ʲô��</laber>
                    <p>������Ϊ�����գ���Ҫ�⳥������ͨ�¹���ɵĳ�����Ա����������Ϊ˾����λ�����պͳ˿���λ�����ա�</p>
                    <laber>����Ҫ����</laber>
                    <p>1�����ּ������������ˣ����׷��������¹ʣ����鹺��˾����λ�����ա�</p>
                    <p>2���������˳��е��ˣ�����Ͷ���˿���λ�����ա�</p>
                    <p>3����ͥ����������Ϊ������λ��Ͷ�������֡�</p>
                </div>
			</div>
			<div class="title_2 title">��������������
				<div class="content">
                    <laber>��ʲô��</laber>
                    <p>�����ֳб����粣���ͳ�������������ɵ���ʧ���������ʻ��ʯ�ӻ��鳵�����߿�׹����ɲ���������������ע�⣬���ơ������������촰������������Ĥ��ʧ���ڱ��Ϸ�Χ�ڡ�</p>
                    <laber>����Ҫ����</laber>
                    <p>1���³���·���ܺǻ�������Ͷ��</p>
                    <p>2�����ٹ�·�г�Ƶ���ģ�����Ͷ��</p>
                    <p>3��¶��ͣ�ţ����ĸ߿�׹�����˵ģ�����Ͷ��</p>
                    </div>
			</div>
			<div class="title_3 title">������ʧ��
				<div class="content">
                    <laber>��ʲô��</laber>
                    <p>�����������¹ʻ���Ȼ�ֺ����ܵ��κ���ʧ�������ն����Խ����⸶������������ײ���������������𺦵ȵȡ������ձ��Ϸ�Χ�㷺���Ǽ�ʻԱ��ѱ���ѡ��</p>
                    <laber>����Ҫ����</laber>
                    <p>1�������³����׷����¹ʣ�ʮ���б�Ҫ����</p>
                    <p>2���κγ�������Ͷ�������յı�Ҫ�ԡ�����޳����ö�����ǧԪ���������ն��ɻ���⸶���Լ۱ȼ��ߡ�</p>
                    </div>
			</div>
			<div class="title_4 title">��ҵ������������
				<div class="content">
                    <laber>��ʲô��</laber>
                    <p>����ʻԱ��ʹ�ó��������з��������¹ʣ����µ�������������������Ʋ�ֱ����٣�����Ӧ���ɱ������˳е��ľ������Σ����չ�˾�����⳥��</p>
                    <laber>����Ҫ����</laber>
                    <p>1����ǿ�ն��ڵ����߲Ʋ���ʧ��ҽ�Ʒ����⳥�ϵͣ���˵����⸶��������ģ������鹺�������ա�</p>
                    <p>2������ײ�����������˵����ؽ�ͨ�¹ʣ������ն������ֲ�һ���ľ�����ʧ��</p>
                    </div>
			</div>
			<div class="title_5 title">����������
				<div class="content">
                <laber>��ʲô��</laber>
                    <p>����������Լ����ָ���ر�Լ��֮�󣬵����������¹ʣ���ӦͶ�������ֿ�����߱����⳥�޶�������յ��������15%��Ͷ������������Լ��֮��15%�������ɱ��չ�˾�е���</p>
                    <laber>����Ҫ����</laber>
                    <p> �����ֱ��ѵͣ�����ȫ��Ľ��ͳ����⸶��׼����΢��ʧҲ�ɻ��ȫ���⳥���ǳ�����Ѵ������֣��ر��Ƽ�����</p>
                    </div>
			</div>
			<div class="title_6 title">��ȼ��ʧ��
				<div class="content">
                <laber>��ʲô��</laber>
                    <p>�򱾳���������·������ϵͳ�������ϼ����ػ�������ԭ�����ȼ�գ���ɱ��ճ�������ʧ�����չ�˾��������涨�����⸶��</p>
                    <laber>����Ҫ����</laber>
                    <p>1��������ʻ����3����󣬳����ڲ����ĥ�����أ�����Ͷ����</p>
                    <p>2����ʻ����ĳ�������·����·�ϻ�������Ͷ����</p>
                    <p>3���ļ����£�¶��ͣ�ŵĳ��ӽ���Ͷ����ȼ��</p>
                    <p>4������Ӫ�˳�������Ͷ��</p>
                    <p>5����;��Ӫ�������߻�����������Ͷ����ȼ�ա�</p>
                    </div>
			</div>
			<div class="title_7 title">ȫ��������
				<div class="content">
                <laber>��ʲô��</laber>
                    <p>ȫ�������ԡ������١���������ɵĳ�����ʧ�Լ��ڱ����ԡ������١��������ڼ��ܵ��𻵻����㲿���������豸��ʧ��Ҫ�޸��ĺ�����ã����չ�˾�����⸶��</p>
                    <laber>����Ҫ����</laber>
                    <p>�����������Ͷ��������</p>
                    <p>1���³��������սϴ󣬽�������֮�ڵĳ������������</p>
                    <p>2�������Ÿ�ɣ���ɡ����￭����ȳ��ͼ��ױ���������Ͷ��</p>
                    <p>3��¶��ͣ�Ż����޹̶�ͣ����ĳ���</p>
                    <p>4�������ΰ��������ã����鹺��</p>
                    <p>5���۸�Ϲ�ĳ������鹺�������</p>
                    </div>
			</div>
			<div class="title_8 title">��ˮ��ʻ��ʧ��
				<div class="content">
                <laber>��ʲô��</laber>
                    <p>��ˮ��Ҳ��Ϊ�������ر���ʧ�գ������ճ����ڻ�ˮ·����ˮ��ʻ��ˮ�ͺ���ʹ�������𻵿ɸ����⳥����������ˮ��"���δ��"�����ʧ�������ֲ������⡣</p>
                    <laber>����Ҫ����</laber>
                    <p>����������鹺��</p>
                    <p>1�������ֺ�������Ƶ�������ĳ���</p>
                    <p>2������ͣ���ڵ��³��⣬��ˮϵͳ�ϲ�����</p>
                    <p>3���Ϸ��ļ���ˮ�϶࣬���������ױ��ͣ��б�ҪͶ��</p>
                    <p>4�����ڳ�����ˮϵͳ���ã���¶��ͣ�ŵĳ�������������֮�󣬸����ֵ���������������������Ͷ�����б��޻���</p>
                    </div>
			</div>
			<div class="title_9 title">��������
				<div class="content"> 
                <laber>��ʲô��</laber>
                    <p>�������տɱ��ϳ��������������С����ʯ�ӡ�Կ�׵���ɵĳ����ƻ��������������巢����ײ��ɵ���ʧ�糵����ײ���в䵽�̶������������������ڻ����յı��Ϸ�Χ�ڡ�</p>
                    <laber>����Ҫ����</laber>
                    <p> �����������Ͷ�������գ�</p>
                    <p>1���³���·�����鹺�򻮺���</p>
                    <p>2������¶��ͣ�ŵĳ���</p>
                    <p>3������С�����ӽ϶࣬��ˣ����ɳ���λ������鹺��</p>
                    </div>
			</div>
			<div class="title_10 title">�˿���λ������
				<div class="content"> 
                <laber>��ʲô��</laber>
                    <p>�������ڷ�����ײ�������¹ʶ���ɵĳ��������豸��ֱ����ʧ����������װ�����豸��CD������¼���豸����Ƥ��綯���εȵȵ�ֱ�����ʱ�����չ�˾��ʵ����ʧ�⳥��</p>
                    <laber>����Ҫ����</laber>
                    <p> ������һ�������Ͷ����</p>
                    <p>1�������豸�϶�ĳ���</p>
                    <p>2������װ�޹����������豸�ĳ���</p>
                    <p>3�������豸��ֵ�ϸߵĳ���</p>
                    </div>
			</div>
		</div>
	</div>
	
	<div class="w_cplb_r">
		<div class="w_bxxyl_1">
			<h2>������Ʒ</h2>
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
	</div>
	<div class="clear"></div>
	<div class="cxlb_table">
		<img src="/images/cxlb_table.jpg" alt="���" title="���"/>
		<div class="but_box">
			<a href="category.php?id=32">��ȡ����</a>
			<a href="category.php?id=3">��ȡ����</a>
			<a href="category.php?id=2">��ȡ����</a>
			<a href="">��ȡ����</a>
			<a href="">��ȡ����</a>
			<a href="">��ȡ����</a>
			<a href="">��ȡ����</a>
			<div class="clear"></div>
		</div>
	</div>
	<div class="cxhdd">
		<div class="title_box"><b>���պô<i>ȫ��������з���</i> </b></div>
		<div class="cxhdd_pro">
			<?php $_from = $this->_var['best_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('k', 'r');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['r']):
?>
			<?php if ($this->_var['k'] < 4): ?>
			<div class="pro_1">
				<img src="/<?php echo $this->_var['r']['goods_img']; ?>"/>
				<div class="pro_txt"><h5><?php echo $this->_var['r']['name']; ?></h5><p><?php echo $this->_var['r']['short_name']; ?><a href="<?php echo $this->_var['r']['url']; ?>">�鿴����></a></p></div>
				<div class="clear"></div>
			</div>
			<?php endif; ?>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</div>
	</div>
</div>
<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>
</html>
