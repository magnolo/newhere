class AppOfferDetailController{
    constructor(OfferService, CategoryService,  $state){
        'ngInject';

        var vm = this;

        this.CategoryService = CategoryService;

        OfferService.one($state.params.id, (offer) => {
            vm.offer = offer;
        });
    }

    $onInit(){
    }
    goBack(){
        history.back();
    }
}

export const AppOfferDetailComponent = {
    templateUrl: './views/app/components/app-offer-detail/app-offer-detail.component.html',
    controller: AppOfferDetailController,
    controllerAs: 'vm',
    bindings: {}
}
