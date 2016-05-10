export class OfferTranslationService{
    constructor(API, ToastService, $window, $filter){
        'ngInject';

        this.$filter = $filter;
        this.$window = $window;
        this._promise;
        this._callbacks = new Array();
        this.API = API;
        this.ToastService = ToastService;

        this.enabledLanguages = [];
        this.defaultLanguage = {};
        this.untranslatedOffers = [];
    }
    
    fetchDefaultLanguage(success, error) {
        this.API.all('languages').customGET('default').then((language) => {
            this.defaultLanguage = language;
            success(this.defaultLanguage);
        });
    }
    
    fetchEnabledLanguages(success, error) {
        this.API.all('languages').customGETLIST('enabled').then((list) => {
            this.enabledLanguages = list;
            success(this.enabledLanguages);
        });
    }

    fetchUntranslated(success, error, force) {

        if (this.untranslatedOffers.length && !force) {
            success(this.untranslatedOffers);
        } else {
            this.API.all('offer-translations').customGETLIST('untranslated').then((list) => {
                this.untranslatedOffers = list;
                success(this.untranslatedOffers);
            });
        }
    }
}

