export class OfferTranslationService{
    constructor(API, ToastService, $translate){
        'ngInject';

        this.API = API;
        this.ToastService = ToastService;
        this.$translate = $translate;

        this.untranslatedOffers = [];
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

    fetchAll(success, error, force) {
        if (this.untranslatedOffers.length && !force) {
            success(this.untranslatedOffers);
        } else {
            this.API.all('offer-translations').getList().then((list) => {
                this.untranslatedOffers = list;
                success(this.untranslatedOffers);
            });
        }
    }
    
    saveOrUpdate(offer, translation, language, success, error) {
        offer.customPUT({
            language: language.language,
            title: translation.title,
            description: translation.description,
            opening_hours: translation.opening_hours,
        }).then((offer) => {
            this.$translate('Erfolgreich gespeichert.').then((msg) => {
                this.ToastService.show(msg);
            });
            var translation;
            angular.forEach(offer.translations, function (t, ignore) {
                if (t.locale == language.language) {
                    translation = t;
                }
            });
            success(translation.title, translation.description, translation.opening_hours, translation.version);
        });
    }
}

