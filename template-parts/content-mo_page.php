<?php

?>
<div class="container-lg">
    <div class="row">
        <div class="col px-0">
            <div class="card card-custom-img rounded-0 rounded-bottom bg-dark text-white mb-2">
                <div class="card-img-overlay d-flex flex-column justify-content-center align-items-center">
                    <h1 class="card-title text-center" style="text-shadow: 2px 2px 2px black;"><?php the_title(); ?></h1>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="container-lg">
    <div class="row pb-2 px-2 px-lg-0">
        <div class="col-12 col-lg-8 text-muted">
            <!-- Breadcrumbs -->
            <?php if (function_exists('fw_ext_breadcrumbs')) {
                fw_ext_breadcrumbs();
            } ?>
            <!-- /breadcrumb -->
        </div>
        <div class="col-12 col-lg-4 d-flex align-items-center justify-content-end">
            <div class="row w-100">
                <div class="col">

                </div>
            </div>
        </div>
    </div>
    <div class="row px-2 px-lg-0">
        <div class="col-lg-4">
            <div class="row me-lg-1">
                <div class="col shadow mb-2 p-3 bg-body rounded-3 stars">
                    <?php
                    $terms = wp_get_post_terms(get_the_ID(), 'mo_group');

                    if (!empty($terms) && !is_wp_error($terms)) {
                        // Берём первый термин (если пост принадлежит одной МО)
                        $mo_term = $terms[0];

                        // Получаем все страницы CPT mo_page с этим термином
                        $mo_pages = get_posts([
                            'post_type'   => 'mo_page',
                            'numberposts' => -1,
                            'orderby'     => 'menu_order',
                            'order'       => 'ASC',
                            'tax_query'   => [[
                                'taxonomy' => 'mo_group',
                                'field'    => 'term_id',
                                'terms'    => $mo_term->term_id,
                            ]],
                            'post_status' => 'publish',
                            'post_parent' => 0, // только верхнеуровневые страницы
                        ]);

                        if ($mo_pages) {
                            echo '<ul class="mo-menu">';
                            foreach ($mo_pages as $page) {
                                // Если нужны вложенные страницы
                                $children = get_posts([
                                                          'post_type'   => 'mo_page',
                                                          'numberposts' => -1,
                                                          'post_parent' => $page->ID,
                                                          'orderby'     => 'menu_order',
                                                          'order'       => 'ASC',
                                                          'post_status' => 'publish',
                                                      ]);



                                echo '<li><a  href="' . get_permalink($page->ID) . '">' . esc_html($page->post_title) . '</a>';



                                if ($children) {
                                    echo '<ul>';
                                    foreach ($children as $child) {
                                        echo '<li><a href="' . get_permalink($child->ID) . '">' . esc_html($child->post_title) . '</a></li>';
                                    }
                                    echo '</ul>';
                                }

                                echo '</li>';
                            }
                            echo '</ul>';
                        }
                    }

                    ?>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-8">
            <div class="row">
                <div class="col shadow mb-2 p-3 bg-body rounded-3"><?php the_content(); ?></div>
            </div>
        </div>
    </div>
</div>
