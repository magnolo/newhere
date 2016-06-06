class CmsFilterTranslationTableController{
    constructor(FilterTranslationService, LanguageService){
        'ngInject';

        this.FilterTranslationService = FilterTranslationService;
        this.LanguageService = LanguageService;

        this.untranslatedFilters = [];
        this.enabledLanguages = [];
        this.defaultLanguage = {};
        this.showAll = false;
        this.loading = true;

        this.LanguageService.fetchDefault((defaultLanguage) => {
            this.defaultLanguage = defaultLanguage;
        });

        this.LanguageService.fetchEnabled((enabledLanguages) => {
            this.enabledLanguages = enabledLanguages;
        });

        this.FilterTranslationService.fetchUntranslated((untranslatedFilters) => {
            this.untranslatedFilters = untranslatedFilters;
            this.loading = false;
        });
    }

    $onInit(){
    }

    getTranslation(untranslatedFilter, targetLanguage) {
        var dummy = {title: '', description: '', version: 0};

        if (angular.isUndefined(untranslatedFilter) || angular.isUndefined(targetLanguage)) {
            return dummy;
        }

        var translation = null;
        angular.forEach(untranslatedFilter.translations, function(t, ignore) {
            if (t.locale == targetLanguage.language) {
                translation = t;
            }
        });

        return translation || dummy;
    }

    reload(showAll) {
        this.loading = true;

        if (showAll) {
            this.FilterTranslationService.fetchAll((untranslatedFilters) => {
                this.untranslatedFilters = untranslatedFilters;
                this.loading = false;
            }, null, true);
        } else {
            this.FilterTranslationService.fetchUntranslated((untranslatedFilters) => {
                this.untranslatedFilters = untranslatedFilters;
                this.loading = false;
            }, null, true);
        }
    }
}

export const CmsFilterTranslationTableComponent = {
    templateUrl: './views/app/components/cms-filter-translation-table/cms-filter-translation-table.component.html',
    controller: CmsFilterTranslationTableController,
    controllerAs: 'vm',
    bindings: {}
}
