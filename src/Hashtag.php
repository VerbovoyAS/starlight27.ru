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

        return $getImageList[$randomNum] ?? 'https://i.pinimg.com/originals/c3/5d/f3/c35df3a6a3b629a7170837d73ed41b93.jpg';
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
}