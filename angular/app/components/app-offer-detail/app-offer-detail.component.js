class AppOfferDetailController{
    constructor(OfferService, CategoryService, MapService, $state){
        'ngInject';

        var vm = this;
        vm.showMap = false;

        this.CategoryService = CategoryService;
        this.MapService = MapService;

        OfferService.one($state.params.id, (offer) => {
            vm.offer = offer;
            vm.MapService.setMarkers({offer});
            vm.MapService.zoomTo(offer);
        });


    }

    $onInit(){
    }
    goBack(){
        history.back();
    }
    toggleMap(){
        this.showMap = !this.showMap;
    }
}

export const AppOfferDetailComponent = {
    templateUrl: './views/app/components/app-offer-detail/app-offer-detail.component.html',
    controller: AppOfferDetailController,
    controllerAs: 'vm',
    bindings: {}
}
