<?php get_header(); ?>

<div id="wrapper_content">
  <div id="container_content" class="full_width search_result">

    <h2>Search results for “<?php echo get_search_query(); ?>” </h2>
  
<?php 
if(have_posts()) : while ( have_posts() ) : the_post();
$type = get_post_type();
?>


    <div class="result">
<?php if($type == 'people') { ?>
      <a href="/studio/people/#<?php echo get_the_ID(); ?>">
<?php } else { ?>
      <a href="<?php echo the_permalink(); ?>">
<?php } ?>
      <p class="thumbnail"><?php echo get_the_post_thumbnail(); ?></p>
      <h3><?php the_title(); ?></h3>
      <div class="clear"></div>
      </a>
    </div>

<?php
endwhile;
endif;
?>

  </div><!-- #container_content -->
</div><!-- #wrapper_content -->

<?php get_footer(); ?>