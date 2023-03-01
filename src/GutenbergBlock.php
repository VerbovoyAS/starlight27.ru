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
                                <img alt="" class="" src="<?= $img_url; ?>">
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
                        'category_name'  => $fields['category_post'] ?: DEFAULT_CATEGORY,
                        'posts_per_page' => $fields['posts_per_page'] ?: '6'
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
                $category = $fields['category_post'] ?: DEFAULT_CATEGORY;
                $cat = get_category_by_slug($category);
                $catName = $cat->name ?: 'Новости';

                $query = new WP_Query(
                    [
                        'category_name'  => $category,
                        'posts_per_page' => $fields['posts_per_page'] ?: '6'
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
                                            <small><?= get_the_time('j F Y', $WPost->ID); ?></small>
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
                    if( !wp_script_is( 'custom-search-form-block' ) ){
                        wp_enqueue_script(
                            'custom-search-form-list',
                            get_template_directory_uri() . '/assets/js/custom-search-form-list.js',
                            array(),
                            false,
                            true
                        );
                    }
                    ?>
                <?php } ?>

                <div id="fast_search" class="<?=$class;?>">
                    <?= $fields['text'];?>
                </div>
                <?php
            });
    }

    public static function blockAccordion()
    {
        Block::make('block_accordion', 'Блок Аккордеон')
            ->add_fields([
                             Field::make('complex', 'accordion', 'Аккордеон')
                                 ->setup_labels(['singular_name' => 'вкладку'])
                                 ->set_collapsed(true)
                                 ->add_fields(
                                 [
                                     Field::make('text', 'accordion_header', __('Заголовок')),
                                     Field::make('rich_text', 'accordion_text', __('Текст')),
                                     Field::make('media_gallery', 'accordion_gallery', __('Галерея')),
                                 ]
                             )->set_header_template(
                                     '
                                        <% if (accordion_header) { %>
                                            <%- accordion_header %>
                                        <% } %>
                                     '
                                 )
                         ])
                ->set_render_callback(function ($fields) {
                        $id = rand(1,100);
                    ?>
                    <div class="accordion py-2" id="accordion-<?= $id;?>">
                    <?php foreach ($fields['accordion'] as $key => $item): ?>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading-<?= $id.'-'.$key;?>">
                                <button class="accordion-button <?php echo $key ? 'collapsed' : '';?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?= $id.'-'.$key;?>" aria-expanded="<?php echo $key ? 'false' : 'true';?>" aria-controls="collapse-<?= $id.'-'.$key;?>">
                                    <?= $item['accordion_header'];?>
                                </button>
                            </h2>
                            <div id="collapse-<?= $id.'-'.$key;?>" class="accordion-collapse collapse <?php echo $key ? '' : 'show';?>" aria-labelledby="heading-<?= $id.'-'.$key;?>" data-bs-parent="#accordion-<?= $id;?>">
                                <div class="accordion-body">
                                    <?= $item['accordion_text'];?>

                                    <div id="featured-<?= $id.'-'.$key;?>" class="list-unstyled row clearfix">
                                        <?php foreach ($item['accordion_gallery'] as $img):?>

                                            <?php
                                            $srcFull = wp_get_attachment_image_url( $img, 'full' );
                                            $description = wp_get_attachment_caption($img) ?? '';
                                            $alt = get_post_meta($img, '_wp_attachment_image_alt', true);
                                            ?>
                                            <a href="<?= $srcFull; ?>" data-exthumbimage="<?= $srcFull; ?>" data-src="<?= $srcFull; ?>" data-sub-html="<?= $description; ?>" class="col-lg-3 col-md-6 mb-4">
                                                <img class="img-fluid img-thumbnail mx-auto d-block" src="<?= $srcFull; ?>" alt="<?= $alt; ?>" style="width:100%;">
                                            </a>
                                        <?php endforeach;?>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php
            });
    }

    public static function postListSection(): void
    {
        Block::make('post_list_section', __('Список постов'))
            ->add_fields(
                    [
                Field::make('separator', 'separator', 'Список постов'),
                Field::make( 'select', 'category_post', __( 'Choose Options' ) )
                    ->set_options(Hashtag::getPostCategories()),
                Field::make('text', 'posts_per_page', 'Количество постов на странице'),
                Field::make( 'checkbox', 'show_header', 'Отображать заголовок' )->set_default_value(1),
            ])
            ->set_render_callback(function ($fields) {
                $category = $fields['category_post'] ?: DEFAULT_CATEGORY;
                $cat = get_category_by_slug($category);
                $catName = $cat->name ?: 'Новости';

                $query = new WP_Query(
                    [
                        'category_name'  => $category,
                        'posts_per_page' => $fields['posts_per_page'] ?: '6'
                    ]
                );

                ?>
                <?php if ($query->have_posts()) :?>
                    <div class="row">
                        <?php  if ($fields['show_header']) :?>
                            <h2 class="pb-2 border-bottom"><?= $catName; ?></h2>
                        <?php endif; ?>
                    </div>
                    <div class="row row-cols-1 row-cols-md-2 g-4 my-2">
                            <?php
                            foreach ($query->get_posts() as $WPost):

                                $img_url = get_the_post_thumbnail_url() ?: Hashtag::getDefaultImg();
                                if (!has_post_thumbnail($WPost->ID)) {
                                    $img_url = Hashtag::getDefaultImg();
                                }
                                ?>

                                <div class="col">
                                    <div class="d-flex row g-0">
                                        <div class="col-md-4 d-flex align-items-start p-1">
                                            <a href="<?= get_the_permalink($WPost->ID); ?>">
                                                <img src="<?php echo $img_url; ?>"
                                                     alt="..." class="img-fluid rounded d-inline-block">
                                            </a>
                                        </div>
                                        <div class="col-md-8 p-1">
                                            <div class="pb-2">
                                                <a class="text-decoration-none link-secondary"
                                                   href="<?php the_permalink(); ?>">
                                                    <h5 class="card-title"><?= $WPost->post_title; ?></h5>
                                                </a>
                                                <div class="d-flex justify-content-between flex-column">
                                                    <p class="card-text">
                                                        <small class="text-muted">
                                                            <?= get_the_time('j F Y', $WPost->ID); ?>
                                                        </small>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php endforeach; ?>
                    </div>

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

    public static function blockGallery()
    {
        Block::make('block_gallery', 'Gallery light')
            ->add_fields([
                             Field::make('text', 'gallery_header', __('Заголовок')),
                             Field::make('media_gallery', 'gallery', __('Галерея')),
                             Field::make( 'checkbox', 'show_description', 'Отображать подпись картинки' ),
                         ])
            ->set_render_callback(function ($fields) {
                $id = rand(1, 100);
                ?>
                <div class="row">
                    <h2 class="text-center">
                        <?= $fields['gallery_header'];?>
                    </h2>

                    <div id="featured-<?= $id;?>" class="list-unstyled row clearfix">
                        <?php foreach ($fields['gallery'] as $img):?>

                            <?php
                            $srcFull = wp_get_attachment_image_url( $img, 'full' );
                            $description = wp_get_attachment_caption($img) ?? '';
                            $alt = get_post_meta($img, '_wp_attachment_image_alt', true);
                            ?>
                            <a href="<?= $srcFull; ?>" data-exthumbimage="<?= $srcFull; ?>" data-src="<?= $srcFull; ?>" data-sub-html="<?= $description; ?>" class="col-lg-3 col-md-6 mb-4 text-decoration-none link-secondary text-center">
                                <img class="img-fluid img-thumbnail mx-auto d-block" src="<?= $srcFull; ?>" alt="<?= $alt; ?>" style="width:100%;">
                                <?php if ($fields['show_description']):?>
                                <p class="pt-2"><?= $description; ?></p>
                                <?php endif;?>
                            </a>
                        <?php endforeach;?>
                    </div>
                </div>
                <?php
            });
    }

    public static function blockStaffList()
    {
        Block::make('staff_list_section', __('Список сотрудников'))
            ->add_fields(
                [
                    Field::make('separator', 'separator', 'Список сотрудников'),
                    Field::make( 'select', 'position', 'Должность' )
                        ->set_options(function () {

                            $terms = get_terms([
                                                            'taxonomy'   => 'positions_staffs',
                                                            'hide_empty' => false,
                                                            'orderby' => 'parent',
                                                        ]);

                            return Staffs::getListTerms($terms);
                        }),
                    Field::make('text', 'header', 'Заголовок'),
                    Field::make( 'checkbox', 'search', 'Включить поиск по списку' ),
                ]
            )
            ->set_render_callback(function ($fields) {
                // Стили для блоков
                echo Staffs::getStyleBlock();

                $arg = [
                    'post_type'      => POST_TYPE_STAFF,
                    'posts_per_page' => -1,
                    'orderby'        => 'meta_query',
                    'order'          => 'DESC',
                    'meta_query'     => [
                        'key' => 'parent',
                    ],
                    'tax_query'      => [
                        [
                            'taxonomy' => 'positions_staffs',
                            'terms'    => $fields['position']
                        ]
                    ]
                ];

                ?>

                <?php if ($fields['search']) {?>
                    <div class="mb-3">
                        <input type="text" id="inputSearchBlock" class="form-control" placeholder="Поиск по сотрудникам..." title="Что вы хотите найти?">
                    </div>
                    <?php
                    // Подключение стилей. Надо потом вынести в отдельный метод
                    if( !wp_script_is( 'custom-search-form-block' ) ){
                        wp_enqueue_script(
                            'custom-search-form-block',
                            get_template_directory_uri() . '/assets/js/custom-search-form-block.js',
                            array(),
                            false,
                            true
                        );
                    }
                    ?>
                <?php } ?>

                <?php  if ($fields['show_header']) :?>
                    <h2 class="pb-2 border-bottom"><?= $fields['header'] ?: ''; ?></h2>
                <?php endif; ?>

                <div id="fast_search_block" class="row row-cols-1 g-3">
                <?php
                $query = new WP_Query($arg);
                if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
                    // пропускаем не активные записи
                    if (!carbon_get_the_post_meta(Staffs::STAFF_ACTIVE)) {
                        continue;
                    }

                    //  Получаем terms таксонов
                    $positions_staffs = Staffs::get_terms_by_tax(get_the_ID(), 'positions_staffs');
                    $cabinet = Staffs::get_terms_by_tax(get_the_ID(), 'taxonomy_cabinet');
                    $taxonomy_education = Staffs::get_terms_by_tax(get_the_ID(), 'taxonomy_education');
                    $taxonomy_education_category = Staffs::get_terms_by_tax(get_the_ID(), 'taxonomy_education_category');
                    //  Получаем metaBox
                    $phone = carbon_get_the_post_meta( Staffs::STAFF_PHONE);
                    $mail = carbon_get_the_post_meta( Staffs::STAFF_MAIL);
                    $working_hours = carbon_get_the_post_meta( Staffs::STAFF_WORKING_HOURS);
                    $year_advanced_training = carbon_get_the_post_meta( Staffs::STAFF_YEAR_ADVANCED_TRAINING);
                    $general_experience = carbon_get_the_post_meta( Staffs::STAFF_GENERAL_EXPERIENCE);
                    $teaching_experience = carbon_get_the_post_meta( Staffs::STAFF_TEACHING_EXPERIENCE);

                    ?>

                    <div class="col search-block">
                        <div class="card h-100">
                            <div class="row gx-1">
                                <div class="col-lg-4 gradient-custom d-flex align-items-center justify-content-center gx-5" style="border-top-left-radius: 0.3rem; border-bottom-left-radius: 0.3rem;">
                                    <img src="<?php echo get_the_post_thumbnail_url() ?? '' ?>" class="img-fluid rounded-3 my-3" alt="">
                                </div>
                                <div class="col-12 col-lg-8 ps-3">
                                    <h3 class="py-2 border-bottom text-black-75"><?php the_title('','');?></h3>
                                    <h5 class="text-secondary"><?= Staffs::getTermsParameters($positions_staffs);?></h5>
                                    <p class="text-secondary"></p>
                                    <table class="table table-hover">
                                        <tbody>
                                        <tr class="mb-2">
                                            <th scope="row" class="p-1" style="width: 35%;">Email:</th>
                                            <td class="p-1 text-600"><?= $mail ?: carbon_get_theme_option(DEFAULT_EMAIL);?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row"  class="p-1" style="width: 35%;">Телефон:</th>
                                            <td class="p-1 text-600"><?= $phone ?: carbon_get_theme_option(DEFAULT_PHONE);?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row"  class="p-1" style="width: 35%;">Время работы (приёма):</th>
                                            <td class="p-1">
                                                <?= $working_hours ?: carbon_get_theme_option(DEFAULT_WORK_TIME);?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row"  class="p-1" style="width: 35%;">Кабинет:</th>
                                            <td class="p-1">
                                                <?= $cabinet->name ?: '';?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row"  class="p-1" style="width: 35%;">Образование:</th>
                                            <td class="p-1"><?= Staffs::getTermsParameters($taxonomy_education); ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row"  class="p-1" style="width: 35%;">Категория:</th>
                                            <td class="p-1"><?= Staffs::getTermsParameters($taxonomy_education_category); ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row"  class="p-1" style="width: 35%;">Год повышения квалификации:</th>
                                            <td class="p-1"><?= $year_advanced_training ?: ''; ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row"  class="p-1" style="width: 35%;">Общий стаж работы:</th>
                                            <td class="p-1"><?= Staffs::getTimeDiff($general_experience); ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row"  class="p-1" style="width: 35%;">Педагогический стаж работы:</th>
                                            <td class="p-1"><?= Staffs::getTimeDiff($teaching_experience); ?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php endwhile; ?>

                <?php else: ?>
                    <div class="col">
                        <div class="alert alert-warning" role="alert">
                            Записи не найдены
                        </div>
                    </div>

                <?php endif; ?>
                </div>
                <?php
            });
    }
}
