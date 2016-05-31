class AppCategoriesToolbarController{
    constructor(CategoryService, $state){
        'ngInject';

        //
        this.$state = $state;
        this.CategoryService = CategoryService;

    }

    $onInit(){
    }
    goBack(){
      if(this.CategoryService.category.parent_id){
        this.$state.go('app.start.categories.sub',{
          slug:this.CategoryService.category.parent.slug
        });
      }
      else{
        this.$state.go('app.start.categories');
      }
    }
}

export const AppCategoriesToolbarComponent = {
    templateUrl: './views/app/components/app-categories-toolbar/app-categories-toolbar.component.html',
    controller: AppCategoriesToolbarController,
    controllerAs: 'vm',
    bindings: {}
}
