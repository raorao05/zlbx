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
<script src="/js/jquery.json-2.4.min.js"></script>
<?php echo $this->smarty_insert_scripts(array('files'=>'transport.js,common.js,utils.js')); ?>


<?php echo $this->smarty_insert_scripts(array('files'=>'common.js')); ?>
<script type="text/javascript">
function $id(element) {
  return document.getElementById(element);
}
//切屏--是按钮，_v是内容平台，_h是内容库
function reg(str){
  var bt=$id(str+"_b").getElementsByTagName("h2");
  for(var i=0;i<bt.length;i++){
    bt[i].subj=str;
    bt[i].pai=i;
    bt[i].style.cursor="pointer";
    bt[i].onclick=function(){
      $id(this.subj+"_v").innerHTML=$id(this.subj+"_h").getElementsByTagName("blockquote")[this.pai].innerHTML;
      for(var j=0;j<$id(this.subj+"_b").getElementsByTagName("h2").length;j++){
        var _bt=$id(this.subj+"_b").getElementsByTagName("h2")[j];
        var ison=j==this.pai;
        _bt.className=(ison?"":"h2bg");
      }
    }
  }
  $id(str+"_h").className="none";
  $id(str+"_v").innerHTML=$id(str+"_h").getElementsByTagName("blockquote")[0].innerHTML;
}
$(document).ready(function () { 
   var w1 = $(".w_an_l2").height();
   var txt = w1 + "px" ;
   $(".w_an_l1").css({"height": txt, "line-height": txt});
});

