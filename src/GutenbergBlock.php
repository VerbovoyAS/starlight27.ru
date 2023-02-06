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

    public static function blockTextSection(): void
    {
        Block::make('beautiful_list_section', 'Блок с текстом')
            ->add_fields([
                             Field::make( 'checkbox', 'show_border', 'Отображать рамки' )
                                 ->set_option_value( 'yes' ),
                             Field::make( 'checkbox', 'show_stars', 'Отображать список с звёздами' )
                                 ->set_option_value( 'yes' ),
                             Field::make( 'checkbox', 'full_height', 'Блок во всю высоту' )
                                 ->set_option_value( 'yes' ),
                             Field::make('rich_text', 'text', 'Текст'),
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
                <div class="<?=$class;?>">
                    <?= $fields['text'];?>
                </div>
                <?php
            });
    }

}