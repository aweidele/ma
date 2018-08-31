<?php
/*
Template Name: Homepage Template

*/
?>
<?php get_header(); ?>

<?php
  if(have_posts()) : ?><?php while(have_posts()) : the_post();
  $gallery = get_field( "homepage_gallery" );
?>
<script type="text/javascript">m_hp_slideshow_go(<?php echo get_option('ma_homepage_slideshow_pause').','.get_option('ma_homepage_slideshow_fade'); ?>);</script>
<div id="wrapper_slideshow">
  <div id="container_slideshow">
  
<?php 
  foreach($gallery as $image) { ?>
    <img src="<?php echo $image["gallery_image"]["sizes"]["Homepage Gallery Mobile"]; ?>" alt="" />
<?php } ?>

  </div><!-- #container_slideshow -->
  <div id="slideshow_load">Loading.</div>
</div><!-- #wrapper_slideshow -->

<div id="wrapper_content">
  <div id="container_content" class="homepage">
<?php the_content(); ?>  
  </div><!-- #container_content -->
</div><!-- #wrapper_content -->
<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>