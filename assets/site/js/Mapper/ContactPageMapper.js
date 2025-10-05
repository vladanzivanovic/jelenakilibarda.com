class ContactPageMapper {
    constructor() {
        if (!ContactPageMapper.instance) {
            this.form = '#contact_form';
            this.submitBtn = '#ask_us_submit';

            ContactPageMapper.instance = this;
        }

        return  ContactPageMapper.instance;
    }
}

const contactPageMapper = new ContactPageMapper();

Object.freeze(contactPageMapper);

export default contactPageMapper;
