class CmsOfferTranslationItemController{
    constructor(){
        'ngInject';
    }

    $onInit(){
    }

    translate(offer, translation) {
        console.log(offer);
        console.log(translation);
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
