<?php
/*
Template Name: Projects


*/
?>
<?php $tablet = preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', strtolower($_SERVER['HTTP_USER_AGENT'])); ?>
<?php get_header(); ?>

<div id="feedback">.</div>
<?php //if($tablet) { ?>

<?php //} else { ?>
<script type="text/javascript">fade_arrows_go();</script>
<?php //} ?>



<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
<div id="wrapper_content">
  <div id="container_content" class="project_index_intro full_width">
<?php if(!$tablet) {  ?>
    <div class="six_col"><?php the_content(); ?></div>
<?php } else { ?>
    <div style="padding-top 20px;">&nbsp;</div>
<?php } ?>
  </div><!-- #container_content -->
</div><!-- #wrapper_content -->
<?php
  endwhile;
  endif;
  wp_reset_postdata();
?>
<?php
$args = array('posts_per_page'=>999,'post_type' => 'project');
$project_query = new WP_Query($args);
if($project_query->have_posts()) :
?>

<div class="project_slider_container">

<?php if (!$tablet) { ?>
  <div class="sliderprev"><span>Previous</span></div>
  <div class="slidernext"><span>Next</span></div>
<?php } ?>

  <div class="project_slider"><div class="project_slides_container">
<?php while ( $project_query->have_posts() ) : $project_query->the_post(); 

$category =  wp_get_post_terms( get_the_ID() , "project_category");
$tid = $category[0]->taxonomy."_".$category[0]->term_taxonomy_id;
$value = get_field( "display_on_project_carousel", $tid );

$carousel = get_field('project_carousel');
$show = $carousel[0];
?>

<?php if ($value[0] && !get_field('hidden') && $show) { ?>
<!-- PROJECT SLIDE -->
    <div class="project_slide"><a href="<?php the_permalink(); ?>">
<?php if(get_field('gallery_image') != "") { $image = get_field('gallery_image'); ?>
      <div class="project_image"><img src="<?php echo $image["sizes"]["Project Slider"]; ?>" width="<?php echo $image["sizes"]["Project Slider-width"]; ?>" height="<?php echo $image["sizes"]["Project Slider-height"]; ?>" /></div>
<?php } ?>
      <div class="project_title"><h3><?php the_title(); ?></h3></div>
    </a></div>
<!-- /PROJECT SLIDE -->
<?php } ?>

<?php endwhile; ?>
  </div></div><!-- .project_slider -->
</div><!-- .project_slider_container -->
<?php
endif;
wp_reset_postdata();
?>
<?php get_footer(); ?>