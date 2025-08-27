<?php

namespace HashtagCore;

class TaxonomyCreate
{

    /**
     * @param string $postType
     * @param string $name
     * @param string $taxonomyName
     * @return void
     */
    public function createTaxonomy(string $postType, string $name, string $taxonomyName, array $args = []): void
    {
        if (empty($args)) {
            $args = $this->getDefaultArg($name);
        }

        $this->registerTaxonomy($postType, $args, $taxonomyName);
    }

    /**
     * @param string $postType
     * @param array  $args
     * @param string $taxonomyName
     * @return void
     */
    private function registerTaxonomy(string $postType, array $args, string $taxonomyName): void
    {
        register_taxonomy($taxonomyName, $postType, $args);
    }

    /**
     * @param string $name
     * @return array
     */
    private function getDefaultArg(string $name): array
    {
        return [
            'labels'            => $this->getLabels($name),
            'hierarchical'      => true,
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud'     => true,
            'meta_box_cb'       => [$this, 'staffs_taxonomy_select_meta_box'],
        ];
    }

    /**
     * @param string $name
     * @return array
     */
    private function getLabels(string $name): array
    {
        return [
            'name'                  => sprintf('%s', $name),
            'singular_name'         => sprintf('%s', $name),
            'menu_name'             => sprintf('%s', $name),
            'all_items'             => sprintf('Все %s', $name),
            'parent_item'           => sprintf('Родитель %s', $name),
            'parent_item_colon'     => sprintf('Родитель %s:', $name),
            'new_item_name'         => sprintf('Название %s', $name),
            'add_new_item'          => sprintf('Добавить %s', $name),
            'edit_item'             => sprintf('Изменить %s', $name),
            'update_item'           => sprintf('Обновить %s', $name),
            'view_item'             => sprintf('Показать %s', $name),
            'add_or_remove_items'   => sprintf('Добавить или удалить %s', $name),
            'popular_items'         => sprintf('Популярный %s', $name),
            'search_items'          => sprintf('Поиск по %s', $name),
            'not_found'             => 'Не найден',
            'no_terms'              => sprintf('нет %s', $name),
            'items_list'            => sprintf('Список %s', $name),
            'items_list_navigation' => sprintf('Навигация по %s', $name),
        ];
    }

    /**
     * @param $post
     * @param $box
     * @return void
     */
    function staffs_taxonomy_select_meta_box($post, $box): void
    {
        if (!isset($box['args']) || !is_array($box['args'])) {
            $args = [];
        } else {
            $args = $box['args'];
        }

        extract(wp_parse_args($args, ['taxonomy' => 'category']), EXTR_SKIP);

        $tax = get_taxonomy($taxonomy);
        $selected = wp_get_object_terms($post->ID, $taxonomy, ['fields' => 'ids']);
        $hierarchical = $tax->hierarchical;
        ?>
        <div id="taxonomy-<?php echo $taxonomy; ?>" class="selectdiv">
            <?php
            if (current_user_can($tax->cap->edit_terms)):
                if ($hierarchical) {
                    wp_dropdown_categories([
                                               'taxonomy'        => $taxonomy,
                                               'class'           => 'widefat',
                                               'hide_empty'      => 0,
                                               'name'            => "tax_input[$taxonomy][]",
                                               'selected'        => count($selected) >= 1 ? $selected[0] : '',
                                               'orderby'         => 'name',
                                               'hierarchical'    => 1,
                                               'show_option_all' => " "
                                           ]);
                } else { ?>
                    <label>
                        <select name="<?php echo "tax_input[$taxonomy][]"; ?>" class="widefat">
                            <option value="0"></option>
                            <?php foreach (get_terms($taxonomy, ['hide_empty' => false]) as $term): ?>
                                <option value="<?php echo esc_attr($term->slug); ?>" <?php echo selected(
                                    $term->term_id,
                                    count(
                                        $selected
                                    ) >= 1 ? $selected[0] : ''
                                ); ?>><?php echo esc_html($term->name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                    <?php
                }
            endif;
            ?>
        </div>
        <?php
    }
}
