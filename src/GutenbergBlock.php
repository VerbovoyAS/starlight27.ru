<?php

namespace HashtagCore;

use Carbon_Fields\Block;
use Carbon_Fields\Field\Complex_Field;
use Carbon_Fields\Field\Field;
use WP_Query;

final class GutenbergBlock
{

    public static function imageBoxSection(): void
    {
        Block::make('image_box_section', __('Image box'))
            ->add_tab("Боксы", [
                             Field::make('separator', 'separator', 'Боксы с изображением'),
                             Field::make('complex', 'blocks', 'Блоки')
                                 ->set_layout(Complex_Field::LAYOUT_TABBED_VERTICAL)
                                 ->add_fields([
                                                  Field::make('text', 'header', 'Заголовок'),
                                                  Field::make('text', 'link', 'Ссылка'),
                                                  Field::make('image', 'img', 'Картинка'),
                                                  Field::make('text', 'description', 'Короткое описание'),
                                              ]),

                         ])
            ->add_tab("Настройки карусели", [
                Field::make( 'select', 'carousel_ps', 'ПК')
                    ->set_default_value('4')
                    ->set_options([ '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' => 7]),
                Field::make( 'select', 'carousel_tab', 'Планшет')
                    ->set_default_value('3')
                    ->set_options([ '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5]),
                Field::make( 'select', 'carousel_mob', 'Мобильная версия')
                    ->set_default_value('1')
                    ->set_options([ '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5]),
            ])
            ->set_render_callback(function ($fields) {
                $blocks = [];
                if (!empty($fields['blocks'])) {
                    $blocks = $fields['blocks'];
                }
                ?>
                <div class="row my-2">
                    <div class="p-0 owl-carousel owl-theme">
                        <?php
                        foreach ($blocks as $block) {
                            $img = wp_get_original_image_url($block['img']);
                            ?>
                            <a class="hashtag-imagebox-link" href="<?= $block['link'] ?? '' ?>">
                                <div class="hashtag-imagebox-custom hashtag-imagebox-1 ">
                                    <img src="<?= $img ?? ''; ?>" alt=""
                                         class="rounded img-fluid rounded-3 d-inline" style="width: 150px;">
                                    <div class="">
                                        <div class="hashtag-imagebox-title">
                                            <h3><?= $block['header'] ?? '' ;?></h3>
                                        </div>
                                        <?php if(!empty($block['description'])) { ?>
                                        <div class="hashtag-imagebox-text">
                                            <p><?= $block['description']; ?></p>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </a>
                            <?php
                        }
                        ?>
                    </div>
                </div>

                <script>
                    $('.owl-carousel').owlCarousel({
                        loop: true,
                        margin: 10,
                        nav: true,
                        responsive: {
                            0: {
                                items: <?= $fields['carousel_mob'] ?? 1;?>
                            },
                            600: {
                                items: <?= $fields['carousel_tab'] ?? 3;?>
                            },
                            1000: {
                                items: <?= $fields['carousel_ps'] ?? 4;?>
                            }
                        }
                    })
                </script>

                <?php
            });
    }

    public static function imageCarouselSection(): void
    {
        Block::make('image_carousel_section', __('Карусель изображений'))
            ->add_tab("Боксы", [
                Field::make('separator', 'separator', 'Карусель изображений'),
                Field::make( 'media_gallery', 'crb_media_gallery', __( 'Media Gallery' ) ),
            ])
            ->add_tab("Настройки карусели", [
                Field::make( 'select', 'carousel_ps', 'ПК')
                    ->set_default_value('4')
                    ->set_options([ '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' => 7,]),
                Field::make( 'select', 'carousel_tab', 'Планшет')
                    ->set_default_value('3')
                    ->set_options([ '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5,]),
                Field::make( 'select', 'carousel_mob', 'Мобильная версия')
                    ->set_default_value('1')
                    ->set_options([ '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5,]),
            ])
            ->set_render_callback(function ($fields) {
                ?>
                <div class="row my-2">
                    <div class="owl-carousel owl-theme">
                        <?php
                        foreach ($fields['crb_media_gallery'] as $img):
                            $img_url = wp_get_original_image_url($img);
                            if (empty($img_url)) {
                                continue;
                            }
                            ?>
                            <div class="item">
                                <img class="" src="<?= $img_url; ?>">
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <script>
                    $('.owl-carousel').owlCarousel({
                        loop: true,
                        margin: 10,
                        nav: true,
                        responsive: {
                            0: {
                                items: <?= $fields['carousel_mob'] ?? 1;?>
                            },
                            600: {
                                items: <?= $fields['carousel_tab'] ?? 3;?>
                            },
                            1000: {
                                items: <?= $fields['carousel_ps'] ?? 4;?>
                            }
                        }
                    })
                </script>

                <?php
            });
    }

    public static function postCarouselSection(): void
    {
        Block::make('post_carousel_section', __('Карусель постов'))
            ->add_tab("Боксы", [
                Field::make('separator', 'separator', 'Карусель постов'),
                Field::make( 'select', 'category_post', __( 'Choose Options' ) )
                    ->set_options(Hashtag::getPostCategories()),
                Field::make('text', 'posts_per_page', 'Количество постов на странице')
            ])
            ->add_tab("Настройки карусели", [
                Field::make( 'select', 'carousel_ps', 'ПК')
                    ->set_default_value('4')
                    ->set_options([ '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' => 7]),
                Field::make( 'select', 'carousel_tab', 'Планшет')
                    ->set_default_value('3')
                    ->set_options([ '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5]),
                Field::make( 'select', 'carousel_mob', 'Мобильная версия')
                    ->set_default_value('1')
                    ->set_options([ '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5]),
            ])
            ->set_render_callback(function ($fields) {
                $query = new WP_Query(
                    [
                        'category_name'  => $fields['category_post'] ?? 'home-news',
                        'posts_per_page' => $fields['posts_per_page'] ?? '6'
                    ]
                );
                ?>
                <style>
                    .owl-item,
                    .owl-stage {
                        height: 100%;!important;
                    }
                </style>
                    <div class="row row-cols-1 row-cols-md-3 g-4 my-2">
                        <div class="owl-carousel owl-theme">
                            <?php
                            foreach ($query->get_posts() as $WPost):
                                $img_url = get_the_post_thumbnail_url(
                                    $WPost
                                ) ?: Hashtag::getDefaultImg();
                                ?>

                                <div class="col h-100">
                                    <div class="card mx-3 mx-md-0 h-100">
                                        <img src="<?= $img_url; ?>" class="card-img-top"
                                             alt="<?= $WPost->post_title ?>">
                                        <div class="card-body">
                                            <a class="link-secondary text-decoration-none" href="<?= get_the_permalink($WPost->ID); ?>">
                                                <h5 class="card-title"><?= $WPost->post_title ?></h5>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            <?php endforeach; ?>
                        </div>
                    </div>

                <script>
                    $('.owl-carousel').owlCarousel({
                        loop: true,
                        margin: 10,
                        nav: true,
                        autoHeight:true,
                        responsive: {
                            0: {
                                items: <?= $fields['carousel_mob'] ?? 1;?>
                            },
                            600: {
                                items: <?= $fields['carousel_tab'] ?? 3;?>
                            },
                            1000: {
                                items: <?= $fields['carousel_ps'] ?? 4;?>
                            }
                        }
                    })
                </script>

                <?php
            });
    }

    public static function postCardStyleCarouselSection(): void
    {
        Block::make('post_card_style_carousel_section', __('Карусель стильных постов'))
            ->add_tab("Боксы", [
                Field::make('separator', 'separator', 'Карусель постов'),
                Field::make( 'select', 'category_post', __( 'Choose Options' ) )
                    ->set_options(Hashtag::getPostCategories()),
                Field::make('text', 'posts_per_page', 'Количество постов на странице'),
                Field::make( 'checkbox', 'show_header', 'Отображать заголовок' )->set_default_value(1),
            ])
            ->add_tab("Настройки карусели", [
                Field::make( 'select', 'carousel_ps', 'ПК')
                    ->set_default_value('3')
                    ->set_options([ '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' => 7]),
                Field::make( 'select', 'carousel_tab', 'Планшет')
                    ->set_default_value('3')
                    ->set_options([ '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5]),
                Field::make( 'select', 'carousel_mob', 'Мобильная версия')
                    ->set_default_value('1')
                    ->set_options([ '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5]),
            ])
            ->set_render_callback(function ($fields) {
                $category = $fields['category_post'] ?? 'home-news';
                $cat = get_category_by_slug($category);
                $catName = $cat->name ?: 'Новости';

                $query = new WP_Query(
                    [
                        'category_name'  => $category,
                        'posts_per_page' => $fields['posts_per_page'] ?? '6'
                    ]
                );
                ?>
                <?php if ($query->have_posts()) :?>
                <div class="row row-cols-1 row-cols-md-3 g-4 my-2">
                    <?php if ($fields['show_header']) :?>
                    <h2 class="pb-2 border-bottom"><?= $catName; ?></h2>
                    <?php endif; ?>
                    <div class="owl-carousel owl-theme">
                        <?php
                        foreach ($query->get_posts() as $WPost):

                            $img_url = get_the_post_thumbnail_url() ?: Hashtag::getDefaultImg();
                            if (!has_post_thumbnail($WPost->ID)) {
                                $img_url = Hashtag::getDefaultImg();
                            }
                            ?>

                            <div class="card card-cover h-100 overflow-hidden text-white bg-dark rounded-5 " style="background-image: url(<?= $img_url; ?>);">
                                <div class="d-flex flex-column h-100 p-5 pb-3 text-white text-shadow-3">
                                    <a class="mt-auto link-light text-decoration-none" href="<?= get_the_permalink($WPost->ID); ?>">
                                        <h2 class="lh-2 fw-bold"><?= $WPost->post_title; ?></h2>
                                    </a>
                                    <ul class="d-flex list-unstyled justify-content-end flex-wrap mt-auto">
                                        <li class="d-flex align-items-center me-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-stars me-2" viewBox="0 0 16 16">
                                                <path d="M7.657 6.247c.11-.33.576-.33.686 0l.645 1.937a2.89 2.89 0 0 0 1.829 1.828l1.936.645c.33.11.33.576 0 .686l-1.937.645a2.89 2.89 0 0 0-1.828 1.829l-.645 1.936a.361.361 0 0 1-.686 0l-.645-1.937a2.89 2.89 0 0 0-1.828-1.828l-1.937-.645a.361.361 0 0 1 0-.686l1.937-.645a2.89 2.89 0 0 0 1.828-1.828l.645-1.937zM3.794 1.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387A1.734 1.734 0 0 0 4.593 5.69l-.387 1.162a.217.217 0 0 1-.412 0L3.407 5.69A1.734 1.734 0 0 0 2.31 4.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387A1.734 1.734 0 0 0 3.407 2.31l.387-1.162zM10.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732L9.1 2.137a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L10.863.1z"/>
                                            </svg>
                                            <small><?= $catName ?? 'Новости';?></small>
                                        </li>
                                        <li class="d-flex align-items-center me-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-calendar3 me-2" viewBox="0 0 16 16">
                                                <path d="M14 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM1 3.857C1 3.384 1.448 3 2 3h12c.552 0 1 .384 1 .857v10.286c0 .473-.448.857-1 .857H2c-.552 0-1-.384-1-.857V3.857z"/>
                                                <path d="M6.5 7a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                                            </svg>
                                            <small><?php the_time('j F Y'); ?></small>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        <?php endforeach; ?>
                    </div>
                </div>
                    <script>
                        $('.owl-carousel').owlCarousel({
                            loop: true,
                            margin: 10,
                            nav: true,
                            autoHeight:true,
                            responsive: {
                                0: {
                                    items: <?= $fields['carousel_mob'] ?? 1;?>
                                },
                                600: {
                                    items: <?= $fields['carousel_tab'] ?? 2;?>
                                },
                                1000: {
                                    items: <?= $fields['carousel_ps'] ?? 3;?>
                                }
                            }
                        })
                    </script>
                <?php else: ?>
                <div class="row my-2">
                    <div class="col">
                        <div class="alert alert-warning" role="alert">
                            Записи не найдены
                        </div>
                    </div>
                </div>

                <?php endif; ?>

                <?php
            });
    }

    public static function blockTextSection(): void
    {
        Block::make('beautiful_list_section', 'Блок с текстом')
            ->add_tab('Текст', [
                Field::make('rich_text', 'text', 'Текст'),
            ])
            ->add_tab('Настройки', [
                             Field::make( 'checkbox', 'show_border', 'Отображать рамки' ),
                             Field::make( 'checkbox', 'show_stars', 'Отображать список с звёздами' ),
                             Field::make( 'checkbox', 'full_height', 'Блок во всю высоту' ),
                             Field::make( 'checkbox', 'search', 'Включить поиск по списку' ),
                         ])
            ->set_render_callback(function ($fields) {
                $class = '';
                if($fields['show_border']){
                    $class .= 'block mb-3 ';
                }

                if($fields['show_stars']){
                    $class .= 'stars ';
                }

                if($fields['full_height']){
                    $class .= 'h-100';
                }
                ?>
                <?php if ($fields['search']) {?>
                <div class="mb-3">
                    <input type="text" id="inputSearch" class="form-control" placeholder="Поиск по списку..." title="Что вы хотите найти?">
                </div>
                    <?php
                    // Подключение стилей. Надо потом вынести в отдельный метод
                    wp_enqueue_script(
                        'custom-search-form-list',
                        get_template_directory_uri() . '/assets/js/custom-search-form-list.js',
                        array(),
                        false,
                        true
                    );

                    ?>
                <?php } ?>

                <div id="fast_search" class="<?=$class;?>">
                    <?= $fields['text'];?>
                </div>
                <?php
            });
    }

}