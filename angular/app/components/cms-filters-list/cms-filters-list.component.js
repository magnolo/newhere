class CmsFiltersListController {
    constructor(API, FilterService, $scope, $state) {
        'ngInject';
        var CmsFiltersListController = this;

        this.FilterService = FilterService;
        this.FilterService.all((filters) =>{
            this.filters = filters;
        });
        this.selection = [];
        this.options = {
            allowMove:true,
            allowDrag:true,
            allowDrop:true,
            drag: true,
            itemClick: function(item){
                $state.go('cms.filters.details',{id:item});
            }
        }
    }
    toggleEnabled(filter) {
        this.FilterService.toggleEnabled(filter);
    }
}

export const CmsFiltersListComponent = {
    templateUrl: './views/app/components/cms-filters-list/cms-filters-list.component.html',
    controller: CmsFiltersListController,
    controllerAs: 'vm',
    bindings: {}
}
