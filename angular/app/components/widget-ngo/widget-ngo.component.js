class WidgetNgoController{
    constructor(NgoService){
        'ngInject';

        //
        this.ngos;
        this.NgoService = NgoService;
        this.NgoService.fetchAll().then((list) => {
          this.ngos = list;
        })
    }

    $onInit(){
    }
}

export const WidgetNgoComponent = {
    templateUrl: './views/app/components/widget-ngo/widget-ngo.component.html',
    controller: WidgetNgoController,
    controllerAs: 'vm',
    bindings: {}
}
