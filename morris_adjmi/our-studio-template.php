<?php
/*
Template Name: Our Studio

*/
?>
<?php get_header(); ?>

<!-- CONTENT -->

<div id="wrapper_content">
  <div id="container_content" class="full_width">

<?php if(have_posts()) : ?><?php while(have_posts()) : the_post(); ?>
<div class="page_content six_one_half_col">
<?php the_content(); ?>
</div><!-- .page_content -->
<div class="page_sidebar five_col">
<?php
$gallery = get_field("gallery");

if( $gallery )
{
	if( count($gallery) > 1 )
	{	
?>
	<script type="text/javascript">other_slideshow_go(<?php echo get_option('ma_homepage_slideshow_pause').','.get_option('ma_homepage_slideshow_fade'); ?>);</script>
	<div id="wrapper_slideshow" class="page_sidebar_slideshow">
  	<div id="container_slideshow">
<?php
		foreach($gallery as $image) { 	
?>
    		<img src="<?php echo $image["sizes"]["Page Featured Image"]; ?>" />
<?php  
		}
?>
  </div>
</div>
<?php
	}
	else
	{
?>
		<img src="<?php echo $gallery[0]["sizes"]["Page Featured Image"]; ?>" />
<?php		
	}
}
else
{
	the_post_thumbnail('Page Featured Image'); 
}
?>
</div>
<div class="clear"></div>
<?php
endwhile;
endif;
?>

  </div><!-- #container_content -->
</div><!-- #wrapper_content -->

<?php get_footer(); ?>