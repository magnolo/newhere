class MyNgoDetailController {
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

export const MyNgoDetailComponent = {
    templateUrl: './views/app/components/my-ngo-detail/my-ngo-detail.component.html',
    controller: MyNgoDetailController,
    controllerAs: 'vm',
    bindings: {}
}
