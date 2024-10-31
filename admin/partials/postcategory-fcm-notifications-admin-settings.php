<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/EmilMfornyam/WordPress-Post-FCM-Plugin
 * @since      1.0.0
 *
 * @package    WordPress-Post-FCM-Plugin
 * @subpackage WordPress-Post-FCM-Plugin/admin/partials
 */
?>
<h1 class="pcfcn-topic">Setup Google Firebase Cloud Messaging</h1>
<div id="acf_location" class="postbox ">
<div class="handlediv" title="Click to toggle"><br></div><h3 class="hndle ui-sortable-handle"><span>SETTINGS</span></h3>
<div class="inside">
<form action="options.php" method="post">

    <?php settings_fields( 'pfcm_group'); ?>
    <?php do_settings_sections( 'pfcm_group' ); ?>
	
	<table class="acf_input widefat" id="acf_location">
		<tbody>
		<tr>
			<td class="label">
				<label for="post_type">FCM API Key</label>
				<p class="description">Get API key from your Firebase Console</p>
			</td>
			<td>
				<div class="acf-input-wrap">
					<input type="text" id="pcfn-api-key" class="number" name="pfcm_api" value="<?php echo get_option( 'pfcm_api' );  ?>" placeholder="" required="required">
				</div>
			</td>
		</tr>
		<tr>
			<td class="label">
				<label for="post_type">FCM Topic</label>
				<p class="description">FCM Topic in Application</p>
			</td>
			<td>
				<div class="acf-input-wrap">
					<input type="text" id="pcfn-topic" class="number" name="pfcm_topic" value="<?php echo get_option( 'pfcm_topic' );  ?>" placeholder="" required="required">
				</div>
			</td>
		</tr>
		<tr>
			<td class="label">
				<label for="post_type">Category</label>
				<p class="description">Send FCM when post is published from these Categories</p>
			</td>
			<td>
				<ul class="acf-checkbox-list checkbox vertical">
					<?php $catest = get_categories() ;
						foreach($catest as $catests){ 
							$pfcmCats = 'pfcm_'.$catests->slug; ?>
							<li>
								<label>
									<input type="checkbox" value="1" name="<?php echo $pfcmCats ; ?>" <?php checked( '1', get_option( $pfcmCats ) ); ?> ><?php echo $catests->name; ?>
								</label>
							</li>
					<?php } ?>
				</ul>
			</td>
		</tr>
		<tr>
			<td class="label">
				<label for="post_type">Notification Alert Sound</label>
				<p class="description">Sound files must reside in /res/raw/...</p>
			</td>
			<td>
				<input type="text" id="pfcm_sound" class="number" name="pfcm_sound" value="<?php echo get_option( 'pfcm_sound' );  ?>" placeholder="" >
				<br/>
				<!-- <input id="pfcm_vibrate" name="pfcm_vibrate" type="checkbox" value="1" <?php //checked( '1', get_option( 'pfcm_vibrate' ) ); ?> >Vibration -->
			</td>
		</tr>
		<tr>
			<td class="label">
				<label for="post_type">Notification Icon</label>
				<p class="description">Sets the notification icon to "myicon" for drawable resource "myicon"</p>
			</td>
			<td>
				<?php 
					/* $image_id = get_option( 'pfcm_icon' );
					if(intval( $image_id ) > 0 ) {
					    // Change with the image size you want to use
					    $image = wp_get_attachment_image( $image_id, 'medium', false, array( 'id' => 'myprefix-preview-image' ) );
					} else {
					    // Some default image
					    $image = '<img id="myprefix-preview-image"  />';
					}
					echo $image; */
				?>
				<!--<img id='myprefix-preview-image' src='<?php //echo $image_id; ?>' width='100' height='100' style='max-height: 100px; width: 100px;' alt="No image. Select image">
				<br/>
				<input id="upload_image_button" type="button" class="button" value="<?php //_e( 'Upload image' ); ?>" />
				<input type='hidden' name='pfcm_icon' id='pfcm_icon' value='<?php echo esc_attr( $pfcm_icon ); ?>' />

				<!-- <div class='image-preview-wrapper'>
					<img id='myprefix-preview-image' src='' width='100' height='100' style='max-height: 100px; width: 100px;'>
				</div> -->
				
				<input type='hidden' name='pfcm_icon' id='pfcm_icon' value='<?php echo esc_attr( $pfcm_icon ); ?>' />
				<input type="text" id="pfcm_icon" class="number" name="pfcm_icon" value="<?php echo get_option( 'pfcm_icon' );  ?>" placeholder="" >
				<br/>
			</td>
		</tr>
		<tr>
			<td class="label">
				<label for="post_type">Disable FCM</label>
				<p class="description">Disable Push Notification on Post Publish</p>
			</td>
			<td>
				<input id="post_disable" name="pfcm_disable" type="checkbox" value="1" <?php checked( '1', get_option( 'pfcm_disable' ) ); ?> >Yes 
			</td>
		</tr>

		</tbody>
	</table>
	
	<p class="submit"><?php submit_button(); ?></p>
</form>
</div>
</div>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
