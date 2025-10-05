require('magnific-popup');

class VideoPageController {
    constructor() {
        $(".lightbox-video-1").magnificPopup({
            gallery: {
                enabled: true,
            },
            type: 'iframe',
            mainClass: "mfp-fade",
            preloader: false,
        });
    }
}

export default VideoPageController;
