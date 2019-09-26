<?php
function sivg_create_save_post_action() {
    function sivg_save_post($post_id, $post, $update ) {
        if ( isset($_POST[SIVG_PLUGIN_SLUG]) ) {
            update_post_meta( $post_id, SIVG_PLUGIN_SLUG, array_values($_POST[SIVG_PLUGIN_SLUG]) );
        }
    }
    add_action( 'save_post', 'sivg_save_post', 10, 3 );
}

function sivg_enqueue_backend_styles_and_scripts() {
    wp_enqueue_style(SIVG_PLUGIN_SLUG.'-back-css', plugins_url('/css/back.css', __FILE__));
}

function sivg_create_options_page() {
    function sivg_admin_menu() {
        add_options_page(
            SIVG_PLUGIN_NAME,
            SIVG_PLUGIN_NAME,
            'manage_options',
            SIVG_PLUGIN_SLUG,
            'sivg_options_page'
        );
    }
    add_action('admin_menu', 'sivg_admin_menu');

    function sivg_options_page() {
        require_once 'pages/options.php';
    }
}

function sivg_create_meta_box() {
    function sivg_meta_box($post) {
        require_once 'components/meta_box.php';
    }

    function sivg_add_meta_boxes() {
        $screens = [
            'imovel',
            'page',
            'post',
        ];

        foreach ($screens as $screen) {
            add_meta_box(
                SIVG_META_BOX_ID,
                __('Gallery', 'simple-image-and-video-gallery'),
                'sivg_meta_box',
                $screen
            );
        }
    }
    add_action('add_meta_boxes', 'sivg_add_meta_boxes');
}

function sivg_create_shortcode() {
    add_shortcode(SIVG_PLUGIN_SLUG, 'sivg_carousel');
}

function sivg_create_textdomain() {
    function sivg_load_textdomain() {
        load_plugin_textdomain(SIVG_PLUGIN_SLUG, false, basename( dirname( __FILE__ ) ) . '/languages');
    }
    add_action( 'plugins_loaded', 'sivg_load_textdomain');
}