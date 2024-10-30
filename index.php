<?php /*
Plugin Name: Change Background Color for Pages, Posts, Widgets
Description: Change the backgrounds colours globally or for a specific page.
Version: 1.0
Author: Andybruce11
Author URI: https://allcatering.ca/
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
/*

/**
 * Main Class - CPA stands for Color Picker API
 */
class BCPCPA_Theme_Options {
 
    /*--------------------------------------------*
     * Attributes
     *--------------------------------------------*/
 
    /** Refers to a single instance of this class. */
    private static $instance = null;
    
    /* Saved options */
    public $options;
 
    /*--------------------------------------------*
     * Constructor
     *--------------------------------------------*/
 
    /**
     * Creates or returns an instance of this class.
     *
     * @return  BCPCPA_Theme_Options A single instance of this class.
     */
    public static function get_instance() {
 
        if ( null == self::$instance ) {
            self::$instance = new self;
        }
 
        return self::$instance;
 
    } // end get_instance;
 
    /**
     * Initializes the plugin by setting localization, filters, and administration functions.
     */
    private function __construct() {
	// Add the page to the admin menu
	add_action( 'admin_menu', array( &$this, 'bcp_add_page' ) );
	
	// Register page options
	add_action( 'admin_init', array( &$this, 'bcp_register_page_options') );
	
	// Css rules for Color Picker
	wp_enqueue_style( 'wp-color-picker' );
	
	// Register javascript
	add_action('admin_enqueue_scripts', array( $this, 'bcp_enqueue_admin_js' ) );

	}
 
    /*--------------------------------------------*
     * Functions
     *--------------------------------------------*/
     
    /**
     * Function that will add the options page under Setting Menu.
     */
    public function bcp_add_page() { 
	// $page_title, $menu_title, $capability, $menu_slug, $callback_function
	add_menu_page( 'Background Color', 'Background Color', 'administrator', 'bcp-background-color-picker', array( $this, 'bcp_display_page' ) );
	add_action('admin_init', 'bcp_page_post_color_picker_settings');
	}
    
	
    /**
     * Function that will display the options page.
     */
	public function bcp_display_page() {  ?>
	<div class="wrap">
		<h1><?php _e('Change Background Colors', 'bcp-background-color-picker'); ?></h1>
		<hr />
        <form action="options.php" method="post" role="form">
		
			<?php settings_fields( 'bcp-background-color-picker' ); ?>
			<?php do_settings_sections( 'bcp-background-color-picker' ); ?>
	
			<!-- ------------------- Site Title Font Size ------------------ -->							
			<div class="form-group">
				<h1>Pages</h1>
				<label><h2><?php _e('Body Background Color', 'bcp-background-color-picker'); ?>:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <input type="text" name="page_body_background_color_picker" value="<?php if (esc_html(get_option( 'page_body_background_color_picker'))) : echo esc_html(get_option( 'page_body_background_color_picker')); endif; ?>" class="bcp-color-picker" ></h2></label>
				<label><h2><?php _e('Content Background Color', 'bcp-background-color-picker'); ?>:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <input type="text" name="page_content_background_color_picker" value="<?php if (esc_html(get_option( 'page_content_background_color_picker'))) : echo esc_html(get_option( 'page_content_background_color_picker')); endif; ?>" class="bcp-color-picker" >
				</h2><p>You can also change the background for a <br />specific page in the page itself</p></label>
				
				
			</div>
			<hr />
			<div class="form-group">
				<h1>Posts</h1>
				<label><h2><?php _e('Body Background Color', 'bcp-background-color-picker'); ?>:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <input type="text" name="post_body_background_color_picker" value="<?php if (esc_html(get_option( 'post_body_background_color_picker'))) : echo esc_html(get_option( 'post_body_background_color_picker')); endif; ?>" class="bcp-color-picker" ></h2></label>
				<label><h2><?php _e('Content Background Color', 'bcp-background-color-picker'); ?>:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <input type="text" name="post_content_background_color_picker" value="<?php if (esc_html(get_option( 'post_content_background_color_picker'))) : echo esc_html(get_option( 'post_content_background_color_picker')); endif; ?>" class="bcp-color-picker" >
				</h2><p>You can also change the background for a <br />specific post in the post itself</p></label>
				
				
			</div>
			<hr />
			<div class="form-group">
				<label><h2><?php _e('Widgets Area Background Color', 'bcp-background-color-picker'); ?>:&nbsp&nbsp&nbsp&nbsp<input type="text" name="widgets_background_color_picker" value="<?php if (esc_html(get_option( 'widgets_background_color_picker'))) : echo esc_html(get_option( 'widgets_background_color_picker')); endif; ?>" class="bcp-color-picker" ></h2></label>
				
				
			</div>
			<hr />
			<h3>Important Note: <h3>
                        <p>You might need to clear your cache if you changed the color and you didnt notice any changes</p>
			<?php submit_button(); ?>
			
		</form>	
	</div>
	<?php	
	}
      
