<?php
add_theme_support('post-thumbnails');
if ( ! function_exists( 'crea_register_nav_menu' ) ) {
    function crea_register_nav_menu(){
        register_nav_menus( array(
            'primary_menu' => __( 'Primary Menu', 'crea' ),
            'footer_menu'  => __( 'Footer Menu', 'crea' ),
        ) );
    }
    add_action( 'after_setup_theme', 'crea_register_nav_menu', 0 );
}
function crea_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'cr' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer', 'cr' ),
		'id'            => 'footer',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer 2', 'cr' ),
		'id'            => 'footer-2',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
}
add_action( 'widgets_init', 'crea_widgets_init' );

function crea_scripts() {
  wp_enqueue_style( 'cr-style', get_stylesheet_uri() );
  wp_enqueue_style( 'cr_custome-style', get_template_directory_uri().'/src/css/main.min.css' );

  wp_register_script( 'main-js-defer',  get_template_directory_uri().'/src/js/main.js', [], false, true ); 
  wp_enqueue_script( 'main-js-defer' );
}
add_action( 'wp_enqueue_scripts', 'crea_scripts' );


require get_template_directory() . '/src/inc/customizer.php';
if(get_theme_mod('d-map') ) {
require get_template_directory() . '/src/inc/map.php';
require get_template_directory() . '/src/inc/cleanup.php';
}

/**
 * This function adds the "async" and "defer" parameters to Javascript resources.
 */
function crea_add_async_defer_attr( $tag, $handle ) {
	if( strpos( $handle, "async" ) ):
		$tag = str_replace(' src', ' async="async" src', $tag);
	endif;

	if( strpos( $handle, "defer" ) ):
		$tag = str_replace(' src', ' defer="defer" src', $tag);
	endif;

	return $tag;
}
add_filter('script_loader_tag', 'crea_add_async_defer_attr', 10, 2);

add_action('wp_default_scripts', function ($scripts) {
    if (!empty($scripts->registered['jquery'])) {
        $scripts->registered['jquery']->deps = array_diff($scripts->registered['jquery']->deps, ['jquery-migrate']);
    }
});

function is_post_type($type){
    global $wp_query;
    if($type == get_post_type($wp_query->post->ID)) 
        return true;
    return false;
}