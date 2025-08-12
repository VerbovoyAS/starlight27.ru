<!DOCTYPE html>
<html <?php language_attributes(); ?>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php the_title(); ?></title>
    <?php wp_head();?>
</head>

<body>
    <style>
        .schedule-table th:not(:first-child),
        .schedule-table td:not(:first-child) {
            min-width: 330px;
        }

        .schedule-table thead th {
            position: sticky;
            top: 0;
            background-color: #fff;
            z-index: 10;
        }

        .table-bordered th,
        .table-bordered td {
            border-width: 2px !important;
            border-color: #dee2e6;
        }

        .schedule-table a {
            padding-left: auto 1em;
        }
    </style>

    <div class="container-fluid my-4">
        <div class="row">
            <div class="col-10 table-responsive">
                <!-- Глобальный лоадер -->
                <div id="schedule-loader" class="position-fixed top-50 start-50 translate-middle d-none z-1050 bg-white bg-opacity-75 rounded p-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Загрузка...</span>
                    </div>
                </div>

                <!-- Контейнер расписания -->
                <div id="schedule-table-wrapper">
                    <div id="schedule-table-container" class="transition-opacity"></div>
                </div>
            </div>
            <div class="col-2">
                <div class="d-flex flex-column justify-content-center">
                    <h3>Классы</h3>
                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                        <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btnradio1">1-4</label>

                        <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off" checked>
                        <label class="btn btn-outline-primary" for="btnradio2">5-9</label>

                        <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btnradio3">10-11</label>
                    </div>
                    <hr>
                    <h3>Неделя</h3>
                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group" id="weekSelector">
                        <input type="radio" class="btn-check" name="weekRadio" id="weekPrev" autocomplete="off">
                        <label class="btn btn-outline-primary" for="weekPrev">Пред.</label>

                        <input type="radio" class="btn-check" name="weekRadio" id="weekCurrent" autocomplete="off" checked>
                        <label class="btn btn-outline-primary" for="weekCurrent">Текущая</label>

                        <input type="radio" class="btn-check" name="weekRadio" id="weekNext" autocomplete="off">
                        <label class="btn btn-outline-primary" for="weekNext">След.</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
л
<?php wp_footer();?>

</body>
</html>
