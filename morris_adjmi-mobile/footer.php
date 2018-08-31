
<div id="wrapper_footer">
  <div id="container_footer">
  <h1><?php bloginfo('name'); ?></h1>
 
<?php if (get_option('ma_address')) : ?>
  <p class="contact_left">
    <?php echo get_option('ma_address'); ?><br />
    <?php echo get_option('ma_city'); ?>, <?php echo get_option('ma_state'); ?> <?php echo get_option('ma_zip'); ?>
  </p>
  <p class="contact_right">
    <?php echo get_option('ma_phone'); ?><br />
    <a href="mailto:<?php echo get_option('ma_email'); ?>"><?php echo get_option('ma_email'); ?></a>
  </p>
  <div class="clear"></div>
<?php endif; ?>

  <div class="contact_left">
<?php  if ( !function_exists('dynamic_sidebar')
|| !dynamic_sidebar('Mobile Footer') ) : ?>
<?php endif;  ?>
  </div>
  <div class="contact_right">
    <p class="back-to-top"><a href="#wrapper_header">Back to Top</a></p>
  </div>
  <div class="clear"></div>
    
  </div><!-- #container_footer -->
</div><!-- #wrapper_footer -->
<?php wp_footer(); ?>
</body>
</html>