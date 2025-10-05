// import DateTimePicker from "../Inputs/DateTimePicker";

class AppHelperService {

    static isArray(data){
        return Object.prototype.toString.call(data) === '[object Array]';
    };

    static isObject(data){
        return Object.prototype.toString.call(data) === '[object Object]';
    };

    static isBoolean(data){
        return Object.prototype.toString.call(data) === '[object Boolean]';
    };

    static isString(data){
        return Object.prototype.toString.call(data) === '[object String]';
    };

    static isUrl(url) {
        let regex = /(http|https):\/\/(\w+:{0,1}\w*)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%!\-\/]))?/;
        return regex.test(url);
    }

    static isJsonString(str) {
        try {
            JSON.parse(str);
        } catch (e) {
            return false;
        }
        return true;
    };

    static redirect(href) {
        if(href == 'reload') {
            window.location.reload();
        } else{
            window.location.href = href;
        }
    };

    static generateLocalizedUrl(url, data) {
        return Routing.generate(url, data);
    }

    static formatPrice(price) {
        const formatter = new Intl.NumberFormat(LOCALE, { style: 'currency', currency: LANGUAGES[LOCALE].currencyCode });

        return formatter.format(price / 100);
    }

    static convertPrice(price)
    {
        if (1 === CURRENCY_RATE) {
            return price;
        }

        return (price / CURRENCY_RATE) * 100;
    }

    static formatAndConvertPrice(price)
    {
        price = this.convertPrice(price);

        return this.formatPrice(price)
    }

    static formatDecimal(price, locale = LOCALE)
    {
        return price.toLocaleString(locale, {minimumFractionDigits: 2, maximumFractionDigits: 2, currencySign: 'accounting'});
    }

    static calculatePercentage(price, discount)
    {
        return ((100 - (discount/price) * 100))
    }
};

export default AppHelperService;
