class AppOfferDetailController{
    constructor(OfferService, MapService,CategoryService, $state){
        'ngInject';

        var vm = this;
        vm.showMap = true;

        this.MapService = MapService;
        this.CategoryService = CategoryService;
        OfferService.one($state.params.id, (offer) => {
            vm.offer = offer;
            if(typeof this.CategoryService.category.id == "undefined"){
              this.CategoryService.category = vm.offer.categories[0];
            }
            vm.MapService.setMarkers({offer});
            vm.MapService.zoomTo(offer);
        });
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
