class NgoDetailController {
    constructor(NgoService, DialogService) {
        'ngInject';
        var vm = this;
        this.NgoService = NgoService;
        this.DialogService = DialogService;
        this.NgoService.one().then(function (response) {
            vm.ngo = response;
            vm.ngo.editMode = true;
        });

    }
}

export const NgoDetailComponent = {
    templateUrl: './views/app/components/ngo-detail/ngo-detail.component.html',
    controller: NgoDetailController,
    controllerAs: 'vm',
    bindings: {}
}
