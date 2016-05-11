class CmsOfferTranslationDialogController{
    constructor($mdDialog){
        'ngInject';
        
        this.$mdDialog = $mdDialog;

        //
    }

    $onInit(){
    }

    save() {
        console.log('Save');
        this.$mdDialog.hide();
    }

    cancel() {
        console.log('Cancel');
        this.$mdDialog.cancel();
    }
}

export const CmsOfferTranslationDialogComponent = {
    templateUrl: './views/app/components/cms-offer-translation-dialog/cms-offer-translation-dialog.component.html',
    controller: CmsOfferTranslationDialogController,
    controllerAs: 'vm',
    bindings: {}
}
