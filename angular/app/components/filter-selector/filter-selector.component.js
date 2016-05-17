class FilterSelectorController{
    constructor(FilterService){
        'ngInject';

        //
        this.selectedFilter = [];
        this.filters = [];
        this.FilterService = FilterService;
        this.FilterService.all((list) => {
          this.filters = list;
        })
    }
    toggleFilter(filter){

    }
    $onInit(){
    }
}

export const FilterSelectorComponent = {
    templateUrl: './views/app/components/filter-selector/filter-selector.component.html',
    controller: FilterSelectorController,
    controllerAs: 'vm',
    bindings: {
      item:'=ngModel'
    }
}
