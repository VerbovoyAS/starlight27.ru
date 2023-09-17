<?php

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
    <div class="container ">
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

    <div class="container ">
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
                    <div class="col shadow mb-2 p-3 bg-body rounded-3 stars">
                        <?php get_sidebar(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
get_footer();
