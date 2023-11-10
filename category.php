<?php
get_header();
global $wp_query;
?>

<?php if ( have_posts() ) : ?>
    <div class="container-lg">
        <div class="row">
            <div class="col px-0">
                <div class="card card-custom-img rounded-0 rounded-bottom bg-dark text-white mb-2">
                    <div class="card-img-overlay d-flex flex-column justify-content-center align-items-center">
                        <?php the_archive_title( '<h1 class="card-title 1" style="text-shadow: 2px 2px 2px black;">', '</h1>' ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-lg mt-2">
        <div class="row px-2 px-lg-0">
            <div class="col-12 p-0">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                        <?php
                        while ( have_posts() ) :
                            the_post();

                            get_template_part( 'template-parts/category/category', get_post_type() );

                        endwhile;
                        ?>
                </div>
                <?php if (  $wp_query->max_num_pages > 1 ) : ?>
                    <script>
                        var ajaxurl = '<?php echo site_url() ?>/wp-admin/admin-ajax.php';
                        var true_posts = '<?php echo serialize($wp_query->query_vars); ?>';
                        var current_page = <?php echo (get_query_var('paged')) ? get_query_var('paged') : 1; ?>;
                        var max_pages = '<?php echo $wp_query->max_num_pages; ?>';
                    </script>
                    <div class="d-flex items-justified-center justify-content-center pt-3">
                        <button id="true_loadmore" class="btn btn-outline-secondary d-block" type="button">Загрузить ещё</button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

<?php
else :

    get_template_part( 'template-parts/category/category', 'none' );

endif;

get_footer();
