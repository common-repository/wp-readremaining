<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
/*
Plugin name: WP ReadRemaining
Plugin URI:  https://github.com/onlineth/WP-ReadRemaining
Description: This WordPress plugin allows you to show the user how long it will take to read the article considering the speed in which the user is scrolling.
Version:     1.0
Author:      Thomas H.
Author URI:  http://onlineth.com
 */


//My First Plugin


	//Settings Page
function wprrjs_register_settings() {
	add_option( 'wprrjs_use_cdn', '0');
	add_option( 'wprrjs_theme', '0');
	register_setting( 'default', 'wprrjs_use_cdn' ); 
	register_setting( 'default', 'wprrjs_theme' ); 
} 
add_action( 'admin_init', 'wprrjs_register_settings' );
 
function wprrjs_register_options_page() {
	add_options_page('ReadRemaining Options', 'ReadRemaining', 'manage_options', 'wprrjs-options', 'wprrjs_options_page');
}
add_action('admin_menu', 'wprrjs_register_options_page');
 
function wprrjs_options_page() {
	?>
<div class="wrap">
	<h2>WP ReadRemaining.js Options</h2>
	<p>It's <i>too</i> simple</p>
	<form method="post" action="options.php"> 
		<?php settings_fields( 'default' ); ?>
			<table class="form-table">
				<tr>
					<th scope="row"><label for="wprrjs_theme"><input name="wprrjs_theme" type="radio" value="0" <?php checked( '0', get_option( 'wprrjs_theme' ) ); ?> /></label>Use the Light Theme</th>
					<td></td>
				</tr>
				<tr>
					<th scope="row"><label for="wprrjs_theme"><input name="wprrjs_theme" type="radio" value="1" <?php checked( '1', get_option('wprrjs_theme')); ?> /></label>Use the Dark Theme</th>
					<td></td>
					</tr>
			</table>
		<?php submit_button(); ?>
	</form>
	<small>More settings on the way</small>
</div>
<?php
}

//Code
	function wp_ReadRemaining_Enqueue_Scripts() {
		//Actual JS
		wp_register_script( 'ReadRemaining', plugins_url('/src/readremaining.js', __FILE__ ), array( 'jquery' ), '1.0.0', true);
		wp_register_script('ReadRemaining-cdn', plugins_url('/src/readremaining.js', __FILE__ ), array( 'jquery' ), '1.0.0', true);
		//CSS Depending on user preference
		wp_register_style('ReadRemaining-dark',  plugins_url('/css/rr_dark.css', __FILE__ ));
		wp_register_style('ReadRemaining-light',  plugins_url('/css/rr_light.css', __FILE__ ));
		if (get_option('wprrjs_theme')) {
		wp_enqueue_style('ReadRemaining-dark' );
	} else {
		wp_enqueue_style("ReadRemaining-light");
	}
		//Call the function
		wp_register_script('ReadRemaining-call', plugins_url('src/call.js', __FILE__), array('ReadRemaining'), null, true);
		wp_enqueue_script('ReadRemaining-call');
	}

	add_action( 'wp_enqueue_scripts', 'wp_ReadRemaining_Enqueue_Scripts' );