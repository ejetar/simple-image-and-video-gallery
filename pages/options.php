<?php
//Prevent direct access to this file
defined( 'ABSPATH' ) or die( ':P' );
?>

<div class="wrap">
    <?php
    if ( current_user_can( 'manage_options' ) ) {
        ?>
        <h1>Simple Image and Video Gallery</h1>

        <form method="post" action="options.php">
            <?php
            settings_fields( 'myoption-group' );
            do_settings_sections( 'myoption-group' );
            submit_button();
            ?>
        </form>
        <?php
    } else {
        wp_die( __( 'You do not have sufficient permissions to access this page.', 'simple-image-and-video-gallery') );
    }
    ?>
</div>
