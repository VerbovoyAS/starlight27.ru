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
        background: #174a99;
        background-image: url(<?= get_template_directory_uri() . '/assets/img/site/staff-bg.svg';?>);
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }
</style>

    <div class="container ">
        <div class="row">
            <div class="col px-0">
                <div class="card card-custom-img rounded-0 rounded-bottom bg-dark text-white mb-2">
                    <div class="card-img-overlay d-flex flex-column justify-content-center align-items-center">
                        <h1 class="card-title 1"><?php the_archive_title(); ?></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container ">
        <div class="row ">
            <div class="col-12 col-lg-8 ps-lg-0">
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
                        $cabinet = carbon_get_the_post_meta( Staffs::STAFF_CABINET);
                        $speciality = carbon_get_the_post_meta( Staffs::STAFF_SPECIALITY);
                        $year_advanced_training = carbon_get_the_post_meta( Staffs::STAFF_YEAR_ADVANCED_TRAINING);
                        $general_experience = carbon_get_the_post_meta( Staffs::STAFF_GENERAL_EXPERIENCE);
                        $teaching_experience = carbon_get_the_post_meta( Staffs::STAFF_TEACHING_EXPERIENCE);
                        ?>
                        <div class="col">
                            <div class="card h-100">
                                <div class="row gx-1">
                                    <div class="col-lg-4 gradient-custom d-flex align-items-center justify-content-center gx-5" style="border-top-left-radius: 0.3rem; border-bottom-left-radius: 0.3rem;">
                                        <img src="<?php echo get_the_post_thumbnail_url() ?? '' ?>" class="img-fluid rounded-3 my-3" alt="">
                                    </div>
                                    <div class="col-12 col-lg-8 ps-3">
                                        <h3 class="py-2 border-bottom text-black-75"><?php the_title('','');?></h3>
                                        <h5 class="text-secondary"><?= Staffs::getTermsParameters($positions_staffs);?></h5>
                                        <p class="text-secondary"></p>
                                        <table class="table table-hover">
                                            <tbody>
                                            <tr class="mb-2">
                                                <th scope="row" class="p-1" style="width: 35%;">Email:</th>
                                                <td class="p-1 text-600"><?= $mail ?: carbon_get_theme_option(DEFAULT_EMAIL);?></td>
                                            </tr>
                                            <tr>
                                                <th scope="row"  class="p-1" style="width: 35%;">Телефон:</th>
                                                <td class="p-1 text-600"><?= $phone ?: carbon_get_theme_option(DEFAULT_PHONE);?></td>
                                            </tr>
                                            <tr>
                                                <th scope="row"  class="p-1" style="width: 35%;">Время работы (приёма):</th>
                                                <td class="p-1">
                                                    <?= $working_hours ?: carbon_get_theme_option(DEFAULT_WORK_TIME);?>
                                                </td>
                                            </tr>
                                            <?php if($cabinet):?>
                                            <tr>
                                                <th scope="row"  class="p-1" style="width: 35%;">Кабинет:</th>
                                                <td class="p-1">
                                                    <?= $cabinet;?>
                                                </td>
                                            </tr>
                                            <?php endif;?>
                                            <tr>
                                                <th scope="row"  class="p-1" style="width: 35%;">Образование:</th>
                                                <td class="p-1"><?= Staffs::getTermsParameters($taxonomy_education); ?></td>
                                            </tr>
                                            <?php if($speciality):?>
                                                <tr>
                                                    <th scope="row"  class="p-1" style="width: 35%;">Специальность:</th>
                                                    <td class="p-1"><?= $speciality; ?></td>
                                                </tr>
                                            <?php endif;?>
                                            <?php if($taxonomy_education_category):?>
                                            <tr>
                                                <th scope="row"  class="p-1" style="width: 35%;">Категория:</th>
                                                <td class="p-1"><?= Staffs::getTermsParameters($taxonomy_education_category); ?></td>
                                            </tr>
                                            <?php endif;?>
                                            <?php if($year_advanced_training):?>
                                            <tr>
                                                <th scope="row"  class="p-1" style="width: 35%;">Год повышения квалификации:</th>
                                                <td class="p-1"><?= $year_advanced_training; ?></td>
                                            </tr>
                                            <?php endif;?>
                                            <tr>
                                                <th scope="row"  class="p-1" style="width: 35%;">Общий стаж работы:</th>
                                                <td class="p-1"><?= Staffs::getTimeDiff($general_experience); ?></td>
                                            </tr>
                                            <tr>
                                                <th scope="row"  class="p-1" style="width: 35%;">Педагогический стаж работы:</th>
                                                <td class="p-1"><?= Staffs::getTimeDiff($teaching_experience); ?></td>
                                            </tr>
                                            </tbody>
                                        </table>
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
                        <h3 class="text-center text-secondary">Свежие записи</h3>

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
