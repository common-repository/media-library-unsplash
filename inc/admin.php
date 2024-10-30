<?php
/**
 * Admin Functions
 * @since 1.0.0
 * @author tCoderBD <touhid@tcoderbd.com>
 * @package MediaLibraryUnsplash
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * MediaLibraryUnsplash class
 *
 * @author tCoderBD <touhid@tcoderbd.com>
 * @since 1.0.0
 */
class TCBDAML_MediaLibraryUnsplash {

	/**
	 * Set up plugin.
	 *
	 * @author tCoderBD <touhid@tcoderbd.com>
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action('admin_menu', [$this, 'tcbdaml_custom_settings_page']);
		add_action('admin_init', [$this, 'tcbdaml_api_key']);
		add_action('admin_notices', [$this, 'tcbd_plugin_activation_notification'], 999);
		add_action('wp_ajax_tcbdaml_image_callback', [$this, 'tcbdaml_image_callback']);
		add_action('wp_ajax_nopriv_tcbdaml_image_callback', [$this, 'tcbdaml_image_callback']);		
		add_filter('admin_footer_text', [$this, 'tcbdaml_filter_admin_footer_text'] );
		add_filter('plugin_action_links_' . TCBDAML_BASENAME, [$this, 'tcbd_plugin_link']);
	}

	public function tcbdaml_custom_settings_page() {
		add_submenu_page(
			'upload.php',
			'Media Library Unsplash',
			'Media Library Unsplash',
			'manage_options',
			'media-library-unsplash',
			[$this, 'tcbdaml_custom_settings_page_content']
		);	
		add_submenu_page(
			'options-general.php', 
			'Media Library Unsplash Settings',     
			'Media Library Unsplash',          
			'manage_options',      
			'media-library-unsplash-settings',   
			[$this, 'tcbdaml_custom_submenu_callback'] 
		);
	}

	public function tcbdaml_custom_settings_page_content() {
	?>
		<div class="wrap">
			<h2 style="display: none;"></h2>
			<div class="tcbd-wrap-header">
				<div class="tcbd-wrap-header-text">
					<h3>Media Library Unsplash</h3>
					<p>One click photo uploads from <a href="https://unsplash.com/" target="_blank">Unsplash</a></p>		
				</div>
				<a class="button button-primary" href="<?php echo esc_url(admin_url('options-general.php?page=media-library-unsplash-settings')); ?>">Settings</a>
			</div>
			<div id="unsplash_media_library"></div>
		</div>
	<?php
	}

	public function tcbdaml_custom_submenu_callback() {
	?>
		<div class="wrap">
			<h2 style="display: none;"></h2>
			<div class="tcbd-wrap-header">
				<div class="tcbd-wrap-header-text">
					<h3>Media Library Unsplash</h3>
					<p>One click photo uploads from <a href="https://unsplash.com/" target="_blank">Unsplash</a></p>		
				</div>
				<a class="button button-primary" href="<?php echo esc_url(admin_url('upload.php?page=media-library-unsplash')); ?>">Media Library Unsplash</a>
			</div>
			<form action="<?php echo esc_url(admin_url('options-general.php?page=media-library-unsplash-settings')); ?>" method="POST">
				<table class="form-table" role="presentation">
					<tbody>
						<tr>
							<th scope="row">
								<label for="tcbdaml_unsplash">Unsplash API Key</label>
							</th>
							<td>
								<input class="regular-text code" id="tcbdaml_unsplash" type="text" name="tcbdaml_unsplash_api" value="<?php echo esc_html(get_option( 'tcbdaml_api_key' )); ?>" required>
								<?php wp_nonce_field( 'tcbdaml_nonce', 'tcbdaml_api_nonce', false ); ?>
								<p class="description"><strong><em><a href="https://unsplash.com/developers" target="_blank">Get Unsplash API key</a></em></strong></p>
							</td>
						</tr>
						<tr>
							<th></th>
							<td><input type="submit" class="button button-primary" value="Save Settings"></td>
						</tr>
					</tbody>
				</table>			
			</form>	
		</div>
	<?php
	}

	public function tcbdaml_api_key() {		
		if ( isset( $_REQUEST['tcbdaml_api_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash ( $_POST['tcbdaml_api_nonce'] ) ), 'tcbdaml_nonce' ) ) {
			$input_key = sanitize_text_field( $_POST['tcbdaml_unsplash_api'] );
			update_option( 'tcbdaml_api_key', $input_key );
			echo '<div class="notice notice-success is-success"><p>Unsplash <strong>API Key</strong></a> update successfully!</p></div>';
		}
	}

	public function tcbd_plugin_activation_notification() {
		$plugin_slug = 'media-library-unsplash/plugin.php';	
	
		if (is_plugin_active($plugin_slug) && empty(get_option('tcbdaml_api_key'))) {
			echo '<div class="notice notice-error is-dismissible">';
			echo '<p>Please setup Unsplash <a href="'.esc_url(admin_url('options-general.php?page=media-library-unsplash-settings')).'"><strong>API Key</strong></a> to use <strong><em>Media Library Unsplash</em></strong> plugin!</p>';
			echo '</div>';
		}
	}

	public function tcbdaml_filter_admin_footer_text( $text ) {
		$screen     = get_current_screen();
		$base_array = [
			'media_page_media-library-unsplash',
			'settings_page_media-library-unsplash-settings',
		];
		if ( in_array( $screen->base, $base_array, true ) ) {
			$text  = wp_kses_post( '<strong><em>Media Library Unsplash</em></strong> is made with <span style="color: #e25555;">♥</span> by <a href="https://tcoderbd.com/?source=WPAdmin&medium=MediaLibraryUnsplash&campaign=Footer" target="_blank" style="font-weight: 500;">tCoderBD</a> <em>|</em> <a href="https://wordpress.org/support/plugin/media-library-unsplash/reviews/#new-post" target="_blank" style="font-weight: 500;">Leave a Review</a> ' );
		}
		return $text;
	}

	public function tcbd_plugin_link( $links ) {
		$plugin_links = [
			'<a href="' . esc_url(admin_url('upload.php?page=media-library-unsplash')) . '">' . esc_html__('Get Images', 'media-library-unsplash') . '</a>',
			'<a href="' . esc_url(admin_url('options-general.php?page=media-library-unsplash-settings')) . '">' . esc_html__('Settings', 'media-library-unsplash') . '</a>'
		];
		return array_merge($plugin_links, $links);
	}

	public function tcbdaml_image_callback() {
		check_ajax_referer('tcbdaml_image_upload_nonce', 'nonce');
	
		$image_url = sanitize_url($_POST['image']);
		$filename = sanitize_file_name($_POST['name']).'.jpg';
		$title = sanitize_text_field($_POST['title']);
		$alt = sanitize_text_field($_POST['alt']);
		$caption = wp_kses_post($_POST['caption']);
	
		if (filter_var($image_url, FILTER_VALIDATE_URL)) {
			
			global $wp_filesystem;
			include_once ABSPATH . 'wp-admin/includes/file.php';
			WP_Filesystem();
			
			$image_data = wp_remote_get($image_url);
			$upload_dir = wp_upload_dir();
	
			$image_content = wp_remote_retrieve_body($image_data);
	
			$file = $upload_dir['path'] . '/' . $filename;
			$wp_filesystem->put_contents($file, $image_content, FS_CHMOD_FILE);
	
			$wp_filetype = wp_check_filetype($filename, null);
	
			$attachment = array(
				'guid' => $upload_dir['url'] . '/' . basename($file),
				'post_mime_type' => 'image/jpeg',
				'post_title' => $title,
				'post_excerpt' => $caption,
				'post_status' => 'inherit'
			);
	
			$attach_id = wp_insert_attachment($attachment, $file, $post_id);
	
			require_once(ABSPATH . 'wp-admin/includes/image.php');
	
			$attach_data = wp_generate_attachment_metadata($attach_id, $file);
			wp_update_attachment_metadata($attach_id, $attach_data);
	
			if($alt === "null") { $alt = ''; }
			update_post_meta($attach_id, '_wp_attachment_image_alt', $alt);
	
			wp_send_json("success");
			return $attach_id;
		}
		wp_send_json("failed");
		return false;
	}
}

/**
 * The main function responsible for returning the one true MediaLibraryUnsplash Instance.
 *
 * @author tCoderBD <touhid@tcoderbd.com>
 * @since 1.0.0
 */
function tcbdaml_unsplash_media_library_images() {
	global $tcbdaml_unsplash_media_library_images;
	if ( ! isset( $tcbdaml_unsplash_media_library_images ) ) {
		$tcbdaml_unsplash_media_library_images = new TCBDAML_MediaLibraryUnsplash();
	}
	return $tcbdaml_unsplash_media_library_images;
}

tcbdaml_unsplash_media_library_images();