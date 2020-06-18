<?php
/**
 * Main template
 */

get_header();

?>

<div class="main-content row">
    <div class="col-12 py-2">

        <?php
        if ( have_posts() ) {
            while ( have_posts() ) {
                the_post();
                ?>

                <header class="page-title d-block"><?php esc_html( the_title() ); ?></header>
                <div class="page-text py-5">
                    <?php

                        if ( has_post_thumbnail() ) {
                            ?>
                            <div class="d-flex justify-content-center mb-2 thumbnail">

                                <?php the_post_thumbnail(); ?>

                            </div>

                            <?php

                        }

                        the_content();
                    ?>


                </div>
                <?php

            } // end while
        } else {
            ?>
            <p class="page-text py-5">Sorry, er is niks gevonden met de opgegeven criteria</p>
            <?php

        } // end if
        ?>
    </div> <!-- einde div main-content -->
</div>
<?php
get_footer();