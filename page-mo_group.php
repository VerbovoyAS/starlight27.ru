<?php

get_header();

// Получаем страницу МО по таксаномии
function getPostMO(int $term_id): array
{
    return get_posts(
        [
            'post_type'      => 'mo_page',
            'posts_per_page' => 1,
            'tax_query'      => [
                [
                    'taxonomy' => 'mo_group',
                    'field'    => 'term_id',
                    'terms'    => $term_id,
                ]
            ],
            'orderby'        => 'ID',
            'order'          => 'ASC',
        ]
    );
}

?>
    <div class="container-lg">
        <div class="row">
            <div class="col px-0">
                <div class="card card-custom-img rounded-0 rounded-bottom bg-dark text-white mb-2">
                    <div class="card-img-overlay d-flex flex-column justify-content-center align-items-center">
                        <h1 class="card-title text-center" style="text-shadow: 2px 2px 2px black;">
                            <?php the_title(); ?>
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container-lg">
        <div class="row pb-2 px-2 px-lg-0">
            <div class="col-12 col-lg-8 text-muted">
                <!-- Breadcrumbs -->
                <?php if (function_exists('fw_ext_breadcrumbs')) {
                    fw_ext_breadcrumbs();
                } ?>
                <!-- /breadcrumb -->
            </div>
            <div class="col-12 col-lg-4 d-flex align-items-center justify-content-end">
                <div class="row w-100">
                    <div class="col">

                    </div>
                </div>
            </div>
        </div>
        <div class="row px-2 px-lg-0">
            <div class="col-12">
                <div class="row">
                    <div class="col shadow mb-2 p-3 bg-body rounded-3">
                        <?php
                        the_content();

                        // Получаем все термины таксономии
                        $terms = get_terms(
                            [
                                'taxonomy'   => 'mo_group',
                                'hide_empty' => false,
                            ]
                        );
                        ?>

                        <?php if (!empty($terms) && !is_wp_error($terms)):
                            $countTerms = count($terms);
                            $isNotEven = (bool)($countTerms % 2);
                            ?>
                            <div class="row g-3 row-cols-1 py-2 row-cols-md-2 row-cols-lg-2">
                                <?php foreach ($terms as $key => $term): $posts = getPostMO($term->term_id) ?>

                                    <?php if (!empty($posts)):
                                        $first_post = $posts[0];
                                        $offset = (($key + 1 === $countTerms) && $isNotEven) ? 'offset-md-3' : '';
                                        ?>
                                        <a class="text-decoration-none link-secondary <?= $offset; ?>"
                                           href="<?= get_permalink($first_post->ID); ?>">
                                            <div class="d-flex align-items-center rounded-3 shadow mb-2 p-3 bg-body h-100">
                                                <i class="bi bi-star px-4" style="font-size: 1.75rem;"></i>
                                                <h4 class="fw-bold mb-0"><?= $term->name; ?></h4>
                                            </div>
                                        </a>
                                    <?php else: ?>
                                        <p>МО пока не добавлены.</p>
                                    <?php endif; ?>

                                <?php endforeach; ?>
                            </div>

                        <?php else: ?>
                            <p>МО пока не добавлены.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
get_footer();
