<?php
/**
 * xMag Customizer functionality
 *
 * @package xMag
 * @since xMag 1.0
 */


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function xmag_customize_preview_js() {
	wp_enqueue_script( 'xmag_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20171003', true );
}
add_action( 'customize_preview_init', 'xmag_customize_preview_js' );


/**
 * Custom Classes
 */
if ( class_exists( 'WP_Customize_Control' ) ) {

	class Xmag_Important_Links extends WP_Customize_Control {

    	public $type = "xmag-important-links";
	
		public function render_content() {
        $important_links = array(
	        'upgrade' => array(
			'link' => esc_url('https://www.designlabthemes.com/xmag-plus-wordpress-theme/?utm_source=wordpress&utm_campaign=xmag&utm_content=customizer_link'),
			'text' => __('Try xMag Plus', 'xmag'),
			),
			'theme' => array(
			'link' => esc_url('https://www.designlabthemes.com/xmag-wordpress-theme/'),
			'text' => __('Theme Homepage', 'xmag'),
			),
	        'documentation' => array(
			'link' => esc_url('https://www.designlabthemes.com/xmag-documentation/'),
			'text' => __('Theme Documentation', 'xmag'),
			),
			'rating' => array(
			'link' => esc_url('https://wordpress.org/support/theme/xmag/reviews/#new-post'),
			'text' => __('Rate This Theme', 'xmag'),
			),
			'twitter' => array(
			'link' => esc_url('https://twitter.com/designlabthemes'),
			'text' => __('Follow on Twitter', 'xmag'),
			)
        );
        foreach ($important_links as $important_link) {
        	echo '<p><a class="button" target="_blank" href="' . esc_url( $important_link['link'] ). '" >' . esc_html($important_link['text']) . ' </a></p>';
        	}
    	}
	}

}


/**
 * Theme Settings
 */
