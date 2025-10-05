class CurrencyEditMapper {
    constructor() {
        this.form = '#edit_form';
        this.submitBtn = '#submit_button';

        if (!CurrencyEditMapper.instance) {
            CurrencyEditMapper.instance = this;
        }

        return CurrencyEditMapper.instance;
    }
}
const currencyEditMapper = new CurrencyEditMapper();
Object.freeze(currencyEditMapper);
export default currencyEditMapper;