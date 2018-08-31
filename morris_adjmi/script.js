var $ = jQuery;

    $last_slide = -1;
/**** HOMEPAGE SLIDESHOW ****/
function cached(url){
    var test = document.createElement("img");
    test.src = url;
    return test.complete || test.width+test.height > 0;
}

function hp_slideshow_go(s_pause, s_speed) {

	loadingFadeOut = function(){
		$("#slideshow_load").fadeOut(1000,function() { hp_next_slide();  });
	};

  $s_pause = s_pause;
  $s_speed = s_speed;

  $(document).ready(function() {
    $current_slide = 0;
    $("#container_slideshow img").hide();
    $("#container_slideshow").css("overflow", "visible");

    fade_arrows_go();

	var $img0 = $("#container_slideshow img:eq(0)");
	
	if( cached($img0.attr('src')) )
	{
		loadingFadeOut();
	}
	else
	{
	    $img0.load(loadingFadeOut);
	}
  });

  $(window).load(function() {

    /* Center the images */
    center_image();
    $(window).resize(function() { center_image(); });

    /* Add click functionality to Next/Prev buttons */
    $("#slideshow_controls li").click(function() {

      if(!$fading) {

        clearTimeout($hp_timeout);

        if($(this).text()=="Previous") {
          hp_prev_slide();
        } else
        if ($(this).text()=="Next") {
          hp_next_slide();
        }

      }

    });

    //$("#slideshow_load").fadeOut(1000,function() { hp_next_slide();  });

  });
}

function other_slideshow_go(s_pause,s_speed) {

  $s_pause = s_pause;
  $s_speed = s_speed;

  $(document).ready(function() {
    $current_slide = 0;
    $("#container_slideshow img").hide();
    $("#container_slideshow").css("overflow", "visible");
	var $img0 = $("#container_slideshow img:eq(0)");
	
	if( cached($img0.attr('src')) )
	{
		hp_next_slide();
	}
	else
	{
	    $img0.load(hp_next_slide);
	}

  });
}

function center_image() {

  $w = $(window).width();
  $("#container_slideshow img").each(function() {
    $p = Math.round(($w - $(this).width()) / 2);
    $(this).css({ "left":$p });
  });

}


function hp_next_slide() {
  hp_fade_slide();
}


function hp_prev_slide() {

  $l = $current_slide;
  $current_slide -= 2;
  if($current_slide < 0) { $current_slide = $current_slide + $("#container_slideshow img").length; }
  hp_fade_slide();

}

function hp_fade_slide() {

      $msg = $current_slide+"<br />";
      $i=0;
      $("#container_slideshow img").each(function() {
        $msg += $i+":"+$(this).css("z-index") + "<br />";
        $i++;
      });
      $("#feedback").html($msg);

  $fading=1;

  $("#container_slideshow img").css({"z-index":0});
  $("#container_slideshow img:eq("+$current_slide+")").css({"z-index":100}).fadeIn($s_speed,function() {
    $("#container_slideshow img:eq("+$last_slide+")").fadeOut();
    $last_slide = $current_slide;
    $current_slide++;
    if($current_slide > ($("#container_slideshow img").length - 1)) { $current_slide = 0; }
    $hp_timeout = window.setTimeout(hp_next_slide,$s_pause);

    $fading=0;

  });

}

/**** HOMEPAGE NEWS ****/
function hp_news_go(n_pause,n_speed) {

  $n_pause = n_pause;
  $n_speed = n_speed;

  $(document).ready(function() {
    $(".news_slide").hide();
    $current_news = 0;
    $(".news_slide:eq(0)").fadeIn($n_speed,function() { window.setTimeout(news_next,$n_pause); });
  });

}

function news_next() {
  $(".news_slide:eq("+$current_news+")").fadeOut($n_speed,function() {
    $current_news++;
    if($current_news > $(".news_slide").length -1) { $current_news = 0; }
    $(".news_slide:eq("+$current_news+")").fadeIn($n_speed,function() { window.setTimeout(news_next,$n_pause); });
  });
}