function xmag_theme_customizer( $wp_customize ) {
	
	// Add postMessage support for site title and description for the Theme Customizer
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	
	// Change Controls Priority
	$wp_customize->get_control( 'background_color' )->priority  = 2;
	$wp_customize->get_control( 'header_textcolor' )->priority  = 4;
	
	// Rename the label to "Site Title"
	$wp_customize->get_control( 'header_textcolor' )->label = __( 'Site Title', 'xmag' );
	
	// xMag Links
	$wp_customize->add_section('xmag_links_section', array(
	  'priority' => 2,
	  'title' => __('xMag Links', 'xmag'),
	) );
	
	$wp_customize->add_setting('xmag_links', array(
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'esc_url_raw',
	) );
	
	$wp_customize->add_control(new Xmag_Important_Links($wp_customize, 'xmag_links', array(
	  'section' => 'xmag_links_section',
	) ) );
	
	// Theme Settings
	$wp_customize->add_panel( 'xmag_panel', array(
    	'title' => __( 'Theme Settings', 'xmag' ),
		'priority' => 10,
	) );
	
	// General Section
	$wp_customize->add_section( 'xmag_general_section', array(
		'title'       => __( 'General', 'xmag' ),
		'priority'    => 5,
		'panel' => 'xmag_panel',
		'description'	=> __( 'General Settings.', 'xmag' ),
	) );
	
	// Layout Style
	$wp_customize->add_setting( 'xmag_layout_style', array(
        'default' => 'site-fullwidth',
        'type' => 'option',
		'capability' => 'edit_theme_options',
        'sanitize_callback' => 'xmag_sanitize_choices',
    ) );
   	   	
	$wp_customize->add_control( 'xmag_layout_style', array(
	    'label'    => __( 'Layout Style', 'xmag' ),
	    'section'  => 'xmag_general_section',
	    'priority' => 1,
	    'type'     => 'select',
		'choices'  => array(
			'site-fullwidth' => __('Full Width', 'xmag'),
			'site-boxed' => __('Boxed', 'xmag'),
	) ) );
	
	// Widget Styles
	$wp_customize->add_setting( 'xmag_widget_style', array(
        'default' => 'grey',
        'sanitize_callback' => 'xmag_sanitize_choices',
    ) );
   	   	
	$wp_customize->add_control( 'xmag_widget_style', array(
	    'label'    => __( 'Widgets Style', 'xmag' ),
	    'section'  => 'xmag_general_section',
	    'type'     => 'select',
		'choices'  => array(
			'grey' => __('Grey', 'xmag'),
			'white' => __('White', 'xmag'),
			'minimal' => __('Minimal', 'xmag'),
	) ) );
	
	// Read More
	$wp_customize->add_setting( 'xmag_read_more', array(
        'default' => '',
        'sanitize_callback' => 'xmag_sanitize_checkbox',
    ) );
   	
	$wp_customize->add_control( 'xmag_read_more', array(
	    'label'    => __( 'Display Read More Link', 'xmag' ),
	    'section'  => 'xmag_general_section',
	    'type'     => 'checkbox',
	) );
	
	// Header Section
	$wp_customize->add_section( 'xmag_header_section', array(
		'title'       => __( 'Header', 'xmag' ),
		'priority'    => 15,
		'panel' => 'xmag_panel',
	) );
	
	// Main Menu Style
	$wp_customize->add_setting( 'xmag_menu_style', array(
        'default' => 'dark',
        'sanitize_callback' => 'xmag_sanitize_choices',
    ) );
   	   	
	$wp_customize->add_control( 'xmag_menu_style', array(
	    'label'    => __( 'Main Menu Style', 'xmag' ),
	    'section'  => 'xmag_header_section',
	    'type'     => 'select',
		'choices'  => array(
			'dark' => __('Dark', 'xmag'),
			'light' => __('Light', 'xmag'),
			'custom' => __('Custom Background', 'xmag'),
		),
	) );
	
	// Main Menu Background
	$wp_customize->add_setting( 'main_menu_background', array(
		'default' => '#e54e53',
		'type' => 'option', 
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'main_menu_background', array(
		'description' => __( 'Set a custom background for the Main Menu', 'xmag' ),
		'section'  => 'xmag_header_section',
		'active_callback' => 'xmag_has_custom_menu',
	) ) );
	
	// Sticky Menu
	$wp_customize->add_setting( 'xmag_sticky_menu', array(
        'default' => '',
        'sanitize_callback' => 'xmag_sanitize_checkbox',
    ) );
   	
	$wp_customize->add_control( 'xmag_sticky_menu', array(
	    'label'    => __( 'Sticky Main Menu', 'xmag' ),
	    'section'  => 'xmag_header_section',
	    'type'     => 'checkbox',
	) );
	
	// Home Icon
	$wp_customize->add_setting( 'xmag_home_icon', array(
        'default' => 1,
        'sanitize_callback' => 'xmag_sanitize_checkbox',
    ) );
   	
	$wp_customize->add_control( 'xmag_home_icon', array(
	    'label'    => __( 'Display the Home icon in the Main Menu', 'xmag' ),
	    'section'  => 'xmag_header_section',
	    'type'     => 'checkbox',
	) );
	
	// Search Form
	$wp_customize->add_setting( 'xmag_show_search', array(
        'default' => 1,
        'sanitize_callback' => 'xmag_sanitize_checkbox',
    ) );
   	
	$wp_customize->add_control( 'xmag_show_search', array(
	    'label'    => __( 'Display Search Form in the Top Menu', 'xmag' ),
	    'section'  => 'xmag_header_section',
	    'type'     => 'checkbox',
	) );
	
	// Header Image Custom Width
	$wp_customize->add_setting( 'xmag_header_image_width', array(
        'default' => 1920,
        'sanitize_callback' => 'absint',
    ) );
	
	$wp_customize->add_control( 'xmag_header_image_width', array(
	    'label'    => __( 'Header Image', 'xmag' ),
	    'description' => __( 'Width (If you change the size you have to add a new image)', 'xmag' ),
	    'section'  => 'xmag_header_section',
	    'type'     => 'number',
	) );
	
	// Header Image Custom Height
	$wp_customize->add_setting( 'xmag_header_image_height', array(
        'default' => 360,
        'sanitize_callback' => 'absint',
    ) );
	
	$wp_customize->add_control( 'xmag_header_image_height', array(
	    'description' => __( 'Height (If you change the size you have to add a new image)', 'xmag' ),
	    'section'  => 'xmag_header_section',
	    'type'     => 'number',
	) );
	
	// Display Header Image on Mobile
	$wp_customize->add_setting( 'show_header_image', array(
        'default' => '',
        'sanitize_callback' => 'xmag_sanitize_checkbox',
    ) );
   	
	$wp_customize->add_control( 'show_header_image', array(
	    'label'    => __( 'Display Header Image on Mobile', 'xmag' ),
	    'section'  => 'xmag_header_section',
	    'type'     => 'checkbox',
	) );
	
	// Display Header Image on Front Page only
	$wp_customize->add_setting( 'xmag_show_header_image', array(
        'default' => 1,
        'sanitize_callback' => 'xmag_sanitize_checkbox',
    ) );
   	
	$wp_customize->add_control( 'xmag_show_header_image', array(
	    'label'    => __( 'Display Header Image on Front Page Only', 'xmag' ),
	    'section'  => 'xmag_header_section',
	    'type'     => 'checkbox',
	) );

	// Blog Section
	$wp_customize->add_section( 'xmag_blog_section', array(
		'title'       => __( 'Blog', 'xmag' ),
		'priority'    => 20,
		'panel' => 'xmag_panel',
		'description'	=> __( 'Settings for Blog Homepage.', 'xmag' ),
	) );
	
	// Blog Layout
	$wp_customize->add_setting( 'xmag_blog', array(
        'default' => 'layout2',
        'sanitize_callback' => 'xmag_sanitize_choices',
    ) );
   	   	
	$wp_customize->add_control( 'xmag_blog', array(
	    'label'    => __( 'Blog Layout', 'xmag' ),
	    'section'  => 'xmag_blog_section',
	    'type'     => 'select',
		'choices'  => array(
			'layout1' => __('List: Small Thumbnail + Sidebar', 'xmag'),
			'layout2' => __('List: Medium Thumbnail + Sidebar', 'xmag'),
			'layout3' => __('Classic: Large Posts + Sidebar', 'xmag'),
			'layout11' => __('Full Content Post + Sidebar', 'xmag'),
			),
	) );
	
	// Blog Excerpt Length
	$wp_customize->add_setting( 'xmag_excerpt_size', array(
        'default' => 25,
        'sanitize_callback' => 'absint',
    ) );
	
	$wp_customize->add_control( 'xmag_excerpt_size', array(
	    'label'    => __( 'Excerpt length', 'xmag' ),
	    'section'  => 'xmag_blog_section',
	    'type'     => 'number',
	) );
	
	// Archive Section
	$wp_customize->add_section( 'xmag_archive_section', array(
		'title'       => __( 'Categories and Archives', 'xmag' ),
		'priority'    => 25,
		'panel' => 'xmag_panel',
		'description'	=> __( 'Settings for Category, Tag, Search result, Author and Archive Pages.', 'xmag' ),
	) );
	
	// Archive Layout
	$wp_customize->add_setting( 'xmag_archive', array(
        'default' => 'layout2',
        'sanitize_callback' => 'xmag_sanitize_choices',
    ) );
   	   	
	$wp_customize->add_control( 'xmag_archive', array(
	    'label'    => __( 'Archives Layout', 'xmag' ),
	    'section'  => 'xmag_archive_section',
	    'type'     => 'select',
		'choices'  => array(
			'layout1' => __('Small Thumbnail + Sidebar', 'xmag'),
			'layout2' => __('Medium Thumbnail + Sidebar', 'xmag'),
			'layout3' => __('Classic: Large Posts + Sidebar', 'xmag'),
	) ) );
	
	// Archive Excerpt Length
	$wp_customize->add_setting( 'xmag_archive_excerpt_size', array(
        'default' => 25,
        'sanitize_callback' => 'absint',
    ) );
	
	$wp_customize->add_control( 'xmag_archive_excerpt_size', array(
	    'label'    => __( 'Excerpt length', 'xmag' ),
	    'section'  => 'xmag_archive_section',
	    'type'     => 'number',
	) );
	
	// Single Post Section
	$wp_customize->add_section( 'xmag_post_section', array(
		'title'       => __( 'Single Post', 'xmag' ),
		'priority'    => 30,
		'panel' => 'xmag_panel',
	) );
	
	// Featured Image
	$wp_customize->add_setting( 'xmag_post_featured_image', array(
        'default' => '',
        'sanitize_callback' => 'xmag_sanitize_checkbox',
    ) );
   	
	$wp_customize->add_control( 'xmag_post_featured_image', array(
	    'label'    => __( 'Display Featured Image', 'xmag' ),
	    'section'  => 'xmag_post_section',
	    'type'     => 'checkbox',
	) );
	
	// Featured Image Size
	$wp_customize->add_setting( 'xmag_post_featured_image_size', array(
        'default' => 'default',
        'sanitize_callback' => 'xmag_sanitize_choices',
    ) );
   	   	
	$wp_customize->add_control( 'xmag_post_featured_image_size', array(
	    'description' => __( 'Featured Image Size', 'xmag' ),
	    'section'  => 'xmag_post_section',
	    'type'     => 'radio',
		'choices'  => array(
			'default' => __('Default', 'xmag'),
			'fullwidth' => __('Full Width (images must be at least 1120px)', 'xmag'),
			),
		'active_callback' => 'xmag_post_has_featured_image',
	) );
	
	// Page Section
	$wp_customize->add_section( 'xmag_page_section', array(
		'title'       => __( 'Page', 'xmag' ),
		'priority'    => 35,
		'panel' => 'xmag_panel',
	) );
	
	// Featured Image
	$wp_customize->add_setting( 'xmag_page_featured_image', array(
        'default' => '',
        'sanitize_callback' => 'xmag_sanitize_checkbox',
    ) );
   	
	$wp_customize->add_control( 'xmag_page_featured_image', array(
	    'label'    => __( 'Display Featured Image', 'xmag' ),
	    'section'  => 'xmag_page_section',
	    'type'     => 'checkbox',
	) );
	
	// Featured Image Size
	$wp_customize->add_setting( 'xmag_page_featured_image_size', array(
        'default' => 'default',
        'sanitize_callback' => 'xmag_sanitize_choices',
    ) );
   	   	
	$wp_customize->add_control( 'xmag_page_featured_image_size', array(
	    'label'    => __( 'Featured Image Size', 'xmag' ),
	    'section'  => 'xmag_page_section',
	    'type'     => 'radio',
		'choices'  => array(
			'default' => __('Default', 'xmag'),
			'fullwidth' => __('Full Width (images must be at least 1120px)', 'xmag'),
			),
		'active_callback' => 'xmag_page_has_featured_image',
	) );
	
	// Footer Section
	$wp_customize->add_section( 'xmag_footer_section', array(
		'title'       => __( 'Footer', 'xmag' ),
		'priority'    => 40,
		'panel' => 'xmag_panel',
	) );
	
	// Scroll Up
	$wp_customize->add_setting( 'xmag_scroll_up', array(
        'default' => '',
        'sanitize_callback' => 'xmag_sanitize_checkbox',
    ) );
   	
	$wp_customize->add_control( 'xmag_scroll_up', array(
	    'label'    => __( 'Display Scroll Up button', 'xmag' ),
	    'section'  => 'xmag_footer_section',
	    'type'     => 'checkbox',
	) );

	// Accent Color
	$wp_customize->add_setting( 'accent_color', array(
		'default' => '#e54e53',
		'type' => 'option', 
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'accent_color', array(
		'label' => __( 'Accent Color', 'xmag' ),
		'section' => 'colors',
		'priority' => 2,
	) ) );
	
	// Header Background
	$wp_customize->add_setting( 'header_background', array(
		'default' => '#ffffff',
		'type' => 'option', 
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_background', array(
		'label' => __( 'Header Background', 'xmag' ),
		'section' => 'colors',
		'priority' => 3,
	) ) );
	
	// Site Tagline Color
	$wp_customize->add_setting( 'site_tagline_color', array(
		'default' => '#777777',
		'type' => 'option', 
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'site_tagline_color', array(
		'label' => __( 'Site Tagline', 'xmag' ),
		'section' => 'colors',
		'priority' => 5,
	) ) );
	
	// Footer Background
	$wp_customize->add_setting( 'footer_background', array(
		'default' => '',
		'type' => 'option', 
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_background', array(
		'label' => __( 'Footer Background', 'xmag' ),
		'section' => 'colors',
	) ) );
			
}
add_action('customize_register', 'xmag_theme_customizer');


