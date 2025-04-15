$(window).on("load", function() {
  //  ============= SIGNIN TAB FUNCTIONALITY =========
    $('.signup-tab ul li').on("click", function(){
        var tab_id = $(this).attr('data-tab');
        $('.signup-tab ul li').removeClass('current');
        $('.dff-tab').removeClass('current');
        $(this).addClass('current animated fadeIn');
        $("#"+tab_id).addClass('current animated fadeIn');
        return false;
    });
    //  ============= SIGNIN CONTROL FUNCTION =========

    $('.sign-control li').on("click", function(){
        var tab_id = $(this).attr('data-tab');
        $('.sign-control li').removeClass('current');
        $('.sign_in_sec').removeClass('current');
        $(this).addClass('current animated fadeIn');
        $("#"+tab_id).addClass('current animated fadeIn');
        return false;
    });

    //  ============ Notifications Open =============

    $(".not-box-open").on("click", function(){$("#message").hide();
        $(".user-account-settingss").hide();
        $(this).next("#notification").toggle();
    });

     //  ============ Messages Open =============

    $(".not-box-openm").on("click", function(){$("#notification").hide();
        $(".user-account-settingss").hide();
        $(this).next("#message").toggle();
    });

    // ============= User Account Setting Open ===========
    /*
      $(".user-info").on("click", function(){$("#users").hide();
          $(".user-account-settingss").hide();
          $(this).next("#notification").toggle();
      });
    */
    $( ".user-info" ).click(function() {
       $( ".user-account-settingss" ).slideToggle( "fast");
       $("#message").not($(this).next("#message")).slideUp();
       $("#notification").not($(this).next("#notification")).slideUp();
    // Animation complete.
    });

    //  ============= eye_showHide =========

    $("#eye_showHide").click(function() {
      var pwdType = $(this).parent(".password-holder").find("input").attr("type");
      var newType = (pwdType === "password")?"text":"password";
      $(this).parent(".password-holder").find("input").attr("type", newType);
      if(pwdType === "password"){
        $("#eye-sh").addClass('fa-eye-slash');
        $("#eye-sh").removeClass('fa-eye');
      }else if(pwdType === "text"){
        $("#eye-sh").removeClass('fa-eye-slash');
        $("#eye-sh").addClass('fa-eye');
      }
    });

    $("#eye-open-hide-1").click(function() {
      var pwdType = $(this).parent(".password-holder").find("input").attr("type");
      var newType = (pwdType === "password")?"text":"password";
      $(this).parent(".password-holder").find("input").attr("type", newType);
      if(pwdType === "password"){
        $("#eye-sh-1").addClass('fa-eye-slash');
        $("#eye-sh-1").removeClass('fa-eye');
      }else if(pwdType === "text"){
        $("#eye-sh-1").removeClass('fa-eye-slash');
        $("#eye-sh-1").addClass('fa-eye');
      }
    });

    $("#eye-open-hide-2").click(function() {
      var pwdType = $(this).parent(".password-holder").find("input").attr("type");
      var newType = (pwdType === "password")?"text":"password";
      $(this).parent(".password-holder").find("input").attr("type", newType);
      if(pwdType === "password"){
        $("#eye-sh-2").addClass('fa-eye-slash');
        $("#eye-sh-2").removeClass('fa-eye');
      }else if(pwdType === "text"){
        $("#eye-sh-2").removeClass('fa-eye-slash');
        $("#eye-sh-2").addClass('fa-eye');
      }
    });

    $("#eye-open-hide-3").click(function() {
      var pwdType = $(this).parent(".password-holder").find("input").attr("type");
      var newType = (pwdType === "password")?"text":"password";
      $(this).parent(".password-holder").find("input").attr("type", newType);
      if(pwdType === "password"){
        $("#eye-sh-3").addClass('fa-eye-slash');
        $("#eye-sh-3").removeClass('fa-eye');
      }else if(pwdType === "text"){
        $("#eye-sh-3").removeClass('fa-eye-slash');
        $("#eye-sh-3").addClass('fa-eye');
      }
    });

    $("#eye-open-hide-4").click(function() {
      var pwdType = $(this).parent(".password-holder").find("input").attr("type");
      var newType = (pwdType === "password")?"text":"password";
      $(this).parent(".password-holder").find("input").attr("type", newType);
      if(pwdType === "password"){
        $("#eye-sh-4").addClass('fa-eye-slash');
        $("#eye-sh-4").removeClass('fa-eye');
      }else if(pwdType === "text"){
        $("#eye-sh-4").removeClass('fa-eye-slash');
        $("#eye-sh-4").addClass('fa-eye');
      }
    });

    $("#eye-open-hide-5").click(function() {
      var pwdType = $(this).parent(".password-holder").find("input").attr("type");
      var newType = (pwdType === "password")?"text":"password";
      $(this).parent(".password-holder").find("input").attr("type", newType);
      if(pwdType === "password"){
        $("#eye-sh-5").addClass('fa-eye-slash');
        $("#eye-sh-5").removeClass('fa-eye');
      }else if(pwdType === "text"){
        $("#eye-sh-5").removeClass('fa-eye-slash');
        $("#eye-sh-5").addClass('fa-eye');
      }
    });
    $("#eye-open-hide-6").click(function() {
      var pwdType = $(this).parent(".password-holder").find("input").attr("type");
      var newType = (pwdType === "password")?"text":"password";
      $(this).parent(".password-holder").find("input").attr("type", newType);
      if(pwdType === "password"){
        $("#eye-sh-6").addClass('fa-eye-slash');
        $("#eye-sh-6").removeClass('fa-eye');
      }else if(pwdType === "text"){
        $("#eye-sh-6").removeClass('fa-eye-slash');
        $("#eye-sh-6").addClass('fa-eye');
      }
    });

});

