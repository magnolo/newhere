class CmsOfferTranslationItemController{
    constructor($mdDialog){
        'ngInject';

        this.$mdDialog = $mdDialog;
    }

    $onInit(){
    }

    translate(event, offer, translation) {
        console.log(offer);
        console.log(translation);

        this.$mdDialog.show({
                /**
                 * @todo Controller?!?!
                 */
                controller: CmsOfferTranslationDialogController,
                templateUrl: './views/app/components/cms-offer-translation-dialog/cms-offer-translation-dialog.component.html',
                parent: angular.element(document.body),
                targetEvent: event,
                clickOutsideToClose:true,
                escapeToClose: true,
                fullscreen: false
            })
            .then(function(answer) {
                //$scope.status = 'You said the information was "' + answer + '".';
            }, function() {
                
            });
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

export const CmsOfferTranslationItemComponent = {
    templateUrl: './views/app/components/cms-offer-translation-item/cms-offer-translation-item.component.html',
    controller: CmsOfferTranslationItemController,
    controllerAs: 'vm',
    bindings: {
        offer: '<',
        translation: '<',
        language: '<'
    },
    scope: {
        offer: '<',
        translation: '<',
        language: '<'
    }
}
