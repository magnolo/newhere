class CmsNgosListController {
    constructor(NgoService, $filter, $state, DialogService) {
        'ngInject';
        var vm = this;
        vm.menu = {
            isOpen: false
        };
        this.$filter = $filter;
        this.$state = $state;
        this.DialogService = DialogService;
        this.NgoService = NgoService;
        this.selectedNgos = [];
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
    bulkToggleEnabled(published) {
        this.NgoService.bulkAssign(this.selectedNgos, 'published', published, (list) => {
            angular.forEach(list, (item) => {
                angular.forEach(this.ngos, (ngo, key) => {
                    if (ngo.id == item.id) {
                        ngo.published = published;
                    }
                });
            });
            this.selectedNgos = [];
            this.DialogService.hide();
        });
    }
    remove() {
        //@todo translation!!!
        var offers = 0;
        angular.forEach(this.selectedNgos, (ngo) => {
            offers += ngo.offers.length;
        });
        this.DialogService.prompt('Deleting NGOs?', 'You are about to delete NGO(s) with ' + offers + ' offer(s) attached. Type in DELETE and confirm?', 'Delete Secret').then((response) => {
            if (response === "DELETE") {
                this.NgoService.bulkRemove(this.selectedNgos, (list) => {
                    this.selectedNgos = [];

                    angular.forEach(list, (item) => {
                        angular.forEach(this.ngos, (ngo, key) => {
                            if (ngo.id == item.id) {
                                this.ngos.splice(key, 1);
                            }
                        });
                    });
                });
            } else {
                this.DialogService.alert('Not correct', 'Thankfully, you entered the wrong secret. So nothing is going to change... for now.');
            }
        });
    }
    $onInit() {}
}

export const CmsNgosListComponent = {
    templateUrl: './views/app/components/cms-ngos-list/cms-ngos-list.component.html',
    controller: CmsNgosListController,
    controllerAs: 'vm',
    bindings: {
        cms: '=?'
    }
}