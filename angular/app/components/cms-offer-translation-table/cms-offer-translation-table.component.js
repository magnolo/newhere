class CmsOfferTranslationTableController{
    constructor(OfferTranslationService, LanguageService){
        'ngInject';

        this.OfferTranslationService = OfferTranslationService;
        this.LanguageService = LanguageService;
        
        this.untranslatedOffers = [];
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

        this.OfferTranslationService.fetchUntranslated((untranslatedOffers) => {
            this.untranslatedOffers = untranslatedOffers;
            this.loading = false;
        });
    }

    getTranslation(untranslatedOffer, targetLanguage) {
        var dummy = {title: '', description: '', opening_hours: '', version: 0};

        if (angular.isUndefined(untranslatedOffer) || angular.isUndefined(targetLanguage)) {
            return dummy;
        }

        var translation = null;
        angular.forEach(untranslatedOffer.translations, function(t, ignore) {
            if (t.locale == targetLanguage.language) {
                translation = t;
            }
        });

        return translation || dummy;
    }

    reload(showAll) {
        this.loading = true;
        
        if (showAll) {
            this.OfferTranslationService.fetchAll((untranslatedOffers) => {
                this.untranslatedOffers = untranslatedOffers;
                this.loading = false;
            }, null, true);
        } else {
            this.OfferTranslationService.fetchUntranslated((untranslatedOffers) => {
                this.untranslatedOffers = untranslatedOffers;
                this.loading = false;
            }, null, true);
        }
    }

    $onInit(){
    }
}

export const CmsOfferTranslationTableComponent = {
    templateUrl: './views/app/components/cms-offer-translation-table/cms-offer-translation-table.component.html',
    controller: CmsOfferTranslationTableController,
    controllerAs: 'vm',
    bindings: {}
}
