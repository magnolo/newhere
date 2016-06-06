class CmsFilterTranslationItemController{
    constructor(FilterTranslationService, DialogService){
        'ngInject';

        this.DialogService = DialogService;
        this.FilterTranslationService = FilterTranslationService;
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
        this.FilterTranslationService.saveOrUpdate(
            this.filter,
            this.translation,
            this.language,
            (title, description, version) => {
                this.translation.title = title;
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

export const CmsFilterTranslationItemComponent = {
    templateUrl: './views/app/components/cms-filter-translation-item/cms-filter-translation-item.component.html',
    controller: CmsFilterTranslationItemController,
    controllerAs: 'vm',
    bindings: {
        filter: '=',
        translation: '=',
        language: '=',
        sourceTranslation: '<',
        sourceLanguage: '<'
    }
}
