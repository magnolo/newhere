class CmsNgosListController{
    constructor(NgoService, $filter, $state, DialogService){
        'ngInject';
        var vm = this;
        this.$filter = $filter;
        this.$state = $state;
        this.DialogService = DialogService;
        this.NgoService = NgoService;
        this.NgoService.fetchAll().then(function(response) {
            vm.ngos = response;
        });

        this.listFilter = {
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

    add() {
        this.DialogService.fromTemplate('ngo', {
            controller: () => this,
            controllerAs: 'vm'
        });
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
