<?php
/**
 * Шаблон таблицы расписания по классам
 */

function getScheduleStyleWeekday(DateTime $date): string
{
    $colors = [
        1 => 'primary',    // Пн
        2 => 'secondary',  // Вт
        3 => 'warning',    // Ср
        4 => 'success',    // Чт
        5 => 'info',       // Пт
        6 => 'danger',     // Сб
    ];

    $weekdayIndex = (int)$date->format('N');

    return $colors[$weekdayIndex] ?? 'light';
}
?>

<div class="d-none d-lg-block">
    <div class="table-responsive">
        <table class="table table-bordered text-center align-middle schedule-table">
            <thead class="table-light">
            <tr>
                <th class="text-body-secondary" style="width: 5%;">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <h6 class="text-body-secondary">Урок</h6>
                    </div>
                </th>
                <?php foreach ($dates as $date): ?>
                    <th>
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <?php $dateTime = DateTime::createFromFormat('Y-m-d', $date); ?>
                            <h6 class="text-body-secondary"><?= getRussianWeekday($dateTime); ?></h6>
                            <h6 class="text-body-secondary"><?= $dateTime->format('d.m.Y'); ?></h6>
                        </div>
                    </th>
                <?php endforeach; ?>
            </tr>
            </thead>
            <tbody>
            <?php for ($i = 1; $i <= $max_lesson_number; $i++): ?>
                <tr>
                    <th class="align-middle">
                        <div class="d-flex justify-content-center h-100 w-100">
                            <div class="text-muted"><?= $i ?></div>
                        </div>
                    </th>
                    <?php foreach ($dates as $date): ?>
                        <?php if (!empty($lessons_by_day[$date][$i])): ?>
                            <?php
                            $dateTime = DateTime::createFromFormat('Y-m-d', $date);
                            $color = getScheduleStyleWeekday($dateTime);
                            ?>
                            <td>
                                <?php
                                $items = $lessons_by_day[$date][$i] ?? [];
                                // Проверяем, все ли элементы имеют одинаковое название
                                $allSameName = count($items) > 1 && count(array_unique(array_column($items, 'name'))) === 1;
                                // Объединим уроки с одинаковыми названиями
                                if ($allSameName):
                                    ?>
                                    <div class="alert alert-<?= $color ?> mb-1">
                                        <div class="d-flex flex-wrap">
                                            <div class="fw-bold"><?= $items[0]['name'] ?? '---' ?></div>
                                            <?php foreach ($items as $item): ?>
                                                <div class="d-flex justify-content-between w-100 flex-wrap">
                                                    <div><?= $item['teacher'] ?? '---' ?></div>
                                                    <div><?= $item['cabinet'] ?? '---' ?></div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <?php foreach ($lessons_by_day[$date][$i] as $item): ?>
                                        <div class="alert alert-<?= $color ?> mb-1">
                                            <div class="d-flex flex-wrap">
                                                <div class="fw-bold"><?= $item['name'] ?? '---' ?></div>
                                                <div class="d-flex justify-content-between w-100 flex-wrap">
                                                    <div><?= $item['teacher'] ?? '---' ?></div>
                                                    <div><?= $item['cabinet'] ?? '---' ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </td>
                        <?php else: ?>
                            <td class="empty"></td>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tr>
            <?php endfor; ?>
            </tbody>
        </table>
    </div>
</div>
<!-- Для мобильной версии -->
<div class="d-block d-lg-none">
    <?php foreach ($lessons_by_day as $date => $lessons): ?>
        <div class="mb-4">

            <div class="d-flex justify-content-between flex-wrap">
                <?php
                $dateTime = DateTime::createFromFormat('Y-m-d', $date);
                $color = getScheduleStyleWeekday($dateTime);
                ?>
                <h5 class="text-body-secondary"><?= getRussianWeekday($dateTime); ?></h5>
                <h5 class="mb-2 text-body-secondary"><?= $dateTime->format('d.m.Y'); ?></h5>
            </div>

            <?php for ($i = 1; $i <= $max_lesson_number; $i++): ?>
                <?php if (!empty($lessons[$i])): ?>
                    <?php
                    $items = $lessons[$i] ?? [];
                    // Проверяем, все ли элементы имеют одинаковое название
                    $allSameName = count($items) > 1 && count(array_unique(array_column($items, 'name'))) === 1;
                    // Объединим уроки с одинаковыми названиями
                    if ($allSameName): ?>
                        <div class="card border-<?= $color ?> mb-2 shadow-sm">
                            <div class="card-header"><?= $i ?>. <?= htmlspecialchars($item['name']) ?></div>
                            <div class="card-body p-2">
                                <?php foreach ($lessons[$i] as $item): ?>
                                    <div class="d-flex justify-content-between small ">
                                        <span><?= $item['teacher'] ?? '---' ?></span>
                                        <span><?= $item['cabinet'] ?? '---' ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <?php foreach ($lessons[$i] as $item): ?>
                            <div class="card border-<?= $color ?> mb-2 shadow-sm">
                                <div class="card-header"><?= $i ?>. <?= htmlspecialchars($item['name']) ?></div>
                                <div class="card-body p-2">
                                    <div class="d-flex justify-content-between small ">
                                        <span><?= $item['teacher'] ?? '---' ?></span>
                                        <span><?= $item['cabinet'] ?? '---' ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endfor; ?>
        </div>
    <?php endforeach; ?>
</div>
