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
			<h2>车险快速投保</h2>
			<div class="w_sy_bfd_1">
				<span>用车城市</span>
				<div class="w_sy_bfd_1x">
					<select name="country" id="selCountries" onchange="region.changed(this, 1, 'selProvinces')" style="display:none;">
						<option value="1">中国</option>
					</select>
					<select name="province" id="selProvinces" onchange="region.changed(this, 2, 'selCities')" style="border:none; width:80px; margin:0 20px;">
						<option value="0">请选择省</option>
					</select>
					<select name="city" id="selCities" onchange="region.changed(this, 3, 'selDistricts')" style="border:none; width:80px;">
						<option value="0">请选择市</option>
					</select>
					<div style="display:none;">
						<select name="district" id="selDistricts" >
							<option value="0">请选择区</option>
						</select>
					</div>
					<!--<i></i><span>长沙</span>
                    <ul>
                      <li><a href="" title="">长沙</a></li>
                      <li><a href="" title="">长沙</a></li>
                      <li><a href="" title="">长沙</a></li>
                      <li><a href="" title="">长沙</a></li>
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
				<a href="javascript:quote();" title="获取报价" class="w_sy_bfd_31">获取报价</a>
				<a href="" title="续保">续保</a>
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
		<div class="title_box"><b>车险保什么？<i>车险不复杂，中联车险管家为您条条解读，选您所需。</i> </b></div>
		<div class="cxlb_box2">
			<div class="title_1 title">司机座位责任险
				<div class="content">
                    <laber>保什么？</laber>
                    <p>该险种为附加险，主要赔偿车辆因交通事故造成的车内人员的伤亡。分为司机座位责任险和乘客座位责任险。</p>
                    <laber>我需要买吗？</laber>
                    <p>1、新手及经常开车的人，容易发生意外事故，建议购买司机座位责任险。</p>
                    <p>2、经常载人出行的人，建议投保乘客座位责任险。</p>
                    <p>3、家庭车辆，建议为所有座位都投保该险种。</p>
                </div>
			</div>
			<div class="title_2 title">玻璃单独破碎险
				<div class="content">
                    <laber>保什么？</laber>
                    <p>该险种承保挡风玻璃和车窗玻璃破碎造成的损失，如高速行驶被石子击碎车窗、高空坠物造成玻璃破碎等情况。需注意，车灯、车镜玻璃、天窗玻璃、车窗贴膜损失不在保障范围内。</p>
                    <laber>我需要买吗？</laber>
                    <p>1、新车上路备受呵护，建议投保</p>
                    <p>2、高速公路行车频繁的，建议投保</p>
                    <p>3、露天停放，担心高空坠物损伤的，建议投保</p>
                    </div>
			</div>
			<div class="title_3 title">车辆损失险
				<div class="content">
                    <laber>保什么？</laber>
                    <p>车辆因意外事故或自然灾害遭受到任何损失，车损险都可以进行赔付。包括车辆碰撞、车子受损、意外损害等等。车损险保障范围广泛，是驾驶员最佳保险选择。</p>
                    <laber>我需要买吗？</laber>
                    <p>1、新手新车最易发生事故，十分有必要购买</p>
                    <p>2、任何车辆都有投保车损险的必要性。如今修车费用动辄数千元，购买车损险都可获得赔付，性价比极高。</p>
                    </div>
			</div>
			<div class="title_4 title">商业第三者责任险
				<div class="content">
                    <laber>保什么？</laber>
                    <p>当驾驶员在使用车辆过程中发生意外事故，导致第三者遭受人身伤亡或财产直接损毁，依法应当由被保险人承担的经济责任，保险公司负责赔偿。</p>
                    <laber>我需要买吗？</laber>
                    <p>1、交强险对于第三者财产损失及医疗费用赔偿较低，因此担心赔付能力不足的，都建议购买三责险。</p>
                    <p>2、意外撞车、车辆伤人等严重交通事故，三者险都可以弥补一定的经济损失。</p>
                    </div>
			</div>
			<div class="title_5 title">不计免赔险
				<div class="content">
                <laber>保什么？</laber>
                    <p>不计免赔特约险是指经特别约定之后，当发生保险事故，对应投保的险种可以提高保险赔偿限额。如三者险的免赔额是15%，投保不计免赔特约险之后，15%的免赔由保险公司承担。</p>
                    <laber>我需要买吗？</laber>
                    <p> 该险种保费低，但能全面的降低车险赔付标准，轻微损失也可获得全额赔偿，是车险最佳搭配险种，特别推荐购买。</p>
                    </div>
			</div>
			<div class="title_6 title">自燃损失险
				<div class="content">
                <laber>保什么？</laber>
                    <p>因本车电器、线路、供油系统发生故障及运载货物自身原因起火燃烧，造成保险车辆的损失，保险公司按照条款规定进行赔付。</p>
                    <laber>我需要买吗？</laber>
                    <p>1、车辆行驶超过3万公里后，车辆内部零件磨损严重，建议投保。</p>
                    <p>2、行驶多年的车辆，油路跟电路老化，建议投保。</p>
                    <p>3、夏季高温，露天停放的车子建议投保自燃险</p>
                    <p>4、公共营运车辆建议投保</p>
                    <p>5、长途运营车辆或者货车，都建议投保自燃险。</p>
                    </div>
			</div>
			<div class="title_7 title">全车防盗险
				<div class="content">
                <laber>保什么？</laber>
                    <p>全车被盗窃、被抢劫、被抢夺造成的车辆损失以及在被盗窃、被抢劫、被抢夺期间受到损坏或车上零部件、附属设备丢失需要修复的合理费用，保险公司予以赔付。</p>
                    <laber>我需要买吗？</laber>
                    <p>以下情况建议投保盗抢险</p>
                    <p>1、新车盗抢风险较大，建议两年之内的车都购买盗抢险</p>
                    <p>2、本田雅阁、桑塔纳、丰田凯美瑞等车型极易被盗，建议投保</p>
                    <p>3、露天停放或者无固定停车点的车主</p>
                    <p>4、周遭治安环境不好，建议购买</p>
                    <p>5、价格较贵的车，建议购买盗抢险</p>
                    </div>
			</div>
			<div class="title_8 title">涉水行驶损失险
				<div class="content">
                <laber>保什么？</laber>
                    <p>涉水险也成为发动机特别损失险，当保险车辆在积水路面涉水行驶或被水淹后致使发动机损坏可给予赔偿。但车主在水中"二次打火"造成损失，该险种不予理赔。</p>
                    <laber>我需要买吗？</laber>
                    <p>以下情况建议购买：</p>
                    <p>1、洪涝灾害、暴雨频发地区的车主</p>
                    <p>2、常年停放在地下车库，排水系统较差的情况</p>
                    <p>3、南方夏季雨水较多，车辆很容易被淹，有必要投保</p>
                    <p>4、所在城市排水系统不好，且露天停放的车辆。北京暴雨之后，该险种的需求明显上升，建议大家投保，有备无患。</p>
                    </div>
			</div>
			<div class="title_9 title">车身划痕险
				<div class="content"> 
                <laber>保什么？</laber>
                    <p>车身划痕险可保障车身因尖锐物体如小刀、石子、钥匙等造成的车漆破坏。而与其他物体发生碰撞造成的损失如车辆碰撞、剐蹭到固定物体等情况，不包含在划痕险的保障范围内。</p>
                    <laber>我需要买吗？</laber>
                    <p> 以下情况建议投保划痕险：</p>
                    <p>1、新车上路，建议购买划痕险</p>
                    <p>2、长期露天停放的车辆</p>
                    <p>3、所在小区孩子较多，玩耍易造成车漆刮花，建议购买</p>
                    </div>
			</div>
			<div class="title_10 title">乘客座位责任险
				<div class="content"> 
                <laber>保什么？</laber>
                    <p>车辆由于发生碰撞等意外事故而造成的车上新增设备的直接损失，包括：加装制冷设备、CD及电视录像设备、真皮或电动座椅等等的直接损毁时，保险公司按实际损失赔偿。</p>
                    <laber>我需要买吗？</laber>
                    <p> 以下任一情况建议投保：</p>
                    <p>1、车上设备较多的车辆</p>
                    <p>2、重新装修过并新增加设备的车辆</p>
                    <p>3、车上设备价值较高的车辆</p>
                    </div>
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
	</div>
	<div class="clear"></div>
	<div class="cxlb_table">
		<img src="/images/cxlb_table.jpg" alt="表格" title="表格"/>
		<div class="but_box">
			<a href="category.php?id=32">获取报价</a>
			<a href="category.php?id=3">获取报价</a>
			<a href="category.php?id=2">获取报价</a>
			<a href="">获取报价</a>
			<a href="">获取报价</a>
			<a href="">获取报价</a>
			<a href="">获取报价</a>
			<div class="clear"></div>
		</div>
	</div>
	<div class="cxhdd">
		<div class="title_box"><b>车险好搭档<i>全面抵御出行风险</i> </b></div>
		<div class="cxhdd_pro">
			<?php $_from = $this->_var['best_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('k', 'r');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['r']):
?>
			<?php if ($this->_var['k'] < 4): ?>
			<div class="pro_1">
				<img src="/<?php echo $this->_var['r']['goods_img']; ?>"/>
				<div class="pro_txt"><h5><?php echo $this->_var['r']['name']; ?></h5><p><?php echo $this->_var['r']['short_name']; ?><a href="<?php echo $this->_var['r']['url']; ?>">查看详情></a></p></div>
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
