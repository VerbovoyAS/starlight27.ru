<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package hashtag
 */

get_header();
?>

<!--    <div class="container ">-->
<!--        <div class="row">-->
<!--            <div class="col px-0">-->
<!--                <div class="card bg-dark text-white mb-2">-->
<!--                    <img src="https://creativo.one/lessons/les5669/01.jpg" class="card-img" alt="...">-->
<!--                    <div class="card-img-overlay d-flex flex-column justify-content-center align-items-center">-->
<!--                        <h1 class="card-title 1">--><?php //the_title(); ?><!--</h1>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->

	<main id="primary" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
//			if ( comments_open() || get_comments_number() ) :
//				comments_template();
//			endif;

		endwhile; // End of the loop.
		?>

	</main>
    <!-- #main -->

<?php

get_footer();