//  ============= fixed nav =============
$(window).scroll(function() {
    var y = $(window).scrollTop();
    if (y > 50) {
      $("#header").addClass('not-top').scrollTop();
    } else {
      $("#header").removeClass('not-top');
    }
});
// MOBILE HEADER MENU.
jQuery(".sidebar-nav .nav-item.dropdown > a").each(function(){
    jQuery(this).after("<span class='submenu-opener'><i class='fa fa-angle-down'></i></span>");
});
jQuery(document).on("click", ".sidebar-nav .nav-item.dropdown > .submenu-opener", function(){
    jQuery(this).siblings(".sidebar-nav .nav-item .dropdown-menu").slideToggle(500);
    jQuery(this).toggleClass("opened");
});
// check box click div show hide function
function check_workingFunction() {
    var checkBox = document.getElementById("myCheck");
    var text = document.getElementById("checkWorkingHere");
    if (checkBox.checked == true){ 
      text.style.display = "none";
    } 
    else {
       text.style.display = "block"; 
    }
}

// radio box click div show hide function
function check_positionFunction() {
  var checkBox = document.getElementById("positionCheck");
  var text = document.getElementById("checkPosition");
  var text2 = document.getElementById("checkCompany");
  if (checkBox.checked == true){ 
    text.style.display = "block"; 
    text2.style.display = "none"; 
  } 
  else {
     text.style.display = "none";
     text2.style.display = "block"; 
  }
}
// radio box click div show hide function
function check_companyFunction() {
  var checkBox = document.getElementById("companyCheck");
  var text = document.getElementById("checkCompany");
  var text2 = document.getElementById("checkPosition");
  if (checkBox.checked == true){ 
    text.style.display = "block"; 
    text2.style.display = "none"; 
  } 
  else {
     text.style.display = "none";
     text2.style.display = "block"; 
  }
}

// check box click div show hide function
// $(function () {
//   $(".currently-working-check").click(function () {
//       if ($(this).is(":checked")) {
//           $(".checkWorking-showhide").hide();
//       } else {
//         $(".checkWorking-showhide").show();
//       }
//   });
// });
// datetimepicker
$(function () {
   $('#datetimepicker1').datetimepicker({format : "YYYY-MM-DD"});
   $('#datetimepicker2').datetimepicker({format : "YYYY-MM-DD"});
   $('#datetimepicker3').datetimepicker({format : "YYYY-MM-DD"});
   $('#datetimepicker4').datetimepicker({format : "YYYY-MM-DD"});
   $('#datetimepicker5').datetimepicker({format : "YYYY-MM-DD"});

});

/*aos*/
AOS.init({
   easing: 'ease-in-out-sine'
});
/*aos*/

