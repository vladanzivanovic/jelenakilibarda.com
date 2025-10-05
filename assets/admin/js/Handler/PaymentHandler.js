import AppHelperService from "../../../js/Helper/AppHelperService";
import NotificationService from "../../../js/NotificationService";
import ShippingDataTables from "../Services/DataTables/ShippingDataTables";
import shippingEditMapper from "../Mapper/ShippingEditMapper";
import paymentEditMapper from "../Mapper/PaymentEditMapper";

class PaymentHandler {
    constructor() {
        this.notification = NotificationService();
        this.mapper = paymentEditMapper;
    }

    save() {
        let urlRoute = Routing.generate('admin.add_payment_api');
        let type = 'POST';
        const data = $(this.mapper.form).serializeArray();

        if (! $(this.mapper.form).valid()) {
            return false;
        }

        if (IS_EDIT) {
            urlRoute = Routing.generate('admin.edit_payment_api', {id: ID});
            type = 'PUT';
        }

        this.notification.showLoadingMessage();

        $.ajax({
            type,
            url: urlRoute,
            data,
            dataType: 'json',
            success: response => {
                AppHelperService.redirect(Routing.generate('admin.payment_page'));
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
            url: Routing.generate('admin.remove_payment_api', {id}),
            dataType: 'json',
            success: () => {
                ShippingDataTables().reload();
                this.notification.remove();
            },
            error: jxHR => {
                const errors = jxHR.responseJSON;

                if (errors.hasOwnProperty('message')) {
                    this.notification.show('error', Translator.trans(errors.message, {item: 'Slanje'}, 'messages', LOCALE), true);

                    return;
                }

                this.notification.show('error', Translator.trans('generic_error', null, 'messages', LOCALE), true);
            }
        })
    }

    changeStatus(checkbox, id, status) {
        $.ajax({
            type: 'PATCH',
            'url': Routing.generate('admin.api_payment_change_status', {id, status}),
            dataType: 'json',
            success: (response) => {
                checkbox.parentElement.firstElementChild.innerText = Translator.trans(response.text, null, 'messages', LOCALE);
            },
            error: () => {
                this.notification.show('error', Translator.trans('generic_error', null, 'message', LOCALE), true);
            }
        })
    }
}

export default PaymentHandler;