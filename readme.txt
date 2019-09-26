=== Simple Image and Video Gallery ===
Contributors: guilhermeagirardi
Donate link:
Tags: image,video,youtube,gallery,carousel,autoplay,responsive
Requires at least:
Tested up to: 5.2.3
Stable tag:
Requires PHP:
License: MIT
License URI:

Relate images and YouTube videos to your posts. You can handle data output manually or automatically, depending on your needs.

== Description ==

Relate images and YouTube videos to your posts. You can handle data output manually or automatically, depending on your needs.

[admin photo]

If you want to automatically display the videos and images of a post on a carousel, simply use:

[short code]

or

```php
echo sivg_carousel();
```

[carousel photo]

One of the most interesting features of this plugin is the automatic playback of YouTube videos. It was initially developed for this purpose, and after a lot of research, we had not found a plugin that really worked as expected.

When the displayed item is a video, it will automatically play. When the video ends, the carousel will skip to the next item, and so on.

[GIF autoplay example]

If you want to handle data output manually, just call the function:

```php
$gallery = sivg($post->ID);
```
Answer example:
```php
Array
(
    [0] => Array
        (
            [id] => bsdTLjLwG3A
            [type] => youtube-video
            [description] =>
            [url] => https://www.youtube.com/watch?v=bsdTLjLwG3A
            [thumbnail] => Array
                (
                    [player_background] => Array
                        (
                            [width] => 480
                            [height] => 360
                            [url] => https://i1.ytimg.com/vi/bsdTLjLwG3A/0.jpg
                        )

                    [start] => Array
                        (
                            [width] => 120
                            [height] => 90
                            [url] => https://i1.ytimg.com/vi/bsdTLjLwG3A/1.jpg
                        )

                    [middle] => Array
                        (
                            [width] => 120
                            [height] => 90
                            [url] => https://i1.ytimg.com/vi/bsdTLjLwG3A/2.jpg
                        )

                    [end] => Array
                        (
                            [width] => 120
                            [height] => 90
                            [url] => https://i1.ytimg.com/vi/bsdTLjLwG3A/3.jpg
                        )

                    [high_quality] => Array
                        (
                            [width] => 480
                            [height] => 360
                            [url] => https://i1.ytimg.com/vi/bsdTLjLwG3A/hqdefault.jpg
                        )

                    [medium_quality] => Array
                        (
                            [width] => 320
                            [height] => 180
                            [url] => https://i1.ytimg.com/vi/bsdTLjLwG3A/mqdefault.jpg
                        )

                    [normal_quality] => Array
                        (
                            [width] => 120
                            [height] => 90
                            [url] => https://i1.ytimg.com/vi/bsdTLjLwG3A/default.jpg
                        )

                    [standard_definition] => Array
                        (
                            [width] => 640
                            [height] => 480
                            [url] => https://i1.ytimg.com/vi/bsdTLjLwG3A/sddefault.jpg
                        )

                    [maximum_definition] => Array
                        (
                            [width] => 1920
                            [height] => 1080
                            [url] => https://i1.ytimg.com/vi/bsdTLjLwG3A/maxresdefault.jpg
                        )

                )

        )

    [1] => Array
        (
            [id] => 123
            [type] => image
            [description] => 2
            [url] => https://example.com/wp-content/uploads/2019/08/IMG_1723-e1567472163796.jpg
            [width] =>
            [height] =>
            [thumbnail] => Array
                (
                    [large] => Array
                        (
                            [height] => 1024
                            [width] => 768
                            [url] => https://example.com/wp-content/uploads/2019/08/IMG_1723-e1567472163796-768x1024.jpg
                        )

                    [medium] => Array
                        (
                            [height] => 300
                            [width] => 225
                            [url] => https://example.com/wp-content/uploads/2019/08/IMG_1723-e1567472163796-225x300.jpg
                        )

                    [thumbnail] => Array
                        (
                            [height] => 150
                            [width] => 150
                            [url] => https://example.com/wp-content/uploads/2019/08/IMG_1723-e1567472163796-150x150.jpg
                        )

                )

        )

)
```

The structure of an item depends on its type. See the index called `thumbnail`, notice that for an image, thumbnails are managed by Wordpress, while for videos, are those generated by YouTube.

== Installation ==


== Frequently Asked Questions ==


== Screenshots ==


== Changelog ==


== Upgrade Notice ==

