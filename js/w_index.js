// JavaScript Document
$(document).ready(function(e) {
             $(".w_top1_r li").hover(
				  function () {
					$(this).children(".w_top1_r li div").show();
				  },
				  function () {
					$(this).children(".w_top1_r li div").hide();
				  }
				); 

           })
$(document).ready(function(e) {
             $(".w_sy_bfd_1x").hover(
				  function () {
					$(this).children(".w_sy_bfd_1x ul").show();
				  },
				  function () {
					$(this).children(".w_sy_bfd_1x ul").hide();
				  }
				); 

           })
		   
		   $(document).ready(function(e) {
             $(".w_top3_2 dl").hover(
				  function () {
					$(this).children(".w_sxg").show();
				  },
				  function () {
					$(this).children(".w_sxg").hide();
				  }
				); 

           })
		   
		   $(document).ready(function(e) {
             $(".w_sy_f2 li").hover(
				  function () {
					$(this).children(".w_sy_f2_d").show();
				  },
				  function () {
					$(this).children(".w_sy_f2_d").hide();
				  }
				); 

           })
		    $(document).ready(function(e) {
             $(".w_sycb li").hover(
				  function () {
					$(this).children(".w_sycb_d1").show();
				  },
				  function () {
					$(this).children(".w_sycb_d1").hide();
				  }
				); 

           })
		   
		   $(function () {
   
        $('.w_sycb_3').click(function () {
            $('html,body').animate({ scrollTop: '0px' }, 800);
        });
    });