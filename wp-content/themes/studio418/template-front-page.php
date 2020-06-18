<?php
/**
 * Template Name: template front page
 */

get_header();
?>

<div class="container pb-5">

	<?php
    /* Weergeef alleen formulier als de plugin actief is */
    if ( class_exists( 'studio418_contactform' ) ) {
        $error = filter_input( INPUT_GET, 'error', FILTER_VALIDATE_INT );
        if( $error === 1) {
            ?>
            <div class="row mt-3" role="alert">
                <p class="col-12 alert alert-danger text-center">
                    Er is iets fouts gegaan bij het versturen van het contact formulier.
                </p>
            </div>
            <?php
        } else if ( $error === 0 ) {
            ?>
            <div class="row mt-3" role="alert">
                <p class="col-12 alert alert-success text-center">
                    Het contact formulier is met succes verstuurd.
                </p>
            </div>
            <?php
        }
    }
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

    <div class="my-cards row card-deck py-2">

        <div class="card rounded card-webdesign col-12">

            <img class="card-img-top mx-auto mt-4" src="<?php echo esc_url( get_template_directory_uri() ) ?>/images/webdesign.png" alt="webdesign">

            <div class="card-body">
                <h5 class="card-title">studio418</h5>
                <p class="card-text">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci aperiam at deserunt dolore doloribus error expedita ipsa, laboriosam minima molestiae nam quaerat quam quia repudiandae sed sint tempora tempore vero.
                </p>

            </div> <!-- einde div card-body -->

        </div> <!-- einde div card -->

        <div class="card rounded card-webdevelopment">
            <img class="card-img-top mx-auto mt-4" src="<?php echo esc_url( get_template_directory_uri() ) ?>/images/webdevelopment.png" alt="web development">
            <div class="card-body">
                <h5 class="card-title">Lorem ipsum</h5>
                <p class="card-text">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut blanditiis consequatur dolorum ex explicabo hic incidunt suscipit? Aperiam expedita facere, facilis numquam omnis quasi quisquam sequi. Aliquid beatae magnam quisquam.
                </p>

            </div> <!-- einde div card-body -->

        </div> <!-- einde div card -->

        <div class="card rounded card-webbeheer">
            <img class="card-img-top mx-auto mt-4" src="<?php echo esc_url( get_template_directory_uri() ) ?>/images/webbeheer.png" alt="webbeheer">
            <div class="card-body">
                <h5 class="card-title">Lorem ipsum </h5>
                <p class="card-text">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet, consequuntur corporis cumque deserunt eos explicabo laboriosam quam quas repellendus unde, vel veritatis! Consequatur est impedit molestias nesciunt rerum? Fugit, perspiciatis.
                </p>

            </div> <!-- einde div card-body -->

        </div> <!-- einde div card -->

    </div> <!-- einde div card-deck -->

    <?php
    /* Weergeef alleen formulier als de plugin actief is */
    if ( class_exists( 'studio418_contactform' ) ) { ?>

        <div class="row">

            <div class="contact py-4 col-lg-6 offset-lg-3 mb-5">

                <header class="contact-title py-2">Neem contact op!</header>

                <p class="contact-text py-2">
                    Lijk het je leuk om bij ons the komen werken? Vul dan het formulier in.
                </p>

                <form action="<?php echo esc_url( admin_url( 'admin-post.php') ); ?>" method="post" class="contact-form">

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="sr-only" for="voornaam">Voornaam</label>
                            <input type="text" class="form-control bg-light rq" id="voornaam" name="voornaam" placeholder="Voornaam *" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="sr-only" for="achternaam">Achternaam</label>
                            <input type="text" class="form-control bg-light rq" id="achternaam" name="achternaam" placeholder="Achternaam *" required>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="sr-only" for="email">E-mailadres</label>
                        <input type="email" class="form-control bg-light rq" id="email" name="email" placeholder="E-mailadres *" required>
                    </div>

                    <div class="form-row">

                        <div class="form-group col-md-6">
                            <label class="sr-only" for="bedrijfsnaam">Bedrijfsnaam</label>
                            <input type="text" class="form-control bg-light" id="bedrijfsnaam" name="bedrijfsnaam" placeholder="Bedrijfsnaam">
                        </div>

                        <div class="form-group col-md-6">
                            <label class="sr-only" for="telefoon">Telefoon</label>
                            <input type="tel" class="form-control bg-light" id="telefoon" name="telefoon" placeholder="Telefoon">
                        </div>

                    </div>

                    <div class="form-group">
                        <label class="sr-only" for="bericht">Bericht</label>
                        <textarea rows="8" class="form-control bg-light rq" id="bericht" name="bericht" placeholder="Bericht *" required></textarea>
                    </div>

                    <!-- Hidden fields -->
                    <input type="hidden" name="action" value="studio418_contactform">
                    <input type="hidden" name="wp_nonce" value="<?php echo wp_create_nonce( 'submit_contactform' ); ?>">
                    <input type="hidden" name="redirect_id" value="<?php echo $post->ID; ?>">
                    <button type="submit" class="btn btn-lg btn-danger rounded-pill float-right mt-3 contactform-submit">Verzenden</button>

                </form>

            </div>
        </div>

        <?php
    }
    ?>

</div> <!-- einde div container -->

<?php
get_footer();