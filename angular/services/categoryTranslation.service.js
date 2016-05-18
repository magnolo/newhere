export class CategoryTranslationService{
    constructor(API, ToastService){
        'ngInject';

        this.API = API;
        this.ToastService = ToastService;

        this.enabledLanguages = [];
        this.defaultLanguage = {};
        this.untranslatedCategories = [];
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
        if (this.untranslatedCategories.length && !force) {
            success(this.untranslatedCategories);
        } else {
            this.API.all('category-translations').customGETLIST('untranslated').then((list) => {
                this.untranslatedCategories = list;
                success(this.untranslatedCategories);
            });
        }
    }

    fetchAll(success, error, force) {
        if (this.untranslatedCategories.length && !force) {
            success(this.untranslatedCategories);
        } else {
            this.API.all('category-translations').getList().then((list) => {
                this.untranslatedCategories = list;
                success(this.untranslatedCategories);
            });
        }
    }

    saveOrUpdate(category, translation, language, success, error) {
        category.customPUT({
            language: language.language,
            title: translation.title,
            description: translation.description,
        }).then((category) => {
            this.ToastService.show('Saved successfully');
            var translation;
            angular.forEach(category.translations, function (t, ignore) {
                if (t.locale == language.language) {
                    translation = t;
                }
            });
            success(translation.title, translation.description, translation.version);
        });
    }
}

