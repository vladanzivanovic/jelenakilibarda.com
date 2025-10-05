import DropZoneService from "../../../../js/Services/DropZoneService";
import AppHelperService from "../../../../js/Helper/AppHelperService";
import NotificationService from "../../../../js/NotificationService";
import ProductDataTables from "../../Services/DataTables/ProductDataTables";
import productEditMapper from "../../Mapper/ProductEditMapper";

class ProductEditHandler {
    constructor() {
        this.mapper = productEditMapper;
        this.notification = NotificationService();
    }

    save() {
        let urlRoute = Routing.generate('admin.add_product_api');
        let type = 'POST';
        const data = $(this.mapper.form).serializeArray();

        data.push({
            name: 'images',
            value: JSON.stringify(DropZoneService().getFilesArray('product')),
        });

        if (IS_EDIT) {
            urlRoute = Routing.generate('admin.edit_product_api', {id: ID});
            type = 'PUT';
        }

        if (! $(this.mapper.form).valid()) {
            return false;
        }

        this.notification.showLoadingMessage();

        $.ajax({
            type,
            url: urlRoute,
            data,
            dataType: 'json',
            success: () => {
                AppHelperService.redirect(Routing.generate('admin.dashboard'));
            },
            error: () => {
                let errors = error.responseJSON;

                if (!AppHelperService.isJsonString(errors.error)) {
                    this.notification.show('error', Translator.trans('generic_error', null, 'messages', LOCALE), true);
                }
            }
        })
    }

    changeStatus(checkbox, id, status) {
        $.ajax({
            type: 'PATCH',
            'url': Routing.generate('admin.api_product_change_status', {id, status}),
            dataType: 'json',
            success: (response) => {
                checkbox.parentElement.firstElementChild.innerText = Translator.trans(response.text, null, 'messages', LOCALE);
            },
            error: (errorResponse) => {
                checkbox.checked = false;

                if (!AppHelperService.isJsonString(errorResponse.responseText)) {
                    this.notification.show('error', Translator.trans('generic_error', null, 'message', LOCALE), true);

                    return;
                }

                let errors = errorResponse.responseJSON;

                this.notification.show('error', errors.error_message, true);
            }
        })
    }

    remove(id) {
        this.notification.showLoadingMessage();

        $.ajax({
            type: 'DELETE',
            url: Routing.generate(`admin.remove_product_api`, {id}),
            success: () => {
                ProductDataTables().reload();
                this.notification.remove();
            },
            error: (error) => {
                const errors = error.responseJSON;

                if (errors.hasOwnProperty('message')) {
                    this.notification.show('error', errors.message, true);

                    return;
                }

                this.notification.show('error', Translator.trans('generic_error', null, 'messages'. LOCALE), true);
            }
        })
    }
}

export default ProductEditHandler;