/**
 * Sanitize Checkbox
 *
 */ 
function xmag_sanitize_checkbox( $input ) {
    if ( $input == 1 ) {
        return 1;
    } else {
        return '';
    }
}


/**
 * Sanitize Radio Buttons and Select Lists
 *
 */
function xmag_sanitize_choices( $input, $setting ) {
    global $wp_customize;
 
    $control = $wp_customize->get_control( $setting->id );
 
    if ( array_key_exists( $input, $control->choices ) ) {
        return $input;
    } else {
        return $setting->default;
    }
}


/**
 * Sanitizes text: only safe HTML tags (the same tags that are allowed in a standard WordPress post)
 *
 */
function xmag_sanitize_text( $input ) {
    return wp_kses_post( $input );
}


/**
 * Strips all of the HTML in the content.
 *
 */ 
function xmag_nohtml_sanitize( $input ) {
    return wp_filter_nohtml_kses( esc_url_raw( $input ) );
}


/**
 * Checks Main Menu Style.
 */
function xmag_has_custom_menu( $control ) {
    if ( $control->manager->get_setting('xmag_menu_style')->value() == 'custom' ) {
		return true;
    } else {
        return false;
    }
}


/**
 * Checks if Post has Featured Image.
 */
function xmag_post_has_featured_image( $control ) {
    if ( $control->manager->get_setting('xmag_post_featured_image')->value() == 1 ) {
		return true;
    } else {
        return false;
    }
}


