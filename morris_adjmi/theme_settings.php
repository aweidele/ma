<?php
///SAVE THE SETTINGS
if (isset($_POST["update_settings"])) { 
    
    foreach($_POST as $key => $value) {
      if ($key != "update_settings") {
        $key = "ma_".$key;
        $value = esc_attr($value);
        update_option($key,$value);
      }
    }
    
    $updated = 1;
} 

///GET OPTIONS
$homepage_slideshow_pause = get_option('ma_homepage_slideshow_pause');
$homepage_slideshow_fade = get_option('ma_homepage_slideshow_fade');
$homepage_news_pause = get_option('ma_homepage_news_pause');
$homepage_news_fade = get_option('ma_homepage_news_fade');
$search_result = get_option('ma_search_result');


$posts_per_page = get_option('ma_posts_per_page');


$slider_move = get_option('ma_slider_move');
$slider_delay = get_option('ma_slider_delay');

$address = get_option('ma_address');
$city = get_option('ma_city');
$state = get_option('ma_state');
$zip = get_option('ma_zip');
$phone = get_option('ma_phone');
$email = get_option('ma_email');

?>
  
  <style type="text/css">
    .ma_settings {
      padding-left: 100px;
      padding-top: 25px;
      background-image: url("<?php bloginfo('template_directory'); ?>/image/ma-logo-settings.png");
      background-repeat: no-repeat;
      background-position: 0 25px;
    }
    
    .ma_settings h2 {
      margin-top: 0;
      padding-bottom: 0.75em;
    }
    
    .ma_settings table {
      padding: 7px;
      border: 1px solid #AAAAAA;
      background: #FFFFFF;
      border-radius: 10px;
    }
    
    .homepage_speed input { width: 50px; margin-right: 15px; }
    p.submit_changes { margin: 2em 0; }
    p.submit_changes input[type="submit"] { font-weight: bold; border: 1px solid #333333; background: #EEEEEE; padding: 10px; text-transform: uppercase; border-radius: 10px; box-shadow: 0px 0px 2px #777777; }
    
    .footer_info td { text-align: right; }
    .footer_info input[type="text"] { width: 100%; }
    
    p.updated { color: #990000; }
  </style> 
  <div class="wrap">
<?php if($updated) { ?>
  <p class="updated">Your settings were updated.</p>
<?php } ?>
  <div class="ma_settings">
    <div class="homepage_settings">
      <form method="POST" action="">  
        <h2>Homepage Settings</h2>
        <table class="homepage_speed">
          <tr>
            <td><strong>Homepage Slideshow:</strong></td>
            <td><label for="homepage_slideshow_pause">Pause time:</label></td>
            <td><input type="number" name="homepage_slideshow_pause" id="homepage_slideshow_pause" <?php if($homepage_slideshow_pause) { echo 'value="'.$homepage_slideshow_pause.'"'; } else { echo 'value="0"'; } ?> /></td>
            <td><label for="homepage_slideshow_fade">Fade speed:</label></td>
            <td><input type="number" name="homepage_slideshow_fade" id="homepage_slideshow_fade" <?php if($homepage_slideshow_fade) { echo 'value="'.$homepage_slideshow_fade.'"'; } else { echo 'value="0"'; } ?> /></td>
           </tr>
          <tr>
            <td><strong>Homepage News Feed:</strong></td>
            <td><label for="homepage_news_pause">Pause time:</label></td>
            <td><input type="number" name="homepage_news_pause" id="homepage_news_pause" <?php if($homepage_news_pause) { echo 'value="'.$homepage_news_pause.'"'; } else { echo 'value="0"'; } ?> /></td>
            <td><label for="homepage_news_fade">Fade speed:</label></td>
            <td><input type="number" name="homepage_news_fade" id="homepage_news_fade" <?php if($homepage_news_fade) { echo 'value="'.$homepage_news_fade.'"'; } else { echo 'value="0"'; } ?> /></td>
          </tr>
        </table>
<!--        
        <h2>News Settings</h2>
        <table class="homepage_speed">
          <tr>
            <td><label for="posts_per_page"># of posts per page:</label></td>
            <td><input type="text" name="posts_per_page" id="posts_per_page"<?php if($posts_per_page) { echo ' value="'.$posts_per_page.'"'; } ?> /></td>
          </tr>
        </table> -->
        
        <h2>Project Slider Settings</h2>
        <p>Adjust speed by tweaking movement and delay. Higher movement and shorter delay = faster sliding.</p>
        <table class="homepage_speed">
          <tr>
            <td><label for="slider_move">Movement:</label></td>
            <td><input type="text" name="slider_move" id="slider_move"<?php if($slider_move) { echo ' value="'.$slider_move.'"'; } ?> /></td>
          </tr>
          <tr>
            <td><label for="slider_delay">Delay:</label></td>
            <td><input type="text" name="slider_delay" id="slider_delay"<?php if($slider_delay) { echo ' value="'.$slider_delay.'"'; } ?> /></td>
          </tr>
        </table>

<!-- COMPANY/FOOTER INFORMATION -->
        <h2>Footer Information</h2>
        <table class="footer_info">
          <tr>
            <td><label for="address">Address:</label></td>
            <td colspan="3"><input type="text" name="address" id="address" <?php if($address) { echo 'value="'.$address.'"'; } ?> /></td>
          </tr>
          <tr>
            <td><label for="city">City:</label></td>
            <td><input type="text" name="city" id="city" <?php if($city) { echo 'value="'.$city.'"'; } ?> /></td>
            <td><label for="state">State:</label></td>
            <td><input type="text" name="state" id="state" <?php if($state) { echo 'value="'.$state.'"'; } ?> /></td>
          </tr>
          <tr>
            <td><label for="phone">Zip:</label></td>
            <td colspan="3"><input type="text" name="zip" id="zip" <?php if($zip) { echo 'value="'.$zip.'"'; } ?> /></td>
          </tr>
          <tr>
            <td><label for="phone">Phone:</label></td>
            <td colspan="3"><input type="text" name="phone" id="phone" <?php if($phone) { echo 'value="'.$phone.'"'; } ?> /></td>
          </tr>
          <tr>
            <td><label for="email">Email:</label></td>
            <td colspan="3"><input type="text" name="email" id="email" <?php if($email) { echo 'value="'.$email.'"'; } ?> /></td>
          </tr>
        </table>

<!-- CHOOSE SEARCH RESULTS -->
        <h3>Search Results Page</h3>
        <p>Which page should display the search results? (Hint: Create a page using the “Search” Template)</p>
        <select name="search_result" id="search_result">
          <option value="0"<?php if($search_result == 0) { echo ' selected="selected"'; } ?>>Default</option>
<?php $pages = get_pages();
//print_r($pages);
foreach ($pages as $p) {
?>
          <option value="<?php echo $p->guid; ?>"<?php if($search_result == $p->guid) { echo ' selected="selected"'; } ?>><?php echo $p->post_title; ?></option>
<?php } ?>
        </select>
        
<!-- SUBMIT -->
        <p class="submit_changes"><input type="submit" value="Submit Changes" /></p>
        <input type="hidden" name="update_settings" value="Y" />
      </form>
    </div><!-- ma_settings -->
  </div><!-- wrap -->