<?php
$error = "";
try
{
    $temp = file_get_contents(get_template_directory_uri() . "/temperature.json");
} catch (Throwable $e) {
    // пока ни чего не делаем, после надо будет отправлять письмо на почту
    $error = "Ошибка получения файла";
}
$t = [];
if ($temp !== false) {
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
                    <div class="col shadow mb-2 p-3 bg-body rounded-3 stars">
                        <?php get_sidebar(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
get_footer();
