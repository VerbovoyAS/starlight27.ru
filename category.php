<?php
get_header();
global $wp_query;
?>

<?php if ( have_posts() ) : ?>
    <div class="container ">
        <div class="row">
            <div class="col px-0">
                <div class="card bg-dark text-white mb-2">
                    <img src="https://creativo.one/lessons/les5669/01.jpg" class="card-img" alt="...">
                    <div class="card-img-overlay d-flex flex-column justify-content-center align-items-center">
                        <?php the_archive_title( '<h1 class="card-title 1">', '</h1>' ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container ">
        <div class="row ">
            <div class="col-12 col-lg-8">
                <div class="row me-1 row-cols-1 shadow mb-2 p-3 bg-body rounded-3 d-flex justify-content-center">
                        <?php
                        while ( have_posts() ) :
                            the_post();

                            get_template_part( 'template-parts/category/category', get_post_type() );

                        endwhile;
                        ?>
                        <?php if (  $wp_query->max_num_pages > 1 ) : ?>
                            <script>
                                var ajaxurl = '<?php echo site_url() ?>/wp-admin/admin-ajax.php';
                                var true_posts = '<?php echo serialize($wp_query->query_vars); ?>';
                                var current_page = <?php echo (get_query_var('paged')) ? get_query_var('paged') : 1; ?>;
                                var max_pages = '<?php echo $wp_query->max_num_pages; ?>';
                            </script>
                            <button id="true_loadmore" class="btn btn-outline-secondary w-50" type="button">Загрузить ещё</button>
                        <?php endif; ?>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="row">
                    <div class="col shadow mb-2 p-3 bg-body rounded-3 stars">
                        <?php get_sidebar(); ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

<?php
else :

    get_template_part( 'template-parts/category/category', 'none' );

endif;
?>


<?php

get_footer();



