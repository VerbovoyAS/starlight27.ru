<?php

use HashtagCore\Staffs;

$positions_staffs = Staffs::get_terms_by_tax(get_the_ID(), 'positions_staffs');
$taxonomy_education = Staffs::get_terms_by_tax(get_the_ID(), 'taxonomy_education');
$taxonomy_education_category = Staffs::get_terms_by_tax(get_the_ID(), 'taxonomy_education_category');
//  Получаем дополнительные поля
$phone = carbon_get_the_post_meta( Staffs::STAFF_PHONE);
$mail = carbon_get_the_post_meta( Staffs::STAFF_MAIL);
$working_hours = carbon_get_the_post_meta( Staffs::STAFF_WORKING_HOURS);
$year_advanced_training = carbon_get_the_post_meta( Staffs::STAFF_YEAR_ADVANCED_TRAINING);
$general_experience = carbon_get_the_post_meta( Staffs::STAFF_GENERAL_EXPERIENCE);
$teaching_experience = carbon_get_the_post_meta( Staffs::STAFF_TEACHING_EXPERIENCE);

?>

<div class="container ">
    <div class="row">
        <div class="col px-0">
            <div class="card bg-dark text-white mb-2">
                <img src="https://creativo.one/lessons/les5669/01.jpg" class="card-img" alt="...">
                <div class="card-img-overlay d-flex flex-column justify-content-center align-items-center">
                    <h1 class="card-title 1"><?php the_title(); ?></h1>
                </div>
            </div>
        </div>
    </div>
</div>

<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-4 ps-0">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <img src="<?php echo get_the_post_thumbnail_url() ?>" alt="avatar"
                             class="rounded img-fluid" style="width: 150px;">
                        <h5 class="my-3"><?php the_title();?></h5>
                        <p class="text-muted mb-4"><?= Staffs::getTermsParameters($positions_staffs);?></p>
                        <div class="d-flex justify-content-center mb-2">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 pe-0">
                <div class="card mb-4">
                    <div class="card-body">
                        <?php Staffs::getParametersHtml('Образование:', Staffs::getTermsParameters($taxonomy_education)); ?>
                        <hr>
                        <?php Staffs::getParametersHtml('Категория:', Staffs::getTermsParameters($taxonomy_education_category)); ?>
                        <hr>
                        <?php Staffs::getParametersHtml('Телефон:', $phone ?: carbon_get_theme_option(DEFAULT_PHONE)); ?>
                        <hr>
                        <?php Staffs::getParametersHtml('E-mail:', $mail ?: carbon_get_theme_option(DEFAULT_EMAIL)); ?>
                        <hr>
                        <?php Staffs::getParametersHtml('Год повышения квалификации:', $year_advanced_training ?: ' '); ?>
                        <hr>
                        <?php Staffs::getParametersHtml('Время работы (приёма):', $working_hours ?: carbon_get_theme_option(DEFAULT_WORK_TIME)); ?>
                        <hr>
                        <?php Staffs::getParametersHtml('Общий стаж работы:', Staffs::getTimeDiff($general_experience)); ?>
                        <hr>
                        <?php Staffs::getParametersHtml('Педагогический стаж работы:', Staffs::getTimeDiff($teaching_experience)); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>