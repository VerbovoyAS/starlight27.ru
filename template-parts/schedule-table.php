<?php
/**
 * Шаблон таблицы расписания (исправленный)
 * Ожидает переменные:
 * - $data: массив расписания
 * - $weekDays: массив DateTime объектов на неделю (Пн..Вс)
 *
 * Структура $data ожидается как:
 * [
 *   [
 *     "class" => "10ИТ",
 *     "lessons" => [
 *       ["date" => "2025-04-22", "lessons" => [
 *          ["lesson_number" => 1, "items" => [ ["name"=>"","teacher"=>"","cabinet"=>""] ]],
 *          ...
 *       ]],
 *       ...
 *     ]
 *   ],
 *   ...
 * ]
 */
?>

<?php if (empty($data)): ?>
    <div class="alert alert-info text-center">Нет данных для отображения.</div>
    <?php return; ?>
<?php endif; ?>

<table class="table table-bordered schedule-table bg-light">
    <thead>
    <tr>
        <th scope="col" style="width: 10%;">
            <div class="d-flex justify-content-center align-items-center w-100">
                <p class="mb-0">Класс</p>
            </div>
        </th>

        <?php foreach ($weekDays as $weekDay): ?>
            <th scope="col">
                <div class="text-center fw-semibold"><?= htmlspecialchars(getRussianWeekday($weekDay)) ?></div>
                <div class="text-center text-muted"><?= htmlspecialchars($weekDay->format('Y-m-d')) ?></div>
            </th>
        <?php endforeach; ?>
    </tr>
    </thead>

    <tbody>
    <?php foreach ($data as $class): ?>
        <?php
        $className = isset($class['class']) ? (string)$class['class'] : '---';
        $daysRaw = isset($class['lessons']) && is_array($class['lessons']) ? $class['lessons'] : [];

        // Индексация: дата (Y-m-d) => запись дня
        $byDate = [];
        foreach ($daysRaw as $dayRow) {
            $dateStr = isset($dayRow['date']) ? (string)$dayRow['date'] : null;
            if ($dateStr) {
                $byDate[$dateStr] = $dayRow;
            }
        }
        ?>
        <tr>
            <th scope="row" class="align-middle text-center"><?= htmlspecialchars($className) ?></th>

            <?php foreach ($weekDays as $weekDay): ?>
                <?php
                $dateKey = $weekDay->format('Y-m-d');
                $dayData = $byDate[$dateKey] ?? null;
                $lessonsList = ($dayData && isset($dayData['lessons']) && is_array($dayData['lessons'])) ? $dayData['lessons'] : [];

                // сортировка по номеру урока (на всякий случай)
                usort($lessonsList, function($a, $b) {
                    $la = isset($a['lesson_number']) ? (int)$a['lesson_number'] : 0;
                    $lb = isset($b['lesson_number']) ? (int)$b['lesson_number'] : 0;
                    return $la <=> $lb;
                });
                ?>

                <td class="p-0 align-top">
                    <?php if (!empty($lessonsList)): ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($lessonsList as $lesson): ?>
                                <?php
                                $num = isset($lesson['lesson_number']) ? (int)$lesson['lesson_number'] : 0;
                                $items = isset($lesson['items']) && is_array($lesson['items']) ? $lesson['items'] : [];
                                $first = $items[0] ?? [];
                                $name = isset($first['name']) ? (string)$first['name'] : '---';
                                ?>
                                <div class="list-group-item d-flex justify-content-between align-items-start px-2">
                                    <div class="ms-2 me-auto d-flex justify-content-between w-100">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="fw-bold"><?= htmlspecialchars($num) ?>.</span>
                                            <div class="fw-bold"><?= htmlspecialchars($name) ?></div>
                                        </div>
                                        <div class="d-flex flex-column justify-content-end align-items-end gap-1">
                                            <?php foreach ($items as $it): ?>
                                                <?php
                                                $teacher = isset($it['teacher']) ? (string)$it['teacher'] : '---';
                                                $cabinet = isset($it['cabinet']) ? (string)$it['cabinet'] : '____';
                                                ?>
                                                <div class="text-muted text-end w-100">
                                                    <?= htmlspecialchars($teacher) ?>
                                                    <span class="badge text-bg-primary rounded-pill"><?= htmlspecialchars($cabinet) ?></span>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="p-3 text-center text-body-secondary">—</div>
                    <?php endif; ?>
                </td>
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>