export class NgoTranslationService{
    constructor(API, ToastService){
        'ngInject';

        this.API = API;
        this.ToastService = ToastService;

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
            this.ToastService.show('Saved successfully');
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