/**** PEOPLE TOP CONTENT STICK ****/
function list_stick() {

  $(document).ready(function() {

    $hash = window.location.hash;
    if($hash != "") {
      //$(window).scrollTo(0);
      $o = Math.round($($hash).offset().top - $("#wrapper_header").height());
      $('html,body').animate({ "scrollTop" : $o },500);
    }

    /* duplicate people list in subnav */
    $message = '<div class="people_dropdown full_width">';
    $message += $("#people_list").html();
    $message += '</div>';
    $("#subnav-people").append($message);

    /* hide or show dropdown menu and back to top */

    $cHeight = $("#wrapper_content").height() + $("#wrapper_content").offset().top;


    $(window).scroll(function() {
      $s = $(window).scrollTop();
      $c = Math.round($("#container_content").offset().top - $("#wrapper_header").height() - 1);

      if($s>$c) {
        $(".people_dropdown").addClass("vis");
        $(".back_to_top").removeClass("hidden");
      } else {
        $(".people_dropdown").removeClass("vis");
        $(".back_to_top").addClass("hidden");
      }

      if($s> $cHeight - $(window).height()) {
        $(".back_to_top").removeClass("fixed");
      }  else {
        $(".back_to_top").addClass("fixed");
      }

    });

    /* People List Click Function */
    $("#people_list a,.people_dropdown a").click(function(e) {
      e.preventDefault();

      /* throttle speed depending on how far down the list the person is */
      $col = $(this).parent().parent().index();
      if($col == 0) {
        $p_index = $(this).parent().index() + 1;
      } else {
        $p_index = $("#people_list ul:eq(0) li").length + $(this).parent().index() + 1;
      }
      $p_index = Math.ceil($p_index / 2);

      $h = $(this).attr("href");
      $o = Math.round($($h).offset().top - $("#wrapper_header").height());
      $('html,body').animate({ "scrollTop" : $o },250*$p_index);
    });

  });

}


/**** PROJECT SLIDER ****/
var $sliding = 0;
function project_slider_go(move,delay) {

  $(document).ready(function() {

    fade_arrows_go();

    $move = move;
    $delay = delay;

    // get total widths of projects
    $widths = new Array();
    $positions = new Array();
    $positions.push(-1);
    $total_width = 0;
    $tallest = 0;
    $(".project_slide").each(function() {

      $(this).width($(this).width());
      $(this).css({ "left":$total_width });
      $positions.push($total_width);

      $this_width = $(this).width() + parseInt($(this).css("margin-left")) + parseInt($(this).css("margin-right"));
      $widths.push( $this_width );
      $total_width += $this_width;

      if( $("img",this).height() > $tallest ) { $tallest = $("img",this).height(); }


    });

    $(".project_slide .project_image").height($tallest);
    $(".project_slide .project_image img").addClass("abs");
    $positions.push( $widths[$widths.length-1] + $positions[$positions.length-1] );
    $positions.push(Infinity);
    $l = $positions.length;

    // clone slides
    $s1 = $(".project_slide:eq(0)").width() + parseInt($(".project_slide:eq(0)").css("margin-left")) + parseInt($(".project_slide:eq(0)").css("margin-right"));

    $slides = '<div class="project_slides_container">'+$(".project_slides_container").html()+'</div>';
    $(".project_slider").append($slides).prepend($slides);
    $(".project_slides_container").width( $total_width );

    $current_slide = 0;
    place_slides();
    $(window).resize(function() {
      place_slides();
    });

    $(".project_slide .project_image").fadeTo(0,0);
    
    var $img = $(".project_slide .project_image img");
    
    $img.each(function(){
	    if( cached($(this).attr('src')) )
	    {
	    	$(this).parent().fadeTo(500,1);
	    }
	    else
	    {
		    $(this).load(function() {
		      $(this).parent().fadeTo(500,1);
		    });
		}
    });

    $newpos = 0;

    $(".sliderprev").mouseenter(function() { $sliding=1; slider_slide($sliding); });
    $(".slidernext").mouseenter(function() { $sliding=-1; slider_slide($sliding); });
    $(".sliderprev,.slidernext").mouseleave(function() { $sliding=0; });
/*
    $(".sliderprev").click(function() { project_slide(-1); });
    $(".slidernext").click(function() { project_slide(1); });
    $(window).keyup(function(e) {
      if(e.keyCode==39) { project_slide(1); }
      if(e.keyCode==37) { project_slide(-1); }
    });

    $(".sliderprev").mouseenter(function() { $sliding = -1; project_slide($sliding);  $("#feedback").html($sliding); });
    $(".sliderprev").mouseleave(function() { $sliding = 0;  $("#feedback").html($sliding);  });

    $(".slidernext").mouseenter(function() { $sliding = 1; project_slide($sliding);  $("#feedback").html($sliding);  });
    $(".slidernext").mouseleave(function() { $sliding = 0;  $("#feedback").html($sliding);  });
*/

      //Enable swiping...
      $(".project_slider_container").swipe( {
        //Generic swipe handler for all directions
        swipeLeft:function(event, direction, distance, duration, fingerCount) {
          sliderSwipe(-1);
        },
        swipeRight:function(event, direction, distance, duration, fingerCount) {
          sliderSwipe(1);
        },
        tap:function(event,target){
			var $target = $(target);

			if($target.is("a"))
			{
				$target.click();
			}
			else
			{
				$target.closest("a")[0].click();
			}
		},
        /*
        swipeStatus:function(event, phase, direction, distance, duration, fingerCount) {
			console.log("Phase: " + phase);
			console.log("Direction: " + direction);
			console.log("Distance: " + distance);
		},
		*/
        //Default is 75px, set to 0 for demo so any distance triggers swipe
        threshold:75,
        excludedElements:"button, input, select, textarea, .noSwipe"
      });



  });

}