    /**
     * Function that will register admin page options.
     */
    public function bcp_register_page_options() { 

	register_setting('bcp-background-color-picker', 'page_body_background_color_picker');
	register_setting('bcp-background-color-picker', 'page_content_background_color_picker');
	register_setting('bcp-background-color-picker', 'post_body_background_color_picker');
	register_setting('bcp-background-color-picker', 'post_content_background_color_picker');
	register_setting('bcp-background-color-picker', 'widgets_background_color_picker');
	
	}
    
    /**
     * Function that will add javascript file for Color Piker.
     */
    public function bcp_enqueue_admin_js() { // Make sure to add the wp-color-picker dependecy to js file
	wp_enqueue_script( 'bcp_custom_js', plugins_url( 'assets/js/jquery.custom.js', __FILE__ ), array( 'jquery', 'wp-color-picker' ), '', true  ); }
    
   
} // end class
 
BCPCPA_Theme_Options::get_instance();

function bcp_page_post_color_picker_settings() {
    class BCP_Post_Colors_Metabox {

	public function __construct() {

		if ( is_admin() ) {
			add_action( 'load-post.php',     array( $this, 'init_metabox' ) );
			add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
		}

	}

	public function init_metabox() {

		add_action( 'add_meta_boxes',        array( $this, 'bcp_add_metabox' )         );
		add_action( 'save_post',             array( $this, 'bcp_save_metabox' ), 10, 2 );
		add_action( 'admin_enqueue_scripts', array( $this, 'bcp_load_scripts_styles')  );
		add_action( 'admin_footer',          array( $this, 'bcp_color_field_js' )      );

	}

	public function bcp_add_metabox() {

		$screens = array( 'post', 'page' );

		foreach ( $screens as $screen ) {

			add_meta_box(
				'post_colors',
				__( 'Background Colors', 'bcp-colors' ),
				array( $this, 'bcp_render_metabox' ),
				$screen, "side", "default", null
			);
		}

	}

	public function bcp_render_metabox( $post ) {

		// Add nonce for security and authentication.
		wp_nonce_field( 'gwp_pc_nonce_action', 'gwp_pc_nonce' );

		// Retrieve an existing value from the database.
		$body_background_color = get_post_meta( $post->ID, 'body_background_color', true );
		$content_background_color = get_post_meta( $post->ID, 'content_background_color', true );

		// Set default values.
		if( empty( $body_background_color ) ) $background_color = '';
		if( empty( $content_background_color ) ) $content_background_color = '';

		// Form fields.
		echo '<table class="form-table">';

		echo '	<tr>';
		echo '		<th><label for="body_background_color" class="background_color_label">' . __( 'Body Background', 'bcp-colors' ) . '</label></th>';
		echo '	</tr><tr>';
		echo '		<td>';
		echo '			<input type="text" name="body_background_color" class="background_color" placeholder="' . esc_attr__( '', 'bcp-colors' ) . '" value="' . esc_attr__( $body_background_color ) . '">';
		//echo '			<p class="description">' . __( 'Select background color', 'bcp-colors' ) . '</p>';
		echo '		</td>';
		echo '	</tr>';
		echo '	<tr>';
		echo '		<th><label for="background_color" class="background_color_label">' . __( 'Content Background', 'bcp-colors' ) . '</label></th>';
		echo '	</tr><tr>';
		echo '		<td>';
		echo '			<input type="text" name="content_background_color" class="background_color" placeholder="' . esc_attr__( '', 'bcp-colors' ) . '" value="' . esc_attr__( $content_background_color ) . '">';
		echo '		</td>';
		echo '	</tr>';

		echo '</table>
		
		<p class="description">' . __( 'You can also change the colours for all pages/posts in the plugin settings page', 'bcp-colors' ) . '</p>';

	}

	public function bcp_save_metabox( $post_id, $post ) {

		// Add nonce for security and authentication.
		$nonce_name   = isset( $_POST['gwp_pc_nonce'] ) ? $_POST['gwp_pc_nonce'] : '';
		$nonce_action = 'gwp_pc_nonce_action';

		// Check if a nonce is set.
		if ( ! isset( $nonce_name ) )
			return;

		// Check if a nonce is valid.
		if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) )
			return;

		// Check if the user has permissions to save data.
		if ( ! current_user_can( 'edit_post', $post_id ) )
			return;

		// Check if it's not an autosave.
		if ( wp_is_post_autosave( $post_id ) )
			return;

		// Check if it's not a revision.
		if ( wp_is_post_revision( $post_id ) )
			return;

		// Sanitize user input.
		//$body_background_color = isset( $_POST[ 'body_background_color' ] ) ? sanitize_text_field( $_POST[ 'body_background_color' ] ) : '';
		$body_background_color = isset( $_POST[ 'body_background_color' ] ) ? sanitize_hex_color( $_POST[ 'body_background_color' ] ) : '';
		$content_background_color = isset( $_POST[ 'content_background_color' ] ) ? sanitize_hex_color( $_POST[ 'content_background_color' ] ) : '';
		
		// Update the meta field in the database.
		update_post_meta( $post_id, 'body_background_color', $body_background_color );
		update_post_meta( $post_id, 'content_background_color', $content_background_color );

	}

	public function bcp_load_scripts_styles() {
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_style( 'wp-color-picker' );

	}

	public function bcp_color_field_js() {

		// Print js only once per page
		if ( did_action( 'BCP_Post_Colors_Metabox_color_picker_js' ) >= 1 ) {
			return;
		}

		?>
		<script type="text/javascript">
			jQuery(document).ready(function($){
				$('.background_color').wpColorPicker();
				//$('#gwp_pc_secondary_color').wpColorPicker();
			});
		</script>
		<?php
		do_action( 'BCP_Post_Colors_Metabox_color_picker_js', $this );

	}

}

