<?php get_header();?>

    <div class="p-slider">

        <ul id="scene">
            <li class="layer layer_1" data-depth="0.15"><img onclick="alert(' Щелчок мыши!')" src="<?= get_template_directory_uri(). '/assets/img/site/SVG/1.svg';?>" alt=""></li>
            <li class="layer layer_2" data-depth="0.20"><img src="<?= get_template_directory_uri(). '/assets/img/site/SVG/2.svg';?>" alt=""></li>
            <li class="layer layer_3" data-depth="0.25"><img src="<?= get_template_directory_uri(). '/assets/img/site/SVG/3.svg';?>" alt=""></li>
            <li class="layer layer_4" data-depth="0.30"><img src="<?= get_template_directory_uri(). '/assets/img/site/SVG/4.svg';?>" alt=""></li>
            <li class="layer layer_5" data-depth="0.35"><img src="<?= get_template_directory_uri(). '/assets/img/site/SVG/5.svg';?>" alt=""></li>
            <li class="layer layer_6" data-depth="0.40"><img src="<?= get_template_directory_uri(). '/assets/img/site/SVG/6.svg';?>" alt=""></li>
            <li class="layer layer_7" data-depth="0.45"><img src="<?= get_template_directory_uri(). '/assets/img/site/SVG/7.svg';?>" alt=""></li>
            <li class="layer layer_8" data-depth="0.50"><img src="<?= get_template_directory_uri(). '/assets/img/site/SVG/8.svg';?>" alt=""></li>
            <li class="layer layer_9" data-depth="0.10"><h2 class="fs-2 text-white text-center">Муниципальное <br>автономное общеобразовательное учреждение<br> г. Хабаровска</h2></li>
            <li class="layer layer_10" data-depth="0.10"><h1 class="fs-1 text-white text-center">"Лицей "Звёздный"</h1></li>

        </ul>
    </div>

    <section class="main-content container">
        <?php the_content();?>
    </section>

<?php get_footer();?>