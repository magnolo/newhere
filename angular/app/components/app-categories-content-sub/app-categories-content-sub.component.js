class AppCategoriesContentSubController {
    constructor($scope, CategoryService, OfferService, MapService, $state, $rootScope) {
        'ngInject';

        this.showMap = false;
        this.showOffers = false;
        this.category = {};
        this.filteredOffers;
        this.CategoryService = CategoryService;
        this.OfferService = OfferService;
        this.MapService = MapService;
        this.state = $state;
        this.offersCallback = (offers) => {
            this.offers = offers;
            this.MapService.setMarkers(offers);
            console.log(this.filteredOffers);
        };
        this.CategoryService.bySlug($state.params.slug, (category) => {
            this.category = category;
            if (!this.category.children.length) {
                this.showOffers = true;
            }
            this.CategoryService.getOffers(this.offersCallback);
        });
        $scope.$watch(this.filteredOffers, function(n,o){
          console.log(n);
        }, true)
    }

    toggleMap() {
        this.showMap = !this.showMap;
    }

    showOffer(id) {
        this.state.go('app.start.detail',{id:id});
    }
}

export const AppCategoriesContentSubComponent = {
    templateUrl: './views/app/components/app-categories-content-sub/app-categories-content-sub.component.html',
    controller: AppCategoriesContentSubController,
    controllerAs: 'vm',
    bindings: {}
}