/**
 * Checks is Page has Featured Image.
 */
function xmag_page_has_featured_image( $control ) {
    if ( $control->manager->get_setting('xmag_page_featured_image')->value() == 1 ) {
		return true;
    } else {
        return false;
    }
}


/**
 * Get Contrast
 *
 */
function xmag_get_brightness($hex) {
 // returns brightness value from 0 to 255
 // strip off any leading #
 $hex = str_replace('#', '', $hex);

 $c_r = hexdec(substr($hex, 0, 2));
 $c_g = hexdec(substr($hex, 2, 2));
 $c_b = hexdec(substr($hex, 4, 2));

 return (($c_r * 299) + ($c_g * 587) + ($c_b * 114)) / 1000;
}


/**
 * Add inline Custom CSS for styles handled by the Theme customizer
 *
 */
function xmag_custom_style() { 
	
	$accent_color = esc_attr( get_option('accent_color') ); 
	$header_background = esc_attr( get_option('header_background') );
	$site_tagline_color = esc_attr( get_option( 'site_tagline_color') );
	$footer_background = esc_attr( get_option('footer_background') );
	$main_menu_background = esc_attr( get_option('main_menu_background') );
	$main_menu_style = get_theme_mod('xmag_menu_style');
	
	$custom_style = "";
	
	// Show Header Image on Mobile
	if ( get_theme_mod( 'show_header_image' ) ) {
		$custom_style .= ".header-image {display: block;}";
	}
		
	// Accent Color
	if ( $accent_color != '' ) {
		$custom_style .= "
		a, .site-title a:hover, .entry-title a:hover,
		.post-navigation .nav-previous a:hover, .post-navigation .nav-previous a:hover span,
		.post-navigation .nav-next a:hover, .post-navigation .nav-next a:hover span,
		.widget a:hover, .block-heading a:hover, .widget_calendar a, .author-social a:hover,
		.top-menu a:hover, .top-menu .current_page_item a, .top-menu .current-menu-item a,
		.nav-previous a:hover span, .nav-next a:hover span, .more-link, .author-social .social-links li a:hover:before { 
	    color: {$accent_color};
	    }
	    button, input[type='button'], input[type='reset'], input[type='submit'],
	    .pagination .nav-links .current, .pagination .nav-links .current:hover, .pagination .nav-links a:hover,
	    .entry-meta .category a, .featured-image .category a, #scroll-up, .large-post .more-link {
		background-color: {$accent_color};
	    }
	    blockquote {
		border-left-color: {$accent_color};
	    }
	    .sidebar .widget-title span:before {
		border-bottom-color: {$accent_color};
	    }";
		if ( xmag_get_brightness($accent_color) > 150) {
	    	$custom_style .= "
			.entry-meta .category a, .featured-image .category a,
			button, input[type='button'], input[type='reset'], input[type='submit'],
			#scroll-up, .search-submit, .large-post .more-link {
			color: rgba(0,0,0,.7);
			} 
			.entry-meta .category a:before {
			background-color: rgba(0,0,0,.7);
			}";
	    }
	}
	
	// Header Background
	if ( $header_background != '' && $header_background != '#ffffff' ) {
		$custom_style .= "
		.site-header {
		background-color: {$header_background};	
		}";
		if ( xmag_get_brightness($header_background) > 150) {
			$custom_style .= "
			.site-title a, .site-description, .top-navigation > ul > li > a {
			color: rgba(0,0,0,.8);
			}
			.site-title a:hover, .top-navigation > ul > li > a:hover {
			color: rgba(0,0,0,.6);
			}";
		} else {
			$custom_style .= "
			.site-title a, .site-description, .top-navigation > ul > li > a {
			color: #fff;
			}
			.site-title a:hover, .top-navigation > ul > li > a:hover {
			color: rgba(255,255,255,0.8);
			}
			.site-header .search-field {
			border: 0;
			}
			.site-header .search-field:focus {
			border: 0;
			background-color: rgba(255,255,255,0.9);
			}";
		}
	}
	
	// Site Tagline Color
	if ( $site_tagline_color != '' ) {
		$custom_style .= ".site-header .site-description {color: {$site_tagline_color};}";
	}
	
	// Footer Background
	if ( $footer_background != '' ) { 
		$custom_style .= "
		.site-footer,
		.site-boxed .site-footer {
		background-color: {$footer_background};
		} ";
		
		if ( xmag_get_brightness($footer_background) > 150) {
			$custom_style .= "
			.site-footer .footer-copy, .site-footer .widget, .site-footer .comment-author-link {
			color: rgba(0,0,0,.4);
			}
			.site-footer .footer-copy a, .site-footer .footer-copy a:hover,
			.site-footer .widget a, .site-footer .widget a:hover,
			.site-footer .comment-author-link a, .site-footer .comment-author-link a:hover {
			color: rgba(0,0,0,.5);
			}
			.site-footer .widget-title, .site-footer .widget caption {
			color: rgba(0,0,0,.6);
			}";
		} else {
		$custom_style .= "
			.site-footer .footer-copy, .site-footer .widget, .site-footer .comment-author-link {
			color: rgba(255,255,255,0.5);
			}
			.site-footer .footer-copy a, .site-footer .footer-copy a:hover,
			.site-footer .widget a, .site-footer .widget a:hover,
			.site-footer .comment-author-link a, .site-footer .comment-author-link a:hover {
			color: rgba(255,255,255,0.7);
			}
			.site-footer .widget-title, .site-footer .widget caption {
			color: #fff;
			}
			.site-footer .widget .tagcloud a {
			background-color: transparent;
			border-color: rgba(255,255,255,.1);
			}
			.footer-copy {
			border-top-color: rgba(255,255,255,.1);
			}";
		}
	}
	
	// Main Menu Custom Background
	if ( $main_menu_background != '' && $main_menu_style == 'custom' ) {
	   	$custom_style .= "
	   	.main-navbar {
		background-color: {$main_menu_background};
		position: relative;
		}
		.mobile-header {
		background-color: {$main_menu_background};
		}
		.main-menu ul {
		background-color: {$main_menu_background};
		}
		.main-menu > li a:hover, .home-link a:hover, .main-menu ul a:hover {
		background-color: rgba(0,0,0,0.05);
		}
		.main-navbar::before {
	    background-color: rgba(0, 0, 0, 0.15);
	    content: '';
	    display: block;
	    height: 4px;
	    position: absolute;
	    top: 0;
	    width: 100%;
		}
		.main-menu > li > a, .home-link a {
		line-height: 24px;
		padding: 12px 12px 10px;
		}";
		if ( xmag_get_brightness($main_menu_background) > 150) {
			$custom_style .= "
			.main-menu > li > a, .main-menu ul a, .home-link a,
			.mobile-header .mobile-title, .mobile-header .menu-toggle {
			color: rgba(0,0,0,.9);
			}
			.home-link a:hover, .main-menu > li > a:hover,
			.main-menu > li.current-menu-item > a, .main-menu > li.current_page_item > a {
			color: rgba(0,0,0,0.6);
			}
			.main-menu ul a:hover,
			.main-menu ul .current-menu-item a,
			.main-menu ul .current_page_item a {
			color: rgba(0,0,0,.9);
			background-color: rgba(0,0,0,.05);
			}
			.mobile-header a {
			color: rgba(0,0,0,.9);
			}
			.button-toggle, .button-toggle:before, .button-toggle:after {
			background-color: rgba(0,0,0,.9);
			} ";
		}
	}
	
	// Main Menu Light
	if ( $main_menu_style == 'light' ) {
		$custom_style .= "
		.main-navbar {
		background-color: #fff;
		border-top: 1px solid #eee;
		border-bottom: 1px solid #eee;
		-webkit-box-shadow: 0 3px 2px 0 rgba(0, 0, 0, 0.03);
		box-shadow: 0 3px 2px 0 rgba(0, 0, 0, 0.03);
		}
		.main-menu > li > a, .home-link a {
		color: #333;
		border-left: 1px solid #f2f2f2;
		}
		.main-menu > li:last-child > a {
		border-right: 1px solid #f2f2f2;
		}
		.home-link a:hover, .main-menu > li > a:hover,
		.main-menu > li.current-menu-item > a,
		.main-menu > li.current_page_item > a{
		background-color: #fff;
		color: {$accent_color};
		}
		.home-link a:hover:before, .main-menu > li:hover:before, .main-menu > li:active:before,
		.main-menu > li.current_page_item:before, .main-menu > li.current-menu-item:before {
		content: '';
		position: absolute;
		bottom: 0;
		left: 0;
		display: block;
		width: 100%;
		height: 2px;
		z-index: 2;
		background-color: {$accent_color};	
		}
		.main-menu ul {
		background-color: #fff;
		border: 1px solid #eee;
		}
		.main-menu ul a {
		border-top: 1px solid #f2f2f2;
		color: #555;
		}
		.main-menu ul a:hover {
		color: {$accent_color};
		}
		.mobile-header {
		background-color: #fff;
		border-bottom: 1px solid #eee;
		-webkit-box-shadow: 0 3px 2px 0 rgba(0, 0, 0, 0.03);
		box-shadow: 0 3px 2px 0 rgba(0, 0, 0, 0.03);
		}
		.mobile-header .mobile-title, 
		.mobile-header .menu-toggle {
		color: #333;
		}
		.button-toggle,
		.button-toggle:before,
		.button-toggle:after {
		background-color: #333;
		} ";
	}
	
	if ( $custom_style != '' ) { 
		wp_add_inline_style( 'xmag-style', $custom_style );
	}
}
add_action( 'wp_enqueue_scripts', 'xmag_custom_style' );
