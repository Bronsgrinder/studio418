<?php
/*
 * Thema header
 */
?>

<!doctype html>
<html <?php language_attributes(); ?>
<head>
	<!-- Meta tags -->
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<div class="container">

    <div class="row">

        <nav class="navbar navbar-collapse navbar-light bg-white">

            <a class="navbar-brand" href="<?php echo esc_url( home_url() ); ?>">
                <?php
                /* Zet custom logo als deze is ingesteld anders val terug op default */
                if ( has_custom_logo() ) {
                    $logo_id = get_theme_mod( 'custom_logo' );
                    $logo = wp_get_attachment_image_src( $logo_id, 'full' );
                    ?>

                    <img src="<?php echo esc_url( $logo[0] ); ?>" alt="<?php bloginfo( 'name' ) ?>">
                    <?php
                } else {
                    ?>

                    <img src="<?php echo esc_url( get_template_directory_uri() ) ?>/images/brand-logo.svg" alt="<?php bloginfo( 'name' ); ?>">
                    <?php
                }
                ?>

            </a>

            <button class="navbar-toggler" type="button">
                <span class="navbar-toggler-icon"></span>
            </button>

        </nav> <!-- einde nav navbar -->

    </div>

    <?php
    if ( get_header_image() ) {
        ?>
        <div class="header row">
            <div class="col-12 d-flex justify-content-center py-2">
                <img class="header-image" src="<?php header_image() ?>" alt="header">
            </div>
        </div>
        <?php
    }
    ?>

</div> <!-- einde div container (header) -->
