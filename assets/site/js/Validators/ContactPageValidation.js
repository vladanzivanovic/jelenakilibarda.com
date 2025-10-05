import contactPageMapper from "../Mapper/ContactPageMapper";

require ('../../../js/Validators/ValidationRuleHelper');

class ContactPageValidation {
    constructor() {
        if (!ContactPageValidation.instance) {
            this.mapper = contactPageMapper;

            ContactPageValidation.instance = this;
        }

        return ContactPageValidation.instance;
    }

    validate() {
        let options;

        options = {
            rules: {
                first_name   : 'required',
                last_name    : 'required',
                email       : {
                    required: true,
                    email   : true
                },
                note : 'required',
            },
        };
        $.extend(options, window.helpBlock);

        return $(this.mapper.form).validate(options);
    }
}

const contactPageValidation = new ContactPageValidation();

Object.freeze(contactPageValidation);

export default contactPageValidation;