function type_css(id,sid){
	$("#"+id).click(function(){
		$("#"+id).find("span").removeClass("w_al_s1");
		$("#"+sid).find("span").addClass('w_al_s1');
	});
}
</script>
<style>
.commentsList{border:1px solid #ccc; background:#f7f7f7; padding:10px; font-size:13px;}
.commentsList .inputBorder{border:1px solid #ccc; background:#fff;}
.captcha{margin-left:0px; position:relative; top:-1px; *margin-left:8px; *position:relative; top:3px; cursor:pointer;}
</style>
</head>
<body>
<?php echo $this->fetch('library/page_header.lbi'); ?>
<div class="w_center"> 
   <div class="w_dqwz"><?php echo $this->fetch('library/ur_here.lbi'); ?></div>
   <div class="w_alfx">
     <div class="w_alfx_1">
	     <h2><?php echo $this->_var['goods']['goods_name']; ?></h2>
		 <h3><?php echo $this->_var['goods']['goods_brief']; ?></h3>
	     <div class="w_alfx_1l">
		   <div class="w_alfx_1l_img"><img src="<?php echo $this->_var['goods']['goods_img']; ?>" alt="<?php echo $this->_var['goods']['goods_name']; ?>" /></div>
		   <div class="w_alfx_1l_1">
      <div class="bdsharebuttonbox bdshare-button-style0-16" data-bd-bind="1457407242957"><em>分享:</em><a class="bds_more" href="#" data-cmd="more"></a><a class="bds_qzone" title="分享到QQ空间" href="#" data-cmd="qzone"></a><a class="bds_tsina" title="分享到新浪微博" href="#" data-cmd="tsina"></a><a class="bds_tqq" title="分享到腾讯微博" href="#" data-cmd="tqq"></a><a class="bds_renren" title="分享到人人网" href="#" data-cmd="renren"></a><a class="bds_weixin" title="分享到微信" href="#" data-cmd="weixin"></a></div>
<script>    window._bd_share_config = { "common": { "bdSnsKey": {}, "bdText": "", "bdMini": "2", "bdPic": "", "bdStyle": "0", "bdSize": "16" }, "share": {}, "selectShare": {"bdContainerClass": null, "bdSelectMiniList": ["qzone", "tsina", "tqq", "renren", "weixin"]} }; with (document) 0[(getElementsByTagName('head')[0] || body).appendChild(createElement('script')).src = 'http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion=' + ~(-new Date() / 36e5)];
</script>
		   </div>
		   <div class="w_alfx_1l_2">
		     <em onclick="javascript:collect(<?php echo $this->_var['goods']['goods_id']; ?>);"><i></i>收藏 </em><span>共有（<?php echo $this->_var['collect_num']; ?>）人收藏</span>
		   </div>
		 </div>
		 <div class="w_alfx_1r">
		   <ul>
		     <li><span>适用人群:</span><?php echo $this->_var['goods']['goods_syrq']; ?></li>
			 <li><span>承保年龄:</span><?php echo $this->_var['goods']['goods_cbnl']; ?></li>
			 <li><span>保障期限:</span><label id="bzqx"></label></li>
			 <li><span>保单形式:</span><?php echo $this->_var['goods']['goods_bdxs']; ?></li>
			 <li><span>限购份数:</span><?php echo $this->_var['goods']['goods_xgfs']; ?></li>
			 <li><span>保费:</span><i id="ECS_GOODS_AMOUNT">
             <?php if ($this->_var['goods']['is_promote'] && $this->_var['goods']['gmt_end_time']): ?><?php echo $this->_var['goods']['promote_price']; ?><?php else: ?><?php echo $this->_var['goods']['shop_price']; ?><?php endif; ?></i>
             <em><?php echo $this->_var['goods']['market_price']; ?></em>省：<?php echo $this->_var['goods']['js_price']; ?>
             </li>
		   </ul>
		   <div class="w_alfx_1r_a">
		    <a href="javascript:addToCart(<?php echo $this->_var['goods']['goods_id']; ?>)" title="立即投保" class="w_alfx_1r_a1"></a>
			<a href="javascript:addToCart(<?php echo $this->_var['goods']['goods_id']; ?>)" title="加入购物车" class="w_alfx_1r_a2"></a>
		   </div>
		 </div>
	 </div>
	  <div class="clear"></div>
	 <div class="w_alfx_2">
	  <div class="w_bxzh_tit">
	   <span class="w_bxzh_s" id="xj1" onmouseover="setTab('xj',1,4,'w_bxzh_s')"><i></i>产品介绍</span>
	   <span id="xj2" onmouseover="setTab('xj',2,4,'w_bxzh_s')"><i></i>投保须知</span>
	   <span id="xj3" onmouseover="setTab('xj',3,4,'w_bxzh_s')"><i></i>案例分享</span> 
	   <span id="xj4" onmouseover="setTab('xj',4,4,'w_bxzh_s')"><i></i>客户评价（<em><?php echo $this->_var['comment_num']; ?></em>）</span>                                                                                                    
	 </div>
     
	  <div class="w_anfx_n">
	    <div id="con_xj_1" style="display:block;">
	   <div class="w_anfx_n1">
       <form action="javascript:addToCart(<?php echo $this->_var['goods']['goods_id']; ?>)" method="post" name="ECS_FORMBUY" id="ECS_FORMBUY" >
       <input name="number" type="text" id="number" value="1" style="display:none; "/>
		  
      <?php $_from = $this->_var['specification']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('spec_key', 'spec');if (count($_from)):
    foreach ($_from AS $this->_var['spec_key'] => $this->_var['spec']):
?>
      <div class="w_anfx_n1_l1">
      
      <div class="w_anfx_n1_l11"><?php echo $this->_var['spec']['name']; ?></div>
        
                    <?php if ($this->_var['spec']['attr_type'] == 1): ?>
                      <?php if ($this->_var['cfg']['goodsattr_style'] == 1): ?>
                        <div class="w_anfx_n1_l12" id="fanhui_<?php echo $this->_var['spec_key']; ?>">
                        <?php $_from = $this->_var['spec']['values']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'value');$this->_foreach['specification'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['specification']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['value']):
        $this->_foreach['specification']['iteration']++;
?>
                        <label for="spec_value_<?php echo $this->_var['value']['id']; ?>" id="ccc_<?php echo $this->_var['value']['id']; ?>" onclick="type_css('fanhui_<?php echo $this->_var['spec_key']; ?>','ccc_<?php echo $this->_var['value']['id']; ?>');">
                        <input type="radio" name="spec_<?php echo $this->_var['spec_key']; ?>" value="<?php echo $this->_var['value']['id']; ?>" id="spec_value_<?php echo $this->_var['value']['id']; ?>" <?php if ($this->_var['key'] == 0): ?>checked<?php endif; ?> onclick="changePrice();" style="display:none;" />
                        <span <?php if (($this->_foreach['specification']['iteration'] <= 1)): ?>class="w_al_s1"<?php endif; ?>><i></i><?php echo $this->_var['value']['label']; ?></span></label>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        </div>
                        <input type="hidden" name="spec_list" value="<?php echo $this->_var['key']; ?>" />
                        <?php else: ?>
                        <select name="spec_<?php echo $this->_var['spec_key']; ?>" onchange="changePrice()">
                          <?php $_from = $this->_var['spec']['values']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'value');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['value']):
?>
                          <option label="<?php echo $this->_var['value']['label']; ?>" value="<?php echo $this->_var['value']['id']; ?>"><?php echo $this->_var['value']['label']; ?> <?php if ($this->_var['value']['price'] > 0): ?><?php echo $this->_var['lang']['plus']; ?><?php elseif ($this->_var['value']['price'] < 0): ?><?php echo $this->_var['lang']['minus']; ?><?php endif; ?><?php if ($this->_var['value']['price'] != 0): ?><?php echo $this->_var['value']['format_price']; ?><?php endif; ?></option>
                          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        </select>
                        <input type="hidden" name="spec_list" value="<?php echo $this->_var['key']; ?>" />
                      <?php endif; ?>
                    <?php else: ?>
                      <?php $_from = $this->_var['spec']['values']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'value');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['value']):
