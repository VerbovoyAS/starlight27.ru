<?php

namespace HashtagCore;

use Carbon_Fields\Container;
use Carbon_Fields\Field\Field;

final class GutenbergContainer
{
    /**
     * Меню настройки сайта
     *
     * @return void
     */
    public static function settingSite(): void
    {
        Container::make('theme_options', 'Настройки темы')
            ->add_tab('Контакты', [
                Field::make('text', 'default_phone', 'Номер телефона'),
                Field::make('text', 'default_mail', 'E-mail'),
            ]);
    }

    /**
     * Дополнительные поля для "Сотрудников" - staff
     *
     * @return void
     */
    public static function fieldsStaff(): void
    {
        Container::make('post_meta', __('Дополнительные поля Сотрудников'))
            ->where('post_type', '=', POST_TYPE_STAFF)
            ->add_fields([
                             Field::make('text', 'staff_phone_number', 'Номер телефона')
                                 ->set_attribute('placeholder', '(***) ***-****'),
                             Field::make('text', 'staff_mail', 'Почта'),
                             Field::make('text', 'staff_working_hours', 'Время работы (приёма)'),
                             Field::make('date_time', 'staff_year_advanced_training', 'Год повышения квалификации'),
                             Field::make('date_time', 'staff_general_experience', 'Год и месяц начала общего стажа'),
                             Field::make(
                                 'date_time',
                                 'staff_teaching_experience',
                                 'Год и месяц начала педагогического стажа'
                             ),
                             Field::make('checkbox', 'staff_active', 'Активировать')->set_default_value(true),
                         ]);
    }
}
