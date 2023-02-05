<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package hashtag
 */

?>

<div class="container">
    <footer class="bd-footer mt-5 bg-light shadow bg-body rounded-3 stars">
        <div class="container py-5">
            <div class="row">
                <?php dynamic_sidebar( 'sidebar-footer-1' ); ?>
                <?php dynamic_sidebar( 'sidebar-footer-2' ); ?>
                <?php dynamic_sidebar( 'sidebar-footer-3' ); ?>
            </div>
        </div>
    </footer>
</div>



<?php wp_footer();?>


<script type="text/javascript">
    var scene = document.getElementById('scene');
    var parallaxInstance = new Parallax(scene);
</script>

</body>

</html>
