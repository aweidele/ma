<?php get_header(); ?>

<div id="wrapper_content" class="news">
<?php if(have_posts()) : while ( have_posts() ) : the_post();
$image = get_field('main_image');
 ?>
  <div class="news_main_image"><a href="<?php the_permalink(); ?>"><img src="<?php echo get_field('main_image'); ?>" alt="" /></a></div>
  <div class="news_content">
    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    <p class="news_date"><?php echo get_the_date("F Y"); ?> | <a href="<?php echo get_field('link_to_article'); ?>" target="_blank">Link to Article</a></p>
    <?php the_content(); ?>
<!--
    <div class="project_share">
      <h3>Share</h3>
      <ul>
        <li class="facebook"><a href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>" target="_blank">Facebook</a></li>
        <li class="twitter"><a href="http://twitter.com/share?url=<?php the_permalink(); ?>&text=<?php the_title(); ?>" target="_blank">Tweet</a></li>
        <li class="pinterest"><a href="//pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php echo $post->guid; ?>&description=<?php
  echo get_bloginfo('name');
  if(get_bloginfo('description') != "") { echo "–".get_bloginfo('description'); }
?> | <?php the_title(); ?>. <?php echo get_option( 'meta_description', '' ); ?>" data-pin-do="buttonPin" data-pin-config="none" target="_blank">Pin</a></li>
        <li class="google"><a href="https://plus.google.com/share?url=<?php the_permalink(); ?>" target="_blank">Google+</a></li>
      </ul>
    </div>.project_share -->
      <div class="clear"></div>

  </div><!-- .news_content -->

<?php
endwhile;
endif;
?>
</div><!-- #wrapper_content -->

<?php get_footer(); ?>