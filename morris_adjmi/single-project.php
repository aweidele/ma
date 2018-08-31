<?php 
if( !is_user_logged_in() )
{
	$id = get_query_var("id");
	
	if( get_field('hidden',$id) )
	{
		header('Location: /');
		return;
	}
}

$tablet = preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', strtolower($_SERVER['HTTP_USER_AGENT'])); ?>
<?php get_header(); ?>

<?php
/**** GET THE PROJECT LIST ****/
$projects = array();
$args = array('post_type' => 'project','posts_per_page' => 9999);
$project_query = new WP_Query($args);
if($project_query -> have_posts()) :
while( $project_query -> have_posts() ) : $project_query -> the_post();

$id = get_the_ID();
$link = get_permalink($id);
$name = get_the_title();
$hidden = get_field( "hidden" );

if(!$hidden[0]) {
  array_push($projects, array( "id" => $id, "link" => $link, "title" => $name ));
}

endwhile;
endif;
?>

<script type="text/javascript">

  $(function() {
      //Enable swiping...
      $("#container_content").swipe( {
        //Generic swipe handler for all directions
        swipeLeft:function(event, direction, distance, duration, fingerCount) {
          $target = $(".single-project_next a").attr("href");
          window.location.href = $target;
        },
        swipeRight:function(event, direction, distance, duration, fingerCount) {
          $target = $(".single-project_prev a").attr("href");
          window.location.href = $target;
        },
        //Default is 75px, set to 0 for demo so any distance triggers swipe
        threshold:100
      });
    });

</script>
<script type="text/javascript">setMenuActive(77); fade_arrows_go(); back_to_top_stick();</script>
<!-- CONTENT -->
<?php
wp_reset_query();
if(have_posts()) : while ( have_posts() ) :
	the_post();

	$id = get_the_ID();
	$gallery = get_field( "gallery" );
	$n = 0;

	$related = get_field( "related_projects" );
	$related = array_slice($related, 0, 4);

	// NEXT PROJECT
    $i = 0;
    foreach($projects as $p) {
      if($id == $p["id"]) { break; }
      $i++;
    }
    $next_project = $i+1;
    if($next_project >= sizeof($projects)) { $next_project = 0; }

    $prev_project = $i-1;
    if($prev_project < 0 ) { $prev_project = sizeof($projects) - 1; }
?>

<div id="wrapper_project_blurb" class="<?= $tablet ? 'tablet' : ''?>">
  <div id="container_project_blurb" class="full_width">
    <h2><?php the_title(); ?></h2>
    <p class="intro"><?php if(get_field('intro') != "") { the_field('intro');  } ?></p>
    <div class="clear"></div>
  </div><!-- #container_project_blurb -->
</div><!-- #wrapper_project_blurb -->
<div id="wrapper_content" class="single-project-wrapper <?= $tablet ? 'tablet' : ''?>">
  <div id="container_content" class="single-project extended">


    <div class="single-project_prev"<?php if($tablet) { echo ' style="display: none !important;"'; } ?>><a href="<?php echo $projects[$prev_project]["link"]; ?>">Previous<br />Project</a></div>


    <div class="single-project_content full_width">
<!--<h2><?php the_title(); ?></h2>
<p class="intro"><?php if(get_field('intro') != "") { the_field('intro');  } ?></p> -->
<div class="project_gallery">

<?php
foreach($gallery as $image) { ?>
  <div class="project_gallery_image<?php if($image["sizes"]["Project Photo-width"] < 920) { echo " narrow"; $n++; } ?>"><img src="<?php echo $image["sizes"]["Project Photo"]; ?>" /></div>
<?php if ($n%2 == 0) { ?>  <div class="clear"></div><?php } ?>
<?php } ?>

  <div class="clear"></div>
</div><!-- .project_gallery -->

<div class="project_content eight_col">
  <?php the_field('description'); ?>
<?php if( !strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') && get_field('photo_credit') != "" ) { ?>  <p>Image Credit: ©<?php the_field('photo_credit'); ?></p> <?php  } ?>
  <?php the_tags('<p class="project_tags">Tags: ', ' | ', '</p>'); ?>
</div>
<div class="project_info three_col">
<?php if(get_field('info') != "") { the_field('info'); } ?>

<?php if( !strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') ) { ?>
  <div class="project_share">
    <h3>Share Project</h3>
    <ul>
      <li class="facebook"><a href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>" target="_blank">Facebook</a></li>
      <li class="twitter"><a href="http://twitter.com/share?url=<?php the_permalink(); ?>&text=<?php the_title(); ?>" target="_blank">Tweet</a></li>
      <li class="pinterest"><a href="//pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php echo $post->guid; ?>&description=<?php
  echo get_bloginfo('name');
  if(get_bloginfo('description') != "") { echo "–".get_bloginfo('description'); }
?> | <?php the_title(); ?>. <?php echo get_option( 'meta_description', '' ); ?>" data-pin-do="buttonPin" data-pin-config="none" target="_blank">Pin</a></li>
      <li class="google"><a href="https://plus.google.com/share?url=<?php the_permalink(); ?>" target="_blank">Google+</a></li>
    </ul>
  </div><!-- project_share -->
<?php } ?>

</div>

<div class="clear"></div>
<div class="related_projects">
<?php foreach($related as $r) { ?>
  <div class="project three_col">
    <a href="<?php echo $r->guid; ?>"><?php echo get_the_post_thumbnail($r->ID, 'Project Related'); ?>
    <?php echo $r->post_title; ?></a>
  </div>
<?php } ?>
  <div class="clear"></div>
</div>
    </div><!-- .single-project_content -->

    <div class="single-project_next"<?php if($tablet) { echo ' style="display: none !important;"'; } ?>><a href="<?php echo $projects[$next_project]["link"]; ?>">Next<br />Project</a></div><?php wp_reset_postdata(); ?>


    <div class="clear"></div>

<div class="back_to_top fixed hidden"><span class="full_width"><a href="#wrapper_header">Back to top</a></span></div>

    </div><!-- #container_content -->
</div><!-- #wrapper_content -->
<?php
endwhile;
endif;
?>


<?php get_footer(); ?>
<!-- get_the_post_thumbnail($post->ID, 'thumbnail');  -->