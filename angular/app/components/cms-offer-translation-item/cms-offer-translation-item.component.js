
class CmsOfferTranslationItemController{
    constructor(DialogService){
        'ngInject';

        this.DialogService = DialogService;
    }

    $onInit(){

    }

    translate(event, offer, translation) {
        this.DialogService.fromTemplate('translation',{
          controller: () => this,
          controllerAs: 'vm'
        });
        // this.$mdDialog.show({
        //         /**
        //          * @todo Controller?!?!
        //          */
        //         controller: controller,
        //         templateUrl: './views/app/components/cms-offer-translation-dialog/cms-offer-translation-dialog.component.html',
        //         parent: angular.element(document.body),
        //         targetEvent: event,
        //         clickOutsideToClose:true,
        //         escapeToClose: true,
        //         fullscreen: false
        //     })
        //     .then(function(answer) {
        //         //$scope.status = 'You said the information was "' + answer + '".';
        //     }, function() {
        //
        //     });
    }

    save() {
        console.log('Save');
        console.log(this);
        this.DialogService.hide();
    }

    cancel() {
        console.log('Cancel');
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
        language: '='
    }
}
