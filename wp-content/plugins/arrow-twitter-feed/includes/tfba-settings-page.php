<?php
wp_nonce_field( 'tfba_ui_meta_box_nonce', 'tfba_meta_box_nonce' );

global $post;
$tfba_show_photos_from = get_post_meta($post->ID, '_tfba_show_photos_from', true);
$tfba_user_id = get_post_meta($post->ID, '_tfba_user_id', true);
$tfba_hashtag = get_post_meta($post->ID, '_tfba_hashtag', true);
$tfba_location = get_post_meta($post->ID, '_tfba_location', true);
$tfba_container_width = get_post_meta($post->ID, '_tfba_container_width', true);
$tfba_date_posted = get_post_meta($post->ID, '_tfba_date_posted', true);
$tfba_profile_picture = get_post_meta($post->ID, '_tfba_profile_picture', true);
$tfba_caption_text = get_post_meta($post->ID, '_tfba_caption_text', true);
$tfba_link_photos_to_instagram = get_post_meta($post->ID, '_tfba_link_photos_to_instagram', true);
$tfba_show_photos_only = get_post_meta($post->ID, '_tfba_show_photos_only', true);
$tfba_number_of_photos = get_post_meta($post->ID, '_tfba_number_of_photos', true);
$tfba_feed_style = get_post_meta($post->ID, '_tfba_feed_style', true);
$tfba_limit_post_characters = get_post_meta($post->ID, '_tfba_limit_post_characters', true);
$tfba_thumbnail_size = get_post_meta($post->ID, '_tfba_thumbnail_size', true);
$tfba_column_count = get_post_meta($post->ID, '_tfba_column_count', true);
$tfba_feed_post_size = get_post_meta($post->ID, '_tfba_feed_post_size', true);
$tfba_theme_selection = get_post_meta($post->ID, '_tfba_theme_selection', true);
$tfba_private_access_token = get_post_meta($post->ID, '_tfba_private_access_token', true);
$tfba_read_more = get_post_meta($post->ID, '_tfba_read_more', true);

$tfba_social_card_width = get_post_meta($post->ID, '_tfba_social_card_width', true);
$tfba_social_card_background_color = get_post_meta($post->ID, '_tfba_social_card_background_color', true);
$tfba_heading_font_size = get_post_meta($post->ID, '_tfba_heading_font_size', true);
$tfba_caption_font_size = get_post_meta($post->ID, '_tfba_caption_font_size', true);
$tfba_social_card_heading_color = get_post_meta($post->ID, '_tfba_social_card_heading_color', true);
$tfba_social_card_content_color = get_post_meta($post->ID, '_tfba_social_card_content_color', true);
$tfba_social_card_date_color = get_post_meta($post->ID, '_tfba_social_card_date_color', true);
$tfba_feed_profile_style = get_post_meta($post->ID, '_tfba_feed_profile_style', true);
$tfba_hide_media = get_post_meta($post->ID, '_tfba_hide_media', true);


