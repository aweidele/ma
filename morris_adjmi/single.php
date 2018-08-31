<?php get_header(); ?>

<script type="text/javascript">sidebarStick();</script>
<!-- CONTENT -->

<div id="wrapper_content">
  <div id="container_content" class="full_width">

    <div class="news_post six_col">
    <div class="news_post_container six_col">
<?php 
if(have_posts()) : while ( have_posts() ) :
	the_post();
?>
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
<?php
endwhile;
endif;
?>
    </div>
    </div><!-- .news_post -->
    <div class="five_col" style="float: right;">
    <div class="recent_posts five_col">
<?php
wp_reset_postdata();
if(isset($_GET["o"])) { $o = $_GET["o"]; } else { $o = 0; }
$p = new WP_Query(array( "posts_per_page"=>9999,"offset"=>0 ));
if($p -> have_posts()) : while ( $p -> have_posts() ) :
	$p -> the_post();
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
 
<?php endif; ?>
    </div>
    </div><!-- .recent_post -->
    <div class="clear"></div>

  </div><!-- #container_content -->
</div><!-- #wrapper_content -->

<?php get_footer(); ?>