// sidenav
$(document).ready(function () {
    $('#cookies-close').on('click', function () {
        $('.accept-cookies-holder').addClass('remove');
    });
    $("#sidebar").mCustomScrollbar({
        theme: "minimal"
    });
    $('#dismiss, .overlay').on('click', function () {
        $('#sidebar').removeClass('active');
        $('.overlay').removeClass('active');
    });
    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').addClass('active');
        $('.overlay').addClass('active');
        $('.collapse.in').toggleClass('in');
        $('a[aria-expanded=true]').attr('aria-expanded', 'false');
    });
    $('.profileimg').on('click', function () {
        $('#sidebar').addClass('active');
        $('.overlay').addClass('active');
        $('.collapse.in').toggleClass('in');
        $('a[aria-expanded=true]').attr('aria-expanded', 'false');
    });    
    $('.search').on('click', function () {
        $('.overlay').addClass('active');
        $('.search-overlay').addClass('active');
        $('.blur-div').addClass('active');
        $('body').addClass('hidden');
    });
    $('.overlay').on('click', function () {
        $('.overlay').removeClass('active');
        $('.search-overlay').removeClass('active');
        $('.blur-div').removeClass('active');
        $('body').removeClass('hidden');
    });  
  
 if (window.matchMedia("(max-width:991px)").matches) {
    $('.benefits-toggle').on('click', function () {
          $('.benefits-list').slideToggle();
      });  
  };


  /*Apply job page*/

    // $('#nextbtn').on('click', function () {
    //     $('#apply-job-company').css("display", "none");
    //     $('#next-specific-qus').css("display", "block");
    // });   
    $('#nextbtn2').on('click', function () {
       $( "#next-specific-qus" ).removeClass( "d-block" );
        $('#next-specific-qus').css("display", "none");
        $('#next-interview-qus').css("display", "block");
    }); 
    $('#prevbtn').on('click', function () {
        $('#apply-job-company').css("display", "block");
        $('#next-specific-qus').css("display", "none");
    });   
    $('#prevbtn2').on('click', function () {
        $('#next-specific-qus').css("display", "block");
        $('#next-interview-qus').css("display", "none");
    }); 

    // $('#nextbtn').on('click', function () {
    //     $('.login-form').css("display", "none");
    //     $(this).parents('.login-form').css("display", "none");
    // }); 
    
  /*Apply job page*/

});


$('#link').click(function(e){
  var $target = $('html,body');
  $target.animate({scrollTop: $target.height()}, 900);
});

jQuery('.ic-scroll-down').click(function(e){
    var jump = $(this).attr('href');
    var new_position = $(jump).offset();
    $('html, body').stop().animate({ scrollTop: new_position.top }, 500);
    e.preventDefault();
});


/*one-page*/
(function($) {
  "use strict"; // Start of use strict
  // Smooth scrolling using jQuery easing
  $('a.js-scroll-trigger[href*="#"]:not([href="#"])').click(function() {
    if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
      if (target.length) {
        $('html, body').animate({
          scrollTop: (target.offset().top - 100)
        }, 1000, "easeInOutExpo");
        return false;
      }
    }
  });

  // Closes responsive menu when a scroll trigger link is clicked
  $('.js-scroll-trigger').click(function() {
    $('.navbar-collapse').collapse('hide');
  });
  // Activate scrollspy to add active class to navbar items on scroll
  // $('body').scrollspy({
  //   target: '#mainNav',
  //   offset: 145
  // });

})(jQuery); // End of use strict

/*one-page End*/


// =================== Dropzone =================== 

// Dropzone.options.myAwesomeDropzone = {
//     maxFiles: 1,
//     maxFilesize: 4, // MB
//     addRemoveLinks: true,
//     autoQueue:false,
//     clickable: true,
//     dictDefaultMessage: " <h2>Click or drag and drop the image file to upload</h2> <h5>You can upload JPEG pr PNG images upto 2 MB</h5>",
//     accept: function(file, done) {
//       console.log("uploaded");
//       done();
//     },

//     init: function() {
//    this.on('addedfile', function(file) {
//     if (this.files.length > 1) {
//      this.removeFile(this.files[0]);
//     }
//    });
//  }
// }
// =================== Dropzone =================== 
 //$(".multiple-select select.multi-select").bsMultiSelect();

// messages-line
(function($){
    $(window).on("load",function(){
        $(".chat-hist, .messages-line , .messages-list").mCustomScrollbar();
         axis:"yx"
    });
});

// swiper
var swiper1 = new Swiper('.connection-details .swiper-container', {
    slidesPerView: 3,
    spaceBetween: 0,
    autoplay: true,
    autoplay: {
       delay: 5000,
     },
    navigation: {
       nextEl: '.section-catch .swiper-button-next',
       prevEl: '.section-catch .swiper-button-prev',
     },  
});


// swiper
var swiper2 = new Swiper('.searchprofile-slider .swiper-container', {
  slidesPerView: 4,
  spaceBetween: 30,
  autoplay: true,
  autoplay: {
     delay: 5000,
   },
  breakpoints: {          
     1340: {slidesPerView: 4,},
     1199: {slidesPerView: 3,spaceBetween: 30,}, 
     991: {slidesPerView: 2,spaceBetween: 30,}, 
     767: {slidesPerView: 2,spaceBetween: 20,},  
     575: {slidesPerView: 1,spaceBetween: 15,}, 

  }  
});

