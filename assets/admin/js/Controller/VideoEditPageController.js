import videoMapper from "../Mapper/VideoMapper";
import videoEditValidator from "../Validators/VideoEditValidator";
import VideoEditHandler from "../Handler/VideoEditHandler";
import YouTubeService from "../Services/YouTubeService";

class VideoEditPageController {
    constructor() {
        this.mapper = videoMapper;
        this.validator = videoEditValidator;
        this.handler = new VideoEditHandler();
        this.youtubeService = YouTubeService();

        this.youtubeService.init();

        this.validator.validate();

        this.registerEvents();
    }

    registerEvents()
    {
        $(this.mapper.submitBtn).on('click', (e) => {
            this.handler.save();
        });
    }
}

export default VideoEditPageController;
