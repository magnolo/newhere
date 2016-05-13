class NgoDetailController {
    constructor(NgoService, DialogService) {
        'ngInject';
        var vm = this;
        this.NgoService = NgoService;
        this.DialogService = DialogService;
        this.NgoService.one().then(function (response) {
            vm.ngo = response;
            vm.ngo.editMode = false;
            vm.ngo.fakeUrl = "/img/newhere-logo.svg";
            vm.ngo.fullAddress = vm.parseFullAddress();
        });

    }

    $onInit() {
    }

    parseFullAddress() {
        return this.ngo.street + " " + this.ngo.street_number + ", " + this.ngo.zip + " " + this.ngo.city;
    }

    edit() {
        this.ngo.editMode = true;
        this.DialogService.fromTemplate('ngo', {
            controller: () => this,
            controllerAs: 'vm'
        });
    }
}

export const NgoDetailComponent = {
    templateUrl: './views/app/components/ngo-detail/ngo-detail.component.html',
    controller: NgoDetailController,
    controllerAs: 'vm',
    bindings: {}
}