var swiper3 = new Swiper('.searchconnected-slider .swiper-container', {
  slidesPerView: 4,
  spaceBetween: 30,
  // pagination: {
  //   el: '.searchconnected-slider .swiper-pagination',
  //   clickable: true,
  // },
  autoplay: true,
  autoplay: {
     delay: 4000,
   },
  // navigation: {
  //    nextEl: '.searchconnected-slider .swiper-button-next',
  //    prevEl: '.searchconnected-slider .swiper-button-prev',
  //  },
  breakpoints: {          
     1340: {slidesPerView: 4,},
     1199: {slidesPerView: 3,spaceBetween: 30,}, 
     991: {slidesPerView: 2,spaceBetween: 30,}, 
     767: {slidesPerView: 2,spaceBetween: 20,},  
     575: {slidesPerView: 1,spaceBetween: 15,}, 

  }  
});

// swiper

if($("#timerValue").length){
/**
 * jQuery Stopwatch
 * by @websightdesigns
 *
 * Based on "Javascript Stopwatch" by Daniel Hug
 * From http://jsfiddle.net/Daniel_Hug/pvk6p/
 * Modified to:
 * - add responsive css styles
 * - add save functionality with cookies
 */

// Initialize our variables
var timerDiv = document.getElementById('timerValue'),
  start = document.getElementById('start'),
  stop = document.getElementById('stop'),
  reset = document.getElementById('reset'),
  t;

// Get time from cookie
var cookieTime = getCookie('time');

// If timer value is saved in the cookie

    if( cookieTime != null && cookieTime != '00:00:00' ) {
    var savedCookie = cookieTime;
    var initialSegments = savedCookie.split('|');
    var savedTimer = initialSegments[0];
    var timerSegments = savedTimer.split(':');
    var seconds = parseInt(timerSegments[2]),
      minutes = parseInt(timerSegments[1]),
      hours = parseInt(timerSegments[0]);
    timer();
    document.getElementById('timerValue').textContent = savedTimer;
    $('#stop').removeAttr('disabled');
    $('#reset').removeAttr('disabled');
  } else {
    var seconds = 0, minutes = 0, hours = 0;
    timerDiv.textContent = "00:00:00";
  }



// New Date object for the expire time
var curdate = new Date();
var exp = new Date();

// Set the expire time
exp.setTime(exp + 2592000000);

function add() {

  seconds++;
  if (seconds >= 60) {
    seconds = 0;
    minutes++;
    if (minutes >= 60) {
      minutes = 0;
      hours++;
    }
  }

  timerDiv.textContent = (hours ? (hours > 9 ? hours : "0" + hours) : "00")
    + ":" + (minutes ? (minutes > 9 ? minutes : "0" + minutes) : "00")
    + ":" + (seconds > 9 ? seconds : "0" + seconds);

  // Set a 'time' cookie with the current timer time and expire time object.
  var timerTime = timerDiv.textContent.replace("%3A", ":");
  // console.log('timerTime', timerTime);
  setCookie('time', timerTime + '|' + curdate, exp);

  timer();
}

function timer() {
  t = setTimeout(add, 1000);
}

// timer(); // autostart timer

/* Start button */
start.onclick = timer;

/* Stop button */
stop.onclick = function() {
  clearTimeout(t);
}

/* Clear button */
reset.onclick = function() {
  timerDiv.textContent = "00:00:00";
  seconds = 0; minutes = 0; hours = 0;
  setCookie('time', "00:00:00", exp);
}

/**
 * Javascript Stopwatch: Button Functionality
 * by @websightdesigns
 */

$('#start').on('click', function() {
  $('#stop').removeAttr('disabled');
  $('#reset').removeAttr('disabled');
});

$('#stop').on('click', function() {
  $(this).prop('disabled', 'disabled');
});

$('#reset').on('click', function() {
  $(this).prop('disabled', 'disabled');
});

/**
 * Javascript Stopwatch: Cookie Functionality
 * by @websightdesigns
 */

function setCookie(name, value, expires) {
  document.cookie = name + "=" + value + "; path=/" + ((expires == null) ? "" : "; expires=" + expires.toGMTString());
}

function getCookie(name) {
  var cname = name + "=";
  var dc = document.cookie;

  if (dc.length > 0) {
    begin = dc.indexOf(cname);
    if (begin != -1) {
    begin += cname.length;
    end = dc.indexOf(";", begin);
      if (end == -1) end = dc.length;
      return unescape(dc.substring(begin, end));
    }
  }
  return null;
}

/** * TODO: Continue timing the timer while away... */
}


$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();

  var $liCollection = $(".step_process > ul > li");
    var $firstListItem = $liCollection.first();
    $liCollection.first().addClass("activess");
    setInterval(function() {
        var $activeListItem = $(".activess")
        $activeListItem.removeClass("activess");
        var $nextListItem = $activeListItem.closest('li').next();
        if ($nextListItem.length == 0) {
            $nextListItem = $firstListItem;
        }
        $nextListItem.addClass("activess");
    }, 2500);


});
