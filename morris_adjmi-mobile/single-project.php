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
      $("#portfolio_container").swipe( {
        //Generic swipe handler for all directions
        swipeRight:function(event, direction, distance, duration, fingerCount) {
          $target = $("#prevpost").val();
          window.location.href = $target;
        },
        swipeLeft:function(event, direction, distance, duration, fingerCount) {
          $target = $("#nextpost").val();
          window.location.href = $target;
        },
        //Default is 75px, set to 0 for demo so any distance triggers swipe
        threshold:100
      });
    });
    
</script>
<?php
$prev_post = get_previous_post();
$next_post = get_next_post();

?>
<div id="portfolio_container">
<?php if(have_posts()) : while ( have_posts() ) : the_post();


	
	// NEXT PROJECT
    $id = get_the_ID();
    $i = 0;
    foreach($projects as $p) {
      if($id == $p["id"]) { break; }
      $i++;
    }
    $next_project = $i+1;
    if($next_project >= sizeof($projects)) { $next_project = 0; }
    
    $prev_project = $i-1;
    if($prev_project < 0 ) { $prev_project = sizeof($projects) - 1; }


$gallery = get_field( "gallery" );
?>
<input id="prevpost" type="hidden" value="<?php echo $projects[$prev_project]["link"]; ?>" />
<input id="nextpost" type="hidden" value="<?php echo $projects[$next_project]["link"]; ?>" />
<div class="project_portfolio">
  <h1><?php the_title(); ?></h1>
  <p class="intro"><?php echo get_field('intro'); ?></p>
</div><!-- .project_portfolio -->

<ul class="mobile_gallery"> 
<?php foreach($gallery as $image) { ?> 
  <li><img src="<?php echo $image['sizes']['Mobile Portfolio View']; ?>" alt="<?php echo $image['alt']; ?>" /></li>
<?php } ?>
</ul><!-- .mobile_gallery -->

<div class="project_portfolio">
  <p class="info"><?php echo get_field('info'); ?></p>
  <?php the_field('description'); ?>
  <?php the_tags('<p class="project_tags">Tags: ', ' | ', '</p>'); ?>
  <?php
  $accolades = get_field("accolades");
  if($accolades) {
  ?>
  <h3 class="accolades_header">Accolades</h3>
  
  <?php } ?>
  <!--
  <div class="project_share">
    <h3>Share Project</h3>
    <ul>
      <li class="facebook"><a href="http://www.facebook.com/sharer.php?u=<?php echo $p["link"]; ?>" target="_blank">Facebook</a></li>
      <li class="twitter"><a href="http://twitter.com/share?url=<?php echo $p["link"]; ?>&text=<?php the_title(); ?>" target="_blank">Tweet</a></li>
      <li class="pinterest"><a href="//pinterest.com/pin/create/button/?url=<?php echo $p["link"]; ?>&media=<?php echo $post->guid; ?>&description=<?php 
  echo get_bloginfo('name'); 
  if(get_bloginfo('description') != "") { echo "–".get_bloginfo('description'); }
?> | <?php the_title(); ?>. <?php echo get_option( 'meta_description', '' ); ?>" data-pin-do="buttonPin" data-pin-config="none" target="_blank">Pin</a></li>
      <li class="google"><a href="https://plus.google.com/share?url=<?php echo $p["link"]; ?>" target="_blank">Google+</a></li>
    </ul>
    <div class="clear"></div>
  </div>
  -->
  
</div><!-- .project_portfolio -->
<?php
endwhile;
endif;
?>
</div><!-- portfolio_container -->

<?php get_footer(); ?>