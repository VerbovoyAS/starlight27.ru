<?php
?>
<div class="container ">
    <div class="row">
        <div class="col px-0">
            <div class="card rounded-0 rounded-bottom bg-dark text-white mb-2">
                <img src="https://creativo.one/lessons/les5669/01.jpg" class="card-img rounded-0 rounded-bottom" alt="...">
                <div class="card-img-overlay d-flex flex-column justify-content-center align-items-center">
                    <h1 class="card-title 1"><?php the_title(); ?></h1>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="container">
    <div class="row pb-2 px-2 px-sm-0">
        <div class="col-12 col-lg-8 text-muted">
            <!-- Breadcrumbs -->
            <?php //TODO Сделать хлебные крошки  ?>
            <!-- /breadcrumb -->
        </div>
        <div class="col-12 col-lg-4 d-flex align-items-center justify-content-end">
            <div class="row w-100">
                <div class="col">
                        <span class="d-flex align-items-center justify-content-end ms-3 text-muted"
                              title="<?php the_time('l, j F Y'); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                 class="me-2 bi bi-calendar3" viewBox="0 0 16 16">
                              <path d="M14 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM1 3.857C1 3.384 1.448 3 2 3h12c.552 0 1 .384 1 .857v10.286c0 .473-.448.857-1 .857H2c-.552 0-1-.384-1-.857V3.857z"/>
                              <path d="M6.5 7a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                            </svg>
                            <?php the_time('j F Y'); ?>
                        </span>
                </div>
            </div>
        </div>
    </div>
    <div class="row px-2 px-sm-0">
        <div class="col-lg-4">
            <div class="row me-lg-1">
                <div class="col shadow mb-2 p-3 bg-body rounded-3 stars">
                    <?php dynamic_sidebar( 'sidebar-info-edu' ); ?>
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
