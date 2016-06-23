class CmsNgosListController{
    constructor(NgoService, $filter, $state, DialogService){
        'ngInject';
        var vm = this;
        this.$filter = $filter;
        this.$state = $state;
        this.DialogService = DialogService;
        this.NgoService = NgoService;
        this.listOrderByColumn = '-organisation';
        this.NgoService.fetchAll().then(function(ngos) {
            vm.ngos = vm.$filter('orderBy')(ngos, [vm.listOrderByColumn], true);

        });

        this.listFilter = {
            search: ''
        };

        this.listPagination = {
            limit: 10,
            page: 1
        };

        this.onOrderChange = (order) => {
            return vm.ngos = vm.$filter('orderBy')(vm.ngos, [order], true);
        };
    }

    togglePublished(ngo) {
        this.NgoService.togglePublished(ngo);
    }

    add() {
        this.ngo = {};
        this.DialogService.fromTemplate('ngo', {
            controller: () => this,
            controllerAs: 'vm'
        });
    }

    edit(ngo) {
        this.ngo = ngo;
        this.ngo.editMode = true;
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
