<?php

namespace HashtagCore;

use DateTime;
use Exception;
use WP_Term;

final class Staffs
{
    const  STAFF_PHONE = 'staff_phone';
    const  STAFF_MAIL = 'staff_mail';
    const  STAFF_WORKING_HOURS = 'staff_working_hours';
    const  STAFF_YEAR_ADVANCED_TRAINING = 'staff_year_advanced_training';
    const  STAFF_GENERAL_EXPERIENCE = 'staff_general_experience';
    const  STAFF_TEACHING_EXPERIENCE = 'staff_teaching_experience';
    const  STAFF_CABINET = 'staff_cabinet';
    const  STAFF_SPECIALITY = 'staff_speciality';
    const  STAFF_ACTIVE = 'staff_active';

    /**
     * Выпадающий список таксона
     *
     * @param string $taxName
     * @param string $text
     * @return void
     */
    public static function terms_select(string $taxName, string $text = ""): void
    {
        /** @SEE https://wp-kama.ru/function/wp_dropdown_categories */
        wp_dropdown_categories(
            [
                'taxonomy'        => $taxName,
                'class'           => 'form-select',
                'id'              => 'inputGroupSelect04',
                'hide_empty'      => 1,
                'orderby'         => 'name',
                'hierarchical'    => 1,
                'show_option_all' => $text,
                'value_field'     => 'term_id',
                'selected'        => $_POST['positions_staffs_select'] ?? 0,
                'name'            => $taxName . '_select'
            ]
        );
    }

    /**
     * Возвращает объект таксона
     *
     * @param $postId
     * @param $taxName
     * @return false|mixed|WP_Term
     */
    public static function get_terms_by_tax($postId, $taxName)
    {
        $tax = get_the_terms($postId, $taxName);
        if (!empty($tax) && isset($tax[0])) {
            return $tax[0];
        }
        return false;
    }

    /**
     * Получает описание или имя Terms таксонов
     *
     * @param $terms
     * @return mixed|string
     */
    public static function getTermsParameters($terms)
    {
        if (!$terms) {
            return '';
        }
        return $terms->description ?: $terms->name ?: '';
    }

    /**
     * Выводит разницу от текущей даты
     *
     * @param string $dateNew
     * @return string
     */
    public static function getTimeDiff(string $dateNew): string
    {
        try {
            $now = new DateTime();
            $date = new DateTime($dateNew);
            $diff = $date->diff($now);

            $year = $diff->y;
            $month = $diff->m;

            $result = '';
            $result .= $year . self::ending($year, ' год', ' года', ' лет');
            $result .= ' ';
            $result .= $month . self::ending($month, ' месяц', ' месяца', ' месяцев');
            return $result;
        } catch (Exception $exception) {
            return ' ';
        }
    }

    /**
     * Определяет вариант окончания для цифр
     *
     * @param $num
     * @param $first
     * @param $second
     * @param $third
     * @return mixed
     */
    public static function ending($num, $first, $second, $third)
    {
        $num = (int)$num;

        if ($num < 21 && $num > 4) {
            return $third;
        }

        $num = $num % 10;

        if ($num == 1) {
            return $first;
        }
        if ($num > 1 && $num < 5) {
            return $second;
        }

        return $third;
    }

    public static function explodeName($title)
    {
        $arrName = explode(' ', $title);
        foreach ($arrName as $name) {
            echo sprintf('<p class="m-1">%s</p>', $name);
        }
    }

    /**
     * @param string $badge
     * @param string $text
     * @return void
     */
    public static function getParametersHtml(string $badge, string $text)
    {
        echo sprintf(
            '<div class="row">
            <div class="col-sm-3">
                <p class="mb-0">%s</p>
            </div>
            <div class="col-sm-9">
                <p class="text-muted mb-0">%s</p>
            </div>
          </div>',
            $badge,
            $text
        );
    }

    /**
     * Возвращает массив Terms с отступами имен
     *
     * @param WP_Term[]  $terms
     * @param int    $sub
     * @param string $tab
     * @return array
     */
    public static function getListTerms(array $terms, $sub = 0, string $tab = ''): array
    {
        if ($sub > 0) {
            $tab .= '-';
        }

        $category = [];
        $category[0] = 'Выберите категорию записей';
        foreach ($terms as $term) {
            if ($sub == $term->parent) {
                $category[$term->term_id] = $tab . $term->name;
                $category += self::getListTerms($terms, $term->term_id, $tab);
            }
        }
        return $category;
    }

    public static function getStyleBlock(): string
    {
        $url = get_template_directory_uri() . '/assets/img/site/staff-bg.svg';
        return "
        <style>
            .gradient-custom {
                background: #174a99;
                background-image: url($url);
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;
            }
        </style>
        ";
    }

}
