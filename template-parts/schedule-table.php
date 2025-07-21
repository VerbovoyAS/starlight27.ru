<?php
/**
 * Шаблон таблицы расписания
 * Ожидает переменные:
 * - $data: массив расписания
 * - $weekDays: массив дней недели
 */
?>

<table class="table table-bordered schedule-table bg-light">
    <thead>
    <tr>
        <th scope="col">
            <div class="d-flex justify-content-center align-items-center w-100">
                <p>Класс</p>
            </div>
        </th>

        <?php foreach ($weekDays as $weekDay):?>
            <th scope="col d-flex flex-column">
                <div class="text-center"><?= getRussianWeekday($weekDay); ?></div>
                <div class="text-center text-muted"><?= $weekDay->format('Y-m-d') ?></div>
            </th>
        <?php endforeach;?>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($data as $class):?>
        <tr>
            <th scope="row" class="align-middle text-center"><?=$class["class"] ?? "---" ?></th>
            <?php foreach ($class["lessons"] as $classLessons):?>
                <td class="p-0">
                    <div class="list-group list-group-flush">
                        <?php foreach ($classLessons["lessons"] as $lessons):?>
                            <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-start px-2">
                                <div class="ms-2 me-auto d-flex justify-content-between w-100">
                                    <div class="d-flex align-items-center">
                                        <span class="fw-bold"><?= $lessons["lesson_number"]?>.</span>
                                        <div class="fw-bold"><?=$lessons["items"][0]["name"] ?? "---"?></div>
                                    </div>
                                    <div class="d-flex flex-column justify-content-end align-items-center gap-1">
                                        <?php foreach ($lessons["items"] as $items):?>
                                            <div class="text-muted text-end w-100">
                                                <?=$items["teacher"] ?? "---" ?>
                                                <span class="badge text-bg-primary rounded-pill"><?=$items["cabinet"] ?? "____" ?></span>
                                            </div>
                                        <?php endforeach;?>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach;?>
                    </div>
                </td>
            <?php endforeach;?>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>