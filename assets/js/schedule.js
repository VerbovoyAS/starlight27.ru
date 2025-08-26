// Загрузка расписания
function loadSchedule() {
    const selectedClass = document.querySelector('input[name="btnradio"]:checked')?.nextElementSibling?.textContent.trim();
    const selectedWeek = document.querySelector('input[name="weekRadio"]:checked')?.nextElementSibling?.textContent.trim();

    const loader = document.getElementById('schedule-loader');
    const container = document.getElementById('schedule-table-container');

    if (!selectedClass || !selectedWeek || !loader || !container) return;

    // Показать глобальный лоадер и затемнить контейнер
    loader.classList.remove('d-none');
    container.style.opacity = '0.5';

    fetch(schedule_ajax.ajax_url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
            action: 'load_schedule_table',
            class_group: selectedClass,
            week_offset: selectedWeek
        })
    })
        .then(response => response.text())
        .then(html => {
            container.innerHTML = html;
        })
        .finally(() => {
            loader.classList.add('d-none');
            container.style.opacity = '1';
        });
}

document.addEventListener('DOMContentLoaded', function () {
    // Вешаем обработчики на переключатели
    document.querySelectorAll('.btn-check').forEach(function (button) {
        button.addEventListener('change', loadSchedule);
    });

    // Загружаем расписание сразу при загрузке
    loadSchedule();

    // Перезагрузка расписания каждые 300 секунд
    const refreshIntervalSeconds = 300;
    setInterval(loadSchedule, refreshIntervalSeconds * 1000);
});
