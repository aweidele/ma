<?php $tablet = preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', strtolower($_SERVER['HTTP_USER_AGENT'])); ?>
<?php get_header(); ?>
<!-- ?????
<?php $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ));

$tid = $term->taxonomy."_".$term->term_taxonomy_id;
$value = get_field( "display_on_project_carousel", $tid ); 

 ?>
 -->
<div id="wrapper_content">
  <div id="container_content" class="project_index_intro full_width">
<?php if(!$tablet) {  ?>
    <p class="intro seven_col"><?php echo $term->description; ?></p>
<?php } else { ?>
    <div style="padding-top 20px;">&nbsp;</div>
<?php } ?>
  </div><!-- #container_content -->
</div><!-- #wrapper_content -->
<?php
  //endwhile;
  //endif;
  //wp_reset_postdata();
?>
<?php
//$args = array('post_type' => 'project');
$project_query = new WP_Query('posts_per_page=999');
if(have_posts()) : ?>
<div class="project_slider_container">

<?php if (!$tablet) { ?>
  <div class="sliderprev"><span>Previous</span></div>
  <div class="slidernext"><span>Next</span></div>
<?php } ?>

  <div class="project_slider"><div class="project_slides_container">
<?php while ( have_posts() ) : the_post(); 

  $carousel = get_field('project_carousel');
  $show = is_array($carousel) && $carousel[0] == "yes";
?>

<?php if($show) { ?>
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