function slider_slide($d) {

  if ($d != 0) {

    $newpos += $d*$move;
    if ($newpos < $positions[$positions.length-2] * -1) { $newpos = 0; }
    if($newpos > 0) { $newpos = $positions[$positions.length-2] * -1; }

    $(".project_slider").css({"left":$newpos});

    $msg = "";
    for($i=0;$i<$positions.length;$i++) {

      if( Math.abs($newpos) >= $positions[$i] && Math.abs($newpos) < $positions[$i+1]) {
        $current_slide=$i;
      } else {
      }
    }
    $("#feedback").html($newpos+"/"+$positions[$positions.length-2]);

    setTimeout(function(){ slider_slide($sliding); },$delay);

  }
}

function sliderSwipe(d) {

  $oldpos = $newpos;
  $newpos += $(window).width() * 0.75 * d;
  
  if ($newpos < $positions[$positions.length-2] * -1) { 
    $newpos = (($newpos * -1) - $positions[$positions.length-2]) * -1;
    $(".project_slider").animate({"left":($positions[$positions.length-2]*-1)},250,"linear").animate({"left":0},0).animate({"left":$newpos},250,"linear");
  } else if($newpos >= 0) {
    $newpos = $newpos - $positions[$positions.length-2];
    $(".project_slider").animate({"left":0},250,"linear").animate({"left":($positions[$positions.length-2]*-1)},0).animate({"left":$newpos},250,"linear");
  } else {
    $(".project_slider").animate({"left":$newpos},500,"linear");
  }
  
      $("#feedback").html($newpos + "<br />" + $positions[$positions.length-2]);

}

function place_slides() {

    //$init = Math.round( ($(window).width() / 2) - ($s1 / 2) );
    $init = $("#container_content").offset().left;
    $(".project_slides_container:eq(1)").css({ "left" : $init });
    $(".project_slides_container:eq(2)").css({ "left" : $init+$total_width });
    $(".project_slides_container:eq(0)").css({ "left" : $init-$total_width });

}

/*
function project_slide(d) {
  $current_slide+=d;
  //if($current_slide > $l-1) { $current_slide = 0; }
  if($current_slide < 0 )   {
    $current_slide = $l-1;
    $(".project_slider").css({ "left":$positions[$current_slide]*-1 });
    $current_slide--;
  }

  $slideto = $positions[$current_slide] * -1;
  $(".project_slider").animate({
    "left":$slideto
  },750,"linear",function() {
    if($current_slide >= $l-1) {
      $(".project_slider").css({ "left":0 });
      $current_slide = 0;
    }

    if($sliding != 0) { project_slide($sliding); }

  });

}

function project_slider_width() {

}
*/

