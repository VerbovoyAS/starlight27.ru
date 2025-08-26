document.addEventListener('DOMContentLoaded', function () {
    const classSelect = document.getElementById('classes');
    const weekSelect = document.getElementById('week');
    const refreshBtn = document.querySelector('.btn-outline-secondary');
    const table = document.getElementById('schedule-table');
    const loader = document.getElementById('schedule-loader');

    // Получение параметров из URL
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('class')) classSelect.value = urlParams.get('class');
    if (urlParams.get('week')) weekSelect.value = urlParams.get('week');

    function updateURLParams() {
        const params = new URLSearchParams();
        if (classSelect.value) params.set('class', classSelect.value);
        if (weekSelect.value) params.set('week', weekSelect.value);
        const newUrl = `${window.location.pathname}?${params.toString()}`;
        history.pushState(null, '', newUrl);
    }

    function loadSchedule() {
        const selectedClass = classSelect.value;

        if (!selectedClass || selectedClass === 'Выберите класс') return;

        updateURLParams();

        loader.classList.remove('d-none');
        table.classList.add('opacity-50');

        fetch(schedule_ajax.ajax_url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({
                action: 'load_class_schedule',
                class: selectedClass,
                week: weekSelect.value,
            })
        })
            .then(res => res.text())
            .then(html => {
                table.innerHTML = html;

                const scheduleTitle = document.getElementById('schedule-title');
                if (scheduleTitle) {
                    scheduleTitle.innerHTML = `<i class="bi bi-calendar-week"></i> Расписание ${selectedClass}`;
                } else {
                    console.warn('scheduleTitle не найден после загрузки');
                }
            })
            .catch(err => {
                console.error(err);
                table.innerHTML = '<tr><td colspan="6">Ошибка загрузки расписания</td></tr>';
            })
            .finally(() => {
                loader.classList.add('d-none');
                table.classList.remove('opacity-50');
            });
    }

    // События
    classSelect.addEventListener('change', loadSchedule);
    weekSelect.addEventListener('change', loadSchedule);
    refreshBtn.addEventListener('click', loadSchedule);

    // Если уже выбран класс при загрузке страницы — сразу загружаем расписание
    if (classSelect.value && classSelect.value !== 'Выберите класс') {
        loadSchedule();
    }
});
