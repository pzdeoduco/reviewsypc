<?php

/**
 * Plugin Name: YPC Reviews Plugin
 * Plugin URI: 
 * Description: Reviews plugin for customer service rating.
 * Version: 1.0
 * Author: patzdojo
 * Author URI: 
 */

function reviews_plugin_scripts() { 
	wp_enqueue_style( 'main-styles', plugin_dir_url( __FILE__ ) . 'assets/main.css');
	wp_enqueue_style( 'font-awesome', plugin_dir_url( __FILE__ ) . 'assets/font-awesome.css');

    wp_enqueue_script( 'main-reviews', plugin_dir_url( __FILE__ ) . 'assets/reviews.js', array('jquery') );
}
add_action('wp_enqueue_scripts', 'reviews_plugin_scripts');


class ReviewsPlugin {
	private $reviews_plugin_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'reviews_plugin_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'reviews_plugin_page_init' ) );
	}

	public function reviews_plugin_add_plugin_page() {
		add_menu_page(
			'YPC Reviews Plugin', // page_title
			'YPC Reviews', // menu_title
			'manage_options', // capability
			'reviews-plugin', // menu_slug
			array( $this, 'reviews_plugin_create_admin_page' ), // function
			'dashicons-star-filled', // icon_url
			99 // position
		);
	}

	public function reviews_plugin_create_admin_page() {
		$this->reviews_plugin_options = get_option( 'reviews_plugin_option_name' ); ?>

		<div class="wrap">
			<h2>Reviews Plugin Settings Page</h2>
			<p>Add the Reviews URL on the empty text field.</p>
			<p>Use this shortcode to display on your page "[site_rating]".</p>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
					settings_fields( 'reviews_plugin_option_group' );
					do_settings_sections( 'reviews-plugin-admin' );
					submit_button();
				?>
			</form>
		</div>
	<?php }

	public function reviews_plugin_page_init() {
		register_setting(
			'reviews_plugin_option_group', // option_group
			'reviews_plugin_option_name', // option_name
			array( $this, 'reviews_plugin_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'reviews_plugin_setting_section', // id
			'Settings', // title
			array( $this, 'reviews_plugin_section_info' ), // callback
			'reviews-plugin-admin' // page
		);

		add_settings_field(
			'google_reviews_url_0', // id
			'Google Reviews URL', // title
			array( $this, 'google_reviews_url_0_callback' ), // callback
			'reviews-plugin-admin', // page
			'reviews_plugin_setting_section' // section
		);

		add_settings_field(
			'bbb_reviews_url_1', // id
			'BBB Reviews URL', // title
			array( $this, 'bbb_reviews_url_1_callback' ), // callback
			'reviews-plugin-admin', // page
			'reviews_plugin_setting_section' // section
		);

		add_settings_field(
			'yelp_reviews_url_2', // id
			'Yelp Reviews URL', // title
			array( $this, 'yelp_reviews_url_2_callback' ), // callback
			'reviews-plugin-admin', // page
			'reviews_plugin_setting_section' // section
		);

		add_settings_field(
			'facebook_reviews_url_3', // id
			'Facebook Reviews URL', // title
			array( $this, 'facebook_reviews_url_3_callback' ), // callback
			'reviews-plugin-admin', // page
			'reviews_plugin_setting_section' // section
		);

		add_settings_field(
			'form_reviews_url_4', // id
			'Form Shortcode', // title
			array( $this, 'form_reviews_url_4_callback' ), // callback
			'reviews-plugin-admin', // page
			'reviews_plugin_setting_section' // section
		);
	}

	public function reviews_plugin_sanitize($input) {
		$sanitary_values = array();
		if ( isset( $input['google_reviews_url_0'] ) ) {
			$sanitary_values['google_reviews_url_0'] = sanitize_text_field( $input['google_reviews_url_0'] );
		}

		if ( isset( $input['bbb_reviews_url_1'] ) ) {
			$sanitary_values['bbb_reviews_url_1'] = sanitize_text_field( $input['bbb_reviews_url_1'] );
		}

		if ( isset( $input['yelp_reviews_url_2'] ) ) {
			$sanitary_values['yelp_reviews_url_2'] = sanitize_text_field( $input['yelp_reviews_url_2'] );
		}

		if ( isset( $input['facebook_reviews_url_3'] ) ) {
			$sanitary_values['facebook_reviews_url_3'] = sanitize_text_field( $input['facebook_reviews_url_3'] );
		}

		if ( isset( $input['form_reviews_url_4'] ) ) {
			$sanitary_values['form_reviews_url_4'] = sanitize_text_field( $input['form_reviews_url_4'] );
		}

		return $sanitary_values;
	}

	public function reviews_plugin_section_info() {
		
	}

	public function google_reviews_url_0_callback() {
		printf(
			'<input class="regular-text" type="text" name="reviews_plugin_option_name[google_reviews_url_0]" id="google_reviews_url_0" value="%s">',
			isset( $this->reviews_plugin_options['google_reviews_url_0'] ) ? esc_attr( $this->reviews_plugin_options['google_reviews_url_0']) : ''
		);
	}

	public function bbb_reviews_url_1_callback() {
		printf(
			'<input class="regular-text" type="text" name="reviews_plugin_option_name[bbb_reviews_url_1]" id="bbb_reviews_url_1" value="%s">',
			isset( $this->reviews_plugin_options['bbb_reviews_url_1'] ) ? esc_attr( $this->reviews_plugin_options['bbb_reviews_url_1']) : ''
		);
	}

	public function yelp_reviews_url_2_callback() {
		printf(
			'<input class="regular-text" type="text" name="reviews_plugin_option_name[yelp_reviews_url_2]" id="yelp_reviews_url_2" value="%s">',
			isset( $this->reviews_plugin_options['yelp_reviews_url_2'] ) ? esc_attr( $this->reviews_plugin_options['yelp_reviews_url_2']) : ''
		);
	}

	public function facebook_reviews_url_3_callback() {
		printf(
			'<input class="regular-text" type="text" name="reviews_plugin_option_name[facebook_reviews_url_3]" id="facebook_reviews_url_3" value="%s">',
			isset( $this->reviews_plugin_options['facebook_reviews_url_3'] ) ? esc_attr( $this->reviews_plugin_options['facebook_reviews_url_3']) : ''
		);
	}

	public function form_reviews_url_4_callback() {
		printf(
			'<input class="regular-text" type="text" name="reviews_plugin_option_name[form_reviews_url_4]" id="form_reviews_url_4" value="%s">',
			isset( $this->reviews_plugin_options['form_reviews_url_4'] ) ? esc_attr( $this->reviews_plugin_options['form_reviews_url_4']) : ''
		);
	}

}
if ( is_admin() )
	$reviews_plugin = new ReviewsPlugin();

 
