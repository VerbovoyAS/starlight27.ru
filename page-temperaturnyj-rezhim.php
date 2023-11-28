<?php

use HashtagCore\Hashtag;

$temp = file_get_contents(get_template_directory_uri() . "/temperature.json");

$error = "";
$t = [];
if (!$temp) {
    $error = "Ошибка получения файла";
} else {
    $t = json_decode($temp, true);
}


get_header();
?>
    <div class="container-lg">
        <div class="row">
            <div class="col px-0">
                <div class="card card-custom-img rounded-0 rounded-bottom bg-dark text-white mb-2">
                    <div class="card-img-overlay d-flex flex-column justify-content-center align-items-center">
                        <h1 class="card-title text-center" style="text-shadow: 2px 2px 2px black;"><?php the_title(
                            ); ?></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-lg">
        <div class="row ">
            <div class="col-12 col-lg-8">
                <div class="row me-1">
                    <div class="col shadow mb-2 p-3 bg-body rounded-3">
                        <?php the_content();?>
                        <?php
                        if (!empty($error)) {
                            echo $error;
                        }
                        ?>
                        <table class="table">
                            <tbody>
                        <?php
                        foreach ($t as $blockName => $kabinets) { ?>
                            <tr>
                                <th colspan="3" style="text-align: center"><?= $blockName; ?></th>
                            </tr>
                            <tr>
                                <th style="text-align: center">кабинет - t&#176;</th>
                                <th style="text-align: center">кабинет - t&#176;</th>
                                <th style="text-align: center">кабинет - t&#176;</th>
                            </tr>
                            <?php
                            foreach (array_chunk($kabinets, 3) as $chunk) {
                                $kab = '';
                                foreach ($chunk as $c) {
                                    if (empty($c)) {
                                        continue;
                                    }

                                    $kab .= '<td style="text-align: center">' . $c . '&#176;</td>';
                                }
                                echo '<tr>' . $kab . '</tr>';
                            }
                        }
                        ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="row">
                    <div class="col shadow mb-2 p-3 bg-body rounded-3">
                        <h3 class="text-center">Свежие записи</h3>

                        <?php
                        $query = new WP_Query(['category_name' => DEFAULT_CATEGORY]);
                        if ($query->have_posts()) :
                        while ($query->have_posts()) : $query->the_post();
                            $img_url = get_the_post_thumbnail_url() ?: Hashtag::getDefaultImg();
                            ?>
                            <div class="col">
                                <div class="d-flex row g-0">
                                    <div class="col-md-4 d-flex align-items-start p-1">
                                        <a href="<?php the_permalink(); ?>">
                                            <img src="<?php echo $img_url; ?>"
                                                 alt="..." class="img-fluid rounded d-inline-block">
                                        </a>
                                    </div>
                                    <div class="col-md-8 p-1">
                                        <div class="pb-2">
                                            <a class="text-decoration-none link-secondary"
                                               href="<?php the_permalink(); ?>">
                                                <h5 class="card-title"><?php the_title(); ?></h5>
                                            </a>
                                            <div class="d-flex justify-content-between flex-column">
                                                <p class="card-text"><small class="text-muted"><?php the_time(
                                                            'j F Y'
                                                        ); ?></small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php endwhile; ?>
                    </div>

                    <?php else: ?>
                        <div class="col">
                            <div class="alert alert-warning" role="alert">
                                Записи не найдены
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="row">
                    <div class="col shadow mb-2 p-3 bg-body rounded-3 stars">
                        <?php get_sidebar(); ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
<?php
get_footer();
