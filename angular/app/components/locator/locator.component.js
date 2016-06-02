class LocatorController{
    constructor(MapService){
        'ngInject';

        //
        this.MapService = MapService;

    }

    $onInit(){
    }

    locateMe(){
      this.MapService.getLocation();
    }
}

export const LocatorComponent = {
    templateUrl: './views/app/components/locator/locator.component.html',
    controller: LocatorController,
    controllerAs: 'vm',
    bindings: {}
}
