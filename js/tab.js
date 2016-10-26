// tasktab
function setTab(name,cursel,n,css){
 for(i=1;i<=n;i++){
  var menu=document.getElementById(name+i);
  var con=document.getElementById("con_"+name+"_"+i);
  menu.className=i==cursel?css:"";
  con.style.display=i==cursel?"block":"none";
 }
}
$(document).ready(function () { 

	$(".hea_tit_d li").hover(function(){
		//$(this).children('a').show();
		$(this).children('.zq_hea_nav2').show();
		$(this).children('a').attr("class","hover");

},function(){
		$(this).children('.zq_hea_nav2').hide();
        $(this).children('a').attr("class","");

	});

	})