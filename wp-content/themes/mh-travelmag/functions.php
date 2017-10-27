<?php

/***** Fetch Theme Data *****/

$mh_magazine_lite_data = wp_get_theme('mh-magazine-lite');
$mh_magazine_lite_version = $mh_magazine_lite_data['Version'];
$mh_travelmag_data = wp_get_theme('mh-travelmag');
$mh_travelmag_version = $mh_travelmag_data['Version'];

/***** Load Google Fonts *****/

function mh_travelmag_fonts() {
	wp_dequeue_style('mh-google-fonts');
	wp_enqueue_style('mh-travelmag-fonts', 'https://fonts.googleapis.com/css?family=Asap:400,400italic,700%7cDosis:300,400,600,700', array(), null);
}
add_action('wp_enqueue_scripts', 'mh_travelmag_fonts', 11);

/***** Load Stylesheets *****/

function mh_travelmag_styles() {
	global $mh_magazine_lite_version, $mh_travelmag_version;
    wp_enqueue_style('mh-magazine-lite', get_template_directory_uri() . '/style.css', array(), $mh_magazine_lite_version);
    wp_enqueue_style('mh-travelmag', get_stylesheet_uri(), array('mh-magazine-lite'), $mh_travelmag_version);
    if (is_rtl()) {
		wp_enqueue_style('mh-magazine-lite-rtl', get_template_directory_uri() . '/rtl.css', array(), $mh_magazine_lite_version);
	}
}
add_action('wp_enqueue_scripts', 'mh_travelmag_styles');

/***** Load Translations *****/

function mh_travelmag_theme_setup(){
	load_child_theme_textdomain('mh-travelmag', get_stylesheet_directory() . '/languages');
}
add_action('after_setup_theme', 'mh_travelmag_theme_setup');

/***** Change Defaults for Custom Colors *****/

function mh_travelmag_custom_colors() {
	remove_theme_support('custom-header');
	remove_theme_support('custom-background');
	add_theme_support('custom-header', array('default-image' => '', 'default-text-color' => 'fff', 'width' => 300, 'height' => 100, 'flex-width' => true, 'flex-height' => true));
	add_theme_support('custom-background', array('default-color' => 'f0f7fa'));
}
add_action('after_setup_theme', 'mh_travelmag_custom_colors');

?>