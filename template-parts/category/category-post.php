<?php
    use HashtagCore\Hashtag;
    $img_url = get_the_post_thumbnail_url() ?: Hashtag::getDefaultImg();
    if (!has_post_thumbnail()) {
        $img_url = Hashtag::getDefaultImg();
    }
    ?>

<div class="col">
    <div class="card shadow-sm h-100">
        <div class="img-category-post" style="background-image: url(<?= $img_url; ?>);">

        </div>
        <div class="card-body d-flex flex-column align-content-between">
            <a class="text-decoration-none link-secondary mb-auto" href="<?php the_permalink(); ?>">
                <h5 class="card-title"><?php the_title() ?></h5>
            </a>
            <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                    <a href="<?php the_permalink(); ?>" class="btn btn-sm btn-outline-secondary">Подробнее</a>
                </div>
                <small class="text-body-secondary"><?php the_time('j F Y'); ?></small>
            </div>
        </div>
    </div>
</div>
