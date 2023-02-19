<?php
    use HashtagCore\Hashtag;
    $img_url = get_the_post_thumbnail_url() ?: Hashtag::getDefaultImg();
    if (!has_post_thumbnail()) {
        $img_url = Hashtag::getDefaultImg();
    }
    ?>

    <div class="col mb-2">
        <div class="d-flex row g-0">
            <div class="col-md-4 d-flex align-items-start p-1">
                <a href="<?= get_the_permalink(); ?>">
                    <img src="<?php echo $img_url; ?>"
                         alt="..." class="img-fluid rounded d-inline-block">
                </a>
            </div>
            <div class="col-md-8 p-1">
                <div class="d-flex flex-column h-100">
                    <a class="text-decoration-none link-secondary mb-auto" href="<?php the_permalink(); ?>">
                        <h5 class="card-title"><?php the_title() ?></h5>
                    </a>
                    <p class="card-text d-flex justify-content-end">
                            <?php the_time('j F Y'); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
<hr>
