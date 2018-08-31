<?php get_header(); ?>

<!-- CONTENT -->

<div id="wrapper_content">
  <div id="container_content" class="full_width">

<?php if(have_posts()) : ?><?php while(have_posts()) : the_post(); ?>
<div class="page_content six_col">
<?php the_content(); ?>
</div><!-- .page_content -->
<div class="page_sidebar five_col">
<?php the_post_thumbnail('Page Featured Image'); ?>
</div>
<div class="clear"></div>
<?php
endwhile;
endif;
?>

  </div><!-- #container_content -->
</div><!-- #wrapper_content -->

<?php get_footer(); ?>