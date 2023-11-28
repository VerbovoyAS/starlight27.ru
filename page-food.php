<?php

use HashtagCore\Hashtag;

function getListFood(string $path)
{
    if (!is_dir($path)) {
        return 'Указанная папка не найдена';
    }

    $list = scandir($path);
    if (!$list) {
        return 'Файлы или директория не найдена';
    }
    return $list;
}

get_header();
?>
    <div class="container-lg">
        <div class="row">
            <div class="col px-0">
                <div class="card card-custom-img rounded-0 rounded-bottom bg-dark text-white mb-2">
                    <div class="card-img-overlay d-flex flex-column justify-content-center align-items-center">
                        <h1 class="card-title text-center" style="text-shadow: 2px 2px 2px black;"><?php the_title(); ?></h1>
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
                        <?php
                        $url = '/wp-content/uploads/food/';
                        $files = $_SERVER['DOCUMENT_ROOT'] . $url;
                        $list = getListFood($files);
                        if (is_array($list)) {
                            echo '<ul>';
                            foreach ($list as $name) {
                                if (strlen($name) <= 2) {
                                    continue;
                                }
                                $nameLink = substr($name, 0, 10);
                                $link = $url . $name;
                                echo '<li>';
                                echo "<a download href='$link'>$nameLink</a>";
                                echo '</li>';
                            }
                            echo '</ul>';
                        } else {
                            echo "<h1 class=\" text-center\">{$list}</h1>";
                        }

                        ?>
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
