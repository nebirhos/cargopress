<?php
// Make theme available for translation
// Translations can be filed in the /languages/ directory
load_theme_textdomain( 'cargopress', TEMPLATEPATH . '/languages' );
 
$locale = get_locale();
$locale_file = TEMPLATEPATH . "/languages/$locale.php";
if ( is_readable($locale_file) )
  require_once($locale_file);
 
function get_page_number() {
  if ( get_query_var('paged') ) {
    print ' | ' . __( 'Page ' , 'cargopress') . get_query_var('paged');
  }
}

// Register widgetized areas
function theme_widgets_init() {
  register_sidebar(
    array (
      'name' => 'Menu Widget Area',
      'id' => 'menu_widget_area',
      'before_widget' => '',
      'after_widget' => '',
      'before_title' => '<h3 class="widget-title">',
      'after_title' => '</h3>',
    )
  );
}
add_action( 'init', 'theme_widgets_init' );

// Check for static widgets in widget-ready areas
function is_sidebar_active( $index ){
  global $wp_registered_sidebars;
  $widgetcolums = wp_get_sidebars_widgets();
  if ($widgetcolums[$index]) return true;
  return false;
}

// Page title
function cargopress_title() {
  if ( is_single() ) { single_post_title(); }
  elseif ( is_home() || is_front_page() ) { bloginfo('name'); print ' | '; bloginfo('description'); get_page_number(); }
  elseif ( is_page() ) { single_post_title(''); }
  elseif ( is_search() ) { bloginfo('name'); print ' | Search results for ' . wp_specialchars($s); get_page_number(); }
  elseif ( is_404() ) { bloginfo('name'); print ' | Not Found'; }
  else { bloginfo('name'); wp_title('|'); get_page_number(); }
}

// Navigation Menu
if ( function_exists( 'register_nav_menu' ) ) {
	register_nav_menu( 'primary', 'Left Menu' );
}
?>
