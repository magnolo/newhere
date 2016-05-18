class CmsCategoryTranslationItemController{
    constructor(CategoryTranslationService, DialogService){
        'ngInject';

        this.DialogService = DialogService;
        this.CategoryTranslationService = CategoryTranslationService;
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
        this.CategoryTranslationService.saveOrUpdate(
            this.category,
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

export const CmsCategoryTranslationItemComponent = {
    templateUrl: './views/app/components/cms-category-translation-item/cms-category-translation-item.component.html',
    controller: CmsCategoryTranslationItemController,
    controllerAs: 'vm',
    bindings: {
        category: '=',
        translation: '=',
        language: '=',
        sourceTranslation: '<',
        sourceLanguage: '<'
    }
}