?>
<script type="text/javascript">
  jQuery(document).ready( function($) {
    var selected_feed_style = $('input[name=tfba_feed_style]:checked', '#tfba_style_selection_option').val();
    if(selected_feed_style == 'thumbnails'){
      $('#tfba_thumbnail_style_options').show();
      $('#tfba_column_count_settings').hide();
      $('#tfba_thumbnails_image').css('border','2px inset #858585');
      $('#tfba_masonry_image').css('border','none');
      $('#tfba_blog_image').css('border','none');
    }
    if(selected_feed_style == 'blog_style' ){
      $('#tfba_blog_masonry_style_options').show();
      $('#tfba_column_count_settings').hide();
      $('#tfba_blog_image').css('border','2px inset #858585');
      $('#tfba_thumbnails_image').css('border','none');
      $('#tfba_masonry_image').css('border','none');

    }
    if(selected_feed_style == 'masonry'){
      $('#tfba_blog_masonry_style_options').show();
      $('#tfba_column_count_settings').show();
      $('#tfba_masonry_image').css('border','2px inset #858585');
      $('#tfba_blog_image').css('border','none');
      $('#tfba_thumbnails_image').css('border','none');


    }
    if(selected_feed_style == 'vertical' ){
      $('#tfba_blog_masonry_style_options').show();
      $('#tfba_column_count_settings').hide();
      $('#tfba_vertical_image').css('border','2px inset #858585');
      $('#tfba_blog_image').css('border','none');
      $('#tfba_thumbnails_image').css('border','none');
      $('#tfba_masonry_image').css('border','none');

    }
    $('#tfba_style_selection_option input').on('change', function() {
      var feed_style_selection = $('input[name=tfba_feed_style]:checked', '#tfba_style_selection_option').val(); 
      if(feed_style_selection == 'thumbnails'){
        $('#tfba_thumbnail_style_options').show();
        $('#tfba_blog_masonry_style_options').hide();
      $('#tfba_column_count_settings').hide();
        $('#tfba_thumbnails_image').css('border','2px inset #858585');
        $('#tfba_vertical_image').css('border','none');
        $('#tfba_masonry_image').css('border','none');
        $('#tfba_blog_image').css('border','none');
      }
      if(feed_style_selection == 'blog_style' ){
        $('#tfba_thumbnail_style_options').hide();
        $('#tfba_blog_masonry_style_options').show();
      $('#tfba_column_count_settings').hide();
        $('#tfba_blog_image').css('border','2px inset #858585');
         $('#tfba_vertical_image').css('border','none');
        $('#tfba_thumbnails_image').css('border','none');
        $('#tfba_masonry_image').css('border','none');
      }
      if(feed_style_selection == 'vertical' ){
        $('#tfba_thumbnail_style_options').hide();
        $('#tfba_blog_masonry_style_options').show();
      $('#tfba_column_count_settings').hide();
        $('#tfba_vertical_image').css('border','2px inset #858585');
        $('#tfba_blog_image').css('border','none');
        $('#tfba_thumbnails_image').css('border','none');
        $('#tfba_masonry_image').css('border','none');
      }
      if(feed_style_selection == 'masonry'){
        $('#tfba_thumbnail_style_options').hide();
        $('#tfba_blog_masonry_style_options').show();
      $('#tfba_column_count_settings').show();
       $('#tfba_vertical_image').css('border','none');
        $('#tfba_masonry_image').css('border','2px inset #858585');
        $('#tfba_blog_image').css('border','none');
        $('#tfba_thumbnails_image').css('border','none');
      }
    });
  });
</script>
<style type="text/css">

  main {
    background: #FFF;
    width: 98%;
    padding: 1%;
    margin-top: 1%;
    box-shadow: 0 3px 5px rgba(0,0,0,0.2);
        border-top: 4px solid #34c5ff;
  }
  main p {
    font-size: 13px;
  }
  main #tfba-tab1, main #tfba-tab2, main #tfba-tab3, main #tfba-tab4, main section {
    clear: both;
    padding-top: 30px;
    display: none;
  }
  #tfba-tab1-label, #tfba-tab2-label,  #tfba-tab3-label,  #tfba-tab4-label {
    font-weight: bold;
    font-size: 14px;
    display: block;
    float: left;
    padding: 10px 30px;
    border-top: 2px solid transparent;
    border-right: 1px solid transparent;
    border-left: 1px solid transparent;
    border-bottom: 1px solid #DDD;
  }
  main label:hover {
    cursor: pointer;
    text-decoration: underline;
  }
  #tfba-tab1:checked ~ #tfba-content1, #tfba-tab2:checked ~ #tfba-content2, #tfba-tab3:checked ~ #tfba-content3, #tfba-tab4:checked ~ #tfba-content4 {
    display: block;
  }
  main input:checked + #tfba-tab1-label, main input:checked + #tfba-tab2-label, main input:checked +  #tfba-tab3-label, main input:checked +  #tfba-tab4-label {
    border-top-color: #2fc4ff;
    border-right-color: #DDD;
    border-left-color: #DDD;
    border-bottom-color: transparent;
    text-decoration: none;
  }
  #tfba_show_photos_from_id , #tfba_show_photos_from_location , #tfba_show_photos_from_hashtag{
    margin-top: 2px;
  }
  .tfba_checkbox{
    width: 25px !important;
    height: 25px !important;
    border: 1px solid lightgrey !important;
    border-radius: 5px !important;
    margin-left: 10px !important;
        border: 2px solid #34c5ff !important;
  }
  .tfba_checkbox:checked:before{
    font-size: 30px !important;
  }
  #tfba_theme_selection_table tr td{
    vertical-align: top;
    display: inline-block;
  }
