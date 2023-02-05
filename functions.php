<?php
/**
 * hashtag functions and definitions
 *
 * @package hashtag
 */

use Carbon_Fields\Carbon_Fields;
use Carbon_Fields\Container;
use Carbon_Fields\Field;
use HashtagCore\GutenbergBlock;
use HashtagCore\TaxonomyCreate;

const POST_TYPE_STAFF = 'staff';

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
    register_post_type(
        'hashtag_blog',
        [
            'labels'             => [
                'name' => __('Полезные статьи'),
                'singular_name' => __('Полезная статья')
            ],
            'public'             => true,
            'has_archive'        => false,
            'rewrite'            => ['slug' => 'blog'],
            'show_in_rest'       => true,
            'publicly_queryable' => true,
        ]
    );



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
//        'show_in_rest'       => true,
        'taxonomies'       => ['positions_staffs', 'post_tag', 'taxonomy_cabinet', 'taxonomy_education', 'taxonomy_education_category'],
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


    /**
     * Дополнительные поля для СТАНИЦЫ
     */
    Container::make('post_meta', 'Дополнительные поля Страниц')
        ->where('post_type', '=', 'page')
        ->add_fields([
                         Field::make('sidebar', 'crb_custom_sidebar'),
                         Field::make('image', 'crb_photo'),

                     ]);

    /**
     * Дополнительные поля для "Полезные статьи" - hashtag_blog
     */
    Container::make('post_meta', __('Дополнительные поля полезных статей'))
        ->where('post_type', '=', 'hashtag_blog')
        ->add_tab( __( 'Profile' ), array(
            Field::make( 'text', 'crb_first_name', __( 'First Name' ) ),
            Field::make( 'text', 'crb_last_name', __( 'Last Name' ) ),
            Field::make( 'text', 'crb_position', __( 'Position' ) ),
        ) )
        ->add_tab( __( 'Notification' ), array(
            Field::make( 'text', 'crb_email', __( 'Notification Email' ) ),
            Field::make( 'text', 'crb_phone', __( 'Phone Number' ) ),
        ) );

    /**
     * Дополнительные поля для "Сотрудников" - staff
     */
    Container::make('post_meta', __('Дополнительные поля Сотрудников'))
        ->where('post_type', '=', POST_TYPE_STAFF)
        ->add_fields([
                         Field::make( 'text', 'staff_phone_number', 'Номер телефона' )
                             ->set_attribute( 'placeholder', '(***) ***-****' ),
                         Field::make( 'text', 'staff_mail', 'Почта' ),
                         Field::make( 'text', 'staff_working_hours', 'Время работы (приёма)' ),
                         Field::make( 'date_time', 'staff_year_advanced_training', 'Год повышения квалификации' ),
                         Field::make( 'date_time', 'staff_general_experience', 'Год и месяц начала общего стажа' ),
                         Field::make( 'date_time', 'staff_teaching_experience', 'Год и месяц начала педагогического стажа' ),
                         Field::make( 'checkbox', 'staff_active', 'Активировать' )->set_default_value(true),
                     ]);

    // Default options page
    /** @var Carbon_Fields\Container\Theme_Options_Container $basic_options_container */
    $basic_options_container = Container::make('theme_options', __('Theme Options'))
        ->add_fields([
                         Field::make('text', 'default_phone', __('Номер телефона')),
                         Field::make('text', 'default_mail', __('E-mail')),
                     ]);

    // Add second options page under 'Theme Options'
    Container::make('theme_options', __('Social Links'))
        ->set_page_parent($basic_options_container) // reference to a top level container
        ->add_fields([
                         Field::make('text', 'crb_facebook_link', __('Facebook Link')),
                         Field::make('text', 'crb_twitter_link', __('Twitter Link')),
                     ]);

    // Настройки внутри меню "Внешний вид"
    Container::make('theme_options', __('Customize Background'))
        ->set_page_parent('themes.php') // identificator of the "Appearance" admin section
        ->add_fields([
                         Field::make('color', 'crb_background_color', __('Background Color')),
                         Field::make('image', 'crb_background_image', __('Background Image')),
                     ]);
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