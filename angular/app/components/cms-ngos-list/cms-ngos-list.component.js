class CmsNgosListController{
    constructor(NgoService){
        'ngInject';
        var vm = this;
        this.NgoService = NgoService;
        this.NgoService.fetchAll().then(function(response) {
            console.log(response);
            vm.ngos = response;
        });

        this.listFilter = {
            unpublished: '',
            search: ''
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