</style>
<p style="text-align: center;
    background: white;
    border: 2px solid #34c5ff;
    padding: 5px;
    font-size: 17px;">Copy this shortcode & paste into your Post or Page to show Twitter Feed<br/> <strong>[arrow_twitter_feed id='<?php echo $post->ID; ?>']</strong></p>
<main>
  <input id="tfba-tab1" type="radio" name="tfba-tabs" checked>
  <label id="tfba-tab1-label" for="tfba-tab1">Feed Settings</label>
  <input id="tfba-tab2" type="radio" name="tfba-tabs">
  <label id="tfba-tab2-label" for="tfba-tab2">Appearance Settings</label>
  <section id="tfba-content1">
    <h2 style="font-size: 17px;">Select Feed Style:</h2>
    <table id="tfba_style_selection_option">
      <tr>
       <td>
          <p style="text-align: center;margin: 0;">
            <input id="tfba_feed_style_vertical" type="radio" name="tfba_feed_style" value="vertical" <?php echo ($tfba_feed_style == 'vertical')? 'checked="checked"':''; ?> <?php if($tfba_feed_style == ''){ echo 'checked="checked"';} ?> /> 
            <label for="tfba_feed_style_vertical"><strong>Vertical</strong></label>
          </p>
          <p style="text-align: center;margin: 5px;">
            <label for="tfba_feed_style_vertical">
              <img id="tfba_vertical_image" src="<?php echo plugins_url('images/vertical.png',__FILE__); ?>" />
            </label>
          </p>
        </td>
    <!--     <td>
          <p style="text-align: center;margin: 0;">
            <input id="tfba_feed_style_thumbnails" type="radio" name="tfba_feed_style" value="thumbnails" <?php echo ($tfba_feed_style == 'thumbnails')? 'checked="checked"':''; ?> /> 
            <label for="tfba_feed_style_thumbnails"><strong>Thumbnails</strong></label>
          </p>
          <p style="text-align: center;margin: 5px;">
            <label for="tfba_feed_style_thumbnails">
              <img id="tfba_thumbnails_image" src="<?php echo plugins_url('images/thumbnails.png',__FILE__); ?>" />
            </label>
          </p>
        </td> -->
        <td>
          <p style="text-align: center;margin: 0;">
            <input id="tfba_feed_style_blog_style" type="radio" name="tfba_feed_style" value="blog_style" <?php echo ($tfba_feed_style == 'blog_style')? 'checked="checked"':''; ?> /> 
            <label for="tfba_feed_style_blog_style"><strong>Blog Style</strong></label>
          </p>
          <p style="text-align: center;margin: 5px;">
            <label for="tfba_feed_style_blog_style">
              <img id="tfba_blog_image" class="tfba_style_image" src="<?php echo plugins_url('images/blog_style.png',__FILE__); ?>" />
            </label>
          </p>
        </td>
        <td>
          <p style="text-align: center;margin: 0;">
            <input disabled id="tfba_feed_style_masonry" type="radio" name="tfba_feed_style" value="" /> 
            <label for="tfba_feed_style_masonry"><strong>Masonry <a href="https://www.arrowplugins.com/twitter-feed" target="_blank">Locked</a></strong></label>
          </p>
          <p style="text-align: center;margin: 5px;">
            <label for="tfba_feed_style_masonry">
              <img id="tfba_masonry_image" class="tfba_style_image" src="<?php echo plugins_url('images/masonry.png',__FILE__); ?>" />
            </label>
          </p>
        </td>
      </tr>
    </table>


    <table id="tfba_general_options">
      <tr>
        <td style="vertical-align: top;">
          <h3 style="margin: 6px;">Show Tweets From:</h3>
        </td>
        <td>
          <table id="tfba_selection_table">
            <tr>
              <td>
                <input type="radio" id="tfba_show_photos_from_id" name="tfba_show_photos_from" value='userid'<?php checked( "userid", $tfba_show_photos_from); ?> <?php if($tfba_show_photos_from == ''){ echo 'checked="checked"';} ?> />
                <label for="tfba_show_photos_from_id"><strong>Username:</strong></label> 
              </td>
              <td>
                <input type="text" id="tfba_show_photos_from_id_value" name="tfba_user_id" placeholder="Example: 13221453" value="<?php echo $tfba_user_id; ?>" /> 
              </td>
            </tr>
            <tr>
              <td>
              </td>
              <td>
                <span><strong>Example: @audi (Don't forget to add '@' with your username)</strong></span>
              </td>
            </tr>
            <tr>
              <td>
                <input disabled type="radio" id="tfba_show_photos_from_hashtag" name="tfba_show_photos_from" value='hashtag'<?php checked( "hashtag", $tfba_show_photos_from); ?>  />
                <label for="tfba_show_photos_from_hashtag"><strong>Hashtag:</strong></label> 
              </td>
              <td>
                <input disabled type="text" id="tfba_show_photos_from_hashtag_value" name="" value="<?php echo $tfba_hashtag; ?>" /><a href="https://www.arrowplugins.com/twitter-feed" target="_blank">Premium Feature</a>
              </td>
            </tr>
            <tr>
              <td>
              </td>
              <td>
                <span><strong>Example: #awesome (Don't forget to add '#' with hashtag)</strong></span>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td>
          <h3>Number of Tweets to Show: </h3> 
        </td>
        <td>
          <input style="margin-left: 15px;" type="number" min="1" max="100" id="tfba_number_of_photos" name="tfba_number_of_photos" value="<?php if($tfba_number_of_photos == ''){ echo '20' ;}else{ echo $tfba_number_of_photos; } ?>" /> 
        </td>
      </tr>
      <tr>
        <td>
          <h3>Change Date Posted Language: </h3> 
        </td>
        <td>
        <select name="" id="" value= >
            <option value="en"  >English (Default)</option>
            <option disabled value="ar"  >Arabic (Premium)</option>
            <option disabled value="bn"  >Bangali (Premium)</option>
            <option disabled value="cs"  >Czech (Premium)</option>
            <option  disabled value="da" >Danish (Premium)</option>
            <option disabled value="nl" >Dutch (Premium)</option>
            <option disabled value="fr" >French (Premium)</option>
            <option disabled value="de"  >German (Premium)</option>
            <option disabled value="it" >Italian (Premium)</option>
            <option disabled value="ja"  >Japanese (Premium)</option>
            <option disabled value="ko"  >Korean (Premium)</option>
            <option disabled value="pt" >Portuguese (Premium)</option>
            <option disabled value="ru" >Russian (Premium)</option>
            <option disabled value="es"  >Spanish (Premium)</option>
            <option disabled value="tr" >Turkish (Premium)</option>
            <option disabled value="uk"  >Ukranian (Premium)</option>
        </select>
        </td>
      </tr>
    </table>

    <table id="tfba_thumbnail_style_options" style="display: none;">
      <tr>
        <td>
          <h3>Thumbnail Size: </h3> 
        </td>
        <td>
          <input style="width: 70px;margin-left: 106px;" type="number"  id="tfba_thumbnail_size" name="tfba_thumbnail_size" value="<?php if($tfba_thumbnail_size == ''){ echo '250' ;}else{ echo $tfba_thumbnail_size; } ?>" /> px 
        </td>
      </tr>
    </table>

<table id="tfba_column_count_settings" style="display: none;">
      <tr>
        <td>
          <h3>Number of Columns in a Row: </h3> 
        </td>
        <td>
          <input style="width: 70px;margin-left: ;" type="number"  id="tfba_column_count" name="tfba_column_count" value="<?php if($tfba_column_count == ''){ echo '2' ;}else{ echo $tfba_column_count; } ?>" /> 
        </td>
      </tr>
    </table>

    <table id="tfba_blog_masonry_style_options" style="display: none;">
      <tr>
        <td>
          <h3>Limit Post Caption Text: </h3> 
        </td>
        <td>
          <input type="number" min="50" max="600" id="tfba_limit_post_characters" name="tfba_limit_post_characters" value="<?php if($tfba_limit_post_characters == ''){ echo '300' ;}else{ echo $tfba_limit_post_characters; } ?>" /> Characters <span>Minimum value is 50 & Maximum value is 600</span>
        </td>
      </tr>
    
      <tr>
        <td>
          <h3>Hide Date Posted: </h3> 
        </td>
        <td>
          <input type="checkbox" class="tfba_checkbox" name="tfba_date_posted" id="tfba_date_posted"  value='1'<?php checked(1, $tfba_date_posted); ?> />
        </td>
      </tr>
      <tr>
        <td>
          <h3>Hide Profile Picture: </h3> 
        </td>
        <td>
          <input type="checkbox" class="tfba_checkbox" name="tfba_profile_picture" id="tfba_profile_picture" value='1'<?php checked('1', $tfba_profile_picture); ?> />
        </td>
      </tr>
       <tr>
        <td>
          <h3>Hide "read more" link: </h3> 
        </td>
        <td>
          <input type="checkbox" class="tfba_checkbox" name="tfba_read_more" id="tfba_read_more" value='1'<?php checked('1', $tfba_read_more); ?> />
        </td>
      </tr>
      <tr>
        <td>
          <h3>Hide Post Caption Text: </h3> 
        </td>
        <td>
          <input type="checkbox" class="tfba_checkbox" name="tfba_caption_text" id="tfba_caption_text" value='1'<?php checked('1', $tfba_caption_text); ?> />
        </td>
      </tr>
    </table>
<br/>

<h2 style="    font-size: 18px; margin: 0;padding: 3px;">Select Feed Template:</h2>
<br/>
    
    <table id="tfba_theme_selection_table">
      <tr>
        <td>
          <p style="text-align: center;margin: 0;">
            <input type="radio" id="tfba_theme_selection_default" name="tfba_theme_selection" value="default" <?php echo ($tfba_theme_selection == 'default')? 'checked="checked"':''; ?> <?php if($tfba_theme_selection == ''){ echo 'checked="checked"';} ?>/>
            <label for="tfba_theme_selection_default"><strong>Default</strong></label>
          </p>
          <p style="text-align: center;margin: 5px;">
          <label for="tfba_theme_selection_default">
            <img style="    box-shadow: 0 0 10px 0 rgba(10, 10, 10, 0.2) !important; width: 200px;" src="<?php echo plugins_url('images/default.png',__FILE__); ?>">
            </label>
          </p>
        </td>
        <td>
          <p style="text-align: center;margin: 0;">
            <input disabled type="radio" id="tfba_theme_selection_template0" name="tfba_theme_selection" value="template0" <?php echo ($tfba_theme_selection == 'template0')? 'checked="checked"':''; ?> />
            <label for="tfba_theme_selection_template0"><strong>Dark</strong> <a href="https://www.arrowplugins.com/twitter-feed" target="_blank">Locked</a></label> 
          </p>
          <p style="text-align: center;margin: 5px;">
          <label for="tfba_theme_selection_template0">
            <img style="width: 200px;" src="<?php echo plugins_url('images/template0.png',__FILE__); ?>">
            </label>
          </p>
        </td>
        <td>
          <p style="text-align: center;margin: 0;">
            <input disabled type="radio" id="tfba_theme_selection_template1" name="tfba_theme_selection" value="template1" <?php echo ($tfba_theme_selection == 'template1')? 'checked="checked"':''; ?> />
            <label for="tfba_theme_selection_template1"><strong>Pinterest Like Layout</strong> <a href="https://www.arrowplugins.com/twitter-feed" target="_blank">Locked</a></label>
          </p>
          <p style="text-align: center;margin: 5px;">
          <label for="tfba_theme_selection_template1">
            <img style="width: 200px;" src="<?php echo plugins_url('images/template1.png',__FILE__); ?>">
            </label>
          </p>
        </td>
        <td>
          <p style="text-align: center;margin: 0;">
            <input disabled type="radio" id="tfba_theme_selection_template2" name="tfba_theme_selection" value="template2" <?php echo ($tfba_theme_selection == 'template2')? 'checked="checked"':''; ?> />
            <label for="tfba_theme_selection_template2"><strong>Modern Light</strong> <a href="https://www.arrowplugins.com/twitter-feed" target="_blank">Locked</a></label>
          </p>
          <p style="text-align: center;margin: 5px;">
          <label for="tfba_theme_selection_template2">
            <img style="    box-shadow: 0 0 10px 0 rgba(10, 10, 10, 0.2) !important; width: 200px;" src="<?php echo plugins_url('images/template2.png',__FILE__); ?>">
            </label>
          </p>
        </td>
        <td>
          <p style="text-align: center;margin: 0;">
            <input disabled type="radio" id="tfba_theme_selection_template3" name="tfba_theme_selection" value="template3" <?php echo ($tfba_theme_selection == 'template3')? 'checked="checked"':''; ?> />
            <label for="tfba_theme_selection_template3"><strong>Modern Dark</strong> <a href="https://www.arrowplugins.com/twitter-feed" target="_blank">Locked</a></label>
          </p>
          <p style="text-align: center;margin: 5px;">
          <label for="tfba_theme_selection_template3">
            <img style="    box-shadow: 0 0 10px 0 rgba(10, 10, 10, 0.2) !important; width: 200px;" src="<?php echo plugins_url('images/template3.png',__FILE__); ?>">
            </label>
          </p>
        </td>
        <td>
          <p style="text-align: center;margin: 0;">
            <input disabled type="radio" id="tfba_theme_selection_template4" name="tfba_theme_selection" value="template4" <?php echo ($tfba_theme_selection == 'template4')? 'checked="checked"':''; ?> />
            <label for="tfba_theme_selection_template4"><strong>Space White</strong> <a href="https://www.arrowplugins.com/twitter-feed" target="_blank">Locked</a></label>
          </p>
          <p style="text-align: center;margin: 5px;">
          <label for="tfba_theme_selection_template4">
            <img style="    box-shadow: 0 0 10px 0 rgba(10, 10, 10, 0.2) !important; width: 200px;" src="<?php echo plugins_url('images/template4.png',__FILE__); ?>">
            </label>
          </p>
        </td>
      </tr>
    </table>
  </section>
  <section id="tfba-content2">
      <table>
    
    <tr>
        <td><h3>Social Feed Card Width:</h3></td>
        <td> <input style="width: 70px;" type="number"  id="tfba_social_card_width" name="tfba_social_card_width" value="<?php if($tfba_social_card_width == ''){ echo '400' ;}else{ echo $tfba_social_card_width; } ?>" /> px
        </td>
    </tr>
    <tr>
        <td><h3 style="margin: 0;margin-top: 6px;margin-bottom: -15px;">Heading Font Size:</h3>
            </br>
            <h4 style="margin: 0;font-weight: normal;">Your Profile Account Name Font Size</h4>
        </td>
        <td>
            <input style="width: 70px;" type="number"  id="tfba_heading_font_size" name="tfba_heading_font_size" value="<?php if($tfba_heading_font_size == ''){ echo '' ;}else{ echo $tfba_heading_font_size; } ?>" /> px <span style="font-weight: bold;color:red;">(Leave empty for default theme font size)</span>
        </td>
    </tr>
    <tr>
        <td><h3  style="margin: 0;margin-top: 6px;margin-bottom: -15px;">Post Content Font Size:</h3>
            </br>
            <h4 style="margin: 0;font-weight: normal;">Single Post Caption Text Font Size</h4>
        </td>
        <td>
            <input style="width: 70px;" type="number"  id="tfba_caption_font_size" name="tfba_caption_font_size" value="<?php if($tfba_caption_font_size == ''){ echo '' ;}else{ echo $tfba_caption_font_size; } ?>" /> px <span style="font-weight: bold;color:red;">(Leave empty for default theme font size)</span>
        </td>
    </tr>
    <tr>
        <td><h3>Heading Color:</h3></td>
        <td><input type="text" id="tfba_social_card_heading_color" name="tfba_social_card_heading_color" class="color_picker" value="<?php if($tfba_social_card_heading_color == '') { echo '';}else { echo $tfba_social_card_heading_color;} ?>"> </td>
    </tr>
    <tr>
        <td><h3>Post Content Color:</h3></td>
        <td><input type="text" id="tfba_social_card_content_color" name="tfba_social_card_content_color" class="color_picker" value="<?php if($tfba_social_card_content_color == '') { echo '';}else { echo $tfba_social_card_content_color;} ?>"> </td>
    </tr>
    <tr>
        <td><h3>Date Text Color:</h3></td>
        <td><input type="text" id="tfba_social_card_date_color" name="tfba_social_card_date_color" class="color_picker" value="<?php if($tfba_social_card_date_color == '') { echo '';}else { echo $tfba_social_card_date_color;} ?>"> </td>
    </tr>
    <tr>
        <td><h3>Profile Picture Style:</h3></td>
        <td>
           <table id="tfba_profile_style_selection_option">
      <tr>
       <td>
          <p style="text-align: center;margin: 0;">
            <input id="tfba_feed_profile_style_square" type="radio" name="tfba_feed_profile_style" value="square" <?php echo ($tfba_feed_profile_style == 'square')? 'checked="checked"':''; ?> <?php if($tfba_feed_profile_style == ''){ echo 'checked="checked"';} ?> /> 
            <label for="tfba_feed_profile_style_square"><strong>Square</strong></label>
          </p>
          <p style="text-align: center;margin: 5px;">
            <label for="tfba_feed_profile_style_square">
              <img id="tfba_vertical_image" src="<?php echo plugins_url('images/square.png',__FILE__); ?>" />
            </label>
          </p>
        </td>
        <td>
          <p style="text-align: center;margin: 0;">
            <input id="tfba_feed_profile_style_rounded" type="radio" name="tfba_feed_profile_style" value="rounded" <?php echo ($tfba_feed_profile_style == 'rounded')? 'checked="checked"':''; ?> /> 
            <label for="tfba_feed_profile_style_rounded"><strong>Rounded</strong></label>
          </p>
          <p style="text-align: center;margin: 5px;">
            <label for="tfba_feed_profile_style_rounded">
              <img id="tfba_thumbnails_image" src="<?php echo plugins_url('images/rounded.png',__FILE__); ?>" />
            </label>
          </p>
        </td>
           <td>
          <p style="text-align: center;margin: 0;">
            <input id="tfba_feed_profile_style_curved" type="radio" name="tfba_feed_profile_style" value="curved" <?php echo ($tfba_feed_profile_style == 'curved')? 'checked="checked"':''; ?> /> 
            <label for="tfba_feed_profile_style_curved"><strong>Curved</strong></label>
          </p>
          <p style="text-align: center;margin: 5px;">
            <label for="tfba_feed_profile_style_curved">
              <img id="tfba_thumbnails_image" src="<?php echo plugins_url('images/curved.png',__FILE__); ?>" />
            </label>
          </p>
        </td>
      </tr>
    </table>
        </td>
    </tr>
    </table>
  </section>
  <section id="tfba-content3">
    <h3>Heading Text</h3>
    <p>Fusce pulvinar porttitor dui, eget ultrices nulla tincidunt vel. Suspendisse faucibus lacinia tellus, et viverra ligula. Suspendisse eget ipsum auctor, congue metus vel, dictum erat. Aenean tristique euismod molestie. Nulla rutrum accumsan nisl, ac semper sapien tincidunt et. Praesent tortor risus, commodo et sagittis nec, aliquam quis augue. Aenean non elit elementum, tempor metus at, aliquam felis.</p>
  </section>
  <section id="tfba-content4">
    <h3>Here Are Many Words</h3>
    <p>Vivamus convallis lectus lobortis dapibus ultricies. Sed fringilla vitae velit id rutrum. Maecenas metus felis, congue ut ante vitae, porta cursus risus. Nulla facilisi. Praesent vel ligula et erat euismod luctus. Etiam scelerisque placerat dapibus. Vivamus a mauris gravida urna mattis accumsan. Duis sagittis massa vel elit tincidunt, sed molestie lacus dictum. Mauris elementum, neque eu dapibus gravida, eros arcu euismod metus, vitae porttitor nibh elit at orci. Vestibulum laoreet id nulla sit amet mattis.</p>
  </section>
   <div class="">
            <h3>Like the plugin? Share with friends & family!</h3>
            <a href="https://twitter.com/share" class="twitter-share-button" data-url="https://wordpress.org/plugins/arrow-twitter-feed/" data-text="Display your Facebook, Twitter, Instagram, Pinterest & VK posts on your site your way using the Social Feed WordPress plugin!" data-via="arrowplugins" data-dnt="true">Tweet</a>
            <a href="https://twitter.com/arrowplugins?ref_src=twsrc%5Etfw" class="twitter-follow-button" data-show-count="false">Follow @arrowplugins</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
            <div id="fb-root" style="display: none;"></div>
            <script>(function(d, s, id) {
              var js, fjs = d.getElementsByTagName(s)[0];
              if (d.getElementById(id)) return;
              js = d.createElement(s); js.id = id;
              js.src = "https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v3.2&appId=340145266536074&autoLogAppEvents=1";
              fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>
            <div style="vertical-align: top;" class="fb-share-button" data-href="https://wordpress.org/plugins/arrow-twitter-feed/" data-layout="button" data-size="small" data-mobile-iframe="true"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Share Twitter Feed Plugin</a></div>
            <div class="fb-like" data-href="https://www.facebook.com/wparrowplugins" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true" style="display: block; float: left; margin-right: 4px;"></div>
            <script src="//platform.linkedin.com/in.js" type="text/javascript">
              lang: en_US
            </script>
            <script type="IN/Share" data-url="https://wordpress.org/plugins/arrow-twitter-feed/"></script>
            <script src="https://apis.google.com/js/platform.js" async defer></script>
            <div class="g-plusone" data-size="medium" data-href="https://wordpress.org/plugins/arrow-twitter-feed/"></div>
        </div>
</main>
