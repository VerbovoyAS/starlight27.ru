<?php
// Получим список классов по группам
$classesGroup = getGroupClassV1();
// Задаем порядок, так как в getGroupClassV1 они могут приходить не упорядочено
$classes = [
    '1-4'   => $classesGroup['1-4'] ?? [],
    '5-9'   => $classesGroup['5-9'] ?? [],
    '10-11' => $classesGroup['10-11'] ?? [],
];

// Для вывода в заголовок
$className = "";
if (!empty($_POST['class'])) {
    $className = sanitize_text_field($_POST['class']);
}
// Проверим, существует ли указанный класс.
$exists = false;
foreach ($classes as $group) {
    if (in_array($className, $group, true)) {
        $exists = true;
        break;
    }
}
// Если указанного класса не существует, то пустая строка
if (!$exists) {
    $className = "";
}

get_header();
?>
<style>
    .schedule-table {
        table-layout: fixed;
    }

    .schedule-table th,
    .schedule-table td {
        vertical-align: top;
        min-height: 50px;
        padding: 6px;
    }

    .alert {
        padding: 0.5rem;
        margin-bottom: 0;
        font-size: 0.85rem;
    }

    .empty {
        background-color: #f8f9fa;
    }
</style>

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
        <div class="col-12">
            <div class="row">
                <div class="col shadow mb-2 p-3 bg-body rounded-3">
                    <?php the_content(); ?>

                    <div class="d-flex flex-column mb-3">
                        <h3 id="schedule-title"><i class="bi bi-calendar-week"></i> Расписание</h3>
                        <div class="d-flex w-100 align-items-end">
                            <div>
                                <label for="classes" class="form-label">Неделя</label>
                                <select id="week" class="form-select" aria-label="Выберите неделю">
                                    <option selected value="0">Текущая</option>
                                    <option value="1">Следующая</option>
                                    <option value="-1">Предыдущая</option>
                                </select>
                            </div>

                            <div class="ms-3">
                                <label for="classes" class="form-label">Класс</label>
                                <select id="classes" class="form-select">
                                    <option selected disabled>Выберите класс</option>
                                    <?php foreach ($classes as $group => $list): ?>
                                        <optgroup label="<?= htmlspecialchars($group) ?>">
                                            <?php foreach ($list as $class): ?>
                                                <option value="<?= htmlspecialchars($class) ?>">
                                                    <?= htmlspecialchars($class) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </optgroup>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="ms-sm-auto ms-2 d-flex align-items-end">
                                <button class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-clockwise" aria-label="Загрузить"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive position-relative" id="schedule-table-container">
                        <div class="text-center position-absolute top-50 start-50 translate-middle d-none"
                             id="schedule-loader">
                            <div class="spinner-border text-primary" role="status"></div>
                        </div>
                        <div id="schedule-table">
                            <div class="alert alert-info text-center" role="alert">
                                🏫 Пожалуйста, выберите класс и нажмите кнопку <i class="bi bi-arrow-clockwise"></i>,
                                чтобы отобразить расписание.
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
