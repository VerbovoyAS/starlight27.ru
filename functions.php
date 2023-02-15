<?php
/**
 * hashtag functions and definitions
 *
 * @package hashtag
 */

use Carbon_Fields\Carbon_Fields;
use HashtagCore\GutenbergBlock;
use HashtagCore\GutenbergContainer;
use HashtagCore\TaxonomyCreate;

const POST_TYPE_STAFF = 'staff';
const DEFAULT_EMAIL = "default_email";
const DEFAULT_PHONE = "default_phone";
const DEFAULT_WORK_TIME = "default_work_time";

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

function hashtag_setup() {

	load_theme_textdomain( 'hashtag', get_template_directory() . '/languages' );

    register_nav_menus(
        [
            'header-menu' => esc_html__('Primary', 'hashtag'),
        ]
    );

    // Позволяет устанавливать миниатюру в записях
    add_theme_support( 'post-thumbnails' );

    // Удаляет префикс заголовка архивов
    add_filter( 'get_the_archive_title_prefix', '__return_empty_string' );
}

add_action( 'after_setup_theme', 'hashtag_setup' );

/**
 * Register widget area.
 *
 */
function hashtag_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'hashtag' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'hashtag' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

    register_sidebar(
        [
            'name'          => esc_html__('Sidebar footer 1', 'hashtag'),
            'id'            => 'sidebar-footer-1',
            'description'   => esc_html__('Add widgets here.', 'hashtag'),
            'before_widget' => '<div id="%1$s" class="col-12 col-lg-3 offset-lg-1 mb-3 widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h5>',
            'after_title'   => '</h5>',
        ]
    );

    register_sidebar(
        [
            'name'          => esc_html__('Sidebar footer 2', 'hashtag'),
            'id'            => 'sidebar-footer-2',
            'description'   => esc_html__('Add widgets here.', 'hashtag'),
            'before_widget' => '<div id="%1$s" class="col-12 col-lg-4 mb-3 widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h5>',
            'after_title'   => '</h5>',
        ]
    );

    register_sidebar(
        [
            'name'          => esc_html__('Sidebar footer 3', 'hashtag'),
            'id'            => 'sidebar-footer-3',
            'description'   => esc_html__('Add widgets here.', 'hashtag'),
            'before_widget' => '<div id="%1$s" class="col-12 col-lg-4 mb-3 widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h5>',
            'after_title'   => '</h5>',
        ]
    );
}
add_action( 'widgets_init', 'hashtag_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function hashtag_scripts() {

    wp_enqueue_style(
        'hashtag-style-boostrap-5',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css'
    );
    wp_enqueue_style(
        'hashtag-font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css'
    );
    wp_enqueue_style('hashtag-style-main-css', get_template_directory_uri() . '/assets/css/main.css');
    wp_enqueue_style('hashtag-style-menu-css', get_template_directory_uri() . '/assets/css/style-menu.css');

    wp_enqueue_script(
        'hashtag-paralax-js',
        'https://cdnjs.cloudflare.com/ajax/libs/parallax/3.1.0/parallax.min.js',
        [],
        '',
        true
    );
    wp_enqueue_script(
        'hashtag-boostrap-5-bundle-js',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js'
    );
    // wp_enqueue_script('hashtag-boostrap-5-popper-js', 'https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js', [], '', true);

    wp_enqueue_script('hashtag-boostrap-5-js', 'https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js', [], '', true);

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

    /** Подключение styles-box-custom */
    wp_enqueue_style(
        'fw-shortcode-icon-box-custom',
        get_template_directory_uri() . '/assets/css/styles-box-custom.css',
    );

    /** Подключение OWL карусели */
    $path = get_template_directory_uri() . '/assets/owl-carousel/';

    if( !wp_script_is( 'custom-script-owl-jquery' ) ){
        wp_enqueue_script(
            'custom-script-owl-jquery',
            'https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js'
        );
    }

    if( ! wp_script_is( 'custom-script-owl-lightgallery' ) ){
        wp_enqueue_script(
            'custom-script-owl-lightgallery',
            $path . 'js/owl.carousel.min.js'
        );
    }

    if( ! wp_style_is( 'custom-style-owl-carousel' ) ){
        wp_enqueue_style(
            'custom-style-owl-carousel',
            $path . 'css/owl.carousel.min.css',
        );
    }

    if( ! wp_style_is( 'custom-style-owl-theme-default' ) ){
        wp_enqueue_style(
            'custom-style-owl-theme-default',
            $path . 'css/owl.theme.default.min.css',
        );
    }
}
add_action( 'wp_enqueue_scripts', 'hashtag_scripts' );


function hashtag_create_post_type() {

    $taxonomy = new TaxonomyCreate();
    $taxonomy->createTaxonomy(POST_TYPE_STAFF, 'Должность', 'positions_staffs');
    $taxonomy->createTaxonomy(POST_TYPE_STAFF, 'Кабинет', 'taxonomy_cabinet');
    $taxonomy->createTaxonomy(POST_TYPE_STAFF, 'Образование', 'taxonomy_education');
    $taxonomy->createTaxonomy(POST_TYPE_STAFF, 'Категория образования', 'taxonomy_education_category');

    register_post_type(POST_TYPE_STAFF, [
        'public'      => true,
        'has_archive' => true,
        'menu_icon'   => 'dashicons-groups',
        'rewrite'     => ['slug' => 'staffs'],
        'label'       => 'Сотрудники',
        'supports' => [ 'title', 'editor', 'thumbnail', 'post-formats']
    ]);
}

add_action( 'init', 'hashtag_create_post_type' );


add_action( 'after_setup_theme', 'crb_load' );
function crb_load() {
    require_once( 'vendor/autoload.php' );
    Carbon_Fields::boot();

    GutenbergBlock::imageBoxSection();
    GutenbergBlock::imageCarouselSection();
    GutenbergBlock::postCarouselSection();
    GutenbergBlock::blockTextSection();
    GutenbergBlock::postCardStyleCarouselSection();

    GutenbergContainer::settingSite();
    GutenbergContainer::fieldsStaff();

}

function getPostViews($postID): string
{
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == '') {
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0";
    }
    return $count;
}

function setPostViews($postID): void
{
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == '') {
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    } else {
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}