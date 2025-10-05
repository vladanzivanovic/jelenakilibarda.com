class GdprService {
    constructor()
    {
        this.options = {
            title: Translator.trans('eu.cookies.accept.title', {'siteName': SITE_SETTINGS.SITE_NAME}, 'messages', LOCALE),
            message: Translator.trans('eu.cookies.accept.text', {'siteName': SITE_SETTINGS.SITE_NAME}, 'messages', LOCALE),
            subtitle: false,
            acceptBtnLabel: Translator.trans('eu.cookies.accept.btn', null, 'messages', LOCALE),
            // advancedBtnLabel: Translator.trans('eu.cookies.learn_more.btn', null, 'messages', LOCALE),
            cookieTypes: [
                {
                    type: Translator.trans('eu.cookies.checkbox.required', null, 'messages', LOCALE),
                    value: "essential",
                    description: "Cookies related to site visits, browser types, etc.",
                },
                {
                    type: Translator.trans('eu.cookies.checkbox.analytics', null, 'messages', LOCALE),
                    value: "analytics",
                    description: "Cookies related to site visits, browser types, etc.",
                    checked: true,
                },
            ]
        };
    }

    init()
    {
        $.gdprcookie.init(this.options);

        this.registerEventsOnInit();
    }

    goToCookiePage()
    {
        location.href = Routing.generate(`site.info_texts.${LOCALE}`, {slug: TEXTS.cookie_policy.slug[LOCALE]});
    }

    registerEventsOnInit()
    {
        $('body').on('gdpr:show', e => {
            $('.gdprcookie-buttons\\/ button:last-of-type').click();
        });
    }
}

export default GdprService;