new BCP_Post_Colors_Metabox;
}


function bcp_action_wp_head() {
	// if we're not on a "Post" or page
	if ( ! is_singular( 'post' ) &&  ! is_singular( 'page' ))
		return;

	// include file with color sanitization functions
	if ( ! function_exists( 'sanitize_hex_color' ) ) {
	    include_once ABSPATH . 'wp-includes/class-wp-customize-manager.php';
	}

	// fetch and sanitize the colors
	$body_background_color   = sanitize_hex_color( get_post_meta( get_the_id(), 'body_background_color',  true ) );
	$content_background_color   = sanitize_hex_color( get_post_meta( get_the_id(), 'content_background_color',   true ) );

	// check if either is empty, then do not display at all
	
	//Body Background Colors
	if ( empty( $body_background_color ) ){
		if (is_singular( 'post' )){
			$body_background_color_picker   = get_option( 'post_body_background_color_picker');
		} else if (is_singular( 'page' )) {
			$body_background_color_picker   = get_option( 'page_body_background_color_picker');
		}
		if (!empty( $body_background_color_picker ) ){
			?>
			<script>
				document.getElementsByTagName("body")[0].style.backgroundColor = "<?php echo esc_attr($body_background_color_picker); ?>";
			</script>
			<?php
		}
	} else {
			?>
			<script>
				document.getElementsByTagName("body")[0].style.backgroundColor = "<?php echo esc_attr($body_background_color); ?>";
			</script>
			<?php
	}
	
	
	
	// Content Background Colors 
	if ( empty( $content_background_color ) ){
		if (is_singular( 'post' )){
			$content_background_color_picker   = get_option( 'post_content_background_color_picker');
		} else if (is_singular( 'page' )) {
			$content_background_color_picker   = get_option( 'page_content_background_color_picker');
		}
		if (!empty( $content_background_color_picker ) ){
			?>
			<script>
			typepage = document.getElementsByClassName("type-page");
			for (i = 0; i < typepage.length; ++i){
			   document.getElementsByClassName("type-page")[i].style.backgroundColor = "<?php echo esc_attr($content_background_color_picker); ?>";
			}
			
			typepost = document.getElementsByClassName("type-post");
			for (i = 0; i < typepost.length; ++i){
			   document.getElementsByClassName("type-post")[i].style.backgroundColor = "<?php echo esc_attr($content_background_color_picker); ?>";
			}
			
				
			</script>
			<?php
		}
	} else {
		?>
		<script>
			typepage = document.getElementsByClassName("type-page");
			for (i = 0; i < typepage.length; ++i){
			   document.getElementsByClassName("type-page")[i].style.backgroundColor = "<?php echo esc_attr($content_background_color); ?>";
			}
			
			typepost = document.getElementsByClassName("type-post");
			for (i = 0; i < typepost.length; ++i){
			   document.getElementsByClassName("type-post")[i].style.backgroundColor = "<?php echo esc_attr($content_background_color); ?>";
			}
		</script>
		<?php
	}
	
	//Widgets Area Background Color
	$widgets_background_color_picker   = get_option( 'widgets_background_color_picker');
	if (!empty( $widgets_background_color_picker ) ){
		?>
		<script>
			widgetarea = document.getElementsByClassName("widget-area");
			for (i = 0; i < widgetarea.length; ++i){
			   document.getElementsByClassName("widget-area")[i].style.backgroundColor = "<?php echo esc_attr($widgets_background_color_picker); ?>";
			}
			
		</script>
		<?php
	}
			
	
}
add_action( 'wp_footer', 'bcp_action_wp_head' );//includes/class-wp-customize-manager.php';

register_activation_hook(__FILE__, 'my_plugin_activate');



function my_plugin_activate() {
    add_option('my_plugin_do_activation_redirect', true);
}
add_action('admin_init', 'my_plugin_redirect');
function my_plugin_redirect() {
    if (get_option('my_plugin_do_activation_redirect', false)) {
        delete_option('my_plugin_do_activation_redirect');
        wp_redirect(get_site_url()."/wp-admin/admin.php?page=bcp-background-color-picker");
    }
}