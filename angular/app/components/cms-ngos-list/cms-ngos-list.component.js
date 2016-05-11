class CmsNgosListController{
    constructor(NgoService, $filter){
        'ngInject';
        var vm = this;
        this.$filter = $filter;
        this.NgoService = NgoService;
        this.NgoService.fetchAll().then(function(response) {
            vm.ngos = response;
        });

        this.listFilter = {
            showOnlyUnpublished: '',
            search: ''
        };

        this.listPagination = {
            limit: 10,
            page: 1
        };

        this.listOrderByColumn = '-organisation';
        this.onOrderChange = (order) => {
            console.log("onOrderChange " + order);
            return vm.ngos = this.$filter('orderBy')(vm.ngos, [order], true);
        };
    }

    update(ngo) {
        this.NgoService.update(ngo);
    }

    $onInit(){
    }
}

export const CmsNgosListComponent = {
    templateUrl: './views/app/components/cms-ngos-list/cms-ngos-list.component.html',
    controller: CmsNgosListController,
    controllerAs: 'vm',
    bindings: {}
}
