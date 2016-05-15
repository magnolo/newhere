class CmsOfferDetailController {

    constructor(OfferDetailService) {
        'ngInject';
        this.OfferDetailService = OfferDetailService;
        this.defaultLanguage = {};
        this.offerBase;
        this.offersExtended = [];

        this.OfferDetailService.fetchDefaultLanguage((defaultLanguage) = > {
            this.defaultLanguage = defaultLanguage;
    })
        ;

    }

    $onInit() {
    }

}
export const CmsOfferDetailComponent = {
    templateUrl: './views/app/components/cms-offer-detail/cms-offer-detail.component.html',
    controller: CmsOfferDetailController,
    controllerAs: 'vm',
    bindings: {}
}

