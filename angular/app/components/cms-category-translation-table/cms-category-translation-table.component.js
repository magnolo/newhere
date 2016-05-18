class CmsCategoryTranslationTableController{
    constructor(CategoryTranslationService){
        'ngInject';

        this.CategoryTranslationService = CategoryTranslationService;

        this.untranslatedCategories = [];
        this.enabledLanguages = [];
        this.defaultLanguage = {};
        this.showAll = false;

        this.CategoryTranslationService.fetchDefaultLanguage((defaultLanguage) => {
            this.defaultLanguage = defaultLanguage;
        });

        this.CategoryTranslationService.fetchEnabledLanguages((enabledLanguages) => {
            this.enabledLanguages = enabledLanguages;
        });

        this.CategoryTranslationService.fetchUntranslated((untranslatedCategories) => {
            this.untranslatedCategories = untranslatedCategories;
        });
    }

    getTranslation(untranslatedCategory, targetLanguage) {
        var dummy = {title: '', description: '', version: 0};

        if (angular.isUndefined(untranslatedCategory) || angular.isUndefined(targetLanguage)) {
            return dummy;
        }

        var translation = null;
        angular.forEach(untranslatedCategory.translations, function(t, ignore) {
            if (t.locale == targetLanguage.language) {
                translation = t;
            }
        });

        return translation || dummy;
    }

    reload(showAll) {
        if (showAll) {
            this.CategoryTranslationService.fetchAll((untranslatedCategories) => {
                this.untranslatedCategories = untranslatedCategories;
            }, null, true);
        } else {
            this.CategoryTranslationService.fetchUntranslated((untranslatedCategories) => {
                this.untranslatedCategories = untranslatedCategories;
            }, null, true);
        }
    }
}

export const CmsCategoryTranslationTableComponent = {
    templateUrl: './views/app/components/cms-category-translation-table/cms-category-translation-table.component.html',
    controller: CmsCategoryTranslationTableController,
    controllerAs: 'vm',
    bindings: {}
}
