class NgoDetailController{
    constructor($state, NgoService){
        'ngInject';

        var vm = this;
        this.NgoService = NgoService;
        this.NgoService.oneById($state.params.id).then(function (response) {
            vm.ngo = response;
            console.log(response);
        });
    }

    $onInit(){
    }
}

export const NgoDetailComponent = {
    templateUrl: './views/app/components/ngo-detail/ngo-detail.component.html',
    controller: NgoDetailController,
    controllerAs: 'vm',
    bindings: {}
}
