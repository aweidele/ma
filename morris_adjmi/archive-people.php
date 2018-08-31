<?php get_header(); ?>

    <div class="news_post">
<?php 
$recent = new WP_Query( 'posts_per_page=1');
if($recent->have_posts()) : while ( $recent->have_posts() ) :
	$recent->the_post();
?>
      <p class="main_image"><img src="<?php the_field('main_image'); ?>" alt="" /></p>
      <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
      <div class="news_post_content">
<?php 
/** SHOW THE ARTICLE DETAIL LINE IF PROVIDED **/
if(get_field('publication') != "" || get_field('publication_date') != "" || get_field('link_to_article') != "") { ?>
        <p>
          <?php if(get_field('publication') != "") { the_field('publication'); ?> | <?php } ?>
          <?php if(get_field('publication_date') != "") { the_field('publication_date'); ?> | <?php } ?>
          <?php if(get_field('link_to_article') != "") { ?><a href="<?php the_field('link_to_article'); ?>">Link to Article</a><?php  } ?>
        </p>
<?php } ?>
      
<?php the_content(); ?>

      </div><!-- .news_post_content -->
      <p class="next_article"><a href="<?php get_next_post(); ?>">Next Article</a></p>
<?php
endwhile;
endif;
?>
    </div><!-- .news_post -->
    <div class="recent_posts">
<?php
wp_reset_postdata();
$args = array(
  'offset'=>0,
  'posts_per_page'=>8
);
$older = new WP_Query( $args );
if($older->have_posts()) : while ( $older->have_posts() ) :
	$older->the_post();
?>
      <div class="post">
        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
        <p class="cat_date"><?php echo get_the_category_list(", "); ?></p>
        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <p class="cat_date"><?php the_date(); ?></p>
        
        <div class="clear"></div>
      </div>
<?php
endwhile;
endif;
?>
    </div><!-- .recent_post -->
    <div class="clear"></div>

<?php get_footer(); ?>