?>
                      <label for="spec_value_<?php echo $this->_var['value']['id']; ?>">
                      <input type="checkbox" name="spec_<?php echo $this->_var['spec_key']; ?>" value="<?php echo $this->_var['value']['id']; ?>" id="spec_value_<?php echo $this->_var['value']['id']; ?>" onclick="changePrice()" />
                      <?php echo $this->_var['value']['label']; ?> [<?php if ($this->_var['value']['price'] > 0): ?><?php echo $this->_var['lang']['plus']; ?><?php elseif ($this->_var['value']['price'] < 0): ?><?php echo $this->_var['lang']['minus']; ?><?php endif; ?> <?php echo $this->_var['value']['format_price']; ?>] </label><br />
                      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                      <input type="hidden" name="spec_list" value="<?php echo $this->_var['key']; ?>" />
                    <?php endif; ?>
      </div>
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      
          </form>
		   <div class="w_anfx_n1_l2">
		     <div class="w_an_l1">保障内容</div>
			 <div class="w_an_l2">
                 <?php echo $this->_var['goods']['goods_desc']; ?>
             </div>
		   </div> 
		   <div class="w_anfx_n1_l3">
		   <i id="price_1"><?php if ($this->_var['goods']['is_promote'] && $this->_var['goods']['gmt_end_time']): ?><?php echo $this->_var['goods']['promote_price']; ?><?php else: ?><?php echo $this->_var['goods']['shop_price']; ?><?php endif; ?></i>
           <em><?php echo $this->_var['goods']['market_price']; ?></em>省：<?php echo $this->_var['goods']['js_price']; ?>
		  </div>
		 </div> 
		 <div class="w_alxq_1">
		   <b>产品解读</b>
		   <?php echo $this->_var['goods']['goods_jd']; ?>
		 </div>
		 <div class="w_alxq_2">
		  <b>投保前请仔细阅读</b><a href="" title="保险条款">保险条款</a><a href="" title="不承保地区">不承保地区</a>
		 </div>
	  </div>
	    <div class="w_anfx_n3"   id="con_xj_2" style="display:none;">
		 <p><?php echo $this->_var['goods']['goods_tbxz']; ?></p>
		</div>
	    <div class="w_anfx_n3"   id="con_xj_3" style="display:none;">
		 <p><?php echo $this->_var['goods']['goods_alfx']; ?></p>
		</div>
		<div class="w_anfx_n3" id="con_xj_4" style="display:none;">
		  <?php echo $this->smarty_insert_scripts(array('files'=>'transport.js,utils.js')); ?>
<div id="ECS_COMMENT"> <?php 
$k = array (
  'name' => 'comments',
  'type' => $this->_var['type'],
  'id' => $this->_var['id'],
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?></div>
          
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

</body>
<script type="text/javascript">
var goods_id = <?php echo $this->_var['goods_id']; ?>;
var goodsattr_style = <?php echo empty($this->_var['cfg']['goodsattr_style']) ? '1' : $this->_var['cfg']['goodsattr_style']; ?>;
var gmt_end_time = <?php echo empty($this->_var['promote_end_time']) ? '0' : $this->_var['promote_end_time']; ?>;
<?php $_from = $this->_var['lang']['goods_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
var goodsId = <?php echo $this->_var['goods_id']; ?>;
var now_time = <?php echo $this->_var['now_time']; ?>;


onload = function(){
  changePrice();
  fixpng();
  try {onload_leftTime();}
  catch (e) {}
}

/**
 * 点选可选属性或改变数量时修改商品价格的函数
 */
function changePrice()
{
  var attr = getSelectedAttributes(document.forms['ECS_FORMBUY']);
  var qty = document.forms['ECS_FORMBUY'].elements['number'].value;

  Ajax.call('goods.php', 'act=price&id=' + goodsId + '&attr=' + attr + '&number=' + qty, changePriceResponse, 'GET', 'JSON');
}

/**
 * 接收返回的信息
 */
function changePriceResponse(res)
{
  if (res.err_msg.length > 0)
  {
    alert(res.err_msg);
  }
  else
  {
    document.forms['ECS_FORMBUY'].elements['number'].value = res.qty;
    document.getElementById('bzqx').innerHTML = res.bzqx;
    document.getElementById('price_1').innerHTML = res.result;

    if (document.getElementById('ECS_GOODS_AMOUNT'))
      document.getElementById('ECS_GOODS_AMOUNT').innerHTML = res.result;


  }
}


</script>
</html>
