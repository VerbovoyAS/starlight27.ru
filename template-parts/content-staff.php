<?php

use HashtagCore\Staffs;

$positions_staffs = Staffs::get_terms_by_tax(get_the_ID(), 'positions_staffs');
$taxonomy_education = Staffs::get_terms_by_tax(get_the_ID(), 'taxonomy_education');
$taxonomy_education_category = Staffs::get_terms_by_tax(get_the_ID(), 'taxonomy_education_category');
//  Получаем дополнительные поля
$phone = carbon_get_the_post_meta( Staffs::STAFF_PHONE);
$mail = carbon_get_the_post_meta( Staffs::STAFF_MAIL);
$working_hours = carbon_get_the_post_meta( Staffs::STAFF_WORKING_HOURS);
$cabinet = carbon_get_the_post_meta( Staffs::STAFF_CABINET);
$speciality = carbon_get_the_post_meta( Staffs::STAFF_SPECIALITY);
$year_advanced_training = carbon_get_the_post_meta( Staffs::STAFF_YEAR_ADVANCED_TRAINING);
$general_experience = carbon_get_the_post_meta( Staffs::STAFF_GENERAL_EXPERIENCE);
$teaching_experience = carbon_get_the_post_meta( Staffs::STAFF_TEACHING_EXPERIENCE);
$staff_edu_program = carbon_get_the_post_meta( Staffs::STAFF_EDU_PROGRAM);

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

<section>
    <div class="container-lg">
        <div class="row">
            <div class="col-lg-4 ps-0">
                <div class="card mb-4">
                    <div class="card-body text-center p-4">
                        <img src="<?php echo get_the_post_thumbnail_url() ?>" alt="avatar"
                             class="rounded img-fluid">
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
                        <?php
                        if ($taxonomy_education_category) {
                            Staffs::getParametersHtml('Категория:', Staffs::getTermsParameters($taxonomy_education_category));
                            echo "<hr>";
                        }

                        if ($speciality) {
                            Staffs::getParametersHtml('Специальность:', $speciality);
                            echo "<hr>";
                        }
                        ?>
                        <hr>
                        <?php if($staff_edu_program):?>
                            <tr>
                                <th scope="row"  class="p-1" style="width: 35%;">Реализация ОП:</th>
                                <td class="p-1">
                                    <?= $staff_edu_program;?>
                                </td>
                            </tr>
                        <?php endif;?>
                        <hr>
                        <?php Staffs::getParametersHtml('Телефон:', $phone ?: carbon_get_theme_option(DEFAULT_PHONE)); ?>
                        <hr>
                        <?php Staffs::getParametersHtml('E-mail:', $mail ?: carbon_get_theme_option(DEFAULT_EMAIL)); ?>
                        <hr>
                        <?php
                        if ($year_advanced_training) {
                            Staffs::getParametersHtml('Год повышения квалификации:', (new DateTime($year_advanced_training))->format('Y') ?: ' ');
                            echo "<hr>";
                        }

                        if ($working_hours) {
                            Staffs::getParametersHtml('Время работы (приёма):', $working_hours ?: carbon_get_theme_option(DEFAULT_WORK_TIME));
                            echo "<hr>";
                        }

                        if ($cabinet) {
                            Staffs::getParametersHtml('Кабинет:', $cabinet);
                            echo "<hr>";
                        }
                        ?>
                        <?php Staffs::getParametersHtml('Общий стаж работы:', Staffs::getTimeDiff($general_experience)); ?>
                        <hr>
                        <?php Staffs::getParametersHtml('Педагогический стаж работы:', Staffs::getTimeDiff($teaching_experience)); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
