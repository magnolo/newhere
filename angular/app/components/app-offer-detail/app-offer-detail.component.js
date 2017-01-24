class AppOfferDetailController {
    constructor($rootScope, OfferService, MapService, CategoryService, $state) {
        'ngInject';

        var vm = this;
        vm.showMap = true;
        this.$root = $rootScope;
        this.$root.showDetails = false;
        this.offer = null;
        this.MapService = MapService;
        this.CategoryService = CategoryService;
        OfferService.one($state.params.id, (offer) => {
            vm.offer = offer;
            if (angular.isUndefined(this.CategoryService.category.id)) {
                this.CategoryService.category = vm.offer.categories[0];
            }
            vm.MapService.highlightMarker(offer);
            vm.MapService.zoomTo(offer);
        });

    }

    goBack() {
        history.back();
    }
    toggleMap() {
        this.showMap = !this.showMap;
        this.$root.showDetails = !this.$root.showDetails;
    }
    showRouting() {
        this.MapService.showRoute([48.209206, 16.372778], [parseFloat(this.offer.longitude), parseFloat(this.offer.latitude)], 'auto');
    }
}

export const AppOfferDetailComponent = {
    templateUrl: './views/app/components/app-offer-detail/app-offer-detail.component.html',
    controller: AppOfferDetailController,
    controllerAs: 'vm',
    bindings: {}
};