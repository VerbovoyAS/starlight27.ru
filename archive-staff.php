<?php
/**
 * Страница отображения Всех сотрудников
 *
 * @package hashtag
 */

use HashtagCore\Hashtag;
use HashtagCore\Staffs;

get_header();
?>
<style>
    .gradient-custom {
        /* fallback for old browsers */
        background: #65e5f6;

        /* Chrome 10-25, Safari 5.1-6 */
        background: -webkit-linear-gradient(to right bottom, rgba(198, 101, 246, 1), rgba(133, 167, 253, 1));

        /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        background: linear-gradient(to right bottom, rgba(198, 101, 246, 1), rgba(133, 167, 253, 1))
    }
</style>

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
            <div class="col-12 col-lg-8 ps-0">
                <div class="row mb-3">
                    <div class="col">
                        <form method="post" action="<?= get_post_type_archive_link(POST_TYPE_STAFF) ?>">
                            <div class="input-group">
                                <?php Staffs::terms_select('positions_staffs', 'Все сотрудники') ?>
                                <input class="btn btn-outline-secondary" type="submit" name="submit" value="Выбрать">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row row-cols-1 g-3">
                    <?php
                    $arg = [
                        'post_type'      => POST_TYPE_STAFF,
                        'posts_per_page' => -1,
                        'orderby'        => 'meta_query',
                        'order'          => 'DESC',
                        'meta_query'     => [
                            'key' => 'parent',
                        ]
                    ];

                    if (isset($_POST['submit'])) {
                        $arg['tax_query'] = ['relation' => 'AND'];

                        if (isset($_POST['positions_staffs_select']) && !empty($_POST['positions_staffs_select'])) {
                            $arg['tax_query'][] = [
                                'taxonomy' => 'positions_staffs',
                                'terms'    => $_POST['positions_staffs_select']
                            ];
                        }
                    }

                    $query = new WP_Query($arg);
                    if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
                        // пропускаем не активные записи
                        if (!carbon_get_the_post_meta(Staffs::STAFF_ACTIVE)) {
                            continue;
                        }

                        //  Получаем terms таксонов
                        $positions_staffs = Staffs::get_terms_by_tax(get_the_ID(), 'positions_staffs');
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
                        <div class="col">
                            <div class="card h-100 ">
                                <div class="row g-0">
                                    <div class="col-md-4 gradient-custom text-center text-white"
                                         style="border-top-left-radius: 0.3rem; border-bottom-left-radius: 0.3rem;">
                                        <img src="<?php echo get_the_post_thumbnail_url() ?? '' ?>"
                                             class="img-fluid mt-5 mb-2 rounded-3 w-75" alt=""/>
                                        <a class="text-decoration-none link-light" href="<?php the_permalink();?>">
                                            <h5><?php Staffs::explodeName(the_title('','', false));?></h5>
                                        </a>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h4><?= Staffs::getTermsParameters($positions_staffs);?></h4>
                                            <hr class="mt-0 mb-4">
                                            <div class="row pt-1">
                                                <div class="col-4 mb-3">
                                                    <h6>Email</h6>
                                                    <p class="text-muted"><?= $mail ?: carbon_get_theme_option(DEFAULT_EMAIL);?></p>
                                                </div>
                                                <div class="col-4 mb-3">
                                                    <h6>Телефон</h6>
                                                    <p class="text-muted"><?= $phone ?: carbon_get_theme_option(DEFAULT_PHONE);?></p>
                                                </div>
                                                <div class="col-4 mb-3">
                                                    <h6>Время работы (приёма)</h6>
                                                    <p class="text-muted"><?= $working_hours ?: carbon_get_theme_option(DEFAULT_WORK_TIME);?></p>
                                                </div>
                                            </div>
                                            <hr class="mt-0 mb-4">
                                            <div class="row pt-1">
                                                <div class="col-4 mb-3">
                                                    <h6>Образование</h6>
                                                    <p class="text-muted"><?= Staffs::getTermsParameters($taxonomy_education); ?></p>
                                                </div>
                                                <div class="col-4 mb-3">
                                                    <h6>Категория</h6>
                                                    <p class="text-muted"><?= Staffs::getTermsParameters($taxonomy_education); ?></p>
                                                </div>
                                                <div class="col-4 mb-3">
                                                    <h6>Год повышения квалификации</h6>
                                                    <p class="text-muted"><?= $year_advanced_training ?: ''; ?></p>
                                                </div>
                                            </div>
                                            <hr class="mt-0 mb-4">
                                            <div class="row pt-1">
                                                <div class="col-6 mb-3">
                                                    <h6>Общий стаж работы</h6>
                                                    <p class="text-muted"><?= Staffs::getTimeDiff($general_experience); ?></p>
                                                </div>
                                                <div class="col-6 mb-3">
                                                    <h6>Педагогический стаж работы</h6>
                                                    <p class="text-muted"><?= Staffs::getTimeDiff($teaching_experience); ?></p>
                                                </div>
                                            </div>
                                        </div>
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
            </div>

            <div class="col-12 col-lg-4">
                <div class="row">
                    <div class="col shadow mb-2 p-3 bg-body rounded-3 stars">
                        <?php get_sidebar(); ?>
                    </div>
                </div>
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
            </div>
        </div>
    </div>
