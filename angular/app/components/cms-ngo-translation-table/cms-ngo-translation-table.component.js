class CmsNgoTranslationTableController{
    constructor(NgoTranslationService, LanguageService){
        'ngInject';

        this.NgoTranslationService = NgoTranslationService;
        this.LanguageService = LanguageService;

        this.untranslatedNgos = [];
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

        this.NgoTranslationService.fetchUntranslated((untranslatedNgos) => {
            this.untranslatedNgos = untranslatedNgos;
            this.loading = false;
        });
    }

    getTranslation(untranslatedNgo, targetLanguage) {
        var dummy = { description: '', version: 0};

        if (angular.isUndefined(untranslatedNgo) || angular.isUndefined(targetLanguage)) {
            return dummy;
        }

        var translation = null;
        angular.forEach(untranslatedNgo.translations, function(t, ignore) {
            if (t.locale == targetLanguage.language) {
                translation = t;
            }
        });

        return translation || dummy;
    }

    reload(showAll) {
        this.loading = true;

        if (showAll) {
            this.NgoTranslationService.fetchAll((untranslatedNgos) => {
                this.untranslatedNgos = untranslatedNgos;
                this.loading = false;
            }, null, true);
        } else {
            this.NgoTranslationService.fetchUntranslated((untranslatedNgos) => {
                this.untranslatedNgos = untranslatedNgos;
                this.loading = false;
            }, null, true);
        }
    }

    $onInit(){
    }
}

export const CmsNgoTranslationTableComponent = {
    templateUrl: './views/app/components/cms-ngo-translation-table/cms-ngo-translation-table.component.html',
    controller: CmsNgoTranslationTableController,
    controllerAs: 'vm',
    bindings: {}
}
