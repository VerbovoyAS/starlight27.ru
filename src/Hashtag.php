<?php

namespace HashtagCore;

class Hashtag {

    /**
     * Возвращает массив категорий WP
     *
     * @return array
     */
    public static function getPostCategories(): array
    {
        $categoriesList = [];
        $categories = get_categories();

        if (empty($categories)){
            return $categoriesList;
        }

        foreach ($categories as $category) {
            $categoriesList[$category->slug] = $category->name;
        }

        return $categoriesList;
    }

    /**
     * Получение изображения по умолчанию
     *
     * @return string
     */
    public static function getDefaultImg(): string
    {
        $getImageList = static::getImageList();
        $randomNum = rand(0, count($getImageList));

        return $getImageList[$randomNum] ?? get_template_directory_uri() . '/assets/img/site/nasa/nasa-4.jpeg';
    }

    /**
     * Получение списка изображений. Временное решение
     *
     * @return string[]
     */
    public static function getImageList(): array
    {
        $path = get_template_directory_uri(). '/assets/img/site/nasa/';
        return [
            $path . 'nasa-1.jpeg',
            $path . 'nasa-2.jpeg',
            $path . 'nasa-3.jpeg',
            $path . 'nasa-4.jpeg',
            $path . 'nasa-5.jpeg',
            $path . 'nasa-6.jpeg',
            $path . 'nasa-7.jpeg',
            $path . 'nasa-8.jpeg',
            $path . 'nasa-9.jpeg',
            $path . 'nasa-10.jpeg',
            $path . 'nasa-11.jpeg',
            $path . 'nasa-12.jpeg',
            $path . 'nasa-13.jpeg',
        ];
    }

    public static function breadcrumbs(): void
    {
        $separator = ' / ';

        echo '<a href="' . site_url() . '">Главная</a>' . $separator;

        global $post;

        if (is_tax()) { // архив таксономии (mo_group и любые другие)
            $term = get_queried_object();
            if ($term && isset($term->taxonomy)) {
                $tax = get_taxonomy($term->taxonomy);
                echo $tax->labels->singular_name . $separator;
                echo '<span>' . $term->name . '</span>';
            }
        } elseif (is_singular('mo_page')) { // отдельная страница внутри МО
            // получаем таксономию
            $terms = get_the_terms($post->ID, 'mo_group');
            if ($terms && !is_wp_error($terms)) {
                $term = array_shift($terms);
                echo '<a href="' . get_term_link($term) . '">' . $term->name . '</a>' . $separator;
            }
            echo '<span>' . get_the_title() . '</span>';
        } elseif ($post && $post->post_parent) { // если есть родитель
            $parent_id = $post->post_parent;
            $breadcrumbs = [];

            while ($parent_id) {
                $page = get_post($parent_id);
                $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
                $parent_id = $page->post_parent;
            }

            echo join($separator, array_reverse($breadcrumbs)) . $separator;
            echo '<span>' . get_the_title() . '</span>';
        } elseif (is_single()) {
            the_category(', ');
            echo $separator . '<span>' . get_the_title() . '</span>';
        } elseif (is_page()) {
            echo '<span>' . get_the_title() . '</span>';
        } elseif (is_category()) {
            single_cat_title();
        } elseif (is_tag()) {
            single_tag_title();
        } elseif (is_day()) {
            echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a>' . $separator;
            echo '<a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . get_the_time('F') . '</a>' . $separator;
            echo get_the_time('d');
        } elseif (is_month()) {
            echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a>' . $separator;
            echo get_the_time('F');
        } elseif (is_year()) {
            echo get_the_time('Y');
        }
    }

}