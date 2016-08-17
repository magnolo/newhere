class CmsMainController{
    constructor($mdSidenav){
        'ngInject';

        //
        this.mdSidenav = $mdSidenav;

    }
    toggleItemsList() {
      this.mdSidenav('left').toggle();
    }
    $onInit(){
    }
}

export const CmsMainComponent = {
    templateUrl: './views/app/components/cms-main/cms-main.component.html',
    controller: CmsMainController,
    controllerAs: 'vm',
    bindings: {}
}
