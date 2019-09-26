(function($) {
    window.player = [];
    var carousel_selector = '#sivg-carousel.carousel';

    //Verify if first carousel-item contains a video
    function sivg_first_item_is_video() {
        return $(carousel_selector).find('.carousel-item:eq(0) .video-player').length == 1;
    }

    function sivg_pause_carousel() {
        $(carousel_selector).carousel('pause');
    }

    function sivg_play_carousel() {
        $(carousel_selector).carousel('cycle');
    }

    function sivg_get_video_id(video_element) {
        return video_element.attr('id')
    }

    function sivg_create_player(videoId) {
        player[videoId] = new window.YT.Player(videoId, {
            videoId: videoId,
            playerVars: {
                autoplay: 1,
                modestbranding: 1,
                rel: 0,
                showinfo: 0,
                disablekb: 1
            },
            events: {
                'onStateChange': onPlayerStateChange
            }
        });
    }

    //Dynamically include YouTube API script
    function include_youtube_api() {
        var youtubeScriptId = "youtube-api";
        var youtubeScript = document.getElementById(youtubeScriptId);

        if (youtubeScript === null) {
            var tag = document.createElement("script");
            var firstScript = document.getElementsByTagName("script")[0];

            tag.src = "https://www.youtube.com/iframe_api";
            tag.id = youtubeScriptId;
            firstScript.parentNode.insertBefore(tag, firstScript);
        }
    }

    function sivg_init_carousel() {
        $(carousel_selector).carousel({
            interval: 3000
        });

        $(carousel_selector).on("slide.bs.carousel", function(e) {
            var prev_index = $(this).find(".active").index();
            var next_index = $(e.relatedTarget).index();

            //Does the previous item contain video?
            var prev_video_div = $(carousel_selector+' .carousel-item:eq('+prev_index+') .video-player');

            //If Yes
            if (prev_video_div.length == 1) {
                var prev_video_id = sivg_get_video_id(prev_video_div);

                if (typeof player[prev_video_id] !== "undefined") {
                    player[prev_video_id].pauseVideo();
                }
            }

            //Does the next item contain video?
            var next_video_div = $(carousel_selector+' .carousel-item:eq('+next_index+') .video-player');

            //If Yes
            if (next_video_div.length == 1) {
                var next_video_id = sivg_get_video_id(next_video_div);

                if (next_video_div[0].tagName == "IFRAME") {
                    player[next_video_id].playVideo();
                } else {
                    sivg_create_player(next_video_id);
                }
            }
        });
    }

    function sivg() {
        window.onYouTubeIframeAPIReady = function() {
            sivg_init_carousel();

            if(sivg_first_item_is_video())
                sivg_create_player(sivg_get_video_id($(carousel_selector).find('.carousel-item:eq(0) .video-player')));
        }

        window.onPlayerStateChange = function(event) {
            if (event.data == YT.PlayerState.PLAYING || event.data == YT.PlayerState.BUFFERING) {
                console.log( 'Playing / Buffering' );
                sivg_pause_carousel();

            } else if (event.data == YT.PlayerState.PAUSED) {
                console.log('Paused');

            } else if (event.data == YT.PlayerState.ENDED) {
                console.log('Ended');
                $(carousel_selector).carousel('next');
                sivg_play_carousel();
            }
        }

        include_youtube_api();
    }

    sivg();
})(jQuery);