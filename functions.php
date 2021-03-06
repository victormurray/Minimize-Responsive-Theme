<?php
/**
 *
 * WARNING: Please do not edit this file.
 * @see http://codex.wordpress.org/Child_Themes
 *
 * Load the theme function files (options panel, theme functions, widgets, etc...).
 */

include_once get_template_directory() . '/includes/Minimize.php'; // Minimize Class (main functionality, actions/filters)

include_once get_template_directory() . '/includes/class-tgm-plugin-activation.php'; // TGM Activation

include_once get_template_directory() . '/includes/theme-options.php'; // SDS Theme Options
include_once get_template_directory() . '/includes/theme-functions.php'; // SDS Theme Options Functions
include_once get_template_directory() . '/includes/class-customize-us-control.php'; // Customize Controller
include_once get_template_directory() . '/includes/widget-social-media.php'; // SDS Social Media Widget


/**
 * ---------------
 * Theme Specifics
 * ---------------
 */

/**
 * This function registers all color schemes available in this theme.
 */
if ( ! function_exists( 'sds_color_schemes' ) ) {
	function sds_color_schemes() {
		$color_schemes = array(
			'default' => array( // Name used in saved option
				'label' => __( 'Default', 'minimize' ), // Label on options panel (required)
				'stylesheet' => false, // Stylesheet URL, relative to theme directory (required)
				'preview' => '#565656', // Preview color on options panel (required)
				'content_color' => '#555555', // Default content color (required)
				'default' => true
			),
			'slocum-blue' => array(
				'label' => __( 'Slocum Blue', 'minimize' ),
				'stylesheet' => '/css/slocum-blue.css',
				'preview' => '#3c639a',
				'content_color' => '#555555',
				'deps' => 'minimize'
			)
		);

		return apply_filters( 'sds_theme_options_color_schemes', $color_schemes );
	}
}

/**
 * This function registers all web fonts available in this theme.
 */
if ( ! function_exists( 'sds_web_fonts' ) ) {
	function sds_web_fonts() {
		$web_fonts = array(
			// Average Sans
			'Lato:400' => array(
				'label' => 'Lato',
				'css' => 'font-family: \'Lato\', sans-serif;'
			)
		);

		return apply_filters( 'sds_theme_options_web_fonts', $web_fonts );
	}
}

/**
 * This function registers all content layouts available in this theme.
 */
if ( ! function_exists( 'sds_content_layouts' ) ) {
	function sds_content_layouts() {
		$content_layouts = array(
			'default' => array( // Name used in saved option
				'label' => __( 'Default', 'minimize' ), // Label on options panel (required)
				'preview' => '<div class="cols cols-1 cols-default"><div class="col col-content" title="%1$s"><span class="label">%1$s</span></div></div>', // Preview on options panel (required; %1$s is replaced with values below on options panel if specified)
				'preview_values' => array( __( 'Default', 'minimize' ) ),
				'default' => true
			),
			'cols-1' => array( // Full Width
				'label' => __( 'Full Width', 'minimize' ),
				'preview' => '<div class="cols cols-1"><div class="col col-content"></div></div>',
			),
			'cols-2' => array( // Content Left, Primary Sidebar Right
				'label' => __( 'Content Left', 'minimize' ),
				'preview' => '<div class="cols cols-2"><div class="col col-content"></div><div class="col col-sidebar"></div></div>'
			),
			'cols-2-r' => array( // Content Right, Primary Sidebar Left
				'label' => __( 'Content Right', 'minimize' ),
				'preview' => '<div class="cols cols-2 cols-2-r"><div class="col col-sidebar"></div><div class="col col-content"></div></div>'
			),
			'cols-3' => array( // Content Left, Primary Sidebar Middle, Secondary Sidebar Right
				'label' => __( 'Content, Sidebar, Sidebar', 'minimize' ),
				'preview' => '<div class="cols-3"><div class="col col-content"></div><div class="col col-sidebar"></div><div class="col col-sidebar col-sidebar-secondary"></div></div>'
			),
			'cols-3-m' => array( // Primary Sidebar Left, Content Middle, Secondary Sidebar Right
				'label' => __( 'Sidebar, Content, Sidebar', 'minimize' ),
				'preview' => '<div class="cols cols-3 cols-3-m"><div class="col col-sidebar"></div><div class="col col-content"></div><div class="col col-sidebar col-sidebar-secondary"></div></div>'
			),
			'cols-3-r' => array( // Primary Sidebar Left, Secondary Sidebar Middle, Content Right
				'label' => __( 'Sidebar, Sidebar, Content', 'minimize' ),
				'preview' => '<div class="cols cols-3 cols-3-r"><div class="col col-sidebar"></div><div class="col col-sidebar col-sidebar-secondary"></div><div class="col col-content"></div></div>'
			)
		);

		return apply_filters( 'sds_theme_options_content_layouts', $content_layouts );
	}
}

