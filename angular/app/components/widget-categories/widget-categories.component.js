class WidgetCategoriesController{
    constructor(CategoryService){
        'ngInject';

        //    //
            this.categories;
            this.CategoryService = CategoryService;
            this.CategoryService.flattened((list) => {
              this.categories = list;
            });
    }

    $onInit(){
    }
}

export const WidgetCategoriesComponent = {
    templateUrl: './views/app/components/widget-categories/widget-categories.component.html',
    controller: WidgetCategoriesController,
    controllerAs: 'vm',
    bindings: {}
}
