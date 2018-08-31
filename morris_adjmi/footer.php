
<!-- FOOTER -->
<div id="wrapper_footer"<?php if(is_page_template("homepage-template.php") || is_page_template("contact_template.php") || is_page_template("project-template.php") || is_tax("project_category") || is_404() || is_search()) { echo ' class="home"'; } ?>>
  <div id="container_footer" class="full_width">
    <div id="footer_left">
      <div class="textwidget">
        ©<?php echo date("Y"); ?> <?php bloginfo('name'); ?>
        <?php if (get_option('ma_address')) : ?>
        | <?php echo get_option('ma_address'); ?>
        | <?php echo get_option('ma_city'); ?>, <?php echo get_option('ma_state'); ?> <?php echo get_option('ma_zip'); ?>
        | <?php echo get_option('ma_phone'); ?> |
        <a href="mailto:<?php echo get_option('ma_email'); ?>"><?php echo get_option('ma_email'); ?></a>
        <?php endif; ?>
      </div>
<!--
<?php if ( !function_exists('dynamic_sidebar')
|| !dynamic_sidebar('Footer Left') ) : ?>
<?php endif; ?>
-->
    </div><!-- #footer_left -->
    
    <div id="footer_right">
<?php  if ( !function_exists('dynamic_sidebar')
|| !dynamic_sidebar('Footer Right') ) : ?>
<?php endif;  ?>
    </div><!-- #footer_right -->
    <div class="clear"></div>
  </div><!-- #container_footer -->
</div><!-- #wrapper_footer -->
<?php wp_footer(); ?>
<?php 
$t = explode ("/",get_page_template());
$template = end($t);
switch($template) {
case "project-template.php": ?>
  <script type="text/javascript">
    project_slider_go(<?php echo get_option('ma_slider_move').','.get_option('ma_slider_delay'); ?>);
    fade_arrows_go();
  </script>
<?php

break;
case "people-template.php": ?>

  <script type="text/javascript">
    setMenuActive(79);
    list_stick();
  <?php if(sizeof($content) > 1) { ?>  blurb_carousel_go(<?php echo $blurbpause.",".$blurbspeed; ?>); <?php } ?>
    back_to_top_stick();
</script>

<?php

break;
case "homepage-template.php": ?>

<script type="text/javascript">
  hp_slideshow_go(<?php echo get_option('ma_homepage_slideshow_pause').','.get_option('ma_homepage_slideshow_fade'); ?>);
  hp_news_go(<?php echo get_option('ma_homepage_news_pause').','.get_option('ma_homepage_news_fade'); ?>);
<?php if($tablet) { ?>

  $(function() {    
      //Enable swiping...
      $("body").swipe( {
        //Generic swipe handler for all directions
        swipeLeft:function(event, direction, distance, duration, fingerCount) {
          alert("left");
        },
        swipeRight:function(event, direction, distance, duration, fingerCount) {
          alert("right");
        },
        //Default is 75px, set to 0 for demo so any distance triggers swipe
        threshold:100
      });
    });
    
<?php } ?>
</script>

<?php
break;
}

$posttype = get_post_type();
if($posttype == "project") { ?>
  <script type="text/javascript">
    project_slider_go(<?php echo get_option('ma_slider_move').','.get_option('ma_slider_delay'); ?>);
    fade_arrows_go();
    setMenuActive(77);
  </script>
<?php } ?>
<div id="feedback"><?php echo $posttype; ?></div>
</body>
</html>