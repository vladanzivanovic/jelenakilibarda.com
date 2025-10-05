import NotificationService from "../../../js/NotificationService";
import loader from "../Dom/LoaderDom";
import contactPageMapper from "../Mapper/ContactPageMapper";

class ContactPageHandler {
    constructor() {
        this.mapper = contactPageMapper;
        this.notification = NotificationService();
    }

    save() {
        let urlRoute = Routing.generate(`site_api.contact.${LOCALE}`);
        let type = 'POST';
        const data = $(this.mapper.form).serializeArray();

        if (! $(this.mapper.form).valid()) {
            return false;
        }

        loader.show();

        $.ajax({
            type,
            url: urlRoute,
            data,
            dataType: 'json',
            success: (response) => {
                this.notification.show('success', Translator.trans(`contact.message.success`, null, 'messages', LOCALE), true);
                $(this.mapper.form)[0].reset();
                loader.hide();
            },
            error: (error) => {
                loader.hide();
            }
        })
    }
}

export default ContactPageHandler;