/**
 * This function sets a default featured image size for use in this theme.
 */
if ( ! function_exists( 'sds_theme_options_default_featured_image_size' ) ) {
	add_filter( 'sds_theme_options_default_featured_image_size', 'sds_theme_options_default_featured_image_size' );

	function sds_theme_options_default_featured_image_size( $default ) {
		return 'min-725x400';
	}
}

/**
 * This function modifies the featured image size output based on content layout settings.
 */
if ( ! function_exists( 'sds_featured_image_size' ) ) {
	add_filter( 'sds_featured_image_size', 'sds_featured_image_size', 10, 2 );

	function sds_featured_image_size( $size, $link_image ) {
		global $sds_theme_options;

		// Content layout was specified by user in Theme Options
		if ( isset( $sds_theme_options['body_class'] ) && ! empty( $sds_theme_options['body_class'] ) ) {
			if ( $sds_theme_options['body_class'] === 'cols-1' )
				$size = 'min-1100x400'; // Full width image
		}
		return $size;
	}
}

/**
 * This function modifies the global $content_width value based on content layout or page template settings.
 */
if ( ! function_exists( 'min_body_class' ) ) {
	add_filter( 'body_class', 'min_body_class', 20 );

	function min_body_class( $classes ) {
		global $sds_theme_options, $content_width;

		// Content layout was specified by user in Theme Options
		if ( isset( $sds_theme_options['body_class'] ) && ! empty( $sds_theme_options['body_class'] ) ) {
			// 1 Column
			if ( $sds_theme_options['body_class'] === 'cols-1' )
				$content_width = 1100;
			// 3 Columns
			else if ( strpos( $sds_theme_options['body_class'], 'cols-3' ) !== false )
				$content_width = 550;
		}

		// Page Template was specified by the user for this page
		if ( ! empty( $sds_theme_options['page_template'] ) && $sds_theme_options['page_template'] !== 'default' ) {
			// Full Width or Landing Page
			if( in_array( $sds_theme_options['page_template'], array( 'page-full-width.php', 'page-landing-page.php' ) ) )
				$content_width = 1100;
		}

		return $classes;
	}
}

/**
 * This function adds the custom Theme Customizer styles to the <head> tag.
 */
if ( ! function_exists( 'min_wp_head' ) ) {
	add_filter( 'wp_head', 'min_wp_head', 20 );

	function min_wp_head() {
		$sds_theme_options_instance = SDS_Theme_Options_Instance();
	?>
		<style type="text/css" id="<?php echo $sds_theme_options_instance->get_parent_theme()->get_template(); ?>-theme-customizer">
			/* Content Color */
			article.content, footer.post-footer, #post-author {
				color: <?php echo get_theme_mod( 'content_color' ); ?>;
			}
		</style>
	<?php
	}
}