/*** SET ACTIVE MENU ITEM ***/
function setMenuActive($m) {
  $(document).ready(function() {
    $a = "#menu-item-"+$m;
    $($a).addClass('current-menu-item');
  });
}

$(document).ready(function() {
  $(".back_to_top").click(function(e) {
    e.preventDefault();
    $('html,body').animate({ "scrollTop" : 0});
  });
});


/*** SHOW ARROWS FOR 3 SECONDS THEN FADE ***/
function fade_arrows_go() {

  $t = 0;
  $group = ".sliderprev, .slidernext, #slideshow_controls ul, .single-project_prev, .single-project_next";
  fade_arrows_in();
  $(window).mousemove(function() { fade_arrows_in(); });
}

function fade_arrows_in() {
  clearTimeout($t);
  $($group).addClass("fadein");
  $t = setTimeout(function() { fade_arrows_out(); }, 3000);
}

function fade_arrows_out() {
  $($group).removeClass("fadein");
}

/*** BLURB CAROUSEL ***/
function blurb_carousel_go(blurbpause,blurbspeed) {

  $(document).ready(function() {

    $blurbpause = blurbpause;
    $blurbspeed = blurbspeed;

    $current = 0;
    $l = $(".blurbs_carousel p").length-1;
    blurb_carousel();
  });

}

function blurb_carousel() {
    $t = setTimeout(function() {
      $(".blurbs_carousel p:eq("+$current+")").fadeOut($blurbspeed,function() {
        $current++;
        if($current > $l) { $current = 0; }
        $(".blurbs_carousel p:eq("+$current+")").fadeIn($blurbspeed,function() { blurb_carousel() });
      });
    },$blurbpause);
}

/*** "BACK TO TOP" STICK ***/
function back_to_top_stick() {

  $(function() {

    fade_btt();
    $(window).mousemove(function(e) {
      fade_btt_in();
    });
    $(window).scroll(function() {
      fade_btt_in();
    });

    $cHeight = $("#wrapper_content").height() + $("#wrapper_content").offset().top;

    $(window).scroll(function() {

      if ( $(window).scrollTop() > 10 ) {
        $(".back_to_top").removeClass("hidden");
      } else {
        $(".back_to_top").addClass("hidden");
      }



      if($(window).scrollTop() > $cHeight - $(window).height()) {
        $(".back_to_top").removeClass("fixed");
      }  else {
        $(".back_to_top").addClass("fixed");
      }

    });

  });

  $(window).load(function() {
    $cHeight = $("#wrapper_content").height() + $("#wrapper_content").offset().top;

  });

}

function fade_btt() {
  $b = setTimeout(function() {
    $(".back_to_top").fadeOut(500);
  },3000);
}

function fade_btt_in() {
  clearTimeout($b);
  $b = 0;
  $(".back_to_top").fadeIn(500,function() { fade_btt(); });
}


/*** NEWS SIDEBAR STICK ***/
function sidebarStick() {

  $(document).ready(function() {

    $(".recent_posts a").click(function(e) {
      e.preventDefault();
      $h = $(this).attr("href") + " .news_post_container";

      $(".news_post_container").fadeOut(500,function() {
        $(".news_post").load($h,function() {
		    var $img = $(".news_post_container img");
		    
		    if( cached($img.attr('src')) )
		    {
		    	$(this).fadeIn(500);
            sidebarStickAction();
		    }
		    else
		    {
			    $img.load(function() {
			      $(this).fadeIn(500);
            	  sidebarStickAction();
			    });
			}
        });
      });
    });

  });

  $(window).load(function() {
    sidebarStickAction();
  });

  $(window).resize(function() {
    sidebarStickAction();
  });

}

function sidebarStickAction() {
  $(".news_post_container").addClass("stick").height( $(window).height() - $("#wrapper_footer").height() - 200 );
}