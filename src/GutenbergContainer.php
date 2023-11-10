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
                Field::make('text', DEFAULT_PHONE, 'Номер телефона'),
                Field::make('text', DEFAULT_EMAIL, 'E-mail'),
                Field::make('text', DEFAULT_ADDRESSES, 'Адрес'),
                Field::make('rich_text', DEFAULT_WORK_TIME, 'Время работы (приёма)'),
            ])
            ->add_tab('Логотип', [
                Field::make( 'image', SITE_LOGO, __( 'Логотип сайта' ) ),
                Field::make( 'text', SITE_LOGO_WIDTH, __( 'Ширина логотипа сайта' ) )->set_default_value(88),
                Field::make( 'text', SITE_LOGO_HEIGHT, __( 'Высота логотипа сайта' ) )->set_default_value(88),
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
                             Field::make('text', Staffs::STAFF_PHONE, 'Номер телефона')
                                 ->set_attribute('placeholder', '(***) ***-****'),
                             Field::make('text', Staffs::STAFF_MAIL, 'Почта'),
                             Field::make('text', Staffs::STAFF_WORKING_HOURS, 'Время работы (приёма)'),
                             Field::make('text', Staffs::STAFF_SPECIALITY, 'Специальность (по диплому)'),
                             Field::make('date', Staffs::STAFF_YEAR_ADVANCED_TRAINING, 'Год повышения квалификации')
                                 ->set_input_format( 'Y', 'Y' ),
                             Field::make('date', Staffs::STAFF_GENERAL_EXPERIENCE, 'Год и месяц начала общего стажа'),
                             Field::make(
                                 'date',
                                 Staffs::STAFF_TEACHING_EXPERIENCE,
                                 'Год и месяц начала педагогического стажа'
                             ),
                             Field::make('text', Staffs::STAFF_CABINET, 'Кабинет'),
                             Field::make('checkbox', Staffs::STAFF_ACTIVE, 'Активировать')->set_default_value(true),
                         ]);
    }

    /**
     * Дополнительные поля для "Основные сведения"
     *
     * @return void
     */
    public static function fieldsBasicInfo()
    {
        Container::make('post_meta', 'Дополнительные поля')
            ->where('post_type', '=', POST_TYPE_BASIC_INFO)
            ->add_fields(
                [
                    Field::make('text', BASIC_INFO_ICON, 'Иконка'),
                ]
            );
    }
}
