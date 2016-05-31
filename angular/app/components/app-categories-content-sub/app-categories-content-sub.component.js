class AppCategoriesContentSubController {
    constructor(CategoryService, OfferService, MapService, $state) {
        'ngInject';


        this.category = {};
        this.CategoryService = CategoryService;
        this.OfferService = OfferService;
        this.MapService = MapService;
        this.CategoryService.bySlug($state.params.slug, (category) => {
            this.category = category;
            this.CategoryService.getOffers(this.MapService.setMarkers);
        });


    }
    prepareLink(category){
      if(category.children.length){
        return 'app.start.categories.sub({slug:'+category.slug+'})';
      }
      return '-';
    }
}

export const AppCategoriesContentSubComponent = {
    templateUrl: './views/app/components/app-categories-content-sub/app-categories-content-sub.component.html',
    controller: AppCategoriesContentSubController,
    controllerAs: 'vm',
    bindings: {}
}
