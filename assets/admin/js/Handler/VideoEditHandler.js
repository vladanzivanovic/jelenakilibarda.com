import AppHelperService from "../../../js/Helper/AppHelperService";
import NotificationService from "../../../js/NotificationService";
import videoMapper from "../Mapper/VideoMapper";
import YouTubeService from "../Services/YouTubeService";

class VideoEditHandler {
    constructor() {
        this.mapper = videoMapper;
        this.notification = NotificationService();
    }

    save() {
        let urlRoute = Routing.generate('admin.add_video_api');
        let type = 'POST';
        const data = $(this.mapper.form).serializeArray();

        if (!$(this.mapper.form).valid()) {
            return false;
        }

        data.push({
            name : 'video',
            value: JSON.stringify(YouTubeService().getLists()),
        });

        this.notification.showLoadingMessage();

        $.ajax({
            type,
            url     : urlRoute,
            data,
            dataType: 'json',
            success : response => {
                AppHelperService.redirect(Routing.generate('admin.video_page'));
            },
            error   : error => {
                this.notification.show('error', Translator.trans('generic_error', null, 'messages', LOCALE), true);
            }
        })
    }
}

export default VideoEditHandler;
