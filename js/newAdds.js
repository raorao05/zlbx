$(function() {
	// 秒杀爆款的选项卡状态
	$('.secKillTab li').click(function() {
		var num = $(this).index();
		$(this).addClass('on').siblings().removeClass('on');
		$('.secKillList').hide();
		$('.secKillList'+num).show();
	});
});