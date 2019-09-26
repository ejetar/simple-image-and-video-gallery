<?php
/*
Plugin Name: Simple Image and Video Gallery
Plugin URI: #
Description: Relate images and YouTube videos to your posts. You can handle data output manually or automatically, depending on your needs.
Version: 0.1
Author: Guilherme A. Girardi
Author URI: https://ejetar.com
License: MIT
*/

//Prevent direct access to this file
defined( 'ABSPATH' ) or die( ':P' );

define('SIVG_META_BOX_ID', 'sivg_meta_box');
define('SIVG_PLUGIN_NAME', 'Simple Image and Video Gallery');
define('SIVG_PLUGIN_SLUG', 'simple-image-and-video-gallery');

require_once 'functions.php';

sivg_enqueue_backend_styles_and_scripts();
sivg_create_meta_box();
sivg_create_save_post_action();
sivg_create_shortcode();
sivg_create_textdomain();
sivg_create_options_page();

function sivg($post_ID) {
    $response = [];

    if (isset(get_post_custom($post_ID)[SIVG_PLUGIN_SLUG])) {
        $gallery = get_post_meta($post_ID, SIVG_PLUGIN_SLUG, TRUE);

        foreach($gallery as $g) {
            $g = (object) $g;

            $item = [
                'id'            => $g->id,
                'type'          => $g->type,
                'description'   => $g->description,
            ];

            if ($g->type == 'image') {
                $attachment = wp_get_attachment_metadata($g->id);

                $item = array_merge($item,[
                    'url'       => wp_get_attachment_image_url($g->id,'full'),
                    'width'     => $attachment['sizes']['full']['width'],
                    'height'    => $attachment['sizes']['full']['height'],
                    'thumbnail' => [
                        'large' => [
                            'height'=> $attachment['sizes']['large']['height'],
                            'width' => $attachment['sizes']['large']['width'],
                            'url'   => wp_get_attachment_image_url($g->id,'large'),
                        ],
                        'medium' => [
                            'height'=> $attachment['sizes']['medium']['height'],
                            'width' => $attachment['sizes']['medium']['width'],
                            'url'   => wp_get_attachment_image_url($g->id,'medium'),
                        ],
                        'thumbnail' => [
                            'height'=> $attachment['sizes']['thumbnail']['height'],
                            'width' => $attachment['sizes']['thumbnail']['width'],
                            'url'   => wp_get_attachment_image_url($g->id,'thumbnail'),
                        ]
                    ]
                ]);

            } elseif ($g->type == 'youtube-video') {
                $item = array_merge($item,[
                    'url'       => "https://www.youtube.com/watch?v=$g->id",
                    'thumbnail' => [
                        'player_background' => [
                            'width' => 480,
                            'height'=> 360,
                            'url'   => "https://i1.ytimg.com/vi/$g->id/0.jpg",
                        ],
                        'start' => [
                            'width' => 120,
                            'height'=> 90,
                            'url'   => "https://i1.ytimg.com/vi/$g->id/1.jpg",
                        ],
                        'middle' => [
                            'width' => 120,
                            'height'=> 90,
                            'url'   => "https://i1.ytimg.com/vi/$g->id/2.jpg",
                        ],
                        'end' => [
                            'width' => 120,
                            'height'=> 90,
                            'url'   => "https://i1.ytimg.com/vi/$g->id/3.jpg",
                        ],
                        'high_quality' => [
                            'width' => 480,
                            'height'=> 360,
                            'url'   => "https://i1.ytimg.com/vi/$g->id/hqdefault.jpg",
                        ],
                        'medium_quality' => [
                            'width' => 320,
                            'height'=> 180,
                            'url'   => "https://i1.ytimg.com/vi/$g->id/mqdefault.jpg",
                        ],
                        'normal_quality' => [
                            'width' => 120,
                            'height'=> 90,
                            'url'   => "https://i1.ytimg.com/vi/$g->id/default.jpg",
                        ],
                        'standard_definition' => [
                            'width' => 640,
                            'height'=> 480,
                            'url'   => "https://i1.ytimg.com/vi/$g->id/sddefault.jpg",
                        ],
                        'maximum_definition' => [
                            'width' => 1920,
                            'height'=> 1080,
                            'url'   => "https://i1.ytimg.com/vi/$g->id/maxresdefault.jpg",
                        ],
                    ]
                ]);
            }

            $response[] = $item;
        }
    }

    return $response;
}

function sivg_carousel($options = []) {
    ob_start();
    require_once 'components/carousel.php';
    return ob_get_clean();
}