import NotificationService from "../../../js/NotificationService";
import AppHelperService from "../../../js/Helper/AppHelperService";
import DescriptionDataTables from "../Services/DataTables/DescriptionDataTables";
import descriptionEditMapper from "../Mapper/DescriptionEditMapper";
import DropZoneService from "../../../js/Services/DropZoneService";

class DescriptionHandler {
    constructor() {
        this.mapper = descriptionEditMapper;
        this.notification = NotificationService();
    }

    save() {
        let urlRoute = Routing.generate('admin.add_description_api');
        let type = 'POST';
        const data = $(this.mapper.form).serializeArray();

        if (IS_EDIT) {
            urlRoute = Routing.generate('admin.edit_description_api', {id: ID});
            type = 'PUT';
        }

        if (!$(this.mapper.form).valid()) {
            return false;
        }

        data.push({
            name : 'images',
            value: JSON.stringify(DropZoneService().getFilesArray('description')),
        });

        this.notification.showLoadingMessage();

        $.ajax({
            type,
            url: urlRoute,
            data,
            dataType: 'json',
            success: response => {
                AppHelperService.redirect(Routing.generate('admin.descriptions'));
            },
            error: error => {
                this.notification.show('error', Translator.trans('generic_error', null, 'messages', LOCALE), true);
            }
        })
    }

    remove(id) {
        this.notification.showLoadingMessage();

        $.ajax({
            type: 'DELETE',
            url: Routing.generate('admin.remove_description_api', {id}),
            dataType: 'json',
            success: () => {
                DescriptionDataTables().reload();
                this.notification.remove();
            },
            error: jxHR => {
                this.notification.show('error', Translator.trans('generic_error', null, 'messages', LOCALE), true);
            }
        })
    }
}

export default DescriptionHandler;
