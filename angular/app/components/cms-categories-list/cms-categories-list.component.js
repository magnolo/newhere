class CmsCategoriesListController {
    constructor(API, CategoryService, $scope, $state) {
        'ngInject';
        var CmsCategoriesListController = this;

        this.CategoryService = CategoryService;
        this.CategoryService.fetchAll();
        this.categories = CategoryService.categories;
        this.options = {
          allowMove:true,
          allowDrag:true,
          allowDrop:true,
          drag: true,
          itemClick: function(item){
            $state.go('cms.categories.details',{id:item});
          }
        }
    }
    toggleEnabled(category) {
        this.CategoryService.toggleEnabled(category);
    }
}

export const CmsCategoriesListComponent = {
    templateUrl: './views/app/components/cms-categories-list/cms-categories-list.component.html',
    controller: CmsCategoriesListController,
    controllerAs: 'vm',
    bindings: {}
}
