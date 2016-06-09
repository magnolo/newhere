class AppOfferDetailController{
    constructor(OfferService, $state){
        'ngInject';

        var vm = this;

        OfferService.one($state.params.id, (offer) => {
            vm.offer = offer;
        });
    }

    $onInit(){
    }
}

export const AppOfferDetailComponent = {
    templateUrl: './views/app/components/app-offer-detail/app-offer-detail.component.html',
    controller: AppOfferDetailController,
    controllerAs: 'vm',
    bindings: {}
}
