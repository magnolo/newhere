
class CmsOfferTranslationItemController{
    constructor(OfferTranslationService, DialogService){
        'ngInject';

        this.DialogService = DialogService;
        this.OfferTranslationService = OfferTranslationService;
        this.originalTranslation;
    }

    $onInit(){
        this.originalTranslation = angular.copy(this.translation);
    }

    translate() {
        this.sourceTranslation = angular.copy(this.sourceTranslation);
        this.sourceLanguage = angular.copy(this.sourceLanguage);

        this.DialogService.fromTemplate('translation', {
            controller: () => this,
            controllerAs: 'vm',
            clickOutsideToClose: true,
            escapeToClose: true
        });
    }

    save() {
        this.OfferTranslationService.saveOrUpdate(
            this.offer,
            this.translation,
            this.language,
            (title, description, opening_hours, version) => {
                this.translation.title = title;
                this.translation.description = description;
                this.translation.opening_hours = opening_hours;
                this.translation.version = version;
                this.DialogService.hide();
            }
        );
    }

    cancel() {
        this.translation = this.originalTranslation;
        this.DialogService.hide();
    }
}

export const CmsOfferTranslationItemComponent = {
    templateUrl: './views/app/components/cms-offer-translation-item/cms-offer-translation-item.component.html',
    controller: CmsOfferTranslationItemController,
    controllerAs: 'vm',
    bindings: {
        offer: '=',
        translation: '=',
        language: '=',
        sourceTranslation: '<',
        sourceLanguage: '<'
    }
}
