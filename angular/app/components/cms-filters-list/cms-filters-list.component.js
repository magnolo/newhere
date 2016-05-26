class CmsFiltersListController{
    constructor($sessionStorage, FilterService, $filter, $state, DialogService){
        'ngInject';
        var vm = this;
        vm.menu = {
            isOpen:false
        };
        vm.loading = true;
        this.$sessionStorage = $sessionStorage;
        this.$filter = $filter;
        this.$state = $state;
        this.DialogService = DialogService;
        this.FilterService = FilterService;
        //if(this.cms){
        //}

        this.selectedFilters = [];
        this.query = {
            order: '-id',
            limit: 10,
            page: 1
        };
        this.search = {
            show: false,
            query: ''
        }
        if(this.$sessionStorage.filterQuery){
            this.query = this.$sessionStorage.filterQuery;
        }

        this.getFilters = ()=>{
            vm.$sessionStorage.filterQuery = vm.query;
            vm.promise = this.FilterService.fetchFiltered(vm.query, (response) => {
                vm.filters = response;
                vm.loading = false;
                vm.count = response.count;
            });
        };
        this.getFilters();
    }

    toggleEnabled(filter) {
        this.FilterService.toggleEnabled(filter);
    }
    bulkToggleEnabled(enabled){
        this.FilterService.bulkAssign(this.selectedFilters, 'enabled' ,enabled, (list) =>{
            angular.forEach(list, (item) => {
                angular.forEach(this.offers, (filter, key) => {
                    if(filter.id == item.id){
                        filter.enabled = enabled;
                    }
                });
            });
            this.selectedFilters = [];
            this.DialogService.hide();
        });
    }

    remove() {
        this.DialogService.prompt('Deleting Filters?', 'You are about to delete filter(s). Type in DELETE and confirm?', 'Delete Secret').then((response) => {
            if (response === "DELETE") {
                this.FilterService.bulkRemove(this.selectedFilters, (list) => {
                    this.selectedFilters = [];
                    angular.forEach(list, (item) => {
                        angular.forEach(this.filters, (filter, key) => {
                            if(filter.id == item.id){
                                this.filters.splice(key, 1);
                            }
                        });
                    });
                });
            } else {
                this.DialogService.alert('Not correct', 'Thankfully, you entered the wrong secret. So nothing is going to change... for now.');
            }
        });
    }

    cancel(){
        this.DialogService.hide();
    }
    $onInit(){
    }
}

export const CmsFiltersListComponent = {
    templateUrl: './views/app/components/cms-filters-list/cms-filters-list.component.html',
    controller: CmsFiltersListController,
    controllerAs: 'vm',
    bindings: {
        cms: '='
    }
}
