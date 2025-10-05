import DropZoneService from "../../../js/Services/DropZoneService";
import AppHelperService from "../../../js/Helper/AppHelperService";
import NotificationService from "../../../js/NotificationService";
import biographyMapper from "../Mapper/BiographyMapper";

class BiographyHandler {
    constructor() {
        this.mapper = biographyMapper;
        this.notification = NotificationService();
    }

    save() {
        let urlRoute = AppHelperService.generateLocalizedUrl('admin.save_biography_api');
        let type = 'POST';
        const data = $(this.mapper.form).serializeArray();

        if (!$(this.mapper.form).valid()) {
            return false;
        }

        data.push({
            name : 'images',
            value: JSON.stringify(DropZoneService().getFilesArray('biography')),
        });

        this.notification.showLoadingMessage();

        $.ajax({
            type,
            url     : urlRoute,
            data,
            dataType: 'json',
            success : response => {
                AppHelperService.redirect(AppHelperService.generateLocalizedUrl('admin.biography'));
            },
            error   : error => {
                this.notification.show('error', Translator.trans('generic_error', null, 'messages', LOCALE), true);
            }
        })
    }
}

export default BiographyHandler;
