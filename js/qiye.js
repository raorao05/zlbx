$(function(){
	SFbest.Slide.init();
})

var SFbest = {};
(function (d) {
	SFbest.Slide = new function () {
		this.init = function () {
			Q();
		};
		function Q() {
			var f = $("#lunbo_1");
			var li = $("ul>li", "#slide_show");
			if (f.length > 0 && li.length > 1) {
				setTimeout(function () {
					$("#lunboNum").show();
					m("#slide_show");		
				}, 1000)
			}
			e();
			function e() {
				var p = p || {};
				p.u_hover = function (r) {
					var q = $(r);
					q.hover(function () {
						$(this).removeClass("hovers").siblings().addClass("hovers")
					}, function () {
						$(this).siblings().removeClass("hovers")
					})
				};
				p.initFun = function () {
					p.u_hover("#index_slide .mini_pic a")
				};
				p.initFun()
			}
			function m(q) {
				p();
				function p() {
					var t = $("ol", "#slide_show").width(),
					B = $("#slide_show>ul>li"),
					A = $("#index_slide>ol"),
					D = $("#index_slide>ol>li"),
					x = D.length,
					z;
					var r = D.first();
					D.last().clone().prependTo(A);
					A.width(t * (x + 2) + 100).css("left", "-" + t + "px");
					$("#slide_show").hover(function () {
						$(this).children("a").show();
						clearInterval(z)
					}, function () {
						$(this).children("a").hide();
						clearInterval(z);
						z = setInterval(function () {
								s(y())
							}, 5000)
					}).trigger("mouseout");
					B.hover(function () {
						var E = B.index(this);
						$(this).addClass("cur").siblings().removeClass("cur");
						$("ol", "#index_slide").stop(true).animate({
							left : "-" + (E + 1) * t + "px"
						}, 360);
					});
					$(".show_next,.show_pre", "#slide_show").click(function () {
						var E = y();
						if ($("ol", "#index_slide").is(":animated")) {
							return
						}
						if ($(this).hasClass("show_pre")) {
							$("ol", "#index_slide").animate({
								left : "+=" + t + "px"
							}, 360, function () {
								if (E > 0) {
									B.eq(E - 1).addClass("cur").siblings().removeClass("cur");
								} else {
									if (E == 0) {
										$("ol", "#index_slide").css("left", "-" + t * (x) + "px");
										B.eq(-1).addClass("cur").siblings().removeClass("cur");
									}
								}
							})
						} else {
							s(E)
						}
						return false
					});
					function s(E) {
						if (E == x - 1) {
							r.addClass("cur").css("left", t * x)
						}
						$("ol", "#index_slide").stop(true, true).animate({
							left : "-=" + t + "px"
						}, 360, function () {
							if (E < x - 1) {
								B.eq(E + 1).addClass("cur").siblings().removeClass("cur");
							} else {
								if (E == x - 1) {
									r.removeClass("cur").css("left", -t);
									$("ol", "#index_slide").css("left", "-" + t + "px");
									B.eq(0).addClass("cur").siblings().removeClass("cur")
								}
							}
						})
					}
					function y() {
						return $("ul>li", "#slide_show").index($("ul>li.cur", "#slide_show"))
					}

				}
			}
		}
			
	};
})(jQuery);

(function($){
    $.fn.sfHover = function(options){
        var defaults = {
            hoverDuring: 200,
            outDuring: 200,
            hoverEvent: function(){},
            outEvent: function(){}
        };
        var s = $.extend(defaults,options || {});
        var h, o, that = this;
        return $(this).each(function(){
            $(this).hover(function(){
                clearTimeout(o);
                h = setTimeout(function(){s.hoverEvent.apply(that)}, s.hoverDuring);
            },function(){
                clearTimeout(h);
                o = setTimeout(function(){s.outEvent.apply(that)}, s.outDuring);
            });
        });
    };
	
	function sf_a(obj,f,c,u) {
		$(obj).addClass("curr").siblings().removeClass("curr");
		var i=$(f).index($(f+".curr"));
		var w = u.find(".slideArror").width();
		var $left = i * w + "px";
		c.eq(i).show().siblings().hide();
		u.find(".slideArror").animate({"left":$left},300);	
		
	}

	var fq=".comgifts .floorTab li";
	$(fq).each(function(){
		$(this).sfHover({
			hoverDuring: 300,
			hoverEvent: function(){
				var This =$(this),
					c=$(".comgifts .subCont > div"),
					t=$(".comgifts");
					sf_a(This,fq,c,t);
				i = $(this).index();
				if(i>0){
					c.eq(i).find("img.lazy_load").trigger("sporty");
				}
			}
		});	
	});
	var fqc=".comcard .floorTab li";
	$(fqc).each(function(){
		$(this).sfHover({
			hoverDuring: 300,
			hoverEvent: function(){
				var This =$(this),
					c=$(".comcard .subCont > div"),
					t=$(".comcard");
					sf_a(This,fqc,c,t);
				i = $(this).index();
				if(i>0){
					c.eq(i).find("img.lazy_load").trigger("sporty");
				}
			}
		});	
	});
	
	var fqh=".comhome .floorTab li";
	$(fqh).each(function(){
		$(this).sfHover({
			hoverDuring: 300,
			hoverEvent: function(){
				var This =$(this),
					c=$(".comhome .subCont > div"),
					t=$(".comhome");
					sf_a(This,fqh,c,t);
				i = $(this).index();
				if(i>0){
					c.eq(i).find("img.lazy_load").trigger("sporty");
				}
			}
		});	
	});
	
	var fqt=".comticket .floorTab li";
	$(fqt).each(function(){
		$(this).sfHover({
			hoverDuring: 300,
			hoverEvent: function(){
				var This =$(this),
					c=$(".comticket .subCont > div"),
					t=$(".comticket");
					sf_a(This,fqt,c,t);
				i = $(this).index();
				if(i>0){
					c.eq(i).find("img.lazy_load").trigger("sporty");
				}
			}
		});	
	});
	
})(jQuery);