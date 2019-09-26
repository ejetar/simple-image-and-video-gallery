<?php
//Prevent direct access to this file
defined( 'ABSPATH' ) or die( ':P' );

wp_enqueue_style( 'fancybox-css', 'https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css');
wp_enqueue_style( SIVG_PLUGIN_SLUG.'-front-css',plugin_dir_url(dirname(__FILE__)).'css/front.css');
wp_enqueue_script('fancybox-js', "https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js");
wp_enqueue_script('bootstrap-js', 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js', ['jquery']);
wp_enqueue_script(SIVG_PLUGIN_SLUG.'-front-js', plugin_dir_url(dirname(__FILE__)).'js/front.js', ['jquery','bootstrap-js']);

global $post;

$gallery = sivg($post->ID);
?>
<div id="sivg-carousel" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <?php
        $count = 0;
        foreach ($gallery as $item) {
            ?>
            <li data-target="#sivg-carousel" data-slide-to="<?= $count ?>" class="<?= $count == 0 ? 'active' : '' ?>"></li>
            <?php
            $count++;
        }
        ?>
    </ol>

    <div class="carousel-inner">
        <?php
        $count = 0;
        foreach ($gallery as $item) {
            if ($item['type'] == 'image') {
                ?>
                <div class="carousel-item <?= $count == 0 ? 'active' : '' ?>">
                    <a data-fancybox="gallery" href="<?= $item['url'] ?>">
                        <img class="d-block w-100" src="<?= $item['url'] ?>">
                    </a>
                    <div class="carousel-caption d-none d-md-block">
                        <p><?= $item['description'] ?></p>
                    </div>
                </div>
                <?php
            } elseif($item['type'] == 'youtube-video') {
                ?>
                <div class="carousel-item <?= $count == 0 ? 'active' : '' ?>">
                    <div class="video-container">
                        <div id="<?= $item['id'] ?>" class="video-player"></div>
                    </div>
                </div>
                <?php
            }
            $count++;
        }
        ?>
    </div>

    <a class="carousel-control-prev" href="#sivg-carousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Anterior</span>
    </a>

    <a class="carousel-control-next" href="#sivg-carousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Próximo</span>
    </a>
</div>