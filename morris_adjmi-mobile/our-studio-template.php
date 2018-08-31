<?php
/*
Template Name: Our Studio

*/
?>
<?php get_header(); ?>
<?php if(have_posts()) : ?><?php while(have_posts()) : the_post(); ?>
<div class="full_image">
<?php
	$gallery = get_field("gallery");
  
	if( $gallery )
	{
		if( count($gallery) > 1 )
		{	
	  ?>
	  	<script type="text/javascript">m_hp_slideshow_go(<?php echo get_option('ma_homepage_slideshow_pause').','.get_option('ma_homepage_slideshow_fade'); ?>);</script>
		<div id="wrapper_slideshow">
	  		<div id="container_slideshow">
			  <?php 
			  foreach($gallery as $image) { ?>
			    <img src="<?php echo $image["sizes"]["Homepage Gallery Mobile"]; ?>" alt="" />
			<?php } ?>
			</div>
			<div id="slideshow_load">Loading.</div>
		</div>
	<?php
		}
		else
		{
	?>
			<img src="<?php echo $gallery[0]["sizes"]["Homepage Gallery Mobile"]; ?>" />
	<?php
		}	
	}
	else
	{
		the_post_thumbnail(get_the_ID(),'Homepage Gallery Mobile');
	}
?>
</div>
<div id="wrapper_content">
  <div id="container_content">
  <?php the_content(); ?>
  </div><!-- container_content -->
</div><!-- wrapper_content -->
<?php
endwhile;
endif;
wp_reset_query();

$peopleList = array();
$args = array('post_type' => 'people');
$people_query = new WP_Query($args);

if($people_query -> have_posts()) :  while( $people_query -> have_posts() ) : $people_query -> the_post();
  $cat = get_the_terms( $post->id, 'people_category' );
  foreach($cat as $c) {
    $peopleList[$c->slug]['people'][] = $post;
    $peopleList[$c->slug]['name'] = $c->name;
    //echo "<pre>";print_r($c); echo "</pre>";
  }
endwhile;
endif;
?>
<div id="people_list">
<?php foreach($peopleList as $peopleSlug => $cat) { ?>
  <div class="peopleCat" id="peopleCat-<?php echo $peopleSlug; ?>">
<?php if($peopleSlug == 'studio') { ?>
    <p class="cat"><?php echo $cat['name']; ?></p>
    <ul>
<?php } ?>
<?php foreach($cat['people'] as $person) { ?>

<?php if($peopleSlug == 'studio') { ?>
    <li><a href="#<?php echo $person->post_name; ?>" class="personToggle"><span><?php echo $person->post_title; ?></span></a>
<?php } ?>
    <div class="person" id="<?php echo $person->post_name; ?>">
<?php if($peopleSlug != 'studio') { ?>
      <p class="cat"><?php echo rtrim($cat['name'],'s'); ?></p>
<?php } ?>
      <h2><?php echo $person->post_title; ?></h2>
      <?php echo get_the_post_thumbnail($person->ID,'Staff Photo'); ?>
      <?php echo wpautop($person->post_content); ?>
      <p><?php echo get_field('cv',$person->ID); ?></p>
<?php 
    $f = get_field('related_projects',$person->ID);
    if(is_array($f) && sizeof($f) > 0) {  
?>
      <h3>Related Projects</h3>
      <ul>
<?php foreach($f as $project) { ?>
        <li><a href="<?php echo $project->guid; ?>"><?php echo $project->post_title; ?></a></li>
<?php } ?>
      </ul>
<?php } ?>
      <p class="back-to-top"><a href="#wrapper_header">Back to Top</a></p>
      </div><!-- .persion #<?php echo $person->post_name; ?> -->
<?php if($peopleSlug == 'studio') { ?>
    </li>
<?php } ?>

<?php } //foreach($cat['people'] as $person) ?>
<?php if($peopleSlug == 'studio') { ?>
    </ul>
<?php } ?>
  </div><!-- peopleCat -->
<?php } //foreach($peopleList as $peopleSlug => $cat) ?>
</div><!-- people_list -->

<?php get_footer(); ?>