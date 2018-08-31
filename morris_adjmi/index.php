<?php get_header(); ?>
<!-- CONTENT -->
<script type="text/javascript">sidebarStick();</script>
<div id="wrapper_content">
  <div id="container_content" class="full_width">

    <div class="news_post six_col">
    <div class="news_post_container six_col">
<?php echo get_query_var( 'cat' ); ?>
<?php 

$args = array( "posts_per_page" => 1 );
if(is_year()) { 
  $y = get_the_time('Y');
  $args["year"] = $y;
}
if(is_category()) {
  echo "?";
  $args["cat"] = get_query_var( 'cat' );
}
$recent = new WP_Query( $args);
if($recent->have_posts()) : while ( $recent->have_posts() ) : $recent->the_post(); ?>

      <p class="main_image"><img src="<?php the_field('main_image'); ?>" alt="" /></p>
 <?php if(get_field('link_to_article') != "") { ?>
      <h3><a href="<?php the_field('link_to_article'); ?>" target="_blank"><?php the_title(); ?></a></h3>
<?php } else { ?>
      <h3><?php the_title(); ?></h3>
<?php } ?>
      <div class="news_post_content">
<?php 
/** SHOW THE ARTICLE DETAIL LINE IF PROVIDED **/
if(get_field('publication') != "" || get_field('publication_date') != "" || get_field('link_to_article') != "") { ?>
        <p>
          <?php if(get_field('publication') != "") { the_field('publication'); ?> | <?php } ?>
          <?php if(get_field('publication_date') != "") { the_field('publication_date');  } ?>
          <?php if(get_field('link_to_article') != "") { ?> | <a href="<?php the_field('link_to_article'); ?>" target="_blank">Link to Article</a><?php  } ?>
        </p>
<?php } ?>
      
<?php the_content(); ?>

      </div><!-- .news_post_content -->

      <p class="next_article"><?php
        $next = get_previous_post();
        $link = get_permalink( $next->ID );
      ?><a href="<?php echo $link; ?>">Next News Item</a></p>

<?php endwhile; ?>
<?php endif; ?>
    
    </div>
    </div><!-- .news_post -->
    <div class="five_col" style="float: right;">
    <div class="recent_posts five_col">
<?php
wp_reset_postdata();
//$p = new WP_Query("posts_per_page=6");
if(have_posts()) : while ( have_posts() ) :
	the_post();
	$categories = get_the_category();
	$msg = "";
	foreach($categories as $cat) {
	  $msg .= "<span>".$cat->name."</span> ";
	}
?>
      <div class="post">
        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
        <p class="cat_date"><?php echo $msg; ?></p>
        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <p class="cat_date"><?php the_date(); ?></p>
        
        <div class="clear"></div>
      </div>
<?php endwhile; ?>
 <?php /*
 global $wp_query;

$big = 999999999; // need an unlikely integer

echo paginate_links( array(
	'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	'format' => '?paged=%#%',
	'current' => max( 1, get_query_var('paged') ),
	'total' => $wp_query->max_num_pages,
	'type'         => 'list'
) ); */
 ?> 
 
<?php endif; ?>
    </div>
    </div><!-- .recent_post -->
    <div class="clear"></div>
  
  </div><!-- #container_content -->
</div><!-- #wrapper_content -->

<?php get_footer(); ?>