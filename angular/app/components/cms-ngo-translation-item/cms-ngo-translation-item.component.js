
class CmsNgoTranslationItemController{
    constructor(NgoTranslationService, DialogService){
        'ngInject';

        this.DialogService = DialogService;
        this.NgoTranslationService = NgoTranslationService;
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
        this.NgoTranslationService.saveOrUpdate(
            this.ngo,
            this.translation,
            this.language,
            (description, version) => {
                this.translation.description = description;
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

export const CmsNgoTranslationItemComponent = {
    templateUrl: './views/app/components/cms-ngo-translation-item/cms-ngo-translation-item.component.html',
    controller: CmsNgoTranslationItemController,
    controllerAs: 'vm',
    bindings: {
        ngo: '=',
        translation: '=',
        language: '=',
        sourceTranslation: '<',
        sourceLanguage: '<'
    }
}