if ( ! function_exists( 'sds_theme_options_ads' ) ) {
	add_action( 'sds_theme_options_ads', 'sds_theme_options_ads' );

	function sds_theme_options_ads() {
	?>
		<div class="sds-theme-options-ad">
			<a href="<?php echo esc_url( sds_get_pro_link( 'theme-options-ad' ) ); ?>" target="_blank" class="sds-theme-options-upgrade-ad">
				<h3><?php _e( 'Upgrade to Minimize Pro!', 'minimize' ); ?></h3>
				<ul>
					<li><?php _e( 'Priority Ticketing Support', 'minimize' ); ?></li>
					<li><?php _e( 'More Color Schemes', 'minimize' ); ?></li>
					<li><?php _e( 'Web Fonts', 'minimize' ); ?></li>
					<li><?php _e( 'Adjust Featured Image Sizes', 'minimize' ); ?></li>
					<li><?php _e( 'Easily Add Custom Scripts/Styles', 'minimize' ); ?></li>
					<li><?php _e( 'and More!', 'minimize' ); ?></li>
				</ul>

				<span class="sds-theme-options-btn-green"><?php _e( 'Upgrade Now!', 'minimize' ); ?></span>
			</a>
		</div>
	<?php
	}
}

if ( ! function_exists( 'sds_theme_options_upgrade_cta' ) ) {
	add_action( 'sds_theme_options_upgrade_cta', 'sds_theme_options_upgrade_cta' );

	function sds_theme_options_upgrade_cta( $type ) {
		switch( $type ) :
			case 'color-schemes':
		?>
				<p>
					<?php
						printf( '<a href="%1$s" target="_blank">%2$s</a> %3$s',
							esc_url( sds_get_pro_link( 'theme-options-colors' ) ),
							__( 'Upgrade to Minimize Pro', 'minimize' ),
							__( 'and receive more color schemes!', 'minimize' )
						);
					?>
				</p>
		<?php
			break;
			case 'web-fonts':
		?>
				<p>
					<?php
						printf( '<a href="%1$s" target="_blank">%2$s</a> %3$s',
							esc_url( sds_get_pro_link( 'theme-options-fonts' ) ),
							__( 'Upgrade to Minimize Pro', 'minimize' ),
							__( 'to use more web fonts!', 'minimize' )
						);
					?>
				</p>
		<?php
			break;
			case 'help-support':
				?>
				<p>
					<?php
						printf( '<a href="%1$s" target="_blank">%2$s</a> %3$s',
							esc_url( sds_get_pro_link( 'theme-options-help' ) ),
							__( 'Upgrade to Minimize Pro', 'minimize' ),
							__( 'to receive priority ticketing support!', 'minimize' )
						);
					?>
				</p>
		<?php
			break;
		endswitch;
	}
}

function sds_get_pro_link( $content ) {
	return esc_url( 'https://slocumthemes.com/wordpress-themes/minimize-pro/?utm_source=minimize&utm_medium=link&utm_content=' . urlencode( sanitize_title_with_dashes( $content ) ) . '&utm_campaign=pro#purchase-theme' );
}

if ( ! function_exists( 'sds_theme_options_help_support_tab_content' ) ) {
	add_action( 'sds_theme_options_help_support_tab_content', 'sds_theme_options_help_support_tab_content' );

	function sds_theme_options_help_support_tab_content( ) {
	?>
		<p><?php printf( __( 'If you\'d like to create a support request, please visit the <a href="%1$s">Minimize Forums on WordPress.org</a>.', 'minimize' ), esc_url( 'http://wordpress.org/support/theme/minimize/' ) ); ?></p>
	<?php
	}
}

if ( ! function_exists( 'sds_copyright_branding' ) ) {
	add_filter( 'sds_copyright_branding', 'sds_copyright_branding', 10, 2 );

	function sds_copyright_branding( $text, $theme_name ) {
		return sprintf( __( '<a href="%1$s">%2$s by Slocum Studio</a>', 'minimize' ), esc_url( 'http://slocumthemes.com/wordpress-themes/minimize-free/' ), $theme_name );
	}
}