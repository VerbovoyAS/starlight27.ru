<?php
/**
 * Страница отображения Списка сведений ОУ
 *
 * @package hashtag
 */

get_header();
?>

<div class="container ">
    <div class="row">
        <div class="col px-0">
            <div class="card bg-dark text-white mb-2">
                <img src="https://creativo.one/lessons/les5669/01.jpg" class="card-img" alt="...">
                <div class="card-img-overlay d-flex flex-column justify-content-center align-items-center">
                    <h1 class="card-title 1"><?php the_archive_title(); ?></h1>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container ">
    <div class="row ">
        <div class="col-12 p-lg-0">
            <div class="row g-3 row-cols-1 row-cols-md-2 row-cols-lg-2 py-2">
                <?php
                $arg = [
                    'post_type'      => POST_TYPE_BASIC_INFO,
                    'posts_per_page' => -1,
                    'orderby'        => 'meta_query',
                    'order'          => 'ASC',
                    'meta_query'     => [
                        'key' => 'parent',
                    ]
                ];

                $query = new WP_Query($arg);
                $countPosts = $query->post_count;
                $isNotEven = (bool)($countPosts % 2);
                if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();

                    $icon = carbon_get_the_post_meta(BASIC_INFO_ICON) ?: 'bi bi-envelope-at';
                    $offset = (($query->current_post + 1 === $countPosts) && $isNotEven) ? 'offset-md-3' : '';
                    ?>
                    <a class="text-decoration-none link-secondary <?= $offset ?: ''; ?>" href="<?php the_permalink(); ?>">
                        <div class="d-flex align-items-center rounded-3 shadow mb-2 p-3 bg-body h-100">
                            <i class="<?= $icon; ?> px-4" style="font-size: 1.75rem;"></i>
                            <h4 class="fw-bold mb-0"><?= the_title(); ?></h4>
                        </div>
                    </a>
                <?php endwhile; ?>

                <?php else: ?>
                    <div class="col">
                        <div class="alert alert-warning" role="alert">
                            Записи не найдены
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
