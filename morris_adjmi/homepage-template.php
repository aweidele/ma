<?php
/*
Template Name: Homepage Template

*/
?>
<?php $tablet = preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', strtolower($_SERVER['HTTP_USER_AGENT'])); ?>
<?php get_header(); ?>

<!-- SLIDESHOW -->

<div id="wrapper_slideshow">
  <div id="container_slideshow">
  
<?php 
  if(have_posts()) : ?><?php while(have_posts()) : the_post();

  $gallery = get_field( "homepage_gallery" );
  foreach($gallery as $image) { 	
    $id = $image['link_to_project']->ID; ?>
    <a href="<?php echo get_permalink( $id ); ?>" title="<?php echo get_the_title($id); ?>" ><img src="<?php echo $image["gallery_image"]["sizes"]["Homepage Gallery"]; ?>" alt="<?php echo get_the_title($id); ?>" /></a>
<?php  } ?>
<?php endwhile; ?>
<?php endif; ?>

<?php if (!$tablet) { ?>
    <div id="slideshow_controls" class="full_width">
      <ul>
        <li class="previous"><span>Previous</span></li>
        <li class="next"><span>Next</span></li>
      </ul>
    </div><!-- #slideshow_controls -->
<?php } ?>
    <div id="slideshow_load">Loading.</div>
  </div><!-- #container_slideshow -->
</div><!-- #wrapper_slideshow -->

<?php 
/*** GET POSTS TO BE FEATURED ON HOMEPAGE ***/
$args = array(
    'showposts' => -1,
	'meta_query' => array(
        array(
            'key' => 'feature_on_homepage', // name of custom field
            'value' => '"Yes"', // matches exaclty "red", not just red. This prevents a match for "acquired"
            'compare' => 'LIKE' )
        )
    );
$my_query = new WP_Query($args);
if ($my_query->have_posts()) : 

?>
<!-- NEWS -->
<div id="wrapper_hpnews">
  <div id="container_hpnews" class="full_width">
    <div id="news_slider">
      <h2>News</h2>
      <div id="news_slider_container">

<?php while ($my_query->have_posts()) : $my_query->the_post(); ?>
        <div class="news_slide">
<p><?php if(get_field( "homepage_blurb" ) != "") { ?>
<?php the_field('homepage_blurb'); ?>
<?php } else { echo get_the_excerpt(); } ?>
 <a href="<?php the_permalink(); ?>">Read more…</a></p>
        </div>
<?php endwhile; ?>

      </div><!-- #news_slider_container -->
    
    </div><!-- #news_slider -->
  </div><!-- #container_hpnews -->
</div><!-- #wrapper_hpnews -->
<?php 
endif;
wp_reset_query(); 
?>
<!-- end NEWS -->
<?php get_footer(); ?>