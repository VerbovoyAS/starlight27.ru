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

/** Тип записи - Сотрудники */
const POST_TYPE_STAFF = 'staff';

/** Тип записи - Основные сведения */
const POST_TYPE_BASIC_INFO = 'info_edu';
const BASIC_INFO_ICON = 'basic_info_icon';

const DEFAULT_EMAIL = "default_email";
const DEFAULT_PHONE = "default_phone";
const DEFAULT_WORK_TIME = "default_work_time";
const DEFAULT_ADDRESSES = "default_addresses";
const SITE_LOGO = "logo_site";
const SITE_LOGO_WIDTH = "logo_site_width";
const SITE_LOGO_HEIGHT = "logo_site_height";

const SET_TEMP = "set_temp";
const SET_TEMP_block_A = "set_temp_block_a";
const SET_TEMP_block_B = "set_temp_block_b";
const SET_TEMP_block_V = "set_temp_block_v";
const SET_TEMP_block_D = "set_temp_block_d";

/** Название рубрики по умолчанию */
const DEFAULT_CATEGORY = 'news';

if (!defined('_S_VERSION')) {
    define('_S_VERSION', '1.0.0');
}

function hashtag_setup()
{
    load_theme_textdomain('hashtag', get_template_directory() . '/languages');

    register_nav_menus(
        [
            'header-menu'   => esc_html__('Главное меню', 'hashtag'),
            'info-edu-menu' => esc_html__('Меню Сведения ОУ', 'hashtag'),
        ]
    );

    // Позволяет устанавливать миниатюру в записях
    add_theme_support('post-thumbnails');

    // Удаляет префикс заголовка архивов
    add_filter('get_the_archive_title_prefix', '__return_empty_string');
}

add_action('after_setup_theme', 'hashtag_setup');

/**
 * Задаем дополнительные атрибуты для записей с типом пост
 */
add_action('admin_init', 'hashtag_posts_order');
function hashtag_posts_order()
{
    add_post_type_support('post', 'page-attributes');
    add_post_type_support(POST_TYPE_STAFF, 'page-attributes');
    add_post_type_support(POST_TYPE_BASIC_INFO, 'page-attributes');
}

/**
 * Register widget area.
 */
