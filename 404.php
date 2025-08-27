<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package hashtag
 */
get_header();
?>
    <div class="container-lg">
        <div class="row">
            <div class="col px-0">
                <div class="card card-custom-img rounded-0 rounded-bottom bg-dark text-white mb-2">
                    <div class="card-img-overlay d-flex flex-column justify-content-center align-items-center">
                        <h1 class="card-title text-center" style="text-shadow: 2px 2px 2px black;">
                            Страница не найдена
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-lg">
        <div class="row px-2 px-lg-0">
            <div class="col-12">
                <div class="row">
                    <div class="d-flex justify-content-center">
                        <img src="<?= get_template_directory_uri(). '/assets/img/site/404.png';?>"
                             class="img-fluid w-50 d-block mx-auto"
                             alt="Пример">
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
get_footer();
