<?php
//Prevent direct access to this file
defined( 'ABSPATH' ) or die( ':P' );

wp_enqueue_style( 'dragula-css', 'https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.2/dragula.min.css');
wp_enqueue_script('dragula-js', "https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.2/dragula.min.js");
?>

<div class="hide-if-no-js">
    <ul>
        <li>
            <p>
                <?= __('Add images:','simple-image-and-video-gallery'); ?>
                <button id="fromGallery" class="button"><?= __('Choose from gallery','simple-image-and-video-gallery'); ?></button>
            </p>
        </li>
        <li>
            <p>
                <?= __('Add YouTube video:','simple-image-and-video-gallery'); ?>
                <input type="text" id="fromYouTubeInput" placeholder="<?= __('Video ID','simple-image-and-video-gallery'); ?>"/>
                <button id="fromYouTubeButton" class="button"><?= __('Insert','simple-image-and-video-gallery'); ?></button>
            </p>
        </li>
    </ul>
</div>

<table class="wp-list-table widefat fixed striped">
    <thead>
        <tr>
            <th><?= __('Thumbnail','simple-image-and-video-gallery'); ?></th>
            <th><?= __('Description','simple-image-and-video-gallery'); ?></th>
            <th><?= __('Link','simple-image-and-video-gallery'); ?></th>
            <th><?= __('Actions','simple-image-and-video-gallery'); ?></th>
        </tr>
    </thead>
    <tbody>
    <?php
    $gallery = sivg($post->ID);

    $count = 0;
    foreach($gallery as $item) {
        if ($item['type'] == 'image') {
            $thumbnail = [
                'width'  => $item['thumbnail']['thumbnail']['width'],
                'height' => $item['thumbnail']['thumbnail']['height'],
                'url'    => $item['thumbnail']['thumbnail']['url'],
            ];

            $description = '<textarea rows="5" class="description" name="'.SIVG_PLUGIN_SLUG.'['.$count.'][description]">'.$item['description'].'</textarea>';

        } elseif ($item['type'] == 'youtube-video') {
            $thumbnail = [
                'width'  => 150,
                'height' => null,
                'url'    => $item['thumbnail']['high_quality']['url'],
            ];

            $description = '<input type="hidden" class="description" name="'.SIVG_PLUGIN_SLUG.'['.$count.'][description]">
                            <span class="no-description">'.__('Unable to add description to videos.','simple-image-and-video-gallery').'</span>';
        }
        ?>
        <tr>
            <td>
                <input type="hidden" name="<?= SIVG_PLUGIN_SLUG; ?>[<?= $count; ?>][id]" value="<?= $item['id']; ?>"/>
                <input type="hidden" name="<?= SIVG_PLUGIN_SLUG; ?>[<?= $count; ?>][type]" value="<?= $item['type']; ?>"/>
                <img width="<?= $thumbnail['width']; ?>" height="<?= $thumbnail['height']; ?>" src="<?= $thumbnail['url']; ?>">
            </td>
            <td>
                <?= $description; ?>
            </td>
            <td>
                <a href="<?= $item['url']; ?>"><?= $item['url']; ?></a>
            </td>
            <td>
                <button class="button delete"><?= __('Delete','simple-image-and-video-gallery'); ?></button>
            </td>
        </tr>
        <?php
        $count++;
    }
    ?>
    </tbody>
</table>

<script>
    jQuery(function($) {
        var SIVG_METABOX_SELECTOR = '#sivg_meta_box.postbox';

        dragula([document.querySelector(SIVG_METABOX_SELECTOR+' table tbody')]);

        var frame,
            metaBox = $(SIVG_METABOX_SELECTOR),

            fromGalleryButton = metaBox.find('#fromGallery'),

            fromYouTubeButton = metaBox.find('#fromYouTubeButton'),
            fromYouTubeInput = metaBox.find('#fromYouTubeInput');

        fromYouTubeButton.on('click', function(event) {
            event.preventDefault();

            var videoID = fromYouTubeInput.val();

            addNewLineToTable(
                videoID,
                'youtube-video',
                150,
                '',
                'https://img.youtube.com/vi/'+videoID+'/hqdefault.jpg',
                'https://www.youtube.com/watch?v='+videoID,
            );

            fromYouTubeInput.val('');
        });

        fromGalleryButton.on('click', function(event) {
            event.preventDefault();

            // If the media frame already exists, reopen it.
            if (frame) {
                frame.open();
                return;
            }

            // Create a new media frame
            frame = wp.media({
                title: 'Select or Upload Media Of Your Chosen Persuasion', //todo
                multiple: true
            });

            // When an image is selected in the media frame...
            frame.on('select', function() {
                frame.state().get('selection').forEach(function(element) {
                    element = element.toJSON();

                    addNewLineToTable(
                        element.id,
                        'image',
                        element.sizes.thumbnail.width,
                        element.sizes.thumbnail.height,
                        element.sizes.thumbnail.url,
                        element.sizes.full.url,
                        ''
                    );
                });
            });

            // Finally, open the modal on click
            frame.open();
        });

        function addNewLineToTable(id, type, thumbnail_width, thumbnail_height, thumbnail_url, full_url, description = null) {
            tbody = metaBox.find('table tbody');
            order = metaBox.find('table tbody tr').length;

            tbody.append(
                '<tr>' +
                    '<td>' +
                        '<input type="hidden" name="<?= SIVG_PLUGIN_SLUG; ?>['+order+'][id]" value="'+id+'"/>' +
                        '<input type="hidden" name="<?= SIVG_PLUGIN_SLUG; ?>['+order+'][type]" value="'+type+'"/>' +
                        '<img width="'+thumbnail_width+'" height="'+thumbnail_height+'" src="'+thumbnail_url+'">' +
                    '</td>' +
                    '<td>' +
                        (description == null ? '<input type="hidden" class="description" name="<?= SIVG_PLUGIN_SLUG; ?>['+order+'][description]" value=""><span class="no-description"><?= __('Unable to add description to videos.','simple-image-and-video-gallery'); ?></span>' : '<textarea rows="5" class="description" name="<?= SIVG_PLUGIN_SLUG; ?>['+order+'][description]">'+description+'</textarea>') +
                    '</td>' +
                    '<td>' +
                        '<a href="'+full_url+'">'+full_url+'</a>' +
                    '</td>' +
                    '<td>' +
                        '<button class="button delete"><?= __('Delete','simple-image-and-video-gallery'); ?></button>' +
                    '</td>' +
                '</tr>'
            );
        }

        $(document).on('click', SIVG_METABOX_SELECTOR+' .delete', function(event) {
            event.preventDefault();

            //tr <- td <- button
            $(this).parent().parent().remove();
        });
    });
</script>