function hashtag_widgets_init()
{
    register_sidebar(
        [
            'name'          => esc_html__('Sidebar', 'hashtag'),
            'id'            => 'sidebar-1',
            'description'   => esc_html__('Add widgets here.', 'hashtag'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ]
    );

    register_sidebar(
        [
            'name'          => esc_html__('Sidebar footer 1', 'hashtag'),
            'id'            => 'sidebar-footer-1',
            'description'   => esc_html__('Add widgets here.', 'hashtag'),
            'before_widget' => '<div id="%1$s" class=" widget %2$s">',
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
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
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
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h5>',
            'after_title'   => '</h5>',
        ]
    );

    register_sidebar(
        [
            'name'          => esc_html__('Sidebar info edu', 'hashtag'),
            'id'            => 'sidebar-info-edu',
            'description'   => esc_html__('Add widgets here.', 'hashtag'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ]
    );
}

add_action('widgets_init', 'hashtag_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function hashtag_scripts()
{
    wp_enqueue_style('hashtag-style-boostrap-5', get_template_directory_uri() . '/assets/css/bootstrap.min.css');
    wp_enqueue_style('hashtag-font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.css');
    wp_enqueue_style('hashtag-bootstrap-icons', get_template_directory_uri() . '/assets/css/bootstrap-icons.css');
    wp_enqueue_style('hashtag-style-main-css', get_template_directory_uri() . '/assets/css/main.css');
    wp_enqueue_style('hashtag-style-menu-css', get_template_directory_uri() . '/assets/css/style-menu.css');

    /** Parallax для главной страницы */
    wp_enqueue_script('hashtag-parallax-js', get_template_directory_uri() . '/assets/js/parallax.min.js', [], null);

    wp_enqueue_script(
        'hashtag-boostrap-5-bundle-js',
        get_template_directory_uri() . '/assets/js/bootstrap.bundle.min.js',
        [],
        null
    );

    // TODO временно за комментирую
//    wp_enqueue_script('hashtag-boostrap-5-js', get_template_directory_uri() . '/assets/js/bootstrap.min.js');

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    /** Подключение styles-box-custom */
    wp_enqueue_style(
        'fw-shortcode-icon-box-custom',
        get_template_directory_uri() . '/assets/css/styles-box-custom.css',
    );

    /** Подключение OWL карусели */
    $owlPath = get_template_directory_uri() . '/assets/owl-carousel/';

    if (!wp_script_is('custom-script-owl-jquery')) {
        wp_enqueue_script(
            'custom-script-owl-jquery',
            $owlPath . 'js/jquery.min.js'
        );
    }

    if (!wp_script_is('custom-script-owl-lightgallery')) {
        wp_enqueue_script(
            'custom-script-owl-lightgallery',
            $owlPath . 'js/owl.carousel.min.js'
        );
    }

    if (!wp_style_is('custom-style-owl-carousel')) {
        wp_enqueue_style(
            'custom-style-owl-carousel',
            $owlPath . 'css/owl.carousel.min.css',
        );
    }

    if (!wp_style_is('custom-style-owl-theme-default')) {
        wp_enqueue_style(
            'custom-style-owl-theme-default',
            $owlPath . 'css/owl.theme.default.min.css',
        );
    }

    /** Подключение Галереи */
    wp_enqueue_script(
        'custom-gallery-lightgallery-js',
        get_template_directory_uri() . '/assets/gallery/js/lightgallery-all.min.js',
        [],
        false,
        true
    );

    wp_enqueue_script(
        'custom-gallery-setting',
        get_template_directory_uri() . '/assets/gallery/js/gallery-setting.js',
        [],
        false,
        true
    );

    wp_enqueue_style(
        'custom-gallery-lightgallery-style',
        get_template_directory_uri() . '/assets/gallery/css/lightgallery.min.css',
    );

    /** Загрузка постов */
    wp_enqueue_script('true_loadmore', get_template_directory_uri() . '/assets/js/loadmore.js', ['jquery']);
}

add_action('wp_enqueue_scripts', 'hashtag_scripts');

function hashtag_create_post_type()
{
    $taxonomy = new TaxonomyCreate();
    $taxonomy->createTaxonomy(POST_TYPE_STAFF, 'Должность', 'positions_staffs');
    $taxonomy->createTaxonomy(POST_TYPE_STAFF, 'Образование', 'taxonomy_education');
    $taxonomy->createTaxonomy(POST_TYPE_STAFF, 'Категория образования', 'taxonomy_education_category');

    register_post_type(POST_TYPE_STAFF, [
        'public'      => true,
        'has_archive' => true,
        'menu_icon'   => 'dashicons-groups',
        'rewrite'     => ['slug' => 'staffs'],
        'label'       => 'Сотрудники',
        'supports'    => ['title', 'editor', 'thumbnail', 'post-formats']
    ]);

    register_post_type(POST_TYPE_BASIC_INFO, [
        'public'       => true,
        'has_archive'  => true,
        'menu_icon'    => 'dashicons-media-document',
        'labels'       => [
            'name'          => 'Сведения об образовательной организации',
            'singular_name' => 'Сведения ОУ',
            'menu_name'     => 'Сведения ОУ'
        ],
        'show_in_rest' => true,
        'supports'     => ['title', 'editor', 'thumbnail', 'post-formats']
    ]);
}

add_action('init', 'hashtag_create_post_type');

add_action('after_setup_theme', 'crb_load');
function crb_load()
{
    require_once('vendor/autoload.php');
    Carbon_Fields::boot();

    GutenbergBlock::imageBoxSection();
    GutenbergBlock::imageCarouselSection();
    GutenbergBlock::postCarouselSection();
    GutenbergBlock::blockTextSection();
    GutenbergBlock::postCardStyleCarouselSection();
    GutenbergBlock::blockAccordion();
    GutenbergBlock::postListSection();
    GutenbergBlock::blockGallery();
    GutenbergBlock::blockStaffList();
    GutenbergBlock::blockPageCardAndIcon();
    GutenbergBlock::alertBlock();

    GutenbergContainer::settingSite();
    GutenbergContainer::fieldsStaff();
    GutenbergContainer::fieldsBasicInfo();
}

/** Автозагрузка постов */
function true_load_posts()
{
    $args = unserialize(stripslashes($_POST['query']));
    $args['paged'] = $_POST['page'] + 1; // следующая страница
    $args['post_status'] = 'publish';

    query_posts($args);
    if (have_posts()) :
        while (have_posts()): the_post();
            get_template_part('template-parts/category/category', get_post_type());
        endwhile;
    endif;
    die();
}

add_action('wp_ajax_loadmore', 'true_load_posts');
add_action('wp_ajax_nopriv_loadmore', 'true_load_posts');

add_shortcode('get-main-site', 'get_main_setting_shortcode');

/**
 * Shortcode для вывода значений по умолчанию
 * Пример: [get-main-site option="phone"]
 *
 * @param $atts
 * @return mixed|string|null
 */
function get_main_setting_shortcode($atts)
{
    switch ($atts['option']) {
        case 'phone':
            return carbon_get_theme_option(DEFAULT_PHONE);
        case 'email':
            return carbon_get_theme_option(DEFAULT_EMAIL);
        case 'work_time':
            return carbon_get_theme_option(DEFAULT_WORK_TIME);
        case 'addresses':
            return carbon_get_theme_option(DEFAULT_ADDRESSES);
        default:
            return '';
    }
}

/** ОБНОВЛЕНИЯ WP */
/** @see https://misha.agency/wordpress/avtomaticheskie-obnovlenie.html */

/** отключить принудительные автообновления */
function true_force_auto_update($checkout, $context)
{
    return false;
}

add_filter('automatic_updates_is_vcs_checkout', 'true_force_auto_update', 10, 2);

/** отключить автообновления для технических релизов */
add_filter('allow_minor_auto_core_updates', '__return_false');

/** отключить автообновления для основных релизов */
add_filter('allow_major_auto_core_updates', '__return_false');

add_shortcode('get-temperature-mode', 'get_temperature_mode_shortcode');

/**
 * Shortcode для вывода таблицы температуры
 * Пример: [get-temperature-mode]
 *
 * @param $atts
 * @return mixed|string|null
 */
function get_temperature_mode_shortcode($atts)
{
    $t = [
        "Блок А" => explode(',', carbon_get_theme_option(SET_TEMP_block_A)),
        "Блок Б" => explode(',', carbon_get_theme_option(SET_TEMP_block_B)),
        "Блок В" => explode(',', carbon_get_theme_option(SET_TEMP_block_V)),
        "Блок Д" => explode(',', carbon_get_theme_option(SET_TEMP_block_D))
    ];

    $tt = [];
    foreach ($t as $blockName => $kabinets) {
        $tt[$blockName] = [];
        foreach ($kabinets as $c) {
            $r = rand(20, 23);
            $tt[$blockName][] = trim($c) . ' - ' . $r;
        }
    }

    file_put_contents(get_theme_file_path() . "/temperature.json", json_encode($tt, JSON_UNESCAPED_UNICODE));
    $time = current_time('d-m-Y H:i:s');
    carbon_set_theme_option(SET_TEMP, current_time('d-m-Y H:i:s'));

    echo 'обновлено: ' . $time;
    return;
}

// если ещё не запланировано - планируем
if (!wp_next_scheduled('generate_temperature_hook')) {
    wp_schedule_event(time(), 'hourly', 'generate_temperature_hook');
}

add_action('generate_temperature_hook', 'generate_temperature');

function generate_temperature($to, $subject, $msg)
{
    $t = [
        "Блок А" => explode(',', carbon_get_theme_option(SET_TEMP_block_A)),
        "Блок Б" => explode(',', carbon_get_theme_option(SET_TEMP_block_B)),
        "Блок В" => explode(',', carbon_get_theme_option(SET_TEMP_block_V)),
        "Блок Д" => explode(',', carbon_get_theme_option(SET_TEMP_block_D))
    ];

    $tt = [];
    foreach ($t as $blockName => $kabinets) {
        $tt[$blockName] = [];
        foreach ($kabinets as $c) {
            $r = rand(20, 23);
            $tt[$blockName][] = trim($c) . ' - ' . $r;
        }
    }

    try {
        file_put_contents(get_theme_file_path() . "/temperature.json", json_encode($tt, JSON_UNESCAPED_UNICODE));
    } catch (Throwable $exception) {
        // Пока не чего не делаем
    }
}

