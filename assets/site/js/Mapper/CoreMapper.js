class CoreMapper {
    constructor() {
        if(!CoreMapper.instance) {
            this.registrationForm = '#registration-form';
            this.registrationBtn = '#registration-btn';
            this.loginForm = '#login-form';
            this.loginBtn = '#login-btn';
            this.loginEmail = '#login_email';
            this.loginPassword = '#login_password';
            this.toggleWishListBtn = '.toggle-wish-list';
            this.newsLetterForm = '#wd1_nlpopup';
            this.newsLetterFormFooter = '#newsletter_form_footer';
            this.newsLetterSubmitBtn = '#news_letter_btn';
            this.newsLetterSubmitBtnFooter = '#newsletter_submit';
            this.newsLetterCloseBtn = '#wd1_nlpopup_close';
            this.resetPasswordBtn = '#reset_btn';
            this.resetForm = '#reset_form';
            this.searchOpener = '.search-opener';
            this.searchClose = '.search-close';
            this.searchArea = '.search-area';
            this.searchAreaMobile = '.search-area-mobile';
            this.searchInput = '#search-input';
            this.searchSubmit = '.search-submit';
            this.searchForm = '.search-form';
            this.meanMenuContainer = '.mean-bar';
            this.meanMenuContainerReveal = '.meanmenu-reveal';

            for(const [locale, data] of Object.entries(LANGUAGES)) {
                this[`lang_link_${locale}`] = `#locale_${locale}`;
            }

            CoreMapper.instance = this;
        }

        return CoreMapper.instance;
    }
}

const coreMapper = new CoreMapper();

Object.freeze(coreMapper);

export default coreMapper;
