export class NgoTranslationService{
    constructor(API, ToastService, $translate){
        'ngInject';

        this.API = API;
        this.ToastService = ToastService;
        this.$translate = $translate;

        this.untranslatedNgos = [];

    }

    fetchUntranslated(success, error, force) {
        if (this.untranslatedNgos.length && !force) {
            success(this.untranslatedNgos);
        } else {
            this.API.all('ngo-translations').customGETLIST('untranslated').then((list) => {
                this.untranslatedNgos = list;
                success(this.untranslatedNgos);
            });
        }
    }

    fetchAll(success, error, force) {
        if (this.untranslatedNgos.length && !force) {
            success(this.untranslatedNgos);
        } else {
            this.API.all('ngo-translations').getList().then((list) => {
                this.untranslatedNgos = list;
                success(this.untranslatedNgos);
            });
        }
    }

    saveOrUpdate(ngo, translation, language, success, error) {
        ngo.customPUT({
            language: language.language,
            description: translation.description,
        }).then((ngo) => {
            this.$translate('Erfolgreich gespeichert.').then((msg) => {
                this.ToastService.show(msg);
            });
            var translation;
            angular.forEach(ngo.translations, function (t, ignore) {
                if (t.locale == language.language) {
                    translation = t;
                }
            });
            success(translation.description, translation.version);
        });
    }
}

