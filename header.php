<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package hashtag
 */

use HashtagCore\BootstrapNavMenu;

$title = get_the_title();
if (is_archive()) {
    $title = get_the_archive_title();
}

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title;?></title>
    <?php wp_head();?>
</head>

<body>
<header>
    <nav id="main-nav-menu" class="navbar navbar-expand-md navbar-dark fixed-top ">
        <div class="container-fluid container-lg">
            <a class="navbar-brand d-lg-block d-none" href="/">
                <img class="main-logo-menu" src="https://starlight27.ru/wp-content/uploads/2018/10/герб-лицей-88.png" alt="" width="88" height="88">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div id="main-menu" class="collapse navbar-collapse justify-content-center" >
                <?php
                wp_nav_menu(
                    [
                        'theme_location' => 'header-menu',
                        'menu_class'     => 'main-menu',
                        'fallback_cb'    => '__return_false',
                        'items_wrap'     => '<ul id="%1$s" class="navbar-nav mb-2 mb-md-0 %2$s stars-img">%3$s</ul>',
                        'depth'          => 2,
                        'walker'         => new BootstrapNavMenu()
                    ]
                );
                ?>
            </div>
        </div>
    </nav>
</header>

<script type="text/javascript">
    /* Для изменения цвета меню при прокрутке. */
    window.addEventListener("scroll", function(){
        var header = document.querySelector("nav");
        header.classList.toggle("bg-dark", window.scrollY > 100)
    })
</script>