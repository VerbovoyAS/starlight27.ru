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
        return 'https://i.pinimg.com/originals/c3/5d/f3/c35df3a6a3b629a7170837d73ed41b93.jpg';
    }

    /**
     * Получение списка изображений. Временное решение
     *
     * @return string[]
     */
    public static function getImageList(): array
    {
        return [
            'https://www.nasa.gov/sites/default/files/thumbnails/image/682400main_pia14922_full_full.jpg',
            'https://www.nasa.gov/sites/default/files/thumbnails/image/757_iss044e020824.jpg',
            'https://www.nasa.gov/sites/default/files/thumbnails/image/pia16613_orig.jpg',
            'https://www.nasa.gov/sites/default/files/thumbnails/image/pia25703_orig.jpg',
            'https://www.nasa.gov/sites/default/files/thumbnails/image/52563811575_3e75f081cc_o.jpg',
            'https://www.nasa.gov/sites/default/files/thumbnails/image/apollo_17_blue_marble_photo_dec_7_1972_as17-148-22727.jpg',
            'https://www.nasa.gov/sites/default/files/thumbnails/image/s65-63188_orig.jpg',
        ];
    }
}