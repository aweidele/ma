$(document).ready(function() {

  $(".back-to-top").click(function(e) {
    e.preventDefault();
    $("html,body").animate({ "scrollTop":0 },2000);
  });
  
  $(".project_share ul").hide();
  $(".project_share h3").click(function() {
    $(this).siblings().slideDown(500);
  });
  
  $peopleCurrent = "";
  $("a.personToggle").click(function(e) {
    e.preventDefault();
    t = $(this);
    h = t.attr("href");
    
    //$("a.personToggle span").show();
    
    //$("#peopleCat-studio .person").slideUp(250);
    $("span",t).hide();
    $(h).slideDown(250);
    $(this).parents('li').addClass('vis');
  });
  $("#peopleCat-studio .person h2").click(function() {
    parent = $(this).parents('.person');
    sibling = parent.siblings('a');
    parent.slideUp(250);
    $('span',sibling).show();
    $(this).parents('li').removeClass('vis');
  });

});


function m_hp_slideshow_go(pause,fade) {
  $pause = pause;
  $fade = fade;
  
  $(document).ready(function() {
    $("#container_slideshow,#container_slideshow img").hide();
    $("#container_slideshow img:eq(0)").show();
    
    $("#container_slideshow,#container_slideshow img").css({ "z-index":0 });
    $("#container_slideshow,#container_slideshow img:eq(0)").css({ "z-index":100 });
  });

  $(window).load(function() {
    
    $("#slideshow_load").fadeOut($fade,function() {
      $("#container_slideshow").fadeIn($fade);
      window_resize();

      // Start slideshow
      $current_slide = 0;
      $length = $("#container_slideshow img").length-1;
      next_slide();
      
    });
    $(window).resize(function() { window_resize(); });
    
  });

} // m_hp_slideshow_go()

function window_resize() {
  $("#container_slideshow").height( $("#container_slideshow img").height() );
}

function next_slide() {
  $current_slide++;
  if($current_slide > $length) { $current_slide = 0; }
  $t = window.setTimeout(fade_slide,$pause);

}

function fade_slide() {
  $last_slide = $current_slide - 1;
  if ($last_slide < 0) { $last_slide = $length; }
  $("#container_slideshow img").css({ "z-index":0 });
  $("#container_slideshow img:eq("+$current_slide+")").css({ "z-index":100 });
  $("#container_slideshow img:eq("+$current_slide+")").fadeIn($fade,function() {
    $("#container_slideshow img:eq("+$last_slide+")").hide();
    next_slide();
  });
}