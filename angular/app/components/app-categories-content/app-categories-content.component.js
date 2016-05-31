class AppCategoriesContentController {
    constructor(CategoryService, MapService) {
        'ngInject';

        this.categories = [];
        //
        this.MapService = MapService;
        this.MapService.markers = {};
        this.CategoryService = CategoryService;
        this.CategoryService.all((categories) => {
            this.categories = categories;
        });


    }

    $onInit() {}
}

export const AppCategoriesContentComponent = {
    templateUrl: './views/app/components/app-categories-content/app-categories-content.component.html',
    controller: AppCategoriesContentController,
    controllerAs: 'vm',
    bindings: {}
}