function reviews_plugin_func($atts) {
/* Retrieve this value with: */
$reviews_plugin_options = get_option( 'reviews_plugin_option_name' ); // Array of All Options
$google_reviews_url_0 = $reviews_plugin_options['google_reviews_url_0']; // Google Reviews URL
$bbb_reviews_url_1 = $reviews_plugin_options['bbb_reviews_url_1']; // BBB Reviews URL
$yelp_reviews_url_2 = $reviews_plugin_options['yelp_reviews_url_2']; // Yelp Reviews URL
$facebook_reviews_url_3 = $reviews_plugin_options['facebook_reviews_url_3']; // Facebook Reviews URL
$form_reviews_url_4 = $reviews_plugin_options['form_reviews_url_4']; // Facebook Reviews URL
 
	$Content .= '<div class="reviews_cont">';
	$Content .= '<div class="reviews_row">';
	$Content .= '<header class="header medium review-stars-header"><p class="boldSuperTitle">Step 1</p><h2><span class="dash"><span class="h2content">How would you rate your most recent experience?</span></span></h2></header>';
	$Content .= '<div id="high-score-segment" class="reviews_row">';
	$Content .= '<div class="rowItem" style="margin-bottom: 3%"><div class="rowItemContent"><header class="header medium"><p class="boldSuperTitle">Step 2</p><h2><span class="dash"><span class="h2content">Share your experience on your preferred network:</span></span></h2></header></div></div>';
	$Content .= '<div class="social_links_reviews">';
	if($google_reviews_url_0 != '') {
	$Content .=  '<div class="rev_social"><a href="'.$google_reviews_url_0.'" target="_blank"><img src="'. plugin_dir_url( __FILE__ ) . 'images/google-review-button.png' . '" alt="Google Reviews" /></a></div>';
	} if($bbb_reviews_url_1 != '') {
	$Content .=  '<div class="rev_social"><a href="'.$bbb_reviews_url_1.'" target="_blank"><img src="'. plugin_dir_url( __FILE__ ) . 'images/bbb-review-button.png' . '" alt="BBB Reviews" /></a></div>';
	} if($yelp_reviews_url_2 != '') {
	$Content .=  '<div class="rev_social"><a href="'.$yelp_reviews_url_2.'" target="_blank"><img src="'. plugin_dir_url( __FILE__ ) . 'images/yelp-review-button.png' . '" alt="Yelp Reviews" /></a></div>';
	} if($facebook_reviews_url_3 != '') {
	$Content .=  '<div class="rev_social"><a href="'.$facebook_reviews_url_3.'" target="_blank"><img src="'. plugin_dir_url( __FILE__ ) . 'images/fb-review-button.png' . '" alt="Facebook Reviews" /></a></div>';
	}
	$Content .= '</div>'; // end social_links_reviews
	$Content .= '</div>'; // end high-score-segment
	$Content .= '</div>'; // end reviews_row
	$Content .= '<div class="reviews_row">';
	$Content .= '<div id="low-score-segment">';
	$Content .= '<div class="rowItem review-us-block"><div class="rowItemContent"><header class="header medium"><p class="boldSuperTitle">Step 2</p><h2><span class="dash"><span class="h2content">It looks like we could have done better.</span></span></h2></header><div class="btText"><p>If we’ve done something wrong or you have suggestions on how we can improve our services,<br>please let us know. Simply fill out the form below and we’ll do what we can to make things right.</p></div></div>';
	$Content .=  do_shortcode($form_reviews_url_4);
	$Content .= '</div>'; // end low-score-segment
	$Content .= '</div>'; // end reviews_row
	$Content .= '</div>'; //end reviews_cont
	 
    return $Content;
}

add_shortcode('site_rating', 'reviews_plugin_func');