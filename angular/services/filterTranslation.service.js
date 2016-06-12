export class FilterTranslationService{
    constructor(API, ToastService, $translate){
        'ngInject';

        this.API = API;
        this.ToastService = ToastService;
        this.$translate = $translate;

        this.untranslatedFilters = [];
    }

    fetchUntranslated(success, error, force) {
        if (this.untranslatedFilters.length && !force) {
            success(this.untranslatedFilters);
        } else {
            this.API.all('filter-translations').customGETLIST('untranslated').then((list) => {
                this.untranslatedFilters = list;
                success(this.untranslatedFilters);
            });
        }
    }

    fetchAll(success, error, force) {
        if (this.untranslatedFilters.length && !force) {
            success(this.untranslatedFilters);
        } else {
            this.API.all('filter-translations').getList().then((list) => {
                this.untranslatedFilters = list;
                success(this.untranslatedFilters);
            });
        }
    }

    saveOrUpdate(offer, translation, language, success, error) {
        offer.customPUT({
            language: language.language,
            title: translation.title,
            description: translation.description,
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
            success(translation.title, translation.description, translation.version);
        });
    }
}

