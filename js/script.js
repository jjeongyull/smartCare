AOS.init();

var swiper = new Swiper(".mySwiper", {
  pagination: {
    el: ".swiper-pagination",
    // type: "progressbar",
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  loop: true,
  autoplay:{
    delay: 6000, // 시간 설정
  },
  speed : 800,
});

$(document).ready(function() {
  $(".set > a").on("click", function() {
    if ($(this).hasClass("active")) {
      $(this).removeClass("active");
      $(this)
        .siblings(".content")
        .slideUp(200);
      $(".set > a i")
        .removeClass("fa-minus")
        .addClass("fa-plus");
    } else {
      $(".set > a i")
        .removeClass("fa-minus")
        .addClass("fa-plus");
      $(this)
        .find("i")
        .removeClass("fa-plus")
        .addClass("fa-minus");
      $(".set > a").removeClass("active");
      $(this).addClass("active");
      $(".content").slideUp(200);
      $(this)
        .siblings(".content")
        .slideDown(200);
    }
  });
});

$(window).scroll(function() {
	var scroll = $(window).scrollTop();
	//console.log(scroll);
	if (scroll >= 500) {
		//console.log('a');
		$(".section01>.inner>.imgList>.list>.textBox").addClass("active");
	} else {
		//console.log('a');
		$(".section01>.inner>.imgList>.list>.textBox").removeClass("active");
	}
});

