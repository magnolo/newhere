class CmsOfferTranslationTableController{
    constructor(OfferTranslationService){
        'ngInject';

        this.OfferTranslationService = OfferTranslationService;
        
        this.untranslatedOffers = [];
        this.enabledLanguages = [];
        this.defaultLanguage = {};
        this.showAll = false;
        
        this.OfferTranslationService.fetchDefaultLanguage((defaultLanguage) => {
            this.defaultLanguage = defaultLanguage;
        });
        
        this.OfferTranslationService.fetchEnabledLanguages((enabledLanguages) => {
            this.enabledLanguages = enabledLanguages;
        });

        this.OfferTranslationService.fetchUntranslated((untranslatedOffers) => {
            this.untranslatedOffers = untranslatedOffers;
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
        if (showAll) {
            this.OfferTranslationService.fetchAll((untranslatedOffers) => {
                this.untranslatedOffers = untranslatedOffers;
            }, null, true);
        } else {
            this.OfferTranslationService.fetchUntranslated((untranslatedOffers) => {
                this.untranslatedOffers = untranslatedOffers;
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
